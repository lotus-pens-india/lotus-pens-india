
<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Add Employee</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Master</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Add Employee</a></li>
         </ol>
	   </div>
	   <div class="col-sm-3">
       <div class="float-sm-right">
        <a href="<?php echo base_url();?>product/employee"> 
         <button type="button" class="btn btn-primary waves-effect waves-light m-1">Employee list</button>
        </a> 
      </div>
     </div>
     </div>
    <!-- End Breadcrumb-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-upload"></i> Add Employee</div>
            <div class="card-body">
			  <form id="add_product" method="post" action="<?php echo base_url();?>product/add_employee_data">
                <div id="wizard-vertical1">
                    
                    <section>
                        <div class="form-group row">
						  <div class="col-md-4">
                            <label>Employee Name *</label>
                            <input class="form-control" name="name" type="text" placeholder="Enter name">
							<div class="form_error_msg nameError"></div>
						  </div>
                          <div class="col-md-4">
						      <label> Mobile no *</label>
							  <input class="form-control" name="mobile_no" id="mobile_no" type="number" placeholder="Enter mobile" onchange="findandcheck1()">
							  <div class="form_error_msg mobile_noError"></div>
							  <label id="existmobile_no" style="color:red;font-size:12px;"></label>
                           </div>
						   <div class="col-md-4">
						    <label>Email id </label>
                            <input class="form-control" name="email_id" type="text" placeholder="Enter email">
						   </div>	
                        </div>
                        <div class="form-group row">
                            
							<div class="col-md-12">
							    <label>Address *</label>
								<textarea class="form-control" name="address" type="text" placeholder="Enter address"></textarea>
								<div class="form_error_msg addressError"></div>
							</div>
						</div>
                        <div class="form-group row">
                            
							<div class="col-md-4">
							    <label>Designation *</label>
								<select class="form-control single-select"  name="designation_id" id="designation_id">
    							  <option value="">Select Desgnation</option>
    							  <?php foreach($all_designation as $designation) { ?>
    								   <option value="<?php echo $designation->designation_id ?>"><?php echo $designation->designation ?></option>
    							  <?php } ?>
    							  </select>
								<div class="form_error_msg designation_idError"></div>
							</div>
							<div class="col-md-4">
							  <label>Username *</label>
                                <input type="text" class="form-control" name="username" id="username" placeholder="Enter username" onchange="findandcheck2()">
								<div class="form_error_msg usernameError"></div>
								<label id="existusername" style="color:red;font-size:12px;"></label>
							</div>
						
							<div class="col-md-4">
							  <label>Password *</label>
                                <input type="text" class="form-control" name="password" placeholder="Enter password">
								<div class="form_error_msg passwordError"></div>
							</div>

                        </div>
                        	

                    </section>

                    <hr>
                    <h4>Adminpanel Access</h4>
                    <hr>
                    <section>
                     <table class="table table-striped table-bordered table-hover table-checkable order-column" id="example4">
						<thead>
							<tr>
								<th width="7%"> Sr. No. </th>
								<th width="20%"> Name</th>
								<th> Access</th>
								
							</tr>
						</thead>
						<tbody>
							 <tr class="odd gradeX">
							  <td>1</td>
							  <td><label class="checkbox-inline">
								  <input type="checkbox" value="" id="select_all" > Setting
								</label></td>
							  <td>
								<label class="checkbox-inline">
								<input type="checkbox" value="1" name="d_master" class="checkbox">  Designation master
								</label>
								<label class="checkbox-inline">
								  <input type="checkbox" value="2" name="e_master" class="checkbox"> Employee master 
								</label>
								<label class="checkbox-inline">
								<input type="checkbox" value="3" name="z_master" class="checkbox"> Zone master
								</label>
								<label class="checkbox-inline">
								  <input type="checkbox" value="4" name="a_master" class="checkbox"> Area master 
								</label>
								<label class="checkbox-inline">
								  <input type="checkbox" value="5" name="banner" class="checkbox"> Banner 
								</label>
								<label class="checkbox-inline">
								  <input type="checkbox" value="6" name="brand" class="checkbox"> Brand 
								</label>
								<label class="checkbox-inline">
								  <input type="checkbox" value="7" name="category" class="checkbox"> Category  
								</label><br>
								<label class="checkbox-inline">
								  <input type="checkbox" value="8" name="subcategory" class="checkbox"> Subcategory  
								</label>
								<label class="checkbox-inline">
								  <input type="checkbox" value="9" name="sub_subcategory" class="checkbox"> Sub Subcategory  
								</label>
								<label class="checkbox-inline">
								  <input type="checkbox" value="10" name="slot" class="checkbox"> Slot Timing  
								</label>
								<label class="checkbox-inline">
								  <input type="checkbox" value="11" name="pickup" class="checkbox"> Pickup point  
								</label>
								<label class="checkbox-inline">
								  <input type="checkbox" value="12" name="pincode" class="checkbox"> Pincode  
								</label>
								<label class="checkbox-inline">
								  <input type="checkbox" value="13" name="coupon" class="checkbox"> Coupon  
								</label>
							
								<label class="checkbox-inline">
								  <input type="checkbox" value="14" name="minlimit" class="checkbox"> Set Min Limit  
								</label><br>
								<label class="checkbox-inline">
								  <input type="checkbox" value="15" name="olimit" class="checkbox"> Order Limit  
								</label>
								
							   </td>
							</tr>
							<tr class="odd gradeX">
							  <td>2</td>
							  <td><label class="checkbox-inline">
								  <input type="checkbox" value="" id="select_all1"> Product
								</label></td>
							  <td>
								<label class="checkbox-inline">
								<input type="checkbox" value="16" name="u_product" class="checkbox1" > Upload Product
								</label>
								<label class="checkbox-inline">
								  <input type="checkbox" value="17" name="l_product" class="checkbox1"> Product List 
								</label>
								<label class="checkbox-inline">
								<input type="checkbox" value="18" name="stock_update" class="checkbox1" > Bulk Stock Update
								</label>
								<label class="checkbox-inline">
								  <input type="checkbox" value="19" name="price_update" class="checkbox1"> Bulk Price Update 
								</label>
								
							   </td>
							 </tr>
							 <tr class="odd gradeX">
							  <td>3</td>
							  <td><label class="checkbox-inline">
								  <input type="checkbox" value="" id="select_all2"> Order
								</label></td>
							  <td>
								<label class="checkbox-inline">
								<input type="checkbox" value="20" name="manually" class="checkbox2"> Manually Order Entry
								</label>
									<label class="checkbox-inline">
								<input type="checkbox" value="21" name="t_order" class="checkbox2"> Today Order
								</label>
									<label class="checkbox-inline">
								<input type="checkbox" value="22" name="to_order" class="checkbox2"> Total Order
								</label>
									<label class="checkbox-inline">
								<input type="checkbox" value="23" name="p_order" class="checkbox2"> Pending Order
								</label>
									<label class="checkbox-inline">
								<input type="checkbox" value="24" name="i_order" class="checkbox2"> Item Wise Pending Order
								</label><br>
									<label class="checkbox-inline">
								<input type="checkbox" value="25" name="a_order" class="checkbox2"> Assign Order
								</label>
									<label class="checkbox-inline">
								<input type="checkbox" value="26" name="a_n_order" class="checkbox2"> Assign but not deliverd
								</label>
								<label class="checkbox-inline">
								<input type="checkbox" value="23" name="dis_order" class="checkbox2"> Dispatch Order
								</label>
									<label class="checkbox-inline">
								<input type="checkbox" value="27" name="d_order" class="checkbox2"> Dlivered Order
								</label>
									<label class="checkbox-inline">
								<input type="checkbox" value="28" name="c_order" class="checkbox2"> Cancel Order (Paid)
								</label><br>
									<label class="checkbox-inline">
								<input type="checkbox" value="29" name="cc_order" class="checkbox2"> Cancel Order (Unpaid)
								</label><br>
								<label class="checkbox-inline">
								<input type="checkbox" value="30" name="r_order" class="checkbox2"> Return product
								</label>
								
							   </td>
							 </tr>
							 <tr class="odd gradeX">
							  <td>4</td>
							  <td><label class="checkbox-inline">
								  <input type="checkbox" value="" id="select_all3"> Subscription
								</label></td>
							  <td>
								<label class="checkbox-inline">
								<input type="checkbox" value="31" name="t_subscribe" class="checkbox3"> Today Subscription Order
								</label>
							
								<label class="checkbox-inline">
								<input type="checkbox" value="32" name="n_subscribe" class="checkbox3"> New Subscription
								</label>
						
								<label class="checkbox-inline">
								<input type="checkbox" value="33" name="to_subscribe" class="checkbox3"> Total Subscription
								</label>
								<label class="checkbox-inline">
								<input type="checkbox" value="34" name="a_subscribe" class="checkbox3"> Active Subscription
								</label>
							<br>
								<label class="checkbox-inline">
								<input type="checkbox" value="35" name="p_subscribe" class="checkbox3"> Pause Subscription
								</label>
						        
								<label class="checkbox-inline">
								<input type="checkbox" value="36" name="en_subscribe" class="checkbox3"> End Subscription
								</label>
								<label class="checkbox-inline">
								<input type="checkbox" value="37" name="e_subscribe" class="checkbox3"> Expire Subscription
								</label>
								</td>
							 </tr>
							  <tr class="odd gradeX">
								  <td>5</td>
								  <td><label class="checkbox-inline">
									  <input type="checkbox" value="" id="select_all4"> Customer / Delivery boy
									</label></td>
								  <td>
							
									 <label class="checkbox-inline">
									  <input type="checkbox" value="38" name="customer" class="checkbox4"> Customer
									</label>
								
								
									 <label class="checkbox-inline">
									  <input type="checkbox" value="39" name="deliver_list" class="checkbox4"> Delivery boy List
									</label>
									
									<label class="checkbox-inline">
									  <input type="checkbox" value="40" name="delivery_recevied_p" class="checkbox4"> Received payment list
									</label>
									
								
								
								   </td>
								 </tr> 
							
								 <tr class="odd gradeX">
								  <td>6</td>
								  <td><label class="checkbox-inline">
									  <input type="checkbox" value="" id="select_all5"> Payment Details
									</label></td>
								  <td>
									
									<label class="checkbox-inline">
									  <input type="checkbox" value="41" name="t_payment" class="checkbox5"> Total Payment
									</label>
									<label class="checkbox-inline">
									  <input type="checkbox" value="42" name="c_payment" class="checkbox5"> Cash Payment
									</label>
									<label class="checkbox-inline">
									  <input type="checkbox" value="43" name="o_payment" class="checkbox5"> Online Payment
									</label>
									<label class="checkbox-inline">
									  <input type="checkbox" value="44" name="r_payment" class="checkbox5"> Refund Payment
									</label>
									
									
								   </td>
								 </tr>
								 
								 
								 <tr class="odd gradeX">
								  <td>7</td>
								  <td><label class="checkbox-inline">
									  <input type="checkbox" value="" id="select_all6"> Report
									</label></td>
								  <td>
									
									<label class="checkbox-inline">
									  <input type="checkbox" value="45" name="s_report" class="checkbox6"> Sales Report
									</label>
									
									<label class="checkbox-inline">
									  <input type="checkbox" value="46" name="p_report" class="checkbox6"> Product Wise Report
									</label>
									
								
								   </td>
								 </tr>
								 
								 
								 <tr class="odd gradeX">
								  <td>8</td>
								  <td><label class="checkbox-inline">
									  <input type="checkbox" value="" id="select_all7"> Bulk SMS
									</label></td>
								  <td>
									<label class="checkbox-inline">
									  <input type="checkbox" value="47" name="sms_customer" class="checkbox7"> Customer
									</label>
									<label class="checkbox-inline">
									  <input type="checkbox" value="48" name="sms_db" class="checkbox7"> Delivery boy
									</label>
									
									
								   </td>
								 </tr>
								 
								  <tr class="odd gradeX">
								  <td>9</td>
								  <td><label class="checkbox-inline">
									  <input type="checkbox" value="" id="select_all8"> Warehouse
									</label></td>
								  <td>
									<label class="checkbox-inline">
									  <input type="checkbox" value="47" name="warehouse" class="checkbox8"> Warehouse
									</label>
								
									
								   </td>
								 </tr>
								 
								  <tr class="odd gradeX">
								  <td>9</td>
								  <td><label class="checkbox-inline">
									  <input type="checkbox" value="" id="select_all9"> Purchse
									</label></td>
								  <td>
									<label class="checkbox-inline">
									  <input type="checkbox" value="47" name="supplier" class="checkbox9"> Supplier
									</label>
										<label class="checkbox-inline">
									  <input type="checkbox" value="47" name="purchse_entry" class="checkbox9"> Purchse Entry
									</label>
										<label class="checkbox-inline">
									  <input type="checkbox" value="47" name="purchse_list" class="checkbox9">  Purchse List
									</label>
										<label class="checkbox-inline">
									  <input type="checkbox" value="47" name="stock_list" class="checkbox9"> Stock
									</label>
								
									
								   </td>
								 </tr>
					
								 
						</tbody>
					 </table>
                    </section>
                    <br>

                    <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i>Add</button>
                </div> <!-- End #wizard-vertical -->
				<br>
				<div class="success_message"></div>
				</form>
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
	
