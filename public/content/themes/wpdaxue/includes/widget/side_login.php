<div class="t">
<?php
  global $user_ID, $user_identity, $user_email, $user_login;
  get_currentuserinfo();
  if (!$user_ID) {
?>
<div class="hc">
<span>用户登录</span>
</div>
<div class="h_widget cl">
<form id="loginform" action="<?php echo get_option('siteurl'); ?>/wp-login.php" method="post">
<p>
<label>用户名：<input class="login" type="text" name="log" id="log" value="" size="12" /></label>
</p>
<p>
<label>密　码：<input class="login" type="password" name="pwd" id="pwd" value="" size="12" /></label>
</p>
<p>
<input class="denglu" type="submit" name="submit" value="登录" /> <label>记住我 <input id="comment_mail_notify" type="checkbox" name="rememberme" value="forever" /></label>
</p>
<p>
<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>"/>
</p>
</form>
</div>
<?php } 
else { ?>
<div class="hc">
<span>用户管理</span>
</div>
<div class="h_widget cl">
<div id="h_avatar"><?php echo get_avatar($user_email, 56 ); ?></div>
<ul id="h_control">
	<li><a target="_blank" href="<?php echo home_url(); ?>/wp-admin/">控制面板</a></li>
	<li><a target="_blank" href="<?php echo home_url(); ?>/wp-admin/post-new.php">撰写文章</a></li>
	<li><a target="_blank" href="<?php echo home_url(); ?>/wp-admin/edit-comments.php">评论管理</a></li>
	<li><a href="<?php echo home_url(); ?>/wp-login.php?action=logout&amp;redirect_to=<?php echo urlencode($_SERVER['REQUEST_URI']) ?>">注销</a></li>
</ul>
</div>
<?php } ?>
</div>
<div class="cl"></div>