<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Delivery Boy</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Delivery Boy</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Delivery Boy Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Delivery Boy Data Tables</li>
         </ol>
	   </div>
	   <div class="col-sm-3">
       <div class="float-sm-right">
         <?php $login_type   = $this->session->userdata('type');  if($login_type !='0') { ?>   
        <button type="button" class="btn btn-primary waves-effect waves-light m-1" data-toggle="modal" data-target="#primarymodal">Add Delivery Boy</button>
        <?php } ?> 
      </div>
     </div>
     </div>
    <!-- End Breadcrumb-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Delivery Boy List</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="saller_datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Name</th>
                        <th>Mobile No</th>
                        <th>Assign Pincode</th>
                        <th>Document</th>
                        <th>Collect Amount</th>
                        <th>Saller</th>
                        <?php $login_type   = $this->session->userdata('type');if($login_type != '0') { ?>
                        <th>Action</th>
                    <?php } ?>    
                    </tr>
                </thead>
                
                <tbody>
					 <?php
						   if ($all_delivery_boy != '')
							{
							$i = 1;
							foreach($all_delivery_boy as $delivery_boy)
							{
					?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $delivery_boy->name ?></td>
						<td><?php echo $delivery_boy->mobile_no ?></td>
						<td>
						    <?php 
						    $CI =& get_instance();
                            $CI->load->model('Customer_model');
                            $result = $CI->Customer_model->get_db_wise_area($delivery_boy->db_id);
                            $i=1;
                            foreach($result as $pincode)
				            {
						      echo $i++.') '.$pincode->pincode.'<BR>';
						    ?>
						   
						    <?php } ?>
						</td>
						 <td>
						<?php if($delivery_boy->aadhaar_card == '') { ?>
						    <a href="https://via.placeholder.com/1500x1000" data-fancybox="images" data-caption="This image has a caption" >
							  <img src="https://via.placeholder.com/240x160" alt="lightbox" class="lightbox-thumb img-thumbnail" style="width:100px">
							</a>
						<?php } else { ?>
						    <a href="<?php echo base_url('assets/images/deliverboy/'.$delivery_boy->aadhaar_card);?>" data-fancybox="images" data-caption="This image has a caption">
							  <img src="<?php echo base_url('assets/images/deliverboy/'.$delivery_boy->aadhaar_card);?>" alt="lightbox" class="lightbox-thumb img-thumbnail" style="width: 100px;">
							</a>
						<?php } ?>						
						</td>
						
				        <td><?php echo $delivery_boy->wallet ?></td>
				        <td><?php echo $delivery_boy->franchise_name ?></td>
				        <?php $login_type   = $this->session->userdata('type');if($login_type != '0') { ?>
						<td>
						    
						 <div class="btn-group m-1" role="group">
                              <button type="button" class="btn btn-dark  waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                              </button>
                              <div class="dropdown-menu">
                             
                                <a href="javaScript:void();" class="dropdown-item" data-toggle="modal" data-target="#primarymodal<?php echo $delivery_boy->db_id ?>"><i aria-hidden="true" class="fa fa-edit"></i> Edit</a>
                                <a href="javaScript:void();" class="dropdown-item tip-top delete delete one_<?php echo  $delivery_boy->db_id ; ?>" data-original-title="Delete" id="<?php echo $delivery_boy->db_id ; ?>"  Onclick="return ConfirmDelete(<?php echo $delivery_boy->db_id  ?>);">
                                    <i aria-hidden="true" class="fa fa-trash"></i> Delete
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="<?php echo base_url();?>customer/make_payment_db?db_id=<?php echo $delivery_boy->db_id  ?>" class="dropdown-item "><i aria-hidden="true" class="fa fa-credit-card"></i> Received payment</a>
                              </div>
                            </div>
 
						</td>
						<?php } ?>
                    </tr>
                        <div class="modal fade" id="primarymodal<?php echo $delivery_boy->db_id ?>">
                          <div class="modal-dialog">
                            <div class="modal-content border-primary">
                              <div class="modal-header bg-primary">
                                <h5 class="modal-title text-white"><i class="fa fa-star"></i>Update Delivery Boy</h5>
                                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <form id="update_saller<?php echo $delivery_boy->db_id ?>" method="post" action="<?php echo base_url();?>customer/update_deliver_boy_data" enctype="multipart/form-data">
                              <div class="modal-body">
                                <div class="form-group">
                    			  <label for="input-1">Name</label>
                    				<input type="text" class="form-control" name="name" id="input-1" placeholder="Enter Name" value="<?php echo $delivery_boy->name;?>">
                    			  <div class="form_error_msg nameError"></div>
                    			 </div>
                    			  <div class="form-group">
                    			  <label for="input-1">Mobile No</label>
                    				<input type="text" class="form-control" name="mobile_no" id="input-1" placeholder="Enter Mobile No" value="<?php echo $delivery_boy->mobile_no;?>">
                    			  <div class="form_error_msg mobile_noError"></div>
                    			 </div>
                    			 
                    			 <div class="form-group">
                    			  <label for="input-1">Address</label>
                    				<textarea type="text" class="form-control" name="address" id="input-1" placeholder="Enter Address"><?php echo $delivery_boy->address;?></textarea>
                    			  <div class="form_error_msg addressError"></div>
                    			 </div>
                    			  <div class="form-group">
									  <label for="input-1">Aadhaar Card</label>
										<input type="file" class="form-control" name="aadhaar_card" id="input-1">
										<?php if($delivery_boy->aadhaar_card != '') { ?>
										  <img src="<?php echo base_url()?>assets/images/deliverboy/<?php echo $delivery_boy->aadhaar_card; ?>" class="images" style="width: 100px;height: 100px;">
										<?php } else { ?>
										  <img src="https://via.placeholder.com/1500x1000" class="images" style="width: 100px;height: 100px;">
										<?php } ?>										
										 <input type="hidden"  class="form-control" name="aadhaar_card_old" value="<?php echo $delivery_boy->aadhaar_card; ?>">
									  <div class="form_error_msg aadhaar_cardError"></div>
									 </div>
				
			                         <select class="form-control multiple-select" name="pincode[]" multiple="multiple" required>
                    				     <option value="">Select Pincode</option>
                    					 <?php foreach($all_pincode as $pincode) { ?>
                    						  <option value="<?php echo $pincode->pincode ?>"><?php echo $pincode->pincode ?></option>
                    					 <?php } ?>
                    					  
                    				  </select>
                    			 <input type="hidden" value="<?php echo $delivery_boy->db_id;?>" name="db_id">
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-inverse-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                                <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Update</button>
                              </div>
                              <div class="success_message"></div>
                              </form>
                            </div>
                          </div>
                         <script type="text/javascript">
						$(function(){
							$('#update_saller<?php echo $delivery_boy->db_id ?>').ajaxForm({
								beforeSend : function(){
									$('.form_error_msg').html('');
									$('.success_message').html('<div class="alert alert-outline-warning alert-dismissible alert-round" role="alert"><button type="button" class="close" data-dismiss="alert">×</button><div class="alert-icon"> <i class="icon-exclamation"></i> </div><div class="alert-message"><span><strong>Data update!</strong> please wait.. <a href="javascript:void();" class="alert-link"></a></span></div></div>');
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
    
    <div class="modal fade" id="primarymodal">
      <div class="modal-dialog">
        <div class="modal-content border-primary">
          <div class="modal-header bg-primary">
            <h5 class="modal-title text-white"><i class="fa fa-star"></i>Add Delivery Boy</h5>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form id="add_delivery_boy" method="post" action="<?php echo base_url();?>customer/add_delivery_boy_data" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="form-group">
			  <label for="input-1">Name</label>
				<input type="text" class="form-control" name="name" id="input-1" placeholder="Enter Name">
			  <div class="form_error_msg nameError"></div>
			 </div>
			  <div class="form-group">
			  <label for="input-1">Mobile No</label>
				<input type="text" class="form-control" id="mobile_no" name="mobile_no" id="input-1" placeholder="Enter Mobile No" onchange="findandcheck1()">
			  <div class="form_error_msg mobile_noError"></div>
			  <label id="existmobile_no" style="color:red;font-size:12px;"></label>
			 </div>
			
			 <div class="form-group">
			  <label for="input-1">Address</label>
				<textarea type="text" class="form-control" name="address" id="input-1" placeholder="Enter Address"></textarea>
			  <div class="form_error_msg addressError"></div>
			 </div>
			 <div class="form-group">
			  <label for="input-1">Password</label>
				<input type="text" class="form-control" name="password" id="input-1" placeholder="Enter Password">
			  <div class="form_error_msg passwordError"></div>
			 </div>
			 <div class="form-group">
			  <label for="input-1">AADHAAR CARD</label>
				<input type="file" class="form-control" name="aadhaar_card" id="input-1" >
			  <div class="form_error_msg aadhaar_cardError"></div>
			 </div>
			 
			 
			 
			 <div class="form-group">
				<label class="form-label" for="exampleInputEmail1">Assign Pincode</label>
				<select class="form-control multiple-select" name="pincode[]" multiple="multiple" required id="pincode">
				     <option value="">Select Pincode</option>
					 <?php foreach($all_pincode as $pincode) { ?>
						  <option value="<?php echo $pincode->pincode ?>"><?php echo $pincode->pincode ?></option>
					 <?php } ?>
					  
				  </select>
			 </div>
			 
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-inverse-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Add</button>
          </div>
          <div class="success_message"></div>
          </form>
        </div>
      </div>
                </div><!--End Modal -->




<script type="text/javascript">
	$(function(){
		$('#add_delivery_boy').ajaxForm({
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
<script type="text/javascript">
function ConfirmDelete(id)
{
if(confirm("Are you sure you want to delete this Record?"))
{
	$(".message").html("");
	
	$.ajax({
	   type: "POST",
	   url: "<?php echo base_url();?>customer/delete_delivery_boy",
	   data: {'delete_id':id},
		   success : function(id) {
		   var idd = "a.one_"+id+":parent";
		   $(idd).parents('tr').hide();
		  
		}
	});

}
return false;
}

</script>

<script>

$(document).on('change','#zone_id',function () {
  $('#area_id').empty();
	if($(this).val() != 'none')
	{
		var id = $(this).val();
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url();?>product/all_area_by_zone_id',
			data: { id: id },
			dataType: 'json',
			success: function( json ) {
				$('#area_id').append($('<option>').text("Select"));
				$.each(json, function(key, value) {
					$('#area_id')
						.append($("<option></option>")
							.attr("value",value.area_id)
							.text(value.area_name));
				});
			}
		})
	}
	else
	{
		$("#area_id").empty();
	}
});



$(document).on('change','#zone_id1',function () {
  $('#area_id1').empty();
	if($(this).val() != 'none')
	{
		var id = $(this).val();
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url();?>product/all_area_by_zone_id',
			data: { id: id },
			dataType: 'json',
			success: function( json ) {
				$('#area_id1').append($('<option>').text("Select"));
				$.each(json, function(key, value) {
					$('#area_id1')
						.append($("<option></option>")
							.attr("value",value.area_id)
							.text(value.area_name));
				});
			}
		})
	}
	else
	{
		$("#area_id1").empty();
	}
});


function findandcheck1()
{
	$("#existmobile_no").val('');
	var mobile_no=document.getElementById('mobile_no').value;
   // alert(mobile_no);
	var scriptUrl1="<?php echo base_url();?>customer/verify_db_mobile?mobile_no="+mobile_no;
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
</script>