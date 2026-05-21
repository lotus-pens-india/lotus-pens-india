<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Today Subscription Order</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Sales</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Today Subscription Order</a></li>
            <li class="breadcrumb-item active" aria-current="page">Today SubscriptionOrder Data Tables</li>
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
            <div class="card-header"><i class="fa fa-table"></i> Today Subscription List</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="brand-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Subscribe ID</th>
                        <th>Customer</th>
                        <th>Mobile no</th>
                        <th>Total Days</th>
                        <th>Date</th>
                        <th>Mode</th> 
                        <th>Assign to</th>
                        <th>Saller</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody>
            	<?php
			   if ($order_list != '')
				{
				$i = 1;
				foreach($order_list as $post)
				{
				?> 
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><a href="<?php echo base_url();?>sales/view_subscripe_details?subscribe_id=<?php echo $post['subscribe_id'] ?>"><?php echo '#'.$post['subscribe_generate_id']; ?></a></td>
                        <td><?php echo $post['first_name'].' '.$post['last_name']; ?></td>
                        <td><?php echo  $post['mobile_no']; ?></td>
                        <td><?php echo  $post['total_day']; ?></td>
                        <td><?php echo date("d-m-Y", strtotime($post['from_date'])).' To '.date("d-m-Y", strtotime($post['to_date'])); ?></td>
                        <td><?php echo  $post['subscribe_mode']; ?></td>
                        <td>
                            <?php 
                               if($post['assign_to'] !='')
                                {
                                    $this->db->select('*');
                            		$this->db->from('delivery_boy');
                            		$this->db->where('db_id',$post['assign_to']);
                            	    $query  = $this->db->get();
                                    $result = $query->row();
                                    $db_name = $result->name;
                                    
                                    echo $db_name;
                                }
                                else
                                {
                                    echo  '';
                                    
                                }
                            ?>
                        </td>
                        <td><?php echo  $post['franchise_name']; ?></td>
                        <td>
                            <a href="<?php echo base_url();?>sales/view_subscripe_details?subscribe_id=<?php echo $post['subscribe_id'] ?>"><button type="button" class="btn btn-primary waves-effect waves-light m-1"> <i class="fa fa-eye"> View</i> </button>
                        </td>
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
