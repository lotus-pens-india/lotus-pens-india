$(document).ready(function () {
  if ($("#rating_form").length) {
    $("#rating_form").validate({
      rules: {
        cname: { required: true, minlength: 2 },
        review: { required: true, minlength: 20 }
      },
      messages: {
        cname: { required: "Name is required", minlength: "Name should be greater than 2 characters" },
        review: { required: "Review is required", minlength: "Enter review more than 20 characters" }
      },
      submitHandler: function () {
        let rating = 0;
        for (let i = 1; i <= 5; i++) {
          if ($(`#rating-${i}`).prop("checked")) {
            rating = i;
          }
        }

        const request = {
          url: `${$("#base_url_input").val()}save_review`,
          method: "POST",
          timeout: 0,
          data: {
            customer_name: $("#cname").val(),
            review: $("#review").val(),
            rating: rating,
            product_id: $("#product_code_text").val()
          }
        };

        $.ajax(request).done(function (response) {
          const parsed = JSON.parse(response);
          if (parsed.status === 200 || parsed === true) {
            window.location.reload();
          } else {
            showInvalidToast(parsed.body || "Unable to save review");
          }
        });
      }
    });
  }

  initPremiumSelects();

  $(".item__boxes").on("click", function () {
    const index = $(this).attr("data-slick-index");
    if ($(".product-slider").hasClass("slick-initialized")) {
      $(".product-slider").slick("slickGoTo", index);
    }
  });
});

function initPremiumSelects() {
  $("select.select-club-services").each(function () {
    const $select = $(this);
    if ($select.parent().hasClass("selectDropdown")) {
      return;
    }

    const $wrapper = $("<div />").addClass("select-club-services selectDropdown");
    $select.wrap($wrapper);
    const $span = $("<span />").text($select.find("option:selected").text() || $select.attr("placeholder") || "Select").insertAfter($select);
    const $list = $("<ul />");

    $select.find("option").each(function () {
      $list.append($("<li />").append($("<a />").attr("href", "#").text($(this).text())));
    });

    $list.insertAfter($span);
    $list.find("li").eq($select.prop("selectedIndex")).addClass("active");
    $select.parent().addClass("filled");
  });
}

$(document).on("click touch", ".selectDropdown ul li a", function (event) {
  event.preventDefault();
  const $item = $(this).parent();
  const $wrapper = $item.closest(".selectDropdown");
  const $select = $wrapper.find("select");
  const index = $item.index();

  $wrapper.find("ul li").removeClass("active");
  $item.addClass("active");
  $select.prop("selectedIndex", index).trigger("change");
  $wrapper.children("span").text($(this).text());
  $wrapper.addClass("filled").removeClass("open");

  if ($select.attr("id") === "material_select") {
    changeMaterialImage();
  }
});

$(document).on("click touch", ".select-club-services > span", function () {
  $(this).parent().toggleClass("open");
});

$(document).on("click touch", function (event) {
  const $select = $(".select-club-services");
  if (!$select.is(event.target) && $select.has(event.target).length === 0) {
    $select.removeClass("open");
  }
});

function selectColor(id) {
  $("#parent_div_of_color").find(".prod-options-slide").removeClass("prod-options-slide-first");
  $("#parent_div_of_color").find("p").removeClass("selected_color");
  $(`#${id}`).addClass("prod-options-slide-first");
  $(`#${id}_text`).addClass("selected_color");
}

function selectClipOption(id) {
  if (id === "with_clip") {
    $("#without_clip").removeClass("active-option selected_clip");
    $("#with_clip").addClass("active-option selected_clip");
  }

  if (id === "without_clip") {
    $("#with_clip").removeClass("active-option selected_clip");
    $("#without_clip").addClass("active-option selected_clip");
  }
}

function addToCart() {
  $("#page_body").LoadingOverlay("show");
  const isLoggedIn = $("#is_user_login").val();
  const clipOption = $(".selected_clip").attr("id");
  const selectedColor = $(".selected_color").text() || "Default";
  const nib = $("#nib_select").val();
  const clip = $("#clip_select").val();
  const material = $("#material_select").val();
  const productId = $("#product_code_text").val();
  const productName = $("#product_name_div").text();
  const requestedQty = Math.max(parseInt($("#product_qty").val() || "1", 10), 1);
  let cartValues = JSON.parse(localStorage.getItem("cartValues") || "[]");

  let existingIndex = -1;
  for (let i = 0; i < cartValues.length; i++) {
    if (
      cartValues[i].productId == productId &&
      cartValues[i].clipOption == clipOption &&
      cartValues[i].selectedColor == selectedColor &&
      cartValues[i].nib == nib &&
      cartValues[i].clip == clip &&
      cartValues[i].material == material
    ) {
      existingIndex = i;
      break;
    }
  }

  if (existingIndex >= 0) {
    cartValues[existingIndex].quantity = parseInt(cartValues[existingIndex].quantity || 0, 10) + requestedQty;
  } else {
    cartValues.push({
      productId: productId,
      clipOption: clipOption,
      selectedColor: selectedColor,
      nib: nib,
      clip: clip,
      material: material,
      quantity: requestedQty
    });
  }

  localStorage.setItem("cartValues", JSON.stringify(cartValues));

  if (isLoggedIn && true == isLoggedIn) {
    addToCartDb();
  } else if (typeof getCartItems === "function") {
    getCartItems();
  } else if (typeof getCartItemsCount === "function") {
    getCartItemsCount();
  }

  $("#page_body").LoadingOverlay("hide");
  showAddToCartToast(productName);
}

