<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('GlobalModal');
	}
	public function index()
	{
		$currency = $this->session->userdata('active_currency');
		$banners = $this->GlobalModal->executeQuery("select * from banner where isActive='0' order by position asc");
		$products = $this->GlobalModal->executeQuery("SELECT VP.*,PP.price as unit_price FROM vegshopy_product VP
		inner join lp_product_price PP on PP.product_id=VP.product_id
		where PP.currency='" . $currency . "'order by rand() limit 10");
		$testimonials = $this->GlobalModal->executeQuery("select * from lp_testimonials where status=1 order by position asc");
		$data = array('view_name' => 'Home/HomeView', 'data' => array('banners' => $banners, 'products' => $products, 'testimonials' => $testimonials));
		$this->load->view('welcome_message', $data);
	}

	public function cart()
	{
		$data = array('view_name' => 'Cart/index.php', 'data' => array());
		$this->load->view('welcome_message', $data);
	}

	public function checkout()
	{
		if ($this->session->userdata('is_user_login') == true) {
			$userdata = $this->session->userdata('userdata');
			$userId = $userdata['customer_id'];
			$cartItemsResult = $this->GlobalModal->executeQuery("select * from lp_add_to_cart where customer_id=" . $userId);
			if ($cartItemsResult != false) {
				$cartItems = json_decode($cartItemsResult[0]['cart_json']);
				$productInfo['productInfo'] = [];
				$cartSummaryAmt = 0;
				if (isset($cartItems) && count($cartItems) > 0) {
					$data = array('view_name' => 'Checkout/index.php', 'data' => array());
					$this->load->view('welcome_message', $data);
				} else {
					$data = array('view_name' => 'Global/EmptyCart.php', 'data' => array());
					$this->load->view('welcome_message', $data);
				}
			} else {
				$data = array('view_name' => 'Global/EmptyCart.php', 'data' => array());
				$this->load->view('welcome_message', $data);
			}
		} else {
			$data = array('view_name' => 'Global/LoginFirst.php', 'data' => array());
			$this->load->view('welcome_message', $data);
		}
	}

	public function product($product_id)
	{
		$currency = $this->session->userdata('active_currency');
		$products = $this->GlobalModal->executeQuery("SELECT * FROM vegshopy_product VP where VP.product_id=" . $product_id . " limit 1");
		if ($products != false && count($products) > 0) {
			$getActiveCurrencyRate = $this->GlobalModal->executeQuery("select * from lp_currency_master where currency='" . $currency . "'");
			$withClipAmt = 5 * $getActiveCurrencyRate[0]['usd_rate'];
			$nibIds = ($products[0]['nib'] != 'null' && $products[0]['nib'] != '') ? implode(',', json_decode($products[0]['nib'])) : '';
			$clipIds = ($products[0]['clip'] != 'null'  && $products[0]['clip'] != '')  ? implode(',', json_decode($products[0]['clip'])) : '';
			$materialIds = ($products[0]['material'] != 'null' && $products[0]['material'] != '') ? implode(',', json_decode($products[0]['material'])) : '';
			if ($nibIds != '') {
				$nib = $this->GlobalModal->executeQuery("SELECT * FROM lp_nib_master where status=1 and id in(" . $nibIds . ")");
			} else {
				$nib = [];
			}

			if ($clipIds != '') {
				$clip = $this->GlobalModal->executeQuery("SELECT * FROM lp_clip_master where status=1 and id in(" . $clipIds . ")");
			} else {
				$clip = [];
			}

			if ($materialIds != '') {
				$matrial = $this->GlobalModal->executeQuery("SELECT * FROM lp_material_master where status=1 and id in(" . $materialIds . ")");
			} else {
				$matrial = [];
			}
			$colors = $this->GlobalModal->executeQuery("SELECT * FROM product_details where product_id=" . $product_id);
			$price = $this->GlobalModal->executeQuery("SELECT * FROM lp_product_price where product_id=" . $product_id . " and currency=" . "'" . $currency . "'");
			$data = array('view_name' => 'ProductDetails/index.php', 'data' => array('matrial' => $matrial, 'nib' => $nib, 'clip' => $clip, 'products' => $products, 'details' => $colors, 'price' => $price, 'withClipAmt' => $withClipAmt));

			$this->load->view('welcome_message', $data);
		} else {
			$data = array('view_name' => 'Global/404', 'data' => array());
			$this->load->view('welcome_message', $data);
		}
	}

	public function changeCurrancy()
	{
		$currency = $this->input->get_post('currency');
		$symbol['euro'] = '€';
		$symbol['pound'] = '£';
		$symbol['rupee'] = '₹';
		$symbol['usd'] = '$';
		$this->session->set_userdata('active_currency', $currency);
		$this->session->set_userdata('currency_symbol', $symbol[$currency]);
		$response['status'] = 200;
		$response['body'] = 'Currenecy changed successfully';
		echo json_encode($response);
	}

	public function setDefaultCurrency()
	{
		$currency = 'usd';
		$symbol['euro'] = '€';
		$symbol['pound'] = '£';
		$symbol['rupee'] = '₹';
		$symbol['usd'] = '$';
		$this->session->set_userdata('active_currency', $currency);
		$this->session->set_userdata('currency_symbol', $symbol[$currency]);
		$response['status'] = 200;
		$response['body'] = 'Currenecy changed successfully';
		echo json_encode($response);
	}

	public function login()
	{
		$username = $this->input->get_post('username');
		$passwod = $this->input->get_post('password');
		if (isset($username) && isset($passwod)) {
			$customerLogin = $this->GlobalModal->executeQuery("SELECT * FROM customer  where username='" . $username . "' and password='" . md5($passwod) . "'");
			if (!empty($customerLogin) && $customerLogin > 0) {
				$this->session->set_userdata('is_user_login', true);
				$this->session->set_userdata('userdata', $customerLogin[0]);
				$symbol['euro'] = '€';
				$symbol['pound'] = '£';
				$symbol['rupee'] = '₹';
				$symbol['usd'] = '$';
				$this->session->set_userdata('active_currency', 'usd');
				$this->session->set_userdata('currency_symbol', $symbol['usd']);
				$response['status'] = 200;
				$response['body'] = $customerLogin[0];
			} else {
				$response['status'] = 400;
				$response['body'] = 'Invalid username/password';
			}
		} else {
			$response['status'] = 400;
			$response['body'] = 'Request parameters missing';
		}
		echo json_encode($response);
		// $this->session->set_userdata('is_user_login', true);
	}

	public function loadLogin()
	{
		$data = array('view_name' => 'Global/LoginSignupModal.php', 'data' => array());
		$this->load->view('welcome_message', $data);
	}

	public function logout()
	{
		$this->session->set_userdata('is_user_login', false);
		$this->session->unset_userdata('userdata');
		$response['status'] = 200;
		$response['body'] = 'Logout successfully';
		echo json_encode($response);
	}


	public function getCountries()
	{
		$countries = $this->GlobalModal->executeQuery('select * from countries');
		if ($countries != false) {
			$response['status'] = 200;
			$response['data'] = $countries;
		} else {
			$response['status'] = 400;
			$response['data'] = [];
		}
		echo json_encode($response);
	}

	public function getStates()
	{
		$countryId = $this->input->get_post('country');
		$states = $this->GlobalModal->executeQuery('select * from states where country_id=' . $countryId);
		if ($states != false) {
			$response['status'] = 200;
			$response['data'] = $states;
		} else {
			$response['status'] = 400;
			$response['data'] = [];
		}
		echo json_encode($response);
	}

	public function products()
	{
		$currency = $this->session->userdata('active_currency');
		$products = $this->GlobalModal->executeQuery("SELECT VP.*,PP.price as unit_price FROM vegshopy_product VP
		inner join lp_product_price PP on PP.product_id=VP.product_id
		where PP.currency='" . $currency . "'");
		$data = array('view_name' => 'Products/index', 'data' => array('products' => $products));
		$this->load->view('welcome_message', $data);
	}

	public function wishlist()
	{
		$currency = $this->session->userdata('active_currency');
		$products = $this->GlobalModal->executeQuery("SELECT VP.*,PP.price as unit_price FROM vegshopy_product VP
		inner join lp_product_price PP on PP.product_id=VP.product_id
		where PP.currency='" . $currency . "'");
		$data = array('view_name' => 'Products/index', 'data' => array('products' => $products));
		$this->load->view('welcome_message', $data);
	}

	public function signUp()
	{
		$firstname = $this->input->get_post('signup_firstname');
		$lastname = $this->input->get_post('signup_lastname');
		$mobile = $this->input->get_post('signup_mobile');
		$email = $this->input->get_post('signup_email');
		$username = $this->input->get_post('signup_username');
		$password = $this->input->get_post('signup_password');
		$addData = array(
			'email_id' => $email, 'full_name' => $firstname . " " . $lastname, 'first_name' => $firstname,
			'mobile_no' => $mobile,
			'last_name' => $lastname,
			'customer_img' => '',
			'pincode' => '',
			'city_id' => '',
			'referral_code' => '',
			'wallet' => '',
			'token' => '',
			'flag' => '',
			'flag' => date('Y-m-d'),
			'username' => $username,
			'password' => md5($password),
			'franchise_id' => 1,
			'user_type' => 1,
			'address' => '',
			'shop_name' => '',
			'gst_no' => '',
			'pan_no' => '',
			'c_name' => ''

		);
		$saveUserData = $this->GlobalModal->addData('customer', $addData);
		if ($saveUserData) {
			$customerLogin = $this->GlobalModal->executeQuery("SELECT * FROM customer  where username='" . $username . "' and password='" . md5($password) . "'");
			if (!empty($customerLogin) && $customerLogin > 0) {
				$this->session->set_userdata('is_user_login', true);
				$this->session->set_userdata('userdata', $customerLogin[0]);
				$symbol['euro'] = '€';
				$symbol['pound'] = '£';
				$symbol['rupee'] = '₹';
				$symbol['usd'] = '$';
				$this->session->set_userdata('active_currency', 'usd');
				$this->session->set_userdata('currency_symbol', $symbol['usd']);
				$response['status'] = 200;
				$response['body'] = $customerLogin[0];
			} else {
				$response['status'] = 400;
				$response['body'] = 'Invalid username/password';
			}
		} else {
			$response['status'] = 400;
			$response['message'] = 'Account Created';
		}
		echo json_encode($response);
	}

	public function profile()
	{
		if ($this->session->userdata('is_user_login') == true) {
			$userdata = $this->session->userdata('userdata');
			$userId = $userdata['customer_id'];
			$getUserProfile = $this->GlobalModal->executeQuery('select * from customer where customer_id=' . $userId);
			if ($getUserProfile != false) {
				$data = array('view_name' => 'Profile/index', 'data' => array('userDetails' => $getUserProfile[0]));
				$this->load->view('welcome_message', $data);
			} else {
				$data = array('view_name' => 'Global/404', 'data' => array());
				$this->load->view('welcome_message', $data);
			}
		} else {
			$data = array('view_name' => 'Global/LoginFirst.php', 'data' => array());
			$this->load->view('welcome_message', $data);
		}
	}
}
