<?php
class Category_Site_Sidebar extends WP_Widget{
	function Category_Site_Sidebar(){
		parent::WP_Widget(
			'Category_Site_Sidebar_Widget', 
			'04 - Chuyên mục tin',
			array(
				'description'=>'Hiển thị thông tin chuyên mục tin trên sidebar right'
			));
	}
	function widget( $args, $instance ) { 
		global $wp_registered_sidebars;
        extract($args); 
        $title = apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], 
            $instance, $this->id_base); 
		$show_count = apply_filters( 'widget_show_count', $instance['show_count'], $instance ); 
		if($title == ''){
			$title = 'Chuyên mục';
		}
		$args = array(
			//'show_option_all'    => '',
			'orderby'            => 'ID',
			'order'              => 'ASC',
			'style'              => 'list',
			'hide_empty'         => 1,
			'hierarchical'       => 1,
			'title_li'           => '',
			'show_option_none'   => __('Không có danh mục'),
			'echo'               => 1,
			'taxonomy'           => 'category',
		);
		if($show_count == 1){
			$args['show_count'] =  1;
		}
        echo $before_widget; 
		echo $before_title . $title . $after_title; 
		echo '<ul class="nav-sidebar svsk tree dhtml">';
		wp_list_categories($args); 
		echo '</ul>';
        echo $after_widget; 
    }
	
	function update( $new_instance, $old_instance ) { 
		$instance = $old_instance; 
		$instance['title'] = strip_tags($new_instance['title']); 
		if ( current_user_can('unfiltered_html') ) {
			$instance['show_count'] = $new_instance['show_count'];
		} else{
			$instance['show_count'] = stripslashes( 
				wp_filter_post_kses( addslashes($new_instance['show_count']) ) 
			); 
		}
		return $instance; 
	}
	function form( $instance ) { 
			$instance = wp_parse_args( (array) $instance, 
				array( 
					'title' => '',
					'show_count' => ''
				) ); 
			$title = strip_tags($instance['title']); 
			$show_count = format_to_edit($instance['show_count']); 
			$option_show_count = array(
				'1' => 'Hiển thị',
				'2' => 'Không hiển',
			);
	?> 
			<p> 
				<label for="<?php echo $this->get_field_id('title'); ?>"> 
					<?php _e('Tên danh mục:'); ?> </label> 
				<input class="widefat" 
					id="<?php echo $this->get_field_id('title'); ?>" 
					name="<?php echo $this->get_field_name('title'); ?>" type="text"
					value="<?php echo  esc_attr($title);?>" /> 
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('show_count'); ?>"> 
					<?php _e('Hiển thị số lượng tin:'); ?> </label> 
				<select name="<?php echo $this->get_field_name('show_count')?>" id="<?php echo $this->get_field_id('show_count'); ?>">
					<?php foreach ($option_show_count as $key=> $value){ ?>
							<option value="<?php echo $key ?>" <?php if($key==trim($show_count)){?> selected="selected" <?php }?>><?php echo $value ?></option>
					<?php }; ?>
				</select>
			</p>
	<?php 
		} 
} 
  
register_widget('Category_Site_Sidebar'); 
