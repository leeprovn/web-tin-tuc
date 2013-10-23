<?php
/**
Template Name: Page Order
*/
 get_header();
global $session_cart;
 ?>
<div class="container-fluid">
	<div class="row-fluid main-warraper">
		<div class="span9">
			<div class="content-box shadow-box">
				<?php 
					if (have_posts()) : the_post(); update_post_caches($posts); 	
				?>
				<h2><?php the_title(); ?></h2>
				<div class="box-content padding-5px">
					<link href="<?php bloginfo('template_directory');?>/includes/shop_cart/style.css" rel="stylesheet">
					<div class="row-fluid">
						<div class="content_shop">
							<form method="post" action="" id="cart_form">
								<table class="table_oder table">
									<thead>
										<tr>
											<th width="65"  align="center" class="image_product">Hình ảnh</th>
											<th class="name_product">Tên sản phẩm</th>
											<th width="50">Số lượng</th>
											<th align="center" class="action">#</th>
										</tr>
									</thead>
									<tbody>
										<?php 
											$count_cart = count( $_SESSION[$session_cart]);
											if($count_cart>0){
											$i=0;
											$set_class="old";
											foreach($_SESSION[$session_cart] as $id => $num){
											$item_product = get_post($id);
											if($item_product){
												if(get_the_post_thumbnail($item_product->ID,'thumbnail') != ''){
													$domsxe = simplexml_load_string(get_the_post_thumbnail($item_product->ID,'thumbnail'));
													$thumbnailsrc = $domsxe->attributes()->src;
												} else{
													$thumbnailsrc =get_bloginfo('template_directory').'/images/no_image.png';
												}
												$id_product = $item_product->ID;
												$title_product = $item_product->post_title;
												$link_product = get_permalink($item_product->ID);
												$price = get_post_meta( $id_product, 'ecpt_gia', true );
												if(is_numeric($price) && $price>0){
													$price = number_format($price,0,'.','.').'VNĐ';
												} else {
													$price = 'Liên hệ';
												}
										?>
											<tr id="tr_item_<?php echo $item_product->ID; ?>" class="<?php if($i%2 != 0){echo $set_class;}?>">
												<td  align="center"><a data-tooltip="<?php echo 'sticky_view_product_id_'.$id_product;?>" href="<?php echo get_permalink($item_product->ID);?>"><img clas="media-object" src="<?php echo $thumbnailsrc ?>" width="60" height="60"/></a></td>
												<td><h6 class="title_table_cart"><a href="<?php echo $link_product ;?>"> <?php echo $item_product->post_title ?></a></h6>
												<p>Giá : <?php echo $price ; ?></p>
												<p class="class_term">
													<?php 
														$tax_terms = get_the_terms($item_product->ID, 'chuyen-muc-san-pham'); 
																$count_term = count($tax_terms);
																if($count_term>0){
																	echo 'Danh mục :&nbsp;';
																	$k =1;
																	foreach($tax_terms as $set_tax_term){
																		echo  '<a href="'.get_term_link( $set_tax_term->slug, 'chuyen-muc-san-pham' ) .'">'.$set_tax_term->name.'</a>';
																		if($k<$count_term)
																			echo ', ';
																		$k++;
																	}
																}
													?>
												</p>
												</td>
												<td align="center"><input value="<?php echo $num;?>" name="qty[<?php echo $item_product->ID; ?>]" class="num"></td>
												<td align="center"><p class="del_item"> <a href="<?php echo get_permalink($page_order);?>?action=del&id=<?php echo $id; ?>" data="<?php echo $item_product->ID; ?>" class="detele_item_cart detele_item btn btn-danger">Xoá</a></p></td>
											</tr>
										<?php }
											$i++;
										}} else{
											echo '<tr><td colspan="4">Giỏ hàng rỗng. <a href="'.get_bloginfo('home').'/">Tiếp tục mua hàng</a></td></tr>'; ?>
											<script>
												jQuery(document).ready(function(){
													jQuery('div.message_loading strong.info').text('Giỏ hàng rỗng, Hệ thống sẽ tự động chuyển về trang chủ.');
													jQuery('div.message_loading').fadeIn();
													setTimeout(function() {
														jQuery('div.message_loading').fadeOut();
														window.location = url_home;
													}, 5000);
												});
											</script>
										<?php }?>
									</tbody>
								</table>
								<?php if($count_cart>0){?>
								<div class="control_oder">
									<span class="detele"> <a class="btn btn-delete-all-cart btn-danger" href="<?php echo get_permalink($page_order);?>?action=delall">Xoá tất cả</a></span>
									<span class="update"><input type="submit"  class="btn btn-update-all-cart btn-info" name="update" value="Cập nhật số lượng" class="update"/></span>
									<span id="id_check_out" class="check_out"><a class="btn btn-send-order btn-success" href="#id_check_out_content"> Gởi đơn hàng</a></span>
								</div>
								<?php }?>
							</form>
							<?php the_content(); ?>
								<?php if($count_cart>0){ ?>
								<div id="id_check_out_content">
									<form id="form-info-send-mailer" class="form-horizontal" method="post" action="">
										<legend>Thông tin khách hàng</legend>
										<div class="control-group">
											<label class="control-label" for="customer_name">Tên khách hàng<sup class="span_required">*</sup></label>
											<div class="controls">
												<input type="text" name="customer_name" id="customer_name" placeholder="Tên khách hàng...">
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="customer_adress">Địa chỉ<sup class="span_required">*</sup></label>
											<div class="controls">
												<input type="text" name="customer_adress" id="customer_adress" placeholder="Địa chỉ...">
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="customer_email">Email<sup class="span_required">*</sup></label>
											<div class="controls">
												<input type="text" name="customer_email" id="customer_email" placeholder="Email...">
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="customer_phone">Số điện thoại<sup class="span_required">*</sup></label>
											<div class="controls">
												<input type="text" name="customer_phone" id="customer_phone" placeholder="Số điện thoại...">
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="customer_note">Ghi chú đơn hàng</label>
											<div class="controls">
												<textarea rows="3" name="customer_note" id="customer_note" placeholder="Ghi chú đơn hàng..."></textarea>
											</div>
										</div>
										<div class="control-group">
											<div class="controls">
											<label class="checkbox" for="customer_via_email" >
												<input name="customer_via_email" type="checkbox"> Gởi một bản vào email của tôi
											</label>
											<button type="submit" class="btn btn-success">Gởi đơn dặt hàng</button>
											</div>
										</div>
									</form>
								</div>
								<script src="<?php bloginfo('template_directory');?>/includes/shop_cart/js/jquery.validate.js"></script>
								<script>
								jQuery(document).ready(function(){
									jQuery("#form-info-send-mailer").validate({
										rules:{
											'customer_name': {
												required:true
											},
											'customer_adress': {
												required:true
											},
											'customer_email': {
												required:true,
												email:true
											},
											'customer_phone': {
												required:true,
												number:true
											}
										},
										messages: {
											'customer_name': {
												required:'Nhập tên khách hàng.'
											},
											'customer_adress': {
												required:'Nhập địa chỉ khách hàng.'
											},
											'customer_email': {
												required:'Nhập email khách hàng.',
												email:'Email không hợp lệ.'
											},
											'customer_phone': {
												required:'Nhập điện thoại khách hàng.',
												number:'Số điện thoại không hợp lệ.'
											}
										},
										submitHandler: function (form) {
											fn_order_send_mailer();
										}
									});
								});
							</script>
								<?php } ?>
						</div>
					 </div>
				</div>
				<?php else : ?>
					<?php include('include-message.php'); ?>
				<?php endif; ?>
			</div>
		</div>
		<?php get_sidebar(); ?>
	</div>								
</div>
<?php get_footer() ?>