<?php

// Actions

add_action('admin_init', 'wptm_init');

add_filter('admin_enqueue_scripts','wptm_admin_enqueue_scripts');


/**
 * Function that initialise the plugin.
 * It loads the translation files.
 *
 * @return void.
 */
function wptm_init() {
    global $wp_version;

    if($wp_version >= '3.0') {
        add_action('created_term', 'wptm_save_meta_tags');
        add_action('edit_term', 'wptm_save_meta_tags');
        add_action('delete_term', 'wptm_delete_meta_tags');
        $wptm_taxonomies=get_taxonomies('','names');
        if (is_array($wptm_taxonomies) )
        {
            foreach ($wptm_taxonomies as $wptm_taxonomy ) {
                add_action($wptm_taxonomy . '_add_form_fields', 'wptm_add_meta_textinput');
                add_action($wptm_taxonomy . '_edit_form', 'wptm_add_meta_textinput');
            }
        }
    } else {
        add_action('create_category', 'wptm_save_meta_tags');
        add_action('edit_category', 'wptm_save_meta_tags');
        add_action('delete_category', 'wptm_delete_meta_tags');
        add_action('edit_category_form', 'wptm_add_meta_textinput');
    }
}

/**
 * Add the loading of needed javascripts for admin part.
 *
 */
function wptm_admin_enqueue_scripts() {
global $ecpt_base_dir;
    if(is_admin()) {
        // chargement des styles
        wp_register_style('thickbox-css', '/wp-includes/js/thickbox/thickbox.css');
        wp_enqueue_style('thickbox-css');
        // Chargement des javascripts
        wp_enqueue_script('thickbox');
        wp_enqueue_script('media-upload');
        wp_enqueue_script('quicktags');
       // wp_enqueue_script('wp-category-meta-scripts',$ecpt_base_dir.'includes/category_meta/js/wp-category-meta-scripts.js');
    }
}

/**
 * add_terms_meta() - adds metadata for terms
 *
 *
 * @param int $terms_id terms (category/tag...) ID
 * @param string $key The meta key to add
 * @param mixed $value The meta value to add
 * @param bool $unique whether to check for a value with the same key
 * @return bool
 */
function add_terms_meta($terms_id, $meta_key, $meta_value, $unique = false) {
    global $wpdb;
    global $wptm_table_name;

    // expected_slashed ($meta_key)
    $meta_key = stripslashes( $meta_key );
    $meta_value = stripslashes( $meta_value );

    if ( $unique && $wpdb->get_var( $wpdb->prepare( "SELECT meta_key FROM $wptm_table_name WHERE meta_key = %s AND terms_id = %d", $meta_key, $terms_id ) ) )
    return false;

    $meta_value = maybe_serialize($meta_value);

    $wpdb->insert( $wptm_table_name, compact( 'terms_id', 'meta_key', 'meta_value' ) );

    wp_cache_delete($terms_id, 'terms_meta');

    return true;
}

/**
 * delete_terms_meta() - delete terms metadata
 *
 *
 * @param int $terms_id terms (category/tag...) ID
 * @param string $key The meta key to delete
 * @param mixed $value
 * @return bool
 */
function delete_terms_meta($terms_id, $key, $value = '') {

    global $wpdb;
    global $wptm_table_name;

    // expected_slashed ($key, $value)
    $key = stripslashes( $key );
    $value = stripslashes( $value );

    if ( empty( $value ) )
    {
        $sql1 = $wpdb->prepare( "SELECT meta_id FROM $wptm_table_name WHERE terms_id = %d AND meta_key = %s", $terms_id, $key );
        $meta_id = $wpdb->get_var( $sql1 );
    } else {
        $sql2 = $wpdb->prepare( "SELECT meta_id FROM $wptm_table_name WHERE terms_id = %d AND meta_key = %s AND meta_value = %s", $terms_id, $key, $value );
        $meta_id = $wpdb->get_var( $sql2 );
    }

    if ( !$meta_id )
    return false;

    if ( empty( $value ) )
    $wpdb->query( $wpdb->prepare( "DELETE FROM $wptm_table_name WHERE terms_id = %d AND meta_key = %s", $terms_id, $key ) );
    else
    $wpdb->query( $wpdb->prepare( "DELETE FROM $wptm_table_name WHERE terms_id = %d AND meta_key = %s AND meta_value = %s", $terms_id, $key, $value ) );

    wp_cache_delete($terms_id, 'terms_meta');

    return true;
}

