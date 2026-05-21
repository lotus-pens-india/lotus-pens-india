<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Cancelled order Bill amount today</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Payment</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Cancelled order Bill amount today Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Cancelled order Bill amount today Data Tables</li>
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
            <div class="card-header"><i class="fa fa-table"></i> Cancelled order Bill amount today List 
            <?php $login_type   = $this->session->userdata('type');  if($login_type !='0') { ?>   
            <button type="button" class="btn btn-info send_all" style="float:right;margin-bottom:13px">Settle refund </button>
            <?php } ?>
            
            </div>
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
                        <th>Payment mode</th>
                        <th>Delivery Status</th>
                        <th>Refund Status</th>
                        <th>Saller</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
					   if ($online_payment != '')
						{
						$i = 1;
						foreach($online_payment as $post)
						{
				?> 
                    <tr>
                        <?php $login_type   = $this->session->userdata('type');  if($login_type !='0') { ?>  
                        <td><input type="checkbox" class="sub_chk" data-id="<?php echo $post->order_id; ?>"></td>
                        <?php } else { ?>
                        <td><?php echo $i++; ?></td>
                        <?php } ?>
                        <td><a href="<?php base_url('sales/view_invoice?order_id='.$post->order_generate_id) ?>"><?php echo '#'.$post->order_generate_id; ?></a></td>
                        <td>
                            <?php 
                                $this->db->select('COUNT(order_id) AS no_of_product');
                        		$this->db->from('order_detail');
                        		$this->db->where('order_id',$post->order_id);
                        	    $query  = $this->db->get();
                                $result = $query->row();
                                echo $no_of_product = $result->no_of_product;
                            ?>
                        </td>
                        <td><?php echo $post->first_name.' '.$post->last_name; ?></td>
                        <td><?php echo $post->order_total; ?></td>
                        <td>
                            <?php 
                               if($post->p_mode == '0')
                                {
                                    echo '<span class="badge badge-info shadow-info m-1">Cash</span>';
                                    
                                }
                                else{
                                  echo '<span class="badge badge-success shadow-success m-1">Online</span>';
                                  
                                }
                            ?>
                        </td>
                        <td>
                           <?php
                              if($post->status == '0')
                                {
                                    echo 'Pending';
                                    
                                }elseif($post->status == '1')
                                {
                                  echo  'Confirm';
                                  
                                }elseif($post->status == '2')
                                {
                                    echo 'Dispatch';
                                    
                                }elseif($post->status == '3')
                                
                                {
                                    echo  'Delivered';
                                }
                                elseif($post->status == '4')
                                
                                {
                                    echo 'Cancel';
                                }
                            ?>
                        </td>
                        <td>
                            <?php 
                               if($post->refund_status == '')
                                {

                                }
                                else
                                {
                                  echo '<span class="badge badge-success shadow-success m-1">Refunded</span>';
                                  
                                }
                            ?>
                        </td>
                        <td><?php echo $post->franchise_name; ?></td>
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
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	   <form id="add_banner" method="post" action="<?php echo base_url();?>sales/settle_refund_data">
		  <div class="modal-body">
		     	<div class="form-group">
			     <h5>Are sure Settle refund amount for this cancel order. </h5>
			 </div>

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

</script>
