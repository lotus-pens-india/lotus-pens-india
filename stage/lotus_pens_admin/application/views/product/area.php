<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Area</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Master</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Area Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Area Data Tables</li>
         </ol>
	   </div>
	   <div class="col-sm-3">
       <div class="float-sm-right">
        <?php $login_type   = $this->session->userdata('type');  if($login_type !='0') { ?>   
         <button type="button" class="btn btn-primary waves-effect waves-light m-1" data-toggle="modal" data-target="#defaultsizemodal">Add Area</button>
        <?php } ?> 
      </div>
     </div>
     </div>
    <!-- End Breadcrumb-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Area List</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="brand-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Zone</th>
                        <th>Area Name</th>
                        <th>Status</th>
                        <th>Saller</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
				<?php
					   if ($all_area != '')
						{
						$i = 1;
						foreach($all_area as $area)
						{
				?>   
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $area->zone_name ?></td>
                        <td><?php echo $area->area_name ?></td>
                        
							<td>
						    <?php 
						      if($area->isActive == '0')
                                {
                                    echo '<span class="badge badge-success shadow-success m-1">Enable</span>';
                                    
                                }elseif($area->isActive == '1')
                                {
                                  echo '<span class="badge badge-danger shadow-danger m-1">Disable</span>';
                                  
                                }
						    ?>
						</td>
						
						<td>
						    <?php echo $area->franchise_name; ?>
						</td>
                        <td>
                            
                            <div class="btn-group m-1" role="group">
                              <button type="button" class="btn btn-dark   waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                              </button>
                              <div class="dropdown-menu">
                                <a  class="dropdown-item" data-toggle="modal" data-target="#defaultsizemodal<?php echo $area->area_id ?>"><i aria-hidden="true" class="fa fa-edit"></i>Edit</a>
                                 <?php if($area->isActive == '0'){ ?>
                                 <a style="cursor:pointer;"  class="dropdown-item tip-top delete delete one_<?php echo  $area->area_id; ?>" data-original-title="Delete" id="<?php echo $area->area_id; ?>"
						         Onclick="return ConfirmDisable(<?php echo $area->area_id ?>);"><i aria-hidden="true" class="fa fa-ban"></i> Disable</a> 
						         <?php }else { ?>
						         <a style="cursor:pointer;"  class="dropdown-item tip-top delete delete one_<?php echo  $area->area_id; ?>" data-original-title="Delete" id="<?php echo $area->area_id; ?>"
						         Onclick="return ConfirmEnable(<?php echo $area->area_id ?>);"><i aria-hidden="true" class="fa fa-key"></i> Enable</a> 
						         <?php } ?>
                                 <a style="cursor:pointer;"  class="dropdown-item tip-top delete delete one_<?php echo  $area->area_id; ?>" data-original-title="Delete" id="<?php echo $area->area_id; ?>"
						         Onclick="return ConfirmDelete(<?php echo $area->area_id ?>);"><i aria-hidden="true" class="fa fa-trash"></i> Delete</a> 
                              </div>
                             </div>
                             
						   
						</td>
                    </tr>
					  <!-- Modal -->
						<div class="modal fade" id="defaultsizemodal<?php echo $area->area_id ?>">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title"><i class="fa fa-star"></i> Update Area</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							   <form id="update_area<?php echo $area->area_id ?>" method="post" action="<?php echo base_url();?>product/update_area_data" enctype="multipart/form-data">
								  <div class="modal-body">
								     <div class="form-group">
                        				<label class="form-label" for="exampleInputEmail1">Select Zone</label><br>
                        				<select class="form-control single-select" name="zone_id">
                        					  <option value="<?php echo $area->zone_id ?>"><?php echo $area->zone_name ?></option>
                        					 <?php foreach($all_zone as $zone) { ?>
                        						  <option value="<?php echo $zone->zone_id ?>"><?php echo $zone->zone_name ?></option>
                        					 <?php } ?>
                        				  </select>
                        				<div class="form_error_msg zone_idError"></div>
                        			 </div>   
									<div class="form-group">
									  <label for="input-1">Area Name</label>
										<input type="text" class="form-control" name="area_name" id="input-1" value="<?php echo $area->area_name;?>" placeholder="Enter Area Name">
									  <div class="form_error_msg area_nameError"></div>
									 </div>
									 
									 
								  </div>
								  <input type="hidden" value="<?php echo $area->area_id;?>" name="area_id">
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
							$('#update_area<?php echo $area->area_id ?>').ajaxForm({
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
		<h5 class="modal-title"><i class="fa fa-star"></i> Add Area</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	   <form id="add_area" method="post" action="<?php echo base_url();?>product/add_area_data" enctype="multipart/form-data">
		  <div class="modal-body">
		    <div class="form-group">
				<label class="form-label" for="exampleInputEmail1">Select Zone</label>
				<select class="form-control single-select" name="zone_id">
					  <option value="">Select Zone</option>
					 <?php foreach($all_zone as $zone) { ?>
						  <option value="<?php echo $zone->zone_id ?>"><?php echo $zone->zone_name ?></option>
					 <?php } ?>
				  </select>
				<div class="form_error_msg zone_idError"></div>
			 </div>    
			<div class="form-group">
			  <label for="input-1">Area Name</label>
				<input type="text" class="form-control" name="area_name" id="input-1" placeholder="Enter area Name">
			  <div class="form_error_msg area_nameError"></div>
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
		$('#add_area').ajaxForm({
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
	   url: "<?php echo base_url();?>product/delete_area",
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
if(confirm("Are you sure you want to disable this area?"))
{
	$(".message").html("");
	
	$.ajax({
	   type: "POST",
	   url: "<?php echo base_url();?>product/disable_area",
	   data: {'delete_id':id},
		   success : function(id) 
		   {
		   window.location = "<?php echo base_url();?>product/area";

		  
		}
	});

}
return false;
}

</script>
<script type="text/javascript">
function ConfirmEnable(id)
{
if(confirm("Are you sure you want to enable this area?"))
{
	$(".message").html("");
	
	$.ajax({
	   type: "POST",
	   url: "<?php echo base_url();?>product/enable_area",
	   data: {'delete_id':id},
		   success : function(id) 
		   {
		   window.location = "<?php echo base_url();?>product/area";

		  
		}
	});

}
return false;
}

</script>