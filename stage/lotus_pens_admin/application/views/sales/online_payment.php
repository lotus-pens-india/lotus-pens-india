<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Total Online Payment</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Payment</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Total Online Payment Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Total Online Payment Data Tables</li>
         </ol>
	   </div>
	   <div class="col-sm-3">
       <div class="float-sm-right">
        
      </div>
     </div>
     </div>
    <!-- End Breadcrumb-->
        	  <div class="row">
        <div class="col-12 col-lg-6 col-xl-3">
         <a href="<?php echo base_url();?>sales/total_payment">    
          <div class="card border-info border-left-sm">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-info"><?php if($total_payment->total_payment == '') { echo '0'; } else { echo $total_payment->total_payment; } ?></h4>
                <span>Total Payment</span>
              </div>
              <div class="align-self-center w-circle-icon rounded-circle gradient-scooter">
                <i class="icon-credit-card text-white"></i></div>
            </div>
            </div>
          </div>
          </a>
        </div>
        <div class="col-12 col-lg-6 col-xl-3">
         <a href="<?php echo base_url();?>sales/cash_payment">    
          <div class="card border-danger border-left-sm">
            <div class="card-body">
              <div class="media">
               <div class="media-body text-left">
                <h4 class="text-warning"><?php if($cash_payment->cash_payment == '') { echo '0'; } else { echo $cash_payment->cash_payment; } ?></h4>
                <span>Cash Payment</span>
              </div>
               <div class="align-self-center w-circle-icon rounded-circle gradient-bloody">
                <i class="icon-credit-card text-white"></i></div>
            </div>
            </div>
          </div>
          </a>
        </div>
        <div class="col-12 col-lg-6 col-xl-3">
         <a href="<?php echo base_url();?>sales/online_payment">    
          <div class="card border-success border-left-sm">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-success"><?php if($online_payment->online_payment == '') { echo '0'; } else { echo $online_payment->online_payment; } ?></h4>
                <span>Online Payment</span>
              </div>
              <div class="align-self-center w-circle-icon rounded-circle gradient-quepal">
                <i class="icon-credit-card text-white"></i></div>
            </div>
            </div>
          </div>
          </a>
        </div>
        <div class="col-12 col-lg-6 col-xl-3">
         <a href="<?php echo base_url();?>sales/refund_payment">    
          <div class="card border-warning border-left-sm">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-warning"><?php if($refund_payment->refund_payment == '') { echo '0'; } else { echo $refund_payment->refund_payment; } ?></h4>
                <span>Refund Payment</span>
              </div>
              <div class="align-self-center w-circle-icon rounded-circle gradient-quepal">
                <i class="icon-credit-card text-white"></i></div>
            </div>
            </div>
          </div>
          </a>
        </div>
       
      </div><!--End row-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Total Online Payment List</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="online_payment_datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Order Code</th>
                        <th>No.of<br>products</th>
                        <th>Customer</th> 
                        <th>Amount</th>
                        <th>Payment mode</th>
                        <th>Saller</th>
                        <th>Option</th>
                    </tr>
                </thead>
                
                
            </table>
            </div>
            </div>
          </div>
        </div>
      </div><!-- End Row-->


    </div>
    <!-- End container-fluid-->
