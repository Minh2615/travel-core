<?php
add_shortcode("mix-search-form", function ($atts) {
	extract(shortcode_atts(array(
	), $atts));

	ob_start(); ?>

    <div class="mix-search">
        <div class="mix-search__header">
            <div class="mix-search__title">
                <span>Vietnamvivu - Niềm tin của bạn</span>
            </div>
            <div class="mix-search__tab-panels">
                <ul>
                    <li class="active">
                        <a href="#flight-tab" class="flight-tab">
                            <img src="<?php echo TRAVEL_CORE_URL . "/build/img/icon_flight.png" ?>" alt="flight">
                            <span>Vé máy bay</span>
                        </a>
                    </li>
                    <li>
                        <a href="#hotel-tab" class="hotel-tab">
                            <img src="<?php echo TRAVEL_CORE_URL . "/build/img/icon_hotel.png" ?>" alt="hotel">
                            <span>Khách sạn</span>
                        </a>
                    </li>
                    <li>
                        <a href="#tour-tab" class="tour-tab">
                            <img src="<?php echo TRAVEL_CORE_URL . "/build/img/icon_tour.png" ?>" alt="tour">
                            <span>Du lịch</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="mix-search__content">
            <div id="flight-tab" class="tab-content flight">
                <div id="vjs-search"></div>
            </div>
            <div id="hotel-tab" class="tab-content hotel relative">
                <p class="m_b_20px">
                    <img width="" src="<?php echo TRAVEL_CORE_URL . "build/img/icon_hotel.png" ?>" alt="hotel">
                    <span class="title">Đặt phòng khách sạn trực tuyến giá rẻ</span>
                </p>

                <form class="m_b_0px" action="" method="get">
                    <div class="d-grid grid-4">
                        <div>
                            <label for="dia-diem">Địa điểm hoặc tên Khách sạn</label>
                            <div class="form-input location">
                                <input type="text" name="location-search" placeholder="Nhập địa điểm">
                            </div>
                        </div>

                        <div>
                            <label for="checkin">Ngày nhận phòng</label>
                            <div class="form-input checkin">
                                <input type="datetime-local" name="checkin" placeholder="Ngày nhận phòng">
                            </div>
                        </div>

                        <div>
                            <label for="checkout">Ngày trả phòng</label>
                            <div class="form-input checkout">
                                <input type="datetime-local" name="checkout" placeholder="Ngày trả phòng">
                            </div>
                        </div>

                        <div>
                            <label for="number_of_person">Số phòng và khách</label>
                            <div class="form-input people">
                                <select name="number_of_person">

                                </select>
                            </div>
                        </div>

                        <button class="hotel-btn-submit hotel-btn-submit-form-data" type="button"> Tìm kiếm</button>
                    </div>
                </form>
                <!--                sub search-->
                <?php
                $terms = get_terms(["taxanomy" => "dia-diem"]);
                ?>
                <div class="sub-location-search">
                    <p class="m_b_0px"><span>Chọn địa điểm</span></p>
                    <div id="tabs">
                        <ul>
                            <li><a href="#viet-nam" onclick="event.preventDefault();">Việt Nam</a></li>
                        </ul>
                        <div id="viet-nam">
		                    <?php $terms = get_terms([
			                    'taxonomy' => 'dia-diem'
		                    ]); ?>
                            <div class="hotel-list">
			                    <?php
			                    foreach ($terms as $term) : ?>
                                    <span class="pointer prevent-select"><?php echo $term->name; ?></span>
			                    <?php
			                    endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="tour-tab" class="tab-content tour">
                <p>tour-tab</p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js" integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>
    <script defer>
        (function () {
            $( ".mix-search__tab-panels ul li" ).click(function (e) {
                e.preventDefault();
                let id = $(this).children("a").attr("href");

                $( ".mix-search__tab-panels ul li" ).each((index, element) => {
                    if ($(element).children("a").attr("href") === id)
                        $(element).addClass("active");
                    else
                        $(element).removeClass("active");
                });
                $(".mix-search__content .tab-content").each((index, element) => {
                    if ($(element).attr("id") === id.replace("#", "") )
                        $(element).addClass("active");
                    else
                        $(element).removeClass("active");
                })
            })
            $("#tabs").tabs({
                active: 1
            });
            $(".hotel-list span").click(function () {
                $('input[name="location-search"]').val($(this).text());
            })
            $(".flight-tab").click();
        })(jQuery)
    </script>
    <script type='text/javascript'>
        var vjs_search = {
            path: ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.vinajet.vn/plugins',
            productKey: 'ADM-ADMVINAJET922',
            languageCode: 'vi',
            type: 'sidebar',//sidebar/full/short
            width: "550px",
            height: "550px"
        };
        (function () {
            var vjs_head = document.getElementsByTagName('head')[0];
            var vjs_script = document.createElement('script');
            vjs_script.async = true;
            vjs_script.src = vjs_search.path.concat('/tim-ve-bay-gia-re.min.js');
            vjs_script.charset = 'UTF-8';
            vjs_head.appendChild(vjs_script);
        })();
    </script>

	<?php
	$result = ob_get_contents();
	ob_end_clean();

	return $result;
});