			<div class="archive-title">
				<?php $posts = query_posts($query_string . get_option('h_archive_title'));?>
				<div class="page_navi"><?php par_pagenavi(7); ?></div>
				<ul>
					<?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>
						<li>
							<h3><span class="date"><?php post_views(' ', '<small> ℃ </small>'); ?> | <?php the_time('Y-m-d') ?></span> <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" target="_blank"><?php the_title(); ?></a> 
							</h3>
						</li>
					<?php endwhile; ?>
				</ul> 
			<?php else : ?>
				<h3>什么也找不到！</h3>
				<p>抱歉,你要找的文章不在这里.</p>
			<?php endif; ?>
			<div class="page_navi mt10"><?php par_pagenavi(7); ?></div>
		</div>