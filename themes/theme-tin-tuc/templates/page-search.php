<?php
/**
Template Name: Page Search
*/
 get_header() ?>
		<div class="container-fluid">
			<div class="row-fluid main-warraper">
				<div class="span12">
					<div class="content-box shadow-box">
						<?php 
							if (have_posts()) : the_post(); update_post_caches($posts); 	
							$get_option =  isovn_get_option_theme();
						?>
						<h2><?php the_title(); ?></h2>
						<div class="box-content padding-5px">
							<div class="row-fluid">
								gggggg
							</div>
						</div>
						<?php else : ?>
							<?php include('include-message.php'); ?>
						<?php endif; ?>
					</div>
				</div>
			</div>								
		</div>
<?php get_footer() ?>