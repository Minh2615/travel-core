/** search api */
const urlCurrent = document.location.href;
const urlPageSearch = custom_script_travel?.url_page_search;
// let filterRooms = {
//     dia_diem : '',
//     s : '',
//     min_price : 0,
//     max_price:0,
//     star : 0,
//     loai_hinh : [],
//     tien_ich: [],
//     page: 1,
// };
let filterRooms = JSON.parse(window.localStorage.getItem('wphb_filter_rooms')) || {};



const skeleton = document.querySelector('.page-search-tour .block-result ul.search-nk-skeleton-animation');
const wrapperResult = document.querySelector('.page-search-tour .block-result .detail__booking-rooms');
const urlApi = custom_script_travel.url_api;

const wphbAddQueryArgs = ( endpoint, args ) => {
	const url = new URL( endpoint );

	Object.keys( args ).forEach( ( arg ) => {
		url.searchParams.set( arg, args[ arg ] );
	} );

	return url;
};

const searchRoomsPages = () => {
    requestSearchRoom( filterRooms );
}

const requestSearchRoom = ( args ) => {
    const wpRestUrl = hotel_settings.wphb_rest_url;

    if ( ! wpRestUrl ) {
        return;
    }
    
    if (Object.keys(args).length === 0) {
        args.dia_diem =0;
        args.text = '';
        args.min_price = 0;
        args.max_price = 0;
        args.star = 0;
        args.loai_hinh = [];
        args.tien_ich = [];
        args.paged = 1;
    }

    const urlWphbSearch = wphbAddQueryArgs( wpRestUrl + 'travel-core/v1/'+ urlApi, { ...args } );

    wp.apiFetch({
        path: 'travel-core/v1/' + urlApi + urlWphbSearch.search,
        method: 'GET',
    }).then((response) => {

        const { status, data, message, total, address } = response;

        const paginationEle = document.querySelector('.rooms-pagination');
        if (paginationEle) {
            paginationEle.remove();
        }
        
        if (status === 'error') {
            throw new Error(message || 'Error');
        }
        wrapperResult.style.display = 'block';
        wrapperResult.innerHTML = data.content;

        const pagination = data.pagination;
       
        if (typeof pagination !== 'undefined') {
            const paginationHTML = new DOMParser().parseFromString(pagination, 'text/html');
            const paginationNewNode = paginationHTML.querySelector('.rooms-pagination');

            if (paginationNewNode) {
                wrapperResult.after(paginationNewNode);
                wphbPaginationRoom(filterRooms, skeleton, wrapperResult);
            }
        }
        const eleCount = document.querySelector('.search-right .result-count');
        if (total > 0) {
            eleCount.style.display = 'block';
            const eleTotal = document.querySelector('.search-right span.total-hotel');
            if (total && eleTotal !== null) {
                eleTotal.innerText = total;
            }

            if (urlApi && urlApi == 'search-hotel') {
                const eleAddress = document.querySelector(
                    '.search-right span.hotel-address'
                );
                if (address && eleAddress !== null) {
                    eleAddress.innerText = 'tại ' + address;
                }
            }
        } else {
            eleCount.style.display = 'none';
        }

    }).catch((error) => {
        wrapperResult.insertAdjacentHTML('beforeend', `<p class="wphb-message error" style="display:block">${error.message || 'Error: Query wphb/v1/rooms/search-room'}</p>`);
    }).finally(() => {
        window.localStorage.setItem(
            'wphb_filter_rooms',
            JSON.stringify(args)
        );

        const urlPush = wphbAddQueryArgs(document.location, args);
        // console.log(urlPush);
        window.history.pushState('', '', urlPush);
        skeleton.style.display = 'none';       
        const contentPageSearch = document.querySelector('.main-content.page-search-tour');
        if ( contentPageSearch != null ) {
            contentPageSearch.scrollIntoView({behavior: "smooth"});
        }
    });
}

