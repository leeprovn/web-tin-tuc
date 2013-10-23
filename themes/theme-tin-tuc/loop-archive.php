<?php
global $options;
while (have_posts()) : the_post(); update_post_caches($posts); 
	$image = isovn_get_post_thumbnai('thumbnail');
	include('include-info-news.php');
endwhile; ?>