<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Add Seller</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Seller</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Add Seller Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Seller Data Tables</li>
         </ol>
	   </div>
	   <div class="col-sm-3">
       <div class="float-sm-right">
         <a href="<?php echo base_url();?>product/franchise">  
          <button type="button" class="btn btn-primary waves-effect waves-light m-1">Seller List</button>
         </a> 
      </div>
     </div>
     </div>
    <!-- End Breadcrumb-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Seller From</div>
            <div class="card-body">
                <form id="add_emp" method="post" action="<?php echo base_url();?>product/add_franchise_data" enctype="multipart/form-data">
    				  
    				<div class="form-group row">
    					<label for="horizontalFormEmail" class="col-sm-2 control-label">Seller Name : <span style="color:red">*</span></label>
    					<div class="col-sm-4">
    						<input type="text" class="form-control" id="franchise_name" name="franchise_name" placeholder="Franchise Name ">
    					 <div class="form_error_msg franchise_nameError"></div>
    					</div>
    					<label for="horizontalFormEmail" class="col-sm-2 control-label">Mobile No : <span style="color:red">*</span></label>
    					<div class="col-sm-4">
    						<input type="number" class="form-control" id="mobile_no" name="mobile_no" placeholder="Mobile No ">
    					 <div class="form_error_msg mobile_noError"></div>
    					</div>
    				</div>
					<div class="form-group row">
						<label for="horizontalFormEmail" class="col-sm-2 control-label">Email id : <span style="color:red">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="email_id" name="email_id" placeholder="Email id">
						<div class="form_error_msg email_idError"></div>
						</div>
						
					</div>
					
				
					<div class="form-group row">
						<label for="horizontalFormEmail" class="col-sm-2 control-label">State: </label>
						<div class="col-sm-4">
							<select class="form-control single-select"   name="state" id="state_id">
        							<option value="">Select State</option>
        							<?php
        							foreach($all_state as $state){
        								
        								echo '<option value="'.$state->state_id.'">'.$state->state_name.'</option>';
        							}
        							?>
        						</select>
							<div class="form_error_msg stateError"></div>
				
						</div>
						<label for="horizontalFormEmail" class="col-sm-2 control-label">City : <span style="color:red">*</span></label>
						<div class="col-sm-4">
							<select class="form-control single-select"   name="city" id="city_id">
						        </select>
						 <div class="form_error_msg cityError"></div>
						</div>
						
					</div>
						<div class="form-group row">
						<label for="horizontalFormEmail" class="col-sm-2 control-label">Address : <span style="color:red">*</span></label>
						<div class="col-sm-4">
							<textarea type="text" class="form-control" id="address" name="address" placeholder="Address"></textarea>
						 <div class="form_error_msg addressError"></div>
						</div>
						
					</div>
					<div class="form-group row">
						<label for="horizontalFormEmail" class="col-sm-2 control-label">User Name : <span style="color:red">*</span></label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="username" name="username" placeholder="User Name ">
						 <div class="form_error_msg usernameError"></div>
						</div>
						<label for="horizontalFormEmail" class="col-sm-2 control-label">Password : <span style="color:red">*</span></label>
						<div class="col-sm-4">
							<input type="password" class="form-control" id="password" name="password" placeholder="Password ">
						 <div class="form_error_msg passwordError"></div>
						</div>
						
					</div>


					 <br>
					<div class="form-group row">
						<div class="col-sm-12">
                          <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i>Add</button>                 
						   <span class="success_message"></span>
						</div>
					</div>	
					</form>
            </div>
          </div>
        </div>
      </div><!-- End Row-->


    </div>
    <!-- End container-fluid-->
	

<script type="text/javascript">
	$(function(){
		$('#add_emp').ajaxForm({
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
<script>

$(document).on('change','#state_id',function () {
  $('#city_id').empty();
	if($(this).val() != 'none')
	{
		var id = $(this).val();
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url();?>product/all_cities_by_state_id',
			data: { id: id },
			dataType: 'json',
			success: function( json ) {
				$('#city_id').append($('<option>').text("Select"));
				$.each(json, function(key, value) {
					$('#city_id')
						.append($("<option></option>")
							.attr("value",value.city_id)
							.text(value.city_name));
				});
			}
		})
	}
	else
	{
		$("#city_id").empty();
	}
});
</script>

