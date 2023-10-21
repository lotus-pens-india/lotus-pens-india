<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
           <!-- Breadcrumb-->
         <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Exotic Basket Dashboard</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Exotic Basket Dashboard</a></li>
         </ol>
	   </div>
	   <div class="col-sm-3">
       <div class="float-sm-right">
      </div>
     </div>
     </div>
    <!-- End Breadcrumb-->
      <!--Start Dashboard Content-->

	  
	  <div class="row">
	     <div class="col-12 col-lg-6 col-xl-3">
         <a href="<?php echo base_url();?>sales/total_sales">     
          <div class="card border-danger border-left-sm">
            <div class="card-body">
              <div class="media">
               <div class="media-body text-left">
                <h4 class="text-danger"><?php if($total_count->total_count == '') { echo '0'; } else { echo $total_count->total_count; } ?></h4>
                <span>Total Order</span>
              </div>
               <div class="align-self-center w-circle-icon rounded-circle gradient-bloody">
                <i class="icon-basket-loaded text-white"></i></div>
            </div>
            </div>
          </div>
          </a>
        </div>  
        <div class="col-12 col-lg-6 col-xl-3">
         <a href="<?php echo base_url();?>sales">    
          <div class="card border-info border-left-sm">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-info"><?php if($today_count->today_count == '') { echo '0'; } else { echo $today_count->today_count; } ?></h4>
                <span>Today Order</span>
              </div>
              <div class="align-self-center w-circle-icon rounded-circle gradient-scooter">
                <i class="icon-basket-loaded text-white"></i></div>
            </div>
            </div>
          </div>
          </a>
        </div>

        <div class="col-12 col-lg-6 col-xl-3">
        <a href="<?php echo base_url();?>sales/pending_sales">    
          <div class="card border-success border-left-sm">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-danger"><?php if($pending_count->pending_count == '') { echo '0'; } else { echo $pending_count->pending_count; } ?></h4>
                <span>Pending Order</span>
              </div>
              <div class="align-self-center w-circle-icon rounded-circle gradient-quepal">
                <i class="icon-basket-loaded text-white"></i></div>
            </div>
            </div>
          </div>
          </a>
        </div>
        <div class="col-12 col-lg-6 col-xl-3">
         <a href="<?php echo base_url();?>sales/monthly_delivered_sales">  
          <div class="card border-success border-left-sm">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-info"><?php if($delivered_count->delivered_count == '') { echo '0'; } else { echo $delivered_count->delivered_count; } ?></h4>
                <span>Deliverd Order</span>
              </div>
              <div class="align-self-center w-circle-icon rounded-circle gradient-scooter">
                <i class="icon-basket-loaded text-white"></i></div>
            </div>
            </div>
          </div>
          </a>
        </div>
        <div class="col-12 col-lg-6 col-xl-3">
        <a href="<?php echo base_url();?>sales/cancel_sales">   
          <div class="card border-success border-left-sm">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-warning"><?php if($cancel_count->cancel_count == '') { echo '0'; } else { echo $cancel_count->cancel_count; } ?></h4>
                <span>Cancelled order (Paid)</span>
              </div>
              <div class="align-self-center w-circle-icon rounded-circle gradient-blooker">
                <i class="icon-basket-loaded text-white"></i></div>
            </div>
            </div>
          </div>
          </a>
        </div>
         <div class="col-12 col-lg-6 col-xl-3">
        <a href="<?php echo base_url();?>sales/cancel_sales1">    
          <div class="card border-success border-left-sm">
            <div class="card-body" style="height: 100px;">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-danger"><?php if($cancel_count1->cancel_count == '') { echo '0'; } else { echo $cancel_count1->cancel_count; } ?></h4>
                <span>Cancelled order (Unpaid)</span>
              </div>
              <div class="align-self-center w-circle-icon rounded-circle gradient-quepal">
                <i class="icon-basket-loaded text-white"></i></div>
            </div>
            </div>
          </div>
          </a>
        </div>
      </div><!--End row-->
      
      <div class="row">
          <div class="col-12 col-lg-6 col-xl-3">
        <a href="<?php echo base_url();?>sales/dispatch_sales">   
          <div class="card border-success border-left-sm">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-warning"><?php if($dispatch_count->dispatch_count == '') { echo '0'; } else { echo $dispatch_count->dispatch_count; } ?></h4>
                <span>Dispatch order</span>
              </div>
              <div class="align-self-center w-circle-icon rounded-circle gradient-blooker">
                <i class="icon-basket-loaded text-white"></i></div>
            </div>
            </div>
          </div>
          </a>
        </div>
         <div class="col-12 col-lg-6 col-xl-3">
         <a href="<?php echo base_url();?>Customer">     
          <div class="card border-danger border-left-sm">
            <div class="card-body" style="height: 124px;">
              <div class="media">
               <div class="media-body text-left">
                <h4 class="text-danger"><?php if($customer_count->customer_count == '') { echo '0'; } else { echo $customer_count->customer_count; } ?></h4>
                <span>Total Customer</span>
              </div>
               <div class="align-self-center w-circle-icon rounded-circle gradient-bloody">
                <i class="icon-people text-white"></i></div>
            </div>
            </div>
          </div>
          </a>
        </div>  
        <div class="col-12 col-lg-6 col-xl-3">
         <a href="<?php echo base_url();?>customer/monthly_customer">    
          <div class="card border-info border-left-sm">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-info"><?php if($customer_monthly_count->customer_count == '') { echo '0'; } else { echo $customer_monthly_count->customer_count; } ?></h4>
                <span>Customer added (Month)</span>
              </div>
              <div class="align-self-center w-circle-icon rounded-circle gradient-scooter">
                <i class="icon-people text-white"></i></div>
            </div>
            </div>
          </div>
          </a>
        </div>

        <div class="col-12 col-lg-6 col-xl-3">
         <a href="<?php echo base_url();?>customer/today_customer">   
          <div class="card border-success border-left-sm">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-danger"><?php if($customer_today_count->customer_count == '') { echo '0'; } else { echo $customer_today_count->customer_count; } ?></h4>
                <span>Customer added (Today)</span>
              </div>
              <div class="align-self-center w-circle-icon rounded-circle gradient-quepal">
                <i class="icon-people text-white"></i></div>
            </div>
            </div>
          </div>
          </a>
        </div>

       
      </div>

        
        
        <div class="row">
          
         <div class="col-12 col-lg-6 col-xl-3">
         <a href="<?php echo base_url();?>sales/total_payment">     
          <div class="card border-danger border-left-sm">
            <div class="card-body">
              <div class="media">
               <div class="media-body text-left">
                <h4 class="text-danger"><?php if($total_payment->total_payment == '') { echo '0'; } else { echo $total_payment->total_payment; } ?></h4>
                <span>Total Payment </span>
              </div>
               <div class="align-self-center w-circle-icon rounded-circle gradient-bloody">
                <i class="icon-credit-card text-white"></i></div>
            </div>
            </div>
          </div>
          </a>
        </div>  
        <div class="col-12 col-lg-6 col-xl-3">
         <a href="<?php echo base_url();?>sales/cash_payment">    
          <div class="card border-info border-left-sm">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-info"><?php if($cash_payment->cash_payment == '') { echo '0'; } else { echo $cash_payment->cash_payment; } ?></h4>
                <span>Cash payments </span>
              </div>
              <div class="align-self-center w-circle-icon rounded-circle gradient-scooter">
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
                <h4 class="text-danger"><?php if($online_payment->online_payment == '') { echo '0'; } else { echo $online_payment->online_payment; } ?></h4>
                <span>Online Payments </span>
              </div>
              <div class="align-self-center w-circle-icon rounded-circle gradient-quepal">
                <i class="icon-credit-card text-white"></i></div>
            </div>
            </div>
          </div>
          </a>
        </div>
        
         <div class="col-12 col-lg-6 col-xl-3">
        <a href="<?php echo base_url();?>sales/cancel_bill_amount">    
          <div class="card border-success border-left-sm">
            <div class="card-body" style="height:100px">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-warning"><?php if($cancel_bill->payment == '') { echo '0'; } else { echo $cancel_bill->payment; } ?></h4>
                <span>Cancelled order Bill amount today(Paid)</span>
              </div>
              <div class="align-self-center w-circle-icon rounded-circle gradient-blooker">
                <i class="icon-credit-card text-white"></i></div>
            </div>
            </div>
          </div>
          </a>
        </div>
        
        </div>

       <!--End Dashboard Content-->

    </div>
    <!-- End container-fluid-->