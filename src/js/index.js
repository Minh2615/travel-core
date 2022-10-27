/** search api */
const urlCurrent = document.location.href;
const urlPageSearch = hotel_settings?.url_page_search;
let filterRooms = {
    dia_diem : null,
    s : '',
    min_price : 0,
    max_price:0,
    star : 0,
    loai_hinh : [],
    tien_ich: [],
    page: 1,
};


const skeleton = document.querySelector('.page-search-tour .block-result ul.search-nk-skeleton-animation');
const wrapperResult = document.querySelector('.page-search-tour .block-result .detail__booking-rooms');

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
    
    const urlWphbSearch = wphbAddQueryArgs( wpRestUrl + 'travel-core/v1/search-tours', { ...args } );

    wp.apiFetch( {
        path: 'travel-core/v1/search-tours' + urlWphbSearch.search,
        method: 'GET',
    } ).then( ( response ) => {

        const { status, data , message , total, address } = response;
        
       
        
        const paginationEle = document.querySelector( '.rooms-pagination' );
		if ( paginationEle ) {
			paginationEle.remove();
		}
        
        if ( status === 'error' ) {
            throw new Error( message || 'Error' );
        }
        wrapperResult.style.display = 'block';
        wrapperResult.innerHTML = data.content;

        const pagination = data.pagination;
       
        if ( typeof pagination !== 'undefined' ) {
			const paginationHTML = new DOMParser().parseFromString( pagination, 'text/html' );
			const paginationNewNode = paginationHTML.querySelector( '.rooms-pagination' );

			if ( paginationNewNode ) {
				wrapperResult.after( paginationNewNode );
				wphbPaginationRoom( filterRooms, skeleton, wrapperResult );
			}
		}
        const eleCount = document.querySelector('.search-right .result-count');
        if( total > 0 ) {
            eleCount.style.display = 'block';
            const eleTotal = document.querySelector('.search-right span.total-hotel');
            if ( total && eleTotal !== null){
                eleTotal.innerText = total;
            }
            const eleAddress = document.querySelector('.search-right span.hotel-address');
            if ( address != 'null' && eleAddress !== null){
                eleAddress.innerText = 'tại ' + address;
            }
        }else{
            eleCount.style.display = 'none';
        }

    }).catch(( error ) => { 
        wrapperResult.insertAdjacentHTML( 'beforeend', `<p class="wphb-message error" style="display:block">${ error.message || 'Error: Query wphb/v1/rooms/search-room' }</p>` );
    }).finally( () => {
        skeleton.style.display = 'none';       
        const contentPageSearch = document.querySelector('.main-content.page-search-tour');
        if ( contentPageSearch != null ) {
            contentPageSearch.scrollIntoView({behavior: "smooth"});
        }
    });
}

const searchTourText = ( filterRooms, skeleton , wrapperResult ) => {
    const elemSearchText = document.querySelector('.search-by-hotel-name .search-group');
    if ( elemSearchText !== null) {
        const btn = elemSearchText.querySelector('.btn-search-by-hotel-name');
        if ( btn !== null ) {
            btn.addEventListener('click', function(e){
                e.preventDefault();
                wrapperResult.innerHTML = '';
                skeleton.style.display = 'block';
                const input = elemSearchText.querySelector('input[name="hotel-name"]');
                filterRooms.s = input.value;
                requestSearchRoom(filterRooms);
                
            });
        }
    }
}
const filterPriceRooms = ( filterRooms, skeleton , wrapperResult ) => {
    const btn = document.querySelector('.price-filter #range-slider a.btn-filter-price');
    if ( btn !== null) {
        btn.addEventListener('click', function(e){
            e.preventDefault();
            wrapperResult.innerHTML = '';
            skeleton.style.display = 'block';
            const min = document.querySelector('#range-slider input#min-filter')?.value;
            const max = document.querySelector('#range-slider input#max-filter')?.value;
            if ( min !== 0 && max !== 0  ) {
                filterRooms.min_price = min;
                filterRooms.max_price = max;
                requestSearchRoom(filterRooms);
            }
        });
    }
}

