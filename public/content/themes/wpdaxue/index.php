<?php get_header(); ?>
<div id="wrap-left">
	<?php 
	if (get_option('h_slide_style') == 'Display') include(TEMPLATEPATH . '/includes/topslide.php');
	if (get_option('h_adt') == 'Display') include(TEMPLATEPATH . '/includes/adt.php');
	if (get_option('h_new') == 'Display') include(TEMPLATEPATH . '/includes/homenews.php'); 
	if (get_option('h_imgscroll') == 'Display') include(TEMPLATEPATH . '/includes/leftloop.php'); 
	?>

	<?php include(TEMPLATEPATH . '/includes/columns.php');?>
	<div class="cl"></div>
</div><!--wrap-left-->


<div id="wrap-right">
	<?php get_sidebar(); ?>
</div>
<div class="cl"></div>
<?php get_footer(); ?>