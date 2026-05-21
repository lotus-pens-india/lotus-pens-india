<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Monthly Cancel Order</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Sales</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Monthly Cancel Order Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page"> Monthly Cancel Order Data Tables</li>
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
              <div class="card-header"><i class="fa fa-table"></i> Monthly Cancel Order List <button type="button" class="btn btn-info send_all" style="float:right;margin-bottom:13px">Settle refund </button></div>            <div class="card-body">
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
                        <th>Refund Status</th>
                        <th>Saller</th>
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
                         <td><input type="checkbox" class="sub_chk" data-id="<?php echo $order_list->order_id; ?>"></td>
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
                                    echo '<span class="badge badge-danger shadow-danger m-1">Cancel</span><br> '.$order_list->cancel_resion;
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
                                 if($order_list->refund_status == '')
                                    {
                                        echo '';
                
                                    }
                                    else
                                    {
                                      echo '<span class="badge badge-success shadow-success m-1">Refunded</span>';
                                      
                                    }
                             
                             ?>
                         </td>
                         <td><?php echo $order_list->franchise_name; ?></td>

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
  <div class="modal-dialog modal-lg">
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	   <form id="add_banner" method="post" action="<?php echo base_url();?>sales/settle_refund_data">
		  <div class="modal-body">
		     			     	    <section>
                       
						  
							 <div class="form-group row">
								 <label class="control-label col-sm-12"> <strong style="font-size:16px">Payment Option</strong></label>
								 </div>
								 <hr/>
							    <div class="form-group row">
								 <label for="horizontalFormPassword" class="col-sm-2 control-label"> Payment Mode</label>
								  <div class="col-sm-4">
								   <select  name="payment_mode" class="form-control single-select" tabindex="-1" onchange="admSelectCheck(this);" required>
										<option >Select Payment Mode</option> 
										<option id="Cash"  value="Cash">Cash</option>
										<option id="Cheque" value="Cheque">Cheque</option>
										<option id="Neft" value="Neft">Neft</option>
										<option id="IMPS" value="IMPS">IMPS</option>
									</select>
									<div class="form_error_msg payment_modeError"></div>
								  </div>
							   </div>
							   <div id="show_cash" style='display:none;'>
								 <div class="form-group row">
									<label for="horizontalFormEmail" class="col-sm-2 control-label">Amount  </label>
									<div class="col-sm-2">
										<input type="text" class="form-control" id="amount_cash" name="amount_cash" placeholder="Amount"  onKeyUp="inWords(this.value)" >
									</div>	
									<label for="horizontalFormEmail" class="col-sm-1 control-label">Pay Date  </label>
									<div class="col-sm-2">
						
												<input type="text" name="pay_date" id="default-datepicker" class="form-control" >
											
									</div>
									<label for="horizontalFormEmail" class="col-sm-1 control-label">In Word  </label>
									<div class="col-sm-3">
									<textarea type="text" class="form-control" id="amount_in_word" name="amount_in_word" placeholder="Amount In Word"></textarea>
									</div>
								   </div>
						        </div>
								
								 <div id="show_cheque" style='display:none;'>
									 <div class="form-group row">
										<label for="horizontalFormEmail" class="col-sm-2 control-label">Amount : </label>
										<div class="col-sm-2">
											<input type="text" class="form-control" id="amount1" name="cheque_amount" placeholder="Amount" onKeyUp="inWords1(this.value)" >
										</div>	
										<label for="horizontalFormEmail" class="col-sm-2 control-label">Cheque No : </label>
										<div class="col-sm-2">
											<input type="text" class="form-control" id="pay_for" name="cheque_no" placeholder="Cheque No" >
										</div>
										<label for="horizontalFormEmail" class="col-sm-2 control-label">Cheque Date : </label>
										<div class="col-sm-2">
									        <input type="text" name="Cheque_date" id="default-datepicker1" class="form-control" >
											
										</div>
									 </div>
									  <div class="form-group row">
										<label for="horizontalFormEmail" class="col-sm-2 control-label">Bank Name : </label>
										<div class="col-sm-2">
											<input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Bank Name" >
										</div>	
										<label for="horizontalFormEmail" class="col-sm-2 control-label">Branch : </label>
										<div class="col-sm-2">
											<input type="text" class="form-control" id="branch" name="branch" placeholder="Branch" >
										</div>
										<label for="horizontalFormEmail" class="col-sm-2 control-label">Pay Date : </label>
										<div class="col-sm-2">
										    
										    <input type="text" name="cheque_pay_date" id="default-datepicker2" class="form-control" >
											
										</div>
									 </div>
									 <div class="form-group row">
									  <label for="horizontalFormEmail" class="col-sm-2 control-label">In Word</label>
									  <div class="col-sm-4">
										<textarea type="text" class="form-control" id="amount_in_word1" name="cheque_amount_in_word" placeholder="Amount In Word" ></textarea>
									  </div>
									 </div>	
							
						        </div>
								

								
								<div id="show_neft" style='display:none;'>
								  <div class="form-group row">
										<label for="horizontalFormEmail" class="col-sm-2 control-label">Amount </label>
										<div class="col-sm-2">
											<input type="text" class="form-control" id="amount1" name="neft_amount" placeholder="Amount" onKeyUp="inWords3(this.value)" >
										</div>	
										<label for="horizontalFormEmail" class="col-sm-2 control-label">Transaction Id# </label>
										<div class="col-sm-2">
											<input type="text" class="form-control" id="neft_transaction_id" name="neft_transaction_id" placeholder="Transaction Id#" >
										</div>
										<label for="horizontalFormEmail" class="col-sm-2 control-label">Pay Date : </label>
										<div class="col-sm-2">
										    
										    <input type="text" name="neft_pay_date" id="default-datepicker3" class="form-control" >
										    
										
										</div>
										
									 </div>
									 <div class="form-group row">
									 <label for="horizontalFormEmail" class="col-sm-2 control-label">In Word</label>
										<div class="col-sm-3">
									    <textarea type="text" class="form-control" id="amount_in_word3" name="neft_amount_in_word" placeholder="Amount In Word" ></textarea>
											
										</div>
									 </div>
								</div>
								
								<div id="show_imps" style='display:none;'>
								  <div class="form-group row">
										<label for="horizontalFormEmail" class="col-sm-2 control-label">Amount </label>
										<div class="col-sm-2">
											<input type="text" class="form-control" id="amount1" name="imps_amount" placeholder="Amount" onKeyUp="inWords4(this.value)" >
										</div>	
										<label for="horizontalFormEmail" class="col-sm-2 control-label">Transaction Id# </label>
										<div class="col-sm-2">
											<input type="text" class="form-control" id="imps_transaction_id" name="imps_transaction_id" placeholder="Transaction Id#" >
										</div>
										<label for="horizontalFormEmail" class="col-sm-2 control-label">Pay Date : </label>
										<div class="col-sm-2">
										    
										    <input type="text" name="imps_pay_date" id="default-datepicker4" class="form-control" >
										    
											
											
										</div>
										
									 </div>
									 <div class="form-group row">
									 <label for="horizontalFormEmail" class="col-sm-2 control-label">In Word</label>
										<div class="col-sm-3">
									    <textarea type="text" class="form-control" id="amount_in_word4" name="imps_amount_in_word" placeholder="Amount In Word" ></textarea>
											
										</div>
									 </div>
								</div>
 
						   
                    </section>

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

