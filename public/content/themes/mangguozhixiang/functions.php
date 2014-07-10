<?php

function mg_styles()
{
  wp_enqueue_style('ionic', get_template_directory_uri() . '/lib/ionic/css/ionic.css');
  #wp_enqueue_style('foundation', get_template_directory_uri() . '/css/foundation.css');
  wp_enqueue_style('style', get_template_directory_uri() . '/style.css');
}

if ( !is_admin() ) add_action('wp_enqueue_scripts', 'mg_styles');

function mg_scripts()
{
  wp_enqueue_script('inoic', get_template_directory_uri() . '/lib/ionic/js/ionic.bundle.js', array('jquery'), '', true);
  wp_enqueue_script('ngResource', get_template_directory_uri() . '/js/angular-resource.js', '', '', true);
  wp_enqueue_script('ngCookies', get_template_directory_uri() . '/js/angular-cookies.js', '', '', true);
  wp_enqueue_script('routingConfig', get_template_directory_uri() . '/js/routing-config.js', '', '', true);
  wp_enqueue_script('app', get_template_directory_uri() . '/js/app.js', '', '', true);
  wp_enqueue_script('services', get_template_directory_uri() . '/js/services.js', '', '', true);
  wp_enqueue_script('directive', get_template_directory_uri() . '/js/directives/ajax_form.js', array('jquery'), '', true);
  wp_enqueue_script('controllers', get_template_directory_uri() . '/js/controllers.js', '', '', true);
  #wp_enqueue_script('angular', get_template_directory_uri() . '/js/angular.js', '', '', true);
  #wp_enqueue_script('angular-resource', get_template_directory_uri() . '/js/angular-resource.js', '', '', true);
  #wp_enqueue_script('angular-touch', get_template_directory_uri() . '/js/angular-touch.js', '', '', true);
  #wp_enqueue_script('angular-route', get_template_directory_uri() . '/js/angular-route.js', '', '', true);
  #wp_enqueue_script('app', get_template_directory_uri() . '/js/app.js', '', '', true);
  #wp_enqueue_script('app', get_template_directory_uri() . '/js/config.js.coffee', '', '', true);
  #wp_enqueue_script('rootController', get_template_directory_uri() . '/js/controllers/root_controller.js.coffee', '', '', true);
  #wp_enqueue_script('mainController', get_template_directory_uri() . '/js/controllers/main_controller.js.coffee', '', '', true);

  $nonce = wp_create_nonce('wp_json');
  wp_localize_script('wp-api', 'WP_API_Settings', array('root' => esc_url_raw(get_json_url()), 'nonce' => $nonce));
  wp_enqueue_script('wp-api');
}

if ( !is_admin() ) add_action('wp_enqueue_scripts', 'mg_scripts');

add_theme_support('post-thumbnails');

add_filter('show_admin_bar', '__return_false');


function ajax_login()
{

  // First check the nonce, if it fails the function will break
  //  check_ajax_referer( 'ajax-login-nonce', 'security' );

  $nonce = getallheaders()['X-WP-Nonce'];
  if ( !wp_verify_nonce($nonce, 'wp_json') )
    exit('Sorry!');

  // Nonce is checked, get the POST data and sign user on
  $info = [];
  $info['user_login'] = $_POST['username'];
  $info['user_password'] = $_POST['password'];
  $info['remember'] = true;

  $user_signon = wp_signon($info, false);
  if ( is_wp_error($user_signon) ) {
    echo json_encode(array('loggedin' => false, 'message' => __('Wrong username or password.')));
  } else {
//    wp_redirect('#/tab/accounts');
    echo json_encode(array('loggedin' => true, 'message' => __('Login successful, redirecting...')));
  }

  die();
}

add_action('wp_ajax_nopriv_ajaxlogin', 'ajax_login');


function ajax_registration()
{
  $nonce = getallheaders()['X-WP-Nonce'];
  if ( !wp_verify_nonce($nonce, 'wp_json') )
    exit('Sorry!');

  var_dump($_POST);

  $username = $_POST['username'];
  $email = $_POST['email'];
  $regusername = explode("@", $email);
  $regusername = $regusername[0];
  $password = $_POST['password'];

  $error = '';

  if ( $email == '' ) {
    $error .= 'Please enter email address';
  } else if ( $password == '' ) {
    $error .= ($error != '') ? '<br>' : '';
    $error .= 'Please enter password';
  }
  if ( $error != '' ) {
    echo json_encode(array('signupresponse' => false, 'message' => __("$error")));
  } else {
    if ( email_exists($email) == false ) {
      $user_id = wp_create_user($regusername, $password, $email);
      update_user_option($user_id, 'firstname', $username);
      echo json_encode(array('signupresponse' => true, 'message' => __('Register successful!\n You can login now')));
    } else {
//      status_header(422);
      echo json_encode(array('signupresponse' => false, 'message' => __('Email already exists.')));
    }
  }
  die();
}

//add_action( 'wp_ajax_nopriv_ajaxregistration', 'ajax_registration', 100 );

add_action( 'wp_ajax_ajaxregistration', 'ajax_registration', 100 );
