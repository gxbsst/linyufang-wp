<div class="t bmw postbox cl">
	<div class="bm_h cl">
		<h2>最新文章</h2>
	</div>
	<div class="first_new">
		<?php $args = array( 'posts_per_page' => 1,'ignore_sticky_posts' => 1); query_posts($args);?>
		<?php while(have_posts()) : the_post(); ?>
			<a class="f_img" target="_blank" href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
				<?php if (get_option('h_timthumb') == 'Enable') { ?>
				<img src="<?php echo get_template_directory_uri(); ?>/timthumb.php?src=<?php echo post_thumbnail_src(); ?>&h=200&w=290&zc=1" alt="<?php the_title(); ?>" class="thumbnail"/>
				<?php } else { ?>
				<img src="<?php echo post_thumbnail_src(); ?>" alt="<?php the_title(); ?>" class="thumbnail" />
				<?php } ?>
			</a>
			<h3 class="f_title" >
				<a target="_blank" href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php echo cut_str($post->post_title,40); ?></a>
			</h3>
			<div class="f_summary"><?php echo dm_strimwidth(strip_tags($post->post_content),0,52,"..."); ?></div>
			<div class="f_time"><?php the_time('Y年m月d日') ?> / <?php post_views(' ', ' 人围观'); ?> / <?php comments_popup_link('坐沙发', '1次吐槽', '% 次吐槽'); ?></div>
		<?php endwhile; wp_reset_query();?>
	</div>

	<div class="new_post">
		<?php $args = array( 'posts_per_page' => 3,'ignore_sticky_posts' => 1,'offset'=> 1 );query_posts($args);?>
		<?php while(have_posts()) : the_post(); ?>
			<div class="new_box">
				<ul class="new_list cl">
					<li>
						<div class="new_thumb"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" target="_blank">
							<?php if (get_option('h_timthumb') == 'Enable') { ?>
							<img src="<?php echo get_template_directory_uri(); ?>/timthumb.php?src=<?php echo post_thumbnail_src(); ?>&h=80&w=80&zc=1" alt="<?php the_title(); ?>" class="thumbnail"/>
							<?php } else { ?>
							<img src="<?php echo post_thumbnail_src(); ?>" alt="<?php the_title(); ?>" class="thumbnail" />
							<?php } ?>
						</a></div>
						<div class="new_summary">
							<h3 class="new_name"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo cut_str($post->post_title,40); ?></a>	</h3>
							<?php if(has_excerpt()) the_excerpt();  
							else  
								echo dm_strimwidth(strip_tags($post->post_content),0,32,"..."); ?>
							<div class="new_time"><?php the_time('Y年m月d日') ?> / <?php post_views(' ', ' 人围观'); ?> / <?php comments_popup_link('坐沙发', '1次吐槽', '% 次吐槽'); ?></div>
						</div>
					</li>
				</ul>
			</div><!--category-->

		<?php endwhile; wp_reset_query();?>
	</div>
</div>