<?php
/**
Author: LeePro
URL: htp://isovn.net
This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images, 
sidebars, comments, ect.

YOU NEED TO COMMENT AND GROUP THEM IN AN AREA CLEARLY.
*/

/**
 ************ REQUIRE GLOBAL CLASSES ************
 */
global $user_not_login;
$user_not_login = true;
if(!is_user_logged_in()){ 
	$user_not_login = false;
}
global $session_cart;
$session_cart = 'cartOrder';
global $session_votes;
$session_votes = 'session_votes';
function register_session(){
	if( !session_id()){
		ob_clean();
		session_start();
		ob_start();
	}
}
add_action('init','register_session');

/*
function __construct() {
	global $session_cart;
	if ( !isset($_SESSION[$session_cart]) ) :	
		$_SESSION[$session_cart] = $_SESSION[$session_cart];
	endif;
} */

require_once('includes/libs/bootstrap_walker.php');
include('includes/theme-option.php');
require_once('includes/widget-categories.php');

function isovn_check_user_role($roles) {
	$user = wp_get_current_user();
	if($user){
		if(isset($user->caps) && isset($user->caps[$roles])){
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}
/**
 ~~~~~~~~~~~~ REQUIRE GLOBAL CLASSES ~~~~~~~~~~~~
 */

/**
 ************ CALL GLOBAL FUNCTIONS DIRECTLY ************
 */
if ( isovn_check_user_role('administrator') ) {
	show_admin_bar( true );	
} else {
	show_admin_bar( false );	
}

/**
 ************ THEME COMMON FUNCTIONS ************
 */

// Adding WP 3+ Functions & Theme Support

function custom_theme_support() {
	add_theme_support('post-thumbnails');     
	/*set_post_thumbnail_size(125, 125, true);   */
	add_theme_support( 'custom-background' );  
	add_theme_support('automatic-feed-links'); 
	add_theme_support( 'menus' );          
	register_nav_menus(                
		array( 
			'main_nav' => 'The Main Menu', 
			'footer_links' => 'Footer Links' 
		)
	);

	if(function_exists('register_sidebar')){
		register_sidebar(array(
			'name' => 'Sidebar Home',
			'description' => 'Sidebar cho tin tức/Sản phẩm',
			'before_widget'  => '<div id="id_%1$s" class="content-box shadow-box">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h2>',
			'after_title'   => '</h2><div class="box-content padding-5px">'
		));
		register_sidebar(array(
			'name' => 'S.Home 4-Box',
			'description' => 'Sidebar cho widget S.Home 4-Box',
			'before_widget'  => '<div id="id_%1$s" class="span3 content-box shadow-box">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h2>',
			'after_title'   => '</h2><div class="box-content widget-box-span-3 format-box">'
		));
		register_sidebar(array(
			'name' => 'Sidebar Right',
			'description' => 'Sidebar cho cột bên phải',
			'before_widget'  => '<div id="id_%1$s" class="sidebar-box shadow-box">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h2>',
			'after_title'   => '</h2><div class="box-content padding-5px">'
		));
		register_sidebar(array(
			'name' => 'S.Right Center',
			'description' => 'Sidebar cho widget S.Home 2-Box',
			'before_widget'  => '<div id="id_%1$s" class="sidebar-box content-box shadow-box">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h2>',
			'after_title'   => '</h2><div class="box-content widget-box-span-4 format-box">'
		));
		register_sidebar(array(
			'name' => 'S.Right Bottom',
			'description' => 'Sidebar cho widget S.Home 2-Box',
			'before_widget'  => '<div id="id_%1$s" class="sidebar-box content-box shadow-box">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h2>',
			'after_title'   => '</h2><div class="box-content widget-box-span-4 format-box">'
		));
		register_sidebar(array(
			'name' => 'S.Home 1-2Box',
			'description' => 'Widget 0.2 - Hiển thị 2(box) trên trang chủ/Sidebar',
			'before_widget'  => '<div id="id_%1$s" class="span6 content-box shadow-box">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h2>',
			'after_title'   => '</h2><div class="box-content widget-box-span-6 format-box">'
		));
		register_sidebar(array(
			'name' => 'S.Home 2-3Box',
			'description' => 'Widget 0.2 - Hiển thị 3(box) trên trang chủ/Sidebar',
			'before_widget'  => '<div id="id_%1$s" class="span4 content-box shadow-box">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h2>',
			'after_title'   => '</h2><div class="box-content widget-box-span-4 format-box">'
		));
		register_sidebar(array(
			'name' => 'S.Home 3-2Box',
			'description' => 'Widget 0.2 - Hiển thị 2(box) trên trang chủ/Sidebar',
			'before_widget'  => '<div id="id_%1$s" class="span6 content-box shadow-box">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h2>',
			'after_title'   => '</h2><div class="box-content widget-box-span-6 format-box">'
		));
		register_sidebar(array(
			'name' => 'S.Home 4-3Box',
			'description' => 'Widget 0.2 - Hiển thị 3(box) trên trang chủ/Sidebar',
			'before_widget'  => '<div id="id_%1$s" class="span4 content-box shadow-box">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h2>',
			'after_title'   => '</h2><div class="box-content widget-box-span-4 format-box">'
		));
		register_sidebar(array(
			'name' => 'S.Home 5-2Box',
			'description' => 'Widget 0.2 - Hiển thị 2(box) trên trang chủ/Sidebar',
			'before_widget'  => '<div id="id_%1$s" class="span6 content-box shadow-box">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h2>',
			'after_title'   => '</h2><div class="box-content widget-box-span-6 format-box">'
		));
		register_sidebar(array(
			'name' => 'S.Home 6-3Box',
			'description' => 'Widget 0.2 - Hiển thị 3(box) trên trang chủ/Sidebar',
			'before_widget'  => '<div id="id_%1$s" class="span4 content-box shadow-box">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h2>',
			'after_title'   => '</h2><div class="box-content widget-box-span-4 format-box">'
		));
		register_sidebar(array(
			'name' => 'S.Home 7-2Box',
			'description' => 'Widget 0.2 - Hiển thị 2(box) trên trang chủ/Sidebar',
			'before_widget'  => '<div id="id_%1$s" class="span6 content-box shadow-box">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h2>',
			'after_title'   => '</h2><div class="box-content widget-box-span-6 format-box">'
		));
		register_sidebar(array(
			'name' => 'S.Home 8-3Box',
			'description' => 'Widget 0.2 - Hiển thị 3(box) trên trang chủ/Sidebar',
			'before_widget'  => '<div id="id_%1$s" class="span4 content-box shadow-box">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h2>',
			'after_title'   => '</h2><div class="box-content widget-box-span-4 format-box">'
		));
		register_sidebar(array(
			'name' => 'S.Home 9-2Box',
			'description' => 'Widget 0.2 - Hiển thị 2(box) trên trang chủ/Sidebar',
			'before_widget'  => '<div id="id_%1$s" class="span6 content-box shadow-box">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h2>',
			'after_title'   => '</h2><div class="box-content widget-box-span-6 format-box">'
		));
	}
}

add_action('after_setup_theme','custom_theme_support');	

/* custom menu */

function custom_main_nav($theme_location = 'main_nav', $container = false ) {
    wp_nav_menu( 
    	array( 
    		'menu' => 'main_nav', /* menu name */
    		'menu_class' => 'nav',
    		'theme_location' => $theme_location, /* where in the theme it's assigned */
    		'container' => $container, /* container class */
    		'fallback_cb' => 'bones_main_nav_fallback', /* menu fallback */
    		'depth' => '3', /* suppress lower levels for now */
    		'walker' => new Bootstrap_Walker()
    	)
    );
}

add_filter('nav_menu_css_class', 'add_active_class', 10, 2 );

function add_active_class($classes, $item) {
	if( $item->menu_item_parent == 0 && in_array('current-menu-item', $classes) ) {
    $classes[] = "active";
	}
  return $classes;
}


/**
 ************ UTIL COMMON FUNCTIONS ************
 */

/**

* Function name:	isovn_utf162utf8
* Description : 	Convert unf-8
* HISTORIES:
* DATE				AUTH			DESCRIPTION
* June 5, 2013		Vinh.le			Convert unf-8
*/

function isovn_utf162utf8($utf16){
	if( function_exists('mb_convert_encoding') ) {
		return mb_convert_encoding($utf16, 'UTF-8', 'UTF-16');
	}
	$bytes = (ord($utf16{0}) << 8) | ord($utf16{1});
	switch (true) {
		case ((0x7F & $bytes) == $bytes):
			// this case should never be reached, because we are in ASCII range
			// see: http://www.cl.cam.ac.uk/~mgk25/unicode.html#utf-8
			return chr(0x7F & $bytes);
			
		case (0x07FF & $bytes) == $bytes:

			// return a 2-byte UTF-8 character

			// see: http://www.cl.cam.ac.uk/~mgk25/unicode.html#utf-8

			return chr(0xC0 | (($bytes >> 6) & 0x1F))

				 . chr(0x80 | ($bytes & 0x3F));

		case (0xFFFF & $bytes) == $bytes:
			// return a 3-byte UTF-8 character
			// see: http://www.cl.cam.ac.uk/~mgk25/unicode.html#utf-8

			return chr(0xE0 | (($bytes >> 12) & 0x0F))

				 . chr(0x80 | (($bytes >> 6) & 0x3F))

				 . chr(0x80 | ($bytes & 0x3F));
	}
	// ignoring UTF-32 for now, sorry

	return '';

}



/**

* Function name:	isovn_decodeUnicodeString

* Description : 	Decode Unicode String

* HISTORIES:

* DATE				AUTH			DESCRIPTION

* June 5, 2013		Vinh.le			Decode Unicode String

*/

function isovn_decodeUnicodeString($chrs)

{

	$delim       = substr($chrs, 0, 1);

	$utf8        = '';

	$strlen_chrs = strlen($chrs);



	for($i = 0; $i < $strlen_chrs; $i++) {



		$substr_chrs_c_2 = substr($chrs, $i, 2);

		$ord_chrs_c = ord($chrs[$i]);



		switch (true) {

			case preg_match('/\\\u[0-9A-F]{4}/i', substr($chrs, $i, 6)):

				// single, escaped unicode character

				$utf16 = chr(hexdec(substr($chrs, ($i + 2), 2)))

					   . chr(hexdec(substr($chrs, ($i + 4), 2)));

				$utf8 .= isovn_utf162utf8($utf16);

				$i += 5;

				break;

			case ($ord_chrs_c >= 0x20) && ($ord_chrs_c <= 0x7F):

				$utf8 .= $chrs{$i};

				break;

			case ($ord_chrs_c & 0xE0) == 0xC0:

				// characters U-00000080 - U-000007FF, mask 110XXXXX

				//see http://www.cl.cam.ac.uk/~mgk25/unicode.html#utf-8

				$utf8 .= substr($chrs, $i, 2);

				++$i;

				break;

			case ($ord_chrs_c & 0xF0) == 0xE0:

				// characters U-00000800 - U-0000FFFF, mask 1110XXXX

				// see http://www.cl.cam.ac.uk/~mgk25/unicode.html#utf-8

				$utf8 .= substr($chrs, $i, 3);

				$i += 2;

				break;

			case ($ord_chrs_c & 0xF8) == 0xF0:

				// characters U-00010000 - U-001FFFFF, mask 11110XXX

				// see http://www.cl.cam.ac.uk/~mgk25/unicode.html#utf-8

				$utf8 .= substr($chrs, $i, 4);

				$i += 3;

				break;

			case ($ord_chrs_c & 0xFC) == 0xF8:

				// characters U-00200000 - U-03FFFFFF, mask 111110XX

				// see http://www.cl.cam.ac.uk/~mgk25/unicode.html#utf-8

				$utf8 .= substr($chrs, $i, 5);

				$i += 4;

				break;

			case ($ord_chrs_c & 0xFE) == 0xFC:

				// characters U-04000000 - U-7FFFFFFF, mask 1111110X

				// see http://www.cl.cam.ac.uk/~mgk25/unicode.html#utf-8

				$utf8 .= substr($chrs, $i, 6);

				$i += 5;

				break;

		}

	}



	return str_replace("\/","/",$utf8); 

}



/**

* Function name:	isovn_get_json

* Description : 	get json with unf-8

* HISTORIES:

* DATE				AUTH			DESCRIPTION

* June 5, 2013		Vinh.le			get json with unf-8

*/

function isovn_get_json($data = null){

		$json = json_encode($data); 

		return isovn_decodeUnicodeString($json);

}



/*

the_post_thumbnail();                  // without parameter -> 'post-thumbnail'



the_post_thumbnail('thumbnail');       // Thumbnail (default 150px x 150px max)

the_post_thumbnail('medium');          // Medium resolution (default 300px x 300px max)

the_post_thumbnail('large');           // Large resolution (default 640px x 640px max)

the_post_thumbnail('full');            // Full resolution (original size uploaded)



the_post_thumbnail( array(100,100) );  // Other resolutions

*/

function isovn_get_post_thumbnai( $thumb ='thumbnail' ){

	global $post;

	$src_img = '';

	if (has_post_thumbnail()){ 

		$image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $thumb);

		if(isset($image[0])){

			$src_img = $image[0];

		} else {

			$src_img = get_thumbnail_by_post_content();

		}

	} else{

		$src_img = get_thumbnail_by_post_content();

	}

	return $src_img;

}



function isovn_custom_taxonomies_terms_slug() {

	global $post, $post_id;

	// get post by post id

	$post = &get_post($post->ID);

	// get post type by post

	$post_type = $post->post_type;

	// get post type taxonomies

	$taxonomies = get_object_taxonomies($post_type);

	$return ='';

	foreach ($taxonomies as $taxonomy) {

		// get the terms related to post

		$terms = get_the_terms( $post->ID, $taxonomy );

		if ( !empty( $terms ) ) {

			foreach ( $terms as $term ){

				$return =  $term->slug;

				if($return){

					return $return;

				}

			}

		}

	}

	return $return;

} 

function get_thumbnail_by_post_content(){

	global $post;

	$src_img = '';

	ob_start();

	ob_end_clean();

	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);

	if(isset($matches [1] [0]))

	$src_img = $matches [1] [0];



	if(empty($src_img)){ //Defines a default image

		$src_img = get_bloginfo('template_directory')."/images/no_image.png";

	}

	return $src_img;

}





