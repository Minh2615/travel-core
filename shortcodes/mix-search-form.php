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
                    <img width="30px" src="<?php echo TRAVEL_CORE_URL . "build/img/icon_hotel.png" ?>" alt="hotel">
                    <span class="title">Đặt phòng khách sạn trực tuyến giá rẻ</span>
                </p>

                <form class="m_b_0px" action="" method="get">
                    <div class="form-content">
                        <div>
                            <label for="dia-diem">Địa điểm</label>
                            <div class="form-input location">
                                <input type="text" name="location-search" placeholder="Nhập địa điểm">
                            </div>
                            <!--                sub search-->
                            <div class="sub-search sub-location-search">
		                        <?php
		                        $terms = get_terms(["taxanomy" => "dia-diem"]);
		                        ?>
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

                        <div>
                            <label for="checkin">Thời gian lưu trú</label>
                            <div class="form-input duration">
                                <input type="daterange" name="duration" value="01/01/2018 - 01/15/2018">
                            </div>
                        </div>

<!--                        <div>-->
<!--                            <label for="checkout">Ngày trả phòng</label>-->
<!--                            <div class="form-input checkout">-->
<!--                                <input type="datetime-local" name="checkout" placeholder="Ngày trả phòng">-->
<!--                            </div>-->
<!--                        </div>-->

                        <div>
                            <label for="number_of_person">Số phòng và khách</label>
                            <div class="form-input people">
                                <input type="text" name="number_of_person" placeholder="Chọn số người" readonly>
                            </div>

<!--                            sub people select-->
                            <div class="sub-search sub-people-select">
                                <div class="sub-people-select__item room m_b_20px">
                                    <span class="bold">Phòng</span>
                                    <div class="count-total">
                                        <button class="count-total__minus">-</button>
                                        <span class="count-total__number">0</span>
                                        <button class="count-total__plus">+</button>
                                    </div>
                                </div>

                                <div class="sub-people-select__item adult m_b_20px">
                                    <span class="bold">Người lớn</span>
                                    <div class="count-total">
                                        <button class="count-total__minus">-</button>
                                        <span class="count-total__number">0</span>
                                        <button class="count-total__plus">+</button>
                                    </div>
                                </div>

                                <div class="sub-people-select__item children">
                                    <span class="bold">Trẻ em</span>
                                    <div class="count-total">
                                        <button class="count-total__minus">-</button>
                                        <span class="count-total__number">0</span>
                                        <button class="count-total__plus">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div></div>
                        <div></div>

                        <div>
                            <button class="hotel-btn-submit"> Tìm kiếm</button>
                        </div>
                    </div>
                </form>
            </div>
            <div id="tour-tab" class="tab-content tour">
                <p>tour-tab</p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js" integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
            $('input[name="duration"]').daterangepicker();
            $(".flight-tab").click();

            // hotel item click
            $(".hotel-list span").click(function () {
                $('input[name="location-search"]').val($(this).text());
            })

            // sub search click
            $('input[name="location-search"]').click(function (e) {
                e.stopPropagation();
                $(".sub-location-search").fadeIn();
            });
            $('input[name="number_of_person"]').click(function (e) {
                e.stopPropagation();
                $(".sub-people-select").fadeIn();
            });
            $(".sub-search").click(function (e) {
                e.stopPropagation();
            })
            $(document).click(function () {
                $(".sub-search").fadeOut();
            })

            // minus plus
            $(".count-total__minus").click(function (e) {
                e.preventDefault();
                e.stopPropagation();
                let current = parseInt($(this).parent().children(".count-total__number").text());
                if (current > 0)
                    $(this).parent().children(".count-total__number").text( current - 1 );
                updatePeopleInput();
            })
            $(".count-total__plus").click(function (e) {
                e.preventDefault();
                e.stopPropagation();
                let current = parseInt($(this).parent().children(".count-total__number").text());
                $(this).parent().children(".count-total__number").text( current + 1 );
                updatePeopleInput();
            })

            function updatePeopleInput () {
                let room_count = parseInt($(".room .count-total__number").text());
                let person_count = parseInt($(".adult .count-total__number").text()) + parseInt($(".children .count-total__number").text());

                let text = room_count + " phòng, " + person_count + " người"
                $('input[name="number_of_person"]').val(text);
            }

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