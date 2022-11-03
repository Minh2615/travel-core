<?php get_header(); ?>
<?php get_header(); ?>
<div class="main-content page-search-tour cpt-tour">
	<div class="content-wrap">
		<div class="container">
			<div class="row">
				<div class="col search-left large-3 hide">
                    <div class="mobile-close">
                        <i class="fa fa-angle-right"></i>
                    </div>
					<div class="search-by-hotel-name">
						<div class="block-title">
							<h3>Tìm kiếm</h3>
						</div>
						<div class="search-group">
							<input value="" type="text" name="hotel-name" placeholder="Tìm kiếm Tour...">
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
							<h3>Địa điểm</h3>
						</div>
						<div class="search-group">
							<?php 
								$terms_noi_o = get_terms(
									array(
										'taxonomy' => 'map-tour',
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
				</div>
				<div class="col search-right large-9 medium-12">
					<div class="block-container">
						<div class="result-count" style="display:none;">
							Tìm thấy <span class="total-hotel">22</span> Tour <span class="hotel-address"></span>                                             
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
                } else {
                    $(this).parent().addClass("hide");
                }
            })
		})
	})(jQuery)
</script>
<?php get_footer(); ?>


<?php get_footer(); ?>