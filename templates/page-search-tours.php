<?php get_header(); ?>
<div class="main-content page-search-tour">
	<div class="content-wrap">
		<div class="container">
			<div class="row">
				<div class="col search-left medium-3">
					<div class="search-by-hotel-name">
						<div class="block-title">
							<h3>Tìm kiếm</h3>
						</div>
						<div class="search-group">
							<input value="" type="text" name="hotel-name" placeholder="Nhập tên khách sạn">
							<button class="btn-search-by-hotel-name">
								<i class="icon-search"></i>
							</button>
						</div>
					</div>
					<div class="price-filter">
						<div class="block-title">
							<h3>Ngân sách</h3>
						</div>
						<div class="search-group">
							<div class="search-item">
								<input type="text" class="sliderValue fromPrice" data-index="0" value="100.000"> - &nbsp;&nbsp;&nbsp;
								<input type="text" class="sliderValue toPrice" data-index="1" value="5.000.000">
								<div id="priceRange" class="ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content">
									<span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 0%;"></span>
									<span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default" style="left: 100%;"></span>
								</div>
							</div>
						</div>
					</div>
					<div class="search-by-hotel-ranking">
						<div class="block-title">
							<h3>Hạng sao</h3>
						</div>
						<div class="search-group">
							<div class="search-item">
								<input id="input-ranking-1" type="checkbox" name="ranking" value="1">
								<label for="input-ranking-1"><span class="fake-checkbox"></span><i class="icon-star"></i></label>
							</div>
							<div class="search-item">
								<input id="input-ranking-2" type="checkbox" name="ranking" value="2">
								<label for="input-ranking-2">
									<span class="fake-checkbox"></span>
									<i class="icon-star"></i>
									<i class="icon-star"></i>
								</label>
							</div>
							<div class="search-item">
								<input id="input-ranking-3" type="checkbox" name="ranking" value="3">
								<label for="input-ranking-3">
									<span class="fake-checkbox"></span>
									<i class="icon-star"></i>
									<i class="icon-star"></i>
									<i class="icon-star"></i>
								</label>
							</div>
							<div class="search-item">
								<input id="input-ranking-4" type="checkbox" name="ranking" value="4">
								<label for="input-ranking-4">
									<span class="fake-checkbox"></span>
									<i class="icon-star"></i>
									<i class="icon-star"></i>
									<i class="icon-star"></i>
									<i class="icon-star"></i>
								</label>
							</div>
							<div class="search-item">
								<input id="input-ranking-5" type="checkbox" name="ranking" value="5">
								<label for="input-ranking-5">
									<span class="fake-checkbox"></span>
									<i class="icon-star"></i>
									<i class="icon-star"></i>
									<i class="icon-star"></i>
									<i class="icon-star"></i>
									<i class="icon-star"></i>
								</label>
							</div>
						</div>
					</div>
					<div class="search-by-hotel-ranking">
						<div class="block-title">
							<h3>Loại hình nhà ở</h3>
						</div>
						<div class="search-group">
							<?php 
								$terms_noi_o = get_terms( 'pa_loai-hinh-noi-o' );
								if ( $terms_noi_o ) {
									foreach( $terms_noi_o as $noi_o ) { ?>
										<div class="search-item">
											<input id="input-tx-hotel-<?php echo $noi_o->term_id; ?>" type="checkbox" value="<?php echo $noi_o->term_id; ?>" name="tx_hotel"> 
											<label for="input-tx-hotel-<?php echo $noi_o->term_id; ?>"> <span class="fake-checkbox"></span><?php echo $noi_o->name; ?></label>
										</div>
									<?php }
								}
							?>
						</div>
					</div>
					<div class="search-by-convenient">
						<div class="block-title">
							<h3>Tiện ích</h3>
						</div>
						<div class="search-group">
							<?php 
								$terms_tien_ich = get_terms( 'pa_tien-ich' );
								if ( $terms_tien_ich ) {
									foreach( $terms_tien_ich as $tien_ich ) { ?>
										<div class="search-item">
											<input id="input-tx-convenient-<?php echo $tien_ich->term_id; ?>" type="checkbox" value="<?php echo $tien_ich->term_id; ?>" name="tx_convenient"> 
											<label for="input-tx-convenient-<?php echo $tien_ich->term_id; ?>"> <span class="fake-checkbox"></span><?php echo $tien_ich->name; ?></label>
										</div>
									<?php }
								}
							?>
						</div>
					</div>
				</div>
				<div class="col search-right medium-9">
					<div class="block-container">
						<div class="result-count">
							Tìm thấy <span class="total-hotel">22</span>  khách sạn tại Đà Nẵng                                               
						</div>
						<div class="filter-form hotel-search-form">
							<div class="row">
								<div class="col medium-10">
									<div class="row">
										<div class="col form-item medium-4 form-search-key">
											<label for="">Chọn địa điểm</label>
											<div class="item">
												<i class="icon-map-pin-fill"></i>
												<input id="form-search-key" type="text" value="Đà Nẵng" placeholder="Bạn muốn đi đâu">
											</div>
										</div>
										<div class="form-item medium-8 form-search-room-count">
											<div class="row">
												<div class="col medium-4">
													<label for="">Số phòng</label>
													<div class="item">
														<select name="count_room" id="count_room">
															<option value="0">Chọn...</option>
															<?php
																for($i = 1; $i <= 10; $i++) {
																	echo '<option value="'.$i.'">'.$i.'</option>';
																}
															?>
														</select>
													</div>
												</div>
												<div class="col medium-4">
													<label for="">Số người lớn</label>
													<div class="item">
														<select name="count_adult" id="count_adult">
															<option value="0">Chọn...</option>
															<?php
																for($i = 1; $i <= 10; $i++) {
																	echo '<option value="'.$i.'">'.$i.'</option>';
																}
															?>
														</select>
													</div>
												</div>
												<div class="col medium-4">
													<label for="">Số trẻ em</label>
													<div class="item">
														<select name="count_child" id="count_child">
															<option value="0">Chọn...</option>
															<?php
																for($i = 1; $i <= 10; $i++) {
																	echo '<option value="'.$i.'">'.$i.'</option>';
																}
															?>
														</select>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col medium-2 form-button">
									<button class="submit-search-room">
										<i class="icon-search"></i>
										Tìm kiếm
									</button>
								</div>
							</div>
						</div>
						<div class="block-result">
							<?php echo nk_skeleton_animation_html( 20, '100%', 'height:20px', 'width:100%' ); ?>
							<div class="detail__booking-rooms"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>