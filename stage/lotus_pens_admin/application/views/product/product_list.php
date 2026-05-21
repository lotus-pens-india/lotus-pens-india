<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Product List</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Product</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Product Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Product Data Tables</li>
         </ol>
	   </div>
	   <div class="col-sm-3">
       <div class="float-sm-right">
	     <a href="<?php echo base_url();?>product/upload_product">
           <button type="button" class="btn btn-primary waves-effect waves-light m-1">Add Product</button>
		 </a>  
      </div>
     </div>
     </div>
    <!-- End Breadcrumb-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Product List</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="product_datetable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Image</th>
						<th>Product Name</th>
						<th>Category</th>
						<th>Brand</th>
						<th>Avilable Qty</th>
						<th>Saller</th>
                        <th>Action</th>
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

<script type="text/javascript">
function ConfirmDelete(id)
{
if(confirm("Are you sure you want to delete this Record?"))
{
	$(".message").html("");
	
	$.ajax({
	   type: "POST",
	   url: "<?php echo base_url();?>product/delete_product",
	   data: {'delete_id':id},
		   success : function(id) {
		   var idd = "a.one_"+id+":parent";
		   $(idd).parents('tr').hide();
		  
		}
	});

}
return false;
}

</script>

<script type="text/javascript">
function ConfirmDelete1(id)
{
if(confirm("Are you sure this product out of stock?"))
{
	$(".message").html("");
	
	$.ajax({
	   type: "POST",
	   url: "<?php echo base_url();?>product/out_of_stock",
	   data: {'delete_id':id},
		   success : function(id) 
		   {
		  window.location.href="<?php echo base_url();?>product/product_list"; 
		  
		}
	});

}
return false;
}

</script>