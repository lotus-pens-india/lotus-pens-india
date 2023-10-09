   <!--Start Back To Top Button-->
   <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
   <!--End Back To Top Button-->


   </div><!--End wrapper-->


   <!-- Bootstrap core JavaScript-->
   <script src="<?php echo base_url(); ?>assets/js/popper.min.js"></script>
   <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>

   <!-- simplebar js -->
   <script src="<?php echo base_url(); ?>assets/plugins/simplebar/js/simplebar.js"></script>
   <!-- sidebar-menu js -->
   <script src="<?php echo base_url(); ?>assets/js/sidebar-menu.js"></script>
   <!-- Custom scripts -->
   <script src="<?php echo base_url(); ?>assets/js/app-script.js"></script>
   <!-- Sparkline JS -->
   <script src="<?php echo base_url(); ?>assets/plugins/sparkline-charts/jquery.sparkline.min.js"></script>
   <!-- Chart js -->
   <script src="<?php echo base_url(); ?>assets/plugins/Chart.js/Chart.min.js"></script>
   <!-- Index js -->
   <script src="<?php echo base_url(); ?>assets/js/index3.js"></script>
   <script src="<?php echo base_url(); ?>assets/js/jquery_form.js"></script>
   <!--Data Tables js-->
   <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js"></script>
   <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js"></script>
   <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js"></script>
   <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datatable/js/buttons.bootstrap4.min.js"></script>
   <!--Lightbox-->
   <script src="<?php echo base_url(); ?>assets/plugins/fancybox/js/jquery.fancybox.min.js"></script>
   <!--Select Plugins Js-->
   <script src="<?php echo base_url(); ?>assets/plugins/select2/js/select2.min.js"></script>
   <script src="<?php echo base_url(); ?>assets/plugins/select2/js/select2.min.js"></script>
   <script src="<?php echo base_url(); ?>assets/js/product.js"></script>
   <!--Inputtags Js-->
   <script src="<?php echo base_url(); ?>assets/plugins/inputtags/js/bootstrap-tagsinput.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.2.0/js/bootstrap-colorpicker.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.2.0/js/bootstrap-colorpicker.js"></script>


   <!--Multi Select Js-->
   <script src="<?php echo base_url(); ?>assets/plugins/jquery-multi-select/jquery.multi-select.js"></script>
   <script src="<?php echo base_url(); ?>assets/plugins/jquery-multi-select/jquery.quicksearch.js"></script>
   <!--Switchery Js-->
   <script src="<?php echo base_url(); ?>assets/plugins/switchery/js/switchery.min.js"></script>
   <script>
   	var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
   	$('.js-switch').each(function() {
   		new Switchery($(this)[0], $(this).data());
   	});
   </script>
   <script type="text/javascript">
   	$(function() {
   		$('#assign_product').ajaxForm({
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

   <!--Bootstrap Datepicker Js-->
   <script>
   	$('#default-datepicker').datepicker({
   		todayHighlight: true
   	});
   	$('#default-datepicker0').datepicker({
   		todayHighlight: true
   	});
   	$('#default-datepicker1').datepicker({
   		todayHighlight: true
   	});
   	$('#default-datepicker2').datepicker({
   		todayHighlight: true
   	});
   	$('#default-datepicker3').datepicker({
   		todayHighlight: true
   	});
   	$('#default-datepicker4').datepicker({
   		todayHighlight: true
   	});
   	$('#autoclose-datepicker').datepicker({
   		autoclose: true,
   		todayHighlight: true
   	});
   	$('#autoclose-datepicker1').datepicker({
   		autoclose: true,
   		todayHighlight: true,
   	});
   	$('#autoclose-datepicker000').datepicker({
   		autoclose: true,
   		todayHighlight: true,
   	});

   	$('#inline-datepicker').datepicker({
   		todayHighlight: true
   	});

   	$('#dateragne-picker .input-daterange').datepicker({});
   </script>

   <!--Bootstrap Switch Buttons-->
   <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-switch/bootstrap-switch.min.js"></script>


   <script>
   	$(".bt-switch input[type='checkbox'], .bt-switch input[type='radio']").bootstrapSwitch();
   	var radioswitch = function() {
   		var bt = function() {
   			$(".radio-switch").on("switch-change", function() {
   				$(".radio-switch").bootstrapSwitch("toggleRadioState")

   			}), $(".radio-switch").on("switch-change", function() {
   				$(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck")

   			}), $(".radio-switch").on("switch-change", function() {
   				$(".radio-switch").bootstrapSwitch("toggleRadioStateAllowUncheck", !1)
   			})
   		};
   		return {
   			init: function() {
   				bt()
   			}
   		}
   	}();

   	$(document).ready(function() {
   		//Default data table
   		$('#brand-datatable').DataTable();
   		$('#saller_datatable').DataTable();
   		$('#pickup-datatable').DataTable();
   		$('#comm-datatable').DataTable();
   		$('#comm-datatable1').DataTable();
   		$('#sales_report_datatable').DataTable();

   		// $('#customer_datatable').DataTable();
   		radioswitch.init()

   		var max_fields = 15; //maximum input boxes allowed
   		var wrapper = $("#color_box"); //Fields wrapper
   		var add_button = $(".add_field_button"); //Add button ID
   		var x = 1; //initlal text box count
   		$(add_button).click(function(e) { //on add input button click
   			e.preventDefault();
   			if (x < max_fields) { //max input box allowed
   				x++; //text box increment
   				$(wrapper).append(`
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
														<button style="background-color:red;" class="remove_field btn btn-info active">Remove</button>
													</div>
		`); //add input box
   			}
   		});
   		$(wrapper).on("click", ".remove_field", function(e) { //user click on remove text
   			e.preventDefault();
   			$(this).parent('div').remove();
   			x--;
   		})


   		$('#product_id').select2();
   		$('#unit').select2();
   		$('.single-select').select2();
   		$('.multiple-select').select2();
   	});
   </script>

   <script>
   	$(document).ready(function() {
   		$('#customer_datatable').DataTable({
   			"processing": true,
   			"serverSide": true,
   			"ajax": {
   				"url": "<?php echo base_url('customer/ajax_customer_list') ?>",
   				"type": "POST",
   				error: function() {

   					$(".customer_datatable-error").html("");
   					$("#customer_datatable").append('<tbody class="posts-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
   					$("#customer_datatable_processing").css("display", "none");

   				}
   			},
   			"columns": [{
   					"data": "customer_id"
   				},
   				{
   					"data": "first_name"
   				},
   				{
   					"data": "mobile_no"
   				},
   				{
   					"data": "referral_code"
   				},
   				{
   					"data": "city"
   				},
   				{
   					"data": "pincode"
   				},
   				{
   					"data": "wallet"
   				},
   				{
   					"data": "date"
   				},
   				{
   					"data": "flag"
   				},
   				{
   					"data": "action"
   				},

   			]

   		});
   	});
   </script>

   <script>
   	$(document).ready(function() {
   		$('#today_sale_datatable').DataTable({
   			"processing": true,
   			"serverSide": true,
   			"ajax": {
   				"url": "<?php echo base_url('sales/ajax_today_order_list') ?>",
   				"type": "POST",
   				error: function() {

   					$(".today_sale_datatable-error").html("");
   					$("#today_sale_datatable").append('<tbody class="posts-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
   					$("#today_sale_datatable_processing").css("display", "none");

   				}
   			},
   			"columns": [{
   					"data": "order_id"
   				},
   				{
   					"data": "order_generate_id"
   				},
   				{
   					"data": "count_product"
   				},
   				{
   					"data": "customer_id"
   				},
   				{
   					"data": "mobile_no"
   				},
   				{
   					"data": "order_total"
   				},

   				{
   					"data": "assign_to"
   				},
   				{
   					"data": "order_date"
   				},
   				{
   					"data": "flag"
   				},
   				{
   					"data": "status"
   				},
   				{
   					"data": "action"
   				},


   			],

   			"columnDefs": [{
   				"targets": [-1], //last column
   				"orderable": false, //set not orderable
   			}, ],

   		});
   	});
   </script>
   <script>
   	$(document).ready(function() {
   		$('#total_sale_datatable').DataTable({
   			"processing": true,
   			"serverSide": true,
   			"ajax": {
   				"url": "<?php echo base_url('sales/ajax_total_order_list') ?>",
   				"type": "POST",
   				error: function() {

   					$(".today_sale_datatable-error").html("");
   					$("#today_sale_datatable").append('<tbody class="posts-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
   					$("#today_sale_datatable_processing").css("display", "none");

   				}
   			},
   			"columns": [{
   					"data": "order_id"
   				},
   				{
   					"data": "order_generate_id"
   				},
   				{
   					"data": "count_product"
   				},
   				{
   					"data": "customer_id"
   				},
   				{
   					"data": "mobile_no"
   				},
   				{
   					"data": "order_total"
   				},

   				{
   					"data": "assign_to"
   				},
   				{
   					"data": "order_date"
   				},
   				{
   					"data": "flag"
   				},
   				{
   					"data": "status"
   				},
   				{
   					"data": "action"
   				},


   			],

   			"columnDefs": [{
   				"targets": [-1], //last column
   				"orderable": false, //set not orderable
   			}, ],

   		});
   	});
   </script>
   <script>
   	$(document).ready(function() {
   		$('#pending_sale_datatable').DataTable({
   			"processing": true,
   			"serverSide": true,
   			"ajax": {
   				"url": "<?php echo base_url('sales/ajax_pending_order_list') ?>",
   				"type": "POST",
   				error: function() {

   					$(".pending_sale_datatable-error").html("");
   					$("#pending_sale_datatable").append('<tbody class="posts-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
   					$("#pending_sale_datatable_processing").css("display", "none");

   				}
   			},
   			"columns": [{
   					"data": "order_id"
   				},
   				{
   					"data": "order_generate_id"
   				},
   				{
   					"data": "count_product"
   				},
   				{
   					"data": "customer_id"
   				},
   				{
   					"data": "order_total"
   				},
   				{
   					"data": "status"
   				},
   				{
   					"data": "payment_status"
   				},
   				{
   					"data": "assign_to"
   				},
   				{
   					"data": "order_date"
   				},
   				{
   					"data": "action"
   				},


   			],

   			"columnDefs": [{
   				"targets": [-1], //last column
   				"orderable": false, //set not orderable
   			}, ],

   		});
   	});
   </script>
   <script>
   	$(document).ready(function() {
   		$('#dispatch_sale_datatable').DataTable({
   			"processing": true,
   			"serverSide": true,
   			"ajax": {
   				"url": "<?php echo base_url('sales/ajax_dispatch_order_list') ?>",
   				"type": "POST",
   				error: function() {

   					$(".dispatch_sale_datatable-error").html("");
   					$("#dispatch_sale_datatable").append('<tbody class="posts-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
   					$("#dispatch_sale_datatable_processing").css("display", "none");

   				}
   			},
   			"columns": [{
   					"data": "order_id"
   				},
   				{
   					"data": "order_generate_id"
   				},
   				{
   					"data": "count_product"
   				},
   				{
   					"data": "customer_id"
   				},
   				{
   					"data": "order_total"
   				},
   				{
   					"data": "order_date"
   				},
   				{
   					"data": "status"
   				},
   				{
   					"data": "payment_status"
   				},
   				{
   					"data": "action"
   				},


   			],

   			"columnDefs": [{
   				"targets": [-1], //last column
   				"orderable": false, //set not orderable
   			}, ],

   		});
   	});
   </script>
   <script>
   	$(document).ready(function() {
   		$('#deliver_sale_datatable').DataTable({
   			"processing": true,
   			"serverSide": true,
   			"ajax": {
   				"url": "<?php echo base_url('sales/ajax_deliver_order_list') ?>",
   				"type": "POST",
   				error: function() {

   					$(".deliver_sale_datatable-error").html("");
   					$("#deliver_sale_datatable").append('<tbody class="posts-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
   					$("#deliver_sale_datatable_processing").css("display", "none");

   				}
   			},
   			"columns": [{
   					"data": "order_id"
   				},
   				{
   					"data": "order_generate_id"
   				},
   				{
   					"data": "count_product"
   				},
   				{
   					"data": "customer_id"
   				},
   				{
   					"data": "order_total"
   				},
   				{
   					"data": "status"
   				},
   				{
   					"data": "payment_status"
   				},
   				{
   					"data": "assign_to"
   				},
   				{
   					"data": "franchise"
   				},
   				{
   					"data": "action"
   				},


   			],

   			"columnDefs": [{
   				"targets": [-1], //last column
   				"orderable": false, //set not orderable
   			}, ],

   		});
   	});
   </script>

   <script>
   	$(document).ready(function() {
   		$('#cancel_sale_datatable').DataTable({
   			"processing": true,
   			"serverSide": true,
   			"ajax": {
   				"url": "<?php echo base_url('sales/ajax_cancel_order_list') ?>",
   				"type": "POST",
   				error: function() {

   					$(".cancel_sale_datatable-error").html("");
   					$("#cancel_sale_datatable").append('<tbody class="posts-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
   					$("#cancel_sale_datatable_processing").css("display", "none");

   				}
   			},
   			"columns": [{
   					"data": "order_id"
   				},
   				{
   					"data": "order_generate_id"
   				},
   				{
   					"data": "count_product"
   				},
   				{
   					"data": "customer_id"
   				},
   				{
   					"data": "order_total"
   				},
   				{
   					"data": "status"
   				},
   				{
   					"data": "payment_status"
   				},
   				{
   					"data": "refund_status"
   				},
   				{
   					"data": "franchise"
   				},


   			],

   			"columnDefs": [{
   				"targets": [-1], //last column
   				"orderable": false, //set not orderable
   			}, ],

   		});
   	});
   </script>


   <script>
   	$(document).ready(function() {
   		$('#cancel_sale_datatable1').DataTable({
   			"processing": true,
   			"serverSide": true,
   			"ajax": {
   				"url": "<?php echo base_url('sales/ajax_cancel_order_list1') ?>",
   				"type": "POST",
   				error: function() {

   					$(".cancel_sale_datatable1-error").html("");
   					$("#cancel_sale_datatable1").append('<tbody class="posts-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
   					$("#cancel_sale_datatable1_processing").css("display", "none");

   				}
   			},
   			"columns": [{
   					"data": "order_id"
   				},
   				{
   					"data": "order_generate_id"
   				},
   				{
   					"data": "count_product"
   				},
   				{
   					"data": "customer_id"
   				},
   				{
   					"data": "order_total"
   				},
   				{
   					"data": "status"
   				},
   				{
   					"data": "resion"
   				},
   				{
   					"data": "franchise"
   				},


   			],

   			"columnDefs": [{
   				"targets": [-1], //last column
   				"orderable": false, //set not orderable
   			}, ],

   		});
   	});
   </script>

   <script>
   	$(document).ready(function() {
   		$('#product_datetable').DataTable({
   			"processing": true,
   			"serverSide": true,
   			"ajax": {
   				"url": "<?php echo base_url('product/ajax_product_list') ?>",
   				"type": "POST",
   				error: function() {

   					$(".product_datetable-error").html("");
   					$("#product_datetable").append('<tbody class="posts-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
   					$("#product_datetable_processing").css("display", "none");

   				}
   			},
   			"columns": [{
   					"data": "product_id"
   				},
   				{
   					"data": "main_image"
   				},
   				{
   					"data": "product_name"
   				},
   				{
   					"data": "category"
   				},
   				{
   					"data": "brand"
   				},
   				{
   					"data": "qty"
   				},
   				{
   					"data": "sales_price"
   				},
   				{
   					"data": "purchse_price"
   				},
   				{
   					"data": "franchise"
   				},
   				{
   					"data": "action"
   				},


   			],

   			"columnDefs": [{
   				"targets": [-1], //last column
   				"orderable": false, //set not orderable
   			}, ],

   		});
   	});
   </script>


   <script>
   	$(document).ready(function() {
   		$('#stock_datetable').DataTable({
   			"processing": true,
   			"serverSide": true,
   			"ajax": {
   				"url": "<?php echo base_url('purchse/ajax_stock_list') ?>",
   				"type": "POST",
   				error: function() {

   					$(".stock_datetable-error").html("");
   					$("#stock_datetable").append('<tbody class="posts-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
   					$("#stock_datetable_processing").css("display", "none");

   				}
   			},
   			"columns": [{
   					"data": "product_id"
   				},
   				{
   					"data": "main_image"
   				},
   				{
   					"data": "product_name"
   				},
   				{
   					"data": "qty"
   				},
   				{
   					"data": "franchise"
   				},


   			],

   			"columnDefs": [{
   				"targets": [-1], //last column
   				"orderable": false, //set not orderable
   			}, ],

   		});
   	});
   </script>

   <script>
   	$(document).ready(function() {
   		$('#subscription_datatable').DataTable({
   			"processing": true,
   			"serverSide": true,
   			"ajax": {
   				"url": "<?php echo base_url('sales/ajax_subscription_list') ?>",
   				"type": "POST",
   				error: function() {

   					$(".subscription_datatable-error").html("");
   					$("#subscription_datatable").append('<tbody class="posts-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
   					$("#subscription_datatable_processing").css("display", "none");

   				}
   			},
   			"columns": [{
   					"data": "subscribe_id"
   				},
   				{
   					"data": "subscribe_generate_id"
   				},
   				{
   					"data": "customer"
   				},
   				{
   					"data": "mobile_no"
   				},
   				{
   					"data": "total_day"
   				},
   				{
   					"data": "date"
   				},
   				{
   					"data": "mode"
   				},
   				{
   					"data": "assign_to"
   				},
   				{
   					"data": "franchise"
   				},
   				{
   					"data": "action"
   				},


   			],

   			"columnDefs": [{
   				"targets": [-1], //last column
   				"orderable": false, //set not orderable
   			}, ],

   		});
   		$("#checkAll").click(function() {
   			$('input:checkbox').not(this).prop('checked', this.checked);
   		});
   	});
   </script>
   <script>
   	$(document).ready(function() {
   		$('#today_datatable').DataTable({
   			"processing": true,
   			"serverSide": true,
   			"ajax": {
   				"url": "<?php echo base_url('sales/ajax_today_subscription_list') ?>",
   				"type": "POST",
   				error: function() {

   					$(".today_datatable-error").html("");
   					$("#today_datatable").append('<tbody class="posts-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
   					$("#today_datatable_processing").css("display", "none");

   				}
   			},
   			"columns": [{
   					"data": "subscribe_id"
   				},
   				{
   					"data": "subscribe_generate_id"
   				},
   				{
   					"data": "customer"
   				},
   				{
   					"data": "mobile_no"
   				},
   				{
   					"data": "total_day"
   				},
   				{
   					"data": "date"
   				},
   				{
   					"data": "mode"
   				},
   				{
   					"data": "assign_to"
   				},
   				{
   					"data": "franchise"
   				},
   				{
   					"data": "action"
   				},


   			],

   			"columnDefs": [{
   				"targets": [-1], //last column
   				"orderable": false, //set not orderable
   			}, ],

   		});
   	});
   </script>
   <script>
   	$(document).ready(function() {
   		$('#active_datatable').DataTable({
   			"processing": true,
   			"serverSide": true,
   			"ajax": {
   				"url": "<?php echo base_url('sales/ajax_active_subscription_list') ?>",
   				"type": "POST",
   				error: function() {

   					$(".active_datatable-error").html("");
   					$("#active_datatable").append('<tbody class="posts-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
   					$("#active_datatable_processing").css("display", "none");

   				}
   			},
   			"columns": [{
   					"data": "subscribe_id"
   				},
   				{
   					"data": "subscribe_generate_id"
   				},
   				{
   					"data": "customer"
   				},
   				{
   					"data": "product_name"
   				},
   				{
   					"data": "date"
   				},
   				{
   					"data": "mode"
   				},
   				{
   					"data": "assign_to"
   				},
   				{
   					"data": "status"
   				},
   				{
   					"data": "franchise"
   				},


   			],


   		});
   	});
   </script>

   <script>
   	$(document).ready(function() {
   		$('#pause_datatable').DataTable({
   			"processing": true,
   			"serverSide": true,
   			"ajax": {
   				"url": "<?php echo base_url('sales/ajax_pause_subscription_list') ?>",
   				"type": "POST",
   				error: function() {

   					$(".pause_datatable-error").html("");
   					$("#pause_datatable").append('<tbody class="posts-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
   					$("#pause_datatable_processing").css("display", "none");

   				}
   			},
   			"columns": [{
   					"data": "subscribe_id"
   				},
   				{
   					"data": "subscribe_generate_id"
   				},
   				{
   					"data": "customer"
   				},
   				{
   					"data": "product_name"
   				},
   				{
   					"data": "date"
   				},
   				{
   					"data": "mode"
   				},
   				{
   					"data": "assign_to"
   				},
   				{
   					"data": "status"
   				},
   				{
   					"data": "franchise"
   				},


   			],


   		});
   	});
   </script>
   <script>
   	$(document).ready(function() {
   		$('#end_datatable').DataTable({
   			"processing": true,
   			"serverSide": true,
   			"ajax": {
   				"url": "<?php echo base_url('sales/ajax_end_subscription_list') ?>",
   				"type": "POST",
   				error: function() {

   					$(".end_datatable-error").html("");
   					$("#end_datatable").append('<tbody class="posts-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
   					$("#end_datatable_processing").css("display", "none");

   				}
   			},
   			"columns": [{
   					"data": "subscribe_id"
   				},
   				{
   					"data": "subscribe_generate_id"
   				},
   				{
   					"data": "customer"
   				},
   				{
   					"data": "product_name"
   				},
   				{
   					"data": "date"
   				},
   				{
   					"data": "mode"
   				},
   				{
   					"data": "assign_to"
   				},
   				{
   					"data": "status"
   				},
   				{
   					"data": "franchise"
   				},


   			],


   		});
   	});
   </script>
   <script>
   	$(document).ready(function() {
   		$('#expire_datatable').DataTable({
   			"processing": true,
   			"serverSide": true,
   			"ajax": {
   				"url": "<?php echo base_url('sales/ajax_expire_subscription_list') ?>",
   				"type": "POST",
   				error: function() {

   					$(".expire_datatable-error").html("");
   					$("#expire_datatable").append('<tbody class="posts-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
   					$("#expire_datatable_processing").css("display", "none");

   				}
   			},
   			"columns": [{
   					"data": "subscribe_id"
   				},
   				{
   					"data": "subscribe_generate_id"
   				},
   				{
   					"data": "customer"
   				},
   				{
   					"data": "date"
   				},
   				{
   					"data": "mode"
   				},
   				{
   					"data": "assign_to"
   				},
   				{
   					"data": "franchise"
   				},
   				{
   					"data": "action"
   				},


   			],

   			"columnDefs": [{
   				"targets": [-1], //last column
   				"orderable": false, //set not orderable
   			}, ],

   		});
   	});
   </script>


   <script>
   	$(document).ready(function() {
   		$('#total_payment_datatable').DataTable({
   			"processing": true,
   			"serverSide": true,
   			"ajax": {
   				"url": "<?php echo base_url('sales/ajax_total_payment_list') ?>",
   				"type": "POST",
   				error: function() {

   					$(".total_payment_datatable-error").html("");
   					$("#total_payment_datatable").append('<tbody class="posts-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
   					$("#total_payment_datatable_processing").css("display", "none");

   				}
   			},
   			"columns": [{
   					"data": "order_id"
   				},
   				{
   					"data": "order_generate_id"
   				},
   				{
   					"data": "count_product"
   				},
   				{
   					"data": "customer_id"
   				},
   				{
   					"data": "order_total"
   				},
   				{
   					"data": "p_mode"
   				},
   				{
   					"data": "franchise"
   				},
   				{
   					"data": "action"
   				},


   			],

   			"columnDefs": [{
   				"targets": [-1], //last column
   				"orderable": false, //set not orderable
   			}, ],

   		});
   	});
   </script>

   <script>
   	$(document).ready(function() {
   		$('#cash_payment_datatable').DataTable({
   			"processing": true,
   			"serverSide": true,
   			"ajax": {
   				"url": "<?php echo base_url('sales/ajax_cash_payment_list') ?>",
   				"type": "POST",
   				error: function() {

   					$(".cash_payment_datatable-error").html("");
   					$("#cash_payment_datatable").append('<tbody class="posts-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
   					$("#cash_payment_datatable_processing").css("display", "none");

   				}
   			},
   			"columns": [{
   					"data": "order_id"
   				},
   				{
   					"data": "order_generate_id"
   				},
   				{
   					"data": "count_product"
   				},
   				{
   					"data": "customer_id"
   				},
   				{
   					"data": "order_total"
   				},
   				{
   					"data": "p_mode"
   				},
   				{
   					"data": "franchise"
   				},
   				{
   					"data": "action"
   				},


   			],

   			"columnDefs": [{
   				"targets": [-1], //last column
   				"orderable": false, //set not orderable
   			}, ],

   		});
   	});
   </script>

   <script>
   	$(document).ready(function() {
   		$('#online_payment_datatable').DataTable({
   			"processing": true,
   			"serverSide": true,
   			"ajax": {
   				"url": "<?php echo base_url('sales/ajax_online_payment_list') ?>",
   				"type": "POST",
   				error: function() {

   					$(".online_payment_datatable-error").html("");
   					$("#online_payment_datatable").append('<tbody class="posts-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
   					$("#online_payment_datatable_processing").css("display", "none");

   				}
   			},
   			"columns": [{
   					"data": "order_id"
   				},
   				{
   					"data": "order_generate_id"
   				},
   				{
   					"data": "count_product"
   				},
   				{
   					"data": "customer_id"
   				},
   				{
   					"data": "order_total"
   				},
   				{
   					"data": "p_mode"
   				},
   				{
   					"data": "franchise"
   				},
   				{
   					"data": "action"
   				},


   			],

   			"columnDefs": [{
   				"targets": [-1], //last column
   				"orderable": false, //set not orderable
   			}, ],

   		});
   	});
   </script>

   <script>
   	$(document).ready(function() {
   		$('#refund_payment_datatable').DataTable({
   			"processing": true,
   			"serverSide": true,
   			"ajax": {
   				"url": "<?php echo base_url('sales/ajax_refund_payment_list') ?>",
   				"type": "POST",
   				error: function() {

   					$(".refund_payment_datatable-error").html("");
   					$("#refund_payment_datatable").append('<tbody class="posts-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
   					$("#refund_payment_datatable_processing").css("display", "none");

   				}
   			},
   			"columns": [{
   					"data": "order_id"
   				},
   				{
   					"data": "order_generate_id"
   				},
   				{
   					"data": "count_product"
   				},
   				{
   					"data": "customer_id"
   				},
   				{
   					"data": "order_total"
   				},
   				{
   					"data": "p_mode"
   				},
   				{
   					"data": "franchise"
   				},
   				{
   					"data": "action"
   				},


   			],

   			"columnDefs": [{
   				"targets": [-1], //last column
   				"orderable": false, //set not orderable
   			}, ],

   		});
   	});
   </script>

   <script type="text/javascript">
   	function getDateTime() {
   		var now = new Date();
   		var year = now.getFullYear();
   		var month = now.getMonth() + 1;
   		var day = now.getDate();
   		var hour = now.getHours();
   		var minute = now.getMinutes();
   		var second = now.getSeconds();
   		if (month.toString().length == 1) {
   			month = '0' + month;
   		}
   		if (day.toString().length == 1) {
   			day = '0' + day;
   		}
   		if (hour.toString().length == 1) {
   			hour = '0' + hour;
   		}
   		if (minute.toString().length == 1) {
   			minute = '0' + minute;
   		}
   		if (second.toString().length == 1) {
   			second = '0' + second;
   		}
   		var dateTime = day + '/' + month + '/' + year + ' ' + hour + ':' + minute + ':' + second;
   		return dateTime;
   	}

   	// example usage: realtime clock
   	setInterval(function() {
   		currentTime = getDateTime();
   		document.getElementById("digital-clock").innerHTML = currentTime;
   	}, 1000);
   </script>
   <script>
   	$(document).ready(function() {
   		$('#assign_sale_datatable').DataTable({
   			"processing": true,
   			"serverSide": true,
   			"ajax": {
   				"url": "<?php echo base_url('sales/ajax_assign_order_list') ?>",
   				"type": "POST",
   				error: function() {

   					$(".assign_sale_datatable-error").html("");
   					$("#assign_sale_datatable").append('<tbody class="posts-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
   					$("#assign_sale_datatable_processing").css("display", "none");

   				}
   			},
   			"columns": [{
   					"data": "order_id"
   				},
   				{
   					"data": "order_generate_id"
   				},
   				{
   					"data": "count_product"
   				},
   				{
   					"data": "customer_id"
   				},
   				{
   					"data": "order_total"
   				},
   				{
   					"data": "status"
   				},
   				{
   					"data": "payment_status"
   				},
   				{
   					"data": "assign_to"
   				},
   				{
   					"data": "order_date"
   				},
   				{
   					"data": "franchise"
   				},
   				{
   					"data": "action"
   				},


   			],

   			"columnDefs": [{
   				"targets": [-1], //last column
   				"orderable": false, //set not orderable
   			}, ],

   		});
   	});
   </script>
   <script>
   	$(document).ready(function() {
   		$('#assign_sale_not_datatable').DataTable({
   			"processing": true,
   			"serverSide": true,
   			"ajax": {
   				"url": "<?php echo base_url('sales/ajax_assign_not_deliver_list') ?>",
   				"type": "POST",
   				error: function() {

   					$(".assign_sale_not_datatable-error").html("");
   					$("#assign_sale_not_datatable").append('<tbody class="posts-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
   					$("#assign_sale_not_datatable_processing").css("display", "none");

   				}
   			},
   			"columns": [{
   					"data": "order_id"
   				},
   				{
   					"data": "order_generate_id"
   				},
   				{
   					"data": "count_product"
   				},
   				{
   					"data": "customer_id"
   				},
   				{
   					"data": "order_total"
   				},
   				{
   					"data": "status"
   				},
   				{
   					"data": "payment_status"
   				},
   				{
   					"data": "assign_to"
   				},
   				{
   					"data": "order_date"
   				},
   				{
   					"data": "franchise"
   				},
   				{
   					"data": "action"
   				},


   			],

   			"columnDefs": [{
   				"targets": [-1], //last column
   				"orderable": false, //set not orderable
   			}, ],

   		});
   	});
   </script>


   <script>
   	$(document).ready(function() {
   		$('#itemwise_datatable').DataTable({
   			"processing": true,
   			"serverSide": true,
   			"ajax": {
   				"url": "<?php echo base_url('sales/ajax_item_wise_list') ?>",
   				"type": "POST",
   				error: function() {

   					$(".itemwise_datatable-error").html("");
   					$("#itemwise_datatable").append('<tbody class="posts-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
   					$("#itemwise_datatable_processing").css("display", "none");

   				}
   			},
   			"columns": [{
   					"data": "order_id"
   				},
   				{
   					"data": "customer_id"
   				},
   				{
   					"data": "product_name"
   				},
   				{
   					"data": "unit"
   				},
   				{
   					"data": "qty"
   				},
   				{
   					"data": "payment_status"
   				},
   				{
   					"data": "status"
   				},
   				{
   					"data": "order_date"
   				},
   				{
   					"data": "franchise"
   				},


   			],

   			"columnDefs": [{
   				"targets": [-1], //last column
   				"orderable": false, //set not orderable
   			}, ],

   		});
   	});
   </script>


   <script>
   	$(document).ready(function() {
   		$('#return_datatable').DataTable({
   			"processing": true,
   			"serverSide": true,
   			"ajax": {
   				"url": "<?php echo base_url('sales/ajax_return_list') ?>",
   				"type": "POST",
   				error: function() {

   					$(".return_datatable-error").html("");
   					$("#return_datatable").append('<tbody class="posts-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
   					$("#return_datatable_processing").css("display", "none");

   				}
   			},
   			"columns": [{
   					"data": "order_id"
   				},
   				{
   					"data": "order_generate_id"
   				},
   				{
   					"data": "customer_id"
   				},
   				{
   					"data": "product_name"
   				},
   				{
   					"data": "unit"
   				},
   				{
   					"data": "qty"
   				},
   				{
   					"data": "status"
   				},
   				{
   					"data": "order_date"
   				},
   				{
   					"data": "db_name"
   				},
   				{
   					"data": "zone"
   				},
   				{
   					"data": "franchise"
   				},


   			],

   			"columnDefs": [{
   				"targets": [-1], //last column
   				"orderable": false, //set not orderable
   			}, ],

   		});
   	});
   </script>


   <script>
   	$(document).ready(function() {
   		$('#total_purchse_datatable').DataTable({
   			"processing": true,
   			"serverSide": true,
   			"ajax": {
   				"url": "<?php echo base_url('purchse/ajax_total_purchse_list') ?>",
   				"type": "POST",
   				error: function() {

   					$(".total_purchse_datatable-error").html("");
   					$("#total_purchse_datatable").append('<tbody class="posts-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
   					$("#total_purchse_datatable_processing").css("display", "none");

   				}
   			},
   			"columns": [{
   					"data": "p_id"
   				},
   				{
   					"data": "count_product"
   				},
   				{
   					"data": "supplier_id"
   				},
   				{
   					"data": "total_amount"
   				},
   				{
   					"data": "total_discount"
   				},
   				{
   					"data": "grand_total_amount"
   				},
   				{
   					"data": "purchse_date"
   				},
   				{
   					"data": "franchise"
   				},
   				{
   					"data": "action"
   				},


   			],

   			"columnDefs": [{
   				"targets": [-1], //last column
   				"orderable": false, //set not orderable
   			}, ],

   		});
   	});
   </script>

   <script>
   	$(document).ready(function() {
   		$('#out_of_stock_datetable').DataTable({
   			"processing": true,
   			"serverSide": true,
   			"ajax": {
   				"url": "<?php echo base_url('product/ajax_out_of_stock_list') ?>",
   				"type": "POST",
   				error: function() {

   					$(".out_of_stock_datetable-error").html("");
   					$("#out_of_stock_datetable").append('<tbody class="posts-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
   					$("#out_of_stock_datetable_processing").css("display", "none");

   				}
   			},
   			"columns": [{
   					"data": "product_id"
   				},
   				{
   					"data": "main_image"
   				},
   				{
   					"data": "product_name"
   				},
   				{
   					"data": "category"
   				},
   				{
   					"data": "brand"
   				},
   				{
   					"data": "qty"
   				},



   			],

   			"columnDefs": [{
   				"targets": [-1], //last column
   				"orderable": false, //set not orderable
   			}, ],

   		});
   	});
   </script>

   <script>
   	$(document).ready(function() {
   		$('#incustomer_datatable').DataTable({
   			"processing": true,
   			"serverSide": true,
   			"ajax": {
   				"url": "<?php echo base_url('customer/ajax_inactive_customer_list') ?>",
   				"type": "POST",
   				error: function() {

   					$(".incustomer_datatable-error").html("");
   					$("#incustomer_datatable").append('<tbody class="posts-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
   					$("#incustomer_datatable_processing").css("display", "none");

   				}
   			},
   			"columns": [{
   					"data": "customer_id"
   				},
   				{
   					"data": "first_name"
   				},
   				{
   					"data": "mobile_no"
   				},
   				{
   					"data": "city"
   				},
   				{
   					"data": "pincode"
   				},
   				{
   					"data": "wallet"
   				},
   				{
   					"data": "date"
   				},
   				{
   					"data": "flag"
   				},

   			]

   		});
   	});
   </script>
   </body>

   </html>