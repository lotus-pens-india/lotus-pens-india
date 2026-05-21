$(document).ready(function () {
  loadCountries();

  let currentFieldset;
  let nextFieldset;
  let previousFieldset;
  let opacity;
  let currentStep = 1;
  const stepCount = $("fieldset").length;
  let paymentInitialized = false;

  function setProgressBar(step) {
    const percentage = (parseFloat(100 / stepCount) * step).toFixed();
    $(".progress-bar").css("width", percentage + "%");
  }

  function addValidationRules() {
    $.validator.addMethod("alphabetsnspace", function (value, element) {
      return this.optional(element) || /^[a-zA-Z ]*$/.test(value);
    });

    if (currentStep === 1) {
      return {
        rules: {
          fname: { required: true, alphabetsnspace: true, minlength: 2 },
          lname: { required: true, alphabetsnspace: true, minlength: 2 },
          email: { required: true, email: true, maxlength: 255 },
          phone: { required: true, digits: true, minlength: 10, maxlength: 10 }
        },
        messages: {
          fname: { required: "Please Enter First Name", alphabetsnspace: "Please Enter Only Character", minlength: "Please Enter First Name More than 2 Letters" },
          lname: { required: "Please Enter Last Name", alphabetsnspace: "Please Enter Only Character", minlength: "Please Enter Last Name" },
          email: { required: "Please Enter Email Id" },
          phone: { required: "Please Enter Phone Number", digits: "Please Enter Only Number", maxlength: "Please Enter 10 digit Number" }
        }
      };
    }

    if (currentStep === 2) {
      $("#billing_post_code").rules("add", { required: true, messages: { required: "Please Enter Postal Code" } });
      $("#billing_address_1").rules("add", { required: true, minlength: 2, messages: { required: "Please Enter Address", minlength: "Please Enter Address" } });
      $("#billing_city").rules("add", { required: true, alphabetsnspace: true, minlength: 2, messages: { required: "Please Enter City", alphabetsnspace: "Please Enter Only Character", minlength: "Please Enter City" } });
    }

    if (currentStep === 3) {
      $("#d_fname").rules("add", { required: true, alphabetsnspace: true, minlength: 2, messages: { required: "Please Enter First Name", alphabetsnspace: "Please Enter Only Character", minlength: "Please Enter First Name" } });
      $("#d_lname").rules("add", { required: true, alphabetsnspace: true, minlength: 2, messages: { required: "Please Enter Last Name", alphabetsnspace: "Please Enter Only Character", minlength: "Please Enter Last Name" } });
      $("#d_post_code").rules("add", { required: true, messages: { required: "Please Enter Postal Code" } });
      $("#d_address_1").rules("add", { required: true, minlength: 2, messages: { required: "Please Enter Address", minlength: "Please Enter Address" } });
      $("#d_city").rules("add", { required: true, alphabetsnspace: true, minlength: 2, messages: { required: "Please Enter City", alphabetsnspace: "Please Enter Only Character", minlength: "Please Enter City" } });
    }

    return { rules: {}, messages: {} };
  }

  function moveToNext() {
    $("#progressbar li").eq($("fieldset").index(nextFieldset)).addClass("active");
    nextFieldset.show();
    currentFieldset.animate(
      { opacity: 0 },
      {
        step: function (now) {
          opacity = 1 - now;
          currentFieldset.css({ display: "none", position: "relative" });
          nextFieldset.css({ opacity: opacity });
        },
        duration: 500
      }
    );
    setProgressBar(++currentStep);
  }

  function getCouponCodeFromUrl() {
    const segments = window.location.pathname.split("/").filter((segment) => segment !== "");
    return segments.length > 1 ? segments[segments.length - 1] : "";
  }

  function getDiscountedTotals(cartBody) {
    let usdTotal = cartBody.cartSummaryAmtWithShipping;
    let inrTotal = cartBody.cartSummaryAmtInr;
    const couponCode = getCouponCodeFromUrl().toLowerCase();

    if (couponCode === "dad20") {
      usdTotal = cartBody.cartSummaryAmtWithShipping - (cartBody.cartSummaryAmt / 100) * 20;
      inrTotal = cartBody.cartSummaryAmtInr - (cartBody.cartSummaryAmtInr / 100) * 20;
    }

    return {
      usdTotal: usdTotal,
      inrTotal: inrTotal
    };
  }

  function initializePaymentButtons() {
    if (paymentInitialized) {
      return;
    }

    $("#page_body").LoadingOverlay("show");
    const cartItems = localStorage.getItem("cartValues");
    const request = {
      url: `${$("#base_url_input").val()}shopping_cart`,
      method: "POST",
      timeout: 0,
      data: { cartItems: cartItems }
    };

    $.ajax(request).done(function (response) {
      $("#page_body").LoadingOverlay("hide");
      const parsed = JSON.parse(response);
      if (parsed.status !== 200 || parsed.body.productInfo.length === 0) {
        return;
      }

      const totals = getDiscountedTotals(parsed.body);
      const firstName = $("#fname").val();
      const lastName = $("#lname").val();

      if (window.paypal && $("#paypal-button").children().length === 0) {
        paypal.Buttons({
          createOrder: function (data, actions) {
            const billingCountry = $("#billing_country").find(":selected").attr("data-country_code");
            const deliveryCountry = $("#d_country").find(":selected").attr("data-country_code");
            const billingState = $("#billing_state").find(":selected").attr("data-state_code");
            const deliveryState = $("#d_state").find(":selected").attr("data-state_code");

            return actions.order.create({
              payer: {
                name: { given_name: firstName, surname: lastName },
                address: {
                  address_line_1: $("#billing_address_1").val(),
                  address_line_2: $("#billing_address_2").val(),
                  admin_area_2: $("#billing_city").val(),
                  admin_area_1: billingState,
                  postal_code: $("#billing_post_code").val(),
                  country_code: billingCountry
                },
                email_address: $("#email").val(),
                phone: { phone_type: "MOBILE", phone_number: { national_number: $("#phone").val() } }
              },
              purchase_units: [
                {
                  amount: { value: totals.usdTotal, currency_code: "USD" },
                  shipping: {
                    name: { fullname: `${firstName} ${lastName}` },
                    address: {
                      address_line_1: $("#d_address_1").val(),
                      address_line_2: $("#d_address_2").val(),
                      admin_area_2: $("#d_city").val(),
                      admin_area_1: deliveryState,
                      postal_code: $("#d_post_code").val(),
                      country_code: deliveryCountry
                    }
                  }
                }
              ]
            });
          },
          onApprove: function (data, actions) {
            $("#page_body").LoadingOverlay("show");
            return actions.order.capture().then(function (details) {
              placeOrderFunction(JSON.stringify(details));
            });
          }
        }).render("#paypal-button");
      }

      const deliveryCountry = $("#d_country").find(":selected").attr("data-country_code");
      const deliveryState = $("#d_state").find(":selected").attr("data-state_code");
      const razorpayOptions = {
        key: "rzp_live_UyBi6t05gqB2NU",
        name: "Lotus Pens",
        image: `${$("#base_url_input").val()}assets/images/Lotus_Logo.png`,
        amount: 100 * totals.inrTotal,
        currency: "INR",
        description: "Order of Lotus Pens",
        handler: function (paymentResponse) {
          placeOrderFunction(JSON.stringify(paymentResponse));
        },
        prefill: { contact: $("#phone").val(), email: $("#email").val() },
        notes: {
          address: `${$("#d_address_1").val()}, ${$("#d_address_2").val()}, ${$("#d_city").val()}, ${deliveryState}, ${$("#d_post_code").val()}, ${deliveryCountry}`
        }
      };

      if (window.Razorpay) {
        const razorpayInstance = new Razorpay(razorpayOptions);
        document.getElementById("rzp-button1").onclick = function (event) {
          razorpayInstance.open();
          event.preventDefault();
        };
      }

      paymentInitialized = true;
    });
  }

  setProgressBar(currentStep);

  $(".next-checkout-btn").click(function () {
    currentFieldset = $(this).parent();
    nextFieldset = $(this).parent().next();
    const validationConfig = addValidationRules();
    const form = $("#msform");
    const validator = form.validate({
      rules: validationConfig.rules,
      messages: validationConfig.messages,
      submitHandler: function () {
        if (currentStep === 3) {
          initializePaymentButtons();
        }
        moveToNext();
      }
    });

    validator.resetForm();
  });

  $(".previous").click(function () {
    currentFieldset = $(this).parent();
    previousFieldset = $(this).parent().prev();
    $("#progressbar li").eq($("fieldset").index(currentFieldset)).removeClass("active");
    previousFieldset.show();
    currentFieldset.animate(
      { opacity: 0 },
      {
        step: function (now) {
          opacity = 1 - now;
          currentFieldset.css({ display: "none", position: "relative" });
          previousFieldset.css({ opacity: opacity });
        },
        duration: 500
      }
    );
    setProgressBar(--currentStep);
  });
});

