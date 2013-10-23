<?php
function isovnTinymce_addbuttons() {
   // Only do this stuff when the current user has permissions and we are in Rich Editor mode
   if ( ( current_user_can('edit_posts') || current_user_can('edit_pages') ) && get_user_option('rich_editing') ) {
     add_filter("mce_external_plugins", "add_isovnTinymce_tinymce_plugin");
     add_filter('mce_buttons', 'register_isovnTinymce_button');
   }
}
 
function register_isovnTinymce_button($buttons) {
	
   array_push($buttons, "|", "isovnTinymcebutton");
   array_push($buttons, "|", "dfw");
   //var_dump($buttons);
   return $buttons;
}
 
// Load the TinyMCE plugin : tinymce.js
function add_isovnTinymce_tinymce_plugin($plugin_array) {
   $plugin_array['isovnTinymce'] = WP_PLUGIN_URL.'/easy-content-types/includes/tinymce/js/tinymce.js';
   return $plugin_array;
}
 
// init process for button control
add_action('init', 'isovnTinymce_addbuttons');

function tinymce_support_manager(){
	if(isset($_POST['support_editor_action']) && $_POST['support_editor_action'] == 'Save Settings') {
		if(isset($_POST['supporteditor-object'])){
			foreach($_POST['supporteditor-object'] as $page) { $pages[] = $page; };
			$pages_final = implode(',', $pages);
			$status = update_option('support_editor_options',$pages_final);
			if($status){
				$uc_message = 'Save successfully!'; 
			} else {
				$uc_message = 'Can not save. Please try again!'; 
			}
		}
		$_POST['supporteditor-object'] = '';
	}
	
	$support_editor_options = get_option('support_editor_options');
	if(isset($support_editor_options)){
		$get_support_editor_options = $support_editor_options;
	}
 ?>
	<div class="wrap">
		<div class="icon32" id="icon-options-general"><br></div>
		<h2>Tinymce Support</h2>
		<p class="message_action" style="display:none; border: 1px solid green;  color: blue;  padding: 10px;"></p>
		<form action="#" method="post" name="form_add_new_account_type" id="form_add_new_account_type">
			<table class="form-table">
				<tr valign="top">
					<td width="100" scope="row"><label for="taxonomy-object">Object<span class="required">*</span></label></td>
					<td width="200">
					<select name="supporteditor-object[]" MULTIPLE id="ecpt-taxonomy-object" class="ecpt-text ecpt-multi-select"/>

						<?php 

						$custom_post_type_objs = get_post_types('', 'objects');
						$limit_args = array('attachment','revision','nav_menu_item');
						$pages = explode(',', $get_support_editor_options);
						foreach ($custom_post_type_objs as $custom_post_type_obj) {
							if(!in_array($custom_post_type_obj->name,$limit_args)){
								if($get_support_editor_options){
									echo '<option', in_array($custom_post_type_obj->name, $pages) ? ' selected="selected"' : '', '>', $custom_post_type_obj->name, '</option>';
								} else {
									echo '<option>' . $custom_post_type_obj->name . '</option>';
								}
							}
						}
			
						?>

					</select>

						<p class="ecpt-description">This is the post type that will use this tinymce support editor.</p><br/>
					</td>
				</tr>
				<tr valign="top">
					<td width="100" scope="row">&nbsp;</td>
					<td><input class="button-primary" type="submit" name="support_editor_action" value="Save Settings" /></td>
				</tr>
			</table>
		</form>
		<script type="text/javascript">
				jQuery(document).ready(function(){
						<?php if(isset($uc_message) && $uc_message !=''){ ?>
							jQuery('p.message_action').text('<?php echo $uc_message; ?>').show().fadeOut(6000);
						<?php $uc_message ='';	}  ?>

					});
					
			</script>

		
	</div>
<?php } 
	function show_isovnShowAds($atts){
		if(isset($atts['postid'])){
			$get_post = get_post($atts['postid']);
			return isset($get_post->post_content) ? '<div class="box_content_ads">'.$get_post->post_content.'</div><div style="clear:both;"></div>': '';
		}
	}
	add_shortcode( 'isovnShowAds', 'show_isovnShowAds' );
	
	//add_action( 'wp_enqueue_scripts', 'content_add_my_stylesheet' );
	function content_add_my_stylesheet(){
		global $ecpt_base_dir;
		 wp_register_style( 'content_add_my_stylesheet',$ecpt_base_dir.'includes/tinymce/css/style.css' );
	}
?>
