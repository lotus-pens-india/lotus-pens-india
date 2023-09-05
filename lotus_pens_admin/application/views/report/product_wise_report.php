<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
    
    <!-- End Breadcrumb-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-upload"></i> Product Wise Report</div>
            <div class="card-body">
			  <form id="add_product" method="post" action="<?php echo base_url();?>report/product_wise_report">
                <div id="wizard-vertical1">
                    
                    <section>
                        <div class="form-group row">
						  <div class="col-md-4">
                            <label>From  *</label>
                            <input class="form-control" name="date_from" type="date" required>
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
        		     <div class="col-md-9">
        		         <Strong><?php echo date("d-m-Y", strtotime($date_from));; ?>  To  <?php echo date("d-m-Y", strtotime($date_to)); ?></Strong>
        		    </div>       
        		      <div class="col-md-3">
        		           <form id="add_product" method="post" action="<?php echo base_url();?>sales/download_product_wise_excel">
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
                            <th>Product Name</th>
                            <th>No.of Sale</th>
                            <th>Qty</th>
                            <th>Saller</th>
              
                        </tr>
                    </thead>
                    <tbody>
                         <?php
							$i = 1;
							foreach($product_wise_report as $post) 
							{
						  ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                           
                            <td><?php echo $post->product_name; ?></td>
                            <td>
                                <?php 
                                     $CI =& get_instance();
                                    $CI->load->model('Sales_model');
                                    $result = $CI->sales_model->product_id_wise_count($post->product_id,$date_from,$date_to);
                                    
                                    echo $result->total_product;
                                ?>
                            </td>
                            <td>
                                <?php 
                                     $CI =& get_instance();
                                    $CI->load->model('Sales_model');
                                    $result = $CI->sales_model->product_id_wise_qty_count($post->product_id,$date_from,$date_to);
                                    
                                    echo $result->total_qty;
                                ?>
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
