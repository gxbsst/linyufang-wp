	<div class="cl">
		<?php 
		$posts = query_posts($query_string .'&orderby=date');?>
		<div class="page_navi"><?php par_pagenavi(7); ?></div>
		<?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>
			<div class="archive-img">
				<ul class="archive-list clearfix">
					<li>
						<?php if ( is_sticky() ) { ?>
						<h3 class="name sticky">
							<?php } else { ?>
							<h3 class="name">
								<?php } ?>
								<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php echo cut_str($post->post_title,80); ?></a>
							</h3>
							<div class="thumb"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" target="_blank">
								<?php if (get_option('h_timthumb') == 'Enable') { ?>
								<img src="<?php echo get_template_directory_uri(); ?>/timthumb.php?src=<?php echo post_thumbnail_src(); ?>&h=120&w=160&zc=1" alt="<?php the_title(); ?>" class="thumbnail"/>
								<?php } else { ?>
								<img src="<?php echo post_thumbnail_src(); ?>" alt="<?php the_title(); ?>" class="thumbnail" />
								<?php } ?>
							</a></div>
							<div class="summary cl">
								<?php echo dm_strimwidth(strip_tags($post->post_content),0,140,"..."); ?>
								<div class="time"><?php the_time('Y年m月d日') ?> / <?php post_views(' ', ' 人围观'); ?> / <?php comments_popup_link('抢占沙发', '1次吐槽', '% 次吐槽'); ?> <?php edit_post_link( '[编辑]'); ?></div>
							</div>
						</li>
					</ul>
				</div><!--category-->
			<?php endwhile; ?>
		<?php else : ?>
			<h3>什么也找不到！</h3>
			<p>抱歉,你要找的文章不在这里.</p>
		<?php endif; ?>
		<div class="page_navi"><?php par_pagenavi(7); ?></div>


	</div><!--wrap-left-->