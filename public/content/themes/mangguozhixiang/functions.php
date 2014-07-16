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
  wp_enqueue_script('ngSanitize', get_template_directory_uri() . '/js/angular-sanitize.js', '', '', true);
  wp_enqueue_script('routingConfig', get_template_directory_uri() . '/js/routing-config.js', '', '', true);
  wp_enqueue_script('app', get_template_directory_uri() . '/js/app.js', '', '', true);
  wp_enqueue_script('services', get_template_directory_uri() . '/js/services.js', '', '', true);
  wp_enqueue_script('directive', get_template_directory_uri() . '/js/directives/ajax_form.js', array('jquery'), '', true);
  wp_enqueue_script('filters', get_template_directory_uri() . '/js/filters/filter.js', '', '', true);
  wp_enqueue_script('controllers', get_template_directory_uri() . '/js/controllers.js', '', '', true);
  #wp_enqueue_script('angular', get_template_directory_uri() . '/js/angular.js', '', '', true);
  #wp_enqueue_script('angular-resource', get_template_directory_uri() . '/js/angular-resource.js', '', '', true);
  #wp_enqueue_script('angular-touch', get_template_directory_uri() . '/js/angular-touch.js', '', '', true);
  #wp_enqueue_script('angular-route', get_template_directory_uri() . '/js/angular-route.js', '', '', true);
  #wp_enqueue_script('app', get_template_directory_uri() . '/js/app.js', '', '', true);
  #wp_enqueue_script('app', get_template_directory_uri() . '/js/config.js.coffee', '', '', true);
  #wp_enqueue_script('rootController', get_template_directory_uri() . '/js/controllers/root_controller.js.coffee', '', '', true);
  #wp_enqueue_script('mainController', get_template_directory_uri() . '/js/controllers/main_controller.js.coffee', '', '', true);

  # 主要为post gform表单使用
  require_once(GFCommon::get_base_path() . "/form_display.php");
  $form_id = 1;
  $form_unique_id = RGFormsModel::get_form_unique_id($form_id);
  $form = RGFormsModel::get_form_meta($form_id, true);
  $form_state = GFFormDisplay::get_state($form, []);

  $nonce = wp_create_nonce('wp_json');
  wp_localize_script('inoic', 'WP_API_Settings', array('root' => esc_url_raw(get_json_url()), 'nonce' => $nonce, 'form_unique_id' => $form_unique_id, 'form_state' => $form_state));
  wp_enqueue_script('inoic');

//  require_once(GFCommon::get_base_path() . "/form_display.php");
//  $form_unique_id = RGFormsModel::get_form_unique_id(1);
//  $form = RGFormsModel::get_form_meta(1, true);
//  $form_state = GFFormDisplay::get_state($form, []);
//  wp_localize_script('gform', 'GForm', array('form_unique_id' => $form_unique_id, 'form_state' => $form_state));
//  wp_enqueue_script('gform');
}


function init_js_object() {
  # 主要为post gform表单使用
  require_once(GFCommon::get_base_path() . "/form_display.php");
  $form_id = 1;
  $form_unique_id = RGFormsModel::get_form_unique_id($form_id);
  $form = RGFormsModel::get_form_meta($form_id, true);
  $form_state = GFFormDisplay::get_state($form, []);

  $nonce = wp_create_nonce('wp_json');
  return array('root' => esc_url_raw(get_json_url()), 'nonce' => $nonce, 'form_unique_id' => $form_unique_id, 'form_state' => $form_state);
//  wp_localize_script('wp-api', 'WP_API_Settings', array('root' => esc_url_raw(get_json_url()), 'nonce' => $nonce, 'form_unique_id' => $form_unique_id, 'form_state' => $form_state));
//  wp_enqueue_script('wp-api');
}

if ( !is_admin() )  add_action('wp_enqueue_scripts', 'init_js_object');

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
    echo json_encode(array(
      'loggedin' => false,
      'username' => 'Guest',
      'message' => __('Wrong username or password.'),
      'role' => ['title' => 'Guest', 'bitMask' => 7] #TODO: 判断是用户还是管理员
      ));
  } else {
    echo json_encode([
      'username' => $user_signon->user_nicename,
      'display_name' => $user_signon->display_name,
      'loggined' => true,
      'role' => ['title' => 'user', 'bitMask' => 6], #TODO: 判断是用户还是管理员
      'nonce' => init_js_object()
    ]);
//    echo json_encode(array('loggedin' => true, 'message' => __('Login successful, redirecting...')));
  }


  die();
}

add_action('wp_ajax_ajaxlogin', 'ajax_login');
add_action('wp_ajax_nopriv_ajaxlogin', 'ajax_login');


