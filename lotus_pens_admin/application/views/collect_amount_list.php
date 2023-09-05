<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Received payment record</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Delivery boy</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Received payment Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Received payment Data Tables</li>
         </ol>
	   </div>
	   <div class="col-sm-3">
       <div class="float-sm-right">
        
      </div>
     </div>
     </div>
    <!-- End Breadcrumb-->
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-header"><i class="fa fa-table"></i> Collect amount List</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="brand-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Delivery boy </th>
                         <th>Pay amount</th>
                        <th>Remaning Amount</th>
                        <th>Pay Date</th>
                        <th>Saller</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php
					   if ($all_db != '')
						{
						$i = 1;
						foreach($all_db as $wallet)
						{
				?> 
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $wallet->name ?></td>
                        <td><?php echo $wallet->debit ?></td>
                        <td><?php echo $wallet->wallet ?></td>
                        <td><?php echo $wallet->c_d_date ?></td>
                        <td><?php echo $wallet->franchise_name ?></td>
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
