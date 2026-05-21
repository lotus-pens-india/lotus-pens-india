<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Notification</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Product</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Notification Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Notification Data Tables</li>
         </ol>
	   </div>
	   <div class="col-sm-3">
       <div class="float-sm-right">
        <?php $login_type   = $this->session->userdata('type');  if($login_type !='0') { ?>   
          <button type="button" class="btn btn-primary waves-effect waves-light m-1" data-toggle="modal" data-target="#defaultsizemodal">Send notification</button>
        <?php } ?>  
      </div>
     </div>
     </div>
    <!-- End Breadcrumb-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Send Notification List</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="brand-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sr.No</th>
						<th>Title</th>
						<th>Message</th>
						<th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
					 <?php
						   if ($all_notification != '')
							{
							$i = 1;
							foreach($all_notification as $notification)
							{
					?>
                    <tr>
                        <td><?php echo $i++; ?></td>
						<td><?php echo $notification->title ?></td>
						<td><?php echo $notification->description ?></td>
						<td>
						    <?php if($notification->image == '') { ?>
						    <a href="https://via.placeholder.com/1500x1000" data-fancybox="images" data-caption="This image has a caption">
							  <img src="https://via.placeholder.com/240x160" alt="lightbox" class="lightbox-thumb img-thumbnail" style="width: 100px;">
							</a>
						<?php } else { ?>
						    <a href="<?php echo base_url('assets/images/notification/'.$notification->image);?>" data-fancybox="images" data-caption="This image has a caption">
							  <img src="<?php echo base_url('assets/images/notification/'.$notification->image);?>" alt="lightbox" class="lightbox-thumb img-thumbnail" style="width: 100px;">
							</a>
						<?php } ?>
						</td>
						<td>
						 <a style="cursor:pointer;"  class="tip-top delete delete one_<?php echo  $notification->notification_id; ?>" data-original-title="Delete" id="<?php echo $notification->notification_id; ?>"
						      Onclick="return ConfirmDelete(<?php echo $notification->notification_id; ?>);">
						     <button type="button" class="btn btn-danger waves-effect waves-light m-1"> <i class="fa fa-trash-o"></i> </button>
						  </a> 
						</td>
                    </tr>

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
		<h5 class="modal-title"><i class="fa fa-star"></i> Send notification</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	   <form id="add_subcategory" method="post" action="<?php echo base_url();?>product/add_notification_data" enctype="multipart/form-data">
		  <div class="modal-body">
			
			 
			  <div class="form-group">
			  <label for="input-1">Image</label>
				<input type="file" class="form-control" name="image" id="input-1">
			  <div class="form_error_msg imageError"></div>
			 </div>
			 <hr>
			 <div class="form-group">
			  <label for="input-1">Notification Title</label>
				<input type="text" class="form-control" name="title" placeholder="Notification Title" id="input-1" required>
			 </div>
			 <div class="form-group">
			  <label for="input-1">Notification Message</label>
				<input type="text" class="form-control" name="description" placeholder="Notification Message" id="input-1" required>
			 </div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
			<button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i>Send</button>
		  </div>
		  <div class="success_message"></div>
		</form>  
	</div>
  </div>
</div>
<script type="text/javascript">
	$(function(){
		$('#add_subcategory').ajaxForm({
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
	   url: "<?php echo base_url();?>product/delete_notification",
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