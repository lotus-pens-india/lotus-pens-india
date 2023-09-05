<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('GlobalModal');
	}
	public function index()
	{
		$banners=$this->GlobalModal->executeQuery("select * from banner where isActive='0' order by position asc");
		$products=$this->GlobalModal->executeQuery("SELECT * FROM vegshopy_product VP
		inner join product_details PD on PD.product_id=VP.product_id order by rand() limit 10");
		$data=array('view_name'=>'Home/HomeView','data'=>array('banners'=>$banners,'products'=>$products));
		$this->load->view('welcome_message',$data);
	}

	public function cart()
	{
		$data=array('view_name'=>'Cart/index.php');
		$this->load->view('welcome_message',$data);
	}

	public function checkout()
	{
		$data=array('view_name'=>'Checkout/index.php');
		$this->load->view('welcome_message',$data);
	}

	public function product()
	{
		$data=array('view_name'=>'ProductDetails/index.php','data'=>array('banners'=>[],'products'=>[]));
		
		$this->load->view('welcome_message',$data);
	}
}
