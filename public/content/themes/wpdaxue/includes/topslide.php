<?php if (get_option('h_slide_content') == 'Category') { ?>
<?php include(TEMPLATEPATH . '/includes/slider_category.php'); ?>
<?php } else { include(TEMPLATEPATH . '/includes/slider_sticky.php'); } ?>
<div id="focus" class="topslide t">
	<a class="prev"></a><a class="next"></a>
	<div class="bd">
		<ul>
			<?php $i = 1; if (have_posts()) : ?>
			<?php while (have_posts()) : the_post(); ?>
				<li class="li<?php echo $i; ?>">
					<div class="pic">
						<a href="<?php the_permalink() ?>" target="_blank">
							<?php if (get_option('h_timthumb') == 'Enable') { ?>
							<img src="<?php echo get_template_directory_uri(); ?>/timthumb.php?src=<?php echo post_thumbnail_src(); ?>&h=240&w=470&zc=1" alt="<?php the_title(); ?>" class="thumbnail"/>
							<?php } else { ?>
							<img src="<?php echo post_thumbnail_src(); ?>" alt="<?php the_title(); ?>" class="thumbnail" />
							<?php } ?>
						</a>
					</div>
					<div class="con">
						<div class="bg"></div>
						<div class="title"><a href="<?php the_permalink() ?>" target="_blank"><?php the_title(); ?></a></div>
						<div class="intro"><?php echo dm_strimwidth(strip_tags($post->post_content),0,100,"..."); ?><a href="<?php the_permalink() ?>" target="_blank" rel="nofollow" class="more"  title="阅读《<?php the_title(); ?>》全文">[详细]</a></div>
					</div>
				</li>
				<?php $i++; ?>
			<?php endwhile; ?>
		<?php endif; wp_reset_query();?>
	</ul>
</div>
<div class="hd">
	<ul>
		<li class="li1"><span>1</span></li>
		<li class="li2"><span>2</span></li>
		<li class="li3"><span>3</span></li>
		<li class="li4"><span>4</span></li>
		<li class="li5"><span>5</span></li>
	</ul>
</div>
</div>
