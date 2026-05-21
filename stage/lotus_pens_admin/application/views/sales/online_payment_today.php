<div class="clearfix"></div>
	
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
		    <h4 class="page-title">Today Online Payment</h4>
		    <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javaScript:void();">Payment</a></li>
            <li class="breadcrumb-item"><a href="javaScript:void();">Today Online Payment Tables</a></li>
            <li class="breadcrumb-item active" aria-current="page">Today Online Payment Data Tables</li>
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
            <div class="card-header"><i class="fa fa-table"></i> Today Online Payment List</div>
            <div class="card-body">
              <div class="table-responsive">
              <table id="brand-datatable" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Order Code</th>
                        <th>No.of<br>products</th>
                        <th>Customer</th> 
                        <th>Amount</th>
                        <th>Payment mode</th>
                        <th>Saller</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
					   if ($online_payment != '')
						{
						$i = 1;
						foreach($online_payment as $post)
						{
				?> 
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><a href="<?php base_url('sales/view_invoice?order_id='.$post->order_generate_id) ?>"><?php echo '#'.$post->order_generate_id; ?></a></td>
                        <td>
                            <?php 
                                $this->db->select('COUNT(order_id) AS no_of_product');
                        		$this->db->from('order_detail');
                        		$this->db->where('order_id',$post->order_id);
                        	    $query  = $this->db->get();
                                $result = $query->row();
                                echo $no_of_product = $result->no_of_product;
                            ?>
                        </td>
                        <td><?php echo $post->first_name.' '.$post->last_name; ?></td>
                        <td><?php echo $post->order_total; ?></td>
                        <td>
                            <?php 
                               if($post->p_mode == '0')
                                {
                                    echo '<span class="badge badge-info shadow-info m-1">Cash</span>';
                                    
                                }
                                else{
                                  echo '<span class="badge badge-success shadow-success m-1">Online</span>';
                                  
                                }
                            ?>
                        </td>
                        <td><?php echo $post->franchise_name; ?></td>
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
