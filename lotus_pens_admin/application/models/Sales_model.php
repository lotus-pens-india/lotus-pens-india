<?php

class Sales_model extends CI_Model {



    /*********************************** count today amount *************************************
     ******************************************************************************************************/
      public function count_today_amount()
      {
          
          $currdate = date('d-m-Y');
        $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {  
             return $query = $this->db
    		 ->select('SUM(order_total) AS total_amount')
    		 ->from('product_order')
    		  ->where('order_date', $currdate)
    	     ->where('status !=', '4')
    		 ->get()->row();
    	 }
    	 else
    	 {
    	      return $query = $this->db
    		 ->select('SUM(order_total) AS total_amount')
    		 ->from('product_order')
             ->where('order_date', $currdate)
    	     ->where('status !=', '4')
    		 ->where('franchise_id',$login_type)
    		 ->get()->row();
    		 
    	     
    	 }

 
		 //echo $this->db->last_query();exit();
           
      }
      
      
      public function count_today_amount1()
      {
          
          $currdate1 = date('d-m-Y');
          $currdate = date('d-m-Y',strtotime($currdate1 . "-1 days"));
        $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {  
             return $query = $this->db
    		 ->select('SUM(order_total) AS total_amount')
    		 ->from('product_order')
    		  ->where('order_date', $currdate)
    	     ->where('status !=', '4')
    		 ->get()->row();
    	 }
    	 else
    	 {
    	      return $query = $this->db
    		 ->select('SUM(order_total) AS total_amount')
    		 ->from('product_order')
             ->where('order_date', $currdate)
    	     ->where('status !=', '4')
    		 ->where('franchise_id',$login_type)
    		 ->get()->row();
    		 
    	     
    	 }

 
		 //echo $this->db->last_query();exit();
           
      }
      
/****************************** Today ORder List    **************/


function today_order_count()
{  
     $currdate = date('d-m-Y');
  	 $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {     
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	 ->where('p.order_date', $currdate)
    	 ->where('p.status !=', '4')
    	->order_by("p.order_id","DESC")
    	->get();
	 }
	 else
	 {
	   
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where('p.franchise_id', $login_type)
    	 ->where('p.order_date', $currdate)
    	 ->where('p.status !=', '4')
    	->order_by("p.order_id","DESC")
    	->get();
	     
	 }

    return $query->num_rows();  

}


function today_order_list($limit,$start,$col,$dir)
{ 
   $currdate = date('d-m-Y');
    $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 { 
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	 ->where('p.order_date', $currdate)
    	 ->where('p.status !=', '4')
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
	 }
	 else
	 {
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where('p.franchise_id', $login_type)
    	 ->where('p.order_date', $currdate)
    	 ->where('p.status !=', '4')
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
    	
	 }

    if($query->num_rows()>0)
    {
        return $query->result(); 
    }
    else
    {
        return null;
    }
    
} 



function today_order_search($limit,$start,$search,$col,$dir)
{
    
    $currdate = date('d-m-Y');
    $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
         $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->or_like('c.first_name',$search)
    	->or_like('c.last_name',$search)
    	->or_like('p.order_generate_id',$search)
    	->or_like('p.order_total',$search)
        ->or_like('p.order_date',$search)
        ->or_like('f.franchise_name',$search)
        ->where('p.order_date', $currdate)
        ->where('p.status !=', '4')
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
	 }
	 else
	 {
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	
    	->or_like('c.first_name',$search)
    	->or_like('c.last_name',$search)
    	->or_like('p.order_generate_id',$search)
    	->or_like('p.order_total',$search)
        ->or_like('p.order_date',$search)
        ->or_like('f.franchise_name',$search)
        ->where('p.order_date', $currdate)
        ->where('p.franchise_id', $login_type)
        ->where('p.status !=', '4')
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get(); 
	     
	 }

    if($query->num_rows()>0)
    {
        return $query->result();  
    }
    else
    {
        return null;
    }
}


    function today_order_search_count($search)
    {
        
        
    $currdate = date('d-m-Y');
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
         $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
        	->from('product_order p')
        	->join('customer c', 'p.customer_id = c.customer_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->or_like('c.first_name',$search)
        	->or_like('c.last_name',$search)
        	->or_like('p.order_generate_id',$search)
        	->or_like('p.order_total',$search)
            ->or_like('p.order_date',$search)
            ->or_like('f.franchise_name',$search)
            ->where('p.order_date', $currdate)
            ->where('p.status !=', '4')
            ->order_by("p.order_id","DESC")
        	->get();
	 }
	 else
	 {
	   
	   $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
        	->from('product_order p')
        	->join('customer c', 'p.customer_id = c.customer_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->or_like('c.first_name',$search)
        	->or_like('c.last_name',$search)
        	->or_like('p.order_generate_id',$search)
        	->or_like('p.order_total',$search)
            ->or_like('p.order_date',$search)
            ->or_like('f.franchise_name',$search)
            ->where('p.order_date', $currdate)
            ->where('p.franchise_id', $login_type)
            ->where('p.status !=', '4')
            ->order_by("p.order_id","DESC")
        	->get();
        	
	 }
    	
         return $query->num_rows();
        
        // echo $this->db->last_query();exit();
    }
    
    
    
  /****************************** Customer wise Ordser list   **************/  

  public function get_customer_wise_order_history_model($customer_id)
    {
          return $query = $this->db
    			 ->select('p.*,s.day,s.slot_timing')
    			 ->from('product_order p')
    			 ->join('slot_timing s', 'p.slot_id = s.slot_id','left')
    			 ->where('p.customer_id', $customer_id)
    			 ->get()->result();
    }
    
    
    
     public function get_order_wise_item_history_model($oid)
    {
          return $query = $this->db
    			 ->select('o.*,v.product_name,v.main_image')
    			 ->from('order_detail o')
    			 ->join('vegshopy_product v', 'o.product_id = v.product_id','left')
    			 ->where('o.order_id', $oid)
    			 ->get()->result();
    }
    
    
    
    
    
    
    
      /****************************** Order Summary   **************/  

  public function get_order_summary($oid)
    {
          return $query = $this->db
    			 ->select('*')
    			 ->from('product_order')
    			 ->where('order_id', $oid)
    			 ->get()->row();
    }
    
    
    
      public function get_order_record($order_id)
    {
          return $query = $this->db
    			 ->select('*')
    			 ->from('product_order')
    			 ->where('order_generate_id', $order_id)
    			 ->get()->row();
    }
    
    
    
     function get_subscribe_list_model($customer_id)
    {
          return $query = $this->db
    			 ->select('*')
    			 ->from('subscription ')
    			 ->where('customer_id', $customer_id)
    			 ->where('subscribe_status !=', '2')
    			 ->get()->result();
    }
    
     public function subscribe_product($subscribe_id)
    {
          return $query = $this->db
    			 ->select('o.*,v.product_name,v.main_image')
    			 ->from('subscribe_product o')
    			 ->join('vegshopy_product v', 'o.product_id = v.product_id','left')
    			 ->where('o.subscribe_id', $subscribe_id)
    			 ->where('o.subscribe_status !=', '2')
    			 ->get()->result_array();
    }
    
    
    
    /****************************** Total ORder List    **************/

function total_order_count()
{  
     $currdate = date('d-m-Y');
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->order_by("p.order_id","DESC")
    	->get();
	 }
	 else
	 {
	  
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where('p.franchise_id', $login_type)
    	->order_by("p.order_id","DESC")
    	->get();   
	 }

    return $query->num_rows();  

}


function total_order_list($limit,$start,$col,$dir)
{ 
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
	 }
	 else
	 {
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where('p.franchise_id', $login_type)
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get(); 
	     
	 }

    if($query->num_rows()>0)
    {
        return $query->result(); 
    }
    else
    {
        return null;
    }
    
} 