/**

* Function name:	get_finished_date

* Description : 	get finished date of one become parent demand.

* Params:			int $email_duration

* HISTORIES:

* DATE				AUTH			DESCRIPTION

* June 15, 2013		Ha.Nguyen		Created

*/

function get_finished_date($email_duration)

{

	if(is_int($email_duration) && $email_duration > 0)

	{		

		$gmdate = get_now_in_option_gmt_offset();



		$d = new DateTime($gmdate);

		$d->modify( "+".$email_duration." month" );

		$d->modify( "-1 day" );

		return $d->format( 'Y-m-d H:i:s' );

	}

	

	return null;

}





/**

* Function name:	get_now_in_option_gmt_offset

* Description : 	get current time in offset table wp-option.gmt

* Params:			

* HISTORIES:

* DATE				AUTH			DESCRIPTION

* June 15, 2013		Ha.Nguyen		Created

*/

function get_now_in_option_gmt_offset()

{

	$h = get_option('gmt_offset'); // Hour for time zone goes here e.g. +7 or -4, just remove the + or -

	$hm = $h * 60; 

	$ms = $hm * 60;

	$gmdate = gmdate("Y-m-d H:i:s", time()+($ms)); // the "-" can be switched to a plus if that's what your time zone is.

	

	return $gmdate;

}



function short_the_title($title, $chars = 30){

	if(strlen($title) > $chars){

		$title = $title." ";

		$title = substr($title,0,$chars);

		$title = substr($title,0,strrpos($title,' '));

		$title = $title."...";

	}

	return $title;

}

