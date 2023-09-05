<?php

class Product_model extends CI_Model {

    public function get_all_cities_by_state_id($state_id)
    {
          return $query = $this->db
    			 ->select('city_id, city_name')
    			 ->from('city_master')
    			 ->where('state_id', $state_id)
    			 ->order_by('city_name', 'ASC')
    			 ->get()->result();
    }
    
    
    
    public function get_all_area_by_zone_id($zone_id)
    {
          return $query = $this->db
    			 ->select('area_id, area_name')
    			 ->from('area')
    			 ->where('zone_id', $zone_id)
    			 ->order_by('area_id', 'ASC')
    			 ->get()->result();
    }
    
/****************************** Brand List    **************/

	public function get_all_brand_model()
	{
	    	    $login_type   = $this->session->userdata('type');
	    if($login_type == '0')
	    {
		return $query = $this->db
			 ->select('b.*,f.franchise_name')
			 ->from('brand b')
			 ->join('franchise f', 'b.franchise_id = f.franchise_id','left')
    			 ->order_by("b.brand_id","DESC")
    			 ->get()->result();
	    }
	    else
	    {
		return $query = $this->db
			 ->select('b.*,f.franchise_name')
			 ->from('brand b')
			 ->join('franchise f', 'b.franchise_id = f.franchise_id','left')
    			 ->where('b.franchise_id',$login_type)
    			 ->order_by("b.brand_id","DESC")
    			 ->get()->result();
	        
	    }
    			 
		//	echo $this->db->last_query();exit();
	}
	
/****************************** Category List    **************/

	public function get_all_category_model()
	{
	    
	    	    $login_type   = $this->session->userdata('type');
	    if($login_type == '0')
	    {
		return $query = $this->db
			 ->select('b.*,f.franchise_name')
			 ->from('category b')
			 ->join('franchise f', 'b.franchise_id = f.franchise_id','left')
    			 ->order_by("b.category_id","DESC")
    			 ->get()->result();
	    }
	    else
	    {
		return $query = $this->db
			 ->select('b.*,f.franchise_name')
			 ->from('category b')
			 ->join('franchise f', 'b.franchise_id = f.franchise_id','left')
    			 ->where('b.franchise_id',$login_type)
    			 ->order_by("b.category_id","DESC")
    			 ->get()->result();
	        
	    }
			 
		//	 echo $this->db->last_query();exit();
	}

/****************************** Category List    **************/

	public function get_all_category_model1($franchise_id)
	{
		return $query = $this->db
			 ->select('*')
			 ->from('category')
			 ->where('isActive', '0')
			 ->where('franchise_id', $franchise_id)
			 ->order_by("position","ASC")
			 ->get()->result();
			 
		//	 echo $this->db->last_query();exit();
	}	
	
	

/****************************** Subcategory List    **************/

    public function get_all_subcategory_model()
    {
      $login_type   = $this->session->userdata('type');
      
      if($login_type == '0')
      {
       	$query = $this->db
    	->select('ss.*,c.name,f.franchise_name')
    	->from('sub_category ss')
    	->join('category c', 'ss.category_id = c.category_id','left')
    	->join('franchise f', 'f.franchise_id = ss.franchise_id','left')
    	->order_by("ss.sub_category_id","DESC")
    	->get();
      }
      else
      {
       	$query = $this->db
    	->select('ss.*,c.name,f.franchise_name')
    	->from('sub_category ss')
    	->join('category c', 'ss.category_id = c.category_id','left')
    	->join('franchise f', 'f.franchise_id = ss.franchise_id','left')
    	->where('ss.franchise_id', $login_type)
    	->order_by("ss.sub_category_id","DESC")
    	->get(); 
          
      }
    	$num_row = $query->num_rows();
    	if($num_row > 0)
    	{
    	$result = $query->result_array();
    	foreach($result as $row){
    		$data[] = array
           (
        		'category'          => $row['name'],
				'category_id'       => $row['category_id'],
        		'sub_category'      => $row['sub_category'],
        		'icon'              => $row['icon'],
        		'sub_category_id'   => $row['sub_category_id'],
        		'franchise_name'   => $row['franchise_name'],
        		'color'   => $row['color'],
        

    	
    		);
    
    	}
    	return $data;
        //echo "<pre>";print_r($data);exit;
       }
       //echo $this->db->last_query();die();
	
    }



/****************************** Categoryid wise Subcategory list   **************/  

  public function get_all_sub_subcategory_by_category_id($category_id)
    {
          return $query = $this->db
    			 ->select('s.*,c.name')
    			 ->from('sub_category s')
    			 ->join('category c', 's.category_id = c.category_id','left')
    			 ->where('s.category_id', $category_id)
    			 ->get()->result();
    }	

/****************************** Sub Subcategory List    **************/


    public function get_all_sub_subcategory_model()
    {
      
      $login_type   = $this->session->userdata('type');
      if($login_type == '0')
      {
          return $query = $this->db
    			 ->select('ss.*,c.name,s.sub_category')
    			 ->from('sub_subcategory ss')
    			 ->join('category c', 'ss.category_id = c.category_id','left')
				  ->join('sub_category s', 'ss.sub_category_id = s.sub_category_id','left')
    			 ->order_by("ss.category_id","DESC")
    			 ->get()->result();
      }
      else
      {
       
        return $query = $this->db
    			 ->select('ss.*,c.name,s.sub_category')
    			 ->from('sub_subcategory ss')
    			 ->join('category c', 'ss.category_id = c.category_id','left')
				  ->join('sub_category s', 'ss.sub_category_id = s.sub_category_id','left')
				  ->where('s.franchise_id', $login_type)
    			 ->order_by("ss.category_id","DESC")
    			 ->get()->result();
          
      }
    }
	
	/****************************** Pincode List    **************/

	public function get_all_pincode_model()
	{
	    $login_type   = $this->session->userdata('type');
	    if($login_type =='0')
	    {
    		return $query = $this->db
    			 ->select('p.*,f.franchise_name')
    			 ->from('pincode p')
    			 ->join('franchise f', 'f.franchise_id = p.franchise_id','left')
    			 ->order_by("p.pincode_id","DESC")
    			 ->get()->result();
	    }
	    else
	    {
    		return $query = $this->db
    			 ->select('p.*,f.franchise_name')
    			 ->from('pincode p')
    			 ->join('franchise f', 'f.franchise_id = p.franchise_id','left')
    			 ->where('p.franchise_id', $login_type)
    			 ->order_by("p.pincode_id","DESC")
    			 ->get()->result();
	    }
		//	 echo $this->db->last_query();exit();
	}
	

	
	
