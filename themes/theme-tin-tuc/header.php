<!DOCTYPE html>
<!--[if lt IE 7 ]><html class="ie ie6" dir="ltr" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 7 ]><html class="ie ie7" dir="ltr" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" dir="ltr" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9 ]><html class="ie ie9" dir="ltr" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html dir="ltr" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
    <title>
	<?php
	/*
	* Print the <title> tag based on what is being viewed.
	*/
	global $page, $paged, $options, $page_order , $session_cart,$title_page , $session_votes, $user_not_login;
	
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
	
	<!--[if lt IE 8]>
	<div style=' clear: both; text-align:center; position: relative;'>
	<a href="http://www.microsoft.com/windows/internet-explorer/default.aspx?ocid=ie6_countdown_bannercode"><img src="http://storage.ie6countdown.com/assets/100/images/banners/warning_bar_0000_us.jpg" border="0" alt="" /></a>
	</div>
	<![endif]-->
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_directory'); ?>/css/normalize.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_directory'); ?>/css/style.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_directory'); ?>/css/prettyPhoto.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_directory'); ?>/css/grid.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_directory'); ?>/css/colorscheme.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_directory'); ?>/css/coda-slider-2.0.css" />
	<link href='<?php bloginfo('stylesheet_directory'); ?>/css/css.css' rel='stylesheet' type='text/css'>
	
	<?php wp_head();?>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url');?>" media="screen" />
	<script type='text/javascript' src='<?php bloginfo('stylesheet_directory'); ?>/js/jquery-1.7.2.min.js'></script>
	<script type='text/javascript' src='<?php bloginfo('stylesheet_directory'); ?>/js/modernizr.js'></script>
	<script type='text/javascript' src='<?php bloginfo('stylesheet_directory'); ?>/js/superfish.js'></script>
	<script type='text/javascript' src='<?php bloginfo('stylesheet_directory'); ?>/js/jquery.easing.1.3.js'></script>
	<script type='text/javascript' src='<?php bloginfo('stylesheet_directory'); ?>/js/jquery.prettyPhoto.js'></script>
	<script type='text/javascript' src='<?php bloginfo('stylesheet_directory'); ?>/js/jquery.coda-slider-2.0.js'></script>
	<script type='text/javascript' src='<?php bloginfo('stylesheet_directory'); ?>/js/jquery.tools.min.js'></script>
	<script type='text/javascript' src='<?php bloginfo('stylesheet_directory'); ?>/js/jquery.loader.js'></script>
	<script type='text/javascript' src='<?php bloginfo('stylesheet_directory'); ?>/js/jquery.elastislide.js'></script>
	<script type='text/javascript' src='<?php bloginfo('stylesheet_directory'); ?>/js/swfobject.js'></script>
	<script type='text/javascript' src='<?php bloginfo('stylesheet_directory'); ?>/js/jquery.cycle.all.js'></script>
	<script type='text/javascript' src='<?php bloginfo('stylesheet_directory'); ?>/js/jquery.twitter.js'></script>
	<script type='text/javascript' src='<?php bloginfo('stylesheet_directory'); ?>/js/jquery.flickrush.js'></script>
	<script type='text/javascript' src='<?php bloginfo('stylesheet_directory'); ?>/js/audio.js'></script>
	<script type='text/javascript' src='<?php bloginfo('stylesheet_directory'); ?>/js/custom.js'></script>
	<?php wp_get_archives('type=monthly&format=link'); if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>	
  <!--[if lt IE 9]>
  <style type="text/css">
    .widget_nav_menu ul li a, .post_list.testimonials_custom_posts, .post_list.testimonials_custom_posts .post_content .inside, .widget.widget_categories ul li a, .tags-cloud a, .tagcloud a, .post-footer a {
      behavior:url(http://livedemo00.template-help.com/wordpress_40786/wp-content/themes/theme1742/PIE.php)
      }
  </style>
  <![endif]-->
  
  <script type="text/javascript">
  	// initialise plugins
		jQuery(function(){
			// main navigation init
			jQuery('ul.sf-menu').superfish({
				delay:       1000, 		// one second delay on mouseout 
				animation:   {opacity:'show',height:'show'}, // fade-in and slide-down animation
				speed:       'normal',  // faster animation speed 
				autoArrows:  true,   // generation of arrow mark-up (for submenu) 
				dropShadows: false   // drop shadows (for submenu)
			});
			
			// prettyphoto init
			jQuery("a[rel^='prettyPhoto']").prettyPhoto({
				animation_speed:'normal',
				slideshow:5000,
				autoplay_slideshow: false,
				overlay_gallery: true
			});
			
		});
		
		// Init for audiojs
		audiojs.events.ready(function() {
			var as = audiojs.createAll();
		});
  </script>
  <script type="text/javascript">
			jQuery().ready(function() {
				jQuery('#coda-slider-1').codaSlider({
					dynamicArrows: false,
					dynamicTabs: false,
					autoSlide: false,
					autoSlideInterval: 7000				});
			});
		 </script>
  <!-- Custom CSS -->
</head>

<body  <?php body_class(); ?>>

<div id="main" class="container"><!-- this encompasses the entire Web site -->
	<header id="header">
		<div class="container_12 clearfix">
			<div class="grid_12">
				<div class="logo">
					<a href="<?php echo home_url(); ?>/" id="logo"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/logo.png" alt="<?php bloginfo('name'); ?>" title="<?php echo $site_description; ?>"></a>
				</div>
				<nav class="primary">
					<?php
						 wp_nav_menu( array(
							'theme_location' => 'main_nav', // Setting up the location for the main-menu, Main Navigation.
							'menu_class' => 'sf-menu', //Adding the class for dropdowns
							'container_id' => 'topnav', //Add CSS ID to the containter that wraps the menu.
							'fallback_cb' => 'wp_page_menu', //if wp_nav_menu is unavailable, WordPress displays wp_page_menu function, which displays the pages of your blog.
							)
						);
					?>
				</nav><!--.primary-->
				<div id="widget-header">
					<ul>
						<?php if(!is_user_logged_in()){ ?>
							<li>
								<a class="simplemodal-login" href="<?php echo get_bloginfo('home').'/wp-login.php?redirect_to='.get_bloginfo('home') ; ?>">Đăng nhập</a>		
							</li>
							<li>
								<a class="simplemodal-register" href="<?php echo get_bloginfo('home').'/wp-login.php?action=lostpassword?redirect_to='.get_bloginfo('home') ; ?>">Đăng ký</a>
							</li>
						<?php 
							} else {
							global $current_user;
						?>
							<li>
								<a href="<?php echo get_bloginfo('home'); ?>/wp-admin/profile.php"><?php echo $current_user->display_name; ?></a>
							</li>
							<li>
								<a title="Đăng xuất" href="<?php echo  esc_url( wp_logout_url(get_bloginfo('home')) ); ?>">Thoát</a>
							</li>
						<?php } ?>
						<li>
							<div id="top-search">
							  <form method="get" action="<?php echo esc_url(home_url('/')); ?>">
								<label for="s">Tìm kiếm</label><span class="wrap"><input value="<?php echo get_search_query(); ?>" placeholder="Nhập từ khóa..." type="text" name="s" id="s" class="input-search"/><input type="submit" value="" id="submit"></span>
							  </form>
							</div>   		
						</li>
					</ul>
				</div><!--#widget-header-->
			</div>
		</div><!--.container_12-->
	</header>