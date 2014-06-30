<?php get_header(); ?>
<div id="wrap-left">
	<div class="newInfor">
		<div class="hB">
			<a href="<?php echo get_option('Home'); ?>" title="首页">首页</a><em> &raquo; </em>
			抱歉，你要找的内容不存在
		</div>
		<div class="pcon">
			<div id="content" class="cl">
				<div class="post-title">
					<h1>【404】抱歉，你要找的内容不存在</h1>
				</div>
				<div class="post-content cl">
					<strong>请继续你的操作：</strong>
					<p><a href="<?php echo home_url(); ?>">返回首页</a></p>
					<p><a href="javascript:history.back();">返回前一页</a></p>
					<p><a href="/guestbook" target="_blank">留言将该错误链接提交给站长</a></p>
					<p>您还可以使用本站搜索功能找到你要的文章哦</p>
				</div>
			</div><!--content-->
		</div>
	</div>

</div><!--wrap-left-->

<div id="wrap-right">
	<?php get_sidebar(); ?>
</div>
<div class="cl"></div>
<?php get_footer(); ?>