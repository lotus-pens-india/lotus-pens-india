<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
    
    <!-- End Breadcrumb-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-upload"></i> Saller Commission Report</div>
            <div class="card-body">
			  <form id="add_product" method="post" action="<?php echo base_url();?>report/saller_commisssion_report">
                <div id="wizard-vertical1">
                    
                    <section>
                        <div class="form-group row">
						  <div class="col-md-4">
                            <label>From  *</label>
                            <input class="form-control" name="date_from" id="default-datepicker" type="text" required>
						  </div>
                          <div class="col-md-4">
						      <label> To *</label>
							  <input class="form-control" name="date_to" id="default-datepicker1" type="text" required>
                           </div>
                           <div class="col-md-4">
						      <label> Select Saller *</label>
						      <select class="form-control single-select" name="saller_id" required>
                				 <option value="">Select Saller</option>
                				 <?php foreach($all_saller as $saller) { ?>
                					  <option value="<?php echo $saller->saller_id ?>"><?php echo $saller->saller_name ?></option>
                				 <?php } ?>	  
                				  </select>
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
        		        
         				$CI =& get_instance();
                        $CI->load->model('Customer_model');
                        $result = $CI->customer_model->get_saller_details($saller_id);
                        $saller_name = $result->saller_name;
                        $commission = $result->commission;

        		 
        		 ?>
        		 <div class="row">
        		      <div class="col-md-2">
        		         <h5>Total Order : <?php if($count_sales_report->total_deliver_order == '') { echo '0'; } else { echo $count_sales_report->total_deliver_order; } ?></h5>
        		      </div>
        		      <div class="col-md-3">
        		         <h5>Total Bussiness : <?php if($sum_sales_report->total_bussiness == '') { echo '0';  } else { echo $sum_sales_report->total_bussiness; } ?></h5>
        		      </div>
        		       <div class="col-md-4">
        		         <h5>Total Commission generate : 
        		           <?php 
        		                  
        		                  $total_commission1 = round(($commission / 100) * $sum_sales_report->total_bussiness);
                                    echo $total_commission = $total_commission1;  
        		           
        		           ?>
        		         </h5>
        		      </div>
        		      <div class="col-md-3">
        		           <form id="add_product" method="post" action="<?php echo base_url();?>sales/saller_wise_commission_download_excel">
                              <button type="submit" class="btn btn-primary waves-effect waves-light m-1">Download Excel</button>
                              <input type="hidden" value="<?php echo $date_from;?>" name="from_date">
                              <input type="hidden" value="<?php echo $date_to;?>" name="to_date">
                              <input type="hidden" value="<?php echo $saller_id;?>" name="saller_id">
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
                            <th>Commission</th>
                            <th>Saller Name</th>
                            <th>Franchise</th>
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
                                    $credit_amount1 = round(($commission / 100) * $post->order_total);
                                    echo $credit_amount = $credit_amount1;
                                ?>
                            </td>
                            <td>
                                <?php echo $saller_name; ?>
                            </td>
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
