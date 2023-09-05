<?php
class OrderController extends  CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('GlobalModal');
	}

	public function custOrderDetails(){
		if($this->input->get_post('customer_id')){
			$cust_id=$this->input->get_post('customer_id');
			$main_join_array=array();
			$join_array_0['join_0_table_1']=['table_name'=>'product_order','table_column'=>'order_id','join_type'=>'inner'];
			$join_array_0['join_0_table_2']=['table_name'=>'order_detail','table_column'=>'order_id'];
			$join_array_1['join_1_table_2']=['table_name'=>'coupon','table_column'=>'coupon_id'];
			$join_array_1['join_1_table_1']=['table_name'=>'product_order','table_column'=>'coupon_id','join_type'=>'left'];
			array_push($main_join_array,$join_array_0);
			array_push($main_join_array,$join_array_1);
			$data=$this->GlobalModal->getDataArrayJoin('product_order',array('product_order.*','order_detail.*','coupon.*'),array('product_order.customer_id'=>$cust_id),$main_join_array);
			if($data!=false){
				$response['status']=200;
				$response['body']=$data;
			}else{
				$response['status']=201;
				$response['body']='No Data Found';
			}
		}else{
			$response['body']='Request Parameter Missing';
			$response['status']=201;
		}
		echo json_encode($response);
	}

	public function checkout(){

	}

}
?>

