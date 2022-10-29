<?php get_header(); ?>
	<div class="book-box-container book-tour">
		<div class="container">
			<div class="row">
				<div class="col col-lg-8">
					<h2 class="title-book-tour">Thông tin liên hệ</h2>
					<div class="block-content">
						<div id="book-details-tour">
							<div class="box-details-tour">
								<form id="customer_booking_tour">
									<table class="tlb-contact-payment-tour">
										<tbody>
											<tr>
												<td>
													<label for="billing_first_name">Họ và tên<span class="red">*</span></label>
													<input required="required" value="" id="billing_first_name" name="billing_first_name" type="text" class="form-control" autocomplete="off">
												</td>
												<td>
													<label for="billing_phone">Điện thoại<span class="red">*</span></label>
													<input required="required" value="" id="billing_phone" name="billing_phone" type="text" class="form-control" autocomplete="off">
												</td>
											</tr>
											<tr>
												<td>
													<label for="billing_email">Email<span class="red">*</span></label>
													<input required="required" value="" id="billing_email" name="billing_email" type="email" class="form-control" autocomplete="off">
												</td>
												<td>
													<label for="billing_address">Địa chỉ</label>
													<input name="billing_address" value="" id="billing_address" type="text" class="form-control" autocomplete="off">
												</td>
											</tr>
											<tr>
												<td colspan="2">
													<!-- <input autocomplete="off" readonly="readonly" value="25/10/2022" type="hidden" name="date_start" id="txt-date-start" class="form-control txt-date-start" required="required">
													<input value="1" type="hidden" min="1" max="20" class="form-control total-number-people" disabled=""> -->
													<!-- <input name="number_people" value="1" type="hidden"> -->
													<!-- <div class="box-agree-rule hidden">
														<label for="chk-agree-rule"><input checked="checked" required="required" name="chk_agree_rule" id="chk-agree-rule" type="checkbox" value="yes"> Tôi đồng ý với các điều kiện trên</label>
													</div> -->
													<label for="order_comments">Yêu cầu khác</label>
													<textarea name="order_comments" id="order_comments" type="text" class="form-control" autocomplete="off"></textarea>
													<!-- <input type="hidden" name="voucher_code" value="" class="txt-voucher-code">
													<input type="hidden" name="voucher_info" value="" class="txt-voucher-info"> -->
													<!-- <span class="box-toggle-radio">
														<i class="fa fa-toggle-off"></i> Nhập mã giảm giá
													</span> -->
													<!-- <div class="box-voucher-promo voucher-tour hidden">
														<input type="hidden" value="179636" class="txt-tour-id-hidden">
														<input type="hidden" value="7490000" class="txt-tour-price-hidden">
														<div><input name="txt_voucher_tour" value="" id="txt_voucher_tour" type="text" class="form-control" autocomplete="off"></div>
														<div><span class="btn-submit-voucher voucher-tour">Áp dụng mã</span></div>
													</div> -->
													<div class="box-voucher-promo-results voucher-tour hidden"></div>
													<div class="box-change-type-payment">
														<h2 class="title-book-tour">Thanh Toán Tại Văn Phóng</h2>
													</div>
													<div class="box-van-phong box-payment">
														<table class="table tlb-payment-office-default">
															<tbody>
																<tr>
																	<td><img src="https://www.vietnambooking.com/wp-content/themes/vietnambooking_master/images/index/bg_sgn.jpg"></td>
																	<td>
																		<div class="box-title">TP. Hồ Chí Minh</div>
																		<a target="_blank" style="color: #000;text-decoration: none;" href="https://goo.gl/maps/hH6fnY1MgzGAdH2z7"><div class="box-address">- Địa chỉ: 164 Lê Thánh Tôn, Bến Thành, Quận 1 <span>(Đối diện cửa bắc chợ Bến Thành)</span></div></a>
																		<a target="_blank" style="color: #000;text-decoration: none;" href="https://g.page/vietnam-booking?share"><div class="box-address">- Địa chỉ: 54 Phạm Hồng Thái, Bến Thành, Quận 1 <span>(Đối diện khách sạn New World)</span></div></a>
																		<a target="_blank" style="color: #000;text-decoration: none;" href="https://goo.gl/maps/RDdqtSPzbkfpsg7S6"><div class="box-address">- Địa chỉ: 190-192 Trần Quý, Phường 6, Quận 11 <span>(Ngay ngã tư Tạ Uyên - Trần Quý)</span></div></a>                        
																	</td>
																</tr>
																<tr>
																	<td><img src="https://www.vietnambooking.com/wp-content/themes/vietnambooking_master/images/index/bg_han.jpg"></td>
																	<td>
																		<div class="box-title">Hà Nội</div>
																		<a style="color: #000;text-decoration: none;" href="https://goo.gl/maps/iRUGbUpyzrYCj7Ve9"><div class="box-address">- Địa chỉ: 30 Phan Chu Trinh, Quận Hoàn Kiếm <span></span></div></a>
																	</td>
																</tr>
																<tr>
																	<td><img src="https://www.vietnambooking.com/wp-content/themes/vietnambooking_master/images/index/bg_dad.jpg"></td>
																	<td>
																		<div class="box-title">Đà Nẵng</div>
																		<a style="color: #000;text-decoration: none;" href="https://goo.gl/maps/ZTcXvQv8p5xd1Yy28"><div class="box-address">- Địa chỉ: 174 Nguyễn Văn Linh, Quận Thanh Khê <span></span></div></a>
																	</td>
																</tr>
															</tbody>
														</table>
													</div>
													<div class="ensure-security-for-customer">
														<i class="fa fa-lock" aria-hidden="true"></i> 
														www.vietnambooking.com cam kết bảo mật thông tin của quý khách.
													</div>
													<div class="box-submit-form-set-tour">
														<button class="btn-event btn-submit-form-set-tour checkout-tour" type="submit" name="btn_submit_form_set_tour">
															HOÀN TẤT ĐẶT TOUR
														</button>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="col col-g-4">
					<?php
					$total_item = count( WC()->cart->get_cart() );
					if ( $total_item > 0 ) {
						foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
							$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
							$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
							$info_tour = $cart_item['info_tour'];
							if ( get_post_type( $product_id =='travel-tour') )  : 
							?>
							<div class="box-img-feature payment-tour">
								<?php echo $_product->get_image(); ?>
							</div>
							<div class="box-info-tour payment-tour">
								<span class="code-tour"> 
									<?php echo get_field('code', $product_id); ?>  <a href="<?php echo get_permalink($product_id); ?>">| <?php echo get_the_title($product_id); ?></a>
								</span>
								<table>
									<tbody>
										<tr>
											<td>
												<i class="fa fa-map-o" aria-hidden="true"></i>
												<?php echo get_field('dia_chi_khach_san', $product_id); ?> | <?php echo $info_tour['capacity']; ?> Khách                                   
											</td>
										</tr>
										<tr>
											<td>
												<i class="fa fa-clock-o" aria-hidden="true"></i>
												<?php echo get_field('duration', $product_id); ?> | Phương tiện: 
												<?php
												$list_img = array(
													'o_to' => 'https://www.vietnambooking.com/wp-content/themes/vietnambooking_master/images/index/tour/icon_traffic/o_to.png',
													'may_bay' => 'https://www.vietnambooking.com/wp-content/themes/vietnambooking_master/images/index/tour/icon_traffic/may_bay.png'
												);
												$phuong_tien = get_field('vehicle', $product_id) ? explode( ',', get_field('vehicle', $product_id) ) : [] ;
												?>
												<?php foreach( $phuong_tien as $value ){
													if( array_key_exists( trim($value), $list_img)){ ?>
														<img class="img-traffic" title="<?php echo $value; ?>" src="<?php echo $list_img[trim($value)]; ?>">
													<?php }
												} ?>                                   
											</td>
										</tr>
										<tr>
											<td>
												<i class="fa fa-calendar-check-o" aria-hidden="true"></i>
												Khởi hành: <?php echo get_field('depart_time',$product_id); ?>
											</td>
										</tr>
									</tbody>
								</table>

							</div>
							<div class="box-price-tour payment-tour">
								<div class="box-item price-tour hidden">
									<span>Giá tour</span>
									<span><?php echo number_format( get_field( 'gia_tour' , $product_id ) ); ?> VNĐ</span>
								</div>
								<!-- <div class="box-item type-voucher hidden">
									<span>Voucher giảm giá</span>
									<span></span>
								</div> -->
								<div class="box-item box-price-final">
									<span>Tổng</span>
									<span class="price-final"><?php echo number_format( get_field( 'gia_tour' , $product_id ) ); ?> VNĐ</span>
								</div>
							</div>
							<div class="box-guide-payment-tour payment-tour">
								Sau khi hoàn tất đơn hàng, nhân viên của www.vietnambooking.com sẽ liên hệ với quý khách để xác nhận tình trạng tour.
								<br>
								Mọi thắc mắc, xin Quý khách vui lòng liên hệ tổng đài <span>1900 3398</span>
							</div>
							<?php
							endif;
						} 
					} else{ ?>
						<div class="warning">
							<div class="alert alert-warning">
								<strong>Lỗi!</strong> Không có tour hợp lệ !
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
<?php get_footer(); ?>