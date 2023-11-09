$(document).ready(function () {
	loadCountries();
	var current_fs, next_fs, previous_fs; //fieldsets
	var opacity;
	var current = 1;
	var steps = $("fieldset").length;

	setProgressBar(current);

	$(".next-checkout-btn").click(function () {
		$.validator.addMethod("alphabetsnspace", function (value, element) {
			return this.optional(element) || /^[a-zA-Z ]*$/.test(value);
		});

		console.log("this is current", current);
		current_fs = $(this).parent();
		next_fs = $(this).parent().next();
		let rules = {};
		let messages = {};
		if (current == 1) {
			(rules = {
				fname: {
					required: true,
					alphabetsnspace: true,
					minlength: 2,
				},
				lname: {
					required: true,
					alphabetsnspace: true,
					minlength: 2,
				},
				email: {
					required: true,
					email: true, //add an email rule that will ensure the value entered is valid email id.
					maxlength: 255,
				},
				phone: {
					required: true,
					digits: true,
					minlength: 10,
					maxlength: 10,
				},
			}),
				(messages = {
					fname: {
						required: "Please Enter First Name",
						alphabetsnspace: "Please Enter Only Character",
						minlength: "Please Enter First Name More than 2 Letters",
					},
					lname: {
						required: "Please Enter Last Name",
						alphabetsnspace: "Please Enter Only Character",
						minlength: "Please Enter Last Name",
						// lettersonly: "Please Enter Character value "
					},
					email: {
						required: "Please Enter Email Id",
					},
					phone: {
						required: "Please Enter Phone Number",
						digits: "Please Enter Only Number",
						maxlength: "Please Enter 10 digit Number",
						//  matches: "Please Enter Number only"
					},
				});
		}

		if (current == 2) {
			$("#billing_post_code").rules("add", {
				required: true,
				digits: true,
				minlength: 5,
				messages: {
					required: "Please Enter Postal Code",
					digits: "Please Enter Only Number",
					minlength: "Please Enter Valid Post Code",
				},
			});
			$("#billing_address_1").rules("add", {
				required: true,
				minlength: 2,
				messages: {
					required: "Please Enter Address",
					minlength: "Please Enter Address",
				},
			});
			$("#billing_city").rules("add", {
				required: true,
				alphabetsnspace: true,
				minlength: 2,
				messages: {
					required: "Please Enter City",
					alphabetsnspace: "Please Enter Only Character",
					minlength: "Please Enter City",
				},
			});
		}

		if (current == 3) {
			$("#d_fname").rules("add", {
				required: true,
				alphabetsnspace: true,
				minlength: 2,
				messages: {
					required: "Please Enter First Name",
					alphabetsnspace: "Please Enter Only Character ",
					minlength: "Please Enter First Name",
				},
			});
			$("#d_lname").rules("add", {
				required: true,
				alphabetsnspace: true,
				minlength: 2,
				messages: {
					required: "Please Enter Last Name",
					alphabetsnspace: "Please Enter Only Character",
					minlength: "Please Enter Last Name",
				},
			});
			$("#d_post_code").rules("add", {
				required: true,
				digits: true,
				minlength: 5,
				messages: {
					required: "Please Enter Postal Code",
					digits: "Please Enter Only Number",
					minlength: "Please Enter Valid Post Code",
				},
			});
			$("#d_address_1").rules("add", {
				required: true,
				minlength: 2,
				messages: {
					required: "Please Enter Address",
					minlength: "Please Enter Address",
				},
			});
			$("#d_city").rules("add", {
				required: true,
				alphabetsnspace: true,
				minlength: 2,
				messages: {
					required: "Please Enter City",
					alphabetsnspace: "Please Enter Only Character",
					minlength: "Please Enter City",
				},
			});
			// $("#d_country").rules("add", {
			// 	required: true,
			// });
		}

		var form = $("#msform");

		const validator = form.validate({
			rules: rules,
			messages: messages,
			submitHandler: function (form) {
				//Add Class Active

				if (current == 3) {
					$("#cart_items_div").LoadingOverlay("show");
					const cartItems = localStorage.getItem("cartValues");
					var settings = {
						url: `${$("#base_url_input").val()}shopping_cart`,
						method: "POST",
						timeout: 0,
						data: { cartItems: cartItems },
					};

					$.ajax(settings).done(function (resp) {
						$("#cart_items_div").LoadingOverlay("hide");
						const response = JSON.parse(resp);
						if (
							response.status == 200 &&
							response.body.productInfo.length > 0
						) {
							const finalAmt = response.body.cartSummaryAmt;
							paypal
								.Buttons({
									createOrder: function (data, actions) {
										const fname = $("#fname").val();
										const lname = $("#lname").val();
										const billingCountryCode = $("#billing_country")
											.find(":selected")
											.attr("data-country_code");
										const shippingCountryCode = $("#d_country")
											.find(":selected")
											.attr("data-country_code");
										const billingStateCode = $("#billing_state")
											.find(":selected")
											.attr("data-state_code");
										const shippingStateCode = $("#d_state")
											.find(":selected")
											.attr("data-state_code");
										return actions.order.create({
											payer: {
												name: {
													given_name: fname,
													surname: lname,
												},
												address: {
													address_line_1: $("#billing_address_1").val(),
													address_line_2: $("#billing_address_2").val(),
													admin_area_2: $("#billing_city").val(),
													admin_area_1: billingStateCode,
													postal_code: $("#billing_post_code").val(),
													country_code: billingCountryCode,
												},
												email_address: $("#email").val(),
												phone: {
													phone_type: "MOBILE",
													phone_number: {
														national_number: $("#phone").val(),
													},
												},
											},
											purchase_units: [
												{
													amount: {
														value: finalAmt, // Set the payment amount here
														currency_code: "USD", // Set the currency code
													},

													shipping: {
														name: {
															fullname: `${fname} ${lname}`,
														},
														address: {
															address_line_1: $("#d_address_1").val(),
															address_line_2: $("#d_address_2").val(),
															admin_area_2: $("#d_city").val(),
															admin_area_1: shippingStateCode,
															postal_code: $("#d_post_code").val(),
															country_code: shippingCountryCode,
														},
													},
												},
											],
										});
									},
									onApprove: function (data, actions) {
										$("#page_body").LoadingOverlay("show");
										return actions.order.capture().then(function (details) {
											placeOrderFunction(JSON.stringify(details));
										});
									},
								})
								.render("#paypal-button");
						}
					});
				}

				$("#progressbar li")
					.eq($("fieldset").index(next_fs))
					.addClass("active");

				//show the next fieldset
				next_fs.show();
				//hide the current fieldset with style
				current_fs.animate(
					{ opacity: 0 },
					{
						step: function (now) {
							// for making fielset appear animation
							opacity = 1 - now;

							current_fs.css({
								display: "none",
								position: "relative",
							});
							next_fs.css({ opacity: opacity });
						},
						duration: 500,
					}
				);
				setProgressBar(++current);
			},
		});
		validator.resetForm();
	});

	$(".previous").click(function () {
		current_fs = $(this).parent();
		previous_fs = $(this).parent().prev();

		//Remove class active
		$("#progressbar li")
			.eq($("fieldset").index(current_fs))
			.removeClass("active");

		//show the previous fieldset
		previous_fs.show();

		//hide the current fieldset with style
		current_fs.animate(
			{ opacity: 0 },
			{
				step: function (now) {
					// for making fielset appear animation
					opacity = 1 - now;

					current_fs.css({
						display: "none",
						position: "relative",
					});
					previous_fs.css({ opacity: opacity });
				},
				duration: 500,
			}
		);
		setProgressBar(--current);
	});

	function setProgressBar(curStep) {
		var percent = parseFloat(100 / steps) * curStep;
		percent = percent.toFixed();
		$(".progress-bar").css("width", percent + "%");
	}
});

