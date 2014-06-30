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
    wp_enqueue_script('app', get_template_directory_uri() . '/js/app.js', array('jquery'), '', true);
}

if (!is_admin()) add_action('wp_enqueue_scripts', 'mg_scripts');
