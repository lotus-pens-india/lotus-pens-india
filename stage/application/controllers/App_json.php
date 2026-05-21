<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class App_json extends CI_Controller
{

	function __construct()
	{
		parent::__construct();

		$this->load->model('product_model');
		$this->load->model('sales_model');
		$this->load->model('customer_model');
		$this->load->model('GlobalModal');

	}


	/********************************  Customer registration ********************************************************************
	 *****************************************************************************************************************************/

	public function customer_registration()
	{

		$customer_fname = $this->input->post('customer_fname');
		$customer_lname = $this->input->post('customer_lname');
		$customer_email = $this->input->post('customer_email');
		$customer_phone = $this->input->post('customer_phone');
		// $city_id = $this->input->post('city_id');

		$pincode = $this->input->post('customer_pincode');
		$token = $this->input->post('token');
		$password = $this->input->post('customer_password');
		$role_type = $this->input->post('role_type');
		$currdate = date('d-m-Y');
		$u_id = $this->GlobalModal->genratedIds('customer', 'customer_unique_id', 'CU_');

		$this->db->select('*');
		$this->db->from('customer');
		$this->db->where('mobile_no', $customer_phone);
		$this->db->where('flag', '0');
		$query = $this->db->get();
		$rowcount = $query->num_rows();
		if ($rowcount == 0) {
			$regData = array(
				'first_name' => $customer_fname,
				'last_name' => $customer_lname,
				'email_id' => $customer_email,
				'mobile_no' => $customer_phone,
				'pincode' => $pincode,
				'city_id' => '',
				'referral_code' => '',
				'rdate' => $currdate,
				'wallet' => '150',
				'franchise_id' => '1',
				'token' => $token,
				'role_type' => $role_type,
				'password' => $password,
				'register_via' => 1,
				'customer_unique_id' => $u_id
			);
			$return_data = $this->GlobalModal->addData('customer', $regData);
			if ($return_data['status']) {
				$msg = 'Customer Register Successfully';
//				   $user_id=$this->db->insert_id();
				$user_id = $return_data['user_id'];
				$data[] = array('status' => 1, 'msg' => $msg, 'user_id' => $user_id);
			} else {
				$msg = 'Failed To Register';
				$data[] = array('status' => 0, 'msg' => $msg, 'user_id' => '');
			}

		} else {
			$msg = 'Mobile no already registerd.';
			$data[] = array('status' => 0, 'msg' => $msg, 'user_id' => '');
		}


		echo json_encode(array('result' => $data));


	}

	/********************************  Login Otp  ******************************************************************************
	 *****************************************************************************************************************************/
	public function login_otp()
	{
		$mobile_no = $this->input->post('mobile_no');

		$this->db->select('*');
		$this->db->from('customer');
		$this->db->where('mobile_no', $mobile_no);
		$this->db->where('flag', '0');
		$query = $this->db->get();
		$rowcount = $query->num_rows();
		$return_data = $query->row_array();
//	    var_dump($return_data);
		if ($rowcount > 0) {

			$otp = rand('1111', '9999');


			$number = $mobile_no;
			$from = "EXOTIC";
			$enmsg = "One%20Time%20OTP%20To%20Verify%20Mobile%20Number%20:%20$otp";

			$usrnme = 't1t1aimbeat';
			$psd = '44364836';


			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://nimbusit.co.in/api/swsendSingle.asp");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			//curl_setopt($ch, CURLOPT_POSTFIELDS, "key=".$api_key."&campaign=1&routeid=20&type=text&contacts=".$number."&senderid=".$from."&msg=".$enmsg);
			curl_setopt($ch, CURLOPT_POSTFIELDS, "username=" . $usrnme . "&password=" . $psd . "&sender=" . $from . "&sendto=" . $number . "&message=" . $enmsg);
			$response = curl_exec($ch);
			curl_close($ch);

			$chk = 1;
			$msg = 'Otp send successfully.';
			$data[] = array("status" => $chk, "otp" => $otp, "msg" => $msg, 'user_id' => $return_data['customer_id']);


		} else {
			$chk = 0;
			$otp = '';
			$msg = 'Login credentials are not found';
			$data[] = array("status" => $chk, "otp" => $otp, "msg" => $msg);
		}
		echo json_encode(array("result" => $data));
	}

	public function getUserIdFromMobile()
	{

	}

	/********************************  Customer Login ***************************************************************************
	 *****************************************************************************************************************************/

	public function login_customer()
	{
		$mobile_no = $this->input->post('mobile_no');
		$token = $this->input->post('token');
		$password = $this->input->post('password');
		$insertArray1 = array
		(
			'token' => $token
		);
		$this->db->where('mobile_no', $mobile_no);
		$this->db->update('customer', $insertArray1);

		$this->db->select('*');
		$this->db->from('customer');
		$this->db->where(array('mobile_no' => $mobile_no, 'password' => $password));
		$this->db->where('flag', '0');
		$query = $this->db->get();
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {
			$result = $query->row();
			$customer_id = $result->customer_id;
			$customer_unique_id = $result->customer_unique_id;
			$mobile_no = $result->mobile_no;
			$email_id = $result->email_id;
			$first_name = $result->first_name;
			$last_name = $result->last_name;
			$token = $result->token;
			$name = $first_name . ' ' . $last_name;
			$referral_code = $result->referral_code;
			$franchise_id = $result->franchise_id;
			$version_code = '1.30';


			$this->db->select('*');
			$this->db->from('product_order');
			$this->db->where('customer_id', $customer_id);
			$query1 = $this->db->get();
			$rowcount1 = $query1->num_rows();

			if ($rowcount1 > 0) {
				$customer_order_record = '1';
			} else {
				$customer_order_record = '0';
			}


			$msg = 'login Successfully.';
			$data[] = array('status' => 1, 'msg' => $msg, 'customer_id' => $customer_id, 'customer_unique_id' => $customer_unique_id, 'mobile_no' => $mobile_no, 'email_id' => $email_id, 'referral_code' => $referral_code,
				'customer_name' => $name, 'token' => $token, 'franchise_id' => $franchise_id, 'version_code' => $version_code, 'customer_order_record' => $customer_order_record);
			echo json_encode(array('result' => $data));
		} else {
			$msg = 'Unauthorized customer.';
			$data[] = array('status' => 0, 'msg' => $msg);
			echo json_encode(array('result' => $data));
		}
	}

	public function reset_password()
	{
		if (!empty($this->input->post('cust_id')) && !empty($this->input->post('password'))) {


			$mobile_no = $this->input->post('mobile_no');
			$password = $this->input->post('password');
			$cust_id = $this->input->post('cust_id');

			if ($this->GlobalModal->updateData('customer', array('password' => $password), array('customer_id' => $cust_id))) {
				$this->db->select('*');
				$this->db->from('customer');
				$this->db->where(array('customer_id' => $cust_id));
				$this->db->where('flag', '0');
				$query = $this->db->get();
				$rowcount = $query->num_rows();
				if ($rowcount > 0) {
					$result = $query->row();
					$customer_id = $result->customer_id;
					$customer_unique_id = $result->customer_unique_id;
					$mobile_no = $result->mobile_no;
					$email_id = $result->email_id;
					$first_name = $result->first_name;
					$last_name = $result->last_name;
					$token = $result->token;
					$name = $first_name . ' ' . $last_name;
					$referral_code = $result->referral_code;
					$franchise_id = $result->franchise_id;
					$version_code = '1.30';


					$this->db->select('*');
					$this->db->from('product_order');
					$this->db->where('customer_id', $customer_id);
					$query1 = $this->db->get();
					$rowcount1 = $query1->num_rows();

					if ($rowcount1 > 0) {
						$customer_order_record = '1';
					} else {
						$customer_order_record = '0';
					}
					$msg = 'Password Updated Successfully';
					$data[] = array('status' => 1, 'msg' => $msg, 'customer_id' => $customer_id, 'customer_unique_id' => $customer_unique_id, 'mobile_no' => $mobile_no, 'email_id' => $email_id, 'referral_code' => $referral_code,
						'customer_name' => $name, 'token' => $token, 'franchise_id' => $franchise_id, 'version_code' => $version_code, 'customer_order_record' => $customer_order_record);
				} else {
					$msg = 'User not found with this id';
					$data[] = array('status' => 0, 'msg' => $msg);
				}

			} else {
				$msg = 'Faild to Update Password';
				$data[] = array('status' => 0, 'msg' => $msg);
			}
		} else {
			$msg = 'Request Paramter Missing';
			$data[] = array('status' => 0, 'msg' => $msg);
		}
		echo json_encode(array("result" => $data));
	}


	/******************************** State List **********************************************************************
	 *********************************************************************************************************************/

	public function state_list()
	{

		$state_list = $this->product_model->get_all_state_model();
		$i = 1;
		if (!empty($state_list)) {
			foreach ($state_list as $state) {
				$state_id = $state->state_id;
				$state_name = $state->state_name;
				$data[] = array('state_id' => $state_id, 'state_name' => $state_name);
			}
			echo json_encode(array('status' => '1', 'result' => $data));
		} else {
			$msg = 'No Record Found.';
			$data[] = array('msg' => $msg);
			echo json_encode(array('status' => '0', 'result' => $data));

		}
	}


	/******************************** City List *************************************************************************
	 *********************************************************************************************************************/

	public function city_list()
	{
		$state_id = $this->input->post('state_id');

		$city_list = $this->product_model->get_all_cities_by_state_id($state_id);
		$i = 1;
		if (!empty($city_list)) {
			foreach ($city_list as $city) {
				$city_id = $city->city_id;
				$city_name = $city->city_name;

				$data[] = array('city_id' => $city_id, 'city_name' => $city_name);
			}
			echo json_encode(array('status' => '1', 'result' => $data));
		} else {
			$msg = 'No Record Found.';
			$data[] = array('msg' => $msg);
			echo json_encode(array('status' => '0', 'result' => $data));

		}
	}

	/******************************** Banner List **********************************************************************
	 *******************************************************************************************************************/

	public function banner_list($franchise_id)
	{

//        $franchise_id  = $this->input->post('franchise_id');
		$banner_list = $this->product_model->get_all_banner_model1($franchise_id);
		$i = 1;
		if (!empty($banner_list)) {
			foreach ($banner_list as $banner) {
				$banner_id = $banner->banner_id;
				$banner1 = $banner->banner;
				$category_id = $banner->category_id;
				if ($category_id == NULL) {
					$category_id = '';
				} else {
					$category_id = $category_id;
				}

				$banner1 = 'sterlex_admin/assets/images/banner/' . $banner1;
				$banner = base_url($banner1);

				$data[] = array('banner_id' => $banner_id, 'banner' => $banner, 'category_id' => $category_id);
			}
			return array('status' => '1', 'result' => $data);
		} else {
			$msg = 'No Record Found.';
			$data[] = array('msg' => $msg);
			return array('status' => '0', 'result' => $data);

		}
	}


	/******************************** Category List **********************************************************************
	 *********************************************************************************************************************/

	public function category_list($franchise_id)
	{

//        $franchise_id  = $this->input->post('franchise_id');
		$category_list = $this->product_model->get_all_category_model1($franchise_id);
		$version_code = '1.30';
		$i = 1;
		if (!empty($category_list)) {
			foreach ($category_list as $category) {
				$category_id = $category->category_id;


				$category_name = $category->name;
				$icon = $category->icon;
				$color = $category->color;
				$position = $category->position;

				if ($icon != '') {
					$icon = 'sterlex_admin/assets/images/category/' . $icon;
					$image = base_url($icon);
				} else {
					$image = '';
				}


				$this->db->select('*');
				$this->db->from('sub_category');
				$this->db->where('category_id', $category_id);
				$query_f = $this->db->get();

				$rowcount = $query_f->num_rows();
				if ($rowcount > 0) {
					$subcategorey = '1';
				} else {
					$subcategorey = '0';
				}

				$data[] = array('category_id' => $category_id, 'category_name' => $category_name, 'image' => $image, 'subcategorey' => $subcategorey, 'subcategorey' => $subcategorey, 'color' => $color, 'position' => $position);
			}
			return array('status' => '1', 'result' => $data, 'result' => $data, 'version_code' => $version_code);
		} else {
			$msg = 'No Record Found.';
			$data[] = array('msg' => $msg);
			return array('status' => '0', 'result' => $data);

		}
	}


	/******************************** Sub Category List ****************************************************************************
	 ********************************************************************************************************************************/

	public function subcategory_list()
	{
		$franchise_id = $this->input->post('franchise_id');
		$category_id = $this->input->post('category_id');
		$subcategory_list = $this->product_model->get_all_subcategory_id_wise_model($category_id, $franchise_id);
		$i = 1;
		if (!empty($subcategory_list)) {
			foreach ($subcategory_list as $subcategory) {
				$sub_category_id = $subcategory->sub_category_id;
				$sub_category = $subcategory->sub_category;
				$icon = $subcategory->icon;
				$color = $subcategory->color;

				$icon = 'sterlex_admin/assets/images/subcategory/' . $icon;
				$image = base_url($icon);


				$this->db->select('*');
				$this->db->from('sub_subcategory');
				$this->db->where('sub_category_id', $sub_category_id);
				$query_f = $this->db->get();

				$rowcount = $query_f->num_rows();
				if ($rowcount > 0) {
					$sub_subcategorey = '1';
				} else {
					$sub_subcategorey = '0';
				}

				$data[] = array('sub_category_id' => $sub_category_id, 'sub_category' => $sub_category, 'image' => $image, 'sub_subcategorey' => $sub_subcategorey, 'color' => $color);
			}
			echo json_encode(array('status' => '1', 'result' => $data));
		} else {
			$msg = 'No Record Found.';
			$data[] = array('msg' => $msg);
			echo json_encode(array('status' => '0', 'result' => $data));

		}
	}


	/******************************** Sub Sub_Category List ***********************************************************************
	 *******************************************************************************************************************************/

	public function sub_subcategory_list()
	{
		$franchise_id = $this->input->post('franchise_id');
		$sub_category_id = $this->input->post('sub_category_id');
		$subcategory_list = $this->product_model->get_all_sub_subcategory_id_wise_model($sub_category_id, $franchise_id);
		$i = 1;
		if (!empty($subcategory_list)) {
			foreach ($subcategory_list as $subcategory) {
				$sub_subcategory_id = $subcategory->sub_subcategory_id;
				$sub_subcategory = $subcategory->sub_subcategory;
				$icon = $subcategory->icon;
				$color = $subcategory->color;

				$icon = 'sterlex_admin/assets/images/sub_subcategory/' . $icon;
				$image = base_url($icon);


				$data[] = array('sub_subcategory_id' => $sub_subcategory_id, 'sub_subcategory' => $sub_subcategory, 'image' => $image, 'color' => $color);
			}
			echo json_encode(array('status' => '1', 'result' => $data));
		} else {
			$msg = 'No Record Found.';
			$data[] = array('msg' => $msg);
			echo json_encode(array('status' => '0', 'result' => $data));

		}
	}


	/******************************** Product List *********************************************************************************
	 ********************************************************************************************************************************/

	public function product_list($category_id, $customer_id, $franchise_id)
	{
//        $category_id = $this->input->post('category_id');
//        $customer_id = $this->input->post('customer_id');
//          = $this->input->post('franchise_id');
		$product_list = $this->product_model->get_all_product_id_wise_model($category_id, $franchise_id);
		$i = 1;
		if (!empty($product_list)) {
			foreach ($product_list as $product) {
				$product_id = $product->product_id;
				$product_name = $product->product_name;
				$main_image = $product->main_image;
				$qty = $product->qty;
				$type = $product->type;


				$serv = array();
				$CI =& get_instance();
				$CI->load->model('Product_model');
				$result = $CI->product_model->product_details_product_id_wise($product_id);

				foreach ($result as $p_details) {
					$id = $p_details['id'];
					$unit = $p_details['title'];
					$price = $p_details['unit_price'];
					$discount = $p_details['discount'];
//        		    $serv[] = array();
					$i++;
				}

				if ($qty == '0') {
					$status = '0';
				} else {
					$status = '1';
				}

				$main_image = 'sterlex_admin/assets/images/product/' . $main_image;
				$image = base_url($main_image);


				$q = $this->db->select('*');
				$q = $this->db->where('customer_id', $customer_id);
				$q = $this->db->where('product_id', $product_id);
				$q = $this->db->get('add_to_cart');
				$rowcount = $q->num_rows();

				if ($rowcount > 0) {
					$this->db->select('*');
					$this->db->from('add_to_cart');
					$this->db->where('product_id', $product_id);
					$this->db->where('customer_id', $customer_id);
					$query = $this->db->get();
					$result = $query->row();
					$p_qty = $result->qty;


				} else {
					$p_qty = '0';
				}

				$data[] = array('product_id' => $product_id, 'product_name' => $product_name, 'image' => $image, 'qty' => $p_qty, 'flag' => $status, 'type' => $type, 'price_id' => $id, "unit" => $unit, "price" => $price, "discount" => $discount);
			}
			return array('status' => '1', 'result' => $data);
		} else {
			$msg = 'No Record Found.';
			$data[] = array('msg' => $msg);
			return array('status' => '0', 'result' => $data);

		}
	}

	public function most_popular_product_list($category_id, $customer_id, $franchise_id)
	{
//        $category_id = $this->input->post('category_id');
//        $customer_id = $this->input->post('customer_id');
//          = $this->input->post('franchise_id');
		$product_list = $this->product_model->get_all_most_popu_product_id_wise_model($category_id, $franchise_id);
		$i = 1;
		if (!empty($product_list)) {
			foreach ($product_list as $product) {
				$product_id = $product->product_id;
				$product_name = $product->product_name;
				$main_image = $product->main_image;
				$qty = $product->qty;
				$type = $product->type;
				$is_veg=$product->is_veg;


				$serv = array();
				$CI =& get_instance();
				$CI->load->model('Product_model');
				$result = $CI->product_model->product_details_product_id_wise($product_id);


				foreach ($result as $p_details) {
					$id = $p_details['id'];
					$unit = $p_details['title'];
					$price = $p_details['unit_price'];
					$discount = $p_details['discount'];
					$gst = $p_details['gst'];
					if ($p_details['product_unit'] != '') {
						$product_unit = explode(',', $p_details['product_unit']);
					} else {
						$product_unit = array();
					}
//        		    $serv[] = array();
					$i++;
				}
				$unit_arrafinal = array();
				$product_unit = $this->product_model->product_unit_details($product_id);
//				var_dump($product_unit);
				if ($product_unit != false) {
					foreach ($product_unit as $unit_data) {
						$unit_array['unit'] = $unit_data['unit'];
						$unit_array['uint_price'] = $unit_data['uint_price'];
						$unit_array['unit_discount'] = $unit_data['unit_discount'];
						$unit_array['unit_purchase_price'] = $unit_data['unit_purchase_price'];
						$unit_array['unit_gst'] = $unit_data['unit_gst'];
						$unit_arrafinal[] = $unit_array;
					}
				} else {
					$unit_arrafinal = array();
				}
				if ($qty == '0') {
					$status = '0';
				} else {
					$status = '1';
				}

				$main_image = 'sterlex_admin/assets/images/product/' . $main_image;
				$image = base_url($main_image);


				$q = $this->db->select('*');
				$q = $this->db->where('customer_id', $customer_id);
				$q = $this->db->where('product_id', $product_id);
				$q = $this->db->get('add_to_cart');
				$rowcount = $q->num_rows();
				if ($rowcount > 0) {
					$this->db->select('*');
					$this->db->from('add_to_cart');
					$this->db->where('product_id', $product_id);
					$this->db->where('customer_id', $customer_id);
					$query = $this->db->get();
					$result = $query->row();
					$p_qty = $result->qty;

				} else {
					$p_qty = '0';
				}
				$data[] = array('product_id' => $product_id, 'product_name' => $product_name, 'image' => $image, 'product_qty' => $p_qty, 'qty' => $qty, 'flag' => $status, 'type' => $type, 'price_id' => $id, "unit" => $unit, "price" => $price, "discount" => $discount, 'gst' => $gst, 'product_unit' => $unit_arrafinal,'is_veg'=>$is_veg);
			}
			return array('status' => '1', 'result' => $data);
		} else {
			$msg = 'No Record Found.';
			$data[] = array('msg' => $msg);
			return array('status' => '0', 'result' => $data);

		}
	}

	public function sub_category_wise_product_list()
	{
		$sub_category_id = $this->input->post('sub_category_id');
		$customer_id = $this->input->post('customer_id');
		$franchise_id = $this->input->post('franchise_id');
		$product_list = $this->product_model->get_all_product_subcategory_id_wise_model($sub_category_id, $franchise_id);
		$i = 1;
		if (!empty($product_list)) {
			foreach ($product_list as $product) {
				$product_id = $product->product_id;
				$product_name = $product->product_name;
				$main_image = $product->main_image;
				$qty = $product->qty;
				$type = $product->type;


				$serv = array();
				$CI =& get_instance();
				$CI->load->model('Product_model');
				$result = $CI->product_model->product_details_product_id_wise($product_id);

				foreach ($result as $p_details) {
					$id = $p_details['id'];
					$unit = $p_details['title'];
					$price = $p_details['unit_price'];
					$discount = $p_details['discount'];
					$serv[] = array('price_id' => $id, "unit" => $unit, "price" => $price, "discount" => $discount);
					$i++;
				}

				if ($qty == '0') {
					$status = '0';
				} else {
					$status = '1';
				}

				$main_image = 'sterlex_admin/assets/images/product/' . $main_image;
				$image = base_url($main_image);


				$q = $this->db->select('*');
				$q = $this->db->where('customer_id', $customer_id);
				$q = $this->db->where('product_id', $product_id);
				$q = $this->db->get('add_to_cart');
				$rowcount = $q->num_rows();

				if ($rowcount > 0) {
					$this->db->select('*');
					$this->db->from('add_to_cart');
					$this->db->where('product_id', $product_id);
					$this->db->where('customer_id', $customer_id);
					$query = $this->db->get();
					$result = $query->row();
					$p_qty = $result->qty;


				} else {
					$p_qty = '0';
				}

				$data[] = array('product_id' => $product_id, 'product_name' => $product_name, 'image' => $image, 'qty' => $p_qty, 'flag' => $status, 'type' => $type, 'price_details' => $serv);
			}
			echo json_encode(array('status' => '1', 'result' => $data));
		} else {
			$msg = 'No Record Found.';
			$data[] = array('msg' => $msg);
			echo json_encode(array('status' => '0', 'result' => $data));

		}
	}


	public function sub_subcategory_wise_product_list()
	{
		$sub_subcategory_id = $this->input->post('sub_subcategory_id');
		$customer_id = $this->input->post('customer_id');
		$franchise_id = $this->input->post('franchise_id');
		$product_list = $this->product_model->get_all_product_sub_subcategory_id_wise_model($sub_subcategory_id, $franchise_id);
		$i = 1;
		if (!empty($product_list)) {
			foreach ($product_list as $product) {
				$product_id = $product->product_id;
				$product_name = $product->product_name;
				$main_image = $product->main_image;
				$qty = $product->qty;
				$type = $product->type;

				$serv = array();
				$CI =& get_instance();
				$CI->load->model('Product_model');
				$result = $CI->product_model->product_details_product_id_wise($product_id);

				foreach ($result as $p_details) {
					$id = $p_details['id'];
					$unit = $p_details['title'];
					$price = $p_details['unit_price'];
					$discount = $p_details['discount'];
					$serv[] = array('price_id' => $id, "unit" => $unit, "price" => $price, "discount" => $discount);
					$i++;
				}

				if ($qty == '0') {
					$status = '0';
				} else {
					$status = '1';
				}

				$main_image = 'sterlex_admin/assets/images/product/' . $main_image;
				$image = base_url($main_image);


				$q = $this->db->select('*');
				$q = $this->db->where('customer_id', $customer_id);
				$q = $this->db->where('product_id', $product_id);
				$q = $this->db->get('add_to_cart');
				$rowcount = $q->num_rows();

				if ($rowcount > 0) {
					$this->db->select('*');
					$this->db->from('add_to_cart');
					$this->db->where('product_id', $product_id);
					$this->db->where('customer_id', $customer_id);
					$query = $this->db->get();
					$result = $query->row();
					$p_qty = $result->qty;


				} else {
					$p_qty = '0';
				}

				$data[] = array('product_id' => $product_id, 'product_name' => $product_name, 'image' => $image, 'qty' => $p_qty, 'flag' => $status, 'type' => $type, 'price_details' => $serv);
			}
			echo json_encode(array('status' => '1', 'result' => $data));
		} else {
			$msg = 'No Record Found.';
			$data[] = array('msg' => $msg);
			echo json_encode(array('status' => '0', 'result' => $data));

		}
	}


	/******************************** Product Details ****************************************************************************
	 ******************************************************************************************************************************/

	public function product_details_id_wise()
	{
		$customer_id = $this->input->post('customer_id');
		$product_id = $this->input->post('product_id');
		$product_list = $this->product_model->get_all_product_details_id_wise_model($product_id);

		$product_name = $product_list->product_name;
		$main_image = $product_list->main_image;
		$qty = $product_list->qty;
		$type = $product_list->type;
		$description = $product_list->description;
		$nutrition_fact = $product_list->nutrition_fact;
		$health_benefit = $product_list->health_benefit;
		$thumbnail_image = $product_list->thumbnail_image;

		$serv = array();
		$serv1 = array();
		$CI =& get_instance();
		$CI->load->model('Product_model');
		$result1 = $CI->product_model->product_details_product_id_wise1($product_id);

		$i = 1;
		foreach ($result1 as $p_details) {
			$id = $p_details['id'];
			$unit = $p_details['title'];
			$price = $p_details['unit_price'];
			$discount = $p_details['discount'];

			$serv[] = array('price_id' => $id, "unit" => $unit, "price" => $price, "discount" => $discount);
			$i++;
		}

		if ($qty == '0') {
			$status = '0';
		} else {
			$status = '1';
		}

		$main_image = 'sterlex_admin/assets/images/product/' . $main_image;
		$image = base_url($main_image);


		if (!empty($thumbnail_image)) {
			$array = $thumbnail_image;
			$var = explode(',', $array);
			$i = 1;
			foreach ($var as $item) {
				$thumbnail_image = 'sterlex_admin/assets/images/thumbnail/' . $item;
				$thumbnail_image = base_url($thumbnail_image);
				$serv1[] = array("thumbnail_image" => $thumbnail_image);
				$i++;
			}

		} else {
			$serv1 = array();
		}


		$q = $this->db->select('*');
		$q = $this->db->where('customer_id', $customer_id);
		$q = $this->db->where('product_id', $product_id);
		$q = $this->db->get('add_to_cart');
		$rowcount = $q->num_rows();

		if ($rowcount > 0) {
			$this->db->select('*');
			$this->db->from('add_to_cart');
			$this->db->where('product_id', $product_id);
			$this->db->where('customer_id', $customer_id);
			$query = $this->db->get();
			$result = $query->row();
			$p_qty = $result->qty;


		} else {
			$p_qty = '0';
		}


		$q = $this->db->select('*');
		$q = $this->db->where('customer_id', $customer_id);
		$q = $this->db->where('product_id', $product_id);
		$q = $this->db->get('add_to_cart');
		$rowcount1 = $q->num_rows();
		if ($rowcount1 > 0) {

			$save_flag = '1';
		} else {
			$save_flag = '0';
		}


		$data[] = array('product_id' => $product_id, 'product_name' => $product_name, 'image' => $image, 'type' => $type, 'flag' => $status, 'qty' => $p_qty, 'save_flag' => $save_flag, 'description' => $description, 'nutrition_fact' => $nutrition_fact, 'health_benefit' => $health_benefit, 'price_details' => $serv, 'thumbnail' => $serv1);

		echo json_encode(array('status' => '1', 'result' => $data));

	}


	/********************************  Add to cart ********************************************************************
	 ******************************************************************************************************************/

	public function add_to_cart()
	{

		$customer_id = $this->input->post('customer_id');
		$product_id = $this->input->post('product_id');
		$unit = $this->input->post('unit');
		$price = $this->input->post('price');
		$gst = $this->input->post('gst');
		$discount = $this->input->post('discount');
		$qty = $this->input->post('qty');


		$q = $this->db->select('*');
		$q = $this->db->where('customer_id', $customer_id);
		$q = $this->db->where('product_id', $product_id);
		$q = $this->db->get('save_for_later');
		$rowcount1 = $q->num_rows();
		if ($rowcount1 > 0) {
			$this->db->where(array('customer_id' => $customer_id, 'product_id' => $product_id));
			$this->db->delete('save_for_later');

		}


		$q = $this->db->select('*');
		$q = $this->db->where('customer_id', $customer_id);
		$q = $this->db->where('product_id', $product_id);
		$q = $this->db->get('add_to_cart');
		$rowcount = $q->num_rows();

		if ($rowcount > 0) {
			$this->db->select('*');
			$this->db->from('add_to_cart');
			$this->db->where('product_id', $product_id);
			$this->db->where('customer_id', $customer_id);
			$query = $this->db->get();
			$result = $query->row();
			$p_qty = $result->qty;


			$arrData = array
			(
				'qty' => $qty,

			);

			$this->db->where(array('customer_id' => $customer_id, 'product_id' => $product_id))->update('add_to_cart', $arrData);

		} else {
			$regData = array
			(
				'customer_id' => $customer_id,
				'product_id' => $product_id,
				'unit' => $unit,
				'price' => $price,
				'discount' => $discount,
				'qty' => $qty,
				'gst' => $gst
			);

			$this->db->insert('add_to_cart', $regData);
		}
		$msg = 'Product added Successfully.';
		$data[] = array('status' => 1, 'msg' => $msg);

		echo json_encode(array('result' => $data));


	}


	/******************************** Cart Count****************************************************************************
	 ********************************************************************************************************************************/

	public function cart_count()
	{
		$customer_id = $this->input->post('customer_id');
		$cart_count = $this->product_model->get_cart_count_model($customer_id);

		$count = $cart_count->count;


		$data[] = array('customer_id' => $customer_id, 'count' => $count);

		echo json_encode(array('status' => '1', 'result' => $data));

	}


	/******************************** cart wise product ****************************************************************************
	 ********************************************************************************************************************************/

	public function cart_wise_product()
	{
		$customer_id = $this->input->post('customer_id');
		$coupon_id = $this->input->post('coupon_id');
		$product_list = $this->product_model->get_cart_product_wise_model($customer_id);
		// print_r($product_list);die;

		$timestamp = date('d-m-Y');
		$current_day = date('l', strtotime($timestamp . ' +1 day'));

		$this->db->select('*');
		$this->db->from('customer');
		$this->db->where('customer_id', $customer_id);
		$query = $this->db->get();
		$result = $query->row();
		$franchise_id = $result->franchise_id;
		$pincode = $result->pincode;

		$this->db->select('*');
		$this->db->from('pincode');
		$this->db->where('pincode', $pincode);
		$query1 = $this->db->get();
		$rowcount = $query1->num_rows();
		if ($rowcount == 0) {
			$delivery_charges = '0';
		} else {
			$result1 = $query1->row();
			$delivery_charges = $result1->delivery_charges;
		}


		if (!empty($product_list)) {
			$sum = 0;
			$bag_discount = 0;
			$order_total = 0;
			$total_number_of_items=0;
			foreach ($product_list as $product) {
				$product_id = $product->pid;
				$cart_id = $product->id;
				$product_name = $product->product_name;
				$main_image = $product->main_image;
				$unit = $product->unit;
				$price = $product->price;
				$discount = $product->discount;
				$qty = $product->qty;
				$gst= $product->qty;

				$total_price = ($price * $qty);

				$discount_price = $total_price - $discount;
				$discount_amt = $discount;


				$main_image = 'sterlex_admin/assets/images/product/' . $main_image;
				$image = base_url($main_image);

				$sum += $total_price;
				$bag_discount += $discount_amt;
				$order_total += $discount_price;
				$total_number_of_items+=$qty;


				$data[] = array('product_id' => $product_id, 'product_name' => $product_name, 'unit' => $unit, 'unit_price' => $price, 'price' => $total_price, 'qty' => $qty, 'discount' => $discount, 'price1' => $discount_price, 'discount_amt' => $discount_amt, 'image' => $image, 'qty' => $qty,'gst'=>$gst, 'cart_id' => $cart_id);


			}


			$bag_details[] = array('total_bag' => $sum, 'bag_discount' => $bag_discount, 'order_total' => $order_total + $delivery_charges, 'delivery_charges' => $delivery_charges,'total_number_of_items'=>$total_number_of_items);

			$slot_list = $this->product_model->get_slot_day_wise_model($current_day, $franchise_id);
			// print_r($slot_list);exit;

			if (!empty($slot_list)) {

				foreach ($slot_list as $slot) {
					$slot_id = $slot->slot_id;
					$slot_timing = $slot->slot_timing;
					$day = $slot->day;
					$slot_details[] = array('slot_id' => $slot_id, 'day' => $day, 'slot_timing' => $slot_timing);
				}

			} else {
				$slot_details = array();
			}
			echo json_encode(array('status' => '1', 'result' => $data, 'bag_details' => $bag_details));
		} else {
			$msg = 'No Record Found.';

			$data[] = array('msg' => $msg);
			echo json_encode(array('status' => '0', 'result' => $data));

		}
	}


	public function remove_cart_product()
	{

		$id = $this->input->post('cart_id');


		$this->db->where('id', $id);
		$this->db->delete('add_to_cart');


		$chk = 1;
		$data[] = array("status" => $chk);


		echo json_encode(array("result" => $data));
	}


	/********************************  Remove Product Qty ********************************************************
	 ******************************************************************************************************************/

	public function remove_product_qty()
	{

		$customer_id = $this->input->post('customer_id');
		$product_id = $this->input->post('product_id');


		$this->db->where(array('customer_id' => $customer_id, 'product_id' => $product_id));
		$this->db->delete('add_to_cart');


		$msg = 'Qty remove from cart.';
		$data[] = array('status' => 1, 'msg' => $msg);
		echo json_encode(array('result' => $data));


	}


	/********************************  Save For Latre ****************************************************************
	 ******************************************************************************************************************/

	public function save_for_later()
	{

		$customer_id = $this->input->post('customer_id');
		$product_id = $this->input->post('product_id');
		$unit = $this->input->post('unit');
		$price = $this->input->post('price');
		$discount = $this->input->post('discount');
		$qty = $this->input->post('qty');


		$q = $this->db->select('*');
		$q = $this->db->where('customer_id', $customer_id);
		$q = $this->db->where('product_id', $product_id);
		$q = $this->db->get('add_to_cart');
		$rowcount1 = $q->num_rows();
		if ($rowcount1 > 0) {
			$this->db->where(array('customer_id' => $customer_id, 'product_id' => $product_id));
			$this->db->delete('add_to_cart');

		}

		$q = $this->db->select('*');
		$q = $this->db->where('customer_id', $customer_id);
		$q = $this->db->where('product_id', $product_id);
		$q = $this->db->get('save_for_later');
		$rowcount = $q->num_rows();

		if ($rowcount > 0) {
			$msg = 'Product already saved.';
			$data[] = array('status' => 0, 'msg' => $msg);

		} else {
			$regData = array
			(
				'customer_id' => $customer_id,
				'product_id' => $product_id,
				'unit' => $unit,
				'price' => $price,
				'discount' => $discount,
				'qty' => $qty,
			);

			$this->db->insert('save_for_later', $regData);
		}

		$msg = 'Product Save Successfully.';
		$data[] = array('status' => 1, 'msg' => $msg);
		echo json_encode(array('result' => $data));


	}


	/******************************** Save wise product ****************************************************************************
	 ********************************************************************************************************************************/

	public function save_wise_product()
	{
		$customer_id = $this->input->post('customer_id');
		$product_list = $this->product_model->get_save_product_wise_model($customer_id);

		//print_r($product_list);exit;

		if (!empty($product_list)) {

			foreach ($product_list as $product) {
				$product_id = $product->pid;
				$save_id = $product->id;
				$product_name = $product->product_name;
				$main_image = $product->main_image;
				$unit = $product->unit;
				$price = $product->price;
				$discount = $product->discount;
				$qty = $product->qty;


				$main_image = 'sterlex_admin/assets/images/product/' . $main_image;
				$image = base_url($main_image);

				$data[] = array('product_id' => $product_id, 'product_name' => $product_name, 'unit' => $unit, 'price' => $price, 'discount' => $discount, 'image' => $image, 'qty' => $qty, 'save_id' => $save_id);


			}
			echo json_encode(array('status' => '1', 'result' => $data));
		} else {
			$msg = 'No Record Found.';
			$data[] = array('msg' => $msg);
			echo json_encode(array('status' => '0', 'result' => $data));

		}
	}


	public function remove_save_product()
	{

		$id = $this->input->post('save_id');


		$this->db->where('id', $id);
		$this->db->delete('save_for_later');


		$chk = 1;
		$data[] = array("status" => $chk);


		echo json_encode(array("result" => $data));
	}


	/******************************** Coupon List *********************************************************************
	 *******************************************************************************************************************/

	public function coupon_list()
	{
		$franchise_id = $this->input->get_post('franchise_id');
		$cust_id = $this->input->get_post('customer_id');
		$coupon_list = $this->product_model->get_all_coupon_model1($franchise_id, $cust_id);
		$i = 1;
		if (!empty($coupon_list)) {
			foreach ($coupon_list as $coupon) {
				$coupon_id = $coupon->coupon_id;
				$coupon_name = $coupon->coupon_name;
				$capping_value = $coupon->capping_value;
				$value = $coupon->value;
				$description = $coupon->description;


				$data[] = array('coupon_id' => $coupon_id, 'coupon_name' => $coupon_name, 'coupon_value' => $value, 'capping_value' => $capping_value, 'description' => $description);
			}
			echo json_encode(array('status' => '1', 'result' => $data));
		} else {
			$msg = 'No Record Found.';
			$data[] = array('msg' => $msg);
			echo json_encode(array('status' => '0', 'result' => $data));

		}
	}


	/******************************** Coupon List *********************************************************************
	 *******************************************************************************************************************/

	public function subscription_coupon_list()
	{

		$franchise_id = $this->input->post('franchise_id');
		$coupon_list = $this->product_model->get_all_coupon_model11($franchise_id);
		$i = 1;
		if (!empty($coupon_list)) {
			foreach ($coupon_list as $coupon) {
				$coupon_id = $coupon->coupon_id;
				$coupon_name = $coupon->coupon_name;
				$capping_value = $coupon->capping_value;
				$value = $coupon->value;
				$description = $coupon->description;


				$data[] = array('coupon_id' => $coupon_id, 'coupon_name' => $coupon_name, 'coupon_value' => $value, 'capping_value' => $capping_value, 'description' => $description);
			}
			echo json_encode(array('status' => '1', 'result' => $data));
		} else {
			$msg = 'No Record Found.';
			$data[] = array('msg' => $msg);
			echo json_encode(array('status' => '0', 'result' => $data));

		}
	}


	/********************************  Customer Address ****************************************************************
	 ********************************************************************************************************************/

	public function customer_address()
	{

		$customer_id = $this->input->post('customer_id');

		$flat_no = $this->input->post('flat_no');
		$building_name = $this->input->post('building_name');
		$landmark = $this->input->post('landmark');
		$area_name = $this->input->post('area_name');
		$pincode = $this->input->post('pincode');
		$sector_number = $this->input->post('sector_number');
		$area_id = $this->input->post('area_id');
		$add_type = $this->input->post('add_type');

		$regData = array
		(
			'customer_id' => $customer_id,
			'flat_no' => $flat_no,
			'building_name' => $building_name,
			'landmark' => $landmark,
			'area_name' => $area_name,
			'pincode' => $pincode,
			'sector_number' => $sector_number,
			'area_id' => $area_id,
			'address_type'=>$add_type
		);
		if ($this->GlobalModal->addData('customer_address', $regData)) {
			$response['status'] = 1;
			$response['result'] = 'Address Added';
		} else {
			$response['status'] = 0;
			$response['result'] = 'Address Not Added';
		}
		echo json_encode($response);

	}


	/******************************** Address List *******************************************************************
	 *******************************************************************************************************************/

	public function customer_address_record()
	{

		$customer_id = $this->input->post('customer_id');
		$address_list = $this->product_model->get_customer_wise_address_model($customer_id);
		$i = 1;
		if (!empty($address_list)) {
			foreach ($address_list as $add) {
				$id = $add->id;
				$flat_no = $add->flat_no;
				$building_name = $add->building_name;
				$landmark = $add->landmark;
				$area_name = $add->area_name;
				$pincode = $add->pincode;
				$sector_number = $add->sector_number;
				$area_id = $add->area_id;
				$address_type = $add->address_type;


				$data[] = array('id' => $id, 'flat_no' => $flat_no, 'building_name' => $building_name, 'landmark' => $landmark, 'area_name' => $area_name, 'pincode' => $pincode, 'sector_number' => $sector_number, 'area_id' => $area_id, 'address_type' => $address_type);
			}
			echo json_encode(array('status' => '1', 'result' => $data));
		} else {
			$msg = 'No Record Found.';
			$data[] = array('msg' => $msg);
			echo json_encode(array('status' => '0', 'result' => $data));

		}
	}


	/********************************  Customer Address Update ****************************************************************
	 ******************************************************************************************************************/

	public function customer_address_update()
	{

		$id = $this->input->post('id');
		$flat_no = $this->input->post('flat_no');
		$building_name = $this->input->post('building_name');
		$landmark = $this->input->post('landmark');
		$area_name = $this->input->post('area_name');
		$pincode = $this->input->post('pincode');
		$sector_number = $this->input->post('sector_number');
		$area_id = $this->input->post('area_id');
		$add_type = $this->input->post('add_type');

		$regData = array
		(
			'flat_no' => $flat_no,
			'building_name' => $building_name,
			'landmark' => $landmark,
			'area_name' => $area_name,
			'pincode' => $pincode,
			'sector_number' => $sector_number,
			'area_id' => $area_id,
			'address_type'=>$add_type
		);

		if ($this->GlobalModal->updateData('customer_address', $regData,array('id'=>$id))) {
			$response['status'] = 1;
			$response['result'] = 'Address Updated';
		} else {
			$response['status'] = 0;
			$response['result'] = 'Address Not Updated';
		}
		echo json_encode($response);
	}


	/********************************  Customer Address Delete ********************************************************
	 ******************************************************************************************************************/

	public function address_delete()
	{

		$id = $this->input->post('id');

		$this->db->where('id', $id);
		$this->db->delete('customer_address');


		$msg = 'Address Deleted Successfully.';
		$data[] = array('status' => 1, 'msg' => $msg);
		echo json_encode(array('result' => $data));
	}


	/********************************  Order Entry *******************************************************************
	 ******************************************************************************************************************/

	public function order_entry()
	{

		$franchise_id = $this->input->post('franchise_id');
		$customer_id = $this->input->post('customer_id');
		$total_bag = $this->input->post('total_bag');
		$bag_discount = $this->input->post('bag_discount');
		$order_total = $this->input->post('order_total');
		$slot_id = $this->input->post('slot_id');
		$coupon_id = $this->input->post('coupon_id');
		$deliver_address = $this->input->post('deliver_address');
		$flag = $this->input->post('flag');
		$rid = $this->input->post('rid');
		$delivery_charges = $this->input->post('delivery_charges');

		$minus_wallet = $this->input->post('minus_wallet');
		$delivery_status = $this->input->post('delivery_status');


		$area_id = $this->input->post('area_id');

		$this->db->select('*');
		$this->db->from('customer');
		$this->db->where('customer_id', $customer_id);
		$query = $this->db->get();
		$result = $query->row();
		$mobile_no = $result->mobile_no;
		$first_name = $result->first_name;
		$wallet = $result->wallet;


		$this->db->select('*');
		$this->db->from('db_wise_area');
		$this->db->where('pincode', $area_id);
		$this->db->where('isActive', '0');
		$query_db = $this->db->get();
		$rowcount = $query_db->num_rows();
		if ($rowcount > 0) {

			$result_db = $query_db->row();
			$assign_to = $result_db->db_id;
			$assign_date = date('d-m-Y h:i:A');
		} else {
			$assign_to = '';
			$assign_date = '';
		}


		if ($delivery_status == '1') {

			$otp = rand('0000', '9999');


			$sender = "BASKET";
			$number2 = $mobile_no;
			$msg2 = "Your order has been placed successfully.When you pick up an order,you will need 4 digit otp for verification.This is the otp $otp.Please remember or save this otp..";

			$api_key = '55A827A192C7C6';
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://www.logonutility.in/app/smsapi/index.php");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, "key=" . $api_key . "&&campaign=1&routeid=20&type=text&contacts=" . $number2 . "&senderid=" . $sender . "&msg=" . $msg2);
			$response = curl_exec($ch);

		} else {
			$otp = '';
		}

		$order_generate_id = mt_rand(000000, 999999);

		$currdate = date('d-m-Y');

		$order_entry = array
		(

			'customer_id' => $customer_id,
			'total_bag' => $total_bag,
			'bag_discount' => $bag_discount,
			'order_total' => $order_total,
			'slot_id' => $slot_id,
			'coupon_id' => $coupon_id,
			'deliver_address' => $deliver_address,
			'p_mode' => $flag,
			'order_date' => $currdate,
			'delivery_status' => $delivery_status,
			'otp' => $otp,
			'wallet_use' => $minus_wallet,
			'rid' => $rid,
			'franchise_id' => $franchise_id,
			'assign_to' => $assign_to,
			'assign_date' => $assign_date,
			'delivery_charges' => $delivery_charges,

		);

		$this->db->insert('product_order', $order_entry);
		$insert_id = $this->db->insert_id();


		$regData1 = array
		(

			'order_generate_id' => 'EX' . $order_generate_id,

		);

		$this->db->where(array('order_id' => $insert_id))->update('product_order', $regData1);

		if ($flag == '1' || $flag == '3') {
			$regData = array
			(

				'payment_status' => '1',

			);

			$this->db->where(array('order_id' => $insert_id))->update('product_order', $regData);


		}

		$product_id_count = explode(',', $this->input->post('product_id'));
		$qty = explode(',', $this->input->post('qty'));
		$unit = explode(',', $this->input->post('unit'));
		$unit_price = explode(',', $this->input->post('unit_price'));
		$discount = explode(',', $this->input->post('discount'));

		$cnt = count($product_id_count);


		//print_r($qty);exit;


		for ($i = 0; $i < $cnt; $i++) {

			$this->db->select('*');
			$this->db->from('vegshopy_product');
			$this->db->where('product_id', $product_id_count[$i]);
			$query11 = $this->db->get();
			$result11 = $query11->row();
			$avi_qty = $result11->qty;

			$stock = $avi_qty - $qty[$i];


			$data2 = array
			(
				'order_id' => $insert_id,
				'product_id' => $product_id_count[$i],
				'qty' => $qty[$i],
				'unit' => $unit[$i],
				'unit_price' => $unit_price[$i],
				'discount' => $discount[$i],
				'franchise_id' => $franchise_id,

			);

			$this->db->insert('order_detail', $data2);

			$data22 = array
			(
				'qty' => $stock,

			);
			$this->db->where('product_id', $product_id_count[$i]);
			$this->db->update('vegshopy_product', $data22);


			$this->db->where(array('customer_id' => $customer_id, 'product_id' => $product_id_count[$i]));
			$this->db->delete('add_to_cart');

		}


		if ($minus_wallet != '') {
			$regData = array
			(

				'wallet' => $wallet - $minus_wallet,

			);

			$this->db->where(array('customer_id' => $customer_id))->update('customer', $regData);


			$current_date = date('d-m-Y');
			$bal_his = array(
				'customer_id' => $customer_id,
				'debit' => $minus_wallet,
				'opening_bal' => $wallet,
				'closing_bal' => $wallet - $minus_wallet,
				'c_d_date' => $current_date,
			);

			$this->db->insert('wallet_history', $bal_his);

		}


		$number = $mobile_no;
		$from = "EXOTIC";
		$enmsg = "Dear%20$first_name%20,%20your%20order%20placed%20successfully%20done.your%20Order%20id%20is%20#EX$order_generate_id.%20Thank%20you%20for%20order%20with%20EXOTIC%20BASKET";

		$usrnme = 't1t1aimbeat';
		$psd = '44364836';


		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://nimbusit.co.in/api/swsendSingle.asp");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, "key=".$api_key."&campaign=1&routeid=20&type=text&contacts=".$number."&senderid=".$from."&msg=".$enmsg);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "username=" . $usrnme . "&password=" . $psd . "&sender=" . $from . "&sendto=" . $number . "&message=" . $enmsg);
		$response = curl_exec($ch);

		curl_close($ch);


		$msg = 'Order Add Successfully.';
		$data[] = array('status' => 1, 'msg' => $msg, 'order_generate_id' => $order_generate_id);
		echo json_encode(array('result' => $data));


	}


	/******************************** Order history List **************************************************************
	 *******************************************************************************************************************/

	public function order_history()
	{

		$customer_id = $this->input->post('customer_id');
		$order_list = $this->sales_model->get_customer_wise_order_history_model($customer_id);
		$i = 1;
		if (!empty($order_list)) {
			foreach ($order_list as $order) {
				$oid = $order->order_id;
				$order_id = $order->order_generate_id;
				$status = $order->status;
				$order_total = $order->order_total;
				$order_date = date('j, F, Y', strtotime($order->order_date));
				$delivery_status = $order->delivery_status;
				$otp = $order->otp;

				$this->db->select('COUNT(order_id) AS no_of_product');
				$this->db->from('order_detail');
				$this->db->where('order_id', $oid);
				$query = $this->db->get();
				$result = $query->row();
				$no_of_product = $result->no_of_product;

				$data[] = array('oid' => $oid, 'order_id' => $order_id, 'status' => $status, 'order_total' => $order_total, 'order_date' => $order_date, 'item' => $no_of_product, 'delivery_status' => $delivery_status, 'otp' => $otp);
			}
			echo json_encode(array('status' => '1', 'result' => $data));
		} else {
			$msg = 'No Record Found.';
			$data[] = array('msg' => $msg);
			echo json_encode(array('status' => '0', 'result' => $data));

		}
	}


	/******************************** Order wise product history List *******************************************************************
	 ************************************************************************************************************************************/

	public function order_wise_item_history()
	{

		$oid = $this->input->post('oid');
		$order_list = $this->sales_model->get_order_wise_item_history_model($oid);
		$i = 1;
		if (!empty($order_list)) {
			foreach ($order_list as $order) {
				$product_id = $order->product_id;
				$unit = $order->unit;
				$unit_price = $order->unit_price;
				$qty = $order->qty;
				$discount = $order->discount;

				$product_name = $order->product_name;
				$main_image = $order->main_image;
				$product_id = $order->product_id;

				$main_image = 'sterlex_admin/assets/images/product/' . $main_image;
				$image = base_url($main_image);


				$total_price = ($unit_price * $qty);

				$id = $order->order_d_id;
				if ($order->flag != NULL) {
					$flag = $order->flag;
				} else {
					$flag = '';
				}

				$data[] = array('id' => $id, 'product_name' => $product_name, 'total_price' => $total_price, 'qty' => $qty, 'main_image' => $image, 'unit' => $unit, 'flag' => $flag);
			}
			echo json_encode(array('status' => '1', 'result' => $data));
		} else {
			$msg = 'No Record Found.';
			$data[] = array('msg' => $msg);
			echo json_encode(array('status' => '0', 'result' => $data));

		}
	}


	/******************************** Order Summary *************************************************************************
	 ************************************************************************************************************************/

	public function order_summary()
	{

		$oid = $this->input->post('oid');
		$order_summary = $this->sales_model->get_order_summary($oid);

		$oid = $order_summary->order_id;
		$order_id = $order_summary->order_generate_id;
		$total_bag = $order_summary->total_bag;
		$bag_discount = $order_summary->bag_discount;
		$order_total = $order_summary->order_total;
		$slot_id = $order_summary->slot_id;
		$coupon_id = $order_summary->coupon_id;
		$deliver_address = $order_summary->deliver_address;
		$order_date = $order_summary->order_date;
		$status = $order_summary->status;
		$p_mode = $order_summary->p_mode;
		$wallet_use = $order_summary->wallet_use;
		$coupon_id = $order_summary->coupon_id;
		$delivery_charges = $order_summary->delivery_charges;

		if ($coupon_id != '') {
			$this->db->select('*');
			$this->db->from('coupon');
			$this->db->where('coupon_id', $coupon_id);
			$query = $this->db->get();
			$result = $query->row();
			//echo $this->db->last_query();exit();
			$coupon_value = $result->value;
		} else {
			$coupon_value = '0';
		}

		$this->db->select('COUNT(order_id) AS no_of_product');
		$this->db->from('order_detail');
		$this->db->where('order_id', $oid);
		$query = $this->db->get();
		$result = $query->row();
		//echo $this->db->last_query();exit();
		$no_of_product = $result->no_of_product;

		$slot_list = $this->product_model->get_slot_id_wise_model($slot_id);
		$slot_id = $slot_list->slot_id;
		$slot_timing = $slot_list->slot_timing;
		$day = substr($slot_list->day, 0, 3);


		$data[] = array('order_id' => $order_id, 'p_mode' => $p_mode, 'item' => $no_of_product, 'order_status' => $status, 'deliver_address' => $deliver_address, 'total_bag' => $total_bag, 'bag_discount' => $bag_discount, 'order_total' => $order_total, 'coupon_value' => $coupon_value, 'day' => $day, 'slot_timing' => $slot_timing, 'wallet_use' => $wallet_use, 'delivery_charges' => $delivery_charges);


		echo json_encode(array('status' => '1', 'result' => $data));

	}


	/******************************** Customer Profile *********************************************************************************
	 ************************************************************************************************************************************/

	public function customer_profile()
	{

		$customer_id = $this->input->post('customer_id');
		$customer_details = $this->customer_model->get_customer_details($customer_id);

		// print_r($customer_details);exit;

		$customer_unique_id = $customer_details->customer_unique_id;
		$first_name = $customer_details->first_name;
		$last_name = $customer_details->last_name;
		$mobile_no = $customer_details->mobile_no;
		$email_id = $customer_details->email_id;
		$customer_pincode = $customer_details->pincode;

		$data[] = array('customer_id' => $customer_id, 'customer_unique_id' => $customer_unique_id, 'first_name' => $first_name, 'last_name' => $last_name, 'mobile_no' => $mobile_no, 'email_id' => $email_id, 'customer_pincode' => $customer_pincode);

		echo json_encode(array('status' => '1', 'result' => $data));

	}


	/******************************** Customer Update Profile *******************************************************************
	 *****************************************************************************************************************************/
	public function update_profile()
	{
		$customer_id = $this->input->post('customer_id');
		$first_name = $this->input->post('first_name');
		$last_name = $this->input->post('last_name');
		$mobile_no = $this->input->post('mobile_no');
		$email_id = $this->input->post('email_id');
		$state = $this->input->post('state');
		$city_id = $this->input->post('city');
		$pincode = $this->input->post('customer_pincode');


		if ($customer_id != '') {
			$update_data = array
			(
				'first_name' => $first_name,
				'last_name' => $last_name,
				'mobile_no' => $mobile_no,
				'email_id' => $email_id,
				'pincode' => $pincode,
				'city_id' => $city_id,
				'update_datetime' => date('Y-m-d h:i:s')
			);
			$this->db->where('customer_id', $customer_id);
			$this->db->update('customer', $update_data);

			$msg = 'Profile Updated Successfully.';
			$data[] = array('status' => 1, 'msg' => $msg);
		} else {
			$msg = 'Error while update profile.';
			$data[] = array('status' => 0, 'msg' => $msg);
		}
		echo json_encode(array('result' => $data));

	}


	/********************************   Search Product **********************************************************
	 *************************************************************************************************************/

	public function product_search_list()
	{
		$franchise_id = $this->input->post('franchise_id');
		$term = $this->input->post('key');
		$product_search = $this->product_model->getAllProduct($term, $franchise_id);
		if (!empty($product_search)) {
			foreach ($product_search as $product) {
				$sub_category_id = $product->product_id;
				$category_id = $product->category_id;
				$product_name = $product->product_name;

				$this->db->select('*');
				$this->db->from('category');
				$this->db->where('category_id', $category_id);
				$query = $this->db->get();
				$result = $query->row();
				//echo $this->db->last_query();exit();
				$name = $result->name;

				$data[] = array('sub_category_id' => $sub_category_id, 'product_name' => $product_name, 'category_name' => $name);
			}
			echo json_encode(array('status' => '1', 'result' => $data));
		} else {
			$data[] = array();
			echo json_encode(array('status' => '0', 'result' => $data));
		}

	}


	/******************************** MIN AMOUNT *********************************************************
	 ******************************************************************************************************/

	public function minimum_amount_limit()
	{

		$amount = $this->product_model->get_order_min_amount();

		$total = $amount->min_limit;
		$total1 = $amount->subscribe_min_limit;
		$total2 = $amount->wallet_use_min_limit;
		$data[] = array('min_limit' => $total, 'subscription_min_limit' => $total1, 'wallet_use_min_limit' => $total2);

		echo json_encode(array('status' => '1', 'result' => $data));

	}


	public function order_limit()
	{

		$franchise_id = $this->input->post('franchise_id');
		$current_date = date('d-m-Y');

		$this->db->select('COUNT(order_id) AS total_order');
		$this->db->from('product_order');
		$this->db->where('franchise_id', $franchise_id);
		$this->db->where('order_date', $current_date);
		$query = $this->db->get();
		$result = $query->row();
		$total_order = $result->total_order;


		$this->db->select('*');
		$this->db->from('order_limit');
		$this->db->where('franchise_id', $franchise_id);
		$query = $this->db->get();
		$result = $query->row();
		$order_limit = $result->order_limit;

		if ($total_order <= $order_limit) {
			$chk = 1;
			$data[] = array("status" => $chk);

		} else {

			$chk = 0;
			$data[] = array("status" => $chk);
		}


		echo json_encode(array("result" => $data));


	}


	/******************************** Customer Wallet *******************************************************************
	 ************************************************************************************************************************************/

	public function customer_wallet()
	{

		$customer_id = $this->input->post('customer_id');
		$wallet_details = $this->customer_model->get_customer_details($customer_id);

		// print_r($customer_details);exit;

		$wallet = $wallet_details->wallet;

		$data[] = array('customer_id' => $customer_id, 'wallet' => $wallet);

		echo json_encode(array('status' => '1', 'result' => $data));

	}

	/******************************** Wallet History *******************************************************************
	 ********************************************************************************************************************/

	public function wallet_history()
	{

		$customer_id = $this->input->post('customer_id');
		$wallet_history = $this->customer_model->get_wallet_history($customer_id);

		if (!empty($wallet_history)) {
			foreach ($wallet_history as $wallet) {

				$opening_bal = $wallet->opening_bal;
				$closing_bal = $wallet->closing_bal;
				$credit = $wallet->credit;
				$debit = $wallet->debit;
				$c_d_date = $wallet->c_d_date;

				if ($credit == NULL) {
					$credit = '';
				} else {
					$credit = $credit;
				}

				if ($debit == NULL) {
					$debit = '';
				} else {
					$debit = $debit;
				}

				$data[] = array('customer_id' => $customer_id, 'opening_bal' => $opening_bal, 'closing_bal' => $closing_bal, 'credit' => $credit, 'debit' => $debit, 'c_d_date' => $c_d_date);
			}
			echo json_encode(array('status' => '1', 'result' => $data));
		} else {
			$data[] = array();
			echo json_encode(array('status' => '0', 'result' => $data));

		}


	}


	/******************************** Cancel Product ****************************************************************
	 *********************************************************************************************************************/

	public function cancel_product()
	{

		$id = $this->input->post('id');

		if ($id != '') {
			$this->db->select('*');
			$this->db->from('order_detail');
			$this->db->where('order_d_id', $id);
			$query1 = $this->db->get();
			$result = $query1->row();
			$order_id = $result->order_id;
			$product_id = $result->product_id;
			$qty = $result->qty;
			$unit = $result->unit;
			$unit_price = $result->unit_price;
			$discount = $result->discount;

			$total_price = ($unit_price * $qty);

			$discount_price = $total_price - $discount;
			$discount_amt = $discount;

			$this->db->select('*');
			$this->db->from('product_order');
			$this->db->where('order_id', $order_id);
			$query22 = $this->db->get();
			$result22 = $query22->row();
			$bag_discount = $result22->bag_discount;
			$order_total = $result22->order_total;
			$total_bag = $result22->total_bag;

			$a = $total_bag - $total_price;
			$b = $bag_discount - $discount_amt;
			$c = $order_total - $discount_price;


			$update_data = array
			(
				'total_bag' => $a,
				'bag_discount' => $b,
				'order_total' => $c,

			);
			$this->db->where('order_id', $order_id);
			$this->db->update('product_order', $update_data);


			$update_data1 = array
			(
				'flag' => '1',

			);
			$this->db->where('order_d_id', $id);
			$this->db->update('order_detail', $update_data1);

			$data[] = array('status' => 1);
			echo json_encode(array('result' => $data));
		} else {

			$data[] = array('status' => 0);
			echo json_encode(array('result' => $data));
		}


	}

	/******************************** Recommend List ******************************************************************************
	 ********************************************************************************************************************************/

	public function best_selling_product()
	{

		$franchise_id = $this->input->post('franchise_id');
		$customer_id = $this->input->post('customer_id');
		$product_list = $this->sales_model->get_best_selling_product($franchise_id);
		$i = 1;
		if (!empty($product_list)) {
			foreach ($product_list as $product) {
				$product_id = $product->product_id;
				$product_name = $product->product_name;
				$main_image = $product->main_image;
				$qty = $product->qty;
				$type = $product->type;


				$serv = array();
				$CI =& get_instance();
				$CI->load->model('Product_model');
				$result = $CI->product_model->product_details_product_id_wise($product_id);

				foreach ($result as $p_details) {
					$id = $p_details['id'];
					$unit = $p_details['title'];
					$price = $p_details['unit_price'];
					$discount = $p_details['discount'];
					$serv[] = array('price_id' => $id, "unit" => $unit, "price" => $price, "discount" => $discount);
					$i++;
				}

				if ($qty == '0') {
					$status = '0';
				} else {
					$status = '1';
				}

				$main_image = 'sterlex_admin/assets/images/product/' . $main_image;
				$image = base_url($main_image);


				$q = $this->db->select('*');
				$q = $this->db->where('customer_id', $customer_id);
				$q = $this->db->where('product_id', $product_id);
				$q = $this->db->get('add_to_cart');
				$rowcount = $q->num_rows();

				if ($rowcount > 0) {
					$this->db->select('*');
					$this->db->from('add_to_cart');
					$this->db->where('product_id', $product_id);
					$this->db->where('customer_id', $customer_id);
					$query = $this->db->get();
					$result = $query->row();
					$p_qty = $result->qty;


				} else {
					$p_qty = '0';
				}

				$data[] = array('product_id' => $product_id, 'product_name' => $product_name, 'image' => $image, 'qty' => $p_qty, 'flag' => $status, 'type' => $type, 'price_details' => $serv);
			}
			echo json_encode(array('status' => '1', 'result' => $data));
		} else {
			$msg = 'No Record Found.';
			$data[] = array('msg' => $msg);
			echo json_encode(array('status' => '0', 'result' => $data));

		}
	}


	/******************************** Pick Up Point *******************************************************************
	 ********************************************************************************************************************/

	public function pickup_point()
	{
		$franchise_id = $this->input->post('franchise_id');
		$pikcup_list = $this->customer_model->get_pickup_point($franchise_id);

		if (!empty($pikcup_list)) {
			foreach ($pikcup_list as $pickup) {

				$pick_up_id = $pickup->pick_up_id;
				$pickup_address = $pickup->pickup_address;


				$data[] = array('pick_up_id' => $pick_up_id, 'pickup_address' => $pickup_address);
			}
			echo json_encode(array('status' => '1', 'result' => $data));
		} else {
			$data[] = array();
			echo json_encode(array('status' => '0', 'result' => $data));

		}


	}


	/********************************  Resend Otp  ******************************************************************************
	 *****************************************************************************************************************************/
	public function resend_otp()
	{
		$mobile_no = $this->input->post('mobile_no');

		$otp = rand('1111', '9999');
		$number = $mobile_no;
		$from = "EXOTIC";
		$enmsg = "One Time%20OTP%20To%20Verify%20Mobile%20Number%20:%20$otp";

		$usrnme = 't1t1aimbeat';
		$psd = '44364836';


		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://nimbusit.co.in/api/swsendSingle.asp");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		//curl_setopt($ch, CURLOPT_POSTFIELDS, "key=".$api_key."&campaign=1&routeid=20&type=text&contacts=".$number."&senderid=".$from."&msg=".$enmsg);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "username=" . $usrnme . "&password=" . $psd . "&sender=" . $from . "&sendto=" . $number . "&message=" . $enmsg);
		$response = curl_exec($ch);
		curl_close($ch);

		$chk = 1;
		$msg = 'Otp send successfully.';
		$data[] = array("status" => $chk, "otp" => $otp, "msg" => $msg);

		echo json_encode(array("result" => $data));
	}


	public function order_cancel()
	{
		$oid = $this->input->post('oid');
		$cancel_resion = $this->input->post('cancel_resion');

		$update_data = array
		(

			'status' => '4',
			'cancel_resion' => $cancel_resion,
		);

		$this->db->where('order_id', $oid)->update('product_order', $update_data);


		$chk = 1;
		$data[] = array("status" => $chk);


		echo json_encode(array("result" => $data));
	}


	/******************************** Ofer List *********************************************************************************
	 ********************************************************************************************************************************/

	public function offer_list()
	{

		$franchise_id = $this->input->post('franchise_id');
		$offer_list = $this->product_model->get_all_offer_model($franchise_id);
		$i = 1;
		if (!empty($offer_list)) {
			foreach ($offer_list as $offer) {
				$offer_id = $offer->offer_id;
				$offer_image = $offer->image;

				$main_image = 'sterlex_admin/assets/images/offer/' . $offer_image;
				$image = base_url($main_image);


				$data[] = array('offer_id' => $offer_id, 'image' => $image);
			}
			echo json_encode(array('status' => '1', 'result' => $data));
		} else {
			$msg = 'No Record Found.';
			$data[] = array('msg' => $msg);
			echo json_encode(array('status' => '0', 'result' => $data));

		}
	}


	public function offer_wise_product()
	{

		$offer_id = $this->input->post('offer_id');
		$customer_id = $this->input->post('customer_id');
		$product_list = $this->product_model->product_details_offer_id_wise($offer_id);
		$i = 1;
		if (!empty($product_list)) {
			foreach ($product_list as $product) {
				$product_id = $product->product_id;
				$main_image = $product->main_image;
				$product_name = $product->product_name;
				$unit = $product->title;
				$price = $product->unit_price;
				$discount = $product->discount;
				$available_qty = $product->qty;


				$main_image = 'sterlex_admin/assets/images/product/' . $main_image;
				$image = base_url($main_image);


				$q = $this->db->select('*');
				$q = $this->db->where('customer_id', $customer_id);
				$q = $this->db->where('product_id', $product_id);
				$q = $this->db->get('add_to_cart');
				$rowcount = $q->num_rows();

				if ($rowcount > 0) {
					$this->db->select('*');
					$this->db->from('add_to_cart');
					$this->db->where('product_id', $product_id);
					$this->db->where('customer_id', $customer_id);
					$query = $this->db->get();
					$result = $query->row();
					$p_qty = $result->qty;


				} else {
					$p_qty = '0';
				}

				$data[] = array('product_id' => $product_id, 'product_name' => $product_name, 'unit' => $unit, 'price' => $price, 'discount' => $discount, 'available_qty' => $available_qty, 'qty' => $p_qty, 'image' => $image);
			}
			echo json_encode(array('status' => '1', 'result' => $data));
		} else {
			$msg = 'No Record Found.';
			$data[] = array('msg' => $msg);
			echo json_encode(array('status' => '0', 'result' => $data));

		}
	}


	/********************************  My Subscription ***************************************************************
	 ******************************************************************************************************************/

	public function my_subscription()
	{

		$customer_id = $this->input->post('customer_id');
		$franchise_id = $this->input->post('franchise_id');
		$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
		$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
		$subscribe_mode = $this->input->post('subscribe_mode');
		$day = $this->input->post('day');
		$p_mode = $this->input->post('p_mode');
		$address = $this->input->post('address');
		$order_total = $this->input->post('order_total');
		$coupon_id = $this->input->post('coupon_id');
		$total_day = $this->input->post('total_day');
		$rid = $this->input->post('rid');

		$subscribe_generate_id = mt_rand(000000, 999900);

		$currdate = date('d-m-Y');

		if ($subscribe_mode == 'Daily') {

			$subscribe_entry = array
			(

				'customer_id' => $customer_id,
				'subscribe_generate_id' => 'VEG' . $subscribe_generate_id,
				'from_date' => $from_date,
				'to_date' => $to_date,
				'subscribe_mode' => $subscribe_mode,
				'p_mode' => $p_mode,
				'address' => $address,
				'order_total' => $order_total,
				's_date' => $currdate,
				'coupon_id' => $coupon_id,
				'franchise_id' => $franchise_id,
				'day' => 'Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
				'total_day' => $total_day,
				'rid' => $rid,
			);

			$this->db->insert('subscription', $subscribe_entry);
			$insert_id = $this->db->insert_id();

			$product_id_count = explode(',', $this->input->post('product_id'));
			$qty = explode(',', $this->input->post('qty'));
			$unit_price = explode(',', $this->input->post('unit_price'));
			$discount = explode(',', $this->input->post('discount'));
			$unit = explode(',', $this->input->post('unit'));
			$cnt = count($product_id_count);
			for ($i = 0; $i < $cnt; $i++) {
				$data2 = array
				(
					'subscribe_id' => $insert_id,
					'product_id' => $product_id_count[$i],
					'qty' => $qty[$i],
					'unit_price' => $unit_price[$i],
					'discount' => $discount[$i],
					'unit' => $unit[$i],
					'from_date' => $from_date,
					'to_date' => $to_date,
					'franchise_id' => $franchise_id,

				);

				$this->db->insert('subscribe_product', $data2);


			}

		} elseif ($subscribe_mode == 'Weekly') {

			$subscribe_entry = array
			(

				'customer_id' => $customer_id,
				'subscribe_generate_id' => 'VEG' . $subscribe_generate_id,
				'from_date' => $from_date,
				'to_date' => $to_date,
				'subscribe_mode' => $subscribe_mode,
				'day' => $day,
				'p_mode' => $p_mode,
				'address' => $address,
				'order_total' => $order_total,
				's_date' => $currdate,
				'coupon_id' => $coupon_id,
				'total_day' => $total_day,
				'rid' => $rid,
				'franchise_id' => $franchise_id,
			);

			$this->db->insert('subscription', $subscribe_entry);
			$insert_id = $this->db->insert_id();

			$product_id_count = explode(',', $this->input->post('product_id'));
			$qty = explode(',', $this->input->post('qty'));
			$unit_price = explode(',', $this->input->post('unit_price'));
			$discount = explode(',', $this->input->post('discount'));
			$unit = explode(',', $this->input->post('unit'));
			$cnt = count($product_id_count);
			for ($i = 0; $i < $cnt; $i++) {
				$data2 = array
				(
					'subscribe_id' => $insert_id,
					'product_id' => $product_id_count[$i],
					'qty' => $qty[$i],
					'unit_price' => $unit_price[$i],
					'discount' => $discount[$i],
					'unit' => $unit[$i],
					'from_date' => $from_date,
					'to_date' => $to_date,
					'franchise_id' => $franchise_id,

				);

				$this->db->insert('subscribe_product', $data2);


			}

		} elseif ($subscribe_mode == 'Custom') {

			$subscribe_entry = array
			(

				'customer_id' => $customer_id,
				'subscribe_generate_id' => 'VEG' . $subscribe_generate_id,
				'from_date' => $from_date,
				'to_date' => $to_date,
				'subscribe_mode' => $subscribe_mode,
				'day' => $day,
				'p_mode' => $p_mode,
				'address' => $address,
				'order_total' => $order_total,
				's_date' => $currdate,
				'coupon_id' => $coupon_id,
				'total_day' => $total_day,
				'rid' => $rid,
				'franchise_id' => $franchise_id,
			);

			$this->db->insert('subscription', $subscribe_entry);
			$insert_id = $this->db->insert_id();

			$product_id_count = explode(',', $this->input->post('product_id'));
			$qty = explode(',', $this->input->post('qty'));
			$unit_price = explode(',', $this->input->post('unit_price'));
			$discount = explode(',', $this->input->post('discount'));
			$unit = explode(',', $this->input->post('unit'));
			$cnt = count($product_id_count);
			for ($i = 0; $i < $cnt; $i++) {
				$data2 = array
				(
					'subscribe_id' => $insert_id,
					'product_id' => $product_id_count[$i],
					'qty' => $qty[$i],
					'unit_price' => $unit_price[$i],
					'discount' => $discount[$i],
					'unit' => $unit[$i],
					'from_date' => $from_date,
					'to_date' => $to_date,
					'franchise_id' => $franchise_id,

				);

				$this->db->insert('subscribe_product', $data2);


			}

		}


		$msg = 'Subscribe Successfully.';
		$data[] = array('status' => 1, 'msg' => $msg);
		echo json_encode(array('result' => $data));


	}


	/********************************  SUbscription List *************************************************************
	 ******************************************************************************************************************/

	public function subscription_list()
	{
		$customer_id = $this->input->post('customer_id');

		$subscribe_list = $this->sales_model->get_subscribe_list_model($customer_id);
		$i = 1;
		if (!empty($subscribe_list)) {
			foreach ($subscribe_list as $subscribe) {
				$subscribe_id = $subscribe->subscribe_id;
				$subscribe_generate_id = $subscribe->subscribe_generate_id;
				$from_date = date("d-m-Y", strtotime($subscribe->from_date));
				$to_date = date("d-m-Y", strtotime($subscribe->to_date));
				$subscribe_mode = $subscribe->subscribe_mode;
				$p_mode = $subscribe->p_mode;
				$payment_status = $subscribe->payment_status;
				$address = $subscribe->address;
				$order_total = $subscribe->order_total;
				$s_subscribe_status = $subscribe->subscribe_status;
				$entry_datetime = date("d-m-Y", strtotime($subscribe->entry_datetime));

				$serv2 = array();
				$serv = array();
				if (!empty($subscribe->day)) {
					$day = $subscribe->day;
					$day_list = explode(",", $day);
					$i = 1;
					foreach ($day_list as $day) {
						//$service_list1 = explode("-",$service_list);
						$serv[] = array("day" => $day);
						$i++;
					}
				} else {
					$serv = array();
				}


				$CI =& get_instance();
				$CI->load->model('Sales_model');
				$result = $CI->Sales_model->subscribe_product($subscribe_id);

				if (!empty($result)) {
					$i = 1;
					foreach ($result as $sp) {
						$spi = $sp['id'];
						$product_name = $sp['product_name'];
						$qty = $sp['qty'];
						$unit = $sp['unit'];
						$unit_price = $sp['unit_price'];
						$discount = $sp['discount'];
						$main_image = $sp['main_image'];
						$subscribe_status = $sp['subscribe_status'];

						$main_image = 'sterlex_admin/assets/images/product/' . $main_image;
						$image = base_url($main_image);

						$serv2[] = array('spi' => $spi, "product_name" => $product_name, "qty" => $qty, "unit" => $unit, "unit_price" => $unit_price, "discount" => $discount, "subscribe_status" => $subscribe_status, "image" => $image);
						$i++;
					}
				} else {
					$serv2 = array();
				}


				$data[] = array('subscribe_id' => $subscribe_id, 'subscribe_generate_id' => $subscribe_generate_id, 'from_date' => $from_date, 'to_date' => $to_date, 'subscribe_mode' => $subscribe_mode
				, 'p_mode' => $p_mode, 'payment_status' => $payment_status, "address" => $address, "order_total" => $order_total, 'subscribe_status' => $s_subscribe_status, "order_date" => $entry_datetime, 'day' => $serv, 'product_details' => $serv2);
			}
			echo json_encode(array('status' => '1', 'result' => $data));
		} else {
			$msg = 'No Record Found.';
			$data[] = array('msg' => $msg);
			echo json_encode(array('status' => '0', 'result' => $data));

		}
	}


	/********************************************   ******************************************************
	 *****************************************************************************************************************************/

	public function single_product_pause()
	{
		$spi = $this->input->post('spi');

		$update_data = array
		(

			'subscribe_status' => '1',
		);

		$this->db->where('id', $spi)->update('subscribe_product', $update_data);


		$chk = 1;
		$data[] = array("status" => $chk);


		echo json_encode(array("result" => $data));
	}


	public function single_product_end()
	{
		$spi = $this->input->post('spi');

		$update_data = array
		(

			'subscribe_status' => '2',
		);

		$this->db->where('id', $spi)->update('subscribe_product', $update_data);


		$chk = 1;
		$data[] = array("status" => $chk);


		echo json_encode(array("result" => $data));
	}

	public function single_product_resume()
	{
		$spi = $this->input->post('spi');

		$update_data = array
		(

			'subscribe_status' => '0',
		);

		$this->db->where('id', $spi)->update('subscribe_product', $update_data);


		$chk = 1;
		$data[] = array("status" => $chk);


		echo json_encode(array("result" => $data));
	}


	public function all_product_pause()
	{
		$subscribe_id = $this->input->post('subscribe_id');

		$update_data = array
		(

			'subscribe_status' => '1',
		);

		$this->db->where('subscribe_id', $subscribe_id)->update('subscribe_product', $update_data);

		$update_data1 = array
		(

			'subscribe_status' => '1',
		);

		$this->db->where('subscribe_id', $subscribe_id)->update('subscription', $update_data1);


		$chk = 1;
		$data[] = array("status" => $chk);


		echo json_encode(array("result" => $data));
	}


	public function all_product_end()
	{
		$subscribe_id = $this->input->post('subscribe_id');

		$update_data = array
		(

			'subscribe_status' => '2',
		);

		$this->db->where('subscribe_id', $subscribe_id)->update('subscribe_product', $update_data);

		$update_data1 = array
		(

			'subscribe_status' => '2',
		);

		$this->db->where('subscribe_id', $subscribe_id)->update('subscription', $update_data1);


		$chk = 1;
		$data[] = array("status" => $chk);


		echo json_encode(array("result" => $data));
	}

	public function all_product_resume()
	{
		$subscribe_id = $this->input->post('subscribe_id');

		$update_data = array
		(

			'subscribe_status' => '0',
		);

		$this->db->where('subscribe_id', $subscribe_id)->update('subscribe_product', $update_data);

		$update_data1 = array
		(

			'subscribe_status' => '0',
		);

		$this->db->where('subscribe_id', $subscribe_id)->update('subscription', $update_data1);


		$chk = 1;
		$data[] = array("status" => $chk);


		echo json_encode(array("result" => $data));
	}

	function dayCount($from_date, $to_date, $day)
	{
		$from = $from_date;
		$to = $to_date;

		$wF = $from->format('w');
		$wT = $to->format('w');
		if ($wF < $wT) $isExtraDay = $day >= $wF && $day <= $wT;
		else if ($wF == $wT) $isExtraDay = $wF == $day;
		else                 $isExtraDay = $day >= $wF || $day <= $wT;

		return floor($from->diff($to)->days / 7) + $isExtraDay;
	}

	function my_subscribtion_cal()
	{
		$product_id_count = explode(',', $this->input->post('product_id'));
		$qty = explode(',', $this->input->post('qty'));
		$unit_price = explode(',', $this->input->post('unit_price'));
		$discount = explode(',', $this->input->post('discount'));
		$unit = explode(',', $this->input->post('unit'));
		$cnt = count($product_id_count);


		$from_date = new DateTime(date("Y-m-d", strtotime($this->input->post('from_date'))));
		$to_date = new DateTime(date("Y-m-d", strtotime($this->input->post('to_date'))));
		$subscribe_mode = $this->input->post('subscribe_mode');
		$day = $this->input->post('day');

		if ($subscribe_mode == 'Daily') {
			$interval = $from_date->diff($to_date);
			$no_of_day = $interval->format('%R%a');
			$total_days = str_replace("+", "", $no_of_day) + 1;

		} elseif ($subscribe_mode == 'Weekly') {
			if ($day == 'Monday') {
				$day = '1';

			} elseif ($day == 'Tuesday') {
				$day = '2';

			} elseif ($day == 'Wednesday') {
				$day = '3';

			} elseif ($day == 'Thursday') {
				$day = '4';

			} elseif ($day == 'Friday') {
				$day = '5';
			} elseif ($day == 'Saturday') {
				$day = '6';
			} elseif ($day == 'Sunday') {
				$day = '7';
			}
			$total_days = $this->dayCount($from_date, $to_date, $day);
		} elseif ($subscribe_mode == 'Custom') {
			$day_count = explode(',', $this->input->post('day'));
			$cnt1 = count($day_count);
			$sum_day = 0;
			for ($i = 0; $i < $cnt1; $i++) {
				if ($day_count[$i] == 'Monday') {
					$day = '1';

				} elseif ($day_count[$i] == 'Tuesday') {
					$day = '2';

				} elseif ($day_count[$i] == 'Wednesday') {
					$day = '3';

				} elseif ($day_count[$i] == 'Thursday') {
					$day = '4';

				} elseif ($day_count[$i] == 'Friday') {
					$day = '5';
				} elseif ($day_count[$i] == 'Saturday') {
					$day = '6';
				} elseif ($day_count[$i] == 'Sunday') {
					$day = '7';
				}

				$total_days = $this->dayCount($from_date, $to_date, $day);
				$sum_day += $total_days;

			}

			$total_days = $sum_day;
		}

		$sum = 0;
		$bag_discount = 0;
		$order_total = 0;
		for ($i = 0; $i < $cnt; $i++) {
			$total_price = ($unit_price[$i] * $qty[$i]);
			$discount_price = $total_price - $discount[$i];
			$discount_amt = $discount[$i];

			$sum += $total_price * $total_days;
			$bag_discount += $discount_amt * $total_days;
			$order_total += $discount_price * $total_days;


			$this->db->select('*');
			$this->db->from('vegshopy_product');
			$this->db->where('product_id', $product_id_count[$i]);
			$query1 = $this->db->get();
			$result = $query1->row();
			$product_name = $result->product_name;
			$main_image = $result->main_image;

			$main_image = 'sterlex_admin/assets/images/product/' . $main_image;
			$image = base_url($main_image);


			$total_price1 = ($unit_price[$i] * $qty[$i]);
			$discount_price1 = $total_price1 - $discount[$i];
			$discount_amt1 = $discount[$i];
			$order_total1 = $discount_price1;

			$serv[] = array("product_id" => $product_id_count[$i], "product_name" => $product_name, "unit" => $unit[$i], "price" => $unit_price[$i], "discount" => $discount[$i], "qty" => $qty[$i], "total_amt" => $order_total1, "image" => $image);


		}
		$bag_details[] = array("total_day" => $total_days, "total_bag" => $sum, "bag_discount" => $bag_discount, "order_total" => $order_total, "product_list" => $serv);
		echo json_encode(array('status' => '1', 'bag_details' => $bag_details));

	}


	public function add_more_product()
	{

		$subscribe_id = $this->input->post('subscribe_id');
		$product_id_count = explode(',', $this->input->post('product_id'));
		$qty = explode(',', $this->input->post('qty'));
		$unit_price = explode(',', $this->input->post('unit_price'));
		$discount = explode(',', $this->input->post('discount'));
		$unit = explode(',', $this->input->post('unit'));

		$this->db->select('*');
		$this->db->from('subscription');
		$this->db->where('subscribe_id', $subscribe_id);
		$query = $this->db->get();
		$result = $query->row();
		//echo $this->db->last_query();exit();
		$from_date = $result->from_date;
		$to_date = $result->to_date;

		$cnt = count($product_id_count);
		for ($i = 0; $i < $cnt; $i++) {
			$data2 = array
			(
				'subscribe_id' => $subscribe_id,
				'product_id' => $product_id_count[$i],
				'qty' => $qty[$i],
				'unit_price' => $unit_price[$i],
				'discount' => $discount[$i],
				'unit' => $unit[$i],
				'from_date' => $from_date,
				'to_date' => $to_date,

			);

			$this->db->insert('subscribe_product', $data2);


		}
		$chk = 1;
		$data[] = array("status" => $chk);


		echo json_encode(array("result" => $data));
	}


	/******************************** Rebook Subscribe *******************************************************************
	 *****************************************************************************************************************************/
	public function re_book_subscribe()
	{

		$subscribe_id = $this->input->post('subscribe_id');
		$end_date = date("Y-m-d", strtotime($this->input->post('end_date')));


		$update_data = array
		(
			'to_date' => $end_date

		);
		$this->db->where('subscribe_id', $subscribe_id);
		$this->db->update('subscription', $update_data);

		$msg = 'Subscribe renewal successfully.';
		$data[] = array('status' => 1, 'msg' => $msg);

		echo json_encode(array('result' => $data));

	}

	public function view_product_entry()
	{

		$customer_id = $this->input->post('customer_id');
		$product_id = $this->input->post('product_id');


		$data2 = array
		(
			'customer_id' => $customer_id,
			'product_id' => $product_id,
		);

		$this->db->insert('view_product_history', $data2);


		$chk = 1;
		$data[] = array("status" => $chk);


		echo json_encode(array("result" => $data));
	}


	public function view_product_list()
	{
		$customer_id = $this->input->post('customer_id');
		$product_list = $this->product_model->get_all_view_history_model($customer_id);
		$i = 1;
		if (!empty($product_list)) {
			foreach ($product_list as $product) {
				$product_id = $product->product_id;
				$product_name = $product->product_name;
				$main_image = $product->main_image;
				$qty = $product->qty;


				$serv = array();
				$CI =& get_instance();
				$CI->load->model('Product_model');
				$result = $CI->product_model->product_details_product_id_wise($product_id);

				foreach ($result as $p_details) {
					$id = $p_details['id'];
					$unit = $p_details['title'];
					$price = $p_details['unit_price'];
					$discount = $p_details['discount'];
					$serv[] = array('price_id' => $id, "unit" => $unit, "price" => $price, "discount" => $discount);
					$i++;
				}

				if ($qty == '0') {
					$status = '0';
				} else {
					$status = '1';
				}

				$main_image = 'sterlex_admin/assets/images/product/' . $main_image;
				$image = base_url($main_image);


				$q = $this->db->select('*');
				$q = $this->db->where('customer_id', $customer_id);
				$q = $this->db->where('product_id', $product_id);
				$q = $this->db->get('add_to_cart');
				$rowcount = $q->num_rows();

				if ($rowcount > 0) {
					$this->db->select('*');
					$this->db->from('add_to_cart');
					$this->db->where('product_id', $product_id);
					$this->db->where('customer_id', $customer_id);
					$query = $this->db->get();
					$result = $query->row();
					$p_qty = $result->qty;


				} else {
					$p_qty = '0';
				}

				$data[] = array('product_id' => $product_id, 'product_name' => $product_name, 'image' => $image, 'qty' => $p_qty, 'flag' => $status, 'price_details' => $serv);
			}
			echo json_encode(array('status' => '1', 'result' => $data));
		} else {
			$msg = 'No Record Found.';
			$data[] = array('msg' => $msg);
			echo json_encode(array('status' => '0', 'result' => $data));

		}
	}


	/******************************** check pincode   ****************************************************************************
	 *****************************************************************************************************************************/
	public function check_pincode()
	{
		$pincode = $this->input->post('pincode');
		$franchise_id = $this->input->post('franchise_id');

		$this->db->select('*');
		$this->db->from('pincode');
		$this->db->where('pincode', $pincode);
		$this->db->where('franchise_id', $franchise_id);
		$query = $this->db->get();
		$rowcount = $query->num_rows();
//		echo $this->db->last_query();
		if ($rowcount > 0) {


			$chk = 1;
			$picked_up_data = $query->row_array();
//			var_dump($picked_up_data);
			$pk = $picked_up_data['delivery_option'];
			$data[] = array("status" => $chk, 'pick_up_option' => $pk);


		} else {
			$chk = 0;

			$data[] = array("status" => $chk, 'pick_up_option' => 0);
		}
		echo json_encode(array("result" => $data));
	}

	////////////////////////////////// Delivery Boy App ////////////////////////////////

	public function login_delivery_boy()
	{
		$mobile_no = $this->input->post('mobile_no');
		$password = $this->input->post('password');

		$this->db->select('*');
		$this->db->from('delivery_boy');
		$this->db->where('mobile_no', $mobile_no);
		$this->db->where('password', md5($password));
		$query = $this->db->get();
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {
			$result = $query->row();
			$delivery_boy_id = $result->db_id;
			$name = $result->name;
			$mobile_no = $result->mobile_no;
			$address = $result->address;
			$photo = $result->photo;

			if ($photo == '') {
				$photo = 'sterlex_admin/assets/images/login.jpg';
				$img = base_url($photo);

			} else {

				$photo = 'sterlex_admin/assets/images/deliver_boy/' . $photo;
				$img = base_url($photo);
			}


			$msg = 'login Successfully.';
			$data[] = array('status' => 1, 'msg' => $msg, 'delivery_boy_id' => $delivery_boy_id, 'name' => $name, 'mobile_no' => $mobile_no, 'address' => $address, 'photo' => $img);
			echo json_encode(array('result' => $data));
		} else {
			$msg = 'Unauthorized delivery boy.';
			$data[] = array('status' => 0, 'msg' => $msg);
			echo json_encode(array('result' => $data));
		}
	}


	/******************************** Order history List *******************************************************************
	 *******************************************************************************************************************/

	public function assign_order_list()
	{

		$db_id = $this->input->post('delivery_boy_id');
		$order_list = $this->sales_model->get_assign_product($db_id);
		$i = 1;
		if (!empty($order_list)) {
			foreach ($order_list as $order) {
				$oid = $order->order_id;
				$order_id = '#' . $order->order_generate_id;
				$status = $order->status;
				$order_total = $order->order_total;
				$deliver_address = $order->deliver_address;
				$order_date = date('j, F, Y', strtotime($order->order_date));
				$delivery_status = $order->delivery_status;
				$otp = $order->otp;

				$first_name = $order->first_name;
				$last_name = $order->last_name;
				$mobile_no = $order->mobile_no;

				$customer_name = $first_name . ' ' . $last_name;

				$day = substr($order->day, 0, 3);
				$slot_timing = $order->slot_timing;


				$this->db->select('COUNT(order_id) AS no_of_product');
				$this->db->from('order_detail');
				$this->db->where('order_id', $oid);
				$query = $this->db->get();
				$result = $query->row();
				$no_of_product = $result->no_of_product;

				$data[] = array('oid' => $oid, 'order_id' => $order_id, 'customer_name' => $customer_name, 'mobile_no' => $mobile_no, 'status' => $status, 'order_total' => $order_total, 'order_date' => $order_date, 'item' => $no_of_product, 'delivery_status' => $delivery_status, 'otp' => $otp, 'deliver_address' => $deliver_address, 'day' => $day, 'slot_timing' => $slot_timing);
			}
			echo json_encode(array('status' => '1', 'result' => $data));
		} else {
			$msg = 'No Record Found.';
			$data[] = array('msg' => $msg);
			echo json_encode(array('status' => '0', 'result' => $data));

		}
	}


	public function order_delivered()
	{
		$oid = $this->input->post('oid');
		$p_mode = $this->input->post('p_mode');
		$db_id = $this->input->post('delivery_boy_id');


		$this->db->select('*');
		$this->db->from('product_order');
		$this->db->where('order_id', $oid);
		$query = $this->db->get();
		$result = $query->row();
		$customer_id = $result->customer_id;
		$order_total = $result->order_total;
		$order_generate_id = $result->order_generate_id;


		$this->db->select('*');
		$this->db->from('customer');
		$this->db->where('customer_id', $customer_id);
		$query_cust = $this->db->get();
		$result_cust = $query_cust->row();
		$first_name = $result_cust->first_name;
		$mobile_no = $result_cust->mobile_no;
		$register_via = $result_cust->register_via;

		$update_data = array
		(

			'status' => '3',
			'p_mode' => $p_mode,
		);

		$this->db->where('order_id', $oid)->update('product_order', $update_data);

		if ($p_mode == '0') {
			$update_data = array
			(

				'payment_status' => '1',
			);

			$this->db->where('order_id', $oid)->update('product_order', $update_data);

			$this->db->select('*');
			$this->db->from('delivery_boy');
			$this->db->where('db_id', $db_id);
			$query22 = $this->db->get();
			$result22 = $query22->row();
			$wallet_db = $result22->wallet;

			$insertArray1 = array
			(
				'wallet' => $wallet_db + $order_total
			);
			$this->db->where('db_id', $db_id);
			$this->db->update('delivery_boy', $insertArray1);

			$current_date = date('d-m-Y');
			$regData = array(
				'db_id' => $db_id,
				'order_id' => $order_generate_id,
				'credit' => $order_total,
				'opening_bal' => $wallet_db,
				'closing_bal' => $wallet_db + $order_total,
				'c_d_date' => $current_date,

			);

			$this->db->insert('db_wallet_history', $regData);


		}


		if ($register_via != NULL) {
			$this->db->select('*');
			$this->db->from('customer');
			$this->db->where('customer_id', $register_via);
			$query_cust = $this->db->get();
			$result_cust = $query_cust->row();
			$rcustomer_id = $result_cust->customer_id;
			$wallet_reord = $result_cust->wallet;

			$insertArray1 = array
			(
				'wallet' => $wallet_reord + 50
			);
			$this->db->where('customer_id', $rcustomer_id);
			$this->db->update('customer', $insertArray1);

			$current_date = date('d-m-Y');
			$regData = array(
				'customer_id' => $rcustomer_id,
				'credit' => '50',
				'opening_bal' => $wallet_reord,
				'closing_bal' => $wallet_reord + 50,
				'c_d_date' => $current_date,
			);

			$this->db->insert('wallet_history', $regData);

		}


		$sender = "BASKET";
		$number2 = $mobile_no;
		$msg2 = "Dear $first_name,your order $order_generate_id successfully delivered.";

		$api_key = '55A827A192C7C6';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://www.logonutility.in/app/smsapi/index.php");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "key=" . $api_key . "&&campaign=1&routeid=20&type=text&contacts=" . $number2 . "&senderid=" . $sender . "&msg=" . $msg2);
		$response = curl_exec($ch);

		curl_close($ch);


		$chk = 1;
		$data[] = array("status" => $chk);
		echo json_encode(array("result" => $data));
	}


	/********************************  Forget Delivery boy Otp  ******************************************************************************
	 *****************************************************************************************************************************/
	public function otp_for_delivery_boy()
	{
		$mobile_no = $this->input->post('mobile_no');

		$this->db->select('*');
		$this->db->from('delivery_boy');
		$this->db->where('mobile_no', $mobile_no);
		$query = $this->db->get();
		$rowcount = $query->num_rows();
		if ($rowcount > 0) {

			$otp = rand('0000', '9999');


			$sender = "BASKET";
			$number2 = $mobile_no;
			$msg2 = "One Time OTP To Verify Mobile Number : $otp";

			$api_key = '55A827A192C7C6';
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "https://www.logonutility.in/app/smsapi/index.php");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, "key=" . $api_key . "&&campaign=1&routeid=20&type=text&contacts=" . $number2 . "&senderid=" . $sender . "&msg=" . $msg2);
			$response = curl_exec($ch);

			curl_close($ch);

			$chk = 1;
			$data[] = array("status" => $chk, "otp" => $otp);


		} else {
			$chk = 0;
			$otp = '';
			$data[] = array("status" => $chk, "otp" => $otp);
		}
		echo json_encode(array("result" => $data));
	}


	/******************************** Password Update Deliveryboy ***************************************************************
	 *****************************************************************************************************************************/
	public function update_deliveryboy_password()
	{

		$mobile_no = $this->input->post('mobile_no');
		$password = $this->input->post('password');


		$update_data = array
		(
			'password' => md5($password),

		);
		$this->db->where('mobile_no', $mobile_no);
		$this->db->update('delivery_boy', $update_data);

		$msg = 'Password Updated Successfully.';
		$data[] = array('status' => 1, 'msg' => $msg);

		echo json_encode(array('result' => $data));

	}

	/******************************** Complete Order history List *****************************************************
	 *******************************************************************************************************************/

	public function complete_order_list()
	{

		$db_id = $this->input->post('delivery_boy_id');
		$order_list = $this->sales_model->get_complete_product($db_id);
		$i = 1;
		if (!empty($order_list)) {
			foreach ($order_list as $order) {
				$oid = $order->order_id;
				$order_id = '#' . $order->order_generate_id;
				$status = $order->status;
				$order_total = $order->order_total;
				$deliver_address = $order->deliver_address;
				$order_date = date('j, F, Y', strtotime($order->order_date));
				$delivery_status = $order->delivery_status;

				$first_name = $order->first_name;
				$last_name = $order->last_name;
				$mobile_no = $order->mobile_no;

				$customer_name = $first_name . ' ' . $last_name;

				$this->db->select('COUNT(order_id) AS no_of_product');
				$this->db->from('order_detail');
				$this->db->where('order_id', $oid);
				$query = $this->db->get();
				$result = $query->row();
				$no_of_product = $result->no_of_product;


				$assign_date = $order->assign_date;

				$data[] = array('oid' => $oid, 'order_id' => $order_id, 'customer_name' => $customer_name, 'mobile_no' => $mobile_no, 'status' => $status, 'order_total' => $order_total, 'order_date' => $order_date, 'item' => $no_of_product, 'delivery_status' => $delivery_status, 'deliver_address' => $deliver_address, 'assign_date' => $assign_date);
			}
			echo json_encode(array('status' => '1', 'result' => $data));
		} else {
			$msg = 'No Record Found.';
			$data[] = array('msg' => $msg);
			echo json_encode(array('status' => '0', 'result' => $data));

		}
	}


	/******************************** Deliverd Order history List ****************************************************
	 *******************************************************************************************************************/

	public function delivered_order_list()
	{

		$db_id = $this->input->post('delivery_boy_id');
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$order_list = $this->sales_model->get_delevered_product($db_id, $from_date, $to_date);
		$i = 1;
		if (!empty($order_list)) {
			foreach ($order_list as $order) {
				$oid = $order->order_id;
				$order_id = '#' . $order->order_generate_id;
				$status = $order->status;
				$order_total = $order->order_total;
				$deliver_address = $order->deliver_address;
				$order_date = date('j, F, Y', strtotime($order->order_date));
				$delivery_status = $order->delivery_status;

				$first_name = $order->first_name;
				$last_name = $order->last_name;
				$mobile_no = $order->mobile_no;
				$p_mode = $order->p_mode;

				$customer_name = $first_name . ' ' . $last_name;

				$this->db->select('COUNT(order_id) AS no_of_product');
				$this->db->from('order_detail');
				$this->db->where('order_id', $oid);
				$query = $this->db->get();
				$result = $query->row();
				$no_of_product = $result->no_of_product;

				$day = substr($order->day, 0, 3);
				$slot_timing = $order->slot_timing;
				$assign_date = $order->assign_date;


				$data[] = array('oid' => $oid, 'order_id' => $order_id, 'customer_name' => $customer_name, 'mobile_no' => $mobile_no, 'status' => $status, 'order_total' => $order_total, 'order_date' => $order_date, 'item' => $no_of_product, 'delivery_status' => $delivery_status, 'deliver_address' => $deliver_address, 'day' => $day, 'slot_timing' => $slot_timing, 'p_mode' => $p_mode, 'assign_date' => $assign_date);
			}
			echo json_encode(array('status' => '1', 'result' => $data));
		} else {
			$msg = 'No Record Found.';
			$data[] = array('msg' => $msg);
			echo json_encode(array('status' => '0', 'result' => $data));

		}
	}


	/********************************Cancel Order history List *******************************************************************
	 *******************************************************************************************************************/

	public function cancel_order_list()
	{

		$db_id = $this->input->post('delivery_boy_id');
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$order_list = $this->sales_model->get_cancel_product($db_id, $from_date, $to_date);
		$i = 1;
		if (!empty($order_list)) {
			foreach ($order_list as $order) {
				$oid = $order->order_id;
				$order_id = '#' . $order->order_generate_id;
				$status = $order->status;
				$order_total = $order->order_total;
				$deliver_address = $order->deliver_address;
				$order_date = date('j, F, Y', strtotime($order->order_date));
				$delivery_status = $order->delivery_status;
				$cancel_resion = $order->cancel_resion;

				$first_name = $order->first_name;
				$last_name = $order->last_name;
				$mobile_no = $order->mobile_no;

				$customer_name = $first_name . ' ' . $last_name;

				$this->db->select('COUNT(order_id) AS no_of_product');
				$this->db->from('order_detail');
				$this->db->where('order_id', $oid);
				$query = $this->db->get();
				$result = $query->row();
				$no_of_product = $result->no_of_product;


				$day = substr($order->day, 0, 3);
				$slot_timing = $order->slot_timing;

				$assign_date = $order->assign_date;


				$data[] = array('oid' => $oid, 'order_id' => $order_id, 'customer_name' => $customer_name, 'mobile_no' => $mobile_no, 'status' => $status, 'cancel_resion' => $cancel_resion, 'order_total' => $order_total, 'order_date' => $order_date, 'item' => $no_of_product, 'delivery_status' => $delivery_status, 'deliver_address' => $deliver_address, 'day' => $day, 'slot_timing' => $slot_timing, 'assign_date' => $assign_date);
			}
			echo json_encode(array('status' => '1', 'result' => $data));
		} else {
			$msg = 'No Record Found.';
			$data[] = array('msg' => $msg);
			echo json_encode(array('status' => '0', 'result' => $data));

		}
	}


	/********************************Pending Order history List *******************************************************************
	 *******************************************************************************************************************/

	public function pending_order_list()
	{

		$db_id = $this->input->post('delivery_boy_id');
		$order_list = $this->sales_model->get_pending_product($db_id);
		$i = 1;
		if (!empty($order_list)) {
			foreach ($order_list as $order) {
				$oid = $order->order_id;
				$order_id = '#' . $order->order_generate_id;
				$status = $order->status;
				$order_total = $order->order_total;
				$deliver_address = $order->deliver_address;
				$order_date = date('j, F, Y', strtotime($order->order_date));
				$delivery_status = $order->delivery_status;


				$first_name = $order->first_name;
				$last_name = $order->last_name;
				$mobile_no = $order->mobile_no;

				$otp = $order->otp;

				$customer_name = $first_name . ' ' . $last_name;

				$this->db->select('COUNT(order_id) AS no_of_product');
				$this->db->from('order_detail');
				$this->db->where('order_id', $oid);
				$query = $this->db->get();
				$result = $query->row();
				$no_of_product = $result->no_of_product;

				$day = substr($order->day, 0, 3);
				$slot_timing = $order->slot_timing;

				$assign_date = $order->assign_date;

				$data[] = array('oid' => $oid, 'order_id' => $order_id, 'customer_name' => $customer_name, 'mobile_no' => $mobile_no, 'status' => $status, 'order_total' => $order_total, 'order_date' => $order_date, 'item' => $no_of_product, 'delivery_status' => $delivery_status, 'deliver_address' => $deliver_address, 'day' => $day, 'slot_timing' => $slot_timing, 'otp' => $otp, 'assign_date' => $assign_date);
			}
			echo json_encode(array('status' => '1', 'result' => $data));
		} else {
			$msg = 'No Record Found.';
			$data[] = array('msg' => $msg);
			echo json_encode(array('status' => '0', 'result' => $data));

		}
	}


	/********************************Dispatch Order history List ******************************************************
	 *******************************************************************************************************************/

	public function dispatch_order_list()
	{

		$db_id = $this->input->post('delivery_boy_id');
		$order_list = $this->sales_model->get_dispatch_product($db_id);
		$i = 1;
		if (!empty($order_list)) {
			foreach ($order_list as $order) {
				$oid = $order->order_id;
				$order_id = '#' . $order->order_generate_id;
				$status = $order->status;
				$order_total = $order->order_total;
				$deliver_address = $order->deliver_address;
				$order_date = date('j, F, Y', strtotime($order->order_date));
				$delivery_status = $order->delivery_status;


				$first_name = $order->first_name;
				$last_name = $order->last_name;
				$mobile_no = $order->mobile_no;

				$otp = $order->otp;

				$customer_name = $first_name . ' ' . $last_name;

				$this->db->select('COUNT(order_id) AS no_of_product');
				$this->db->from('order_detail');
				$this->db->where('order_id', $oid);
				$query = $this->db->get();
				$result = $query->row();
				$no_of_product = $result->no_of_product;

				$day = substr($order->day, 0, 3);
				$slot_timing = $order->slot_timing;

				$assign_date = $order->assign_date;

				$data[] = array('oid' => $oid, 'order_id' => $order_id, 'customer_name' => $customer_name, 'mobile_no' => $mobile_no, 'status' => $status, 'order_total' => $order_total, 'order_date' => $order_date, 'item' => $no_of_product, 'delivery_status' => $delivery_status, 'deliver_address' => $deliver_address, 'day' => $day, 'slot_timing' => $slot_timing, 'otp' => $otp, 'assign_date' => $assign_date);
			}
			echo json_encode(array('status' => '1', 'result' => $data));
		} else {
			$msg = 'No Record Found.';
			$data[] = array('msg' => $msg);
			echo json_encode(array('status' => '0', 'result' => $data));

		}
	}

	/******************************** Total Collect Amount *********************************************************
	 *******************************************************************************************************************/

	public function total_collect_amount()
	{

		$db_id = $this->input->post('delivery_boy_id');


		$this->db->select('*');
		$this->db->from('delivery_boy');
		$this->db->where('db_id', $db_id);
		$query1 = $this->db->get();
		$result1 = $query1->row();
		$wallet = $result1->wallet;


		$this->db->select('SUM(debit) AS paid_amount');
		$this->db->from('db_wallet_history');
		$this->db->where('db_id', $db_id);
		$query11 = $this->db->get();
		$result11 = $query11->row();
		$paid_amount = $result11->paid_amount;

		if ($paid_amount == '') {
			$paid_amount = '0';
		} else {
			$paid_amount = $paid_amount;
		}


		$data[] = array('collect_amount' => $wallet, 'paid_amount' => $paid_amount);

		echo json_encode(array('status' => '1', 'result' => $data));

	}


	/******************************** Transaction DB *****************************************************************
	 *******************************************************************************************************************/

	public function delevery_transcation_list()
	{

		$db_id = $this->input->post('delivery_boy_id');
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$wallet_history = $this->customer_model->get_db_wallet_history($db_id, $from_date, $to_date);

		if (!empty($wallet_history)) {
			foreach ($wallet_history as $wallet) {

				$opening_bal = $wallet->opening_bal;
				$closing_bal = $wallet->closing_bal;
				$credit = $wallet->credit;
				$debit = $wallet->debit;
				$c_d_date = $wallet->c_d_date;
				$order_id = '#' . $wallet->order_id;


				if ($credit == NULL) {
					$credit = '';
				} else {
					$credit = $credit;
				}

				if ($debit == NULL) {
					$debit = '';
				} else {
					$debit = $debit;
				}

				$data[] = array('db_id' => $db_id, 'opening_bal' => $opening_bal, 'closing_bal' => $closing_bal, 'credit' => $credit, 'debit' => $debit, 'c_d_date' => $c_d_date, 'order_id' => $order_id);
			}
			echo json_encode(array('status' => '1', 'result' => $data));
		} else {
			$data[] = array();
			echo json_encode(array('status' => '0', 'result' => $data));

		}
	}


	/******************************** Hot Product List **********************************************************************
	 *******************************************************************************************************************/

	public function hot_product_list()
	{

		$hot_product_list = $this->product_model->get_all_hot_product_model();
		$i = 1;
		if (!empty($hot_product_list)) {
			foreach ($hot_product_list as $product) {
				$hp_id = $product->hp_id;
				$sub_category_id = $product->sub_category_id;
				$image1 = $product->image;

				$image1 = 'sterlex_admin/assets/images/hot_product/' . $image1;
				$image = base_url($image1);

				$data[] = array('hp_id' => $hp_id, 'sub_category_id' => $sub_category_id, 'image' => $image);
			}
			echo json_encode(array('status' => '1', 'result' => $data));
		} else {
			$msg = 'No Record Found.';
			$data[] = array('msg' => $msg);
			echo json_encode(array('status' => '0', 'result' => $data));

		}
	}


	/******************************** Notification List ***************************************************************
	 *******************************************************************************************************************/

	public function notification_list()
	{

		$notification_list = $this->product_model->get_all_notification_model();
		$i = 1;
		if (!empty($notification_list)) {
			foreach ($notification_list as $notification) {
				$notification_id = $notification->notification_id;
				$title = $notification->title;
				$description = $notification->description;
				$image1 = $notification->image;
				if ($image1 != '') {
					$image1 = 'sterlex_admin/assets/images/notification/' . $image1;
					$image = base_url($image1);
				} else {
					$image = '';
				}
				$data[] = array('notification_id' => $notification_id, 'title' => $title, 'message' => $description, 'image' => $image);
			}
			echo json_encode(array('status' => '1', 'result' => $data));
		} else {
			$msg = 'No Record Found.';
			$data[] = array('msg' => $msg);
			echo json_encode(array('status' => '0', 'result' => $data));

		}
	}


	/******************************** Today offer List ***************************************************************
	 *******************************************************************************************************************/

	public function today_offer()
	{

		$customer_id = $this->input->post('customer_id');
		$offer_list = $this->product_model->get_all_today_offer_model1();
		$i = 1;
		if (!empty($offer_list)) {
			foreach ($offer_list as $offer) {
				$tf_id = $offer->tf_id;
				$offer_date = $offer->date;
				$start_time = date('h:i:s A', strtotime($offer->start_time));
				$end_time = date('h:i:s A', strtotime($offer->end_time));

				$product_list = $this->product_model->get_todat_offer_wise_product($tf_id);

				// print_r($product_list);die;

				$product_on_offer = array();
				foreach ($product_list as $product) {
					$product_id = $product->product_id;
					$main_image = $product->main_image;
					$product_name = $product->product_name;

					$qty = $product->qty;
					$type = $product->type;


					$main_image = 'sterlex_admin/assets/images/product/' . $main_image;
					$image = base_url($main_image);


					if ($qty == '0') {
						$status = '0';
					} else {
						$status = '1';
					}


					$q = $this->db->select('*');
					$q = $this->db->where('customer_id', $customer_id);
					$q = $this->db->where('product_id', $product_id);
					$q = $this->db->get('add_to_cart');
					$rowcount = $q->num_rows();

					if ($rowcount > 0) {
						$this->db->select('*');
						$this->db->from('add_to_cart');
						$this->db->where('product_id', $product_id);
						$this->db->where('customer_id', $customer_id);
						$query = $this->db->get();
						$result = $query->row();
						$p_qty = $result->qty;


					} else {
						$p_qty = '0';
					}

					$serv = array();
					$CI =& get_instance();
					$CI->load->model('Product_model');
					$result = $CI->product_model->product_details_product_id_wise($product_id);

					foreach ($result as $p_details) {
						$id = $p_details['id'];
						$unit = $p_details['title'];
						$price = $p_details['unit_price'];
						$discount = $p_details['discount'];
						$serv[] = array('price_id' => $id, "unit" => $unit, "price" => $price, "discount" => $discount);
						$i++;
					}

					$product_on_offer[] = array('product_id' => $product_id, 'product_name' => $product_name, 'image' => $image, 'qty' => $p_qty, 'flag' => $status, 'type' => $type, 'price_details' => $serv);

				}

				$data[] = array('tf_id' => $tf_id, 'offer_date' => $offer_date, 'start_time' => $start_time, 'end_time' => $end_time, 'product_list' => $product_on_offer);
			}
			echo json_encode(array('status' => '1', 'result' => $data));
		} else {
			$msg = 'No Record Found.';
			$data[] = array('msg' => $msg);
			echo json_encode(array('status' => '0', 'result' => $data));

		}
	}



	/*public function shoot_sms()
    {
      $sms = $this->customer_model->shoot_sms();


      if(!empty($sms))
        {
           foreach ($sms as $sms)
    		{
    		    $mobile_no            = $sms->mobile_no;

    		    $sender="EXOTIC";
    			$number2 = $mobile_no;
    			$msg2="Exotic Basket has credited Rs 150 to your a/c for 1st Order on All Products! Use wallet balance while checkout. Download app https://tinyurl.com/exoticbasket to avail offer.";

    			$api_key = '55A827A192C7C6';
    			$ch = curl_init();
    			curl_setopt($ch,CURLOPT_URL, "https://www.logonutility.in/app/smsapi/index.php");
    			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    			curl_setopt($ch, CURLOPT_POST, 1);
    		    curl_setopt($ch, CURLOPT_POSTFIELDS, "key=".$api_key."&&campaign=1&routeid=20&type=text&contacts=".$number2."&senderid=".$sender."&msg=".$msg2);
    		    $response = curl_exec($ch);

    			curl_close($ch);

                $data[]=array("mobile_no"=>$mobile_no);
    		}


            }
            else
            {
                     $data[]=array("mobile_no"=>'');
            }
		 echo json_encode(array("result"=>$data));
    }*/


	/******************************** Trest **********************************************************************
	 *********************************************************************************************************************/

	public function test()
	{

		$franchise_id = $this->input->post('franchise_id');
		$category_list = $this->product_model->get_product_data($franchise_id);

		$i = 1;
		if (!empty($category_list)) {
			foreach ($category_list as $category) {
				$otp = rand('000000', '999999');
				$product_id = $category->product_id;

				$insertArray1 = array
				(
					'product_code' => $otp,

				);
				$this->db->where('product_id', $product_id);
				$this->db->update('vegshopy_product', $insertArray1);


			}
			echo json_encode(array('status' => '1'));
		} else {
			$msg = 'No Record Found.';
			$data[] = array('msg' => $msg);
			echo json_encode(array('status' => '0', 'result' => $data));

		}
	}


	public function getSectionStruct()
	{
		$order_by = 'position asc';
		$data = $this->GlobalModal->getDataArray('section_positions', array('*'), array(), 1);
//    	echo $this->db->last_query();
		$customer_id=$this->input->get_post('customer_id');
		$franchise_id = $this->input->post('franchise_id');
		if ($data != false) {
			$new_res = array();
			$new_res2 = array();

			foreach ($data as $scection_data) {
				$new_res = array();
				if ($scection_data['section_name'] == 'categories') {
					$category_array = $this->category_list(1);
					$new_res['category'] = $category_array;
					$new_res['section_name'] = $scection_data['section_name'];
					$new_res['status'] = $scection_data['status'];
					$new_res['position'] = $scection_data['position'];
					$new_res['section_text'] = $scection_data['section_text'];
					$new_res['view'] = $scection_data['view'];
					$new_res['section_icon'] = base_url('sterlex_admin/assets/images/section/') . $scection_data['section_background'];
					$new_res['section_background'] = base_url('sterlex_admin/assets/images/section/') . $scection_data['section_icons'];
					array_push($new_res2, $new_res);
				}
				if ($scection_data['section_name'] == 'banner') {
					$banner_array = $this->banner_list(1);
					$new_res['banner'] = $banner_array;
					$new_res['section_name'] = $scection_data['section_name'];
					$new_res['status'] = $scection_data['status'];
					$new_res['position'] = $scection_data['position'];
					$new_res['section_text'] = $scection_data['section_text'];
					$new_res['view'] = $scection_data['view'];
					$new_res['section_icon'] = base_url('sterlex_admin/assets/images/section/') . $scection_data['section_background'];
					$new_res['section_background'] = base_url('sterlex_admin/assets/images/section/') . $scection_data['section_icons'];
					array_push($new_res2, $new_res);
				}
				if ($scection_data['section_name'] == 'products') {
					$product_array = $this->most_popular_product_list(1, $customer_id, $franchise_id);
					$new_res['product'] = $product_array;
					$new_res['section_name'] = $scection_data['section_name'];
					$new_res['status'] = $scection_data['status'];
					$new_res['position'] = $scection_data['position'];
					$new_res['section_text'] = $scection_data['section_text'];
					$new_res['section_icon'] = base_url('sterlex_admin/assets/images/section/') . $scection_data['section_background'];
					$new_res['section_background'] = base_url('sterlex_admin/assets/images/section/') . $scection_data['section_icons'];
					$new_res['view'] = $scection_data['view'];
					array_push($new_res2, $new_res);
				}
				if ($scection_data['section_name'] == 'offers') {

					$new_res['section_name'] = $scection_data['section_name'];
					$new_res['status'] = $scection_data['status'];
					$new_res['position'] = $scection_data['position'];
					$new_res['section_text'] = $scection_data['section_text'];
					$new_res['view'] = $scection_data['view'];
					$new_res['images'] = $this->mostPopularProducts($scection_data);
					$new_res['section_icon'] = base_url('sterlex_admin/assets/images/section/') . $scection_data['section_background'];
					$new_res['section_background'] = base_url('sterlex_admin/assets/images/section/') . $scection_data['section_icons'];
					$new_res3['offer_object']['position'] = $scection_data['position'];
					$new_res3['offer_object']['section_text'] = $scection_data['section_text'];
					$new_res3['offer_object']['status'] = $scection_data['status'];
					$new_res3['offer_object']['result'][] = $new_res;
//					array_push($new_res2,$new_res3);
				}

			}
			array_push($new_res2, $new_res3);
			$response['staus'] = 1;
			$response['message'] = 'Data Found';
			$response['result'] = $new_res2;

		} else {
			$response['staus'] = 0;
			$response['message'] = 'no data found';
			$response['result'] = new StdClass();
		}
		echo json_encode($response);

	}

	public function mostPopularProducts($scection_data)
	{
		$imagesArray = explode('|', $scection_data['images']);
		$n_array = array();
		foreach ($imagesArray as $images) {
			array_push($n_array, array('image' => base_url('sterlex_admin/assets/images/banner/') . $images));
		}
		return array('images_data' => $n_array);
	}

	public function getCartItem()
	{
		if (!empty($this->input->get_post('customer_id'))) {
			$cust_id = $this->input->get_post('customer_id');

			$data = $this->GlobalModal->executeQuery("select sum(qty)as total_qty,sum((price*qty)-discount) as total_price from add_to_cart where customer_id='$cust_id'");
			if ($data != false) {
				$response['status'] = 1;
				$response['result'] = $data;
			} else {
				$response['status'] = 0;
				$response['result'] = new StdClass();
			}
		} else {
			$response['status'] = 0;
			$response['result'] = new StdClass();
		}
		echo json_encode($response);
	}

	public function getCats()
	{
		if (empty($this->input->get_post('category_id'))) {
			$data = $this->GlobalModal->getDataArray('category', array('*'), array());
			if ($data != false) {
				$response['status'] = 200;
				$response['body'] = $data;
			} else {
				$response['status'] = 201;
				$response['body'] = 'No Data Found';
			}
		} else {
			if (!empty($this->input->get_post('category_id'))) {
				$cat_id = $this->input->get_post('category_id');
				$data = $this->GlobalModal->getDataArray('category', array('*'), array('category_id' => $cat_id, 'isActive' => 0, 'web_category' => 0));
				if ($data != false) {
					$response['status'] = 200;
					$response['body'] = $data;
				} else {
					$response['status'] = 201;
					$response['body'] = 'No Data Found';
				}
			} else {
				$response['status'] = 202;
				$response['body'] = 'Request Parameter Missing';
			}
		}
		echo json_encode($response);
	}


	public function getMostPop()
	{
		$data = $this->product_model->getMostPopularProducts();
		if ($data != false) {
			$response['status'] = 200;
			$response['body'] = $data;
		} else {
			$response['status'] = 201;
			$response['body'] = 'No Data Found';
		}
		echo json_encode($response);
	}

	public function getSlotTimes()
	{
		$data = $this->GlobalModal->getDataArray('slot_timing', array('*'), array('isActive' => 0));


		if ($data != false) {
			$slot_days=array();
			foreach ($data as $slotData){
//				var_dump($slotData);
				array_push($slot_days,$slotData['day']);
			}
			$unic_slot_days=array_unique($slot_days);

			$final_slot_array_new=array();
			foreach ($unic_slot_days as $unic_data){
				$final_slot_array=array();
//				var_dump($slotData);
				foreach ($data as $slotData){
					if($unic_data==$slotData['day']){
						$final_slot_array[$unic_data][]=array('slot_time'=>$slotData['slot_timing'],'slot_id'=>$slotData['slot_id']);
					}
//				var_dump($slotData);
				}
				array_push($final_slot_array_new,$final_slot_array);
			}

			$response['status'] = 200;
			$response['body'] = $final_slot_array_new;
		} else {
			$response['status'] = 201;
			$response['body'] = 'No Data Found';
		}
		echo json_encode($response);;
	}

	public function deleteCartItemm(){
		if(!empty($this->input->get_post('customer_id')) && !empty($this->input->get_post('product_id'))){
			$customer_id = $this->input->post('customer_id');
			$product_id = $this->input->post('product_id');
			;
			if($this->GlobalModal->deleteData('add_to_cart',array('customer_id' => $customer_id, 'product_id' => $product_id))){
				$response['status'] = 1;
				$response['body'] = 'Cart Item Removed';
			}else{
				$response['status'] = 0;
				$response['body'] = 'Error to removed item from cart';
			}

		}else{
			$response['status'] = 0;
			$response['body'] = 'Request Paramter Missing';
		}
		echo json_encode($response);
	}

////////////////////////////////////////////////////////////////////////////////////////////
}

?>
