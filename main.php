<?php 
  /*
  Plugin Name: Oauth Any
  Plugin URI: http://www.techracers.com
  Description: Plugin for authentication from other application and get user details then Signup/login into wordpress without login/signup screen in wordpress.
  Author: J. Hardia
  Version: 1.0
  */

function oauth_any_admin() {
    include('oauth_any_admin_form.php');
}
 
function oauth_any_admin_actions() {
    add_options_page("Oauth Any", "Oauth Any", 1, "Oauth Any", "oauth_any_admin");
}

add_action('admin_menu', 'oauth_any_admin_actions');

include('oauth_any_redirection.php');

add_action('after_setup_theme', 'remove_admin_bar');
 
function remove_admin_bar() {
  if (!current_user_can('administrator') && !is_admin()) {
    show_admin_bar(false);
  }
}


