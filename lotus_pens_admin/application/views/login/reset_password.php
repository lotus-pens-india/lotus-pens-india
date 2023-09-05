<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <meta name="description" content=""/>
  <meta name="author" content=""/>
  <title>Exotic Basket</title>
  <link rel="icon" href="<?php echo base_url();?>assets/images/favicon.ico" type="image/x-icon">
  <!-- Bootstrap core CSS-->
  <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet"/>
  <!-- animate CSS-->
  <link href="<?php echo base_url();?>assets/css/animate.css" rel="stylesheet" type="text/css"/>
  <!-- Icons CSS-->
  <link href="<?php echo base_url();?>assets/css/icons.css" rel="stylesheet" type="text/css"/>
  <!-- Custom Style-->
  <link href="<?php echo base_url();?>assets/css/app-style.css" rel="stylesheet"/>
  
</head>

<body>
 <!-- Start wrapper-->
 <div id="wrapper">
	<div class="card border-primary border-top-sm border-bottom-sm card-authentication1 mx-auto my-5 animated bounceInDown">
		<div class="card-body">
		 <div class="card-content p-2">
		  <div class="card-title text-uppercase text-center pb-2">Reset Password</div>
		    <p class="text-center pb-2">Please enter your mobile no to create a new password via otp.</p>
		    <form id="login" method="post" action="<?php echo base_url();?>login/change_pass_page">
			  <div class="form-group">
			   <div class="position-relative has-icon-right">
				  <label for="exampleInputEmailAddress" class="sr-only">Mobile no</label>
				  <input type="text" id="mobile" class="form-control form-control-rounded" placeholder="Enter mobile no">
				  <div class="form-control-position">
					  <i class="icon-phone"></i>
				  </div>
			   </div>
			  </div>
			  <div class="form-group">
			   <div class="position-relative has-icon-right">
				  <label for="exampleInputPassword" class="sr-only">Otp</label>
				  <input type="text"  name="otp" id="otp" class="form-control form-control-rounded" placeholder="Enter OTP">
				  <div class="form-control-position" id= 'otp_icon'>
					  <i class="icon-phone"></i>
				  </div>
			   </div>
			   
			  </div>
			 
			  <button type="button" class="btn btn-primary shadow-primary btn-round btn-block waves-effect waves-light mt-3" name="next" id="next" onclick="show()">Send otp</button>
			  <button type="submit"  class="btn btn-primary shadow-primary btn-round btn-block waves-effect waves-light" id="login_button" style="display:none;">Submit</button>
			 
			 <div id="mnne" style="font-size:12px;color:red">Mobile Number Not Exist.OR Account Deactive</div>
			  <div class="text-center pt-3">
				<hr>
				<p class="text-muted">Return to the <a href="<?php echo base_url();?>login"> Sign In</a></p>
			  </div>
			  <div class="success_message"></div> 
			 </form>
		   </div>
		  </div>
	     </div>
    
     <!--Start Back To Top Button-->
    <a href="javaScript:void();" class="back-to-top"><i class="fa fa-angle-double-up"></i> </a>
    <!--End Back To Top Button-->
	</div><!--wrapper-->
	
  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/popper.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
  	<script src="<?php echo base_url();?>assets/js/jquery_form.js"></script>
	<script type="text/javascript">
		$(function(){
			$('#login').ajaxForm({
				beforeSend : function(){
					$('.form_error_msg').html('');
					$('.success_message').html('<div class="alert alert-outline-warning alert-dismissible alert-round" role="alert"><button type="button" class="close" data-dismiss="alert">×</button><div class="alert-icon"> <i class="icon-exclamation"></i> </div><div class="alert-message"><span><strong>Login!</strong> please wait.. <a href="javascript:void();" class="alert-link"></a></span></div></div>');
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
$(document).ready(function() {
	$("#otp").hide();
	$("#mnne").hide();
	$("#otp_icon").hide();
	
});
function show()
{
	var m=$("#mobile").val();
	//alert(m);
	$.ajax({
		type: "POST",
		url: "<?php echo base_url();?>login/numberCheck",
		dataType : "html",
		data: {m:m},
		cache: false,
		success: function(res){
			//alert(res);		
			if(res==1)
			{		
				//alert('if');
				$("#mnne").hide();		   
				$("#mobile").attr("readonly", true);				
				$("#next").hide();
				$("#otp").show();
				$("#login_button").show();
				$("#otp_icon").show();
				
			}
			else if(res==0)
			{
				//alert('else');
				$("#mnne").show();
			}
			
		}		
	});
}

</script>
	
</body>
</html>
