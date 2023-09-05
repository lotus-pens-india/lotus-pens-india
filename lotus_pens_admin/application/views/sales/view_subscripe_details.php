<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Subscribe Deatils</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Sales</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">View Subscribe</a></li>
            <li class="breadcrumb-item active" aria-current="page">Subscribe</li>
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
                            <img src="<?php echo base_url();?>assets/images/veg shoppy 512x512.png" style="height:100px;    margin-top: -35px;">
                          </div>
                          <div class="col-lg-3">
                              <h5>
                                  Subscription ID
                                  <small>#<?php echo $order_summary->subscribe_generate_id; ?></small>
                                </h5>
                          </div>
    					  <div class="col-lg-7">
    					   <h6 class="float-sm-right">Date: <?php echo $order_summary->from_date.' To '.$order_summary->to_date; ?></h6>
    					  </div>
    					  
    					  
    					  
                     </div>
                    <hr>
                    <div class="row invoice-info">
                      <div class="col-sm-6 invoice-col">
                        From
                        <address>
                         <strong><?php echo $order_summary->first_name.' '.$order_summary->last_name; ?></strong><br>
                          <?php echo $order_summary->address; ?><br>
                          Phone:<?php echo $order_summary->mobile_no; ?><br>
                          Email: <?php echo $order_summary->email_id; ?>
                        </address>
                      </div><!-- /.col -->
                      
                      <div class="col-sm-3 invoice-col">
                        <b>Invoice #<?php echo $order_summary->subscribe_generate_id; ?></b><br>
                        <br>
                        <b>Subscribe  Mode:</b><?php echo $order_summary->subscribe_mode; ?><br><br>

                      </div><!-- /.col -->
                        <div class="col-sm-3 invoice-col">
                        <b>Day : <?php echo $order_summary->day; ?><br>
                        Total Subscribe Day : <?php echo $order_summary->total_day; ?>
                            
                        </b><br>

                        
                      </div><!-- /.col -->
                    </div><!-- /.row -->
                    
                    <!-- Table row -->
                    <div class="row">
                      <div class="col-12 table-responsive">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <tr>
                              <th>Unit</th>    
                              <th>Qty</th>
                              <th>Product</th>
                              <th>Unit Price</th>
                              <th>Discount(%)</th>
                              <th>Subtotal</th>
                              <th>Status</th>
                            </tr>
                            </tr>
                          </thead>
                          <tbody>
                              <?php
                              
                                $CI =& get_instance();
        						$CI->load->model('sales_model');
        						$result = $CI->sales_model->get_subscribeitem_details($order_summary->subscribe_id);
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
                              <td>
                                  <?php
                              if($p_detail->subscribe_status == '0')
                                {
                                    echo '<span class="badge badge-success shadow-success m-1">Active</span>';
                                    
                                }elseif($p_detail->subscribe_status == '1')
                                {
                                  echo  '<span class="badge badge-info shadow-info m-1">Pause</span>';
                                  
                                }elseif($p_detail->subscribe_status == '2')
                                {
                                    echo '<span class="badge badge-danger shadow-danger m-1">End</span>';
                                    
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
                      <div class="col-lg-6 payment-icons">
                        
                        
                      </div><!-- /.col -->
                      <div class="col-lg-6">
                        <div class="table-responsive">
                          <table class="table">
                            <tbody>
							
                            <tr>
                              <th style="width:50%">Subtotal:</th>
                              <td>Rs. <?php echo $sum; ?></td>
                            </tr>
                            <tr>
                              <th style="width:50%">Total Day:</th>
                              <td>Rs. <?php echo $order_summary->total_day; ?></td>
                            </tr>
                            <tr>
                              <th>Grand Total :</th>
                              <td>Rs. <?php echo $sum * $order_summary->total_day; ?></td>
                            </tr>
                            
                          </tbody>
						  </table>
                        </div>
                      </div><!-- /.col -->
                    </div><!-- /.row -->

                    <!-- this row will not appear when printing -->
                    <hr>

                  </section><!-- /.content -->
          </div>
      </div>

	  <!--start overlay-->
	  <div class="overlay toggle-menu"></div>
	<!--end overlay-->
    </div>
    <!-- End container-fluid-->
    
    
  