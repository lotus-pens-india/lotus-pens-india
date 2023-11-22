$(document).ready(() => {
    getWishlistItems();
});
const getWishlistItems = () => {
    $("#cart_items_div").LoadingOverlay("show");
    const wishlistItems = localStorage.getItem("wishlistValues");
    var settings = {
        url: `${$("#base_url_input").val()}wishlist_items`,
        method: "POST",
        timeout: 0,
        data: { wishlistItems: wishlistItems },
    };

    $.ajax(settings).done(function (resp) {
        $("#cart_items_div").LoadingOverlay("hide");
        const response = JSON.parse(resp);
        if (response.status == 200 && response.data.length > 0) {
            // const rawData = response.body.rawData;
            // localStorage.setItem("wishlistValues", JSON.stringify(rawData));
            const ui = productUi(response.data);
            $("#wishlist_products_div").empty();
            $("#wishlist_products_div").append(ui);
        } else {
            localStorage.setItem("wishlistValues", JSON.stringify([]));
            $("#wishlist_products_div").empty();
        }
    });
};

const productUi = (productData) => {
    if (productData && productData.length > 0) {
        let ui = '';
        for (let i = 0; i < productData.length; i++) {
            ui += `<div class="col-xs-6 col-sm-6 col-md-6 col-lg-3">
            <div class="img-wrapper">
                <img src="${$('#base_url_input').val()}/lotus_pens_admin/assets/images/product/${productData[i]['main_image']}" />
                <div class="img-overview">
                    <a class="overview-link" type="button" onclick="openQuickView('<?= base_url('lotus_pens_admin/assets/') ?>images/product/<?= $product['main_image'] ?>')">Quick View</a>
                    <a class="overview-link" href="${$('#base_url_input').val()}product/${productData[i]['product_id']}">Explore</a>
                </div>
            </div>
            <a href="<?= base_url() ?>product/${productData[i]['product_id']}" style="cursor:pointer;text-decoration:none;color:black">
                <!-- <p class="best-seller-title">Bestseller</p> -->
                <p class="product-name">${productData[i]['product_name']}</p>
                <!-- <p class="product-colors">4 Colours</p> -->
                <p class="product-amount">${$('#currency_symbol').val()} ${productData[i]['unit_price']}</p>
            </a>
        </div>`;
        }
        return ui;
    }

}