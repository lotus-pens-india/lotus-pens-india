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
	const checkUserLogin = $("#is_user_login").val();

	if (checkUserLogin && checkUserLogin == true) {
		console.log("user logged in");
	} else {
		const clipOption = $(".selected_clip").attr("id");
		const selectedColor = $(".selected_color").text();
		const nib = $("#nib_select").val();
		const clip = $("#clip_select").val();
		const material = $("#material_select").val();
		const productId = $("#product_code_text").val();
		const getCartValue = localStorage.getItem("cartValues");
		console.log(getCartValue);
		const addToCartObj = {
			productId,
			clipOption,
			selectedColor,
			nib,
			clip,
			material,
			quantity: 1,
		};
		// console.log(addToCartObj);
		localStorage.setItem("cartValues", JSON.stringify(addToCartObj));
	}
};
