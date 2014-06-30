<?php

//订阅WordPress大学
function dashboard_custom_feed_output() {
	echo '<div class="rss-widget">';
	wp_widget_rss_output(array(
		'url' => 'http://www.wpdaxue.com/feed/',
		'title' => '查看WordPress大学的最新内容',
		'items' => 6,
		'show_summary' => 0,
		'show_author' => 0,
		'show_date' => 1  ));
	echo '</div>';
}

// Create the function use in the action hook
function h_add_dashboard_widgets() {
	wp_add_dashboard_widget('example_dashboard_widget', 'WordPress大学', 'dashboard_custom_feed_output');
}
// Hoook into the 'wp_dashboard_setup' action to register our other functions
add_action('wp_dashboard_setup', 'h_add_dashboard_widgets' );

?>