const searchTourText = (filterRooms, skeleton, wrapperResult) => {
    const elemSearchText = document.querySelector(
        '.search-by-hotel-name .search-group'
    );
    if (elemSearchText !== null) {
        const btn = elemSearchText.querySelector('.btn-search-by-hotel-name');
        if (btn !== null) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                wrapperResult.innerHTML = '';
                skeleton.style.display = 'block';
                const input = elemSearchText.querySelector(
                    'input[name="hotel-name"]'
                );
                filterRooms.text = input.value;
                window.localStorage.setItem(
                    'wphb_filter_rooms',
                    JSON.stringify(filterRooms)
                );
                requestSearchRoom(filterRooms);
            });
        }
    }
};
const filterPriceRooms = (filterRooms, skeleton, wrapperResult) => {
    const btn = document.querySelector(
        '.price-filter #range-slider a.btn-filter-price'
    );
    if (btn !== null) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            wrapperResult.innerHTML = '';
            skeleton.style.display = 'block';
            const min = document.querySelector(
                '#range-slider input#min-filter'
            )?.value;
            const max = document.querySelector(
                '#range-slider input#max-filter'
            )?.value;
            if (min !== 0 && max !== 0) {
                filterRooms.min_price = min;
                filterRooms.max_price = max;
                window.localStorage.setItem(
                     'wphb_filter_rooms',
                     JSON.stringify(filterRooms)
                );
                requestSearchRoom(filterRooms);
            }
        });
    }
};

const filterLoaiHinh = (filterRooms, skeleton, wrapperResult) => {
    const filterLoaiHinh = document.querySelectorAll(
        '.search-by-tx-hotel .search-item input[name="tx_hotel"]'
    );
    if (filterLoaiHinh.length > 0) {
        filterLoaiHinh.forEach((item) => {
            item.addEventListener('change', function (e) {
                if (this.checked) {
                    filterRooms.loai_hinh.push(this.value);
                } else {
                    filterRooms.loai_hinh = filterRooms.loai_hinh.filter(
                        (item) => item !== this.value
                    );
                }
                wrapperResult.innerHTML = '';
                skeleton.style.display = 'block';
                window.localStorage.setItem(
                    'wphb_filter_rooms',
                    JSON.stringify(filterRooms)
                );
                requestSearchRoom(filterRooms);
            });
        });
    }
};

const filterTienIch = (filterRooms, skeleton, wrapperResult) => {
    const filterTienIch = document.querySelectorAll(
        '.search-by-convenient .search-item input[name="tx_convenient"]'
    );
    if (filterTienIch.length > 0) {
        filterTienIch.forEach((item) => {
            item.addEventListener('change', function (e) {
                if (this.checked) {
                    filterRooms.tien_ich.push(this.value);
                } else {
                    filterRooms.tien_ich = filterRooms.tien_ich.filter(
                        (item) => item !== this.value
                    );
                }
                wrapperResult.innerHTML = '';
                skeleton.style.display = 'block';
                window.localStorage.setItem(
                    'wphb_filter_rooms',
                    JSON.stringify(filterRooms)
                );
                requestSearchRoom(filterRooms);
            });
        });
    }
};



const wphbPaginationRoom = (filterRooms, skeleton, wrapperResult) => {
    const paginationEle = document.querySelectorAll(
        '.page-search-tour .rooms-pagination .page-numbers'
    );

    paginationEle.length > 0 &&
        paginationEle.forEach((ele) =>
            ele.addEventListener('click', (event) => {
                event.preventDefault();
                event.stopPropagation();

                wrapperResult.style.display = 'none';
                skeleton.style.display = 'block';
                const urlString = event.currentTarget.getAttribute('href');

                if (urlString) {
                    const current = [...paginationEle].filter((el) =>
                        el.classList.contains('current')
                    );
                    const paged =
                        parseInt(event.currentTarget.textContent) ||
                        (ele.classList.contains('next') &&
                            parseInt(current[0].textContent) + 1) ||
                        (ele.classList.contains('prev') &&
                            parseInt(current[0].textContent) - 1);
                    filterRooms.paged = paged;
                    window.localStorage.setItem(
                        'wphb_filter_rooms',
                        JSON.stringify(filterRooms)
                    );
                    requestSearchRoom(filterRooms);
                }
            })
        );
};