/**

 ~~~~~~~~~~~~ UTIL COMMON FUNCTIONS ~~~~~~~~~~~~

 */

 

 

	function ajax_seach_post(){

		 global $wpdb;



    $search = like_escape($_POST['q']);

    $query = 'SELECT ID,post_title, post_content FROM ' . $wpdb->posts . '

        WHERE post_title LIKE \'%' . $search . '%\'

        AND post_type = \'game\'

        AND post_status = \'publish\'

        ORDER BY post_title ASC';

		$results = array();

		$i=0;

		foreach ($wpdb->get_results($query) as $row) {

			$results[$i]['title'] = $row->post_title;

			$results[$i]['href'] = get_permalink($row->ID);

			$results[$i]['src'] = leeproOptions::get_thumbnail_by_post_id($row->ID);

			$results[$i]['content'] = leeproOptions::lee_pro_limit_content($row->post_content, 50);

			$results[$i]['views'] = 0;

			$views = get_post_meta($row->ID,'views',true);

			$results[$i]['views'] = ($views>0) ? $views : 0;

			//$meta = get_post_meta($id, 'YOUR_METANAME', TRUE);

			$i++;

		}

		die(isovn_get_json($results));

	}

	add_action( 'wp_ajax_ajax_seach_post', 'ajax_seach_post' );

	add_action( 'wp_ajax_nopriv_ajax_seach_post', 'ajax_seach_post' );

	

/* Set status order */

function leepro_curPageURL() {

	$pageURL = 'http';

	if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {$pageURL .= "s";}

	$pageURL .= "://";

	if ($_SERVER["SERVER_PORT"] != "80") {

	$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];

	} else {

	$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

	}

	return $pageURL;

}



function getDomain_website($url = null){

	$url = leepro_curPageURL();

	if(filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED) === FALSE)

	{

	return false;

	}

	/*** get the url parts ***/

	$parts = parse_url($url);

	/*** return the host domain ***/

	return $parts['scheme'].'://'.$parts['host'];

}



	function leepro_getWeb_Root($url = null){

		$url = leepro_curPageURL();

		if(filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED) === FALSE)

		{

		return false;

		}

		/*** get the url parts ***/

		$parts = parse_url($url);

		/*** return the host domain ***/

		return $parts['scheme'].'://'.$parts['host'].$parts['path'];

	}



