<?php
/*
Template Name: Tags
*/
?>
<?php get_header(); ?>
<div id="wrap-left">
	<div class="newInfor">
		<div class="hB">
			<a href="<?php echo get_option('Home'); ?>" title="首页">首页</a><em> &raquo; </em>
			<?php the_title(); ?>
		</div>
		<div class="pcon">
			<div id="content" class="cl">
				<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
					<div class="post-title">
						<h1><?php the_title(); ?></h1>
					</div>
					<div class="post-content cl">
						<?php wp_tag_cloud('smallest=12&largest=18&unit=px&number=300&orderby=count&order=DESC');?>
					</div>
				</div><!--content-->
			</div>
		</div>
	<?php endwhile; ?>

</div><!--wrap-left-->

<div id="wrap-right">
	<?php get_sidebar(); ?>
</div>
<div class="cl"></div>
<?php get_footer(); ?>