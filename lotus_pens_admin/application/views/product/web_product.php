<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Web Category Product</h4>
		    <ol class="breadcrumb">
       
            <li class="breadcrumb-item active" aria-current="page">Web Category Data Tables</li>
         </ol>
	   </div>
	  
     </div>
    <!-- End Breadcrumb-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Web Category List</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="web_table" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Category name</th>
                        <th>status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="web_category_table">
				
                </tbody>
                
            </table>
            </div>
            </div>
          </div>
        </div>
      </div><!-- End Row-->


    </div>
    <!-- End container-fluid-->
	
  <!-- Modal -->




<script type="text/javascript">
	$(function(){
	getweb_data();
	});
	
	function getweb_data(){
	     $.ajax({
        type: "POST",
          url: "<?php echo base_url();?>Product/get_web_category",
        dataType: "json",
        success: function (result) {
$('#web_category_table').empty();
            if (result.status === true) {
                $('#web_category_table').append(result.body);
            } else {
                $('#web_category_table').append(result.body);
            }
            $("#web_table").DataTable({
        "destroy": true,
        "processing": true

    });

        }, error: function (error) {
           
           
        }
    });
	}
	
	function change_status(category_id,status){
	    
	    $.ajax({
        type: "POST",
          url: "<?php echo base_url();?>Product/change_status",
        dataType: "json",
        data:{category_id:category_id,status:status},
        success: function (result) {

            if (result.status === true) {
             alert('Successfully');
             	getweb_data();
            } else {
                 alert('failed');
            }

        }, error: function (error) {
           
             alert('failed');
        }
    }); 
	}

</script>