		/****************************** SubCategoryid wise Sub_SubCategory list   **************/  
  public function get_all_all_sub_subcategory_by_sub_category_id($sub_category_id)
    {
          return $query = $this->db
    			 ->select('*')
    			 ->from('sub_subcategory s')
    			 ->where('sub_category_id', $sub_category_id)
    			 ->get()->result();
				 

    }
	
	


	public function get_product_details($product_id)
	{
		return $query = $this->db
			 ->select('*')
			 ->from('product_details')
			 ->where('product_id', $product_id)
			 ->get()->result();
			 
		//	 echo $this->db->last_query();exit();
	}
	
	/****************************** Banner List    **************/

	public function get_all_banner_model()
	{
	    $login_type   = $this->session->userdata('type');
	    if($login_type == '0')
	    {
		return $query = $this->db
			 ->select('b.*,f.franchise_name')
			 ->from('banner b')
			 ->join('franchise f', 'b.franchise_id = f.franchise_id','left')
    			 ->order_by("b.banner_id","DESC")
    			 ->get()->result();
	    }
	    else
	    {
		return $query = $this->db
			 ->select('b.*,f.franchise_name')
			 ->from('banner b')
			 ->join('franchise f', 'b.franchise_id = f.franchise_id','left')
    			 ->where('b.franchise_id',$login_type)
    			 ->order_by("b.banner_id","DESC")
    			 ->get()->result();
	        
	    }
			 
		//	 echo $this->db->last_query();exit();
	}
	
	
		/****************************** Banner List    **************/

	public function get_all_banner_model1($franchise_id)
	{
		return $query = $this->db
			 ->select('*')
			 ->from('banner')
			 ->where('isActive', '0')
			  ->where('franchise_id', $franchise_id)
			 ->order_by("position","ASC")
			 ->get()->result();
			 
		//	 echo $this->db->last_query();exit();
	}
	
    public function get_all_subcategory_id_wise_model($category_id,$franchise_id)
	{
		return $query = $this->db
			 ->select('*')
			 ->from('sub_category')
			 ->where('category_id', $category_id)
			 ->where('franchise_id', $franchise_id)
			 ->get()->result();
			 
		//	 echo $this->db->last_query();exit();
	}
	
	
	public function get_all_sub_subcategory_id_wise_model($sub_category_id,$franchise_id)
	{
		return $query = $this->db
			 ->select('*')
			 ->from('sub_subcategory')
			 ->where('sub_category_id', $sub_category_id)
			 ->where('franchise_id', $franchise_id)
			 ->get()->result();
			 
		//	 echo $this->db->last_query();exit();
	}
	
	
	
	
	
	/****************************** Product list Id Wise  **************/  
  public function get_all_product_id_wise_model($category_id,$franchise_id)
  {
          return $query = $this->db
    			 ->select('p.*,c.name,s.sub_category,ss.sub_subcategory,b.brand_name')
    			 ->from('vegshopy_product p')
    			 ->join('category c', 'p.category_id = c.category_id','left')
				 ->join('sub_category s', 'p.sub_category_id = s.sub_category_id','left')
				 ->join('sub_subcategory ss', 'p.sub_subcategory_id = ss.sub_subcategory_id','left')
				 ->join('brand b', 'p.brand_id = b.brand_id','left')
				 ->where('p.category_id', $category_id)
				 ->where('p.franchise_id', $franchise_id)
    			 ->order_by("p.qty","DESC")
    			 ->get()->result();
				 
				// echo $this->db->last_query();exit();
    }
    
    
    
      public function get_all_product_subcategory_id_wise_model($sub_category_id,$franchise_id)
  {
          return $query = $this->db
    			 ->select('p.*,c.name,s.sub_category,ss.sub_subcategory,b.brand_name')
    			 ->from('vegshopy_product p')
    			 ->join('category c', 'p.category_id = c.category_id','left')
				 ->join('sub_category s', 'p.sub_category_id = s.sub_category_id','left')
				 ->join('sub_subcategory ss', 'p.sub_subcategory_id = ss.sub_subcategory_id','left')
				 ->join('brand b', 'p.brand_id = b.brand_id','left')
				 ->where('p.sub_category_id', $sub_category_id)
				 ->where('p.franchise_id', $franchise_id)
    			 ->order_by("p.qty","DESC")
    			 ->get()->result();
				 
				// echo $this->db->last_query();exit();
    }
    
    
         public function get_all_product_sub_subcategory_id_wise_model($sub_subcategory_id,$franchise_id)
        {
          return $query = $this->db
    			 ->select('p.*,c.name,s.sub_category,ss.sub_subcategory,b.brand_name')
    			 ->from('vegshopy_product p')
    			 ->join('category c', 'p.category_id = c.category_id','left')
				 ->join('sub_category s', 'p.sub_category_id = s.sub_category_id','left')
				 ->join('sub_subcategory ss', 'p.sub_subcategory_id = ss.sub_subcategory_id','left')
				 ->join('brand b', 'p.brand_id = b.brand_id','left')
				 ->where('p.sub_subcategory_id', $sub_subcategory_id)
				 ->where('p.franchise_id', $franchise_id)
    			 ->order_by("p.qty","DESC")
    			 ->get()->result();
				 
				// echo $this->db->last_query();exit();
    }
    
    public function product_details_product_id_wise($product_id)
	{
		return $query = $this->db
			 ->select('*')
			 ->from('product_details')
			 ->where('product_id', $product_id)
			 ->order_by("product_id","ASC")
			 ->limit(1)
			 ->get()->result_array();
			 
		//	 echo $this->db->last_query();exit();
	}
	
	
	    public function product_details_product_id_wise1($product_id)
	{
		return $query = $this->db
			 ->select('*')
			 ->from('product_details')
			 ->where('product_id', $product_id)
			 ->order_by("product_id","ASC")
			 ->get()->result_array();
			 
		//	 echo $this->db->last_query();exit();
	}
	
	
	

	
	
