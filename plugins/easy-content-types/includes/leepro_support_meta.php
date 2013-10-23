<?php
/* TAXONOMY
-----------------------------*/
//add filter to post type
 add_action('restrict_manage_posts','restrict_listings_by_taxonomy');
	function restrict_listings_by_taxonomy() {
		global $typenow,$wp_query,$wpdb,$get_info_taxonomy;
		global $ecpt_db_name;
		global $ecpt_db_tax_name;
		if ($typenow==$wp_query->query['post_type']) {
			$get_result_tax = $wpdb->get_results("SELECT * FROM `".$ecpt_db_tax_name."` WHERE `page` LIKE '%".$wp_query->query['post_type']."%'");
			if($get_result_tax){
				$taxonomy = '';
				foreach ($get_result_tax as $set_tax=> $tax){
					$taxonomy = $tax->name;
					if($taxonomy){
						break;
					}
				
				}
				if($taxonomy){
					$get_info_taxonomy = get_taxonomy($taxonomy);
					return wp_dropdown_categories(array(
						'show_option_all' =>  __("Show All {$get_info_taxonomy->label}"),
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
		}
	}

	add_filter('parse_query','convert_term_id_to_taxonomy_term_in_query');
	function convert_term_id_to_taxonomy_term_in_query($query) {
		global $typenow,$wp_query,$wpdb,$ecpt_db_tax_name,$pagenow,$get_info_taxonomy;
		
		$qv = &$query->query_vars;
		if (isset($wp_query->query['post_type']) && ($typenow==$wp_query->query['post_type'])) {
			$get_result_tax = $wpdb->get_results("SELECT * FROM `".$ecpt_db_tax_name."` WHERE `page` LIKE '%".$wp_query->query['post_type']."%'");
			if($get_result_tax){
				$taxonomy = '';
				foreach ($get_result_tax as $set_tax=> $tax){
					$taxonomy = $tax->name;
					if($taxonomy){
						break;
					}
				}
				if($taxonomy){
					if ($pagenow=='edit.php' &&	isset($qv[$taxonomy]) && is_numeric($qv[$taxonomy])) {
						$term = get_term_by('id',$qv[$taxonomy],$taxonomy);
						$qv[$taxonomy] = $term->slug;
					}
				}
			}
		}
	}
	
	//INIT
	add_action('init','load_data_header_init');
	function load_data_header_init($query){
		global $typenow;
		global $wp_query;
		global $wpdb;
		global $ecpt_db_tax_name,$ecpt_db_name;
		//$get_link = parse_url($_SERVER['REQUEST_URI']);
		if(isset($_REQUEST['post_type'])){
			$sql = "SELECT * FROM `".$ecpt_db_name."` WHERE `name` = '".$_REQUEST['post_type']."' AND `hierarchical` =0 ;" ;
			$get_result_post_type = $wpdb->get_results($sql);
			if(!empty($get_result_post_type)){
				$set_typenow = $_REQUEST['post_type'];
				$get_result_tax = $wpdb->get_results("SELECT * FROM `".$ecpt_db_tax_name."` WHERE `page` LIKE '%".$set_typenow."%'");
				$taxonomy_page = '';
				if($get_result_tax){
					foreach ($get_result_tax as $set_tax=> $tax){
						$get_taxonomy_page = explode(',',$tax->page);
						foreach($get_taxonomy_page as $set_taxonomy_page){
							if(trim($set_taxonomy_page) == trim($set_typenow)){
								$taxonomy_page = trim($set_taxonomy_page);
							}
							if($taxonomy_page){
								break;
							}
						}
						if($taxonomy_page){
							break;
						}
					}
					
					if($taxonomy_page){
						add_filter( 'manage_'.$taxonomy_page.'_posts_columns', 'add_term_toxonomy_ColumnHeader' );
					}
				}
			}
		}
	}
	//add colum category into post type
	
	function add_term_toxonomy_ColumnHeader($columns){
		global $typenow,$wp_query,$wpdb,$ecpt_db_tax_name;
		if ($typenow==$wp_query->query['post_type']) {
			$new_columns = array();
			if(isset($columns['cb']))			$new_columns['cb'] = '';
			if(isset($columns['title']))		$new_columns['title'] = '';
			if(isset($columns['author']))		$new_columns['author'] = '';
		//	if(isset($columns['categories']))	$new_columns['categories'] = '';
			if(isset($columns['tags']))			$new_columns['tags'] = '';
			$get_result_tax = $wpdb->get_results("SELECT * FROM `".$ecpt_db_tax_name."` WHERE `page` LIKE '%".$wp_query->query['post_type']."%'");
			$taxonomy = '';
			$taxonomy_label = '';
			if($get_result_tax){
				foreach ($get_result_tax as $set_tax=> $tax){
					$taxonomy = $tax->name.'_col';
					$taxonomy_label = $tax->singular_name;
					if($taxonomy){
						break;
					}
				}
				if(!$taxonomy){
					$taxonomy = 'set_category_col';
					$taxonomy_label = 'Category';
				}
				$new_columns[$taxonomy] = __($taxonomy_label);
				return array_merge($new_columns, $columns);;
			}
		}
	}
	
	add_action( 'manage_posts_custom_column', 'add_column_data_term_taxonomy', 10, 2 );
	function add_column_data_term_taxonomy( $column_name, $post_id ) {
		global $typenow,$wpdb,$wp_query,$ecpt_db_tax_name,$ecpt_db_name;
		if ($typenow == $wp_query->query['post_type']) {
				/*$sql = "SELECT * FROM `".$ecpt_db_name."` WHERE `name` = '".$wp_query->query['post_type']."' AND `hierarchical` =0 ;" ;
			$get_result_post_type = $wpdb->get_results($sql);
			if(!empty($get_result_post_type)){*/
				$get_result_tax = $wpdb->get_results("SELECT * FROM `".$ecpt_db_tax_name."` WHERE `page` LIKE '%".$wp_query->query['post_type']."%'");
				$taxonomy_name = '';
				$set_taxonomy = '';
				$taxonomy_label = '';
				if($get_result_tax){
					foreach ($get_result_tax as $set_tax=> $tax){
						$taxonomy_name = $tax->name.'_col';
						$taxonomy_label = $tax->singular_name;
						$set_taxonomy = $tax->name;
						if($taxonomy_name){
							break;
						}
					}
					if(!$taxonomy_name){
						$taxonomy_name = 'set_category_col';
						$taxonomy_label = 'Category';
					}
					if( $column_name == $taxonomy_name ) {
						$_posttype 	= $wp_query->query['post_type'];
						$_taxonomy 	= $set_taxonomy;
						$terms 		= get_the_terms( $post_id, $_taxonomy );
						if ( !empty( $terms ) ) {
							$out = array();
							foreach ( $terms as $c ){
								$_taxonomy_title = esc_html(sanitize_term_field('name', $c->name, $c->term_id, $_taxonomy, 'display'));
								$get_slug = $c->slug;
								$out[] = "<a href='edit.php?".$_taxonomy."=$get_slug&post_type=$_posttype'>$_taxonomy_title</a>";
							}
							echo join( ', ', $out );
						}
						else {
							_e('Uncategorized');
						}
					}
				//}
			}
		}
	}
