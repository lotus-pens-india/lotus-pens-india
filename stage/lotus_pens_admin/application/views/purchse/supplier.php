<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Supplier</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Purchse</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Supplier Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Supplier Data Tables</li>
         </ol>
	   </div>
	   <div class="col-sm-3">
       <div class="float-sm-right">
        
         <button type="button" class="btn btn-primary waves-effect waves-light m-1" data-toggle="modal" data-target="#defaultsizemodal">Add supplier</button>
    
      </div>
     </div>
     </div>
    <!-- End Breadcrumb-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Supplier List</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="brand-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Supplier</th>
                        <th>Mobile no</th>
                        <th>Email </th>
                        <th>Address</th>
                        <th>Saller</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
				<?php
					   if ($all_supplier != '')
						{
						$i = 1;
						foreach($all_supplier as $supplier)
						{
				?>   
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $supplier->company_name; ?></td>
                        <td><?php echo $supplier->mobile_no; ?></td>
                        <td><?php echo $supplier->email_id; ?></td>
                        <td><?php echo $supplier->address; ?></td>
						<td>
						    <?php echo $supplier->franchise_name; ?>
						</td>
                        <td>
                            
                            <div class="btn-group m-1" role="group">
                              <button type="button" class="btn btn-dark   waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                              </button>
                              <div class="dropdown-menu">
                                <a  class="dropdown-item" data-toggle="modal" data-target="#defaultsizemodal<?php echo $supplier->supplier_id ?>"><i aria-hidden="true" class="fa fa-edit"></i>Edit</a>
                                
                                 <a style="cursor:pointer;"  class="dropdown-item tip-top delete delete one_<?php echo  $supplier->supplier_id; ?>" data-original-title="Delete" id="<?php echo $supplier->supplier_id; ?>"
						         Onclick="return ConfirmDelete(<?php echo $supplier->supplier_id ?>);"><i aria-hidden="true" class="fa fa-trash"></i> Delete</a> 
                              </div>
                             </div>
                             
						   
						</td>
                    </tr>
					  <!-- Modal -->
						<div class="modal fade" id="defaultsizemodal<?php echo $supplier->supplier_id ?>">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title"><i class="fa fa-star"></i> Update supplier</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							   <form id="update_supplier<?php echo $supplier->supplier_id ?>" method="post" action="<?php echo base_url();?>purchse/update_supplier_data" enctype="multipart/form-data">
								  <div class="modal-body">
												<div class="form-group">
                                    			  <label for="input-1">Supplier Name</label>
                                    				<input type="text" class="form-control" name="company_name" id="input-1" placeholder="Enter supplier Name" value="<?php echo $supplier->company_name  ?>">
                                    			  <div class="form_error_msg company_nameError"></div>
                                    			 </div>
                                    			 <div class="form-group">
                                    			  <label for="input-1">Mobile no</label>
                                    				<input type="text" class="form-control" name="mobile_no" id="input-1" placeholder="Enter mobile" value="<?php echo $supplier->mobile_no  ?>">
                                    			  <div class="form_error_msg mobile_noError"></div>
                                    			 </div>
                                    			 <div class="form-group">
                                    			  <label for="input-1">Email id</label>
                                    				<input type="text" class="form-control" name="email_id" id="input-1" placeholder="Enter email" value="<?php echo $supplier->email_id  ?>">
                                    			 </div>
                                    			 <div class="form-group">
                                    			  <label for="input-1">Address</label>
                                    				<textarea type="text" class="form-control" name="address" id="input-1" placeholder="Enter address Name"><?php echo $supplier->address  ?></textarea>
                                    			  <div class="form_error_msg addressError"></div>
                                    			 </div>
									 
									 
								  </div>
								  <input type="hidden" value="<?php echo $supplier->supplier_id;?>" name="supplier_id">
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
							$('#update_supplier<?php echo $supplier->supplier_id ?>').ajaxForm({
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
		<h5 class="modal-title"><i class="fa fa-star"></i> Add supplier</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	   <form id="add_supplier" method="post" action="<?php echo base_url();?>purchse/add_supplier_data" enctype="multipart/form-data">
		  <div class="modal-body">
			<div class="form-group">
			  <label for="input-1">Supplier Name</label>
				<input type="text" class="form-control" name="company_name" id="input-1" placeholder="Enter supplier Name">
			  <div class="form_error_msg company_nameError"></div>
			 </div>
			 <div class="form-group">
			  <label for="input-1">Mobile no</label>
				<input type="text" class="form-control" name="mobile_no" id="input-1" placeholder="Enter mobile">
			  <div class="form_error_msg mobile_noError"></div>
			 </div>
			 <div class="form-group">
			  <label for="input-1">Email id</label>
				<input type="text" class="form-control" name="email_id" id="input-1" placeholder="Enter email">
			 </div>
			 <div class="form-group">
			  <label for="input-1">Address</label>
				<textarea type="text" class="form-control" name="address" id="input-1" placeholder="Enter address Name"></textarea>
			  <div class="form_error_msg addressError"></div>
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
		$('#add_supplier').ajaxForm({
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
	   url: "<?php echo base_url();?>purchse/delete_supplier",
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


