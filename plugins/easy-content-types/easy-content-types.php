<?php
/*
Plugin Name: Easy Content Types
Plugin URI: http://pippinspages.com
Description: The easiest way to create unlimited custom post types, taxonomies, and meta boxes
Author: LeePro
Author URI: http://24hzui.com
Version: 2.0.9
*/

/*****************************************
plugin shortname = ECPT
*****************************************/


/*****************************************
global variables
*****************************************/

global $wpdb;
 global $wp_version;
// plugin root folder
global $ecpt_base_dir;
$ecpt_base_dir = WP_PLUGIN_URL . '/' . str_replace(basename( __FILE__), "" ,plugin_basename(__FILE__));
// plugin root file
global $ecpt_base_filse;
$ecpt_base_filse = WP_PLUGIN_URL . '/' . plugin_basename(__FILE__);


// directory mulupload
global $adpdir;
$adpdir =  WP_CONTENT_DIR.'/uploads/';

global $dir_view_file;
$dir_view_file = get_bloginfo('home')."/wp-content/uploads";
// plugin prefix
global $ecpt_prefix;
$ecpt_prefix = 'ecpt_';

// ECPT DB version
global $ecpt_db_version;
$ecpt_db_version = 1.0;

// ECPT DB taxonomy version
global $ecpt_db_tax_version;
$ecpt_db_tax_version = 1.0;

// ECPT DB taxonomy version
global $ecpt_db_categorymeta_version;
$ecpt_db_categorymeta_version = 1.0;

// ECPT DB meta box version
global $ecpt_db_meta_version;
$ecpt_db_meta_version = 1.0;

// ECPT DB meta box fields version
global $ecpt_db_meta_fields_version;
$ecpt_db_meta_fields_version = 1.6;
// ECPT DB category fields version
global $ecpt_db_category_version;
$ecpt_db_category_version = 1.9;
// name of the ECPT post type database
global $ecpt_db_name;
$ecpt_db_name = $wpdb->prefix . "ecpt_post_types";

// name of the category post type database
global $ecpt_db_category_name;
$ecpt_db_category_name = $wpdb->prefix . "ecpt_categories";

// name of the ECPT post type database
global $ecpt_db_tax_name;
$ecpt_db_tax_name = $wpdb->prefix . "ecpt_taxonomies";

// name of the ECPT post type database
global $ecpt_db_categorymeta_name;
$ecpt_db_categorymeta_name = $wpdb->prefix . "ecpt_categorymetas";

// name of the ECPT post type database
global $wptm_table_name;
$wptm_table_name = $wpdb->prefix . "ecpt_categorymetas";

// name of the ECPT metabox database
global $ecpt_db_meta_name;
$ecpt_db_meta_name = $wpdb->prefix . "ecpt_meta_boxes";

// name of the ECPT metabox fields database
global $ecpt_db_meta_fields_name;
$ecpt_db_meta_fields_name = $wpdb->prefix . "ecpt_meta_box_fields";

// field types
$field_types = array('text', 'textarea', 'select', 'checkbox', 'radio', 'date', 'upload','multiupload', 'google_map');

// metabox page
$metabox_pages = get_post_types('', 'objects');

// metabox context
$metabox_contexts = array('normal', 'advanced', 'side');

// metabox priority
$metabox_priorities = array('default', 'high', 'core', 'low');

// taxonomy objects
$tax_objects = get_post_types('', 'objects');


// taxonomy attributes
$tax_atts = array('hierarchical', 'show_tagcloud', 'show_in_nav_menus');

// user levels
$user_levels = array('Admin', 'Editor', 'Author');

// load the plugin options
$ecpt_options = get_option( 'ecpt_settings' );

// meta upload
global $meta_name;
$meta_name = "photo";
/*****************************************
includes
*****************************************/
include('includes/page-home.php');
include('includes/process-data.php');
include('includes/post-types-admin.php');
include('includes/taxonomies-admin.php');
include('includes/category_meta/category_meta-admin.php');
include('includes/metabox-admin.php');
include('includes/scripts.php');
include('includes/misc-functions.php');
include('includes/register-post-types.php');
include('includes/register-taxonomies.php');
include('includes/category_meta/register-category-metas.php');

include('includes/register-meta-boxes.php');
include('includes/shortcodes.php');
include('includes/settings.php');
include('includes/export-admin.php');
include('includes/help-page.php');
include('includes/leepro_support_meta.php');include('includes/tinymce/tinymce.php');

/*****************************************
Install
*****************************************/

