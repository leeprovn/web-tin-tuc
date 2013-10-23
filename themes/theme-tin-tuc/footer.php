</div><!--#main-->
<footer id="footer" class="container footer">
	<?php 
		if(is_home()){
			include('include-footer.php');
		}
	?>
            <div id="copyright" class="shadow">
		<div class="container_12 clearfix">
				<div class="grid_12">
					  
					<nav class="footer">
						<?php
							 wp_nav_menu( array(
								'theme_location' => 'footer_links', // Setting up the location for the main-menu, Main Navigation.
								'menu_class' => 'footer-nav', //Adding the class for dropdowns
								'container_id' => 'menu-footer-menu', //Add CSS ID to the containter that wraps the menu.
								'fallback_cb' => 'wp_page_menu', //if wp_nav_menu is unavailable, WordPress displays wp_page_menu function, which displays the pages of your blog.
								)
							);
						?>
					</nav>
					<div id="footer-text">
							<a href="<?php echo home_url(); ?>" title="<?php bloginfo('name'); ?>" class="site-name"><?php bloginfo('name'); ?></a> &copy; <?php echo date('Y'); ?>
							<a href="#23" title="Privacy Policy">Privacy Policy</a>
						<br />
						<!-- {%FOOTER_LINK} -->
					</div>
					
				</div>
			</div>
		</div><!--.container_12-->
	</footer>
<?php wp_footer(); ?>	
</body>
</html>