function leepro_detect_browser(){

	global $mobile_browser;

	$status = '';	

	$user_agent = $_SERVER['HTTP_USER_AGENT']; /* get the user agent value */

	$accept = $_SERVER['HTTP_ACCEPT']; /* get the content accept value */

	$args_platform;

	$args_platform = array(

			'ipad_platform' 	=> 'Apple iPad',

			'iphone_platform' 	=> 'Apple iphone',

			'android_platform' 	=> 'Android',

			'opera_mini_platform' 	=> 'Opera',

			'blackberry_platform' => 'Blackberry',

			'parm_os_platform' 	=> 'Palm',

			'windows_platform' 	=> 'Windows Smartphone',

			'default_browser'	=> 'Theme default in wordpress',

			'other_platform'	=> 'Other platform of mobi'

		);

	switch(true){ /* using a switch against the following statements which could return true is more efficient than the previous method of using if statements */



		case (preg_match('/ipad/i',$user_agent)); /* we find the word ipad in the user agent */

		  $mobile_browser = get_option('ipad_platform'); /* mobile browser is ipad */

		  $status = 'Apple iPad';      

		break; // break out and skip the rest if we've had a match on the ipad */



		case (preg_match('/ipod/i',$user_agent)||preg_match('/iphone/i',$user_agent)); /* we find the words iphone or ipod in the user agent */

		  $mobile_browser = ('iphone_platform'); /* mobile browser is iphone/ ipod */

		  $status = 'Apple iphone';      

		break; /*  break out and skip the rest if we've had a match on the iphone or ipod */



		case (preg_match('/android/i',$user_agent));  /* we find android in the user agent */

		  $mobile_browser = ('android_platform'); /*  mobile browser is android */

		  $status = 'Android';      

		break; // break out and skip the rest if we've had a match on android



		case (preg_match('/opera mini/i',$user_agent)); /* we find opera mini in the user agent */

		  $mobile_browser = ('opera_mini_platform'); /* mobile browser is opera mini */

		  $status = 'Opera';      

		break; // break out and skip the rest if we've had a match on opera



		case (preg_match('/blackberry/i',$user_agent)); // we find blackberry in the user agent

		  $mobile_browser = ('blackberry_platform'); // mobile browser is blackberry */

		  $status = 'Blackberry';      

		break; // break out and skip the rest if we've had a match on blackberry



		case (preg_match('/(pre\/|palm os|palm|hiptop|avantgo|plucker|xiino|blazer|elaine)/i',$user_agent)); // we find palm os in the user agent - the i at the end makes it case insensitive

		  $mobile_browser = ('parm_os_platform'); // mobile browser is either true or false depending on the setting of palm when calling the function

		  $status = 'Palm';      

		break; // break out and skip the rest if we've had a match on palm os



		case (preg_match('/(iris|3g_t|windows ce|opera mobi|windows ce; smartphone;|windows ce; iemobile)/i',$user_agent)); // we find windows mobile in the user agent - the i at the end makes it case insensitive

		  $mobile_browser = ('windows_platform'); // mobile browser is windows phone */

		  $status = 'Windows Smartphone';      

		break; // break out and skip the rest if we've had a match on windows



		case (preg_match('/(mini 9.5|vx1000|lge |m800|e860|u940|ux840|compal|wireless| mobi|ahong|lg380|lgku|lgu900|lg210|lg47|lg920|lg840|lg370|sam-r|mg50|s55|g83|t66|vx400|mk99|d615|d763|el370|sl900|mp500|samu3|samu4|vx10|xda_|samu5|samu6|samu7|samu9|a615|b832|m881|s920|n210|s700|c-810|_h797|mob-x|sk16d|848b|mowser|s580|r800|471x|v120|rim8|c500foma:|160x|x160|480x|x640|t503|w839|i250|sprint|w398samr810|m5252|c7100|mt126|x225|s5330|s820|htil-g1|fly v71|s302|-x113|novarra|k610i|-three|8325rc|8352rc|sanyo|vx54|c888|nx250|n120|mtk |c5588|s710|t880|c5005|i;458x|p404i|s210|c5100|teleca|s940|c500|s590|foma|samsu|vx8|vx9|a1000|_mms|myx|a700|gu1100|bc831|e300|ems100|me701|me702m-three|sd588|s800|8325rc|ac831|mw200|brew |d88|htc\/|htc_touch|355x|m50|km100|d736|p-9521|telco|sl74|ktouch|m4u\/|me702|8325rc|kddi|phone|lg |sonyericsson|samsung|240x|x320|vx10|nokia|sony cmd|motorola|up.browser|up.link|mmp|symbian|smartphone|midp|wap|vodafone|o2|pocket|kindle|mobile|psp|treo)/i',$user_agent)); // check if any of the values listed create a match on the user agent - these are some of the most common terms used in agents to identify them as being mobile devices - the i at the end makes it case insensitive

		  $mobile_browser = ('other_platform'); // set mobile browser to true

		  $status = 'Mobile matched on piped preg_match';

		break; // break out and skip the rest if we've preg_match on the user agent returned true 



		case ((strpos($accept,'text/vnd.wap.wml')>0)||(strpos($accept,'application/vnd.wap.xhtml+xml')>0)); // is the device showing signs of support for text/vnd.wap.wml or application/vnd.wap.xhtml+xml

		  $mobile_browser = ('other_platform'); // set mobile browser to true

		  $status = 'Mobile matched on content accept header';

		break; // break out and skip the rest if we've had a match on the content accept headers



		case (isset($_SERVER['HTTP_X_WAP_PROFILE'])||isset($_SERVER['HTTP_PROFILE'])); // is the device giving us a HTTP_X_WAP_PROFILE or HTTP_PROFILE header - only mobile devices would do this

		  $mobile_browser = ('other_platform'); // set mobile browser to true

		  $status = 'Mobile matched on profile headers being set';

		break; // break out and skip the final step if we've had a return true on the mobile specfic headers



		case (in_array(strtolower(substr($user_agent,0,4)),array('1207'=>'1207','3gso'=>'3gso','4thp'=>'4thp','501i'=>'501i','502i'=>'502i','503i'=>'503i','504i'=>'504i','505i'=>'505i','506i'=>'506i','6310'=>'6310','6590'=>'6590','770s'=>'770s','802s'=>'802s','a wa'=>'a wa','acer'=>'acer','acs-'=>'acs-','airn'=>'airn','alav'=>'alav','asus'=>'asus','attw'=>'attw','au-m'=>'au-m','aur '=>'aur ','aus '=>'aus ','abac'=>'abac','acoo'=>'acoo','aiko'=>'aiko','alco'=>'alco','alca'=>'alca','amoi'=>'amoi','anex'=>'anex','anny'=>'anny','anyw'=>'anyw','aptu'=>'aptu','arch'=>'arch','argo'=>'argo','bell'=>'bell','bird'=>'bird','bw-n'=>'bw-n','bw-u'=>'bw-u','beck'=>'beck','benq'=>'benq','bilb'=>'bilb','blac'=>'blac','c55/'=>'c55/','cdm-'=>'cdm-','chtm'=>'chtm','capi'=>'capi','cond'=>'cond','craw'=>'craw','dall'=>'dall','dbte'=>'dbte','dc-s'=>'dc-s','dica'=>'dica','ds-d'=>'ds-d','ds12'=>'ds12','dait'=>'dait','devi'=>'devi','dmob'=>'dmob','doco'=>'doco','dopo'=>'dopo','el49'=>'el49','erk0'=>'erk0','esl8'=>'esl8','ez40'=>'ez40','ez60'=>'ez60','ez70'=>'ez70','ezos'=>'ezos','ezze'=>'ezze','elai'=>'elai','emul'=>'emul','eric'=>'eric','ezwa'=>'ezwa','fake'=>'fake','fly-'=>'fly-','fly_'=>'fly_','g-mo'=>'g-mo','g1 u'=>'g1 u','g560'=>'g560','gf-5'=>'gf-5','grun'=>'grun','gene'=>'gene','go.w'=>'go.w','good'=>'good','grad'=>'grad','hcit'=>'hcit','hd-m'=>'hd-m','hd-p'=>'hd-p','hd-t'=>'hd-t','hei-'=>'hei-','hp i'=>'hp i','hpip'=>'hpip','hs-c'=>'hs-c','htc '=>'htc ','htc-'=>'htc-','htca'=>'htca','htcg'=>'htcg','htcp'=>'htcp','htcs'=>'htcs','htct'=>'htct','htc_'=>'htc_','haie'=>'haie','hita'=>'hita','huaw'=>'huaw','hutc'=>'hutc','i-20'=>'i-20','i-go'=>'i-go','i-ma'=>'i-ma','i230'=>'i230','iac'=>'iac','iac-'=>'iac-','iac/'=>'iac/','ig01'=>'ig01','im1k'=>'im1k','inno'=>'inno','iris'=>'iris','jata'=>'jata','java'=>'java','kddi'=>'kddi','kgt'=>'kgt','kgt/'=>'kgt/','kpt '=>'kpt ','kwc-'=>'kwc-','klon'=>'klon','lexi'=>'lexi','lg g'=>'lg g','lg-a'=>'lg-a','lg-b'=>'lg-b','lg-c'=>'lg-c','lg-d'=>'lg-d','lg-f'=>'lg-f','lg-g'=>'lg-g','lg-k'=>'lg-k','lg-l'=>'lg-l','lg-m'=>'lg-m','lg-o'=>'lg-o','lg-p'=>'lg-p','lg-s'=>'lg-s','lg-t'=>'lg-t','lg-u'=>'lg-u','lg-w'=>'lg-w','lg/k'=>'lg/k','lg/l'=>'lg/l','lg/u'=>'lg/u','lg50'=>'lg50','lg54'=>'lg54','lge-'=>'lge-','lge/'=>'lge/','lynx'=>'lynx','leno'=>'leno','m1-w'=>'m1-w','m3ga'=>'m3ga','m50/'=>'m50/','maui'=>'maui','mc01'=>'mc01','mc21'=>'mc21','mcca'=>'mcca','medi'=>'medi','meri'=>'meri','mio8'=>'mio8','mioa'=>'mioa','mo01'=>'mo01','mo02'=>'mo02','mode'=>'mode','modo'=>'modo','mot '=>'mot ','mot-'=>'mot-','mt50'=>'mt50','mtp1'=>'mtp1','mtv '=>'mtv ','mate'=>'mate','maxo'=>'maxo','merc'=>'merc','mits'=>'mits','mobi'=>'mobi','motv'=>'motv','mozz'=>'mozz','n100'=>'n100','n101'=>'n101','n102'=>'n102','n202'=>'n202','n203'=>'n203','n300'=>'n300','n302'=>'n302','n500'=>'n500','n502'=>'n502','n505'=>'n505','n700'=>'n700','n701'=>'n701','n710'=>'n710','nec-'=>'nec-','nem-'=>'nem-','newg'=>'newg','neon'=>'neon','netf'=>'netf','noki'=>'noki','nzph'=>'nzph','o2 x'=>'o2 x','o2-x'=>'o2-x','opwv'=>'opwv','owg1'=>'owg1','opti'=>'opti','oran'=>'oran','p800'=>'p800','pand'=>'pand','pg-1'=>'pg-1','pg-2'=>'pg-2','pg-3'=>'pg-3','pg-6'=>'pg-6','pg-8'=>'pg-8','pg-c'=>'pg-c','pg13'=>'pg13','phil'=>'phil','pn-2'=>'pn-2','pt-g'=>'pt-g','palm'=>'palm','pana'=>'pana','pire'=>'pire','pock'=>'pock','pose'=>'pose','psio'=>'psio','qa-a'=>'qa-a','qc-2'=>'qc-2','qc-3'=>'qc-3','qc-5'=>'qc-5','qc-7'=>'qc-7','qc07'=>'qc07','qc12'=>'qc12','qc21'=>'qc21','qc32'=>'qc32','qc60'=>'qc60','qci-'=>'qci-','qwap'=>'qwap','qtek'=>'qtek','r380'=>'r380','r600'=>'r600','raks'=>'raks','rim9'=>'rim9','rove'=>'rove','s55/'=>'s55/','sage'=>'sage','sams'=>'sams','sc01'=>'sc01','sch-'=>'sch-','scp-'=>'scp-','sdk/'=>'sdk/','se47'=>'se47','sec-'=>'sec-','sec0'=>'sec0','sec1'=>'sec1','semc'=>'semc','sgh-'=>'sgh-','shar'=>'shar','sie-'=>'sie-','sk-0'=>'sk-0','sl45'=>'sl45','slid'=>'slid','smb3'=>'smb3','smt5'=>'smt5','sp01'=>'sp01','sph-'=>'sph-','spv '=>'spv ','spv-'=>'spv-','sy01'=>'sy01','samm'=>'samm','sany'=>'sany','sava'=>'sava','scoo'=>'scoo','send'=>'send','siem'=>'siem','smar'=>'smar','smit'=>'smit','soft'=>'soft','sony'=>'sony','t-mo'=>'t-mo','t218'=>'t218','t250'=>'t250','t600'=>'t600','t610'=>'t610','t618'=>'t618','tcl-'=>'tcl-','tdg-'=>'tdg-','telm'=>'telm','tim-'=>'tim-','ts70'=>'ts70','tsm-'=>'tsm-','tsm3'=>'tsm3','tsm5'=>'tsm5','tx-9'=>'tx-9','tagt'=>'tagt','talk'=>'talk','teli'=>'teli','topl'=>'topl','hiba'=>'hiba','up.b'=>'up.b','upg1'=>'upg1','utst'=>'utst','v400'=>'v400','v750'=>'v750','veri'=>'veri','vk-v'=>'vk-v','vk40'=>'vk40','vk50'=>'vk50','vk52'=>'vk52','vk53'=>'vk53','vm40'=>'vm40','vx98'=>'vx98','virg'=>'virg','vite'=>'vite','voda'=>'voda','vulc'=>'vulc','w3c '=>'w3c ','w3c-'=>'w3c-','wapj'=>'wapj','wapp'=>'wapp','wapu'=>'wapu','wapm'=>'wapm','wig '=>'wig ','wapi'=>'wapi','wapr'=>'wapr','wapv'=>'wapv','wapy'=>'wapy','wapa'=>'wapa','waps'=>'waps','wapt'=>'wapt','winc'=>'winc','winw'=>'winw','wonu'=>'wonu','x700'=>'x700','xda2'=>'xda2','xdag'=>'xdag','yas-'=>'yas-','your'=>'your','zte-'=>'zte-','zeto'=>'zeto','acs-'=>'acs-','alav'=>'alav','alca'=>'alca','amoi'=>'amoi','aste'=>'aste','audi'=>'audi','avan'=>'avan','benq'=>'benq','bird'=>'bird','blac'=>'blac','blaz'=>'blaz','brew'=>'brew','brvw'=>'brvw','bumb'=>'bumb','ccwa'=>'ccwa','cell'=>'cell','cldc'=>'cldc','cmd-'=>'cmd-','dang'=>'dang','doco'=>'doco','eml2'=>'eml2','eric'=>'eric','fetc'=>'fetc','hipt'=>'hipt','http'=>'http','ibro'=>'ibro','idea'=>'idea','ikom'=>'ikom','inno'=>'inno','ipaq'=>'ipaq','jbro'=>'jbro','jemu'=>'jemu','java'=>'java','jigs'=>'jigs','kddi'=>'kddi','keji'=>'keji','kyoc'=>'kyoc','kyok'=>'kyok','leno'=>'leno','lg-c'=>'lg-c','lg-d'=>'lg-d','lg-g'=>'lg-g','lge-'=>'lge-','libw'=>'libw','m-cr'=>'m-cr','maui'=>'maui','maxo'=>'maxo','midp'=>'midp','mits'=>'mits','mmef'=>'mmef','mobi'=>'mobi','mot-'=>'mot-','moto'=>'moto','mwbp'=>'mwbp','mywa'=>'mywa','nec-'=>'nec-','newt'=>'newt','nok6'=>'nok6','noki'=>'noki','o2im'=>'o2im','opwv'=>'opwv','palm'=>'palm','pana'=>'pana','pant'=>'pant','pdxg'=>'pdxg','phil'=>'phil','play'=>'play','pluc'=>'pluc','port'=>'port','prox'=>'prox','qtek'=>'qtek','qwap'=>'qwap','rozo'=>'rozo','sage'=>'sage','sama'=>'sama','sams'=>'sams','sany'=>'sany','sch-'=>'sch-','sec-'=>'sec-','send'=>'send','seri'=>'seri','sgh-'=>'sgh-','shar'=>'shar','sie-'=>'sie-','siem'=>'siem','smal'=>'smal','smar'=>'smar','sony'=>'sony','sph-'=>'sph-','symb'=>'symb','t-mo'=>'t-mo','teli'=>'teli','tim-'=>'tim-','tosh'=>'tosh','treo'=>'treo','tsm-'=>'tsm-','upg1'=>'upg1','upsi'=>'upsi','vk-v'=>'vk-v','voda'=>'voda','vx52'=>'vx52','vx53'=>'vx53','vx60'=>'vx60','vx61'=>'vx61','vx70'=>'vx70','vx80'=>'vx80','vx81'=>'vx81','vx83'=>'vx83','vx85'=>'vx85','wap-'=>'wap-','wapa'=>'wapa','wapi'=>'wapi','wapp'=>'wapp','wapr'=>'wapr','webc'=>'webc','whit'=>'whit','winw'=>'winw','wmlb'=>'wmlb','xda-'=>'xda-',))); // check against a list of trimmed user agents to see if we find a match

		  $mobile_browser = ('other_platform'); // set mobile browser to true

		  $status = 'Mobile matched on in_array';

		break; // break even though it's the last statement in the switch so there's nothing to break away from but it seems better to include it than exclude it

		default:

			$mobile_browser = ('default_platform');

			$status = 'Theme default in wordpress';

			break;

	} // ends the switch 



  return $mobile_browser;



}