function ajax_registration()
{
  $nonce = getallheaders()['X-WP-Nonce'];
  if ( !wp_verify_nonce($nonce, 'wp_json') )
    exit('Sorry!');

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

add_action('wp_ajax_nopriv_ajaxregistration', 'ajax_registration');
add_action('wp_ajax_ajaxregistration', 'ajax_registration');

function ajax_logout()
{
  wp_logout();
  init_js_object();
  status_header(200);
}

add_action('wp_ajax_nopriv_ajaxlogout', 'ajax_logout');
add_action('wp_ajax_ajaxlogout', 'ajax_logout');

function ajax_reset_password()
{
  $user = wp_get_current_user();

  if ( is_wp_error($user) ) {
    if ( $user->get_error_code() === 'expired_key' ) {
      $status = 'expiredkey';
    } else {
      $status = 'invalidkey';
    }
    echo $status;
    die;
  }

  reset_password($user, $_POST['password']);
  status_header(200);
}

add_action('wp_ajax_nopriv_ajaxresetpassword', 'ajax_reset_password');
add_action('wp_ajax_ajaxresetpassword', 'ajax_reset_password');

function ajax_create_comment()
{

//  $nonce = getallheaders()['X-WP-Nonce'];
//  if ( !wp_verify_nonce($nonce, 'wp_json') )
//    exit('Sorry!');

  $time = current_time('mysql');
  $author = wp_get_current_user();
  $post_id = $_POST['post_id'];
  $comment = $_POST['comment'];
  $data = array(
    'comment_post_ID' => $post_id,
    'comment_author' => $author->data->user_login,
    'comment_author_email' => $author->data->user_email,
    'comment_author_url' => $author->data->user_url,
    'comment_content' => $comment,
    'comment_type' => '',
    'comment_parent' => 0,
    'user_id' => 1,
    'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
    'comment_agent' => 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.0.10) Gecko/2009042316 Firefox/3.0.10 (.NET CLR 3.5.30729)',
    'comment_date' => $time,
    'comment_approved' => 1,
  );

  wp_insert_comment($data);
  die();
}

add_action('wp_ajax_nopriv_create_comment', 'ajax_create_comment');
add_action('wp_ajax_create_comment', 'ajax_create_comment');

function ajax_create_order()
{
  require_once(GFCommon::get_base_path() . "/form_display.php");
  $form_id = 1;
  $form_state_1 = getallheaders()['GFORM-State'];
  $form_unique_id = getallheaders()['GFORM-Unique_Id'];

  $params = [
    'input_2' => get_current_user_id(),
    'input_8' => 'nopay',
    'input_9' => 'alipay',
    'input_10' => uniqid(),
    'input_11' => wp_get_current_user()->user_email,
    'is_submit_1' => '1',
    'gform_submit' => '1',
    'gfrom_unique_id' => $form_unique_id,
    'state_1' => $form_state_1,
    'gform_target_page_number_1' => 0,
    'gform_source_page_number_1'  => 0,
    'gform_field_values' => '',
    'gform_ajax' => true
  ];

  $new_params = array_merge($params, $_POST);

  $_POST = $new_params;

  GFFormDisplay::process_form($form_id);

  echo json_encode(array('a' => 111));
  die();
}

add_action('wp_ajax_nopriv_create_order', 'ajax_create_order');
add_action('wp_ajax_create_order', 'ajax_create_order');

function ajax_get_orders()
{
  $orders = RGFormsModel::get_leads(1, 0, 'DESC',  wp_get_current_user()->user_email);
  wp_send_json($orders);
}

add_action('wp_ajax_nopriv_get_orders', 'ajax_get_orders');
add_action('wp_ajax_get_orders', 'ajax_get_orders');

function ajax_cancel_order()
{
  global $wpdb;
  $lead_detail_table = 'wp_rg_lead_detail';
  $lead_id = $_POST['id'];
  $input_id = 8;
  $value = 'cancel';

  $current_fields = $wpdb->get_results($wpdb->prepare("SELECT id, field_number FROM $lead_detail_table WHERE lead_id=%d", $lead_id));
  $lead_detail_id = RGFormsModel::get_lead_detail_id($current_fields, $input_id);
  $wpdb->update($lead_detail_table, array("value" => $value), array("id" => $lead_detail_id), array("%s"), array("%d"));
  wp_send_json($lead_detail_id);
}

add_action('wp_ajax_nopriv_cancel_order', 'ajax_cancel_order');
add_action('wp_ajax_cancel_order', 'ajax_cancel_order');