<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sitemap_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    public function get_sitemap_data() {
        $urls = [
            ['slug' => '', 'updated_at' => date('Y-m-d H:i:s')],
            ['slug' => 'about_a_us', 'updated_at' => date('Y-m-d H:i:s')],
            ['slug' => 'contact_us', 'updated_at' => date('Y-m-d H:i:s')],
            ['slug' => 'about_us', 'updated_at' => date('Y-m-d H:i:s')], 
            ['slug' => 'faqs', 'updated_at' => date('Y-m-d H:i:s')],
            ['slug' => 'products/4', 'updated_at' => date('Y-m-d H:i:s')],
            ['slug' => 'custom_hand_painted', 'updated_at' => date('Y-m-d H:i:s')],
            ['slug' => 'products', 'updated_at' => date('Y-m-d H:i:s')],
        ];

        return $urls;
    }
}
