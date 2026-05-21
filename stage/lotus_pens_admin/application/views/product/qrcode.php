
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">APP QRCODE</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Master</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">APP QRCODE</a></li>
         </ol>
	   </div>
	   <div class="col-sm-3">
      
     </div>
     </div>
    <!-- End Breadcrumb-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-upload"></i> APP QRCODE</div>
            <div class="card-body">
			  <!--<form id="add_product" method="post" action="<?php echo base_url();?>product/add_qrcode_data">
                <div id="wizard-vertical1">
                    
                   

                    <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i>Add</button>
                </div> 
				<br>
				<div class="success_message"></div>
				</form>-->
				
				<img src="<?php echo base_url();?>global/tmp/qr_codes/<?php echo $qrcode->barcode; ?>" alt="user-img" style="width: 300px; height: 300px;"  >
            </div>
          </div>
        </div>
      </div><!-- End Row-->


    </div>
    <!-- End container-fluid-->

<script type="text/javascript">
	$(function(){
		$('#add_product').ajaxForm({
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

