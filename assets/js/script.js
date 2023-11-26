$(document).ready(function () {

	var form = $("#login_form");
	rules = {
		username: { required: true, minlength: 2 },
		password: { required: true, minlength: 2 },
	};

	const validator = form.validate({
		rules: rules,
		submitHandler: function (form) {
			const username = $("#username").val();
			const password = $("#password").val();
			var settings = {
				url: `${$("#base_url_input").val()}customer_login`,
				method: "POST",
				timeout: 0,
				data: { username, password },
			};
			$.ajax(settings).done(function (resp) {
				const response = JSON.parse(resp);
				if (response.status == 200) {
					$("#loginModal").modal("hide");
					addToCartDb();
					window.location.reload();
				} else {
					showInvalidToast(response.body);
				}
			});
		},
	});
	$.validator.addMethod("alphabetsnspace", function (value, element) {
		return this.optional(element) || /^[a-zA-Z ]*$/.test(value);
	});
	$("#signup_form").validate({
		rules: {
			signup_firstname: {
				required: true,
				alphabetsnspace: true,
				minlength: 2,
			},
			signup_lastname: {
				required: true,
				alphabetsnspace: true,
				minlength: 2,
			},
			signup_email: {
				required: true,
				email: true, //add an email rule that will ensure the value entered is valid email id.
				maxlength: 255,
			},
			signup_mobile: {
				required: true,
				digits: true,
				minlength: 10,
				maxlength: 10,
			},
			signup_username: {
				required: true,
				minlength: 6,
			},
			signup_password: {
				required: true,
				minlength: 6,
			},
		},
		messages: {
			signup_firstname: {
				required: "Please Enter First Name",
				alphabetsnspace: "Please Enter Only Character",
				minlength: "Please Enter First Name More than 2 Letters",
			},
			signup_lastname: {
				required: "Please Enter Last Name",
				alphabetsnspace: "Please Enter Only Character",
				minlength: "Please Enter Last Name",
				// lettersonly: "Please Enter Character value "
			},
			signup_email: {
				required: "Please Enter Email Id",
			},
			signup_mobile: {
				required: "Please Enter Phone Number",
				digits: "Please Enter Only Number",
				maxlength: "Please Enter 10 digit Number",
				//  matches: "Please Enter Number only"
			},
			signup_username: {
				required: "Please Enter Phone Number",
				maxlength: "Please Enter 10 digit Number",
				//  matches: "Please Enter Number only"
			},
			signup_password: {
				required: "Please Enter Phone Number",
				maxlength: "Please Enter 10 digit Number",
				//  matches: "Please Enter Number only"
			},
		},
		submitHandler: function (form) {
			const formData = $(form).serialize();
			$("#page_body").LoadingOverlay("show");
			var settings = {
				url: `${$("#base_url_input").val()}signup`,
				method: "POST",
				timeout: 0,
				data: formData,
			};

			$.ajax(settings).done(function (resp) {
				$("#page_body").LoadingOverlay("hide");
				const response = JSON.parse(resp);
				if (response.status == 200) {
					$("#loginModal").modal("hide");
					Swal.fire(
						"Congratulations!",
						"Your account has been successfully created. Welcome to our community. Start exploring and enjoy!",
						"success"
					);
				}
			});
		},
	});

	if ($("#currency_symbol").val() == "") {
		var settings = {
			url: `${$("#base_url_input").val()}set_default_currency`,
			method: "POST",
			timeout: 0,
		};

		$.ajax(settings).done(function (resp) {
			const response = JSON.parse(resp);
		});
	}
	const loginText = document.querySelector(".title-text .login");
	const loginForm = document.querySelector("form.login");
	const loginBtn = document.querySelector("label.login");
	const signupBtn = document.querySelector("label.signup");
	const signupLink = document.querySelector("form .signup-link a");
	signupBtn.onclick = () => {
		loginForm.style.marginLeft = "-50%";
		loginText.style.marginLeft = "-50%";
	};
	loginBtn.onclick = () => {
		loginForm.style.marginLeft = "0%";
		loginText.style.marginLeft = "0%";
	};
	signupLink.onclick = () => {
		signupBtn.click();
		return false;
	};
	if ($("#currency_symbol").val() == "") {
		var settings = {
			url: `${$("#base_url_input").val()}set_default_currency`,
			method: "POST",
			timeout: 0,
		};

		$.ajax(settings).done(function (resp) {
			const response = JSON.parse(resp);
			if (response.status == 200) {
				window.location.reload();
			}
		});
	}
	const baseUrl = $("#base_url_input").val();
	$("body").css("padding-top", $(".header").height());

	$("#banner-slider").slick({
		dots: true,
		infinite: true,
		speed: 300,
		slidesToShow: 1,
		slidesToScroll: 1,
		autoplay: true,
		arrows: true,
		prevArrow: `<img class='a-left control-c prev slick-prev' src='${baseUrl}assets/images/left-arrow.png'>`,
		nextArrow: `<img class='a-right control-c next slick-next' src='${baseUrl}assets/images/right-arrow.png'>`,
	});
	$(".featured-slider").slick({
		dots: false,
		infinite: true,
		speed: 300,
		slidesToShow: 4,
		slidesToScroll: 4,
		autoplay: true,
		arrows: true,
		prevArrow: `<img class='a-left control-c prev slick-prev' src='${baseUrl}assets/images/left-arrow.png'>`,
		nextArrow: `<img class='a-right control-c next slick-next' src='${baseUrl}assets/images/right-arrow.png'>`,
		responsive: [
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 4,
					slidesToScroll: 4,
				},
			},
			{
				breakpoint: 600,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 2,
				},
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				},
			},
		],
	});

	$(".faq-question").click(function () {
		$(".faq-answer").css("height", "0px");
		$(this).siblings().css("height", "auto");
	});

	$(".testimonials-slider").slick({
		dots: false,
		infinite: true,
		speed: 300,
		autoplay: true,
		slidesToShow: 3,
		slidesToScroll: 3,
		centerMode: true,
		arrows: true,
		prevArrow: `<img class='a-left control-c prev slick-prev' src='${baseUrl}assets/images/left-arrow.png'>`,
		nextArrow: `<img class='a-right control-c next slick-next' src='${baseUrl}assets/images/right-arrow.png'>`,
		responsive: [
			{
				breakpoint: 1024,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 3,
				},
			},
			{
				breakpoint: 600,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				},
			},
			{
				breakpoint: 480,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				},
			},
		],
	});

	$(".product-slider").slick({
		dots: false,
		infinite: true,
		speed: 300,
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: true,
		prevArrow: `<img class='a-left control-c prev slick-prev' src='${baseUrl}assets/images/left-arrow.png'>`,
		nextArrow: `<img class='a-right control-c next slick-next' src='${baseUrl}assets/images/right-arrow.png'>`,
	});

	$(".prod-options-slider").slick({
		dots: false,
		infinite: true,
		speed: 300,
		autoplay: true,
		slidesToShow: 5,
		slidesToScroll: 5,
	});

	$(".menu-btn").click(function () {
		$(".menu-wrapper").toggle();
		$(".header-backdrop").toggle();
	});

	$(".header-backdrop").click(function () {
		$(".menu-wrapper").toggle();
		$(".header-backdrop").toggle();
	});

	$(".item__boxes").on("click", function () {
		var slickIndex = $(this).attr("data-slick-index");
		console.log("this is called", slickIndex);
		$(".product-slider").slick("slickGoTo", slickIndex);
	});
});

