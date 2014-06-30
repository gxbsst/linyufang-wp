<?php
/**
 * Template Name: tougao
 * 作者：露兜
 * 博客：http://www.ludou.org/
 */
if( isset($_POST['tougao_form']) && $_POST['tougao_form'] == 'send')
{
    global $wpdb;
    $last_post = $wpdb->get_var("SELECT post_date FROM $wpdb->posts WHERE post_type = 'post' ORDER BY post_date DESC LIMIT 1");
    
    // 博客当前最新文章发布时间与要投稿的文章至少间隔120秒。
    // 可自行修改时间间隔，修改下面代码中的120即可
    // 相比Cookie来验证两次投稿的时间差，读数据库的方式更加安全
    if ( current_time('timestamp') - strtotime($last_post) < 120 )
    {
        wp_die('您投稿也太勤快了吧，先歇会儿！');
    }
    
    // 表单变量初始化
    $name = isset( $_POST['tougao_authorname'] ) ? trim(htmlspecialchars($_POST['tougao_authorname'], ENT_QUOTES)) : '';
    $email =  isset( $_POST['tougao_authoremail'] ) ? trim(htmlspecialchars($_POST['tougao_authoremail'], ENT_QUOTES)) : '';
    $blog =  isset( $_POST['tougao_authorblog'] ) ? trim(htmlspecialchars($_POST['tougao_authorblog'], ENT_QUOTES)) : '';
    $title =  isset( $_POST['tougao_title'] ) ? trim(htmlspecialchars($_POST['tougao_title'], ENT_QUOTES)) : '';
    $category =  isset( $_POST['cat'] ) ? (int)$_POST['cat'] : 0;
    $tags = isset( $_POST['tougao_tags'] ) ? $_POST['tougao_tags'] : '';
    $content = isset( $_POST['tougao_content'] ) ? $_POST['tougao_content'] : '';
    
    // 表单项数据验证
    if ( empty($name) || mb_strlen($name) > 20 )
    {
        wp_die('昵称必须填写，且长度不得超过20字');
    }
    
    if ( empty($email) || strlen($email) > 60 || !preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email))
    {
        wp_die('Email必须填写，且长度不得超过60字，必须符合Email格式');
    }
    
    if ( empty($title) || mb_strlen($title) > 100 )
    {
        wp_die('标题必须填写，且长度不得超过100字');
    }
    
    if ( empty($content) || mb_strlen($content) > 3000 || mb_strlen($content) < 100)
    {
        wp_die('内容必须填写，且长度不得超过3000字，不得少于100字');
    }
    
    $post_content = '昵称: '.$name.'<br />Email: '.$email.'<br />blog: '.$blog.'<br />内容:<br />'.$content;
    
    $tougao = array(
        'post_title' => $title,
        'post_content' => $post_content,
        'tags_input' => $tags, 
        'post_category' => array($category)
        );
    
    
    // 将文章插入数据库
    $status = wp_insert_post( $tougao );
	//设置博主接收邮件的邮箱
    $admin_email = get_option('h_admin_email');
    if ($status != 0) 
    { 
        // 投稿成功给博主发送邮件
        // somebody#example.com替换博主邮箱
        // My subject替换为邮件标题，content替换为邮件内容
        wp_mail($admin_email,"有人给你的博客投稿啦！赶紧审核吧！！","有人给你的博客投稿啦！赶紧审核吧！！");
        
        wp_die('投稿成功！您的文章将在审核通过后发布！','投稿成功！');
    }
    else
    {
        wp_die('投稿失败！');
    }
}
?>
<?php get_header(); ?>
<div id="wrap-left">
    <div class="newInfor">
        <div class="hB">
            <a href="<?php echo get_option('Home'); ?>" title="首页">首页</a><em> &raquo; </em>
            <?php
            if( is_single() ){
                $categorys = get_the_category();
                $category = $categorys[0];
                echo( get_category_parents($category->term_id,true,'<em> &raquo; </em>') );echo '正文';
            } elseif ( is_page() ){
                the_title();
            } elseif ( is_category() ){
                single_cat_title();
            } elseif ( is_tag() ){
                single_tag_title();
            } elseif ( is_day() ){
                the_time('Y年Fj日');
            } elseif ( is_month() ){
                the_time('Y年F');
            } elseif ( is_year() ){
                the_time('Y年');
            } elseif ( is_search() ){
                echo htmlspecialchars($s).' 的搜索结果';
            }
            ?>
        </div>
        <div class="pcon">
           <div id="content" class="cl">
              <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
                  <div class="post-title">
                     <h1><?php the_title(); ?></h1>
                 </div>
                 <div id="tougao-page">
                   <?php the_content(); ?>
                   
                   <!-- 关于表单样式，请自行调整-->
                   <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
                    <div class="tougao-d">
                        <input type="text" size="40" value="" id="tougao_authorname" name="tougao_authorname" />
                        <label for="tougao_authorname">昵称（必填）</label>
                    </div>
                    
                    <div class="tougao-d">
                        <input type="text" size="40" value="" id="tougao_authoremail" name="tougao_authoremail" />
                        <label for="tougao_authoremail">邮箱（必填）</label>
                    </div>
                    
                    <div class="tougao-d">
                        <input type="text" size="40" value="" id="tougao_authorblog" name="tougao_authorblog" />
                        <label for="tougao_authorblog">您的博客/文章来源</label>
                    </div>
                    
                    <div class="tougao-d">
                        <input type="text" size="40" value="" id="tougao_title" name="tougao_title" />
                        <label for="tougao_title">文章标题（必填）</label>
                    </div>

                    <div class="tougao-d">
                       <input id="tags" type="text" size="40" value="" name="tougao_tags" /><label for="tougao_tags"> 文章标签（多个标签请用英文逗号 , 分开）</label>
                   </div>
                   
                   <div class="tougao-d">
                    <?php wp_dropdown_categories('show_option_none=请选择文章分类&id=tougao-cat&show_count=1&hierarchical=1&hide_empty=0'); ?>
                    <label for="tougaocategorg">请选择文章分类（必选）</label>
                </div>
                
                <div class="tougao-d">
                    <textarea rows="15" cols="55" id="tougao_content" name="tougao_content" ></textarea>
                </div>
                
                <br clear="all">
                <p>
                    <input type="hidden" value="send" name="tougao_form" />
                    <input id="submit" type="submit" value="提交" />
                    <input id="reset" type="reset" value="重填" />
                </p>
            </form>
        </div>
    </div><!--content-->
</div>
</div>
<?php endwhile; ?>

</div><!--wrap-left-->

<div id="wrap-right">
    <?php get_sidebar(); ?>
</div>
<div class="cl"></div>
<?php get_footer(); ?>