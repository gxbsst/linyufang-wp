<?php
///////////////////////////短代码///////////////////////////
//警示
function warningbox($atts, $content=null, $code="") {
	$return = '<div class="warning shortcodestyle">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}
add_shortcode('warning' , 'warningbox' );
//禁止
function nowaybox($atts, $content=null, $code="") {
	$return = '<div class="noway shortcodestyle">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}
add_shortcode('noway' , 'nowaybox' );
//购买
function buybox($atts, $content=null, $code="") {
	$return = '<div class="buy shortcodestyle">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}
add_shortcode('buy' , 'buybox' );
//项目版
function taskbox($atts, $content=null, $code="") {
	$return = '<div class="task shortcodestyle">';
	$return .= $content;
	$return .= '</div>';
	return $return;
}
add_shortcode('task' , 'taskbox' );
//音乐播放器
function doubanplayer($atts, $content=null){
	extract(shortcode_atts(array("auto"=>'0'),$atts));
	return '<embed src="'.get_bloginfo("template_url").'/shortcode/doubanplayer.swf?url='.$content.'&amp;autoplay='.$auto.'" type="application/x-shockwave-flash" wmode="transparent" allowscriptaccess="always" width="400" height="30">';
}
add_shortcode('music','doubanplayer');

//下载链接
function downlink($atts,$content=null){
	extract(shortcode_atts(array("href"=>'http://'),$atts));
	return '<div class="but_down"><a href="'.$href.'" target="_blank"><span>'.$content.'</span></a><div class="clear"></div></div>';
}
add_shortcode('Downlink','downlink');
//flv播放器
function flvlink($atts,$content=null){
	extract(shortcode_atts(array("auto"=>'0'),$atts));
	return'<embed src="'.get_bloginfo("template_url").'/shortcode/flvideo.swf?auto='.$auto.'&flv='.$content.'" menu="false" quality="high" wmode="transparent" bgcolor="#ffffff" width="560" height="315" name="flvideo" align="middle" allowScriptAccess="sameDomain" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer_cn" />';
}
add_shortcode('flv','flvlink');
//mp3专用播放器
function mp3link($atts, $content=null){
	extract(shortcode_atts(array("auto"=>'0',"replay"=>'0',),$atts));	
	return '<embed src="'.get_bloginfo("template_url").'/shortcode/dewplayer.swf?mp3='.$content.'&amp;autostart='.$auto.'&amp;autoreplay='.$replay.'" wmode="transparent" height="20" width="240" type="application/x-shockwave-flash" />';
}
add_shortcode('mp3','mp3link');	

/////////////////////////////////////////////////////////////

function h_Shortpage(){?>
<style type="text/css">
	.wrap{padding:10px; font-size:12px; line-height:24px;color:#383838;}
	.devetable td{vertical-align:top;text-align: left; }
	.top td{vertical-align: middle;text-align: left; }
	pre{white-space: pre;overflow: auto;padding:0px;line-height:19px;font-size:12px;color:#898989;}
	strong{ color:#666}
	.none{display:none;}
	fieldset{ border:1px solid #ddd;margin:5px 0 10px;padding:10px 10px 20px 10px;-moz-border-radius:5px;-khtml-border-radius:5px;-webkit-border-radius:5px;border-radius:5px;}
	fieldset:hover{border-color:#bbb;}
	fieldset legend{padding:0 5px;color:#777;font-size:14px;font-weight:700;cursor:pointer}
	fieldset .line{border-bottom:1px solid #e5e5e5;padding-bottom:15px;}
</style>
<script type="text/javascript">
	jQuery(document).ready(function($){  
		$(".toggle").click(function(){$(this).next().slideToggle('slow')});
	});
</script>
<div class="wrap">
	<div id="icon-themes" class="icon32"><br></div>
	<h2>Htwo主题短代码</h2>
	<div style="padding-left:20px;">
		<p>写文章时如果需要可以加入下列短代码（在“可视化”与“HTML”两种模式均可直接加入）</p>
		<fieldset>
			<legend class="toggle">各种短代码面板</legend>
			<div class="none">
				<table width="600" border="0" class="devetable">
					<tr><td width="120">灰色项目面板：</td><td width="464"><code>[task]文字内容[/task]</code></td></tr>
					<tr><td width="120">红色禁止面板：</td><td width="464"><code>[noway]文字内容[/noway]</code></td></tr>
					<tr><td width="120">黄色警告面板：</td><td width="464"><code>[warning]文字内容[/warning]</code></td></tr>
					<tr><td width="120">绿色购买面板：</td><td width="464"><code>[buy]文字内容[/buy]</code></td></tr>
				</table>
			</div>
		</fieldset>
		<fieldset>
			<legend class="toggle">下载样式</legend>
			<div class="none">
				<table width="800" border="0" class="devetable">
					<tr><td width="120"><strong>下载样式</strong></td><td width="584"><code>[Downlink href="http://www.xxx.com/xxx.zip"]download xxx.zip[/Downlink]</code></td></tr>
				</table>
			</div>
		</fieldset>

		<fieldset>
			<legend class="toggle">音乐播放器</legend>
			<div class="none">
				<table width="800" border="0" class="devetable">
					<tr><td width="120"><strong>通用音乐播放器</strong></td><td>&nbsp;</td></tr>
					<tr><td width="120">默认不自动播放：</td><td width="463"><code>[music]http://www.xxx.com/xxx.mp3[/music]</code></td></tr> 
					<tr><td width="120">自动播放:</td><td><code>[music auto=1]http://www.xxx.com/xxx.mp3[/music]</code></td></tr>

					<tr><td width="120"><strong>Mp3专用播放器</strong></td><td>&nbsp;</td></tr>
					<tr><td width="210">默认不循环不自动播放：</td><td><code>[mp3]http://www.xxx.com/xxx.mp3[/mp3]</code></td></tr>
					<tr><td width="120">自动播放：　</td><td><code>[mp3 auto="1"]http://www.xxx.com/xxx.mp3[/mp3]</code></td></tr>  
					<tr><td width="120">循环播放：	</td><td><code>[mp3 replay="1"]http://www.xxx.com/xxx.mp3[/mp3]</code></td></tr>
					<tr><td width="120">自动及循环播放：</td><td><code>[mp3 auto="1" replay="1"]http://www.xxx.com/xxx.mp3[/mp3]</code></td></tr>
				</table>
			</div>
		</fieldset> 

		<fieldset>
			<legend class="toggle">Flv专用播放器</legend>
			<div class="none">
				<table width="600" border="0" class="devetable">
					<tr><td width="120"><strong>Flv专用播放器</strong></td><td>&nbsp;</td></tr>
					<tr><td width="120">默认不自动播放：</td><td><code>[flv]http://www.xxx.com/xxx.flv[/flv]</code></td></tr>
					<tr><td width="120">自动播放：</td><td><code>[flv auto="1"]http://www.xxx.com/xxx.flv[/flv]</code></td></tr>
				</table> 
				<p><span style="color: #808000;">注意：如果要使用这个播放器，一定要添加flv格式的视频文件</span></p>
			</div>
		</fieldset>
	</div>
	
</div>
<?php }
function h_shortcode_page(){
	add_theme_page("Htwo短代码提示","Htwo短代码提示",'edit_themes','h_shortcode_page','h_Shortpage'); 
}
add_action('admin_menu','h_shortcode_page');

?>