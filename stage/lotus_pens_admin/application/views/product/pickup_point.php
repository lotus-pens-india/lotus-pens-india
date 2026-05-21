<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Pickup point</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Product</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Pickup point Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pickup point Data Tables</li>
         </ol>
	   </div>
	   <div class="col-sm-3">
       <div class="float-sm-right">

      <?php $login_type   = $this->session->userdata('type');  if($login_type !='0') { ?>
        <button type="button" class="btn btn-primary waves-effect waves-light m-1" data-toggle="modal" data-target="#defaultsizemodal">Add pickup point</button>
    <?php } ?>    
      </div>
     </div>
     </div>
    <!-- End Breadcrumb-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Pickup point List</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="brand-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Pickup point</th>
                        <th>Franchise</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
					 <?php
						   if ($all_pickup != '')
							{
							$i = 1;
							foreach($all_pickup as $pickup)
							{
					?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $pickup->pickup_address ?></td>
                        <td><?php echo $pickup->franchise_name ?></td>
						<td>
						 <button type="button" class="btn btn-secondary waves-effect waves-light m-1" data-toggle="modal" data-target="#defaultsizemodal<?php echo $pickup->pick_up_id ?>"> <i class="fa fa-edit"></i> </button>
						 <a style="cursor:pointer;"  class="tip-top delete delete one_<?php echo  $pickup->pick_up_id; ?>" data-original-title="Delete" id="<?php echo $pickup->pick_up_id; ?>"
						      Onclick="return ConfirmDelete(<?php echo $pickup->pick_up_id ?>);">
						     <button type="button" class="btn btn-danger waves-effect waves-light m-1"> <i class="fa fa-trash-o"></i> </button>
						  </a> 
						</td>
                    </tr>
					<div class="modal fade" id="defaultsizemodal<?php echo $pickup->pick_up_id ?>">
					  <div class="modal-dialog">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title"><i class="fa fa-star"></i> Update Pickup point</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						   <form id="update_pickup<?php echo $pickup->pick_up_id ?>" method="post" action="<?php echo base_url();?>product/update_pickup_point_data">
							  <div class="modal-body">
								<div class="form-group">
								  <label for="input-1">Pickup point</label>
									<textarea type="text" class="form-control" name="pickup_address"  id="input-1" placeholder="Enter pincode"><?php echo $pickup->pickup_address ?></textarea>
								  <div class="form_error_msg pickup_addressError"></div>
								 </div>
								 
							  </div>
							  <input type="hidden" value="<?php echo $pickup->pick_up_id;?>" name="pick_up_id">
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
							$('#update_pickup<?php echo $pickup->pick_up_id ?>').ajaxForm({
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
		<h5 class="modal-title"><i class="fa fa-star"></i> Add Pickup Point</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	   <form id="add_pickup" method="post" action="<?php echo base_url();?>product/add_pickup_point_data">
		  <div class="modal-body">
			<div class="form-group">
			  <label for="input-1">Pickup point</label>
				<textarea type="text" class="form-control" name="pickup_address" id="input-1" placeholder="Enter Pickup point"></textarea>
			  <div class="form_error_msg pickup_addressError"></div>
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
		$('#add_pickup').ajaxForm({
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
	   url: "<?php echo base_url();?>product/delete_pickup_point",
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