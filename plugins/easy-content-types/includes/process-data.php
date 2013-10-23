<?php

global $ecpt_db_name;
global $ecpt_db_tax_name;
global $ecpt_db_meta_name;
global $ecpt_db_meta_fields_name;
global $ecpt_db_categorymeta_name;
$post = (!empty($_POST)) ? true : false;
if($post) // if data is being sent
{
	if(isset($_POST['post-type-name'])) 
	{	
		if($_POST['label-single'] != '') { $single = $_POST['label-single']; } else { $single = $_POST['post-type-name']; }
		if($_POST['label-plural'] != '') { $plural = $_POST['label-plural']; } else { $plural = $_POST['post-type-name']; }

		// check for checked options
		if($_POST['options-hierarchial']) 		{ $hierarchical = 1; }
		if($_POST['options-post-formats']) 		{ $post_formats = 1; }
		if($_POST['options-archives']) 			{ $archives = 1; }
		if($_POST['options-nav']) 				{ $nav = 1; }
		
		// check for supports options
		if($_POST['options-title']) 		{ $title = 1; }
		if($_POST['options-editor']) 		{ $editor = 1; }
		if($_POST['options-author']) 		{ $author = 1; }
		if($_POST['options-thumbnail']) 	{ $thumbnail = 1; }
		if($_POST['options-excerpt']) 		{ $excerpt = 1; }
		if($_POST['options-custom-fields']) { $fields = 1; }
		if($_POST['options-comments']) 		{ $comments = 1; }
		if($_POST['options-revisions']) 	{ $revisions = 1; }
		
		// check for advanced options
		if(!$_POST['advanced-position']) 	{ $position = 0; } else { $position = $_POST['advanced-position']; }
					$name = process_string_post($_POST['post-type-name'],'-');
		$add = $wpdb->query("INSERT INTO " . $ecpt_db_name . " SET 
			`name`='" .$name. "',			
			`singular_name`='"		. 	$single . "',	
			`plural_name`='"			. 	$plural . "',	
			`hierarchical`='"			. 	$hierarchical . "',	
			`post_formats`='"			. 	$post_formats . "',	
			`has_archive`='"			. 	$archives . "',		
			`title`='"				. 	$title . "',
			`editor`='"				. 	$editor . "',
			`author`='"				. 	$author . "',
			`thumbnail`='"			. 	$thumbnail . "',
			`excerpt`='"				. 	$excerpt . "',
			`fields`='"				. 	$fields . "',
			`comments`='"				. 	$comments . "',
			`revisions`='"			. 	$revisions . "',
			`menu_icon`='"			. 	$_POST['options-icon'] . "',
			`menu_position`='"		. 	$position . "'

		;");	
		
		$url = get_bloginfo('wpurl') . '/wp-admin/admin.php?page=easy-content-types/easy-content-types.php?posttypes&post-type-added=1';
		header ("Location: $url");
	}
	
	if(isset($_POST['taxonomy-name'])) 
	{	
		if($_POST['label-single'] != '') { $single = $_POST['label-single']; } else { $single = $_POST['taxonomy-name']; }
		if($_POST['label-plural'] != '') { $plural = $_POST['label-plural']; } else { $plural = $_POST['taxonomy-name']; }

		// check for checked options
		if($_POST['options-hierarchial']) 	{ $hierarchical = 1; }
		if($_POST['options-tagcloud']) { $show_tagcloud = 1; }
		if($_POST['options-nav']) 			{ $nav = 1; }
		
		$pages = array();
		foreach($_POST['taxonomy-object'] as $page) { $pages[] = $page; };
		$pages_final = implode(',', $pages);
		$type = $_POST['taxonomy-type'] == '' ? '' : 1;		$name = process_string_post($_POST['taxonomy-name'],'-');
		$add = $wpdb->query("INSERT INTO " . $ecpt_db_tax_name . " SET 
			`name`='" 				. $name . "',
			`singular_name`='"		. 	$single . "',
			`plural_name`='"			. 	$plural . "',	
			`hierarchical`='"			. 	$hierarchical . "',
			`show_tagcloud`='"		. 	$show_tagcloud . "',
			`show_in_nav_menus`='"	. 	$nav . "',
			`type`='".$type."',
			`page`='"					. 	$pages_final . "'

		;");	
		
		$url = get_bloginfo('wpurl') . '/wp-admin/admin.php?page=easy-content-types/easy-content-types.php?taxonomies&taxonomy-added=1';
		header ("Location: $url");
	}
	
	// add custom meta boxes
	if(isset($_POST['metabox-name'])) 
	{				$name = process_string_post($_POST['metabox-name'],'-');
		$add = $wpdb->query("INSERT INTO " . $ecpt_db_meta_name . " SET 
			`name`='" 	.  $name . "',
			`nicename`='" .   $_POST['metabox-name'] . "',
			`page`='"		. 	$_POST['metabox-page'] . "',
			`context`='"	. 	$_POST['metabox-context'] . "',
			`priority`='"	. 	$_POST['metabox-priority'] . "'

		;");	
		
		$url = get_bloginfo('wpurl') . '/wp-admin/admin.php?page=easy-content-types/easy-content-types.php?metaboxes&metabox-added=1';
		header ("Location: $url");
	}
	// add fields to meta boxes
	if(isset($_POST['field-name'])) 
	{			$meta_name = process_string_post($_POST['field-name']);
		if(check_exist_metapost($meta_name,$_POST['field-parent'],null) == false){
			$list_id = $_POST['field-order'] + 1;
			
			if($_POST['rich-editor']) 	{ $rich_editor = 1; }
			
			$add = $wpdb->query("INSERT INTO " . $ecpt_db_meta_fields_name . " SET 
				`name`= '" 			. $meta_name. "',
				`nicename`='"		. $_POST['field-name'] . "',
				`parent`='"			. $_POST['field-parent'] . "',
				`type`='"			. $_POST['field-type'] . "',
				`description`='"	. $_POST['field-desc'] . "',
				`options`='"		. $_POST['field-options'] . "',
				`rich_editor`='"	. $rich_editor . "',
				`list_order`='"		. $_POST['field-order'] . "'

			;");	
		}
		$url = get_bloginfo('wpurl') . '/wp-admin/admin.php?page=easy-content-types/easy-content-types.php?metaboxes&fields-edit=' . $_POST['current-field'];
		header ("Location: $url");
	}	
} //check exist metapostfunction check_exist_metapost($meta_name = null, $parent= null, $id_edit= null){	global $wpdb,$ecpt_db_meta_fields_name;		$result =  $wpdb->get_row("SELECT * FROM ".$ecpt_db_meta_fields_name." WHERE name = '".$meta_name."' AND parent = '".$parent."'", ARRAY_A);	if($result){		if($id_edit){			if($id_edit == $result['id']){				return false;			} else {				return true;			}		} else {			return true;		}	} else {		return false;	}}
?>