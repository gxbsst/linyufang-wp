<?php
//添加导航
if ( function_exists('register_nav_menus') ) {
	register_nav_menus(array(
		'left-menu' => '左边栏菜单'
		));}

//修改默认邮箱
	function res_from_email($email) {
		$wp_from_email = get_option('admin_email');
		return $wp_from_email;
	}

	function res_from_name($email){
		$wp_from_name = get_option('blogname');
		return $wp_from_name;
	}

	add_filter('wp_mail_from', 'res_from_email');
	add_filter('wp_mail_from_name', 'res_from_name');

//修复友链函数

	add_filter( 'pre_option_link_manager_enabled', '__return_true' );

//标题截断
	function cut_str($src_str,$cut_length){$return_str='';$i=0;$n=0;$str_length=strlen($src_str);
	while (($n<$cut_length) && ($i<=$str_length))
		{$tmp_str=substr($src_str,$i,1);$ascnum=ord($tmp_str);
			if ($ascnum>=224){$return_str=$return_str.substr($src_str,$i,3); $i=$i+3; $n=$n+2;}
			elseif ($ascnum>=192){$return_str=$return_str.substr($src_str,$i,2);$i=$i+2;$n=$n+2;}
			elseif ($ascnum>=65 && $ascnum<=90){$return_str=$return_str.substr($src_str,$i,1);$i=$i+1;$n=$n+2;}
			else {$return_str=$return_str.substr($src_str,$i,1);$i=$i+1;$n=$n+1;}
		}
		if ($i<$str_length){$return_str = $return_str . '...';}
		if (get_post_status() == 'private'){ $return_str = $return_str . '（private）';}
		return $return_str;};

//添加特色缩略图支持
		if ( function_exists('add_theme_support') )add_theme_support('post-thumbnails');

//输出缩略图地址 From wpdaxue.com
		function post_thumbnail_src(){
			global $post;
	if( $values = get_post_custom_values("thumb") ) {	//输出自定义域图片地址
		$values = get_post_custom_values("thumb");
		$post_thumbnail_src = $values [0];
	} elseif( has_post_thumbnail() ){    //如果有特色缩略图，则输出缩略图地址
		$thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full');
		$post_thumbnail_src = $thumbnail_src [0];
	} else {
		$post_thumbnail_src = '';
		ob_start();
		ob_end_clean();
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		if(!empty($matches[1][0])){
			$post_thumbnail_src = $matches[1][0];   //获取该图片 src
		}else{	//如果日志中没有图片，则显示随机图片
			$random = mt_rand(1, 10);
			$post_thumbnail_src = get_template_directory_uri().'/images/pic/'.$random.'.jpg';
			//如果日志中没有图片，则显示默认图片
			//$post_thumbnail_src = get_template_directory_uri().'/images/default_thumb.jpg';
		}
	};
	echo $post_thumbnail_src;
} 

//访问计数
function record_visitors(){
	if (is_singular()) {global $post;
		$post_ID = $post->ID;
		if($post_ID) 
		{
			$post_views = (int)get_post_meta($post_ID, 'views', true);
			if(!update_post_meta($post_ID, 'views', ($post_views+1))) 
			{
				add_post_meta($post_ID, 'views', 1, true);
			}
		}
	}
}
add_action('wp_head', 'record_visitors');  
function post_views($before = '(点击 ', $after = ' 次)', $echo = 1)
{
	global $post;
	$post_ID = $post->ID;
	$views = (int)get_post_meta($post_ID, 'views', true);
	if ($echo) echo $before, number_format($views), $after;
	else return $views;
};

//文章归档
function h_archives_list() {
	if( !$output = get_option('h_archives_list') ){
		$output = '<div id="archives"><p>[<a id="al_expand_collapse" href="#">全部展开/收缩</a>] <em>(注: 点击月份可以展开)</em></p>';
		$the_query = new WP_Query( 'posts_per_page=-1&ignore_sticky_posts=1' ); 
		$year=0; $mon=0; $i=0; $j=0;
		while ( $the_query->have_posts() ) : $the_query->the_post();
		$year_tmp = get_the_time('Y');
		$mon_tmp = get_the_time('m');
		$y=$year; $m=$mon;
		if ($mon != $mon_tmp && $mon > 0) $output .= '</ul></li>';
		if ($year != $year_tmp && $year > 0) $output .= '</ul>';
		if ($year != $year_tmp) {
			$year = $year_tmp;
			$output .= '<h3 class="al_year">'. $year .' 年</h3><ul class="al_mon_list">'; 
		}
		if ($mon != $mon_tmp) {
			$mon = $mon_tmp;
			$output .= '<li><span class="al_mon">'. $mon .' 月</span><ul class="al_post_list">'; 
		}
		$output .= '<li>'. get_the_time('d日: ') .'<a href="'. get_permalink() .'" target="_blank">'. get_the_title() .'</a> <em>('. get_comments_number('0', '1', '%') .')</em></li>'; 
		endwhile;
		wp_reset_postdata();
		$output .= '</ul></li></ul></div>';
		update_option('h_archives_list', $output);
	}
	echo $output;
}
function clear_zal_cache() {
	update_option('h_archives_list', ''); 
}
add_action('save_post', 'clear_zal_cache'); 

