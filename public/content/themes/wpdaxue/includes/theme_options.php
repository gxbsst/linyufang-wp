<?php ob_start();
$themename = "wpdaxue";
$shortname = "h";
$categories = get_categories('hide_empty=0&orderby=name');
$wp_cats = array();
foreach ($categories as $category_list ) {
	$wp_cats[$category_list->cat_ID] = $category_list->cat_name;
}
$number_entries = array("Select a Number:","1","2","3","4","5","6","7","8","9","10", "12","14", "16", "18", "20" );
$options = array ( 
	array( "name" => $themename." Options",
		"type" => "title"),

//基本信息设置
	array( "name" => "基本信息设置",
		"type" => "section"),
	array( "type" => "open"),

	array("name" => "★ 新浪微博地址(包含http://)",
		"desc" => "",
		"id" => $shortname."_sinamblog",
		"type" => "text",
		"std" => "http://weibo.com/wpdaxue"),

	array("name" => "★ 腾讯微博地址(包含http://)",
		"desc" => "",
		"id" => $shortname."_qqmblog",
		"type" => "text",
		"std" => "http://t.qq.com/wpdaxue"),

	array("name" => "★ Feed地址(包含http://)",
		"desc" => "",
		"id" => $shortname."_rsssub",
		"type" => "text",
		"std" => "http://feed.feedsky.com/wpdaxue"),

	array("name" => "★ 腾讯邮件订阅地址",
		"desc" => "不会设置？请阅读 <a href='http://www.cmhello.com/list-qq-com.html' target='_blank'>QQ邮件列表：自动定时发送最新文章到订阅者的邮箱</a> ",
		"id" => $shortname."_emailid",
		"type" => "text",
		"std" => "http://list.qq.com/cgi-bin/qf_invite?id=ed4d4e0ee165b9c45fb71fafb5272e6d981268f02f2d7d81"),
	
	array(	"name" => "★ 首页描述（Description）",
		"desc" => "",
		"id" => $shortname."_description",
		"type" => "textarea",
		"std" => "输入你的网站描述，一般不超过200个字符"),

	array(	"name" => "★ 首页关键词（KeyWords）",
		"desc" => "",
		"id" => $shortname."_keywords",
		"type" => "textarea",
		"std" => "输入你的网站关键词，每个关键词中间请用英文逗号＂,＂隔开，一般不超过100个字符"),

	array("name" => "★ 头部代码",
		"desc" => "在 &lt;head&gt; 标签中输出，可以添加JS或CSS等",
		"id" => $shortname."_head_code",
		"type" => "textarea",
		"std" => ''),

	array("name" => "★ 底部代码",
		"desc" => "自行修改版权信息，还可在此添加流量统计代码（请保留 <a class=\"s4 tooltip\" href=\"http://www.wpdaxue.com\" title=\"WordPress大学主题\" target=\"_blank\">WPDAXUE</a> 主题链接，谢谢） ",
		"id" => $shortname."_foot_code",
		"type" => "textarea",
		"std" => '<p>&copy; 2012 <a href="/" class="s4 tooltip" title="WPdaxue.com">WPDAXUE.COM</a> All Rights Reserved , Powered by <a class="s4 tooltip" href="http://www.wordpress.org/" title="WordPress" target="_blank"> WordPress </a> & <a class="s4 tooltip" href="http://www.wpdaxue.com" title="WordPress大学主题" target="_blank">WPDAXUE</a>.</p>'),


//布局样式设置
	array( "type" => "close"),
	array( "name" => "布局样式设置",
		"type" => "section"),
	array( "type" => "open"),


	array(	"name" => "★ CMS分类ID设置",
		"desc" => "输入分类ID，多个分类请用英文逗号＂,＂隔开",
		"id" => $shortname."_cms_cat",
		"type" => "text",
		"std" => "1,2"),

	array(	"name" => "★ 显示 最新文章？",
		"desc" => "默认【隐藏Hidden】，可选【显示Display】",
		"id" => $shortname."_new",
		"type" => "select",
		"std" => "Hidden",
		"options" => array("Hidden", "Display")),

	array(	"name" => "<span class='child'>○ 最新文章篇数</span>",
		"desc" => "<span class='child'>→ 默认 4 篇</span>",
		"id" => $shortname."_new_num",
		"type" => "text",
		"std" => "4"),

	array(  "name" => "★ 显示 首页头部幻灯？",
		"desc" => "默认【隐藏Hidden】，可选【显示Display】",
		"id" => $shortname."_slide_style",
		"type" => "select",
		"std" => "Hidden",
		"options" => array("Hidden", "Display")),

	array(  "name" => "<span class='child'>○ 幻灯内容</span>",
		"desc" => "<span class='child'>→ 默认【置顶文章Sticky】,可选【特定分类Category】，请设置分类ID</span>",
		"id" => $shortname."_slide_content",
		"type" => "select",
		"std" => "Sticky",
		"options" => array("Sticky", "Category")),

	array(	"name" => "<span class='child'>○ 特定分类ID</span>",
		"desc" => "<span class='child'>→ 多个分类ID请用英文逗号＂,＂隔开</span>",
		"id" => $shortname."_slide_cat",
		"type" => "text",
		"std" => ""),
	
	array(  "name" => "★ 显示 热门推荐？",
		"desc" => "多图轮播那里，默认【隐藏Hide】，如选【显示Display】，请设置下面的参数：",
		"id" => $shortname."_imgscroll",
		"type" => "select",
		"std" => "Hide",
		"options" => array("Hide", "Display")),
	
	array(	"name" => "<span class='child'>○ 热门推荐的分类ID</span>",
		"desc" => "<span class='child'>→ 多个分类ID请用英文逗号＂,＂隔开</span>",
		"id" => $shortname."_imgscroll_id",
		"type" => "text",
		"std" => ""),
	array(	"name" => "<span class='child'>○ 热门推荐的标题</span>",
		"desc" => "<span class='child'>→ 填写标题，默认为“热门推荐”</span>",
		"id" => $shortname."_imgscroll_title",
		"type" => "text",
		"std" => "热门推荐"),


	array(	"name" => "★ 分类页面样式设置",
		"desc" => "默认【图文列表】，若要显示为【标题列表】，请输入分类ID，多个分类用英文逗号＂,＂隔开，<br/>填写全部分类ID即所有分类页面都为【标题列表】",
		"id" => $shortname."_archive",
		"type" => "text",
		"std" => ""),

	array(	"name" => "<span class='child'>○ 【标题列表】每页篇数</span>",
		"desc" => "<span class='child'>→ 默认 30 篇（修改数字即可）</span><br /><font color=#08A5E0>注：【图文列表】篇数设置，请访问 <a href='/wp-admin/options-reading.php' target='_blank'>WP后台->设置->阅读</a>，设置[博客页面至多显示]篇数，<br />建议10篇，且不能超过【标题列表】篇数！</font>",
		"id" => $shortname."_archive_title",
		"type" => "text",
		"std" => "&orderby=date&showposts=30"),

	array(  "name" => "★ 文章底部【相关文章】设置",
		"desc" => "默认【隐藏Hide】，你可以选择【title样式】或【img样式】",
		"id" => $shortname."_related",
		"type" => "select",
		"std" => "Hide",
		"options" => array("Hide","related_title", "related_img")),
	
	array(	"name" => "<span class='child'>○ 设置相关文章篇数</span>",
		"desc" => "<span class='child'>→ 【title样式】默认显示5篇(可修改);【img样式】固定为5篇(不可改)</span>",
		"id" => $shortname."_related_num",
		"type" => "text",
		"std" => "5"),

//侧边栏设置
	array( "type" => "close"),
	array( "name" => "侧边栏设置",
		"type" => "section"),
	array( "type" => "open"),

	array("name" => "★【最新/热门/随机】文章数",
		"desc" => "默认为 10 篇",
		"id" => $shortname."_side_tab_num",
		"type" => "text",
		"std" => "10"),

	array("name" => "★【热门文章】排行期限",
		"desc" => "【热门文章】是限制时间段内评论最多的文章，默认为60天",
		"id" => $shortname."_side_tab_time",
		"type" => "text",
		"std" => "60"),

	array("name" => "★【博主昵称】",
		"desc" => "让侧边栏的【读者排行】和【最新评论】不显示您的头像及内容",
		"id" => $shortname."_outer",
		"type" => "text",
		"std" => "博主"),

	array("name" => "★【读者排行】期限",
		"desc" => "如：输入 3 ,表示调用3个月内评论最多的读者头像",
		"id" => $shortname."_timer",
		"type" => "text",
		"std" => "3"),

	array("name" => "★【读者排行】个数",
		"desc" => "如：输入 12 ,将显示12个读者头像,建议输入3和4的公倍数",
		"id" => $shortname."_limit",
		"type" => "text",
		"std" => "12"),

	array("name" => "★【标签云】参数",
		"desc" => "说明：largest=最大字号&smallest=最小字号&unit=字体单位&number=显示个数",
		"id" => $shortname."_side_tags_set",
		"type" => "text",
		"std" => "largest=18&smallest=12&unit=px&number=38"),

	array("name" => "★【最新评论】条数",
		"desc" => "如：输入 5 ,将显示 5 条最新评论",
		"id" => $shortname."_com_limit",
		"type" => "text",
		"std" => "5"),


//广告设置
	array( "type" => "close"),
	array( "name" => "广告设置",
		"type" => "section"),
	array( "type" => "open"),

	array(  "name" => "★【菜单下通栏】广告",
		"desc" => "默认【隐藏Hide】",
		"id" => $shortname."_adt",
		"type" => "select",
		"std" => "Hide",
		"options" => array("Hide", "Display")),

	array(	"name" => "输入广告代码",
		"desc" => "",
		"id" => $shortname."_adtc",
		"type" => "textarea",
		"std" => '请输入广告代码，支持百度、Google联盟等，最大宽度为730px'),
	
	array(  "name" => "★【正文右上】广告",
		"desc" => "默认【隐藏Hide】",
		"id" => $shortname."_adr",
		"type" => "select",
		"std" => "Hide",
		"options" => array("Hide", "Display")),

	array(	"name" => "输入广告代码",
		"desc" => "",
		"id" => $shortname."_adrc",
		"type" => "textarea",
		"std" => '请输入广告代码，支持百度、Google联盟等，高宽为250*250'),

	array(  "name" => "★【正文底部】广告",
		"desc" => "默认【隐藏Hide】",
		"id" => $shortname."_adb",
		"type" => "select",
		"std" => "Hide",
		"options" => array("Hide", "Display")),

	array(	"name" => "输入广告代码",
		"desc" => "",
		"id" => $shortname."_adbc",
		"type" => "textarea",
		"std" => '请输入广告代码，支持百度、Google联盟等，最大宽度为700px'),


//高级功能设置
	array( "type" => "close"),
	array( "name" => "高级功能设置",
		"type" => "section"),
	array( "type" => "open"),

	array(  "name" => "★ 显示 评论表情 ？",
		"desc" => "在评论框上方显示表情，默认【显示Display】，可选【隐藏Hidden】",
		"id" => $shortname."_smiley",
		"type" => "select",
		"std" => "Display",
		"options" => array("Display","Hidden")),

	array(  "name" => "★ 启用自带 垃圾评论拦截 ？",
		"desc" => "建议不要和其他同类插件共用，下同",
		"id" => $shortname."_anti_spam",
		"type" => "select",
		"std" => "Disable",
		"options" => array("Disable", "Enable")),

	array(  "name" => "★ 启用自带 邮件评论通知 ？",
		"desc" => "评论被回复后通知评论者，需主机支持 mail函数，如果无效，请禁用！",
		"id" => $shortname."_comment_mail_notify",
		"type" => "select",
		"std" => "Disable",
		"options" => array("Disable", "Enable")),

	array("name" => "★ 你的投稿提醒邮箱 ",
		"desc" => "如果有人投稿，将发邮件提醒你，请测试多种邮箱，需mail函数支持<br />关于投稿功能，请阅读 <a href='http://www.cmhello.com/wordpress-add-contribute-page.html' target='_blank'>WordPress添加投稿功能</a> ",
		"id" => $shortname."_admin_email",
		"type" => "text",
		"std" => "123@123.com"),

	array(  "name" => "★ 启用 稿件发布通知 ？",
		"desc" => "稿件审核发布后，邮件通知投稿人，需mail函数支持",
		"id" => $shortname."_tougao_notify",
		"type" => "select",
		"std" => "Disable",
		"options" => array("Disable", "Enable")),

	array(  "name" => "★ 启用 feed订阅版权输出？",
		"desc" => "在feed订阅的文章底部输出版权声明，<a href='http://feed.feedsky.com/cmhello' target='_blank'>查看样例</a>",
		"id" => $shortname."_feednote",
		"type" => "select",
		"std" => "Disable",
		"options" => array("Disable", "Enable")),

	array(  "name" => "★ 启用 短代码功能 ？",
		"desc" => "启用后，你可以在 <a href='/wp-admin/themes.php?page=h_shortcode_page' target='_blank'>WP后台-外观-Htwo短代码提示</a> ，查看使用方法<br />如果想添加短代码快捷按钮，可<a href='http://www.cmhello.com/hcms-quicktags.html' target='_blank'>参考这篇文章</a>",
		"id" => $shortname."_shortcode",
		"type" => "select",
		"std" => "Disable",
		"options" => array("Disable", "Enable")),

	array(  "name" => "★ 启用自带 头像缓存 ？",
		"desc" => "<font color=#08A5E0>启用前，请在 网站根目录 新建avatar文件夹，Linux主机用户将该文件夹权限设为755或777，<br />并且上传一个名为 default.jpg 的默认头像到 avatar文件夹</font>",
		"id" => $shortname."_my_avatar",
		"type" => "select",
		"std" => "Disable",
		"options" => array("Disable", "Enable")),

	array(  "name" => "★ 启用 timthumb截图功能 ？",
		"desc" => "<font color=#08A5E0>启用后，会自动按需生成缩略图，加快首页等图片多的页面的加载速度，需要主机支持GD库，<br />开启后会占用一定的服务器资源，也会占用一点空间。<a href='http://www.cmhello.com/timthumb.html' target='_blank'>了解什么是timthumb</a></font>",
		"id" => $shortname."_timthumb",
		"type" => "select",
		"std" => "Enable",
		"options" => array("Enable","Disable" )),

	array(  "name" => "★ 订阅 WordPress大学 ？",
		"desc" => "在后台首页显示 <a href='http://www.wpdaxue.com/' target='_blank'>WordPress大学</a> 更新，帮你解决WordPress问题！",
		"id" => $shortname."_feed_cmhello",
		"type" => "select",
		"std" => "Enable",
		"options" => array("Enable", "Disable")),

	array(	"type" => "close") 
	);