<script>
function admSelectCheck(nameSelect)
{
    console.log(nameSelect);
    if(nameSelect){
        CashValue = document.getElementById("Cash").value;
        if(CashValue == nameSelect.value){
            document.getElementById("show_cash").style.display = "block";
        }
        else{
            document.getElementById("show_cash").style.display = "none";
        }
    }
    else{
        document.getElementById("show_cash").style.display = "none";
    }
	
	if(nameSelect){
	ChequeValue = document.getElementById("Cheque").value;
        if(ChequeValue == nameSelect.value){
            document.getElementById("show_cheque").style.display = "block";
        }
        else{
            document.getElementById("show_cheque").style.display = "none";
        }
    }
    else{
        document.getElementById("show_cheque").style.display = "none";
    }

	
	if(nameSelect){
	NeftValue = document.getElementById("Neft").value;
        if(NeftValue == nameSelect.value){
            document.getElementById("show_neft").style.display = "block";
        }
        else{
            document.getElementById("show_neft").style.display = "none";
        }
    }
    else{
        document.getElementById("show_neft").style.display = "none";
    }
	
	if(nameSelect){
	IMPSValue = document.getElementById("IMPS").value;
        if(IMPSValue == nameSelect.value){
            document.getElementById("show_imps").style.display = "block";
        }
        else{
            document.getElementById("show_imps").style.display = "none";
        }
    }
    else{
        document.getElementById("show_imps").style.display = "none";
    }
	

	
	
}

</script>
 <script>

var a = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ','eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
var b = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];

function inWords (num) {
	//alert(num);
    if ((num = num.toString()).length > 9) return 'overflow';
    n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
    if (!n) return; var str = '';
    str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
    str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
    str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
    str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
    str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'only ' : '';
    $('#amount_in_word').val(str);
	return str;
}
      
    </script>
	
<script>

var a = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ','eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
var b = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];

function inWords1 (num) {
	//alert(num);
    if ((num = num.toString()).length > 9) return 'overflow';
    n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
    if (!n) return; var str = '';
    str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
    str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
    str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
    str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
    str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'only ' : '';
    $('#amount_in_word1').val(str);
	return str;
}
      
    </script>
	
	<script>

var a = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ','eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
var b = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];

function inWords2 (num) {
	//alert(num);
    if ((num = num.toString()).length > 9) return 'overflow';
    n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
    if (!n) return; var str = '';
    str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
    str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
    str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
    str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
    str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'only ' : '';
    $('#amount_in_word2').val(str);
	return str;
}
      
    </script>
		<script>

var a = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ','eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
var b = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];

function inWords3 (num) {
	//alert(num);
    if ((num = num.toString()).length > 9) return 'overflow';
    n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
    if (!n) return; var str = '';
    str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
    str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
    str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
    str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
    str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'only ' : '';
    $('#amount_in_word3').val(str);
	return str;
}
      
    </script>
	<script>

var a = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ','eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
var b = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];

function inWords4 (num) {
	//alert(num);
    if ((num = num.toString()).length > 9) return 'overflow';
    n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
    if (!n) return; var str = '';
    str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
    str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
    str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
    str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
    str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'only ' : '';
    $('#amount_in_word4').val(str);
	return str;
}
      
    </script>
	<script>

var a = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ','eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
var b = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];

function inWords5 (num) {
	//alert(num);
    if ((num = num.toString()).length > 9) return 'overflow';
    n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
    if (!n) return; var str = '';
    str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
    str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
    str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
    str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
    str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'only ' : '';
    $('#amount_in_word5').val(str);
	return str;
}
      
    </script>
