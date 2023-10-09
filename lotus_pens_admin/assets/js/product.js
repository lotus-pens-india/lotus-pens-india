const base_url = $("#base_url_textbox").val();
$(document).ready(async () => {
	await getNibDropdown();
	await getClipAndRingsDropdown();
	await getMaterialDropdown();
	$("#nib_drp").select2({
		placeholder: "Select Nib",
		multiple: true,
	});

	$("#clip_drp").select2({
		placeholder: "Select Clip and Rings",
		multiple: true,
	});

	$("#material_drp").select2({
		placeholder: "Select Material Varients",
		multiple: true,
	});
});

const getNibDropdown = async () => {
	var settings = {
		url: `${base_url}/nib_dropdown`,
		method: "POST",
		timeout: 0,
	};

	$.ajax(settings).done(function (resp) {
		const response = JSON.parse(resp);
		if (response.status == 200 && response.data.length > 0) {
			$("#nib_drp").empty();
			for (let i = 0; i < response.data.length; i++) {
				$("#nib_drp").append(
					`<option value='${response.data[i].id}'>${response.data[i].name}</option>`
				);
			}
		}
	});
};

const getClipAndRingsDropdown = async () => {
	var settings = {
		url: `${base_url}/clip_dropdown`,
		method: "POST",
		timeout: 0,
	};

	$.ajax(settings).done(function (resp) {
		const response = JSON.parse(resp);
		if (response.status == 200 && response.data.length > 0) {
			$("#clip_drp").empty();
			for (let i = 0; i < response.data.length; i++) {
				$("#clip_drp").append(
					`<option value='${response.data[i].id}'>${response.data[i].name}</option>`
				);
			}
		}
	});
};

const getMaterialDropdown = async () => {
	var settings = {
		url: `${base_url}/material_dropdown`,
		method: "POST",
		timeout: 0,
	};

	$.ajax(settings).done(function (resp) {
		const response = JSON.parse(resp);
		if (response.status == 200 && response.data.length > 0) {
			$("#material_drp").empty();
			for (let i = 0; i < response.data.length; i++) {
				$("#material_drp").append(
					`<option value='${response.data[i].id}'>${response.data[i].name}</option>`
				);
			}
		}
	});
};
