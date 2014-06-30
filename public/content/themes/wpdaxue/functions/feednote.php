<?php

//Feed输出版权
function feednote($content) {
	if(is_feed()) {
		$wzbt = get_the_title();
		$wzlj = get_permalink($post->ID);
		$content.= '<p>';
		$content.= '<span style="font-weight:bold;text-shadow:0 1px 0 #ddd;">声明:</span> 本文采用 <a rel="nofollow" href="http://creativecommons.org/licenses/by-nc-sa/3.0/" title="署名-非商业性使用-相同方式共享">BY-NC-SA</a> 协议进行授权 | <a href="'.home_url().'">'.get_bloginfo('name').'</a>';
		$content.= '<br />转载请注明转自《<a rel="bookmark" title="' . $wzbt . '" href="' . $wzlj . '">' . $wzbt . '</a>》';
		$content.= '</p>';
	}
	return $content;
}
add_filter ('the_content', 'feednote');

?>