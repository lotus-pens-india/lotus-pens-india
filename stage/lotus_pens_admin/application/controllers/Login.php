<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
     
	public function __construct()
    {
        parent::__construct();

        // Load database
        $this->load->model('login_database');
    } 
	 
	public function index()
	{ 
	
       $this->load->view('login/login_view');

	}
	
	
	
	public function numberCheck()
	{
      $mobile = $this->input->post('m');

      //print_r($username);die();
      
        $this->db->select('*');
        $this->db->from('vg_login');
        $this->db->where('company_phone', $mobile);
        $this->db->where('flag', '0');
        $query  = $this->db->get();
        
        $num = $query->num_rows();
        if($num > 0)
    	{
    
                $otp = rand('0000','9999');
                $sender="BASKET";
    			$number2 = $mobile;
    			
    			$otp=mt_rand(0000, 9999);
        		
        		$session_data = array
        		(
        			'get_otp'         => $otp,
        			'get_mobile'         => $number2,
                );
                $this->session->set_userdata($session_data);
                
    			$msg2="One Time OTP To Verify Mobile Number : $otp";
    			
    			$api_key = '55A827A192C7C6';
    			$ch = curl_init();
    			curl_setopt($ch,CURLOPT_URL, "https://www.logonutility.in/app/smsapi/index.php");
    			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    			curl_setopt($ch, CURLOPT_POST, 1);
    		    curl_setopt($ch, CURLOPT_POSTFIELDS, "key=".$api_key."&&campaign=1&routeid=20&type=text&contacts=".$number2."&senderid=".$sender."&msg=".$msg2);
    		    $response = curl_exec($ch);
    		    curl_close($ch);
        		    

        		echo 1;
    	}
    	else
    	{
    		    echo 0;
    	}
		
    }
	
	
	public function change_pass_page()
	
    {
        //check validations for user input in login page
        $status = '';
        $errors = array();
        $message = '';
        $redirect = '';


        $otp = $this->input->post('otp');
        
        $orignalOtp   = $this->session->userdata('get_otp');
        $mobile_no   = $this->session->userdata('get_mobile');
 
	
		
    	if($otp == $orignalOtp)
    	{
                 $status = 'success';
                 $message  = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
					<button type="button" class="close" data-dismiss="alert">×</button>
					
					<div class="alert-icon">
					 <i class="icon-check"></i>
					</div>
					<div class="alert-message">
					  <span><strong>!</strong> Redirecting... <a href="javascript:void();" class="alert-link"></a></span>
					</div>
				  </div>';
				$this->session->set_flashdata('message', $message);
				$redirect = base_url('login/change_password?mobile_no='.$mobile_no);   

        } 
        else
        {
            $status = 'success';
            $message = '<br><div class="alert alert-outline-danger alert-dismissible alert-round" role="alert">
				   <button type="button" class="close" data-dismiss="alert">×</button>
				    <div class="alert-icon">
					 <i class="icon-close"></i>
				    </div>
				    <div class="alert-message">
				      <span><strong>Wrong otp...</strong> <a href="javascript:void();" class="alert-link"></a></span>
				    </div>
                  </div>';
                $this->session->set_flashdata('message', $message);
                $redirect = '#';

        

        }
        $data['status'] = $status;
        $data['errors'] = $errors;
        $data['redirect'] = $redirect;
        $data['message'] = $message;
        echo json_encode($data);
    }
	
	public function login_process()
	
    {
        //check validations for user input in login page
        $status = '';
        $errors = array();
        $message = '';
        $redirect = '';

        $this->form_validation->set_rules('username', 'username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'password', 'trim|required|xss_clean');
        $this->form_validation->set_message('required', 'Please add %s.');

 
	
		
        if($this->form_validation->run() == TRUE)
        {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $result = $this->login_database->check_admin_login($username, $password);
            $status = 'success';



//            echo $this->db->last_query();
            if($result !='')
            {
               

				 $sessionData = $this->set_session($username);
				 $message  = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
					<button type="button" class="close" data-dismiss="alert">×</button>
					
					<div class="alert-icon">
					 <i class="icon-check"></i>
					</div>
					<div class="alert-message">
					  <span><strong>Success!</strong> Redirecting... <a href="javascript:void();" class="alert-link"></a></span>
					</div>
				  </div>';
				$this->session->set_flashdata('message', $message);
				$redirect = base_url('dashboard');   
        
                
           }
           else
           {
                $message = '<br><div class="alert alert-outline-danger alert-dismissible alert-round" role="alert">
				   <button type="button" class="close" data-dismiss="alert">×</button>
				    <div class="alert-icon">
					 <i class="icon-close"></i>
				    </div>
				    <div class="alert-message">
				      <span><strong>Invalid Credential!</strong> Please Try Again... <a href="javascript:void();" class="alert-link"></a></span>
				    </div>
                  </div>';
                $this->session->set_flashdata('message', $message);
                $redirect = '#';
           }
    
  
            

        } 
        else
        {
            $status = 'error';
            if (form_error('username')) {
                $errors['usernameError'] = form_error('username');
            }

            if (form_error('password')) {
                $errors['passwordError'] = form_error('password');
            }

        

        }
        $data['status'] = $status;
        $data['errors'] = $errors;
        $data['redirect'] = $redirect;
        $data['message'] = $message;
        echo json_encode($data);
    }
	
	
    function set_session($username)
	{
     
		$result = $this->login_database->get_admin_data($username);
		$type   = 'admin';
        $session_data = array
		(
			'login_id'         => $result->p_id,
			'company_name' => $result->company_name,
			'username'     => $username,
			'company_phone'=> $result->company_phone,
			'company_email'=> $result->company_email,
			'company_address'=> $result->company_address,
			'type'=> $result->type,
			'employee_id'=> $result->employee_id,

			'isLoggedIn' => TRUE,

        );
        $this->session->set_userdata($session_data);

    }

    /*
    * Function   : _logout()
    * Parameters : None
    * Returns    : destroy session data for Admin
    * */
    public function admin_logout()
    {
        $this->session->sess_destroy();
        $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
					<button type="button" class="close" data-dismiss="alert">×</button>
					
					<div class="alert-icon">
					 <i class="icon-check"></i>
					</div>
					<div class="alert-message">
					  <span><strong>Logout Successfully!</strong></span>
					</div>
				  </div>';
        $this->session->set_flashdata('message',$message);
        redirect('login');
    }
    
    
    public function reset_password()
	{ 
	
    $this->load->view('login/reset_password');

	}
	
	
	
	public function change_password()
	{ 
	   
	   $data['mobile_no']  = $this->input->get('mobile_no');
       $this->load->view('login/change_password',$data);

	}
	
	
	
	    /******************************************* Update Password **************************************
****************************************************************************************************/
	  
    public function password_update_data()
	{

        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('password', 'password', 'required');
        $this->form_validation->set_message('required', '* Please add %s');
        
		$password  = $this->input->post('current_pass');
		$mobile_no = $this->input->post('mobile_no');


        if($this->form_validation->run() == TRUE)
		{
            $update_data = array
			(
                'password'  => md5($password),

            );
			
            $this->db->where('company_phone',$mobile_no)->update('vg_login', $update_data);
			
			$status = 'success';
			
			 $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Password!</strong> update successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';
					  

            $this->session->set_flashdata('message',$message);
            $redirect = base_url('login');
        }
		else
		{
            $status = 'error';
            if(form_error('password'))
			{
                $errors['passwordError'] = form_error('password');
            }
            


			
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
     
    } 
	
////////////////////////////////////////////////////////////////////////////////////////////////
    
    
}
