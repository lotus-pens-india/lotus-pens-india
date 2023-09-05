<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Monthly Pending Order</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Sales</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Monthly Pending Order Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Monthly Pending Order Data Tables</li>
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
            <div class="card-header"><i class="fa fa-table"></i> Monthly Pending order list <button type="button" class="btn btn-info send_all" style="float:right;margin-bottom:13px">Assign to</button></div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="brand-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Select</th>
                        <th>Order Code</th>
                        <th>No.of<br>products</th>
                        <th>Customer</th> 
                        <th>Amount</th>
                        <th>Deliver<br>Status</th>
                        <th>Payment<br>Status</th>
                        <th>Assign to</th>
                         <th>Saller</th>
                        <th>Option</th>
                    </tr>
                </thead>
                 <tbody>
                     <?php
					   if ($order_list != '')
						{
						$i = 1;
						foreach($order_list as $order_list)
						{
				     ?>
                     <tr>
                         <td><input type="checkbox" class="sub_chk" data-id="<?php echo $order_list->order_id ?>"></td>
                         <td><?php echo '#'.$order_list->order_generate_id; ?></td>
                         <td>
                             <?php 
                                $this->db->select('COUNT(order_id) AS no_of_product');
                        		$this->db->from('order_detail');
                        		$this->db->where('order_id',$order_list->order_id);
                        	    $query  = $this->db->get();
                                $result = $query->row();
                                echo $no_of_product = $result->no_of_product;
                             ?>
                         </td>
                         <td><?php echo $order_list->first_name.' '.$order_list->last_name ?></td>
                         <td><?php echo $order_list->order_total; ?></td>
                         <td>
                             <?php 
                                if($order_list->status == '0')
                                {
                                    echo '<span class="badge badge-danger shadow-danger m-1">Pending</span>';
                                    
                                }elseif($order_list->status == '1')
                                {
                                  echo '<span class="badge badge-success shadow-success m-1">Confirm</span>';
                                  
                                }elseif($order_list->status == '2')
                                {
                                    echo '<span class="badge badge-info shadow-info m-1">Dispatch</span>';
                                    
                                }elseif($order_list->status == '3')
                                
                                {
                                    echo  '<span class="badge badge-primary shadow-primary m-1">Delivered</span>';
                                }
                                elseif($order_list->status == '4')
                                
                                {
                                    echo '<span class="badge badge-danger shadow-danger m-1">Cancel</span><br> '.$post->cancel_resion;
                                }
                             ?>
                         </td>
                         <td>
                             <?php 
                               if($order_list->payment_status == '0')
                                {
                                    echo '<span class="badge badge-danger shadow-danger m-1">Unpaid</span>';
                                    
                                }elseif($order_list->payment_status == '1')
                                {
                                  echo '<span class="badge badge-success shadow-success m-1">Paid</span>';
                                  
                                }
                               
                             ?>
                         </td>
                         <td>
                             <?php 
                                 if($order_list->assign_to !='')
                                {
                                    $this->db->select('*');
                            		$this->db->from('delivery_boy');
                            		$this->db->where('db_id',$order_list->assign_to);
                            	    $query  = $this->db->get();
                                    $result = $query->row();
                                    $db_name = $result->name;
                                    
                                    echo $db_name;
                                }
                                else
                                {
                                    echo '';
                                    
                                }
                  
                             
                             ?>
                         </td>
                          <td><?php echo $order_list->franchise_name; ?></td>
                         <td>
                             <div class="btn-group m-1" role="group">
                              <button type="button" class="btn btn-dark   waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                              </button>
                              <div class="dropdown-menu">
                                <a href="<?php echo base_url();?>sales/assign_order?order_id=<?php echo $order_list->order_generate_id; ?>" class="dropdown-item" target="_blank"><i aria-hidden="true" class="fa fa-user"></i> Assign</a>
                                <a href="<?php echo base_url();?>sales/view_invoice?order_id=<?php echo $order_list->order_generate_id; ?>" class="dropdown-item" target="_blank"><i aria-hidden="true" class="fa fa-eye"></i> View</a>
                                <a href="<?php echo base_url();?>sales/invoice/<?php echo $order_list->order_generate_id; ?>" class="dropdown-item" target="_blank"><i aria-hidden="true" class="fa fa-file"></i> Download Invoice</a>
                              </div>
                            </div>
                         </td>
                     </tr>
                     <?php } }else { echo '';} ?>
                 </tbody>     
                
                
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
		<h5 class="modal-title"><i class="fa fa-star"></i> Assign to delivery boy</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	   <form id="add_banner" method="post" action="<?php echo base_url();?>sales/assign_order_data">
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