function placeOrderFunction(paymentDetails) {
  $("#page_body").LoadingOverlay("show");
  const orderData = {
    billing_details: {
      company: $("#billling_company").val(),
      post_code: $("#billing_post_code").val(),
      add_1: $("#billing_address_1").val(),
      add_2: $("#billing_address_2").val(),
      city: $("#billing_city").val(),
      country: $("#billing_country").val(),
      state: $("#billing_state").val()
    },
    delivery_details: {
      firstname: $("#d_fname").val(),
      lastname: $("#d_lname").val(),
      company: $("#d_company").val(),
      post_code: $("#d_post_code").val(),
      add_1: $("#d_address_1").val(),
      add_2: $("#d_address_2").val(),
      city: $("#d_city").val(),
      country: $("#d_country").val(),
      state: $("#d_state").val(),
      note: $("#d_note").val()
    }
  };
  const request = {
    url: `${$("#base_url_input").val()}place_order`,
    method: "POST",
    data: { orderData: orderData, paymentDetails: paymentDetails }
  };

  $.ajax(request).done(function (response) {
    const parsed = JSON.parse(response);
    $("#page_body").LoadingOverlay("hide");
    if (parsed.status === 200) {
      window.location.href = `${$("#base_url_input").val()}order_confirm/${parsed.order_id}`;
    }
  });
}

function sameAsBillingAddress(id) {
  if ($("#" + id).is(":checked")) {
    $("#d_fname").val($("#fname").val());
    $("#d_lname").val($("#lname").val());
    $("#d_company").val($("#billling_company").val());
    $("#d_post_code").val($("#billing_post_code").val());
    $("#d_address_1").val($("#billing_address_1").val());
    $("#d_address_2").val($("#billing_address_2").val());
    $("#d_city").val($("#billing_city").val());
    $("#d_country").val($("#billing_country").val()).trigger("change");
    $("#d_state").val($("#billing_state").val()).trigger("change");
  } else {
    $("#d_fname").val("");
    $("#d_lname").val("");
    $("#d_company").val("");
    $("#d_post_code").val("");
    $("#d_address_1").val("");
    $("#d_address_2").val("");
    $("#d_city").val("");
    $("#d_country").val("");
    $("#d_state").val("");
  }
}
