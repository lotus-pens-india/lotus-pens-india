<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchse extends CI_Controller {


    function __construct()
    {
        parent::__construct();
		$this->load->model('product_model');
		$this->load->model('purchse_model');
		$this->load->library('upload');
		
    }


/****************************** STock View Page **************/

    public function stock()
	{
		 if(!$this->session->userdata('isLoggedIn'))
		 {
			   redirect('login');
		 }
		 else	
		 {
			$this->load->view('common/header');
			$this->load->view('purchse/stock');
			$this->load->view('common/footer');
		 }
     }
     
     
               //////////////////////////////////AJAX STOCK LIST //////////////////////////
	
	public function ajax_stock_list ()
	{

        	   $columns = array
        	   ( 
                    0 =>'product_id', 
                    1 =>'main_image',
                    2 =>'product_name',
                    3 =>'qty',
                    4 =>'franchise',

                    
                );
    
    		$limit = $this->input->post('length');
            $start = $this->input->post('start');
            $order = $columns[$this->input->post('order')[0]['column']];
            $dir = $this->input->post('order')[0]['dir'];
      
            $totalData = $this->product_model->product_count();
                
            $totalFiltered = $totalData; 
                
            if(empty($this->input->post('search')['value']))
            {            
                $posts = $this->product_model->product_list($limit,$start,$order,$dir);
            }
            else
            {
                $search = $this->input->post('search')['value']; 
    
                $posts =  $this->product_model->product_search($limit,$start,$search,$order,$dir);
    
                $totalFiltered = $this->product_model->product_search_count($search);
            }
    
            $data = array();
            if(!empty($posts))
            {
                $i=1; 
                foreach ($posts as $post)
                {
                
                    $nestedData['product_id'] = $i;
                    $nestedData['product_name'] = $post->product_name;
                    $this->db->select('*');
            		$this->db->from('franchise');
            		$this->db->where('franchise_id',$post->franchise_id);
            	    $query44  = $this->db->get();
                    $result44 = $query44->row();
                    $franchise_name = $result44->franchise_name;
                    
                   $nestedData['franchise'] = $franchise_name;
                    
                    if($post->qty == '0')
                    {
                        $nestedData['qty'] = '<span class="badge badge-danger shadow-danger m-1">Out of stock</span>';
                    }
                    else
                    {
                        $nestedData['qty'] = $post->qty;
                    }

                    if($post->main_image == '')
                    {
                        $nestedData['main_image'] = '<a href="https://via.placeholder.com/1500x1000" data-fancybox="images" data-caption="This image has a caption">
                    							  <img src="https://via.placeholder.com/240x160" alt="lightbox" class="lightbox-thumb img-thumbnail">
                    							</a>';
                        
                    }else
                    {
                      $nestedData['main_image'] = '<a href="'.base_url('assets/images/product/'.$post->main_image).'" data-fancybox="images" data-caption="This image has a caption">
									           <img src="'.base_url('assets/images/product/'.$post->main_image).'" alt="lightbox" class="lightbox-thumb img-thumbnail" style="width: 80px;">
								            	</a>';
                      
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
	
	
	
	/****************************** supplier View Page **************/

    public function supplier()
	{
		 if(!$this->session->userdata('isLoggedIn'))
		 {
			   redirect('login');
		 }
		 else	
		 {
		    $data['all_supplier'] = $this->purchse_model->get_all_supplier_model(); 
			$this->load->view('common/header');
			$this->load->view('purchse/supplier',$data);
			$this->load->view('common/footer');
		 }
     }
     
     
     
    public function add_supplier_data()
	{
	    $login_type   = $this->session->userdata('type');
	    
        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('company_name', 'nam', 'required');
        $this->form_validation->set_rules('mobile_no', 'mobile', 'required');
        $this->form_validation->set_rules('address', 'address', 'required');
        $this->form_validation->set_message('required', '* Please add %s');
        
		$company_name  = $this->input->post('company_name');
		$mobile_no  = $this->input->post('mobile_no');
		$email_id  = $this->input->post('email_id');
		$address  = $this->input->post('address');

        if($this->form_validation->run() == TRUE)
		{
            $data_supplier = array
			(
                'company_name'      => $company_name,
                'mobile_no'      => $mobile_no,
                'email_id'      => $email_id,
                'address'      => $address,
                'franchise_id'      => $login_type,

            );
			
            $this->db->insert('supplier', $data_supplier);

			
			$status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>supplier!</strong> add successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';
		
            $this->session->set_flashdata('message',$message);
             $redirect = base_url('purchse/supplier');
        }
		else
		{
             $status = 'error';
             if(form_error('company_name')){
                $errors['company_nameError'] = form_error('company_name');
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
    
    
    
    public function update_supplier_data()
	{
	    $login_type   = $this->session->userdata('type');
	    
        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('company_name', 'nam', 'required');
        $this->form_validation->set_rules('mobile_no', 'mobile', 'required');
        $this->form_validation->set_rules('address', 'address', 'required');
        $this->form_validation->set_message('required', '* Please add %s');
        
		$company_name  = $this->input->post('company_name');
		$mobile_no  = $this->input->post('mobile_no');
		$email_id  = $this->input->post('email_id');
		$address  = $this->input->post('address');
		
		$supplier_id  = $this->input->post('supplier_id');

        if($this->form_validation->run() == TRUE)
		{
            $update_data = array
			(
                'company_name'      => $company_name,
                'mobile_no'      => $mobile_no,
                'email_id'      => $email_id,
                'address'      => $address,

            );
			
            $this->db->where('supplier_id', $supplier_id)->update('supplier', $update_data);

			
			$status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>supplier!</strong> update successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';
		
            $this->session->set_flashdata('message',$message);
             $redirect = base_url('purchse/supplier');
        }
		else
		{
             $status = 'error';
             if(form_error('company_name')){
                $errors['company_nameError'] = form_error('company_name');
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
     
     
     /********************** Delete  supplier **********************
*********************************************************************************/
    public function delete_supplier()
    {
    	$delete_id = $this->input->post('delete_id');
		
            $update_data = array
			(

				'isActive'      => '1',

            );
			
           $this->db->where('supplier_id', $delete_id)->update('supplier', $update_data);
        echo $delete_id;
    }
    
    
	public function purchse_entry()
	{
		 if(!$this->session->userdata('isLoggedIn'))
		 {
			   redirect('login');
		 }
		 else	
		 {
            
            $data['all_supplier'] = $this->purchse_model->get_all_supplier_model();
		    $data['all_product'] = $this->product_model->get_product_data(); 
			$this->load->view('common/header');
			$this->load->view('purchse/purchse_entry',$data);
			$this->load->view('common/footer');
		 }
     }
     
     
     
    public function get_supplier()
	{
	    $supplier_id = $this->input->post('supplier_id');
	    
        $this->db->select('*');
        $this->db->from('supplier');
        $this->db->where('supplier_id', $supplier_id );
        $query  = $this->db->get();
        $rowcount = $query->num_rows();
	    if($rowcount == 0)
		{
		    echo '';
		}
		else
	    {
            $result = $query->row();
            $mobile_no = $result->mobile_no;
            $email_id     = $result->email_id;
            $address     = $result->address;
            
 


        echo $mobile_no."#". $email_id."#".$address;
	    }
	    
	}
	
	
	
    public function add_purchase_entry_data()
	{
	    
	    
        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('supplier_id', 'supplier name', 'required');

        $this->form_validation->set_message('required', '* Please add %s');
        
        $currdate = date('d-m-Y');
		$supplier_id  = $this->input->post('supplier_id');
		$total_amount  = $this->input->post('total_amount');
		$total_discount  = $this->input->post('total_discount');
		$grand_total_amount  = $this->input->post('grand_total_amount');

		$franchise_id   = $this->session->userdata('type');
		


        if($this->form_validation->run() == TRUE)
		{

        		
        		$purchse_entry = array
                (                                                                                                                                                                                                       
          
                    'supplier_id'  => $supplier_id,
                    'total_amount'    => $total_amount,
                    'total_discount' => $total_discount,
                    'grand_total_amount'  => $grand_total_amount,
                    'purchse_date'      => $currdate,
                    'franchise_id'  => $franchise_id,

                );
                
               //print_r($purchse_entry);die;
                
                $this->db->insert('purchse_order', $purchse_entry);
                $insert_id = $this->db->insert_id();
                

                 $cnt = count($product_id = $this->input->post('product_id'));
                    
                    
                    //print_r($qty);exit;
                    
                    
                    for($i=0; $i<$cnt; $i++)
                    {
                        
                        $this->db->select('*');
                		$this->db->from('product_details');
                		$this->db->where('id',$_POST['unit'][$i]);
                	    $query  = $this->db->get();
                        $result = $query->row();
                        $title = $result->title;
                        
                        $this->db->select('*');
                		$this->db->from('vegshopy_product');
                		$this->db->where('product_id',$_POST['product_id'][$i]);
                	    $query11  = $this->db->get();
                        $result11 = $query11->row();
                        $avi_qty = $result11->qty;
                        
                        $stock   = $avi_qty + $_POST['qty'][$i] ;
                        
                        
                    	$data2 = array
                       (
                            'p_id'       => $insert_id,
                    		'product_id'     => $_POST['product_id'][$i],
                    		'qty'            => $_POST['qty'][$i],
                    		'unit'           => $title,
                    		'unit_price'     => $_POST['unit_price'][$i],
                    		'discount'       => $_POST['discount'][$i],
                    		'franchise_id'   => $franchise_id,
        
                    	);
                    	$this->db->insert('purchse_order_detail', $data2);
                    	
                    	$data22 = array
                       (
                            'qty'       => $stock,

                    	);
                    	$this->db->where('product_id', $_POST['product_id'][$i]);
                        $this->db->update('vegshopy_product', $data22);
                    	
                    	
                    }
                    

        			
        			
        			$status = 'success';
                    $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
        						<button type="button" class="close" data-dismiss="alert">×</button>
        						
        						<div class="alert-icon">
        						 <i class="icon-check"></i>
        						</div>
        						<div class="alert-message">
        						  <span><strong>purchse!</strong> add successfully. <a href="javascript:void();" class="alert-link"></a></span>
        						</div>
        					  </div>';
        		
                    $this->session->set_flashdata('message',$message);
                     $redirect = base_url('purchse/purchse_list');


        }
		else
		{
            $status = 'error';
            if(form_error('supplier_id'))
            {
                $errors['supplier_idError'] = form_error('supplier_id');
            }
            

			
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }
    
    
    public function purchse_list()
	{
		 if(!$this->session->userdata('isLoggedIn'))
		 {
			   redirect('login');
		 }
		 else	
		 {
			$this->load->view('common/header');
			$this->load->view('purchse/purchse_list');
			$this->load->view('common/footer');
		 }
     }
     
     
     
            //////////////////////////////////AJAX TOTAL ORDER LIST //////////////////////////
	
	public function ajax_total_purchse_list ()
	{
	    $login_type   = $this->session->userdata('type');  

        	   $columns = array
        	   ( 
                    0 =>'p_id', 
                    1 =>'count_product',
                    2 =>'supplier_id',
                    3 =>'total_amount',
                    4 =>'total_discount',
                    5 =>'grand_total_amount',
                    6 =>'purchse_date',
                    7 =>'franchise',
                    8 =>'action',

                    
                );
    
    		$limit = $this->input->post('length');
            $start = $this->input->post('start');
            $order = $columns[$this->input->post('order')[0]['column']];
            $dir = $this->input->post('order')[0]['dir'];
      
            $totalData = $this->purchse_model->total_purchse_count();
                
            $totalFiltered = $totalData; 
                
            if(empty($this->input->post('search')['value']))
            {            
                $posts = $this->purchse_model->total_purchse_list($limit,$start,$order,$dir);
            }
            else
            {
                $search = $this->input->post('search')['value']; 
    
                $posts =  $this->purchse_model->total_purchse_search($limit,$start,$search,$order,$dir);
    
                $totalFiltered = $this->purchse_model->total_purchse_search_count($search);
            }
    
            $data = array();
            if(!empty($posts))
            {
                $i=1; 
                foreach ($posts as $post)
                {
                
                    $nestedData['p_id'] = $i++;
                    $nestedData['supplier_id'] = $post->company_name;
                    $nestedData['total_amount'] = $post->total_amount;
                    $nestedData['total_discount'] = $post->total_discount;
                    $nestedData['grand_total_amount'] = $post->grand_total_amount;
                    $nestedData['purchse_date'] = $post->purchse_date;
                     $nestedData['franchise'] = $post->franchise_name;

                    $this->db->select('COUNT(p_id) AS no_of_product');
            		$this->db->from('purchse_order_detail');
            		$this->db->where('p_id',$post->p_id);
            	    $query  = $this->db->get();
                    $result = $query->row();
                    $no_of_product = $result->no_of_product;
                    
                    
                    $nestedData['count_product'] = $no_of_product;
                    
                    $nestedData['action']='';
                    
            
                    $nestedData['action'] = ' <div class="btn-group m-1" role="group">
                                              <button type="button" class="btn btn-dark   waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                              </button>
                                              <div class="dropdown-menu">
                                                <a href="'.base_url('purchse/view_invoice?purchse_id='.$post->p_id).'" class="dropdown-item" target="_blank"><i aria-hidden="true" class="fa fa-eye"></i> View</a>
                                              </div>
                                            </div>';
                   

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
	
	
	
	public function view_invoice()
	{
		 if(!$this->session->userdata('isLoggedIn'))
		 {
			   redirect('login');
		 }
		 else	
		 {
            $p_id = $this->input->get('purchse_id');
            $data['order_summary'] = $this->purchse_model->get_order_summary($p_id);
			$this->load->view('common/header');
			$this->load->view('purchse/view_invoice',$data);
			$this->load->view('common/footer');
		 }
     }
    
 //////////////////////////////////////////////////////////////////////////////////    
     
} 