//分页功能
function par_pagenavi($range = 9){
	global $paged, $wp_query;
	$max_page = $wp_query->max_num_pages;
	if($max_page > 1){if(!$paged){$paged = 1;}
	if($paged != 1){echo "<a href='" . get_pagenum_link(1) . "' class='extend' title='第一页'>&laquo;</a>";}
	previous_posts_link('&lt;');
	if($max_page > $range){
		if($paged < $range){for($i = 1; $i <= ($range + 1); $i++){echo "<a href='" . get_pagenum_link($i) ."'";
		if($i==$paged)echo " class='current'";echo ">$i</a>";}}
		elseif($paged >= ($max_page - ceil(($range/2)))){
			for($i = $max_page - $range; $i <= $max_page; $i++){echo "<a href='" . get_pagenum_link($i) ."'";
				if($i==$paged)echo " class='current'";echo ">$i</a>";}}
			elseif($paged >= $range && $paged < ($max_page - ceil(($range/2)))){
				for($i = ($paged - ceil($range/2)); $i <= ($paged + ceil(($range/2))); $i++){echo "<a href='" . get_pagenum_link($i) ."'";if($i==$paged) echo " class='current'";echo ">$i</a>";}}}
					else{for($i = 1; $i <= $max_page; $i++){echo "<a href='" . get_pagenum_link($i) ."'";
				if($i==$paged)echo " class='current'";echo ">$i</a>";}}
				next_posts_link('&gt;');
				if($paged != $max_page){echo "<a href='" . get_pagenum_link($max_page) . "' class='extend' title='最后一页'>&raquo;</a>";}}
			};

//边栏热门文章
			function most_comm_posts($days=30, $nums=10) {
				global $wpdb;
				$today = date("Y-m-d H:i:s"); 
				$daysago = date( "Y-m-d H:i:s", strtotime($today) - ($days * 24 * 60 * 60) ); 
				$result = $wpdb->get_results("SELECT comment_count, ID, post_title, post_date FROM $wpdb->posts WHERE post_date BETWEEN '$daysago' AND '$today' ORDER BY comment_count DESC LIMIT 0 , $nums");
				$output = '';
				if(empty($result)) {
					$output = '<li>None data.</li>';
				} else {
					foreach ($result as $topten) {
						$postid = $topten->ID;
						$title = $topten->post_title;
						$commentcount = $topten->comment_count;
						if ($commentcount != 0) {
							$output .= '<li><a href="'.get_permalink($postid).'" title="'.$title.'">'.$title.'</a></li>';
						}
					}
				}
				echo $output;
			}

//边栏读者排行*
			function h_readers($outer,$timer,$limit){
				global $wpdb;
				$counts = $wpdb->get_results("SELECT COUNT(comment_author) AS cnt, comment_author, comment_author_url, comment_author_email FROM (SELECT * FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->posts.ID=$wpdb->comments.comment_post_ID) WHERE comment_date > date_sub( NOW(), INTERVAL $timer MONTH ) AND user_id='0' AND comment_author != '$outer' AND post_password='' AND comment_approved='1' AND comment_type='') AS tempcmt GROUP BY comment_author ORDER BY cnt DESC LIMIT $limit");   
				$mostactive = ''; 
				foreach ($counts as $count) {
					$c_url = $count->comment_author_url;
					if ($c_url == '') $c_url = home_url();
					$mostactive .= '<a rel="nofollow" href="'. $c_url . '" title="' . $count->comment_author .' 留下 '. $count->cnt . ' 个脚印" target="_blank">' . get_avatar($count->comment_author_email, 48, '', $count->comment_author . ' 留下 ' . $count->cnt . ' 个脚印') . '</a>';
				}
				echo $mostactive;
			} 

