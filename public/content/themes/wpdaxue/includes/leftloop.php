<div class="leftLoop t">
	<div class="hd">
		<a class="stitle"><?php echo get_option('h_imgscroll_title') ?></a>
		<a class="next"></a>
		<ul><li>1</li><li>2</li><li>3</li></ul>
		<a class="prev"></a>
	</div>
	<div class="bd">
		<ul class="picList">
			<?php
			$slider_img_id = explode(',', get_option('h_imgscroll_id'));
			query_posts(array(
				'posts_per_page' => 12,
				'category__in' =>$slider_img_id,
				'ignore_sticky_posts' => 1
				)
			);
			?>
			<?php if (have_posts()) : ?>
				<?php while (have_posts()) : the_post(); ?>   
					<li>
						<div class="pic"><a href="<?php the_permalink() ?>" target="_blank">
							<?php if (get_option('h_timthumb') == 'Enable') { ?>
							<img src="<?php echo get_template_directory_uri(); ?>/timthumb.php?src=<?php echo post_thumbnail_src(); ?>&h=180&w=150&zc=1" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="thumbnail"/>
							<?php } else { ?>
							<img src="<?php echo post_thumbnail_src(); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="thumbnail" />
							<?php } ?>
						</a>
					</div>
				</li>
			<?php endwhile; ?>
		<?php endif; wp_reset_query();?>	
	</ul>
</div>
</div>
