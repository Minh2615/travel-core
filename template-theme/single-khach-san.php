<?php get_header(); ?>

<div class="flex-row container">
	<div class="block-detail-hotel-content">
		<div class="block-detail-hotel-image">
			<div class="img-wrapper">
			<?php if( have_rows('gallery_hotel') ): ?>
				<?php while( have_rows('gallery_hotel') ): the_row(); 
					$image = get_sub_field('img_hotel');
					?>
						<div class="img-slide">
							<img src="<?php echo $image; ?>" />
						</div>
					<?php endwhile; ?>
				<?php endif; ?>
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
						<i class="icon-map-pin-fill"></i>
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
						<a href="<?php echo get_field('link_book'); ?>" target="_blank">Liên hệ</a>
					</div>
				</div>
			</div>
			<div class="block-detail-tien-nghi">
				<div class="title-tien-nghi">
					<h3>Tiện Nghi Khách Sạn</h3>
				</div>
				<div class="content-facilities">
					<ul class="tien-nghi">
						<?php $terms = get_the_terms( get_the_ID(),'tien-nghi');
							if ( !empty( $terms ) ){
								foreach( $terms as $term ) { ?>
									<li><?php echo $term->name; ?></li>
							<?php }
							}
						?>
					</ul>
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
									<th scope="col">Số Lượng</th>
									<th scope="col" style="width: 16%;">Giá</th>
									<th scope="col">Đặt phòng</th>
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
																<img src="<?php echo get_the_post_thumbnail_url( $room_id ); ?>" />
															</div>
															<div class="hotel-room-description">
																<?php
																	$rows = get_field('tien_nghi', $room_id);
																	if( $rows ) {
																		echo '<ul class="slides">';
																		foreach( $rows as $row ) {
																			$tien_nghi = $row['cac_tien_nghi'];
																			echo '<li>';
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
													<div class="hotel-room-number">
														<div class="hotel-room-number-content">
															<div class="number-room">
																<span class="minus"><i class="icon-plus"></i></span>
																<input type="text" min="0" max="999" step="1" value="0" class="numberOfroom" data-room-id="696">
																<span>Phòng</span>
																<span class="plus"><i class="icon-plus"></i></span>
															</div>
															<div class="room-max-people">
																<?php echo get_field( 'so_luong', $room_id ); ?>
															</div>
														</div>
													</div>
												</td>
												<td>
													<div class="hotel-room-price">
														<div class="hotel-room-price-content">
															Giá:  <span><?php echo number_format( get_field( 'price_zoom', $room_id ) ); ?> VNĐ</span>
														</div>
													</div>
												</td>
												<td>
													<div class="hotel-room-booking">
														<div class="hotel-room-booking-content">
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
			<div class="block-detail-content">
				<?php echo get_the_content(); ?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function($){
      $('.img-wrapper').slick({
        slidesToShow: 1,
		slidesToScroll: 1,
		infinite: true,
		swipe: true,
		swipeToSlide: true,
		prevArrow: "<button type='button' class='slick-prev-galery detail-slick pull-left'></button>",
      	nextArrow: "<button type='button' class='slick-next-galery detail-slick pull-right'></button>",
		arrows: false,
		draggable: true,
		dots: true,
		speed: 500,
		fade: true,
		cssEase: 'linear'
      });
    });
</script>
<?php get_footer(); ?>