/**
 * get_terms_meta() - Get a terms meta field
 *
 *
 * @param int $terms_id terms (category/tag...) ID
 * @param string $key The meta key to retrieve
 * @param bool $single Whether to return a single value
 * @return mixed The meta value or meta value list
 */
function get_terms_meta($terms_id, $key, $single = false) {

    $terms_id = (int) $terms_id;

    $meta_cache = wp_cache_get($terms_id, 'terms_meta');

    if ( !$meta_cache ) {
        update_termsmeta_cache($terms_id);
        $meta_cache = wp_cache_get($terms_id, 'terms_meta');
    }

    if ( isset($meta_cache[$key]) ) {
        if ( $single ) {
            return maybe_unserialize( $meta_cache[$key][0] );
        } else {
            return array_map('maybe_unserialize', $meta_cache[$key]);
        }
    }

    return '';
}

/**
 * get_all_terms_meta() - Get all meta fields for a terms (category/tag...)
 *
 *
 * @param int $terms_id terms (category/tag...) ID
 * @return array The meta (key => value) list
 */
function get_all_terms_meta($terms_id) {

    $terms_id = (int) $terms_id;

    $meta_cache = wp_cache_get($terms_id, 'terms_meta');

    if ( !$meta_cache ) {
        update_termsmeta_cache($terms_id);
        $meta_cache = wp_cache_get($terms_id, 'terms_meta');
    }

    return maybe_unserialize( $meta_cache );

}

/**
 * update_terms_meta() - Update a terms meta field
 *
 *
 * @param int $terms_id terms (category/tag...) ID
 * @param string $key The meta key to update
 * @param mixed $value The meta value to update
 * @param mixed $prev_value previous value (for differentiating between meta fields with the same key and terms ID)
 * @return bool
 */
function update_terms_meta($terms_id, $meta_key, $meta_value, $prev_value = '') {

    global $wpdb;
    global $wptm_table_name;

    // expected_slashed ($meta_key)
    $meta_key = stripslashes( $meta_key );
    $meta_value = stripslashes( $meta_value );

    if ( ! $wpdb->get_var( $wpdb->prepare( "SELECT meta_key FROM $wptm_table_name WHERE meta_key = %s AND terms_id = %d", $meta_key, $terms_id ) ) ) {
        return add_terms_meta($terms_id, $meta_key, $meta_value);
    }

    $meta_value = maybe_serialize($meta_value);

    $data  = compact( 'meta_value' );
    $where = compact( 'meta_key', 'terms_id' );

    if ( !empty( $prev_value ) ) {
        $prev_value = maybe_serialize($prev_value);
        $where['meta_value'] = $prev_value;
    }

    $wpdb->update( $wptm_table_name, $data, $where );
    wp_cache_delete($terms_id, 'terms_meta');
    return true;
}

/**
 * update_termsmeta_cache()
 *
 *
 * @uses $wpdb
 *
 * @param array $category_ids
 * @return bool|array Returns false if there is nothing to update or an array of metadata
 */
