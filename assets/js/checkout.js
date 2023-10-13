$(document).ready(function () {
	var current_fs, next_fs, previous_fs; //fieldsets
	var opacity;
	var current = 1;
	var steps = $("fieldset").length;

	setProgressBar(current);

	$(".next-checkout-btn").click(function () {
		console.log("this is current", current);
		current_fs = $(this).parent();
		next_fs = $(this).parent().next();
		let rules = {};
		if (current == 1) {
			rules = {
				fname: { required: true, minlength: 2 },
				lname: { required: true, minlength: 2 },
			};
		}
		if (current == 2) {
			$("#company").rules("add", {
				required: true,
			});
      $("#post_code").rules("add", {
				required: true,
			});
		}

    if (current == 3) {
			$("#d_fname").rules("add", {
				required: true,
			});
      $("#d_lname").rules("add", {
				required: true,
			});
		}

		var form = $("#msform");

		const validator = form.validate({
			rules: rules,
			submitHandler: function (form) {
				//Add Class Active
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
