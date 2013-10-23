<?php get_header() ?>

<div class="container_12 primary_content_wrap clearfix">
	<div class="grid_9 right" id="content">
		<?php
			if (have_posts()) {
				the_post(); update_post_caches($posts); 
				$id = intval($post->ID);
				$post_views = get_post_custom($id);
				$post_views = intval($post_views['views'][0]);
				if(!update_post_meta($id, 'views', ($post_views+1))) {
					add_post_meta($id, 'views', 1, true);
				}
		?>
			<article class="post-<?php the_ID(); ?> post  <?php echo get_post_type( $post ) ?>   <?php get_post_status( get_the_ID() ) ?> format-standard hentry post-holder" id="post-<?php the_ID(); ?>">			
				<header class="entry-header">		
				<h1 class="entry-title"><?php the_title(); ?></h1>
					<div class="post-meta">
						<time datetime="2011-07-14T20:30"><?php the_time('d/m/Y'); ?></time>
						<?php the_author_posts_link(); ?>
						<?php comments_popup_link(__('0 bình luận', 'theme_option'), __('1 comment', 'theme_option'), __('%  bình luận', 'theme_option'), 'comments-link', __('Đóng bình luận', 'theme_option')); ?>	
					</div><!--.post-meta-->
				</header>
				<div class="clear"></div>		
				<div class="content">
					<?php the_content(); ?>
				</div>
			</article>
			<?php 
			} else { 
				include('include-message.php');
			} ?>
  	
	</div><!--#content-->
	<?php
		get_sidebar();
	?>
</div>
<?php get_footer() ?>