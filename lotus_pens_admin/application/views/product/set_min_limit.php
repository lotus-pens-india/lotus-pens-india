<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Set Minimum Order Limit</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Product</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Set Minimum Order Limit Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Set Minimum Order Limit</li>
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
            <div class="card-header"><i class="fa fa-table"></i>Set Minimum Order Limit</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="brand-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Minimum order limit</th>
                        <th>Subscription Minimum order limit</th>
                        <th>New Customer For Set Limit </th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td><?php echo $set_min_limit->min_limit ?></td>
                        <td><?php echo $set_min_limit->subscribe_min_limit ?></td>
                        <td>
						    <?php echo $set_min_limit->wallet_use_min_limit; ?>
						</td>

						<td>
						 <button type="button" class="btn btn-secondary waves-effect waves-light m-1" data-toggle="modal" data-target="#defaultsizemodal<?php echo $set_min_limit->id ?>"> <i class="fa fa-edit"></i> </button>
 
						</td>
                    </tr>
					<div class="modal fade" id="defaultsizemodal<?php echo $set_min_limit->id ?>">
					  <div class="modal-dialog">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title"><i class="fa fa-star"></i> Update Minimum order limit</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						   <form id="update_pincode<?php echo $set_min_limit->id ?>" method="post" action="<?php echo base_url();?>product/update_minimu_limit_data">
							  <div class="modal-body">
								<div class="form-group">
								  <label for="input-1">Minimum order limit</label>
									<input type="text" class="form-control" name="min_limit" value="<?php echo $set_min_limit->min_limit ?>" id="input-1">
								  <div class="form_error_msg min_limitError"></div>
								 </div>
								 <div class="form-group">
								  <label for="input-1">Subscription order limit</label>
									<input type="text" class="form-control" name="subscribe_min_limit" value="<?php echo $set_min_limit->subscribe_min_limit ?>" id="input-1">
								  <div class="form_error_msg subscribe_min_limitError"></div>
								 </div>
								 <div class="form-group">
								  <label for="input-1">New Customer For Set Limit</label>
									<input type="text" class="form-control" name="wallet_use_min_limit" value="<?php echo $set_min_limit->wallet_use_min_limit ?>" id="input-1">
								  <div class="form_error_msg wallet_use_min_limitError"></div>
								 </div>
								  
								
								 
								 
							  </div>
							  <input type="hidden" value="<?php echo $set_min_limit->id;?>" name="id">
							  <div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
								<button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i>Update</button>
							  </div>
							  <div class="success_message"></div>
							</form>  
						</div>
					  </div>
					</div>
					<script type="text/javascript">
						$(function(){
							$('#update_pincode<?php echo $set_min_limit->id ?>').ajaxForm({
								beforeSend : function(){
									$('.form_error_msg').html('');
									$('.success_message').html('<div class="alert alert-outline-warning alert-dismissible alert-round" role="alert"><button type="button" class="close" data-dismiss="alert">×</button><div class="alert-icon"> <i class="icon-exclamation"></i> </div><div class="alert-message"><span><strong>Data update!</strong> please wait.. <a href="javascript:void();" class="alert-link"></a></span></div></div>');
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
                 
                </tbody>
                
            </table>
            </div>
            </div>
          </div>
        </div>
      </div><!-- End Row-->


    </div>
    <!-- End container-fluid-->
