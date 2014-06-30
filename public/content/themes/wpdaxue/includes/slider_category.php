<?php
$cat_slider = explode(',', get_option('h_slide_cat'));
query_posts(array(
	'posts_per_page' => 5,
	'category__in' =>$cat_slider,
	'ignore_sticky_posts' => 1
	)
);
?>