function findandcheck1()
{
	$("#existmobile_no").val('');
	var mobile_no=document.getElementById('mobile_no').value;
   // alert(mobile_no);
	var scriptUrl1="<?php echo base_url();?>product/verify_emp_mobile?mobile_no="+mobile_no;
//	alert(scriptUrl1);
	$.ajax({url:scriptUrl1,success: function(res1)
	{
		//	alert(res1);
			if(res1==1)
          {
          	$("#mobile_no").focus();
          	$('#existmobile_no').html(mobile_no + '  already exist,try another number');
          	$("#mobile_no").val('');
          }
          else
          {
          	$("#existmobile_no").html('');
          }
                      
			
	}});
}



function findandcheck2()
{
	$("#existusername").val('');
	var username=document.getElementById('username').value;
   // alert(mobile_no);
	var scriptUrl1="<?php echo base_url();?>product/verify_emp_username?username="+username;
//	alert(scriptUrl1);
	$.ajax({url:scriptUrl1,success: function(res1)
	{
		//	alert(res1);
			if(res1==1)
          {
          	$("#username").focus();
          	$('#existusername').html(username + '  already exist,try another username');
          	$("#username").val('');
          }
          else
          {
          	$("#existusername").html('');
          }
                      
			
	}});
}

</script>
<script type="text/javascript">
	$("#select_all").change(function(){  //"select all" change 
    var status = this.checked; // "select all" checked status
    $('.checkbox').each(function(){ //iterate all listed checkbox items
        this.checked = status; //change ".checkbox" checked status
    });
});

