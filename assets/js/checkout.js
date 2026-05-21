$(document).ready(function () {
    loadCountries();
    var e,
        a,
        t,
        n,
        l = 1,
        r = $("fieldset").length;
    function s(e) {
        var a = parseFloat(100 / r) * e;
        (a = a.toFixed()), $(".progress-bar").css("width", a + "%");
    }
    s(l),
        $(".next-checkout-btn").click(function () {
            $.validator.addMethod("alphabetsnspace", function (e, a) {
                return this.optional(a) || /^[a-zA-Z ]*$/.test(e);
            }),
                console.log("this is current", l),
                (e = $(this).parent()),
                (a = $(this).parent().next());
            let t = {},
                r = {};
            1 == l &&
                ((t = {
                    fname: { required: !0, alphabetsnspace: !0, minlength: 2 },
                    lname: { required: !0, alphabetsnspace: !0, minlength: 2 },
                    email: { required: !0, email: !0, maxlength: 255 },
                    phone: { required: !0, digits: !0, minlength: 10, maxlength: 10 },
                }),
                    (r = {
                        fname: { required: "Please Enter First Name", alphabetsnspace: "Please Enter Only Character", minlength: "Please Enter First Name More than 2 Letters" },
                        lname: { required: "Please Enter Last Name", alphabetsnspace: "Please Enter Only Character", minlength: "Please Enter Last Name" },
                        email: { required: "Please Enter Email Id" },
                        phone: { required: "Please Enter Phone Number", digits: "Please Enter Only Number", maxlength: "Please Enter 10 digit Number" },
                    })),
                2 == l &&
                ($("#billing_post_code").rules("add", { required: !0, messages: { required: "Please Enter Postal Code", digits: "Please Enter Only Number", minlength: "Please Enter Valid Post Code" } }),
                    $("#billing_address_1").rules("add", { required: !0, minlength: 2, messages: { required: "Please Enter Address", minlength: "Please Enter Address" } }),
                    $("#billing_city").rules("add", { required: !0, alphabetsnspace: !0, minlength: 2, messages: { required: "Please Enter City", alphabetsnspace: "Please Enter Only Character", minlength: "Please Enter City" } })),
                3 == l &&
                ($("#d_fname").rules("add", { required: !0, alphabetsnspace: !0, minlength: 2, messages: { required: "Please Enter First Name", alphabetsnspace: "Please Enter Only Character ", minlength: "Please Enter First Name" } }),
                    $("#d_lname").rules("add", { required: !0, alphabetsnspace: !0, minlength: 2, messages: { required: "Please Enter Last Name", alphabetsnspace: "Please Enter Only Character", minlength: "Please Enter Last Name" } }),
                    $("#d_post_code").rules("add", { required: !0, messages: { required: "Please Enter Postal Code", digits: "Please Enter Only Number", minlength: "Please Enter Valid Post Code" } }),
                    $("#d_address_1").rules("add", { required: !0, minlength: 2, messages: { required: "Please Enter Address", minlength: "Please Enter Address" } }),
                    $("#d_city").rules("add", { required: !0, alphabetsnspace: !0, minlength: 2, messages: { required: "Please Enter City", alphabetsnspace: "Please Enter Only Character", minlength: "Please Enter City" } }));
            var d = $("#msform");
            let i = d.validate({
                rules: t,
                messages: r,
                submitHandler: function (t) {
                    if (3 == l) {
                        $("#cart_items_div").LoadingOverlay("show");
                        let r = localStorage.getItem("cartValues");
                        var d = { url: `${$("#base_url_input").val()}shopping_cart`, method: "POST", timeout: 0, data: { cartItems: r } };
                        $.ajax(d).done(function (e) {
                            $("#cart_items_div").LoadingOverlay("hide");
                            let a = JSON.parse(e);
                            if (200 == a.status && a.body.productInfo.length > 0) {
                                let t = a.body.cartSummaryAmtWithShipping,
                                    n = a.body.cartSummaryAmtInr,
                                    l = window.location.href,
                                    r = new URL(l),
                                    s = r.pathname,
                                    d = s.split("/").filter((e) => "" !== e),
                                    i = d[1];
                                if (("" != i && "DAD20" == i) || "dad20" == i) {
                                    let o = a.body.cartSummaryAmt,
                                        c = a.body.cartSummaryAmtInr;
                                    (t = a.body.cartSummaryAmtWithShipping - (o / 100) * 20), (n = a.body.cartSummaryAmtInr - (c / 100) * 20);
                                }
                                paypal
                                    .Buttons({
                                        createOrder: function (e, a) {
                                            let n = $("#fname").val(),
                                                l = $("#lname").val(),
                                                r = $("#billing_country").find(":selected").attr("data-country_code"),
                                                s = $("#d_country").find(":selected").attr("data-country_code"),
                                                d = $("#billing_state").find(":selected").attr("data-state_code"),
                                                i = $("#d_state").find(":selected").attr("data-state_code");
                                            return a.order.create({
                                                payer: {
                                                    name: { given_name: n, surname: l },
                                                    address: {
                                                        address_line_1: $("#billing_address_1").val(),
                                                        address_line_2: $("#billing_address_2").val(),
                                                        admin_area_2: $("#billing_city").val(),
                                                        admin_area_1: d,
                                                        postal_code: $("#billing_post_code").val(),
                                                        country_code: r,
                                                    },
                                                    email_address: $("#email").val(),
                                                    phone: { phone_type: "MOBILE", phone_number: { national_number: $("#phone").val() } },
                                                },
                                                purchase_units: [
                                                    {
                                                        amount: { value: t, currency_code: "USD" },
                                                        shipping: {
                                                            name: { fullname: `${n} ${l}` },
                                                            address: {
                                                                address_line_1: $("#d_address_1").val(),
                                                                address_line_2: $("#d_address_2").val(),
                                                                admin_area_2: $("#d_city").val(),
                                                                admin_area_1: i,
                                                                postal_code: $("#d_post_code").val(),
                                                                country_code: s,
                                                            },
                                                        },
                                                    },
                                                ],
                                            });
                                        },
                                        onApprove: function (e, a) {
                                            return (
                                                $("#page_body").LoadingOverlay("show"),
                                                a.order.capture().then(function (e) {
                                                    placeOrderFunction(JSON.stringify(e));
                                                })
                                            );
                                        },
                                    })
                                    .render("#paypal-button"),
                                    $("#fname").val(),
                                    $("#lname").val(),
                                    $("#billing_country").find(":selected").attr("data-country_code");
                                let u = $("#d_country").find(":selected").attr("data-country_code");
                                $("#billing_state").find(":selected").attr("data-state_code");
                                let m = $("#d_state").find(":selected").attr("data-state_code"),
                                    p = {
                                        key: "rzp_live_UyBi6t05gqB2NU",
                                        name: "Lotus Pens",
                                        image: `${$("#base_url_input").val()}assets/images/Lotus_Logo.png`,
                                        amount: 100 * n,
                                        currency: "INR",
                                        description: "order of lotus pens",
                                        handler: function (e) {
                                            placeOrderFunction(JSON.stringify(e));
                                        },
                                        prefill: { contact: $("#phone").val(), email: $("#email").val() },
                                        notes: {
                                            address: `${$("#d_address_1").val()},
									 ${$("#d_address_2").val()},
						${$("#d_city").val()},
							 ${m},
								${$("#d_post_code").val()},
									${u}, `,
                                        },
                                    };
                                var y = new Razorpay(p);
                                document.getElementById("rzp-button1").onclick = function (e) {
                                    y.open(), e.preventDefault();
                                };
                                let g = document.querySelector(".btn");
                                (function e() {
                                    if (!p.key.includes("rzp_test") && !p.key.includes("rzp_live")) {
                                        let a = document.createElement("p");
                                        (a.innerHTML = `Enter a valid API Key in the JS editor and the pay button will appear here automatically 😉`),
                                            a.classList.add("bg-55"),
                                            g.appendChild(a),
                                            document.querySelector("#rzp-button1").remove();
                                    }
                                })(),
                                    console.log(p.key.includes("rzp_test"));
                            }
                        });
                    }
                    $("#progressbar li").eq($("fieldset").index(a)).addClass("active"),
                        a.show(),
                        e.animate(
                            { opacity: 0 },
                            {
                                step: function (t) {
                                    (n = 1 - t), e.css({ display: "none", position: "relative" }), a.css({ opacity: n });
                                },
                                duration: 500,
                            }
                        ),
                        s(++l);
                },
            });
            i.resetForm();
        }),
        $(".previous").click(function () {
            (e = $(this).parent()),
                (t = $(this).parent().prev()),
                $("#progressbar li").eq($("fieldset").index(e)).removeClass("active"),
                t.show(),
                e.animate(
                    { opacity: 0 },
                    {
                        step: function (a) {
                            (n = 1 - a), e.css({ display: "none", position: "relative" }), t.css({ opacity: n });
                        },
                        duration: 500,
                    }
                ),
                s(--l);
        });
}),
    $(document).ready(function () {
        let e = document.querySelector(".btn");
        (function a() {
            if (!options.key.includes("rzp_test") && !options.key.includes("rzp_live")) {
                let t = document.createElement("p");
                (t.innerHTML = `Enter a valid API Key in the JS editor and the pay button will appear here automatically 😉`), t.classList.add("bg-55"), e.appendChild(t), document.querySelector("#rzp-button1").remove();
            }
        })(),
            console.log(options.key.includes("rzp_test"));
    });
