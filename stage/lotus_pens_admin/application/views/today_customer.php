<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Customer added (Today)</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Customer</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Customer added (Today) Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Customer added (Today) Data Tables</li>
         </ol>
	   </div>
	   <div class="col-sm-3">
       <div class="float-sm-right">
        <form id="add_product" method="post" action="<?php echo base_url();?>customer/download_excel">
          <button type="submit" class="btn btn-primary waves-effect waves-light m-1">Download Customer details in excel </button>
          </form>
      </div>
     </div>
     </div>
    <!-- End Breadcrumb-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Customer added (Today) List</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="brand-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Customer Id</th>
                         <th>Name</th>
                        <th>Mobile No</th>
                        <th>Email id</th>
                        <th>Pincode</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
						   if ($all_customer != '')
							{
							$i = 1;
							foreach($all_customer as $post)
							{
					?>
                    <tr>
                        <td><?php echo $i++ ?></td>
                        <td><?php echo $post->customer_unique_id; ?></td>
                        <td><?php echo $post->first_name.' '.$post->last_name; ?></td>
                        <td><?php echo $post->mobile_no; ?></td>
                        <td><?php echo $post->email_id; ?></td>
                        <td><?php echo $post->pincode; ?></td>
                        
                    </tr>
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
