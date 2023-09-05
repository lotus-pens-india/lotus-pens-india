<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends CI_Controller {


    function __construct()
    {
        parent::__construct();
        $this->load->model('sales_model');
        $this->load->model('customer_model');
        $this->load->model('product_model');
        $this->load->model('purchse_model');

    }


    
        
/****************************** Sales REPORT *************************************************
***************************************************************************************************/

    public function sales_report()
	{
         if(!$this->session->userdata('isLoggedIn'))
		 {
			   redirect('login');
		 }
		 
		 else
		 {
             
         $submit = $this->input->post('submit');
         $date_from    =   date("d-m-Y", strtotime($this->input->post('date_from')));
         $date_to =   date("d-m-Y", strtotime($this->input->post('date_to')));
         
         if(!empty($submit))
         {

            if(!empty($date_from))
            {
                if(!empty($date_to))
                {
                    $page_data['sales_report'] = $this->sales_model->sales_report($date_from,$date_to); 
                    $page_data['count_sales_report'] = $this->sales_model->count_sales_report($date_from,$date_to); 
                    $page_data['cancel_sales_report'] = $this->sales_model->cancel_sales_report($date_from,$date_to); 
                    $page_data['deliver_sales_report'] = $this->sales_model->deliver_sales_report($date_from,$date_to);

                }
            }
                
         }
            $page_data['submit'] = $submit;
            $page_data['date_from'] = $date_from;
            $page_data['date_to'] =  $date_to;
            $page_data['sales_report'] = $this->sales_model->sales_report($date_from,$date_to);
            $page_data['count_sales_report'] = $this->sales_model->count_sales_report($date_from,$date_to);
            $page_data['cancel_sales_report'] = $this->sales_model->cancel_sales_report($date_from,$date_to); 
            $page_data['deliver_sales_report'] = $this->sales_model->deliver_sales_report($date_from,$date_to);
            $this->load->view('common/header');
    		$this->load->view('report/sales_report',$page_data);
    		$this->load->view('common/footer');
         	
        }
         
		
    }
    
    
    /****************************** Sales REPORT *************************************************
***************************************************************************************************/

    public function product_wise_report()
	{
         if(!$this->session->userdata('isLoggedIn'))
		 {
			   redirect('login');
		 }
		 
		 else
		 {
             
         $submit = $this->input->post('submit');
         $date_from    =   date("d-m-Y", strtotime($this->input->post('date_from')));
         $date_to =   date("d-m-Y", strtotime($this->input->post('date_to')));
         if(!empty($submit))
         {

            if(!empty($date_from))
            {
                if(!empty($date_to))
                {
                    $page_data['product_wise_report'] = $this->sales_model->product_wise_report($date_from,$date_to); 
                   

                }
            }
                
         }
            $page_data['submit'] = $submit;
            $page_data['date_from'] = $date_from;
            $page_data['date_to'] =  $date_to;
            $page_data['product_wise_report'] = $this->sales_model->product_wise_report($date_from,$date_to);

            $this->load->view('common/header');
    		$this->load->view('report/product_wise_report',$page_data);
    		$this->load->view('common/footer');
         	
        }
         
		
    }
    
    
    
    /****************************** Sales REPORT *************************************************
***************************************************************************************************/

    public function saller_wise_sales_report()
	{
         if(!$this->session->userdata('isLoggedIn'))
		 {
			   redirect('login');
		 }
		 
		 else
		 {
             
         $submit = $this->input->post('submit');
         $date_from = $this->input->post('date_from');
         $date_to = $this->input->post('date_to');
         $saller_id = $this->input->post('saller_id');
         if(!empty($submit))
         {

            if(!empty($date_from))
            {
                if(!empty($date_to))
                {
                    if(!empty($saller_id))
                    {
                       $page_data['all_saller'] = $this->customer_model->get_all_saller_model();
                       $page_data['count_sales_report'] = $this->sales_model->count_saller_wise_report($date_from,$date_to,$saller_id);
                       $page_data['sales_report'] = $this->sales_model->saller_wise_sales_report($date_from,$date_to,$saller_id);
                       $page_data['sum_sales_report'] = $this->sales_model->sum_saller_wise_report($date_from,$date_to,$saller_id);
                    }   
                }
            }
                
         }
            $page_data['submit'] = $submit;
            $page_data['date_from'] = $date_from;
            $page_data['date_to'] =  $date_to;
            $page_data['saller_id'] = $saller_id;
            $page_data['count_sales_report'] = $this->sales_model->count_saller_wise_report($date_from,$date_to,$saller_id);
            $page_data['sum_sales_report'] = $this->sales_model->sum_saller_wise_report($date_from,$date_to,$saller_id);
            $page_data['all_saller'] = $this->customer_model->get_all_saller_model();
            $page_data['sales_report'] = $this->sales_model->saller_wise_sales_report($date_from,$date_to,$saller_id);
            $this->load->view('common/header');
    		$this->load->view('report/saller_wise_sales_report',$page_data);
    		$this->load->view('common/footer');
         	
        }
         
		
    }
    
    
    
        /****************************** Saller commission REPORT *************************************************
***************************************************************************************************/

    public function saller_commisssion_report()
	{
         if(!$this->session->userdata('isLoggedIn'))
		 {
			   redirect('login');
		 }
		 
		 else
		 {
             
         $submit = $this->input->post('submit');
         $date_from = $this->input->post('date_from');
         $date_to = $this->input->post('date_to');
         $saller_id = $this->input->post('saller_id');
         if(!empty($submit))
         {

            if(!empty($date_from))
            {
                if(!empty($date_to))
                {
                    if(!empty($saller_id))
                    {
                       $page_data['count_sales_report'] = $this->sales_model->count_saller_wise_report($date_from,$date_to,$saller_id);
                       $page_data['sum_sales_report'] = $this->sales_model->sum_saller_wise_report($date_from,$date_to,$saller_id);    
                       $page_data['all_saller'] = $this->customer_model->get_all_saller_model();
                       $page_data['sales_report'] = $this->sales_model->saller_wise_sales_report($date_from,$date_to,$saller_id);
                    }   
                }
            }
                
         }
            $page_data['submit'] = $submit;
            $page_data['date_from'] = $date_from;
            $page_data['date_to'] =  $date_to;
            $page_data['saller_id'] = $saller_id;
            $page_data['count_sales_report'] = $this->sales_model->count_saller_wise_report($date_from,$date_to,$saller_id);
            $page_data['sum_sales_report'] = $this->sales_model->sum_saller_wise_report($date_from,$date_to,$saller_id);
            $page_data['all_saller'] = $this->customer_model->get_all_saller_model();
            $page_data['sales_report'] = $this->sales_model->saller_wise_sales_report($date_from,$date_to,$saller_id);
            $this->load->view('common/header');
    		$this->load->view('report/saller_commisssion_report',$page_data);
    		$this->load->view('common/footer');
         	
        }
         
		
    }
    
    
    
    public function pincode_wise_report()
	{
		 if(!$this->session->userdata('isLoggedIn'))
		 {
			   redirect('login');
		 }
		 else	
		 {
		    $pincode  = $this->input->get('pincode');
		    $page_data['pin_area'] = $this->input->get('pincode');
            $page_data['total_customer'] = $this->product_model->count_pincode_wise_customer($pincode);
            $page_data['total_order'] = $this->sales_model->count_pincode_wise_order($pincode);
            $page_data['pending_order'] = $this->sales_model->count_pincode_wise_pending_order($pincode);
            $page_data['assign_order'] = $this->sales_model->count_pincode_wise_assign_order($pincode);
            $page_data['deliver_order'] = $this->sales_model->count_pincode_wise_deliver_order($pincode);
            $page_data['not_deliver_order'] = $this->sales_model->count_pincode_wise_not_deliver_order($pincode);
            $page_data['cancel_order'] = $this->sales_model->count_pincode_wise_cancel_order($pincode);
            $page_data['total_amount'] = $this->sales_model->count_pincode_wise_total_amount($pincode);
            $page_data['cash_amount'] = $this->sales_model->count_pincode_wise_total_cash_amount($pincode);
            $page_data['online_amount'] = $this->sales_model->count_pincode_wise_total_online_amount($pincode);
            $page_data['refund_amount'] = $this->sales_model->count_pincode_wise_total_refund_amount($pincode);
			$this->load->view('common/header');
			$this->load->view('report/pincode_wise_report',$page_data);
			$this->load->view('common/footer');
		 }
     }
     
     
     
     
     /****************************** Purchse REPORT *************************************************
***************************************************************************************************/

    public function purchse_report()
	{
         if(!$this->session->userdata('isLoggedIn'))
		 {
			   redirect('login');
		 }
		 
		 else
		 {
             
         $submit = $this->input->post('submit');
         $date_from = $this->input->post('date_from');
         $date_to = $this->input->post('date_to');
         
         if(!empty($submit))
         {

            if(!empty($date_from))
            {
                if(!empty($date_to))
                {
                    $page_data['purchase_report'] = $this->purchse_model->purchse_report($date_from,$date_to); 

                }
            }
                
         }
            $page_data['submit'] = $submit;
            $page_data['date_from'] = $date_from;
            $page_data['date_to'] =  $date_to;
            $page_data['purchase_report'] = $this->purchse_model->purchse_report($date_from,$date_to);
            $this->load->view('common/header');
    		$this->load->view('report/purchse_report',$page_data);
    		$this->load->view('common/footer');
         	
        }
         
		
    }
    
    
    
    
    public function purchse_report1()
	{
         if(!$this->session->userdata('isLoggedIn'))
		 {
			   redirect('login');
		 }
		 
		 else
		 {
             
         $submit = $this->input->post('submit');
         $date_from = $this->input->post('date_from');
         $date_to = $this->input->post('date_to');
         
         if(!empty($submit))
         {

            if(!empty($date_from))
            {
                if(!empty($date_to))
                {
                    $page_data['purchase_report'] = $this->purchse_model->purchse_report1($date_from,$date_to); 

                }
            }
                
         }
            $page_data['submit'] = $submit;
            $page_data['date_from'] = $date_from;
            $page_data['date_to'] =  $date_to;
            $page_data['purchase_report'] = $this->purchse_model->purchse_report1($date_from,$date_to);
            $this->load->view('common/header');
    		$this->load->view('report/purchse_report1',$page_data);
    		$this->load->view('common/footer');
         	
        }
         
		
    }
    
    

///////////////////////////////////////////////////////////////////    

}