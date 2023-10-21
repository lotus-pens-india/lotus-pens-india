$(document).ready(function () {
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
			rules = {
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
					email: true,//add an email rule that will ensure the value entered is valid email id.
					maxlength: 255,
				},
				phone: {
					required: true,
					digits: true,
					minlength: 10,
					maxlength: 10,

				},

			},
				messages = {
					fname: {
						required: 'Please Enter First Name',
						alphabetsnspace: "Please Enter Only Character",
						minlength: "Please Enter First Name",
					},
					lname: {
						required: 'Please Enter Last Name',
						alphabetsnspace: "Please Enter Only Character",
						minlength: "Please Enter Last Name",
						// lettersonly: "Please Enter Character value "
					},
					email: {
						required: 'Please Enter Email Id',
					},
					phone: {
						required: 'Please Enter Phone Number',
						digits: "Please Enter Only Number",
						maxlength: "Please Enter 10 digit Number",
						//  matches: "Please Enter Number only"
					},

				}

		}

		if (current == 2) {

			$("#post_code").rules("add", {
				required: true,
				digits: true,
				minlength: 5,
				messages: {
					required: "Please Enter Postal Code",
					digits: "Please Enter Only Number",
					minlength: "Please Enter Valid Post Code"
				}

			})
			$("#address_1").rules("add", {
				required: true,
				minlength: 2,
				messages: {
					required: "Please Enter Address",
					minlength: "Please Enter Address"
				}
			})
			$("#city").rules("add", {
				required: true,
				alphabetsnspace: true,
				minlength: 2,
				messages: {
					required: "Please Enter City",
					alphabetsnspace: "Please Enter Only Character",
					minlength: "Please Enter City"
				}
			});
			// $("#country").rules("add", {
			// 	required: true,
			// });
			// $("#state").rules("add", {
			// 	required: true,
			// });
		}

		if (current == 3) {
			$("#d_fname").rules("add", {
				required: true,
				alphabetsnspace: true,
				minlength: 2,
				messages: {
					required: 'Please Enter First Name',
					alphabetsnspace: "Please Enter Only Character ",
					minlength: "Please Enter First Name",
				}
			});
			$("#d_lname").rules("add", {
				required: true,
				alphabetsnspace: true,
				minlength: 2,
				messages: {
					required: 'Please Enter Last Name',
					alphabetsnspace: "Please Enter Only Character",
					minlength: "Please Enter Last Name",
				}
			});
			$("#d_post_code").rules("add", {
				required: true,
				digits: true,
				minlength: 5,
				messages: {
					required: "Please Enter Postal Code",
					digits: "Please Enter Only Number",
					minlength: "Please Enter Valid Post Code"
				}
			});
			$("#d_address_1").rules("add", {
				required: true,
				minlength: 2,
				messages: {
					required: "Please Enter Address",
					minlength: "Please Enter Address"
				}
			});
			$("#d_city").rules("add", {
				required: true,
				alphabetsnspace: true,
				minlength: 2,
				messages: {
					required: "Please Enter City",
					alphabetsnspace: "Please Enter Only Character",
					minlength: "Please Enter City",
				}
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
				str_data = $(form).serializeArray();

				console.log(str_data)

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
				// form.submit();
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

	// $(".submit").click(function () {
	// 	return false;
	// });
});
