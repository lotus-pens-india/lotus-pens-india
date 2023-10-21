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
		$banners = $this->GlobalModal->executeQuery("select * from banner where isActive='0' order by position asc");
		$products = $this->GlobalModal->executeQuery("SELECT * FROM vegshopy_product VP
		inner join product_details PD on PD.product_id=VP.product_id group by VP.product_id order by rand() limit 10");
		$data = array('view_name' => 'Home/HomeView', 'data' => array('banners' => $banners, 'products' => $products));
		$this->load->view('welcome_message', $data);
	}

	public function cart()
	{
		$data = array('view_name' => 'Cart/index.php', 'data' => array());
		$this->load->view('welcome_message', $data);
	}

	public function checkout()
	{
		$data = array('view_name' => 'Checkout/index.php', 'data' => array());
		$this->load->view('welcome_message', $data);
	}

	public function product($product_id)
	{
		$currency = $this->session->userdata('active_currency');
		$products = $this->GlobalModal->executeQuery("SELECT * FROM vegshopy_product VP where VP.product_id=" . $product_id . " limit 1");
		if (count($products) > 0) {
			$nibIds = implode(',', json_decode($products[0]['nib']));
			$clipIds = implode(',', json_decode($products[0]['clip']));
			$materialIds = implode(',', json_decode($products[0]['material']));
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
		}

		$colors = $this->GlobalModal->executeQuery("SELECT * FROM product_details where product_id=" . $product_id);
		$price = $this->GlobalModal->executeQuery("SELECT * FROM lp_product_price where product_id=" . $product_id . " and currency=" . "'" . $currency . "'");
		$data = array('view_name' => 'ProductDetails/index.php', 'data' => array('matrial' => $matrial, 'nib' => $nib, 'clip' => $clip, 'products' => $products, 'details' => $colors, 'price' => $price));

		$this->load->view('welcome_message', $data);
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
			$customerLogin = $this->GlobalModal->executeQuery("SELECT customer_id,username,mobile_no,email_id,full_name,address FROM customer  where username='" . $username . "' and password='" . md5($passwod) . "'");
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
}
