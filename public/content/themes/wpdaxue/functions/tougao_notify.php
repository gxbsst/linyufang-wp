<?php

//通知投稿者
function tougao_notify($mypost) {
    $email = get_post_meta($mypost->ID, "tougao_authoremail", true);

    if( !empty($email) ) {
        // 以下是邮件标题
        $subject = '您在 '. get_option('blogname') .' 的投稿已发布';
        // 以下是邮件内容
        $message = '
        <p><strong>'. get_option('blogname') .'</strong> 提醒您: 您投递的文章 <strong>' . $mypost->post_title . '</strong> 已发布</p>
        
        <p>您可以点击以下链接查看具体内容:<br />
            <a href="' . get_permalink( $mypost->ID ) . '" target="_blank">点此查看完整內容</a></p>
            <p>感谢您对 <a href="'. home_url() .'" target="_blank">'. get_option('blogname') .'</a> 的关注和支持</p>
            <p><strong>该信件由系统自动发出, 请勿回复, 谢谢.</strong></p>';
            
            add_filter('wp_mail_content_type',create_function('', 'return "text/html";'));
            @wp_mail( $email, $subject, $message );
        }
    }

    add_action('draft_to_publish', 'tougao_notify', 6);

    ?>