<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Controller {


    function __construct()
    {
        parent::__construct();
        $this->load->model('customer_model');
        $this->load->model('product_model');
		$this->load->library('upload');

		
    }

    public function index()
	{
		 if(!$this->session->userdata('isLoggedIn'))
		 {
			   redirect('login');
		 }
		 else	
		 {

			$this->load->view('common/header');
			$this->load->view('customer_list');
			$this->load->view('common/footer');
		 }
     }
     
     
     
     //////////////////////////////////AJAX CUSTOMER LIST //////////////////////////
	
	public function ajax_customer_list ()
	{
	    $login_type   = $this->session->userdata('type');

        	   $columns = array
        	   ( 
                    0 =>'customer_id', 
                    1 =>'first_name',
                    2 =>'mobile_no',
                    3 =>'city',
                    4 =>'pincode',
                    5=>'date',
                    6 =>'flag',
                    7 =>'action',
                    
                );
    
    		$limit = $this->input->post('length');
            $start = $this->input->post('start');
            $order = $columns[$this->input->post('order')[0]['column']];
            $dir = $this->input->post('order')[0]['dir'];
      
            $totalData = $this->customer_model->customer_count();
                
            $totalFiltered = $totalData; 
                
            if(empty($this->input->post('search')['value']))
            {            
                $posts = $this->customer_model->customer_list($limit,$start,$order,$dir);
            }
            else
            {
                $search = $this->input->post('search')['value']; 
    
                $posts =  $this->customer_model->customer_search($limit,$start,$search,$order,$dir);
    
                $totalFiltered = $this->customer_model->customer_search_count($search);
            }
    
            $data = array();
            if(!empty($posts))
            {
                $i=1; 
                foreach ($posts as $post)
                {
                
                    $nestedData['customer_id'] = '<input type="checkbox" class="sub_chk" data-id="'.$post->customer_id.'">';
                    $nestedData['wallet'] = $post->wallet;
                    $nestedData['mobile_no'] = $post->mobile_no;
                    $nestedData['referral_code'] = $post->referral_code;
                    $nestedData['dor'] = $post->rdate;
                    
                    $nestedData['first_name'] = $post->first_name.' '.$post->last_name;
                    
                    
                    
                     if($post->flag == '0')
                    {
                        $nestedData['flag'] = '<span class="badge badge-success shadow-success m-1">Active</span>';
                        
                    }elseif($post->flag == '1')
                    {
                      $nestedData['flag'] = '<span class="badge badge-danger shadow-danger m-1">Deactive</span>';
                      
                    }
                    if($post->pincode !='')
                    {
                        $nestedData['pincode'] = $post->pincode;
                        
                    }
                    else
                    {
                       $nestedData['pincode'] = '';
                    }
                    
                    if($post->city_id !='')
                    {
                        $this->db->select('*');
                		$this->db->from('city_master');
                		$this->db->where('city_id', $post->city_id );
                	    $query1  = $this->db->get();
                        $result1 = $query1->row();
                        $city = $result1->city_name;
                    }
                    else
                    {
                       $city = ''; 
                    }
                    
                    $nestedData['city'] = $city;
                    

            	    
            	    $CI =& get_instance();
                    $CI->load->model('Customer_model');
                    $result22 = $CI->customer_model->customer_last_order($post->customer_id);
                    if(!empty($result22))
                    {
                       $nestedData['date'] = $result22->order_date ; 
                    }
                    else
                    {
                        $nestedData['date'] ='';
                    }
                    
                    $nestedData['action']='';
                    
                    if($login_type == '0')
	                {
	                    
	                    $this->db->select('*');
                		$this->db->from('franchise');
                		$this->db->where('franchise_id', $post->franchise_id );
                	    $query1  = $this->db->get();
                        $result1 = $query1->row();
                        $franchise_name = $result1->franchise_name;     
                      $nestedData['action'] =$franchise_name;
	                }
	                else
	                {
	                    $nestedData['action'] = '<a style="cursor:pointer;"  class="tip-top dropdown-item delete one_' . $post->customer_id . '" data-original-title="Delete" id="' . "'" . $post->customer_id . "'" . '"
						                           Onclick="return ConfirmDelete(' . "'" . $post->customer_id . "'" . ')">
						                        <button type="button" class="btn btn-danger waves-effect waves-light m-1"> <i class="fa fa-trash-o"></i> </button>
						                      </a> ';
	                }

                    $data[] = $nestedData;
    
                $i++; }
            }
              
            $json_data = array
            (
                "draw"            => intval($this->input->post('draw')),  
                "recordsTotal"    => intval($totalData),  
                "recordsFiltered" => intval($totalFiltered), 
                "data"            => $data   
            );
                
            echo json_encode($json_data); 
	    
	}
	
	    public function delete_customer()
    {
    	$delete_id = $this->input->post('delete_id');
		
		
        $this->db->where('customer_id', $delete_id);
        $this->db->delete('customer');
		

        echo $delete_id;
    }
	

     
	public function delivery_boy()
	{
		 if(!$this->session->userdata('isLoggedIn'))
		 {
			   redirect('login');
		 }
		 else	
		 {
            $data['all_delivery_boy'] = $this->customer_model->get_all_db_model();
            $data['all_pincode'] = $this->product_model->get_all_pincode_model();
			$this->load->view('common/header');
			$this->load->view('delivery_boy',$data);
			$this->load->view('common/footer');
		 }
     }
     
     
    public function upload_db_doc() 
    {


        
            $config = array();
            $config['upload_path'] = "assets/images/deliverboy/";
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['overwrite'] = TRUE;
            return $config;

    }
    
    public function add_delivery_boy_data()
	{
	     $login_type   = $this->session->userdata('type');

        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('name', 'name', 'required');
		$this->form_validation->set_rules('mobile_no', 'mobile no', 'required');
		$this->form_validation->set_rules('address', 'address', 'required');
		$this->form_validation->set_rules('password', 'password', 'required');
        $this->form_validation->set_message('required', '* Please add %s');
        
		$name  = $this->input->post('name');
		$mobile_no    = $this->input->post('mobile_no');
		$address   = $this->input->post('address');
		$password   = $this->input->post('password');

		$pincode  = $this->input->post('pincode');
		
        if($this->form_validation->run() == TRUE)
		{
            $data_db = array
			(
                'name'      => $name,
				'mobile_no'        => $mobile_no,
				'address'          => $address,
				'password'         => md5($password),
				'franchise_id'        => $login_type,
            );
			
            $this->db->insert('delivery_boy', $data_db);
            $insert_id = $this->db->insert_id();
            
            $cnt = count($pincode);
                for($i=0; $i<$cnt; $i++)
                {
                	$data2 = array
                   (
                		'db_id'              => $insert_id,
                		'pincode'             => $_POST['pincode'][$i],
                		'franchise_id'        => $login_type,
                	);
                
                	$this->db->insert('db_wise_area', $data2);
                
                }
            
           
            
             $files = $_FILES;
		
		     ///////// aadhaar card ////////////////
		
            if (!empty($_FILES['aadhaar_card']['name']))
            {
    
                $_FILES['aadhaar_card']['name'] = $files['aadhaar_card']['name'];
                $_FILES['aadhaar_card']['type'] = $files['aadhaar_card']['type'];
                $_FILES['aadhaar_card']['tmp_name'] = $files['aadhaar_card']['tmp_name'];
                $_FILES['aadhaar_card']['error'] = $files['aadhaar_card']['error'];
                $_FILES['aadhaar_card']['size'] = $files['aadhaar_card']['size'];
                
                $this->load->library('upload', $this->upload_db_doc());
                    
                $this->upload->initialize($this->upload_db_doc());
        
                if (!$this->upload->do_upload('aadhaar_card')) 
                {
      
                     $this->upload->display_errors();
                     $upload_error[] = array('error' => $this->upload->display_errors());
                } 
                else 
                {
                    $upload_data = $this->upload->data();
                    $name_array = $upload_data['file_name'];
                    
                    $insertArray1 = array
                    (
                        'aadhaar_card'      => $upload_data['file_name'],
                       
                    );
                    $this->db->where('db_id', $insert_id);
                    $this->db->update('delivery_boy', $insertArray1);
    
                }
                
             
            }

		    $sender="EXOTIC";
			$number2 = $mobile_no;
			$msg2="Dear $name, your registration successfully done. Your username is $mobile_no and password is $password.https://play.google.com/store/apps/details?id=com.exoticbasket.in.711basketdelivery Thanks Regards Exotic Basket Team";
			
			$api_key = '55A827A192C7C6';
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL, "https://www.logonutility.in/app/smsapi/index.php");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
		    curl_setopt($ch, CURLOPT_POSTFIELDS, "key=".$api_key."&&campaign=1&routeid=20&type=text&contacts=".$number2."&senderid=".$sender."&msg=".$msg2);
		    $response = curl_exec($ch);
	    	
			curl_close($ch);
			    
			
			$status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Delivery boy!</strong> add successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';
		
            $this->session->set_flashdata('message',$message);
             $redirect = base_url('customer/delivery_boy');
        }
		else
		{
             $status = 'error';
             if(form_error('name')){
                $errors['nameError'] = form_error('name');
            }
			if(form_error('mobile_no')){
                $errors['mobile_noError'] = form_error('mobile_no');
            }
		
            if(form_error('address')){
                $errors['addressError'] = form_error('address');
            }
            if(form_error('password')){
                $errors['passwordError'] = form_error('password');
            }
            
            
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }
    
    function update_deliver_boy_data()
    
    {
	
         $login_type   = $this->session->userdata('type');
         
        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('name', ' name', 'required');
		$this->form_validation->set_rules('mobile_no', 'mobile no', 'required');
		$this->form_validation->set_rules('address', 'address', 'required');
        $this->form_validation->set_message('required', '* Please add %s');
        
		$name  = $this->input->post('name');
		$mobile_no    = $this->input->post('mobile_no');
		$address   = $this->input->post('address');

		

		$edit_id  = $this->input->post('db_id');
		
		$pincode  = $this->input->post('pincode');
		$aadhaar_card      = $this->input->post('aadhaar_card');
		$aadhaar_card_old   = $this->input->post('aadhaar_card_old');
		
		
        if($this->form_validation->run() == TRUE)
		{
            $update_data = array
			(
                'name'      => $name,
				'mobile_no'        => $mobile_no,
				'address'          => $address,

            );
			
            $this->db->where('db_id', $edit_id)->update('delivery_boy', $update_data);
            
            
             $update_data1 = array
			(

				'isActive'      => '1',

            );
			
           $this->db->where('db_id', $edit_id)->update('db_wise_area', $update_data1);
           
            $cnt = count($pincode);
                for($i=0; $i<$cnt; $i++)
                {
                	$data2 = array
                   (
                		'db_id'              => $edit_id,
                		'pincode'             => $_POST['pincode'][$i],
                		'franchise_id'        => $login_type,
                	);
                
                	$this->db->insert('db_wise_area', $data2);
                
                }
                
            
            $files = $_FILES;
            if (!empty($_FILES['aadhaar_card']['name']))
            {

                $_FILES['aadhaar_card']['name'] = $files['aadhaar_card']['name'];
                $_FILES['aadhaar_card']['type'] = $files['aadhaar_card']['type'];
                $_FILES['aadhaar_card']['tmp_name'] = $files['aadhaar_card']['tmp_name'];
                $_FILES['aadhaar_card']['error'] = $files['aadhaar_card']['error'];
                $_FILES['aadhaar_card']['size'] = $files['aadhaar_card']['size'];
                
                if($aadhaar_card_old != $aadhaar_card)
                {
                    
                  //  unlink('./assets/images/deliverboy/'.$aadhaar_card_old);
                    
                    $this->upload->initialize($this->upload_db_doc());
                    if (!$this->upload->do_upload('aadhaar_card')) 
                    {
                        $upload_error[] = array('error' => $this->upload->display_errors());
                        
                    } else 
                    {
                        $upload_data = $this->upload->data();
    
                        $name_array = $upload_data['file_name'];
                        $insertArray1 = array
                        (
                            'aadhaar_card' => $upload_data['file_name']
                        );
                        $this->db->where('db_id', $edit_id);
                        $this->db->update('delivery_boy', $insertArray1);
                       
                    }
                } 
                  else 
                {
                    $insertArray1 = array
                    (
                        'aadhaar_card' => $aadhaar_card_old
                    );
                    $this->db->where('db_id', $edit_id);
                    $this->db->update('delivery_boy', $insertArray1);
                    
                   
                }    
            }

		
			    
			
			$status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Delivery boy!</strong> update successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';
		
            $this->session->set_flashdata('message',$message);
             $redirect = base_url('customer/delivery_boy');
        }
		else
		{
             $status = 'error';
             if(form_error('name')){
                $errors['nameError'] = form_error('name');
            }
			if(form_error('mobile_no')){
                $errors['mobile_noError'] = form_error('mobile_no');
            }
		
            if(form_error('address')){
                $errors['addressError'] = form_error('address');
            }
            
			
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }
    
     /********************** Delete Deliver boy  **********************
*********************************************************************************/
    public function delete_delivery_boy()
    {
    	$delete_id = $this->input->post('delete_id');
		

		  $update_data = array
			(

				'isActive'      => '1',

            );
			
           $this->db->where('db_id', $delete_id)->update('delivery_boy', $update_data);
           
             $update_data1 = array
			(

				'isActive'      => '1',

            );
			
           $this->db->where('db_id', $delete_id)->update('db_wise_area', $update_data1);
        echo $delete_id;
    } 
    
    
    
     public function make_payment()
	{
		 if(!$this->session->userdata('isLoggedIn'))
		 {
			   redirect('login');
		 }
		 else	
		 {
            $saller_id = $this->input->get('saller_id');
            $data['saller'] = $this->customer_model->get_saller_details($saller_id);
			$this->load->view('common/header');
			$this->load->view('make_payment',$data);
			$this->load->view('common/footer');
		 }
     }
     

    
    
    public function make_payment_db()
	{
		 if(!$this->session->userdata('isLoggedIn'))
		 {
			   redirect('login');
		 }
		 else	
		 {
            $db_id = $this->input->get('db_id');
            $data['db'] = $this->customer_model->get_db_details($db_id);
			$this->load->view('common/header');
			$this->load->view('make_payment_db',$data);
			$this->load->view('common/footer');
		 }
     }
     
     
    public function add_payment_data1()
	{

        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('payment_mode', 'payment mode', 'required');
        $this->form_validation->set_message('required', '* Please add %s');
        
		$current_bal  = $this->input->post('current_bal');
		$db_id    = $this->input->post('db_id');
		
		$payment_mode   =$this->input->post('payment_mode');


        $amount_cash    =$this->input->post('amount_cash');
        $cheque_amount  =$this->input->post('cheque_amount');
        $neft_amount    =$this->input->post('neft_amount');
        $imps_amount    =$this->input->post('imps_amount');

  
        $neft_transaction_id  = $this->input->post('neft_transaction_id');
        $imps_transaction_id  = $this->input->post('imps_transaction_id');

        $pay_date       =$this->input->post('pay_date');
        $cheque_pay_date=$this->input->post('cheque_pay_date');
        $neft_pay_date   =$this->input->post('neft_pay_date');
        $imps_pay_date   =$this->input->post('imps_pay_date');

        
        $cheque_no      =$this->input->post('cheque_no');
        $Cheque_date    =$this->input->post('Cheque_date');
        $bank_name      =$this->input->post('bank_name');
        $bank_branch    =$this->input->post('bank_branch');
        
         if($payment_mode == 'Cash')
         {
        	 $amount = $amount_cash;
        	 
         }else if($payment_mode == 'Cheque')
         {
        	$amount = $cheque_amount; 
        	
         }else if($payment_mode == 'Neft')
         {
        	$amount = $neft_amount; 
        	
         }else if($payment_mode == 'IMPS')
         {
        	$amount = $imps_amount; 
        	
         }
         
         
         
          if($payment_mode == 'Neft')
         {
        	$transaction_id = $neft_transaction_id; 
        	
         }
         else if($payment_mode == 'IMPS')
         {
        	$transaction_id = $imps_transaction_id; 
        	
         }

         
         
        if($payment_mode == 'Cash')
         {
        	 $date1 = $pay_date;
        	 $date  = date("d-m-Y", strtotime($date1));
        	 
         }
         else if($payment_mode == 'Cheque')
         {
        	$date1 = $cheque_pay_date;
        	$date  = date("d-m-Y", strtotime($date1));	
        	
         }
         
         else if($payment_mode == 'Neft')
         {
        	$date1 = $neft_pay_date;
        	$date  = date("d-m-Y", strtotime($date1));	
        	
         } else if($payment_mode == 'IMPS')
         {
        	$date1 = $imps_pay_date;
        	$date  = date("d-m-Y", strtotime($date1));	
        	
         }
         
         
        if($this->form_validation->run() == TRUE)
		{
		    
		       
                
                $insertArray1 = array
                (
                    'wallet' => $current_bal - $amount
                );
                $this->db->where('db_id', $db_id);
                $this->db->update('delivery_boy', $insertArray1);
                

                $regData = array
                (
                    'db_id' => $db_id,

                    'debit' => $amount,
                    'opening_bal'  => $current_bal,
                    'closing_bal'  => $current_bal - $amount,
                    'c_d_date'  => $date,
                  
                );
                
                $this->db->insert('db_wallet_history', $regData);
    
			$status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Amount!</strong> pay successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';
		
            $this->session->set_flashdata('message',$message);
             $redirect = base_url('customer/delivery_boy');
        }
		else
		{
             $status = 'error';
             if(form_error('payment_mode'))
             {
                $errors['payment_modeError'] = form_error('payment_mode');
            }
			
			
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }
    
    
	    //////////////////////////////// Client Export in Excel  ///////////////////////////////////////////////////// 
 
    public function download_excel()
    {

    	require_once './application/third_party/PHPExcel.php';
    	require_once './application/third_party/PHPExcel/IOFactory.php';
    
    	// Create new PHPExcel object
    	$objPHPExcel = new PHPExcel();
    
    	$default_border = array(
    		'style' => PHPExcel_Style_Border::BORDER_THIN,
    		'color' => array('rgb' => 'ffffff'),
    	);
    
    	$acc_default_border = array(
    		'style' => PHPExcel_Style_Border::BORDER_THIN,
    		'color' => array('rgb' => 'c7c7c7'),
    	);
    	$outlet_style_header = array(
    		'font' => array(
    			'color' => array('rgb' => 'ffffff'),
    			'size' => 10,
    			'name' => 'Arial',
    			'bold' => true,
    		),
    	);
    	$top_header_style = array(
    		'borders' => array(
    			'bottom' => $default_border,
    			'left' => $default_border,
    			'top' => $default_border,
    			'right' => $default_border,
    		),
    		'fill' => array(
    			'type' => PHPExcel_Style_Fill::FILL_SOLID,
    			'color' => array('rgb' => 'fc5d61'),
    		),
    		'font' => array(
    			'color' => array('rgb' => 'ffffff'),
    			'size' => 15,
    			'name' => 'Arial',
    			'bold' => true,
    		),
    		'alignment' => array(
    			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    		),
    	);
    	$style_header = array(
    		'borders' => array(
    			'bottom' => $default_border,
    			'left' => $default_border,
    			'top' => $default_border,
    			'right' => $default_border,
    		),
    		'fill' => array(
    			'type' => PHPExcel_Style_Fill::FILL_SOLID,
    			'color' => array('rgb' => 'fc5d61'),
    		),
    		'font' => array(
    			'color' => array('rgb' => 'ffffff'),
    			'size' => 12,
    			'name' => 'Arial',
    			'bold' => true,
    		),
    		'alignment' => array(
    			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    		),
    	);
    	$account_value_style_header = array(
    		'borders' => array(
    			'bottom' => $default_border,
    			'left' => $default_border,
    			'top' => $default_border,
    			'right' => $default_border,
    		),
    		'font' => array(
    			'color' => array('rgb' => 'ffffff'),
    			'size' => 12,
    			'name' => 'Arial',
    		),
    		'alignment' => array(
    			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
    		),
    	);
    	$text_align_style = array(
    		'alignment' => array(
    			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    		),
    		'borders' => array
    		(
    			'bottom' => $default_border,
    			'left' => $default_border,
    			'top' => $default_border,
    			'right' => $default_border,
    		),
    		'fill' => array(
    			'type' => PHPExcel_Style_Fill::FILL_SOLID,
    			'color' => array('rgb' => 'fc5d61'),
    		),
    		'font' => array(
    			'color' => array('rgb' => 'ffffff'),
    			'size' => 12,
    			'name' => 'Arial',
    			'bold' => true,
    		),
    	);
        

    	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:G1');
    	$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Customer List');
    
    	$objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($top_header_style);
    	$objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($top_header_style);
    	$objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($top_header_style);
    	$objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($top_header_style);
    	$objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($top_header_style);
    	$objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($top_header_style);
    	$objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($top_header_style);

    
    	$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Customer id');
    	$objPHPExcel->getActiveSheet()->setCellValue('B2', 'Customer name');
    	$objPHPExcel->getActiveSheet()->setCellValue('C2', 'Mobile no');
    	$objPHPExcel->getActiveSheet()->setCellValue('D2', 'Email id');
    	$objPHPExcel->getActiveSheet()->setCellValue('E2', 'Pincode');
    	$objPHPExcel->getActiveSheet()->setCellValue('F2', 'Last order date');
    	$objPHPExcel->getActiveSheet()->setCellValue('G2', 'Register date');


    
    	$objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
    	$objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
    	$objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
    	$objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);
    	$objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_header);
    	$objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($style_header);
    	$objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($style_header);

    
    	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(50);
    	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);



    	$objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);
    
    	$row = 3;
    	$customer_list  = $this->customer_model->get_customer_data();
        // echo "<pre>";print_r($customer_list);exit;
       if (is_array($customer_list) || is_object($customer_list))
       {
    	foreach ($customer_list as $value)
    	{ 
    	    

            	    $CI =& get_instance();
                    $CI->load->model('Customer_model');
                    $result22 = $CI->customer_model->customer_last_order($value->customer_id);
                    if(!empty($result22))
                    {
                       $date = $result22->order_date ; 
                    }
                    else
                    {
                        $date ='';
                    }
                    
     

            
            

    		$objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$value->customer_unique_id);
    		$objPHPExcel->getActiveSheet()->setCellValue('B'.$row, $value->first_name.'  '.$value->last_name);
    		$objPHPExcel->getActiveSheet()->setCellValue('C'.$row, $value->mobile_no);
    		$objPHPExcel->getActiveSheet()->setCellValue('D'.$row, $value->email_id);
    		$objPHPExcel->getActiveSheet()->setCellValue('E'.$row, $value->pincode);
    		
    		$objPHPExcel->getActiveSheet()->setCellValue('F'.$row, $date);
    		$objPHPExcel->getActiveSheet()->setCellValue('G'.$row, $value->rdate);

    	
    		$row++;
    	}
       }
    	header('Content-Type: application/vnd.ms-excel');
    	header('Content-Disposition: attachment;filename="Customer list.xls"');
    	header('Cache-Control: max-age=0');
    	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    	$objWriter->save('php://output');
    }
    

     
     
     
    public function collect_amount_list()
	{
		 if(!$this->session->userdata('isLoggedIn'))
		 {
			   redirect('login');
		 }
		 else	
		 {
            $data['all_db'] = $this->customer_model->get_collect_amount_model();
			$this->load->view('common/header');
			$this->load->view('collect_amount_list',$data);
			$this->load->view('common/footer');
		 }
     }
     
     
    public function monthly_customer()
	{
		 if(!$this->session->userdata('isLoggedIn'))
		 {
			   redirect('login');
		 }
		 else	
		 {
            $data['all_customer'] = $this->customer_model->get_monthly_customer_model();
			$this->load->view('common/header');
			$this->load->view('monthly_customer',$data);
			$this->load->view('common/footer');
		 }
     }
     
     
    public function today_customer()
	{
		 if(!$this->session->userdata('isLoggedIn'))
		 {
			   redirect('login');
		 }
		 else	
		 {
            $data['all_customer'] = $this->customer_model->get_today_customer_model();
			$this->load->view('common/header');
			$this->load->view('today_customer',$data);
			$this->load->view('common/footer');
		 }
     }

     
     
     
    public function verify_db_mobile()
	{
	    
      $mobile_no = $this->input->get('mobile_no');
      //print_r($username);die();
      
        $this->db->select('*');
        $this->db->from('delivery_boy');
        $this->db->where('mobile_no', $mobile_no );
        $this->db->where('isActive', '0' );
        $query  = $this->db->get();
        $num = $query->num_rows();
        if($num > 0)
    	{
    		echo $flag=1;
    		//echo "Username Alredy Exists";
    	}
    	else
    	{
    		echo $flag=0;
    	}
		
    }
    