function total_order_search($limit,$start,$search,$col,$dir)
{
    
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
         $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->or_like('c.first_name',$search)
    	->or_like('c.last_name',$search)
    	->or_like('p.order_generate_id',$search)
    	->or_like('p.order_total',$search)
        ->or_like('p.order_date',$search)
        ->or_like('f.franchise_name',$search)
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
	 }
	 else
	 {
	    $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->or_like('c.first_name',$search)
    	->or_like('c.last_name',$search)
    	->or_like('p.order_generate_id',$search)
    	->or_like('p.order_total',$search)
        ->or_like('p.order_date',$search)
        ->or_like('f.franchise_name',$search)
        ->where('p.franchise_id', $login_type)
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
	     
	 }

    if($query->num_rows()>0)
    {
        return $query->result();  
    }
    else
    {
        return null;
    }
}


    function total_order_search_count($search)
    {
        
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {    

    	    $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
        	->from('product_order p')
        	->join('customer c', 'p.customer_id = c.customer_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->or_like('c.first_name',$search)
        	->or_like('c.last_name',$search)
        	->or_like('p.order_generate_id',$search)
        	->or_like('p.order_total',$search)
            ->or_like('p.order_date',$search)
            ->or_like('f.franchise_name',$search)
            
            ->order_by("p.order_id","DESC")
        	->get();
	 }
	 
	 else
	 {
    	    $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
        	->from('product_order p')
        	->join('customer c', 'p.customer_id = c.customer_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->or_like('c.first_name',$search)
        	->or_like('c.last_name',$search)
        	->or_like('p.order_generate_id',$search)
        	->or_like('p.order_total',$search)
            ->or_like('p.order_date',$search)
            ->or_like('f.franchise_name',$search)
            ->where('p.franchise_id', $login_type)
            ->order_by("p.order_id","DESC")
        	->get();
	     
	 }
    	
         return $query->num_rows();
        
        // echo $this->db->last_query();exit();
    }
    
    
        
     /*********************************** Pending count *************************************
     ******************************************************************************************************/
      public function get_pending_count_model()
      {
        
         $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {  
             return $query = $this->db
    		 ->select('count(order_id) AS pending_count')
    		 ->from('product_order')
    		 ->where('status','0')
    		 ->get()->row();
    	 }
    	 else
    	 {
    	      return $query = $this->db
    		 ->select('count(order_id) AS pending_count')
    		 ->from('product_order')
    		  ->where('status','0')
    		 ->where('franchise_id',$login_type)
    		 ->get()->row();
    		 
    	     
    	 }

 
		 //echo $this->db->last_query();exit();
           
      }
      
     /*********************************** Assign count *************************************
     ******************************************************************************************************/
      public function get_assign_count_model()
      {
        $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {  
             return $query = $this->db
    		 ->select('count(order_id) AS assign_count')
    		 ->from('product_order')
    		 ->get()->row();
    	 }
    	 else
    	 {
    	      return $query = $this->db
    		 ->select('count(order_id) AS assign_count')
    		 ->from('product_order')
             ->where('assign_to !=','')
    		 ->where('franchise_id',$login_type)
    		 ->get()->row();
    		 
    	     
    	 }

 
		 //echo $this->db->last_query();exit();
           
      }
      

      
    /*********************************** Delivered count *************************************
     ******************************************************************************************************/
      public function get_delivered_count_model()
      {
          
          
        $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {  
             return $query = $this->db
    		 ->select('count(order_id) AS delivered_count')
    		 ->from('product_order')
    		  ->where('status','3')
    		 ->get()->row();
    	 }
    	 else
    	 {
    	      return $query = $this->db
    		 ->select('count(order_id) AS delivered_count')
    		 ->from('product_order')
             ->where('status','3')
    		 ->where('franchise_id',$login_type)
    		 ->get()->row();
    		 
    	     
    	 }

 
		 //echo $this->db->last_query();exit();
           
      }
      
      
       /*********************************** Dispatch count *************************************
     ******************************************************************************************************/
      public function get_dispatch_count_model()
      {
          
          
        $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {  
             return $query = $this->db
    		 ->select('count(order_id) AS dispatch_count')
    		 ->from('product_order')
    		  ->where('status','2')
    		 ->get()->row();
    	 }
    	 else
    	 {
    	      return $query = $this->db
    		 ->select('count(order_id) AS dispatch_count')
    		 ->from('product_order')
             ->where('status','2')
    		 ->where('franchise_id',$login_type)
    		 ->get()->row();
    		 
    	     
    	 }

 
		 //echo $this->db->last_query();exit();
           
      }
      
      
          /*********************************** Delivered count *************************************
     ******************************************************************************************************/
      public function get_not_delivered_count_model()
      {
          
        $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {  
             return $query = $this->db
    		 ->select('count(order_id) AS not_delivered_count')
    		 ->from('product_order')
    		 ->where('status','0')
		     ->where('assign_to !=','')
		     ->like('order_date', date('m-Y'))
    		 ->get()->row();
    	 }
    	 else
    	 {
    	      return $query = $this->db
    		 ->select('count(order_id) AS not_delivered_count')
    		 ->from('product_order')
             ->where('status','0')
		     ->where('assign_to !=','')
		     ->like('order_date', date('m-Y'))
    		 ->where('franchise_id',$login_type)
    		 ->get()->row();
    		 
    	     
    	 } 

		 //echo $this->db->last_query();exit();
           
      }
      
          /*********************************** Cancel count *************************************
     ******************************************************************************************************/
      public function get_cancel_count_model()
      {
         
        $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {  
             return $query = $this->db
    		 ->select('count(order_id) AS cancel_count')
    		 ->from('product_order')
    		 ->where('status','4')
		     ->like('order_date', date('m-Y'))
    		 ->get()->row();
    	 }
    	 else
    	 {
    	      return $query = $this->db
    		 ->select('count(order_id) AS cancel_count')
    		 ->from('product_order')
             ->where('status','4')
		     ->where('payment_status','1')
    		 ->where('franchise_id',$login_type)
    		 ->get()->row();
    		 
    	     
    	 } 

		 //echo $this->db->last_query();exit();
           
      }
      
      
      
      public function get_cancel_count_model1()
      {
         
        $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {  
             return $query = $this->db
    		 ->select('count(order_id) AS cancel_count')
    		 ->from('product_order')
    		 ->where('status','4')
		     ->where('payment_status','0')
    		 ->get()->row();
    	 }
    	 else
    	 {
    	      return $query = $this->db
    		 ->select('count(order_id) AS cancel_count')
    		 ->from('product_order')
             ->where('status','4')
		     ->where('payment_status','0')
    		 ->where('franchise_id',$login_type)
    		 ->get()->row();
    		 
    	     
    	 } 

		 //echo $this->db->last_query();exit();
           
      }
      
    /*********************************** Total count *************************************
     ******************************************************************************************************/
      public function get_total_count_model()
      {
        
         $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {  
             return $query = $this->db
    		 ->select('count(order_id) AS total_count')
    		 ->from('product_order')
    		 ->get()->row();
    	 }
    	 else
    	 {
    	      return $query = $this->db
    		 ->select('count(order_id) AS total_count')
    		 ->from('product_order')
    		 ->where('franchise_id',$login_type)
    		 ->get()->row();
    		 
    	     
    	 }
 
		// echo $this->db->last_query();exit();
           
      }
      
            
          /*********************************** Today count *************************************
     ******************************************************************************************************/
      public function get_today_count_model()
      {
        $currdate = date('d-m-Y'); 
        $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {  
             return $query = $this->db
    		 ->select('count(order_id) AS today_count')
    		 ->from('product_order')
    		 ->where('status !=','4')
    		 ->where('order_date',$currdate)
    		 ->get()->row();
    	 }
    	 else
    	 {
    	      return $query = $this->db
    		 ->select('count(order_id) AS today_count')
    		 ->from('product_order')
    		 ->where('status !=','4')
    		 ->where('order_date', $currdate)
    		 ->where('franchise_id',$login_type)
    		 ->get()->row();
    		 
    	     
    	 }

 
		 //echo $this->db->last_query();exit();
           
      }
      
      
        /****************************** Assign wise Ordser list   **************/  

  public function get_assign_product($db_id)
    {
        $date = date('m/d/Y');
          return $query = $this->db
    			 ->select('p.*,s.day,s.slot_timing,c.first_name,c.last_name,c.mobile_no')
    			 ->from('product_order p')
    			 ->join('customer c', 'p.customer_id = c.customer_id','left')
    			 ->join('slot_timing s', 'p.slot_id = s.slot_id','left')
    			 ->where('p.assign_to', $db_id)
    			 ->where('p.status', '0')
    			 //->where('p.assign_date', $date)
    			 ->get()->result();
    			 
    			 	 //echo $this->db->last_query();exit();
    }
    
    
            /****************************** Complete wise Ordser list   **************/  

  public function get_complete_product($db_id)
    {
          return $query = $this->db
    			 ->select('p.*,s.day,s.slot_timing,c.first_name,c.last_name,c.mobile_no')
    			 ->from('product_order p')
    			 ->join('customer c', 'p.customer_id = c.customer_id','left')
    			 ->join('slot_timing s', 'p.slot_id = s.slot_id','left')
    			 ->where('p.assign_to', $db_id)

    			 ->get()->result();
    			 
    			 	 //echo $this->db->last_query();exit();
    }
    
  public function get_delevered_product($db_id,$from_date,$to_date)
    {
        if($from_date == '' && $to_date == '')
	    {
          return $query = $this->db
    			 ->select('p.*,s.day,s.slot_timing,c.first_name,c.last_name,c.mobile_no')
    			 ->from('product_order p')
    			 ->join('customer c', 'p.customer_id = c.customer_id','left')
    			 ->join('slot_timing s', 'p.slot_id = s.slot_id','left')
    			 ->where('p.assign_to', $db_id)
    			 ->where('p.status', '3')
                 ->like('p.order_date', date('m-Y'))
    			 ->get()->result();
	    }
	    else
	    {
	             $newDate = date("d-m-Y", strtotime($from_date));
                 $newDate1 = date("d-m-Y", strtotime($to_date));
                 
                 $condition = "p.assign_to = $db_id AND p.status = '3' AND (p.order_date BETWEEN '$newDate'  AND '$newDate1') "; 
                 return $query = $this->db
    			 ->select('p.*,s.day,s.slot_timing,c.first_name,c.last_name,c.mobile_no')
    			 ->from('product_order p')
    			 ->join('customer c', 'p.customer_id = c.customer_id','left')
    			 ->join('slot_timing s', 'p.slot_id = s.slot_id','left')
                  ->where($condition)
    			 ->get()->result();
	        
	    }
    			 
    			 	 //echo $this->db->last_query();exit();
    }
    
    
    public function get_cancel_product($db_id,$from_date,$to_date)
    {
        if($from_date == '' && $to_date == '')
	    {
          return $query = $this->db
    			 ->select('p.*,s.day,s.slot_timing,c.first_name,c.last_name,c.mobile_no')
    			 ->from('product_order p')
    			 ->join('customer c', 'p.customer_id = c.customer_id','left')
    			 ->join('slot_timing s', 'p.slot_id = s.slot_id','left')
    			 ->where('p.assign_to', $db_id)
    			 ->where('p.status', '4')
                 ->like('p.order_date', date('m-Y'))
    			 ->get()->result();
	    }
	    else
	    {
	         $newDate = date("d-m-Y", strtotime($from_date));
                  $newDate1 = date("d-m-Y", strtotime($to_date));
                 $condition = "p.assign_to = $db_id AND p.status = '4' AND (p.order_date BETWEEN '$newDate'  AND '$newDate1') "; 
                 return $query = $this->db
    			 ->select('p.*,s.day,s.slot_timing,c.first_name,c.last_name,c.mobile_no')
    			 ->from('product_order p')
    			 ->join('customer c', 'p.customer_id = c.customer_id','left')
    			 ->join('slot_timing s', 'p.slot_id = s.slot_id','left')
                  ->where($condition)
    			 ->get()->result();
	        
	    }
    			 
    			 	 //echo $this->db->last_query();exit();
    }
    
    public function get_pending_product($db_id)
    {
          return $query = $this->db
    			 ->select('p.*,s.day,s.slot_timing,c.first_name,c.last_name,c.mobile_no')
    			 ->from('product_order p')
    			 ->join('customer c', 'p.customer_id = c.customer_id','left')
    			 ->join('slot_timing s', 'p.slot_id = s.slot_id','left')
    			 ->where('p.assign_to', $db_id)
    			 ->where('p.status', '0')

    			 ->get()->result();
    			 
    			 //echo $this->db->last_query();exit();
    }
    
    
    
    public function get_dispatch_product($db_id)
    {
          return $query = $this->db
    			 ->select('p.*,s.day,s.slot_timing,c.first_name,c.last_name,c.mobile_no')
    			 ->from('product_order p')
    			 ->join('customer c', 'p.customer_id = c.customer_id','left')
    			 ->join('slot_timing s', 'p.slot_id = s.slot_id','left')
    			 ->where('p.assign_to', $db_id)
    			 ->where('p.status', '2')

    			 ->get()->result();
    			 
    			 //echo $this->db->last_query();exit();
    }
    
    

    
    
      public function get_total_amount($db_id)
    {
          return $query = $this->db
    			 ->select('SUM(order_total) AS total_amount')
    			 ->from('product_order')
    			 ->where('assign_to', $db_id)
    			 ->where('status', '3')
    			 ->where('p_mode', '0')

    			 ->get()->row();
    			 
    			 	 //echo $this->db->last_query();exit();
    }
    
    
    
    /****************************** Pending ORder List    **************/

function pending_order_count()
{  
    $currdate = date('d-m-Y');
    $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {  
	   	$query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where('p.status', '0')
    	->order_by("p.order_id","DESC")
    	->get();
	 }
	 else
	 {
	   	$query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where('p.status', '0')
    	 ->where('p.franchise_id', $login_type)
    	->order_by("p.order_id","DESC")
    	->get();
	 }

    return $query->num_rows();  

}


function pending_order_list($limit,$start,$col,$dir)
{ 

     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
	   	$query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where('p.status', '0')
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
	 }
	 else
	 {
	   	$query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where('p.status', '0')
    	 ->where('p.franchise_id', $login_type)
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
	     
	 }

    if($query->num_rows()>0)
    {
        return $query->result(); 
    }
    else
    {
        return null;
    }
    
} 



function pending_order_search($limit,$start,$search,$col,$dir)
{
    
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
	   	$query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->or_like('c.first_name',$search)
    	->or_like('c.last_name',$search)
    	->or_like('p.order_generate_id',$search)
    	->or_like('p.order_total',$search)
        ->or_like('p.order_date',$search)
        ->or_like('f.franchise_name',$search)
        ->where('p.status', '0')
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
	 }
	 else
	 {
	     
	   	$query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->or_like('c.first_name',$search)
    	->or_like('c.last_name',$search)
    	->or_like('p.order_generate_id',$search)
    	->or_like('p.order_total',$search)
        ->or_like('p.order_date',$search)
        ->or_like('f.franchise_name',$search)
        ->where('p.status', '0')
         ->where('p.franchise_id', $login_type)
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
    	
	 }

    if($query->num_rows()>0)
    {
        return $query->result();  
    }
    else
    {
        return null;
    }
}


    function pending_order_search_count($search)
    {
        
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {   

	   	$query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
        	->from('product_order p')
        	->join('customer c', 'p.customer_id = c.customer_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->or_like('c.first_name',$search)
        	->or_like('c.last_name',$search)
        	->or_like('p.order_generate_id',$search)
        	->or_like('p.order_total',$search)
            ->or_like('p.order_date',$search)
            ->or_like('f.franchise_name',$search)
            ->where('p.status', '0')
            ->order_by("p.order_id","DESC")
        	->get();
	 }
	 
	 else
	 {
	     
	   	$query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
        	->from('product_order p')
        	->join('customer c', 'p.customer_id = c.customer_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->or_like('c.first_name',$search)
        	->or_like('c.last_name',$search)
        	->or_like('p.order_generate_id',$search)
        	->or_like('p.order_total',$search)
            ->or_like('p.order_date',$search)
            ->or_like('f.franchise_name',$search)
            ->where('p.status', '0')
            ->where('p.franchise_id', $login_type)
            ->order_by("p.order_id","DESC")
        	->get();
	 }
    	
         return $query->num_rows();
        
        // echo $this->db->last_query();exit();
    } 
    
    
    
    
        /****************************** Dispatch ORder List    **************/

function dispatch_order_count()
{  
     $currdate = date('d-m-Y');
       	$query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->where('p.status', '2')
    	->order_by("p.order_id","DESC")
    	->get();

    return $query->num_rows();  

}


function dispatch_order_list($limit,$start,$col,$dir)
{ 

     $query = $this->db
	->select('p.*,c.first_name,c.last_name,c.mobile_no')
	->from('product_order p')
	->join('customer c', 'p.customer_id = c.customer_id','left')
	->where('p.status', '2')
    ->order_by("p.order_id","DESC")
    ->limit($limit,$start)
	->get();

    if($query->num_rows()>0)
    {
        return $query->result(); 
    }
    else
    {
        return null;
    }
    
} 



function dispatch_order_search($limit,$start,$search,$col,$dir)
{
    

     $query = $this->db
	->select('p.*,c.first_name,c.last_name,c.mobile_no')
	->from('product_order p')
	->join('customer c', 'p.customer_id = c.customer_id','left')
	
    ->or_like('c.first_name',$search)
    ->or_like('c.last_name',$search)
    ->or_like('c.mobile_no',$search)
    ->or_like('p.order_date',$search)
    ->where('p.status', '2')
    ->order_by("p.order_id","DESC")
    ->limit($limit,$start)
	->get();

    if($query->num_rows()>0)
    {
        return $query->result();  
    }
    else
    {
        return null;
    }
}


    function dispatch_order_search_count($search)
    {
        
        

     $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
        ->or_like('c.first_name',$search)
        ->or_like('c.last_name',$search)
        ->or_like('c.mobile_no',$search)
        ->or_like('p.order_date',$search)
        ->where('p.status', '2')
        ->order_by("p.order_id","DESC")
    	->get();
    	
         return $query->num_rows();
        
        // echo $this->db->last_query();exit();
    } 
    
    
    
            /****************************** Delivered ORder List    **************/

function deliver_order_count()
{  
     $currdate = date('d-m-Y');
    $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 { 
       	$query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where('status="3"')
    	->order_by("p.order_id","DESC")
    	->get();
	 }
	 else
	 {
	  
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where('p.franchise_id', $login_type)
        ->where('status="3"')
    	->order_by("p.order_id","DESC")
    	->get();
    	
	 } 

    return $query->num_rows();  

}


function deliver_order_list($limit,$start,$col,$dir)
{ 
  
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 { 
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        ->where('status="3"')
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
	 }
	 else
	 {
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where('p.franchise_id', $login_type)
    	->where('status="3"')
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get(); 
	     
	 }

    if($query->num_rows()>0)
    {
        return $query->result(); 
    }
    else
    {
        return null;
    }
    
} 



function deliver_order_search($limit,$start,$search,$col,$dir)
{
    
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
         $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->or_like('c.first_name',$search)
    	->or_like('c.last_name',$search)
    	->or_like('p.order_generate_id',$search)
    	->or_like('p.order_total',$search)
        ->or_like('p.order_date',$search)
        ->or_like('f.franchise_name',$search)
        ->where('status="3"')
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
	 }
	 else
	 {
	    
	  $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->or_like('c.first_name',$search)
    	->or_like('c.last_name',$search)
    	->or_like('p.order_generate_id',$search)
    	->or_like('p.order_total',$search)
        ->or_like('p.order_date',$search)
        ->or_like('f.franchise_name',$search)
        ->where('p.franchise_id', $login_type)
        ->where('status="3"')
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
    	
	 }

    if($query->num_rows()>0)
    {
        return $query->result();  
    }
    else
    {
        return null;
    }
}


    function deliver_order_search_count($search)
    {
        
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {    

	  $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->or_like('c.first_name',$search)
        	->or_like('c.last_name',$search)
        	->or_like('p.order_generate_id',$search)
        	->or_like('p.order_total',$search)
            ->or_like('p.order_date',$search)
            ->or_like('f.franchise_name',$search)
    		 ->where('status="3"')
            ->order_by("p.order_id","DESC")
        	->get();
	 }
	 else
	 {
	     
	  $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->or_like('c.first_name',$search)
        	->or_like('c.last_name',$search)
        	->or_like('p.order_generate_id',$search)
        	->or_like('p.order_total',$search)
            ->or_like('p.order_date',$search)
            ->or_like('f.franchise_name',$search)
            ->where('p.franchise_id', $login_type)
    		->where('status="3"')
            ->order_by("p.order_id","DESC")
        	->get(); 
	 }
    	
         return $query->num_rows();
        
        // echo $this->db->last_query();exit();
    } 
    
    
 /****************************** Cancel ORder List    **************/

function cancel_order_count()
{ 
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
	     
      $currdate = date('d-m-Y');
	  $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->where('p.status', '4')
        	->where('p.payment_status =', '1')
        	->order_by("p.order_id","DESC")
        	->get();
	 }
	 else
	 {
	   $currdate = date('d-m-Y');
	  $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
        	->from('product_order p')
        	->join('customer c', 'p.customer_id = c.customer_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->where('p.status', '4')
        	->where('p.payment_status =', '1')
        	->where('p.franchise_id', $login_type)
        	->order_by("p.order_id","DESC")
        	->get();
        	
	     
	 }

    return $query->num_rows();  

}


function cancel_order_list($limit,$start,$col,$dir)
{ 
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
	  $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
        	->from('product_order p')
        	->join('customer c', 'p.customer_id = c.customer_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where('p.status', '4')
    	->where('p.payment_status =', '1')
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
    	
	 }
	 else
	 {
	     
	  $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
        	->from('product_order p')
        	->join('customer c', 'p.customer_id = c.customer_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where('p.status', '4')
    	->where('p.payment_status =', '1')
    	->where('p.franchise_id', $login_type)
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
    	
	 }

    if($query->num_rows()>0)
    {
        return $query->result(); 
    }
    else
    {
        return null;
    }
    
} 



function cancel_order_search($limit,$start,$search,$col,$dir)
{
    
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
	  $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
        	->from('product_order p')
        	->join('customer c', 'p.customer_id = c.customer_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->or_like('c.first_name',$search)
    	->or_like('c.last_name',$search)
    	->or_like('p.order_generate_id',$search)
    	->or_like('p.order_total',$search)
        ->or_like('p.order_date',$search)
        ->or_like('f.franchise_name',$search)
        ->where('p.status', '4')
        ->where('p.payment_status =', '1')
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
	 }
	 else
	 {
	   
	  $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
        	->from('product_order p')
        	->join('customer c', 'p.customer_id = c.customer_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->or_like('c.first_name',$search)
    	->or_like('c.last_name',$search)
    	->or_like('p.order_generate_id',$search)
    	->or_like('p.order_total',$search)
        ->or_like('p.order_date',$search)
        ->or_like('f.franchise_name',$search)
        ->where('p.status', '4')
        ->where('p.payment_status =', '1')
        ->where('p.franchise_id', $login_type)
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
    	
	 }

    if($query->num_rows()>0)
    {
        return $query->result();  
    }
    else
    {
        return null;
    }
}


    function cancel_order_search_count($search)
    {
        
        
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
	  $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
        	->from('product_order p')
        	->join('customer c', 'p.customer_id = c.customer_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->or_like('c.first_name',$search)
        	->or_like('c.last_name',$search)
        	->or_like('p.order_generate_id',$search)
        	->or_like('p.order_total',$search)
            ->or_like('p.order_date',$search)
            ->or_like('f.franchise_name',$search)
            ->where('p.status', '4')
            ->where('p.payment_status =', '1')
            ->order_by("p.order_id","DESC")
        	->get();
	 }
	 else
	 {
	  
	  $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
        	->from('product_order p')
        	->join('customer c', 'p.customer_id = c.customer_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->or_like('c.first_name',$search)
        	->or_like('c.last_name',$search)
        	->or_like('p.order_generate_id',$search)
        	->or_like('p.order_total',$search)
            ->or_like('p.order_date',$search)
            ->or_like('f.franchise_name',$search)
            ->where('p.status', '4')
            ->where('p.payment_status =', '1')
             ->where('p.franchise_id', $login_type)
            ->order_by("p.order_id","DESC")
        	->get();
        	
	 }
    	
         return $query->num_rows();
        
        // echo $this->db->last_query();exit();
    }  
    
    
    /*********************************** Recend order *************************************
     ******************************************************************************************************/
      public function get_recent_order_model()
      {
         return $query = $this->db
		 ->select('p.*,c.first_name,c.last_name')
		 ->from('product_order p')
		 ->join('customer c', 'p.customer_id = c.customer_id','left')
		->limit(5)
		 ->get()->result();
 
		 //echo $this->db->last_query();exit();
           
      }
      
                /***********************************  count *************************************
     ******************************************************************************************************/
      public function count_product($order_id)
      {
         return $query = $this->db
		 ->select('count(order_d_id) AS total_count')
		 ->from('order_detail')
		 ->where('order_id',$order_id)
		 ->get()->row();
 
		 //echo $this->db->last_query();exit();
           
      }
      
      
    /****************************** Total Subscription List    **************/

function supscription_count()
{  
    $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
       	$query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('subscription p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
     	->order_by("p.subscribe_id","DESC")
    	->get();
	 }
	 else
	 {
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('subscription p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where('p.franchise_id',$login_type)
     	->order_by("p.subscribe_id","DESC")
    	->get();
    	
	     
	 }

    return $query->num_rows();  

}


function supscription_list($limit,$start,$col,$dir)
{ 
     
    $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
        $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('subscription p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        ->order_by("p.subscribe_id","DESC")
        ->limit($limit,$start)
    	->get();

        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
	 }
	 else
	 {
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('subscription p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where('p.franchise_id',$login_type)
        ->order_by("p.subscribe_id","DESC")
        ->limit($limit,$start)
    	->get();

        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
	     
	 }
    
} 



function supscription_search($limit,$start,$search,$col,$dir)
{
    
    $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
        $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('subscription p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        ->or_like('p.subscribe_mode',$search)
        ->order_by("p.subscribe_id","DESC")
        ->limit($limit,$start)
    	->get();
    
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
	 }
	 else
	 {
	     
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('subscription p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->or_like('c.first_name',$search)
    	->or_like('c.last_name',$search)
    	->or_like('c.mobile_no',$search)
    	->or_like('p.total_day',$search)
    	->or_like('p.from_date',$search)
        ->or_like('p.subscribe_mode',$search)
        ->where('p.franchise_id',$login_type)
        ->order_by("p.subscribe_id","DESC")
        ->limit($limit,$start)
    	->get();
    
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
        
	     
	 }
}


    function supscription_search_count($search)
    {
        
    $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
        $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('subscription p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->or_like('c.first_name',$search)
    	->or_like('c.last_name',$search)
    	->or_like('c.mobile_no',$search)
    	->or_like('p.total_day',$search)
    	->or_like('p.from_date',$search)
        ->or_like('p.subscribe_mode',$search)
        ->order_by("p.subscribe_id","DESC")
    	->get();
	 }
	 else
	 {
	            $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('subscription p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->or_like('c.first_name',$search)
    	->or_like('c.last_name',$search)
    	->or_like('c.mobile_no',$search)
    	->or_like('p.total_day',$search)
    	->or_like('p.from_date',$search)
        ->or_like('p.subscribe_mode',$search)
        ->where('p.franchise_id',$login_type)
        ->order_by("p.subscribe_id","DESC")
    	->get();
	     
	 }
    	
         return $query->num_rows();
        
        // echo $this->db->last_query();exit();
    }      
    
    
        /****************************** Today Subscription List    **************/

function today_supscription_count()
{  
    $currdate = date('d-m-Y');
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
       	$query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('subscription p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where('p.s_date', $currdate)
    	->order_by("p.subscribe_id","DESC")
    	->get();
    	
	 }
	 else
	 {
	   
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('subscription p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where('p.s_date', $currdate)
    	->where('p.franchise_id', $login_type)
    	->order_by("p.subscribe_id","DESC")
    	->get();
    	
	 }

    return $query->num_rows();  

}


function today_supscription_list($limit,$start,$col,$dir)
{ 
$currdate = date('d-m-Y');
    $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('subscription p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where('p.s_date', $currdate)
        ->order_by("p.subscribe_id","DESC")
        ->limit($limit,$start)
    	->get();
    
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
	 }
	 else
	 {
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('subscription p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where('p.s_date', $currdate)
    	->where('p.franchise_id', $login_type)
        ->order_by("p.subscribe_id","DESC")
        ->limit($limit,$start)
    	->get();
    
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        } 
	 }
    
} 



function today_supscription_search($limit,$start,$search,$col,$dir)
{
    $currdate = date('d-m-Y');
    $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('subscription p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->or_like('c.first_name',$search)
    	->or_like('c.last_name',$search)
    	->or_like('c.mobile_no',$search)
    	->or_like('p.total_day',$search)
    	->or_like('p.from_date',$search)
    	->or_like('p.to_date',$search)
        ->or_like('p.subscribe_mode',$search)
        ->or_like('f.franchise_name',$search)
        ->where('p.s_date', $currdate)
        ->order_by("p.subscribe_id","DESC")
        ->limit($limit,$start)
    	->get();
    
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
	 }
	 else
	 {
	    $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('subscription p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->or_like('c.first_name',$search)
    	->or_like('c.last_name',$search)
    	->or_like('c.mobile_no',$search)
    	->or_like('p.total_day',$search)
    	->or_like('p.from_date',$search)
    	->or_like('p.to_date',$search)
        ->or_like('p.subscribe_mode',$search)
        ->or_like('f.franchise_name',$search)
        ->where('p.s_date', $currdate)
        ->where('p.franchise_id', $login_type)
        ->order_by("p.subscribe_id","DESC")
        ->limit($limit,$start)
    	->get();
    
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
	     
	 }
}


    function today_supscription_search_count($search)
    {
        
        $currdate = date('d-m-Y');
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
	    $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('subscription p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->or_like('c.first_name',$search)
    	->or_like('c.last_name',$search)
    	->or_like('c.mobile_no',$search)
    	->or_like('p.total_day',$search)
    	->or_like('p.from_date',$search)
    	->or_like('p.to_date',$search)
            ->or_like('p.subscribe_mode',$search)
            ->or_like('f.franchise_name',$search)
            ->where('p.s_date', $currdate)
            ->order_by("p.subscribe_id","DESC")
        	->get();
	 }
	 else
	 {
	     	    $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('subscription p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->or_like('c.first_name',$search)
    	->or_like('c.last_name',$search)
    	->or_like('c.mobile_no',$search)
    	->or_like('p.total_day',$search)
    	->or_like('p.from_date',$search)
    	->or_like('p.to_date',$search)
            ->or_like('p.subscribe_mode',$search)
            ->or_like('f.franchise_name',$search)
            ->where('p.s_date', $currdate)
            ->where('p.franchise_id', $login_type)
            ->order_by("p.subscribe_id","DESC")
        	->get();
	     
	 }
    	
         return $query->num_rows();
        
        // echo $this->db->last_query();exit();
    }
    
    
    /****************************** Subscribe Summary   **************/  

  public function get_subscribe_summary($subscribe_id)
    {
          return $query = $this->db
    			 ->select('o.*,c.first_name,c.last_name,c.mobile_no,c.email_id')
    			 ->from('subscription o')
    			 ->join('customer c', 'o.customer_id = c.customer_id','left')
    			 ->where('o.subscribe_id', $subscribe_id)
    			 ->get()->row();
    }
    
    
    public function get_subscribeitem_details($subscribe_id)
    {
          return $query = $this->db
    			 ->select('o.*,c.product_name')
    			 ->from('subscribe_product o')
    			 ->join('vegshopy_product c', 'o.product_id = c.product_id','left')
    			 ->where('o.subscribe_id', $subscribe_id)
    			 ->get()->result();
    }
    
    
    
        /****************************** Active Subscription List    **************/

    function active_supscription_count()
    {  
        $currdate = date('Y-m-d');
        $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {
           	$query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,v.product_name,s.day,s.subscribe_mode,s.subscribe_generate_id,s.subscribe_id,s.assign_to,f.franchise_name')
        	->from('subscribe_product p')
        	->join('subscription s', 'p.subscribe_id = s.subscribe_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->where('p.subscribe_status', '0')
        	->where("DATE_FORMAT(p.to_date,'%Y-%m-%d') >= ",$currdate)
        	->order_by("p.id","DESC")
        	->get();
    	 }
    	 else
    	 {
    	   
    	   	$query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,v.product_name,s.day,s.subscribe_mode,s.subscribe_generate_id,s.subscribe_id,s.assign_to,f.franchise_name')
        	->from('subscribe_product p')
        	->join('subscription s', 'p.subscribe_id = s.subscribe_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('franchise f', 's.franchise_id = f.franchise_id','left')
        	->where('p.subscribe_status', '0')
        	->where("DATE_FORMAT(p.to_date,'%Y-%m-%d') >= ",$currdate)
        	->where('p.franchise_id', $login_type)
        	->order_by("p.id","DESC")
        	->get();
        	
    	     
    	 }
    
       return $query->num_rows(); 
        
       //  echo $this->db->last_query();exit();
    
    }
        
function active_supscription_list($limit,$start,$col,$dir)
{ 
        $currdate = date('Y-m-d');
        $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {
           	$query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,v.product_name,s.day,s.subscribe_mode,s.subscribe_generate_id,s.subscribe_id,s.assign_to,f.franchise_name')
        	->from('subscribe_product p')
        	->join('subscription s', 'p.subscribe_id = s.subscribe_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->where('p.subscribe_status', '0')
        	->where("DATE_FORMAT(p.to_date,'%Y-%m-%d') >= ",$currdate)
        	->order_by("p.id","DESC")
            ->limit($limit,$start)
        	->get();
        
            if($query->num_rows()>0)
            {
                return $query->result(); 
            }
            else
            {
                return null;
            }
    	 }
    	 else
    	 {
    	   $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,v.product_name,s.day,s.subscribe_mode,s.subscribe_generate_id,s.subscribe_id,s.assign_to,f.franchise_name')
        	->from('subscribe_product p')
        	->join('subscription s', 'p.subscribe_id = s.subscribe_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->where('p.subscribe_status', '0')
        	->where("DATE_FORMAT(p.to_date,'%Y-%m-%d') >= ",$currdate)
        	->where('p.franchise_id',$login_type)
        	->order_by("p.id","DESC")
            ->limit($limit,$start)
        	->get();
        
            if($query->num_rows()>0)
            {
                return $query->result(); 
            }
            else
            {
                return null;
            }
    	     
    	 }
    
}


function active_supscription_search($limit,$start,$search,$col,$dir)
{
        $currdate = date('Y-m-d');
        $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {
           	$query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,v.product_name,s.day,s.subscribe_mode,s.subscribe_generate_id,s.subscribe_id,s.assign_to,f.franchise_name')
        	->from('subscribe_product p')
        	->join('subscription s', 'p.subscribe_id = s.subscribe_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->or_like('s.subscribe_generate_id',$search)
        	->or_like('f.franchise_name',$search)
        	->or_like('c.first_name',$search)
        	->or_like('c.mobile_no',$search)
        	->where('p.subscribe_status', '0')
        	->where("DATE_FORMAT(p.to_date,'%Y-%m-%d') >= ",$currdate)
        	->order_by("p.id","DESC")
            ->limit($limit,$start)
        	->get();
        
            if($query->num_rows()>0)
            {
                return $query->result();  
            }
            else
            {
                return null;
            }
    	 }
    	 else
    	 {
    	   $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,v.product_name,s.day,s.subscribe_mode,s.subscribe_generate_id,s.subscribe_id,s.assign_to,f.franchise_name')
        	->from('subscribe_product p')
        	->join('subscription s', 'p.subscribe_id = s.subscribe_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->or_like('s.subscribe_generate_id',$search)
        	->or_like('c.first_name',$search)
        	->or_like('c.mobile_no',$search)
        	->or_like('f.franchise_name',$search)
        	->where('p.subscribe_status', '0')
        	->where("DATE_FORMAT(p.to_date,'%Y-%m-%d') >= ",$currdate)
        	->where('p.franchise_id',$login_type)
        	->order_by("p.id","DESC")
            ->limit($limit,$start)
        	->get();
        
            if($query->num_rows()>0)
            {
                return $query->result();  
            }
            else
            {
                return null;
            }
    	     
    	 }
}


    function active_supscription_search_count($search)
    {
        
        $currdate = date('Y-m-d');
        $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {
           	$query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,v.product_name,s.day,s.subscribe_mode,s.subscribe_generate_id,s.subscribe_id,s.assign_to,f.franchise_name')
        	->from('subscribe_product p')
        	->join('subscription s', 'p.subscribe_id = s.subscribe_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->or_like('s.subscribe_generate_id',$search)
        	->or_like('c.first_name',$search)
        	->or_like('c.mobile_no',$search)
        	->or_like('f.franchise_name',$search)
        	->where('p.subscribe_status', '0')
        	->where("DATE_FORMAT(p.to_date,'%Y-%m-%d') >= ",$currdate)
        	->order_by("p.id","DESC")
    	    ->get();
    	 }
    	 else
    	 {
    	   $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,v.product_name,s.day,s.subscribe_mode,s.subscribe_generate_id,s.subscribe_id,s.assign_to,f.franchise_name')
        	->from('subscribe_product p')
        	->join('subscription s', 'p.subscribe_id = s.subscribe_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->or_like('s.subscribe_generate_id',$search)
        	->or_like('c.first_name',$search)
        	->or_like('c.mobile_no',$search)
        	->or_like('f.franchise_name',$search)
        	->where('p.subscribe_status', '0')
        	->where("DATE_FORMAT(p.to_date,'%Y-%m-%d') >= ",$currdate)
        	->where('p.franchise_id',$login_type)
        	->order_by("p.id","DESC")
    	    ->get();
    	     
    	 }
    	
         return $query->num_rows();
        
        // echo $this->db->last_query();exit();
    }
    
        /****************************** Pause Subscription List    **************/


    function pause_supscription_count()
    {  
        $currdate = date('Y-m-d');
         $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {
           	$query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,v.product_name,s.day,s.subscribe_mode,s.subscribe_generate_id,s.subscribe_id,s.assign_to,f.franchise_name')
        	->from('subscribe_product p')
        	->join('subscription s', 'p.subscribe_id = s.subscribe_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->where('p.subscribe_status', '1')
        	->where("DATE_FORMAT(p.to_date,'%Y-%m-%d') >= ",$currdate)
        	->order_by("p.id","DESC")
        	->get();
    	 }
    	 else
    	 {
    	     
    	   $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,v.product_name,s.day,s.subscribe_mode,s.subscribe_generate_id,s.subscribe_id,s.assign_to,f.franchise_name')
        	->from('subscribe_product p')
        	->join('subscription s', 'p.subscribe_id = s.subscribe_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->where('p.subscribe_status', '1')
        	->where("DATE_FORMAT(p.to_date,'%Y-%m-%d') >= ",$currdate)
        	->where('p.franchise_id',$login_type)
        	->order_by("p.id","DESC")
        	->get(); 
    	 }
    
       return $query->num_rows(); 
        
       //  echo $this->db->last_query();exit();
    
    }
        
function pause_supscription_list($limit,$start,$col,$dir)
{ 
        $currdate = date('Y-m-d');
         $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {
           	$query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,v.product_name,s.day,s.subscribe_mode,s.subscribe_generate_id,s.subscribe_id,s.assign_to,f.franchise_name')
        	->from('subscribe_product p')
        	->join('subscription s', 'p.subscribe_id = s.subscribe_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->where('p.subscribe_status', '1')
        	->where("DATE_FORMAT(p.to_date,'%Y-%m-%d') >= ",$currdate)
        	->order_by("p.id","DESC")
            ->limit($limit,$start)
        	->get();
        
            if($query->num_rows()>0)
            {
                return $query->result(); 
            }
            else
            {
                return null;
            }
    	 }
    	 else
    	 {
    	   $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,v.product_name,s.day,s.subscribe_mode,s.subscribe_generate_id,s.subscribe_id,s.assign_to,f.franchise_name')
        	->from('subscribe_product p')
        	->join('subscription s', 'p.subscribe_id = s.subscribe_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->where('p.subscribe_status', '1')
        	->where("DATE_FORMAT(p.to_date,'%Y-%m-%d') >= ",$currdate)
        	->where('p.franchise_id',$login_type)
        	->order_by("p.id","DESC")
            ->limit($limit,$start)
        	->get();
        
            if($query->num_rows()>0)
            {
                return $query->result(); 
            }
            else
            {
                return null;
            }
    	 }
    
}


function pause_supscription_search($limit,$start,$search,$col,$dir)
{
        $currdate = date('Y-m-d');
         $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {
           	$query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,v.product_name,s.day,s.subscribe_mode,s.subscribe_generate_id,s.subscribe_id,s.assign_to,f.franchise_name')
        	->from('subscribe_product p')
        	->join('subscription s', 'p.subscribe_id = s.subscribe_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->or_like('s.subscribe_generate_id',$search)
        	->or_like('c.first_name',$search)
        	->or_like('c.mobile_no',$search)
        	->or_like('f.franchise_name',$search)
        	->where('p.subscribe_status', '1')
        	->where("DATE_FORMAT(p.to_date,'%Y-%m-%d') >= ",$currdate)
        	->order_by("p.id","DESC")
            ->limit($limit,$start)
        	->get();
        
            if($query->num_rows()>0)
            {
                return $query->result();  
            }
            else
            {
                return null;
            }
    	 }
    	 else
    	 {
    	     
    	   $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,v.product_name,s.day,s.subscribe_mode,s.subscribe_generate_id,s.subscribe_id,s.assign_to,f.franchise_name')
        	->from('subscribe_product p')
        	->join('subscription s', 'p.subscribe_id = s.subscribe_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->or_like('s.subscribe_generate_id',$search)
        	->or_like('c.first_name',$search)
        	->or_like('c.mobile_no',$search)
        	->or_like('f.franchise_name',$search)
        	->where('p.subscribe_status', '1')
        	->where("DATE_FORMAT(p.to_date,'%Y-%m-%d') >= ",$currdate)
        	->where('p.franchise_id',$login_type)
        	->order_by("p.id","DESC")
            ->limit($limit,$start)
        	->get();
        
            if($query->num_rows()>0)
            {
                return $query->result();  
            }
            else
            {
                return null;
            }
            
    	 }
}


    function pause_supscription_search_count($search)
    {
        
        $currdate = date('Y-m-d');
         $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {
           	$query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,v.product_name,s.day,s.subscribe_mode,s.subscribe_generate_id,s.subscribe_id,s.assign_to,f.franchise_name')
        	->from('subscribe_product p')
        	->join('subscription s', 'p.subscribe_id = s.subscribe_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->or_like('s.subscribe_generate_id',$search)
        	->or_like('c.first_name',$search)
        	->or_like('c.mobile_no',$search)
        	->or_like('f.franchise_name',$search)
        	->where('p.subscribe_status', '1')
        	->where("DATE_FORMAT(p.to_date,'%Y-%m-%d') >= ",$currdate)
        	->order_by("p.id","DESC")
    	    ->get();
    	 }
    	 else
    	 {
    	   $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,v.product_name,s.day,s.subscribe_mode,s.subscribe_generate_id,s.subscribe_id,s.assign_to,f.franchise_name')
        	->from('subscribe_product p')
        	->join('subscription s', 'p.subscribe_id = s.subscribe_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->or_like('s.subscribe_generate_id',$search)
        	->or_like('c.first_name',$search)
        	->or_like('c.mobile_no',$search)
        	->or_like('f.franchise_name',$search)
        	->where('p.subscribe_status', '1')
        	->where("DATE_FORMAT(p.to_date,'%Y-%m-%d') >= ",$currdate)
        	->where('p.franchise_id',$login_type)
        	->order_by("p.id","DESC")
    	    ->get();
    	     
    	 }
    	
         return $query->num_rows();
        
        // echo $this->db->last_query();exit();
    } 
    
 /****************************** End Subscription List    **************/


    function end_supscription_count()
    {  
        $currdate = date('Y-m-d');
         $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {
           	$query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,v.product_name,s.day,s.subscribe_mode,s.subscribe_generate_id,s.subscribe_id,s.assign_to,f.franchise_name')
        	->from('subscribe_product p')
        	->join('subscription s', 'p.subscribe_id = s.subscribe_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->where('p.subscribe_status', '2')
        	->where("DATE_FORMAT(p.to_date,'%Y-%m-%d') >= ",$currdate)
        	->order_by("p.id","DESC")
        	->get();
    	 }
    	 else
    	 {
    	     
    	  $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,v.product_name,s.day,s.subscribe_mode,s.subscribe_generate_id,s.subscribe_id,s.assign_to,f.franchise_name')
        	->from('subscribe_product p')
        	->join('subscription s', 'p.subscribe_id = s.subscribe_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->where('p.subscribe_status', '2')
        	->where("DATE_FORMAT(p.to_date,'%Y-%m-%d') >= ",$currdate)
        	->where('p.franchise_id',$login_type)
        	->order_by("p.id","DESC")
        	->get();
    	 }
    
       return $query->num_rows(); 
        
       // echo $this->db->last_query();exit();
    
    }
        
function end_supscription_list($limit,$start,$col,$dir)
{ 
        $currdate = date('Y-m-d');
         $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {
           	$query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,v.product_name,s.day,s.subscribe_mode,s.subscribe_generate_id,s.subscribe_id,s.assign_to,f.franchise_name')
        	->from('subscribe_product p')
        	->join('subscription s', 'p.subscribe_id = s.subscribe_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->where('p.subscribe_status', '2')
        	->where("DATE_FORMAT(p.to_date,'%Y-%m-%d') >= ",$currdate)
        	->order_by("p.id","DESC")
            ->limit($limit,$start)
        	->get();
        
            if($query->num_rows()>0)
            {
                return $query->result(); 
            }
            else
            {
                return null;
            }
            
    	 }
    	 else
    	 {
    	   $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,v.product_name,s.day,s.subscribe_mode,s.subscribe_generate_id,s.subscribe_id,s.assign_to,f.franchise_name')
        	->from('subscribe_product p')
        	->join('subscription s', 'p.subscribe_id = s.subscribe_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->where('p.subscribe_status', '2')
        	->where("DATE_FORMAT(p.to_date,'%Y-%m-%d') >= ",$currdate)
        	->where('p.franchise_id',$login_type)
        	->order_by("p.id","DESC")
            ->limit($limit,$start)
        	->get();
        
            if($query->num_rows()>0)
            {
                return $query->result(); 
            }
            else
            {
                return null;
            }
    	     
    	 }
    
}


function end_supscription_search($limit,$start,$search,$col,$dir)
{
       $currdate = date('Y-m-d');
         $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {
           	$query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,v.product_name,s.day,s.subscribe_mode,s.subscribe_generate_id,s.subscribe_id,s.assign_to,f.franchise_name')
        	->from('subscribe_product p')
        	->join('subscription s', 'p.subscribe_id = s.subscribe_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->or_like('s.subscribe_generate_id',$search)
        	->or_like('c.first_name',$search)
        	->or_like('c.mobile_no',$search)
        	->or_like('f.franchise_name',$search)
        	->where('p.subscribe_status', '2')
        	->where("DATE_FORMAT(p.to_date,'%Y-%m-%d') >= ",$currdate)
        	->order_by("p.id","DESC")
            ->limit($limit,$start)
        	->get();
        
            if($query->num_rows()>0)
            {
                return $query->result();  
            }
            else
            {
                return null;
            }
    	 }
    	 else
    	 {
    	   $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,v.product_name,s.day,s.subscribe_mode,s.subscribe_generate_id,s.subscribe_id,s.assign_to,f.franchise_name')
        	->from('subscribe_product p')
        	->join('subscription s', 'p.subscribe_id = s.subscribe_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->or_like('s.subscribe_generate_id',$search)
        	->or_like('c.first_name',$search)
        	->or_like('c.mobile_no',$search)
        	->or_like('f.franchise_name',$search)
        	->where('p.subscribe_status', '2')
        	->where("DATE_FORMAT(p.to_date,'%Y-%m-%d') >= ",$currdate)
        	->where('p.franchise_id',$login_type)
        	->order_by("p.id","DESC")
            ->limit($limit,$start)
        	->get();
        
            if($query->num_rows()>0)
            {
                return $query->result();  
            }
            else
            {
                return null;
            }
    	     
    	 }
}


    function end_supscription_search_count($search)
    {
        
        $currdate = date('Y-m-d');
         $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {
           	$query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,v.product_name,s.day,s.subscribe_mode,s.subscribe_generate_id,s.subscribe_id,s.assign_to,f.franchise_name')
        	->from('subscribe_product p')
        	->join('subscription s', 'p.subscribe_id = s.subscribe_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->or_like('s.subscribe_generate_id',$search)
        	->or_like('c.first_name',$search)
        	->or_like('c.mobile_no',$search)
        	->or_like('f.franchise_name',$search)
         	->where('p.subscribe_status', '2')
         	->where("DATE_FORMAT(p.to_date,'%Y-%m-%d') >= ",$currdate)
        	->order_by("p.id","DESC")
    	    ->get();
    	 }
    	 else
    	 {
    	   $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,v.product_name,s.day,s.subscribe_mode,s.subscribe_generate_id,s.subscribe_id,s.assign_to,f.franchise_name')
        	->from('subscribe_product p')
        	->join('subscription s', 'p.subscribe_id = s.subscribe_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->or_like('s.subscribe_generate_id',$search)
        	->or_like('c.first_name',$search)
        	->or_like('c.mobile_no',$search)
        	->or_like('f.franchise_name',$search)
         	->where('p.subscribe_status', '2')
         	->where("DATE_FORMAT(p.to_date,'%Y-%m-%d') >= ",$currdate)
         	->where('p.franchise_id',$login_type)
        	->order_by("p.id","DESC")
    	    ->get(); 
    	     
    	 }
    	
         return $query->num_rows();
        
        // echo $this->db->last_query();exit();
    } 
    
    
    
 /****************************** Expire Subscription List    **************/

function expire_supscription_count()
{  
    $currdate = date('Y-m-d');
    $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
       	$query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('subscription p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where("DATE_FORMAT(p.to_date,'%Y-%m-%d') <",$currdate)
    	->order_by("p.subscribe_id","DESC")
      	->get();
	 }
	 else
	 {
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('subscription p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where("DATE_FORMAT(p.to_date,'%Y-%m-%d') <",$currdate)
    	->where('p.franchise_id',$login_type)
    	->order_by("p.subscribe_id","DESC")
      	->get();
	     
	 }

    return $query->num_rows();  

}


function expire_supscription_list($limit,$start,$col,$dir)
{ 
$currdate = date('Y-m-d');
    $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
       	$query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('subscription p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where("DATE_FORMAT(p.to_date,'%Y-%m-%d') <",$currdate)
        ->order_by("p.subscribe_id","DESC")
        ->limit($limit,$start)
    	->get();
    
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
        
	 }
	 else
	 {
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('subscription p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where("DATE_FORMAT(p.to_date,'%Y-%m-%d') <",$currdate)
    	->where('p.franchise_id',$login_type)
        ->order_by("p.subscribe_id","DESC")
        ->limit($limit,$start)
    	->get();
    
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
	     
	 }
    
} 



function expire_supscription_search($limit,$start,$search,$col,$dir)
{
    $currdate = date('Y-m-d');
    $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
       	$query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('subscription p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        ->or_like('p.subscribe_mode',$search)
        ->or_like('f.franchise_name',$search)
        ->where("DATE_FORMAT(p.to_date,'%Y-%m-%d') <",$currdate)
        ->order_by("p.subscribe_id","DESC")
        ->limit($limit,$start)
    	->get();
    
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
	 }
	 else
	 {
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('subscription p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        ->or_like('p.subscribe_mode',$search)
        ->or_like('f.franchise_name',$search)
        ->where("DATE_FORMAT(p.to_date,'%Y-%m-%d') <",$currdate)
        ->where('p.franchise_id',$login_type)
        ->order_by("p.subscribe_id","DESC")
        ->limit($limit,$start)
    	->get();
    
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
	     
	 }
}


    function expire_supscription_search_count($search)
    {
        
        $currdate = date('Y-m-d');

    $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
       	$query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('subscription p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        ->or_like('p.subscribe_mode',$search)
        ->or_like('f.franchise_name',$search)
        ->where("DATE_FORMAT(p.to_date,'%Y-%m-%d') <",$currdate)
        ->order_by("p.subscribe_id","DESC")
    	->get();
	 }
	 else
	 {
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('subscription p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        ->or_like('p.subscribe_mode',$search)
        ->where("DATE_FORMAT(p.to_date,'%Y-%m-%d') <",$currdate)
        ->where('p.franchise_id',$login_type)
        ->order_by("p.subscribe_id","DESC")
    	->get();
	     
	 }
    	
         return $query->num_rows();
        
        // echo $this->db->last_query();exit();
    } 
    
    
    /*********************************** SUM TOTAL *******************************************************
     ******************************************************************************************************/
      public function get_sum_total_model()
      {
          
         $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {  

             return $query = $this->db
    		 ->select('SUM(order_total) AS total_payment')
    		 ->from('product_order')
    		 ->where('status="3"')
    		 ->get()->row();
    		 
    	 }
    	 else
    	 {
    	   
    	   return $query = $this->db
    		 ->select('SUM(order_total) AS total_payment')
    		 ->from('product_order')
    		 ->where('franchise_id',$login_type)
              ->where('status="3"')
    		 ->get()->row();
    		 
    	 }
 
		 //echo $this->db->last_query();exit();
           
      }
      
          
    /*********************************** SUM CASH TOTAL ***************************************************
     ******************************************************************************************************/
      public function get_sum_cash_model()
      {
          
        $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {

             return $query = $this->db
    		 ->select('SUM(order_total) AS cash_payment')
    		 ->from('product_order')
    		 ->where('status','3')
    		 ->where('p_mode','0')
    		 ->where('payment_status','1')
    		 ->get()->row();
    	 }
    	 else
    	 {
    	             return $query = $this->db
    		 ->select('SUM(order_total) AS cash_payment')
    		 ->from('product_order')
    		 ->where('status','3')
    		 ->where('p_mode','0')
    		 ->where('payment_status','1')
    		 ->where('franchise_id',$login_type)
    		 ->get()->row();
    	     
    	 }
 
		 //echo $this->db->last_query();exit();
           
      }
      
      public function get_today_cash_model()
      {
         $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {    
         $currdate = date('d-m-Y');
         return $query = $this->db
		 ->select('SUM(w.credit) AS cash_payment')
		 ->from('db_wallet_history w')
		 ->join('product_order p', 'p.order_generate_id = w.order_id','left')
		 ->get()->row();
    	 }
    	 else
    	 {
    	   $currdate = date('d-m-Y');
             return $query = $this->db
    		 ->select('SUM(w.credit) AS cash_payment')
    		 ->from('db_wallet_history w')
    		 ->join('product_order p', 'p.order_generate_id = w.order_id','left')
    		  ->where('p.franchise_id',$login_type)
    		 ->get()->row();
    	 }
 
		 //echo $this->db->last_query();exit();
           
      }
      
          /*********************************** SUM ONLINE TOTAL *************************************
     ******************************************************************************************************/
      public function get_sum_online_model()
      {
       
               $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {
    	     
         return $query = $this->db
		 ->select('SUM(order_total) AS online_payment')
		 ->from('product_order')
		 ->where('p_mode !="0" AND p_mode != "3"')
		 ->get()->row();
    	 }
    	 else
    	 {
    	   
    	       	     
         return $query = $this->db
		 ->select('SUM(order_total) AS online_payment')
		 ->from('product_order')
		 ->where('p_mode !="0" AND p_mode != "3"')
		 ->where('franchise_id',$login_type)
		 ->get()->row();
		 
    	 }
 
		 //echo $this->db->last_query();exit();
           
      }
      
      public function get_today_online_model()
      {
          $currdate = date('d-m-Y');
        
        $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 { 
    	     
             return $query = $this->db
    		 ->select('SUM(order_total) AS online_payment')
    		 ->from('product_order')
             ->where('p_mode !="0" AND p_mode != "3"')
    		 ->get()->row();
    	 }
    	 else
    	 {
    	     
    	    return $query = $this->db
    		 ->select('SUM(order_total) AS online_payment')
    		 ->from('product_order')
             ->where('p_mode !="0" AND p_mode != "3"')
    		  ->where('franchise_id',$login_type)
    		 ->get()->row();
    		 
    	     
    	 }
 
		 //echo $this->db->last_query();exit();
           
      }
      
      
    /*********************************** SUM REFUND TOTAL *************************************
     ******************************************************************************************************/
      public function get_sum_refund_model()
      {
        
         $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {
	     
             return $query = $this->db
    		 ->select('SUM(order_total) AS refund_payment')
    		 ->from('product_order')
    		 ->where('refund_status !=','')
    		 ->get()->row();
    	 }
    	 else
    	 {
    	   return $query = $this->db
    		 ->select('SUM(order_total) AS refund_payment')
    		 ->from('product_order')
    		 ->where('refund_status !=','')
    		 ->where('franchise_id',$login_type)
    		 ->get()->row();
    	 }
		 //echo $this->db->last_query();exit();
           
      }
      
      
    public function get_sum_cancel_amount_model()
    {
         $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {
             return $query = $this->db
    		 ->select('SUM(order_total) AS sattel_payment')
    		 ->from('product_order')
    		 ->where('status','4')
    		 ->where('payment_status','1')
    		 ->get()->row();
    	 }
    	 else
    	 {
    	     
    	   return $query = $this->db
    		 ->select('SUM(order_total) AS sattel_payment')
    		 ->from('product_order')
    		 ->where('status','4')
    		 ->where('payment_status','1')
    		  ->where('franchise_id',$login_type)
    		 ->get()->row();
    		 
    	 }
 
		 //echo $this->db->last_query();exit();
           
      }
      
      
      
      public function get_today_cancel_bill_model()
      {
          $currdate = date('d-m-Y');
         $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {
             return $query = $this->db
    		 ->select('SUM(order_total) AS payment')
    		 ->from('product_order')
    		 ->where('status','4')
    		 ->where('payment_status','1')
    		 ->where('cancel_date',$currdate)
    		 ->get()->row();
    	 }
    	 else
    	 {
    	   
    	    return $query = $this->db
    		 ->select('SUM(order_total) AS payment')
    		 ->from('product_order')
    		 ->where('status','4')
    		 ->where('payment_status','1')
    		 ->where('cancel_date',$currdate)
    		 ->where('franchise_id',$login_type)
    		 ->get()->row();
    		 
    	 }
 
		 //echo $this->db->last_query();exit();
           
      }
      
      
/****************************** Cash Payment List    **************/

function cash_payment_count()
{  
     $currdate = date('d-m-Y');
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
       	$query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where('p.status', '3')
    	->where('p.p_mode', '0')
    	->where('p.payment_status', '1')
    	->order_by("p.order_id","DESC")
    	->get();
    	
	 }
	 else
	 {
	     
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where('p.status', '3')
    	->where('p.p_mode', '0')
    	->where('p.payment_status', '1')
    	->where('p.franchise_id',$login_type)
    	->order_by("p.order_id","DESC")
    	->get();
	 }

    return $query->num_rows();  

}


function cash_payment_list($limit,$start,$col,$dir)
{ 
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
       	$query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where('p.status', '3')
    	->where('p.p_mode', '0')
    	->where('p.payment_status', '1')
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
    
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
	 }
	 else
	 {
	     
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where('p.status', '3')
    	->where('p.p_mode', '0')
    	->where('p.payment_status', '1')
    	->where('p.franchise_id',$login_type)
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
    
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
	 }
    
} 



function cash_payment_search($limit,$start,$search,$col,$dir)
{
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
       	$query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
	
        ->or_like('c.first_name',$search)
        ->or_like('c.last_name',$search)
        ->or_like('c.mobile_no',$search)
        ->or_like('p.order_date',$search)
        ->where('p.status', '3')
        ->where('p.p_mode', '0')
        ->where('p.payment_status', '1')
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
    
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
	 }
	 else
	 {
	     
	     
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
	
        ->or_like('c.first_name',$search)
        ->or_like('c.last_name',$search)
        ->or_like('c.mobile_no',$search)
        ->or_like('p.order_date',$search)
        ->where('p.status', '3')
        ->where('p.p_mode', '0')
        ->where('p.payment_status', '1')
        ->where('p.franchise_id',$login_type)
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
    
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
        
	 }
}


    function cash_payment_search_count($search)
    {
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
       	$query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        ->or_like('c.first_name',$search)
        ->or_like('c.last_name',$search)
        ->or_like('c.mobile_no',$search)
        ->or_like('p.order_date',$search)
        ->where('p.status', '3')
        ->where('p.p_mode', '0')
        ->where('p.payment_status', '1')
        ->order_by("p.order_id","DESC")
    	->get();
	 }
	 else
	 {
	    
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        ->or_like('c.first_name',$search)
        ->or_like('c.last_name',$search)
        ->or_like('c.mobile_no',$search)
        ->or_like('p.order_date',$search)
        ->where('p.status', '3')
        ->where('p.p_mode', '0')
        ->where('p.payment_status', '1')
         ->where('p.franchise_id',$login_type)
        ->order_by("p.order_id","DESC")
    	->get();
    	
	 }
    	
         return $query->num_rows();
        
        // echo $this->db->last_query();exit();
    }
    
    
    /****************************** Online Payment List    **************/

function online_payment_count()
{  
     $currdate = date('d-m-Y');
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
       	$query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        ->where('p_mode !="0" AND p_mode != "3"')
    	->order_by("p.order_id","DESC")
    	->get();
	 }
	 else
	 {
	     
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        ->where('p_mode !="0" AND p_mode != "3"')
        ->where('p.franchise_id',$login_type)
    	->order_by("p.order_id","DESC")
    	->get();
    	
	 }

    return $query->num_rows();  

}


function online_payment_list($limit,$start,$col,$dir)
{ 
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
       	$query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        ->where('p_mode !="0" AND p_mode != "3"')
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
    
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
	 }
	 else
	 {
	  
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        ->where('p_mode !="0" AND p_mode != "3"')
         ->where('p.franchise_id',$login_type)
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
    
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
        
	 }
    
} 



function online_payment_search($limit,$start,$search,$col,$dir)
{
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
       	$query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
	
        ->or_like('c.first_name',$search)
        ->or_like('c.last_name',$search)
        ->or_like('c.mobile_no',$search)
        ->or_like('p.order_date',$search)
        ->where('p_mode !="0" AND p_mode != "3"')
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
    
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
	 }
	 else
	 {
	    
	           	$query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
	
        ->or_like('c.first_name',$search)
        ->or_like('c.last_name',$search)
        ->or_like('c.mobile_no',$search)
        ->or_like('p.order_date',$search)
        ->where('p_mode !="0" AND p_mode != "3"')
        ->where('p.franchise_id',$login_type)
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
    
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
        
	 }
}


    function online_payment_search_count($search)
    {
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
       	$query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        ->or_like('c.first_name',$search)
        ->or_like('c.last_name',$search)
        ->or_like('c.mobile_no',$search)
        ->or_like('p.order_date',$search)
        ->where('p_mode !="0" AND p_mode != "3"')
        ->order_by("p.order_id","DESC")
    	->get();
	 }
	 else
	 {
	            	$query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        ->or_like('c.first_name',$search)
        ->or_like('c.last_name',$search)
        ->or_like('c.mobile_no',$search)
        ->or_like('p.order_date',$search)
        ->where('p_mode !="0" AND p_mode != "3"')
        ->where('p.franchise_id',$login_type)
        ->order_by("p.order_id","DESC")
    	->get();
	     
	 }
    	
         return $query->num_rows();
        
        // echo $this->db->last_query();exit();
    }
    
    
    
        /****************************** Refund Payment List    **************/

function refund_payment_count()
{  
     $currdate = date('d-m-Y');
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
       	$query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        ->where('p.refund_status', '1')
    	->order_by("p.order_id","DESC")
    	->get();
	 }
	 else
	 {
	   
	   	$query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        ->where('p.refund_status', '1')
         ->where('p.franchise_id',$login_type)
    	->order_by("p.order_id","DESC")
    	->get();
    	
	 }

    return $query->num_rows();  

}


function refund_payment_list($limit,$start,$col,$dir)
{ 
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
       	$query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
         ->where('p.refund_status', '1')
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
    
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
	 }
	 else
	 {
	   
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
         ->where('p.refund_status', '1')
         ->where('p.franchise_id',$login_type)
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
    
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
        
	 }
    
} 



function refund_payment_search($limit,$start,$search,$col,$dir)
{
    
   $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
       	$query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
	
        ->or_like('c.first_name',$search)
        ->or_like('c.last_name',$search)
        ->or_like('c.mobile_no',$search)
        ->or_like('p.order_date',$search)
       ->where('p.refund_status', '1')
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
    
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
	 }
	 else
	 {
	            	$query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
	
        ->or_like('c.first_name',$search)
        ->or_like('c.last_name',$search)
        ->or_like('c.mobile_no',$search)
        ->or_like('p.order_date',$search)
       ->where('p.refund_status', '1')
       ->where('p.franchise_id',$login_type)
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
    
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
	     
	 }
}


    function refund_payment_search_count($search)
    {
   $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
       	$query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        ->or_like('c.first_name',$search)
        ->or_like('c.last_name',$search)
        ->or_like('c.mobile_no',$search)
        ->or_like('p.order_date',$search)
        ->where('p.refund_status', '1')
        ->order_by("p.order_id","DESC")
    	->get();
	 }
	 else
	 {
	           	$query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        ->or_like('c.first_name',$search)
        ->or_like('c.last_name',$search)
        ->or_like('c.mobile_no',$search)
        ->or_like('p.order_date',$search)
        ->where('p.refund_status', '1')
         ->where('p.franchise_id',$login_type)
        ->order_by("p.order_id","DESC")
    	->get();
	     
	 }
    	
         return $query->num_rows();
        
        // echo $this->db->last_query();exit();
    }
    
    
    function sales_report($date_from,$date_to)
    {
      $newDate = $date_from;
      $newDate1 = $date_to;
      
         $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
         {  
            $condition = "(p.order_date BETWEEN '$newDate'  AND '$newDate1')  ORDER BY order_id DESC ";
            return  $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
        	->from('product_order p')
        	->join('customer c', 'p.customer_id = c.customer_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    		->where($condition)
    	    ->get()->result();
         }
         else
         {
            
            $condition = " p.franchise_id = $login_type AND (p.order_date BETWEEN '$newDate'  AND '$newDate1')  ORDER BY order_id DESC ";
            return  $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
        	->from('product_order p')
        	->join('customer c', 'p.customer_id = c.customer_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    		->where($condition)
    	    ->get()->result();
    	    
         }
        
    }
    
    
    
        /***********************************  *************************************
     ******************************************************************************************************/
      public function count_order_wise_product($order_id)
      {

         return $query = $this->db
		 ->select('COUNT(order_id) AS total_product')
		 ->from('order_detail')
		 ->where('order_id',$order_id)
		 ->get()->row();
 
		 //echo $this->db->last_query();exit();
           
      }
      
      public function count_sales_report($date_from,$date_to)
      {
      $newDate = $date_from;
      $newDate1 = $date_to;
      
        $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
         {     
            $condition = "(order_date BETWEEN '$newDate'  AND '$newDate1') ";
    
             return $query = $this->db
    		 ->select('COUNT(order_id) AS total_order')
    		 ->from('product_order')
    		 ->where($condition)
    		 ->get()->row();
         }
         else
         {
            $condition = " franchise_id = $login_type AND (order_date BETWEEN '$newDate'  AND '$newDate1') ";
    
             return $query = $this->db
    		 ->select('COUNT(order_id) AS total_order')
    		 ->from('product_order')
    		 ->where($condition)
    		 ->get()->row(); 
         }
 
		 //echo $this->db->last_query();exit();
           
      }
      
      public function cancel_sales_report($date_from,$date_to)
      {
      $newDate = $date_from;
      $newDate1 = $date_to;
      
        $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
         { 
        
            $condition = " status='4' AND (order_date BETWEEN '$newDate'  AND '$newDate1') ";
    
             return $query = $this->db
    		 ->select('COUNT(order_id) AS total_cancel_order')
    		 ->from('product_order')
    		 ->where($condition)
    		 ->get()->row();
         }
         else
         {
            $condition = "franchise_id = $login_type AND status='4' AND (order_date BETWEEN '$newDate'  AND '$newDate1') ";
    
             return $query = $this->db
    		 ->select('COUNT(order_id) AS total_cancel_order')
    		 ->from('product_order')
    		 ->where($condition)
    		 ->get()->row();
             
         }
 
		 //echo $this->db->last_query();exit();
           
      }
      
      public function deliver_sales_report($date_from,$date_to)
      {
      $newDate = $date_from;
      $newDate1 = $date_to;
      
         $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
         { 
        
            $condition = " status='3' AND (order_date BETWEEN '$newDate'  AND '$newDate1') ";
    
             return $query = $this->db
    		 ->select('COUNT(order_id) AS total_deliver_order')
    		 ->from('product_order')
    		 ->where($condition)
    		 ->get()->row();
         }
         else
         {
             
            $condition = " franchise_id = $login_type AND status='3' AND (order_date BETWEEN '$newDate'  AND '$newDate1') ";
    
             return $query = $this->db
    		 ->select('COUNT(order_id) AS total_deliver_order')
    		 ->from('product_order')
    		 ->where($condition)
    		 ->get()->row();
         }
 
		 //echo $this->db->last_query();exit();
           
      }
      
      
    function product_wise_report($date_from,$date_to)
    {
        $newDate = $date_from;
      $newDate1 = $date_to;
      
        $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
         { 
        
            $condition = "(c.order_date BETWEEN '$newDate'  AND '$newDate1') GROUP BY p.product_id";
                return  $query = $this->db
                    	->select('p.*,v.product_name,v.unit,v.qty,f.franchise_name')
                    	->from('order_detail p')
                    	->join('product_order c', 'p.order_id = c.order_id','left')
                    	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
                    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
                		 ->where($condition)
                		 ->get()->result();
                		 
         }
         else
         {
           $condition = "p.franchise_id = $login_type AND (c.order_date BETWEEN '$newDate'  AND '$newDate1') GROUP BY p.product_id";
                return  $query = $this->db
                    	->select('p.*,v.product_name,v.unit,v.qty,f.franchise_name')
                    	->from('order_detail p')
                    	->join('product_order c', 'p.order_id = c.order_id','left')
                    	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
                    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
                		 ->where($condition)
                		 ->get()->result();
         }
        
    }
    
    
    public function product_id_wise_count($product_id,$date_from,$date_to)
      {
     $newDate = date("d-m-Y", strtotime($date_from));
      $newDate1 = date("d-m-Y", strtotime($date_to));
        

        $condition = "p.product_id=$product_id AND(c.order_date BETWEEN '$newDate'  AND '$newDate1')";
        return  $query = $this->db
            	->select('COUNT(p.order_d_id) AS total_product')
            	->from('order_detail p')
            	->join('product_order c', 'p.order_id = c.order_id','left')
		 ->where($condition)
		 ->get()->row();
 
		 //echo $this->db->last_query();exit();
           
      }
      
      
      public function product_id_wise_qty_count($product_id,$date_from,$date_to)
      {
      $newDate = date("m-d-Y", strtotime($date_from));
      $newDate1 = date("m-d-Y", strtotime($date_to));
        

        $condition = "p.product_id=$product_id AND(c.order_date BETWEEN '$newDate'  AND '$newDate1')";
        return  $query = $this->db
            	->select('SUM(p.qty) AS total_qty')
            	->from('order_detail p')
            	->join('product_order c', 'p.order_id = c.order_id','left')
		 ->where($condition)
		 ->get()->row();
 
		 //echo $this->db->last_query();exit();
           
      }
      
      
    function get_export_order_data()
    {
   
            $currdate = date('d-m-Y');
            $login_type   = $this->session->userdata('type');  
        	 if($login_type == '0')
             {
                return $query = $this->db
            	  ->select('p.*,v.product_name')
            	 ->from('count_order_product p')
            	 ->join('vegshopy_product v', 'p.product_id = v.product_id','left')
              	 ->where('p.order_date', $currdate)
            	 ->order_by('p.id','DESC')
            	 ->get()->result();
            }
            else
            {
              return   $query = $this->db
            	  ->select('p.*,v.product_name')
            	 ->from('count_order_product p')
            	 ->join('vegshopy_product v', 'p.product_id = v.product_id','left')
              	 ->where('p.order_date', $currdate)
            	 ->order_by('p.id','DESC')
            	 ->get()->result();
            	 
            	// echo $this->db->last_query();exit();
            	 
            }
    
        
        
	 
    }
    
    
    function pending_order_list1()
   { 

     $query = $this->db
	->select('p.*,c.first_name,c.last_name,c.mobile_no')
	->from('product_order p')
	->join('customer c', 'p.customer_id = c.customer_id','left')
	->where('p.status', '0')
	->where('p.assign_to =', '')
    ->order_by("p.order_id","DESC")
	->get();

    if($query->num_rows()>0)
    {
        return $query->result(); 
    }
    else
    {
        return null;
    }
    
} 



    /*********************************** Customer wise turnover  *************************************
     ******************************************************************************************************/
      public function get_total_turnover_this_month($customer_id)
      {

         return $query = $this->db
		 ->select('SUM(order_total) AS total_turnover')
		 ->from('product_order')
		 ->where('customer_id',$customer_id)
		 ->where('status','3')
		 ->get()->row();
 
		 //echo $this->db->last_query();exit();
           
      }
      
      
    function get_monthly_total_sales_model()
    { 
    
        $login_type   = $this->session->userdata('type');  
    	if($login_type == '0')
        {
                    	     
             $query = $this->db
            	  ->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
            	->from('product_order p')
            	->join('customer c', 'p.customer_id = c.customer_id','left')
            	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
            	->like('p.order_date', date('m-Y'))
                ->order_by("p.order_id","DESC")
            	->get();
            
                if($query->num_rows()>0)
                {
                    return $query->result(); 
                }
                else
                {
                    return null;
                }
        }
        else
        {
            
             $query = $this->db
            	  ->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
            	->from('product_order p')
            	->join('customer c', 'p.customer_id = c.customer_id','left')
            	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
            	->like('p.order_date', date('m-Y'))
            	->where('p.franchise_id', $login_type)
                ->order_by("p.order_id","DESC")
            	->get();
            
                if($query->num_rows()>0)
                {
                    return $query->result(); 
                }
                else
                {
                    return null;
                }
        }
        
    }
    
    
    function get_monthly_pending_total_sales_model()
    { 
    
    
        $login_type   = $this->session->userdata('type');  
    	if($login_type == '0')
        {
                    	     
             $query = $this->db
            	  ->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
            	->from('product_order p')
            	->join('customer c', 'p.customer_id = c.customer_id','left')
            	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
            	->like('p.order_date', date('m-Y'))
            	 ->where('status','0')
            	 ->where('assign_to =','')
                ->order_by("p.order_id","DESC")
            	->get();
            
                if($query->num_rows()>0)
                {
                    return $query->result(); 
                }
                else
                {
                    return null;
                }
        }
        else
        {
            
             $query = $this->db
            	  ->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
            	->from('product_order p')
            	->join('customer c', 'p.customer_id = c.customer_id','left')
            	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
            	->like('p.order_date', date('m-Y'))
            	 ->where('status','0')
            	 ->where('assign_to =','')
            	->where('p.franchise_id', $login_type)
                ->order_by("p.order_id","DESC")
            	->get();
            
                if($query->num_rows()>0)
                {
                    return $query->result(); 
                }
                else
                {
                    return null;
                }
        }

        
    } 
    
    
    
    function get_monthly_assign_sales_model()
    { 
        
        $login_type   = $this->session->userdata('type');  
    	if($login_type == '0')
        {
                    	     
             $query = $this->db
            	  ->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
            	->from('product_order p')
            	->join('customer c', 'p.customer_id = c.customer_id','left')
            	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
            	->like('p.order_date', date('m-Y'))
    	         ->where('assign_to !=','')
                ->order_by("p.order_id","DESC")
            	->get();
            
                if($query->num_rows()>0)
                {
                    return $query->result(); 
                }
                else
                {
                    return null;
                }
        }
        else
        {
            
             $query = $this->db
            	  ->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
            	->from('product_order p')
            	->join('customer c', 'p.customer_id = c.customer_id','left')
            	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
            	->like('p.order_date', date('m-Y'))
    	         ->where('assign_to !=','')
            	->where('p.franchise_id', $login_type)
                ->order_by("p.order_id","DESC")
            	->get();
            
                if($query->num_rows()>0)
                {
                    return $query->result(); 
                }
                else
                {
                    return null;
                }
        }

        
    }
    
    
    
    function get_monthly_deliverd_sales_model()
    { 
    
        $login_type   = $this->session->userdata('type');  
    	if($login_type == '0')
        {
                    	     
             $query = $this->db
            	  ->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
            	->from('product_order p')
            	->join('customer c', 'p.customer_id = c.customer_id','left')
            	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
            	->like('p.order_date', date('m-Y'))
    	         ->where('status','3')
                ->order_by("p.order_id","DESC")
            	->get();
            
                if($query->num_rows()>0)
                {
                    return $query->result(); 
                }
                else
                {
                    return null;
                }
        }
        else
        {
            
             $query = $this->db
            	  ->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
            	->from('product_order p')
            	->join('customer c', 'p.customer_id = c.customer_id','left')
            	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
            	->like('p.order_date', date('m-Y'))
    	         ->where('status','3')
            	->where('p.franchise_id', $login_type)
                ->order_by("p.order_id","DESC")
            	->get();
            
                if($query->num_rows()>0)
                {
                    return $query->result(); 
                }
                else
                {
                    return null;
                }
        }

        
    }
    
    
    function get_monthly_not_deliverd_sales_model()
    { 
        
        $login_type   = $this->session->userdata('type');  
    	if($login_type == '0')
        {
                    	     
             $query = $this->db
            	  ->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
            	->from('product_order p')
            	->join('customer c', 'p.customer_id = c.customer_id','left')
            	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
            	->like('p.order_date', date('m-Y'))
    	        ->where('status','0')
    	         ->where('assign_to !=','')
                ->order_by("p.order_id","DESC")
            	->get();
            
                if($query->num_rows()>0)
                {
                    return $query->result(); 
                }
                else
                {
                    return null;
                }
        }
        else
        {
            
             $query = $this->db
            	  ->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
            	->from('product_order p')
            	->join('customer c', 'p.customer_id = c.customer_id','left')
            	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
            	->like('p.order_date', date('m-Y'))
    	        ->where('status','0')
    	        ->where('assign_to !=','')
            	->where('p.franchise_id', $login_type)
                ->order_by("p.order_id","DESC")
            	->get();
            
                if($query->num_rows()>0)
                {
                    return $query->result(); 
                }
                else
                {
                    return null;
                }
        }
        

        
    }
    
    
    
    function get_monthly_cancel_sales_model()
    { 
        
        
       $login_type   = $this->session->userdata('type');  
    	if($login_type == '0')
        {
                    	     
             $query = $this->db
            	  ->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
            	->from('product_order p')
            	->join('customer c', 'p.customer_id = c.customer_id','left')
            	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
            	->like('p.order_date', date('m-Y'))
    	        ->where('status','4')
    	        ->where('payment_status','1')
                ->order_by("p.order_id","DESC")
            	->get();
            
                if($query->num_rows()>0)
                {
                    return $query->result(); 
                }
                else
                {
                    return null;
                }
        }
        else
        {
            
             $query = $this->db
            	  ->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
            	->from('product_order p')
            	->join('customer c', 'p.customer_id = c.customer_id','left')
            	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
            	->like('p.order_date', date('m-Y'))
    	        ->where('status','4')
    	        ->where('payment_status','1')
            	->where('p.franchise_id', $login_type)
                ->order_by("p.order_id","DESC")
            	->get();
            
                if($query->num_rows()>0)
                {
                    return $query->result(); 
                }
                else
                {
                    return null;
                }
        }

        
    }
    
    
    
function get_cash_payment_model()
{ 
 $currdate = date('d-m-Y');
 
        $login_type   = $this->session->userdata('type');  
    	if($login_type == '0')
        {
            
             $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
        	->from('product_order p')
        	->join('customer c', 'p.customer_id = c.customer_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	 ->where('p.status','3')
        	 ->where('p.p_mode =','0')
        	->where('p.order_date',$currdate)
            ->order_by("p.order_id","DESC")
        	->get();
        }
        else
        {
            $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
        	->from('product_order p')
        	->join('customer c', 'p.customer_id = c.customer_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	 ->where('p.status','3')
        	 ->where('p.p_mode =','0')
        	->where('p.order_date',$currdate)
            ->order_by("p.order_id","DESC")
        	->get();
        //	echo $this->db->last_query();exit();
            
        }

    if($query->num_rows()>0)
    {
        return $query->result(); 
    }
    else
    {
        return null;
    }
    
}


function get_online_payment_model()
{ 
 $currdate = date('d-m-Y');
  
        $login_type   = $this->session->userdata('type');  
    	if($login_type == '0')
        {
            
            $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
        	->from('product_order p')
        	->join('customer c', 'p.customer_id = c.customer_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
             ->where('p_mode !="0" AND p_mode != "3"')
        	->where('p.order_date',$currdate)
            ->order_by("p.order_id","DESC")
        	->get();
        }
        else
        {
            $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
        	->from('product_order p')
        	->join('customer c', 'p.customer_id = c.customer_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
             ->where('p_mode !="0" AND p_mode != "3"')
        	->where('p.order_date',$currdate)
        	->where('p.franchise_id', $login_type)
            ->order_by("p.order_id","DESC")
        	->get();
        }

    if($query->num_rows()>0)
    {
        return $query->result(); 
    }
    else
    {
        return null;
    }
    
}


function get_cancel_bill_amount_model()
{ 
 $currdate = date('d-m-Y');
         $login_type   = $this->session->userdata('type');  
    	if($login_type == '0')
        {
            $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
        	->from('product_order p')
        	->join('customer c', 'p.customer_id = c.customer_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->where('p.status','4')
        	->where('p.payment_status','1')
        	->where('p.cancel_date',$currdate)
            ->order_by("p.order_id","DESC")
        	->get();
        
            if($query->num_rows()>0)
            {
                return $query->result(); 
            }
            else
            {
                return null;
            }
        }
        else
        {
            $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
        	->from('product_order p')
        	->join('customer c', 'p.customer_id = c.customer_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->where('p.status','4')
        	->where('p.payment_status','1')
        	->where('p.cancel_date',$currdate)
        		->where('p.franchise_id', $login_type)
            ->order_by("p.order_id","DESC")
        	->get();
        
            if($query->num_rows()>0)
            {
                return $query->result(); 
            }
            else
            {
                return null;
            } 
            
        }
    
}


    function saller_wise_sales_report($date_from,$date_to,$saller_id)
    {
      $newDate = date("d-m-Y", strtotime($date_from));
      $newDate1 = date("d-m-Y", strtotime($date_to));
      
        $login_type   = $this->session->userdata('type');  
    	if($login_type == '0')
        {
            
            return  $query = $this->db
                	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
                	->from('product_order p')
                	->join('customer c', 'p.customer_id = c.customer_id','left')
                	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
                	->where('status','3')
            		->where('p.saller_id' , $saller_id)
            	     ->where('p.order_date >=', $newDate)
                    ->where('p.order_date <=', $newDate1)
            		 ->get()->result();
            		 
        }
        else
        {
            return  $query = $this->db
                	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
                	->from('product_order p')
                	->join('customer c', 'p.customer_id = c.customer_id','left')
                	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
                	->where('status','3')
            		->where('p.saller_id' , $saller_id)
            	     ->where('p.order_date >=', $newDate)
                    ->where('p.order_date <=', $newDate1)
                    ->where('p.franchise_id', $login_type)
            		 ->get()->result();
            		 
            		 
        }
        
    }
    
    
      public function count_saller_wise_report($date_from,$date_to,$saller_id)
      {
      $newDate = date("d-m-Y", strtotime($date_from));
      $newDate1 = date("d-m-Y", strtotime($date_to));
        
         return $query = $this->db
		 ->select('COUNT(order_id) AS total_deliver_order')
		 ->from('product_order')
		 ->where('status','3')
         ->where('saller_id' , $saller_id)
		 ->where('order_date >=', $newDate)
         ->where('order_date <=', $newDate1)
		 ->get()->row();
 
		 //echo $this->db->last_query();exit();
           
      }
      
      
       public function sum_saller_wise_report($date_from,$date_to,$saller_id)
      {
      $newDate = date("d-m-Y", strtotime($date_from));
      $newDate1 = date("d-m-Y", strtotime($date_to));
        
         return $query = $this->db
		 ->select('SUM(order_total) AS total_bussiness')
		 ->from('product_order')
		 ->where('status','3')
         ->where('saller_id' , $saller_id)
		 ->where('order_date >=', $newDate)
         ->where('order_date <=', $newDate1)
		 ->get()->row();
 
		 //echo $this->db->last_query();exit();
           
      }
      
      
      
        /*********************************** Today Subscription Order *****************************************************
        *******************************************************************************************************/
        
          public function get_today_subscription_order_model()
          {
              $current_date = date('Y-m-d');
              $current_day = date ('l',strtotime("+1 day"));
              
             // print_r($current_day);die();
              
             $login_type   = $this->session->userdata('type');  
        	 if($login_type == '0')
        	 {  

                $query = $this->db
                 ->select('s.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
                 ->from('subscription s')
                 ->join('customer c', 's.customer_id = c.customer_id','left')
                 ->join('franchise f', 's.franchise_id = f.franchise_id','left')
                 ->where('s.from_date <=',$current_date)
                 ->where('s.to_date >=',$current_date)
                 ->where('s.subscribe_status','0')
                 ->get();
                 //echo $this->db->last_query();exit();
                $num_row = $query->num_rows();
                if($num_row > 0){
                    $result = $query->result_array();
                    
                    foreach($result as $rows){
                        $day = $rows['day'];
                        $subscribe_id = $rows['subscribe_id'];
                        $keyExp = explode(',',$day);
                        $i=0;
                        foreach($keyExp as $row){
                            
                            if($row == $current_day){
                                $current_day;
                                $iid[] = $subscribe_id;
                            }
                            
                            $i++;
                        }
                        
                    }
                    $queryn1 = array();
                    if(!empty($iid)){
                             $queryn = $this->db
                                 ->select('s.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
                                 ->from('subscription s')
                                 ->join('customer c', 's.customer_id = c.customer_id','left')
                                 ->join('franchise f', 's.franchise_id = f.franchise_id','left')
                                 ->where_in('s.subscribe_id',$iid)
                                 ->get()->result_array();
                                
                       return $queryn;
                       
                    }else{
                        return false;
                    }
                    
                }else{
                    return false;
                }
                
        	 }
        	 
        	 else
        	 {
        	   
        	   $query = $this->db
                 ->select('s.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
                 ->from('subscription s')
                 ->join('customer c', 's.customer_id = c.customer_id','left')
                 ->join('franchise f', 's.franchise_id = f.franchise_id','left')
                 ->where('s.from_date <=',$current_date)
                 ->where('s.to_date >=',$current_date)
                 ->where('s.subscribe_status','0')
                 ->where('s.franchise_id', $login_type)
                 ->get();
                 //echo $this->db->last_query();exit();
                $num_row = $query->num_rows();
                if($num_row > 0){
                    $result = $query->result_array();
                    
                    foreach($result as $rows){
                        $day = $rows['day'];
                        $subscribe_id = $rows['subscribe_id'];
                        $keyExp = explode(',',$day);
                        $i=0;
                        foreach($keyExp as $row){
                            
                            if($row == $current_day){
                                $current_day;
                                $iid[] = $subscribe_id;
                            }
                            
                            $i++;
                        }
                        
                    }
                    $queryn1 = array();
                    if(!empty($iid)){
                             $queryn = $this->db
                                 ->select('s.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
                                 ->from('subscription s')
                                 ->join('customer c', 's.customer_id = c.customer_id','left')
                                 ->join('franchise f', 's.franchise_id = f.franchise_id','left')
                                 ->where_in('s.subscribe_id',$iid)
                                 ->where('s.franchise_id', $login_type)
                                 ->get()->result_array();
                                
                       return $queryn;
                       
                    }else{
                        return false;
                    }
                    
                }else{
                    return false;
                }
        	     
        	 }
                 
                  //echo $this->db->last_query();exit();
    
          }
      
      
      
    function get_export_total_order_data()
    {
     $login_type   = $this->session->userdata('type');  
        	 if($login_type == '0')
             {
                return $query = $this->db
            	  ->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
            	->from('product_order p')
            	->join('customer c', 'p.customer_id = c.customer_id','left')
            	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
                ->order_by("p.order_id","DESC")
            	 ->get()->result();
            }
            else
            {
                return $query = $this->db
            	  ->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
            	->from('product_order p')
            	->join('customer c', 'p.customer_id = c.customer_id','left')
            	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
            	 ->where('p.franchise_id', $login_type)
                ->order_by("p.order_id","DESC")
            	 ->get()->result();
            	 
            }
       
            
        
	 
    }
    
    
    function get_export_pending_order_data()
    {
       
         $login_type   = $this->session->userdata('type');  
        	 if($login_type == '0')
            	 {
                return $query = $this->db
            	  ->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
            	->from('product_order p')
            	->join('customer c', 'p.customer_id = c.customer_id','left')
            	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
            	 	->where('p.status','0')
		         ->where('p.assign_to =','')
                ->order_by("p.order_id","DESC")
            	 ->get()->result();
            }
            else
            {
                return $query = $this->db
            	  ->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
            	->from('product_order p')
            	->join('customer c', 'p.customer_id = c.customer_id','left')
            	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
            	->where('p.status','0')
		         ->where('p.assign_to =','')
            	 ->where('p.franchise_id', $login_type)
                ->order_by("p.order_id","DESC")
            	 ->get()->result();
            	 
            }
            

	 
    }
    
    
    
     /****************************** Assign ORder List    **************/

function assign_order_count()
{  
     $currdate = date('d-m-Y');
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
       	$query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where('p.assign_to !=','')
    	->order_by("p.order_id","DESC")
    	->get();
	 }
	 else
	 {
	   
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where('p.assign_to !=','')
    	->where('p.franchise_id', $login_type)
    	->order_by("p.order_id","DESC")
    	->get();  
	 }

    return $query->num_rows();  

}


function assign_order_list($limit,$start,$col,$dir)
{ 
  
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
	     
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where('p.assign_to !=','')
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
	 }
	 else
	 {
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where('p.assign_to !=','')
    	->where('p.franchise_id', $login_type)
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
    	
    	
    	
	     
	 }

    if($query->num_rows()>0)
    {
        return $query->result(); 
    }
    else
    {
        return null;
    }
    
} 



function assign_order_search($limit,$start,$search,$col,$dir)
{
   
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 { 

	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->or_like('c.first_name',$search)
    	->or_like('c.last_name',$search)
    	->or_like('p.order_generate_id',$search)
    	->or_like('p.order_total',$search)
        ->or_like('p.order_date',$search)
        ->or_like('f.franchise_name',$search)
        ->where('p.assign_to !=','')
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
	 }
	 else
	 {
	    
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->or_like('c.first_name',$search)
    	->or_like('c.last_name',$search)
    	->or_like('p.order_generate_id',$search)
    	->or_like('p.order_total',$search)
        ->or_like('p.order_date',$search)
        ->or_like('f.franchise_name',$search)
        ->where('p.assign_to !=','')
        ->where('p.franchise_id', $login_type)
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
    	
	 }

    if($query->num_rows()>0)
    {
        return $query->result();  
    }
    else
    {
        return null;
    }
}


    function assign_order_search_count($search)
    {
        
        
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 { 
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->or_like('c.first_name',$search)
    	->or_like('c.last_name',$search)
    	->or_like('p.order_generate_id',$search)
    	->or_like('p.order_total',$search)
        ->or_like('p.order_date',$search)
        ->or_like('f.franchise_name',$search)
        ->where('p.assign_to !=','')
        ->order_by("p.order_id","DESC")
    	->get();
    	
	 }
	 else
	 {
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->or_like('c.first_name',$search)
    	->or_like('c.last_name',$search)
    	->or_like('p.order_generate_id',$search)
    	->or_like('p.order_total',$search)
        ->or_like('p.order_date',$search)
        ->or_like('f.franchise_name',$search)
        ->where('p.assign_to !=','')
        ->where('p.franchise_id', $login_type)
        ->order_by("p.order_id","DESC")
    	->get();
	     
	 }
    	
         return $query->num_rows();
        
        // echo $this->db->last_query();exit();
    }
    
    
     /****************************** Assign but not delivered ORder List    **************/

function assign_not_deliver_count()
{  
     $currdate = date('d-m-Y');
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 { 
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where('p.assign_to !=','')
    	->where('p.status ','0')
    	->order_by("p.order_id","DESC")
    	->get();
	 }
	 else
	 {
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where('p.assign_to !=','')
    	->where('p.status ','0')
    	->where('p.franchise_id', $login_type)
    	->order_by("p.order_id","DESC")
    	->get();  
	 }

    return $query->num_rows();  

}


function assign_not_deliver_list($limit,$start,$col,$dir)
{ 
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 { 
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where('p.assign_to !=','')
    	->where('p.status ','0')
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
    	
    	
	 }
	 else
	 {
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where('p.assign_to !=','')
    	->where('p.status ','0')
    	->where('p.franchise_id', $login_type)
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get(); 
	     
	 }

    if($query->num_rows()>0)
    {
        return $query->result(); 
    }
    else
    {
        return null;
    }
    
} 



function assign_not_deliver_search($limit,$start,$search,$col,$dir)
{
    
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 { 
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->or_like('c.first_name',$search)
    	->or_like('c.last_name',$search)
    	->or_like('p.order_generate_id',$search)
    	->or_like('p.order_total',$search)
        ->or_like('p.order_date',$search)
        ->or_like('f.franchise_name',$search)
        ->where('p.assign_to !=','')
        ->where('p.status ','0')
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
	 }
	 else
	 {
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->or_like('c.first_name',$search)
    	->or_like('c.last_name',$search)
    	->or_like('p.order_generate_id',$search)
    	->or_like('p.order_total',$search)
        ->or_like('p.order_date',$search)
        ->or_like('f.franchise_name',$search)
        ->where('p.assign_to !=','')
        ->where('p.status ','0')
        ->where('p.franchise_id', $login_type)
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
	     
	 }

    if($query->num_rows()>0)
    {
        return $query->result();  
    }
    else
    {
        return null;
    }
}


    function assign_not_deliver_search_count($search)
    {
        
        
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 { 
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->or_like('c.first_name',$search)
        	->or_like('c.last_name',$search)
        	->or_like('p.order_generate_id',$search)
        	->or_like('p.order_total',$search)
            ->or_like('p.order_date',$search)
            ->or_like('f.franchise_name',$search)
            ->where('p.assign_to !=','')
             ->where('p.status ','0')
            ->order_by("p.order_id","DESC")
        	->get();
	 }
	 else
	 {
	     
	   $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->or_like('c.first_name',$search)
        	->or_like('c.last_name',$search)
        	->or_like('p.order_generate_id',$search)
        	->or_like('p.order_total',$search)
            ->or_like('p.order_date',$search)
            ->or_like('f.franchise_name',$search)
            ->where('p.assign_to !=','')
             ->where('p.status ','0')
             ->where('p.franchise_id', $login_type)
            ->order_by("p.order_id","DESC")
        	->get();
        	
	 }
    	
         return $query->num_rows();
        
        // echo $this->db->last_query();exit();
    } 
    
    
    

      public function count_pincode_wise_order($pincode)
      {

         return $query = $this->db
		 ->select('COUNT(order_id) AS total_order')
		 ->from('product_order')
		 ->or_like('deliver_address',$pincode)
		 ->get()->row();
 
		 //echo $this->db->last_query();exit();
           
      }
      
      
      public function count_pincode_wise_pending_order($pincode)
      {

         return $query = $this->db
		 ->select('COUNT(order_id) AS total_order')
		 ->from('product_order')
		 ->or_like('deliver_address',$pincode)
		 ->where('assign_to =','')
		 ->get()->row();
 
		 //echo $this->db->last_query();exit();
           
      }
       public function count_pincode_wise_assign_order($pincode)
      {

         return $query = $this->db
		 ->select('COUNT(order_id) AS total_order')
		 ->from('product_order')
		 ->or_like('deliver_address',$pincode)
		 ->where('assign_to !=','')
		 ->get()->row();
 
		 //echo $this->db->last_query();exit();
           
      }
      
      
     public function count_pincode_wise_deliver_order($pincode)
      {

         return $query = $this->db
		 ->select('COUNT(order_id) AS total_order')
		 ->from('product_order')
		 ->or_like('deliver_address',$pincode)
		 ->where('status ','3')
		 ->get()->row();
 
		 //echo $this->db->last_query();exit();
           
      }
      
    public function count_pincode_wise_not_deliver_order($pincode)
      {

         return $query = $this->db
		 ->select('COUNT(order_id) AS total_order')
		 ->from('product_order')
		 ->or_like('deliver_address',$pincode)
		 ->where('status ','0')
		 ->where('assign_to !=','')
		 ->get()->row();
 
		 //echo $this->db->last_query();exit();
           
      }
      
      
      
      public function count_pincode_wise_cancel_order($pincode)
      {

         return $query = $this->db
		 ->select('count(order_id) AS total_order')
		 ->from('product_order')
		 ->or_like('deliver_address',$pincode)
		 ->where('status','4')
		 ->where('payment_status','1')
		 ->get()->row();
 
		 //echo $this->db->last_query();exit();
           
      }
      
      
    public function count_pincode_wise_total_amount($pincode)
      {

         return $query = $this->db
		 ->select('SUM(order_total) AS total_amount')
		 ->from('product_order')
		 ->or_like('deliver_address',$pincode)
		 ->where('status','3')
		 ->where('payment_status','1')
		 ->get()->row();
 
		 //echo $this->db->last_query();exit();
           
      }
      
      
      
      public function count_pincode_wise_total_cash_amount($pincode)
      {

         return $query = $this->db
		 ->select('SUM(order_total) AS total_amount')
		 ->from('product_order')
		 ->or_like('deliver_address',$pincode)
		 ->where('status','3')
		 ->where('p_mode','0')
		 ->where('payment_status','1')
		 ->get()->row();
 
		 //echo $this->db->last_query();exit();
           
      }
      
      
      
     public function count_pincode_wise_total_online_amount($pincode)
      {

         return $query = $this->db
		 ->select('SUM(order_total) AS total_amount')
		 ->from('product_order')
		 ->or_like('deliver_address',$pincode)
          ->where('p_mode !="0" AND p_mode != "3"')
		 ->get()->row();
 
		 //echo $this->db->last_query();exit();
           
      }
      
      
      public function count_pincode_wise_total_refund_amount($pincode)
      {

         return $query = $this->db
		 ->select('SUM(order_total) AS total_amount')
		 ->from('product_order')
		 ->or_like('deliver_address',$pincode)
		 ->where('refund_status !=','')
		 ->get()->row();
 
		 //echo $this->db->last_query();exit();
           
      }
      
      
      
      
      function cancel_order_count1()
{ 
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
	     
      $currdate = date('d-m-Y');
	  $query = $this->db
    	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
    	->from('product_order p')
    	->join('customer c', 'p.customer_id = c.customer_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->where('p.status', '4')
        	->where('p.payment_status =', '0')
        	->order_by("p.order_id","DESC")
        	->get();
	 }
	 else
	 {
	   $currdate = date('d-m-Y');
	  $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
        	->from('product_order p')
        	->join('customer c', 'p.customer_id = c.customer_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->where('p.status', '4')
        	->where('p.payment_status =', '0')
        	->where('p.franchise_id', $login_type)
        	->order_by("p.order_id","DESC")
        	->get();
        	
	     
	 }

    return $query->num_rows();  

}


function cancel_order_list1($limit,$start,$col,$dir)
{ 
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
	  $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
        	->from('product_order p')
        	->join('customer c', 'p.customer_id = c.customer_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where('p.status', '4')
    	->where('p.payment_status =', '0')
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
    	
	 }
	 else
	 {
	     
	  $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
        	->from('product_order p')
        	->join('customer c', 'p.customer_id = c.customer_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where('p.status', '4')
    	->where('p.payment_status =', '0')
    	->where('p.franchise_id', $login_type)
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
    	
	 }

    if($query->num_rows()>0)
    {
        return $query->result(); 
    }
    else
    {
        return null;
    }
    
} 



function cancel_order_search1($limit,$start,$search,$col,$dir)
{
    
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
	  $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
        	->from('product_order p')
        	->join('customer c', 'p.customer_id = c.customer_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->or_like('c.first_name',$search)
    	->or_like('c.last_name',$search)
    	->or_like('p.order_generate_id',$search)
    	->or_like('p.order_total',$search)
        ->or_like('p.order_date',$search)
        ->or_like('f.franchise_name',$search)
        ->where('p.status', '4')
        ->where('p.payment_status =', '0')
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
	 }
	 else
	 {
	   
	  $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
        	->from('product_order p')
        	->join('customer c', 'p.customer_id = c.customer_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->or_like('c.first_name',$search)
    	->or_like('c.last_name',$search)
    	->or_like('p.order_generate_id',$search)
    	->or_like('p.order_total',$search)
        ->or_like('p.order_date',$search)
        ->or_like('f.franchise_name',$search)
        ->where('p.status', '4')
        ->where('p.payment_status =', '0')
        ->where('p.franchise_id', $login_type)
        ->order_by("p.order_id","DESC")
        ->limit($limit,$start)
    	->get();
    	
	 }

    if($query->num_rows()>0)
    {
        return $query->result();  
    }
    else
    {
        return null;
    }
}


    function cancel_order_search_count1($search)
    {
        
        
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
	  $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
        	->from('product_order p')
        	->join('customer c', 'p.customer_id = c.customer_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->or_like('c.first_name',$search)
        	->or_like('c.last_name',$search)
        	->or_like('p.order_generate_id',$search)
        	->or_like('p.order_total',$search)
            ->or_like('p.order_date',$search)
            ->or_like('f.franchise_name',$search)
            ->where('p.status', '4')
            ->where('p.payment_status =', '0')
            ->order_by("p.order_id","DESC")
        	->get();
	 }
	 else
	 {
	  
	  $query = $this->db
        	->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
        	->from('product_order p')
        	->join('customer c', 'p.customer_id = c.customer_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->or_like('c.first_name',$search)
        	->or_like('c.last_name',$search)
        	->or_like('p.order_generate_id',$search)
        	->or_like('p.order_total',$search)
            ->or_like('p.order_date',$search)
            ->or_like('f.franchise_name',$search)
            ->where('p.status', '4')
            ->where('p.payment_status =', '0')
             ->where('p.franchise_id', $login_type)
            ->order_by("p.order_id","DESC")
        	->get();
        	
	 }
    	
         return $query->num_rows();
        
        // echo $this->db->last_query();exit();
    }
    
    
    
    
    
            /****************************** Item wise List    **************/

    function item_wise_count()
    {  
        $currdate = date('Y-m-d');
        $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {
           	$query = $this->db
        	->select('p.*,c.first_name,c.last_name,v.product_name,f.franchise_name,s.order_date,s.order_generate_id,s.status,s.payment_status')
        	->from('order_detail p')
        	->join('product_order s', 'p.order_id = s.order_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->where('s.status', '0')
        	->order_by("p.order_d_id","DESC")
        	->get();
    	 }
    	 else
    	 {
    	   
           	$query = $this->db
        	->select('p.*,c.first_name,c.last_name,v.product_name,f.franchise_name,s.order_date,s.order_generate_id,s.status,s.payment_status')
        	->from('order_detail p')
        	->join('product_order s', 'p.order_id = s.order_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->where('s.status', '0')
        	->where('p.franchise_id', $login_type)
        	->order_by("p.order_d_id","DESC")
        	->get();
        	
    	     
    	 }
    
       return $query->num_rows(); 
        
       //  echo $this->db->last_query();exit();
    
    }
        
function item_wise_list($limit,$start,$col,$dir)
{ 
        $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {
           	$query = $this->db
        	->select('p.*,c.first_name,c.last_name,v.product_name,f.franchise_name,s.order_date,s.order_generate_id,s.status,s.payment_status')
        	->from('order_detail p')
        	->join('product_order s', 'p.order_id = s.order_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->where('s.status', '0')
        	->order_by("p.order_d_id","DESC")
            ->limit($limit,$start)
        	->get();
        
            if($query->num_rows()>0)
            {
                return $query->result(); 
            }
            else
            {
                return null;
            }
    	 }
    	 else
    	 {
           	$query = $this->db
        	->select('p.*,c.first_name,c.last_name,v.product_name,f.franchise_name,s.order_date,s.order_generate_id,s.status,s.payment_status')
        	->from('order_detail p')
        	->join('product_order s', 'p.order_id = s.order_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->where('s.status', '0')
        	->where('p.franchise_id',$login_type)
        	->order_by("p.order_d_id","DESC")
            ->limit($limit,$start)
        	->get();
        	
        	
        
            if($query->num_rows()>0)
            {
                return $query->result(); 
            }
            else
            {
                return null;
            }
    	     
    	 }
    
}


function item_wise_search($limit,$start,$search,$col,$dir)
{
        $currdate = date('Y-m-d');
        $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {
           	$query = $this->db
        	->select('p.*,c.first_name,c.last_name,v.product_name,f.franchise_name,s.order_date,s.order_generate_id,s.status,s.payment_status')
        	->from('order_detail p')
        	->join('product_order s', 'p.order_id = s.order_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->or_like('v.product_name',$search)
        	->where('s.status', '0')
        	->order_by("p.order_d_id","DESC")
            ->limit($limit,$start)
        	->get();
        
            if($query->num_rows()>0)
            {
                return $query->result();  
            }
            else
            {
                return null;
            }
    	 }
    	 else
    	 {
           	$query = $this->db
        	->select('p.*,c.first_name,c.last_name,v.product_name,f.franchise_name,s.order_date,s.order_generate_id,s.status,s.payment_status')
        	->from('order_detail p')
        	->join('product_order s', 'p.order_id = s.order_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->or_like('v.product_name',$search)
        	->where('s.status', '0')
        	->where('p.franchise_id',$login_type)
        	->order_by("p.order_d_id","DESC")
            ->limit($limit,$start)
        	->get();
        
            if($query->num_rows()>0)
            {
                return $query->result();  
            }
            else
            {
                return null;
            }
    	     
    	 }
}


    function item_wise_search_count($search)
    {
        
        $currdate = date('Y-m-d');
        $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {
           	$query = $this->db
        	->select('p.*,c.first_name,c.last_name,v.product_name,f.franchise_name,s.order_date,s.order_generate_id,s.status,s.payment_status')
        	->from('order_detail p')
        	->join('product_order s', 'p.order_id = s.order_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->or_like('v.product_name',$search)
        	->where('s.status', '0')
        	->order_by("p.order_d_id","DESC")
    	    ->get();
    	 }
    	 else
    	 {
           	$query = $this->db
        	->select('p.*,c.first_name,c.last_name,v.product_name,f.franchise_name,s.order_date,s.order_generate_id,s.status,s.payment_status')
        	->from('order_detail p')
        	->join('product_order s', 'p.order_id = s.order_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->or_like('v.product_name',$search)
        	->where('s.status', '0')
        	->where('p.franchise_id',$login_type)
        	->order_by("p.order_d_id","DESC")
    	    ->get();
    	     
    	 }
    	
         return $query->num_rows();
        
        // echo $this->db->last_query();exit();
    }
    
    
    
    
        
            /****************************** Return List    **************/

    function return_count()
    {  
        $currdate = date('Y-m-d');
        $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {
           	$query = $this->db
        	->select('p.*,c.first_name,c.last_name,v.product_name,f.franchise_name,s.order_date,s.order_generate_id,s.status,s.payment_status,z.zone_name,d.name')
        	->from('order_detail p')
        	->join('product_order s', 'p.order_id = s.order_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('zone z', 's.zone_id = z.zone_id','left')
        	->join('delivery_boy d', 's.assign_id = d.db_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->where('p.flag', '1')
        	->order_by("p.order_d_id","DESC")
        	->get();
    	 }
    	 else
    	 {
    	   
           	$query = $this->db
        	->select('p.*,c.first_name,c.last_name,v.product_name,f.franchise_name,s.order_date,s.order_generate_id,s.status,s.payment_status,z.zone_name,d.name')
        	->from('order_detail p')
        	->join('product_order s', 'p.order_id = s.order_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('zone z', 's.zone_id = z.zone_id','left')
        	->join('delivery_boy d', 's.assign_to = d.db_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->where('p.flag', '1')
        	->where('p.franchise_id', $login_type)
        	->order_by("p.order_d_id","DESC")
        	->get();
        	
    	     
    	 }
    
       return $query->num_rows(); 
        
       //  echo $this->db->last_query();exit();
    
    }
        
function return_list($limit,$start,$col,$dir)
{ 
        $currdate = date('Y-m-d');
        $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {
           	$query = $this->db
        	->select('p.*,c.first_name,c.last_name,v.product_name,f.franchise_name,s.order_date,s.order_generate_id,s.status,s.payment_status,z.zone_name,d.name')
        	->from('order_detail p')
        	->join('product_order s', 'p.order_id = s.order_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('zone z', 's.zone_id = z.zone_id','left')
        	->join('delivery_boy d', 's.assign_to = d.db_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->where('p.flag', '1')
        	->order_by("p.order_d_id","DESC")
            ->limit($limit,$start)
        	->get();
        
            if($query->num_rows()>0)
            {
                return $query->result(); 
            }
            else
            {
                return null;
            }
    	 }
    	 else
    	 {
           	$query = $this->db
        	->select('p.*,c.first_name,c.last_name,v.product_name,f.franchise_name,s.order_date,s.order_generate_id,s.status,s.payment_status,z.zone_name,d.name')
        	->from('order_detail p')
        	->join('product_order s', 'p.order_id = s.order_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('zone z', 's.zone_id = z.zone_id','left')
        	->join('delivery_boy d', 's.assign_to = d.db_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->where('p.flag', '1')
        	->where('p.franchise_id',$login_type)
        	->order_by("p.order_d_id","DESC")
            ->limit($limit,$start)
        	->get();
        	
        	//echo $this->db->last_query();exit();
        
            if($query->num_rows()>0)
            {
                return $query->result(); 
            }
            else
            {
                return null;
            }
    	     
    	 }
    
}


function return_search($limit,$start,$search,$col,$dir)
{
        $currdate = date('Y-m-d');
        $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {
           	$query = $this->db
        	->select('p.*,c.first_name,c.last_name,v.product_name,f.franchise_name,s.order_date,s.order_generate_id,s.status,s.payment_status,z.zone_name,d.name')
        	->from('order_detail p')
        	->join('product_order s', 'p.order_id = s.order_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('zone z', 's.zone_id = z.zone_id','left')
        	->join('delivery_boy d', 's.assign_to = d.db_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->or_like('v.product_name',$search)
        	->or_like('f.franchise_name',$search)
        	->or_like('c.first_name',$search)
        	->where('p.flag', '1')
        	->order_by("p.order_d_id","DESC")
            ->limit($limit,$start)
        	->get();
        
            if($query->num_rows()>0)
            {
                return $query->result();  
            }
            else
            {
                return null;
            }
    	 }
    	 else
    	 {
           	$query = $this->db
        	->select('p.*,c.first_name,c.last_name,v.product_name,f.franchise_name,s.order_date,s.order_generate_id,s.status,s.payment_status,z.zone_name,d.name')
        	->from('order_detail p')
        	->join('product_order s', 'p.order_id = s.order_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('zone z', 's.zone_id = z.zone_id','left')
        	->join('delivery_boy d', 's.assign_to = d.db_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->or_like('v.product_name',$search)
        	->or_like('f.franchise_name',$search)
        	->or_like('c.first_name',$search)
        	->where('p.flag', '1')
        	->where('p.franchise_id',$login_type)
        	->order_by("p.order_d_id","DESC")
            ->limit($limit,$start)
        	->get();
        
            if($query->num_rows()>0)
            {
                return $query->result();  
            }
            else
            {
                return null;
            }
    	     
    	 }
}


    function return_search_count($search)
    {
        
        $currdate = date('Y-m-d');
        $login_type   = $this->session->userdata('type');  
    	 if($login_type == '0')
    	 {
           	$query = $this->db
        	->select('p.*,c.first_name,c.last_name,v.product_name,f.franchise_name,s.order_date,s.order_generate_id,s.status,s.payment_status,z.zone_name,d.name')
        	->from('order_detail p')
        	->join('product_order s', 'p.order_id = s.order_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('zone z', 's.zone_id = z.zone_id','left')
        	->join('delivery_boy d', 's.assign_to = d.db_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->or_like('v.product_name',$search)
        	->or_like('f.franchise_name',$search)
        	->or_like('c.first_name',$search)
        	->where('p.flag', '1')
        	->order_by("p.order_d_id","DESC")
    	    ->get();
    	 }
    	 else
    	 {
           	$query = $this->db
        	->select('p.*,c.first_name,c.last_name,v.product_name,f.franchise_name,s.order_date,s.order_generate_id,s.status,s.payment_status,z.zone_name,d.name')
        	->from('order_detail p')
        	->join('product_order s', 'p.order_id = s.order_id','left')
        	->join('customer c', 's.customer_id = c.customer_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
        	->join('zone z', 's.zone_id = z.zone_id','left')
        	->join('delivery_boy d', 's.assign_to = d.db_id','left')
        	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        	->or_like('v.product_name',$search)
        	->or_like('f.franchise_name',$search)
        	->or_like('c.first_name',$search)
        	->where('p.flag', '1')
        	->where('p.franchise_id',$login_type)
        	->order_by("p.order_d_id","DESC")
    	    ->get();
    	     
    	 }
    	
         return $query->num_rows();
        
        // echo $this->db->last_query();exit();
    }
    
    
    
    function get_best_selling_product($franchise_id)
    {

                return  $query = $this->db
                    	->select('SUM(o.qty) AS total_qty,p.*')
                    	->from('order_detail o')
                    	->join('vegshopy_product p', 'p.product_id = o.product_id','left')
                		->where('o.franchise_id',$franchise_id)
                		->group_by('o.product_id')
                		->order_by("total_qty","DESC")
                		->limit(10)
                		->get()->result();
                		
                		
                		
         
        
    }
    

    function get_export_order_data1($from_date,$to_date)
    {

          $newDate = date("d-m-Y", strtotime($from_date));
          $newDate1 = date("d-m-Y", strtotime($to_date));
          
            $login_type   = $this->session->userdata('type');  
        	 if($login_type == '0')
             {
                  $condition = "(p.order_date BETWEEN '$newDate'  AND '$newDate1')";
                    return $query = $this->db
                	 ->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
                	->from('product_order p')
                	->join('customer c', 'p.customer_id = c.customer_id','left')
                	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
                	->where($condition)
                	->get()->result();
             }
             else
             {
               
                    $condition = "p.franchise_id = $login_type AND (p.order_date BETWEEN '$newDate'  AND '$newDate1')";
                    return $query = $this->db
                	 ->select('p.*,c.first_name,c.last_name,c.mobile_no,f.franchise_name')
                	->from('product_order p')
                	->join('customer c', 'p.customer_id = c.customer_id','left')
                	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
                	->where($condition)
                	->get()->result();
                	
             }
            
        
            
        
	 
    }


      
/*******************************************************************************/
}

?>