const addToCartDb = () => {
	const cartItems = localStorage.getItem("cartValues");
	var settings = {
		url: `${$("#base_url_input").val()}add_to_cart`,
		method: "POST",
		timeout: 0,
		data: { cartItems: cartItems },
	};

	$.ajax(settings).done(function (resp) {
		const response = JSON.parse(resp);
		if (response.status == 200) {
			const updatedData = response.body.cart_json;
			localStorage.setItem("cartValues", updatedData);
			getCartItems();
		}
	});
};

const addToWishlistDb = () => {
	const cartItems = localStorage.getItem("wishlistValues");
	var settings = {
		url: `${$("#base_url_input").val()}add_to_cart`,
		method: "POST",
		timeout: 0,
		data: { cartItems: cartItems },
	};

	$.ajax(settings).done(function (resp) {
		const response = JSON.parse(resp);
		if (response.status == 200) {
			const updatedData = response.body.cart_json;
			localStorage.setItem("cartValues", updatedData);
			getCartItems();
		}
	});
};

const changeCurrency = (currency) => {
	var settings = {
		url: `${$("#base_url_input").val()}change_currency`,
		method: "POST",
		timeout: 0,
		data: { currency: currency },
	};

	$.ajax(settings).done(function (resp) {
		const response = JSON.parse(resp);
		if (response.status == 200) {
			window.location.reload();
		}
	});
};

