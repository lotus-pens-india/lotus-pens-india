<?php

class Customer_model extends CI_Model {


/****************************** Customer List    **************/

function customer_count()
{ 
    
       $login_type   = $this->session->userdata('type');
	    if($login_type == '0')
	    { 
	        
	   $query = $this->db
    	->select('*')
    	->from('customer')
    	->order_by("customer_id","DESC")
    	->get();
	    }
	    else
	    {
	       $query = $this->db
    	->select('*')
    	->from('customer')
    	 ->where('franchise_id',$login_type)
    	->order_by("customer_id","DESC")
    	->get();

	        
	    }

    return $query->num_rows();  

}
    
    
function customer_list($limit,$start,$col,$dir)
{ 
    $login_type   = $this->session->userdata('type');
    if($login_type == '0')
    { 
	        
  	   $query = $this->db
    	->select('*')
    	->from('customer')
    	->order_by("customer_id","DESC")
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
    	->select('*')
    	->from('customer')
    	 ->where('franchise_id',$login_type)
    	->order_by("customer_id","DESC")
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


    function customer_search($limit,$start,$search,$col,$dir)
    {
        $login_type   = $this->session->userdata('type');
        if($login_type == '0')
        {
            $query = $this
                    ->db
                    
                    ->or_like('first_name',$search)
                    ->or_like('last_name',$search)
                    ->or_like('mobile_no',$search)
                    ->or_like('email_id',$search)
                    ->limit($limit,$start)
                    ->order_by($col,$dir)
                    ->get('customer');
            
           
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
            
            $query = $this
                    ->db
                    
                    ->or_like('first_name',$search)
                    ->or_like('last_name',$search)
                    ->or_like('mobile_no',$search)
                    ->or_like('email_id',$search)
                    ->where('franchise_id',$login_type)
                    ->limit($limit,$start)
                    ->order_by($col,$dir)
                    ->get('customer');
            
           
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
    
    function customer_search_count($search)
    {
        $login_type   = $this->session->userdata('type');
        if($login_type == '0')
        {
            $query = $this
                    ->db
                    
                    ->or_like('first_name',$search)
                    ->or_like('last_name',$search)
                    ->or_like('mobile_no',$search)
                    ->or_like('email_id',$search)
                    ->get('customer');
        }
        else
        {
             $query = $this
                    ->db
                    
                    ->or_like('first_name',$search)
                    ->or_like('last_name',$search)
                    ->or_like('mobile_no',$search)
                    ->or_like('email_id',$search)
                    ->where('franchise_id',$login_type)
                    ->get('customer');
            
        }
    
       return $query->num_rows();
        
         //echo $this->db->last_query();exit();
    } 
    
    
    
/****************************** Customer Details   **************/  

  public function get_customer_details($customer_id)
  {
          return $query = $this->db
    			 ->select('*')
    			 ->from('customer')
    			 ->where('customer_id', $customer_id)
    			 ->get()->row();
    			 
    			 
    }
    


	
	
	    /****************************** Wallet histrory    **************/

	public function get_wallet_history($customer_id)
	{
		return $query = $this->db
			 ->select('*')
			 ->from('wallet_history')
			 ->where('customer_id', $customer_id)
			 ->order_by("id","DESC")
			 ->get()->result();
			 
		//	 echo $this->db->last_query();exit();
	}
	

	
	
	/****************************** Pickup point   **************/

	public function get_pickup_point($franchise_id)
	{
		return $query = $this->db
			 ->select('*')
			 ->from('pickup_point')
			 ->where('franchise_id', $franchise_id)
			 ->order_by("pick_up_id","DESC")
			 ->get()->result();
			 
		//	 echo $this->db->last_query();exit();
	}
	
	
			    /****************************** Delivery boy   **************/

	public function get_all_db_model()
	{
	    $login_type   = $this->session->userdata('type');
	    if($login_type == '0')
	    {
    		return $query = $this->db
    			 ->select('d.*,f.franchise_name')
    			 ->from('delivery_boy d')
    			 ->join('franchise f', 'f.franchise_id = d.franchise_id','left')
    			 ->where('d.isActive', '0')
    			 ->order_by("d.db_id","DESC")
    			 ->get()->result();
	    }
	    else
	    {
	     
    		return $query = $this->db
    			 ->select('d.*,f.franchise_name')
    			 ->from('delivery_boy d')
    			 ->join('franchise f', 'f.franchise_id = d.franchise_id','left')
    			 ->where('d.isActive', '0')
    			 ->where('d.franchise_id', $login_type)
    			 ->order_by("d.db_id","DESC")
    			 ->get()->result();
	        
	    }
    			 
			 
		//	 echo $this->db->last_query();exit();
	}

    
      public function get_db_details($db_id)
  {
          return $query = $this->db
    			 ->select('*')
    			 ->from('delivery_boy')
    			 ->where('db_id', $db_id)
    			 ->get()->row();
    			//	 echo $this->db->last_query();exit();

    			 
    }

	
	
	public function get_db_wallet_history($db_id,$from_date,$to_date)
	{
	    
	    
	    if($from_date == '' && $to_date == '')
	    {
	        
	       return $query = $this->db
			 ->select('*')
			 ->from('db_wallet_history')
			 ->where('db_id', $db_id)
			 ->where('credit !=', NULL)
			 ->like('c_d_date', date('m-Y'))
			 ->order_by("id","DESC")
			 ->get()->result();
			 
    	
	    }
	    else
	    {
	              $newDate = date("d-m-Y", strtotime($from_date));
                  $newDate1 = date("d-m-Y", strtotime($to_date));
                 $condition = "db_id = $db_id AND credit != 'NULL' AND (c_d_date BETWEEN '$newDate'  AND '$newDate1')   ORDER BY id DESC "; 
                 return $query = $this->db
    			 ->select('*')
    			 ->from('db_wallet_history')
                  ->where($condition)
    			 ->get()->result();
    			 
	        
	    }
	    

			 
		//	 echo $this->db->last_query();exit();
	}
	
	
		public function customer_last_order($customer_id)
	{
		return $query = $this->db
			 ->select('*')
			 ->from('product_order')
			 ->where('customer_id ', $customer_id)
			 ->order_by("order_id","DESC")
			 ->limit(1)
			 ->get()->row();
			 
		//	 echo $this->db->last_query();exit();
	}
	
	
	
	public function get_customer_data()
	{
	    $login_type   = $this->session->userdata('type');
	    if($login_type == '0')
	    { 
    		return $query = $this->db
    			 ->select('*')
    			 ->from('customer')
    			 ->order_by("customer_id","DESC")
    			 ->get()->result();
	    }
	    else
	    {
	        
	       return $query = $this->db
    			 ->select('*')
    			 ->from('customer')
    			 ->where('franchise_id ', $login_type)
    			 ->order_by("customer_id","DESC")
    			 ->get()->result();
	    }
		//	 echo $this->db->last_query();exit();
	}
	
	
	
	          /*********************************** Customer count *************************************
     ******************************************************************************************************/
      public function get_customer_count_model()
      {
        $login_type   = $this->session->userdata('type');
	    if($login_type == '0')
	    {  
         return $query = $this->db
		 ->select('count(customer_id) AS customer_count')
		 ->from('customer')
		 ->get()->row();
	    }
	    else
	    {
    	       return $query = $this->db
    		 ->select('count(customer_id) AS customer_count')
    		 ->from('customer')
    		 ->where('franchise_id ', $login_type)
    		 ->get()->row();
	    }
 
		 //echo $this->db->last_query();exit();
           
      }
      
      
      /*********************************** Customer count *************************************
     ******************************************************************************************************/
      public function get_monthly_customer_count_model()
      {
         
        $login_type   = $this->session->userdata('type');
	    if($login_type == '0')
	    {  
         return $query = $this->db
		 ->select('count(customer_id) AS customer_count')
		 ->from('customer')
		 ->like('rdate', date('m-Y'))
		 ->get()->row();
	    }
	    else
	    {
    	       return $query = $this->db
    		 ->select('count(customer_id) AS customer_count')
    		 ->from('customer')
    		 ->like('rdate', date('m-Y'))
    		 ->where('franchise_id ', $login_type)
    		 ->get()->row();
	    }

		 //echo $this->db->last_query();exit();
           
      }
      
      
            /*********************************** Customer count *************************************
     ******************************************************************************************************/
      public function get_today_customer_count_model()
      {
          
        $login_type   = $this->session->userdata('type');
	    if($login_type == '0')
	    {  
         return $query = $this->db
		 ->select('count(customer_id) AS customer_count')
		 ->from('customer')
		->where('rdate', date('d-m-Y'))
		 ->get()->row();
	    }
	    else
	    {
    	       return $query = $this->db
    		 ->select('count(customer_id) AS customer_count')
    		 ->from('customer')
    		 ->where('rdate', date('d-m-Y'))
    		 ->where('franchise_id ', $login_type)
    		 ->get()->row();
	    } 
		 //echo $this->db->last_query();exit();
           
      }



	
	
	
    public function get_db_wallet_debit_history($db_id,$from_date,$to_date)
	{
	    
	    
	    if($from_date == '' && $to_date == '')
	    {
	        
	       return $query = $this->db
    		 ->select('s.*,p.name,p.wallet')
    		 ->from('db_wallet_history s')
    		 ->join('delivery_boy p', 's.db_id = p.db_id','left')
			 ->where('s.debit !=', NULL)
			 ->where('s.db_id ', $db_id)
			 ->order_by("s.id","DESC")
			 ->get()->result();
			 
	    }
	    else
	    {
	             $newDate = date("d-m-Y", strtotime($from_date));
                 $newDate1 = date("d-m-Y", strtotime($to_date));
                 $condition = "s.db_id = $db_id AND s.debit != 'NULL' AND (s.c_d_date BETWEEN '$newDate'  AND '$newDate1')   ORDER BY id DESC "; 
                 return $query = $this->db
        	     ->select('s.*,p.name,p.wallet')
        		 ->from('db_wallet_history s')
    		     ->join('delivery_boy p', 's.db_id = p.db_id','left')
                 ->where($condition)
    			 ->get()->result();
    			 
	        
	    }
	    

			 
		//	 echo $this->db->last_query();exit();
	}

	
	
	public function get_collect_amount_model()
	{
	   
	   $login_type   = $this->session->userdata('type');
	   
	   if($login_type == '0')
	   {
    		return $query = $this->db
    			 ->select('s.*,p.name,p.wallet,f.franchise_name')
    			 ->from('db_wallet_history s')
    			 ->join('delivery_boy p', 's.db_id = p.db_id','left')
    			 ->join('franchise f', 'f.franchise_id = p.franchise_id','left')
    			 ->where('s.debit !=', NULL)
    			 ->order_by("s.id","DESC")
    			 ->get()->result();
	   }
	   else
	   {
    		return $query = $this->db
    			 ->select('s.*,p.name,p.wallet,f.franchise_name')
    			 ->from('db_wallet_history s')
    			 ->join('delivery_boy p', 's.db_id = p.db_id','left')
    			 ->join('franchise f', 'f.franchise_id = p.franchise_id','left')
    			 ->where('s.debit !=', NULL)
    			 ->where('p.franchise_id', $login_type)
    			 ->order_by("s.id","DESC")
    			 ->get()->result();

	   }
	  
		//	 echo $this->db->last_query();exit();
	}
	
	
	function get_monthly_customer_model()
    {
        
        $login_type   = $this->session->userdata('type');
	    if($login_type == '0')
	    {    
           return $query = $this->db
    		 ->select('*')
    		 ->from('customer')
    		 ->like('rdate', date('m-Y'))
    		 ->order_by("customer_id","DESC")
    		 ->get()->result();
	    }
	    
	    else
	    {
	       return $query = $this->db
    		 ->select('*')
    		 ->from('customer')
    		 ->like('rdate', date('m-Y'))
    		 ->where('franchise_id', $login_type)
    		 ->order_by("customer_id","DESC")
    		 ->get()->result();
	        
	    }
    			 
      
        
    } 
    
    function get_today_customer_model()
    { 
        $login_type   = $this->session->userdata('type');
	    if($login_type == '0')
	    {    
           return $query = $this->db
    		 ->select('*')
    		 ->from('customer')
    		 ->where('rdate', date('d-m-Y'))
    		 ->order_by("customer_id","DESC")
    		 ->get()->result();
	    }
	    else
	    {
	       return $query = $this->db
    		 ->select('*')
    		 ->from('customer')
    		 ->where('rdate', date('d-m-Y'))
    		 ->where('franchise_id', $login_type)
    		 ->order_by("customer_id","DESC")
    		 ->get()->result();
	        
	    }
    			 
      
        
    }
    


	
		
	public function get_customer_login_wise($login_type)
	{
		return $query = $this->db
			 ->select('*')
			 ->from('customer')
			 ->where('franchise_id ', $login_type)
			 ->order_by("customer_id","DESC")
             ->get()->result();
			 
		//	 echo $this->db->last_query();exit();
	}
	
	
	public function get_db_login_wise($login_type)
	{
		return $query = $this->db
			 ->select('*')
			 ->from('delivery_boy')
			 ->where('franchise_id ', $login_type)
			 ->order_by("db_id","DESC")
             ->get()->result();
			 
		//	 echo $this->db->last_query();exit();
	}
	
	
	
	public function get_db_wise_area($db_id)
	{
		return $query = $this->db
			 ->select('d.*')
			 ->from('db_wise_area d')
			 ->where('d.db_id ', $db_id)
			 ->where("d.isActive","0")
			 ->order_by("d.id","DESC")
             ->get()->result();
			 
		//	 echo $this->db->last_query();exit();
	}
	
	
	function get_customer_model()
    {
        
        $login_type   = $this->session->userdata('type');
	    if($login_type == '0')
	    {    
           return $query = $this->db
    		 ->select('*')
    		 ->from('customer')
    		 ->order_by("customer_id","DESC")
    		 ->get()->result();
	    }
	    
	    else
	    {
	       return $query = $this->db
    		 ->select('*')
    		 ->from('customer')
    		 ->where('franchise_id', $login_type)
    		 ->order_by("customer_id","DESC")
    		 ->get()->result();
	        
	    }
    			 
      
        
    }
    
    
    
    
    /****************************** Customer List    **************/

    function incustomer_count()
    { 
        
           $login_type   = $this->session->userdata('type');
    	    if($login_type == '0')
    	    { 
    	        
    	   $query = $this->db
        	->select('c.*')
        	->from('customer c')
        	->where("c.customer_id NOT IN (SELECT customer_id FROM product_order)", NULL, FALSE)
        	->order_by("c.customer_id","DESC")
        	->get();
    	    }
    	    else
    	    {
    	       $query = $this->db
        	->select('c.*')
        	->from('customer c')
        	->where("c.customer_id NOT IN (SELECT customer_id FROM product_order)", NULL, FALSE)
        	->where('c.franchise_id',$login_type)
        	->order_by("c.customer_id","DESC")
        	->get();
    
    	        
    	    }
    
        return $query->num_rows();  
    
    }
        
        
    function incustomer_list($limit,$start,$col,$dir)
    { 
        $login_type   = $this->session->userdata('type');
        if($login_type == '0')
        { 
    	        
      	   $query = $this->db
        	->select('c.*')
        	->from('customer c')
        	->where("c.customer_id NOT IN (SELECT customer_id FROM product_order)", NULL, FALSE)
        	->order_by("c.customer_id","DESC")
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
        	->select('c.*')
        	->from('customer c')
             ->where("c.customer_id NOT IN (SELECT customer_id FROM product_order)", NULL, FALSE)
             ->where('c.franchise_id',$login_type)
        	->order_by("c.customer_id","DESC")
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


    function incustomer_search($limit,$start,$search,$col,$dir)
    {
        $login_type   = $this->session->userdata('type');
        if($login_type == '0')
        {
            $query = $this
                    ->db
                    
                    ->or_like('c.first_name',$search)
                    ->or_like('c.last_name',$search)
                    ->or_like('c.mobile_no',$search)
                    ->or_like('c.email_id',$search)
                     ->where("c.customer_id NOT IN (SELECT customer_id FROM product_order)", NULL, FALSE)
                    ->limit($limit,$start)
                    ->order_by($col,$dir)
                    ->get('customer c');
            
           
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
            
            $query = $this
                    ->db
                    
                    ->or_like('c.first_name',$search)
                    ->or_like('c.last_name',$search)
                    ->or_like('c.mobile_no',$search)
                    ->or_like('c.email_id',$search)
                     ->where("c.customer_id NOT IN (SELECT customer_id FROM product_order)", NULL, FALSE)
                    ->where('c.franchise_id',$login_type)
                    ->limit($limit,$start)
                    ->order_by($col,$dir)
                    
                    ->get('customer c');
            
           
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
    
    function incustomer_search_count($search)
    {
        $login_type   = $this->session->userdata('type');
        if($login_type == '0')
        {
            $query = $this
                    ->db
                    
                    ->or_like('c.first_name',$search)
                    ->or_like('c.last_name',$search)
                    ->or_like('c.mobile_no',$search)
                    ->or_like('c.email_id',$search)
                     ->where("c.customer_id NOT IN (SELECT customer_id FROM product_order)", NULL, FALSE)
                    ->get('customer c');
        }
        else
        {
             $query = $this
                    ->db
                    ->or_like('c.first_name',$search)
                    ->or_like('c.last_name',$search)
                    ->or_like('c.mobile_no',$search)
                    ->or_like('c.email_id',$search)
                    ->where('c.franchise_id',$login_type)
                     ->where("c.customer_id NOT IN (SELECT customer_id FROM product_order)", NULL, FALSE)
                    ->get('customer c');
            
        }
    
       return $query->num_rows();
       //echo $this->db->last_query();exit();
    }
    
    function shoot_sms()
    {
       return $query = $this->db
        	->select('c.*')
        	->from('customer c')
             ->where("c.customer_id NOT IN (SELECT customer_id FROM product_order)", NULL, FALSE)
             ->where('c.franchise_id','1')
        	->order_by("c.customer_id","DESC")
        	->get()->result();
        	
        //	echo $this->db->last_query();exit();
    }
    

/*******************************************************************************/
}

?>