<?php get_header(); ?>
<div id="wrap-left">
	<div class="newInfor">
		<div class="hB">
			<a href="<?php echo get_option('Home'); ?>" title="首页">首页</a><em> &raquo; </em>
			<?php
			if( is_single() ){
				$categorys = get_the_category();
				$category = $categorys[0];
				echo( get_category_parents($category->term_id,true,'<em> &raquo; </em>') );echo '正文';
			} elseif ( is_page() ){
				the_title();
			} elseif ( is_category() ){
				single_cat_title();
			} elseif ( is_tag() ){
				single_tag_title();
			} elseif ( is_day() ){
				the_time('Y年Fj日');
			} elseif ( is_month() ){
				the_time('Y年F');
			} elseif ( is_year() ){
				the_time('Y年');
			} elseif ( is_search() ){
				echo htmlspecialchars($s).' 的搜索结果';
			}
			?>
		</div>
		<div class="pcon">
			<div id="content" class="clearfix">
				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
						<div class="post-title">
							<h1><?php the_title(); ?></h1>
							<div class="post-info mt10 clearfix">
								<?php the_author(); ?> 发布于 <?php the_time('Y年m月d日'); ?> + <?php post_views(' ', ' 人围观'); ?> + <?php comments_number('抢占沙发','1 次吐槽','% 次吐槽'); ?>
								<?php edit_post_link( '[编辑]'); ?>
							</div>
						</div>
						<div class="cl"></div>
						<div class="post-content cl">
							<?php if (get_option('h_adr') == 'Display') include(TEMPLATEPATH . '/includes/adr.php'); ?>
							<?php the_content(); include(TEMPLATEPATH . '/includes/content_page.php'); ?>
						</div>
						<!--/post-copyright -->
						<div class="post-copyright clearfix">
							<?php if ( get_post_meta($post->ID, 'site_url', true) ) { ?>
							<p><strong> 声明: </strong> 本文参考自(<a target="_blank" href="<?php echo get_post_meta($post->ID, "site_url", $single = true); ?>" title="<?php the_title(); ?>"><?php echo get_post_meta($post->ID, "site_name", $single = true); ?></a>)，由(<?php the_author_posts_link(); ?>)整编</p>
							<p><strong> 本文链接: </strong><a href="<?php the_permalink()?>" title="<?php the_title(); ?>" target="_blank"><?php the_permalink()?></a></p>
							<?php } else { ?>
							<p><strong> 声明: </strong> 本文由(<?php the_author_posts_link(); ?>)原创编译，转载请保留链接: <a href="<?php the_permalink()?>" title="<?php the_title(); ?>" target="_blank"><?php the_permalink()?></a></p>
							<?php } ?>
						</div>
						<!--post-copyright /-->
						<?php if (get_option('h_adb') == 'Display') include(TEMPLATEPATH . '/includes/adb.php'); ?>
						<div class="con_pretext clearfix">
							<ul>
								<li class="first">
									<?php $prev_post = get_previous_post();if ($prev_post){ ?>
									上一篇：<?php previous_post_link('%link') ?>
									<?php } else { echo '当前为最早发布的文章，木有更早的啦！';} ?>
								</li>
								<li class="last">
									<?php $next_post = get_next_post();if ($next_post){ ?>
									下一篇：<?php next_post_link('%link') ?>
									<?php } else { echo '当前为最新发布的文章，明天再来看下一篇吧！' ; }?>
								</li>
							</ul>
						</div><!--上一页 下一页--> 
					</div> 
				</div><!--content-->
			</div>
		</div>
		<?php if (get_option('h_related') == 'related_title') { 
			include(TEMPLATEPATH . '/includes/related_title.php'); }
			elseif (get_option('h_related') == 'related_img') {
				include(TEMPLATEPATH . '/includes/related_img.php'); }
				else {echo '';} ?>

				<?php if (comments_open()) comments_template( '', true ); ?>
			<?php endwhile; ?>

		</div><!--wrap-left-->

		<div id="wrap-right">
			<?php get_sidebar(); ?>
		</div>
		<div class="cl"></div>
		<?php get_footer(); ?>