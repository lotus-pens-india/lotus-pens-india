<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Category</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Product</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Category Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Category Data Tables</li>
         </ol>
	   </div>
	   <div class="col-sm-3">
       <div class="float-sm-right">
        <?php $login_type   = $this->session->userdata('type');  if($login_type !='0') { ?>   
         <button type="button" class="btn btn-primary waves-effect waves-light m-1" data-toggle="modal" data-target="#defaultsizemodal">Add Category</button>
        <?php } ?> 
      </div>
     </div>
     </div>
    <!-- End Breadcrumb-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Category List</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="brand-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Category Name</th>
                        <th>Color</th>
                        <th>Icon</th>
						 <th>Status</th>
                        <th>Position</th>
                        <th>Franchise</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
				<?php
					   if ($all_category != '')
						{
						$i = 1;
						foreach($all_category as $category)
						{
				?>   
                    <tr>
                        <td><?php echo $category->name ?></td>
                        <td>
                            <h1 style="height: 50px;background-color:<?php echo $category->color ?>;"></h1>
                        </td>
                        <td>
						<?php if($category->icon == '') { ?>
						    <a href="https://via.placeholder.com/1500x1000" data-fancybox="images" data-caption="This image has a caption">
							  <img src="https://via.placeholder.com/240x160" alt="lightbox" class="lightbox-thumb img-thumbnail" style="width: 100px;">
							</a>
						<?php } else { ?>
						    <a href="<?php echo base_url('assets/images/category/'.$category->icon);?>" data-fancybox="images" data-caption="This image has a caption">
							  <img src="<?php echo base_url('assets/images/category/'.$category->icon);?>" alt="lightbox" class="lightbox-thumb img-thumbnail" style="width: 100px;">
							</a>
						<?php } ?>						
						</td>
							<td>
						    <?php 
						      if($category->isActive == '0')
                                {
                                    echo '<span class="badge badge-success shadow-success m-1">Enable</span>';
                                    
                                }elseif($category->isActive == '1')
                                {
                                  echo '<span class="badge badge-danger shadow-danger m-1">Disable</span>';
                                  
                                }
						    ?>
						</td>
						<td>
						    <?php echo $category->position; ?>
						</td>
							<td>
						    <?php echo $category->franchise_name; ?>
						</td>
                        <td>
                            
                            <div class="btn-group m-1" role="group">
                              <button type="button" class="btn btn-dark   waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                              </button>
                              <div class="dropdown-menu">
                                <a  class="dropdown-item" data-toggle="modal" data-target="#defaultsizemodal<?php echo $category->category_id ?>"><i aria-hidden="true" class="fa fa-edit"></i>Edit</a>
                                 <?php if($category->isActive == '0'){ ?>
                                 <a style="cursor:pointer;"  class="dropdown-item tip-top delete delete one_<?php echo  $category->category_id; ?>" data-original-title="Delete" id="<?php echo $category->category_id; ?>"
						         Onclick="return ConfirmDisable(<?php echo $category->category_id ?>);"><i aria-hidden="true" class="fa fa-ban"></i> Disable</a> 
						         <?php }else { ?>
						         <a style="cursor:pointer;"  class="dropdown-item tip-top delete delete one_<?php echo  $category->category_id; ?>" data-original-title="Delete" id="<?php echo $category->category_id; ?>"
						         Onclick="return ConfirmEnable(<?php echo $category->category_id ?>);"><i aria-hidden="true" class="fa fa-key"></i> Enable</a> 
						         <?php } ?>
                                 <a style="cursor:pointer;"  class="dropdown-item tip-top delete delete one_<?php echo  $category->category_id; ?>" data-original-title="Delete" id="<?php echo $category->category_id; ?>"
						         Onclick="return ConfirmDelete(<?php echo $category->category_id ?>);"><i aria-hidden="true" class="fa fa-trash"></i> Delete</a> 
                              </div>
                             </div>
                             
						   
						</td>
                    </tr>
					  <!-- Modal -->
						<div class="modal fade" id="defaultsizemodal<?php echo $category->category_id ?>">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title"><i class="fa fa-star"></i> Update category</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							   <form id="update_category<?php echo $category->category_id ?>" method="post" action="<?php echo base_url();?>product/update_category_data" enctype="multipart/form-data">
								  <div class="modal-body">
									<div class="form-group">
									  <label for="input-1">Category Name</label>
										<input type="text" class="form-control" name="category_name" id="input-1" value="<?php echo $category->name;?>" placeholder="Enter Category Name">
									  <div class="form_error_msg category_nameError"></div>
									 </div>
									 <div class="form-group">
                        			  <label for="input-1">Color</label>
                        				<input id="simple-color-picker<?php echo $category->category_id ?>" type="text" class="form-control" value="<?php echo $category->color;?>" name="color"/>
                        			  <div class="form_error_msg colorError"></div>
                        			 </div>
									 <div class="form-group">
									  <label for="input-1">Icon (32x32)</label>
										<input type="file" class="form-control" name="icon" id="input-1">
										<?php if($category->icon != '') { ?>
										  <img src="<?php echo base_url()?>assets/images/category/<?php echo $category->icon; ?>" class="images" style="width: 100px;height: 100px;">
										<?php } else { ?>
										  <img src="https://via.placeholder.com/1500x1000" class="images" style="width: 100px;height: 100px;">
										<?php } ?>										
										 <input type="hidden"  class="form-control" name="icon_old" value="<?php echo $category->icon; ?>">
									  <div class="form_error_msg iconError"></div>
									 </div>
									 
									 <div class="form-group">
									  <label for="input-1">Category position</label>
										<input type="text" class="form-control" name="position" id="input-1" value="<?php echo $category->position;?>" placeholder="Enter position">
									  <div class="form_error_msg positionError"></div>
									 </div>
									 
								  </div>
								  <input type="hidden" value="<?php echo $category->category_id;?>" name="category_id">
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
							$('#update_category<?php echo $category->category_id ?>').ajaxForm({
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
					<script>
                      $(function () {
                          $('#simple-color-picker<?php echo $category->category_id ?>').colorpicker();
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
		<h5 class="modal-title"><i class="fa fa-star"></i> Add Category</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	   <form id="add_category" method="post" action="<?php echo base_url();?>product/add_category_data" enctype="multipart/form-data">
		  <div class="modal-body">
			<div class="form-group">
			  <label for="input-1">Category Name</label>
				<input type="text" class="form-control" name="category_name" id="input-1" placeholder="Enter Category Name">
			  <div class="form_error_msg category_nameError"></div>
			 </div>
			 <div class="form-group">
			  <label for="input-1">Color</label>
				<input id="simple-color-picker" type="text" class="form-control" name="color"/>
			  <div class="form_error_msg colorError"></div>
			 </div>
			 <div class="form-group">
			  <label for="input-1">Icon (32x32)</label>
				<input type="file" class="form-control" name="icon" id="input-1">
			  <div class="form_error_msg iconError"></div>
			 </div>
			 <div class="form-group">
			  <label for="input-1">Category position</label>
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
		$('#add_category').ajaxForm({
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
	   url: "<?php echo base_url();?>product/delete_category",
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
if(confirm("Are you sure you want to disable this category?"))
{
	$(".message").html("");
	
	$.ajax({
	   type: "POST",
	   url: "<?php echo base_url();?>product/disable_category",
	   data: {'delete_id':id},
		   success : function(id) 
		   {
		   window.location = "<?php echo base_url();?>product/category";

		  
		}
	});

}
return false;
}

</script>
<script type="text/javascript">
function ConfirmEnable(id)
{
if(confirm("Are you sure you want to enable this category?"))
{
	$(".message").html("");
	
	$.ajax({
	   type: "POST",
	   url: "<?php echo base_url();?>product/enable_category",
	   data: {'delete_id':id},
		   success : function(id) 
		   {
		   window.location = "<?php echo base_url();?>product/category";

		  
		}
	});

}
return false;
}

</script>
<script>
          $(function () {
              $('#simple-color-picker').colorpicker();
          });
      </script>