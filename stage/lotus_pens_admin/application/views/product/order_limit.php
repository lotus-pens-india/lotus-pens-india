<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title"> Order Limit</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Product</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Order Limit Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Order Limit</li>
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
            <div class="card-header"><i class="fa fa-table"></i> Order Limit</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="brand-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Order limit</th>
                        <th>Saller</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td><?php echo $order_limit->order_limit ?></td>
                         <td>
						    <?php echo $order_limit->franchise_name; ?>
						</td>

						<td>
						 <button type="button" class="btn btn-secondary waves-effect waves-light m-1" data-toggle="modal" data-target="#defaultsizemodal<?php echo $order_limit->id ?>"> <i class="fa fa-edit"></i> </button>
 
						</td>
                    </tr>
					<div class="modal fade" id="defaultsizemodal<?php echo $order_limit->id ?>">
					  <div class="modal-dialog">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title"><i class="fa fa-star"></i> Update order limit</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						   <form id="update_pincode<?php echo $order_limit->id ?>" method="post" action="<?php echo base_url();?>product/update_order_limit_data">
							  <div class="modal-body">
								<div class="form-group">
								  <label for="input-1">Order limit</label>
									<input type="text" class="form-control" name="order_limit" value="<?php echo $order_limit->order_limit ?>" id="input-1">
								  <div class="form_error_msg order_limitError"></div>
								 </div>
								 
							  </div>
							  <input type="hidden" value="<?php echo $order_limit->id;?>" name="id">
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
							$('#update_pincode<?php echo $order_limit->id ?>').ajaxForm({
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