function htx_custom_logo() {

echo '

<style type="text/css">



#wpadminbar #wp-admin-bar-wp-logo.hover > .ab-item .ab-icon {

	background-position: 0 0;

	}	



</style>

';

}





add_action("login_head", "my_login_head");

function my_login_head() {

	echo "

	<style>

	body.login{

		background: url('".get_bloginfo('template_url')."/images/bg.jpg') repeat scroll center top transparent;

		display: block;

		min-height: 500px;

		overflow: hidden;

	}

	

	.login #nav a, .login #backtoblog a, .login label {

		color: #000!important;

	}

	body.login #login h1 a {

		background: url('".get_bloginfo('template_url')."/images/logo.png') no-repeat scroll center 0px transparent;

		 height: 85px;

		margin-top: 45px;

		width: 319px;

	}



	body.login #login h1 a:hover {

		background: url('".get_bloginfo('template_url')."/images/logo.png') no-repeat scroll center 0 transparent;

		 height: 85px;

		margin-top: 45px;

		width: 319px;

	}

	html body.login div#login p#backtoblog a{color:#000!important;}

	.login form{

		background: #fff;

	}



	.login label{

		color:#fff;

	}

	.login #nav a, .login #backtoblog a{

		color:#000!important;

		 font-size: 1.2em;

	}

	html body.login div#login{

		padding-top:50px;

	}

	</style>

	";

}

function my_login_logo_url() {

    return get_bloginfo( 'url' );

}

add_filter( 'login_headerurl', 'my_login_logo_url' );



function my_login_logo_url_title() {

    return get_bloginfo('name');

}

add_filter( 'login_headertitle', 'my_login_logo_url_title' );

/* Process cart */

function addToCart($id){  
	global $session_cart, $messenge_order ;  
	if(isset($_SESSION[$session_cart][$id])){
			$qty = $_SESSION[$session_cart][$id] + 1;
			 $messenge_order = 'Sản phẩm được cập nhật thêm vào giỏ hàng';
	  }else{
		$qty=1;
		 $messenge_order = 'Sản phẩm được thêm vào giỏ hàng';
	  }
	  $_SESSION[$session_cart][$id]=$qty;
}

/**
 *  Add prodcut vào cart => qty
 */
function addToCartQty($id, $qty_new){
	global $session_cart,$messenge_order;  
	if(isset($_SESSION[$session_cart][$id])){
		if(check_quanty($qty_new)){
			$qty = $_SESSION[$session_cart][$id] + $qty_new;
		}
		
	}else{
		$qty = (int)$qty_new;
	}
	$_SESSION[$session_cart][$id]=$qty;
}
/**
 *   Update số lượng các product trong cart
 */
function updateCart($cart){
	global $session_cart,$messenge_order;
	if($cart){
		foreach($cart as $key=>$value){
		  if( ($value == 0) and (is_numeric($value))){ 
		   unset($_SESSION[$session_cart][$key]);
		  }else if($value > 0 && is_numeric($value)){ 
		   $_SESSION[$session_cart][$key]=$value;
		  }
		}
		$messenge_order = 'Sản phẩm được cập nhật vào giỏ hàng';
	} else{
		$messenge_order = '';
	}
	
}

/**
 *   Xóa product trong cart theo id
 */
function delCartByID($id){
	global $session_cart,$messenge_order;
    unset($_SESSION[$session_cart][$id]);  
	$messenge_order = 'Sản phẩm được xoá khỏi giỏ hàng';	
}

/**
 *   Xóa bỏ cart
 */