const filterLoaiHinh = ( filterRooms, skeleton , wrapperResult ) =>{
    const filterLoaiHinh = document.querySelectorAll('.search-by-tx-hotel .search-item input[name="tx_hotel"]');
    if ( filterLoaiHinh.length > 0 ) {
        filterLoaiHinh.forEach( ( item ) => {
            item.addEventListener('change', function(e){
                if ( this.checked ) {
                    filterRooms.loai_hinh.push( this.value );
                } else {
                    filterRooms.loai_hinh = filterRooms.loai_hinh.filter( ( item ) => item !== this.value );
                }
                wrapperResult.innerHTML = '';
                skeleton.style.display = 'block';
                requestSearchRoom(filterRooms);
            });
        });
    }
}

const filterTienIch = ( filterRooms, skeleton , wrapperResult ) =>{
    const filterTienIch = document.querySelectorAll('.search-by-convenient .search-item input[name="tx_convenient"]');
    if ( filterTienIch.length > 0 ) {
        filterTienIch.forEach( ( item ) => {
            item.addEventListener('change', function(e){
                if ( this.checked ) {
                    filterRooms.tien_ich.push( this.value );
                } else {
                    filterRooms.tien_ich = filterRooms.tien_ich.filter( ( item ) => item !== this.value );
                }
                wrapperResult.innerHTML = '';
                skeleton.style.display = 'block';
                requestSearchRoom(filterRooms);
            });
        });
    }
}



const wphbPaginationRoom = ( filterRooms, skeleton, wrapperResult ) => {
	const paginationEle = document.querySelectorAll( '.page-search-tour .rooms-pagination .page-numbers' );

	paginationEle.length > 0 && paginationEle.forEach( ( ele ) => ele.addEventListener( 'click', ( event ) => {
		event.preventDefault();
		event.stopPropagation();

        wrapperResult.style.display = 'none';
        skeleton.style.display = 'block';        
		const urlString = event.currentTarget.getAttribute( 'href' );

		if ( urlString ) {
			const current = [ ...paginationEle ].filter( ( el ) => el.classList.contains( 'current' ) );
			const paged = parseInt( event.currentTarget.textContent ) || ( ele.classList.contains( 'next' ) && parseInt( current[ 0 ].textContent ) + 1 ) || ( ele.classList.contains( 'prev' ) && parseInt( current[ 0 ].textContent ) - 1 );
			filterRooms.paged = paged;

			requestSearchRoom( filterRooms );
		}
	} ) );
};

const searchFormCategory = ( filterRooms, skeleton , wrapperResult ) => {
    const btn = document.querySelector('.search-right button.submit-search-room');
    if ( btn === null ){
        return;
    }
    btn.addEventListener('click',function(e){
        const tax = document.querySelector('#form-search-key');
        if( tax !== null ){
            wrapperResult.innerHTML = '';
            skeleton.style.display = 'block';
            filterRooms.dia_diem = tax.value;
            requestSearchRoom(filterRooms);
        }
    });
}

const searchFormRating = ( filterRooms, skeleton , wrapperResult ) => {
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
    console.log(quantity);
    const quantityValue = document.querySelectorAll('.hotel-room-number .number-room #numberOfroom');
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


document.addEventListener( 'DOMContentLoaded', () => {
    if ( custom_script_travel.is_search_ks == 1 ) {
        searchRoomsPages();//use in page search room
        searchTourText( filterRooms, skeleton , wrapperResult );
        filterPriceRooms( filterRooms, skeleton , wrapperResult );
        filterLoaiHinh( filterRooms, skeleton , wrapperResult );
        filterTienIch( filterRooms, skeleton , wrapperResult );
        searchFormCategory( filterRooms, skeleton , wrapperResult );
        searchFormRating( filterRooms, skeleton , wrapperResult );
    }
    //single ks
    changeQuantity();
} );