$('.checkbox').change(function(){ //".checkbox" change 
    //uncheck "select all", if one of the listed checkbox item is unchecked
    if(this.checked == false){ //if this item is unchecked
        $("#select_all")[0].checked = false; //change "select all" checked status to false
    }
    
    //check "select all" if all checkbox items are checked
    if ($('.checkbox:checked').length == $('.checkbox').length ){ 
        $("#select_all")[0].checked = true; //change "select all" checked status to true
    }
});
		
</script>
<script type="text/javascript">
	$("#select_all1").change(function(){  //"select all" change 
    var status = this.checked; // "select all" checked status
    $('.checkbox1').each(function(){ //iterate all listed checkbox items
        this.checked = status; //change ".checkbox" checked status
    });
});

$('.checkbox1').change(function(){ //".checkbox" change 
    //uncheck "select all", if one of the listed checkbox item is unchecked
    if(this.checked == false){ //if this item is unchecked
        $("#select_all1")[0].checked = false; //change "select all" checked status to false
    }
    
    //check "select all" if all checkbox items are checked
    if ($('.checkbox1:checked').length == $('.checkbox1').length ){ 
        $("#select_all1")[0].checked = true; //change "select all" checked status to true
    }
});
		
</script>  
<script type="text/javascript">
	$("#select_all2").change(function(){  //"select all" change 
    var status = this.checked; // "select all" checked status
    $('.checkbox2').each(function(){ //iterate all listed checkbox items
        this.checked = status; //change ".checkbox" checked status
    });
});

