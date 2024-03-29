<?php get_header(); ?>
	<div class="page-full-header book-hotel">
		<div class="container">
			<div class="row">
				<!-- <div class="col-lg-3 col-md-3">
					<div class="box-logo">
						<div class="header-box-logo">
							<a href="<?php //echo home_url(); ?>">
								<img src="https://data.vietnambooking.com/common/svg/logo_blue.svg" alt="logo">
							</a>
						</div>
					</div>
				</div> -->
				<div class="col-lg-12 col-md-12">
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
									<textarea id="order_comments" autocomplete="off" maxlength="200" class="form-control txt_note" name="order_comments"></textarea>

									<!-- <div class="box-services-extra-inner">
										<div class="box-item type-radio">
											<div class="box-item-inner">
												<label for="rad-item-1"></label>
												<input type="radio" id="[info_services_extra][room_smoke]" value="0"></input>
												 Phòng không hút thuốc 
											</div>
										</div>
									</div> -->
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
								<div id="item-cart-<?php echo $product_id; ?>" class="detail-item-cart" data-cart="<?php echo $cart_item_key; ?>" data-pid ="<?php echo $product_id; ?>">
									<div class="summary-main">
										<div class="box-img">
											<?php echo $_product->get_image(); ?>
										</div>
										<div class="box-title">
											<h3><?php echo get_the_title($product_id); ?></h3>
											<div class="description"> Phòng Superior </div>
										</div>
										<div class="edit-cart">
											<i class="fa fa-pencil-square-o edit-item" aria-hidden="true" data-pid="<?php echo $product_id; ?>"></i>
											<i class="fa fa-trash-o delete-item" aria-hidden="true" data-pid="<?php echo $product_id; ?>"></i>
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
													<td> <div class="info-right"> <?php echo $cart_item['info_rooms']['adult'] ?? 1; ?> người lớn, <?php echo $cart_item['info_rooms']['child'] ?? 1;?> trẻ em </div> </td>
												</tr>
												<tr class="show-in-edit">
													<td>
														<label for="Người lớn">Người lớn</label>
														<input id="adult_edit" type="number" placeholder="Số lượng người lớn" value="<?php echo $cart_item['info_rooms']['adult'] ?? 1; ?>">
													</td>
													<td>
														<label for="Người lớn">Trẻ em</label>
														<input id="child_edit" type="number" placeholder="Số lượng trẻ em" value="<?php echo $cart_item['info_rooms']['child'] ?? 1;?>">
													</td>
												</tr>
											</tbody>
										</table>                        
									</div>
									<div class="show-data-event-edit">
										<div class="sub-item">
											<div class="title">
												Ngày nhận phòng
											</div>
											<div class="content">
												<input id="checkin_edit" value="<?php echo $cart_item['info_rooms']['checkin'] ?? ''; ?>" required="" placeholder="Ngày nhận phòng" class="hotel-date-start form-control" type="text"> 
											</div>
										</div>
										<div class="sub-item">
											<div class="title">
												Ngày trả phòng
											</div>
											<div class="content">
												<input id="checkout_edit" value="<?php echo $cart_item['info_rooms']['checkout'] ?? ''; ?>" required="" placeholder="Ngày trả phòng" class="hotel-date-end form-control" type="text"> 
											</div>
										</div>
										<div class="sub-item">
											<div class="title">
												Số đêm
											</div>
											<div class="content">
												<span id="so_dem_update"><?php echo $cart_item['info_rooms']['sodem'] ?? 1; ?></span>
											</div>
										</div>
										<div class="update-item">
											<button>Cập nhật</button>
										</div>
									</div>
									<div class="date-event">
										<div class="sub-item">
											<div class="title">
												Ngày nhận phòng
											</div>
											<div class="content">
												<?php echo $cart_item['info_rooms']['checkin'] ?? ''; ?>
											</div>
										</div>
										<div class="sub-item">
											<div class="title">
												Ngày trả phòng
											</div>
											<div class="content">
												<?php echo $cart_item['info_rooms']['checkout'] ?? ''; ?>
											</div>
										</div>
										<div class="sub-item">
											<div class="title">
												Số đêm
											</div>
											<div class="content">
												<?php echo $cart_item['info_rooms']['sodem'] ?? 1; ?>
											</div>
										</div>
									</div>
								</div>
							<?php } 
							} endif; ?>
							<div class="summary-total">
								<table class="tlb-info tlb-info-price">
									<tbody>
										<tr>
											<!-- <td> <div class="title">1 phòng x 1 đêm </div> </td> -->
											<!-- <td> <div class="info-right"><?php //echo WC()->cart->get_cart_total(); ?></div> </td> -->
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
										<tr class="tr-coupon">
											<input type="text" placeholder="Mã giảm giá" id="coupon-book-room">
										</tr>
										<tr class="tr-note">
											<!-- <td colspan="2"> 
												<div class="alert alert-warning">
													Booking của bạn đang được chờ xác nhận. Tư vấn viên sẽ sớm liên hệ với bạn
												</div>
											</td> -->
										</tr>
									</tbody>
								</table>
								<div class="box-submit">
									<button type="submit" class="btn-submit-contact-booking">Yêu cầu đặt phòng</button>
								</div>
								<div class="box-hotline"><i class="icon-vnbk icon-phone-96-48"></i> Gọi <a href="tel:19004698">1900 4698</a> để được hỗ trợ 24/7</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
    jQuery(document).ready(function($){
		var  today = new Date(),
            tomorrow = new Date();
		var checkin = $('.hotel-date-start');
		var checkout = $('.hotel-date-end');
		checkin.datepicker({
			minDate: today,
			maxDate: '+365D',
			onSelect: function (selected) {
				var checkout_date = checkin.datepicker('getDate'),
					time = new Date(checkout_date);

				checkout_date.setDate(checkout_date.getDate() + 1);
				checkout.datepicker('option', 'minDate', checkout_date);
			},
			onClose: function () {
				checkout.datepicker('show');
			}
		});
		
		checkout.datepicker({
			minDate: tomorrow,
			maxDate: '+365D',
			onSelect: function () {
				var checkin_date = checkout.datepicker('getDate'),
					time = new Date(checkin_date);
				checkin_date.setDate(checkin_date.getDate() - 1);
				checkin.datepicker('option', 'maxDate', checkin_date);
				updateSoDem();
			}
		});
		function updateSoDem() {
			var checkin_date = checkin.datepicker('getDate'),
				checkout_date = checkout.datepicker('getDate'),
				time = new Date(checkin_date),
				time2 = new Date(checkout_date);
			var so_dem = (time2 - time) / (1000 * 60 * 60 * 24);
			$('#so_dem_update').text(so_dem - 1);
		}
    });
</script>
<?php get_footer();?>