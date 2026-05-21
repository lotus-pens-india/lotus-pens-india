<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Dispatch Order</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Order</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Dispatch Order Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dispatch Order Data Tables</li>
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
            <div class="card-header"><i class="fa fa-table"></i> Dispatch Order List<button type="button" class="btn btn-info send_all" style="float:right;margin-bottom:13px">Delivered Order</button></div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="dispatch_sale_datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th><input type="checkbox" onclick="toggle(this);" /> Check all </th>
                        <th>Order Code</th>
                        <th>No.of<br>products</th>
                        <th>Customer</th> 
                        <th>Amount</th>
                        <th>Order date</th>
                        <th>Deliver Status</th>
                        <th>Payment Status</th>
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
					alert("Please select  order.");
					
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
		<h5 class="modal-title"><i class="fa fa-star"></i>Deliverd Order</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	   <form id="add_banner" method="post" action="<?php echo base_url();?>sales/delivered_product_order_data">
		  <div class="modal-body">
		     	<h5 class="modal-title"><i class="fa fa-star"></i>Are you sure you want to deliverd this order.</h5>

				<input type="hidden" class="form-control" name="multiple_id" id="multiple_id">
		
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> No</button>
			<button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i>Yes</button>
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
	
	
	
	function toggle(source) {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i] != source)
            checkboxes[i].checked = source.checked;
    }
}

</script>

    <!-- End container-fluid-->