$('.checkbox2').change(function(){ //".checkbox" change 
    //uncheck "select all", if one of the listed checkbox item is unchecked
    if(this.checked == false){ //if this item is unchecked
        $("#select_all2")[0].checked = false; //change "select all" checked status to false
    }
    
    //check "select all" if all checkbox items are checked
    if ($('.checkbox2:checked').length == $('.checkbox2').length ){ 
        $("#select_all2")[0].checked = true; //change "select all" checked status to true
    }
});
		
</script>
<script type="text/javascript">
	$("#select_all3").change(function(){  //"select all" change 
    var status = this.checked; // "select all" checked status
    $('.checkbox3').each(function(){ //iterate all listed checkbox items
        this.checked = status; //change ".checkbox" checked status
    });
});

$('.checkbox3').change(function(){ //".checkbox" change 
    //uncheck "select all", if one of the listed checkbox item is unchecked
    if(this.checked == false){ //if this item is unchecked
        $("#select_all3")[0].checked = false; //change "select all" checked status to false
    }
    
    //check "select all" if all checkbox items are checked
    if ($('.checkbox3:checked').length == $('.checkbox3').length ){ 
        $("#select_all3")[0].checked = true; //change "select all" checked status to true
    }
});
		
</script>
<script type="text/javascript">
	$("#select_all4").change(function(){  //"select all" change 
    var status = this.checked; // "select all" checked status
    $('.checkbox4').each(function(){ //iterate all listed checkbox items
        this.checked = status; //change ".checkbox" checked status
    });
});

