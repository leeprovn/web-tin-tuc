<?php 

function ecpt_register_post_types() {
	global $wpdb;
	global $ecpt_db_name;
	global $ecpt_options;
	global $wp_rewrite;
	
	foreach( $wpdb->get_results("SELECT * FROM " . $ecpt_db_name . ";") as $key => $type) {
		$labels = array(
			'name' 				=> _x( $type->plural_name, 'post type general name' ),
			'singular_name'		=> _x( $type->singular_name, 'post type singular name' ),
			'add_new' 			=> _x( 'Add New ' . $type->singular_name, $type->singular_name),
			'add_new_item' 		=> __( 'Add New ' . $type->singular_name ),
			'edit_item' 		=> __( 'Edit ' . $type->singular_name ),
			'new_item' 			=> __( 'New ' . $type->singular_name ),
			'view_item' 		=> __( 'View ' . $type->singular_name ),
			'search_items' 		=> __( 'Search ' . $type->plural_name ),
			'not_found' 		=>  __( 'No ' . $type->singular_name . ' found' ),
			'not_found_in_trash'=> __( 'No ' . $type->singular_name . ' found in Trash' ),
			'parent_item_colon' => ''
		);

		// hierarchical is disabled at this time due to a bug in WP core
		if($type->hierarchical == 1) { $hierarchical = true; } else { $hierarchical = false; } 
		if($type->has_archive == 1) { $archive = true; } else { $archive = false; } 
		
		// check for supports options
		$supports = array();
		if($type->title == 1) 			{ $supports[] = 'title'; }
		if($type->editor == 1) 			{ $supports[] = 'editor'; }
		if($type->author == 1) 			{ $supports[] = 'author'; }
		if($type->thumbnail == 1) 		{ $supports[] = 'thumbnail'; }
		if($type->excerpt == 1) 		{ $supports[] = 'excerpt'; }
		if($type->fields == 1) 			{ $supports[] = 'custom-fields'; }
		if($type->comments == 1) 		{ $supports[] = 'comments'; }
		if($type->revisions == 1) 		{ $supports[] = 'revisions'; }
		if($type->post_formats == 1) 	{ $supports[] = 'post-formats'; }
		if($type->hierarchical == 1) 	{ $supports[] = 'page-attributes'; }
		
		// convert menu position to an int
		$position = (int)$type->menu_position;
		 $icon = "";
		if($type->menu_icon != '' && $type->menu_icon != 'undefined' )	{ $icon = $type->menu_icon; }
		$post_type_args = array(
			'labels' 			=> $labels,
			'singular_label' 	=> __($type->singular_name),
			'public' 			=> true,
			'show_ui' 			=> true,
			'publicly_queryable'=> true,
			'query_var'			=> true,
			'capability_type' 	=> 'post',
			'has_archive' 		=> $archive,
			'hierarchical' 		=> $hierarchical,
			'rewrite' 			=> array('slug' => $type->name),
			'supports' 			=> $supports,
			'menu_position' 	=> $position,
			'menu_icon' 		=> $icon
		 );
		 
		if($ecpt_options['create_single_templates'] == true) {
			 // create a template file for the single post type if it doesn't exist
			 if(!file_exists(STYLESHEETPATH . '/single-' . $type->name . '.php')) {
				if(file_exists(STYLESHEETPATH . '/single.php')) {
					copy(STYLESHEETPATH . '/single.php', STYLESHEETPATH . '/single-' . $type->name . '.php');
				} else {
					// copy index.php if single.php doesn't exist
					copy(STYLESHEETPATH . '/index.php', STYLESHEETPATH . '/single-' . $type->name . '.php');
				}
			 }
		}
		if($ecpt_options['create_archive_templates'] == true) {
			 // create a template file for the single post type if it doesn't exist
			 if(!file_exists(STYLESHEETPATH . '/archive-' . $type->name . '.php')) {
				if(file_exists(STYLESHEETPATH . '/archive.php')) {
					copy(STYLESHEETPATH . '/archive.php', STYLESHEETPATH . '/archive-' . $type->name . '.php');
				} else {
					// copy index.php if archive.php doesn't exist
					copy(STYLESHEETPATH . '/index.php', STYLESHEETPATH . '/archive-' . $type->name . '.php');
				}
			 }
		}	
		 
		 
		register_post_type($type->name,$post_type_args);
	}
	if($ecpt_options['auto_flush_permalinks'] == true) {
		// update the permalink structure
		$wp_rewrite->flush_rules();
	}
}
add_action('init', 'ecpt_register_post_types');

add_action('restrict_manage_posts','restrict_manage_posts_taxonomy');
function restrict_manage_posts_taxonomy() {
	global $typenow,$wp_query;
	
	if ($typenow==$set_post_type) {
		$taxonomy = $set_taxonomy;
		$product_category_taxonomy = get_taxonomy($taxonomy);
	  return wp_dropdown_categories(array(
			'show_option_all' =>  __("Show All {$product_category_taxonomy->label}"),
			'taxonomy'        =>  $taxonomy,
			'name'            =>  $taxonomy,
			'orderby'         =>  'name',
			'selected'        =>  $wp_query->query[$taxonomy],
			'hierarchical'    =>  true,
			'depth'           =>  3,
			'show_count'      =>  true, // Show # listings in parens
			'hide_empty'      =>  true, // Don't show businesses w/o listings
		));
	}
}
?>