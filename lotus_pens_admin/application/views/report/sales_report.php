<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
    
    <!-- End Breadcrumb-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-upload"></i> Sales Report</div>
            <div class="card-body">
			  <form id="add_product" method="post" action="<?php echo base_url();?>report/sales_report">
                <div id="wizard-vertical1">
                    
                    <section>
                       <div class="form-group row">
						  <div class="col-md-4">
                            <label>From  *</label>
                            <input class="form-control" name="date_from"  type="date" required>
						  </div>
                          <div class="col-md-4">
						      <label> To *</label>
							  <input class="form-control" name="date_to" type="date" required>
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
        		 <div class="row">
        		     <div class="col-md-3">
        		         <h5>Total Order : <?php if($count_sales_report->total_order == '') { echo '0'; } else { echo $count_sales_report->total_order; } ?></h5>
        		      </div> 
        		      <div class="col-md-3">
        		         <h5>Cancel Order : <?php if($cancel_sales_report->total_cancel_order == '') { echo '0'; } else { echo $cancel_sales_report->total_cancel_order; } ?></h5>
        		      </div>
        		      <div class="col-md-3">
        		         <h5>Deliverd Order : <?php if($deliver_sales_report->total_deliver_order == '') { echo '0'; } else { echo $deliver_sales_report->total_deliver_order; } ?></h5>
        		      </div>
        		      <div class="col-md-3">
        		           <form id="add_product" method="post" action="<?php echo base_url();?>sales/download_excel_sales_report">
                              <button type="submit" class="btn btn-primary waves-effect waves-light m-1">Download Excel</button>
                              <input type="hidden" value="<?php echo $date_from;?>" name="from_date">
                              <input type="hidden" value="<?php echo $date_to;?>" name="to_date">
                         </form>
        		      </div>        
        		      
        		 </div>
        		 <hr>
        		 <div class="table-responsive">
                  <table id="sales_report_datatable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sr.No</th>
                            <th>Order Code</th>
                            <th>No.of<br>products</th>
                            <th>Customer</th> 
                            <th>Amount</th>
                            <th>Deliver Status</th>
                            <th>Payment Status</th>
                            <th>Date</th>
                            <th>Saller</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                         <?php
							$i = 1;
							foreach($sales_report as $post) 
							{
						  ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><a href="<?php echo base_url();?>sales/invoice/<?php echo $post->order_generate_id; ?>" target="_blank"><?php echo '#'.$post->order_generate_id ?></td>
                            <td>
                                <?php 
            						        $CI =& get_instance();
                                            $CI->load->model('Sales_model');
                                            $result = $CI->sales_model->count_order_wise_product($post->order_id);
                                            
                                            echo $result->total_product;
						                  ?>
                            </td>
                            <td><?php echo $post->first_name.' '.$post->last_name; ?></td>
                            <td><?php echo $post->order_total; ?></td>
                            <td>
                                <?php 
                                  if($post->status == '0')
                                    {
                                        echo '<span class="badge badge-danger shadow-danger m-1">Pending</span>';
                                        
                                    }elseif($post->status == '1')
                                    {
                                      echo '<span class="badge badge-success shadow-success m-1">Confirm</span>';
                                      
                                    }elseif($post->status == '2')
                                    {
                                        echo '<span class="badge badge-info shadow-info m-1">Dispatch</span>';
                                        
                                    }elseif($post->status == '3')
                                    
                                    {
                                        echo '<span class="badge badge-primary shadow-primary m-1">Delivered</span>';
                                    }
                                    elseif($post->status == '4')
                                    
                                    {
                                        echo '<span class="badge badge-danger shadow-danger m-1">Cancel</span><br> '.$post->cancel_resion;
                                    }
                                ?>
                            </td>
                            <td>
                                <?php 
                                  if($post->payment_status == '0')
                                    {
                                        echo  '<span class="badge badge-danger shadow-danger m-1">Unpaid</span>';
                                        
                                    }elseif($post->payment_status == '1')
                                    {
                                      echo '<span class="badge badge-success shadow-success m-1">Paid</span>';
                                      
                                    }
                                
                                ?>
                            </td>
                            <td><?php echo $post->order_date; ?></td>
                            <td><?php echo $post->franchise_name; ?></td>
                            
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
