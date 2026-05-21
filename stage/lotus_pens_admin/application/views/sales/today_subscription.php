<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">New Subscription</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Sales</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">New Subscription</a></li>
            <li class="breadcrumb-item active" aria-current="page">New Subscription Data Tables</li>
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
            <div class="card-header"><i class="fa fa-table"></i> New Subscription List 
            <?php $login_type   = $this->session->userdata('type');  if($login_type !='0') { ?> 
            <button type="button" class="btn btn-info send_all" style="float:right;margin-bottom:13px">Assign to</button>
            <?php } ?>
            </div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="today_datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Select</th>
                        <th>Subscribe ID</th>
                        <th>Customer</th>
                        <th>Mobile no</th>
                        <th>Total Days</th>
                        <th>Date</th>
                        <th>Mode</th> 
                        <th>Assign to</th>
                        <th>Saller</th>
                        <th>Option</th>
                    </tr>
                </thead>
                
                
            </table>
            </div>
            </div>
          </div>
        </div>
      </div><!-- End Row-->


    </div>
    <!-- End container-fluid-->
    
        <script type="text/javascript">
		$(document).ready(function () {
			$('#example').on('click', function(e) {
			 if($(this).is(':checked',true))  
			 {
				$(".sub_chk").prop('checked', true);  
			 } else {  
				$(".sub_chk").prop('checked',false);  
			 }  
			});

			$('.send_all').on('click', function(e) {

				var allVals = [];  
				$(".sub_chk:checked").each(function() {  
					allVals.push($(this).attr('data-id'));
				});  

				if(allVals.length <=0)  
				{  
					alert("Please select subcription order.");
					
				} 
 
				else
				{ 
				    var join_selected_values = allVals.join(",");
				    $('#send_smss').modal('show');
				    $("#multiple_id").val(join_selected_values);
	
				}  
			});
		});
</script>
<div class="modal fade" id="send_smss">
  <div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title"><i class="fa fa-star"></i> Assign to delivery boy</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	   <form id="add_banner" method="post" action="<?php echo base_url();?>sales/assign_subscription_data">
		  <div class="modal-body">
		     	<div class="form-group">
			  <label for="input-1">Select Delivery boy</label>
               <select class="form-control single-select"  name="assign_to" id="assign_to">
				  <option value="">Select Delivery Boy</option>
				  <?php foreach($all_delivery_boy as $delivery_boy) { ?>
					   <option value="<?php echo $delivery_boy->db_id ?>"><?php echo $delivery_boy->name ?></option>
				  <?php } ?>
				  </select>
				<div class="form_error_msg assign_toError"></div>
			 </div>

				<input type="hidden" class="form-control" name="multiple_id" id="multiple_id">
		
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
		$('#add_banner').ajaxForm({
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
