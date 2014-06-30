<?php

//评论邮件提醒
function comment_mail_notify($comment_id) {
	$comment = get_comment($comment_id);
	$parent_id = $comment->comment_parent ? $comment->comment_parent : '';
	$spam_confirmed = $comment->comment_approved;
	if (($parent_id != '') && ($spam_confirmed != 'spam')) {
		$wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME'])); 
		$to = trim(get_comment($parent_id)->comment_author_email);
		$subject = '您在 [' . get_option("blogname") . '] 的留言有了回复';
		$message = '
		<div style="background-color:#eef2fa; border:1px solid #d8e3e8; color:#111; padding:0 15px; -moz-border-radius:5px; -webkit-border-radius:5px; -khtml-border-radius:5px;">
			<p>' . trim(get_comment($parent_id)->comment_author) . ', 您好!</p>
			<p>您曾在《' . get_the_title($comment->comment_post_ID) . '》的留言:<br />'
				. trim(get_comment($parent_id)->comment_content) . '</p>
				<p>' . trim($comment->comment_author) . ' 给您的回复:<br />'
					. trim($comment->comment_content) . '<br /></p>
					<p>您可以点击 <a href="' . htmlspecialchars(get_comment_link($parent_id)) . '">查看回复完整內容</a></p>
					<p>欢迎再度光临 <a href="' . home_url() . '">' . get_option('blogname') . '</a></p>
					<p>(由于服务器原因,我是不能收到您直接回复的邮件的,如果您还有问题,就到我的网站进行留言.)</p>
				</div>';
				$from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
				$headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
				wp_mail( $to, $subject, $message, $headers );
    //echo 'mail to ', $to, '<br/> ' , $subject, $message; // for testing
			}
		}
		add_action('comment_post', 'comment_mail_notify');

		?>