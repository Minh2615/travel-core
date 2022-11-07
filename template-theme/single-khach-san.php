<?php get_header(); ?>

<div class="flex-row container">
	<div class="block-detail-hotel-content">
		<div class="block-detail-hotel-image">
			<div class="img-wrapper">
				<div class="hotel-img">
					<?php 
						$galery = get_field('gallery_hotel');
						if( !empty( $galery ) ) { 
							foreach($galery as $key => $image){ ?>
								<div class="hotel-img-item">
									<?php if($key ==3) :  ?>
										<div class="overlay">
											<p>Xem thêm <?php echo absint( count($galery) - 3 ) ; ?> ảnh</p>
										</div>
									<?php endif; ?>
									<a href="<?php echo $image['img_hotel']; ?>" data-fancybox ="images" rel="group1">
										<img src="<?php echo $image['img_hotel']; ?>" />
									</a>
								</div>
								<?php if($key == 3){
									break;
								} ?>
							<?php }
						}
						if( have_rows('gallery_hotel') ): ?>
							<?php while( have_rows('gallery_hotel') ): the_row(); 
								$image = get_sub_field('img_hotel');
								?>
									<a href="<?php echo $image; ?>" data-fancybox ="images" rel="group1">
									</a>
							<?php endwhile; ?>
						<?php endif; ?>
					</div>
			</div>
		</div>
		<div class="detail-hotel-main">
			<div class="detail-hotel-header">
				<div class="left-title">
					<div class="title-hotel">
						<h3><?php echo get_the_title(); ?></h3>
						<span class="hotel_rate">
							<?php 
							$rating = get_field('danh_gia');
							for($i = 1 ; $i <= $rating ; $i++){ ?>
								<i class="icon-star"></i>
							<?php }
							?>
						</span>
					</div>
					<div class="address-hotel">
						<i class="fa fa-map-o" aria-hidden="true"></i>
						<span><?php echo get_field('dia_chi_khach_san'); ?></span>
					</div>
				</div>
				<div class="right-title">
					<p>Giá chỉ từ</p>
					<div class="price-hotel">
						<span class="price"><?php echo number_format( get_field( 'price_ks' ) ); ?> VNĐ</span>
						<span class="price-text">/đêm</span>
					</div>
					<div class="btn-book-hotel">
						<a href="<?php echo get_field('link_book'); ?>" target="_blank">Đặt Phòng</a>
					</div>
				</div>
			</div>
			<div class="detail-hotel-wrapper">
				<div class="wrapper-right">
					<div class="block-detail-vi-tri">
						<div class="title-tien-nghi">
							<h3>Vị Trí</h3>
						</div>
						<div class="content-vi-tri">
							<?php echo get_field('ban_do'); ?>
						</div>
					</div>
					<div class="hotel-introduce">
						<div class="hotel-introduce-content">
							<div class="hotel-introduce-title">
								<i class="fa fa-paper-plane-o" aria-hidden="true"></i>
								<h3><?php echo get_the_title(); ?></h3>
							</div>
							<div class="hotel-introduce-text">
								<?php echo get_the_content(); ?>
							</div>
						</div>
					</div>
					<div class="hotel-utilities">
						<div class="hotel-utilities-content">
							<div class="hotel-utilities-title">
								<span>Tiện ích khách sạn</span>
							</div>
							<div class="hotel-utilities-detail">
								<ul>
									<?php $terms = get_the_terms( get_the_ID(),'tien-nghi');
										if ( !empty( $terms ) ){
											foreach( $terms as $term ) { ?>
												<li>
													<i class="fa fa-check-square-o" aria-hidden="true"></i>
													<span><?php echo $term->name; ?></span>
												</li>
										<?php }
										}
									?>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="wrapper-left">
					<div class="block-detail-tien-nghi">
						<div class="title-tien-nghi">
							<h3>Tiện Nghi Khách Sạn</h3>
						</div>
						<div class="content-facilities">
							<ul class="tien-nghi">
								<?php $terms = get_the_terms( get_the_ID(),'tien-nghi');
									if ( !empty( $terms ) ){
										foreach( $terms as $term ) { ?>
											<li>
												<i class="fa fa-check-square-o" aria-hidden="true"></i>
												<span><?php echo $term->name; ?></span>
											</li>
									<?php }
									}
								?>
							</ul>
						</div>
					</div>
					<div class="block-detail-calendar">
						<div class="hotel-box-date-start box-input-item"> 
							<label class="">Ngày nhận phòng</label>
							<input value="" required="" placeholder="Ngày nhận phòng" class="hotel-date-start form-control" type="text"> 
						</div>
						<div class="hotel-box-date-end box-input-item"> 
							<label class="">Ngày trả phòng</label>
							<input value="" required="" placeholder="Ngày trả phòng" class="hotel-date-end form-control" type="text"> 
						</div>
						<div class="box-input-item input-count-night">
							<label class="">Số đêm</label>
							<input type="number" placeholder="Số đêm" class="hotel-info-passenger form-control" max="30" value="1" min="1">
						</div>
					</div>
					<div class="block-hotel-list-room">
						<div class="block-hotel-list-room-content">
							<div class="table-room">
								<table class="table table-bordered">
									<thead>
										<tr>
											<th style="width: 243px;" scope="col">Loại phòng</th>
											<th scope="col">Khuyến mại</th>
											<th scope="col" style="width: 16%;">Giá</th>
											<th scope="col">Đặt Phòng</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										$list_room_ids = get_post_meta( get_the_ID(),'travel_list_rooms',true );
										if(!empty($list_room_ids)){
											
											foreach( $list_room_ids as $room_id ){
												$room = get_post($room_id);?>
													<tr>
														<td>
															<div class="hotel-room">
																<div class="hotel-room-content">
																	<div class="hotel-room-name">
																		<h3 class="heading-tertiary"><?php echo get_the_title($room_id); ?></h3>
																	</div>
																	<div class="hotel-room-image">
																		<a href="<?php echo $image; ?>" data-fancybox ="images" rel="group1">
																			<img src="<?php echo get_the_post_thumbnail_url( $room_id ); ?>" />
																		</a>
																		<?php if( have_rows('gallerys', $room_id) ): ?>
																			<?php while( have_rows('gallerys', $room_id) ): the_row(); 
																				$image = get_sub_field('img_gal');
																				?>
																					<a style="display:none;"href="<?php echo $image; ?>" data-fancybox ="images" rel="group1">
																						<img src="<?php echo $image; ?>" alt="">
																					</a>
																			<?php endwhile; ?>
																		<?php endif; ?>
																	</div>
																	<div class="hotel-room-description">
																		<?php
																			$rows = get_field('tien_nghi', $room_id);
																			if( $rows ) {
																				echo '<ul class="slides">';
																				foreach( $rows as $row ) {
																					$tien_nghi = $row['cac_tien_nghi'];
																					echo '<li>';
																						echo '<i class="fa fa-hand-o-right" aria-hidden="true"></i>';
																						echo '<span>';
																							echo $tien_nghi;
																						echo '</span>';
																					echo '</li>';
																				}
																				echo '</ul>';
																			}
																		?>
																	</div>
																</div>
															</div>
														</td>
														<td>
															<div class="hotel-room-offers">
																<div class="hotel-room-offers-content">
																	<?php
																			$rows = get_field('khuyen_mai', $room_id);
																			if( $rows ) {
																				echo '<ul class="slides">';
																				foreach( $rows as $row ) {
																					$khuyen_mai = $row['cac_khuyen_mai'];
																					echo '<li>';
																						echo '<i class="fa fa-check-square-o" aria-hidden="true"></i>';
																						echo '<span>';
																							echo $khuyen_mai;
																						echo '</span>';
																					echo '</li>';
																				}
																				echo '</ul>';
																			}
																		?>
																</div>
															</div>
														</td>
														<td>
															<div class="hotel-room-price">
																<div class="hotel-room-price-content">
																	Giá:  <span id="price-room-<?php echo $room_id; ?>" data-price= "<?php echo get_field( 'price_zoom', $room_id ); ?>"><?php echo number_format( get_field( 'price_zoom', $room_id ) ); ?> VNĐ</span>
																</div>
															</div>
														</td>
														<td class="col-book-room">
															<div class="hotel-room-booking">
																<div class="hotel-room-booking-content">
																	<div class="hotel-room-number">
																		<div class="hotel-room-number-content">
																			<div class="number-room">
																				<span class="minus" id="minus-room-ks"><i class="fa fa-minus" aria-hidden="true"></i></span>
																				<input type="text" min="0" max="999" step="1" value="1" class="numberOfroom" id="numberOfroom-<?php echo $room_id; ?>">
																				<span class="plus" id="plus-room-ks"><i class="fa fa-plus" aria-hidden="true"></i></span>
																			</div>
																			<div class="room-max-people">
																				<?php echo get_field( 'so_luong', $room_id ); ?>
																			</div>
																		</div>
																	</div>
																	<a href="#" class="btn-oranges btn-booking-hotel" data-nid="<?php echo $room_id; ?>">Đặt phòng</a>	
																</div>
															</div>
														</td>
													</tr>
											<?php } 
										}
										?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="block-hotel-policy">
						<div class="block-hotel-policy-content">
							<div class="block-hotel-policy-title">
								<h2>Chính sách khách sạn</h2>
							</div>
							<div class="block-hotel-policy-list">
								<ul>
									<?php 
										$chinh_sach = get_field( 'chinh_sach');
										if( $chinh_sach ) {
											foreach( $chinh_sach as $cs ) {
												echo '<li>';
													echo '<span style="font-weight:bold;">'.$cs['tieu_de_chinh_sach'].'</span>';
													echo '<div>';
														echo '<span>';
															echo $cs['noi_dung_chinh_sach'];
														echo '</span>';
													echo '</div>';
												echo '</li>';
											}
										}
									?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script src="http://code.jquery.com/jquery-1.9.0.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>

<script type="text/javascript">
    jQuery(document).ready(function($){
		$("a[data-fancybox='images']").fancybox({
			'transitionIn'	:	'none',
			'transitionOut'	:	'none',
			'speedIn'		:	600, 
			'speedOut'		:	200, 
		});
		var checkin = $('.hotel-date-start');
		checkin.datepicker({});
		var checkout = $('.hotel-date-end');
		checkout.datepicker({});
    });
</script>
<?php get_footer(); ?>



