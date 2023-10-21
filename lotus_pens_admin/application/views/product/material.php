<div class="clearfix"></div>

<div class="content-wrapper">
	<div class="container-fluid">
		<!-- Breadcrumb-->
		<div class="row pt-2 pb-2">
			<div class="col-sm-9">
				<h4 class="page-title">Nib</h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="javaScript:void();">Product</a></li>
					<li class="breadcrumb-item"><a href="javaScript:void();">Material Tables</a></li>
					<li class="breadcrumb-item active" aria-current="page">Material Data Tables</li>
				</ol>
			</div>
			<div class="col-sm-3">
				<div class="float-sm-right">
					<?php $login_type = $this->session->userdata('type');
					if ($login_type != '0') { ?>
						<button type="button" class="btn btn-primary waves-effect waves-light m-1" data-toggle="modal"
							data-target="#defaultsizemodal">Add Material</button>
					<?php } ?>
				</div>
			</div>
		</div>
		<!-- End Breadcrumb-->
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header"><i class="fa fa-table"></i> Material List</div>
					<div class="card-body">
						<div class="table-responsive">
							<table id="brand-datatable" class="table table-bordered">
								<thead>
									<tr>
										<th>Sr.No</th>
										<th>Material Name</th>
										<th>Usd Price</th>
										<th>Rupee Price</th>
										<th>Euro price</th>
										<th>Pound price</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if ($all_brand != '') {
										$i = 1;
										foreach ($all_brand as $brand) {
											?>
											<tr>
												<td>
													<?php echo $i++; ?>
												</td>
												<td>
													<?php echo $brand->name ?>
												</td>
												<td>
													<?php echo $brand->usd_price ?>
												</td>
												<td>
													<?php echo $brand->rupee_price ?>
												</td>
												<td>
													<?php echo $brand->euro_price ?>
												</td>
												<td>
													<?php echo $brand->pound_price ?>
												</td>
												<td>
													<?php
													if ($brand->status == '1') {
														echo '<span class="badge badge-success shadow-success m-1">Enable</span>';

													} elseif ($brand->status == '0') {
														echo '<span class="badge badge-danger shadow-danger m-1">Disable</span>';

													}
													?>
												</td>
												<td>
													<button type="button" class="btn btn-secondary waves-effect waves-light m-1"
														data-toggle="modal"
														data-target="#defaultsizemodal<?php echo $brand->id ?>"> <i
															class="fa fa-edit"></i> </button>
													<a style="cursor:pointer;"
														class="tip-top delete delete one_<?php echo $brand->id; ?>"
														data-original-title="Delete" id="<?php echo $brand->id; ?>"
														Onclick="return isActive_Material(<?php echo $brand->id ?>,<?php echo $brand->status ?>);">
														<button type="button"
															class="btn btn-secondary waves-effect waves-light m-1"> 
															<?php echo $brand->status=='1'?'<i
																class="fa fa-times" ></i> ':'<i
																class="fa fa-check"></i> ' ?>
															</button>
													</a>
												</td>
											</tr>
											<!-- Modal -->
											<div class="modal fade" id="defaultsizemodal<?php echo $brand->id ?>">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title"><i class="fa fa-star"></i> Update Material</h5>
															<button type="button" class="close" data-dismiss="modal"
																aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<form id="update_Material<?php echo $brand->id ?>" method="post"
															action="<?php echo base_url(); ?>product/update_material_data"
															enctype="multipart/form-data">
															<div class="modal-body">
																<div class="form-group">
																	<label for="input-1">Material Name</label>
																	<input type="text" class="form-control" name="name"
																		id="input-1" value="<?php echo $brand->name; ?>"
																		placeholder="Enter NIB Name">
																	<div class="form_error_msg brand_nameError"></div>
																</div>
																<div class="form-group">
																	<label for="input-1">Usd Price</label>
																	<input type="number" name="usd_price" class="form-control"
																		value="<?php echo $brand->usd_price; ?>">
																</div>
																<div class="form-group">
																	<label for="input-1">Rupee Price</label>
																	<input type="number" name="rupee_price" class="form-control"
																		value="<?php echo $brand->rupee_price; ?>">
																</div>
																<div class="form-group">
																	<label for="input-1">Euro Price</label>
																	<input type="number" name="euro_price" class="form-control"
																		value="<?php echo $brand->euro_price; ?>">
																</div>
																<div class="form-group">
																	<label for="input-1">Pound Price</label>
																	<input type="number" name="pound_price" class="form-control"
																		value="<?php echo $brand->pound_price; ?>">
																</div>

															</div>
															<input type="hidden" value="<?php echo $brand->id; ?>" name="id">
															<div class="modal-footer">
																<button type="button" class="btn btn-secondary"
																	data-dismiss="modal"><i class="fa fa-times"></i>
																	Close</button>
																<button type="submit" class="btn btn-primary"><i
																		class="fa fa-check-square-o"></i>Update</button>
															</div>
															<div class="success_message"></div>
														</form>
													</div>
												</div>
											</div>
											<script type="text/javascript">
												$(function () {
													$('#update_Material<?php echo $brand->id ?>').ajaxForm({
														beforeSend: function () {
															$('.form_error_msg').html('');
															$('.success_message').html('<div class="alert alert-outline-warning alert-dismissible alert-round" role="alert"><button type="button" class="close" data-dismiss="alert">×</button><div class="alert-icon"> <i class="icon-exclamation"></i> </div><div class="alert-message"><span><strong>Data update!</strong> please wait.. <a href="javascript:void();" class="alert-link"></a></span></div></div>');
														},
														complete: function (response) {
															var temp = JSON.parse(response.responseText);
															if (temp.status == 'success') {
																$('.success_message').show().html(temp.message);
																window.location.href = temp.redirect;
															} else if (temp.status == 'error') {
																$('.success_message').html('');
																$.each(temp.errors, function (key, val) {
																	$('.' + key).html(val);
																})
															}
														}
													});
												});

											</script>
										<?php }
									} else {
										echo '';
									} ?>
								</tbody>

							</table>
						</div>
					</div>
				</div>
			</div>
		</div><!-- End Row-->


	</div>
	<!-- End container-fluid-->

	<!-- Modal -->
	<div class="modal fade" id="defaultsizemodal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><i class="fa fa-star"></i> Add Material</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="add_material" method="post" action="<?php echo base_url(); ?>product/add_material_data"
					enctype="multipart/form-data">
					<div class="modal-body">
						<div class="form-group">
							<label for="input-1">Material Name</label>
							<input type="text" class="form-control" name="name" id="name" placeholder="Enter Material Name">
							<div class="form_error_msg brand_nameError"></div>
						</div>
						<div class="form-group">
							<label for="input-1">USD Price</label>
							<input type="text" class="form-control" name="usd_price" id="usd_price"
								placeholder="Enter USD Price">
							<div class="form_error_msg brand_nameError"></div>
						</div>
						<div class="form-group">
							<label for="input-1">Rupee Price</label>
							<input type="text" class="form-control" name="rupee_price" id="rupee_price"
								placeholder="Enter Rupee Price">
							<div class="form_error_msg brand_nameError"></div>
						</div>
						<div class="form-group">
							<label for="input-1">Euro Price</label>
							<input type="text" class="form-control" name="euro_price" id="euro_price"
								placeholder="Enter Euro Price">
							<div class="form_error_msg brand_nameError"></div>
						</div>
						<div class="form-group">
							<label for="input-1">Pound Price</label>
							<input type="text" class="form-control" name="pound_price" id="pound_price"
								placeholder="Enter Pound Price">
							<div class="form_error_msg brand_nameError"></div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>
							Close</button>
						<button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i>Add</button>
					</div>
					<div class="success_message"></div>
				</form>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(function () {
			$('#add_material').ajaxForm({
				beforeSend: function () {
					$('.form_error_msg').html('');
					$('.success_message').html('<div class="alert alert-outline-warning alert-dismissible alert-round" role="alert"><button type="button" class="close" data-dismiss="alert">×</button><div class="alert-icon"> <i class="icon-exclamation"></i> </div><div class="alert-message"><span><strong>Data add!</strong> please wait.. <a href="javascript:void();" class="alert-link"></a></span></div></div>');
				},
				complete: function (response) {
					var temp = JSON.parse(response.responseText);
					if (temp.status == 'success') {
						$('.success_message').show().html(temp.message);
						window.location.href = temp.redirect;
					} else if (temp.status == 'error') {
						$('.success_message').html('');
						$.each(temp.errors, function (key, val) {
							$('.' + key).html(val);
						})
					}
				}
			});
		});

	</script>
	<script type="text/javascript">
		function isActive_Material(id, status) {
			if (confirm("Are you sure you want to delete this Record?")) {
				$(".message").html("");

				$.ajax({
					type: "POST",
					url: "<?php echo base_url(); ?>product/isActive_Material",
					data: { 'id': id, 'status': status },
					success: function (resp) {
						resp = JSON.parse(resp);
						if (resp.status == 'success') {
							window.location.reload();
						}
					}
				});

			}
			return false;
		}

	</script>