function mytheme_add_admin() {
	global $themename, $shortname, $options;
	if ( @$_GET['page'] == basename(__FILE__) ) {
		if ( 'save' == @$_REQUEST['action'] ) {
			foreach ($options as $value) {
				update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
				foreach ($options as $value) {
					if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }
					header("Location: admin.php?page=theme_options.php&saved=true");
					exit();
				}
				else if( 'reset' == @$_REQUEST['action'] ) {
					foreach ($options as $value) {
						delete_option( $value['id'] ); }
						header("Location: admin.php?page=theme_options.php&reset=true");
						exit();
					}
				}
				add_theme_page($themename."主题设置", $themename."主题设置", 'edit_themes', basename(__FILE__), 'mytheme_admin');
			}
			function mytheme_add_init() {
				$file_dir=get_bloginfo('template_directory');
				wp_enqueue_style("functions", $file_dir."/includes/options/options.css", false, "1.0", "all");
				wp_enqueue_script("rm_script", $file_dir."/includes/options/rm_script.js", false, "1.0");
			}
			function mytheme_admin() {
				global $themename, $shortname, $options;
				$i=0;
				if ( @$_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.'主题设置已保存</strong></p></div>';
				if ( @$_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.'主题已重新设置</strong></p></div>';
				?>
				<div class="wrap rm_wrap">
					<div id="icon-themes" class="icon32"><br></div>
					<h2><?php echo $themename; ?>主题设置</h2>
					<p>当前使用主题: <?php echo $emename; ?> |设计者: <a href="http://www.cmhello.com" target="_blank">倡萌</a> @ <a href="http://www.wpdaxue.com" target="_blank">WordPress大学</a> |  <a href="http://www.wpdaxue.com/<?php echo $themename; ?>-theme.html" target="_blank">主题更新及使用指南（必看）</a></p> 
					<?php
					function show_category() {
						global $wpdb;
						$request = "SELECT $wpdb->terms.term_id, name FROM $wpdb->terms ";
						$request .= " LEFT JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id ";
						$request .= " WHERE $wpdb->term_taxonomy.taxonomy = 'category' ";
						$request .= " ORDER BY term_id asc";
						$categorys = $wpdb->get_results($request);
	foreach ($categorys as $category) { //调用菜单
		$output = '<span>'.$category->name."(<em>".$category->term_id.'</em>)</span>';
		echo $output;
	}
}//栏目列表结束
?> 
<div id="all_cat">
	<h4>站点所有分类ID:</h4>
	<?php show_category(); ?> 
	<br />
	<small>注: 这些分类ID将在下面的【布局样式设置】中用到。</small>
</div>
<div class="rm_opts">
	<form method="post">
		<?php foreach ($options as $value) {
			switch ( $value['type'] ) {
				case "open":
				?> 
				<?php break;case "close": ?>
			</div>
		</div>
		<br /> 
		<?php break; case "title": ?>
		<?php break; case 'text': ?>
		<div class="rm_input rm_text">
			<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
			<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id'])  ); } else { echo $value['std']; } ?>" />
			<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
		</div>
		<?php break; case 'textarea': ?>
		<div class="rm_input rm_textarea">
			<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
			<textarea name="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_option( $value['id'] ) != "") { echo stripslashes(get_option( $value['id']) ); } else { echo $value['std']; } ?></textarea>
			<small><?php echo $value['desc']; ?></small><div class="clearfix"></div> 
		</div> 
		<?php break;case 'select': ?>
		<div class="rm_input rm_select">
			<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
			<select name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
				<?php foreach ($value['options'] as $option) { ?>
				<option <?php if (get_option( $value['id'] ) == $option) { echo 'selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?>
			</select>
			<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
		</div>
		<?php break; case "checkbox": ?>
		<div class="rm_input rm_checkbox">
			<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
			<?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
			<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
			<small><?php echo $value['desc']; ?></small><div class="clearfix"></div>
		</div>
		<?php break; case "section": $i++; ?>
		<div class="rm_section">
			<div class="rm_title">
				<h3><img src="<?php echo get_template_directory_uri();?>/includes/options/clear.png" class="inactive" alt=""><?php echo $value['name']; ?></h3>
				<span class="submit"><input name="save<?php echo $i; ?>" type="submit" value="保存设置" /></span>
				<div class="clearfix"></div>
			</div>
			<div class="rm_options">
				<?php break; }} ?>
				<input type="hidden" name="action" value="save" />
			</form>
			<span class="show_id">
				<p><strong>倡萌提示：</strong></p>
				<p>1.首次使用该主题，请随意点击一次【保存设置】初始化主题，否则可能会错位！详细使用方法，请阅读 <a href="http://www.wpdaxue.com/wpdaxue-theme.html" target="_blank">wpdaxue主题使用教程</a></p>
				<p>2.主题支持小工具，请访问 <a href="/wp-admin/widgets.php" target="_blank">外观-小工具</a> 进行边栏设置。边栏广告，使用[文本]小工具添加即可。</p>
				<p>3.导航菜单，请到 <a href="/wp-admin/nav-menus.php" target="_blank">外观-菜单</a> 设置。</p>
				<p>4.如果你觉得主题对你有帮助，请赞助倡萌<br /><a href="https://me.alipay.com/cmhello" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/includes/options/alipay.png"></a></p>
				<p>5.如果要恢复到主题默认设置，请点击：</p>
				<form method="post">
					<input name="reset" type="submit" value="恢复默认设置" />
					<input type="hidden" name="action" value="reset" />
				</form><p style="color:#FF0000">提示：此按钮将恢复主题初始状态，您的所有设置将消失！请谨慎操作！！</p>
			</span>
		</div>
<?php } ?>
<?php
function mytheme_wp_head() { 
	$stylesheet = get_option('h_alt_stylesheet');
	if($stylesheet != ''){?>
		<link href="<?php echo get_template_directory_uri(); ?>/styles/<?php echo $stylesheet; ?>" rel="stylesheet" type="text/css" />
<?php }
} 
add_action('wp_head', 'mytheme_wp_head');
add_action('admin_init', 'mytheme_add_init');
add_action('admin_menu', 'mytheme_add_admin');
?>