function update_termsmeta_cache($terms_ids) {

    global $wpdb;
    global $wptm_table_name;

    if ( empty( $terms_ids ) )
    return false;

    if ( !is_array($terms_ids) ) {
        $terms_ids = preg_replace('|[^0-9,]|', '', $terms_ids);
        $terms_ids = explode(',', $terms_ids);
    }

    $terms_ids = array_map('intval', $terms_ids);

    $ids = array();
    foreach ( (array) $terms_ids as $id ) {
        if ( false === wp_cache_get($id, 'terms_meta') )
        $ids[] = $id;
    }

    if ( empty( $ids ) )
    return false;

    // Get terms-meta info
    $id_list = join(',', $ids);
    $cache = array();
    if ( $meta_list = $wpdb->get_results("SELECT terms_id, meta_key, meta_value FROM $wptm_table_name WHERE terms_id IN ($id_list) ORDER BY terms_id, meta_key", ARRAY_A) ) {
        foreach ( (array) $meta_list as $metarow) {
            $mpid = (int) $metarow['terms_id'];
            $mkey = $metarow['meta_key'];
            $mval = $metarow['meta_value'];

            // Force subkeys to be array type:
            if ( !isset($cache[$mpid]) || !is_array($cache[$mpid]) )
            $cache[$mpid] = array();
            if ( !isset($cache[$mpid][$mkey]) || !is_array($cache[$mpid][$mkey]) )
            $cache[$mpid][$mkey] = array();

            // Add a value to the current pid/key:
            $cache[$mpid][$mkey][] = $mval;
        }
    }

    foreach ( (array) $ids as $id ) {
        if ( ! isset($cache[$id]) )
        $cache[$id] = array();
    }

    foreach ( array_keys($cache) as $terms)
    wp_cache_set($terms, $cache[$terms], 'terms_meta');

    return $cache;
}

/**
 * Function that saves the meta from form.
 *
 * @param $id : terms (category) ID
 * @return void;
 */
function wptm_save_meta_tags($id) {

    $metaList = ecpt_get_categories();// get_option("wptm_configuration");

    // Check that the meta form is posted
    $wptm_edit = $_POST["wptm_edit"];
    if (isset($wptm_edit) && !empty($wptm_edit)) {
        foreach($metaList as $inputName => $inputType)
        {
            $inputValue = $_POST['wptm_'.$inputType->meta_name];
            delete_terms_meta($id, $inputType->meta_name);
            if (isset($inputValue) && !empty($inputValue)) {
                add_terms_meta($id, $inputType->meta_name, $inputValue);
            }
        }
    }
}

/**
 * Function that deletes the meta for a terms (category/..)
 *
 * @param $id : terms (category) ID
 * @return void
 */
function wptm_delete_meta_tags($id) {

    $metaList = ecpt_get_categories();//get_option("wptm_configuration");
    foreach($metaList as $inputName => $inputType)
    {
        delete_terms_meta($id, $inputType->meta_name);
    }
}
function check_is_exist_taxonomy($ecpt_get_categories){	global $taxonomy;	if($ecpt_get_categories){		foreach($ecpt_get_categories as $kye=>$value){			if($taxonomy == $value->meta_taxonomy){				return true;			}		}	}	return false;}
/**
 * Function that display the meta text input.
 *
 * @return void.
 */
