$(document).ready(() => {
  getWishlistItems();
});

const getWishlistItems = () => {
  $("#wishlist_products_div").LoadingOverlay("show");
  const wishlistItems = localStorage.getItem("wishlistValues");
  const request = {
    url: `${$("#base_url_input").val()}wishlist_items`,
    method: "POST",
    timeout: 0,
    data: { wishlistItems: wishlistItems }
  };

  $.ajax(request).done(function (response) {
    $("#wishlist_products_div").LoadingOverlay("hide");
    const parsed = JSON.parse(response);

    if (parsed.status === 200 && parsed.data.length > 0) {
      $("#wishlist_products_div").empty().append(productUi(parsed.data));
      $("#wishlist_empty_state").prop("hidden", true);
    } else {
      localStorage.setItem("wishlistValues", JSON.stringify([]));
      $("#wishlist_products_div").empty();
      $("#wishlist_empty_state").prop("hidden", false);
    }
  });
};

const productUi = (products) => {
  let html = "";
  const baseUrl = $("#base_url_input").val();
  const currency = $("#currency_symbol").val();

  if (products && products.length > 0) {
    for (let index = 0; index < products.length; index++) {
      const product = products[index];
      const imageUrl = `${baseUrl}lotus_pens_admin/assets/images/product/${product.main_image}`;
      html += `
        <article class="lp-product-card">
          <a class="lp-product-media" href="${baseUrl}product/${product.product_id}">
            <span class="lp-product-badge">Saved</span>
            <img src="${imageUrl}" alt="${product.product_name}" title="${product.product_name}">
          </a>
          <div class="lp-product-actions">
            <button type="button" onclick="openQuickView('${imageUrl}')" title="Quick view" aria-label="Quick view"><i class="fa fa-eye"></i></button>
            <a href="${baseUrl}product/${product.product_id}" title="Explore" aria-label="Explore"><i class="fa fa-arrow-right"></i></a>
          </div>
          <div class="lp-product-body">
            <p class="lp-product-category">Wishlist</p>
            <a href="${baseUrl}product/${product.product_id}" class="lp-product-title">${product.product_name}</a>
            <div class="lp-product-footer">
              <span class="lp-price">${currency} ${product.unit_price}</span>
              <a class="lp-mini-link" href="${baseUrl}product/${product.product_id}">Details</a>
            </div>
          </div>
        </article>
      `;
    }
  }

  return html;
};
