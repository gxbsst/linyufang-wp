<div class="t widget_recent_entries">
<div class="hc">
<span>随机推荐</span>
</div>
<div class="h_widget cl">
	<ul>
	<?php $args = array('posts_per_page' => get_option('h_side_tab_num'),'ignore_sticky_posts' => 1,'orderby'=>'rand');query_posts($args);?>
	<?php while (have_posts()) : the_post(); ?>
	<li><a  href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" target="_blank"><?php the_title(); ?></a></li>
	<?php endwhile; ?>
	</ul>
</div>
</div>