//边栏彩色标签
			function colorCloud($text) {$text = preg_replace_callback('|<a (.+?)>|i','colorCloudCallback', $text);return $text;}
			function colorCloudCallback($matches) {
				$text = $matches[1];
				$color = dechex(rand(0,16777215));
				$pattern = '/style=(\'|\”)(.*)(\'|\”)/i';
				$text = preg_replace($pattern, "style=\"color:#{$color};$2;\"", $text);
				return "<a $text>";}
				add_filter('wp_tag_cloud', 'colorCloud', 1);

//边栏评论*
				function h_comments($outer,$limit){
					global $wpdb;
					$sql = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_date_gmt, comment_approved, comment_type,comment_author_url,comment_author_email, SUBSTRING(comment_content,1,22) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' AND user_id='0' AND comment_author != '$outer' ORDER BY comment_date_gmt DESC LIMIT $limit";
					$comments = $wpdb->get_results($sql);
					$output = '';
					foreach ($comments as $comment) {
						$output .= "\n<li>".get_avatar( $comment, 32,'',$comment->comment_author)." <p class=\"s_r\"><a href=\"" . get_permalink($comment->ID) ."#comment-" . $comment->comment_ID . "\" title=\"《" .$comment->post_title . "》上的评论\"><span class=\"s_name\">" .strip_tags($comment->comment_author).":</span><span class=\"s_desc\">". strip_tags($comment->com_excerpt)."</span></a></p></li>";}
					$output = convert_smilies($output);
					echo $output;
				};