$('.checkbox4').change(function(){ //".checkbox" change 
    //uncheck "select all", if one of the listed checkbox item is unchecked
    if(this.checked == false){ //if this item is unchecked
        $("#select_all4")[0].checked = false; //change "select all" checked status to false
    }
    
    //check "select all" if all checkbox items are checked
    if ($('.checkbox4:checked').length == $('.checkbox4').length ){ 
        $("#select_all4")[0].checked = true; //change "select all" checked status to true
    }
});
		
</script>
<script type="text/javascript">
	$("#select_all5").change(function(){  //"select all" change 
    var status = this.checked; // "select all" checked status
    $('.checkbox5').each(function(){ //iterate all listed checkbox items
        this.checked = status; //change ".checkbox" checked status
    });
});

$('.checkbox5').change(function(){ //".checkbox" change 
    //uncheck "select all", if one of the listed checkbox item is unchecked
    if(this.checked == false){ //if this item is unchecked
        $("#select_all5")[0].checked = false; //change "select all" checked status to false
    }
    
    //check "select all" if all checkbox items are checked
    if ($('.checkbox5:checked').length == $('.checkbox5').length ){ 
        $("#select_all5")[0].checked = true; //change "select all" checked status to true
    }
});
		
</script>
<script type="text/javascript">
	$("#select_all6").change(function(){  //"select all" change 
    var status = this.checked; // "select all" checked status
    $('.checkbox6').each(function(){ //iterate all listed checkbox items
        this.checked = status; //change ".checkbox" checked status
    });
});

$('.checkbox6').change(function(){ //".checkbox" change 
    //uncheck "select all", if one of the listed checkbox item is unchecked
    if(this.checked == false){ //if this item is unchecked
        $("#select_all6")[0].checked = false; //change "select all" checked status to false
    }
    
    //check "select all" if all checkbox items are checked
    if ($('.checkbox6:checked').length == $('.checkbox6').length ){ 
        $("#select_all6")[0].checked = true; //change "select all" checked status to true
    }
});
		
</script>
<script type="text/javascript">
	$("#select_all7").change(function(){  //"select all" change 
    var status = this.checked; // "select all" checked status
    $('.checkbox7').each(function(){ //iterate all listed checkbox items
        this.checked = status; //change ".checkbox" checked status
    });
});

