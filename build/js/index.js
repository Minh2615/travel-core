!function(){var e;document.location.href,null===(e=hotel_settings)||void 0===e||e.url_page_search;let t={dia_diem:null,s:"",min_price:0,max_price:0,star:0,loai_hinh:[],tien_ich:[],page:1};const n=document.querySelector(".page-search-tour .block-result ul.search-nk-skeleton-animation"),r=document.querySelector(".page-search-tour .block-result .detail__booking-rooms"),o=e=>{const o=hotel_settings.wphb_rest_url;if(!o)return;const c=((e,t)=>{const n=new URL(e);return Object.keys(t).forEach((e=>{n.searchParams.set(e,t[e])})),n})(o+"travel-core/v1/search-tours",{...e});wp.apiFetch({path:"travel-core/v1/search-tours"+c.search,method:"GET"}).then((e=>{const{status:o,data:c,message:l,total:a,address:i}=e,u=document.querySelector(".rooms-pagination");if(u&&u.remove(),"error"===o)throw new Error(l||"Error");r.style.display="block",r.innerHTML=c.content;const h=c.pagination;if(void 0!==h){const e=(new DOMParser).parseFromString(h,"text/html").querySelector(".rooms-pagination");e&&(r.after(e),s(t,n,r))}const d=document.querySelector(".search-right .result-count");if(a>0){d.style.display="block";const e=document.querySelector(".search-right span.total-hotel");a&&null!==e&&(e.innerText=a);const t=document.querySelector(".search-right span.hotel-address");"null"!=i&&null!==t&&(t.innerText="tại "+i)}else d.style.display="none"})).catch((e=>{r.insertAdjacentHTML("beforeend",`<p class="wphb-message error" style="display:block">${e.message||"Error: Query wphb/v1/rooms/search-room"}</p>`)})).finally((()=>{n.style.display="none";const e=document.querySelector(".main-content.page-search-tour");null!=e&&e.scrollIntoView({behavior:"smooth"})}))},c=(e,t,n)=>{const r=document.querySelectorAll('.search-by-tx-hotel .search-item input[name="tx_hotel"]');r.length>0&&r.forEach((r=>{r.addEventListener("change",(function(r){this.checked?e.loai_hinh.push(this.value):e.loai_hinh=e.loai_hinh.filter((e=>e!==this.value)),n.innerHTML="",t.style.display="block",o(e)}))}))},l=(e,t,n)=>{const r=document.querySelectorAll('.search-by-convenient .search-item input[name="tx_convenient"]');r.length>0&&r.forEach((r=>{r.addEventListener("change",(function(r){this.checked?e.tien_ich.push(this.value):e.tien_ich=e.tien_ich.filter((e=>e!==this.value)),n.innerHTML="",t.style.display="block",o(e)}))}))},s=(e,t,n)=>{const r=document.querySelectorAll(".page-search-tour .rooms-pagination .page-numbers");r.length>0&&r.forEach((c=>c.addEventListener("click",(l=>{if(l.preventDefault(),l.stopPropagation(),n.style.display="none",t.style.display="block",l.currentTarget.getAttribute("href")){const t=[...r].filter((e=>e.classList.contains("current"))),n=parseInt(l.currentTarget.textContent)||c.classList.contains("next")&&parseInt(t[0].textContent)+1||c.classList.contains("prev")&&parseInt(t[0].textContent)-1;e.paged=n,o(e)}}))))};document.addEventListener("DOMContentLoaded",(()=>{o(t),((e,t,n)=>{const r=document.querySelector(".search-by-hotel-name .search-group");if(null!==r){const c=r.querySelector(".btn-search-by-hotel-name");null!==c&&c.addEventListener("click",(function(c){c.preventDefault(),n.innerHTML="",t.style.display="block";const l=r.querySelector('input[name="hotel-name"]');""!==l.value&&(e.s=l.value,o(e))}))}})(t,n,r),((e,t,n)=>{const r=document.querySelector(".price-filter #range-slider a.btn-filter-price");null!==r&&r.addEventListener("click",(function(r){var c,l;r.preventDefault(),n.innerHTML="",t.style.display="block";const s=null===(c=document.querySelector("#range-slider input#min-filter"))||void 0===c?void 0:c.value,a=null===(l=document.querySelector("#range-slider input#max-filter"))||void 0===l?void 0:l.value;0!==s&&0!==a&&(e.min_price=s,e.max_price=a,o(e))}))})(t,n,r),c(t,n,r),l(t,n,r),((e,t,n)=>{const r=document.querySelector(".search-right button.submit-search-room");null!==r&&r.addEventListener("click",(function(r){const c=document.querySelector("#form-search-key");null!==c&&(n.innerHTML="",t.style.display="block",e.dia_diem=c.value,o(e))}))})(t,n,r),((e,t,n)=>{const r=document.querySelectorAll('.search-by-hotel-ranking input[name="ranking"]');r.length>0&&r.forEach((function(r){r.addEventListener("change",(function(){r.checked&&(n.innerHTML="",t.style.display="block",e.star=r.value,o(e))}))}))})(t,n,r)}))}();