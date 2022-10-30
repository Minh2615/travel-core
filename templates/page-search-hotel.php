<?php get_header(); ?>
<div class="main-content page-search-tour">
	<div class="content-wrap">
		<div class="container">
			<div class="row">
				<div class="col search-left medium-3">
                    <div class="mobile-close">
                        <i class="fa fa-angle-right"></i>
                    </div>
					<div class="filter-content">
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
                                    <div id="range-slider">
                                        <div id="slider-range"></div>
                                        <div class="range-value">
                                            <input type="text" id="amount" readonly style="border:0;">
                                        </div>
                                        <div class="range-submit">
                                            <input type="hidden" id="min-filter">
                                            <input type="hidden" id="max-filter">
                                            <a href="#" class="btn-filter-price btn-normal btn-large text-center mt-2 font_15px">Xem kết quả</a>
                                        </div>
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
                        <div class="search-by-tx-hotel">
                            <div class="block-title">
                                <h3>Loại hình nhà ở</h3>
                            </div>
                            <div class="search-group">
								<?php
								$terms_noi_o = get_terms(
									array(
										'taxonomy' => 'loai-phong',
										'hide_empty' => false,
									)
								);
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
								$terms_tien_ich = get_terms(
									array(
										'taxonomy' => 'tien-nghi',
										'hide_empty' => false,
									)
								);
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
				</div>
				<div class="col search-right medium-9">
					<div class="block-container">
						<div class="result-count" style="display:none;">
							Tìm thấy <span class="total-hotel">22</span>  khách sạn <span class="hotel-address"></span>                                             
						</div>
						<div class="filter-form hotel-search-form">
							<div class="row">
								<div class="col medium-8">
									<div class="row">
										<div class="col form-item medium-12 form-search-key">
											<label for="">Chọn địa điểm</label>
											<div class="item">
												<i class="icon-map-pin-fill"></i>
												<input id="form-search-key" type="text" value="" placeholder="Bạn muốn đi đâu">
												<!-- <div class="tt-menu">
													<h5 class="item-title-autocomplete">
														<span>Khu Vực</span>
													</h5>
													<div class="list-item-cate-search">
														<div class="box-item">
															<div class="box-title">
																Khách sạn <strong class="tt-highlight">Đà Nẵng</strong>
																<span class="pull-right extra-data">236 khách sạn</span> 
															</div>
														</div>
													</div>
												</div> -->
											</div>
										</div>
									</div>
								</div>
								<div class="col medium-4 form-button">
									<button class="submit-search-room">
										<i class="icon-search"></i>
										Tìm kiếm
									</button>
								</div>
							</div>
						</div>
						<div class="block-result">
							<?php echo nk_skeleton_animation_html( 20, '100%', 'height:20px', 'width:100%' ); ?>
							<div class="detail__booking-rooms">
                                <ul class="list-tour-search">
                                    <li class="tour-item">
                                        <div class="left-tour-item">
                                            <a href="http://vietnamvivu.ktwebtest.xyz/khach-san/pandora-boutique-hotel/">
                                                <img src="http://vietnamvivu.ktwebtest.xyz/wp-content/uploads/2022/10/pandora-boutique-hotel-1.jpg" alt="Pandora Boutique Hotel">
                                            </a>
                                        </div>
                                        <div class="right-tour-item">
                                            <h2 class="title-tour">
                                                <a href="http://vietnamvivu.ktwebtest.xyz/khach-san/pandora-boutique-hotel/">Pandora Boutique Hotel</a>
                                            </h2>
                                            <div class="rating">
                                                <i class="icon-star"></i>
                                                <i class="icon-star"></i>
                                                <i class="icon-star"></i>
                                                <i class="icon-star"></i>
                                            </div>
                                            <p class="dia-chi">
                                                <i class="fa fa-map-o" aria-hidden="true"></i>
                                                <span>
						21-23 Phan Tôn, Bắc Mỹ Phú, Ngũ Hành Sơn, Đà Nẵng					</span>
                                            </p>
                                            <ul class="tien-nghi">
                                                <li>
                                                    <i class="fa fa-check-square-o" aria-hidden="true"></i>
                                                    <span>Hồ bơi</span>
                                                </li>
                                                <li>
                                                    <i class="fa fa-check-square-o" aria-hidden="true"></i>
                                                    <span>Máy giặt</span>
                                                </li>
                                                <li>
                                                    <i class="fa fa-check-square-o" aria-hidden="true"></i>
                                                    <span>Máy nước nóng</span>
                                                </li>
                                                <li>
                                                    <i class="fa fa-check-square-o" aria-hidden="true"></i>
                                                    <span>Nhà hàng</span>
                                                </li>
                                            </ul>
                                            <div class="price-tour">
                                                <div class="price-left">
                                                    Giá chỉ từ:  <span>500,000 VNĐ</span>
                                                </div>
                                                <div class="price-right">
                                                    <a href="http://vietnamvivu.ktwebtest.xyz/khach-san/pandora-boutique-hotel/">Xem chi tiết</a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script defer>
	(function ($) {
		$(document).ready(function () {
            let sliderRange = $( "#slider-range" );
            sliderRange.slider({
                range: true,
                min: 0,
                max: 10000000,
                step: 100000,
				value: [ 0, 10000000 ],
                slide: function( event, ui ) {
                    $( "#amount" ).val( new Intl.NumberFormat('de-DE').format(ui.values[ 0 ] * 1)
                        + ' đ' + " - "
                        + new Intl.NumberFormat('de-DE').format( ui.values[ 1 ] * 1) + ' đ' );
                    $('input#min-filter').val(ui.values[ 0 ] * 1);
                    $('input#max-filter').val(ui.values[ 1 ] * 1);
                }
            });
            $( "#amount" ).val( new Intl.NumberFormat('de-DE').format(sliderRange.slider( "values", 0 ) * 1)
                + ' đ' + " - "
                + new Intl.NumberFormat('de-DE').format( sliderRange.slider( "values", 1 ) * 1) + ' đ' ) ;
            $('input#min-filter').val(sliderRange.slider( "values", 0 ) * 1);
            $('input#max-filter').val(sliderRange.slider( "values", 1 ) * 1);

            $(".search-left .mobile-close").click(function () {
                if ($(this).parent().hasClass("hide")) {
                    $(this).parent().removeClass("hide");
                    $(this).parent().css("transform", "translateX(0)");
                } else {
                    $(this).parent().addClass("hide");
                    $(this).parent().css("transform", "translateX(-100%)");
                }
            })
		})
	})(jQuery)
</script>
<?php get_footer(); ?>