const placeOrderFunction = (e) => {
    $("#page_body").LoadingOverlay("show");
    let a = {
        billing_details: {
            company: $("#billling_company").val(),
            post_code: $("#billing_post_code").val(),
            add_1: $("#billing_address_1").val(),
            add_2: $("#billing_address_2").val(),
            city: $("#billing_city").val(),
            country: $("#billing_country").val(),
            state: $("#billing_state").val(),
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
            note: $("#d_note").val(),
        },
    };
    var t = { url: `${$("#base_url_input").val()}place_order`, method: "POST", data: { orderData: a, paymentDetails: e } };
    $.ajax(t).done(function (e) {
        let a = JSON.parse(e);
        $("#page_body").LoadingOverlay("hide"), 200 == a.status && (window.location.href = `${$("#base_url_input").val()}order_confirm/${a.order_id} `);
    });
},
    sameAsBillingAddress = (e) => {
        if ((console.log($("#" + e).is(":checked")), $("#" + e).is(":checked"))) {
            let a = {
                company: $("#billling_company").val(),
                post_code: $("#billing_post_code").val(),
                add_1: $("#billing_address_1").val(),
                add_2: $("#billing_address_2").val(),
                city: $("#billing_city").val(),
                country: $("#billing_country").val(),
                state: $("#billing_state").val(),
            };
            $("#d_fname").val($("#fname").val()),
                $("#d_lname").val($("#lname").val()),
                $("#d_company").val(a.company),
                $("#d_post_code").val(a.post_code),
                $("#d_address_1").val(a.add_1),
                $("#d_address_2").val(a.add_2),
                $("#d_city").val(a.city),
                $("#d_country").val(a.country).trigger("change"),
                $("#d_state").val(a.state).trigger("change");
        } else $("#d_fname").val(""), $("#d_lname").val(""), $("#d_company").val(""), $("#d_post_code").val(""), $("#d_address_1").val(""), $("#d_address_2").val(""), $("#d_city").val(""), $("#d_country").val(""), $("#d_state").val("");
    };
