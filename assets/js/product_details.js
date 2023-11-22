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
	const productName = $('#product_name_div').text();
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

const addToWishlist = (eleId) => {
	if ($(eleId).attr('class') == 'fa fa-heart-o') {

	} else {
		$("#page_body").LoadingOverlay("show");
		const checkUserLogin = $("#is_user_login").val();
		const productId = $("#product_code_text").val();
		const getCartValue = JSON.parse(localStorage.getItem("wishlistValues"));
		if (getCartValue && getCartValue.length > 0) {
			let updateIndex = 0;
			let isAlreadyInCart = false;
			for (let i = 0; i < getCartValue.length; i++) {
				if (
					getCartValue[i] == productId
				) {
					updateIndex = i;
					isAlreadyInCart = true;
				}
			}
			if (isAlreadyInCart) {

			} else {
				getCartValue.push(
					productId,
				);
			}
			localStorage.setItem("wishlistValues", JSON.stringify(getCartValue));
			if (checkUserLogin && checkUserLogin == true) {
				addToWishlistDb();
			} else {
				getCartItems();
			}
			$("#page_body").LoadingOverlay("hide");
		} else {

			const addToCartObj = [productId];
			// console.log(addToCartObj);
			localStorage.setItem("wishlistValues", JSON.stringify(addToCartObj));
			if (checkUserLogin && checkUserLogin == true) {
				// addToCartDb();
			} else {
				// getCartItems();
			}
			$("#page_body").LoadingOverlay("hide");
		}
		window.location.reload();
	}
};

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
			const ui = productUi(response.data);
			$("#wishlist_btn_div").empty();
			$("#wishlist_btn_div").append(`
			<i class="fa fa-heart-o" style="font-size:24px" onclick="addToWishlist()"></i>`);
		} else {
			localStorage.setItem("wishlistValues", JSON.stringify([]));
			$("#wishlist_btn_div").empty();
			$("#wishlist_btn_div").append(`
			<i class="fa fa-heart-o" style="font-size:24px" onclick="addToWishlist()"></i>`);
		}
	});
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
