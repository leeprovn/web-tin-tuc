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
	<script type="text/javascript">
	//<![CDATA[
	window.__CF=window.__CF||{};window.__CF.AJS={"abetterbrowser":{"ie":"7"},"ga_key":{"ua":"UA-7078796-5","ga_bs":"2"}};
	//]]>
	</script>
	<script type="text/javascript">
	//<![CDATA[
	//try{if (!window.CloudFlare) { var CloudFlare=[{verbose:0,p:0,byc:0,owlid:"cf",bag2:1,mirage2:0,oracle:0,paths:{cloudflare:"/cdn-cgi/nexp/abv=1309062649/"},atok:"38fdcb0eb0ddc97405c4c6477f333767",petok:"2ef2fb09b2dd2872397bbf7e3ccbf158-1382534683-1800",zone:"template-help.com",rocket:"0",apps:{"abetterbrowser":{"ie":"7"},"ga_key":{"ua":"UA-7078796-5","ga_bs":"2"}}}];var a=document.createElement("script"),b=document.getElementsByTagName("script")[0];a.async=!0;a.src="js/cloudflare.min.js";b.parentNode.insertBefore(a,b);}}catch(e){};
	//]]>
	</script>
	<script type="text/javascript">var NREUMQ=NREUMQ||[];NREUMQ.push(["mark","firstbyte",new Date().getTime()]);</script>
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
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url');?>" media="screen" />
	<?php wp_head();?>
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
	<script type='text/javascript' src='<?php bloginfo('stylesheet_directory'); ?>/js/comment-reply.js'></script>

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

<body class="home page page-id-203 page-template page-template-page-home-php">

<div id="main" class="container"><!-- this encompasses the entire Web site -->
	<header id="header">
		<div class="container_12 clearfix">
			<div class="grid_12">
      	<div class="logo">
                    	            	<a href="<?php echo home_url(); ?>/" id="logo"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/logo.png" alt="Education" title="Just another WordPress site"></a>
                              </div>
        <nav class="primary">
          <ul id="topnav" class="sf-menu">
		  <li id="menu-item-205" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-203 current_page_item menu-item-205"><a href="http://livedemo00.template-help.com/wordpress_40786/">Home</a></li>
<li id="menu-item-21" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-21"><a href="http://livedemo00.template-help.com/wordpress_40786/about/">about</a>
<ul class="sub-menu">
	<li id="menu-item-225" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-225"><a href="http://livedemo00.template-help.com/wordpress_40786/about/testimonials/">Testimonials</a></li>
	<li id="menu-item-421" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-421"><a href="http://livedemo00.template-help.com/wordpress_40786/about/archives/">Archives</a></li>
	<li id="menu-item-18" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-18"><a href="http://livedemo00.template-help.com/wordpress_40786/about/faqs/">FAQs</a></li>
</ul>
</li>
<li id="menu-item-19" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-19"><a href="http://livedemo00.template-help.com/wordpress_40786/programs/">programs</a>
<ul class="sub-menu">
	<li id="menu-item-40" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-40"><a href="http://livedemo00.template-help.com/wordpress_40786/programs/programs-1-col/">programs 1 col</a></li>
	<li id="menu-item-39" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-39"><a href="http://livedemo00.template-help.com/wordpress_40786/programs/programs-2-cols/">programs 2 cols</a></li>
	<li id="menu-item-38" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-38"><a href="http://livedemo00.template-help.com/wordpress_40786/programs/programs-3-cols/">programs 3 cols</a>
	<ul class="sub-menu">
		<li id="menu-item-239" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-239"><a href="http://livedemo00.template-help.com/wordpress_40786/programs/programs-3-cols/1st-category/">1st category</a></li>
		<li id="menu-item-238" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-238"><a href="http://livedemo00.template-help.com/wordpress_40786/programs/programs-3-cols/2nd-category/">2nd category</a></li>
		<li id="menu-item-237" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-237"><a href="http://livedemo00.template-help.com/wordpress_40786/programs/programs-3-cols/3rd-category/">3rd category</a></li>
	</ul>
</li>
	<li id="menu-item-37" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-37"><a href="http://livedemo00.template-help.com/wordpress_40786/programs/programs-4-cols/">programs 4 cols</a></li>
</ul>
</li>
<li id="menu-item-105" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-105"><a href="http://livedemo00.template-help.com/wordpress_40786/blog/">Blog</a></li>
<li id="menu-item-492" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-492"><a href="http://livedemo00.template-help.com/wordpress_40786/partners/">partners</a></li>
<li id="menu-item-17" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-17"><a href="http://livedemo00.template-help.com/wordpress_40786/contacts/">Contacts</a></li>
</ul>        
</nav><!--.primary-->
        <div id="widget-header">
        	<ul>
			<li>
				<a href="http://livedemo00.template-help.com/wordpress_40786/wp-login.php">Log in</a>			</li>
			<li><a href="http://livedemo00.template-help.com/wordpress_40786/wp-login.php?action=register">Register</a></li>			<li>
				  
					<div id="top-search">
					  <form method="get" action="http://livedemo00.template-help.com/wordpress_40786/">
					    <label for="s">Search</label><span class="wrap"><input type="text" name="s" id="s" class="input-search"/><input type="submit" value="" id="submit"></span>
					  </form>
					</div>  
				      		
			</li>
		</ul>
        </div><!--#widget-header-->
      </div>
		</div><!--.container_12-->
	</header>