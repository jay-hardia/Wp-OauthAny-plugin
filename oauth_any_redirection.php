<?php 
define( 'PASSWORD', 'W0rDPr33$' );

add_action('after_setup_theme', 'check_get_param');

function  check_get_param() {

  $action_variable     = get_option('oauth_any_action_variable');

  if(array_key_exists($action_variable, $_GET)) {
    oauth_any_init($action_variable);
  } else if(array_key_exists('code', $_GET) && array_key_exists('oauth_token', $_GET) ) {
    oauth_any_get_access_token();
  }
}

function oauth_any_init($action_variable) {

  $time_limit          = get_option('oauth_any_time_limit');
  $action_time = intval( $_GET[$action_variable] );

  if ( ($action_time + $time_limit) < time() )
    return false;

  if(!is_user_logged_in() ) {
    $auth_url = get_option('oauth_any_oauth_url');
    $get_param = array(
      'oauth_token'  => get_option('oauth_any_consumer_key'), 
      'redirect_uri' => get_site_url()
    );
    $url = $auth_url.'?'.http_build_query($get_param);
    wp_redirect($url);
  } 
}


function oauth_any_get_access_token() {
  $oauth_url           = get_option('oauth_any_oauth_url');  

  $post_data = array( 
    'oauth_token'        => get_option('oauth_any_consumer_key'), 
    'oauth_token_secret' => get_option('oauth_any_consumer_secret_key'),
    'code'               => $_GET['code'],
    'redirect_uri'       => get_site_url()
  );
  
  $output =  curl_request($oauth_url, 'POST', $post_data);
  
  oauth_any_custom_login_via_rails($output['access_token']);
}

function oauth_any_custom_login_via_rails($access_token) {
  $user_api = get_option('oauth_any_user_api');

  $url = "{$user_api}?access_token={$access_token}";
  $output =  curl_request($url);
  
  if(array_key_exists('email', $output)) {

    $password = ( array_key_exists('password', $output)) ? $output['password'] : PASSWORD;
    
    if(!username_exists( $output['user_name'] ) ) {     
      $new_user_id = wp_create_user($output['user_name'], $password, $output['email']);
    }


    $login_data = array(
        'user_login'    => $output['user_name'],
        'user_password' => $password,
        'remember'      => 0
        );
      
      $user_verify = wp_signon( $login_data, false );

      header("Refresh:0");

  } else {
    echo '<script> console.log("INVALID ACCESS TOKEN"); </script>';
  }
}


function curl_request($url, $method = 'GET', $post_data = array()) {

  $url = urldecode( trim($url) );

  $ch = curl_init();

  if($method == 'POST') {
    curl_setopt( $ch, CURLOPT_POST, true );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $post_data );
  }

    
  curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
  curl_setopt( $ch, CURLOPT_URL, $url );    
  curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );    
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
  curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
  curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );    # required for https urls
  curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
  $content = curl_exec( $ch );
  // $response = curl_getinfo( $ch );
  curl_close ( $ch );

  return json_decode( $content, true);
}

?>