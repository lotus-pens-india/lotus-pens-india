const getCartItems = () => {
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
		if (response.status == 200 && response.body.productInfo.length > 0) {
			const rawData = response.body.rawData;
			localStorage.setItem("cartValues", JSON.stringify(rawData));
			const ui = createCartItemsUi(response.body.productInfo);
			$("#cart_items_div").empty();
			$("#cart_items_div").append(ui);
			$("#cart_items_count").text(response.body.cartItemsCount);
			$("#summary_price").text(response.body.cartSummaryAmt);
			$("#summary_price_total").text(response.body.cartSummaryAmt);
		} else {
			localStorage.setItem("cartValues", JSON.stringify([]));
			$("#main_cart_page_div").empty();
			$("#main_cart_page_div")
				.append(` <div class="title-wrapper" id="empty_cart_div">
			<p class="title-headings">Shopping Cart</p>
		</div>
		<div class="row shadow-lg text-center rounded-4">
		<div class="col-12 pt-5">
			   <img src='${$(
						"#base_url_input"
					).val()}assets/images/empty_cart.svg' style="width:30%"/>
			</div>

			<div class="col-12 "> <h3>At the moment, your shopping cart is empty</h3></div>
		   
			<div class="col-12 pt-3 pb-3"><a href="${$(
				"#base_url_input"
			).val()}" class="btn btn-primary">Start Shopping Now</a></div>
		</div>`);
		}
	});
};
$(document).ready(() => {
	getCartItems();
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
					window.location.href = "checkout";
				} else {
					showInvalidToast(response.body);
				}
			});
		},
	});
});

const createCartItemsUi = (data) => {
	let ui = ``;
	if (data && data.length > 0) {
		for (let i = 0; i < data.length; i++) {
			const productInformation = data[i].productInformation[0];
			const clipOption =
				data[i].clipOption == "with_clip" ? "With Clip" : "Without Clip";
			const nibData = data[i].nibData[0];
			const materialData = data[i].materialData[0];
			const clipData = data[i].clipData[0];
			const quantity = data[i].quantity;
			const currencySymbol = $("#currency_symbol").val();
			console.log("this is clip data", clipData);
			let nibUi = ``;
			let materialUi = ``;
			let clipUi = ``;
			if (nibData) {
				nibUi += `<p>Nib: ${nibData.name}</p>`;
			}

			if (materialData) {
				materialUi += `<p>Material: ${materialData.name}</p>`;
			}

			if (clipData) {
				clipUi += `${clipData.name}`;
			}
			ui += `
            <div class="row m-1 cart-page-items" style="border-bottom: 1px solid #292929;">
                         <div class="col-3 col-lg-2 col-md-2 col-sm-3 p-0">
                             <div class="img-wrapper" style="width: 100%; display: inline-block;">
                                 <img src="${$(
																		"#base_url_input"
																	).val()}lotus_pens_admin/assets/images/product/${
				productInformation.main_image
			}">
                             </div>
                         </div>
                         <div class="col-9 col-lg-10 col-md-10 col-sm-9 p-0">
                             <div class="w-100">
                                 <label>
                                     <h5>${productInformation.product_name}</h5>
                                 </label>
                                 <label class="float-end">
                                     <img src="${$(
																				"#base_url_input"
																			).val()}assets/images/heart-solid.svg" style="height: 15px;width: 15px;cursor: pointer;">
                                     <img onclick="removeFromCart(${i})" src="${$(
				"#base_url_input"
			).val()}assets/images/trash-can-solid.svg" style="height: 15px;width: 15px;cursor: pointer;"></label>
                             </div>
                             <p>Clip: ${clipOption},${clipUi} | Color: Maroon</p>
                             ${nibUi}
                             ${materialUi}
                             <div class="w-100">
                                 <label>
                                     <h6>${currencySymbol} ${
				data[i].finalAmount
			}</h6>
                                 </label>
                                 <label class="float-end">
                                     <div class="quantity">
                                         <img onclick="addQuantityToCart(${i})" src="${$(
				"#base_url_input"
			).val()}assets/images/square-plus-regular.svg" style="height: 20px;width: 20px;cursor: pointer;" alt="" />
                                         <input type="text" name="name" value="${quantity}">
                                         <img  onclick="removeQuantityToCart(${i})" src="${$(
				"#base_url_input"
			).val()}assets/images/square-minus-regular.svg" style="height: 20px;width: 20px;cursor: pointer;" alt="" />
                                     </div>
                             </div>

                         </div>
                     </div>
            `;
		}
	}
	return ui;
};

const processToCheckout = () => {
	const checkUserLogin = $("#is_user_login").val();
	if (checkUserLogin && checkUserLogin == true) {
		window.location.href = "checkout";
	} else {
		$("#loginModal").modal("show");
	}
};

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

const placeOrder = () => {
	// const cartItems = localStorage.getItem("cartValues");
	var settings = {
		url: `${$("#base_url_input").val()}place_order`,
		method: "POST",
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
