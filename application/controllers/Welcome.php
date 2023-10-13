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
		inner join product_details PD on PD.product_id=VP.product_id order by rand() limit 10");
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

	public function product($product_id, $currency)
	{
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
		$this->session->set_userdata('active_currency', $currency);
	}


	public function login()
	{
		$this->session->set_userdata('is_user_login', true);
	}

	public function logout()
	{
		$this->session->set_userdata('is_user_login', false);
	}
}
