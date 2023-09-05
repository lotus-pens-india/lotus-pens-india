<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Delivery bulk sms</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Bulk sms</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Delivery bulk sms</a></li>
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
            <div class="card-header"><i class="fa fa-table"></i> </div>
            <div class="card-body">
                <form id="add_emp" method="post" action="<?php echo base_url();?>product/add_sms_db_data" enctype="multipart/form-data">
						<div class="form-group row">
						<label for="horizontalFormEmail" class="col-sm-2 control-label">Message : <span style="color:red">*</span></label>
						<div class="col-sm-10">
							<textarea type="text" class="form-control" id="textarea" name="sms" placeholder="Message" rows="8" cols="30" maxlength="140"></textarea>
						    <div class="form_error_msg smsError"></div>
						    <div id="textarea_feedback"></div>
						</div>
						
					</div>
					

					 <br>
					<div class="form-group row">
						<div class="col-sm-12">
                          <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i>Send</button>                 
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
	

$(document).ready(function() {
var text_max = 140;
$('#textarea_feedback').html(text_max + ' characters remaining');

$('#textarea').keyup(function() {
    var text_length = $('#textarea').val().length;
    var text_remaining = text_max - text_length;

    $('#textarea_feedback').html(text_remaining + ' characters remaining');
});

});

</script>


