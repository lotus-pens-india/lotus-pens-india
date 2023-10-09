<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css'>
<link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/summernote/0.6.6/summernote.min.css'>


<div class="clearfix"></div>

<div class="content-wrapper">
	<div class="container-fluid">
		<!-- Breadcrumb-->
		<div class="row pt-2 pb-2">
			<div class="col-sm-9">
				<h4 class="page-title">Upload Product</h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="javaScript:void();">Product</a></li>
					<li class="breadcrumb-item"><a href="javaScript:void();">Upload Product</a></li>
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
					<div class="card-header"><i class="fa fa-upload"></i> Upload Product</div>
					<div class="card-body">
						<form id="add_product" method="post" action="<?php echo base_url(); ?>product/add_product_data">
							<div id="wizard-vertical1">

								<section>
									<h4>General</h4>
									<div class="form-group row">
										<div class="col-md-4">
											<label>Product Name *</label>
											<input class="form-control" name="product_name" type="text">
											<div class="form_error_msg product_nameError"></div>
										</div>
										<div class="col-md-4">
											<label> Category *</label>
											<select class="form-control single-select" name="category_id" id="category_id">
												<option value="">Select Category</option>
												<?php foreach ($all_category as $category) { ?>
													<option value="<?php echo $category->category_id ?>"><?php echo $category->name ?></option>
												<?php } ?>
											</select>
											<div class="form_error_msg category_idError"></div>
										</div>
										<div class="col-md-4">
											<label>Subcategory </label>
											<select class="form-control single-select" name="sub_category_id" id="sub_category_id">
											</select>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-4">
											<label>Brand *</label>
											<select class="form-control single-select" name="brand_id" id="brand_id">
												<option value="">Select Brand</option>
												<?php foreach ($all_brand as $brand) { ?>
													<option value="<?php echo $brand->brand_id ?>"><?php echo $brand->brand_name ?></option>
												<?php } ?>
											</select>
											<div class="form_error_msg brand_idError"></div>
										</div>
										<div class="col-md-4">
											<label>Unit *</label>
											<input type="text" class="form-control" name="unit" placeholder="Unit (e.g. KG, Pc etc)">
											<div class="form_error_msg unitError"></div>
										</div>
										<div class="col-md-4">
											<label>Main Image</label>
											<div class="uploadOuter">
												<input type="file" id="files" class="form-control" name="main_image" />
												<div class="form_error_msg main_imageError"></div>
											</div>

										</div>
									</div>
								</section>
								<hr>
								<h4>Colors</h4>
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
															<select class="form-control" id="nib_drp" name="nib_drp[]">
															</select>
														</div>
														<div class="col-md-4">
															<label>Select CLIP & RINGS</label>
															<select class="form form-input" id="clip_drp" name="clip_drp[]">
															</select>
														</div>
														<div class="col-md-4">
															<label>Select MATERIAL VARIANTS</label>
															<select class="form form-input" id="material_drp" name="clip_drp[]">
															</select>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</section>

								<h4>Pricing</h4>
								<hr>
								<section>
									<div>
										<div class="form-group row">

											<div class="col-md-12">
												<div class="input_fields_wrap">
													<h6>€ Euro</h6>
													<div class="row m-1">

														<div class="col-md-4">
															<label>Mrp *</label>
															<input class="form-control" name="euro_mrp" type="text" id="euro_mrp">
															<div class="form_error_msg euro_mrpError"></div>
														</div>
														<div class="col-md-4">
															<label>Price *</label>
															<input class="form-control" name="euro_price" type="text" id="euro_price">
															<div class="form_error_msg euro_priceError"></div>
														</div>
														<div class="col-md-4">
															<label>Discount *</label>
															<input class="form-control" name="euro_discount" type="text" id="euro_discount">
															<div class="form_error_msg euro_discountError"></div>
														</div>
													</div>

													<h6>£ Pound Sterling</h6>
													<div class="row m-1">

														<div class="col-md-4">
															<label>Mrp *</label>
															<input class="form-control" name="pound_mrp" type="text" id="pound_mrp">
															<div class="form_error_msg product_nameError"></div>
														</div>
														<div class="col-md-4">
															<label>Price *</label>
															<input class="form-control" name="pound_price" id="pound_price" type="text">
															<div class="form_error_msg product_nameError"></div>
														</div>
														<div class="col-md-4">
															<label>Discount *</label>
															<input class="form-control" name="pound_discount" type="text" id="pound_discount">
															<div class="form_error_msg product_nameError"></div>
														</div>
													</div>

													<h6>₹ Rupee</h6>
													<div class="row m-1">

														<div class="col-md-4">
															<label>Mrp *</label>
															<input class="form-control" name="rupee_mrp" type="text" id="rupee_mrp">
															<div class="form_error_msg product_nameError"></div>
														</div>
														<div class="col-md-4">
															<label>Price *</label>
															<input class="form-control" name="rupee_price" type="text" id="rupee_price">
															<div class="form_error_msg product_nameError"></div>
														</div>
														<div class="col-md-4">
															<label>Discount *</label>
															<input class="form-control" name="rupee_discount" type="text" id="rupee_discount">
															<div class="form_error_msg product_nameError"></div>
														</div>
													</div>	


													<h6>$ US Dollar</h6>
													<div class="row m-1">

														<div class="col-md-4">
															<label>Mrp *</label>
															<input class="form-control" name="usd_mrp" type="text" id="usd_mrp">
															<div class="form_error_msg product_nameError"></div>
														</div>
														<div class="col-md-4">
															<label>Price *</label>
															<input class="form-control" name="usd_price" type="text" id="usd_price">
															<div class="form_error_msg product_nameError"></div>
														</div>
														<div class="col-md-4">
															<label>Discount *</label>
															<input class="form-control" name="usd_discount" type="text"  id="usd_discount">
															<div class="form_error_msg product_nameError"></div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</section>

								<h4>Description</h4>
								<section>
									<?php $content_row = 0; ?>
									<div class="form-group row">
										<div class="col-lg-12">

											<textarea name="product_detail" id="code_preview0" rows="10" cols="80"></textarea>
											<div class="form_error_msg product_detailError"></div>
										</div>
									</div>
									<?php $content_row++; ?>
								</section>
								<!--- <h4>Shipping Info</h4>
                    <section>
                        <div class="row bt-switch">
						  <div class="col-lg-4">
                           <label>Free Shipping</label>
						  </div>
                          <div class="col-lg-8">	
							
							<input id="option2" type="radio" name="shipping_type" value="free" class="switch-input">						  
						  </div>	  
                        </div>
						<hr>
						<div class="row bt-switch">
						  <div class="col-lg-4">
                           <label>Local Pickup</label>
						  </div>
                          <div class="col-lg-8">
								<input id="option1" type="radio" name="shipping_type" value="local_pickup" class="switch-input">						  
						  </div>	  
                        </div><br>
                         <div class="row">
						  <div class="col-lg-4">
						  <label>Shipping cost</label>
						  </div>
                          <div class="col-lg-8">						  
							  <input type="number" min="0" value="0" step="0.01" id="local_pickup_shipping_cost" disabled placeholder="Shipping cost" name="shipping_cost" class="form-control">
						  </div>	  
                        </div>	
                        <hr>--->

								</section>
								<button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i>Add</button>
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
			$('#code_preview0').summernote({
				height: 300
			});
		});
	</script>
	<script src='//production-assets.codepen.io/assets/common/stopExecutionOnTimeout-b2a7b3fe212eaa732349046d8416e00a9dec26eb7fd347590fbced3ab38af52e.js'></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/summernote/0.6.6/summernote.min.js'></script>
	<script>
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
						$('#sub_category_id').append($('<option value>').text("Select"));
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
					$('.success_message').html('<div class="alert alert-outline-warning alert-dismissible alert-round" role="alert"><button type="button" class="close" data-dismiss="alert">×</button><div class="alert-icon"> <i class="icon-exclamation"></i> </div><div class="alert-message"><span><strong>Data add!</strong> please wait.. <a href="javascript:void();" class="alert-link"></a></span></div></div>');
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