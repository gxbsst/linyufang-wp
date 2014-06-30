<?php

// 垃圾评论拦截
class anti_spam {
 function anti_spam() {
   if ( !is_user_logged_in() ) {
     add_action('template_redirect', array($this, 'w_tb'), 1);
     add_action('init', array($this, 'gate'), 1);
     add_action('preprocess_comment', array($this, 'sink'), 1);
   }
 }
 function w_tb() {
  if ( is_singular() ) {
    ob_start(create_function('$input','return preg_replace("#textarea(.*?)name=([\"\'])comment([\"\'])(.+)/textarea>#",
      "textarea$1name=$2w$3$4/textarea><textarea name=\"comment\" cols=\"100%\" rows=\"4\" style=\"display:none\"></textarea>",$input);') );
  }
}
function gate() {
  if ( !empty($_POST['w']) && empty($_POST['comment']) ) {
    $_POST['comment'] = $_POST['w'];
  } else {
    $request = $_SERVER['REQUEST_URI'];
    $referer = isset($_SERVER['HTTP_REFERER'])         ? $_SERVER['HTTP_REFERER']         : '隐瞒';
    $IP      = isset($_SERVER["HTTP_X_FORWARDED_FOR"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] . ' (透过代理)' : $_SERVER["REMOTE_ADDR"];
    $way     = isset($_POST['w'])                      ? '手动操作'                       : '未经评论表格';
    $spamcom = isset($_POST['comment'])                ? $_POST['comment']                : null;
    $_POST['spam_confirmed'] = "请求: ". $request. "\n来路: ". $referer. "\nIP: ". $IP. "\n方式: ". $way. "\n內容: ". $spamcom. "\n -- 记录成功 --";
  }
}
function sink( $comment ) {
  if ( !empty($_POST['spam_confirmed']) ) {
    if ( in_array( $comment['comment_type'], array('pingback', 'trackback') ) ) return $comment;
      //方法一: 直接挡掉, 將 die(); 前面两斜线刪除即可.
    die();
      //方法二: 标记为 spam, 留在资料库检查是否误判.
      //add_filter('pre_comment_approved', create_function('', 'return "spam";'));
      //$comment['comment_content'] = "[ 小墙判断这是 Spam! ]\n". $_POST['spam_confirmed'];
  }
  return $comment;
}
}
$anti_spam = new anti_spam();

?>