function addToWishlist() {
  const productId = $("#product_code_text").val();
  let wishlistValues = JSON.parse(localStorage.getItem("wishlistValues") || "[]");

  if (wishlistValues.indexOf(productId) === -1) {
    wishlistValues.push(productId);
    localStorage.setItem("wishlistValues", JSON.stringify(wishlistValues));
    toastr.success("Added to your wishlist", "Saved", {
      closeButton: true,
      progressBar: true,
      positionClass: "toast-top-right",
      timeOut: "3000"
    });
  } else {
    toastr.info("Already in your wishlist", "Saved", {
      closeButton: true,
      progressBar: true,
      positionClass: "toast-top-right",
      timeOut: "3000"
    });
  }
}

function showAddToCartToast(productName) {
  toastr.success(`${productName} added to your cart`, "Product Added", {
    closeButton: true,
    debug: false,
    newestOnTop: false,
    progressBar: true,
    positionClass: "toast-top-right",
    preventDuplicates: false,
    onclick: null,
    showDuration: "300",
    hideDuration: "1000",
    timeOut: "5000",
    extendedTimeOut: "1000",
    showEasing: "swing",
    hideEasing: "linear",
    showMethod: "fadeIn",
    hideMethod: "fadeOut"
  });
}

function showInvalidToast(message) {
  toastr.error(message, {
    closeButton: true,
    debug: false,
    newestOnTop: false,
    progressBar: true,
    positionClass: "toast-top-right",
    preventDuplicates: false,
    onclick: null,
    showDuration: "300",
    hideDuration: "1000",
    timeOut: "5000",
    extendedTimeOut: "1000",
    showEasing: "swing",
    hideEasing: "linear",
    showMethod: "fadeIn",
    hideMethod: "fadeOut"
  });
}

function removeFromCart(index) {
  const isLoggedIn = $("#is_user_login").val();
  $("#cart_items_div").LoadingOverlay("show");
  let cartValues = JSON.parse(localStorage.getItem("cartValues") || "[]");

  if (cartValues.length > 0) {
    cartValues.splice(index, 1);
    localStorage.setItem("cartValues", JSON.stringify(cartValues));
    if (isLoggedIn && true == isLoggedIn) {
      addToCartDb();
    } else {
      getCartItems();
    }
  }

  $("#cart_items_div").LoadingOverlay("hide");
}

function addQuantityToCart(index) {
  const isLoggedIn = $("#is_user_login").val();
  $("#cart_items_div").LoadingOverlay("show");
  let cartValues = JSON.parse(localStorage.getItem("cartValues") || "[]");

  if (cartValues.length > 0) {
    cartValues[index].quantity = parseInt(cartValues[index].quantity || 0, 10) + 1;
    localStorage.setItem("cartValues", JSON.stringify(cartValues));
    if (isLoggedIn && true == isLoggedIn) {
      addToCartDb();
    } else {
      getCartItems();
    }
  }

  $("#cart_items_div").LoadingOverlay("hide");
}

function removeQuantityToCart(index) {
  const isLoggedIn = $("#is_user_login").val();
  $("#cart_items_div").LoadingOverlay("show");
  let cartValues = JSON.parse(localStorage.getItem("cartValues") || "[]");

  if (cartValues.length > 0) {
    cartValues[index].quantity = parseInt(cartValues[index].quantity || 0, 10) - 1;
    if (cartValues[index].quantity <= 0) {
      cartValues.splice(index, 1);
    }
    localStorage.setItem("cartValues", JSON.stringify(cartValues));
    if (isLoggedIn && true == isLoggedIn) {
      addToCartDb();
    } else {
      getCartItems();
    }
  }

  $("#cart_items_div").LoadingOverlay("hide");
}

function changeMaterialImage() {
  const materialId = $("#material_select").val();
  if (!materialId) {
    return;
  }

  const request = {
    url: `${$("#base_url_input").val()}material_image`,
    method: "POST",
    data: { id: materialId }
  };

  $.ajax(request).done(function (response) {
    const parsed = JSON.parse(response);
    if (parsed && parsed[0] && parsed[0].image) {
      const imageUrl = `${$("#base_url_input").val()}lotus_pens_admin/assets/images/material/${parsed[0].image}`;
      $("#material_image").attr("src", imageUrl);
      $("#view_material_button").attr("onclick", `openQuickView("${imageUrl}")`);
    }
  });
}
