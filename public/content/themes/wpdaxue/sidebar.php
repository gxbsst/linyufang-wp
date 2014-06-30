	<?php wp_reset_query(); if ( is_home() ) { ?>
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('首页边栏') ) : ?>
	<?php endif; ?>
	<?php } ?>

	<?php wp_reset_query(); if ( is_single() ) { ?>
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('文章页面边栏') ) : ?>
	<?php endif; ?>
	<?php } ?>

	<?php wp_reset_query(); if ( !is_home()&&!is_single()) { ?>
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('其他页面边栏') ) : ?>
	<?php endif; ?>
	<?php } ?>