function delAllCart(){
	global $session_cart;
    unset($_SESSION[$session_cart]);
}
function check_quanty($qty){
	if(!is_numeric($qty)){
		return false;
	} else if(is_numeric($qty) && ($qty<=0)){
		return false;
	} else{
		return true;
	}
}
function check_validate($data_order = null){
	global $messenge_check_out;
	$messenge_check_out ='';
	if(trim($data_order['customer_name']) == ''){
		$messenge_check_out .= '&nbsp;&nbsp;- Nhập tên khách hàng<br/>';
	}
	if(trim($data_order['customer_adress']) == ''){
		$messenge_check_out .= '&nbsp;&nbsp;- Nhập địa chỉ khách hàng<br/>';
	}
	if(trim($data_order['customer_email']) == ''){
		$messenge_check_out .= '&nbsp;&nbsp;- Nhập email khách hàng<br/>';
	} 
	else if(!preg_match("/^([0-9A-Za-z._\-]+)@([0-9A-Za-z._\-]+)\.([0-9A-Za-z._\-]+)$/",$data_order['customer_email']) ) {
		$messenge_check_out .= '&nbsp;&nbsp;- Email khách hàng không hợp lệ<br/>';
	}
	if(trim($data_order['customer_phone']) == ''){
		$messenge_check_out .= '&nbsp;&nbsp;- Nhập số điện thoại khách hàng<br/>';
	}
	if(trim($messenge_check_out) == ''){
		return true;
	} else{
		return false;
	}
}
add_action( 'wp_ajax_nopriv_ajax_add_to_cart', 'ajax_add_to_cart' );  
add_action( 'wp_ajax_ajax_add_to_cart', 'ajax_add_to_cart' );
function ajax_add_to_cart(){
	$results = array();
	$results['status'] = 'false';
	$results['message'] = 'Đàn xữ lý đơn hàng';
	if(isset($_POST['id']) && isset($_POST['qty'])){
		addToCartQty(intval($_POST['id']),$_POST['qty']);
		$results['status'] = 'true';
		$results['message'] = 'Thêm sản phẩm thành công. Hệ thống sẽ chuyển đến giỏ hàng...';
	}
	die(isovn_get_json($results));
}


add_action( 'wp_ajax_nopriv_ajax_update_all_cart', 'ajax_update_all_cart' );  
add_action( 'wp_ajax_ajax_update_all_cart', 'ajax_update_all_cart' );	
function ajax_update_all_cart(){
	global $session_cart;
	$results = array();
	$results['message'] = 'Đang cập nhật đơn hàng.';
	$results['status'] = 'false';
	$data = array();
	if(isset($_POST['dataForm'])){
		parse_str($_POST['dataForm'], $data);
		if($data['qty']){
			updateCart($data['qty']);
			$results['status'] = 'true';
			$results['message'] = 'Cập nhật thành công.';
		} else {
			$results['message'] = 'Cập nhật không thành công.';
		}
	}
	die(isovn_get_json($results));
}

add_action( 'wp_ajax_nopriv_ajax_delete_all_cart', 'ajax_delete_all_cart' );  
add_action( 'wp_ajax_ajax_delete_all_cart', 'ajax_delete_all_cart' );	
function ajax_delete_all_cart(){
	global $session_cart;
	$results = array();
	$results['message'] = 'Đang xử lý đơn hàng';
	$results['status'] = 'true';
	delAllCart();
	$results['message'] = 'Xóa sản phẩm thành công.';
	if(count($_SESSION[$session_cart])<=0){
		$results['message'] .= ' Giỏ hàng rỗng, Hệ thống sẽ tự động chuyển về trang chủ.';
		$results['refresh'] = 'true';
	}
	die(isovn_get_json($results));
}

add_action( 'wp_ajax_nopriv_ajax_load_order', 'ajax_load_order' );  
add_action( 'wp_ajax_ajax_load_order', 'ajax_load_order' );	
function ajax_load_order(){
	global $session_cart;
	$results = array();
	$results['num'] = 0;
	$results['status'] = 'false';
	if(count($_SESSION[$session_cart])>0){
		$results['status'] = 'true';
		$results['num'] = count($_SESSION[$session_cart]);
	}
	die(isovn_get_json($results));
}

