<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
  <meta name="description" content=""/>
  <meta name="author" content=""/>
  <title>Lotus Pens - Admin Dashboard</title>
  <!--favicon-->
  <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
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
		 	<div class="text-center">
		 		<img src="<?php echo base_url();?>assets/images/login.jpg" style="height:100px">
		 	</div>
		  <div class="card-title text-uppercase text-center py-3">Sign In</div>
		    <form id="login" method="post" action="<?php echo base_url();?>login/login_process">
			  <div class="form-group">
			   <div class="position-relative has-icon-right">
				  <label for="exampleInputUsername" class="sr-only">Username</label>
				  <input type="text" id="exampleInputUsername" name="username" class="form-control form-control-rounded" placeholder="Username">
				  <div class="form-control-position">
					  <i class="icon-user"></i>
				  </div>
				  <div class="form_error_msg usernameError"></div>
			   </div>
			   
			  </div>
			  <div class="form-group">
			   <div class="position-relative has-icon-right">
				  <label for="exampleInputPassword" class="sr-only">Password</label>
				  <input type="password" id="exampleInputPassword" name="password" class="form-control form-control-rounded" placeholder="Password">
				  <div class="form-control-position">
					  <i class="icon-lock"></i>
				  </div>
				  <div class="form_error_msg passwordError"></div>
			   </div>
			   
			  </div>
			  	<div class="form-row mr-0 ml-0">
    			 <div class="form-group col-6">
    			   
    			  </div>
    			 
    			 <div class="form-group col-6 text-right">
    			  <a href="<?php echo base_url();?>login/reset_password">Reset Password</a>
    			 </div>
    			</div>
			
			 <button type="submit" class="btn btn-primary shadow-primary btn-round btn-block waves-effect waves-light">Sign In</button>
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
  
</body>
</html>
