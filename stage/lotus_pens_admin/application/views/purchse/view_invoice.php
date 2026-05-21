<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Invoice</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Purchse</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">View Invoice</a></li>
            <li class="breadcrumb-item active" aria-current="page">Invoice</li>
         </ol>
	   </div>
	   <div class="col-sm-3">

     </div>
     </div>
    <!-- End Breadcrumb-->
      <div class="card">
          <div class="card-body">
                  <!-- Content Header (Page header) -->
 
                  <!-- Main content -->
                  <section class="invoice">
                    <!-- title row -->
                    <div class="row mt-3">

                          <div class="col-lg-2">
                            <img src="<?php echo base_url();?>assets/images/login.jpg" style="height:65px;    margin-top: -18px;">
                          </div>
                          <div class="col-lg-3">

                          </div>
    					  <div class="col-lg-2">
    					   <h6 class="float-sm-right">Date: <?php echo $order_summary->purchse_date; ?></h6>
    					  </div>
    					  
    					  

                     </div>
                    <hr>
                    <div class="row invoice-info">
                      <div class="col-sm-6 invoice-col">
                        From
                        <address>
                         <strong><?php echo $order_summary->company_name; ?></strong><br>
                          <?php echo $order_summary->address; ?><br>
                          Phone:<?php echo $order_summary->mobile_no; ?><br>
                          Email: <?php echo $order_summary->email_id; ?>
                        </address>
                      </div><!-- /.col -->
                      
                      <div class="col-sm-3 invoice-col">
                       
                      </div><!-- /.col -->
                        <div class="col-sm-3 invoice-col">
                        
                      </div><!-- /.col -->
                    </div><!-- /.row -->
                    
                    <!-- Table row -->
                    <div class="row">
                      <div class="col-12 table-responsive">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th>Unit</th>    
                              <th>Qty</th>
                              <th>Product</th>
                              <th>Unit Price</th>
                              <th>Discount(%)</th>
                              <th>Subtotal</th>
                            </tr>
                          </thead>
                          <tbody>
                              <?php
                              
                                $CI =& get_instance();
        						$CI->load->model('Purchse_model');
        						$result = $CI->Purchse_model->get_item_details($order_summary->p_id);
        						$sum = 0;
                                foreach($result as $p_detail)
    					        {
                              ?>
                            <tr>
                              <td><?php echo $p_detail->unit; ?></td>    
                              <td><?php echo $p_detail->qty; ?></td>
                              <td><?php echo $p_detail->product_name; ?></td>
                              <td><?php echo $p_detail->unit_price; ?></td>
                              <td><?php echo $p_detail->discount; ?></td>
                              <td>
                                  <?php 
                                  $a = ($p_detail->qty * $p_detail->unit_price ); 
                                  if ($p_detail->discount > 0) 
                                  { 
                                    $b = ($a*$p_detail->discount)/100; $sum+= $a - $b;  echo $sub_total = $a - $b; 
                                  } 
                                  else 
                                  { 
                                    $sum+=$a;  echo $sub_total = $a; 
                                  }
                                  ?> 
                            </td>
                              
                            </tr>
                           <?php } ?>
                          </tbody>
                        </table>
                      </div><!-- /.col -->
                    </div><!-- /.row -->

                    <div class="row">
                      <!-- accepted payments column -->
                      <div class="col-lg-8 payment-icons">
                        
                        
                      </div><!-- /.col -->
                      <div class="col-lg-4">
                        <div class="table-responsive">
                          <table class="table">
                            <tbody>
							<tr>
                              <th style="width:50%">Total amount:</th>
                              <td>Rs. <?php echo $order_summary->total_amount; ?></td>
                            </tr>
                            <tr>
                              <th>Discount Amt :</th>
                              <td>Rs. <?php echo $order_summary->total_discount; ?></td>
                            </tr>
                            <tr>
                              <th>Grand Total :</th>
                              <td>Rs. <?php echo $order_summary->grand_total_amount; ?></td>
                            </tr>
                            
                            
                          </tbody>
						  </table>
                        </div>
                      </div><!-- /.col -->
                    </div><!-- /.row -->


                  </section><!-- /.content -->
          </div>
      </div>

	  <!--start overlay-->
	  <div class="overlay toggle-menu"></div>
	<!--end overlay-->
    </div>
    <!-- End container-fluid-->
    
    
