<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Coupon</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Setting</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Coupon Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Coupon Data Tables</li>
         </ol>
	   </div>
	   <div class="col-sm-3">
       <div class="float-sm-right">
        <?php $login_type   = $this->session->userdata('type');  if($login_type !='0') { ?>   
         <button type="button" class="btn btn-primary waves-effect waves-light m-1" data-toggle="modal" data-target="#defaultsizemodal">Add Coupon</button>
        <?php } ?> 
      </div>
     </div>
     </div>
    <!-- End Breadcrumb-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Coupon List</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="brand-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Type</th>
                        <th>Coupon name</th>
						<th>Validity</th>
						<th>Value</th>
						<th>Capping value</th>
						<th>Status</th>
						<th>Franchise</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
					<?php
						   if ($all_coupon != '')
							{
							$i = 1;
							foreach($all_coupon as $coupon)
							{
					?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td>
						    <?php 
						      if($coupon->flag == '0')
                                {
                                    echo '<span class="badge badge-info shadow-info m-1">Order</span>';
                                    
                                }elseif($coupon->flag == '1')
                                {
                                  echo '<span class="badge badge-primary shadow-primary m-1">Subscription</span>';
                                  
                                }
						    ?>
						</td>
                        <td><?php echo $coupon->coupon_name;?></td>
						<td><?php echo date("d-m-Y", strtotime($coupon->from_validity)).' To'.date("d-m-Y", strtotime($coupon->validity)); ?></td>
						<td><?php echo $coupon->value; ?></td>
						<td><?php echo $coupon->capping_value; ?></td>
						<td>
						    <?php 
						      if($coupon->isActive == '0')
                                {
                                    echo '<span class="badge badge-success shadow-success m-1">Enable</span>';
                                    
                                }elseif($coupon->isActive == '1')
                                {
                                  echo '<span class="badge badge-danger shadow-danger m-1">Disable</span>';
                                  
                                }
						    ?>
						</td>
							<td>
						    <?php echo $coupon->franchise_name; ?>
						</td>
						<td>
						     <div class="btn-group m-1" role="group">
                              <button type="button" class="btn btn-dark   waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                              </button>
                              <div class="dropdown-menu">
                                <a  class="dropdown-item" data-toggle="modal" data-toggle="modal" data-target="#defaultsizemodal<?php echo  $coupon->coupon_id; ?>"><i aria-hidden="true" class="fa fa-edit"></i> Edit</a>
                                 <?php if($coupon->isActive == '0'){ ?>
                                 <a style="cursor:pointer;"  class="dropdown-item tip-top delete delete one_<?php echo  $coupon->coupon_id; ?>" data-original-title="Delete" id="<?php echo $coupon->coupon_id; ?>"
						         Onclick="return ConfirmDisable(<?php echo $coupon->coupon_id ?>);"><i aria-hidden="true" class="fa fa-ban"></i> Disable</a> 
						         <?php }else { ?>
						         <a style="cursor:pointer;"  class="dropdown-item tip-top delete delete one_<?php echo  $coupon->coupon_id; ?>" data-original-title="Delete" id="<?php echo $coupon->coupon_id; ?>"
						         Onclick="return ConfirmEnable(<?php echo $coupon->coupon_id ?>);"><i aria-hidden="true" class="fa fa-key"></i> Enable</a> 
						         <?php } ?>
                                 <a style="cursor:pointer;"  class="dropdown-item tip-top delete delete one_<?php echo  $coupon->coupon_id; ?>" data-original-title="Delete" id="<?php echo $coupon->coupon_id; ?>"
						         Onclick="return ConfirmDelete(<?php echo $coupon->coupon_id ?>);"><i aria-hidden="true" class="fa fa-trash"></i> Delete</a> 
                              </div>
                             </div>
                             
						</td>
                    </tr>
					  <!-- Modal -->
						<div class="modal fade" id="defaultsizemodal<?php echo  $coupon->coupon_id; ?>">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title"><i class="fa fa-star"></i> Update Coupon</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							   <form id="update_coupon<?php echo  $coupon->coupon_id; ?>" method="post" action="<?php echo base_url();?>product/update_coupon_data">
								  <div class="modal-body">
								    <div class="form-group">
                    					  <label for="input-1">Coupon Type</label><br>
                    						<select class="form-control single-select" name="flag">
                                    			<option value="<?php echo $coupon->flag;?>">Select Type</option>
                                    			<option value="0">Order Coupon</option>
                                    			<option value="1">Subscription Coupon</option>
                                    					    
                                    		 </select>
                    					  <div class="form_error_msg flagError"></div>
                    					 </div>  
									<div class="form-group">
									  <label for="input-1">Coupon Name</label>
										<input type="text" class="form-control" name="coupon_name" value="<?php echo $coupon->coupon_name;?>" id="input-1" placeholder="Enter coupon name">
									  <div class="form_error_msg coupon_nameError"></div>
									 </div>
									  <div class="form-group">
                    					  <label for="input-1">Validity From</label>
                    						 <input type="date" class="form-control" name="from_validity" value="<?php echo $coupon->from_validity;?>"    placeholder="Enter date">
                    					  <div class="form_error_msg from_validityError"></div>
                    					 </div>
									 <div class="form-group">
									  <label for="input-1">Validity To</label>
										 <input type="date" class="form-control" name="validity" value="<?php echo $coupon->validity;?>" placeholder="Enter date">
									  <div class="form_error_msg validityError"></div>
									 </div>
									 <div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Value</label>
									      <input type="text" class="form-control" name="value" value="<?php echo $coupon->value;?>" id="input-1" placeholder="Enter value">
										<div class="form_error_msg valueError"></div>
									 </div>
									 <div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Capping value</label>
									      <input type="text" class="form-control" name="capping_value" value="<?php echo $coupon->capping_value;?>" id="input-1" placeholder="Enter capping value">
										<div class="form_error_msg capping_valueError"></div>
									 </div>
									 <div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Description</label>
									      <input type="text" class="form-control" name="description" value="<?php echo $coupon->description;?>" id="input-1" placeholder="Enter Description">
										<div class="form_error_msg descriptionError"></div>
									 </div>
									  
									 
								  </div>
								  <input type="hidden" value="<?php echo $coupon->coupon_id;?>" name="coupon_id">
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
							$('#update_coupon<?php echo  $coupon->coupon_id; ?>').ajaxForm({
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
						
						$('#autoclose-datepicker<?php echo  $coupon->coupon_id; ?>').datepicker({
                                autoclose: true,
                                todayHighlight: true
                              });
                        		$('#autoclose-datepicker0<?php echo  $coupon->coupon_id; ?>').datepicker({
                                autoclose: true,
                                todayHighlight: true
                              });      

					</script>
					<?php } }else { echo '';} ?>
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
		<h5 class="modal-title"><i class="fa fa-star"></i> Add Coupon</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	   <form id="add_coupon" method="post" action="<?php echo base_url();?>product/add_coupon_data">
		  <div class="modal-body">
		            <div class="form-group">
					  <label for="input-1">Coupon Type</label>
						<select class="form-control single-select" name="flag">
                			<option value="">Select Type</option>
                			<option value="0">Order Coupon</option>
                			<option value="1">Subscription Coupon</option>
                					    
                		 </select>
					  <div class="form_error_msg flagError"></div>
					 </div>
					<div class="form-group">
					  <label for="input-1">Coupon Name</label>
						<input type="text" class="form-control" name="coupon_name"  id="input-1" placeholder="Enter coupon name">
					  <div class="form_error_msg coupon_nameError"></div>
					 </div>
					 <div class="form-group">
					  <label for="input-1">Validity From</label>
						 <input type="date" class="form-control" name="from_validity" placeholder="Enter date">
					  <div class="form_error_msg from_validityError"></div>
					 </div>
					 <div class="form-group">
					  <label for="input-1">Validity To</label>
						 <input type="date" class="form-control" name="validity"  placeholder="Enter date">
					  <div class="form_error_msg validityError"></div>
					 </div>
					 <div class="form-group">
						<label class="form-label" for="exampleInputEmail1">Value</label>
					      <input type="text" class="form-control" name="value"  id="input-1" placeholder="Enter value">
						<div class="form_error_msg valueError"></div>
					 </div>
					 <div class="form-group">
						<label class="form-label" for="exampleInputEmail1">Capping value</label>
					      <input type="text" class="form-control" name="capping_value"  id="input-1" placeholder="Enter capping value">
						<div class="form_error_msg capping_valueError"></div>
					 </div>
					 <div class="form-group">
						<label class="form-label" for="exampleInputEmail1">Description</label>
					      <input type="text" class="form-control" name="description"  id="input-1" placeholder="Enter Description">
						<div class="form_error_msg descriptionError"></div>
					 </div>
			  
			 
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
			<button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i>Add</button>
		  </div>
		  <div class="success_message"></div>
		</form>  
	</div>
  </div>
</div>

<script type="text/javascript">
	$(function(){
		$('#add_coupon').ajaxForm({
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
<script type="text/javascript">
function ConfirmDelete(id)
{
if(confirm("Are you sure you want to delete this Record?"))
{
	$(".message").html("");
	
	$.ajax({
	   type: "POST",
	   url: "<?php echo base_url();?>product/delete_coupon",
	   data: {'delete_id':id},
		   success : function(id) {
		   var idd = "a.one_"+id+":parent";
		   $(idd).parents('tr').hide();
		  
		}
	});

}
return false;
}

</script>
<script type="text/javascript">
function ConfirmDisable(id)
{
if(confirm("Are you sure you want to disable this coupon?"))
{
	$(".message").html("");
	
	$.ajax({
	   type: "POST",
	   url: "<?php echo base_url();?>product/disable_coupon",
	   data: {'delete_id':id},
		   success : function(id) 
		   {
		   window.location = "<?php echo base_url();?>product/coupon";

		  
		}
	});

}
return false;
}

</script>
<script type="text/javascript">
function ConfirmEnable(id)
{
if(confirm("Are you sure you want to enable this coupon?"))
{
	$(".message").html("");
	
	$.ajax({
	   type: "POST",
	   url: "<?php echo base_url();?>product/enable_coupon",
	   data: {'delete_id':id},
		   success : function(id) 
		   {
		   window.location = "<?php echo base_url();?>product/coupon";

		  
		}
	});

}
return false;
}

</script>