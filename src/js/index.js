/** search api */
const urlCurrent = document.location.href;
const urlPageSearch = hotel_settings?.url_page_search;
let filterRooms = {
    dia_diem : null,
    so_phong : 0,
    so_nguoi_lon : 0,
    so_tre_em : 0,
    s : '',
    min_price : 0,
    max_price:0,
    star : 0,
    loai_hinh : '',
    tien_ich: ''
};

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

    const skeleton = document.querySelector('.page-search-tour .block-result ul.search-nk-skeleton-animation');
    const wrapperResult = document.querySelector('.page-search-tour .block-result .detail__booking-rooms');
    const wpRestUrl = hotel_settings.wphb_rest_url;

    if ( ! wpRestUrl ) {
        return;
    }
    
    const urlWphbSearch = wphbAddQueryArgs( wpRestUrl + 'travel-core/v1/search-tours', { ...args } );

    wp.apiFetch( {
        path: 'travel-core/v1/search-tours' + urlWphbSearch.search,
        method: 'GET',
    } ).then( ( response ) => {

        const { status, data , message } = response;

        const paginationEle = document.querySelector( '.rooms-pagination' );
		if ( paginationEle ) {
			paginationEle.remove();
		}

        if ( status === 'error' ) {
            throw new Error( message || 'Error' );
        }
        wrapperResult.style.display = 'block';
        wrapperResult.innerHTML = data.content;

        searchTourText( filterRooms, skeleton , wrapperResult);


        const pagination = data.pagination;
       
        if ( typeof pagination !== 'undefined' ) {
			const paginationHTML = new DOMParser().parseFromString( pagination, 'text/html' );
			const paginationNewNode = paginationHTML.querySelector( '.rooms-pagination' );

			if ( paginationNewNode ) {
				wrapperResult.after( paginationNewNode );
				wphbPaginationRoom( forms, skeleton, wrapperResult );
			}
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
                if ( input.value !== '' ) {
                    filterRooms.s = input.value;
                    requestSearchRoom(filterRooms);
                }
            });
        }
    }
}

const wphbPaginationRoom = ( forms, skeleton, wrapperResult ) => {
	const paginationEle = document.querySelectorAll( '.wp-hotel-booking-search-rooms .rooms-pagination .page-numbers' );

	paginationEle.length > 0 && paginationEle.forEach( ( ele ) => ele.addEventListener( 'click', ( event ) => {
		event.preventDefault();
		event.stopPropagation();

        wrapperResult.style.display = 'none';
        skeleton.style.display = 'block';

		let filterRooms = JSON.parse(window.localStorage.getItem('wphb_filter_rooms')) || {};
        
		const urlString = event.currentTarget.getAttribute( 'href' );

		if ( urlString ) {
			const current = [ ...paginationEle ].filter( ( el ) => el.classList.contains( 'current' ) );
			const paged = parseInt( event.currentTarget.textContent ) || ( ele.classList.contains( 'next' ) && parseInt( current[ 0 ].textContent ) + 1 ) || ( ele.classList.contains( 'prev' ) && parseInt( current[ 0 ].textContent ) - 1 );
			filterRooms.paged = paged;

			requestSearchRoom( forms, { ...filterRooms } );
		}
	} ) );
};
/** end search api */

document.addEventListener( 'DOMContentLoaded', () => {
    searchRoomsPages();//use in page search room
} );
