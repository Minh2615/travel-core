<?php get_header(); ?>
	<div class="flex-row container">
		<div class="block-detail-tour-content">
			<div class="form-search-tour">
				<div class="frontpage-box-form-inner">
					<div class="frontpage-box-tabs-form">
						<div class="box-title">
							Du lịch 5 châu, không đâu rẻ bằng
						</div>
						<div class="box-search-tour">
							<label for="search-tour-text">Nhập địa điểm bạn muốn đến</label>
							<div class="input-search">
								<i class="fa fa-map-o" aria-hidden="true"></i>
								<input type="text" name="search-tour-text" id="search-tour-text" placeholder="Quốc gia, thành phố, địa điểm du lịch">
							</div>
							<div class="box-button-tour">
								<a href="<?php echo get_permalink(get_page_by_path('search-tour')); ?>">
									Tìm Kiếm
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="single-box-content">
				<div class="container">
					<div class="row">
						<div class="col col-lg-8">
							<div class="single-box-content-inner">
								<h1 class="title-tour">
									<?php echo get_the_title(); ?>
								</h1>
								<div class="single-content">
									
									<div class="gallery-tour">
										<div class="owl-carousel owl-theme">
											<?php
												if( have_rows('gallery') ):
													while( have_rows('gallery') ) : the_row();
														$img = get_sub_field('hinh_anh');?>
														<div class="item">
															<img src="<?php echo $img ?>" alt="">
														</div>
													<?php endwhile;
												endif;
											?>
										</div>
									</div>
									<div class="box-tlb-tour">
										<?php
											$list_img = array(
												'o_to' => 'https://www.vietnambooking.com/wp-content/themes/vietnambooking_master/images/index/tour/icon_traffic/o_to.png',
												'may_bay' => 'https://www.vietnambooking.com/wp-content/themes/vietnambooking_master/images/index/tour/icon_traffic/may_bay.png'
											);
											$phuong_tien = get_field('vehicle') ? explode( ',', get_field('vehicle') ) : [] ;
										?>
										<table class="tlb-info-tour">
											<tbody><tr>
												<td><i class="fa fa-map-o" aria-hidden="true"></i>
												<?php echo get_field('dia_chi_khach_san'); ?></td>
												<td><i class="fa fa-clock-o" aria-hidden="true"></i> <span><?php echo get_field('duration'); ?></span></td>
												<td>
													<span>Phương tiện: </span>
													<?php foreach($phuong_tien as $value){
														if( array_key_exists( trim($value), $list_img)){ ?>
															<img class="img-traffic" title="<?php echo $value; ?>" src="<?php echo $list_img[trim($value)]; ?>">
														<?php }
													} ?>
												</td>
												<td>
													<span class="title-tour">Mã tour: </span>
													<span class="id-tour">
														<?php echo get_field('code'); ?>                                   
													</span>
												</td>
												</tr>
												<tr>
													<td colspan="4" class="depart_time"><i class="fa fa-calendar" aria-hidden="true"></i>Khởi hành: <span><?php echo get_field('depart_time'); ?></span></td>
												</tr>
											</tbody>
										</table>
									</div>
									<div class="dich-vu-tour">
										<?php echo get_the_content(); ?>
									</div>
									<div class="panel-group" id="tour-product">
										<?php

												$rows = get_field('tab_tour');
												if( !empty($row) ) : 
													foreach( $rows as $key => $row ) {
													$title = $row['tieu_de'];
													$content_tab = $row['noi_dung_tab'];
													if( $key == 0 ){
														$class='active';
													}else{
														$class='';
													}
													?>
													<div class="panel panel-tour-product <?php echo $key; ?>">
														<div class="panel-heading">
															<h4 class="panel-title" data-tab="tab-tour-<?php echo $key ?>">
																<a href="#">
																	<?php echo $title; ?>
																	<i class="fa fa-chevron-up" aria-hidden="true"></i>
																</a>
															</h4>
														</div>
														<div class="panel-content <?php echo $class; ?>" id="tab-tour-<?php echo $key; ?>">
															<?php echo $content_tab; ?>
														</div>
													</div>
												<?php  };
												endif;
										?>
									</div>
									<div class="box-tour-product-relative">
										<h4>Các tour khác có thể bạn quan tâm</h4>
										<ul>
											<?php 
											$args = array(
												'post_type' => 'travel-tour',
												'posts_per_page' => 5,
												'post__not_in' => array(get_the_ID()),
											);
											$the_query = new WP_Query( $args );
											if ( $the_query->have_posts() ) :
											while ( $the_query->have_posts() ) : $the_query->the_post();?>
												<li>
													<a href="<?php echo get_permalink();?>">
														<div class="box-img">
															<img src="<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>" alt="">
														</div>
														<div class="box-content">
															<div class="title-h4">
																<?php echo get_the_title();?>
															</div>
															<div class="box-price">
																Giá:  <span><?php echo number_format( get_field( 'gia_tour' , get_the_ID() ) ); ?> VNĐ</span>
															</div>
															<div class="box-date-start">
																<i class="fa fa-calendar-check-o" aria-hidden="true"></i>
																<?php echo get_field('depart_time', get_the_ID()); ?>
															</div>
														</div>
													</a>
												</li>
											<?php endwhile;
											endif;
											wp_reset_postdata();
											?>
										</ul>
										
									</div>
									<div class="box-posts-relation">
										<h4>Bài viết mới nhất</h4>
										<ul>
											<?php 
											$args = array(
												'post_type' => 'post',
												'posts_per_page' => 5,
											);
											$the_query = new WP_Query( $args );
											if ( $the_query->have_posts() ) :
											while ( $the_query->have_posts() ) : $the_query->the_post();?>
												<li>
													<a href="<?php echo get_permalink();?>">
														<i class="fa fa-chevron-right" aria-hidden="true"></i>
														<?php echo get_the_title(get_the_ID()); ?>
													</a>
												</li>
											<?php endwhile;
											endif;
											wp_reset_postdata();
											?>
										</ul>
									</div>
									<div class="box-social">
										<div class="box-hotline">
											<img class="lazy" src="https://data.vietnambooking.com/common/single/single_banner_tour.jpg" alt="banner contact" style="display: inline-block;">
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col col-lg-4">
							<div class="sidebar-box-tour">
								<div class="box-form-price-tour vertical">
									<table class="tlb-box-price-tour">
										<tbody>
											<tr>
												<td colspan="2">
													<span class="price-tour">
														<div class="title-price-old"></div><?php echo number_format( get_field( 'price_ks' , get_the_ID() ) ); ?> <span>VND/người</span>
													</span>
												</td>
											</tr>
											<tr>
												<td><label>Khởi hành</label></td>
												<td>
													<input required="required" name="id" value="179636" type="hidden">
													<input data-role="none" value="<?php echo date('d/m/Y'); ?>" name="date_start" class="form-control txt-date-start" required="required" id="date_start">
												</td>
											</tr>
											<tr>
												<td><label>Số khách</label></td>
												<td>
													<select data-role="none" data-price="7490000" name="number_people" class="form-control slc-tour-people">
														<option value="1">01 Khách</option>
														<option value="2">02 Khách</option>
														<option value="3">03 Khách</option>
														<option value="4">04 Khách</option>
														<option value="5">05 Khách</option>
														<option value="6">06 Khách</option>
														<option value="7">07 Khách</option>
														<option value="8">08 Khách</option>
														<option value="9">09 Khách</option>
														<option value="10">10 Khách</option>
													</select>
												</td>
											</tr>
											<tr>
												<td colspan="2"><button data-role="none" class="btn-submit-set-tour" type="submit">Đặt Tour</button></td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="sidebar-box-item">
									<h3>TỔNG ĐÀI TƯ VẤN</h3>
									<div class="sidebar-box-content sidebar-hotline">
										<label>Mọi thắc mắc của Quý khách</label>
										vui lòng gọi:<a href="tel:19003398">1900 3398</a>
										<span class="span-note">Chúng tôi hỗ trợ 24/7</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<script type="text/javascript">
	jQuery(document).ready(function($){
		$('.owl-carousel').owlCarousel({
			loop:true,
			margin:10,
			nav:false,
			items:1,
			center: true
		});
		var checkin = $('#date_start');
		checkin.datepicker({});

		$('.panel-group .panel-tour-product').click(function(e){
			e.preventDefault();
			if($(this).find('.panel-content').hasClass('active')){
				$(this).find('.panel-content.active').removeClass('active');
			}else{
				$(this).find('.panel-content').addClass('active');
			}
		})
	});
</script>
<?php get_footer(); ?>
