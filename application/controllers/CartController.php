<?php
class CartController extends  CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('GlobalModal');
	}

	public function addToCart(){
		if(!empty($this->input->post('customer_id')) && !empty($this->input->post('product_id')) && !empty($this->input->post('title'))  && !empty($this->input->post('unit_price')) && !empty($this->input->post('qty'))){
		$customer_id = $this->input->post('customer_id');
		$product_id = $this->input->post('product_id');
		$unit = $this->input->post('unit');
		$title = $this->input->post('title');
		$unit_price = $this->input->post('unit_price');
		$discount = $this->input->post('discount');
		$qty = $this->input->post('qty');
		$dataArray=array('customer_id'=>$customer_id,'product_id'=>$product_id,
			'unit'=>$unit,'price'=>$unit_price,'discount'=>$discount,'qty'=>$qty,
			'flag'=>0
			);
		if($this->GlobalModal->addData('add_to_cart',$dataArray)){
			$response['status']=200;
			$response['body']='Item Add To Cart';
		}else{
			$response['status']=202;
			$response['body']='Failed To Add  Cart';
		}
		}else{
			$response['status']=201;
			$response['body']='Request Parameter Missing';
		}
		echo json_encode($response);
	}
}
?>
