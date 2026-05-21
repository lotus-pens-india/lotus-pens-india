$(document).ready(() => {
  getCartItems();
});

function getCartItems() {
  $("#cart_items_div").LoadingOverlay("show");
  const cartItems = localStorage.getItem("cartValues");
  const request = {
    url: `${$("#base_url_input").val()}shopping_cart`,
    method: "POST",
    timeout: 0,
    data: { cartItems: cartItems }
  };

  $.ajax(request).done(function (response) {
    $("#cart_items_div").LoadingOverlay("hide");
    const parsed = JSON.parse(response);

    if (parsed.status === 200 && parsed.body.productInfo.length > 0) {
      localStorage.setItem("cartValues", JSON.stringify(parsed.body.rawData));
      $("#cart_items_div").empty().append(createCartItemsUi(parsed.body.productInfo));
      $("#cart_items_count").text(parsed.body.cartItemsCount);
      $("#cart_items_count_mobile").text(parsed.body.cartItemsCount);
      $("#summary_price").text(parsed.body.cartSummaryAmt);
      $("#total_item_value").val(parsed.body.cartSummaryAmt);
      $("#summary_price_total").text(parsed.body.cartSummaryAmtWithShipping);
      $("#shpping_price").text(parsed.body.shppingCharges == 0 ? "Free" : parsed.body.shppingCharges);
    } else {
      localStorage.setItem("cartValues", JSON.stringify([]));
      $("#main_cart_page_div").empty().append(`
        <section class="lp-section">
          <div class="lp-empty-state">
            <img src="${$("#base_url_input").val()}assets/images/empty_cart.svg" style="width:180px;max-width:55%;margin-bottom:22px" alt="Empty cart">
            <h2 class="lp-section-title">Your cart is empty</h2>
            <p>Start with a handcrafted Lotus piece and return here when you are ready.</p>
            <a href="${$("#base_url_input").val()}products" class="btn btn-primary mt-3">Start Shopping</a>
          </div>
        </section>
      `);
    }
  });
}

function createCartItemsUi(items) {
  let html = "";
  const currency = $("#currency_symbol").val();

  if (items && items.length > 0) {
    for (let index = 0; index < items.length; index++) {
      const product = items[index].productInformation[0];
      const clipOption = items[index].clipOption === "with_clip" ? "With Clip" : "Without Clip";
      const nib = items[index].nibData[0];
      const material = items[index].materialData[0];
      const clip = items[index].clipData[0];
      const quantity = items[index].quantity;
      const optionRows = [
        `Clip: ${clipOption}${clip ? ", " + clip.name : ""}`,
        nib ? `Nib: ${nib.name}` : "",
        material ? `Material: ${material.name}` : ""
      ].filter(Boolean).map((row) => `<span>${row}</span>`).join("");

      html += `
        <article class="row cart-page-items">
          <div class="col-4 col-md-3 col-lg-2 p-0">
            <a class="img-wrapper d-block" href="${$("#base_url_input").val()}product/${product.product_id}">
              <img src="${$("#base_url_input").val()}lotus_pens_admin/assets/images/product/${product.main_image}" alt="${product.product_name}">
            </a>
          </div>
          <div class="col-8 col-md-9 col-lg-10">
            <div class="d-flex justify-content-between gap-3">
              <div>
                <a href="${$("#base_url_input").val()}product/${product.product_id}" class="lp-product-title">${product.product_name}</a>
                <div class="d-flex flex-wrap gap-2 mt-2 cart-option-list">${optionRows}</div>
              </div>
              <button type="button" class="lp-icon-btn" onclick="removeFromCart(${index})" title="Remove" aria-label="Remove">
                <i class="fa fa-trash"></i>
              </button>
            </div>
            <div class="d-flex align-items-center justify-content-between mt-3">
              <strong class="lp-price">${currency} ${items[index].finalAmount}</strong>
              <div class="quantity">
                <button type="button" class="lp-icon-btn" onclick="removeQuantityToCart(${index})" title="Decrease" aria-label="Decrease"><i class="fa fa-minus"></i></button>
                <input type="text" name="quantity_${index}" value="${quantity}" readonly>
                <button type="button" class="lp-icon-btn" onclick="addQuantityToCart(${index})" title="Increase" aria-label="Increase"><i class="fa fa-plus"></i></button>
              </div>
            </div>
          </div>
        </article>
      `;
    }
  }

  return html;
}

function processToCheckout() {
  const isLoggedIn = $("#is_user_login").val();
  if (isLoggedIn && true == isLoggedIn) {
    const couponCode = $("#coupon_code").val();
    window.location.href = `${$("#base_url_input").val()}${couponCode !== "" ? `checkout/${couponCode}` : "checkout/none"}`;
  } else {
    $("#loginModal").modal("show");
  }
}

function checkCouponCode() {
  $("#cart_items_div").LoadingOverlay("show");
  const couponCode = ($("#coupon_code").val() || "").trim().toLowerCase();

  if (couponCode === "dad20") {
    const discount = ($("#total_item_value").val() / 100) * 20;
    const total = parseInt($("#summary_price_total").text(), 10) - discount;
    const subtotal = parseInt($("#summary_price").text(), 10) - discount;
    $("#summary_price").text(subtotal);
    $("#summary_price_total").text(total);
    $("#coupon_message").text("Coupon applied");
    $("#checkCouponCodeBtn").prop("disabled", true);
    $("#coupon_code").prop("disabled", true);
  } else {
    $("#coupon_message").text("Invalid coupon code");
  }

  $("#cart_items_div").LoadingOverlay("hide");
}

function placeOrder() {
  const request = {
    url: `${$("#base_url_input").val()}place_order`,
    method: "POST"
  };

  $.ajax(request).done(function (response) {
    const parsed = JSON.parse(response);
    if (parsed.status === 200) {
      localStorage.setItem("cartValues", parsed.body.cart_json);
      getCartItems();
    }
  });
}