// function to create the DB / Options / Defaults					
function ecpt_options_install() {
   	global $wpdb;
  	global $ecpt_db_version;
  	global $ecpt_db_tax_version;
  	global $ecpt_db_name;
  	global $ecpt_db_tax_name;
	global $ecpt_db_categorymeta_name;
	global $ecpt_db_categorymeta_version;
  	global $ecpt_db_meta_name;
  	global $ecpt_db_meta_version;
  	global $ecpt_db_meta_fields_name;
  	global $ecpt_db_meta_fields_version;
	global $ecpt_db_category_name;
	global $ecpt_db_category_version;

	// create the ECPT post type database table
	if($wpdb->get_var("show tables like '$ecpt_db_name'") != $ecpt_db_name) 
	{
		$sql = "CREATE TABLE " . $ecpt_db_name . " (
		`id` mediumint(9) NOT NULL AUTO_INCREMENT,
		`name` tinytext NOT NULL,
		`singular_name` tinytext NOT NULL,
		`plural_name` tinytext NOT NULL,
		`hierarchical` tinyint NOT NULL,
		`title` tinyint NOT NULL,
		`editor` tinyint NOT NULL,
		`author` tinyint NOT NULL,
		`thumbnail` tinyint NOT NULL,
		`excerpt` tinyint NOT NULL,
		`fields` tinyint NOT NULL,
		`comments` tinyint NOT NULL,
		`revisions` tinyint NOT NULL,
		`has_archive` tinyint NOT NULL,
		`post_formats` tinyint NOT NULL,
		`page_attributes` tinyint NOT NULL,
		`show_in_nav_menus` tinyint NOT NULL,
		`menu_position` tinyint NOT NULL,
		`menu_icon` tinytext NOT NULL,
		`exclude_from_search` TINYINT NOT NULL,		
		UNIQUE KEY id (id)
		);";
		
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
				
		add_option("ecpt_db_version", $ecpt_db_version);	
	}
	
	// create the ECPT taxonomy database table
	if($wpdb->get_var("show tables like '$ecpt_db_tax_name'") != $ecpt_db_tax_name) 
	{
		$sql = "CREATE TABLE " . $ecpt_db_tax_name . " (
		`id` mediumint(9) NOT NULL AUTO_INCREMENT,
		`name` tinytext NOT NULL,
		`page` tinytext NOT NULL,
		`singular_name` tinytext NOT NULL,
		`plural_name` tinytext NOT NULL,
		`hierarchical` tinyint NOT NULL,
		`show_tagcloud` tinyint NOT NULL,
		`show_in_nav_menus` tinyint NOT NULL,
		`menu_position` tinyint NOT NULL,
		`type` tinyint NOT NULL,
		UNIQUE KEY id (id)
		);";
		
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
				
		add_option("ecpt_db_tax_version", $ecpt_db_tax_version);	
	}
	
	
	
	// create the ECPT category meta database table
	if($wpdb->get_var("show tables like '$ecpt_db_categorymeta_name'") != $ecpt_db_categorymeta_name) 
	{
		$sql = "CREATE TABLE " . $ecpt_db_categorymeta_name . " (
		  meta_id mediumint(9) NOT NULL auto_increment,
          terms_id bigint(20) NOT NULL default '0',
          meta_key varchar(255) default NULL,
          meta_value longtext,
          PRIMARY KEY  (`meta_id`),
          KEY `terms_id` (`terms_id`),
          KEY `meta_key` (`meta_key`)
        ) ENGINE=MyISAM AUTO_INCREMENT=6887 DEFAULT CHARSET=utf8;";
		
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
				
		add_option("ecpt_db_categorymeta_version", $ecpt_db_categorymeta_version);	
	}

		// create the ECPT category meta database table
	if($wpdb->get_var("show tables like '$ecpt_db_category_name'") != $ecpt_db_category_name) 
	{
		$sql = "CREATE TABLE " . $ecpt_db_category_name . " (
		  id mediumint(9) NOT NULL auto_increment,
		   meta_label varchar(255) default NULL,
          meta_name varchar(255) default NULL,
          meta_type varchar(255) default 'text',
          meta_taxonomy varchar(255) default 'category',
		  meta_desciption varchar(255) default NULL,
		  required_input tinyint NOT NULL,
		  list_order tinyint NOT NULL,
          PRIMARY KEY  (`id`)
        ) ENGINE=MyISAM AUTO_INCREMENT=6887 DEFAULT CHARSET=utf8;";
		
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
				
		add_option("ecpt_db_category_version", $ecpt_db_category_version);	
	}
	// create the ECPT metabox database table
	if($wpdb->get_var("show tables like '$ecpt_db_meta_name'") != $ecpt_db_meta_name) 
	{
		$sql = "CREATE TABLE " . $ecpt_db_meta_name . " (
		`id` mediumint(9) NOT NULL AUTO_INCREMENT,
		`name` tinytext NOT NULL,
		`nicename` tinytext NOT NULL,
		`page` tinytext NOT NULL,
		`context` tinytext NOT NULL,
		`priority` tinytext NOT NULL,
		UNIQUE KEY id (id)
		);";
		
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
				
		add_option("ecpt_db_meta_version", $ecpt_db_meta_version);	
	}
	
	// create the ECPT metabox fields database table
	if($wpdb->get_var("show tables like '$ecpt_db_meta_fields_name'") != $ecpt_db_meta_fields_name) 
	{
		$sql = "CREATE TABLE " . $ecpt_db_meta_fields_name . " (
		`id` mediumint(9) NOT NULL AUTO_INCREMENT,
		`name` tinytext NOT NULL,
		`nicename` tinytext NOT NULL,
		`parent` tinytext NOT NULL,
		`type` tinytext NOT NULL,
		`options` tinytext NOT NULL,
		`description` tinytext NOT NULL,
		`list_order` tinyint NOT NULL,
		UNIQUE KEY id (id)
		);";
		
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
				
		add_option("ecpt_db_meta_fields_version", $ecpt_db_meta_fields_version);	
	}
	// check if the meatbox fields table needs to be upgraded
	if(get_option('ecpt_db_meta_fields_version') < 1.3)
	{
		$wpdb->query("ALTER TABLE " . $ecpt_db_meta_fields_name . " MODIFY `list_order` tinyint");
		update_option('ecpt_db_meta_fields_version', 1.3 );	
	} 
	if(get_option('ecpt_db_meta_fields_version') < 1.5) 
	{
		$wpdb->query("ALTER TABLE " . $ecpt_db_meta_fields_name . " MODIFY `options` mediumtext");
	}
	
	// check if the rich_editor column exists
	if(!$wpdb->query("SELECT `description` FROM `" . $ecpt_db_meta_fields_name . "`")) 
	{
		$wpdb->query("ALTER TABLE `" . $ecpt_db_meta_fields_name . "` ADD `description` tinytext");
	}
	
	// check if the rich_editor column exists
	if(!$wpdb->query("SELECT `rich_editor` FROM `" . $ecpt_db_meta_fields_name . "`")) 
	{
		$wpdb->query("ALTER TABLE `" . $ecpt_db_meta_fields_name . "` ADD `rich_editor` tinyint");
	}
	
	update_option('ecpt_db_meta_fields_version', $ecpt_db_meta_fields_version );
}
// run the install scripts upon plugin activation
register_activation_hook(__FILE__,'ecpt_options_install');

