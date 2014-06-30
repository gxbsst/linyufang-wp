<?php get_header(); ?>

<div id="wrap-left" class="newInfor">
	<div class="hB">
		<a href="<?php echo get_option('Home'); ?>" title="首页">首页</a><em> &raquo; </em>
		<?php
		if( is_single() ){
			$categorys = get_the_category();
			$category = $categorys[0];
			echo( get_category_parents($category->term_id,true,'<em> &raquo; </em>') );echo'正文';
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
		<?php include(TEMPLATEPATH . '/includes/archive_title.php'); ?>
	</div>
</div>
<div id="wrap-right">
	<?php get_sidebar(); ?>
</div>
<div class="cl"></div>
<?php get_footer(); ?>