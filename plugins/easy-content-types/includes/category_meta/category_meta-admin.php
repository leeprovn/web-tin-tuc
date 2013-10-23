<?php 
function ecpt_get_categories(){
	global $wpdb;
	global $ecpt_db_category_name;
	return $wpdb->get_results( "SELECT * FROM `$ecpt_db_category_name`" );
}
function ecpt_categorymate_manager(){
		global $wpdb;
		global $ecpt_db_categorymeta_name;
		global $ecpt_db_category_name;
		global $wp_version;
        if(isset($_POST['action']) && ($_POST['action'] == "add")) 
        {
			if ( trim( $_POST["new_meta_name"]) != ''){
				if(trim( $_POST['new_meta_label'] ) == ''){
						$_POST['new_meta_label']  = $_POST['new_meta_name'] ;
				}
				$new_meta_required_input = '';
				if(isset(	$_POST['new_meta_required_input'] )){
					$new_meta_required_input =	$_POST['new_meta_required_input'] ;
				}
				$add = $wpdb->query("INSERT INTO " . $ecpt_db_category_name . " SET 
					`meta_label`='" .   $_POST['new_meta_label'] . "',
					`meta_name`='" 	.   replace_character_utf_8(str_replace(' ', '-', strtolower($_POST['new_meta_name']))) . "',
					`meta_type`='" .   $_POST['new_meta_type'] . "',
					`meta_taxonomy`='"		. 	$_POST['new_meta_taxonomy'] . "',
					`meta_desciption`='".$_POST['new_meta_description']."',
					`required_input`='"		. 	$new_meta_required_input  . "'
					;");	
				if($add){
					echo '<div class="updated below-h2" id="message"><p>Add new meta categoty success!. </p></div>';
				} else {
					echo '<div class="updated below-h2" id="message"><p>Add new meta categoty not success. Please try agian!.</p></div>';
				}
			} else {
				echo '<div class="updated below-h2" id="message"><p>Meta name not empty. </p></div>';
			}
            
        }
        else if(isset($_POST['action']) && ($_POST['action'] == "delete")) 
        {
			/*
            $delete_Meta_Name = $_POST["delete_Meta_Name"];
            unset($configuration[$delete_Meta_Name]);
            update_option("wptm_configuration", $configuration);*/
			$remove = $wpdb->query("DELETE FROM " . $ecpt_db_category_name . " WHERE `id`='" . $_POST['delete_Meta_id'] . "';");
			if($remove) {
				echo '<div class="updated below-h2" id="message"><p>Meata category deleted.  </p></div>';
			} else {
				echo '<div class="updated below-h2" id="message"><p>Meata category not delete. </p></div>';
			}
        }
		$get_meta_categories = ecpt_get_categories();
    ?>
        <div class="wrap">
            <h2><?php _e('Category Meta ', 'category-meta'); ?></h2>
            <table class="widefat fixed">
                <thead>
                    <tr class="title">
                        <th scope="col" class="manage-column"><?php _e('Meta list', 'category-meta'); ?></th>
                        <th scope="col" class="manage-column"></th>
                        <?php if($wp_version >= '3.0') {?>
                        <th scope="col" class="manage-column"></th>
                        <?php } ?>
                        <th scope="col" class="manage-column"></th>						<th scope="col" class="manage-column"></th>
						<th scope="col" class="manage-column"></th>
                    </tr>
                    <tr class="title">
					  <th scope="col" class="manage-column"><?php _e('Meta Label', 'category-meta'); ?></th>
                        <th scope="col" class="manage-column"><?php _e('Meta Name', 'category-meta'); ?></th>
                        <th scope="col" class="manage-column"><?php _e('Meta Type', 'category-meta'); ?></th>
						<th scope="col" class="manage-column"><?php _e('Input required', 'category-meta'); ?></th>
                        <?php if($wp_version >= '3.0') {?>
                        <th scope="col" class="manage-column"><?php _e('Meta Taxonomy', 'category-meta'); ?></th>
                        <?php } ?>
                        <th scope="col" class="manage-column"><?php _e('Action', 'category-meta'); ?></th>
                    </tr>
                </thead>
                <?php 
                    foreach($get_meta_categories as $name => $data)
                    { 
							$type = '';
                            $type = $data->meta_type;
							 $taxonomy = $data->meta_taxonomy;
							 if(empty($taxonomy)) $taxonomy = 'category';
                        ?>
                <tr class="mainrow">    
					<td class="titledesc"><?php echo $data->meta_label;?></td>				
                    <td class="titledesc"><?php echo $data->meta_name;?></td>
                    <td class="forminp">
                        <?php echo $type;?>
                    </td>
					<td class="titledesc"><?php echo $data->required_input;?></td>
                    <?php if($wp_version >= '3.0') {?>
                    <td class="forminp">
                        <?php echo $taxonomy;?>
                    </td>
                    <?php } ?>
                    <td class="forminp">
                        <form method="post">
                        <input type="hidden" name="action" value="delete" />
                        <input type="hidden" name="delete_Meta_id" value="<?php echo $data->id;?>" />
                        <input class="confirm_delete" type="submit" value="<?php _e('Delete this Meta', 'category-meta') ?>" />
                        </form>
                    </td>
                </tr>
                    <?php }
                ?>
            </table>
			
            <br/>
            <form method="post" action="#">
                <table class="widefat">
                    <thead>
                        <tr class="title">
                            <th scope="col" class="manage-column"><?php _e('Add a Meta', 'category-meta'); ?></th>
                            <th scope="col" class="manage-column"></th>
                        </tr>
                    </thead>
                    <tr class="mainrow">        
                        <td class="titledesc"><?php _e('Meta label','category-meta'); ?>:</td>
                        <td class="forminp">
                            <input type="text" id="new_meta_label" name="new_meta_label" value="" />
                        </td>
                    </tr>
                    <tr class="mainrow">        
                        <td class="titledesc"><?php _e('Meta Name','category-meta'); ?>:</td>
                        <td class="forminp">
                            <input type="text" id="new_meta_name" name="new_meta_name" value="" />
                        </td>
                    </tr>
                    <tr class="mainrow">        
                        <td class="titledesc"><?php _e('Meta description','category-meta'); ?>:</td>
                        <td class="forminp">
                            <input type="text" id="new_meta_description" size="100" name="new_meta_description" value="" />
                        </td>
                    </tr>
                    <tr class="mainrow" >        
                        <td class="titledesc"><?php _e('Input required','category-meta'); ?>:</td>
                        <td class="forminp">
                            <input type="checkbox" id="new_meta_name_required_input" name="new_meta_required_input" value="1" />
                        </td>
                    </tr>
                    <tr class="mainrow">        
                        <td class="titledesc"><?php _e('Meta Type','category-meta'); ?>:</td>
                        <td class="forminp">
                            <select id="new_meta_type" name="new_meta_type">
                                <option value="text"><?php _e('Text','category-meta'); ?></option>
                                <option value="textarea"><?php _e('Text Area','category-meta'); ?></option>
                                <option value="image"><?php _e('Image','category-meta'); ?></option>
                                <option value="checkbox"><?php _e('Check Box','category-meta'); ?></option>
                            </select>
                        </td>
                    </tr>
                    <?php if($wp_version >= '3.0') {?>
                    <tr class="mainrow">        
                        <td class="titledesc"><?php _e('Meta Toxonomy','category-meta'); ?>:</td>
                        <td class="forminp">
                            <select id="new_meta_taxonomy" name="new_meta_taxonomy">
                                <?php 
                                    $taxonomies=get_taxonomies('','names'); 
                                    foreach ($taxonomies as $taxonomy ) {
                                      echo '<option value="'.$taxonomy.'">'. $taxonomy. '</option>';
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <?php } ?>
                    <tr class="mainrow">
                        <td class="titledesc">
                        <input type="hidden" name="action" value="add" />
                        </td>
                        <td class="forminp">
                        <input type="submit" value="<?php _e('Add Meta', 'category-meta') ?>" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>		<script>			jQuery(function($){					jQuery('input.confirm_delete').click(function(){						var r=confirm("Are you sure you want delete this taxonamy?");						if (r == true) {                    							return true;						}  						return false;					});			});					</script>
	<?php

}
?>