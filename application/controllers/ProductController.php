<?php
class ProductController extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ProductModel');
		$this->load->model('GlobalModal');
	}

	public function index(){
		$data["load_view"] = array("product/HomeView.php");
		$this->load->view('welcome_message.php',$data);
	}

	public function getProducts(){
		if(empty($this->input->get_post('product_id'))){
			$data=$this->GlobalModal->executeQuery("SELECT v.*,p.* FROM `vegshopy_product` v  INNER JOIN `product_details` p on (p.product_id=v.product_id)");
			if($data!=false){
				$response['status']=200;
				$response['body']=$data;
			}else{
				$response['status']=201;
				$response['body']='No Data Found';
			}
		}else{
			if(!empty($this->input->get_post('product_id'))){
				$product_id=$this->input->get_post('product_id');
				$data=$this->GlobalModal->executeQuery("SELECT v.*,p.* FROM `vegshopy_product` v  INNER JOIN `product_details` p on (p.product_id=v.product_id) where v.product_id='$product_id'");
				if($data!=false){
					$response['status']=200;
					$response['body']=$data;
				}else{
					$response['status']=201;
					$response['body']='No Data Found';
				}
			}else {
				$response['status'] = 202;
				$response['body'] = 'Request Parameter Missing';
			}
		}
		echo json_encode($response);
	}

	public function getProductsByCat(){
			if(!empty($this->input->get_post('category_id'))) {
				$category_id = $this->input->get_post('category_id');
				$data = $this->GlobalModal->executeQuery("SELECT v.*,p.* FROM `vegshopy_product` v  INNER JOIN `product_details` p on (p.product_id=v.product_id) where v.category_id='$category_id'");
				if ($data != false) {
					$response['status'] = 200;
					$response['body'] = $data;
				} else {
					$response['status'] = 201;
					$response['body'] = 'No Data Found';
				}
			}else{
				$response['status'] = 202;
				$response['body'] = 'Request Parameter Missing';
			}
		echo json_encode($response);
}

	public function getCats(){
		if(empty($this->input->get_post('category_id'))){
			$data=$this->GlobalModal->getDataArray('category',array('*'),array());
			if($data!=false){
				$response['status']=200;
				$response['body']=$data;
			}else{
				$response['status']=201;
				$response['body']='No Data Found';
			}
		}else{
			if(!empty($this->input->get_post('category_id'))){
				$cat_id=$this->input->get_post('category_id');
				$data=$this->GlobalModal->getDataArray('category',array('*'),array('category_id'=>$cat_id,'isActive'=>0,'web_category'=>0));
				if($data!=false){
					$response['status']=200;
					$response['body']=$data;
				}else{
					$response['status']=201;
					$response['body']='No Data Found';
				}
			}else {
				$response['status'] = 202;
				$response['body'] = 'Request Parameter Missing';
			}
		}
		echo json_encode($response);
	}

	public function getSubCats(){
		if(empty($this->input->get_post('sub_category_id'))){
			$data=$this->GlobalModal->getDataArray('sub_category',array('*'),array());
			if($data!=false){
				$response['status']=200;
				$response['body']=$data;
			}else{
				$response['status']=201;
				$response['body']='No Data Found';
			}
		}else{
			if(!empty($this->input->get_post('sub_category_id'))){
				$cat_id=$this->input->get_post('sub_category_id');
				$data=$this->GlobalModal->getDataArray('sub_category',array('*'),array('sub_category_id'=>$cat_id));
				if($data!=false){
					$response['status']=200;
					$response['body']=$data;
				}else{
					$response['status']=201;
					$response['body']='No Data Found';
				}
			}else {
				$response['status'] = 202;
				$response['body'] = 'Request Parameter Missing';
			}
		}
		echo json_encode($response);
	}

	public function getSubSubCats(){
		if(empty($this->input->get_post('sub_subcategory_id'))){
			$data=$this->GlobalModal->getDataArray('sub_subcategory',array('*'),array());
			if($data!=false){
				$response['status']=200;
				$response['body']=$data;
			}else{
				$response['status']=201;
				$response['body']='No Data Found';
			}
		}else{
			if(!empty($this->input->get_post('sub_subcategory_id'))){
				$cat_id=$this->input->get_post('sub_subcategory_id');
				$data=$this->GlobalModal->getDataArray('sub_subcategory',array('*'),array('sub_category_id'=>$cat_id));
				if($data!=false){
					$response['status']=200;
					$response['body']=$data;
				}else{
					$response['status']=201;
					$response['body']='No Data Found';
				}
			}else {
				$response['status'] = 202;
				$response['body'] = 'Request Parameter Missing';
			}
		}
		echo json_encode($response);
	}

	public function getCouponList(){
		if(!empty($this->input->get_post('cust_id'))) {
			$category_id = $this->input->get_post('cust_id');
			$data = $this->GlobalModal->executeQuery("SELECT v.*,p.* FROM `vegshopy_product` v  INNER JOIN `product_details` p on (p.product_id=v.product_id) where v.category_id='$category_id'");
			if ($data != false) {
				$response['status'] = 200;
				$response['body'] = $data;
			} else {
				$response['status'] = 201;
				$response['body'] = 'No Data Found';
			}
		}else{
			$response['status'] = 202;
			$response['body'] = 'Request Parameter Missing';
		}
		echo json_encode($response);

	}

	public function getUsedCoupons(){

	}

	public function getMostPop(){
		$data=$this->ProductModel->getMostPopularProducts();
		if($data!=false){
			$response['status']=200;
			$response['body']=$data;
		}else{
			$response['status']=201;
			$response['body']='No Data Found';
		}
		echo json_encode($response);;
	}
}

?>
