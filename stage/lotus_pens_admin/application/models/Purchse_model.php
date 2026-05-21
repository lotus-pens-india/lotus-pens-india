<?php

class Purchse_model extends CI_Model {


    
/****************************** Supplier List    **************/

	public function get_all_supplier_model()
	{
	   $login_type   = $this->session->userdata('type');
	    if($login_type == '0')
	    {
		return $query = $this->db
			 ->select('b.*,f.franchise_name')
			 ->from('supplier b')
			 ->join('franchise f', 'b.franchise_id = f.franchise_id','left')
			 ->where('b.isActive','0')
    			 ->order_by("b.supplier_id","DESC")
    			 ->get()->result();
	    }
	    else
	    {
		return $query = $this->db
			 ->select('b.*,f.franchise_name')
			 ->from('supplier b')
			 ->join('franchise f', 'b.franchise_id = f.franchise_id','left')
			 ->where('b.isActive','0')
    			 ->where('b.franchise_id',$login_type)
    			 ->order_by("b.supplier_id","DESC")
    			 ->get()->result();
	        
	    }
    			 
		//	echo $this->db->last_query();exit();
	}
	
	
    /****************************** Total Purchse List    **************/

function total_purchse_count()
{  
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
	   $query = $this->db
    	->select('p.*,c.company_name,f.franchise_name')
    	->from('purchse_order p')
    	->join('supplier c', 'p.supplier_id = c.supplier_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->order_by("p.p_id","DESC")
    	->get();
	 }
	 else
	 {
	  
	   $query = $this->db
    	->select('p.*,c.company_name,f.franchise_name')
    	->from('purchse_order p')
    	->join('supplier c', 'p.supplier_id = c.supplier_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where('p.franchise_id', $login_type)
    	->order_by("p.p_id","DESC")
    	->get();   
	 }

    return $query->num_rows();  

}


function total_purchse_list($limit,$start,$col,$dir)
{ 
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
	   $query = $this->db
    	->select('p.*,c.company_name,f.franchise_name')
    	->from('purchse_order p')
    	->join('supplier c', 'p.supplier_id = c.supplier_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
        ->order_by("p.p_id","DESC")
        ->limit($limit,$start)
    	->get();
	 }
	 else
	 {
	   $query = $this->db
    	->select('p.*,c.company_name,f.franchise_name')
    	->from('purchse_order p')
    	->join('supplier c', 'p.supplier_id = c.supplier_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->where('p.franchise_id', $login_type)
        ->order_by("p.p_id","DESC")
        ->limit($limit,$start)
    	->get(); 
    	
    	//echo $this->db->last_query();exit();
	     
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



function total_purchse_search($limit,$start,$search,$col,$dir)
{
    
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {
	   $query = $this->db
    	->select('p.*,c.company_name,f.franchise_name')
    	->from('purchse_order p')
    	->join('supplier c', 'p.supplier_id = c.supplier_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->or_like('c.company_name',$search)
        ->or_like('p.purchse_date',$search)
        ->or_like('f.franchise_name',$search)
        ->order_by("p.p_id","DESC")
        ->limit($limit,$start)
    	->get();
	 }
	 else
	 {
	   $query = $this->db
    	->select('p.*,c.company_name,f.franchise_name')
    	->from('purchse_order p')
    	->join('supplier c', 'p.supplier_id = c.supplier_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->or_like('c.company_name',$search)
        ->or_like('p.purchse_date',$search)
        ->or_like('f.franchise_name',$search)
        ->where('p.franchise_id', $login_type)
        ->order_by("p.p_id","DESC")
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


    function total_purchse_search_count($search)
    {
        
     $login_type   = $this->session->userdata('type');  
	 if($login_type == '0')
	 {    
	   $query = $this->db
    	->select('p.*,c.company_name,f.franchise_name')
    	->from('purchse_order p')
    	->join('supplier c', 'p.supplier_id = c.supplier_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->or_like('c.company_name',$search)
        ->or_like('p.purchse_date',$search)
            ->or_like('f.franchise_name',$search)
            
            ->order_by("p.p_id","DESC")
        	->get();
	 }
	 
	 else
	 {
	   $query = $this->db
    	->select('p.*,c.company_name,f.franchise_name')
    	->from('purchse_order p')
    	->join('supplier c', 'p.supplier_id = c.supplier_id','left')
    	->join('franchise f', 'p.franchise_id = f.franchise_id','left')
    	->or_like('c.company_name',$search)
        ->or_like('p.purchse_date',$search)
            ->or_like('f.franchise_name',$search)
            ->where('p.franchise_id', $login_type)
            ->order_by("p.p_id","DESC")
        	->get();
	     
	 }
    	
         return $query->num_rows();
        
        // echo $this->db->last_query();exit();
    }	
	
    
    
    
    
     public function get_order_summary($p_id)
    {
          return $query = $this->db
    			 ->select('p.*,c.company_name,c.mobile_no,c.email_id,c.address')
              	->from('purchse_order p')
    			 ->join('supplier c', 'p.supplier_id = c.supplier_id','left')
    			 ->where('p.p_id', $p_id)
    			 ->get()->row();
    }
    
    
          public function get_item_details($p_id)
    {
          return $query = $this->db
    			 ->select('o.*,c.product_name')
    			 ->from('purchse_order_detail o')
    			 ->join('vegshopy_product c', 'o.product_id = c.product_id','left')
    			 ->where('o.p_id', $p_id)
    			 ->get()->result();
    }
    
    
    
    
    function purchse_report($date_from,$date_to)
    {
      $newDate = date("m-d-Y", strtotime($date_from));
      $newDate1 = date("m-d-Y", strtotime($date_to));
      
         $login_type   = $this->session->userdata('type'); 
         
    	 if($login_type == '0')
         {  
            $condition = "(s.purchse_date BETWEEN '$newDate'  AND '$newDate1')  ORDER BY p_id DESC ";
            return  $query = $this->db
        	->select('p.*,c.company_name,v.product_name,s.purchse_date')
        	->from('purchse_order_detail p')
        	->join('purchse_order s', 'p.p_id = s.p_id','left')
        	->join('supplier c', 's.supplier_id = c.supplier_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
    		->where($condition)
    	    ->get()->result();
         }
         else
         {
            
            $condition = " p.franchise_id = $login_type AND (s.purchse_date BETWEEN '$newDate'  AND '$newDate1')  ORDER BY p_id DESC ";
            return  $query = $this->db
        	  ->select('p.*,c.company_name,v.product_name,s.purchse_date')
        	->from('purchse_order_detail p')
        	->join('purchse_order s', 'p.p_id = s.p_id','left')
        	->join('supplier c', 's.supplier_id = c.supplier_id','left')
        	->join('vegshopy_product v', 'p.product_id = v.product_id','left')
    		->where($condition)
    	    ->get()->result();
    	    
    	    //echo $this->db->last_query();exit();
    	    
         }
        
    }
    
    
    
    function purchse_report1($date_from,$date_to)
    {
      $newDate = date("m-d-Y", strtotime($date_from));
      $newDate1 = date("m-d-Y", strtotime($date_to));
      
         $login_type   = $this->session->userdata('type'); 
         
    	 if($login_type == '0')
         {  
            return  $query = $this->db
        	->select('p.*,c.name')
        	->from('vegshopy_product p')
        	->join('category c', 'p.category_id = c.category_id','left')
        	->order_by("p.product_id","DESC")
    	    ->get()->result();
         }
         else
         {
            
            return  $query = $this->db
        	->select('p.*,c.name')
        	->from('vegshopy_product p')
        	->join('category c', 'p.category_id = c.category_id','left')
        	->where('p.franchise_id', $login_type)
        	->order_by("p.product_id","DESC")
    	    ->get()->result();
    	    
    	    //echo $this->db->last_query();exit();
    	    
         }
        
    }
    
    
    
    
   function date_wise_stock_count($product_id,$date_from,$date_to)
    {
      $newDate = date("m-d-Y", strtotime($date_from));
      $newDate1 = date("m-d-Y", strtotime($date_to));
      
         $login_type   = $this->session->userdata('type'); 
         
    	 if($login_type == '0')
         {  
            $condition = " product_id = $product_id AND (p_date BETWEEN '$newDate'  AND '$newDate1') ";
            return  $query = $this->db
        	  ->select('SUM(qty) AS stock')
        	->from('purchse_order_detail')
    		->where($condition)
    	    ->get()->row();
         }
         else
         {
            
            $condition = " product_id = $product_id AND franchise_id = $login_type AND (p_date BETWEEN '$newDate'  AND '$newDate1') ";
            return  $query = $this->db
        	  ->select('SUM(qty) AS stock')
        	->from('purchse_order_detail')
    		->where($condition)
    	    ->get()->row();
    	    
    	    //echo $this->db->last_query();exit();
    	    
         }
        
    }
     
/*******************************************************************************/
}

?>