const searchFormCategory = (filterRooms, skeleton, wrapperResult) => {
    const btn = document.querySelector(
        '.search-right button.submit-search-room'
    );
    if (btn === null) {
        return;
    }
    btn.addEventListener('click', function (e) {
        const tax = document.querySelector('#form-search-key');
        if (tax !== null) {
            wrapperResult.innerHTML = '';
            skeleton.style.display = 'block';
            filterRooms.dia_diem = tax.value;
            window.localStorage.setItem(
                'wphb_filter_rooms',
                JSON.stringify(filterRooms)
            );
            requestSearchRoom(filterRooms);
        }
    });
};

const searchFormRating = ( filterRooms, skeleton , wrapperResult) => {
    const ratings = document.querySelectorAll('.search-by-hotel-ranking input[name="ranking"]');
    if ( ratings.length > 0 ) {
        ratings.forEach( function( rating ){
            rating.addEventListener('change', function(){
                if ( rating.checked ){
                    filterRooms.star = rating.value;       
                }else{
                    filterRooms.star = '';
                }
               
                wrapperResult.innerHTML = '';
                skeleton.style.display = 'block';
                window.localStorage.setItem(
                    'wphb_filter_rooms',
                    JSON.stringify(filterRooms)
                );
                requestSearchRoom(filterRooms);
            });
        });
    }
  
}
/** end search api */

//single ks 
var timeout;
const changeQuantity = () => {
    const quantity = document.querySelectorAll('.hotel-room-number .number-room');
    const quantityValue = document.querySelectorAll('.hotel-room-number .number-room .numberOfroom');
    const quantityMinus = document.querySelectorAll('.hotel-room-number .number-room span#minus-room-ks');
    const quantityPlus = document.querySelectorAll('.hotel-room-number .number-room span#plus-room-ks');
    if ( quantity.length > 0 ) { 
        quantity.forEach((item, i) => {
            quantityMinus[i].addEventListener('click', () => {
                if (quantityValue[i].value > 1) {
                    quantityValue[i].value--;
                }
            });
            quantityPlus[i].addEventListener('click', () => {
                quantityValue[i].value++;
            });
        });
    }
}

const addToCartHotel = () => {
    const btn = document.querySelectorAll(".block-hotel-list-room-content .btn-booking-hotel");
   
    if ( btn.length > 0 ) {   
        const submit = async (data) => {
            try {
                const response = await wp.apiFetch({
                  path: "travel-core/v1/add-to-cart",
                  method: "POST",
                  data: data,
                });
            const { status, message, redirect } = response;
                if ("success" === status) {
                    // alert(message);
                    window.location.href = redirect;
                } else {
                  notify(message, false);
                }

            } catch (error) {
                console.log(error);
            }
        };
        btn.forEach((item, i) => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                const id = item.dataset.nid;
                const quantity = document.querySelector(`#numberOfroom-${id}`)?.value;
                const price = document.querySelector(`#price-room-${id}`)?.dataset.price;
                const data = {
                    id: id,
                    quantity: quantity,
                    price: price
                };
                submit(data);
            });
        });
    }
}

const checkoutHotel = () => {
    const btn = document.querySelector(".box-submit .btn-submit-contact-booking");
    if (btn !== null) {
        const submit = async (data) => {
          try {
            const response = await wp.apiFetch({
              path: "travel-core/v1/checkout",
              method: "POST",
              data: data,
            });
            const { status, message, redirect } = response;
            if ("success" === status) {
                alert(message);
                // window.location.href = redirect;
                window.location.href = "/success";
            } else {
              alert(message, false);
            }
        } catch (error) {
            console.log(error);
        }
        };
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const data = {};
            const form = document.querySelector("#form-hotel-create-booking");
            const formData = new FormData(form);
            formData.forEach((value, key) => {
                   data[key] = value;
            });
            // console.log(data);
            submit(data);
        });
    }
}

const checkoutTour = () => {
    const btn = document.querySelector('.book-tour button.checkout-tour');
    if (btn !== null) {
        const submit = async (data) => {
            try {
                const response = await wp.apiFetch({
                    path: 'travel-core/v1/checkout-tour',
                    method: 'POST',
                    data: data,
                });
                const { status, message, redirect } = response;
                if ('success' === status) {
                    alert(message);
                    window.location.href = redirect;
                } else {
                    alert(message, false);
                }
            } catch (error) {
                console.log(error);
            }
        };
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const data = {};
            const form = document.querySelector('#customer_booking_tour');
            const formData = new FormData(form);
            formData.forEach((value, key) => {
                data[key] = value;
            });
            console.log(data);
            submit(data);
        });
    }
}