function wptm_add_meta_textinput($tag){
	global $ecpt_base_dir;
    global $category, $wp_version, $taxonomy;
    $category_id = '';
    if($wp_version >= '3.0') {
        $category_id = $tag->term_id;
    } else {
        $category_id = $category;
    }
    $metaList =  ecpt_get_categories();	if(check_is_exist_taxonomy($metaList)){
		if (is_object($category_id)) {
			$category_id = $category_id->term_id;
		}
		if(!is_null($metaList) && count($metaList) > 0 && $metaList != ''){		?>
		<link rel="stylesheet" href="<?php  echo $ecpt_base_dir;?>includes/category_meta/wp-category-meta.css"	type="text/css" media="screen" />		
		<div id="categorymeta" class="postbox">
		<h3 class='hndle'><span><?php _e('Term meta', 'wp-category-meta');?></span></h3>
		<div class="inside"><input value="wptm_edit" type="hidden"	name="wptm_edit" /> 
		<?php
		foreach($metaList as $key=>$inputData){
			$inputName = $inputData->meta_name;
			$inputType = '';
			$inputType = $inputData->meta_type;
			 $inputTaxonomy = $inputData->meta_taxonomy;
			 if(empty($inputTaxonomy)) $inputTaxonomy = 'category';
									 
			// display the input field in 2 cases
			// WP version if < 3.0
			// or WP version > 3.0 and $inputTaxonomy == current taxonomy
			if($wp_version < '3.0' || $inputTaxonomy == $taxonomy) {
					$inputValue = htmlspecialchars(stripcslashes(get_terms_meta($category_id, $inputName, true)));
				if($inputType == 'text')
				{
					?>
					<div class="form-field <?php echo ($inputData->required_input == 1) ? ' form-required' : ''; ?>">
						<label for="tag-<?php echo $inputName;?>"><?php echo  $inputData->meta_label; ?></label>
						<input type="text" size="40"  value="<?php echo $inputValue ?>" id="tag-<?php echo $inputName;?>" name="<?php echo 'wptm_'.$inputName;?>"/>
						<?php if(isset($inputData->meta_desciption)) { ?><p style="padding-left:50px;"><?php _e($inputData->meta_desciption);?></p> <?php } ?>
					</div>
				<?php } elseif($inputType == 'textarea') { ?>
					<div class="form-field <?php echo ($inputData->required_input == 1) ? ' form-required' : ''; ?>">
						<label for="tag-<?php echo $inputName;?>"><?php echo  $inputData->meta_label; ?></label>
						<textarea cols="40" rows="3" id="tag-<?php echo $inputName;?>"  name="<?php echo 'wptm_'.$inputName;?>"><?php echo $inputValue ?></textarea>
						<?php if(isset($inputData->meta_desciption)) { ?><p style="padding-left:50px;"><?php _e($inputData->meta_desciption);?></p> <?php } ?>
					</div>
			<?php } elseif($inputType == 'image') {
				$current_image_url = get_terms_meta($category_id, $inputName, true);
				
				?>
				<div class="form-field">
						<label for="tag-<?php echo $inputName;?>"><?php echo  $inputData->meta_label; ?></label>
						<span id="<?php echo "wptm_".$inputName;?>_selected_image" class="wptm_selected_image"><?php echo '<img id="image_'.$inputName.'" width="50" height="50" src="'.$current_image_url.'" style="display:'.(($current_image_url != '')? "block;" : 'none;').'" />';?>
						</span>
						<input type="text" style="width: 50%;" size="30" value="<?php echo $current_image_url;?>" id="ecpt_image_<?php echo $inputName;?>" name="<?php echo "wptm_".$inputName;?>" class="ecpt_upload_field "/>
						<input type="button" style="width: 100px;" data="ecpt_image_<?php echo $inputName;?>" value="Upload Image" class="upload_image_button button-primary"/>
						<?php if(isset($inputData->meta_desciption)) { ?><p style="padding-left:0px;"><?php _e($inputData->meta_desciption);?></p> <?php } ?>
				</div>
			<?php } elseif($inputType == 'checkbox') { ?>
				<div class="form-field">
						<label style="float:left;" for="tag-<?php echo $inputName;?>"><?php echo  $inputData->meta_label; ?></label>
						<input style="float:left; width:30px;" value="checked" type="checkbox" <?php echo $inputValue ? 'checked="checked" ' : ''; ?>     name="<?php echo 'wptm_'.$inputName;?>" />
						<?php if(isset($inputData->meta_desciption)) { ?><p style="padding-left:40px;"><?php _e($inputData->meta_desciption);?></p> <?php } ?>
				</div>
			<?php } // end elseif				else if($inputType == 'textarea') { ?>								<div class="form-field">				<textarea id="<?php echo 'wptm_'.$inputName;?>" name="<?php echo 'wptm_'.$inputName;?>" rows="100" cols="10" tabindex="2"					style="width: 1px; height: 1px; padding: 0px; border: none display :   none;"></textarea>				</div>				<script type="text/javascript">edCanvas = document.getElementById('<?php echo 'wptm_'.$inputName;?>');</script>			<?php	}
			}//end foreach
		}//end IF
		  ?>
		</div>			<script>				jQuery(function($){					var txtBox_id = '';					var image_id = '';					$('.upload_image_button').click(function() {						txtBox_id = '#'+$(this).attr('data');						image_id = '#image_'+$(this).attr('data').replace('ecpt_image_', '');						formfield = $(txtBox_id);						tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');						return false;					});					// send the selected image to the iamge url field					window.send_to_editor = function(html) {						imgurl = $('img',html).prop('src');						$(txtBox_id).val(imgurl);						$(image_id).attr('src', imgurl).fadeIn();						tb_remove();					}				});			</script>		</div>
		<?php		}	}
}
?>