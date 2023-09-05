

<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Assign Product</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Product</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Assign Product</a></li>
         </ol>
	   </div>
	   <div class="col-sm-3">
       <div class="float-sm-right">
        <button type="button" class="btn btn-primary waves-effect waves-light m-1">Product list</button>
      </div>
     </div>
     </div>
    <!-- End Breadcrumb-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-upload"></i> Assign Product</div>
            <div class="card-body">
			  <form id="assign_product" method="post" action="<?php echo base_url();?>sales/add_assignproduct_data">
         
					 
                        <div class="form-group row">
						  <div class="col-md-4">
                            <label>Select Delivery boy *</label>
                            <select class="form-control single-select"  name="assign_to" id="assign_to">
							  <option value="">Select Delivery Boy</option>
							  <?php foreach($all_delivery_boy as $delivery_boy) { ?>
								   <option value="<?php echo $delivery_boy->db_id ?>"><?php echo $delivery_boy->name ?></option>
							  <?php } ?>
							  </select>
							<div class="form_error_msg assign_toError"></div>
						  </div>
                          
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4">
							  <label>Assign Date </label>
							    <input class="form-control" id="default-datepicker" name="assign_date" type="text">
						     	<div class="form_error_msg assign_dateError"></div>
							</div>
							
                        </div>

                    </section>
                     <input class="form-control" name="order_id" type="hidden" value="<?php echo $order_summary->order_id; ?>">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i>Assign</button>
       
				<div class="success_message"></div>
				</form>
            </div>
          </div>
        </div>
      </div><!-- End Row-->


    </div>
    <!-- End container-fluid-->
<script>