	  public function get_all_product_details_id_wise_model($product_id)
  {
          return $query = $this->db
    			 ->select('p.*,c.name,s.sub_category,ss.sub_subcategory,b.brand_name')
    			 ->from('vegshopy_product p')
    			 ->join('category c', 'p.category_id = c.category_id','left')
				 ->join('sub_category s', 'p.sub_category_id = s.sub_category_id','left')
				 ->join('sub_subcategory ss', 'p.sub_subcategory_id = ss.sub_subcategory_id','left')
				 ->join('brand b', 'p.brand_id = b.brand_id','left')
				 ->where('p.product_id', $product_id)
    			 ->get()->row();
				 
				// echo $this->db->last_query();exit();
    }
    
    
    
    /****************************** Cart COunt    **************/

	public function get_cart_count_model($customer_id)
	{
		return $query = $this->db
			 ->select('COUNT(id) as count')
			 ->from('add_to_cart')
			 ->where('customer_id', $customer_id)
			 ->get()->row();
			 
		//	 echo $this->db->last_query();exit();
	}
	 
	 

 /****************************** Cart Wise Product **************/  
  public function get_cart_product_wise_model($customer_id)
  {
          return $query = $this->db
    			 ->select('a.*,p.product_name,p.main_image,p.product_id as pid')
    			 ->from('add_to_cart a')
    			 ->join('vegshopy_product p', 'p.product_id = a.product_id','left')
				 ->where('a.customer_id', $customer_id)
    			 ->get()->result();
				 
				// echo $this->db->last_query();exit();
    } 
    
    
    
     /****************************** Save Wise Product **************/  
  public function get_save_product_wise_model($customer_id)
  {
          return $query = $this->db
    			 ->select('a.*,p.product_name,p.main_image,p.product_id as pid')
    			 ->from('save_for_later a')
    			 ->join('vegshopy_product p', 'p.product_id = a.product_id','left')
				 ->where('a.customer_id', $customer_id)
    			 ->get()->result();
				 
				// echo $this->db->last_query();exit();
    } 
    
    

	
  public function tuesday_time_slot()
  {
      $login_type   = $this->session->userdata('type');
      if($login_type =='0')
      {
          return $query = $this->db
    			 ->select('*')
    			 ->from('slot_timing')
				 ->where('day', 'Tuesday')
    			 ->get()->result();
      }
      else
      {
        return $query = $this->db
    			 ->select('*')
    			 ->from('slot_timing')
				 ->where('day', 'Tuesday')
				 ->where('franchise_id', $login_type)
    			 ->get()->result();  
          
      }
				 
				// echo $this->db->last_query();exit();
    }
    
    
    
    
      public function get_all_slot_model()
  {
      $login_type   = $this->session->userdata('type');
      if($login_type =='0')
      {
          return $query = $this->db
    			 ->select('*')
    			 ->from('slot_timing')
				 ->where('isActive', '0')
				 ->order_by('slot_id', 'DESC')
    			 ->get()->result();
      }
      else
      {
        return $query = $this->db
    			 ->select('*')
    			 ->from('slot_timing')
				 ->where('isActive', '0')
				 ->where('franchise_id', $login_type)
				 ->order_by('slot_id', 'DESC')
    			 ->get()->result();  
          
      }
				 
				// echo $this->db->last_query();exit();
    } 
    
    
    
  public function monday_time_slot()
  {
      $login_type   = $this->session->userdata('type');
      if($login_type =='0')
      {
          return $query = $this->db
    			 ->select('*')
    			 ->from('slot_timing')
				 ->where('day', 'Monday')
    			 ->get()->result();
      }
      else
      {
        return $query = $this->db
    			 ->select('*')
    			 ->from('slot_timing')
				 ->where('day', 'Monday')
				 ->where('franchise_id', $login_type)
    			 ->get()->result();  
          
      }
				// echo $this->db->last_query();exit();
    }
    
    
    
 public function wednesday_time_slot()
  {
      $login_type   = $this->session->userdata('type');
      if($login_type =='0')
      {
          return $query = $this->db
    			 ->select('*')
    			 ->from('slot_timing')
				 ->where('day', 'Wednesday')
    			 ->get()->result();
      }
      else
      {
        return $query = $this->db
    			 ->select('*')
    			 ->from('slot_timing')
				 ->where('day', 'Wednesday')
				 ->where('franchise_id', $login_type)
    			 ->get()->result();  
          
      }
				 
				// echo $this->db->last_query();exit();
    } 
    
    
    
  public function thursday_time_slot()
  {
      $login_type   = $this->session->userdata('type');
      if($login_type =='0')
      {
          return $query = $this->db
    			 ->select('*')
    			 ->from('slot_timing')
				 ->where('day', 'Thursday')
    			 ->get()->result();
      }
      else
      {
        return $query = $this->db
    			 ->select('*')
    			 ->from('slot_timing')
				 ->where('day', 'Thursday')
				 ->where('franchise_id', $login_type)
    			 ->get()->result();  
          
      }
				 
				// echo $this->db->last_query();exit();
    } 
    
    
    
    public function friday_time_slot()
  {
      $login_type   = $this->session->userdata('type');
      if($login_type =='0')
      {
          return $query = $this->db
    			 ->select('*')
    			 ->from('slot_timing')
				 ->where('day', 'Friday')
    			 ->get()->result();
      }
      else
      {
        return $query = $this->db
    			 ->select('*')
    			 ->from('slot_timing')
				 ->where('day', 'Friday')
				 ->where('franchise_id', $login_type)
    			 ->get()->result();  
          
      }
				 
				// echo $this->db->last_query();exit();
    }
    
    
  public function saturday_time_slot()
  {
      $login_type   = $this->session->userdata('type');
      if($login_type =='0')
      {
          return $query = $this->db
    			 ->select('*')
    			 ->from('slot_timing')
				 ->where('day', 'Saturday')
    			 ->get()->result();
      }
      else
      {
        return $query = $this->db
    			 ->select('*')
    			 ->from('slot_timing')
				 ->where('day', 'Saturday')
				 ->where('franchise_id', $login_type)
    			 ->get()->result();  
          
      }
				 
				// echo $this->db->last_query();exit();
    } 
    
    
    
public function sunday_time_slot()
  {
      $login_type   = $this->session->userdata('type');
      if($login_type =='0')
      {
          return $query = $this->db
    			 ->select('*')
    			 ->from('slot_timing')
				 ->where('day', 'Sunday')
    			 ->get()->result();
      }
      else
      {
        return $query = $this->db
    			 ->select('*')
    			 ->from('slot_timing')
				 ->where('day', 'Sunday')
				 ->where('franchise_id', $login_type)
    			 ->get()->result();  
          
      }
				 
				// echo $this->db->last_query();exit();
    } 
    
    
    
