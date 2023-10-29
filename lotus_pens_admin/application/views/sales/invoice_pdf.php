<?php 

$login_type   = $this->session->userdata('type');
$company_name   = $this->session->userdata('company_name');
$company_email   = $this->session->userdata('company_email');
$company_phone   = $this->session->userdata('company_phone');

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Invoice</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>
<body style="font-size:10px;">


<div class="container"> 
	<table class="table table-bordered" style="border:1px solid #333;padding: 15px;">
	
		<tr>
		    
		  <td>
		       <img src="<?php echo base_url();?>assets/images/login.jpg" style="height:65px; margin-top: -18px;"> 
		   
	     </td>	
          <td align="right">
		    <h1>Invoice no : #<?php echo $order_summary->order_generate_id ?></h1>
		  </td>		  
		</tr>
		
        <tr>
		   <td style="border:1px solid #333;font-size:12px">
		    <strong>To,</strong><br>
			<b><?php echo $order_summary->first_name.' '.$order_summary->last_name ?></b><br>
			<?php echo $order_summary->deliver_address; ?><br>
			
			 <td><b>Mobile : <?php echo $order_summary->mobile_no; ?></b></td>

             Email : <?php echo $order_summary->email_id; ?>
		   </td>
		   <td style="border:1px solid #333;padding:10px;" align="right">
		      <b>Invoice no : </b>#<?php echo $order_summary->order_generate_id ?><br><b>Dated: </b><?php echo $order_summary->order_date ?>
		      <br><b>Payment Mode:</b><?php if($order_summary->p_mode == '0'){ echo 'Cash on delivery'; } elseif($order_summary->p_mode == '1') { echo 'Online payment';} elseif($order_summary->p_mode == '2') { echo 'Swipe machine';} ?><br>
		      
		      <b>Slot : 
                        <?php 
                                 $CI =& get_instance();
        						$CI->load->model('product_model');
        						$result1 = $CI->product_model->get_slot_id_wise_model($order_summary->slot_id);
        						
        						echo $result1->day.' '.$result1->slot_timing;
        						
                        ?>
                        </b>
		   </td>
		</tr>
        	
	</table>

	<table class="table table-bordered" style="border:1px solid #333;padding: 10px;">
	   <thead>
		<tr>
		    <td style="border-right:1px solid #333;border-bottom:1px solid #333;" width="10%">Unit</td>
			<td style="border-right:1px solid #333;border-bottom:1px solid #333;" width="10%">Qty</td>
			<td style="border-right:1px solid #333;border-bottom:1px solid #333;" width="43%" >Product</td>
			<td style="border-right:1px solid #333;border-bottom:1px solid #333;" width="10%">Unit Price</td>
			<td style="border-right:1px solid #333;border-bottom:1px solid #333;" width="15%">Discount</td>
			<td style="border-right:1px solid #333;border-bottom:1px solid #333;" width="12%" align="right">Subtotal</td>
			

		</tr>
	</thead>
	<tbody>
       <?php
                              
            $CI =& get_instance();
			$CI->load->model('product_model');
			$result = $CI->product_model->get_item_details1($order_summary->order_id);
			$sum = 0;
            foreach($result as $p_detail)
	        {
          ?>
        <tr>
          <td style="border-right:1px solid #333;border-bottom:1px solid #333;" width="10%"><?php echo $p_detail->unit; ?></td>    
          <td style="border-right:1px solid #333;border-bottom:1px solid #333;" width="10%"><?php echo $p_detail->qty; ?></td>
          <td style="border-right:1px solid #333;border-bottom:1px solid #333;" width="43%"><?php echo $p_detail->product_name; ?></td>
          <td style="border-right:1px solid #333;border-bottom:1px solid #333;" width="10%"><?php echo $p_detail->unit_price; ?></td>
          <td style="border-right:1px solid #333;border-bottom:1px solid #333;" width="15%"><?php echo $p_detail->discount* $p_detail->qty; ?></td>
          <td style="border-right:1px solid #333;border-bottom:1px solid #333; text-align:right;" width="12%"><?php $a = ($p_detail->qty * $p_detail->unit_price ); if ($p_detail->discount > 0) { $b = $p_detail->discount * $p_detail->qty; $sum+= $a - $b;  echo $sub_total = $a - $b;  } else { $sum+=$a;  echo $sub_total = $a; }?> </td>
          
        </tr>
       <?php } ?>
       <tr>
		    <td colspan="4" rowspan="6" style="border-right:1px solid #333;border-bottom:1px solid #333;"></td>
			<td style="border-right:1px solid #333;border-bottom:1px solid #333;text-align:right" >Total Unit Price</td>
			<td style="border-right:1px solid #333;border-bottom:1px solid #333;text-align:right">Rs. <?php echo $order_summary->total_bag; ?></td>
		</tr>
		 <tr>
			<td style="border-right:1px solid #333;border-bottom:1px solid #333;text-align:right" >Total Savings</td>
			<td style="border-right:1px solid #333;border-bottom:1px solid #333;text-align:right">Rs. <?php echo round($order_summary->bag_discount); ?></td>
		</tr>
		<?php if($order_summary->wallet_use > 0) { ?>
         <tr>
          <td style="border-right:1px solid #333;border-bottom:1px solid #333;text-align:right" >Wallet Use</td>
          <td style="border-right:1px solid #333;border-bottom:1px solid #333;text-align:right">Rs. <?php echo $order_summary->wallet_use; ?></td>
        </tr>
       
        <?php } ?>
        <tr>
			<td style="border-right:1px solid #333;border-bottom:1px solid #333;text-align:right" >Subtotal</td>
			<td style="border-right:1px solid #333;border-bottom:1px solid #333;text-align:right">Rs. <?php echo $order_summary->total_bag - round($order_summary->bag_discount) - $order_summary->wallet_use ; ?></td>
		</tr>

		<tr>
			<td style="border-right:1px solid #333;border-bottom:1px solid #333;text-align:right" >Delivery Charge</td>
			<td style="border-right:1px solid #333;border-bottom:1px solid #333;text-align:right"><?php if($order_summary->delivery_charges == '0') { echo 'Free'; } else { ?>Rs. <?php echo round($order_summary->delivery_charges).' '.'+'; }?></td>
		</tr>
		
        <?php if($order_summary->coupon_id != '') { ?>
         <tr>
          <td style="border-right:1px solid #333;border-bottom:1px solid #333;text-align:right">Coupon Amount </td>
          <td style="border-right:1px solid #333;border-bottom:1px solid #333;text-align:right">
          Rs. <?php
          
                 $CI =& get_instance();
				 $CI->load->model('product_model');
			  	 $result1 = $CI->product_model->get_coupon_value($order_summary->coupon_id);
                 echo $c = $result1->value; ?></td>
        </tr>
        <tr>
          <td style="border-right:1px solid #333;border-bottom:1px solid #333;text-align:right">Grand Total</td>
          <td style="border-right:1px solid #333;border-bottom:1px solid #333;text-align:right">Rs. <?php echo round($order_summary->order_total); ?></td>
        </tr>
        <?php } else { ?>
        
        <tr>
          <td style="border-right:1px solid #333;border-bottom:1px solid #333;text-align:right; font-size: 12px;"><b>Grand Total </b></td>
          <td style="border-right:1px solid #333;border-bottom:1px solid #333;text-align:right; font-size: 12px;"><b>Rs. <?php echo $order_summary->order_total; ?></b></td>
        </tr>
        <?php } ?>
		
	</tbody>
  </table>
  <table class="table table-bordered" style="border:1px solid #333;padding: 15px;">
	   <tr>
		  <td>
		     
			  <p><b>Terms & Conditions</b></p>
			  <p>Dear customer, kindly check the delivered material/veggies, Fruits or any other items. for any damage or shortage at the time of delivery n report the same to delivery boy.Once it is delivered we will not be responsible.<br>For Support Call: +91 9819122200, Gpay,Phonepe,Paytm.9819122200</p>
		  </td>
		</tr>
       
	   <tr>
	     <td>
		 
		    <p style="margin-left:-20px;">Thanking You,<br>for shopping with us.</p>
			

		 </td>
	   </tr>
       	   
	</table>
  
</div>


 </body>
</html>