const placeOrderFunction = (paymentDetails) => {
	$("#page_body").LoadingOverlay("show");
	const orderData = {
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
	var settings = {
		url: `${$("#base_url_input").val()}place_order`,
		method: "POST",
		data: { orderData, paymentDetails },
	};

	$.ajax(settings).done(function (resp) {
		const response = JSON.parse(resp);
		$("#page_body").LoadingOverlay("hide");
		if (response.status == 200) {
			window.location.href = `${$("#base_url_input").val()}order_confirm/${
				response.order_id
			}`;
		}
	});
};

const sameAsBillingAddress = (id) => {
	console.log($("#" + id).is(":checked"));
	if ($("#" + id).is(":checked")) {
		const billing_details = {
			company: $("#billling_company").val(),
			post_code: $("#billing_post_code").val(),
			add_1: $("#billing_address_1").val(),
			add_2: $("#billing_address_2").val(),
			city: $("#billing_city").val(),
			country: $("#billing_country").val(),
			state: $("#billing_state").val(),
		};
		$("#d_fname").val($("#fname").val());
		$("#d_lname").val($("#lname").val());
		$("#d_company").val(billing_details.company);
		$("#d_post_code").val(billing_details.post_code);
		$("#d_address_1").val(billing_details.add_1);
		$("#d_address_2").val(billing_details.add_2);
		$("#d_city").val(billing_details.city);
		$("#d_country").val(billing_details.country).trigger("change");
		$("#d_state").val(billing_details.state).trigger("change");
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
};
