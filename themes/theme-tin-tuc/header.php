<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
    <title>
	<?php
	/*
	* Print the <title> tag based on what is being viewed.
	*/
	global $page, $paged, $options;
	
	$options = isovn_get_option_theme();

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	//if ( $site_description && ( is_home() || is_front_page() ) )
	echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
	echo ' | ' . sprintf( __( 'Page %s', 'option-theme' ), max( $paged, $page ) );

	?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="robots" content="index, follow" />
	<meta name="description" content="<?php echo $site_description;?>">
    <meta name="keywords" content="<?php echo $site_description;?>">
	<meta name="language" content="<?php bloginfo( 'charset' ); ?>" />
	<meta name="title" content="<?php echo $site_description;?>" />
    <meta name="author" content="iSovn team">
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <!-- Le styles -->
    <!--<link href="<?php bloginfo('template_directory');?>/assets/css/bootstrap.css" rel="stylesheet">-->
  
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url');?>" media="screen" />
   
	<script type="text/javascript">
	//<![CDATA[
		ajaxurl = '<?php echo admin_url( 'admin-ajax.php'); ?>';
		url_theme = '<?php echo get_bloginfo('template_directory'); ?>';
		url_home = '<?php echo get_bloginfo('url'); ; ?>';
	//]]>
	</script>
	<link rel="shortcut icon" href="<?php bloginfo('template_directory');?>/favicon.png">
	<?php wp_head();?>
  </head>
  <body>