function block_customer()
    
    {
	
        
        $errors   = array();
        $message  = '';
        $redirect = '';



		$multiple_id  = $this->input->post('multiple_id');

             
            $customer_id = explode(",", $multiple_id);
            $i=0;
            foreach($customer_id as $customer_id)
            {
                $update_data = array
               (
            		'flag'                => '1',
            	
		
            	);
            
            	$this->db->where('customer_id',$customer_id)->update('customer', $update_data);
            	
                $i++;
            }
            
            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Customer block!</strong>  successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';
		
            $this->session->set_flashdata('message',$message);
            $redirect = base_url('customer');


        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }
    
    
    
    public function credit_wallet()
	{
		 if(!$this->session->userdata('isLoggedIn'))
		 {
			   redirect('login');
		 }
		 else	
		 {
            $data['all_customer'] = $this->customer_model->get_customer_model();
			$this->load->view('common/header');
			$this->load->view('credit_wallet',$data);
			$this->load->view('common/footer');
		 }
     }
     
     
     public function credit_amount_in_wallet()
	{
	    $login_type   = $this->session->userdata('type');
	    
        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('credit_amount', 'credit amount', 'required');
        $this->form_validation->set_rules('customer_id', 'customer', 'required');
        $this->form_validation->set_message('required', '* Please add %s');
        
		$credit_amount  = $this->input->post('credit_amount');
		$customer_id  = $this->input->post('customer_id');
		
        

        if($this->form_validation->run() == TRUE)
		{
		    $this->db->select('*');
    		$this->db->from('customer');
    		$this->db->where('customer_id',$customer_id);
    	    $query_wallet  = $this->db->get();
            $result_wallet = $query_wallet->row();
            $wallet = $result_wallet->wallet;
        
            $update_data = array
			(
                'wallet'      => $wallet + $credit_amount,

            );
			
            $this->db->where('customer_id', $customer_id)->update('customer', $update_data);


			
			$status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Amount credit in wallet!</strong>  successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';
		
            $this->session->set_flashdata('message',$message);
             $redirect = base_url('customer');
        }
		else
		{
             $status = 'error';
             if(form_error('customer_id')){
                $errors['customer_idError'] = form_error('customer_id');
            }
            if(form_error('credit_amount')){
                $errors['credit_amountError'] = form_error('credit_amount');
            }
            
			
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }
    
    
    
    public function add_qrcode_data()
	{
	   	$this->load->library('ci_qr_code');
        $this->config->load('qr_code');
        
        $login_type   = $this->session->userdata('type');
        
        $errors   = array();
        $message  = '';
        $redirect = '';
  
            $data_qrcode = array
			(
                'date' => date('d-m-Y')
            );
			
			//print_r($data_qrcode);die;
            $this->db->insert('qrcode', $data_qrcode);
            $insert_id = $this->db->insert_id();
            
            $qr_code_config = array();
            $qr_code_config['cacheable'] = $this->config->item('cacheable');
            $qr_code_config['cachedir'] = $this->config->item('cachedir');
            $qr_code_config['imagedir'] = $this->config->item('imagedir');
            $qr_code_config['errorlog'] = $this->config->item('errorlog');
            $qr_code_config['ciqrcodelib'] = $this->config->item('ciqrcodelib');
            $qr_code_config['quality'] = $this->config->item('quality');
            $qr_code_config['size'] = $this->config->item('size');
            $qr_code_config['black'] = $this->config->item('black');
            $qr_code_config['white'] = $this->config->item('white');
            $this->ci_qr_code->initialize($qr_code_config);
            
            $code_name = 'QRCODE'.rand('11111','99999');
            // get full name and user details
            $qr_details = $this->product_model->get_qrcode_one($insert_id);
            $image_name = $code_name . ".png";
    
            // create user content
            
            $data11[]=array("id"=>$qr_details->id,"barcode"=>$qr_details->barcode);
            $codeContents = json_encode(array("result"=>$data11)); 

            $params['data'] = $codeContents;
            $params['level'] = 'H';
            $params['size'] = 8;
    
            $params['savename'] = FCPATH . $qr_code_config['imagedir'] . $image_name;
            $this->ci_qr_code->generate($params);
    
            $this->data['qr_code_image_url'] = './assets/images/qrcode/'.$qr_code_config['imagedir'] . $image_name;
    
            // save image path in tree table
            $this->product_model->change_userqr($insert_id, $image_name);
            // then redirect to see image link
            $file = $params['savename'];

			
			$status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>qrcode!</strong> add successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';
		
            $this->session->set_flashdata('message',$message);
             $redirect = base_url('product/qrcode');


        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }
    
    
    
    public function inactive_customer()
	{
		 if(!$this->session->userdata('isLoggedIn'))
		 {
			   redirect('login');
		 }
		 else	
		 {

			$this->load->view('common/header');
			$this->load->view('inactive_customer');
			$this->load->view('common/footer');
		 }
     }
     
     
     
     
          //////////////////////////////////AJAX INCATIVE CUSTOMER LIST //////////////////////////
	
	public function ajax_inactive_customer_list ()
	{
	    $login_type   = $this->session->userdata('type');

        	   $columns = array
        	   ( 
                    0 =>'customer_id', 
                    1 =>'first_name',
                    2 =>'mobile_no',
                    3 =>'city',
                    4 =>'pincode',
                    5 =>'wallet',
                    6 =>'date',
                    7 =>'flag',

                );
    
    		$limit = $this->input->post('length');
            $start = $this->input->post('start');
            $order = $columns[$this->input->post('order')[0]['column']];
            $dir = $this->input->post('order')[0]['dir'];
      
            $totalData = $this->customer_model->incustomer_count();
                
            $totalFiltered = $totalData; 
                
            if(empty($this->input->post('search')['value']))
            {            
                $posts = $this->customer_model->incustomer_list($limit,$start,$order,$dir);
            }
            else
            {
                $search = $this->input->post('search')['value']; 
    
                $posts =  $this->customer_model->incustomer_search($limit,$start,$search,$order,$dir);
    
                $totalFiltered = $this->customer_model->incustomer_search_count($search);
            }
    
            $data = array();
            if(!empty($posts))
            {
                $i=1; 
                foreach ($posts as $post)
                {
                
                    $nestedData['customer_id'] = $i++;
                    $nestedData['wallet'] = $post->wallet;
                    $nestedData['mobile_no'] = $post->mobile_no;
                    $nestedData['date'] = $post->rdate;
                    
                    $nestedData['first_name'] = $post->first_name.' '.$post->last_name;
                    
                    
                    
                     if($post->flag == '0')
                    {
                        $nestedData['flag'] = '<span class="badge badge-success shadow-success m-1">Active</span>';
                        
                    }elseif($post->flag == '1')
                    {
                      $nestedData['flag'] = '<span class="badge badge-danger shadow-danger m-1">Deactive</span>';
                      
                    }
                    if($post->pincode !='')
                    {
                        $nestedData['pincode'] = $post->pincode;
                        
                    }
                    else
                    {
                       $nestedData['pincode'] = '';
                    }
                    
                    if($post->city_id !='')
                    {
                        $this->db->select('*');
                		$this->db->from('city_master');
                		$this->db->where('city_id', $post->city_id );
                	    $query1  = $this->db->get();
                        $result1 = $query1->row();
                        $city = $result1->city_name;
                    }
                    else
                    {
                       $city = ''; 
                    }
                    
                    $nestedData['city'] = $city;
                    

                    
                   

                    $data[] = $nestedData;
    
                $i++; }
            }
              
            $json_data = array
            (
                "draw"            => intval($this->input->post('draw')),  
                "recordsTotal"    => intval($totalData),  
                "recordsFiltered" => intval($totalFiltered), 
                "data"            => $data   
            );
                
            echo json_encode($json_data); 
	    
	}
////////////////////////////////////////////////////////////////////////////////////


}