const addToCartTour = () => {
    const btn = document.querySelector(
        '.block-detail-tour-content .add-cart-tour'
    );
     if (btn !== null) {
         const submit = async (data) => {
             try {
                 const response = await wp.apiFetch({
                     path: 'travel-core/v1/add-cart-tour',
                     method: 'POST',
                     data: data,
                 });
                 const { status, message, redirect } = response;
                 if ('success' === status) {
                     alert(message);
                     window.location.href = redirect;
                 } else {
                     notify(message, false);
                 }
             } catch (error) {
                 console.log(error);
             }
         };

         btn.addEventListener('click', (e) => {
             e.preventDefault();
             const id = btn.dataset.id;
             const capacity = document.querySelector(
                 'select[name="number_people"]'
             )?.value;
             const date_start = document.querySelector(
                 'input[name="date_start"]'
             )?.value;
             const price = btn.dataset.price; 
             const data = {
                 id: id,
                 date_start: date_start,
                 price: price,
                 capacity: capacity
            };
            submit(data);
         });
     }
}
const searchHotelHomePage = () => {
    const btn = document.querySelector('.mix-search .hotel-btn-submit');
    if (btn !== null) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const idDiaDiem = document.querySelector(
                'input[name="location-search-id"]'
            )?.value;
            filterRooms.dia_diem = idDiaDiem;
            window.localStorage.setItem(
                'wphb_filter_rooms',
                JSON.stringify(filterRooms)
            );
            const urlPush = wphbAddQueryArgs(document.location, filterRooms);
            const urlString = urlPush.search;
            window.location.href = urlPageSearch + urlString;
        });
    }
}

const selectFormTour = () => {
    const input = document.querySelector('input#search-tour-text');
    if (input !== null) {
        input.addEventListener('click', function (e) {
            e.preventDefault();
            const form = document.querySelector('#list-map-tour');
            form.classList.toggle('active');
        });
        const listTax = document.querySelectorAll('.list-tour-top');
        if (listTax.length > 0) {
            listTax.forEach((item, i) => {
                item.addEventListener('click', function (e) {
                    e.preventDefault();
                    const id = item.dataset.id;
                    const name = item.dataset.name;
                    const form = document.querySelector('#list-map-tour');
                    form.classList.toggle('active');
                    input.value = name;
                    input.dataset.id = id;
                });
            });
        }
        const btn = document.querySelector('.box-search-tour .box-button-tour');
        if (btn !== null) {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const data = [];
                const idDiaDiem = document.querySelector(
                    'input#search-tour-text'
                )?.dataset.id;
                data.push(idDiaDiem);
                filterRooms.loai_hinh = data;
                window.localStorage.setItem(
                    'wphb_filter_rooms',
                    JSON.stringify(filterRooms)
                );
                const urlPush = wphbAddQueryArgs(
                    document.location,
                    filterRooms
                );
                const urlString = urlPush.search;
                window.location.href = urlPageSearch + urlString;
            });
        }
        
    }
}

//
document.addEventListener( 'DOMContentLoaded', () => {
    if (
        custom_script_travel.is_search_ks == 1 ||
        custom_script_travel.is_search_tour == 1 ||
        custom_script_travel.is_archive_ks == 1
    ) {
        searchRoomsPages();
        searchTourText(filterRooms, skeleton, wrapperResult);
        filterPriceRooms(filterRooms, skeleton, wrapperResult);
        filterLoaiHinh(filterRooms, skeleton, wrapperResult);
        filterTienIch(filterRooms, skeleton, wrapperResult);
        searchFormCategory(filterRooms, skeleton, wrapperResult);
        searchFormRating(filterRooms, skeleton, wrapperResult);
    }
    //single ks
    changeQuantity();
    addToCartHotel();
    checkoutHotel();
    addToCartTour();
    checkoutTour();

    //form search home page
    searchHotelHomePage();
    //single tour
    selectFormTour();
} );
