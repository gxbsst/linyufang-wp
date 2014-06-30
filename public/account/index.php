<?php
require dirname(dirname(__DIR__)) . '/config/wordpress.php';

$app= new \Slim\Slim([
	'log.enabled' => true,
	'log.writer' => $logger,
	'debug' => true,
  'templates.path' => './views'
	]);

$app->view(new \Slim\Views\Twig());

$app->view->parserOptions = array(
  'charset' => 'utf-8',
  'cache' => realpath('./cache'),
  'auto_reload' => true,
  'strict_variables' => false,
  'autoescape' => true
);

$app->view->parserExtensions = array(new \Slim\Views\TwigExtension());

$app->get("(/)", function() use($app){
	// $creds = array();
	// $creds['user_login'] = 'gxbsst@gmail.com';
	// $creds['user_password'] = '51448888';
	// $creds['remember'] = true;
	// $user = wp_signon( $creds, false );
	// if ( is_wp_error($user) )
	// 	echo $user->get_error_message();

	if(!is_user_logged_in()) {
		wp_redirect(wp_login_url());
		exit;
	}
	$user = wp_get_current_user();
	/* var_dump($user); */
	$userid = get_current_user_id();
	$user_info = get_userdata($userid);
	//echo $user_info->user_name;
  $args = array(
    'numberposts' => 10,
    'orderby' => 'post_date',
    'order' => 'DESC',
    'post_type' => 'post',
    'post_status' => 'draft, publish, future, pending, private',
    'suppress_filters' => true );

  $recent_posts = wp_get_recent_posts( $args, ARRAY_A );

  /* var_dump($recent_posts); */
	//var_dump($user_info);

  $app->render('test.html', array(
    'user_info' => $user_info,
    'form' => wp_login_form()
  ));
	// var_dump(get_userdata( $user->ID ));
});

$app->run();
