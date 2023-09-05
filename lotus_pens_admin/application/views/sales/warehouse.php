<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
    
    <!-- End Breadcrumb-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-upload"></i>Warehouse</div>
            <div class="card-body">
			  <form id="add_product" method="post" action="<?php echo base_url();?>sales/warehouse">
                <div id="wizard-vertical1">
                    
                    <section>
                        <div class="form-group row">
						  <div class="col-md-4">
                            <label>Order id  *</label>
                            <input class="form-control" name="order_id" placeholder="EX : 943001598585"  type="text" required>
						  </div>
                          
                        </div>


                    </section>

                    <button type="submit" value="Submit" name="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Submit</button>
                </div> <!-- End #wizard-vertical -->
				</form>
				<hr>
				 <?php if(!empty($submit))
        		 {
        		    if($submit == 'Submit')
        		    {
        		 
        		 ?>
        		<button type="button" class="btn btn-info send_all" style="float:right;margin-bottom:13px">Dispatch Product</button>
        		 <div class="table-responsive">
                  <table id="sales_report_datatable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Dispatch</th>
                            <th>Unit</th>
                            <th>Qty</th>
                            <th>Product</th>
                            <th>Unit price</th> 
                            <th>Discount(%)</th>
                            <th>Sub total</th>
                            <th>Status</th>
                            

                        </tr>
                    </thead>
                    <tbody>
                         <?php
				
							    $CI =& get_instance();
        						$CI->load->model('product_model');
        						$result = $CI->product_model->get_item_details($order_summary->order_id);
        						$sum = 0;
                                foreach($result as $p_detail)
    					        {
						  ?>
                        <tr>
                              <td>
                                  <input type="checkbox" class="sub_chk" data-id="<?php echo $p_detail->order_d_id; ?>">
                              </td>
                              <td><?php echo $p_detail->unit; ?></td>    
                              <td><?php echo $p_detail->qty; ?></td>
                              <td><?php echo $p_detail->product_name; ?></td>
                              <td><?php echo $p_detail->unit_price; ?></td>
                              <td><?php echo $p_detail->discount; ?></td>
                              <td>
                                  <?php 
                                  $a = ($p_detail->qty * $p_detail->unit_price ); 
                                  if ($p_detail->discount > 0) 
                                  { 
                                    $b = ($a*$p_detail->discount)/100; $sum+= $a - $b;  echo $sub_total = $a - $b; 
                                  } 
                                  else 
                                  { 
                                    $sum+=$a;  echo $sub_total = $a; 
                                  }
                                  ?> 
                            </td>
                              <td>
                                  <?php 
                                       if($p_detail->flag == '1' && $order_summary->status == '3')
                                        {
                                            echo '<span class="badge badge-danger shadow-danger m-1">Cancel </span>';
                                            
                                        }elseif($p_detail->flag == '0' && $order_summary->status == '3' )
                                        {
                                          echo  '<span class="badge badge-success shadow-success m-1">Deliverd</span>';
                                          
                                        }elseif($order_summary->status == '0')
                                        {
                                            echo  '<span class="badge badge-warning shadow-warning m-1">Pending</span>';
                                        }elseif($p_detail->flag == '2' && $order_summary->status == '2' )
                                        {
                                          echo  '<span class="badge badge-info shadow-info m-1">Dispatch</span>';
                                          
                                        }
                                  ?>
                              </td>
                              
                            </tr>
                           <?php } ?>
                     
                    </tbody>
                    
                    
                </table>
                </div>
            
        		 
        		 <?php 
		        
            		    } 
                      } 
                     
                     ?>
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
					alert("Please select  product.");
					
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
		<h5 class="modal-title"><i class="fa fa-star"></i> Dispatch Product</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	   <form id="add_product" method="post" action="<?php echo base_url();?>sales/dispatch_order_data">
		  <div class="modal-body">

			 
			 <h3 style="font-size: 17px;">Are you sure dispatch this product from warehouse.</h3>

				<input type="hidden" class="form-control" name="multiple_id" id="multiple_id">
		
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
			<button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i>Submit</button>
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