// create custom plugin settings menu
add_action('admin_menu', 'ecpt_menu');
function ecpt_menu() {
	global $ecpt_options;
	
	// check the user levels needed to access each page
	
	if($ecpt_options['menu_user_level'] == 'Author') { 
		$menu_level = 'edit_posts'; $posts_level = 'edit_posts'; $tax_level = 'edit_posts'; $meta_level = 'edit_posts';
	} else if ($ecpt_options['menu_user_level'] == 'Editor') { 
		$menu_level = 'edit_pages'; $posts_level = 'edit_pages'; $tax_level = 'edit_pages'; $meta_level = 'edit_pages';
	} else { 
		$menu_level = 'manage_options'; $posts_level = 'manage_options'; $tax_level = 'manage_options'; $meta_level = 'manage_options'; 
	}	
	
	if($ecpt_options['posttype_user_level'] == 'Author' && (($ecpt_options['menu_user_level'] != 'Editor') && ($ecpt_options['menu_user_level'] != 'Admin'))) { 
		$posts_level = 'edit_posts'; 
	} else if ($ecpt_options['posttype_user_level'] == 'Editor' && ($ecpt_options['menu_user_level'] != 'Admin')) { 
		$posts_level = 'edit_pages'; 
	} else { 
		$posts_level = 'manage_options'; 
	}
	
	if($ecpt_options['tax_user_level'] == 'Author' && (($ecpt_options['menu_user_level'] != 'Editor') && ($ecpt_options['menu_user_level'] != 'Admin'))) { 
		$tax_level = 'edit_posts'; 
	} else if ($ecpt_options['tax_user_level'] == 'Editor' && ($ecpt_options['menu_user_level'] != 'Admin')) { 
		$tax_level = 'edit_pages'; 
	} else { 
		$tax_level = 'manage_options'; 
	}
	//echo $tax_level; exit;
	
	if($ecpt_options['metabox_user_level'] == 'Author' && (($ecpt_options['menu_user_level'] != 'Editor') && ($ecpt_options['menu_user_level'] != 'Admin'))) { 
		$meta_level = 'edit_posts'; 
	} else if ($ecpt_options['metabox_user_level'] == 'Editor' && ($ecpt_options['menu_user_level'] != 'Admin')) { 
		$meta_level = 'edit_pages'; 
	} else { 
		$meta_level = 'manage_options'; 
	}
	
	//create new top-level menu
	add_menu_page('Custom Content Types', 'Content Types', $menu_level, __FILE__, 'ecpt_home_page', plugins_url('/includes/images/icon.png', __FILE__));
	
	// add about page -- top level page links here
	add_submenu_page(__FILE__, 'About', 'About',$menu_level, __FILE__, 'ecpt_home_page');	
	
	
	// add custom post types page
	add_submenu_page(__FILE__, 'Post Types', 'Post Types',$posts_level, __FILE__ . '?posttypes', 'ecpt_posttype_manager');	
	
	// add custom taxonomies page
	add_submenu_page(__FILE__, 'Taxonomies', 'Taxonomies',$tax_level, __FILE__ . '?taxonomies', 'ecpt_tax_manager');	
	
	// add custom category mate page
	add_submenu_page(__FILE__, 'CategoryMetas', 'Category Metas',$tax_level, __FILE__ . '?categorymates', 'ecpt_categorymate_manager');	
	// add custom metaboxes page
	add_submenu_page(__FILE__, 'MetaBoxes', 'Meta Boxes',$meta_level, __FILE__ . '?metaboxes', 'ecpt_metabox_manager');			//Tinymce Support	add_submenu_page(__FILE__, 'Tinymce Support', 'Tinymce Support',$meta_level, __FILE__ . '?tinymce_support', 'tinymce_support_manager');
	
	// add settings page
	add_submenu_page(__FILE__, 'Settings', 'Settings','manage_options', __FILE__ . '?settings', 'ecpt_settings_page');		
	
	// add export page
	add_submenu_page(__FILE__, 'Export', 'Export','manage_options', __FILE__ . '?export', 'ecpt_export_page');		
	
	// add help page
	add_submenu_page(__FILE__, 'Help', 'Help',$menu_level, __FILE__ . '?help', 'ecpt_help_page');	
	
}

