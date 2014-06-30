<div class="t widget_recent_entries">
<div class="hc">
<span>近期热门</span>
</div>
<div class="h_widget cl">
	<ul>
	<?php if(function_exists('most_comm_posts')) most_comm_posts(get_option('h_side_tab_time'), get_option('h_side_tab_num')); ?>
	</ul>
</div>
</div>