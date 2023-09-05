<?php

class ProductModel extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function getMostPopularProducts()
	{
		$data = $this->db->query("select DISTINCT(v.product_id),v.product_name,v.main_image,v.qty,v.flag,v.type,o.unit,o.unit_price,o.discount 
from vegshopy_product v INNER JOIN order_detail o ON o.product_id=v.product_id 
where v.product_id in(select DISTINCT(product_id) from product_details where order_id in(select order_id from product_order where status=3)) order by o.qty desc limit 10")->result_array();
		if (count($data) == 0) {
			return false;
		} else {
			return $data;
		}
	}
}

?>
