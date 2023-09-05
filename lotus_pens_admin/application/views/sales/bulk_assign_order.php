
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Bulk Assign Order</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Sales</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Import Bulk Assign Order</a></li>
         </ol>
	   </div>
	   <div class="col-sm-3">
       <div class="float-sm-right">
        <a href="<?php echo base_url();?>sales/total_sales"> 
         <button type="button" class="btn btn-primary waves-effect waves-light m-1">Order list</button>
        </a> 
      </div>
     </div>
     </div>
    <!-- End Breadcrumb-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-upload"></i> Import Bulk Assign Order</div>
            <div class="card-body">
			  
                <div id="wizard-vertical1">
                    
                    <section>
                        <div class="form-group row">
                          <div class="col-md-12">    
                          <form  method="post" action="<?php echo base_url();?>sales/download_sales_excel">
                            <p>Your bulk assign order data file should as per this template 
                              
                               <button type="submit" class="btn btn-primary waves-effect waves-light m-1">Download template</button>
                              
                            </p>
                            </form>
                           </div>    
                        </div>  
                        <hr>
                      <form id="add_product" method="post" action="<?php echo base_url();?>sales/import_bulk_assign_order_data">
                        <div class="form-group row">
						  <div class="col-md-4">
                            <label>Select Delivery boy *</label>
                            <select class="form-control single-select"  name="assign_to" id="assign_to">
							  <option value="">Select Delivery Boy</option>
							  <?php foreach($all_delivery_boy as $delivery_boy) { ?>
								   <option value="<?php echo $delivery_boy->db_id ?>"><?php echo $delivery_boy->name ?></option>
							  <?php } ?>
							  </select>
							<div class="form_error_msg assign_toError"></div>
						  </div>
                          
                        </div>  
						<div class="form-group row">
							
				    		<div class="col-md-4">
						   <label>File (csv format only)</label>
                           <div class="uploadOuter">
						      <input type="file"   class="form-control" name="file"  required/>
							  <div class="form_error_msg fileError"></div>
							</div>
			
						   </div>
							
                        </div>

                    </section>

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

<script type="text/javascript">
	$(function(){
		$('#add_product').ajaxForm({
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