add_action( 'wp_ajax_nopriv_ajax_delete_cart', 'ajax_delete_cart' );  
add_action( 'wp_ajax_ajax_delete_cart', 'ajax_delete_cart' );	
function ajax_delete_cart(){
	global $session_cart;
	$results = array();
	$results['status'] = 'false';
	$results['refresh'] = 'false';
	$results['message'] = 'Đang xử lý đơn hàng';
	if(isset($_POST['id']) && intval($_POST['id'])>0){
		delCartByID(intval($_POST['id']));
		$results['status'] = 'true';
		$results['message'] = 'Xóa sản phẩm thành công.';
		if(count($_SESSION[$session_cart])<=0){
			$results['message'] .= ' Giỏ hàng rỗng, Hệ thống sẽ tự động chuyển về trang chủ.';
			$results['refresh'] = 'true';
		}
	}
	die(isovn_get_json($results));
}
add_action( 'wp_ajax_nopriv_ajax_order_send_mailer', 'ajax_order_send_mailer' );  
add_action( 'wp_ajax_ajax_order_send_mailer', 'ajax_order_send_mailer' );	
function ajax_order_send_mailer(){
	global $session_cart;
	$results = array();
	$results['status'] = 'false';
	$results['message'] = 'Đang xử lý đơn hàng';
	$options = isovn_get_option_theme();
	$data = array();
	if(isset($_POST['dataForm'])){
		parse_str($_POST['dataForm'], $data);
	}
	if(isset($data['customer_name']) && isset($data['customer_email'])){
		if(check_validate($data)){
			if($options['info_email']){
				$to = trim($options['info_email']);
			}
			else{
				$to = get_bloginfo('email');
			}
			$taxonomy_name = 'chuyen-muc-san-pham';
			$message ='';
			$subject = 'Thông tin đặt hàng từ website '.get_bloginfo('url');
			$message .= '<table width="600" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td align="left" valign="top" style="padding:5px;margin:5px">
			  <table width="590" cellspacing="0" cellpadding="0" border="0">
				<tbody><tr>
				  <td align="left" width="28%" valign="top"><a target="_blank" href="'.get_bloginfo('home').'"><img width="145" alt="Kiên - Hưng - An" height="60" border="0" src="'.get_bloginfo('template_directory').'/images/logo.png"></a></td>
				  <td align="center" width="72%" valign="middle" nowrap="" style="font-size:17px;color:#c40000;font-weight:bold;font-family:Arial,Helvetica,sans-serif">'.get_bloginfo('name').' - Xác nhận đơn hàng <span style="font-family:Georgia,\'Times New Roman\',Times,serif">&nbsp;</span></td>
				</tr>
				<tr>
				  <td align="left" valign="top" colspan="2"><div style="margin-top:10px;color:rgb(102,102,102);font-weight:normal;line-height:22px"> <span>Chúc mừng bạn đã dặt thành công sản phẩm dịch vụ tại <a target="_blank" style="text-decoration:none;color:rgb(19,130,224)" href="'.get_bloginfo('url').'">'.get_bloginfo('url').'</a>.&nbsp;</span> Chúng tôi sẽ liên lạc lại với bạn trong thời gian sớm nhất.</div></td>
				</tr>
			  </tbody>
			 </table>
			  <table width="590" cellspacing="4" cellpadding="0" border="0">
				<tbody><tr>
				  <td align="left" nowrap="" style="font-size:17px;font-weight:bold;font-family:Arial,Helvetica,sans-serif;color:rgb(254,144,1)" colspan="2">Chi tiết đơn hàng</td>
				</tr>
				<tr>
				  <td align="right" width="150" nowrap="" style="color:#666;padding-left:15px">Ngày đặt hàng:</td>
				  <td align="left" style="font-size:12px;font-weight:normal;font-family:Arial,Helvetica,sans-serif">'.date("d/m/Y h:i:s").'</td>
				</tr>
				<tr>
				  <td align="right" width="150" nowrap="" style="color:#666">Ghi chú:</td>
				  <td align="left" style="font-size:12px;font-family:Arial,Helvetica,sans-serif">';
					if($data['customer_note']){ $message .= $data['customer_note'];} else{ $message .= 'Không có thông tin ghi chú';}
				$message .= '</td>
				</tr>
				  </tbody>
			</table>
			  <table width="590" cellspacing="0" cellpadding="0" border="0" style="BORDER-RIGHT:#b1d1e6 1px solid;BORDER-TOP:#b1d1e6 1px solid;TEXT-DECORATION:none;background-color:#ecffd8;width:100%;font-family:Arial,Helvetica,sans-serif;width:590px">
				<tbody>
				  <tr>
					<th align="center" width="20" style="PADDING-RIGHT:6px;PADDING-LEFT:6px;PADDING-BOTTOM:6px;PADDING-TOP:6px;font-weight:bold;font-size:12px;BORDER-BOTTOM:#b1d1e6 1px solid;BORDER-LEFT:#b1d1e6 1px solid;color:#07519a">STT</th>
					<th align="center" width="90" nowrap="" style="PADDING-RIGHT:6px;PADDING-LEFT:6px;PADDING-BOTTOM:6px;PADDING-TOP:6px;font-weight:bold;font-size:12px;BORDER-BOTTOM:#b1d1e6 1px solid;BORDER-LEFT:#b1d1e6 1px solid;color:#07519a">Hình ảnh</th>
					<th align="center" width="320" style="PADDING-RIGHT:6px;PADDING-LEFT:6px;PADDING-BOTTOM:6px;PADDING-TOP:6px;font-weight:bold;font-size:12px;BORDER-BOTTOM:#b1d1e6 1px solid;BORDER-LEFT:#b1d1e6 1px solid;color:#07519a">Sản Phẩm</th>
					<th align="center" width="20" style="PADDING-RIGHT:6px;PADDING-LEFT:6px;PADDING-BOTTOM:6px;PADDING-TOP:6px;font-weight:bold;font-size:12px;BORDER-BOTTOM:#b1d1e6 1px solid;BORDER-LEFT:#b1d1e6 1px solid;color:#07519a">SL</th>
				  </tr>';
				  $i = 0;
				  $count_pro = 0;
				 foreach($_SESSION[$session_cart] as $id => $num){
				$item_product = get_post($id);
					if($item_product){
						$count_pro += $num;
						$i ++;
						if(get_the_post_thumbnail($item_product->ID,'thumbnail') != ''){
							$domsxe = simplexml_load_string(get_the_post_thumbnail($item_product->ID,'thumbnail'));
							$thumbnailsrc = $domsxe->attributes()->src;
						} else{
							$thumbnailsrc =get_bloginfo('template_directory').'/images/no_image.png';
						}	
						$price = get_post_meta( $item_product->ID, 'ecpt_gia', true );
						if(is_numeric($price) && $price>0){
							$price = number_format($price,0,'.','.').'VNĐ';
						} else {
							$price = 'Liên hệ';
						}						
					  $message .= '<tr bgcolor="#FFFFFF">
								<td align="center" style="PADDING-RIGHT:6px;PADDING-LEFT:6px;PADDING-BOTTOM:6px;PADDING-TOP:6px;BORDER-BOTTOM:#b1d1e6 1px solid;BORDER-LEFT:#b1d1e6 1px solid">'. $i.'</td>
								<td align="center" style="PADDING-RIGHT:6px;PADDING-LEFT:6px;PADDING-BOTTOM:6px;PADDING-TOP:6px;BORDER-BOTTOM:#b1d1e6 1px solid;BORDER-LEFT:#b1d1e6 1px solid;font-family:Arial;font-size:12px"><a href="'.get_permalink($item_product->ID).'"><img alt="'.$item_product->post_title.'" src="'.$thumbnailsrc.'" width="60" height="60"/></a></td>
								<td align="left" style="PADDING-RIGHT:6px;PADDING-LEFT:6px;PADDING-BOTTOM:6px;PADDING-TOP:6px;BORDER-BOTTOM:#b1d1e6 1px solid;BORDER-LEFT:#b1d1e6 1px solid;font-family:Arial;font-size:12px"><a href="'.get_permalink($item_product->ID).'">'.$item_product->post_title.'</a><p>Giá : '.$price.'</p><p>';
									/*$tax_terms = get_the_terms($item_product->ID, $taxonomy_name); 
									$count_term = count($tax_terms);
									if($count_term>0){
										$k =1;
										foreach($tax_terms as $set_tax_term){
											$message  .= '<a href="'.get_term_link( $set_tax_term->slug, $taxonomy_name ) .'">'.$set_tax_term->name.'</a>';
											if($k<$count_term)
												$message  .= ', ';
											$k++;
										}
									} */
							$message .= '</p>	</td>
								<td align="center" style="PADDING-RIGHT:6px;PADDING-LEFT:6px;PADDING-BOTTOM:6px;PADDING-TOP:6px;BORDER-BOTTOM:#b1d1e6 1px solid;BORDER-LEFT:#b1d1e6 1px solid;font-family:Arial;font-size:12px">'.$num.'</td>
							  </tr>';
					  }
				  }
				  $message .='
				  <tr>
					<td align="right" style="PADDING-RIGHT:6px;PADDING-LEFT:6px;PADDING-BOTTOM:6px;PADDING-TOP:6px;BORDER-BOTTOM:#b1d1e6 1px solid;BORDER-LEFT:#b1d1e6 1px solid" colspan="5"><div style="line-height:18px;font-size:12px">
						 
						Tổng số sản phẩm: <span style="font-family:Georgia,\'Times New Roman\',Times,serif;font-weight:bold;font-size:15px;color:#c40000">'.$count_pro.'</span></div></td>
				  </tr>
				</tbody>
			  </table>
			  <table width="590" cellspacing="4" cellpadding="0" border="0">
				<tbody><tr>
				  <td align="left" nowrap="" style="font-size:17px;font-weight:bold;font-family:Arial,Helvetica,sans-serif;color:rgb(254,144,1)" colspan="2">Thông tin khách hàng</td>
				</tr>
				<tr>
				  <td align="right" nowrap="" style="color:#666">Khách hàng:</td>
				  <td align="left">'.$data['customer_name'].'</td>
				</tr>
				<tr>
				  <td align="right" nowrap="" style="color:#666">Địa chỉ:</td>
				  <td align="left">'.$data['customer_adress'].'</td>
				</tr>
				<tr>
				  <td align="right" nowrap="" style="color:#666">Email:</td>
				  <td align="left">'.$data['customer_email'].'</td>
				</tr>
				<tr>
				  <td align="right" nowrap="" style="color:#666">Điện thoại:</td>
				  <td align="left">'.$data['customer_phone'].'</td>
				</tr>
			  </tbody></table>
			  <table width="590" cellspacing="4" cellpadding="0" border="0">
				<tbody><tr>
				  <td align="left" nowrap="" style="font-size:17px;font-weight:bold;font-family:Arial,Helvetica,sans-serif;color:rgb(254,144,1)">Thông tin liên hệ</td>
				</tr>
				<tr>
				  <td align="left" nowrap="" height="23" style="color:#c40000;font-size:15px;font-family:Arial,Helvetica,sans-serif;font-weight:bold;padding-left:15px">Kiên - Hưng - An</td></tr><tr><td align="left" style="padding-left:25px;font-size:12px;font-family:Arial,Helvetica,sans-serif"><strong>Website:</strong> <a target="_blank" href="'.get_bloginfo('home').'">'.get_bloginfo('home').'</a></td></tr>
				  <tr><td align="left" valign="top" style="padding-left:25px;font-size:12px;font-family:Arial,Helvetica,sans-serif"><strong>Tel:</strong>';
				  if(isset($options['info_phone'])){ $message .=  trim($options['info_phone']);}  else  { $message .=  '0932 400 606';}
				 $message .= ' - Fax: ';
				 if(isset($options['info_phone'])){ $message .=  trim($options['info_phone']);} else { $message .=  '0932 400 606';}
				  $message .= '</td></tr>
				  <tr><td align="left" valign="top" style="padding-left:25px;font-size:12px;font-family:Arial,Helvetica,sans-serif"><strong>Email:</strong> <a target="_blank" href="mailto:';
				  if(isset($options['info_email'])){ $message .=  trim($options['info_email']);} else { $message .=  'leeseawuyhs@yahoo.com';}
				   $message .= '">';
				   if(isset($options['info_email'])){ $message .=  trim($options['info_email']);} else {echo 'leeseawuyhs@yahoo.com';}
				   $message .= '</a></td></tr>
			</tbody></table></td></tr></tbody></table> ';

			$headers  = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			$headers .= 'Content-Transfer-Encoding: 8bit' . "\r\n";
			$headers .= 'To: Kiên - Hưng - An <'.$to.'>' . "\r\n";
			$headers .= 'From: '.$data['customer_name'].' <'. $data['customer_email'] .'>' . "\r\n";
			$b64subject = "=?UTF-8?B?" . base64_encode($subject) . "?=";
			$headers .= 'Subject: '. $b64subject . "\r\n";
			
			$info_send =wp_mail( $to, $subject, $message, $headers);
			 if($info_send){
				$results['message'] = 'Cảm ơn đã gởi đơn đặt hàng. Chúng tối sẽ liên hệ lại trong thời gian sớm nhất';
				$results['status'] = 'true';
				if($data['customer_via_email']){
					$headers  = 'MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
					$headers .= 'Content-Transfer-Encoding: 8bit' . "\r\n";
					$headers .= 'To: '.$data['customer_name'].' <'. $data['customer_email'] .'>' . "\r\n";
					$headers .= 'Form: Kiên - Hưng - An <'.$to.'>' . "\r\n";
					$b64subject = "=?UTF-8?B?" . base64_encode($subject) . "?=";
					$headers .= 'Subject: '. $b64subject . "\r\n";
					wp_mail( $data['customer_email'], $subject, $message, $headers);
				}
				delAllCart();
			 } else{
				$results['message'] = 'Thông tin đơn hàng chưa được gởi đi. Hãy kiểm tra lại thông tin';
				$results['status'] = 'false';
			 }
		} else{
			
		}
	}
	die(isovn_get_json($results));
}
function isovn_get_meta_product($id_product = null,$type_product = 'product',$data_limit = null){	
	global $wpdb,$ecpt_db_meta_name;	
	global $ecpt_db_meta_fields_name;	
	$tr_content ='';	
	$fields_arrays = array();	
	$i =0;	
	$meta_product = $wpdb->get_results("SELECT * FROM " . $ecpt_db_meta_name . " WHERE `page`='".$type_product."';");	
	if(isset($meta_product)){				
		foreach($meta_product  as $key => $metabox) 		{
			$result_metas = $wpdb->get_results("SELECT * FROM " . $ecpt_db_meta_fields_name . " WHERE parent = '" . $metabox->name ."' ORDER BY list_order;");				
			if(!empty($result_metas) && count($result_metas) >0){						
				$tr_content .=  '<table class="details"><thead><tr><th colspan="2">'.($metabox->nicename).'</th></tr></thead><tbody>';					
				foreach($result_metas as $key => $meta_field) 					{							
					if(!in_array($meta_field->name,$data_limit, false)){							
						if(get_post_meta($id_product,'ecpt_'.$meta_field->name,true)){									
							$tr_content .=  '<tr><th>'.($meta_field->nicename).'</th><td>';									
							$tr_content .=  (get_post_meta($id_product,'ecpt_'.$meta_field->name,true));									
							$tr_content .=  '</td></tr>';							
						}						
					}					
				}					
				$tr_content .=  '</tbody></table>';				
			}		
		}			
	}	
	return $tr_content;	
}
/* vote */
add_action( 'wp_ajax_nopriv_ajax_vote_post', 'ajax_vote_post' );  
add_action( 'wp_ajax_ajax_vote_post', 'ajax_vote_post' );
function ajax_vote_post(){
	global $current_user;
	$results['status_login'] = 'true';
	$results['message'] = 'Đã có lỗi trong quá trình nhập dữ liệu. Vui lòng thử lại sau';
	$results['status'] = 'false';
	$results['vote'] = 0;
	if(isset($current_user->ID)){
	   if(isset($_POST['photo_id'])){
			$vote = 1;
			$id = intval($_POST['photo_id']);
			$post_votes = get_post_meta($id,'votes',true );
			if($post_votes ){
				$post_votes = intval($post_votes);
				if(!update_post_meta($id, 'votes', ($post_votes+$vote))) {
					add_post_meta($id, 'votes', $vote, true);
				}
			} else {
				add_post_meta($id, 'votes', $vote, true);
			}
			update_session_votes($id);
			$results['vote'] = number_format(get_post_meta($id,'votes',true ),0,'.','.');
			$results['message'] = 'Bình chọn thành công.';
			$results['status'] = 'true';
	   }
	} else{
		$results['status_login'] = 'false';
		$results['message'] = 'Hãy đăng nhập để tiếp tục bình chọn';
	}
	die(isovn_get_json($results));
}
add_action( 'wp_ajax_nopriv_ajax_get_map_by_id', 'ajax_get_map_by_id' );  
add_action( 'wp_ajax_ajax_get_map_by_id', 'ajax_get_map_by_id' );
function ajax_get_map_by_id(){
	if(isset($_POST['mapId'])){
		echo do_shortcode( '[mappress mapid="'.$_POST['mapId'].'"]' ); 
	}
	die();
}
add_action( 'wp_ajax_nopriv_ajax_get_data_post', 'ajax_get_data_post' );  
add_action( 'wp_ajax_ajax_get_data_post', 'ajax_get_data_post' );
function ajax_get_data_post(){
	global $session_votes, $current_user;
	$user_not_login = 'true';
	if(!isset($current_user->ID)){
		$user_not_login = 'false';
	}
	$results['message'] = 'Đã có lỗi trong quá trình nhập dữ liệu. Vui lòng thử lại sau';
	$results['status'] = 'false';
	if(isset($_POST['type_load'])){
		$option_order = $_POST['type_load'];
		$option_show = isset($_POST['show_post']) ? $_POST['show_post'] : 5;
		$args = array(
				'post_type' => 'post',
				'post_status' => 'publish',
				'showposts' => $option_show,
				'order'	=>'DESC'
			);
			if($option_order == 'rand'){
				$args['orderby'] = 'rand';
			} else if($option_order == 'votes'){
				$args['meta_key'] = 'votes';
				$args['orderby'] = 'meta_value_num';
				$args['meta_query'] = array(
				   array(
					   'key' => 'votes',
					   'compare' => 'IN'
				   )
			   );
			   $args['order'] = 'DESC';
			} else if($option_order == 'views'){
				$args['meta_key'] = 'views';
				$args['orderby'] = 'meta_value_num';
				$args['meta_query'] = array(
				   array(
					   'key' => 'views',
					   'compare' => 'IN'
				   )
			   );
			   $args['order'] = 'DESC';
			}
			if(isset($_POST['category'])){
				$args['cat'] = $_POST['category'];
			}
			$post_in_category = new WP_Query();
			$post_in_category->query($args);
			$results['data'] = array();
			
			if($post_in_category->have_posts()){
				$i=0;
				while($post_in_category->have_posts()) : $post_in_category->the_post(); 
					$image = isovn_get_post_thumbnai();
					$views = get_post_meta(get_the_ID(),'views' , true);
					$views= ($views) ? number_format($views,0,'.','.') : 0;
					$votes = get_post_meta(get_the_ID(),'votes' , true);
					$votes= ($votes) ? number_format($votes,0,'.','.') : 0;
					$address = get_post_meta(get_the_ID(),'ecpt_Dia-chi' , true);
					$phone = get_post_meta(get_the_ID(),'ecpt_Dien-thoai' , true);
					$google_map = get_post_meta(get_the_ID(),'ecpt_ban-do' , true);
					$status_vote = 'true';
					if (!isset($_SESSION[$session_votes]) || (!in_array(get_the_ID(), $_SESSION[$session_votes]))) {
						$status_vote = 'false';
					}
					$results['data'][$i]['id']	= get_the_ID();
					$results['data'][$i]['title']	= get_the_title();
					$results['data'][$i]['href']	= get_permalink();
					$results['data'][$i]['descripton']	= get_the_excerpt();
					$results['data'][$i]['image']	= $image;
					$results['data'][$i]['views']	= $views;
					$results['data'][$i]['votes']	= $votes;
					$results['data'][$i]['address']	= $address;
					$results['data'][$i]['phone']	= $phone;
					$results['data'][$i]['google_map']	= $google_map;
					$results['data'][$i]['status_vote']	= $status_vote;
					$results['data'][$i]['user_not_login'] = $user_not_login;
					$i++;
				endwhile; wp_reset_query(); 
				$results['message'] = 'Tải dữ liệu thành công.';
				$results['status'] = 'true';
			}
		
	}
	die(isovn_get_json($results));
}

function update_session_votes($id= null){
	global $session_votes;
	$_SESSION[$session_votes][$id]=$id;
}
 
 function delete_session_vote_wp_logout() {
	global $session_votes;
    unset($_SESSION[$session_votes]);
	wp_redirect( home_url('/') );
	exit;
}
add_action('wp_logout', 'delete_session_vote_wp_logout');

function custom_excerpt_length( $length ) {
	$options = isovn_get_option_theme();
	return $options['custom_excerpt_length'] ? $options['custom_excerpt_length'] : 35;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );