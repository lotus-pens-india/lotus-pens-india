
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Import Out of stock products</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Product</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Import Out of stock products</a></li>
         </ol>
	   </div>
	   <div class="col-sm-3">
       <div class="float-sm-right">
        <a href="<?php echo base_url();?>product/product_list"> 
         <button type="button" class="btn btn-primary waves-effect waves-light m-1">Product list</button>
        </a> 
      </div>
     </div>
     </div>
    <!-- End Breadcrumb-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-upload"></i> Import Out of stock products</div>
            <div class="card-body">
			  
                <div id="wizard-vertical1">
                    
                    <section>
                        <div class="form-group row">
                          <div class="col-md-12">  
                          <form  method="post" action="<?php echo base_url();?>product/download_product_excel">
                            <p>Your bulk stock update data file should as per this template 
                              
                               <button type="submit" class="btn btn-primary waves-effect waves-light m-1">Download template</button>
                              
                            </p>
                            </form>
                           </div>    
                        </div>  
                        <hr>
                      <form id="add_product" method="post" action="<?php echo base_url();?>product/import_out_of_stock_data">
						<div class="form-group row">
							
							
							<div class="col-md-4">
						   <label>File (csv format only)</label>
                           <div class="uploadOuter">
						      <input type="file"   class="form-control" name="file"  required/>
							  <div class="form_error_msg fileError"></div>
							</div>
			
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
