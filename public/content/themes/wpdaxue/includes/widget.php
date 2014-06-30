<?php

//边栏小工具

if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => '首页边栏',
		'before_widget' => '<div class="t %2$s">',
		'after_widget' => '</div></div>',
		'before_title' => '<div class="hc"><span>',
		'after_title' => '</span></div><div class="h_widget cl">',
		));
}

if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => '文章页面边栏',
		'before_widget' => '<div class="t %2$s">',
		'after_widget' => '</div></div>',
		'before_title' => '<div class="hc"><span>',
		'after_title' => '</span></div><div class="h_widget cl">',
		));
}

if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => '其他页面边栏',
		'before_widget' => '<div class="t %2$s">',
		'after_widget' => '</div></div>',
		'before_title' => '<div class="hc"><span>',
		'after_title' => '</span></div><div class="h_widget cl">',
		));
}

// 读者排行
class widget_readers extends WP_Widget{
	function widget_readers(){
		$widget_options = array('classname'=>'set_contact','description'=>'H-读者排行');
		$this->WP_Widget(false,'H-读者排行',$widget_options);
	}
	function widget($instance){
		include("widget/side_reader.php");
	}}
	add_action('widgets_init',create_function('', 'return register_widget("widget_readers");'));
//最新评论
	class widget_comment extends WP_Widget{
		function widget_comment(){
			$widget_options = array('classname'=>'set_contact','description'=>'H-最新评论');
			$this->WP_Widget(false,'H-最新评论',$widget_options);
		}
		function widget($instance){
			include("widget/side_comment.php");
		}}
		add_action('widgets_init',create_function('', 'return register_widget("widget_comment");'));
//最新/最热/随机
		class widget_tab extends WP_Widget{
			function widget_tab(){
				$widget_options = array('classname'=>'set_contact','description'=>'H-最新/最热/随机');
				$this->WP_Widget(false,'H-最新/最热/随机',$widget_options);
			}
			function widget($instance){
				include("widget/side_tab.php");
			}}
			add_action('widgets_init',create_function('', 'return register_widget("widget_tab");'));
//标签云
			class widget_tags extends WP_Widget{
				function widget_tags(){
					$widget_options = array('classname'=>'set_contact','description'=>'H-标签云');
					$this->WP_Widget(false,'H-标签云',$widget_options);
				}
				function widget($instance){
					include("widget/side_tags.php");
				}}
				add_action('widgets_init',create_function('', 'return register_widget("widget_tags");'));

// 用户登录
				class widget_login extends WP_Widget{
					function widget_login(){
						$widget_options = array('classname'=>'set_contact','description'=>'在边栏显示用户登录管理面板');
						$this->WP_Widget(false,'H-登录管理',$widget_options);
					}
					function widget($instance){
						include("widget/side_login.php");
					}}
					add_action('widgets_init',create_function('', 'return register_widget("widget_login");'));

// 近期热门
					class widget_hot extends WP_Widget{
						function widget_hot(){
							$widget_options = array('classname'=>'set_contact','description'=>'H-近期评论最多的文章');
							$this->WP_Widget(false,'H-近期热门',$widget_options);
						}
						function widget($instance){
							include("widget/side_hot.php");
						}}
						add_action('widgets_init',create_function('', 'return register_widget("widget_hot");'));

// 随机推荐
						class widget_rand extends WP_Widget{
							function widget_rand(){
								$widget_options = array('classname'=>'set_contact','description'=>'H-随机推荐');
								$this->WP_Widget(false,'H-随机推荐',$widget_options);
							}
							function widget($instance){
								include("widget/side_rand.php");
							}}
							add_action('widgets_init',create_function('', 'return register_widget("widget_rand");'));

//注销多余的小工具
							add_action( 'widgets_init', 'my_unregister_widgets' );   
							function my_unregister_widgets() {           
								unregister_widget( 'WP_Widget_Recent_Comments' );   
    //unregister_widget( 'WP_Widget_Recent_Posts' );
	//unregister_widget( 'WP_Widget_RSS' );   
								unregister_widget( 'WP_Widget_Search' );   
								unregister_widget( 'WP_Widget_Tag_Cloud' );    
								unregister_widget( 'WP_Nav_Menu_Widget' );   
							}  
							?>