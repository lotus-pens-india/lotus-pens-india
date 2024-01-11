<?php
class CartController extends  CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('GlobalModal');
	}

	public function addToCart()
	{
		if ($this->session->userdata('is_user_login') == true) {
			if (!empty($this->input->get_post('cartItems'))) {
				$activeCurrency = $this->session->userdata('active_currency');
				$cartItems = $this->input->get_post('cartItems');
				$userdata = $this->session->userdata('userdata');
				if (isset($userdata)) {
					$userId = $userdata['customer_id'];
					$checkCart = $this->GlobalModal->executeQuery("select * from lp_add_to_cart where customer_id=" . $userId);
					if ($checkCart) {
						$updateData = $this->GlobalModal->updateData('lp_add_to_cart', array('cart_json' => $cartItems), array('customer_id' => $userId));
					} else {
						$addData = $this->GlobalModal->addData('lp_add_to_cart', array('customer_id' => $userId, 'cart_json' => $cartItems));
					}
					$checkCartFinal = $this->GlobalModal->executeQuery("select * from lp_add_to_cart where customer_id=" . $userId);
					$response['status'] = 200;
					$response['body'] = $checkCartFinal[0];
				} else {
					$response['status'] = 200;
					$response['message'] = 'User not logged in';
				}
			} else {
				$response['status'] = 400;
				$response['body'] = 'Request parameters missing';
			}
		} else {
			$response['status'] = 200;
			$response['message'] = 'User not logged in';
		}
		echo json_encode($response);
	}

	public function viewCart()
	{
		if ($this->session->userdata('is_user_login') == true) {
			$userdata = $this->session->userdata('userdata');
			// var_dump($userdata);
			$userId = $userdata['customer_id'];
			$activeCurrency = $this->session->userdata('active_currency');
			$cartItemsResult = $this->GlobalModal->executeQuery("select * from lp_add_to_cart where customer_id=" . $userId);
			if ($cartItemsResult != false) {
				$cartItems = json_decode($cartItemsResult[0]['cart_json']);
				$productInfo['productInfo'] = [];
				$cartSummaryAmt = 0;
				$cartSummaryAmtInr = 0;
				if (isset($cartItems) && count($cartItems) > 0) {
					for ($i = 0; $i < count($cartItems); $i++) {
						if (isset($cartItems[$i])) {
							$productArray = [];
							$finalAmount = 0;
							$finalAmountInr = 0;
							$productId = $cartItems[$i]->productId;
							$products = $this->GlobalModal->executeQuery("select * from vegshopy_product vp
						inner join lp_product_price lpp on lpp.product_id=vp.product_id
						where vp.product_id=" . $productId . " and lpp.currency='" . $activeCurrency . "'");
						$productsInr = $this->GlobalModal->executeQuery("select * from vegshopy_product vp
						inner join lp_product_price lpp on lpp.product_id=vp.product_id
						where vp.product_id=" . $productId . " and lpp.currency='rupee'");
							$finalAmount += $products[0]['price'];
							$finalAmountInr += $productsInr[0]['price'];
							$productArray['productInformation'] = $products;
							if (isset($cartItems[$i]->nib)) {
								$nibId = $cartItems[$i]->nib;
								$nibData = $this->GlobalModal->executeQuery("select " . $activeCurrency . "_price,name from lp_nib_master where id=" . $nibId);
								$nibDataInr = $this->GlobalModal->executeQuery("select rupee_price,name from lp_nib_master where id=" . $nibId);
								$finalAmount += $nibData[0][$activeCurrency . "_price"];
								$finalAmountInr += $nibDataInr[0]["rupee_price"];
								
								$productArray['nibData'] = $nibData;
							} else {
								$productArray['nibData'] = [];
							}
							if (isset($cartItems[$i]->material)) {
								$materialId = $cartItems[$i]->material;
								$materialData = $this->GlobalModal->executeQuery("select " . $activeCurrency . "_price,name from lp_material_master where id=" . $materialId);
								$materialDataInr = $this->GlobalModal->executeQuery("select rupee_price,name from lp_material_master where id=" . $materialId);
								$finalAmount += $materialData[0][$activeCurrency . "_price"];
								$finalAmountInr += $materialDataInr[0]["rupee_price"];
								
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

							if ($cartItems[$i]->clipOption == 'with_clip') {
								$getActiveCurrnecyRate = $this->GlobalModal->executeQuery("select * from lp_currency_master where currency='" . $activeCurrency . "' limit 1");
								$getActiveCurrnecyRateInr = $this->GlobalModal->executeQuery("select * from lp_currency_master where currency='rupee' limit 1");
								if (count($getActiveCurrnecyRate) > 0) {
									$finalAmount += 5 * $getActiveCurrnecyRate[0]['usd_rate'];
									$finalAmountInr += 5 * $getActiveCurrnecyRateInr[0]['usd_rate'];
								}
							}
							$productArray['finalAmount'] = $finalAmount * $cartItems[$i]->quantity;
							$productArray['finalAmountInr'] = $finalAmountInr * $cartItems[$i]->quantity;
							$productArray['clipOption'] = $cartItems[$i]->clipOption;
							$productArray['quantity'] = $cartItems[$i]->quantity;
							$cartSummaryAmt += $finalAmount * $cartItems[$i]->quantity;
							$cartSummaryAmtInr += $finalAmountInr * $cartItems[$i]->quantity;
							array_push($productInfo['productInfo'], $productArray);
							// var_dump($materialData);
						}
					}
					$productInfo['cartItemsCount'] = count($cartItems);
					$productInfo['cartSummaryAmt'] = $cartSummaryAmt;
					$productInfo['cartSummaryAmtInr'] = $cartSummaryAmtInr;
					$productInfo['rawData'] = $cartItems;

					$response['status'] = 200;
					$response['body'] = $productInfo;
				} else {
					$response['status'] = 400;
					$response['body'] = "Empty cart";
				}
			} else {
				$response['status'] = 400;
				$response['body'] = "Empty cart";
			}
		} else {
			if (!empty($this->input->get_post('cartItems'))) {
				$activeCurrency = $this->session->userdata('active_currency');
				$cartItems = json_decode($this->input->get_post('cartItems'));
				$productInfo['productInfo'] = [];
				$cartSummaryAmt = 0;
				if (isset($cartItems) && count($cartItems) > 0) {
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
							if ($cartItems[$i]->clipOption == 'with_clip') {

								$getActiveCurrnecyRate = $this->GlobalModal->executeQuery("select * from lp_currency_master where currency='" . $activeCurrency . "' limit 1");
								if (count($getActiveCurrnecyRate) > 0) {

									$finalAmount += 5 * $getActiveCurrnecyRate[0]['usd_rate'];
								}
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
				}
				$response['status'] = 200;
				$response['body'] = $productInfo;
			} else {
				$response['status'] = 201;
				$response['body'] = 'Empty Cart';
			}
		}
		echo json_encode($response);
	}

	public function viewCartCount()
	{
		if ($this->session->userdata('is_user_login') == true) {
			$userdata = $this->session->userdata('userdata');
			// var_dump($userdata);
			$userId = $userdata['customer_id'];
			$activeCurrency = $this->session->userdata('active_currency');
			$cartItemsResult = $this->GlobalModal->executeQuery("select * from lp_add_to_cart where customer_id=" . $userId);
			if ($cartItemsResult != false) {
				$cartItems = json_decode($cartItemsResult[0]['cart_json']);
				if (isset($cartItems) && count($cartItems) > 0) {
					$productInfo['cartItemsCount'] = count($cartItems);
					$response['status'] = 200;
					$response['body'] = $productInfo;
				} else {
					$response['status'] = 400;
					$response['body'] = "Empty cart";
				}
			} else {
				$response['status'] = 400;
				$response['body'] = "Empty cart";
			}
		} else {
			if (!empty($this->input->get_post('cartItems'))) {
				$activeCurrency = $this->session->userdata('active_currency');
				$cartItems = json_decode($this->input->get_post('cartItems'));
				$productInfo=[];
				$cartSummaryAmt = 0;
				if (isset($cartItems) && count($cartItems) > 0) {
					$productInfo['cartItemsCount'] = count($cartItems);
				}
				$response['status'] = 200;
				$response['body'] = $productInfo;
			} else {
				$response['status'] = 201;
				$response['body'] = 'Empty Cart';
			}
		}
		echo json_encode($response);
	}

	
}
