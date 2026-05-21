
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Update Password</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Password</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Update Password</a></li>
         </ol>
	   </div>
	   <div class="col-sm-3">
      
     </div>
     </div>
    <!-- End Breadcrumb-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-upload"></i> Update Password</div>
            <div class="card-body">
			  <form id="password_update" method="post" action="<?php echo base_url();?>product/update_password_data">
                <div id="wizard-vertical1">
                    
                    <section>
                       	<div class="form-row">
								<div class="form-group col-md-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">Current Password</label>
										<input type="password" class="form-control" name="current_pass" id="current_pass" placeholder="Current Password" onchange="findandcheck()">

									</div>
								</div>
								<div class="form-group col-md-6">
									<div class="form-group">
										<label class="form-label" for="exampleInputEmail1">New Password</label>
										<input type="password" class="form-control" name="new_pass" id="new_pass"   placeholder="New Password">
										
									</div>
								</div>
								<div class="form-group col-md-6">
									<label for="inputEmail4" class="col-form-label">Confirm Password</label>
									<input type="text" class="form-control" name="confirm_pass" id="confirm_pass"  placeholder="Confirm Password">
									
								</div>
							   <div class="form-group col-md-6">
							       
							   </div>      
							</div>
							<div class="form-row">
								<div class="form-group col-md-6">
									 <div class="form_error_msg current_passError"></div>
									 <div class="form_error_msg confirm_passError"></div>
									 <div class="form_error_msg new_passError"></div>
									 <div id="existpass" class="form_error_msg"></div>
										 
							
							    </div>
							 </div>

                    </section>

                    <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i>Update</button>
                </div> <!-- End #wizard-vertical -->
				<br>
				<div class="success_message"></div>
				</form>
            </div>
          </div>
        </div>
      </div><!-- End Row-->


    </div>
    <!-- End container-fluid-->
 
<script type="text/javascript">
	$(function(){
		$('#password_update').ajaxForm({
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

function findandcheck()
{
	$("#existpass").val('');
	var current_pass=document.getElementById('current_pass').value;
    //alert(current_pass);
	var scriptUrl1="<?php echo base_url();?>product/verify_password?current_pass="+current_pass;
//	alert(scriptUrl1);
	$.ajax({url:scriptUrl1,success: function(res1)
	{
		//	alert(res1);
		  if(res1==1)
          {
          	$("#current_pass").focus();
          	$('#existpass').html(current_pass +' '+'current password does not match!');
          	$("#current_pass").val('');
          }
          else
          {
          	$("#existpass").html('');
                      }
                      
			
	}});
}

var new_pass = document.getElementById("new_pass")
  , confirm_pass = document.getElementById("confirm_pass");

function validatePassword(){
  if(new_pass.value != confirm_pass.value) {
    confirm_pass.setCustomValidity("Passwords Don't Match");
  } else {
    confirm_pass.setCustomValidity('');
  }
}

new_pass.onchange = validatePassword;
confirm_pass.onkeyup = validatePassword;

</script>
