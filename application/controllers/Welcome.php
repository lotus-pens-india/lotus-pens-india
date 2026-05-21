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
		$featured = $this->GlobalModal->executeQuery("select * from lp_featured where status=1 order by position asc limit 4");
		$banners = $this->GlobalModal->executeQuery("select * from banner where isActive='0' order by position asc");
		$products = $this->GlobalModal->executeQuery("SELECT VP.*,PP.price as unit_price FROM vegshopy_product VP
		inner join lp_product_price PP on PP.product_id=VP.product_id
		where PP.currency='" . $currency . "'order by rand() limit 10");
		$testimonials = $this->GlobalModal->executeQuery("select * from lp_testimonials where status=1 order by position asc");
		$metaData=array('title'=>'Premium Quality Personalized Writing Instruments - Lotus Pens','description'=>'Discover exquisite 
		custom hand-made pens at Lotus Pens. Our premium quality, personalized writing 
		instruments are crafted with precision and elegance, perfect for collectors, professionals,
		 and special gifts. Ship globally to bring the art of fine writing to your doorstep',
		'keywords'=>'Custom hand-made pens,Personalized writing pens, Premium quality pens, Luxury pens, 
		Custom pens online, Handcrafted pens,
		Custom pens for gifts, High-quality writing instruments, Unique writing pens, Collectible pens, Luxury personalized pens,
		Handmade pens for sale, Best custom pens, Exclusive writing pens, Lotus Pens,  Lotus Writing Instruments'
	);
		$data = array('view_name' => 'Home/HomeView', 'data' => array('banners' => $banners, 'products' => $products, 'testimonials' => $testimonials, 'featured' => $featured,'metaData'=>$metaData));
		$this->load->view('welcome_message', $data);
	}

	public function cart()
	{
		$metaData=array('title'=>'Your Cart - Lotus Pens | Review and Complete Your Order','description'=>'Review your selection of 
		premium Lotus pens in your cart. Edit items, check quantities, and proceed to a secure
		 checkout for fast shipping. Enjoy a seamless shopping experience with Lotus Pens.',
			'keywords'=>'Lotus pens, shopping cart, view cart, pen purchase, review order, buy Lotus pens, 
			secure checkout, online shopping, 
			writing instruments, cart review'
			);
		$data = array('view_name' => 'Cart/index.php', 'data' => array('metaData'=>$metaData));
		$this->load->view('welcome_message', $data);
	}

	public function checkout($coupon_code = null)
	{
		if ($this->session->userdata('is_user_login') == true) {
			$userdata = $this->session->userdata('userdata');
			$userId = $userdata['customer_id'];
			$cartItemsResult = $this->GlobalModal->executeQuery("select * from lp_add_to_cart where customer_id=" . $userId);
				$metaData=array('title'=>'Checkout - Lotus Pens | Secure Your Purchase','description'=>'Complete your purchase of premium 
				Lotus pens securely. Review your order, add payment information, and enjoy fast shipping. 
				Shop with confidence at Lotus Pens.',
			'keywords'=>'Lotus pens, checkout, buy Lotus pens, pen purchase, premium pens, buy online, secure checkout, 
			fast shipping, writing instruments'
			);
			if ($cartItemsResult != false) {
				$cartItems = json_decode($cartItemsResult[0]['cart_json']);
				$productInfo['productInfo'] = [];
				$cartSummaryAmt = 0;
				if (isset($cartItems) && count($cartItems) > 0) {
					$data = array('view_name' => 'Checkout/index.php', 'data' => array('metaData'=>$metaData));
					$this->load->view('welcome_message', $data);
				} else {
					$data = array('view_name' => 'Global/EmptyCart.php', 'data' => array('metaData'=>$metaData));
					$this->load->view('welcome_message', $data);
				}
			} else {
				$data = array('view_name' => 'Global/EmptyCart.php', 'data' => array('metaData'=>$metaData));
				$this->load->view('welcome_message', $data);
			}
		} else {
			$data = array('view_name' => 'Global/LoginFirst.php', 'data' => array('metaData'=>$metaData));
			$this->load->view('welcome_message', $data);
		}
	}

	public function product($product_id)
	{
		$currency = $this->session->userdata('active_currency');
		$products = $this->GlobalModal->executeQuery("SELECT * FROM vegshopy_product VP where VP.product_id=" . $product_id . " limit 1");
		if ($products != false && count($products) > 0) {
			$metaData=array('title'=>'Buy '.$products[0]['product_name'].' Lotus Pen | Premium Quality Pens','description'=>substr(strip_tags($products[0]['description']), 0, 160),
			'keywords'=>$products[0]['product_name'].'|'.strip_tags($products[0]['description']));
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
			$reviews = $this->GlobalModal->executeQuery("SELECT * FROM lp_product_reviews where status=1 and product_id=" . $product_id);
			$colors = $this->GlobalModal->executeQuery("SELECT * FROM product_details where product_id=" . $product_id);
			$price = $this->GlobalModal->executeQuery("SELECT * FROM lp_product_price where product_id=" . $product_id . " and currency=" . "'" . $currency . "'");
			$data = array('view_name' => 'ProductDetails/index.php', 'data' => array('matrial' => $matrial, 'nib' => $nib, 'clip' => $clip, 'products' => $products, 'details' => $colors, 
			'price' => $price, 'withClipAmt' => $withClipAmt, 'reviews' => $reviews,'metaData'=>$metaData));
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
		where PP.currency='" . $currency . "' and VP.category_id!=4 and VP.status=1");
		$keywords='Lotus pens, premium writing instruments, buy Lotus pens online, luxury pens, high-quality pens, pen collection, professional pens, best pens for writing';
		if(isset($products) && is_array($products) && count($products) >0){
			$keywords='';
			foreach ($products as $product) {
				$keywords.=$product['product_name'].', ';
			}
		}
		$metaData=array('title'=>'Buy Lotus Pens - Premium Writing Instruments | Best Deals Online',
		'description'=>'Browse and buy premium Lotus pens online. Our collection includes high-quality writing instruments for professionals and enthusiasts. Shop now for exclusive deals and fast shipping.',
		'keywords'=>$keywords);
		$data = array('view_name' => 'Products/index', 'data' => array('products' => $products,'metaData'=>$metaData));
		$this->load->view('welcome_message', $data);
	}

	public function customHandPaintedProducts()
	{
		$currency = $this->session->userdata('active_currency');
		$products = $this->GlobalModal->executeQuery("SELECT VP.*,PP.price as unit_price FROM vegshopy_product VP
		inner join lp_product_price PP on PP.product_id=VP.product_id
		where PP.currency='" . $currency . "' and VP.category_id=3 and VP.status=1");
		$keywords='Lotus pens, premium writing instruments, buy Lotus pens online, luxury pens, high-quality pens, pen collection, professional pens, best pens for writing';
		if(isset($products) && is_array($products) && count($products) >0){
			$keywords='';
			foreach ($products as $product) {
				$keywords.=$product['product_name'].', ';
			}
		}
		$metaData=array('title'=>'Custom Handmade Pens - Unique, Personalized Writing Instruments',
		'description'=>'Discover custom handmade pens, crafted by skilled artisans for a unique and personalized writing experience. Choose your design, material, and finish to create your perfect pen. Shop now for quality, exclusive pens.',
		'keywords'=>$keywords);
		$data = array('view_name' => 'Products/index', 'data' => array('products' => $products,'metaData'=>$metaData));
		$this->load->view('welcome_message', $data);
	}

	public function customPens()
	{
		$currency = $this->session->userdata('active_currency');
		$products = $this->GlobalModal->executeQuery("SELECT VP.*,PP.price as unit_price FROM vegshopy_product VP
		inner join lp_product_price PP on PP.product_id=VP.product_id
		inner join category CT on CT.category_id=VP.category_id
		where PP.currency='" . $currency . "' and CT.name='Custom Fountain Pens'");
		$data = array('view_name' => 'Products/index', 'data' => array('products' => $products));
		$this->load->view('welcome_message', $data);
	}

	public function productsByCategory($cat_id)
	{
		$currency = $this->session->userdata('active_currency');
		$products = $this->GlobalModal->executeQuery("SELECT VP.*,PP.price as unit_price FROM vegshopy_product VP
		inner join lp_product_price PP on PP.product_id=VP.product_id
		where PP.currency='" . $currency . "' and VP.category_id=" . $cat_id);
		$keywords='pen accessories, pen refills, ink refills, pen cases, writing accessories, pen ink, custom pen accessories, high-quality pen supplies, writing instrument accessories';
		if(isset($products) && is_array($products) && count($products) >0){
			$keywords='';
			foreach ($products as $product) {
				$keywords.=$product['product_name'].', ';
			}
		}
		$metaData=array('title'=>'Pen Accessories-Refills, Cases, Ink | Premium Writing Supplies',
		'description'=>'Browse premium pen accessories including refills, ink, cases, and more. Enhance your writing experience with high-quality products designed for Lotus pens and other writing instruments. Shop now for reliable, essential accessories.',
		'keywords'=>$keywords);
		if ($products != false) {
			$data = array('view_name' => 'Products/index', 'data' => array('products' => $products,'metaData'=>$metaData));
			$this->load->view('welcome_message', $data);
		} else {
			$data = array('view_name' => 'Global/404', 'data' => array());
			$this->load->view('welcome_message', $data);
		}
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

	public function aboutUs()
	{
		$metaData=array('title'=>'About Us - Lotus Pens | Premium Writing Instruments',
		'description'=>'Learn more about Lotus Pens. We craft premium writing instruments for professionals and enthusiasts, blending timeless design with exceptional craftsmanship. Discover our story, mission, and commitment to quality.',
		'keywords'=>'about Lotus pens, premium writing instruments, professional pens, handcrafted pens, pen craftsmanship, writing instruments company, luxury pens, pen brand story, pen manufacturing values');
		$data = array('view_name' => 'AboutUs/index', 'data' => array('metaData'=>$metaData));
		$this->load->view('welcome_message', $data);
	}

	public function faqs()
	{
		$metaData=array('title'=>'FAQs - Lotus Pens | Answers to Common Questions',
		'description'=>'Find answers to common questions about Lotus Pens. Learn more about our products, shipping policies, returns, and customer support.',
		'keywords'=>'FAQs, frequently asked questions, Lotus Pens FAQs, product questions, shipping policies, return policies, customer support, pen information');
		$data = array('view_name' => 'Faqs/index', 'data' => array('metaData'=>$metaData));
		$this->load->view('welcome_message', $data);
	}

	public function privacy_policy()
	{
		$metaData=array('title'=>'Privacy Policy - Lotus Pens',
		'description'=>'Read the privacy policy of Lotus Pens. Learn how we collect, use, and protect your personal data when you use our services and purchase our products.',
		'keywords'=>'privacy policy, Lotus Pens privacy, data protection, personal information, privacy practices, data usage, user privacy, Lotus Pens terms');
		$data = array('view_name' => 'Privacy/index', 'data' => array('metaData'=>$metaData));
		$this->load->view('welcome_message', $data);
	}

	public function contactUs()
	{
		$metaData=array('title'=>'Contact Us - Get in Touch with Lotus Pens',
		'description'=>'Contact Lotus Pens for inquiries, support, or more information about our premium writing instruments. We are here to help!',
		'keywords'=>'contact Lotus pens, customer support, inquiries, contact us page, premium writing instruments, Lotus pens support');
		$data = array('view_name' => 'ContactUs/index', 'data' => array('metaData'=>$metaData));
		$this->load->view('welcome_message', $data);
	}

	public function aboutAUs()
	{
		$metaData=array('title'=>'About Us Lotus Pens by Arun Singhi | Premium Writing Instruments',
		'description'=>'Learn more about Lotus Pens, founded by Arun Singhi. We craft premium writing instruments for professionals, blending timeless design with exceptional craftsmanship. Discover our story, our mission, and our commitment to quality',
		'keywords'=>'about Lotus pens, Arun Singhi, premium writing instruments, professional pens, handcrafted pens, pen craftsmanship, writing instruments company, luxury pens, pen brand story, pen manufacturing values');
		$data = array('view_name' => 'AboutUs/about_arun_singhi', 'data' => array('metaData'=>$metaData));
		$this->load->view('welcome_message', $data);
	}

	public function wishlist()
	{
		$currency = $this->session->userdata('active_currency');
		$products = $this->GlobalModal->executeQuery("SELECT VP.*,PP.price as unit_price FROM vegshopy_product VP
		inner join lp_product_price PP on PP.product_id=VP.product_id
		inner join category CT on CT.category_id=VP.category_id
		where PP.currency='" . $currency . "' and CT.name='Custom Hand Painted Fountain Pens'");
		$data = array('view_name' => 'Wishlist/index', 'data' => array('products' => $products));
		$this->load->view('welcome_message', $data);
	}

	public function wishlistItems()
	{
		$productIds = $this->input->get_post('wishlistItems');
		$arr = implode(json_decode($productIds), ',');
		$currency = $this->session->userdata('active_currency');
		$products = $this->GlobalModal->executeQuery("SELECT VP.*,PP.price as unit_price FROM vegshopy_product VP
		inner join lp_product_price PP on PP.product_id=VP.product_id where
		PP.currency='" . $currency . "' and
		 VP.product_id in (" . $arr . ")");
		if ($products != false) {
			echo json_encode(array('status' => 200, 'data' => $products));
		} else {
			echo json_encode(array('status' => 401, 'data' => []));
		}
	}

	public function addPrice()
	{
		$getPros = 'select product_id from vegshopy_product';
		$prodData = $this->GlobalModal->executeQuery($getPros);
		$currencyArray = ['rupee', 'usd', 'pound', 'euro'];
		foreach ($prodData as $pData) {
			foreach ($currencyArray as $cData) {
				$this->GlobalModal->addData('lp_product_price', array('product_id' => $pData['product_id'], 'currency' => $cData, 'mrp' => 100, 'price' => 100, 'discount' => 0));
			}
		}
	}

	public function featured()
	{
		$featured = $this->GlobalModal->executeQuery("select * from lp_featured where status=1 order by position asc limit 4");
		$data = array('view_name' => 'Featured/index', 'data' => array('featured' => $featured));
		$this->load->view('welcome_message', $data);
	}


	public function searchProducts($product_name)
	{
		$currency = $this->session->userdata('active_currency');
		$products = $this->GlobalModal->executeQuery("SELECT VP.*,PP.price as unit_price FROM vegshopy_product VP
		inner join lp_product_price PP on PP.product_id=VP.product_id
		where PP.currency='" . $currency . "' and VP.product_name like '%" . $product_name . "%'");
		$data = array('view_name' => 'Products/index', 'data' => array('products' => $products));
		if ($products != false) {
			$data = array('view_name' => 'Products/index', 'data' => array('products' => $products));
			$this->load->view('welcome_message', $data);
		} else {
			$data = array('view_name' => 'Global/404', 'data' => array());
			$this->load->view('welcome_message', $data);
		}
	}

	public function saveProductReview()
	{
		$product_id = $this->input->get_post('product_id');
		$customer_name = $this->input->get_post('customer_name');
		$review = $this->input->get_post('review');
		$ratings = $this->input->get_post('rating');
		$insertArray = array('product_id' => $product_id, 'customer_name' => $customer_name, 'review' => $review, 'ratings' => $ratings, 'status' => 1, 'created_at' => date("d M Y"));
		$saveData = $this->GlobalModal->addData('lp_product_reviews', $insertArray);
		echo json_encode($saveData);
	}
	
	public function getMaterialImage()
	{
		$material_id = $this->input->get_post('id');
		$matrial = $this->GlobalModal->executeQuery("SELECT * FROM lp_material_master where status=1 and id=".$material_id);
		echo json_encode($matrial);
	}
	
	public function sendEnquiry()
	{
		$firstName = $this->input->get_post('fname');
		$lastName = $this->input->get_post('lname');
		$Phone = $this->input->get_post('phone');
		$Email = $this->input->get_post('email');
		$Address = $this->input->get_post('address');
		$Enquiry = $this->input->get_post('enquiry');
		$emailContent='<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enquiry Form Details</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 20px; background-color: #f9f1f9;">

    <!-- Email Container -->
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">

        <!-- Heading -->
        <h2 style="text-align: center; color: #ffffff; font-size: 26px; margin-bottom: 20px; background: linear-gradient(to right, #e91e63, #f06292); -webkit-background-clip: text; color: #ffffff;">
            Enquiry Form Details
        </h2>

        <!-- Introduction -->
        <p style="font-size: 16px; color: #333; margin-bottom: 15px;">Dear Lotus Pens,</p>
        <p style="font-size: 16px; color: #333; margin-bottom: 20px;">Please find below the details from the enquiry form:</p>

        <!-- Data Blocks -->
        <div style="display: flex; flex-wrap: wrap; margin-bottom: 15px; background-color: #fce4ec; padding: 10px; border-radius: 8px; border: 1px solid #f8bbd0; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);">
            <div style="flex: 1; padding: 10px; background-color: #f8bbd0; border-right: 2px solid #d81b60; font-weight: bold; color: #d81b60; border-radius: 6px 0 0 6px;">
                First Name
            </div>
            <div style="flex: 2; padding: 10px; font-size: 14px; color: #333;">'.$firstName;
            $emailContent.='</div>
        </div>

        <div style="display: flex; flex-wrap: wrap; margin-bottom: 15px; background-color: #fce4ec; padding: 10px; border-radius: 8px; border: 1px solid #f8bbd0; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);">
            <div style="flex: 1; padding: 10px; background-color: #f8bbd0; border-right: 2px solid #d81b60; font-weight: bold; color: #d81b60; border-radius: 6px 0 0 6px;">
                Last Name
            </div>
            <div style="flex: 2; padding: 10px; font-size: 14px; color: #333;">'.$lastName;
                
            $emailContent.='</div>
        </div>

        <div style="display: flex; flex-wrap: wrap; margin-bottom: 15px; background-color: #fce4ec; padding: 10px; border-radius: 8px; border: 1px solid #f8bbd0; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);">
            <div style="flex: 1; padding: 10px; background-color: #f8bbd0; border-right: 2px solid #d81b60; font-weight: bold; color: #d81b60; border-radius: 6px 0 0 6px;">
                Phone
            </div>
            <div style="flex: 2; padding: 10px; font-size: 14px; color: #333;">'.$Phone;
                
            $emailContent.='</div>
        </div>

        <div style="display: flex; flex-wrap: wrap; margin-bottom: 15px; background-color: #fce4ec; padding: 10px; border-radius: 8px; border: 1px solid #f8bbd0; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);">
            <div style="flex: 1; padding: 10px; background-color: #f8bbd0; border-right: 2px solid #d81b60; font-weight: bold; color: #d81b60; border-radius: 6px 0 0 6px;">
                Email
            </div>
            <div style="flex: 2; padding: 10px; font-size: 14px; color: #333;">'.$Email;
			
            $emailContent.='</div>
        </div>

        <div style="display: flex; flex-wrap: wrap; margin-bottom: 15px; background-color: #fce4ec; padding: 10px; border-radius: 8px; border: 1px solid #f8bbd0; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);">
            <div style="flex: 1; padding: 10px; background-color: #f8bbd0; border-right: 2px solid #d81b60; font-weight: bold; color: #d81b60; border-radius: 6px 0 0 6px;">
                Address
            </div>
            <div style="flex: 2; padding: 10px; font-size: 14px; color: #333;">'.$Address;
			
            $emailContent.='</div>
        </div>

        <div style="display: flex; flex-wrap: wrap; margin-bottom: 20px; background-color: #fce4ec; padding: 10px; border-radius: 8px; border: 1px solid #f8bbd0; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);">
            <div style="flex: 1; padding: 10px; background-color: #f8bbd0; border-right: 2px solid #d81b60; font-weight: bold; color: #d81b60; border-radius: 6px 0 0 6px;">
                Enquiry
            </div>
            <div style="flex: 2; padding: 10px; font-size: 14px; color: #333;">'.$Enquiry;
            $emailContent.='</div></div>

        <!-- Footer -->
        <p style="font-size: 14px; color: #888888; text-align: center; margin-top: 30px; padding-top: 15px; border-top: 1px solid #f8bbd0;">
            Thank you for your enquiry.
        </p>

        <!-- Button -->
        <a href="'.base_url().'" style="display: inline-block; padding: 10px 20px; font-size: 16px; background-color: #d81b60; color: white; border-radius: 4px; text-decoration: none; text-align: center; margin-top: 20px;">
            Visit Our Website
        </a>

    </div>

</body>
</html>
';
		$saveData = $this->GlobalModal->sendCustomMail(['lotuspensindia@gmail.com','info@lotuspens.in'],$emailContent,'Enquiry Form Details');
		if ($saveData != false) {
			echo json_encode(array('status' => 200, 'message' => 'Enquiry Submit Success'));
		} else {
			echo json_encode(array('status' => 401, 'message' => 'Something went wrong'));
		}
	}
	
	
}
