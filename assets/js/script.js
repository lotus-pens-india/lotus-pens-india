$(document).ready(function () {
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
				cValues += `<option value="${response.data[i].id}">${response.data[i].name}</option>`;
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
				cValues += `<option value="${response.data[i].id}">${response.data[i].name}</option>`;
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
