<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css'>
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/summernote/0.6.6/summernote.min.css'>
<div class="clearfix"></div>

<div class="content-wrapper">
	<div class="container-fluid">
		<!-- Breadcrumb-->
		<div class="row pt-2 pb-2">
			<div class="col-sm-9">
				<h4 class="page-title">Update Product</h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="javaScript:void();">Product</a></li>
					<li class="breadcrumb-item"><a href="javaScript:void();">Update Product</a></li>
				</ol>
			</div>
			<div class="col-sm-3">
				<div class="float-sm-right">
					<a href="<?php echo base_url(); ?>product/product_list">
						<button type="button" class="btn btn-primary waves-effect waves-light m-1">Product list</button>
					</a>
				</div>
			</div>
		</div>
		<!-- End Breadcrumb-->
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header"><i class="fa fa-upload"></i> Update Product</div>
					<div class="card-body">
						<form id="add_product" method="post" action="<?php echo base_url(); ?>product/update_product_data" enctype="multipart/form-data">
							<div id="wizard-vertical1">

								<section>
									<h4>General</h4>
									<div class="form-group row">
										<div class="col-md-4">
											<label>Product Name *</label>
											<input class="form-control" name="product_name" value="<?php echo $product->product_name; ?>" type="text">
											<div class="form_error_msg product_nameError"></div>
										</div>
										<div class="col-md-4">
											<label> Category *</label>
											<select class="form-control single-select" name="category_id" id="category_id">
												<option value="">Select Category</option>
												<?php foreach ($all_category as $category) { ?>
													<option value="<?php echo $category->category_id ?>" <?= ($product->category_id == $category->category_id) ? 'selected' : ''; ?>><?php echo $category->name ?></option>
												<?php } ?>
											</select>
											<div class="form_error_msg category_idError"></div>
										</div>
										<div class="col-md-4">
											<label>Sub Subcategory </label>
											<select class="form-control single-select" name="sub_subcategory_id" id="sub_subcategory_id">
												<option value="<?php echo $product->sub_subcategory_id ?>"><?php echo $product->sub_subcategory ?></option>
											</select>
										</div>
									</div>
									<div class="form-group row">

										<div class="col-md-4">
											<label>Brand *</label>
											<select class="form-control single-select" name="brand_id" id="brand_id">
												<option value="<?php echo $product->brand_id ?>"><?php echo $product->brand_name ?></option>
												<?php foreach ($all_brand as $brand) { ?>
													<option value="<?php echo $brand->brand_id ?>"><?php echo $brand->brand_name ?></option>
												<?php } ?>
											</select>
											<div class="form_error_msg brand_idError"></div>
										</div>
										<div class="col-md-4">
											<label>Unit *</label>
											<input type="text" class="form-control" name="unit" value="<?php echo $product->unit; ?>" placeholder="Unit (e.g. KG, Pc etc)">
											<div class="form_error_msg unitError"></div>
										</div>
										<div class="col-md-4">
											<label>Main Image</label>
											<div class="uploadOuter">
												<input type="file" class="form-control" name="main_image" />
												<?php if ($product->main_image != '') { ?>
													<a href="<?php echo base_url('aassets/images/product/' . $product->main_image . '') ?>" download>
														<img src="<?php echo base_url('assets/images/product/' . $product->main_image . '') ?>" alt="Hospital Image" class="images">
													</a>
												<?php } ?>
												<input type="hidden" class="form-control" name="old_main_image" value='<?= ($product->main_image); ?>'>
												<div class="form_error_msg main_imageError"></div>
											</div>

										</div>
									</div>
								</section>
								<hr>
								<h4>Colors</h4>
								<section id="updateImageSection">
									<?php
									if (isset($product_details) && is_array($product_details)) {
										foreach ($product_details as $imagesData) { ?>
											<div class="row">
												<div class="col-2">
													<p><?= $imagesData['title'] ?></p>
												</div>
												<div class="col-2">
													<img style="object-fit: contain;width:auto" src="<?= base_url() ?>assets/images/thumbnail/<?= $imagesData['image'] ?>">
												</div>
												<div class="col-2">
													<button class="btn btn-danger" type="button" onclick="removeProductImage(<?= $imagesData['id'] ?>)">Remove</button>
												</div>
											</div>

									<?php }
									}

									?>

								</section>
								<section>
									<div>
										<div class="form-group row">
											<div class="col-md-12">
												<div class="input_fields_wrap" id="color_box">
													<div class="row m-1">
														<div class="col-md-2">
															<input class="form-control" type="text" name="title[]" placeholder=" Title(Color name)">
														</div>
														<div class="col-md-4">
															<div class="uploadOuter">
																<input type="file" id="files1" class="form-control" name="thumbnail_image[]" multiple />
																<div class="form_error_msg thumbnail_imageError"></div>
															</div>
														</div>
														<button style="background-color:green;" class="add_field_button btn btn-info active">Add More</button>
													</div>
												</div>
											</div>
										</div>
									</div>
								</section>

								<h4>Attributes</h4>
								<hr>
								<section>
									<div>
										<div class="form-group row">
											<div class="col-md-12">
												<div class="input_fields_wrap">
													<div class="row m-1">
														<div class="col-md-4">
															<label>Select NIB</label>
															<input type="hidden" id="nib_drp_values" value='<?= $product->nib ?>'>
															<select class="form-control" id="nib_drp" name="nib_drp[]">

															</select>
														</div>
														<div class="col-md-4">
															<label>Select CLIP & RINGS</label>
															<input type="hidden" id="clip_drp_values" value='<?= $product->clip ?>'>
															<select class="form form-input" id="clip_drp" name="clip_drp[]">
															</select>
														</div>
														<div class="col-md-4">
															<input type="hidden" id="material_drp_values" value='<?= $product->material ?>'>
															<label>Select MATERIAL VARIANTS</label>
															<select class="form form-input" id="material_drp" name="material_drp[]" value="<?= $product->material ?>">
															</select>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</section>
								<?php
								if (isset($all_currencies)) {
									if (count($all_currencies) > 0) { ?>

										<h4>Pricing</h4>
										<hr>
										<section>
											<div>
												<div class="form-group row">
													<?php
													foreach ($all_currencies as $currencyData) {
														foreach ($product_price as $productPriceData) {
															if ($productPriceData['currency'] == $currencyData['currency']) {

													?>
																<div class="col-md-6">
																	<div class="input_fields_wrap">

																		<div class="row m-1" style="border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;padding-bottom:10px">
																			<div class="col-12" style="border-top: 1px solid black;border-bottom: 1px solid black">
																				<h6 id="currency_type_<?= $currencyData['currency'] ?>" data-currency_rate="<?= $currencyData['usd_rate'] ?>" style="margin-bottom: 0px;padding: 3px;"><?= $currencyData['symbol'] ?> <?= strtoupper($currencyData['currency']) ?></h6>
																			</div>
																			<div class="col-md-4">
																				<label for="<?= $currencyData['currency'] ?>_mrp">Mrp *</label>
																				<?php
																				if ($currencyData['currency'] == 'usd') { ?>
																					<input value="<?= $productPriceData['mrp'] ?>" class="form-control" name="<?= $currencyData['currency'] ?>_mrp" type="text" id="<?= $currencyData['currency'] ?>_mrp" onkeypress="chnageValuesOfPrice('mrp',this.value)" onkeydown="chnageValuesOfPrice('mrp',this.value)" onkeyup="chnageValuesOfPrice('mrp',this.value)">
																				<?php } else { ?>
																					<input value="<?= $productPriceData['mrp'] ?>" class=" form-control" name="<?= $currencyData['currency'] ?>_mrp" type="text" id="<?= $currencyData['currency'] ?>_mrp">
																				<?php }
																				?>

																				<div class="form_error_msg <?= $currencyData['currency'] ?>_mrp_mrpError"></div>
																			</div>
																			<div class="col-md-4">
																				<label for="<?= $currencyData['currency'] ?>_price">Price *</label>

																				<?php
																				if ($currencyData['currency'] == 'usd') { ?>
																					<input value="<?= $productPriceData['price'] ?>" class=" form-control" name="<?= $currencyData['currency'] ?>_price" type="text" id="<?= $currencyData['currency'] ?>_price" onkeypress="chnageValuesOfPrice('price',this.value)" onkeydown="chnageValuesOfPrice('price',this.value)" onkeyup="chnageValuesOfPrice('price',this.value)">
																				<?php } else { ?>
																					<input value="<?= $productPriceData['price'] ?>" class=" form-control" name="<?= $currencyData['currency'] ?>_price" type="text" id="<?= $currencyData['currency'] ?>_price">
																				<?php }
																				?>
																				<div class="form_error_msg <?= $currencyData['currency'] ?>_mrp_priceError"></div>
																			</div>
																			<div class="col-md-4">
																				<label for="<?= $currencyData['currency'] ?>_discount">Discount *</label>
																				<?php
																				if ($currencyData['currency'] == 'usd') { ?>
																					<input value="<?= $productPriceData['discount'] ?>" class=" form-control" name="<?= $currencyData['currency'] ?>_discount" type="text" id="<?= $currencyData['currency'] ?>_discount" onkeypress="chnageValuesOfPrice('discount',this.value)" onkeydown="chnageValuesOfPrice('discount',this.value)" onkeyup="chnageValuesOfPrice('discount',this.value)">
																				<?php } else { ?>
																					<input value="<?= $productPriceData['discount'] ?>" class=" form-control" name="<?= $currencyData['currency'] ?>_discount" type="text" id="<?= $currencyData['currency'] ?>_discount">
																				<?php }
																				?>
																				<div class="form_error_msg <?= $currencyData['currency'] ?>_mrp_discountError"></div>
																			</div>
																		</div>
																	</div>
																</div>
													<?php }
														}
													}
													?>
												</div>
											</div>
										</section>

								<?php }
								}
								?>

								<h4>Description</h4>
								<section>
									<div class="form-group row">
										<div class="col-lg-12">
											<textarea name="product_detail" id="code_preview0" rows="10" cols="80"><?= ($product->description); ?></textarea>
											<div class="form_error_msg product_detailError"></div>

										</div>
									</div>
								</section>

								<h4>Technical Specification</h4>
								<hr>
								<section>
								<div class="form-group row">
									<?php

									$tsp = ['dimension', 'nib_material', 'pen_material', 'trim', 'filling_mechanism'];
									
									$productTsp=json_decode($product->technical_specification);
									
									foreach($tsp as $tspData){?>
									
										<div class="col-4">
										<label for="<?= $tspData?>"><?= $tspData?></label>
											<textarea rows="5"  id="<?= $tspData?>" class="form-control" type="text" name="<?= $tspData?>"><?= $productTsp?$productTsp->$tspData:''?></textarea>
											<div class="form_error_msg <?= $tspData?>Error"></div>
										</div>
									
									<?php }?>
									</div>
								</section>
								<section>
								<div class="form-group row">
								<div class="col-md-4" data-select2-id="986">
											<label> Status</label>
											<select class="form-control single-select" name="status" id="status">
												<?php
												$makeSelectActive='';
												$makeSelectInActive='';
												if($product->status==1){ 
													$makeSelectActive='selected';
												} else {
													$makeSelectInActive='selected';
												 }
												?>			
												<option value="1" <?=$makeSelectActive?>>Active</option>
												<option value="0" <?=$makeSelectInActive?>>Inactive</option>
																									
		
																							</select>
											<div class="form_error_msg category_idError"></div>
										</div>
									</div>
								</section>

								<input type="hidden" class="form-control" name="product_id" value="<?= ($product->product_id); ?>">
								<button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i>Update</button>
							</div> <!-- End #wizard-vertical -->
							<br>
							<div class="success_message"></div>
						</form>
					</div>
				</div>
			</div>
		</div><!-- End Row-->


	</div>
	<!-- End container-fluid-->
	<script type="text/javascript">
		$(document).ready(function() {
			const tsp = ['dimension', 'nib_material', 'pen_material', 'trim', 'filling_mechanism'];
			tsp.map((tspid)=>{
				console.log(tspid);
				$(`#${tspid}`).summernote({
				height: 100
			});
		});
			$('#code_preview0').summernote({
				height: 300
			});
		});
	</script>
	<script src='//production-assets.codepen.io/assets/common/stopExecutionOnTimeout-b2a7b3fe212eaa732349046d8416e00a9dec26eb7fd347590fbced3ab38af52e.js'></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/summernote/0.6.6/summernote.min.js'></script>
	<script>
		$(document).ready(async () => {

			await getNibDropdownUpdate();
			await getClipAndRingsDropdownUpdate();
			await getMaterialDropdownUpdate();
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

		const getNibDropdownUpdate = async () => {
			const base_url = $("#base_url_textbox").val();
			var settings = {
				url: `${base_url}/nib_dropdown`,
				method: "POST",
				timeout: 0,
			};

			$.ajax(settings).done(function(resp) {
				const response = JSON.parse(resp);
				if (response.status == 200 && response.data.length > 0) {
					const selectedNibs = JSON.parse($('#nib_drp_values').val());
					$("#nib_drp").empty();
					for (let i = 0; i < response.data.length; i++) {
						if (selectedNibs.includes(response.data[i].id)) {
							$("#nib_drp").append(
								`<option selected value='${response.data[i].id}'>${response.data[i].name}</option>`
							);
						} else {
							$("#nib_drp").append(
								`<option value='${response.data[i].id}'>${response.data[i].name}</option>`
							);
						}

					}
				}
			});
		};

		const removeProductImage = async (id) => {
			if (confirm("Are you sure to remove this image?") == true) {
				const base_url = $("#base_url_textbox").val();
						var settings = {
							url: `${base_url}/remove_images`,
							method: "POST",
							timeout: 0,
							data:{id:id},
						};

						$.ajax(settings).done(function(resp) {
							const response = JSON.parse(resp);
							if (response.status == 200) {
								window.location.reload();
							}
						});
			}
		};

		const getClipAndRingsDropdownUpdate = async () => {
			const base_url = $("#base_url_textbox").val();
			var settings = {
				url: `${base_url}/clip_dropdown`,
				method: "POST",
				timeout: 0,
			};

			$.ajax(settings).done(function(resp) {
				const response = JSON.parse(resp);
				if (response.status == 200 && response.data.length > 0) {
					const selectedClips = JSON.parse($('#clip_drp_values').val());
					$("#clip_drp").empty();
					for (let i = 0; i < response.data.length; i++) {
						if (selectedClips.includes(response.data[i].id)) {
							$("#clip_drp").append(
								`<option selected value='${response.data[i].id}'>${response.data[i].name}</option>`
							);
						} else {
							$("#clip_drp").append(
								`<option value='${response.data[i].id}'>${response.data[i].name}</option>`
							);
						}
					}
				}
			});
		};

		const getMaterialDropdownUpdate = async () => {
			const base_url = $("#base_url_textbox").val();
			var settings = {
				url: `${base_url}/material_dropdown`,
				method: "POST",
				timeout: 0,
			};

			$.ajax(settings).done(function(resp) {
				const response = JSON.parse(resp);
				if (response.status == 200 && response.data.length > 0) {
					const selectedMaterial = JSON.parse($('#material_drp_values').val());
					$("#material_drp").empty();
					for (let i = 0; i < response.data.length; i++) {
						if (selectedMaterial.includes(response.data[i].id)) {
							$("#material_drp").append(
								`<option selected value='${response.data[i].id}'>${response.data[i].name}</option>`
							);
						} else {
							$("#material_drp").append(
								`<option value='${response.data[i].id}'>${response.data[i].name}</option>`
							);
						}
					}
				}
			});
		};

		const chnageValuesOfPrice = (type, value) => {
			const arrayOfCurrncies = ['rupee', 'pound', 'euro'];
			for (currency in arrayOfCurrncies) {
				console.log(arrayOfCurrncies[currency]);
				const usdRate = $(`#currency_type_${arrayOfCurrncies[currency]}`).data(`currency_rate`);
				console.log(usdRate, parseFloat(usdRate * value));
				$(`#${arrayOfCurrncies[currency]}_${type}`).val(parseFloat(usdRate * value));
			}
		}
		var content_row = 1;

		function addContent() {
			html = '<div id="content-row">';
			html += '<div class="form-group">';
			html += '<label class="col-sm-2">Page Content</label>';
			html += '<div class="col-sm-10">';
			html += '<textarea class="form-control" id="code_preview' + content_row + '" name="page_code[' + content_row + '][code]" style="height: 300px;"></textarea>';
			html += '</div>';
			html += '</div>';
			html += '</div>';
			$('#content-row').append(html);
			$('#code_preview' + content_row).summernote({
				height: 300
			});

			content_row++;
		}
		//# sourceURL=pen.js
	</script>
	<script>
		$(".delete").click(function() {

			if (confirm("Are you sure you want to delete this?"))

			{

				$(".success_message").html("");

				var element = $(this);

				var delete_id = element.attr("id");

				// var profile_image = element.attr("profile_image");

				// var data = 'delete_id=' + delete_id + '&profile_image=' + profile_image;
				var data = 'delete_id=' + delete_id;
				$.ajax({

					type: "POST",

					url: "<?php echo base_url(); ?>product/delete_product_price",

					data: data,

					success: function(data) {

						$(".show_" + delete_id).remove();

						$(".success_message").html(data).show();

						location.reload();

					}

				});

			}

			return false;



		});

		$(document).on('change', '#category_id', function() {
			$('#sub_category_id').empty();
			if ($(this).val() != 'none') {
				var id = $(this).val();
				$.ajax({
					type: 'POST',
					url: '<?php echo base_url(); ?>product/all_sub_subcategory_by_category_id',
					data: {
						id: id
					},
					dataType: 'json',
					success: function(json) {
						$('#sub_category_id').append($('<option>').text("Select"));
						$.each(json, function(key, value) {
							$('#sub_category_id')
								.append($("<option></option>")
									.attr("value", value.sub_category_id)
									.text(value.sub_category));
						});
					}
				})
			} else {
				$("#sub_category_id").empty();
			}
		});
	</script>




	<script>
		$(document).on('change', '#sub_category_id', function() {
			$('#sub_subcategory_id').empty();
			if ($(this).val() != 'none') {
				var id = $(this).val();
				$.ajax({
					type: 'POST',
					url: '<?php echo base_url(); ?>product/all_sub_subcategory_by_sub_category_id',
					data: {
						id: id
					},
					dataType: 'json',
					success: function(json) {
						$('#sub_subcategory_id').append($('<option>').text("Select"));
						$.each(json, function(key, value) {
							$('#sub_subcategory_id')
								.append($("<option></option>")
									.attr("value", value.sub_subcategory_id)
									.text(value.sub_subcategory));
						});
					}
				})
			} else {
				$("#sub_subcategory_id").empty();
			}
		});
	</script>
	<script type="text/javascript">
		$(function() {
			$('#add_product').ajaxForm({
				beforeSend: function() {
					$('.form_error_msg').html('');
					$('.success_message').html('<div class="alert alert-outline-warning alert-dismissible alert-round" role="alert"><button type="button" class="close" data-dismiss="alert">×</button><div class="alert-icon"> <i class="icon-exclamation"></i> </div><div class="alert-message"><span><strong>Data update!</strong> please wait.. <a href="javascript:void();" class="alert-link"></a></span></div></div>');
				},
				complete: function(response) {
					var temp = JSON.parse(response.responseText);
					if (temp.status == 'success') {
						$('.success_message').show().html(temp.message);
						window.location.href = temp.redirect;
					} else if (temp.status == 'error') {
						$('.success_message').html('');
						$.each(temp.errors, function(key, val) {
							$('.' + key).html(val);
						})
					}
				}
			});
		});
	</script>

	<script type="text/javascript">
		function addDocDetail1(tableId) {
			var table = document.getElementById(tableId);
			var rowCount = table.rows.length;
			var row = table.insertRow(rowCount);


			var cell1 = row.insertCell(0);
			var element1 = document.createElement('input');
			element1.type = 'text';
			element1.name = 'title[]';
			element1.className = 'form-control';
			element1.id = 'title' + rowCount;
			var element2 = document.createElement('input');

			element2.type = 'hidden';

			element2.name = 'fid[]';

			element2.id = 'fid' + rowCount;
			cell1.appendChild(element1);
			cell1.appendChild(element2);


			var cell2 = row.insertCell(1);
			var element3 = document.createElement('input');
			element3.type = 'text';
			element3.name = 'unit_price[]';
			element3.className = 'form-control';
			element3.id = 'unit_price' + rowCount;
			cell2.appendChild(element3);

			var cell3 = row.insertCell(2);
			var element4 = document.createElement('select');
			element4.options.add(new Option("Inclusion", "Inclusion", true));
			element4.options.add(new Option("Exclusion", "Exclusion", true));
			element4.type = 'text';
			element4.name = 'inc_exc[]';
			element4.className = 'form-control';
			element4.id = 'inc_exc' + rowCount;
			cell3.appendChild(element4);

			var cell4 = row.insertCell(3);
			var element5 = document.createElement('input');
			element5.type = 'text';
			element5.name = 'discount[]';
			element5.className = 'form-control';
			element5.id = 'discount' + rowCount;
			cell4.appendChild(element5);

			var cell5 = row.insertCell(4);
			var element6 = document.createElement('input');
			element6.type = 'text';
			element6.name = 'purchse_price[]';
			element6.className = 'form-control';
			element6.id = 'purchse_price' + rowCount;
			cell5.appendChild(element6);


			var cell6 = row.insertCell(5);
			var element7 = document.createElement("input");
			element7.type = "checkbox";
			element7.name = 'chkbox[]';
			//element5.setAttribute('class', 'fa fa-remove');
			element7.id = 'chkbox' + rowCount;
			element7.onchange = function() {
				//alert(rowCount);

				removeDoc1(tableId);
			}
			cell6.appendChild(element7);
			hideDocDiv1(tableId);
		}

		function hideDocDiv1(tableId) {
			try {
				var table = document.getElementById(tableId);
				var rowCount = table.rows.length;
				var cnt = rowCount - 1;
				if (rowCount == 1)
					$("#docAttachDiv").hide();
				else
					$("#docAttachDiv").show();
			} catch (e) {
				alert(e);
			}
			$("#photo_cnt").val(cnt);
		}

		function removeDoc1(tableId) {
			//alert(tableId);
			try {
				var table = document.getElementById(tableId);

				var rowCount = table.rows.length;
				var cnt = rowCount - 1;
				//alert(cnt);
				for (var i = 0; i < rowCount; i++) {
					var row = table.rows[i];
					//alert(row);
					var chkbox = row.cells[5].childNodes[1];
					var chkbox1 = row.cells[5].childNodes[0];
					//alert(chkbox);
					if (null != chkbox && true == chkbox.checked || null != chkbox1 && true == chkbox1.checked) {
						//alert('hi');
						if (rowCount <= 1) {
							alert("Cannot delete all the rows.");
							break;
						}
						table.deleteRow(i);
						rowCount--;
						i--;
					}
				}
			} catch (e) {
				alert(e);
			}

		}
	</script>