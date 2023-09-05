<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Pincode <?php echo $pin_area; ?> Wise Report</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Pincode</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Pincode Wise Report Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pincode Wise Report Data Tables</li>
         </ol>
	   </div>
	   <div class="col-sm-3">
       <div class="float-sm-right">
      </div>
     </div>
     </div>
    <!-- End Breadcrumb-->
     	    <div class="row">
		  <div class="col-12 col-lg-4 col-xl-4">
		    <div class="card bg-pattern-dark">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-white"><?php echo $total_customer->count; ?></h4>
                <span class="text-white">Total Customer</span>
              </div>
			  <div class="align-self-center w-circle-icon rounded gradient-violet">
                <i class="icon-like text-white"></i></div>
            </div>
            </div>
          </div>
		  </div>
		  <div class="col-12 col-lg-4 col-xl-4">
		    <div class="card bg-pattern-dark">
            <div class="card-body">
              <div class="media">
			  <div class="media-body text-left">
                <h4 class="text-white"><?php echo $total_order->total_order; ?></h4>
                <span class="text-white">Total Order</span>
              </div>
               <div class="align-self-center w-circle-icon rounded gradient-ibiza">
                <i class="icon-speech text-white"></i></div>
            </div>
            </div>
          </div>
		  </div>
		  <div class="col-12 col-lg-4 col-xl-4">
		    <div class="card bg-pattern-dark">
            <div class="card-body">
              <div class="media">
			  <div class="media-body text-left">
                <h4 class="text-white"><?php echo $pending_order->total_order; ?></h4>
                <span class="text-white">Total Pending Order</span>
              </div>
               <div class="align-self-center w-circle-icon rounded gradient-ibiza">
                <i class="icon-speech text-white"></i></div>
            </div>
            </div>
          </div>
		  </div>
		  <div class="col-12 col-lg-4 col-xl-4">
		    <div class="card bg-pattern-dark">
            <div class="card-body">
              <div class="media">
			  <div class="media-body text-left">
                <h4 class="text-white"><?php echo $assign_order->total_order; ?></h4>
                <span class="text-white">Total Assign Order</span>
              </div>
               <div class="align-self-center w-circle-icon rounded gradient-ibiza">
                <i class="icon-speech text-white"></i></div>
            </div>
            </div>
          </div>
		  </div>
		  <div class="col-12 col-lg-4 col-xl-4">
		    <div class="card bg-pattern-dark">
            <div class="card-body">
              <div class="media">
			  <div class="media-body text-left">
                <h4 class="text-white"><?php echo $deliver_order->total_order; ?></h4>
                <span class="text-white">Total Delivered</span>
              </div>
               <div class="align-self-center w-circle-icon rounded gradient-ibiza">
                <i class="icon-speech text-white"></i></div>
            </div>
            </div>
          </div>
		  </div>
		  <div class="col-12 col-lg-4 col-xl-4">
		    <div class="card bg-pattern-dark">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-white"><?php echo $not_deliver_order->total_order; ?></h4>
                <span class="text-white">Total assign but not delivered</span>
              </div>
			  <div class="align-self-center w-circle-icon rounded gradient-quepal">
                <i class="icon-share text-white"></i></div>
            </div>
            </div>
          </div>
		  </div>
		   <div class="col-12 col-lg-4 col-xl-4">
		    <div class="card bg-pattern-dark">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-white"><?php echo $cancel_order->total_order; ?></h4>
                <span class="text-white">Total cancel order (Paid)</span>
              </div>
			  <div class="align-self-center w-circle-icon rounded gradient-quepal">
                <i class="icon-share text-white"></i></div>
            </div>
            </div>
          </div>
		  </div>
		   <div class="col-12 col-lg-4 col-xl-4">
		    <div class="card bg-pattern-dark">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-white"><?php if($total_amount->total_amount == '') { echo '0'; } else { echo $total_amount->total_amount; } ?></h4>
                <span class="text-white">Total Bussiness</span>
              </div>
			  <div class="align-self-center w-circle-icon rounded gradient-quepal">
                <i class="icon-share text-white"></i></div>
            </div>
            </div>
          </div>
		  </div>
		   <div class="col-12 col-lg-4 col-xl-4">
		    <div class="card bg-pattern-dark">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-white"><?php if($cash_amount->total_amount == '') { echo '0'; } else { echo $cash_amount->total_amount; } ?></h4>
                <span class="text-white">Total Cash payment</span>
              </div>
			  <div class="align-self-center w-circle-icon rounded gradient-quepal">
                <i class="icon-share text-white"></i></div>
            </div>
            </div>
          </div>
		  </div>
		   <div class="col-12 col-lg-4 col-xl-4">
		    <div class="card bg-pattern-dark">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-white"><?php if($online_amount->total_amount == '') { echo '0'; } else { echo $online_amount->total_amount; } ?></h4>
                <span class="text-white">Total Online payment</span>
              </div>
			  <div class="align-self-center w-circle-icon rounded gradient-quepal">
                <i class="icon-share text-white"></i></div>
            </div>
            </div>
          </div>
		  </div>
		  <div class="col-12 col-lg-4 col-xl-4">
		    <div class="card bg-pattern-dark">
            <div class="card-body">
              <div class="media">
              <div class="media-body text-left">
                <h4 class="text-white"><?php if($refund_amount->total_amount == '') { echo '0'; } else { echo $refund_amount->total_amount; } ?></h4>
                <span class="text-white">Total Refund payment</span>
              </div>
			  <div class="align-self-center w-circle-icon rounded gradient-quepal">
                <i class="icon-share text-white"></i></div>
            </div>
            </div>
          </div>
		  </div>
		</div><!--End Row-->


    </div>
    <!-- End container-fluid-->