$('.checkbox7').change(function(){ //".checkbox" change 
    //uncheck "select all", if one of the listed checkbox item is unchecked
    if(this.checked == false){ //if this item is unchecked
        $("#select_all7")[0].checked = false; //change "select all" checked status to false
    }
    
    //check "select all" if all checkbox items are checked
    if ($('.checkbox7:checked').length == $('.checkbox7').length ){ 
        $("#select_all7")[0].checked = true; //change "select all" checked status to true
    }
});
		
</script>
<script type="text/javascript">
	$("#select_all8").change(function(){  //"select all" change 
    var status = this.checked; // "select all" checked status
    $('.checkbox8').each(function(){ //iterate all listed checkbox items
        this.checked = status; //change ".checkbox" checked status
    });
});

$('.checkbox8').change(function(){ //".checkbox" change 
    //uncheck "select all", if one of the listed checkbox item is unchecked
    if(this.checked == false){ //if this item is unchecked
        $("#select_all8")[0].checked = false; //change "select all" checked status to false
    }
    
    //check "select all" if all checkbox items are checked
    if ($('.checkbox8:checked').length == $('.checkbox8').length ){ 
        $("#select_all8")[0].checked = true; //change "select all" checked status to true
    }
});
		
</script>
<script type="text/javascript">
	$("#select_all9").change(function(){  //"select all" change 
    var status = this.checked; // "select all" checked status
    $('.checkbox9').each(function(){ //iterate all listed checkbox items
        this.checked = status; //change ".checkbox" checked status
    });
});

$('.checkbox9').change(function(){ //".checkbox" change 
    //uncheck "select all", if one of the listed checkbox item is unchecked
    if(this.checked == false){ //if this item is unchecked
        $("#select_all9")[0].checked = false; //change "select all" checked status to false
    }
    
    //check "select all" if all checkbox items are checked
    if ($('.checkbox9:checked').length == $('.checkbox9').length ){ 
        $("#select_all9")[0].checked = true; //change "select all" checked status to true
    }
});
		
</script>
<script type="text/javascript">
	$("#select_all10").change(function(){  //"select all" change 
    var status = this.checked; // "select all" checked status
    $('.checkbox10').each(function(){ //iterate all listed checkbox items
        this.checked = status; //change ".checkbox" checked status
    });
});

$('.checkbox10').change(function(){ //".checkbox" change 
    //uncheck "select all", if one of the listed checkbox item is unchecked
    if(this.checked == false){ //if this item is unchecked
        $("#select_all10")[0].checked = false; //change "select all" checked status to false
    }
    
    //check "select all" if all checkbox items are checked
    if ($('.checkbox10:checked').length == $('.checkbox10').length ){ 
        $("#select_all10")[0].checked = true; //change "select all" checked status to true
    }
});
		
</script>
<script type="text/javascript">
	$("#select_all11").change(function(){  //"select all" change 
    var status = this.checked; // "select all" checked status
    $('.checkbox11').each(function(){ //iterate all listed checkbox items
        this.checked = status; //change ".checkbox" checked status
    });
});

$('.checkbox11').change(function(){ //".checkbox" change 
    //uncheck "select all", if one of the listed checkbox item is unchecked
    if(this.checked == false){ //if this item is unchecked
        $("#select_all11")[0].checked = false; //change "select all" checked status to false
    }
    
    //check "select all" if all checkbox items are checked
    if ($('.checkbox11:checked').length == $('.checkbox11').length ){ 
        $("#select_all11")[0].checked = true; //change "select all" checked status to true
    }
});
		
</script>
<script type="text/javascript">
	$("#select_all12").change(function(){  //"select all" change 
    var status = this.checked; // "select all" checked status
    $('.checkbox12').each(function(){ //iterate all listed checkbox items
        this.checked = status; //change ".checkbox" checked status
    });
});

$('.checkbox12').change(function(){ //".checkbox" change 
    //uncheck "select all", if one of the listed checkbox item is unchecked
    if(this.checked == false){ //if this item is unchecked
        $("#select_all12")[0].checked = false; //change "select all" checked status to false
    }
    
    //check "select all" if all checkbox items are checked
    if ($('.checkbox12:checked').length == $('.checkbox12').length ){ 
        $("#select_all12")[0].checked = true; //change "select all" checked status to true
    }
});
		
</script>
