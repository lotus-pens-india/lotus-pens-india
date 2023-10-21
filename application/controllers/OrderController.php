<?php
class OrderController extends  CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('GlobalModal');
	}

	public function custOrderDetails(){
		if($this->input->get_post('customer_id')){
			$cust_id=$this->input->get_post('customer_id');
			$main_join_array=array();
			$join_array_0['join_0_table_1']=['table_name'=>'product_order','table_column'=>'order_id','join_type'=>'inner'];
			$join_array_0['join_0_table_2']=['table_name'=>'order_detail','table_column'=>'order_id'];
			$join_array_1['join_1_table_2']=['table_name'=>'coupon','table_column'=>'coupon_id'];
			$join_array_1['join_1_table_1']=['table_name'=>'product_order','table_column'=>'coupon_id','join_type'=>'left'];
			array_push($main_join_array,$join_array_0);
			array_push($main_join_array,$join_array_1);
			$data=$this->GlobalModal->getDataArrayJoin('product_order',array('product_order.*','order_detail.*','coupon.*'),array('product_order.customer_id'=>$cust_id),$main_join_array);
			if($data!=false){
				$response['status']=200;
				$response['body']=$data;
			}else{
				$response['status']=201;
				$response['body']='No Data Found';
			}
		}else{
			$response['body']='Request Parameter Missing';
			$response['status']=201;
		}
		echo json_encode($response);
	}

	public function placeOrder(){
		if ($this->session->userdata('is_user_login') == true) {
			$userdata = $this->session->userdata('userdata');
			$userId = $userdata['customer_id'];
			// var_dump($userdata);;
			$activeCurrency = $this->session->userdata('active_currency');
			$cartItemsResult = $this->GlobalModal->executeQuery("select * from lp_add_to_cart where customer_id=" . $userId);
			$cartItems = json_decode($cartItemsResult[0]['cart_json']);
			$productInfo['productInfo'] = [];
			$cartSummaryAmt = 0;
			if (isset($cartItems) && count($cartItems) > 0) {
				$orderEntryData=array('order_generate_id'=>'LP000098','customer_id'=>$userId,'order_total'=>0,'delivery_charges'=>0,
			'coupon_id'=>'','deliver_address'=>'dsfsdfsdf','order_date'=>date('Y-m-d H:i:s'),'p_mode'=>0,'rid'=>'','payment_status'=>1,'transaction_id'=>'',
			'cancel_resion'=>'','status'=>1,'delivery_status'=>0,'otp'=>'','wallet_use'=>0,'cancel_date'=>'',
			'refund_status'=>'','franchise_id'=>1,'zone_id'=>'','flag'=>1,'entry_datetime'=>date('Y-m-d H:i:s'));
			$orderInsertStatus=$this->GlobalModal->addData('product_order',$orderEntryData);
			var_dump($orderEntryData);
				for ($i = 0; $i < count($cartItems); $i++) {
					if (isset($cartItems[$i])) {
						$productArray = [];
						$finalAmount = 0;
						$productId = $cartItems[$i]->productId;
						$products = $this->GlobalModal->executeQuery("select * from vegshopy_product vp
						inner join lp_product_price lpp on lpp.product_id=vp.product_id
						where vp.product_id=" . $productId . " and lpp.currency='" . $activeCurrency . "'");
						$finalAmount += $products[0]['price'];
						$productArray['productInformation'] = $products;
						if (isset($cartItems[$i]->nib)) {
							$nibId = $cartItems[$i]->nib;
							$nibData = $this->GlobalModal->executeQuery("select " . $activeCurrency . "_price,name from lp_nib_master where id=" . $nibId);
							$finalAmount += $nibData[0][$activeCurrency . "_price"];
							$productArray['nibData'] = $nibData;
						} else {
							$productArray['nibData'] = [];
						}
						if (isset($cartItems[$i]->material)) {
							$materialId = $cartItems[$i]->material;
							$materialData = $this->GlobalModal->executeQuery("select " . $activeCurrency . "_price,name from lp_material_master where id=" . $materialId);
							$finalAmount += $materialData[0][$activeCurrency . "_price"];
							$productArray['materialData'] = $materialData;
						} else {
							$productArray['materialData'] = [];
						}
						if (isset($cartItems[$i]->clip)) {
							$clipId = $cartItems[$i]->clip;
							$clipData = $this->GlobalModal->executeQuery("select " . $activeCurrency . "_price,name from lp_clip_master where id=" . $clipId);
							$productArray['clipData'] = $clipData;
						} else {
							$productArray['clipData'] = [];
						}
						$productArray['finalAmount'] = $finalAmount * $cartItems[$i]->quantity;
						$productArray['clipOption'] = $cartItems[$i]->clipOption;
						$productArray['quantity'] = $cartItems[$i]->quantity;
						$cartSummaryAmt += $finalAmount * $cartItems[$i]->quantity;
						array_push($productInfo['productInfo'], $productArray);
						// var_dump($materialData);
					}
				}
				$productInfo['cartItemsCount'] = count($cartItems);
				$productInfo['cartSummaryAmt'] = $cartSummaryAmt;
				$productInfo['rawData'] = $cartItems;

				$response['status'] = 200;
				$response['body'] = $productInfo;
				$orderEntryData=array('order_generate_id'=>'LP000098','customer_id'=>$userId,'order_total'=>0,'delivery_charges'=>0,
			'coupon_id'=>'','deliver_address'=>'dsfsdfsdf','order_date'=>date('Y-m-d H:i:s'),'p_mode'=>0,'rid'=>'','payment_status'=>1,'transaction_id'=>'',
			'cancel_resion'=>'','status'=>1,'delivery_status'=>0,'otp'=>'','wallet_use'=>0,'cancel_date'=>'',
			'refund_status'=>'','franchise_id'=>1,'zone_id'=>'','flag'=>1,'entry_datetime'=>date('Y-m-d H:i:s'));
			} else {
				$response['status'] = 400;
				$response['body'] = "Empty cart";
			}
		}
	}

}
?>