// add menu links to the plugin entry in the plugins menu
function ecpt_action_links($links, $file) {
    static $this_plugin;
 
    if (!$this_plugin) {
        $this_plugin = plugin_basename(__FILE__);
    }
 
    // check to make sure we are on the correct plugin
    if ($file == $this_plugin) {
	
        $ecpt_links[] = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=easy-content-types/easy-content-types.php?settings">Settings</a>';
		
		$ecpt_links[] = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=easy-content-types/easy-content-types.php?categorymates">Category Metas</a>';
       
	   $ecpt_links[] = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=easy-content-types/easy-content-types.php?metaboxes">Meta Boxes</a>';
		
        $ecpt_links[] = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=easy-content-types/easy-content-types.php?taxonomies">Taxonomies</a>';
		
        $ecpt_links[] = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/admin.php?page=easy-content-types/easy-content-types.php?posttypes">Post Types</a>';
		
		
		
        // add the links to the list of links alread there
		foreach($ecpt_links as $ecpt_link) {
			array_unshift($links, $ecpt_link);
		}
    }
 
    return $links;
}
add_filter('plugin_action_links', 'ecpt_action_links', 10, 2);
/* return link ko dau */function replace_character_utf_8($str) {	$str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);	$str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);	$str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);	$str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);	$str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);	$str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);	$str = preg_replace("/(đ)/", 'd', $str);	$str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);	$str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);	$str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);	$str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);	$str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);	$str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);	$str = preg_replace("/(Đ)/", 'D', $str);	//$str = str_replace(" ", "-", str_replace("&*#39;","",$str));	return $str;}
function process_string_post($name = null, $character = null){	if($name == null){		return null;	}	if($character == null){		$character = '-';	} 	return preg_replace('/[^a-zA-Z0-9!@#$"\'\/()\.,]/', $character, replace_character_utf_8(str_replace(array(' \ ',' /','/ ',' / ','/'),'-',str_replace('  ',' ', strtolower(trim($name))))));}
?>