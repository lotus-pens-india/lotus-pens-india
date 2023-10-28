<?php
class OrderController extends  CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('GlobalModal');
	}

	public function custOrderDetails()
	{
		if ($this->input->get_post('customer_id')) {
			$cust_id = $this->input->get_post('customer_id');
			$main_join_array = array();
			$join_array_0['join_0_table_1'] = ['table_name' => 'product_order', 'table_column' => 'order_id', 'join_type' => 'inner'];
			$join_array_0['join_0_table_2'] = ['table_name' => 'order_detail', 'table_column' => 'order_id'];
			$join_array_1['join_1_table_2'] = ['table_name' => 'coupon', 'table_column' => 'coupon_id'];
			$join_array_1['join_1_table_1'] = ['table_name' => 'product_order', 'table_column' => 'coupon_id', 'join_type' => 'left'];
			array_push($main_join_array, $join_array_0);
			array_push($main_join_array, $join_array_1);
			$data = $this->GlobalModal->getDataArrayJoin('product_order', array('product_order.*', 'order_detail.*', 'coupon.*'), array('product_order.customer_id' => $cust_id), $main_join_array);
			if ($data != false) {
				$response['status'] = 200;
				$response['body'] = $data;
			} else {
				$response['status'] = 201;
				$response['body'] = 'No Data Found';
			}
		} else {
			$response['body'] = 'Request Parameter Missing';
			$response['status'] = 201;
		}
		echo json_encode($response);
	}

	public function placeOrder()
	{
		if ($this->session->userdata('is_user_login') == true) {
			$userdata = $this->session->userdata('userdata');
			$userId = $userdata['customer_id'];
			// var_dump($userdata);;
			$orderData = $this->input->get_post('orderData');
			$customerInfo = $this->GlobalModal->executeQuery("select * from customer where customer_id=" . $userId . " limit 1");
			$activeCurrency = $this->session->userdata('active_currency');
			$cartItemsResult = $this->GlobalModal->executeQuery("select * from lp_add_to_cart where customer_id=" . $userId);
			$cartItems = json_decode($cartItemsResult[0]['cart_json']);
			$productInfo['productInfo'] = [];
			$cartSummaryAmt = 0;
			if (isset($cartItems) && count($cartItems) > 0) {
				$orderGeneratedId = $this->GlobalModal->generatedIds('product_order', 'order_generate_id', 'LP');
				$billingDetails = json_encode($orderData['billing_details']);
				$diliveryDetails = json_encode($orderData['delivery_details']);
				$orderEntryData = array(
					'order_generate_id' => $orderGeneratedId, 'customer_id' => $userId, 'order_total' => 0, 'delivery_charges' => 0,
					'coupon_id' => '', 'deliver_address' => $diliveryDetails, 'billing_address' => $billingDetails, 'order_date' => date('Y-m-d'), 'p_mode' => 0, 'rid' => '', 'payment_status' => 1, 'transaction_id' => '',
					'cancel_resion' => '', 'status' => 1, 'delivery_status' => 0, 'otp' => '', 'wallet_use' => 0, 'cancel_date' => '',
					'refund_status' => '', 'franchise_id' => 1, 'zone_id' => '', 'flag' => 1, 'order_currency' => $activeCurrency, 'entry_datetime' => date('Y-m-d H:i:s')
				);
				$orderInsertStatus = $this->GlobalModal->addData('product_order', $orderEntryData);
				if ($orderInsertStatus['status'] == 200) {
					$orderId = $orderInsertStatus['id'];
					$orderDetailsArray = [];
					for ($i = 0; $i < count($cartItems); $i++) {
						if (isset($cartItems[$i])) {
							$orderDetailsData = [];
							$finalAmount = 0;
							$materialPrice = 0;
							$nibPrice = 0;
							$productId = $cartItems[$i]->productId;
							$products = $this->GlobalModal->executeQuery("select * from vegshopy_product vp
						inner join lp_product_price lpp on lpp.product_id=vp.product_id
						where vp.product_id=" . $productId . " and lpp.currency='" . $activeCurrency . "'");
							$finalAmount += $products[0]['price'];
							$unitPrice = $products[0]['price'];
							$orderDetailsData['order_id'] = $orderId;
							$orderDetailsData['product_id'] = $productId;
							$orderDetailsData['product_name'] = $products[0]['product_name'];
							$orderDetailsData['qty'] = $cartItems[$i]->quantity;
							$orderDetailsData['unit'] = 'pcs';
							$orderDetailsData['clip_option'] = $cartItems[$i]->clipOption;

							if (isset($cartItems[$i]->nib)) {
								$nibId = $cartItems[$i]->nib;
								$nibData = $this->GlobalModal->executeQuery("select " . $activeCurrency . "_price,name from lp_nib_master where id=" . $nibId);
								$finalAmount += $nibData[0][$activeCurrency . "_price"];
								$nibPrice = $nibData[0][$activeCurrency . "_price"];
								$orderDetailsData['nib'] = $nibData[0]['name'];
							}
							if (isset($cartItems[$i]->material)) {
								$materialId = $cartItems[$i]->material;
								$materialData = $this->GlobalModal->executeQuery("select " . $activeCurrency . "_price,name from lp_material_master where id=" . $materialId);
								$finalAmount += $materialData[0][$activeCurrency . "_price"];
								$materialPrice = $materialData[0][$activeCurrency . "_price"];
								$orderDetailsData['material'] = $materialData[0]['name'];
							}
							if (isset($cartItems[$i]->clip)) {
								$clipId = $cartItems[$i]->clip;
								$clipData = $this->GlobalModal->executeQuery("select " . $activeCurrency . "_price,name from lp_clip_master where id=" . $clipId);
								$orderDetailsData['clip_and_ring'] = $clipData[0]['name'];
							}
							if ($cartItems[$i]->clipOption == 'with_clip') {
								$getActiveCurrnecyRate = $this->GlobalModal->executeQuery("select * from lp_currency_master where currency='" . $activeCurrency . "' limit 1");
								if (count($getActiveCurrnecyRate) > 0) {
									$finalAmount += 5 * $getActiveCurrnecyRate[0]['usd_rate'];
								}
							}
							$cartSummaryAmt += $finalAmount * $cartItems[$i]->quantity;
							$orderDetailsData['unit_price'] = $unitPrice;
							$orderDetailsData['discount'] = 0;
							$orderDetailsData['material_price'] = $materialPrice;
							$orderDetailsData['nib_price'] = $nibPrice;
							$orderDetailsData['sub_total'] = $unitPrice * $cartItems[$i]->quantity;
							$orderDetailsData['total'] = $finalAmount * $cartItems[$i]->quantity;
							array_push($orderDetailsArray, array('tableName' => 'order_detail', 'tableData' => $orderDetailsData));
						}
					}

					if (count($orderDetailsArray) > 0) {
						$orderDetailsInsertStatus = $this->GlobalModal->addDataArray($orderDetailsArray);
						$orderFinalAmountUpdate = $this->GlobalModal->updateData('product_order', array('order_total' => $cartSummaryAmt), array('order_id' => $orderId));
						$sendMailStatus = $this->GlobalModal->sendOrderPlaceMail($orderEntryData, $orderDetailsArray, $customerInfo, $cartSummaryAmt);
						$deleteCartData = $this->GlobalModal->deleteData('lp_add_to_cart', array('customer_id' => $userId));
						if ($orderDetailsInsertStatus) {
							$response['status'] = 200;
							$response['body'] = "Order placed successfully";
						}
					} else {
						$response['status'] = 400;
						$response['body'] = "Order details not found";
					}

					$response['status'] = 200;
					$response['body'] = '';
				} else {
					$response['status'] = 400;
					$response['body'] = "Error to place order";
				}
			} else {
				$response['status'] = 400;
				$response['body'] = "Empty cart";
			}
		} else {
			$response['status'] = 400;
			$response['body'] = "Not Logged in";
		}
		echo json_encode($response);
	}
}
