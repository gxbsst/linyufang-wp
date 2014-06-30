<title><?php if (is_home() ) {?><?php bloginfo('name');?> - <?php bloginfo('description');?><?php $paged = get_query_var('paged'); if($paged > 1) printf(' - 第 %s 页 ',$paged); ?><?php } else { ?><?php echo trim(wp_title('',0)); ?><?php $paged = get_query_var('paged'); if($paged > 1) printf(' - 第 %s 页 ',$paged); ?> | <?php bloginfo('name'); ?><?php } ?></title>
<?php 
$description ='';
$keywords = '';
if (is_home())
{
	$description = get_option('h_description');
	$keywords = get_option('h_keywords');
}
elseif (is_category())
{
	$description = strip_tags(trim(category_description()));
	$keywords = single_cat_title('', false);
}
elseif (is_tag())
{
	$description = tag_description();
	$keywords = single_tag_title('', false);
}
elseif (is_single())
{
	if ($post->post_excerpt) {$description = $post->post_excerpt;} 
	else {$description = dm_strimwidth(strip_tags($post->post_content),0,110,"");}
	$keywords = "";
	$tags = wp_get_post_tags($post->ID);
	foreach ($tags as $tag ) {$keywords = $keywords . $tag->name . ", ";}
}
elseif (is_page())
{
	$keywords = get_post_meta($post->ID, "keywords", true);
	$description = get_post_meta($post->ID, "description", true);
}
?>
<meta name="keywords" content="<?php echo $keywords ?>" />
<meta name="description" content="<?php echo $description?>" />