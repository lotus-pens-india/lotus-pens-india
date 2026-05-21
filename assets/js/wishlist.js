$(document).ready(()=>{getWishlistItems()});const getWishlistItems=()=>{$("#cart_items_div").LoadingOverlay("show");let s=localStorage.getItem("wishlistValues");var t={url:`${$("#base_url_input").val()}wishlist_items`,method:"POST",timeout:0,data:{wishlistItems:s}};$.ajax(t).done(function(s){$("#cart_items_div").LoadingOverlay("hide");let t=JSON.parse(s);if(200==t.status&&t.data.length>0){let e=productUi(t.data);$("#wishlist_products_div").empty(),$("#wishlist_products_div").append(e)}else localStorage.setItem("wishlistValues",JSON.stringify([])),$("#wishlist_products_div").empty()})},productUi=s=>{if(s&&s.length>0){let t="";for(let e=0;e<s.length;e++)t+=`<div class="col-xs-6 col-sm-6 col-md-6 col-lg-3">
            <div class="img-wrapper">
                <img src="${$("#base_url_input").val()}/lotus_pens_admin/assets/images/product/${s[e].main_image}" />
                <div class="img-overview">
                    <a class="overview-link" type="button" onclick="openQuickView('<?= base_url('lotus_pens_admin/assets/') ?>images/product/<?= $product['main_image'] ?>')">Quick View</a>
                    <a class="overview-link" href="${$("#base_url_input").val()}product/${s[e].product_id}">Explore</a>
                </div>
            </div>
            <a href="<?= base_url() ?>product/${s[e].product_id}" style="cursor:pointer;text-decoration:none;color:black">
                <!-- <p class="best-seller-title">Bestseller</p> -->
                <p class="product-name">${s[e].product_name}</p>
                <!-- <p class="product-colors">4 Colours</p> -->
                <p class="product-amount">${$("#currency_symbol").val()} ${s[e].unit_price}</p>
            </a>
        </div>`;return t}};