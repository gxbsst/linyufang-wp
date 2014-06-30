	<?php $i = 1; $display_categories = explode(',', get_option('h_cms_cat') ); foreach ($display_categories as $category) { ?> 
	<?php query_posts("cat=$category")?>
	<div class="t bmw column cat<?php echo $i;?> cl ">
		<div class="bm_h cl">
			<span class="more">
				<a rel="nofollow" href="<?php echo get_category_link($category);?>" target="_blank" title="查看更多 <?php single_cat_title(); ?> 分类下的文章"><?php single_cat_title(); ?></a>
			</span>
			<h2><a href="<?php echo get_category_link($category);?>" style=""><?php single_cat_title(); ?></a></h2>
		</div>
		<div class="bm_c">
			<div class="column-img cl">
				<ul>
					<?php query_posts( array('showposts' => 1,'cat' => $category));?>
					<?php while (have_posts()) : the_post(); ?>
						<li><div class="thumb"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
							<?php if (get_option('h_timthumb') == 'Enable') { ?>
							<img src="<?php echo get_template_directory_uri(); ?>/timthumb.php?src=<?php echo post_thumbnail_src(); ?>&h=80&w=80&zc=1" alt="<?php the_title(); ?>" class="thumbnail"/>
							<?php } else { ?>
							<img src="<?php echo post_thumbnail_src(); ?>" alt="<?php the_title(); ?>" class="thumbnail" />
							<?php } ?>
						</a></div>
						<div class="list-info"><div class="list-name"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></div><div class="list-summary"><?php echo dm_strimwidth(strip_tags($post->post_content),0,30,"..."); ?></div></div></li>
					<?php endwhile; ?>	
				</ul>
			</div><!--column-img-->	
			<div class="column-list cl">
				<?php query_posts( array('showposts' => 6,'cat' => $category,'offset' => 1));?>
				<ul>
					<?php while (have_posts()) : the_post(); ?>
						<li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" target="_blank"><?php the_title(); ?></a><span><?php the_time('m-d'); ?></span></li>
					<?php endwhile; ?>
				</ul>
			</div><!--column-list-->

		</div>
	</div>
	<?php $i++; ?>
	<?php } ?>