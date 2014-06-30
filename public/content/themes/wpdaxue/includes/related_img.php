<div class="newInfor">
	<div class="hB">
		<h3><?php the_tags('与  ', ' , '); ?>  相关的文章</h3>
	</div>
	<ul class="related_img cl">
		<?php
		$post_num = 5; 
		$exclude_id = $post->ID; 
		$posttags = get_the_tags(); $i = 0;
		if ( $posttags ) {
			$tags = ''; foreach ( $posttags as $tag ) $tags .= $tag->term_id . ','; 
			$args = array(
				'post_status' => 'publish',
				'tag__in' => explode(',', $tags), 
				'post__not_in' => explode(',', $exclude_id), 
				'caller_get_posts' => 1,
				'orderby' => 'comment_date', 
				'posts_per_page' => $post_num
				);
			query_posts($args);
			while( have_posts() ) { the_post(); ?>
			<li class="related_box"  >
				<div class="r_pic">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" target="_blank">
						<?php if (get_option('h_timthumb') == 'Enable') { ?>
						<img src="<?php echo get_template_directory_uri(); ?>/timthumb.php?src=<?php echo post_thumbnail_src(); ?>&h=100&w=120&zc=1" alt="<?php the_title(); ?>" class="thumbnail"/>
						<?php } else { ?>
						<img src="<?php echo post_thumbnail_src(); ?>" alt="<?php the_title(); ?>" class="thumbnail" />
						<?php } ?>
					</a>			
				</div>
				<div class="r_title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" target="_blank" rel="bookmark"><?php the_title(); ?></a></div>
			</li>
			<?php
			$exclude_id .= ',' . $post->ID; $i ++;
		} wp_reset_query();
	}
	if ( $i < $post_num ) { 
		$cats = ''; foreach ( get_the_category() as $cat ) $cats .= $cat->cat_ID . ',';
		$args = array(
			'category__in' => explode(',', $cats), 
			'post__not_in' => explode(',', $exclude_id),
			'caller_get_posts' => 1,
			'orderby' => 'comment_date',
			'posts_per_page' => $post_num - $i
			);
		query_posts($args);
		while( have_posts() ) { the_post(); ?>
		<li class="related_box"  >
			<div class="r_pic">
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" target="_blank">
					<?php if (get_option('h_timthumb') == 'Enable') { ?>
					<img src="<?php echo get_template_directory_uri(); ?>/timthumb.php?src=<?php echo post_thumbnail_src(); ?>&h=100&w=120&zc=1" alt="<?php the_title(); ?>" class="thumbnail"/>
					<?php } else { ?>
					<img src="<?php echo post_thumbnail_src(); ?>" alt="<?php the_title(); ?>" class="thumbnail" />
					<?php } ?>
				</a>			
			</div>
			<div class="r_title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" target="_blank" rel="bookmark"><?php the_title(); ?></a></div>
		</li>
		<?php $i++;
	} wp_reset_query();
}
if ( $i  == 0 )  echo '<div class=\"r_title\">没有相关文章!</div>';
?>
</ul>
</div>