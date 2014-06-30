<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
	<?php include(TEMPLATEPATH . '/includes/seo.php');?>
	<link rel="shortcut icon" href="<?php  echo home_url(); ?>/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" />
	<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.min.js" type="text/javascript"></script>
	<?php wp_head(); ?>
	<?php echo stripslashes(get_option('h_head_code')); ?>
</head>
<body id="nv_forum" class="pg_index">
<!--[if lt IE 9]>
<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->
<!--[if IE 6]>
<script type="text/javascript" src="http://letskillie6.googlecode.com/svn/trunk/2/zh_CN.js"></script>
<![endif]-->
<div id="sidebar_l" class="sidebar_l">
	<div class="menu-link" id="menu-link">
		<div id="logoico"></div>
		<div class="menu-box tabs">
			<a class="current"><span><i class="h-icons icon-sms"></i>导航</span></a>
		</div>
		<div class="help-links">
			<div id="helpLinksBox">
				<a href="/guestbook" target="_blank" title="反馈" class="h-icons icon-support tooltip"></a>
			</div>
		</div>
	</div>
	<div class="sub-menu">
		<div id="groupAll">
			<ul class="group-list">
				<li groupid="-1" class="f group-item logClass selected" id="logClass" name="group_all">
					<form method="GET" action="<?php echo home_url(); ?>">
						<div class="ip"><input type="text"  name="s" id="search_input" value="请输入搜索内容" onFocus="if (value =='请输入搜索内容'){value =''}" onBlur="if (value ==''){value='请输入搜索内容'}" x-webkit-speech /></div>
						<button type="submit" class="fl cp"></button>
					</form>
				</li>
			</ul>
		</div>
		<div class="box visible">
			<?php if(function_exists('wp_nav_menu')) {wp_nav_menu(array( 'theme_location' => 'left-menu','menu_class'=>'main-nav') ); }?>
			<ul class="social">
				<li class="sinaweibo"><a href="<?php echo stripslashes(get_option('h_sinamblog')); ?>" class="tooltip" target="_blank" title="新浪微博">新浪微博</a></li>
				<li class="qqweibo"><a href="<?php echo stripslashes(get_option('h_qqmblog')); ?>" class="tooltip" target="_blank" title="腾讯微博">腾讯微博</a></li>
				<li class="email"><a href="<?php echo stripslashes(get_option('h_emailid')); ?>" target="_blank" class="tooltip" title="邮件订阅">Email</a></li>
				<li class="rss"><a href="<?php echo stripslashes(get_option('h_rsssub')); ?>" target="_blank" class="tooltip" title="RSS">RSS</a></li>
			</ul>
		</div>
	</div>
</div>
<div id="wrapper">
	<div class="wrapper">
		<div id="main">
			<div class="bbsname tal">
				<h2><a href="<?php echo home_url(); ?>" class="tooltip s4" title="WordPress大学 WPdaxue.com">WPdaxue.com</a></h2>
			</div>