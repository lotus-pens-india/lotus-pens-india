<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Seller</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Seller</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Seller Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Seller Data Tables</li>
         </ol>
	   </div>
	   <div class="col-sm-3">
       <div class="float-sm-right">
         <a href="<?php echo base_url();?>product/add_franchise">  
          <button type="button" class="btn btn-primary waves-effect waves-light m-1">Add Seller</button>
         </a> 
      </div>
     </div>
     </div>
    <!-- End Breadcrumb-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Seller List</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="brand-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Name</th>
                        <th>Mobile no</th>
                        <th>Email id</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
				<?php
					   if ($all_franchise != '')
						{
						$i = 1;
						foreach($all_franchise as $franchise)
						{
				?>   
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $franchise->franchise_name ?></td>
                        <td><?php echo $franchise->mobile_no ?></td>
                        <td><?php echo $franchise->email_id ?></td>
                        <td><?php echo $franchise->state_name ?></td>
                        <td><?php echo $franchise->city_name ?></td>
                        <td>
                            <?php if($franchise->isActive == '0') { ?>
                            <span class="badge badge-success shadow-success m-1">Active</span>
                             <?php } else { ?>
                             <span class="badge badge-danger shadow-danger m-1">Deactive</span>
                             <?php } ?>
                        </td>
                        <td>
						   <div class="btn-group m-1" role="group">
                              <button type="button" class="btn btn-dark   waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action
                              </button>
                              <div class="dropdown-menu">
                                <a href="<?php echo base_url();?>product/edit_franchise?franchise_id=<?php echo  $franchise->franchise_id; ?>"  class="dropdown-item" ><i aria-hidden="true" class="fa fa-eye"></i> Edit</a>
                                 <?php if($franchise->isActive == '0'){ ?>
                                 <a style="cursor:pointer;"  class="dropdown-item tip-top delete delete one_<?php echo  $franchise->franchise_id; ?>" data-original-title="Delete" id="<?php echo $franchise->franchise_id; ?>"
						         Onclick="return ConfirmDisable(<?php echo $franchise->franchise_id ?>);"><i aria-hidden="true" class="fa fa-ban"></i> Deactive</a> 
						         <?php }else { ?>
						         <a style="cursor:pointer;"  class="dropdown-item tip-top delete delete one_<?php echo  $emp->franchise_id; ?>" data-original-title="Delete" id="<?php echo $franchise->franchise_id; ?>"
						         Onclick="return ConfirmEnable(<?php echo $franchise->franchise_id ?>);"><i aria-hidden="true" class="fa fa-key"></i> Active</a> 
						         <?php } ?>
                                 
                              </div>
                             </div>
						</td>
                    </tr>
					  <!-- Modal -->

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
	

<script type="text/javascript">
function ConfirmDisable(id)
{
if(confirm("Are you sure you want to deactive this franchise?"))
{
	$(".message").html("");
	
	$.ajax({
	   type: "POST",
	   url: "<?php echo base_url();?>product/deactive_franchise",
	   data: {'delete_id':id},
		   success : function(id) 
		   {
		   window.location = "<?php echo base_url();?>product/franchise";

		  
		}
	});

}
return false;
}

</script>
<script type="text/javascript">
function ConfirmEnable(id)
{
if(confirm("Are you sure you want to active this franchise?"))
{
	$(".message").html("");
	
	$.ajax({
	   type: "POST",
	   url: "<?php echo base_url();?>product/active_franchise",
	   data: {'delete_id':id},
		   success : function(id) 
		   {
		   window.location = "<?php echo base_url();?>product/franchise";

		  
		}
	});

}
return false;
}

</script>