  public function get_slot_day_wise_model($current_day,$franchise_id)
  {
         return  $query = $this->db
    			 ->select('*')
    			 ->from('slot_timing')
    			 /*->where('day',$current_day)*/
				 ->where('flag','Active')
				 ->where('franchise_id', $franchise_id)
    			 ->get()->result();
				 
			//	 echo $this->db->last_query();exit();
    } 
    
    
    
      public function get_slot_id_wise_model($slot_id)
  {
          return $query = $this->db
    			 ->select('*')
    			 ->from('slot_timing')
				 ->where('slot_id',$slot_id)
    			 ->get()->row();
				 
				// echo $this->db->last_query();exit();
    } 
    
    
    
    	 
 /****************************** coupon **************/  
 
 
  public function get_all_coupon_model()
    {
        $current_date  = date('Y-m-d');
          return $query = $this->db
    			 ->select('*')
    			 ->from('coupon')
    			 ->where('validity >=', $current_date)
    			 ->get()->result();
				 

    }
    
      public function get_all_coupon_model1($franchise_id)
    {
        $current_date  = date('Y-m-d');
          return $query = $this->db
    			 ->select('*')
    			 ->from('coupon')
    			 ->where('validity >=', $current_date)
    			 ->where('flag','0')
    			 ->where('isActive','0')
    			 ->where('franchise_id', $franchise_id)
    			 ->get()->result();
				 

    }
    
    public function get_all_coupon_model11($franchise_id)
    {
        $current_date  = date('Y-m-d');
          return $query = $this->db
    			 ->select('*')
    			 ->from('coupon')
    			 ->where('validity >=', $current_date)
    			 ->where('flag','1')
    			 ->where('isActive','0')
    			 ->where('franchise_id', $franchise_id)
    			 ->get()->result();
				 

    }

            
   /****************************** Address list   **************/  
  public function get_customer_wise_address_model($customer_id)
    {
          return $query = $this->db
    			 ->select('*')
    			 ->from('customer_address')
    			 ->where('customer_id', $customer_id)
    			 ->get()->result();
    }
    
    
    /****************************** Order Summary   **************/  

  public function get_order_summary($order_id)
    {
          return $query = $this->db
    			 ->select('o.*,c.first_name,c.last_name,c.mobile_no,c.email_id,v.zone_name')
    			 ->from('product_order o')
    			 ->join('customer c', 'o.customer_id = c.customer_id','left')
    			 ->join('zone v', 'o.zone_id = v.zone_id','left')
    			 ->where('o.order_generate_id', $order_id)
    			 ->get()->row();
    }
    
    
    
    
      public function get_item_details($order_id)
    {
          return $query = $this->db
    			 ->select('o.*,c.product_name,a.id as unit_id')
    			 ->from('order_detail o')
    			 ->join('vegshopy_product c', 'o.product_id = c.product_id','left')
    			 ->join('product_details a', 'o.product_id = a.product_id','left')
    			 ->where('o.order_id', $order_id)
    			 ->get()->result();
    			 
    			 
    }
    
    
    
        
      public function get_item_details1($order_id)
    {
          return $query = $this->db
    			 ->select('o.*,c.product_name')
    			 ->from('order_detail o')
    			 ->join('vegshopy_product c', 'o.product_id = c.product_id','left')
    			 ->where('o.order_id', $order_id)
    			 ->get()->result();
    			 
    			 
    }
    
    
    		    public function product_details_product_id_wise2($product_id)
	{
		return $query = $this->db
			 ->select('*')
			 ->from('product_details')
			 ->where('product_id', $product_id)
			 ->order_by("product_id","ASC")
			 ->get()->result();
			 
		//	 echo $this->db->last_query();exit();
	}
    
    
      public function get_coupon_value($coupon_id)
    {
          return $query = $this->db
    			 ->select('*')
    			 ->from('coupon')
    			 ->where('coupon_id', $coupon_id)
    			 ->get()->row();
    }
    
    
    public function getAllProduct($term,$franchise_id) 
            {
            
                $this->db->select('*');
                $this->db->from('vegshopy_product');
                $this->db->like('product_name', $term);
                $this->db->where('franchise_id', $franchise_id);
                $query1 = $this->db->get();
                $result1 = $query1->result();
                return $result1;
            
        }
        
        
    /****************************** Product list   **************/  
  public function get_all_product_recommend_model()
  {
          return $query = $this->db
    			 ->select('*')
    			 ->from('vegshopy_product p')
    			 ->group_by('sub_category_id')
    			 ->order_by("product_id","DESC")
    			 ->get()->result();
				 
				// echo $this->db->last_query();exit();
    } 
    
    
    
    /****************************** Pickup point List    **************/

