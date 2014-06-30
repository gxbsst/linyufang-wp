<?php

function mg_styles()
{
    wp_enqueue_style('foundation', get_template_directory_uri() . '/css/foundation.css');
    wp_enqueue_style('style', get_template_directory_uri() . '/style.css');
}

if (!is_admin()) add_action('wp_enqueue_scripts', 'mg_styles');

function mg_scripts()
{
    wp_enqueue_script('foundation', get_template_directory_uri() . '/js/foundation.min.js', array('jquery'), '', true);
    wp_enqueue_script('modernizr', get_template_directory_uri() . '/js/modernizr.js', '', '', true);
    wp_enqueue_script('angular', get_template_directory_uri() . '/js/angular.js', '', '', true);
    wp_enqueue_script('angular-resource', get_template_directory_uri() . '/js/angular-resource.js', '', '', true);
    wp_enqueue_script('angular-touch', get_template_directory_uri() . '/js/angular-touch.js', '', '', true);
    wp_enqueue_script('angular-route', get_template_directory_uri() . '/js/angular-route.js', '', '', true);
    wp_enqueue_script('app', get_template_directory_uri() . '/js/app.js', '', '', true);
    wp_enqueue_script('app', get_template_directory_uri() . '/js/config.js.coffee', '', '', true);
    wp_enqueue_script('rootController', get_template_directory_uri() . '/js/controllers/root_controller.js.coffee', '', '', true);
    wp_enqueue_script('mainController', get_template_directory_uri() . '/js/controllers/main_controller.js.coffee', '', '', true);
}

if (!is_admin()) add_action('wp_enqueue_scripts', 'mg_scripts');
