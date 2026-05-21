<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sitemap extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Sitemap_model');
        $this->load->model('GlobalModal');
    }

    public function index() {
        $data['pages'] = $this->Sitemap_model->get_sitemap_data();
        $productData = $this->GlobalModal->executeQuery("SELECT v.product_id FROM `vegshopy_product` v");
        if ($productData != false) {
            foreach ($productData as $product) {
                array_push($data['pages'], ['slug' => 'product/'.$product['product_id'], 'updated_at' => date('Y-m-d H:i:s')] );
            }
        }
        header('Content-Type: application/xml');
        $this->load->view('Sitemap/index', $data);
    }
}
