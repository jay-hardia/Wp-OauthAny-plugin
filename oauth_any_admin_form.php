<?php 
    if($_POST['oauth_any_hidden'] == 'Y') {
        //Form data sent
        $consumer_key = $_POST['oauth_any_consumer_key'];
        update_option('oauth_any_consumer_key', $consumer_key);

        $consumer_secret_key = $_POST['oauth_any_consumer_secret_key'];
        update_option('oauth_any_consumer_secret_key', $consumer_secret_key);


        $action_variable = $_POST['oauth_any_action_variable'];
        update_option('oauth_any_action_variable', $action_variable);

        $time_limit = $_POST['oauth_any_time_limit'];
        update_option('oauth_any_time_limit', $time_limit);

        $oauth_url = $_POST['oauth_any_oauth_url'];
        update_option('oauth_any_oauth_url', $oauth_url);

        $user_api = $_POST['oauth_any_user_api'];
        update_option('oauth_any_user_api', $user_api);
      
        ?>
        <div class="updated"><p><strong><?php _e('Options saved.' ); ?></strong></p></div>
        <?php
    } else {
       //Normal page display
       $consumer_key        = get_option('oauth_any_consumer_key');
       $consumer_secret_key = get_option('oauth_any_consumer_secret_key');

       $action_variable     = get_option('oauth_any_action_variable');
       $time_limit          = get_option('oauth_any_time_limit');
       $oauth_url           = get_option('oauth_any_oauth_url');
       $user_api            = get_option('oauth_any_user_api');
    }
?>


<div class="wrap">
  <h2> <?php  echo __( 'Oauth Any Settings ', 'oauth_any' ) ; ?> </h2>

  <form name="oscimp_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
    <input type="hidden" name="oauth_any_hidden" value="Y">
    <?php    echo "<h4>" . __( 'Consumer key & Secret key', 'oauth_any' ) . "</h4>"; ?>
    <p><?php _e("Consumer key: " ); ?><input type="text" name="oauth_any_consumer_key" value="<?php echo $consumer_key; ?>" maxlength="100" size="50"><?php _e(" ex: xxxxxxxxxxxxxxxxxxxxxxxxxxxxx" ); ?></p>
    <p><?php _e("Consumer Secret key: " ); ?><input type="text" name="oauth_any_consumer_secret_key" value="<?php echo $consumer_secret_key; ?>"  maxlength="100" size="50" ><?php _e(" ex: xxxxxxxxxxxxxxxxxxxxxxxxxxxxx" ); ?></p>
    
    <hr />

    <?php    echo "<h4>" . __( 'URL Settings', 'oauth_any' ) . "</h4>"; ?>
    <p><?php _e("Action Variable: " ); ?><input type="text" name="oauth_any_action_variable" value="<?php echo $action_variable; ?>" maxlength="20" size="50"><?php _e(" ex: http://www.example.com?<b>action_time</b>=98797456498" ); ?></p>
    <p><?php _e("Time Limit: " ); ?><input type="number" name="oauth_any_time_limit" value="<?php echo $time_limit; ?>" max="3600" min ="0" size="50"><?php _e(" Time in seconds from <b>action_time value</b> , Max 3600 Sec " ); ?></p>
    
    <p><?php _e("Oauth URL: " ); ?><input type="text" name="oauth_any_oauth_url" value="<?php echo $oauth_url; ?>" maxlength="500" size="50"><?php _e(" Url of authentication provider for access token " ); ?></p>
    
    <p><?php _e("User API URL: " ); ?><input type="text" name="oauth_any_user_api" value="<?php echo $user_api; ?>" maxlength="500" size="50"><?php _e(" Url of user api from where user data will fetch after authentication " ); ?></p>

    <p class="submit">
      <input type="submit" name="Submit" value="<?php _e('Update Options', 'oauth_any' ) ?>" />
    </p>
  </form>
</div>