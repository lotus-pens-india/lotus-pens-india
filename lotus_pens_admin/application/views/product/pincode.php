<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">pincode</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Product</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">pincode Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">pincode Data Tables</li>
         </ol>
	   </div>
	   <div class="col-sm-3">
       <div class="float-sm-right">
         <?php $login_type   = $this->session->userdata('type');  if($login_type !='0') { ?>  
          <button type="button" class="btn btn-primary waves-effect waves-light m-1" data-toggle="modal" data-target="#defaultsizemodal">Add pincode</button>
         <?php } ?>
      </div>
     </div>
     </div>
    <!-- End Breadcrumb-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Pincode List</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="brand-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>pincode</th>
                        <th>City</th>
                        <th>Location</th>
                        <th>Delivery Charges</th>
                        <th>No.of register</th>
                        <th>Franchise</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
					 <?php
						   if ($all_pincode != '')
							{
							$i = 1;
							foreach($all_pincode as $pincode)
							{
					?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><a href="<?php echo base_url();?>report/pincode_wise_report?pincode=<?php echo $pincode->pincode ?>" target="_blank"><?php echo $pincode->pincode ?></a></td>
                        <td><?php echo $pincode->city ?></td>
                        <td><?php echo $pincode->location ?></td>
                        <td><?php echo $pincode->delivery_charges ?></td>
                        <td>
                            <?php 
                                $CI =& get_instance();
                                $CI->load->model('Product_model');
                                $result = $CI->product_model->count_pincode_wise_customer($pincode->pincode);
                                
                                echo $result->count;
                            ?>
                        </td>
                    	<td>
						    <?php echo $pincode->franchise_name; ?>
						</td>
						<td>
						 <button type="button" class="btn btn-secondary waves-effect waves-light m-1" data-toggle="modal" data-target="#defaultsizemodal<?php echo $pincode->pincode_id ?>"> <i class="fa fa-edit"></i> </button>
						 <a style="cursor:pointer;"  class="tip-top delete delete one_<?php echo  $pincode->pincode_id; ?>" data-original-title="Delete" id="<?php echo $pincode->pincode_id; ?>"
						      Onclick="return ConfirmDelete(<?php echo $pincode->pincode_id ?>);">
						     <button type="button" class="btn btn-danger waves-effect waves-light m-1"> <i class="fa fa-trash-o"></i> </button>
						  </a> 
						</td>
                    </tr>
					<div class="modal fade" id="defaultsizemodal<?php echo $pincode->pincode_id ?>">
					  <div class="modal-dialog">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title"><i class="fa fa-star"></i> Update pincode</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						   <form id="update_pincode<?php echo $pincode->pincode_id ?>" method="post" action="<?php echo base_url();?>product/update_pincode_data">
							  <div class="modal-body">
								<div class="form-group">
								  <label for="input-1">City</label>
									<input type="text" class="form-control" name="city" value="<?php echo $pincode->city ?>" id="input-1" placeholder="Enter city">
								  <div class="form_error_msg cityError"></div>
								 </div>
								  <div class="form-group">
								 <label for="input-1">Location</label>
									<input type="text" class="form-control" name="location_area" value="<?php echo $pincode->location ?>" id="input-1" placeholder="Enter location">
								  <div class="form_error_msg location_areaError"></div>
								 </div>
								 <div class="form-group">
								  <label for="input-1">Pincode</label>
									<input type="number" class="form-control" name="pincode" value="<?php echo $pincode->pincode ?>" id="input-1" placeholder="Enter pincode">
								  <div class="form_error_msg pincodeError"></div>
								 </div>
								 <div class="form-group">
								  <label for="input-1">Delivery charge</label>
									<input type="number" class="form-control" name="delivery_charges" value="<?php echo $pincode->delivery_charges ?>" id="input-1" placeholder="Enter delivery charges">
								  <div class="form_error_msg delivery_chargesError"></div>
								 </div>
								
								 
								 
							  </div>
							  <input type="hidden" value="<?php echo $pincode->pincode_id;?>" name="pincode_id">
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
							$('#update_pincode<?php echo $pincode->pincode_id ?>').ajaxForm({
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
		<h5 class="modal-title"><i class="fa fa-star"></i> Add Pincode</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	   <form id="add_pincode" method="post" action="<?php echo base_url();?>product/add_pincode_data">
		  <div class="modal-body">
  			<div class="form-group">
			  <label for="input-1">City</label>
				<input type="text" class="form-control" name="city"  id="input-1" placeholder="Enter city">
			  <div class="form_error_msg cityError"></div>
			 </div>
			  <div class="form-group">
			 <label for="input-1">Location</label>
				<input type="text" class="form-control" name="location_area"  id="input-1" placeholder="Enter location">
			  <div class="form_error_msg location_areaError"></div>
			 </div>    
			<div class="form-group">
			  <label for="input-1">Pincode</label>
				<input type="number" class="form-control" name="pincode" id="input-1" placeholder="Enter Pincode">
			  <div class="form_error_msg pincodeError"></div>
			 </div>
			 <div class="form-group">
				  <label for="input-1">Delivery charge</label>
					<input type="number" class="form-control" name="delivery_charges" value="0" id="input-1" placeholder="Enter delivery charges">
				  <div class="form_error_msg delivery_chargesError"></div>
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
		$('#add_pincode').ajaxForm({
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
	   url: "<?php echo base_url();?>product/delete_pincode",
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