<div class="slideTxtBox t">
	<div class="hd">
		<ul><li>最新文章</li><li>热门文章</li><li>随机文章</li></ul>
	</div>
	<div class="bd cl">
		<ul class="side-list">
		<?php $args = array('posts_per_page' => get_option('h_side_tab_num'),'ignore_sticky_posts' => 1);query_posts($args);?>
		<?php while (have_posts()) : the_post(); ?>
		<li><a  href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" target="_blank"><?php the_title(); ?></a></li>
		<?php endwhile; ?>
		</ul>
		<ul class="side-list">
		<?php if(function_exists('most_comm_posts')) most_comm_posts(get_option('h_side_tab_time'), get_option('h_side_tab_num')); ?>
		</ul>
		<ul class="side-list">
		<?php $args = array('posts_per_page' => get_option('h_side_tab_num'),'ignore_sticky_posts' => 1,'orderby'=>'rand');query_posts($args);?>
		<?php while (have_posts()) : the_post(); ?>
		<li><a  href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" target="_blank"><?php the_title(); ?></a></li>
		<?php endwhile; ?>
		</ul>
	</div>
</div>