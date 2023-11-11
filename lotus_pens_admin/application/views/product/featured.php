<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Featured</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Product</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Featured Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Featured Data Tables</li>
         </ol>
	   </div>
	   <div class="col-sm-3">
       <div class="float-sm-right">
           <?php $login_type   = $this->session->userdata('type');  if($login_type !='0') { ?>
            <button type="button" class="btn btn-primary waves-effect waves-light m-1" data-toggle="modal" data-target="#defaultsizemodal">Add Featured</button>
           <?php } ?>
      </div>
     </div>
     </div>
    <!-- End Breadcrumb-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Featured List</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="brand-datatable" class="table table-bordered">
                <thead>
                    <tr>
                         <th>Image</th>
                        <th>Product Id</th>
						<th>Position</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
				<?php
					   if ($all_featured != '')
						{
						$i = 1;
						foreach($all_featured as $banner)
						{
				?>   
                    <tr>
                        <td>
						<?php if($banner->image == '') { ?>
						    <a href="https://via.placeholder.com/1500x1000" data-fancybox="images" data-caption="This image has a caption">
							  <img src="https://via.placeholder.com/240x160" alt="lightbox" class="lightbox-thumb img-thumbnail">
							</a>
						<?php } else { ?>
						    <a href="<?php echo base_url('assets/images/featured/'.$banner->image);?>" data-fancybox="images" data-caption="This image has a caption">
							  <img src="<?php echo base_url('assets/images/featured/'.$banner->image);?>" alt="lightbox" class="lightbox-thumb img-thumbnail" style="width: 150px;height:200px">
							</a>
						<?php } ?>						
						</td>
						<td>
						    <?php echo $banner->product_id; ?>
						</td>
						<td>
						    <?php echo $banner->position; ?>
						</td>
						<td>
						    <?php 
						      if($banner->status == '0')
                                {
                                    echo '<span class="badge badge-success shadow-success m-1">Enable</span>';
                                    
                                }elseif($banner->status == '1')
                                {
                                  echo '<span class="badge badge-danger shadow-danger m-1">Disable</span>';
                                  
                                }
						    ?>
						</td>
						
						
                        <td>
                            <div class="btn-group m-1" role="group">
                              <button type="button" class="btn btn-dark   waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                              </button>
                              <div class="dropdown-menu">
                                <a  class="dropdown-item" data-toggle="modal" data-target="#defaultsizemodal<?php echo $banner->id ?>"><i aria-hidden="true" class="fa fa-eye"></i> Update</a>
                                 <?php if($banner->status == '0'){ ?>
                                 <a style="cursor:pointer;"  class="dropdown-item tip-top delete delete one_<?php echo  $banner->id; ?>" data-original-title="Delete" id="<?php echo $banner->id; ?>"
						         Onclick="return ConfirmDisable(<?php echo $banner->id ?>);"><i aria-hidden="true" class="fa fa-ban"></i> Disable</a> 
						         <?php }else { ?>
						         <a style="cursor:pointer;"  class="dropdown-item tip-top delete delete one_<?php echo  $banner->id; ?>" data-original-title="Delete" id="<?php echo $banner->id; ?>"
						         Onclick="return ConfirmEnable(<?php echo $banner->id ?>);"><i aria-hidden="true" class="fa fa-key"></i> Enable</a> 
						         <?php } ?>
                                 <a style="cursor:pointer;"  class="dropdown-item tip-top delete delete one_<?php echo  $banner->id; ?>" data-original-title="Delete" id="<?php echo $banner->id; ?>"
						         Onclick="return ConfirmDelete(<?php echo $banner->id ?>);"><i aria-hidden="true" class="fa fa-trash"></i> Delete</a> 
                              </div>
                             </div>
					 
						</td>
                    </tr>
                    
                    					  <!-- Modal -->
						<div class="modal fade" id="defaultsizemodal<?php echo $banner->id ?>">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title"><i class="fa fa-star"></i>Set Banner Position</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							   <form id="update_feature<?php echo $banner->id ?>" method="post" action="<?php echo base_url();?>product/update_feature_data" enctype="multipart/form-data">
								  <div class="modal-body">
								  <!-- <div class="form-group">
									  <label for="input-1">Image</label>
										<input type="file" class="form-control" name="logo" id="input-1">
										<?php if($banner->image != '') { ?>
										  <img src="<?php echo base_url()?>assets/images/feature/<?php echo $banner->image; ?>" class="images" style="width: 100px;height: 100px;">
										<?php } else { ?>
										  <img src="https://via.placeholder.com/1500x1000" class="images" style="width: 100px;height: 100px;">
										<?php } ?>										
										 <input type="hidden"  class="form-control" name="logo_old" value="<?php echo $banner->image; ?>">
									  <div class="form_error_msg logoError"></div>
									 </div> -->

									 <div class="form-group">
									  <label for="input-1">Product ID</label>
										<input type="text" class="form-control" name="product_id" id="input-1" value="<?php echo $banner->product_id;?>" placeholder="Enter product ID">
									  <div class="form_error_msg positionError"></div>
									 </div>

									<div class="form-group">
									  <label for="input-1">Feature position</label>
										<input type="text" class="form-control" name="position" id="input-1" value="<?php echo $banner->position;?>" placeholder="Enter position">
									  <div class="form_error_msg positionError"></div>
									 </div>
									
								  </div>
								  <input type="hidden" value="<?php echo $banner->id;?>" name="id">
								  <div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
									<button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i>Change position</button>
								  </div>
								  <div class="success_message"></div>
								</form>  
							</div>
						  </div>
						</div>
						<script type="text/javascript">
						$(function(){
							$('#update_feature<?php echo $banner->id ?>').ajaxForm({
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
		<h5 class="modal-title"><i class="fa fa-star"></i> Add featured</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	   <form id="add_featured" method="post" action="<?php echo base_url();?>product/add_featured_data">
		  <div class="modal-body">
		     	
			 <div class="form-group">
			  <label for="input-1">Featured (specipication of picther size 1024 x 500)</label>
				<input type="file" class="form-control" name="banner" id="input-1" required>
			  <div class="form_error_msg bannerError"></div>
			 </div>
			 <div class="form-group">
			  <label for="input-1">product Id</label>
				<input type="text" class="form-control" name="product_id" id="input-1"  placeholder="Enter product id">
			  <div class="form_error_msg positionError"></div>
			 </div>
			 <div class="form-group">
			  <label for="input-1">featured position</label>
				<input type="text" class="form-control" name="position" id="input-1"  placeholder="Enter position">
			  <div class="form_error_msg positionError"></div>
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
		$('#add_featured').ajaxForm({
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
	   url: "<?php echo base_url();?>product/delete_feature",
	   data: {'delete_id':id},
		   success : function(id) {
			window.location = "<?php echo base_url();?>product/featured";
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
if(confirm("Are you sure you want to disable this Feature?"))
{
	$(".message").html("");
	
	$.ajax({
	   type: "POST",
	   url: "<?php echo base_url();?>product/disable_feature",
	   data: {'id':id},
		   success : function(id) 
		   {
		   window.location = "<?php echo base_url();?>product/featured";

		  
		}
	});

}
return false;
}

</script>
<script type="text/javascript">
function ConfirmEnable(id)
{
if(confirm("Are you sure you want to enable this feature?"))
{
	$(".message").html("");
	
	$.ajax({
	   type: "POST",
	   url: "<?php echo base_url();?>product/enable_feature",
	   data: {'id':id},
		   success : function(id) 
		   {
		   window.location = "<?php echo base_url();?>product/featured";

		  
		}
	});

}
return false;
}

</script>