<?php

function my_avatar($avatar) {
   $tmp = strpos($avatar, 'http');
   $g = substr($avatar, $tmp, strpos($avatar, "'", $tmp) - $tmp);
   $tmp = strpos($g, 'avatar/') + 7;
   $f = substr($g, $tmp, strpos($g, "?", $tmp) - $tmp);
     $w = home_url(); // $w = get_bloginfo('url');
     $e = preg_replace('/wordpress\//', '', ABSPATH) .'avatar/'. $f .'.jpg';
     $t = 604800; //设定7天, 单位:秒
     if ( empty($default) ) $default = $w. '/avatar/default.jpg';
     if ( !is_file($e) || (time() - filemtime($e)) > $t ) //当头像不存在或者文件超过7天才更新
     copy(htmlspecialchars_decode($g), $e);
     else
       $avatar = strtr($avatar, array($g => $w.'/avatar/'.$f.'.jpg'));
   if (filesize($e) < 500) copy($default, $e);
   return $avatar;
}
add_filter('get_avatar', 'my_avatar');

?>