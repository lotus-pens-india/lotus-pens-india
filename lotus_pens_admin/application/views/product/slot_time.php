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
            <div class="card-header"><i class="fa fa-table"></i> Slot List</div>
            <div class="card-body">
             <div class="form-group row">    
              <div class="col-md-4">
                  <h4>Monday</h4>
                  
                  <?php 
      				 $CI =& get_instance();
                     $CI->load->model('Product_model');
                     $mon_result = $CI->product_model->monday_time_slot();
                     
                     //print_r($tue_result);
                     if(!empty($mon_result))
                     {
                         foreach ($mon_result as $mon) 
                        {
                            echo $time_slot = $mon->slot_timing.' '.'<a data-toggle="modal" data-target="#defaultsizemodal'.$mon->slot_id.'" style="margin-left:10px">
			                      <i class="fa fa-edit"></i>
			                     </a>'.'<a data-original-title="Delete" id="'.$mon->slot_id.'" Onclick="return ConfirmDelete('.$mon->slot_id.');"> <i aria-hidden="true" class="fa fa-trash"></i>  </a>'.'<BR>';
			                   
			              ?>
			              
			              
			              					  <!-- Modal -->
						<div class="modal fade" id="defaultsizemodal<?php echo $mon->slot_id ?>">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title"><i class="fa fa-star"></i> Update Slot</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							   <form id="update_slot<?php echo $mon->slot_id ?>" method="post" action="<?php echo base_url();?>product/update_slot_data">
								  <div class="modal-body">
									<div class="form-group">
									  <label for="input-1">Time slot</label>
										<input type="text" class="form-control" name="slot_timing" id="input-1" value="<?php echo $mon->slot_timing;?>">
									  <div class="form_error_msg slot_timingError"></div>
									 </div>
							
								  </div>
								  <input type="hidden" value="<?php echo $mon->slot_id;?>" name="slot_id">
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
							$('#update_slot<?php echo $mon->slot_id ?>').ajaxForm({
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
			        <?php
			                   
			                   
			                   
                        }
                     } 
                     else
                     {
                         echo '<p>No slot found.</p>';
                     }
                 
                 ?>

              </div>
               <div class="col-md-4">
                  <h4>Tuesday</h4>
                  
                  <?php 
      				 $CI =& get_instance();
                     $CI->load->model('Product_model');
                     $tue_result = $CI->product_model->tuesday_time_slot();
                     
                     //print_r($tue_result);
                     if(!empty($tue_result))
                     {
                         foreach ($tue_result as $tue) 
                        {
                            echo $time_slot = $tue->slot_timing.' '.'<a data-toggle="modal" data-target="#defaultsizemodal'.$tue->slot_id.'" style="margin-left:10px">
			                      <i class="fa fa-edit"></i>
			                     </a>'.'<a data-original-title="Delete" id="'.$tue->slot_id.'" Onclick="return ConfirmDelete('.$tue->slot_id.');"> <i aria-hidden="true" class="fa fa-trash"></i>  </a>'.'<BR>';
			                   
			              ?>
			              
			              
			              					  <!-- Modal -->
						<div class="modal fade" id="defaultsizemodal<?php echo $tue->slot_id ?>">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title"><i class="fa fa-star"></i> Update Slot</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							   <form id="update_slot<?php echo $tue->slot_id ?>" method="post" action="<?php echo base_url();?>product/update_slot_data">
								  <div class="modal-body">
									<div class="form-group">
									  <label for="input-1">Time slot</label>
										<input type="text" class="form-control" name="slot_timing" id="input-1" value="<?php echo $tue->slot_timing;?>">
									  <div class="form_error_msg slot_timingError"></div>
									 </div>
							
								  </div>
								  <input type="hidden" value="<?php echo $tue->slot_id;?>" name="slot_id">
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
							$('#update_slot<?php echo $tue->slot_id ?>').ajaxForm({
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
			        <?php
			                   
			                   
			                   
                        }
                     } 
                     else
                     {
                         echo '<p>No slot found.</p>';
                     }
                 
                 ?>


              </div>

            <div class="col-md-4">
                  <h4>Wednesday</h4>
                  
                   <?php 
      				 $CI =& get_instance();
                     $CI->load->model('Product_model');
                     $wed_result = $CI->product_model->wednesday_time_slot();
                     
                     //print_r($tue_result);
                     if(!empty($wed_result))
                     {
                         foreach ($wed_result as $wed) 
                        {
                            echo $time_slot = $wed->slot_timing.' '.'<a data-toggle="modal" data-target="#defaultsizemodal'.$wed->slot_id.'" style="margin-left:10px">
			                      <i class="fa fa-edit"></i>
			                     </a>'.'<a data-original-title="Delete" id="'.$wed->slot_id.'" Onclick="return ConfirmDelete('.$wed->slot_id.');"> <i aria-hidden="true" class="fa fa-trash"></i>  </a>'.'<BR>';
			                   
			              ?>
			              
			              
			              					  <!-- Modal -->
						<div class="modal fade" id="defaultsizemodal<?php echo $wed->slot_id ?>">
						  <div class="modal-dialog">
							<div class="modal-content">
							  <div class="modal-header">
								<h5 class="modal-title"><i class="fa fa-star"></i> Update Slot</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								  <span aria-hidden="true">&times;</span>
								</button>
							  </div>
							   <form id="update_slot<?php echo $wed->slot_id ?>" method="post" action="<?php echo base_url();?>product/update_slot_data">
								  <div class="modal-body">
									<div class="form-group">
									  <label for="input-1">Time slot</label>
										<input type="text" class="form-control" name="slot_timing" id="input-1" value="<?php echo $wed->slot_timing;?>">
									  <div class="form_error_msg slot_timingError"></div>
									 </div>
							
								  </div>
								  <input type="hidden" value="<?php echo $wed->slot_id;?>" name="slot_id">
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
							$('#update_slot<?php echo $wed->slot_id ?>').ajaxForm({
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
			        <?php
			                   
			                   
			                   
                        }
                     } 
                     else
                     {
                         echo '<p>No slot found.</p>';
                     }
                 
                 ?>



              </div>
             </div> 
            <hr>
            <div class="form-group row">    
              <div class="col-md-4">
                  <h4>Thursday</h4>
                  
                     <?php 
          				 $CI =& get_instance();
                         $CI->load->model('Product_model');
                         $thr_result = $CI->product_model->thursday_time_slot();
                         
                         //print_r($tue_result);
                         if(!empty($thr_result))
                         {
                             foreach ($thr_result as $thr) 
                            {
                                echo $time_slot = $thr->slot_timing.' '.'<a data-toggle="modal" data-target="#defaultsizemodal'.$thr->slot_id.'" style="margin-left:10px">
    			                      <i class="fa fa-edit"></i>
    			                     </a>'.'<a data-original-title="Delete" id="'.$thr->slot_id.'" Onclick="return ConfirmDelete('.$thr->slot_id.');"> <i aria-hidden="true" class="fa fa-trash"></i>  </a>'.'<BR>';
    			                   
    			              ?>
    			              
    			              
    			              					  <!-- Modal -->
    						<div class="modal fade" id="defaultsizemodal<?php echo $thr->slot_id ?>">
    						  <div class="modal-dialog">
    							<div class="modal-content">
    							  <div class="modal-header">
    								<h5 class="modal-title"><i class="fa fa-star"></i> Update Slot</h5>
    								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    								  <span aria-hidden="true">&times;</span>
    								</button>
    							  </div>
    							   <form id="update_slot<?php echo $thr->slot_id ?>" method="post" action="<?php echo base_url();?>product/update_slot_data">
    								  <div class="modal-body">
    									<div class="form-group">
    									  <label for="input-1">Time slot</label>
    										<input type="text" class="form-control" name="slot_timing" id="input-1" value="<?php echo $thr->slot_timing;?>">
    									  <div class="form_error_msg slot_timingError"></div>
    									 </div>
    							
    								  </div>
    								  <input type="hidden" value="<?php echo $thr->slot_id;?>" name="slot_id">
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
    							$('#update_slot<?php echo $thr->slot_id ?>').ajaxForm({
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
    			        <?php
    			                   
    			                   
    			                   
                            }
                         } 
                         else
                         {
                             echo '<p>No slot found.</p>';
                         }
                     
                     ?>

              </div>
               <div class="col-md-4">
                  <h4>Friday</h4>
                  
                     <?php 
          				 $CI =& get_instance();
                         $CI->load->model('Product_model');
                         $fri_result = $CI->product_model->friday_time_slot();
                         
                         //print_r($tue_result);
                         if(!empty($fri_result))
                         {
                             foreach ($fri_result as $fri) 
                            {
                                echo $time_slot = $fri->slot_timing.' '.'<a data-toggle="modal" data-target="#defaultsizemodal'.$fri->slot_id.'" style="margin-left:10px">
    			                      <i class="fa fa-edit"></i>
    			                     </a>'.'<a data-original-title="Delete" id="'.$fri->slot_id.'" Onclick="return ConfirmDelete('.$fri->slot_id.');"> <i aria-hidden="true" class="fa fa-trash"></i>  </a>'.'<BR>';
    			                   
    			              ?>
    			              
    			              
    			              					  <!-- Modal -->
    						<div class="modal fade" id="defaultsizemodal<?php echo $fri->slot_id ?>">
    						  <div class="modal-dialog">
    							<div class="modal-content">
    							  <div class="modal-header">
    								<h5 class="modal-title"><i class="fa fa-star"></i> Update Slot</h5>
    								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    								  <span aria-hidden="true">&times;</span>
    								</button>
    							  </div>
    							   <form id="update_slot<?php echo $fri->slot_id ?>" method="post" action="<?php echo base_url();?>product/update_slot_data">
    								  <div class="modal-body">
    									<div class="form-group">
    									  <label for="input-1">Time slot</label>
    										<input type="text" class="form-control" name="slot_timing" id="input-1" value="<?php echo $fri->slot_timing;?>">
    									  <div class="form_error_msg slot_timingError"></div>
    									 </div>
    							
    								  </div>
    								  <input type="hidden" value="<?php echo $fri->slot_id;?>" name="slot_id">
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
    							$('#update_slot<?php echo $fri->slot_id ?>').ajaxForm({
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
    			        <?php
    			                   
    			                   
    			                   
                            }
                         } 
                         else
                         {
                             echo '<p>No slot found.</p>';
                         }
                     
                     ?>


              </div>
            <div class="col-md-4">
                  <h4>Saturday</h4>
                  
                    <?php 
          				 $CI =& get_instance();
                         $CI->load->model('Product_model');
                         $sat_result = $CI->product_model->saturday_time_slot();
                         
                         //print_r($tue_result);
                         if(!empty($sat_result))
                         {
                             foreach ($sat_result as $sat) 
                            {
                                echo $time_slot = $sat->slot_timing.' '.'<a data-toggle="modal" data-target="#defaultsizemodal'.$sat->slot_id.'" style="margin-left:10px">
    			                      <i class="fa fa-edit"></i>
    			                     </a>'.'<a data-original-title="Delete" id="'.$sat->slot_id.'" Onclick="return ConfirmDelete('.$sat->slot_id.');"> <i aria-hidden="true" class="fa fa-trash"></i>  </a>'.'<BR>';
    			                   
    			              ?>
    			              
    			              
    			              					  <!-- Modal -->
    						<div class="modal fade" id="defaultsizemodal<?php echo $sat->slot_id ?>">
    						  <div class="modal-dialog">
    							<div class="modal-content">
    							  <div class="modal-header">
    								<h5 class="modal-title"><i class="fa fa-star"></i> Update Slot</h5>
    								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    								  <span aria-hidden="true">&times;</span>
    								</button>
    							  </div>
    							   <form id="update_slot<?php echo $sat->slot_id ?>" method="post" action="<?php echo base_url();?>product/update_slot_data">
    								  <div class="modal-body">
    									<div class="form-group">
    									  <label for="input-1">Time slot</label>
    										<input type="text" class="form-control" name="slot_timing" id="input-1" value="<?php echo $sat->slot_timing;?>">
    									  <div class="form_error_msg slot_timingError"></div>
    									 </div>
    							
    								  </div>
    								  <input type="hidden" value="<?php echo $sat->slot_id;?>" name="slot_id">
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
    							$('#update_slot<?php echo $sat->slot_id ?>').ajaxForm({
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
    			        <?php
    			                   
    			                   
    			                   
                            }
                         } 
                         else
                         {
                             echo '<p>No slot found.</p>';
                         }
                     
                     ?>




              </div>
              
             </div>
             <hr>
             <div class="form-group row"> 
             
               <div class="col-md-4">
                  <h4>Sunday</h4>
                  
                    <?php 
          				 $CI =& get_instance();
                         $CI->load->model('Product_model');
                         $sun_result = $CI->product_model->sunday_time_slot();
                         
                         //print_r($tue_result);
                         if(!empty($sun_result))
                         {
                             foreach ($sun_result as $sun) 
                            {
                                echo $time_slot = $sun->slot_timing.' '.'<a data-toggle="modal" data-target="#defaultsizemodal'.$sun->slot_id.'" style="margin-left:10px">
    			                      <i class="fa fa-edit"></i>
    			                     </a>'.'<a data-original-title="Delete" id="'.$sun->slot_id.'" Onclick="return ConfirmDelete('.$sun->slot_id.');"> <i aria-hidden="true" class="fa fa-trash"></i>  </a>'.'<BR>';
    			                   
    			              ?>
    			              
    			              
    			              					  <!-- Modal -->
    						<div class="modal fade" id="defaultsizemodal<?php echo $sun->slot_id ?>">
    						  <div class="modal-dialog">
    							<div class="modal-content">
    							  <div class="modal-header">
    								<h5 class="modal-title"><i class="fa fa-star"></i> Update Slot</h5>
    								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    								  <span aria-hidden="true">&times;</span>
    								</button>
    							  </div>
    							   <form id="update_slot<?php echo $sun->slot_id ?>" method="post" action="<?php echo base_url();?>product/update_slot_data">
    								  <div class="modal-body">
    									<div class="form-group">
    									  <label for="input-1">Time slot</label>
    										<input type="text" class="form-control" name="slot_timing" id="input-1" value="<?php echo $sun->slot_timing;?>">
    									  <div class="form_error_msg slot_timingError"></div>
    									 </div>
    							
    								  </div>
    								  <input type="hidden" value="<?php echo $sun->slot_id;?>" name="slot_id">
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
    							$('#update_slot<?php echo $sun->slot_id ?>').ajaxForm({
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
    			        <?php
    			                   
    			                   
    			                   
                            }
                         } 
                         else
                         {
                             echo '<p>No slot found.</p>';
                         }
                     
                     ?>





              </div>
             
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
		   window.location = "<?php echo base_url();?>product/slot_time";
		  
		}
	});

}
return false;
}

</script>