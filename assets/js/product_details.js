const selectColor = (color) => {
	$(`#parent_div_of_color`)
		.find(".prod-options-slide")
		.each(function () {
			$(this).removeClass("prod-options-slide-first");
		});
	$(`#parent_div_of_color`)
		.find("p")
		.each(function () {
			$(this).removeClass("selected_color");
		});
	$(`#${color}`).addClass("prod-options-slide-first");
	$(`#${color}_text`).addClass("selected_color");
};

const selectClipOption = (clip_option) => {
	if (clip_option === "with_clip") {
		$("#without_clip").removeClass("active-option selected_clip");
		$("#with_clip").addClass("active-option selected_clip");
	}

	if (clip_option === "without_clip") {
		$("#with_clip").removeClass("active-option selected_clip");
		$("#without_clip").addClass("active-option selected_clip");
	}
};

$("select.select-club-services").each(function () {
	var dropdown = $("<div />").addClass("select-club-services selectDropdown");

	$(this).wrap(dropdown);

	var label = $("<span />")
		.text($(this).attr("placeholder"))
		.insertAfter($(this));
	var list = $("<ul />");

	$(this)
		.find("option")
		.each(function () {
			list.append($("<li />").append($("<a />").text($(this).text())));
		});

	list.insertAfter($(this));

	if ($(this).find("option:selected").length) {
		label.text($(this).find("option:selected").text());
		list
			.find("li:contains(" + $(this).find("option:selected").text() + ")")
			.addClass("active");
		$(this).parent().addClass("filled");
	}
});

$(document).on("click touch", ".selectDropdown ul li a", function (e) {
	e.preventDefault();
	var dropdown = $(this).parent().parent().parent();
	var active = $(this).parent().hasClass("active");
	var label = active
		? dropdown.find("select").attr("placeholder")
		: $(this).text();

	dropdown.find("option").prop("selected", false);
	dropdown.find("ul li").removeClass("active");

	dropdown.toggleClass("filled", !active);
	dropdown.children("span").text(label);

	if (!active) {
		dropdown
			.find("option:contains(" + $(this).text() + ")")
			.prop("selected", true);
		$(this).parent().addClass("active");
	}

	dropdown.removeClass("open");
});

$(".select-club-services > span").on("click touch", function (e) {
	var self = $(this).parent();
	self.toggleClass("open");
});

$(document).on("click touch", function (e) {
	var dropdown = $(".select-club-services");
	if (dropdown !== e.target && !dropdown.has(e.target).length) {
		dropdown.removeClass("open");
	}
});

const addToCart = () => {
	$("#page_body").LoadingOverlay("show");
	const checkUserLogin = $("#is_user_login").val();

	const clipOption = $(".selected_clip").attr("id");
	const selectedColor = $(".selected_color").text();
	const nib = $("#nib_select").val();
	const clip = $("#clip_select").val();
	const material = $("#material_select").val();
	const productId = $("#product_code_text").val();
	const productName=$('#product_name_div').text();
	const getCartValue = JSON.parse(localStorage.getItem("cartValues"));
	if (getCartValue && getCartValue.length > 0) {
		let updateIndex = 0;
		let isAlreadyInCart = false;
		for (let i = 0; i < getCartValue.length; i++) {
			if (
				getCartValue[i].productId == productId &&
				getCartValue[i].clipOption == clipOption &&
				getCartValue[i].selectedColor == selectedColor &&
				getCartValue[i].nib == nib &&
				getCartValue[i].clip == clip &&
				getCartValue[i].material == material
			) {
				updateIndex = i;
				isAlreadyInCart = true;
			}
		}
		if (isAlreadyInCart) {
			getCartValue[updateIndex].quantity =
				getCartValue[updateIndex].quantity + 1;
			// localStorage.setItem("cartValues", JSON.stringify(getCartValue));
		} else {
			getCartValue.push({
				productId,
				clipOption,
				selectedColor,
				nib,
				clip,
				material,
				quantity: 1,
			});
		}
		localStorage.setItem("cartValues", JSON.stringify(getCartValue));
		if (checkUserLogin && checkUserLogin == true) {
			addToCartDb();
		} else {
			getCartItems();
		}
		$("#page_body").LoadingOverlay("hide");
		showAddToCartToast(productName);
	} else {
		console.log("first time item added");
		const addToCartObj = [
			{
				productId,
				clipOption,
				selectedColor,
				nib,
				clip,
				material,
				quantity: 1,
			},
		];
		// console.log(addToCartObj);
		localStorage.setItem("cartValues", JSON.stringify(addToCartObj));
		if (checkUserLogin && checkUserLogin == true) {
			addToCartDb();
		} else {
			getCartItems();
		}
		$("#page_body").LoadingOverlay("hide");
		showAddToCartToast(productName);
	}
};

const showAddToCartToast = (productId) => {
	toastr.success(`${productId} added to your cart`, "Product Added!", {
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
		hideMethod: "fadeOut",
	});
};

const showInvalidToast = (message) => {
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
		hideMethod: "fadeOut",
	});
};

const removeFromCart = (cartId) => {
	const checkUserLogin = $("#is_user_login").val();
	$("#cart_items_div").LoadingOverlay("show");

	const getCartValue = JSON.parse(localStorage.getItem("cartValues"));
	if (getCartValue && getCartValue.length > 0) {
		getCartValue.splice(cartId, 1);
		localStorage.setItem("cartValues", JSON.stringify(getCartValue));
		if (checkUserLogin && checkUserLogin == true) {
			addToCartDb();
		} else {
			getCartItems();
		}
	}
	$("#cart_items_div").LoadingOverlay("hide");
};

const addQuantityToCart = (cartId) => {
	const checkUserLogin = $("#is_user_login").val();
	$("#cart_items_div").LoadingOverlay("show");

	const getCartValue = JSON.parse(localStorage.getItem("cartValues"));
	if (getCartValue && getCartValue.length > 0) {
		getCartValue[cartId].quantity = getCartValue[cartId].quantity + 1;
		localStorage.setItem("cartValues", JSON.stringify(getCartValue));
		if (checkUserLogin && checkUserLogin == true) {
			addToCartDb();
		} else {
			getCartItems();
		}
		$("#cart_items_div").LoadingOverlay("hide");
	}
};

const removeQuantityToCart = (cartId) => {
	const checkUserLogin = $("#is_user_login").val();
	$("#cart_items_div").LoadingOverlay("show");
	const getCartValue = JSON.parse(localStorage.getItem("cartValues"));
	if (getCartValue && getCartValue.length > 0) {
		getCartValue[cartId].quantity = getCartValue[cartId].quantity - 1;
		if (getCartValue[cartId].quantity == 0) {
			getCartValue.splice(cartId, 1);
		}
		localStorage.setItem("cartValues", JSON.stringify(getCartValue));
		if (checkUserLogin && checkUserLogin == true) {
			addToCartDb();
		} else {
			getCartItems();
		}
		$("#cart_items_div").LoadingOverlay("hide");
	}
};
