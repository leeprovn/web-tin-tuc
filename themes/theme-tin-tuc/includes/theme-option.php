<?php
add_action('admin_menu', 'isovn_register_theme_option_submenu_page');

/**
* Function name:	isovn_register_theme_option_submenu_page
* Description : 	Register menu theme option page
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* July 14, 2013		LeePro			Register menu theme option page
*/
function isovn_register_theme_option_submenu_page() {
	add_submenu_page(
		'themes.php', 
		get_bloginfo('name').' Theme Options',
		get_bloginfo('name').' Theme Options',
		'edit_themes',
		'orphan-theme-option', 
		'isovn_theme_option_callback'
	); 
}
/**
* Function name:	isovn_get_option_theme
* Description : 	Get options theme
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* July 1, 2013		LeePro			Get options theme
*/
 function isovn_get_option_theme(){
	$options = get_option("orphan_theme_options");
	if($options){
		$options = unserialize(base64_decode($options));
	}
	return $options ;
 }
/**
* Function name:	isovn_theme_option_callback
* Description : 	Option theme form
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* July 1, 2013		LeePro			Setting form
*/
function isovn_theme_option_callback(){
	global $uc_message;
	if (!current_user_can( 'manage_options' ) ) {
		wp_die ( __( 'You do not have sufficient permissions to access this page' ) );
	}
	if(isset($_POST['save_theme_setting']) && $_POST['save_theme_setting'] == 'Save Settings'){
		unset($_POST['save_theme_setting']);
		$data_post = base64_encode(serialize($_POST));
		if(!update_option("orphan_theme_options",$data_post)) {
			$uc_message = __("Updated Failed",'theme_option');
		}else{
			$uc_message = __("Updated",'theme_option');
		};
		$_POST = null;
	} else {
		$uc_message= '';
	}
	$options = get_option("orphan_theme_options");
	if($options){
		$options = unserialize(base64_decode($options));
	}
	
?>
	<div class="wrap">
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
		<div class="icon32" id="icon-options-general"><br></div>
		<h2><?php echo get_bloginfo('name').' Theme Options'; ?></h2>
		
		<br/>
		
			<div id="tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
					<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
						<li class="ui-state-default ui-corner-top ui-tabs-selected ui-state-active"><a href="#orphan-option-info-tab">Settings</a></li>												
						<li class="ui-state-default ui-corner-top"><a href="#orphan-document-info-tab">Documents</a></li>												
						<li class="ui-state-default ui-corner-top"><a href="#orphan-system-info-tab">System Info</a></li>			
					</ul>
			
					<!-- Start show_post_option -->
					<div class="tab ui-tabs-panel ui-widget-content ui-corner-bottom" id="orphan-option-info-tab">
						<form class="setting-theme_option" action="#" method="post" name="setting-theme_option" id="setting-theme_option">
							<h2>Tùy chỉnh thông tin</h2>
							<table width="100%">
								<tr>
									<td width="25%" valign="top">
										<p class="message_action" style="display:none; border: 1px solid green;  color: blue;  padding: 10px;"></p>
										Tùy chỉnh hiển thị thông tin trên wedsite &nbsp;<?php bloginfo('name');?>.
										<hr/><h4> Tùy chỉnh thôn tin</h4>
										<table class="form-table">
											<tbody>
												<tr valign="top">
													<th scope="row">
														<?php _e('Giỏ hàng', 'theme_option'); ?>
														<br/>
														<small style="font-weight:normal;"><?php _e('Chọn trang', 'theme_option'); ?></small>
														<?php $args = array(
																	'depth'            => 0,
																	'child_of'         => 0,
																	'selected'         => $options['page_order'],
																	'echo'             => 1,
																	'name'             => 'page_order');
														wp_dropdown_pages($args) ?>
													</th>
												</tr>
												<tr valign="top">
													<th scope="row">
														<?php _e('Số lượng bài viết khi load ajax trên trang chủ', 'theme_option'); ?>
														<br/>
														<select name="show_post_ajax_index" id="show_post_ajax_index">
														<?php for ( $i=1 ; $i<=30 ; $i++ ) : ?>
																<option value="<?php echo $i ?>" <?php if($i==trim($options['show_post_ajax_index'])){?> selected="selected" <?php }?>><?php echo $i ?></option>
														<?php endfor; ?>
													</select>
													</th>
												</tr>
												<tr valign="top">
													<th scope="row">
														<?php _e('Số từ tóm tắt', 'theme_option'); ?>
														<input name="custom_excerpt_length" value="<?php echo $options['custom_excerpt_length']; ?>" id="custom_excerpt_length"/>
													</select>
													</th>
												</tr>
											</tbody>
										</table>
									
								</td>
									<td class="td_option_travel" width="75%" valign="top" vertical-align="top">
										<img class="set_img_option_travel" src="<?php bloginfo('template_directory')?>/screenshot.png" width="100%" height="auto"/>
										
									</td>
								</tr>
							</table>
							
							<hr/><h4> Thông tin liên hệ</h4>	
							<table class="form-table">
								<tbody>
									<tr valign="top">
										<th  scope="row"><?php _e('Yahoo', 'theme_option'); ?></th>
										<td>
											<input size="50"  name="nick_yahoo" id="nick_yahoo" value="<?php echo($options['nick_yahoo']); ?>" />
										</td>
									</tr>
									<tr valign="top">
										<th scope="row"><?php _e('Facbooks App ID', 'theme_option'); ?></th>
										<td>
											<input size="50"  name="fb_app_id" id="fb_app_id" value="<?php echo($options['fb_app_id']); ?>" />
										</td>
									</tr>
									
									<tr valign="top">
										<th scope="row"><?php _e('Google analytics', 'theme_option'); ?></th>
										<td>
											<input size="50"  name="google_analytics" id="google_analytics" value="<?php echo($options['google_analytics']); ?>" />
										</td>
									</tr>
									<tr valign="top">
										<th scope="row"><?php _e('Skype', 'theme_option'); ?></th>
										<td>
											<input size="50"  name="nick_skype" id="nick_skype" value="<?php echo($options['nick_skype']); ?>" />
										</td>
									</tr>
									<tr valign="top">
										<th scope="row"><?php _e('Email', 'theme_option'); ?></th>
										<td>
											<input size="50"  name="info_email" id="info_email" value="<?php echo($options['info_email']); ?>" />
										</td>
									</tr>
									<tr valign="top">
										<th scope="row"><?php _e('Điện thoại', 'theme_option'); ?></th>
										<td>
											<input size="50" name="info_phone" id="info_phone" value="<?php echo($options['info_phone']); ?>" />
										</td>
									</tr>
									<tr valign="top">
										<th scope="row"><?php _e('Fax', 'theme_option'); ?></th>
										<td>
											<input size="50" name="info_fax" id="info_fax" value="<?php echo($options['info_fax']); ?>" />
										</td>
									</tr>
									<tr valign="top">
										<th scope="row"><?php _e('Địa chỉ', 'theme_option'); ?></th>
										<td>
											<input size="100%" name="info_address" id="info_address" value="<?php echo($options['info_address']); ?>" />
										</td>
									</tr>
								</tbody>
							</table>
							
							<hr/><h4>Bản đồ địa chỉ liên hệ</h4>					
							<table class="form-table">						
								<tbody>							
									<tr valign="top">								
										<th scope="row">									
											<?php _e('Thông tin', 'theme_option'); ?>									<br/>	
											<small style="font-weight:normal;"><?php _e('Thông tin được hiển thị trên trang liên hệ', 'theme_option'); ?></small>
										</th>								
										<td>									
											<label>										
											<textarea name="show_google_map" cols="50" rows="2" id="show_google_map" class="code" style="width:98%;font-size:12px;">
												<?php echo($options['show_google_map']); ?></textarea>									</label>									
												Để thay đổi thông tin website có thể truy cập vào địa chỉ sau: <a target="_blank" href="http://maps.google.com/maps/empw?url=http:%2F%2Fmaps.google.com%2Fmaps%3Ff%3Dq%26source%3Ds_q%26hl%3Den%26geocode%3D%26q%3DAustralia%2Bjervis%2Bbay%26sll%3D-35.065973">Bản đồ</a>
											<br/>									
											Sau khi truy cập tìm địa chỉ để hiển thị thông tin của bạn trong bản dồ. Sau đó copy code trong textbox và dán vào ô trên.								
										</td>
									</tr>						
								</tbody>					
							</table>

							<hr/><h4>Thông tin bản quyền website</h4>

							<table class="form-table">
								<tbody>
									<tr valign="top">
										<th scope="row">
											<?php _e('Thông tin', 'theme_option'); ?>
											<br/>
											<small style="font-weight:normal;"><?php _e('Thông tin được hiển thị dưới chân trang website', 'theme_option'); ?></small>
										</th>
										<td>
											<label>
												<textarea name="show_footer_address" cols="50" rows="2" id="show_footer_address" class="code" style="width:98%;font-size:12px;"><?php echo($options['show_footer_address']); ?></textarea>
											</label>
										</td>
									</tr>
								</tbody>
							</table>
							<p class="submit">
							<input class="button-primary" type="submit" name="save_theme_setting" value="<?php _e('Save Settings', 'theme_option'); ?>" />
							</p>
						</form>
					</div>
					<!-- End show_post_option -->
					<div class="tab ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide" id="orphan-document-info-tab">
						<h2>Documents</h2>
						<div class="orphan-document-info">
							<p>Để hiển thị thông tin tùy chọn trên theme. Bạn có thể gọi function sau: isovn_get_option_theme();</p>
							
							<p>Dữ liệu trả về của function: isovn_get_option_theme():</p>
							
							<table class="form-table" border="1">
							<thead>
								<tr valign="top">
									<th scope="row">$option['key']</th>
									<td>
										$option['value']
									</td>
								</tr>
							</thead>
							<tbody>
								<?php 
								$get_options = isovn_get_option_theme();
								if($get_options){
									foreach($get_options as $options_key=>$options_value){ ?>
									<tr valign="top">
										<th scope="row">
											<?php _e($options_key, 'theme_option'); ?>
										</th>
										<td>
											<?php _e($options_value, 'theme_option'); ?>
										</td>
									</tr>
									<?php }
									} else {
										echo '<tr valign="top"><td colspan="2">No config.</td></tr>';
									} ?>
							</tbody>
						</table>
						</div>
					</div>
					<!-- Start System Info Panel -->
					<div class="tab ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide" id="orphan-system-info-tab">
						<h2>System Info</h2>
						<h3 class="border-top">WordPress Version :  <span><?php global $wp_version; echo $wp_version; ?></span></h3>			
							<h3 class="border-top">PHP Version : <span><?php echo PHP_VERSION; ?></span></h3>
							<?php if(function_exists('mysql_get_server_info')){ ?>
							<h3 class="border-top">MySQL Version : <span><?php echo mysql_get_server_info(); ?></span></h3>
							<?php } ?>
							<h3 class="border-top">Web Server Info : <span><?php echo $_SERVER['SERVER_SOFTWARE']; ?></span></h3>
							<h3 class="border-top">Browser Info : <span><?php echo $_SERVER['HTTP_USER_AGENT']; ?></span></h3>
							<h3 class="border-top">PHP GD (Image Library) Support : <span><?php echo (function_exists('gd_info')) ? 'Yes' : 'No'; ?></span></h3>
					</div>
					<!-- End System Info Panel -->
			</div>
		<style>
			form fieldset{ border:1px solid #d5d5d5; padding 5px;}
			form legend{ border:1px solid #d5d5d5; padding:5px 10px; margin-left: 5px;}
			#tabs a {
				outline: medium none;
				text-decoration: none;
			}
		</style>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				<?php if(isset($uc_message) && $uc_message !=''){ ?>
					jQuery('p.message_action').text('<?php echo $uc_message; ?>').show().fadeOut(6000);
				<?php $uc_message ='';	}  ?>
				
				$( "#tabs" ).tabs();
			});
			
		</script>
	</div>
<?php
}

function isovn_show_num_post($begin = 3,$end=20, $select, $select_name){
	
	$html = '<select id="select_'.$select_name.'" name="'.$select_name.'">';
	for($begin; $begin<= $end; $begin++){
		$selected = '';
		if( $select == $begin){
			$selected = 'selected="selected"';
		}
		$html .='<option '.$selected.' value="'.$begin.'">'.$begin.'</option>';
	}
	$html .= '</select>';
	return $html;
}
?>