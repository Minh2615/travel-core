<?php get_header(); ?>
	<div class="page-full-header book-hotel">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-3">
					<div class="box-logo">
						<div class="header-box-logo">
							<a href="<?php echo home_url(); ?>">
								<img src="https://data.vietnambooking.com/common/svg/logo_blue.svg" alt="logo">
							</a>
						</div>
					</div>
				</div>
				<div class="col-lg-9 col-md-9">
					<div class="box-step">
						<ul>               
							<li class="active "> <span>1</span> Điền thông tin </li>                
							<li class=" "> 
								<div class="box-bar"> 
									<div> 
										<i class="bar"></i>
									</div> 
									<div>
										<span>2</span> 
										Thanh Toán
									</div> 
									<div> 
										<i class="bar"></i> 
									</div> 
								</div>
							</li> 
							<li class=""><span>3</span> Xác nhận </li>
						</ul>
					</div>
				</div>
			</div>
		</div>	
	</div>
	<div class="page-box-content page-hotel">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-8">
					<h3>Điền thông tin liên hệ</h3>
					<div class="box-content">
						<form id="form-hotel-create-booking">
							<div class="input-item form-group col-lg-12 col-md-12">
								<label for="billing_first_name">Họ và tên <span class="required">*</span></label>
								<input type="text" name="billing_first_name" id="billing_first_name" class="form-control" placeholder="Họ và tên" required autocomplete="off">
								<span class="help-block"></span>
							</div>
							<div class="input-item form-group col-lg-7 col-md-7">
								<label for="billing_email">Email <span class="required">*</span></label>
								<input type="email" name="billing_email" id="billing_email" class="form-control" placeholder="Email" required autocomplete="off">
								<span class="help-block"></span>
							</div>
							<div class="input-item form-group col-lg-5 col-md-5">
								<label for="billing_phone">Số điện thoại <span class="required">*</span></label>
								<input type="text" name="billing_phone" id="billing_phone" class="form-control" placeholder="Số điện thoại" required autocomplete="off">
								<span class="help-block"></span>
							</div>
							<div class="input-item form-group col-lg-12 col-md-12 box-full-services-extra">
								<label for="info_services_extra">Hãy cho chúng tôi biết Quý khách cần gì? </label>
								<div class="box-services-extra">
									<div class="note"> Lưu ý tất cả các yêu cầu chỉ được đáp ứng tùy theo khách sạn</div>
									<div class="box-services-extra-inner">
										<div class="box-item type-radio">
											<div class="box-item-inner">
												<label for="rad-item-1"></label>
												<input type="radio" id="[info_services_extra][room_smoke]" value="0"></input>
												 Phòng không hút thuốc 
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="input-item form-group col-lg-12 col-md-12">
								<div class="hotel-box-note">
									<div class="box-title">
										<i class="fas fa-plus-circle"></i>
										Thêm yêu cầu đặc biệt 
									</div>
									<textarea id="order_comments" autocomplete="off" maxlength="200" class="form-control txt_note hidden" name="order_comments"></textarea>
								</div>
								<span class="help-block"></span>
								<div class="box-submit">
									<button type="submit" class="btn-submit-contact-booking">Tiếp Tục</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="col-lg-4 col-md-4">
					<h3>Thông tin đặt phòng</h3>
					<div class="hotel-page-sidebar">
						<div class="box-summary">
							<?php
							$total_item = count( WC()->cart->get_cart() );
							if ( $total_item > 0 ) :
							foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
								$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
								$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
								if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
								?>
								<div class="summary-main">
									<div class="box-img">
										<?php echo $_product->get_image(); ?>
									</div>
									<div class="box-title">
										<h3><?php echo get_the_title($product_id); ?></h3>
										<div class="description"> Phòng Superior </div>
									</div>
								</div>
								<div class="summary-total">
									<table class="tlb-info">
										<tbody>
											<!-- <tr>
												<td> <div class="title"><i class="icon-vnbk icon-calendar-from-570-48 "></i> Ngày nhận phòng </div> </td>
												<td> <div class="info-right"> 27/10/2022 </div> </td>
											</tr>
											<tr>
												<td> <div class="title"><i class="icon-vnbk icon-calendar-to-612-48 "></i> Ngày trả phòng </div> </td>
												<td> <div class="info-right">  28/10/2022 </div> </td>
											</tr> -->
											<tr>
												<td> <div class="title"><i class="icon-vnbk icon-passenger-528-96"></i> Số khách phòng </div> </td>
												<td> <div class="info-right"> 1 khách, 1 phòng </div> </td>
											</tr>
										</tbody>
									</table>                        
								</div>
							<?php } 
							} endif; ?>
							<div class="summary-total">
								<table class="tlb-info tlb-info-price">
									<tbody>
										<tr>
											<!-- <td> <div class="title">1 phòng x 1 đêm </div> </td> -->
											<td> <div class="info-right"><?php echo WC()->cart->get_cart_total(); ?></div> </td>
										</tr>
										<!-- <tr>
											<td> <div class="title box-promo">Promo giảm 40%</div> </td>
											<td> <div class="info-right">- 598,800 VND</div> </td>
										</tr> -->
										<!-- <tr class="tr-voucher hidden">
											<td> <div class="title">Mã giảm giá </div> </td>
											<td> <div class="info-right">0 VND</div> <input class="txt-total-price-hidden" type="hidden" value="898200"> </td>
										</tr> -->
										<tr>
											<td> <div class="title type-tax">Phí dịch vụ</div> </td>
											<td> <div class="info-right type-tax">MIỄN PHÍ</div> </td>
										</tr>
										<tr class="tr-total">
											<td> <div class="title">Tổng tiền</div> </td>
											<td> <div class="info-right"><?php echo WC()->cart->get_cart_total(); ?></div> </td>
										</tr>
										<tr class="tr-note">
											<td colspan="2"> 
												<div class="alert alert-warning">
													Booking của bạn đang được chờ xác nhận. Tư vấn viên sẽ sớm liên hệ với bạn
												</div>
											</td>
										</tr>
									</tbody>
								</table>
								<div class="box-hotline"><i class="icon-vnbk icon-phone-96-48"></i> Gọi <a href="tel:19004698">1900 4698</a> để được hỗ trợ 24/7</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php get_footer();?>