	public function get_all_pickup_point_model()
	{
	   $login_type   = $this->session->userdata('type'); 
	   if($login_type == '0')
	   {
		return $query = $this->db
			 ->select('p.*,f.franchise_name')
			 ->from('pickup_point p')
			 ->join('franchise f', 'p.franchise_id = f.franchise_id','left')
			 ->order_by("p.pick_up_id","DESC")
			 ->get()->result();
	    }
	    else
	    {
		return $query = $this->db
			 ->select('p.*,f.franchise_name')
			 ->from('pickup_point p')
			 ->join('franchise f', 'p.franchise_id = f.franchise_id','left')
			 ->where('p.franchise_id', $login_type)
			 ->order_by("p.pick_up_id","DESC")
			 ->get()->result();
	        
	    }
			 
		//	 echo $this->db->last_query();exit();
	}
	
	
  public function assign_to_details($assign_to)
    {
          return $query = $this->db
    			 ->select('*')
    			 ->from('delivery_boy')
    			 ->where('db_id', $assign_to)
    			 ->get()->row();
				 

    }
    
    

/****************************** Product List    **************/

function product_count()
{ 
    $login_type   = $this->session->userdata('type');
    if($login_type == '0')
    {
        $query = $this->db
        	->select('p.*,c.name,b.brand_name')
        	->from('vegshopy_product p')
        	->join('category c', 'p.category_id = c.category_id','left')
        	->join('brand b', 'p.brand_id = b.brand_id','left')
        	->order_by("p.product_id","DESC")
        	->get();
    }
    else
    {
        $query = $this->db
        	->select('p.*,c.name,b.brand_name')
        	->from('vegshopy_product p')
        	->join('category c', 'p.category_id = c.category_id','left')
        	->join('brand b', 'p.brand_id = b.brand_id','left')
        	->where('p.franchise_id', $login_type)
        	->order_by("p.product_id","DESC")
        	->get();
        
    }
    return $query->num_rows();  

}
function product_list($limit,$start,$col,$dir)
{ 
    $login_type   = $this->session->userdata('type');
    if($login_type == '0')
    {
       	$query = $this->db
    	->select('p.*,c.name,b.brand_name')
    	->from('vegshopy_product p')
    	->join('category c', 'p.category_id = c.category_id','left')
    	->join('brand b', 'p.brand_id = b.brand_id','left')
    	->order_by("p.product_id","DESC")
        ->limit($limit,$start)
    	->get();
    }
    else
    {
        	$query = $this->db
        	->select('p.*,c.name,b.brand_name')
        	->from('vegshopy_product p')
        	->join('category c', 'p.category_id = c.category_id','left')
        	->join('brand b', 'p.brand_id = b.brand_id','left')
        	->where('p.franchise_id', $login_type)
        	->order_by("p.product_id","DESC")
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

function product_search($limit,$start,$search,$col,$dir)
{
    $login_type   = $this->session->userdata('type');
    if($login_type == '0')
    {
        $query = $this->db
    	->select('p.*,c.name,b.brand_name')
    	->from('vegshopy_product p')
    	->join('category c', 'p.category_id = c.category_id','left')
    	->join('brand b', 'p.brand_id = b.brand_id','left')
        ->or_like('p.product_name',$search)
        ->order_by("p.product_id","DESC")
        ->limit($limit,$start)
    	->get();
    }
    else
    {
      $query = $this->db
    	->select('p.*,c.name,b.brand_name')
    	->from('vegshopy_product p')
    	->join('category c', 'p.category_id = c.category_id','left')
    	->join('brand b', 'p.brand_id = b.brand_id','left')
        ->or_like('p.product_name',$search)
        ->where('p.franchise_id', $login_type)
        ->order_by("p.product_id","DESC")
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

function product_search_count($search)
{
        
    $login_type   = $this->session->userdata('type');
    if($login_type == '0')
    {     

        $query = $this->db
    	->select('p.*,c.name,b.brand_name')
    	->from('vegshopy_product p')
    	->join('category c', 'p.category_id = c.category_id','left')
    	->join('brand b', 'p.brand_id = b.brand_id','left')
        ->or_like('p.product_name',$search)
        ->order_by("p.product_id","DESC")
    	->get();
    }
    else
    {
      $query = $this->db
    	->select('p.*,c.name,b.brand_name')
    	->from('vegshopy_product p')
    	->join('category c', 'p.category_id = c.category_id','left')
    	->join('brand b', 'p.brand_id = b.brand_id','left')
        ->or_like('p.product_name',$search)
        ->where('p.franchise_id', $login_type)
        ->order_by("p.product_id","DESC")
    	->get(); 
    }
    	
         return $query->num_rows();
        
        // echo $this->db->last_query();exit();
 }
    
    
  public function get_product_detail_id_wise($product_id)
  {
          return $query = $this->db
    			 ->select('p.*,c.name,s.sub_category,ss.sub_subcategory,b.brand_name')
    			 ->from('vegshopy_product p')
    			 ->join('category c', 'p.category_id = c.category_id','left')
				 ->join('sub_category s', 'p.sub_category_id = s.sub_category_id','left')
				 ->join('sub_subcategory ss', 'p.sub_subcategory_id = ss.sub_subcategory_id','left')
				 ->join('brand b', 'p.brand_id = b.brand_id','left')
				 ->where('p.product_id',$product_id)
    			 ->get()->row();
				 
				// echo $this->db->last_query();exit();
    }  
    
    
      public function getproduct_price_list($product_id)
    {
          return $query = $this->db
    			 ->select('*')
    			 ->from('product_details')
    			 ->where('product_id', $product_id)
    			 ->get()->result_array();
    }
    
    
/****************************** Coupon List    **************/

	public function get_all_coupon1_model()
	{
	
	 $login_type   = $this->session->userdata('type');
	 if($login_type == '0')
	 {
		return $query = $this->db
			 ->select('c.*,f.franchise_name')
			 ->from('coupon c')
			 ->join('franchise f', 'c.franchise_id = f.franchise_id','left')
			 ->order_by("c.coupon_id","DESC")
			 ->get()->result();
	 }
	 else
	 {
		return $query = $this->db
			 ->select('c.*,f.franchise_name')
			 ->from('coupon c')
			 ->join('franchise f', 'c.franchise_id = f.franchise_id','left')
			 ->where('c.franchise_id', $login_type)
			 ->order_by("c.coupon_id","DESC")
			 ->get()->result();
	     
	 }
			 
		//	echo $this->db->last_query();exit();
	}
	
	
   public function get_all_view_history_model($customer_id)
   {
        return   $query = $this->db
    			 ->select('v.*,p.product_name,p.main_image,p.qty,p.flag')
    			 ->from('view_product_history v')
    			 ->join('vegshopy_product p', 'v.product_id = p.product_id','left')
				 ->where('v.customer_id', $customer_id)
				 ->group_by('v.product_id')
    			 ->order_by("v.id","DESC")
    			 ->limit(5)
    			 ->get()->result();
				 
			//	 echo $this->db->last_query();exit();
    }
    
    
    /****************************** MINIMUM ORDER AMOUNT    **************/

	public function get_min_amount()
	{
	    $login_type   = $this->session->userdata('type');
	    if($login_type == '0')
	    {
    		return $query = $this->db
    			 ->select('m.*,f.franchise_name')
    			 ->from('min_limit m')
    			 ->join('franchise f', 'm.franchise_id = f.franchise_id','left')
    			 ->get()->row();
	    }
	    else
	    {
    		return $query = $this->db
    			 ->select('m.*,f.franchise_name')
    			 ->from('min_limit m')
    			 ->join('franchise f', 'm.franchise_id = f.franchise_id','left')
    			 ->where('m.franchise_id', $login_type)
    			 ->get()->row(); 
	        
	    }
			 
		//	 echo $this->db->last_query();exit();
	} 
	
	
	
	public function get_order_min_amount()
	{
		return $query = $this->db
			 ->select('*')
			 ->from('min_limit')
			 ->get()->row();
			 
		//	 echo $this->db->last_query();exit();
	}
	
	
	
	    /****************************** PINCODE WISE CUSTOMER   **************/

	public function count_pincode_wise_customer($pincode)
	{
		return $query = $this->db
			 ->select('COUNT(customer_id) as count')
			 ->from('customer')
			 ->where('pincode', $pincode)
			 ->get()->row();
			 
		//	 echo $this->db->last_query();exit();
	}
	
	
		
/****************************** Product List    **************/

	public function get_product_data()
	{
	    $login_type   = $this->session->userdata('type');
	    if($login_type == '0')
	    {
    		return $query = $this->db
    			 ->select('*')
    			 ->from('vegshopy_product')
    			 ->order_by("product_id","DESC")
    			 ->get()->result();
	    }
	    else
	    {
	        
	           return $query = $this->db
    			 ->select('*')
    			 ->from('vegshopy_product')
    			 ->where('franchise_id', $login_type)
    			 ->order_by("product_id","DESC")
    			 ->get()->result();
	    }
			 
		//	 echo $this->db->last_query();exit();
	}
	
	/****************************** Product Price List    **************/

	public function get_product_price_data()
	{
      	$login_type   = $this->session->userdata('type');
        if($login_type == '0')
        {
    		return $query = $this->db
    			 ->select('*')
    			 ->from('product_details')
    			 ->order_by("id","DESC")
    			 ->get()->result();
        }
        else
        {
          
          
        	return $query = $this->db
    			 ->select('*')
    			 ->from('product_details')
    			 ->where('franchise_id', $login_type)
    			 ->order_by("id","DESC")
    			 ->get()->result();
    			 
        }
			 
		//	 echo $this->db->last_query();exit();
	}
	
	
	
	/****************************** franchise List    **************/

	public function get_all_franchise_model()
	{
		return $query = $this->db
			 ->select('f.*,, s.state_name,c.city_name')
			 ->from('franchise f')
			 ->join('city_master c', 'c.city_id = f.city','left')
    	     ->join('state_master s', 's.state_id = f.state','left')
			 ->order_by("f.franchise_id","DESC")
			 ->get()->result();
			 
		//	echo $this->db->last_query();exit();
	}
	
	
	public function get_franchise_deatils($franchise_id)
	{
		return $query = $this->db
			 ->select('f.*,, s.state_name,c.city_name')
			 ->from('franchise f')
			 ->join('city_master c', 'c.city_id = f.city','left')
    	     ->join('state_master s', 's.state_id = f.state','left')
			 ->where('f.franchise_id', $franchise_id)
			 ->get()->row();
			 
		//	echo $this->db->last_query();exit();
	}
	

	
	 /*************************** Returns State list from state_master table************************************/
    
    public function get_all_state_model()
    {
    return $query = $this->db
    		 ->select('*')
    		 ->from('state_master')
    		 ->get()->result();
    }
    
    
    
        /****************************** MINIMUM ORDER AMOUNT    **************/

	public function get_order_limit()
	{
	    $login_type   = $this->session->userdata('type');
	    if($login_type == '0')
	    {
    		return $query = $this->db
    			 ->select('m.*,f.franchise_name')
    			 ->from('order_limit m')
    			 ->join('franchise f', 'm.franchise_id = f.franchise_id','left')
    			 ->get()->row();
	    }
	    else
	    {
    		return $query = $this->db
    			 ->select('m.*,f.franchise_name')
    			 ->from('order_limit m')
    			 ->join('franchise f', 'm.franchise_id = f.franchise_id','left')
    			 ->where('m.franchise_id', $login_type)
    			 ->get()->row(); 
	        
	    }
			 
		//	 echo $this->db->last_query();exit();
	} 
	
	
	
	/****************************** Area List    **************/

	public function get_all_area_model()
	{
	    $login_type   = $this->session->userdata('type');
	    if($login_type == '0')
	    {
		return $query = $this->db
			 ->select('b.*,f.franchise_name,z.zone_name')
			 ->from('area b')
			 ->join('franchise f', 'b.franchise_id = f.franchise_id','left')
			 ->join('zone z', 'b.zone_id = z.zone_id','left')
    			 ->order_by("b.area_id","DESC")
    			 ->get()->result();
	    }
	    else
	    {
		return $query = $this->db
			 ->select('b.*,f.franchise_name,z.zone_name')
			 ->from('area b')
			 ->join('franchise f', 'b.franchise_id = f.franchise_id','left')
			 ->join('zone z', 'b.zone_id = z.zone_id','left')
    			 ->where('b.franchise_id',$login_type)
    			 ->order_by("b.area_id","DESC")
    			 ->get()->result();
	        
	    }
    			 
		//	echo $this->db->last_query();exit();
	}
	
	
	
		/****************************** Area List    **************/

	public function get_all_area_model1($franchise_id)
	{


		return $query = $this->db
			 ->select('b.*,f.franchise_name')
			 ->from('area b')
			 ->join('franchise f', 'b.franchise_id = f.franchise_id','left')
    			 ->where('b.franchise_id',$franchise_id)
    			 ->order_by("b.area_id","DESC")
    			 ->get()->result();
	        
	    
    			 
		//	echo $this->db->last_query();exit();
	}
	
	
	
		/****************************** Zone List    **************/

	public function get_all_zone_model()
	{
	    $login_type   = $this->session->userdata('type');
	    if($login_type == '0')
	    {
		return $query = $this->db
			 ->select('b.*,f.franchise_name')
			 ->from('zone b')
			 ->join('franchise f', 'b.franchise_id = f.franchise_id','left')
    			 ->order_by("b.zone_id","DESC")
    			 ->get()->result();
	    }
	    else
	    {
		return $query = $this->db
			 ->select('b.*,f.franchise_name')
			 ->from('zone b')
			 ->join('franchise f', 'b.franchise_id = f.franchise_id','left')
    			 ->where('b.franchise_id',$login_type)
    			 ->order_by("b.zone_id","DESC")
    			 ->get()->result();
	        
	    }
    			 
		//	echo $this->db->last_query();exit();
	}
	
	
	
	
	/****************************** Designation List    **************/

	public function get_all_designation_model()
	{
	    	    $login_type   = $this->session->userdata('type');
	    if($login_type == '0')
	    {
		return $query = $this->db
			 ->select('b.*,f.franchise_name')
			 ->from('designation b')
			 ->join('franchise f', 'b.franchise_id = f.franchise_id','left')
    			 ->order_by("b.designation_id","DESC")
    			 ->get()->result();
	    }
	    else
	    {
		return $query = $this->db
			 ->select('b.*,f.franchise_name')
			 ->from('designation b')
			 ->join('franchise f', 'b.franchise_id = f.franchise_id','left')
    			 ->where('b.franchise_id',$login_type)
    			 ->order_by("b.designation_id","DESC")
    			 ->get()->result();
	        
	    }
    			 
		//	echo $this->db->last_query();exit();
	}
	
	
	
	
	/****************************** EMployee List    **************/

	public function get_all_employee_model()
	{
	    	    $login_type   = $this->session->userdata('type');
	    if($login_type == '0')
	    {
		return $query = $this->db
			 ->select('b.*,f.franchise_name,d.designation')
			 ->from('employee b')
			 ->join('franchise f', 'b.franchise_id = f.franchise_id','left')
			 ->join('designation d', 'b.designation_id = d.designation_id','left')
    		 ->order_by("b.employee_id","DESC")
       	     ->get()->result();
	    }
	    else
	    {
		return $query = $this->db
			 ->select('b.*,f.franchise_name,d.designation')
			 ->from('employee b')
			 ->join('franchise f', 'b.franchise_id = f.franchise_id','left')
			 ->join('designation d', 'b.designation_id = d.designation_id','left')
    		 ->where('b.franchise_id',$login_type)
    		 ->order_by("b.employee_id","DESC")
    		 ->get()->result();
	        
	    }
    			 
			echo $this->db->last_query();exit();
	}
	
	
	
			/****************************** Access    **************/

	public function get_emp_access($employee_id)
	{


		return $query = $this->db
			 ->select('*')
			 ->from('crm_access')
    			 ->where('employee_id',$employee_id)
    			 ->get()->row();
	        
	    
    			 
		//	echo $this->db->last_query();exit();
	}
	
	
	
	
		/****************************** Product list   **************/  
  public function get_all_product_model($franchise_id)
  {
          return $query = $this->db
    			 ->select('p.*')
    			 ->from('vegshopy_product p')
				 ->where('p.franchise_id', $franchise_id)
    			 ->order_by("p.qty","DESC")
    			 ->get()->result();
				 
				// echo $this->db->last_query();exit();
    }
    
    
    
    
/****************************** Offer list   **************/  
  public function get_all_offer_model($franchise_id)
  {
          return $query = $this->db
    			 ->select('*')
    			 ->from('offer')
				 ->where('franchise_id', $franchise_id)
    			 ->order_by("offer_id","DESC")
    			 ->get()->result();
				 
				// echo $this->db->last_query();exit();
    }
    
    
    public function product_details_offer_id_wise($offer_id)
	{
		return $query = $this->db
			 ->select('o.*,p.product_name,p.main_image,d.title,d.unit_price,d.discount,p.qty')
			 ->from('offer_on_product o')
			 ->join('vegshopy_product p', 'p.product_id = o.product_id','left')
			 ->join('product_details d', 'p.product_id = d.product_id','left')
			 ->where('o.offer_id', $offer_id)
			 ->group_by('p.product_id')
			 ->get()->result();
			 
		//	 echo $this->db->last_query();exit();
	}
	
	
	
	/****************************** Out of stock Product List    **************/

function oos_product_count()
{ 
    $login_type   = $this->session->userdata('type');
    if($login_type == '0')
    {
        $query = $this->db
        	->select('p.*,c.name,b.brand_name')
        	->from('vegshopy_product p')
        	->join('category c', 'p.category_id = c.category_id','left')
        	->join('brand b', 'p.brand_id = b.brand_id','left')
        	->where('p.qty <=', '0')
        	->order_by("p.product_id","DESC")
        	->get();
    }
    else
    {
        $query = $this->db
        	->select('p.*,c.name,b.brand_name')
        	->from('vegshopy_product p')
        	->join('category c', 'p.category_id = c.category_id','left')
        	->join('brand b', 'p.brand_id = b.brand_id','left')
        	->where('p.qty <=', '0')
        	->where('p.franchise_id', $login_type)
        	->order_by("p.product_id","DESC")
        	->get();
        
    }
    return $query->num_rows();  

}
function oos_product_list($limit,$start,$col,$dir)
{ 
    $login_type   = $this->session->userdata('type');
    if($login_type == '0')
    {
       	$query = $this->db
    	->select('p.*,c.name,b.brand_name')
    	->from('vegshopy_product p')
    	->join('category c', 'p.category_id = c.category_id','left')
    	->join('brand b', 'p.brand_id = b.brand_id','left')
    	->where('p.qty <=', '0')
    	->order_by("p.product_id","DESC")
        ->limit($limit,$start)
    	->get();
    }
    else
    {
        	$query = $this->db
        	->select('p.*,c.name,b.brand_name')
        	->from('vegshopy_product p')
        	->join('category c', 'p.category_id = c.category_id','left')
        	->join('brand b', 'p.brand_id = b.brand_id','left')
        	->where('p.qty <=', '0')
        	->where('p.franchise_id', $login_type)
        	->order_by("p.product_id","DESC")
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

function oos_product_search($limit,$start,$search,$col,$dir)
{
    $login_type   = $this->session->userdata('type');
    if($login_type == '0')
    {
        $query = $this->db
    	->select('p.*,c.name,b.brand_name')
    	->from('vegshopy_product p')
    	->join('category c', 'p.category_id = c.category_id','left')
    	->join('brand b', 'p.brand_id = b.brand_id','left')
        ->or_like('p.product_name',$search)
        ->where('p.qty <=', '0')
        ->order_by("p.product_id","DESC")
        ->limit($limit,$start)
    	->get();
    }
    else
    {
      $query = $this->db
    	->select('p.*,c.name,b.brand_name')
    	->from('vegshopy_product p')
    	->join('category c', 'p.category_id = c.category_id','left')
    	->join('brand b', 'p.brand_id = b.brand_id','left')
        ->or_like('p.product_name',$search)
        ->where('p.qty <=', '0')
        ->where('p.franchise_id', $login_type)
        ->order_by("p.product_id","DESC")
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

function oos_product_search_count($search)
{
        
    $login_type   = $this->session->userdata('type');
    if($login_type == '0')
    {     

        $query = $this->db
    	->select('p.*,c.name,b.brand_name')
    	->from('vegshopy_product p')
    	->join('category c', 'p.category_id = c.category_id','left')
    	->join('brand b', 'p.brand_id = b.brand_id','left')
        ->or_like('p.product_name',$search)
        ->where('p.qty <=', '0')
        ->order_by("p.product_id","DESC")
    	->get();
    }
    else
    {
      $query = $this->db
    	->select('p.*,c.name,b.brand_name')
    	->from('vegshopy_product p')
    	->join('category c', 'p.category_id = c.category_id','left')
    	->join('brand b', 'p.brand_id = b.brand_id','left')
        ->or_like('p.product_name',$search)
        ->where('p.qty <=', '0')
        ->where('p.franchise_id', $login_type)
        ->order_by("p.product_id","DESC")
    	->get(); 
    }
    	
         return $query->num_rows();
        
        // echo $this->db->last_query();exit();
 }
 
 
 
 
 /****************************** Notification list   **************/  
  public function get_all_notification_model()
  {
      $current_date = date('d-m-Y');
          return $query = $this->db
    			 ->select('*')
    			 ->from('notification')
    			 ->where('date', $current_date)
    			 ->order_by("notification_id","DESC")
    			 ->get()->result();
				 
				// echo $this->db->last_query();exit();
    }
    
    
    
    function get_qrcode_one($insert_id)
    {
        $this->db->where('id', $insert_id);
        $result = $this->db->get('qrcode');
        return $result->row();
    } 
    
    
    function change_userqr($insert_id,$user_qr)
    {
        $this->db->where('id', $insert_id);
        $this->db->set('barcode',$user_qr);
        $this->db->update('qrcode');
    }
    
    
    
    public function get_offer_details($offer_id)
  {
          return $query = $this->db
    			 ->select('*')
    			 ->from('offer')
				 ->where('offer_id', $offer_id)
    			 ->get()->row();
				 
				// echo $this->db->last_query();exit();
    }
    
    
    public function getproduct_offer_list($offer_id)
    {
          return $query = $this->db
    			 ->select('o.*,c.product_name')
    			 ->from('offer_on_product o')
    			 ->join('vegshopy_product c', 'o.product_id = c.product_id','left')
    			 ->where('o.offer_id', $offer_id)
    			 ->get()->result();
    			 
    			 
    }
    
    
    
    /****************************** hot product List    **************/


    public function get_all_hot_product_model()
    {
      

       
        return $query = $this->db
    			 ->select('ss.*,s.sub_category')
    			 ->from('hot_product ss')
				  ->join('sub_category s', 'ss.sub_category_id = s.sub_category_id','left')
    			 ->order_by("ss.hp_id","DESC")
    			 ->get()->result();
          
      
    }
    
     /****************************** web category List    **************/


    public function get_web_category_list()
    {
      
      $this->db->select("*");
        $this->db->from("category");
      $this->db->order_by("category_id","ASC");
      $query = $this->db->get();
      return $query->result();
      
       //return $this->db->query("select * from category order by id desc")->result();

       
      
    }
    
    
    
    /******************************  List    **************/

	public function get_all_subcategory_model1()
	{
	    
	    	    $login_type   = $this->session->userdata('type');
	    if($login_type == '0')
	    {
		return $query = $this->db
			 ->select('b.*,f.franchise_name')
			 ->from('sub_category b')
			 ->join('franchise f', 'b.franchise_id = f.franchise_id','left')
    			 ->order_by("b.sub_category_id","DESC")
    			 ->get()->result();
	    }
	    else
	    {
		return $query = $this->db
			 ->select('b.*,f.franchise_name')
			 ->from('sub_category b')
			 ->join('franchise f', 'b.franchise_id = f.franchise_id','left')
    			 ->where('b.franchise_id',$login_type)
    			 ->order_by("b.sub_category_id","DESC")
    			 ->get()->result();
	        
	    }
			 
		//	 echo $this->db->last_query();exit();
	}
	
	
	
	/****************************** Today list   **************/  
  public function get_all_today_offer_model($franchise_id)
  {
          return $query = $this->db
    			 ->select('*')
    			 ->from('today_offer')
				 ->where('franchise_id', $franchise_id)
    			 ->order_by("tf_id","DESC")
    			 ->get()->result();
				 
				// echo $this->db->last_query();exit();
    }
    
    
  public function get_all_today_offer_model1()
  {
      $current_date = date('d-m-Y');
          return $query = $this->db
    			 ->select('*')
    			 ->from('today_offer')
				 ->where('date', $current_date)
    			 ->order_by("tf_id","DESC")
    			 ->get()->result();
				 
				// echo $this->db->last_query();exit();
    }
    
    
  public function get_todat_offer_wise_product($tf_id)
  {
          return $query = $this->db
    			 ->select('t.*,p.product_name,p.main_image,p.qty,p.type')
    			 ->from('today_offer_product t')
    			 ->join('vegshopy_product p', 'p.product_id = t.product_id','left')
				 ->where('t.tf_id', $tf_id)
    			 ->order_by("t.id","DESC")
    			 ->get()->result();
				// echo $this->db->last_query();exit();
    }
     
/*******************************************************************************/
}

?>