const logout = () => {
	var settings = {
		url: `${$("#base_url_input").val()}logout`,
		method: "POST",
		timeout: 0,
	};

	$.ajax(settings).done(function (resp) {
		const response = JSON.parse(resp);
		if (response.status == 200) {
			window.location.reload();
		}
	});
};

const loadCountries = () => {
	var settings = {
		url: `${$("#base_url_input").val()}get_country`,
		method: "POST",
		timeout: 0,
	};

	$.ajax(settings).done(function (resp) {
		const response = JSON.parse(resp);
		if (response.status == 200) {
			console.log(response);
			$("#billing_country").empty();
			$("#d_country").empty();

			let cValues = ``;
			for (let i = 0; i < response.data.length; i++) {
				cValues += `<option value="${response.data[i].id}" data-country_code="${response.data[i].iso2}">${response.data[i].name}</option>`;
			}
			$("#billing_country").append(cValues);
			$("#d_country").append(cValues);
			$("#billing_country").select2();
			$("#d_country").select2();
			$countryId = $("#billing_country").val();

			loadStates($countryId, "billing_state");
			loadStates($countryId, "d_state");
		} else {
			$("#billing_country").empty();
			$("#d_country").empty();
		}
	});
};

const loadStates = (countryId, state_id) => {
	var settings = {
		url: `${$("#base_url_input").val()}get_states`,
		method: "POST",
		timeout: 0,
		data: { country: countryId },
	};

	$.ajax(settings).done(function (resp) {
		const response = JSON.parse(resp);
		if (response.status == 200) {
			console.log(response);
			$(`#${state_id}`).empty();
			let cValues = ``;
			for (let i = 0; i < response.data.length; i++) {
				cValues += `<option value="${response.data[i].id}" data-state_code="${response.data[i].iso2}">${response.data[i].name}</option>`;
			}
			$(`#${state_id}`).append(cValues);
			$(`#${state_id}`).select2();
		} else {
			$(`#${state_id}`).empty();
		}
	});
};

const openLoginModal = () => {
	$("#loginModal").modal("show");
};

const openQuickView = (imageUrl) => {
	console.log("modal open");
	$("#quickViewImg").attr("src", `${imageUrl}`);
	$("#quickViewModal").modal("show");
};
const searchProducts = () => {
	const searchQuery = $('#search_product').val();
	if (searchQuery != '') {
		window.location.href = `${$('#base_url_input').val()}product_search/${searchQuery}`;
	}
}

// const getCartItems = () => {
// 	$("#cart_items_div").LoadingOverlay("show");
// 	const cartItems = localStorage.getItem("cartValues");
// 	var settings = {
// 		url: `${$("#base_url_input").val()}shopping_cart`,
// 		method: "POST",
// 		timeout: 0,
// 		data: { cartItems: cartItems },
// 	};

// 	$.ajax(settings).done(function (resp) {
// 		$("#cart_items_div").LoadingOverlay("hide");
// 		const response = JSON.parse(resp);
// 		if (response.status == 200 && response.body.productInfo.length > 0) {
// 			const rawData = response.body.rawData;
// 			localStorage.setItem("cartValues", JSON.stringify(rawData));
// 			const ui = createCartItemsUi(response.body.productInfo);
// 			$("#cart_items_div").empty();
// 			$("#cart_items_div").append(ui);
// 			$("#cart_items_count").text(response.body.cartItemsCount);
// 			$("#summary_price").text(response.body.cartSummaryAmt);
// 			$("#summary_price_total").text(response.body.cartSummaryAmt);
// 		} else {
// 			localStorage.setItem("cartValues", JSON.stringify([]));
// 			$("#main_cart_page_div").empty();
// 			$("#main_cart_page_div")
// 				.append(` <div class="title-wrapper" id="empty_cart_div">
// 			<p class="title-headings">Shopping Cart</p>
// 		</div>
// 		<div class="row shadow-lg text-center rounded-4">
// 		<div class="col-12 pt-5">
// 			   <img src='${$(
// 					"#base_url_input"
// 				).val()}assets/images/empty_cart.svg' style="width:30%"/>
// 			</div>

// 			<div class="col-12 "> <h3>At the moment, your shopping cart is empty</h3></div>

// 			<div class="col-12 pt-3 pb-3"><a href="${$(
// 					"#base_url_input"
// 				).val()}" class="btn btn-primary">Start Shopping Now</a></div>
// 		</div>`);
// 		}
// 	});
// };

