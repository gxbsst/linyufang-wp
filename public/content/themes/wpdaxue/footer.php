<div id="footer">
	<div class="s6">
		<?php echo stripslashes(get_option('h_foot_code')); ?>
	</div>
</div>
<script src="<?php echo get_template_directory_uri(); ?>/js/wpdaxue.js" type="text/javascript"></script>
<?php wp_reset_query(); if ( is_page('archives') ) { ?>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/js/archives.js"></script>
<?php } ?>
<?php wp_footer(); ?>
<div id="scrollBar"><a hidefocus="true" href="javascript:scroll(0,0)">回到顶部</a></div>
</body>
</html>