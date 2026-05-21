<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {


    function __construct()
    {
        parent::__construct();
		
		$this->load->model('sales_model');
		$this->load->model('customer_model');
    }

    public function index()
	{
		 if(!$this->session->userdata('isLoggedIn'))
		 {
			   redirect('login');
		 }
		 else	
		 {
		    $data['total_count'] = $this->sales_model->get_total_count_model(); 
		    $data['today_count'] = $this->sales_model->get_today_count_model();
            $data['pending_count'] = $this->sales_model->get_pending_count_model();
            $data['assign_count'] = [0];
            $data['delivered_count'] = $this->sales_model->get_delivered_count_model();
            $data['dispatch_count'] = $this->sales_model->get_dispatch_count_model();
            $data['not_delivered_count'] = 0;
            $data['cancel_count'] = $this->sales_model->get_cancel_count_model();
            $data['cancel_count1'] = $this->sales_model->get_cancel_count_model1();
            $data['customer_count'] = $this->customer_model->get_customer_count_model();
            $data['customer_monthly_count'] = $this->customer_model->get_monthly_customer_count_model();
            $data['customer_today_count'] = $this->customer_model->get_today_customer_count_model();

            
            $data['total_payment'] = $this->sales_model->get_sum_total_model();
            $data['cash_payment'] = $this->sales_model->get_sum_cash_model();
            $data['online_payment'] = $this->sales_model->get_sum_online_model();
            $data['cancel_bill'] = $this->sales_model->get_today_cancel_bill_model();
            
            
            $data['order_list'] = $this->sales_model->get_recent_order_model();
			$this->load->view('common/header');
			$this->load->view('dashboard/dashboard_view',$data);
			$this->load->view('common/footer');
		 }
     }
////////////////////////////////////////////////////////////////////////////////////


}