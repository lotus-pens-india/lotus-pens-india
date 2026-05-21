

<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Credit in wallet</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">customer</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Credit in wallet</a></li>
         </ol>
	   </div>
	   <div class="col-sm-3">
       <div class="float-sm-right">
      </div>
     </div>
     </div>
    <!-- End Breadcrumb-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-upload"></i> Credit in Wallet</div>
            <div class="card-body">
			  <form id="add_banner" method="post" action="<?php echo base_url();?>customer/credit_amount_in_wallet">
         
					 
                        <div class="form-group row">
						  <div class="col-md-4">
                            <label>Select Customer *</label>
                            <select class="form-control single-select"  name="customer_id" id="customer_id">
							  <option value="">Select Customer</option>
							  <?php foreach($all_customer as $customer) { ?>
								   <option value="<?php echo $customer->customer_id ?>"><?php echo $customer->first_name.' '.$customer->last_name.' / '.$customer->mobile_no ?></option>
							  <?php } ?>
							  </select>
							<div class="form_error_msg customer_idError"></div>
						  </div>
                          
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
							  <label>Credit amount *</label>
							    <input class="form-control"  name="credit_amount" type="number" placeholder="credit amount">
						     	<div class="form_error_msg credit_amountError"></div>
							</div>
							
                        </div>

                    </section>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Add</button>
       
				<div class="success_message"></div>
				</form>
            </div>
          </div>
        </div>
      </div><!-- End Row-->


    </div>
    <!-- End container-fluid-->
<script type="text/javascript">
	$(function(){
		$('#add_banner').ajaxForm({
			beforeSend : function(){
				$('.form_error_msg').html('');
				$('.success_message').html('<div class="alert alert-outline-warning alert-dismissible alert-round" role="alert"><button type="button" class="close" data-dismiss="alert">×</button><div class="alert-icon"> <i class="icon-exclamation"></i> </div><div class="alert-message"><span><strong>Data add!</strong> please wait.. <a href="javascript:void();" class="alert-link"></a></span></div></div>');
			},
			complete : function (response) {
				var temp = JSON.parse(response.responseText);
				if(temp.status == 'success'){
					$('.success_message').show().html(temp.message);
					window.location.href = temp.redirect;
				}else if(temp.status == 'error'){
					$('.success_message').html('');
					$.each(temp.errors, function (key, val) {
						$('.'+key).html(val);
					})
				}
			}
		});
	});

</script>

