<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Slot timing</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Product</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Slot timing Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Slot timing Data Tables</li>
         </ol>
	   </div>
	   <div class="col-sm-3">
       <div class="float-sm-right">
        <?php $login_type   = $this->session->userdata('type');  if($login_type !='0') { ?>   
         <button type="button" class="btn btn-primary waves-effect waves-light m-1" data-toggle="modal" data-target="#defaultsizemodal">Add Slot</button>
        <?php } ?> 
      </div>
     </div>
     </div>
    <!-- End Breadcrumb-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Slot List <button type="button" class="btn btn-info send_all" style="float:right;margin-bottom:13px">Active / Deactive Slot</button></div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="brand-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Timing</th>
                        <th>Day</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
					 <?php
						   if ($all_slot != '')
							{
							$i = 1;
							foreach($all_slot as $slot)
							{
					?>
                    <tr>
                        <td><input type="checkbox" class="sub_chk" data-id="<?php echo $slot->slot_id; ?>"></td>
                        <td><?php echo $slot->slot_timing ?></td>
                        <td><?php echo $slot->day ?></td>
                        <td><?php 
                        
                             if($slot->flag == 'Active')
                                {
                                    echo '<span class="badge badge-success shadow-success m-1">Active</span>';
                                    
                                }elseif($slot->flag == 'Deactive')
                                {
                                  echo '<span class="badge badge-danger shadow-danger m-1">Dective</span>';
                                  
                                }
                        ?></td>
                        
						<td>
						 <button type="button" class="btn btn-secondary waves-effect waves-light m-1" data-toggle="modal" data-target="#defaultsizemodal<?php echo $slot->slot_id ?>"> <i class="fa fa-edit"></i> </button>
						 <a style="cursor:pointer;"  class="tip-top delete delete one_<?php echo  $slot->slot_id; ?>" data-original-title="Delete" id="<?php echo $slot->slot_id; ?>"
						      Onclick="return ConfirmDelete(<?php echo $slot->slot_id ?>);">
						     <button type="button" class="btn btn-danger waves-effect waves-light m-1"> <i class="fa fa-trash-o"></i> </button>
						  </a> 
						</td>
                    </tr>
					<div class="modal fade" id="defaultsizemodal<?php echo $slot->slot_id ?>">
    						  <div class="modal-dialog">
    							<div class="modal-content">
    							  <div class="modal-header">
    								<h5 class="modal-title"><i class="fa fa-star"></i> Update Slot</h5>
    								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    								  <span aria-hidden="true">&times;</span>
    								</button>
    							  </div>
    							   <form id="update_slot<?php echo $slot->slot_id ?>" method="post" action="<?php echo base_url();?>product/update_slot_data">
    								  <div class="modal-body">
    									<div class="form-group">
    									  <label for="input-1">Time slot</label>
    										<input type="text" class="form-control" name="slot_timing" id="input-1" value="<?php echo $slot->slot_timing;?>">
    									  <div class="form_error_msg slot_timingError"></div>
    									 </div>
    							
    								  </div>
    								  <input type="hidden" value="<?php echo $slot->slot_id;?>" name="slot_id">
    								  <div class="modal-footer">
    									<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
    									<button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i>Update</button>
    								  </div>
    								  <div class="success_message"></div>
    								</form>  
    							</div>
    						  </div>
    						</div>
					<script type="text/javascript">
						$(function(){
							$('#update_slot<?php echo $slot->slot_id ?>').ajaxForm({
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
	
  <!-- Modal -->
<div class="modal fade" id="defaultsizemodal">
  <div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title"><i class="fa fa-star"></i> Add Slot</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	   <form id="add_slot" method="post" action="<?php echo base_url();?>product/add_slot_data">
		  <div class="modal-body">
		     
		     
		      <div class="form-group row mb-2">
                          
                   	<div class="col-12" id="docAttachDivVideo">
					   <table id="video_tbl" class="table table-hover table-bordered table-striped" >
							<thead>
							<tr>
								
								<td>Time slot</td>
								<td>Day</td>
								<td></td>
							</tr>
							</thead>
							<tbody>
							<tr>
								<td><input type="text" class="form-control" name="slot_timing[]" id="slot_timing1" placeholder="Ex: 08:00 AM TO 12:00 PM" required></td>
							    <td>
								        	<select name="day[]" id="day1" class="form-control" required> 
								        	      <option value="">Select</option>
								        	      <option value="Monday">Monday</option>
												  <option value="Tuesday">Tuesday</option>
												  <option value="Wednesday">Wednesday</option>
												  <option value="Thursday">Thursday</option>
												  <option value="Friday">Friday</option>
												  <option value="Saturday">Saturday</option>
												  <option value="Sunday">Sunday</option>
											</select>
    								    </td>
								<td>
									<input type="checkbox" name="chkboxvideo_tbl[]" id="chkboxvideo_tbl" onchange="removeDoc1('video_tbl')">
								</td>
							</tr>

							</tbody>
					    </table>

			         </div>

                        <div class="col-12">
                            <input type="hidden" name="photo_cnt" id="photo_cnt" value="0" />
                            <label class="label-control subHeads"><a href="javascript:addDocDetail1('video_tbl')" id="add_more" style="color:#000">Add more <i class="fa fa-plus"></i></a></label>
							
                        </div>
   
                </div>	
			
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
    function addDocDetail1(tableId)
    {
        var table =document.getElementById(tableId);
        var rowCount = table.rows.length;
        var row=table.insertRow(rowCount);
    	
    	
        var cell1=row.insertCell(0);
        var element1 = document.createElement('input');
        element1.type='text';
        element1.name='slot_timing[]';
        element1.className ='form-control';
        element1.placeholder='Ex: 08:00 AM TO 12:00 PM';
        element1.id='slot_timing'+  rowCount;
        cell1.appendChild(element1);


        var cell2=row.insertCell(1);
        var element3 = document.createElement('select');
        element3.options.add( new Option("Select","",  true) );        
        element3.options.add( new Option("Monday","Monday",  true) );
        element3.options.add( new Option("Tuesday","Tuesday",  true) );
        element3.options.add( new Option("Wednesday","Wednesday",  true) );
        element3.options.add( new Option("Thursday","Thursday",  true) );
        element3.options.add( new Option("Friday","Friday",  true) );
        element3.options.add( new Option("Saturday","Saturday",  true) );
        element3.options.add( new Option("Sunday","Sunday",  true) );
        element3.type='text';
        element3.name='day[]';
        element3.className ='form-control';
        element3.placeholder='Option 1';
        element3.id='day'+  rowCount;
        cell2.appendChild(element3);
        
        
        



    	
        var cell3=row.insertCell(2);
        var element4 = document.createElement("input");
        element4.type = "checkbox";
        element4.name='chkbox[]';
        //element5.setAttribute('class', 'fa fa-remove');
        element4.id='chkbox'+  rowCount;
        element4.onchange = function()
        {
            //alert(rowCount);
    
            removeDoc1(tableId);
        }
        cell3.appendChild(element4);
        hideDocDiv1(tableId);
    }
    
    function hideDocDiv1(tableId)
    {
        try{
            var table = document.getElementById(tableId);
            var rowCount = table.rows.length;
            var cnt = rowCount-1;
            if(rowCount==1)
                $("#docAttachDiv").hide();
            else
                $("#docAttachDiv").show();
        }catch(e){ alert(e); }
        $("#photo_cnt").val(cnt);
    }
    
    function removeDoc1(tableId)
    {
        //alert(tableId);
        try {
            var table = document.getElementById(tableId);
    
            var rowCount = table.rows.length;
            var cnt = rowCount-1;
            //alert(cnt);
            for(var i=0; i<rowCount; i++)
            {
                var row = table.rows[i];
                //alert(row);
                var chkbox = row.cells[2].childNodes[1];
                var chkbox1 = row.cells[2].childNodes[0];
                //alert(chkbox);
                if(null != chkbox && true == chkbox.checked || null != chkbox1 && true == chkbox1.checked) {
                    //alert('hi');
                    if(rowCount <= 1) {
                        alert("Cannot delete all the rows.");
                        break;
                    }
                    table.deleteRow(i);
                    rowCount--;
                    i--;
                }
            }                  
        }catch(e) { alert(e); }
    	
    }
    </script>
<script type="text/javascript">
	$(function(){
		$('#add_slot').ajaxForm({
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
	   url: "<?php echo base_url();?>product/delete_timeslot",
	   data: {'delete_id':id},
		   success : function(id) 
		   {
		   window.location = "<?php echo base_url();?>product/slot";
		  
		}
	});

}
return false;
}

</script>


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
					alert("Please select  slot.");
					
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
		<h5 class="modal-title"><i class="fa fa-star"></i> Active / Deactive Slot</h5>
		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>
	   <form id="add_banner" method="post" action="<?php echo base_url();?>product/active_sloct">
		  <div class="modal-body">
	
                 <div class="form-group">
			  <label for="input-1">Select Active/Deactive</label>
               <select class="form-control single-select"  name="flag" id="flag">
				  <option value="">Select </option>
				  <option value="Active">Active </option>
				  <option value="Deactive">Deactive </option>
				  
				  </select>
				<div class="form_error_msg flagError"></div>
			 </div>
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