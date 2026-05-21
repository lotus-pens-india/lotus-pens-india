<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Sub Subcategory</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Product</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Sub Subcategory Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sub Subcategory Data Tables</li>
         </ol>
	   </div>
	   <div class="col-sm-3">
       <div class="float-sm-right">
           <?php $login_type   = $this->session->userdata('type');  if($login_type !='0') { ?>
              <button type="button" class="btn btn-primary waves-effect waves-light m-1" data-toggle="modal" data-target="#defaultsizemodal">Add Sub Subcategory</button>
            <?php } ?>  
      </div>
     </div>
     </div>
    <!-- End Breadcrumb-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Brands List</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="brand-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Icon</th>
                        <th>Sub Subcategory</th>
                        <th>Color</th>
						<th>Subcategory</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
					<?php
						   if ($all_sub_subcategory != '')
							{
							$i = 1;
							foreach($all_sub_subcategory as $sub_subcategory)
							{
					?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td>
						    <?php if($sub_subcategory->icon == '') { ?>
						    <a href="https://via.placeholder.com/1500x1000" data-fancybox="images" data-caption="This image has a caption">
							  <img src="https://via.placeholder.com/240x160" alt="lightbox" class="lightbox-thumb img-thumbnail">
							</a>
						<?php } else { ?>
						    <a href="<?php echo base_url('assets/images/sub_subcategory/'.$sub_subcategory->icon);?>" data-fancybox="images" data-caption="This image has a caption">
							  <img src="<?php echo base_url('assets/images/sub_subcategory/'.$sub_subcategory->icon);?>" alt="lightbox" class="lightbox-thumb img-thumbnail" style="width: 100px;">
							</a>
						<?php } ?>
						</td>
                        <td><?php echo $sub_subcategory->sub_subcategory;?></td>
                        <td>
                            <h1 style="height: 50px;background-color:<?php echo $sub_subcategory->color ?>;"></h1>
                        </td>
						<td><?php echo $sub_subcategory->sub_category; ?></td>
						<td><?php echo $sub_subcategory->name; ?></td>
						<td>
							<button type="button" class="btn btn-secondary waves-effect waves-light m-1"  data-toggle="modal" data-target="#defaultsizemodal<?php echo  $sub_subcategory->sub_subcategory_id; ?>"> <i class="fa fa-edit"></i> </button>
							 <a style="cursor:pointer;"  class="tip-top delete delete one_<?php echo  $sub_subcategory->sub_subcategory_id; ?>" data-original-title="Delete" id="<?php echo $sub_subcategory->sub_subcategory_id; ?>"
								  Onclick="return ConfirmDelete(<?php echo $sub_subcategory->sub_subcategory_id; ?>);">
								 <button type="button" class="btn btn-danger waves-effect waves-light m-1"> <i class="fa fa-trash-o"></i> </button>
							  </a>
						</td>
                    </tr>
					  <!-- Modal -->
						<div class="modal fade" id="defaultsizemodal<?php echo  $sub_subcategory->sub_subcategory_id; ?>">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title"><i class="fa fa-star"></i> Update Sub Subcategory</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							   <form id="update_sub_subcategory<?php echo  $sub_subcategory->sub_subcategory_id; ?>" method="post" action="<?php echo base_url();?>product/update_sub_subcategory_data">
								  <div class="modal-body">
									<div class="form-group">
									  <label for="input-1">Sub Subcategory</label>
										<input type="text" class="form-control" name="sub_subcategory" value="<?php echo $sub_subcategory->sub_subcategory;?>" id="input-1" placeholder="Enter Subcategory">
									  <div class="form_error_msg sub_subcategoryError"></div>
									 </div>
									 <div class="form-group">
                        			  <label for="input-1">Color</label>
                        				<input id="simple-color-picker<?php echo $sub_subcategory->sub_subcategory_id ?>" type="text" class="form-control" value="<?php echo $sub_subcategory->color;?>" name="color" />
                        			  <div class="form_error_msg colorError"></div>
                        			 </div>
									 <div class="form-group">
									  <label for="input-1">Select Category</label>
										 <select class="form-control single-select" name="category_id" id="category_id1">
										 <option value="<?php echo $sub_subcategory->category_id ?>"><?php echo $sub_subcategory->name ?></option>
										 <?php foreach($all_category as $category) { ?>
											  <option value="<?php echo $category->category_id ?>"><?php echo $category->name ?></option>
										 <?php } ?>	  
										  </select>
									  <div class="form_error_msg category_idError"></div>
									 </div>
									 <div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Select Sub Category</label>
										<select class="form-control single-select"  name="sub_category_id" id="sub_category_id1">
										<option value="<?php echo $sub_subcategory->sub_category_id ?>"><?php echo $sub_subcategory->sub_category ?></option>
										 </select>
										<div class="form_error_msg sub_category_idError"></div>
									 </div>
									 <div class="form-group">
									  <label for="input-1">Icon (32x32)</label>
										<input type="file" class="form-control" name="icon" id="input-1">
										<?php if($sub_subcategory->icon != '') { ?>
										  <img src="<?php echo base_url()?>assets/images/sub_subcategory/<?php echo $sub_subcategory->icon ?>" class="images" style="width: 100px;height: 100px;">
										<?php } else { ?>
										  <img src="https://via.placeholder.com/1500x1000" class="images" style="width: 100px;height: 100px;">
										<?php } ?>										
										 <input type="hidden"  class="form-control" name="icon_old" value="<?php echo $sub_subcategory->sub_subcategory_id ?>">
									  <div class="form_error_msg iconError"></div>
									 </div> 
									 
								  </div>
								  <input type="hidden" value="<?php echo $sub_subcategory->sub_subcategory_id;?>" name="sub_subcategory_id">
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
							$('#update_sub_subcategory<?php echo  $sub_subcategory->sub_subcategory_id; ?>').ajaxForm({
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
                          $('#simple-color-picker<?php echo $sub_subcategory->sub_subcategory_id ?>').colorpicker();
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
		<h5 class="modal-title"><i class="fa fa-star"></i> Add Sub Subcategory</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	   <form id="add_sub_subcategory" method="post" action="<?php echo base_url();?>product/add_sub_subcategory_data">
		  <div class="modal-body">
			<div class="form-group">
			  <label for="input-1">Sub Subcategory</label>
				<input type="text" class="form-control" name="sub_subcategory" id="input-1" placeholder="Enter Subcategory">
			  <div class="form_error_msg sub_subcategoryError"></div>
			 </div>
			  <div class="form-group">
			  <label for="input-1">Color</label>
				<input id="simple-color-picker" type="text" class="form-control" name="color"/>
			  <div class="form_error_msg colorError"></div>
			 </div>
			 <div class="form-group">
			  <label for="input-1">Select Category</label>
				 <select class="form-control single-select" name="category_id" id="category_id">
				 <option value="">Select Category</option>
				 <?php foreach($all_category as $category) { ?>
					  <option value="<?php echo $category->category_id ?>"><?php echo $category->name ?></option>
				 <?php } ?>	  
				  </select>
			  <div class="form_error_msg category_idError"></div>
			 </div>
			 <div class="form-group">
				<label class="form-label" for="exampleInputEmail1">Select Sub Category</label>
				<select class="form-control single-select"  name="sub_category_id" id="sub_category_id">
				 </select>
				<div class="form_error_msg sub_category_idError"></div>
			 </div>
			 <div class="form-group">
			  <label for="input-1">Icon</label>
				<input type="file" class="form-control" name="icon" id="input-1" required>
			  <div class="form_error_msg iconError"></div>
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
<script>

$(document).on('change','#category_id',function () {
  $('#sub_category_id').empty();
	if($(this).val() != 'none')
	{
		var id = $(this).val();
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url();?>product/all_sub_subcategory_by_category_id',
			data: { id: id },
			dataType: 'json',
			success: function( json ) {
				$('#sub_category_id').append($('<option>').text("Select"));
				$.each(json, function(key, value) {
					$('#sub_category_id')
						.append($("<option></option>")
							.attr("value",value.sub_category_id)
							.text(value.sub_category));
				});
			}
		})
	}
	else
	{
		$("#sub_category_id").empty();
	}
});
</script> 

<script>

$(document).on('change','#category_id1',function () {
  $('#sub_category_id1').empty();
	if($(this).val() != 'none')
	{
		var id = $(this).val();
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url();?>product/all_sub_subcategory_by_category_id',
			data: { id: id },
			dataType: 'json',
			success: function( json ) {
				$('#sub_category_id1').append($('<option>').text("Select"));
				$.each(json, function(key, value) {
					$('#sub_category_id1')
						.append($("<option></option>")
							.attr("value",value.sub_category_id)
							.text(value.sub_category));
				});
			}
		})
	}
	else
	{
		$("#sub_category_id1").empty();
	}
});
</script> 
<script type="text/javascript">
	$(function(){
		$('#add_sub_subcategory').ajaxForm({
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
	   url: "<?php echo base_url();?>product/delete_sub_subcategory",
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
<script>
          $(function () {
              $('#simple-color-picker').colorpicker();
          });
      </script>