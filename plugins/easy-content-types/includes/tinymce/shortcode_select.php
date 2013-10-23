<?php
$inc_path = "../../../../../";
require_once($inc_path."wp-admin/admin.php");
if(!current_user_can("edit_post")&&!current_user_can("edit_pages")){
    die("Hacker ??");
}
header('Content-Type: text/html; charset=' . get_bloginfo('charset'));
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
<title>Rich Editor Help</title>
<script type="text/javascript" src="<?php print get_option('siteurl');?>/wp-includes/js/tinymce/tiny_mce_popup.js?ver=3223"></script>
<link rel="stylesheet" href="<?php print get_option('siteurl');?>/wp-admin/css/colors-fresh.min.css">
<?php
wp_admin_css( 'global', true );
wp_admin_css( 'wp-admin', true );
do_action('admin_init');
do_action('admin_print_styles');
do_action('admin_print_scripts');
do_action('admin_head');

// Include amember styles and scripts; 

?>

</head>
<body>

<?php 
$support_editor_options = explode(',',get_option('support_editor_options'));
if(count($support_editor_options)>0) {
foreach($support_editor_options as $ojb_post_type){

$args = array(
	'post_type' => $ojb_post_type,
	'post_status' => 'publish',
	'orderby'	=>'DESC',
	'posts_per_page' => -1,
	'caller_get_posts'=> 1
);
	$adsPost = new WP_Query();
	$adsPost->query($args);
	if($adsPost->have_posts()){ ?>
	<table cellspacing="0" class="wp-list-table widefat fixed posts">
	<thead>
		<tr>
			<th style="" class="manage-column column-title sortable desc" scope="col"><a href="#title_table">Tên quảng cáo</a></th>
		</tr>
	</thead>

	<tfoot>
		<tr>
			<th style="" class="manage-column column-title sortable desc" scope="col"><a href="#title_table">Tên quảng cáo</a></th>
		</tr>
	</tfoot>

	<tbody id="the-list">
		<?php 
		while($adsPost->have_posts()) : $adsPost->the_post(); ?>
		<tr valign="top" class="post-<?php the_ID(); ?> status-publish" id="post-<?php the_ID(); ?>">
			<td class="post-title page-title column-title isovnShortcode-syntax">
				<span class="isovnShortcode expandable" data='[isovnShowAds title="<?php the_title(); ?>" postID="<?php the_ID(); ?>"]'><a title="Sửa “<?php the_title(); ?>”" target="_blank" href="<?php print get_option('siteurl');?>/wp-admin/post.php?post=<?php the_ID(); ?>&amp;action=edit" class="row-title"><?php the_title(); ?></a></span>
			</td>
		</tr>
		<?php endwhile; wp_reset_query(); ?>
	</tbody>
</table>

<?php }
}} else {
	echo 'Date is empty';
} ?>
<script>
jQuery(document).ready(function(){
    jQuery('.isovnShortcode').shortcodemenu();
});
;
(function($) {
$.fn.shortcodemenu = function(param) {
    return this.each(function(){
        var menu = {
            state : false,
            show : function(){
                if(jQuery(this).find('.isovnShortcode-menu').length) return;
                var s = jQuery(this).find('.isovnShortcode');
                var d = jQuery("<div class='isovnShortcode-menu'></div>");
                d.appendTo(this);
                var ins = jQuery("<a href='#' title='Insert Shortcode into Editor'>Chèn vào bài viết</a>");
                var copy = jQuery("<a href='#' title='Copy Shortcode to Clicpboard'>Sap chép</a>");
                var open = jQuery("<a href='#' title='Open Help'>Xem nội dung</a>");
                d.append(ins);
				//d.append(ins, "&nbsp;|&nbsp;", copy);
               /* if(s.hasClass("expandable")){
                    d.append("&nbsp;|&nbsp;", open);
                    open.click(menu.open);
                } */
                ins.click(menu.insert);
                //copy.click(menu.copy);
            },
            hide : function(){
                jQuery('.isovnShortcode-menu').remove();
            },
            open : function(e){
                e.preventDefault();
                jQuery('tr.isovnShortcode-help').hide();
                jQuery(this).parents('tr').next('tr').show();
                
            },
            copy : function(e){
                
            },
            insert : function(e){
                e.preventDefault();
                var win = window.dialogArguments || opener || parent || top;
                var s = jQuery(this).parent().prev('.isovnShortcode');
                menu.send_to_editor(s.attr('data'));
            },
            send_to_editor : function(text){
                var ed;
                var win = window.dialogArguments || opener || parent || top;
                var reg = /(.*)(\[\/\w+\])$/;
                var close_tag = text.match(reg);

				if ( typeof win.tinyMCE != 'undefined' && ( ed = win.tinyMCE.activeEditor ) && !ed.isHidden() ) {
				// restore caret position on IE
					if(ed.selection && (content = ed.selection.getContent())&&close_tag){
						ed.selection.setContent(close_tag[1]+content+close_tag[2]);
					}else{
						ed.execCommand('mceInsertContent', false, text);
					}

				} else if ( typeof edInsertContent == 'function' ) {
					edInsertContent(edCanvas, text);
				} else {
					jQuery( edCanvas ).val( jQuery( edCanvas ).val() + text );
				}
                
            }
        }
        jQuery(this).parent().hover(menu.show, menu.hide);
        jQuery(this).click(menu.open);
    });
}
})(jQuery);
</script>
</body>
</html>
