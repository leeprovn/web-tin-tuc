<?php
/**
Template Name: Page Liên hệ
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
								<div class="span4">
									<?php the_content(); ?>
								</div>
								<div class="span8">
									<div class="row-fluid">
										<div class="span12">
											<h4>Thông tin liên hệ</h4>
											<div class="contentMapView">
												<div class="shadow-box" id="map_canvas"></div>
												<!-- Google Maps Code -->
												<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
												<script type="text/javascript">
												  var map;
												  var myLatLng = new google.maps.LatLng(16.060702,108.211251);
												  function initialize() {
													var myOptions = {
													  zoom: 17,
													  zoomControl: true,
													  scaleControl: true,
													  panControl: false,
													  streetViewControl: false,
													  overviewMapControl: true,
													  mapTypeControl: true,           
													  center: myLatLng,
													  mapTypeId: google.maps.MapTypeId.ROADMAP
													};
													map = new google.maps.Map(document.getElementById('map_canvas'), myOptions);
													
													var marker = new google.maps.Marker({
														position: myLatLng,
														map: map,
														title: '<?php bloginfo('name'); ?>'
													});
													var title_site = '<?php bloginfo('name'); ?>';
													var phone_site = '<?php if(isset($get_option['info_phone'])){echo trim($get_option['info_phone']);} else {echo '0932 400 606';}?>';
													var email_to = '<a href="mailto:<?php if(isset($get_option['info_email'])){echo trim($get_option['info_email']);} else {echo 'leeseawuyhs@yahoo.com';}?>"><?php if(isset($get_option['info_email'])){echo trim($get_option['info_email']);} else {echo 'leeseawuyhs@yahoo.com';}?></a>';
													var address_to = '<?php echo $get_option['info_address']; ?>';
													var infowindow = new google.maps.InfoWindow({
														  content: "<div style='text-align: left;'><div  style=\"color: blue; font-weight: bold; font-family: Arial; font-size: 0.9em\">"+title_site+"</div><div style=\"font-family: Arial; font-size: 0.9em\">Điện thoại: "+phone_site+"</div><div style=\"font-family: Arial; font-size: 0.9em\">Email: "+email_to+"</div><div style='clear:both;'></div><div style=\"font-family: Arial; font-size: 0.9em\">Địa chỉ: "+address_to+"</div></div><div style='clear:both;'></div><div style=\"font-family: Arial; font-size: 0.9em\">Website: <a style='color:green;' href='<?php bloginfo('home');?>'><?php echo str_replace('http://','',get_bloginfo('home'));?></a></div>",
														  maxWidth:625 ,
														  boxStyle: {
															 border: "1px solid black"                 
														   },                                  
														  position: myLatLng,
														  pixelOffset: new google.maps.Size(-1, 0)
													});
													infowindow.open(map);        
												  }

												  google.maps.event.addDomListener(window, 'load', initialize);
												</script>
												<!-- END Google Maps Code -->
												<span class="span_thanks_contact">Cảm ơn quí khách đã liên hệ với chúng tôi. Thông tin của quí khách sẽ được phản hồi trong thời gian nhanh nhất!</span>
											</div>
										</div>
									</div>
								</div>
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