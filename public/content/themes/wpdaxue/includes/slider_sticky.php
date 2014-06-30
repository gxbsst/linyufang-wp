<?php query_posts(array(
	'posts_per_page' => 5,
	'post__in'  => get_option('sticky_posts'),
	'ignore_sticky_posts' => 1
	)
);
?>