//文章评论功能
				function h_comment($comment, $args, $depth) {$GLOBALS['comment'] = $comment;
				global $commentcount,$wpdb, $post;
				if(!$commentcount) { 
					$comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_post_ID = $post->ID AND comment_type = '' AND comment_approved = '1' AND !comment_parent");
					$cnt = count($comments);
					$page = get_query_var('cpage');
					$cpp=get_option('comments_per_page');
					if (ceil($cnt / $cpp) == 1 || ($page > 1 && $page  == ceil($cnt / $cpp))) {
						$commentcount = $cnt + 1;
					} else {$commentcount = $cpp * $page + 1;}
				}?>
				<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
					<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
						<?php $add_below = 'div-comment'; ?>
						<div class="comment-author vcard">
							<?php echo get_avatar( $comment, 40 , '',$comment->comment_author); ?>
							<div class="floor">
								<?php 
								if(!$parent_id = $comment->comment_parent){switch ($commentcount){
									case 2 :echo "沙发";--$commentcount;break;
									case 3 :echo "板凳";--$commentcount;break;
									case 4 :echo "地板";--$commentcount;break;
									default:printf('%1$s楼', --$commentcount);}}
									?>
								</div>
								<strong><?php comment_author_link() ?></strong>:<?php edit_comment_link('编辑','&nbsp;&nbsp;',''); ?></div>
								<?php if ( $comment->comment_approved == '0' ) : ?>
									<span style="color:#C00; font-style:inherit">您的评论正在等待审核中...</span>
									<br />			
								<?php endif; ?>
								<?php comment_text() ?>
								<div class="clear"></div><span class="datetime"><?php comment_date('Y-m-d') ?> <?php comment_time() ?> </span> <span class="reply"><?php comment_reply_link(array_merge( $args, array('reply_text' => '[回复]', 'add_below' =>$add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?></span>
							</div>
							<?php
						}
						function h_end_comment() {echo '</li>';};
	//自定义表情地址
						function custom_smilies_src($src, $img){return get_template_directory_uri().'/images/smilies/' . $img;}
						add_filter('smilies_src', 'custom_smilies_src', 10, 2);

//取消自己PING自己
						function no_self_ping(&$links) {
							$home = home_url();
							foreach ($links as $l => $link )
								if (0 === strpos($link, $home))
									unset($links[$l]);
							} 
							add_action( 'pre_ping', 'no_self_ping' );


//过滤代码的中文符号
							remove_filter('the_content', 'wptexturize');

//移除顶部多余信息
	function wpbeginner_remove_version() { 
		return ; 
	}
	add_filter('the_generator', 'wpbeginner_remove_version');//wordpress的版本号 
	remove_action('wp_head', 'index_rel_link');//当前文章的索引 
	remove_action('wp_head', 'feed_links_extra', 3);// 额外的feed,例如category, tag页 
	remove_action('wp_head', 'start_post_rel_link', 10, 0);// 开始篇 
	remove_action('wp_head', 'parent_post_rel_link', 10, 0);// 父篇 
	remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // 上、下篇. 
	remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );//rel=pre
	remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0 );//rel=shortlink 
	remove_action('wp_head', 'rel_canonical' ); 
	//wp_deregister_script('l10n'); 


//主题设置文件，勿删！！
	if (get_option('h_anti_spam') == 'Enable') include('functions/anti_spam.php');
	if (get_option('h_comment_mail_notify') == 'Enable') include('functions/comment_mail_notify.php');
	if (get_option('h_my_avatar') == 'Enable')  include('functions/my_avatar.php');
	if (get_option('h_tougao_notify') == 'Enable')  include('functions/tougao_notify.php');
	if (get_option('h_feednote') == 'Enable') include('functions/feednote.php');
	if (get_option('h_feed_cmhello') == 'Enable')  include('functions/feed_cmhello.php');
	if (get_option('h_shortcode') == 'Enable')  include('includes/shortcode.php');
	include("includes/widget.php");
	include("includes/theme_options.php");

//摘要截断
	function dm_strimwidth($str ,$start , $width ,$trimmarker ){$output = preg_replace('/^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$start.'}((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$width.'}).*/s','\1',$str); return $output.$trimmarker;};

	function lms_excerpt_length( $length ) {
		return 36; //150是摘要输出的字数
	}
	add_filter( 'excerpt_length', 'lms_excerpt_length' );

///////////请不要在【//滑门CMS布局】 和【//栏目列表结束】之间添加任何代码！//////////////

//滑门CMS布局
	function home_category($to="list") {
		global $wpdb;	
		$h_clms = get_option('h_cms_cat');
		$h_clms_arr = explode(",",$h_clms);

		$request = "SELECT $wpdb->terms.term_id, name FROM $wpdb->terms ";
		$request .= " LEFT JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id ";
		$request .= " WHERE $wpdb->term_taxonomy.taxonomy = 'category' ";
		$request .= " AND $wpdb->terms.term_id in ($h_clms) ";
	//echo $request ;
		$categorys = $wpdb->get_results($request);
		if ($to=="nav") {
			foreach ($h_clms_arr as $arr_item) {
			foreach ($categorys as $category) { //调用菜单
				if($arr_item == $category->term_id){
					$output = '<li>';
					$output .= '<span>'.$category->name.'</span>';
					$output .= '</li>'."\n";
					echo $output;
					break;
				}
			}
		}
	}else {
		foreach ($categorys as $category) { //调用文章
			?>
			<ul>
				<div class="column-img cl">
					<ul>
						<?php query_posts( array('showposts' => 2,'cat' => $category->term_id));?>
						<?php while (have_posts()) : the_post(); ?>
							<li><div class="thumb"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
								<?php if (get_option('h_timthumb') == 'Enable') { ?>
								<img src="<?php echo get_template_directory_uri(); ?>/timthumb.php?src=<?php echo post_thumbnail_src(); ?>&h=80&w=80&zc=1" alt="<?php the_title(); ?>" class="thumbnail"/>
								<?php } else { ?>
								<img src="<?php echo post_thumbnail_src(); ?>" alt="<?php the_title(); ?>" class="thumbnail" />
								<?php } ?>
							</a></div>
							<div class="list-info"><div class="list-name"><a href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></div><div class="list-summary"><?php the_excerpt(); ?></div></div></li>
						<?php endwhile; ?>	
					</ul>
				</div><!--column-img-->	
				<div class="column-list cl">
					<?php query_posts( array('showposts' => 6,'cat' => $category->term_id,'offset' => 2));?>
					<ul>
						<?php while (have_posts()) : the_post(); ?>
							<li><a  href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" target="_blank"><?php the_title(); ?></a><span><?php the_time('m-d'); ?></span></li>
						<?php endwhile; ?>
					</ul>
				</div><!--column-list-->
			</ul>
			<?php
		}
	}
}//栏目列表结束

///////////请不要在【//滑门CMS布局】和【//栏目列表结束】之间添加任何代码！//////////////

//增强搜索结果相关性
if(is_search()){ 
	add_filter('posts_orderby_request', 'h_search_orderby_filter');
}
function h_search_orderby_filter($orderby = ''){
	global $wpdb;
	$keyword = $wpdb->prepare($_REQUEST['s']);
	return "((CASE WHEN {$wpdb->posts}.post_title LIKE '%{$keyword}%' THEN 2 ELSE 0 END) + (CASE WHEN {$wpdb->posts}.post_content LIKE '%{$keyword}%' THEN 1 ELSE 0 END)) DESC, {$wpdb->posts}.post_modified DESC, {$wpdb->posts}.ID ASC";
}
//所有设置结束
?>