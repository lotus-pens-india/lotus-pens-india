<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->model('product_model');
        $this->load->model('customer_model');
        $this->load->library('upload');
    }


    /****************************** Brand View Page **************/

    public function brands()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['all_brand'] = $this->product_model->get_all_brand_model();
            $this->load->view('common/header');
            $this->load->view('product/brands', $data);
            $this->load->view('common/footer');
        }
    }

    public function nib_master()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['all_brand'] = $this->product_model->get_all_nib_model();
            $this->load->view('common/header');
            $this->load->view('product/nib', $data);
            $this->load->view('common/footer');
        }
    }

    public function currency_master()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['all_brand'] = $this->product_model->get_all_currency_model();
            $this->load->view('common/header');
            $this->load->view('product/currency', $data);
            $this->load->view('common/footer');
        }
    }



    /***********************Add Material*********************** */

    public function material_master()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['all_brand'] = $this->product_model->get_all_material_model();
            $this->load->view('common/header');
            $this->load->view('product/material', $data);
            $this->load->view('common/footer');
        }
    }


    /********************** Add brand data **************/

    public function upload_brand()
    {



        $config = array();
        $config['upload_path'] = "assets/images/brand/";
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['overwrite'] = TRUE;
        return $config;
    }
    public function add_brand_data()
    {
        $login_type   = $this->session->userdata('type');

        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('brand_name', 'brand name', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $brand_name  = $this->input->post('brand_name');

        if ($this->form_validation->run() == TRUE) {
            $data_brand = array(
                'brand_name'      => $brand_name,
                'franchise_id'      => $login_type,

            );

            $this->db->insert('brand', $data_brand);
            $insert_id = $this->db->insert_id();



            $files = $_FILES;

            ///////// Logo ////////////////

            if (!empty($_FILES['logo']['name'])) {

                $_FILES['logo']['name'] = $files['logo']['name'];
                $_FILES['logo']['type'] = $files['logo']['type'];
                $_FILES['logo']['tmp_name'] = $files['logo']['tmp_name'];
                $_FILES['logo']['error'] = $files['logo']['error'];
                $_FILES['logo']['size'] = $files['logo']['size'];

                $this->load->library('upload', $this->upload_brand());

                $this->upload->initialize($this->upload_brand());

                if (!$this->upload->do_upload('logo')) {

                    $this->upload->display_errors();
                    $upload_error[] = array('error' => $this->upload->display_errors());
                } else {
                    $upload_data = $this->upload->data();
                    $name_array = $upload_data['file_name'];

                    $insertArray1 = array(
                        'logo'      => $upload_data['file_name'],

                    );
                    $this->db->where('brand_id', $insert_id);
                    $this->db->update('brand', $insertArray1);
                }
            }

            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Brand!</strong> add successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/brands');
        } else {
            $status = 'error';
            if (form_error('brand_name')) {
                $errors['brand_nameError'] = form_error('brand_name');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }

    /********************** Update brand data **************/
    public function update_brand_data()
    {
        $errors   = array();
        $message  = '';
        $redirect = '';
        $edit_id  = $this->input->post('brand_id');
        $this->form_validation->set_rules('brand_name', 'brand name', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $brand_name  = $this->input->post('brand_name');
        $logo      = $this->input->post('logo');
        $logo_old   = $this->input->post('logo_old');

        $date = date('Y-m-d H:i:s');
        if ($this->form_validation->run() == TRUE) {
            $update_data = array(
                'brand_name'        => $brand_name,
                'update_datetime'        => $date,

            );
            $status = 'success';
            $this->db->where('brand_id', $edit_id)->update('brand', $update_data);

            $files = $_FILES;
            if (!empty($_FILES['logo']['name'])) {

                $_FILES['logo']['name'] = $files['logo']['name'];
                $_FILES['logo']['type'] = $files['logo']['type'];
                $_FILES['logo']['tmp_name'] = $files['logo']['tmp_name'];
                $_FILES['logo']['error'] = $files['logo']['error'];
                $_FILES['logo']['size'] = $files['logo']['size'];

                if ($logo_old != $logo) {

                    unlink('./assets/images/brand/' . $logo_old);

                    $this->upload->initialize($this->upload_brand());
                    if (!$this->upload->do_upload('logo')) {
                        $upload_error[] = array('error' => $this->upload->display_errors());
                    } else {
                        $upload_data = $this->upload->data();

                        $name_array = $upload_data['file_name'];
                        $insertArray1 = array(
                            'logo' => $upload_data['file_name']
                        );
                        $this->db->where('brand_id', $edit_id);
                        $this->db->update('brand', $insertArray1);
                    }
                } else {
                    $insertArray1 = array(
                        'logo' => $logo_old
                    );
                    $this->db->where('brand_id', $edit_id);
                    $this->db->update('brand', $insertArray1);
                }
            }


            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
					<button type="button" class="close" data-dismiss="alert">×</button>
					
					<div class="alert-icon">
					 <i class="icon-check"></i>
					</div>
					<div class="alert-message">
					  <span><strong>Brand!</strong> update successfully. <a href="javascript:void();" class="alert-link"></a></span>
					</div>
				  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/brands');
        } else {
            $status = 'error';
            if (form_error('brand_name')) {
                $errors['brand_nameError'] = form_error('brand_name');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;

        echo json_encode($data);
    }


    /********************** Delete brand Data in brand Table  **********************
     *********************************************************************************/
    public function delete_brand()
    {
        $delete_id = $this->input->post('delete_id');

        $this->db->select('*');
        $this->db->from('brand');
        $this->db->where('brand_id', $delete_id);
        $query  = $this->db->get();
        $result = $query->row();
        $logo = $result->logo;

        unlink('./assets/images/brand/' . $logo);

        $this->db->where('brand_id', $delete_id);
        $this->db->delete('brand');
        echo $delete_id;
    }


    /********************** Add NIB data **************/

    public function upload_nib()
    {



        $config = array();
        $config['upload_path'] = "assets/images/brand/";
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['overwrite'] = TRUE;
        return $config;
    }
    public function add_nib_data()
    {
        $login_type   = $this->session->userdata('type');

        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('name', 'name', 'required');
        $this->form_validation->set_rules('usd_price', 'usd_price', 'required');
        $this->form_validation->set_rules('rupee_price', 'rupee_price', 'required');
        $this->form_validation->set_rules('euro_price', 'euro_price', 'required');
        $this->form_validation->set_rules('pound_price', 'pound_price', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $nib_name  = $this->input->post('name');
        $usd_price  = $this->input->post('usd_price');
        $rupee_price  = $this->input->post('rupee_price');
        $euro_price  = $this->input->post('euro_price');
        $pound_price  = $this->input->post('pound_price');

        if ($this->form_validation->run() == TRUE) {
            $data_nib = array(
                'name'      => $nib_name,
                'usd_price' => $usd_price,
                'rupee_price' => $rupee_price,
                'euro_price' => $euro_price,
                'pound_price' => $pound_price,
                'status'    => 1,
            );

            $this->db->insert('lp_nib_master', $data_nib);
            $insert_id = $this->db->insert_id();
            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Brand!</strong> add successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/nib_master');
        } else {
            $status = 'error';
            if (form_error('name')) {
                $errors['nameError'] = form_error('name');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }


    /********************** Update NIB data **************/
    public function update_nib_data()
    {
        $errors   = array();
        $message  = '';
        $redirect = '';
        $edit_id  = $this->input->post('id');
        $this->form_validation->set_rules('name', 'name', 'required');
        $this->form_validation->set_rules('usd_price', 'usd_price', 'required');
        $this->form_validation->set_rules('rupee_price', 'rupee_price', 'required');
        $this->form_validation->set_rules('euro_price', 'euro_price', 'required');
        $this->form_validation->set_rules('pound_price', 'pound_price', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $nib_name  = $this->input->post('name');
        $usd_price  = $this->input->post('usd_price');
        $rupee_price  = $this->input->post('rupee_price');
        $euro_price  = $this->input->post('euro_price');
        $pound_price  = $this->input->post('pound_price');

        $date = date('Y-m-d H:i:s');
        if ($this->form_validation->run() == TRUE) {
            $update_data = array(
                'name'      => $nib_name,
                'usd_price' => $usd_price,
                'rupee_price' => $rupee_price,
                'euro_price' => $euro_price,
                'pound_price' => $pound_price,
                'updated_at'        => $date,

            );
            $status = 'success';
            $this->db->where('id', $edit_id)->update('lp_nib_master', $update_data);

            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
                <button type="button" class="close" data-dismiss="alert">×</button>
                
                <div class="alert-icon">
                 <i class="icon-check"></i>
                </div>
                <div class="alert-message">
                  <span><strong>Brand!</strong> update successfully. <a href="javascript:void();" class="alert-link"></a></span>
                </div>
              </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/nib_master');
        } else {
            $status = 'error';
            if (form_error('name')) {
                $errors['nameError'] = form_error('name');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;

        echo json_encode($data);
    }


    /*************************IS AVTIVE  NIB************* */

    public function isActive()
    {
        $errors   = array();
        $message  = '';
        $redirect = '';
        $edit_id  = $this->input->post('id');
        $status  = $this->input->post('status');
        if ($status != 1) {
            $status = 1;
        } else {
            $status = 0;
        }


        $date = date('Y-m-d H:i:s');
        if (TRUE) {
            $update_data = array(
                'status' => $status,
                'updated_at'        => $date,

            );
            $status = 'success';
            $this->db->where('id', $edit_id)->update('lp_nib_master', $update_data);

            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    
                    <div class="alert-icon">
                     <i class="icon-check"></i>
                    </div>
                    <div class="alert-message">
                      <span><strong>Brand!</strong> update successfully. <a href="javascript:void();" class="alert-link"></a></span>
                    </div>
                  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/nib_master');
        } else {
            $status = 'error';
            if (form_error('id')) {
                $errors['nameError'] = form_error('id');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;

        echo json_encode($data);
    }




    /********************** Add NIB data **************/

    public function upload_material()
    {



        $config = array();
        $config['upload_path'] = "assets/images/brand/";
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['overwrite'] = TRUE;
        return $config;
    }
    public function add_material_data()
    {
        $login_type   = $this->session->userdata('type');

        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('name', 'name', 'required');
        $this->form_validation->set_rules('usd_price', 'usd_price', 'required');
        $this->form_validation->set_rules('rupee_price', 'rupee_price', 'required');
        $this->form_validation->set_rules('euro_price', 'euro_price', 'required');
        $this->form_validation->set_rules('pound_price', 'pound_price', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $nib_name  = $this->input->post('name');
        $usd_price  = $this->input->post('usd_price');
        $rupee_price  = $this->input->post('rupee_price');
        $euro_price  = $this->input->post('euro_price');
        $pound_price  = $this->input->post('pound_price');

        if ($this->form_validation->run() == TRUE) {
            $data_nib = array(
                'name'      => $nib_name,
                'usd_price' => $usd_price,
                'rupee_price' => $rupee_price,
                'euro_price' => $euro_price,
                'pound_price' => $pound_price,
                'status'    => 1,
            );

            $this->db->insert('lp_material_master', $data_nib);
            $insert_id = $this->db->insert_id();
            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
                      <button type="button" class="close" data-dismiss="alert">×</button>
                      
                      <div class="alert-icon">
                       <i class="icon-check"></i>
                      </div>
                      <div class="alert-message">
                        <span><strong>Brand!</strong> add successfully. <a href="javascript:void();" class="alert-link"></a></span>
                      </div>
                    </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/material_master');
        } else {
            $status = 'error';
            if (form_error('name')) {
                $errors['nameError'] = form_error('name');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }


    /********************** Update NIB data **************/
    public function update_material_data()
    {
        $errors   = array();
        $message  = '';
        $redirect = '';
        $edit_id  = $this->input->post('id');
        $this->form_validation->set_rules('name', 'name', 'required');
        $this->form_validation->set_rules('usd_price', 'usd_price', 'required');
        $this->form_validation->set_rules('rupee_price', 'rupee_price', 'required');
        $this->form_validation->set_rules('euro_price', 'euro_price', 'required');
        $this->form_validation->set_rules('pound_price', 'pound_price', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $nib_name  = $this->input->post('name');
        $usd_price  = $this->input->post('usd_price');
        $rupee_price  = $this->input->post('rupee_price');
        $euro_price  = $this->input->post('euro_price');
        $pound_price  = $this->input->post('pound_price');

        $date = date('Y-m-d H:i:s');
        if ($this->form_validation->run() == TRUE) {
            $update_data = array(
                'name'      => $nib_name,
                'usd_price' => $usd_price,
                'rupee_price' => $rupee_price,
                'euro_price' => $euro_price,
                'pound_price' => $pound_price,
                'updated_at'        => $date,

            );
            $status = 'success';
            $this->db->where('id', $edit_id)->update('lp_material_master', $update_data);

            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
              <button type="button" class="close" data-dismiss="alert">×</button>
              
              <div class="alert-icon">
               <i class="icon-check"></i>
              </div>
              <div class="alert-message">
                <span><strong>Brand!</strong> update successfully. <a href="javascript:void();" class="alert-link"></a></span>
              </div>
            </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/material_master');
        } else {
            $status = 'error';
            if (form_error('name')) {
                $errors['nameError'] = form_error('name');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;

        echo json_encode($data);
    }

    public function update_currency_data()
    {
        $errors   = array();
        $message  = '';
        $redirect = '';
        $edit_id  = $this->input->post('id');

        $this->form_validation->set_rules('usd_rate', 'usd_rate', 'required');
        $usd_rate  = $this->input->post('usd_rate');


        $date = date('Y-m-d H:i:s');
        if ($this->form_validation->run() == TRUE) {
            $update_data = array(
                'usd_rate' => $usd_rate,
            );
            $status = 'success';
            $this->db->where('id', $edit_id)->update('lp_currency_master', $update_data);

            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
              <button type="button" class="close" data-dismiss="alert">×</button>
              
              <div class="alert-icon">
               <i class="icon-check"></i>
              </div>
              <div class="alert-message">
                <span><strong>Brand!</strong> update successfully. <a href="javascript:void();" class="alert-link"></a></span>
              </div>
            </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/material_master');
        } else {
            $status = 'error';
            if (form_error('name')) {
                $errors['nameError'] = form_error('name');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;

        echo json_encode($data);
    }



    /*************************IS AVTIVE  NIB************* */

    public function isActive_material()
    {
        $errors   = array();
        $message  = '';
        $redirect = '';
        $edit_id  = $this->input->post('id');
        $status  = $this->input->post('status');
        if ($status != 1) {
            $status = 1;
        } else {
            $status = 0;
        }


        $date = date('Y-m-d H:i:s');
        if (TRUE) {
            $update_data = array(
                'status' => $status,
                'updated_at'        => $date,

            );
            $status = 'success';
            $this->db->where('id', $edit_id)->update('lp_material_master', $update_data);

            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
                  <button type="button" class="close" data-dismiss="alert">×</button>
                  
                  <div class="alert-icon">
                   <i class="icon-check"></i>
                  </div>
                  <div class="alert-message">
                    <span><strong>Brand!</strong> update successfully. <a href="javascript:void();" class="alert-link"></a></span>
                  </div>
                </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/material_master');
        } else {
            $status = 'error';
            if (form_error('id')) {
                $errors['nameError'] = form_error('id');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;

        echo json_encode($data);
    }

    /****************************** Category View Page **************/

    public function category()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['all_category'] = $this->product_model->get_all_category_model();
            $this->load->view('common/header');
            $this->load->view('product/category', $data);
            $this->load->view('common/footer');
        }
    }

    /********************** Add category data **************/

    public function upload_icon()
    {



        $config = array();
        $config['upload_path'] = "assets/images/category/";
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['overwrite'] = TRUE;
        return $config;
    }
    public function add_category_data()
    {
        $login_type   = $this->session->userdata('type');

        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('category_name', 'category name', 'required');
        $this->form_validation->set_rules('position', 'position', 'required');
        $this->form_validation->set_rules('color', 'color', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $category_name  = $this->input->post('category_name');
        $position  = $this->input->post('position');
        $color  = $this->input->post('color');

        if ($this->form_validation->run() == TRUE) {
            $data_category = array(
                'name'      => $category_name,
                'position'      => $position,
                'franchise_id'      => $login_type,
                'color'      => $color,

            );

            $this->db->insert('category', $data_category);
            $insert_id = $this->db->insert_id();

            $files = $_FILES;

            ///////// Icon ////////////////

            if (!empty($_FILES['icon']['name'])) {

                $_FILES['icon']['name'] = $files['icon']['name'];
                $_FILES['icon']['type'] = $files['icon']['type'];
                $_FILES['icon']['tmp_name'] = $files['icon']['tmp_name'];
                $_FILES['icon']['error'] = $files['icon']['error'];
                $_FILES['icon']['size'] = $files['icon']['size'];



                $this->load->library('upload', $this->upload_icon());

                $this->upload->initialize($this->upload_icon());

                if (!$this->upload->do_upload('icon')) {

                    $this->upload->display_errors();

                    $upload_error[] = array('error' => $this->upload->display_errors());
                } else {
                    $upload_data = $this->upload->data();
                    $name_array = $upload_data['file_name'];

                    $insertArray1 = array(
                        'icon' => $upload_data['file_name'],
                    );
                    $this->db->where('category_id', $insert_id);
                    $this->db->update('category', $insertArray1);
                }
            }

            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Category!</strong> add successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/category');
        } else {
            $status = 'error';
            if (form_error('category_name')) {
                $errors['category_nameError'] = form_error('category_name');
            }
            if (form_error('position')) {
                $errors['positionError'] = form_error('position');
            }
            if (form_error('color')) {
                $errors['colorError'] = form_error('color');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }

    /********************** Update  category data **************/


    public function update_category_data()
    {
        $errors   = array();
        $message  = '';
        $redirect = '';
        $edit_id  = $this->input->post('category_id');
        $this->form_validation->set_rules('category_name', 'category name', 'required');
        $this->form_validation->set_rules('position', 'position', 'required');
        $this->form_validation->set_rules('color', 'color', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $category_name  = $this->input->post('category_name');
        $position  = $this->input->post('position');
        $color  = $this->input->post('color');
        $icon_old   = $this->input->post('icon_old');

        $date = date('Y-m-d H:i:s');
        if ($this->form_validation->run() == TRUE) {
            $update_data = array(
                'name'        => $category_name,
                'position'        => $position,
                'color'        => $color,
                'update_datetime'        => $date,

            );
            $status = 'success';
            $this->db->where('category_id', $edit_id)->update('category', $update_data);

            $files = $_FILES;

            ///////// Main Image  ////////////////

            if (!empty($_FILES['icon']['name'])) {

                $_FILES['icon']['name'] = $files['icon']['name'];

                $_FILES['icon']['type'] = $files['icon']['type'];
                $_FILES['icon']['tmp_name'] = $files['icon']['tmp_name'];
                $_FILES['icon']['error'] = $files['icon']['error'];
                $_FILES['icon']['size'] = $files['icon']['size'];


                if ($icon_old != $_FILES['icon']['name']) {
                    unlink("./assets/images/category/$icon_old");


                    $this->load->library('upload', $this->upload_icon());

                    $this->upload->initialize($this->upload_icon());

                    if (!$this->upload->do_upload('icon')) {

                        $this->upload->display_errors();

                        $upload_error[] = array('error' => $this->upload->display_errors());
                    } else {
                        $upload_data = $this->upload->data();
                        $name_array = $upload_data['file_name'];

                        $insertArray1 = array(
                            'icon' => $upload_data['file_name'],
                        );
                        $this->db->where('category_id', $edit_id);
                        $this->db->update('category', $insertArray1);
                    }
                } else {
                    $insertArray1 = array(
                        'icon' => $icon_old
                    );
                    $this->db->where('category_id', $edit_id);
                    $this->db->update('category', $insertArray1);
                }
            }


            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
					<button type="button" class="close" data-dismiss="alert">×</button>
					
					<div class="alert-icon">
					 <i class="icon-check"></i>
					</div>
					<div class="alert-message">
					  <span><strong>Category!</strong> update successfully. <a href="javascript:void();" class="alert-link"></a></span>
					</div>
				  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/category');
        } else {
            $status = 'error';
            if (form_error('category_name')) {
                $errors['category_nameError'] = form_error('category_name');
            }

            if (form_error('position')) {
                $errors['positionError'] = form_error('position');
            }
            if (form_error('color')) {
                $errors['colorError'] = form_error('color');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;

        echo json_encode($data);
    }



    /********************** Delete category Data in category Table  **********************
     *********************************************************************************/
    public function delete_category()
    {
        $delete_id = $this->input->post('delete_id');

        $this->db->select('*');
        $this->db->from('category');
        $this->db->where('category_id', $delete_id);
        $query  = $this->db->get();
        $result = $query->row();
        $icon = $result->icon;

        unlink('./assets/images/category/' . $icon);

        $this->db->where('category_id', $delete_id);
        $this->db->delete('category');
        echo $delete_id;
    }

    /****************************** Subcategory View Page **************/

    public function upload_subcategory()
    {



        $config = array();
        $config['upload_path'] = "assets/images/subcategory/";
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['overwrite'] = TRUE;
        return $config;
    }

    public function subcategory()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['all_category'] = $this->product_model->get_all_category_model();
            $data['all_subcategory'] = $this->product_model->get_all_subcategory_model();
            $this->load->view('common/header');
            $this->load->view('product/subcategory', $data);
            $this->load->view('common/footer');
        }
    }



    public function add_subcategory_data()
    {
        $login_type   = $this->session->userdata('type');

        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('sub_category', 'subcategory name', 'required');
        $this->form_validation->set_rules('category_id', 'category name', 'required');
        $this->form_validation->set_rules('color', 'color', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $sub_category  = $this->input->post('sub_category');
        $category_id  = $this->input->post('category_id');
        $color  = $this->input->post('color');

        if ($this->form_validation->run() == TRUE) {
            $data_subcategory = array(
                'sub_category'      => $sub_category,
                'category_id'      => $category_id,
                'color'      => $color,
                'franchise_id'      => $login_type,


            );

            $this->db->insert('sub_category', $data_subcategory);
            $insert_id = $this->db->insert_id();


            $files = $_FILES;

            ///////// Icon ////////////////

            if (!empty($_FILES['icon']['name'])) {

                $_FILES['icon']['name'] = $files['icon']['name'];
                $_FILES['icon']['type'] = $files['icon']['type'];
                $_FILES['icon']['tmp_name'] = $files['icon']['tmp_name'];
                $_FILES['icon']['error'] = $files['icon']['error'];
                $_FILES['icon']['size'] = $files['icon']['size'];



                $this->load->library('upload', $this->upload_subcategory());

                $this->upload->initialize($this->upload_subcategory());

                if (!$this->upload->do_upload('icon')) {

                    $this->upload->display_errors();

                    $upload_error[] = array('error' => $this->upload->display_errors());
                } else {
                    $upload_data = $this->upload->data();
                    $name_array = $upload_data['file_name'];

                    $insertArray1 = array(
                        'icon' => $upload_data['file_name'],
                    );
                    $this->db->where('sub_category_id', $insert_id);
                    $this->db->update('sub_category', $insertArray1);
                }
            }



            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Subcategory!</strong> add successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/subcategory');
        } else {
            $status = 'error';
            if (form_error('sub_category')) {
                $errors['sub_categoryError'] = form_error('sub_category');
            }
            if (form_error('category_id')) {
                $errors['category_idError'] = form_error('category_id');
            }
            if (form_error('color')) {
                $errors['colorError'] = form_error('color');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }


    public function update_subcategory_data()
    {
        $errors   = array();
        $message  = '';
        $redirect = '';
        $edit_id  = $this->input->post('sub_category_id');
        $this->form_validation->set_rules('sub_category', 'subcategory name', 'required');
        $this->form_validation->set_rules('category_id', 'category name', 'required');
        $this->form_validation->set_rules('color', 'color', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $sub_category  = $this->input->post('sub_category');
        $category_id  = $this->input->post('category_id');
        $color  = $this->input->post('color');
        $date = date('Y-m-d H:i:s');

        $icon_old   = $this->input->post('icon_old');

        if ($this->form_validation->run() == TRUE) {
            $update_data = array(
                'sub_category'      => $sub_category,
                'category_id'      => $category_id,
                'color'      => $color,
                'update_datetime'        => $date,

            );
            $status = 'success';
            $this->db->where('sub_category_id', $edit_id)->update('sub_category', $update_data);

            $files = $_FILES;

            ///////// Main Image  ////////////////

            if (!empty($_FILES['icon']['name'])) {

                $_FILES['icon']['name'] = $files['icon']['name'];

                $_FILES['icon']['type'] = $files['icon']['type'];
                $_FILES['icon']['tmp_name'] = $files['icon']['tmp_name'];
                $_FILES['icon']['error'] = $files['icon']['error'];
                $_FILES['icon']['size'] = $files['icon']['size'];


                if ($icon_old != $_FILES['icon']['name']) {
                    unlink("./assets/images/subcategory/$icon_old");


                    $this->load->library('upload', $this->upload_subcategory());

                    $this->upload->initialize($this->upload_subcategory());

                    if (!$this->upload->do_upload('icon')) {

                        $this->upload->display_errors();

                        $upload_error[] = array('error' => $this->upload->display_errors());
                    } else {
                        $upload_data = $this->upload->data();
                        $name_array = $upload_data['file_name'];

                        $insertArray1 = array(
                            'icon' => $upload_data['file_name'],
                        );
                        $this->db->where('sub_category_id', $edit_id);
                        $this->db->update('sub_category', $insertArray1);
                    }
                } else {
                    $insertArray1 = array(
                        'icon' => $icon_old
                    );
                    $this->db->where('sub_category_id', $edit_id);
                    $this->db->update('sub_category', $insertArray1);
                }
            }


            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Subcategory!</strong> add successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/subcategory');
        } else {
            $status = 'error';
            if (form_error('sub_category')) {
                $errors['sub_categoryError'] = form_error('sub_category');
            }
            if (form_error('category_id')) {
                $errors['category_idError'] = form_error('category_id');
            }
            if (form_error('color')) {
                $errors['colorError'] = form_error('color');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }

    /********************** Delete Subcategory Data in sub_category Table  **********************
     **********************************************************************************************/
    public function delete_subcategory()
    {
        $delete_id = $this->input->post('delete_id');


        $this->db->where('sub_category_id', $delete_id);
        $this->db->delete('sub_category');
        echo $delete_id;
    }


    /****************************** Sub Subcategory View Page **************/


    public function upload_sub_subcategory()
    {



        $config = array();
        $config['upload_path'] = "assets/images/sub_subcategory/";
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['overwrite'] = TRUE;
        return $config;
    }

    public function sub_subcategory()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['all_category'] = $this->product_model->get_all_category_model();
            $data['all_sub_subcategory'] = $this->product_model->get_all_sub_subcategory_model();
            $this->load->view('common/header');
            $this->load->view('product/sub_subcategory', $data);
            $this->load->view('common/footer');
        }
    }

    public function add_sub_subcategory_data()
    {
        $login_type   = $this->session->userdata('type');

        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('category_id', 'category', 'required');
        $this->form_validation->set_rules('sub_category_id', 'sub category', 'required');
        $this->form_validation->set_rules('sub_subcategory', 'sub subcategory', 'required');
        $this->form_validation->set_rules('color', 'color', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $category_id  = $this->input->post('category_id');
        $sub_category_id  = $this->input->post('sub_category_id');
        $sub_subcategory  = $this->input->post('sub_subcategory');
        $color  = $this->input->post('color');

        if ($this->form_validation->run() == TRUE) {
            $data_sub_subcategory = array(
                'sub_subcategory'      => $sub_subcategory,
                'category_id'          => $category_id,
                'sub_category_id'          => $sub_category_id,
                'franchise_id'          => $login_type,
                'color'          => $color,

            );

            $this->db->insert('sub_subcategory', $data_sub_subcategory);
            $insert_id = $this->db->insert_id();


            $files = $_FILES;

            ///////// Icon ////////////////

            if (!empty($_FILES['icon']['name'])) {

                $_FILES['icon']['name'] = $files['icon']['name'];
                $_FILES['icon']['type'] = $files['icon']['type'];
                $_FILES['icon']['tmp_name'] = $files['icon']['tmp_name'];
                $_FILES['icon']['error'] = $files['icon']['error'];
                $_FILES['icon']['size'] = $files['icon']['size'];



                $this->load->library('upload', $this->upload_sub_subcategory());

                $this->upload->initialize($this->upload_sub_subcategory());

                if (!$this->upload->do_upload('icon')) {

                    $this->upload->display_errors();

                    $upload_error[] = array('error' => $this->upload->display_errors());
                } else {
                    $upload_data = $this->upload->data();
                    $name_array = $upload_data['file_name'];

                    $insertArray1 = array(
                        'icon' => $upload_data['file_name'],
                    );
                    $this->db->where('sub_subcategory_id', $insert_id);
                    $this->db->update('sub_subcategory', $insertArray1);
                }
            }



            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Sub subcategory!</strong> add successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/sub_subcategory');
        } else {
            $status = 'error';
            if (form_error('sub_subcategory')) {
                $errors['sub_subcategoryError'] = form_error('sub_subcategory');
            }
            if (form_error('category_id')) {
                $errors['category_idError'] = form_error('category_id');
            }
            if (form_error('sub_category_id')) {
                $errors['sub_category_idError'] = form_error('sub_category_id');
            }
            if (form_error('color')) {
                $errors['colorError'] = form_error('color');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }


    public function update_sub_subcategory_data()
    {
        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('category_id', 'category', 'required');
        $this->form_validation->set_rules('sub_category_id', 'sub category', 'required');
        $this->form_validation->set_rules('sub_subcategory', 'sub subcategory', 'required');
        $this->form_validation->set_rules('color', 'color', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $category_id  = $this->input->post('category_id');
        $sub_category_id  = $this->input->post('sub_category_id');
        $sub_subcategory  = $this->input->post('sub_subcategory');
        $color  = $this->input->post('color');

        $edit_id  = $this->input->post('sub_subcategory_id');
        $icon_old   = $this->input->post('icon_old');

        if ($this->form_validation->run() == TRUE) {
            $update_sub_subcategory = array(
                'sub_subcategory'      => $sub_subcategory,
                'category_id'          => $category_id,
                'sub_category_id'          => $sub_category_id,
                'color'          => $color,

            );

            $this->db->where('sub_subcategory_id', $edit_id)->update('sub_subcategory', $update_sub_subcategory);


            $files = $_FILES;

            ///////// Main Image  ////////////////

            if (!empty($_FILES['icon']['name'])) {

                $_FILES['icon']['name'] = $files['icon']['name'];

                $_FILES['icon']['type'] = $files['icon']['type'];
                $_FILES['icon']['tmp_name'] = $files['icon']['tmp_name'];
                $_FILES['icon']['error'] = $files['icon']['error'];
                $_FILES['icon']['size'] = $files['icon']['size'];


                if ($icon_old != $_FILES['icon']['name']) {
                    unlink("./assets/images/sub_subcategory/$icon_old");


                    $this->load->library('upload', $this->upload_sub_subcategory());

                    $this->upload->initialize($this->upload_sub_subcategory());

                    if (!$this->upload->do_upload('icon')) {

                        $this->upload->display_errors();

                        $upload_error[] = array('error' => $this->upload->display_errors());
                    } else {
                        $upload_data = $this->upload->data();
                        $name_array = $upload_data['file_name'];

                        $insertArray1 = array(
                            'icon' => $upload_data['file_name'],
                        );
                        $this->db->where('sub_subcategory_id', $edit_id);
                        $this->db->update('sub_subcategory', $insertArray1);
                    }
                } else {
                    $insertArray1 = array(
                        'icon' => $icon_old
                    );
                    $this->db->where('sub_subcategory_id', $edit_id);
                    $this->db->update('sub_subcategory', $insertArray1);
                }
            }
            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Sub subcategory!</strong> update successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/sub_subcategory');
        } else {
            $status = 'error';
            if (form_error('sub_subcategory')) {
                $errors['sub_subcategoryError'] = form_error('sub_subcategory');
            }
            if (form_error('category_id')) {
                $errors['category_idError'] = form_error('category_id');
            }
            if (form_error('sub_category_id')) {
                $errors['sub_category_idError'] = form_error('sub_category_id');
            }
            if (form_error('color')) {
                $errors['colorError'] = form_error('color');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }
    /******************************************** returns all Subcategory by category id**************************
     ***************************************************************************************************************/

    public function all_sub_subcategory_by_category_id()
    {
        $category_id = $this->input->post('id');
        $data     = $this->product_model->get_all_sub_subcategory_by_category_id($category_id);
        echo json_encode($data);
    }


    /********************** Delete Sub Subcategory Data in sub_subcategory Table  **********************
     *****************************************************************************************************/
    public function delete_sub_subcategory()
    {
        $delete_id = $this->input->post('delete_id');


        $this->db->where('sub_subcategory_id', $delete_id);
        $this->db->delete('sub_subcategory');

        $this->db->where('sub_subcategory_id', $delete_id);
        $this->db->delete('subcategory_wise_brand');
        echo $delete_id;
    }


    /****************************** Pincode View Page **************/

    public function pincode()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['all_pincode'] = $this->product_model->get_all_pincode_model();
            $this->load->view('common/header');
            $this->load->view('product/pincode', $data);
            $this->load->view('common/footer');
        }
    }


    public function add_pincode_data()
    {
        $login_type   = $this->session->userdata('type');

        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('pincode', 'pincode', 'required');
        $this->form_validation->set_rules('city', 'city', 'required');
        $this->form_validation->set_rules('location_area', 'location', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $pincode  = $this->input->post('pincode');
        $city  = $this->input->post('city');
        $location_area  = $this->input->post('location_area');
        $delivery_charges  = $this->input->post('delivery_charges');

        if ($this->form_validation->run() == TRUE) {
            $data_pincode = array(
                'pincode'      => $pincode,
                'city'      => $city,
                'location'      => $location_area,
                'delivery_charges'      => $delivery_charges,
                'franchise_id'      => $login_type,

            );

            $this->db->insert('pincode', $data_pincode);


            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Pincode!</strong> add successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/pincode');
        } else {
            $status = 'error';
            if (form_error('pincode')) {
                $errors['pincodeError'] = form_error('pincode');
            }

            if (form_error('city')) {
                $errors['cityError'] = form_error('city');
            }
            if (form_error('location_area')) {
                $errors['location_areaError'] = form_error('location_area');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }

    public function update_pincode_data()
    {
        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('pincode', 'pincode', 'required');
        $this->form_validation->set_rules('city', 'city', 'required');
        $this->form_validation->set_rules('location_area', 'location', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $pincode  = $this->input->post('pincode');
        $city  = $this->input->post('city');
        $location_area  = $this->input->post('location_area');
        $delivery_charges = $this->input->post('delivery_charges');
        $edit_id  = $this->input->post('pincode_id');

        if ($this->form_validation->run() == TRUE) {
            $update_pincode = array(
                'pincode'      => $pincode,
                'city'      => $city,
                'location'      => $location_area,
                'delivery_charges'      => $delivery_charges,

            );

            $this->db->where('pincode_id', $edit_id)->update('pincode', $update_pincode);


            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Pincode!</strong> update successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/pincode');
        } else {
            $status = 'error';
            if (form_error('pincode')) {
                $errors['pincodeError'] = form_error('pincode');
            }

            if (form_error('city')) {
                $errors['cityError'] = form_error('city');
            }
            if (form_error('location_area')) {
                $errors['location_areaError'] = form_error('location_area');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }


    public function delete_pincode()
    {
        $delete_id = $this->input->post('delete_id');


        $this->db->where('pincode_id', $delete_id);
        $this->db->delete('pincode');


        echo $delete_id;
    }


    /****************************** Upload Product View Page **************/

    public function upload_product()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['all_category'] = $this->product_model->get_all_category_model();
            $data['all_brand'] = $this->product_model->get_all_brand_model();
            $data['all_currencies'] = $this->GlobalModal->executeQuery('select * from lp_currency_master where status=1');
            $this->load->view('common/header');
            $this->load->view('product/upload_product', $data);
            $this->load->view('common/footer');
        }
    }





    /******************************************** returns all Sub_subcategory by subcategory id**************************
     ***************************************************************************************************************/

    public function all_sub_subcategory_by_sub_category_id()
    {
        $sub_category_id = $this->input->post('id');
        $data     = $this->product_model->get_all_all_sub_subcategory_by_sub_category_id($sub_category_id);
        echo json_encode($data);
    }


    /****************************** Add product data **************/
    public function upload_product_image()
    {


        $config = array();
        $config['upload_path'] = "assets/images/product/";
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['overwrite'] = TRUE;
        return $config;
    }

    public function upload_product_image1()
    {


        $config = array();
        $config['upload_path'] = "assets/images/thumbnail/";
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['overwrite'] = TRUE;
        return $config;
    }
    public function add_product_data()
    {
        $login_type   = $this->session->userdata('type');

        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('product_name', 'product name', 'required');
        $this->form_validation->set_rules('category_id', 'category name', 'required');
        $this->form_validation->set_rules('unit', 'unit', 'required');
        $this->form_validation->set_rules('product_detail', 'description', 'required');
        $this->form_validation->set_rules('brand_id', 'brand', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $product_name  = $this->input->post('product_name');
        $category_id  = $this->input->post('category_id');
        $sub_category_id = $this->input->post('sub_category_id');
        $sub_subcategory_id = $this->input->post('sub_subcategory_id');
        $brand_id = $this->input->post('brand_id');
        $unit = $this->input->post('unit');
        $description = $this->input->post('product_detail');
        $shipping_cost = $this->input->post('shipping_cost');
        $qty = $this->input->post('qty');
        $type = $this->input->post('type');

        $product_code = mt_rand(000000, 999999);
        //	echo $aaaa = count($_FILES['thumbnail_image']['name']);die;


        if ($this->form_validation->run() == TRUE) {
            $cnt = count($title = $this->input->post('title'));
            $nib = $this->input->get_post('nib_drp');
            $clip = $this->input->get_post('clip_drp');
            $material = $this->input->get_post('material_drp');

            $tsp = ['dimension', 'nib_material', 'pen_material', 'trim', 'filling_mechanism'];
            $tspArray=[];
            foreach($tsp as $tspData){
                $tspArray[$tspData]=$this->input->get_post($tspData);
            }
            
            $data_product = array(
                'product_name'      => $product_name,
                'category_id'      => $category_id,
                'sub_category_id'      => $sub_category_id,
                'sub_subcategory_id'      => $sub_subcategory_id,
                'brand_id'      => $brand_id,
                'unit'      => $unit,
                'description'      => $description,
                'shipping_cost'      => $shipping_cost,
                'qty'      => $qty,
                'franchise_id'      => $login_type,
                'type'      => $type,
                'product_code'      => $product_code,
                'nib' => json_encode($nib),
                'clip' => json_encode($clip),
                'material' => json_encode($material),
                'qty' => 100,
                'technical_specification'=>count($tspArray)>0? json_encode($tspArray):''
            );

            // print_r($data_product);die;

            $this->db->insert('vegshopy_product', $data_product);
            $insert_id = $this->db->insert_id();

            $priceArray = array('euro', 'pound', 'rupee', 'usd');
            $priceTypeArray = array('mrp', 'price', 'discount');
            foreach ($priceArray as $price) {
                $priceInsertData = array(
                    'product_id'           => $insert_id,
                    'currency'                => $price,
                    'mrp'           => $_POST[$price . '_mrp'],
                    'price'             => $_POST[$price . '_price'],
                    'discount'             => $_POST[$price . '_discount'],
                );
                $this->db->insert('lp_product_price', $priceInsertData);
            }

            $files = $_FILES;

            ///////// Main Image ////////////////


            if (!empty($_FILES['main_image']['name'])) {

                $_FILES['main_image']['name'] = $files['main_image']['name'];
                $_FILES['main_image']['type'] = $files['main_image']['type'];
                $_FILES['main_image']['tmp_name'] = $files['main_image']['tmp_name'];
                $_FILES['main_image']['error'] = $files['main_image']['error'];
                $_FILES['main_image']['size'] = $files['main_image']['size'];

                $this->load->library('upload', $this->upload_product_image());

                $this->upload->initialize($this->upload_product_image());

                if (!$this->upload->do_upload('main_image')) {

                    $this->upload->display_errors();
                    $upload_error[] = array('error' => $this->upload->display_errors());
                } else {
                    $upload_data = $this->upload->data();
                    $name_array = $upload_data['file_name'];



                    $insertArray1 = array(
                        'main_image'      => $upload_data['file_name'],

                    );
                    $this->db->where('product_id', $insert_id);
                    $this->db->update('vegshopy_product', $insertArray1);
                }
            }

            if (!empty($_FILES['thumbnail_image']['name']) && !empty($_FILES['thumbnail_image']['name'][0])) {

                $cpt = count($_FILES['thumbnail_image']['name']);
                for ($i = 0; $i < $cpt; $i++) {
                    $_FILES['thumbnail_image']['name'] = $files['thumbnail_image']['name'][$i];
                    $_FILES['thumbnail_image']['type'] = $files['thumbnail_image']['type'][$i];
                    $_FILES['thumbnail_image']['tmp_name'] = $files['thumbnail_image']['tmp_name'][$i];
                    $_FILES['thumbnail_image']['error'] = $files['thumbnail_image']['error'][$i];
                    $_FILES['thumbnail_image']['size'] = $files['thumbnail_image']['size'][$i];


                    $this->load->library('upload', $this->upload_product_image1());
                    $this->upload->initialize($this->upload_product_image1());

                    if (!$this->upload->do_upload('thumbnail_image')) {
                        $this->upload->display_errors();
                        $upload_error[] = array('error' => $this->upload->display_errors());
                    } else {

                        $name_array = array();
                        $upload_data = $this->upload->data();
                        $filepath = $upload_data['file_name'];
                        $colorInsertData = array(
                            'product_id'           => $insert_id,
                            'title'                => $_POST['title'][$i],
                            'image'           => $filepath,
                        );
                        $this->db->insert('product_details', $colorInsertData);
                    }
                }
            }
            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Product!</strong> add successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/product_list');
        } else {
            $status = 'error';
            if (form_error('product_name')) {
                $errors['product_nameError'] = form_error('product_name');
            }
            if (form_error('category_id')) {
                $errors['category_idError'] = form_error('category_id');
            }


            if (form_error('unit')) {
                $errors['unitError'] = form_error('unit');
            }

            if (form_error('qty')) {
                $errors['qtyError'] = form_error('qty');
            }
            if (form_error('product_detail')) {
                $errors['product_detailError'] = form_error('product_detail');
            }
            if (form_error('type')) {
                $errors['typeError'] = form_error('type');
            }
            if (form_error('brand_id')) {
                $errors['brand_idError'] = form_error('brand_id');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }


    /****************************** Product List View Page **************/

    public function product_list()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $this->load->view('common/header');
            $this->load->view('product/product_list');
            $this->load->view('common/footer');
        }
    }

    /****************************** Banner View Page **************/

    public function banner()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['all_banner'] = $this->product_model->get_all_banner_model();
            $data['all_category'] = $this->product_model->get_all_category_model();
            $data['all_products'] = $this->GlobalModal->executeQuery('select product_id,product_name from vegshopy_product');
            $this->load->view('common/header');
            $this->load->view('product/banner', $data);
            $this->load->view('common/footer');
        }
    }


    //**********************ADD FEATURED********************************* */

    public function featured()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['all_featured'] = $this->product_model->get_all_featured_model();
            $this->load->view('common/header');
            $this->load->view('product/featured', $data);
            $this->load->view('common/footer');
        }
    }

    /////////////////////////////////ADD FEatured///////////////////////////////////////////////////
    public function add_featured_data()
    {
        $login_type   = $this->session->userdata('type');

        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('product_id', 'product_id', 'required');
        $this->form_validation->set_rules('position', 'position', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $product_id  = $this->input->post('product_id');
        $position  = $this->input->post('position');

        if ($this->form_validation->run() == TRUE) {
            $data_banner = array(
                'product_id'      => $product_id,
                'position'         => $position,
                'status'     => 0,

            );

            $this->db->insert('lp_featured', $data_banner);
            $insert_id = $this->db->insert_id();



            $files = $_FILES;

            ///////// Featured ////////////////

            if (!empty($_FILES['banner']['name'])) {
                $_FILES['banner']['name'] = $files['banner']['name'];
                $_FILES['banner']['type'] = $files['banner']['type'];
                $_FILES['banner']['tmp_name'] = $files['banner']['tmp_name'];
                $_FILES['banner']['error'] = $files['banner']['error'];
                $_FILES['banner']['size'] = $files['banner']['size'];

                $this->load->library('upload', $this->upload_featured());

                $this->upload->initialize($this->upload_featured());
                if (!$this->upload->do_upload('banner')) {
                    $this->upload->display_errors();
                    $upload_error[] = array('error' => $this->upload->display_errors());
                } else {

                    $upload_data = $this->upload->data();
                    $name_array = $upload_data['file_name'];

                    $insertArray1 = array(
                        'image'      => $upload_data['file_name'],
                    );
                    $this->db->where('id', $insert_id);
                    $this->db->update('lp_featured', $insertArray1);
                }
            }

            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Banner!</strong> add successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/featured');
        } else {
            $status = 'error';
            if (form_error('product_id')) {
                $errors['banner_nameError'] = form_error('product_id');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }


    /////////////////////////Update Feature//////////////////////

    public function update_feature_data()
    {
        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('product_id', 'product_id', 'required');
        $this->form_validation->set_rules('position', 'position', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $product_id  = $this->input->post('product_id');
        $position  = $this->input->post('position');
        $edit_id  = $this->input->post('id');

        if ($this->form_validation->run() == TRUE) {
            $update_banner = array(
                'product_id' => $product_id,
                'position'      => $position,

            );

            $this->db->where('id', $edit_id)->update('lp_featured', $update_banner);


            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Position!</strong> update successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/featured');
        } else {
            $status = 'error';
            if (form_error('position')) {
                $errors['positionError'] = form_error('position');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }
    ////////////////////////////Delete Featured/////////////////////////////////

    public function delete_feature()
    {
        $delete_id = $this->input->post('delete_id');

        $this->db->select('*');
        $this->db->from('lp_featured');
        $this->db->where('id', $delete_id);
        $query  = $this->db->get();
        $result = $query->row();
        $banner = $result->banner;

        unlink('./assets/images/featured/' . $banner);

        $this->db->where('id', $delete_id);
        $this->db->delete('lp_featured');
        echo $delete_id;
    }

    /********************** Disbale Feature  **********************
     *********************************************************************************/
    public function disable_feature()
    {
        $delete_id = $this->input->post('id');

        $update_data = array(

            'status'      => '1',

        );

        $this->db->where('id', $delete_id)->update('lp_featured', $update_data);
        echo $delete_id;
    }


    /********************** Disbale feature  **********************
     *********************************************************************************/
    public function enable_feature()
    {
        $delete_id = $this->input->post('id');

        $update_data = array(

            'status'      => '0',

        );

        $this->db->where('id', $delete_id)->update('lp_featured', $update_data);
        echo $delete_id;
    }





    //////////////////////////Upload Data//////////////////////////////////////////
    public function upload_featured()
    {
        $config = array();
        $config['upload_path'] = "assets/images/featured/";
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['overwrite'] = TRUE;
        return $config;
    }

































    public function testimonials()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['all_featured'] = $this->product_model->get_all_testimonials_model();
            // $data['all_category'] = $this->product_model->get_all_category_model();
            $this->load->view('common/header');
            $this->load->view('product/testimonials', $data);
            $this->load->view('common/footer');
        }
    }

    /////////////////////////////////ADD FEatured///////////////////////////////////////////////////
    public function add_testimonials_data()
    {
        $login_type   = $this->session->userdata('type');

        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('review', 'review', 'required');
        $this->form_validation->set_rules('rating', 'rating', 'required');
        $this->form_validation->set_rules('author', 'author', 'required');
        $this->form_validation->set_rules('position', 'position', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $review  = $this->input->post('review');
        $rating  = $this->input->post('rating');
        $author  = $this->input->post('author');
        $position  = $this->input->post('position');

        if ($this->form_validation->run() == TRUE) {
            $data_banner = array(
                'review'      => $review,
                'rating'      => $rating,
                'author'      => $author,
                'position'    => $position,
                'status'     => 0,

            );

            $this->db->insert('lp_testimonials', $data_banner);
            $insert_id = $this->db->insert_id();





            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Banner!</strong> add successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/testimonials');
        } else {
            $status = 'error';
            if (form_error('REVIEW')) {
                $errors['banner_nameError'] = form_error('REVIEWlp_testimonials');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }


    /////////////////////////Update Feature//////////////////////

    public function update_testimonials_data()
    {
        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('review', 'review', 'required');
        $this->form_validation->set_rules('rating', 'rating', 'required');
        $this->form_validation->set_rules('author', 'author', 'required');
        $this->form_validation->set_rules('position', 'position', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $review  = $this->input->post('review');
        $rating  = $this->input->post('rating');
        $author  = $this->input->post('author');
        $position  = $this->input->post('position');
        $edit_id  = $this->input->post('id');

        if ($this->form_validation->run() == TRUE) {
            $update_banner = array(
                'review'      => $review,
                'rating'      => $rating,
                'author'      => $author,
                'position'      => $position,

            );

            $this->db->where('id', $edit_id)->update('lp_testimonials', $update_banner);


            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Position!</strong> update successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/testimonials');
        } else {
            $status = 'error';
            if (form_error('position')) {
                $errors['positionError'] = form_error('position');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }
    ////////////////////////////Delete Featured/////////////////////////////////

    public function delete_testimonials()
    {
        $delete_id = $this->input->post('delete_id');

        $this->db->select('*');
        $this->db->from('lp_testimonials');
        $this->db->where('id', $delete_id);
        $query  = $this->db->get();
        $result = $query->row();
        $banner = $result->banner;

        // unlink('./assets/images/featured/' . $banner);

        $this->db->where('id', $delete_id);
        $this->db->delete('lp_testimonials');
        echo $delete_id;
    }

    /********************** Disbale Feature  **********************
     *********************************************************************************/
    public function disable_testimonials()
    {
        $delete_id = $this->input->post('id');

        $update_data = array(

            'status'      => '1',

        );

        $this->db->where('id', $delete_id)->update('lp_testimonials', $update_data);
        echo $delete_id;
    }


    /********************** Disbale feature  **********************
     *********************************************************************************/
    public function enable_testimonials()
    {
        $delete_id = $this->input->post('id');

        $update_data = array(

            'status'      => '0',

        );

        $this->db->where('id', $delete_id)->update('lp_testimonials', $update_data);
        echo $delete_id;
    }










































    /********************** Add banner data **************/

    public function upload_banner()
    {
        $config = array();
        $config['upload_path'] = "assets/images/banner/";
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['overwrite'] = TRUE;
        return $config;
    }

    public function add_banner_data()
    {
        $login_type   = $this->session->userdata('type');

        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('tag', 'tag name', 'required');
        $this->form_validation->set_rules('banner_name', 'brand name', 'required');
        $this->form_validation->set_rules('position', 'position', 'required');
        $this->form_validation->set_rules('category_id', 'category', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $banner_name  = $this->input->post('banner_name');
        $tag  = $this->input->post('tag');
        $position  = $this->input->post('position');
        $text_position  = $this->input->post('text_position');
        $category_id  = $this->input->post('category_id');

        if ($this->form_validation->run() == TRUE) {
            $data_banner = array(
                'tag'      => $tag,
                'banner_name'      => $banner_name,
                'position'         => $position,
                'franchise_id'     => $login_type,
                'category_id'      => $category_id,
                'text_position' => $text_position
            );

            $this->db->insert('banner', $data_banner);
            $insert_id = $this->db->insert_id();



            $files = $_FILES;

            ///////// banner ////////////////

            if (!empty($_FILES['banner']['name'])) {

                $_FILES['banner']['name'] = $files['banner']['name'];
                $_FILES['banner']['type'] = $files['banner']['type'];
                $_FILES['banner']['tmp_name'] = $files['banner']['tmp_name'];
                $_FILES['banner']['error'] = $files['banner']['error'];
                $_FILES['banner']['size'] = $files['banner']['size'];

                $this->load->library('upload', $this->upload_banner());

                $this->upload->initialize($this->upload_banner());

                if (!$this->upload->do_upload('banner')) {

                    $this->upload->display_errors();
                    $upload_error[] = array('error' => $this->upload->display_errors());
                } else {
                    $upload_data = $this->upload->data();
                    $name_array = $upload_data['file_name'];

                    $insertArray1 = array(
                        'banner'      => $upload_data['file_name'],

                    );
                    $this->db->where('banner_id', $insert_id);
                    $this->db->update('banner', $insertArray1);
                }
            }

            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Banner!</strong> add successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/banner');
        } else {
            $status = 'error';
            if (form_error('banner_name')) {
                $errors['banner_nameError'] = form_error('banner_name');
            }

            if (form_error('position')) {
                $errors['positionError'] = form_error('position');
            }

            if (form_error('category_id')) {
                $errors['category_idError'] = form_error('category_id');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }



    /********************** Delete Banner Data in banner Table  **********************
     *********************************************************************************/
    public function delete_banner()
    {
        $delete_id = $this->input->post('delete_id');

        $this->db->select('*');
        $this->db->from('banner');
        $this->db->where('banner_id', $delete_id);
        $query  = $this->db->get();
        $result = $query->row();
        $banner = $result->banner;

        unlink('./assets/images/banner/' . $banner);

        $this->db->where('banner_id', $delete_id);
        $this->db->delete('banner');
        echo $delete_id;
    }




    /********************** Disbale Banner  **********************
     *********************************************************************************/
    public function disable_banner()
    {
        $delete_id = $this->input->post('delete_id');

        $update_data = array(

            'isActive'      => '1',

        );

        $this->db->where('banner_id', $delete_id)->update('banner', $update_data);
        echo $delete_id;
    }


    /********************** Disbale Banner  **********************
     *********************************************************************************/
    public function enable_banner()
    {
        $delete_id = $this->input->post('delete_id');

        $update_data = array(

            'isActive'      => '0',

        );

        $this->db->where('banner_id', $delete_id)->update('banner', $update_data);
        echo $delete_id;
    }


    /****************************** Slot View Page **************/

    public function slot_time()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $this->load->view('common/header');
            $this->load->view('product/slot_time');
            $this->load->view('common/footer');
        }
    }



    public function slot()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['all_slot'] = $this->product_model->get_all_slot_model();
            $this->load->view('common/header');
            $this->load->view('product/slot', $data);
            $this->load->view('common/footer');
        }
    }


    public function add_slot_data()
    {
        $login_type   = $this->session->userdata('type');
        $errors   = array();
        $message  = '';
        $redirect = '';

        $cnt = count($this->input->post('slot_timing'));
        for ($i = 0; $i < $cnt; $i++) {
            $data2 = array(

                'slot_timing'      => $_POST['slot_timing'][$i],
                'day'              => $_POST['day'][$i],
                'franchise_id'     => $login_type,

            );

            $this->db->insert('slot_timing', $data2);
        }


        $status = 'success';
        $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
					<button type="button" class="close" data-dismiss="alert">×</button>
					
					<div class="alert-icon">
					 <i class="icon-check"></i>
					</div>
					<div class="alert-message">
					  <span><strong>Slot!</strong> add successfully. <a href="javascript:void();" class="alert-link"></a></span>
					</div>
				  </div>';

        $this->session->set_flashdata('message', $message);
        $redirect = base_url('product/slot_time');


        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }



    public function update_slot_data()
    {
        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('slot_timing', 'slot', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $slot_timing = $this->input->post('slot_timing');
        $edit_id  = $this->input->post('slot_id');

        if ($this->form_validation->run() == TRUE) {
            $update_slot = array(

                'slot_timing'      => $slot_timing,

            );

            $this->db->where('slot_id', $edit_id)->update('slot_timing', $update_slot);


            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Slot!</strong> update successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/slot');
        } else {
            $status = 'error';
            if (form_error('slot_timing')) {
                $errors['slot_timingError'] = form_error('slot_timing');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }


    /****************************** Pickup point View Page **************/

    public function pickup_point()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['all_pickup'] = $this->product_model->get_all_pickup_point_model();
            $this->load->view('common/header');
            $this->load->view('product/pickup_point', $data);
            $this->load->view('common/footer');
        }
    }


    public function add_pickup_point_data()
    {
        $login_type   = $this->session->userdata('type');

        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('pickup_address', 'pickupup point', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $pickup_address  = $this->input->post('pickup_address');

        if ($this->form_validation->run() == TRUE) {
            $data_pickup_point = array(
                'pickup_address' => $pickup_address,
                'franchise_id'      => $login_type,

            );

            $this->db->insert('pickup_point', $data_pickup_point);


            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Pickup point!</strong> add successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/pickup_point');
        } else {
            $status = 'error';
            if (form_error('pickup_address')) {
                $errors['pickup_addressError'] = form_error('pickup_address');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }

    public function update_pickup_point_data()
    {
        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('pickup_address', 'pickup point', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $pickup_address  = $this->input->post('pickup_address');
        $edit_id  = $this->input->post('pick_up_id');

        if ($this->form_validation->run() == TRUE) {
            $update_pickup = array(
                'pickup_address'      => $pickup_address,

            );

            $this->db->where('pick_up_id', $edit_id)->update('pickup_point', $update_pickup);


            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Pickup point!</strong> update successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/pickup_point');
        } else {
            $status = 'error';
            if (form_error('pickup_address')) {
                $errors['pickup_addressError'] = form_error('pickup_address');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }


    public function delete_pickup_point()
    {
        $delete_id = $this->input->post('delete_id');


        $this->db->where('pick_up_id', $delete_id);
        $this->db->delete('pickup_point');


        echo $delete_id;
    }


    ////////////////////////////////ADD FEATURED/////////////////////////////////////////////////////////////




    //////////////////////////////////AJAX PRODUCT LIST //////////////////////////

    public function ajax_product_list()
    {

        $columns = array(
            0 => 'product_id',
            1 => 'main_image',
            2 => 'product_name',
            3 => 'category',
            4 => 'brand',
            5 => 'qty',
            8 => 'franchise',
            9 => 'action',


        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->product_model->product_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $posts = $this->product_model->product_list($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $posts =  $this->product_model->product_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->product_model->product_search_count($search);
        }

        $data = array();
        if (!empty($posts)) {
            $i = 1;
            foreach ($posts as $post) {

                $nestedData['product_id'] = $i;
                $nestedData['product_name'] = $post->product_name;
                $nestedData['category'] = $post->name;
                $nestedData['brand'] = $post->brand_name;
                $this->db->select('*');
                $this->db->from('franchise');
                $this->db->where('franchise_id', $post->franchise_id);
                $query44  = $this->db->get();
                $result44 = $query44->row();
                $franchise_name = $result44->franchise_name;

                $nestedData['franchise'] = $franchise_name;

                if ($post->qty == '0') {
                    $nestedData['qty'] = '<span class="badge badge-danger shadow-danger m-1">Out of stock</span>';
                } else {
                    $nestedData['qty'] = $post->qty;
                }

                if ($post->main_image == '') {
                    $nestedData['main_image'] = '<a href="https://via.placeholder.com/1500x1000" data-fancybox="images" data-caption="This image has a caption">
                    							  <img src="https://via.placeholder.com/240x160" alt="lightbox" class="lightbox-thumb img-thumbnail">
                    							</a>';
                } else {
                    $nestedData['main_image'] = '<a href="' . base_url('assets/images/product/' . $post->main_image) . '" data-fancybox="images" data-caption="This image has a caption">
									           <img src="' . base_url('assets/images/product/' . $post->main_image) . '" alt="lightbox" class="lightbox-thumb img-thumbnail" style="width: 80px;">
								            	</a>';
                }


                $this->db->select('*');
                $this->db->from('product_details');
                $this->db->where('product_id', $post->product_id);
                $query444  = $this->db->get();
                $result444 = $query444->row();


                $nestedData['action'] = '';

                $nestedData['action'] = ' <div class="btn-group m-1" role="group">
                                              <button type="button" class="btn btn-dark   waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                              </button>
                                              <div class="dropdown-menu">
                                                <a href="' . base_url('product/update_product?product_id=' . $post->product_id) . '" class="dropdown-item"><i aria-hidden="true" class="fa fa-edit"></i> Edit</a>
                                                
                                                <a style="cursor:pointer;"  class="tip-top dropdown-item delete one_' . $post->product_id . '" data-original-title="Delete" id="' . "'" . $post->product_id . "'" . '"
						                           Onclick="return ConfirmDelete1(' . "'" . $post->product_id . "'" . ')">
                                                  <i aria-hidden="true" class="fa fa-sticky-note"></i> Out of stock
                                               </a>
                                               
                                                <a style="cursor:pointer;"  class="tip-top dropdown-item delete one_' . $post->product_id . '" data-original-title="Delete" id="' . "'" . $post->product_id . "'" . '"
						                           Onclick="return ConfirmDelete(' . "'" . $post->product_id . "'" . ')">
                                                  <i aria-hidden="true" class="fa fa-trash"></i> Delete
                                               </a>
                                              </div>
                                            </div>';

                $data[] = $nestedData;

                $i++;
            }
        }

        $json_data = array(
            "draw"            => intval($this->input->post('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
    }

    public function update_product()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $product_id = $this->input->get('product_id');
            $data['all_category'] = $this->product_model->get_all_category_model();
            $data['product'] = $this->product_model->get_product_detail_id_wise($product_id);
            $data['all_brand'] = $this->product_model->get_all_brand_model();
            $data['all_nibs'] = $this->GlobalModal->executeQuery('select * from lp_nib_master where status=1');
            $data['all_materials'] = $this->GlobalModal->executeQuery('select * from lp_material_master where status=1');
            $data['all_clips'] = $this->GlobalModal->executeQuery('select * from lp_clip_master where status=1');
            $data['all_currencies'] = $this->GlobalModal->executeQuery('select * from lp_currency_master where status=1');
            $data['product_price'] = $this->GlobalModal->executeQuery('select * from lp_product_price where product_id=' . $product_id);
            $data['product_details'] = $this->GlobalModal->executeQuery('select * from product_details where product_id=' . $product_id);
            $this->load->view('common/header');
            $this->load->view('product/update_product', $data);
            $this->load->view('common/footer');
        }
    }


    public function update_product_data()
    {
        $login_type   = $this->session->userdata('type');

        $errors   = array();
        $message  = '';
        $redirect = '';

        $this->form_validation->set_rules('product_name', 'product name', 'required');
        $this->form_validation->set_rules('category_id', 'category name', 'required');
        $this->form_validation->set_rules('unit', 'unit', 'required');
        $this->form_validation->set_rules('product_detail', 'description', 'required');
        $this->form_validation->set_rules('brand_id', 'brand', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $product_name  = $this->input->post('product_name');
        $category_id  = $this->input->post('category_id');
        $sub_category_id = $this->input->post('sub_category_id');
        $sub_subcategory_id = $this->input->post('sub_subcategory_id');
        $brand_id = $this->input->post('brand_id');
        $unit = $this->input->post('unit');
        $description = $this->input->post('product_detail');
        $shipping_cost = $this->input->post('shipping_cost');
        $qty = $this->input->post('qty');
        $type = $this->input->post('type');

        $product_id = $this->input->post('product_id');
        //	echo $aaaa = count($_FILES['thumbnail_image']['name']);die;


        if ($this->form_validation->run() == TRUE) {
            $cnt = count($title = $this->input->post('title'));
            $nib = $this->input->get_post('nib_drp');
            $clip = $this->input->get_post('clip_drp');
            $material = $this->input->get_post('material_drp');
            $tsp = ['dimension', 'nib_material', 'pen_material', 'trim', 'filling_mechanism'];
            $tspArray=[];
            foreach($tsp as $tspData){
                $tspArray[$tspData]=$this->input->get_post($tspData);
            }
            $data_product = array(
                'product_name'      => $product_name,
                'category_id'      => $category_id,
                'sub_category_id'      => $sub_category_id,
                'sub_subcategory_id'      => $sub_subcategory_id,
                'brand_id'      => $brand_id,
                'unit'      => $unit,
                'description'      => $description,
                'shipping_cost'      => $shipping_cost,
                'qty'      => $qty,
                'franchise_id'      => $login_type,
                'type'      => $type,
                'nib' => json_encode($nib),
                'clip' => json_encode($clip),
                'material' => json_encode($material),
                'qty' => 100,
                'technical_specification'=>count($tspArray)>0? json_encode($tspArray):''
            );

            $this->db->where('product_id', $product_id);
            $this->db->update('vegshopy_product', $data_product);

            $files = $_FILES;

            if (!empty($_FILES['main_image']['name'])) {

                $_FILES['main_image']['name'] = $files['main_image']['name'];
                $_FILES['main_image']['type'] = $files['main_image']['type'];
                $_FILES['main_image']['tmp_name'] = $files['main_image']['tmp_name'];
                $_FILES['main_image']['error'] = $files['main_image']['error'];
                $_FILES['main_image']['size'] = $files['main_image']['size'];

                $this->load->library('upload', $this->upload_product_image());

                $this->upload->initialize($this->upload_product_image());

                if (!$this->upload->do_upload('main_image')) {

                    $this->upload->display_errors();
                    $upload_error[] = array('error' => $this->upload->display_errors());
                } else {
                    $upload_data = $this->upload->data();
                    $name_array = $upload_data['file_name'];
                    $insertArray1 = array(
                        'main_image'      => $upload_data['file_name'],

                    );
                    $this->db->where('product_id', $product_id);
                    $this->db->update('vegshopy_product', $insertArray1);
                }
            }

            if (!empty($_FILES['thumbnail_image']['name']) && !empty($_FILES['thumbnail_image']['name'][0])) {

                $cpt = count($_FILES['thumbnail_image']['name']);
                for ($i = 0; $i < $cpt; $i++) {
                    $_FILES['thumbnail_image']['name'] = $files['thumbnail_image']['name'][$i];
                    $_FILES['thumbnail_image']['type'] = $files['thumbnail_image']['type'][$i];
                    $_FILES['thumbnail_image']['tmp_name'] = $files['thumbnail_image']['tmp_name'][$i];
                    $_FILES['thumbnail_image']['error'] = $files['thumbnail_image']['error'][$i];
                    $_FILES['thumbnail_image']['size'] = $files['thumbnail_image']['size'][$i];


                    $this->load->library('upload', $this->upload_product_image1());
                    $this->upload->initialize($this->upload_product_image1());

                    if (!$this->upload->do_upload('thumbnail_image')) {
                        $this->upload->display_errors();
                        $upload_error[] = array('error' => $this->upload->display_errors());
                    } else {

                        $name_array = array();
                        $upload_data = $this->upload->data();
                        $filepath = $upload_data['file_name'];
                        $colorInsertData = array(
                            'product_id'           => $product_id,
                            'title'                => $_POST['title'][$i],
                            'image'           => $filepath,
                        );
                        $this->db->insert('product_details', $colorInsertData);
                    }
                }
            }

            $priceArray = array('euro', 'pound', 'rupee', 'usd');
            $priceTypeArray = array('mrp', 'price', 'discount');
            $deletePrice = $this->GlobalModal->deleteData('lp_product_price', array('product_id' => $product_id));
            foreach ($priceArray as $price) {
                $priceInsertData = array(
                    'product_id'           => $product_id,
                    'currency'                => $price,
                    'mrp'           => $_POST[$price . '_mrp'],
                    'price'             => $_POST[$price . '_price'],
                    'discount'             => $_POST[$price . '_discount'],
                );
                $this->db->insert('lp_product_price', $priceInsertData);
            }

            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Product!</strong> Update successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/product_list');
        } else {
            $status = 'error';
            if (form_error('product_name')) {
                $errors['product_nameError'] = form_error('product_name');
            }

            if (form_error('unit')) {
                $errors['unitError'] = form_error('unit');
            }
            if (form_error('product_detail')) {
                $errors['product_detailError'] = form_error('product_detail');
            }
            if (form_error('qty')) {
                $errors['qtyError'] = form_error('qty');
            }
            if (form_error('category_id')) {
                $errors['category_idError'] = form_error('category_id');
            }
            if (form_error('brand_id')) {
                $errors['brand_idError'] = form_error('brand_id');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }

    /***************************** Delete Product Price  *************************************
     *******************************************************************************************************/
    public function delete_product_price()
    {
        $delete_id     = $this->input->post('delete_id');
        $this->db->where('id', $delete_id);
        $this->db->delete('product_details');
    }


    /****************************** Import Product View Page **************/

    public function import_product()
    {


        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['all_category'] = $this->product_model->get_all_category_model();
            $this->load->view('common/header');
            $this->load->view('product/import_product', $data);
            $this->load->view('common/footer');
        }
    }


    /************************************ (Import Lead) **********************************************************
     ***************************************************************************************************************/

    public function import_product_data()
    {
        $login_type   = $this->session->userdata('type');

        $this->load->library('Excel');

        $errors   = array();
        $message  = '';
        $redirect = '';

        $this->form_validation->set_rules('category_id', 'category name', 'required');
        $this->form_validation->set_rules('sub_category_id', 'sub category', 'required');
        $this->form_validation->set_rules('brand_id', 'brand', 'required');
        $this->form_validation->set_message('required', '* Please select %s');


        $category_id  = $this->input->post('category_id');
        $sub_category_id = $this->input->post('sub_category_id');
        $sub_subcategory_id = $this->input->post('sub_subcategory_id');
        $brand_id = $this->input->post('brand_id');

        if ($this->form_validation->run() == TRUE) {

            if (isset($_FILES["file"]["name"])) {
                $path = $_FILES["file"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 2; $row <= $highestRow; $row++) {
                        $product_name       = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                        $unit               = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                        $qty                = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                        $description        = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                        $title              = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                        $unit_price         = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                        $discount           = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                        $inc_exc            = $worksheet->getCellByColumnAndRow(7, $row)->getValue();


                        $data = array(
                            'product_name'      => $product_name,
                            'category_id'      => $category_id,
                            'sub_category_id'      => $sub_category_id,
                            'sub_subcategory_id'      => $sub_subcategory_id,
                            'brand_id'      => $brand_id,
                            'unit'      => $unit,
                            'description'      => $description,
                            'qty'      => $qty,
                            'shipping_type'      => 'free',
                            'shipping_cost'      => '0',
                            'franchise_id'      => $login_type,

                        );
                    }

                    $this->db->insert_batch('vegshopy_product', $data);
                    //$this->db->insert('vegshopy_product', $data);
                    $insert_id = $this->db->insert_id();
                }




                $status = 'success';
                $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Product!</strong> add successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

                $this->session->set_flashdata('message', $message);
                $redirect = base_url('product/product_list');
            }
        } else {
            $status = 'error';
            if (form_error('category_id')) {
                $errors['category_idError'] = form_error('category_id');
            }
            if (form_error('sub_category_id')) {
                $errors['sub_category_idError'] = form_error('sub_category_id');
            }
            if (form_error('brand_id')) {
                $errors['brand_idError'] = form_error('brand_id');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }



    /********************** Delete Product Data in vegshopy_product Table  **********************
     *********************************************************************************/
    public function delete_product()
    {
        $delete_id = $this->input->post('delete_id');

        $this->db->select('*');
        $this->db->from('vegshopy_product');
        $this->db->where('product_id', $delete_id);
        $query  = $this->db->get();
        $result = $query->row();
        $main_image = $result->main_image;

        unlink('./assets/images/product/' . $main_image);

        $this->db->where('product_id', $delete_id);
        $this->db->delete('vegshopy_product');

        $this->db->where('product_id', $delete_id);
        $this->db->delete('product_details');

        echo $delete_id;
    }


    /****************************** Change Password View Page **************/

    public function change_password()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $this->load->view('common/header');
            $this->load->view('product/change_password');
            $this->load->view('common/footer');
        }
    }

    public function verify_password()
    {
        $login_type   = $this->session->userdata('type');
        $current_pass = $this->input->get('current_pass');
        //print_r($username);die();

        $this->db->select('*');
        $this->db->from('vg_login');
        $this->db->where('password', md5($current_pass));
        $this->db->where('type', $login_type);
        $query  = $this->db->get();
        $num = $query->num_rows();
        if ($num == 0) {
            echo $flag = 1;
            //echo "Username Alredy Exists";
        } else {
            echo $flag = 0;
        }
    }


    /******************************************* Update Password **************************************
     ****************************************************************************************************/

    public function update_password_data()
    {
        $login_type   = $this->session->userdata('type');
        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('current_pass', 'Current password', 'required');
        $this->form_validation->set_rules('new_pass', 'New password', 'required');
        $this->form_validation->set_rules('confirm_pass', 'Confirm password', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $current_pass  = $this->input->post('current_pass');
        $new_pass = $this->input->post('new_pass');
        $confirm_pass  = $this->input->post('confirm_pass');

        if ($this->form_validation->run() == TRUE) {
            $update_data = array(
                'password'  => md5($new_pass),

            );

            $this->db->where('type', $login_type)->update('vg_login', $update_data);

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


            $this->session->set_flashdata('message', $message);
            $redirect = base_url('dashboard');
        } else {
            $status = 'error';
            if (form_error('current_pass')) {
                $errors['current_passError'] = form_error('current_pass');
            }

            if (form_error('new_pass')) {
                $errors['new_passError'] = form_error('new_pass');
            }

            if (form_error('confirm_pass')) {
                $errors['confirm_passError'] = form_error('confirm_pass');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }


    /***************************** Out of stock  *************************************
     *******************************************************************************************************/
    public function out_of_stock()
    {
        $delete_id     = $this->input->post('delete_id');


        $update_data = array(
            'qty'  => '0',

        );

        $this->db->where('product_id', $delete_id)->update('vegshopy_product', $update_data);

        echo $delete_id;
    }


    /****************************** Coupon View Page **************/

    public function coupon()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['all_coupon'] = $this->product_model->get_all_coupon1_model();
            $this->load->view('common/header');
            $this->load->view('product/coupon', $data);
            $this->load->view('common/footer');
        }
    }


    public function add_coupon_data()
    {
        $login_type   = $this->session->userdata('type');

        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('flag', 'type', 'required');
        $this->form_validation->set_rules('coupon_name', 'coupon name', 'required');
        $this->form_validation->set_rules('validity', 'validity', 'required');
        $this->form_validation->set_rules('from_validity', 'from validity', 'required');
        $this->form_validation->set_rules('value', 'value', 'required');
        $this->form_validation->set_rules('capping_value', 'capping value', 'required');
        $this->form_validation->set_rules('description', 'description', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $coupon_name  = $this->input->post('coupon_name');
        $validity  = date("Y-m-d", strtotime($this->input->post('validity')));
        $from_validity  = date("Y-m-d", strtotime($this->input->post('from_validity')));
        $value_amt  = $this->input->post('value');
        $capping_value  = $this->input->post('capping_value');
        $description  = $this->input->post('description');
        $flag  = $this->input->post('flag');

        if ($this->form_validation->run() == TRUE) {
            $data_coupon = array(
                'coupon_name'      => $coupon_name,
                'validity'         => $validity,
                'from_validity'         => $from_validity,
                'value'            => $value_amt,
                'capping_value'    => $capping_value,
                'description'      => $description,
                'flag'      => $flag,
                'franchise_id'      => $login_type,

            );

            $this->db->insert('coupon', $data_coupon);



            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Coupon!</strong> add successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/coupon');
        } else {
            $status = 'error';
            if (form_error('coupon_name')) {
                $errors['coupon_nameError'] = form_error('coupon_name');
            }
            if (form_error('validity')) {
                $errors['validityError'] = form_error('validity');
            }
            if (form_error('value')) {
                $errors['valueError'] = form_error('value');
            }
            if (form_error('capping_value')) {
                $errors['capping_valueError'] = form_error('capping_value');
            }
            if (form_error('description')) {
                $errors['descriptionError'] = form_error('description');
            }
            if (form_error('from_validity')) {
                $errors['from_validityError'] = form_error('from_validity');
            }
            if (form_error('flag')) {
                $errors['flagError'] = form_error('flag');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }


    public function update_coupon_data()
    {
        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('coupon_name', 'coupon name', 'required');
        $this->form_validation->set_rules('flag', 'type', 'required');
        $this->form_validation->set_rules('validity', 'validity', 'required');
        $this->form_validation->set_rules('from_validity', 'from validity', 'required');
        $this->form_validation->set_rules('value', 'value', 'required');
        $this->form_validation->set_rules('capping_value', 'capping value', 'required');
        $this->form_validation->set_rules('description', 'description', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $coupon_name  = $this->input->post('coupon_name');
        $validity  = date("Y-m-d", strtotime($this->input->post('validity')));
        $from_validity  = date("Y-m-d", strtotime($this->input->post('from_validity')));
        $value_amt  = $this->input->post('value');
        $capping_value  = $this->input->post('capping_value');
        $description  = $this->input->post('description');
        $flag  = $this->input->post('flag');

        $edit_id  = $this->input->post('coupon_id');

        if ($this->form_validation->run() == TRUE) {
            $update_coupo = array(
                'coupon_name'      => $coupon_name,
                'validity'         => $validity,
                'value'            => $value_amt,
                'capping_value'    => $capping_value,
                'description'      => $description,
                'from_validity'      => $from_validity,
                'flag'      => $flag,

            );

            $this->db->where('coupon_id', $edit_id)->update('coupon', $update_coupo);



            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Coupon!</strong> update successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/coupon');
        } else {
            $status = 'error';
            if (form_error('coupon_name')) {
                $errors['coupon_nameError'] = form_error('coupon_name');
            }
            if (form_error('validity')) {
                $errors['validityError'] = form_error('validity');
            }
            if (form_error('value')) {
                $errors['valueError'] = form_error('value');
            }
            if (form_error('capping_value')) {
                $errors['capping_valueError'] = form_error('capping_value');
            }
            if (form_error('description')) {
                $errors['descriptionError'] = form_error('description');
            }
            if (form_error('from_validity')) {
                $errors['from_validityError'] = form_error('from_validity');
            }

            if (form_error('flag')) {
                $errors['flagError'] = form_error('flag');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }



    /********************** Delete COupon Data in coupon Table  **********************
     *****************************************************************************************************/
    public function delete_coupon()
    {
        $delete_id = $this->input->post('delete_id');



        $this->db->where('coupon_id', $delete_id);
        $this->db->delete('coupon');
        echo $delete_id;
    }


    public function update_banner_data()
    {
        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('position', 'position', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $position  = $this->input->post('position');
        $edit_id  = $this->input->post('banner_id');

        if ($this->form_validation->run() == TRUE) {
            $update_banner = array(
                'position'      => $position,
            );

            $this->db->where('banner_id', $edit_id)->update('banner', $update_banner);


            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Position!</strong> update successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/banner');
        } else {
            $status = 'error';
            if (form_error('position')) {
                $errors['positionError'] = form_error('position');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }


    /********************** Disbale Category  **********************
     *********************************************************************************/
    public function disable_category()
    {
        $delete_id = $this->input->post('delete_id');

        $update_data = array(

            'isActive'      => '1',

        );

        $this->db->where('category_id', $delete_id)->update('category', $update_data);
        echo $delete_id;
    }


    /********************** Disbale Category  **********************
     *********************************************************************************/
    public function enable_category()
    {
        $delete_id = $this->input->post('delete_id');

        $update_data = array(

            'isActive'      => '0',

        );

        $this->db->where('category_id', $delete_id)->update('category', $update_data);
        echo $delete_id;
    }


    /********************** Delete timeslot Data in slot_timing Table  **********************
     **********************************************************************************************/
    public function delete_timeslot()
    {
        $delete_id = $this->input->post('delete_id');


        $this->db->where('slot_id', $delete_id);
        $this->db->delete('slot_timing');
        echo $delete_id;
    }



    /****************************** Set min limit View Page **************/

    public function set_min_limit()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['set_min_limit'] = $this->product_model->get_min_amount();
            $this->load->view('common/header');
            $this->load->view('product/set_min_limit', $data);
            $this->load->view('common/footer');
        }
    }


    public function update_minimu_limit_data()
    {
        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('min_limit', 'min limit', 'required');
        $this->form_validation->set_rules('subscribe_min_limit', 'subscribe min limit', 'required');
        $this->form_validation->set_rules('wallet_use_min_limit', 'wallet use min limit', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $min_limit  = $this->input->post('min_limit');
        $subscribe_min_limit  = $this->input->post('subscribe_min_limit');
        $wallet_use_min_limit  = $this->input->post('wallet_use_min_limit');
        $edit_id  = $this->input->post('id');

        if ($this->form_validation->run() == TRUE) {
            $update_data = array(
                'min_limit'      => $min_limit,
                'subscribe_min_limit'      => $subscribe_min_limit,
                'wallet_use_min_limit'      => $wallet_use_min_limit,

            );

            $this->db->where('id', $edit_id)->update('min_limit', $update_data);


            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Limit set!</strong>  successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/set_min_limit');
        } else {
            $status = 'error';
            if (form_error('min_limit')) {
                $errors['min_limitError'] = form_error('min_limit');
            }
            if (form_error('subscribe_min_limit')) {
                $errors['subscribe_min_limitError'] = form_error('subscribe_min_limit');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }


    /********************** Disbale COupon  **********************
     *********************************************************************************/
    public function disable_coupon()
    {
        $delete_id = $this->input->post('delete_id');

        $update_data = array(

            'isActive'      => '1',

        );

        $this->db->where('coupon_id', $delete_id)->update('coupon', $update_data);
        echo $delete_id;
    }


    /********************** Disbale COupon  **********************
     *********************************************************************************/
    public function enable_coupon()
    {
        $delete_id = $this->input->post('delete_id');

        $update_data = array(

            'isActive'      => '0',

        );

        $this->db->where('coupon_id', $delete_id)->update('coupon', $update_data);
        echo $delete_id;
    }


    /****************************** Out of stock **************/

    public function out_of_stock_product()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $this->load->view('common/header');
            $this->load->view('product/out_of_stock');
            $this->load->view('common/footer');
        }
    }

    //////////////////////////////// Product Export in Excel  ///////////////////////////////////////////////////// 

    public function download_product_excel()
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
        );


        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:C1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Product List');

        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($top_header_style);

        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'product_id');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'product_name');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'qty');




        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);


        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);




        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

        $row = 3;
        $product_list  = $this->product_model->get_product_data();
        // echo "<pre>";print_r($order_list);exit;
        if (is_array($product_list) || is_object($product_list)) {
            foreach ($product_list as $value) {



                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $value->product_id);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value->product_name);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value->qty);

                $row++;
            }
        }
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="stock_list.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }



    /************************************ (Import Lead) **********************************************************
     ***************************************************************************************************************/

    public function import_out_of_stock_data()
    {
        $this->load->library('Excel');

        $errors   = array();
        $message  = '';
        $redirect = '';



        if (isset($_FILES["file"]["name"])) {
            $path = $_FILES["file"]["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);
            foreach ($object->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                //print_r($highestColumn);exit;
                for ($row = 3; $row <= $highestRow; $row++) {
                    $product_id       = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $product_name     = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $qty              = $worksheet->getCellByColumnAndRow(2, $row)->getValue();



                    $data11 = array(
                        'qty'      => $qty,
                    );

                    $this->db->where('product_id', $product_id)->update('vegshopy_product', $data11);
                }
            }




            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Product!</strong> qty updated successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/product_list');
        }



        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }



    /****************************** Price updated **************/

    public function bulk_price_product()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $this->load->view('common/header');
            $this->load->view('product/bulk_price_product');
            $this->load->view('common/footer');
        }
    }


    //////////////////////////////// Product Price Export in Excel  ///////////////////////////////////////////////////// 

    public function download_product_price_excel()
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
        );


        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:F1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Product Price List');

        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($top_header_style);

        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'id');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'Product name');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'Title');
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'Unit price');
        $objPHPExcel->getActiveSheet()->setCellValue('E2', 'Discount %');
        $objPHPExcel->getActiveSheet()->setCellValue('F2', 'Purchse Pice');




        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($style_header);


        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);




        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

        $row = 3;
        $product_list  = $this->product_model->get_product_price_data();
        // echo "<pre>";print_r($order_list);exit;
        if (is_array($product_list) || is_object($product_list)) {
            foreach ($product_list as $value) {

                $this->db->select('*');
                $this->db->from('vegshopy_product');
                $this->db->where('product_id', $value->product_id);
                $query  = $this->db->get();
                $rowcount = $query->num_rows();
                if ($rowcount == 0) {
                    $product_name = '';
                } else {
                    $result = $query->row();
                    $product_name = $result->product_name;
                }



                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $value->id);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $product_name);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value->title);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value->unit_price);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $value->discount);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $value->purchse_price);

                $row++;
            }
        }
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="product_price.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }



    /************************************ (Import Lead) **********************************************************
     ***************************************************************************************************************/

    public function import_product_price_data()
    {
        $this->load->library('Excel');

        $errors   = array();
        $message  = '';
        $redirect = '';



        if (isset($_FILES["file"]["name"])) {
            $path = $_FILES["file"]["tmp_name"];
            $object = PHPExcel_IOFactory::load($path);
            foreach ($object->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                //print_r($highestColumn);exit;
                for ($row = 3; $row <= $highestRow; $row++) {
                    $id              = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $product_name    = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $title           = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $unit_price      = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $discount        = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $purchse_price   = $worksheet->getCellByColumnAndRow(5, $row)->getValue();



                    $data11 = array(
                        'title'        => $title,
                        'unit_price'   => $unit_price,
                        'discount'     => $discount,
                        'purchse_price'     => $purchse_price,
                    );

                    $this->db->where('id', $id)->update('product_details', $data11);
                }
            }




            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Product!</strong> price updated successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/product_list');
        }



        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }



    /****************************** Franchise View Page **************/

    public function franchise()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['all_franchise'] = $this->product_model->get_all_franchise_model();
            $this->load->view('common/header');
            $this->load->view('product/franchise', $data);
            $this->load->view('common/footer');
        }
    }


    /********************** Disbale franchise  **********************
     *********************************************************************************/
    public function deactive_franchise()
    {
        $delete_id = $this->input->post('delete_id');

        $update_data = array(

            'isActive'      => '1',

        );

        $this->db->where('franchise_id', $delete_id)->update('franchise', $update_data);
        $update_data1 = array(

            'flag'      => '1',

        );

        $this->db->where('type', $delete_id)->update('vg_login', $update_data1);
        echo $delete_id;
    }


    /********************** Disbale franchise  **********************
     *********************************************************************************/
    public function active_franchise()
    {
        $delete_id = $this->input->post('delete_id');

        $update_data = array(

            'isActive'      => '0',

        );

        $this->db->where('franchise_id', $delete_id)->update('franchise', $update_data);
        $update_data1 = array(

            'flag'      => '0',

        );

        $this->db->where('type', $delete_id)->update('vg_login', $update_data1);
        echo $delete_id;
    }



    /****************************** Franchise Add Page **************/

    public function add_franchise()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['all_state'] = $this->product_model->get_all_state_model();
            $this->load->view('common/header');
            $this->load->view('product/add_franchise', $data);
            $this->load->view('common/footer');
        }
    }


    public function add_franchise_data()
    {
        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('franchise_name', 'Name', 'required');
        $this->form_validation->set_rules('mobile_no', 'mobile no', 'required');
        $this->form_validation->set_rules('email_id', 'Email id', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('address', 'address', 'required');
        $this->form_validation->set_rules('state', 'state', 'required');
        $this->form_validation->set_rules('city', 'city', 'required');

        $this->form_validation->set_message('required', '* Please add %s');

        $franchise_name       = $this->input->post('franchise_name');
        $mobile_no            = $this->input->post('mobile_no');
        $email_id             = $this->input->post('email_id');
        $username             = $this->input->post('username');
        $password             = $this->input->post('password');
        $address              = $this->input->post('address');
        $state                = $this->input->post('state');
        $city                 = $this->input->post('city');






        if ($this->form_validation->run() == TRUE) {
            $data_franchise = array(
                'franchise_name'     => $franchise_name,
                'email_id'           => $email_id,
                'mobile_no'          => $mobile_no,
                'username'           => $username,
                'password'           => md5($password),
                'state'              => $state,
                'city  '             => $city,
                'address'            => $address,
            );

            $this->db->insert('franchise', $data_franchise);

            $insert_id = $this->db->insert_id();

            $data_login = array(
                'company_name'      => $franchise_name,
                'company_phone'     => $mobile_no,
                'company_email'     => $email_id,
                'company_address'   => $address,
                'username'          => $username,
                'password'          => md5($password),
                'type'              => $insert_id,
            );

            $this->db->insert('vg_login', $data_login);



            $data_min = array(
                'franchise_id'        => $insert_id,
                'min_limit'       => '0',
                'subscribe_min_limit'       => '0',



            );
            $this->db->insert('min_limit', $data_min);

            $data_min1 = array(
                'franchise_id'        => $insert_id,
                'order_limit'       => '100',
            );
            $this->db->insert('order_limit', $data_min1);



            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Franchise!</strong> add successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/franchise');
        } else {
            $status = 'error';

            if (form_error('franchise_name')) {
                $errors['franchise_nameError'] = form_error('franchise_name');
            }

            if (form_error('mobile_no')) {
                $errors['mobile_noError'] = form_error('mobile_no');
            }
            if (form_error('email_id')) {
                $errors['email_idError'] = form_error('email_id');
            }

            if (form_error('username')) {
                $errors['usernameError'] = form_error('username');
            }
            if (form_error('password')) {
                $errors['passwordError'] = form_error('password');
            }

            if (form_error('address')) {
                $errors['addressError'] = form_error('address');
            }

            if (form_error('state')) {
                $errors['stateError'] = form_error('state');
            }

            if (form_error('city')) {
                $errors['cityError'] = form_error('city');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }



    /****************************** Franchise Edit Page **************/

    public function edit_franchise()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $franchise_id     = $this->input->get('franchise_id');
            $data['franchise'] = $this->product_model->get_franchise_deatils($franchise_id);
            $data['all_state'] = $this->product_model->get_all_state_model();
            $this->load->view('common/header');
            $this->load->view('product/edit_franchise', $data);
            $this->load->view('common/footer');
        }
    }




    public function update_franchise_data()
    {
        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('franchise_name', 'Name', 'required');
        $this->form_validation->set_rules('mobile_no', 'mobile no', 'required');
        $this->form_validation->set_rules('email_id', 'Email id', 'required');
        $this->form_validation->set_rules('address', 'address', 'required');
        $this->form_validation->set_rules('state', 'state', 'required');
        $this->form_validation->set_rules('city', 'city', 'required');

        $this->form_validation->set_message('required', '* Please add %s');

        $franchise_name       = $this->input->post('franchise_name');
        $mobile_no            = $this->input->post('mobile_no');
        $email_id             = $this->input->post('email_id');
        $address              = $this->input->post('address');
        $state                = $this->input->post('state');
        $city                 = $this->input->post('city');

        $edit_id                 = $this->input->post('franchise_id');






        if ($this->form_validation->run() == TRUE) {
            $update_data = array(
                'franchise_name'     => $franchise_name,
                'email_id'           => $email_id,
                'mobile_no'          => $mobile_no,
                'state'              => $state,
                'city  '             => $city,
                'address'            => $address,
            );
            $this->db->where('franchise_id', $edit_id)->update('franchise', $update_data);

            $data_login = array(
                'company_name'      => $franchise_name,
                'company_phone'     => $mobile_no,
                'company_email'     => $email_id,
                'company_address'   => $address,
            );

            $this->db->where('type', $edit_id)->update('vg_login', $data_login);




            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Franchise!</strong> update successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/franchise');
        } else {
            $status = 'error';

            if (form_error('franchise_name')) {
                $errors['franchise_nameError'] = form_error('franchise_name');
            }

            if (form_error('mobile_no')) {
                $errors['mobile_noError'] = form_error('mobile_no');
            }
            if (form_error('email_id')) {
                $errors['email_idError'] = form_error('email_id');
            }



            if (form_error('address')) {
                $errors['addressError'] = form_error('address');
            }

            if (form_error('state')) {
                $errors['stateError'] = form_error('state');
            }

            if (form_error('city')) {
                $errors['cityError'] = form_error('city');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }



    public function all_cities_by_state_id()
    {
        $state_id = $this->input->post('id');
        $data     = $this->product_model->get_all_cities_by_state_id($state_id);
        echo json_encode($data);
    }




    /****************************** Set Order limit View Page **************/

    public function order_limit()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['order_limit'] = $this->product_model->get_order_limit();
            $this->load->view('common/header');
            $this->load->view('product/order_limit', $data);
            $this->load->view('common/footer');
        }
    }




    /****************************** Area View Page **************/

    public function area()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['all_zone'] = $this->product_model->get_all_zone_model();
            $data['all_area'] = $this->product_model->get_all_area_model();
            $this->load->view('common/header');
            $this->load->view('product/area', $data);
            $this->load->view('common/footer');
        }
    }



    public function add_area_data()
    {
        $login_type   = $this->session->userdata('type');

        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('area_name', 'area name', 'required');
        $this->form_validation->set_rules('zone_id', 'zone', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $area_name  = $this->input->post('area_name');
        $zone_id  = $this->input->post('zone_id');

        if ($this->form_validation->run() == TRUE) {
            $data_category = array(
                'area_name'      => $area_name,
                'zone_id'      => $zone_id,
                'franchise_id'      => $login_type,

            );

            $this->db->insert('area', $data_category);


            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Area!</strong> add successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/area');
        } else {
            $status = 'error';
            if (form_error('area_name')) {
                $errors['area_nameError'] = form_error('area_name');
            }
            if (form_error('zone_id')) {
                $errors['zone_idError'] = form_error('zone_id');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }




    public function update_area_data()
    {
        $login_type   = $this->session->userdata('type');

        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('area_name', 'area name', 'required');
        $this->form_validation->set_rules('zone_id', 'zone', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $area_name  = $this->input->post('area_name');
        $zone_id  = $this->input->post('zone_id');
        $area_id  = $this->input->post('area_id');

        if ($this->form_validation->run() == TRUE) {
            $update_data = array(
                'area_name'      => $area_name,
                'zone_id'      => $zone_id,

            );

            $this->db->where('area_id', $area_id)->update('area', $update_data);



            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Area!</strong> update successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/area');
        } else {
            $status = 'error';
            if (form_error('area_name')) {
                $errors['area_nameError'] = form_error('area_name');
            }
            if (form_error('zone_id')) {
                $errors['zone_idError'] = form_error('zone_id');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }


    /********************** Delete Area Data in area Table  **********************
     *********************************************************************************/
    public function delete_area()
    {
        $delete_id = $this->input->post('delete_id');


        $this->db->where('area_id', $delete_id);
        $this->db->delete('area');
        echo $delete_id;
    }




    /********************** Disbale Area  **********************
     *********************************************************************************/
    public function disable_area()
    {
        $delete_id = $this->input->post('delete_id');

        $update_data = array(

            'isActive'      => '1',

        );

        $this->db->where('area_id', $delete_id)->update('area', $update_data);
        echo $delete_id;
    }


    /********************** Disbale Area  **********************
     *********************************************************************************/
    public function enable_area()
    {
        $delete_id = $this->input->post('delete_id');

        $update_data = array(

            'isActive'      => '0',

        );

        $this->db->where('area_id', $delete_id)->update('area', $update_data);
        echo $delete_id;
    }



    public function update_order_limit_data()
    {
        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('order_limit', 'order limit', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $order_limit  = $this->input->post('order_limit');
        $edit_id  = $this->input->post('id');

        if ($this->form_validation->run() == TRUE) {
            $update_data = array(
                'order_limit'      => $order_limit,

            );

            $this->db->where('id', $edit_id)->update('order_limit', $update_data);


            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Limit set!</strong>  successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/order_limit');
        } else {
            $status = 'error';
            if (form_error('order_limit')) {
                $errors['order_limitError'] = form_error('order_limit');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }



    /****************************** Customer sms View Page **************/

    public function customer_sms()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['all_customer'] = $this->customer_model->get_customer_model();
            $this->load->view('common/header');
            $this->load->view('product/customer_sms', $data);
            $this->load->view('common/footer');
        }
    }



    public function add_sms_customer_data()
    {
        $login_type   = $this->session->userdata('type');

        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('sms', 'message', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $sms  = $this->input->post('sms');

        if ($this->form_validation->run() == TRUE) {


            $CI = &get_instance();
            $CI->load->model('Customer_model');
            $result = $CI->Customer_model->get_customer_login_wise($login_type);

            //print_r($result);die;

            foreach ($result as $p_details) {

                $mobile_no = $p_details->mobile_no;
                $sender = "EXOTIC";
                $number2 = $mobile_no;
                $msg2 = $sms;

                $api_key = '55A827A192C7C6';
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://www.logonutility.in/app/smsapi/index.php");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, "key=" . $api_key . "&&campaign=1&routeid=20&type=text&contacts=" . $number2 . "&senderid=" . $sender . "&msg=" . $msg2);
                $response = curl_exec($ch);

                curl_close($ch);
            }
            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Message!</strong> send successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/customer_sms');
        } else {
            $status = 'error';
            if (form_error('sms')) {
                $errors['smsError'] = form_error('sms');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }



    public function add_sms_customer_data1()
    {
        $login_type   = $this->session->userdata('type');

        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('sms1', 'message', 'required');
        $this->form_validation->set_rules('mobile_no', 'customer', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $sms  = $this->input->post('sms1');
        $mobile_no  = $this->input->post('mobile_no');

        if ($this->form_validation->run() == TRUE) {

            $sender = "EXOTIC";
            $number2 = $mobile_no;
            $msg2 = $sms;

            $api_key = '55A827A192C7C6';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://www.logonutility.in/app/smsapi/index.php");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "key=" . $api_key . "&&campaign=1&routeid=20&type=text&contacts=" . $number2 . "&senderid=" . $sender . "&msg=" . $msg2);
            $response = curl_exec($ch);

            curl_close($ch);


            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Message!</strong> send successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/customer_sms');
        } else {
            $status = 'error';
            if (form_error('sms1')) {
                $errors['sms1Error'] = form_error('sms1');
            }
            if (form_error('mobile_no')) {
                $errors['mobile_noError'] = form_error('mobile_no');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }

    public function db_sms()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $this->load->view('common/header');
            $this->load->view('product/db_sms');
            $this->load->view('common/footer');
        }
    }




    public function add_sms_db_data()
    {
        $login_type   = $this->session->userdata('type');

        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('sms', 'message', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $sms  = $this->input->post('sms');

        if ($this->form_validation->run() == TRUE) {


            $CI = &get_instance();
            $CI->load->model('Customer_model');
            $result = $CI->Customer_model->get_db_login_wise($login_type);

            foreach ($result as $p_details) {

                $mobile_no = $p_details->mobile_no;
                $sender = "EXOTIC";
                $number2 = $mobile_no;
                $msg2 = $sms;

                $api_key = '55A827A192C7C6';
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "https://www.logonutility.in/app/smsapi/index.php");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, "key=" . $api_key . "&&campaign=1&routeid=20&type=text&contacts=" . $number2 . "&senderid=" . $sender . "&msg=" . $msg2);
                $response = curl_exec($ch);

                curl_close($ch);
            }
            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Message!</strong> send successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/db_sms');
        } else {
            $status = 'error';
            if (form_error('sms')) {
                $errors['smsError'] = form_error('sms');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }



    /****************************** Zone View Page **************/

    public function zone()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['all_zone'] = $this->product_model->get_all_zone_model();
            $this->load->view('common/header');
            $this->load->view('product/zone', $data);
            $this->load->view('common/footer');
        }
    }



    public function add_zone_data()
    {
        $login_type   = $this->session->userdata('type');

        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('zone_name', 'zone name', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $zone_name  = $this->input->post('zone_name');

        if ($this->form_validation->run() == TRUE) {
            $data_category = array(
                'zone_name'      => $zone_name,
                'franchise_id'      => $login_type,

            );

            $this->db->insert('zone', $data_category);


            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Zone!</strong> add successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/zone');
        } else {
            $status = 'error';
            if (form_error('zone_name')) {
                $errors['zone_nameError'] = form_error('zone_name');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }




    public function update_zone_data()
    {
        $login_type   = $this->session->userdata('type');

        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('zone_name', 'zone name', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $zone_name  = $this->input->post('zone_name');
        $zone_id  = $this->input->post('zone_id');

        if ($this->form_validation->run() == TRUE) {
            $update_data = array(
                'zone_name'      => $zone_name,

            );

            $this->db->where('zone_id', $zone_id)->update('zone', $update_data);



            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Zone!</strong> update successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/zone');
        } else {
            $status = 'error';
            if (form_error('zone_name')) {
                $errors['zone_nameError'] = form_error('zone_name');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }



    /********************** Delete zone Data in zone Table  **********************
     *********************************************************************************/
    public function delete_zone()
    {
        $delete_id = $this->input->post('delete_id');


        $this->db->where('zone_id', $delete_id);
        $this->db->delete('zone');
        echo $delete_id;
    }


    public function all_area_by_zone_id()
    {
        $zone_id = $this->input->post('id');
        $data     = $this->product_model->get_all_area_by_zone_id($zone_id);
        echo json_encode($data);
    }



    /****************************** Designation View Page **************/

    public function designation()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['all_designation'] = $this->product_model->get_all_designation_model();
            $this->load->view('common/header');
            $this->load->view('product/designation', $data);
            $this->load->view('common/footer');
        }
    }




    public function add_designation_data()
    {
        $login_type   = $this->session->userdata('type');

        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('designation', 'designation', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $designation  = $this->input->post('designation');

        if ($this->form_validation->run() == TRUE) {
            $data_designation = array(
                'designation'      => $designation,
                'franchise_id'      => $login_type,

            );

            $this->db->insert('designation', $data_designation);


            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Designation!</strong> add successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/designation');
        } else {
            $status = 'error';
            if (form_error('designation')) {
                $errors['designationError'] = form_error('designation');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }




    public function update_designation_data()
    {
        $login_type   = $this->session->userdata('type');

        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('designation', 'designation', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $designation  = $this->input->post('designation');
        $designation_id  = $this->input->post('designation_id');

        if ($this->form_validation->run() == TRUE) {
            $update_data = array(
                'designation'      => $designation,

            );

            $this->db->where('designation_id', $designation_id)->update('designation', $update_data);



            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Designation!</strong> update successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/designation');
        } else {
            $status = 'error';
            if (form_error('designation')) {
                $errors['designationError'] = form_error('designation');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }



    /********************** Delete designation Data in designation Table  **********************
     *********************************************************************************/
    public function delete_designation()
    {
        $delete_id = $this->input->post('delete_id');


        $this->db->where('designation_id', $delete_id);
        $this->db->delete('designation');
        echo $delete_id;
    }



    /****************************** employee View Page **************/

    public function employee()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['all_employee'] = $this->product_model->get_all_employee_model();
            $this->load->view('common/header');
            $this->load->view('product/employee', $data);
            $this->load->view('common/footer');
        }
    }



    /****************************** add employee View Page **************/

    public function add_employee()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['all_designation'] = $this->product_model->get_all_designation_model();
            $this->load->view('common/header');
            $this->load->view('product/add_employee', $data);
            $this->load->view('common/footer');
        }
    }



    public function verify_emp_mobile()
    {

        $mobile_no = $this->input->get('mobile_no');
        //print_r($username);die();

        $this->db->select('*');
        $this->db->from('vg_login');
        $this->db->where('company_phone', $mobile_no);
        $this->db->where('flag', '0');
        $query  = $this->db->get();
        $num = $query->num_rows();
        if ($num > 0) {
            echo $flag = 1;
            //echo "Username Alredy Exists";
        } else {
            echo $flag = 0;
        }
    }


    public function verify_emp_username()
    {

        $username = $this->input->get('username');
        //print_r($username);die();

        $this->db->select('*');
        $this->db->from('vg_login');
        $this->db->where('username', $username);
        $this->db->where('flag', '0');
        $query  = $this->db->get();
        $num = $query->num_rows();
        if ($num > 0) {
            echo $flag = 1;
            //echo "Username Alredy Exists";
        } else {
            echo $flag = 0;
        }
    }



    public function add_employee_data()
    {
        $login_type   = $this->session->userdata('type');

        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('name', 'name', 'required');
        $this->form_validation->set_rules('mobile_no', 'mobile_no', 'required');
        $this->form_validation->set_rules('address', 'address', 'required');
        $this->form_validation->set_rules('designation_id', 'designation', 'required');
        $this->form_validation->set_rules('username', 'username', 'required');
        $this->form_validation->set_rules('password', 'password', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $name       = $this->input->post('name');
        $mobile_no  = $this->input->post('mobile_no');
        $address  = $this->input->post('address');
        $designation_id  = $this->input->post('designation_id');
        $email_id  = $this->input->post('email_id');
        $username  = $this->input->post('username');
        $password  = $this->input->post('password');


        $d_master             = $this->input->post('d_master');
        if ($this->input->post('d_master') != "") {
            $d_master = 'Y';
        } else {
            $d_master = 'N';
        }
        $e_master             = $this->input->post('e_master');
        if ($this->input->post('e_master') != "") {
            $e_master = 'Y';
        } else {
            $e_master = 'N';
        }
        $z_master             = $this->input->post('z_master');
        if ($this->input->post('z_master') != "") {
            $z_master = 'Y';
        } else {
            $z_master = 'N';
        }
        $a_master             = $this->input->post('a_master');
        if ($this->input->post('a_master') != "") {
            $a_master = 'Y';
        } else {
            $a_master = 'N';
        }
        $banner               = $this->input->post('banner');
        if ($this->input->post('banner') != "") {
            $banner = 'Y';
        } else {
            $banner = 'N';
        }
        $brand                = $this->input->post('brand');
        if ($this->input->post('brand') != "") {
            $brand = 'Y';
        } else {
            $brand = 'N';
        }
        $category             = $this->input->post('category');
        if ($this->input->post('category') != "") {
            $category = 'Y';
        } else {
            $category = 'N';
        }
        $subcategory          = $this->input->post('subcategory');
        if ($this->input->post('subcategory') != "") {
            $subcategory = 'Y';
        } else {
            $subcategory = 'N';
        }
        $sub_subcategory      = $this->input->post('sub_subcategory');
        if ($this->input->post('sub_subcategory') != "") {
            $sub_subcategory = 'Y';
        } else {
            $sub_subcategory = 'N';
        }
        $slot                 = $this->input->post('slot');
        if ($this->input->post('slot') != "") {
            $slot = 'Y';
        } else {
            $slot = 'N';
        }
        $pickup               = $this->input->post('pickup');
        if ($this->input->post('pickup') != "") {
            $pickup = 'Y';
        } else {
            $pickup = 'N';
        }
        $pincode              = $this->input->post('pincode');
        if ($this->input->post('pincode') != "") {
            $pincode = 'Y';
        } else {
            $pincode = 'N';
        }
        $coupon               = $this->input->post('coupon');
        if ($this->input->post('coupon') != "") {
            $coupon = 'Y';
        } else {
            $coupon = 'N';
        }
        $minlimit             = $this->input->post('minlimit');
        if ($this->input->post('minlimit') != "") {
            $minlimit = 'Y';
        } else {
            $minlimit = 'N';
        }
        $olimit               = $this->input->post('olimit');
        if ($this->input->post('olimit') != "") {
            $olimit = 'Y';
        } else {
            $olimit = 'N';
        }
        $u_product            = $this->input->post('u_product');
        if ($this->input->post('u_product') != "") {
            $u_product = 'Y';
        } else {
            $u_product = 'N';
        }
        $l_product            = $this->input->post('l_product');
        if ($this->input->post('l_product') != "") {
            $l_product = 'Y';
        } else {
            $l_product = 'N';
        }
        $stock_update         = $this->input->post('stock_update');
        if ($this->input->post('stock_update') != "") {
            $stock_update = 'Y';
        } else {
            $stock_update = 'N';
        }
        $price_update         = $this->input->post('price_update');
        if ($this->input->post('price_update') != "") {
            $price_update = 'Y';
        } else {
            $price_update = 'N';
        }
        $manually             = $this->input->post('manually');
        if ($this->input->post('manually') != "") {
            $manually = 'Y';
        } else {
            $manually = 'N';
        }
        $t_order              = $this->input->post('t_order');
        if ($this->input->post('t_order') != "") {
            $t_order = 'Y';
        } else {
            $t_order = 'N';
        }
        $to_order             = $this->input->post('to_order');
        if ($this->input->post('to_order') != "") {
            $to_order = 'Y';
        } else {
            $to_order = 'N';
        }
        $p_order              = $this->input->post('p_order');
        if ($this->input->post('p_order') != "") {
            $p_order = 'Y';
        } else {
            $p_order = 'N';
        }
        $i_order              = $this->input->post('i_order');
        if ($this->input->post('i_order') != "") {
            $i_order = 'Y';
        } else {
            $i_order = 'N';
        }
        $a_order              = $this->input->post('a_order');
        if ($this->input->post('a_order') != "") {
            $a_order = 'Y';
        } else {
            $a_order = 'N';
        }
        $a_n_order            = $this->input->post('a_n_order');
        if ($this->input->post('a_n_order') != "") {
            $a_n_order = 'Y';
        } else {
            $a_n_order = 'N';
        }
        $dis_order            = $this->input->post('dis_order');
        if ($this->input->post('dis_order') != "") {
            $dis_order = 'Y';
        } else {
            $dis_order = 'N';
        }
        $d_order              = $this->input->post('d_order');
        if ($this->input->post('d_order') != "") {
            $d_order = 'Y';
        } else {
            $d_order = 'N';
        }
        $c_order              = $this->input->post('c_order');
        if ($this->input->post('c_order') != "") {
            $c_order = 'Y';
        } else {
            $c_order = 'N';
        }
        $cc_order             = $this->input->post('cc_order');
        if ($this->input->post('cc_order') != "") {
            $cc_order = 'Y';
        } else {
            $cc_order = 'N';
        }
        $r_order              = $this->input->post('r_order');
        if ($this->input->post('r_order') != "") {
            $r_order = 'Y';
        } else {
            $r_order = 'N';
        }
        $t_subscribe          = $this->input->post('t_subscribe');
        if ($this->input->post('t_subscribe') != "") {
            $t_subscribe = 'Y';
        } else {
            $t_subscribe = 'N';
        }
        $n_subscribe          = $this->input->post('n_subscribe');
        if ($this->input->post('n_subscribe') != "") {
            $n_subscribe = 'Y';
        } else {
            $n_subscribe = 'N';
        }
        $to_subscribe         = $this->input->post('to_subscribe');
        if ($this->input->post('to_subscribe') != "") {
            $to_subscribe = 'Y';
        } else {
            $to_subscribe = 'N';
        }
        $a_subscribe          = $this->input->post('a_subscribe');
        if ($this->input->post('a_subscribe') != "") {
            $a_subscribe = 'Y';
        } else {
            $a_subscribe = 'N';
        }
        $p_subscribe          = $this->input->post('p_subscribe');
        if ($this->input->post('p_subscribe') != "") {
            $p_subscribe = 'Y';
        } else {
            $p_subscribe = 'N';
        }
        $en_subscribe         = $this->input->post('en_subscribe');
        if ($this->input->post('en_subscribe') != "") {
            $en_subscribe = 'Y';
        } else {
            $en_subscribe = 'N';
        }
        $e_subscribe          = $this->input->post('e_subscribe');
        if ($this->input->post('e_subscribe') != "") {
            $e_subscribe = 'Y';
        } else {
            $e_subscribe = 'N';
        }
        $customer             = $this->input->post('customer');
        if ($this->input->post('customer') != "") {
            $customer = 'Y';
        } else {
            $customer = 'N';
        }
        $deliver_list         = $this->input->post('deliver_list');
        if ($this->input->post('deliver_list') != "") {
            $deliver_list = 'Y';
        } else {
            $deliver_list = 'N';
        }
        $delivery_recevied_p  = $this->input->post('delivery_recevied_p');
        if ($this->input->post('delivery_recevied_p') != "") {
            $delivery_recevied_p = 'Y';
        } else {
            $delivery_recevied_p = 'N';
        }
        $t_payment            = $this->input->post('t_payment');
        if ($this->input->post('t_payment') != "") {
            $t_payment = 'Y';
        } else {
            $t_payment = 'N';
        }
        $c_payment            = $this->input->post('c_payment');
        if ($this->input->post('c_payment') != "") {
            $c_payment = 'Y';
        } else {
            $c_payment = 'N';
        }
        $o_payment            = $this->input->post('o_payment');
        if ($this->input->post('o_payment') != "") {
            $o_payment = 'Y';
        } else {
            $o_payment = 'N';
        }
        $r_payment            = $this->input->post('r_payment');
        if ($this->input->post('r_payment') != "") {
            $r_payment = 'Y';
        } else {
            $r_payment = 'N';
        }
        $s_report             = $this->input->post('s_report');
        if ($this->input->post('s_report') != "") {
            $s_report = 'Y';
        } else {
            $s_report = 'N';
        }
        $p_report             = $this->input->post('p_report');
        if ($this->input->post('p_report') != "") {
            $p_report = 'Y';
        } else {
            $p_report = 'N';
        }
        $sms_customer         = $this->input->post('sms_customer');
        if ($this->input->post('sms_customer') != "") {
            $sms_customer = 'Y';
        } else {
            $sms_customer = 'N';
        }
        $sms_db               = $this->input->post('sms_db');
        if ($this->input->post('sms_db') != "") {
            $sms_db = 'Y';
        } else {
            $sms_db = 'N';
        }
        $warehouse               = $this->input->post('warehouse');
        if ($this->input->post('warehouse') != "") {
            $warehouse = 'Y';
        } else {
            $warehouse = 'N';
        }


        $supplier               = $this->input->post('supplier');
        if ($this->input->post('supplier') != "") {
            $supplier = 'Y';
        } else {
            $supplier = 'N';
        }
        $purchse_entry               = $this->input->post('purchse_entry');
        if ($this->input->post('purchse_entry') != "") {
            $purchse_entry = 'Y';
        } else {
            $purchse_entry = 'N';
        }
        $purchse_list               = $this->input->post('purchse_list');
        if ($this->input->post('purchse_list') != "") {
            $purchse_list = 'Y';
        } else {
            $purchse_list = 'N';
        }
        $stock_list               = $this->input->post('stock_list');
        if ($this->input->post('stock_list') != "") {
            $stock_list = 'Y';
        } else {
            $stock_list = 'N';
        }

        if ($this->form_validation->run() == TRUE) {
            $data_employee = array(
                'name'      => $name,
                'mobile_no'      => $mobile_no,
                'address'      => $address,
                'designation_id'      => $designation_id,
                'email_id'      => $email_id,
                'franchise_id'      => $login_type,

            );

            //print_r($data_employee);die;

            $this->db->insert('employee', $data_employee);
            $insert_id = $this->db->insert_id();

            $data_login = array(
                'company_name'         => $name,
                'company_phone'     => $mobile_no,
                'company_email'    => $email_id,
                'company_address'     => $address,
                'username'     => $username,
                'password'     => md5($password),
                'type'    => $login_type,
                'employee_id'    => $insert_id,
            );

            $this->db->insert('vg_login', $data_login);

            $data_access = array(
                'employee_id'      => $insert_id,
                'd_master'      => $d_master,
                'e_master'      => $e_master,
                'z_master'      => $z_master,
                'a_master'      => $a_master,
                'banner'      => $banner,
                'brand'      => $brand,
                'category'      => $category,
                'subcategory'      => $subcategory,
                'sub_subcategory'      => $sub_subcategory,
                'slot'      => $slot,
                'pickup'      => $pickup,
                'pincode'      => $pincode,
                'coupon'      => $coupon,
                'minlimit'      => $minlimit,
                'olimit'      => $olimit,
                'u_product'      => $u_product,
                'l_product'      => $l_product,
                'stock_update'      => $stock_update,
                'price_update'      => $price_update,
                'manually'      => $manually,
                't_order'      => $t_order,
                'to_order'      => $to_order,
                'p_order'      => $p_order,
                'i_order'      => $i_order,
                'a_order'      => $a_order,
                'a_n_order'      => $a_n_order,
                'dis_order'      => $dis_order,
                'd_order'      => $d_order,
                'c_order'      => $c_order,
                'cc_order'      => $cc_order,
                'r_order'      => $r_order,
                't_subscribe'      => $t_subscribe,
                'n_subscribe'      => $n_subscribe,
                'to_subscribe'      => $to_subscribe,
                'a_subscribe'      => $a_subscribe,
                'p_subscribe'      => $p_subscribe,
                'en_subscribe'      => $en_subscribe,
                'e_subscribe'      => $e_subscribe,
                'customer'      => $customer,
                'deliver_list'      => $deliver_list,
                'delivery_recevied_p'      => $delivery_recevied_p,
                't_payment'      => $t_payment,
                'c_payment'      => $c_payment,
                'o_payment'      => $o_payment,
                'r_payment'      => $r_payment,
                's_report'      => $s_report,
                'p_report'      => $p_report,
                'sms_customer'      => $sms_customer,
                'sms_db'      => $sms_db,
                'warehouse'      => $warehouse,
                'supplier'      => $supplier,
                'purchse_entry'      => $purchse_entry,
                'purchse_list'      => $purchse_list,
                'stock_list'      => $stock_list,

            );
            $this->db->insert('crm_access', $data_access);


            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Designation!</strong> add successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/employee');
        } else {
            $status = 'error';
            if (form_error('name')) {
                $errors['nameError'] = form_error('name');
            }
            if (form_error('mobile_no')) {
                $errors['mobile_noError'] = form_error('mobile_no');
            }
            if (form_error('address')) {
                $errors['addressError'] = form_error('address');
            }
            if (form_error('designation_id')) {
                $errors['designation_idError'] = form_error('designation_id');
            }
            if (form_error('username')) {
                $errors['usernameError'] = form_error('username');
            }
            if (form_error('password')) {
                $errors['passwordError'] = form_error('password');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }



    /********************** Delete employee Data in employee Table  **********************
     *********************************************************************************/
    public function delete_employee()
    {
        $delete_id = $this->input->post('delete_id');


        $this->db->where('employee_id', $delete_id);
        $this->db->delete('employee');

        $this->db->where('employee_id', $delete_id);
        $this->db->delete('crm_access');

        $this->db->where('employee_id', $delete_id);
        $this->db->delete('vg_login');

        echo $delete_id;
    }



    /****************************** Offer View Page **************/

    public function offer()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $franchise_id   = $this->session->userdata('type');
            $data['all_offer'] = $this->product_model->get_all_offer_model($franchise_id);
            $data['all_product'] = $this->product_model->get_all_product_model($franchise_id);
            $this->load->view('common/header');
            $this->load->view('product/offer', $data);
            $this->load->view('common/footer');
        }
    }


    public function update_offer()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $offer_id = $this->input->get('offer_id');
            $franchise_id   = $this->session->userdata('type');
            $data['offer'] = $this->product_model->get_offer_details($offer_id);
            $data['all_product'] = $this->product_model->get_all_product_model($franchise_id);
            $this->load->view('common/header');
            $this->load->view('product/update_offer', $data);
            $this->load->view('common/footer');
        }
    }


    /********************** Update offer data **************/
    public function update_offer_data()
    {
        $this->load->library('firebase');
        $login_type   = $this->session->userdata('type');

        $errors   = array();
        $message  = '';
        $redirect = '';
        $edit_id  = $this->input->post('offer_id');
        $this->form_validation->set_rules('description', 'Message', 'required');
        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $description  = $this->input->post('description');
        $title  = $this->input->post('title');
        $image      = $this->input->post('image');
        $old_image   = $this->input->post('old_image');

        if ($this->form_validation->run() == TRUE) {
            $update_data = array(
                'description'        => $description,
                'title'        => $title,

            );
            $status = 'success';
            $this->db->where('offer_id', $edit_id)->update('offer', $update_data);



            $files = $_FILES;
            if (!empty($_FILES['image']['name'])) {

                $_FILES['image']['name'] = $files['image']['name'];
                $_FILES['image']['type'] = $files['image']['type'];
                $_FILES['image']['tmp_name'] = $files['image']['tmp_name'];
                $_FILES['image']['error'] = $files['image']['error'];
                $_FILES['image']['size'] = $files['image']['size'];

                if ($old_image != $image) {

                    unlink('./assets/images/offer/' . $old_image);

                    $this->upload->initialize($this->upload_offer());
                    if (!$this->upload->do_upload('image')) {
                        $upload_error[] = array('error' => $this->upload->display_errors());
                    } else {
                        $upload_data = $this->upload->data();

                        $name_array = $upload_data['file_name'];
                        $insertArray1 = array(
                            'image' => $upload_data['file_name']
                        );
                        $this->db->where('offer_id', $edit_id);
                        $this->db->update('offer', $insertArray1);
                    }
                } else {
                    $insertArray1 = array(
                        'image' => $old_image
                    );
                    $this->db->where('offer_id', $edit_id);
                    $this->db->update('offer', $insertArray1);
                }
            }


            $cnt = count($product_id = $this->input->post('product_id'));
            for ($i = 0; $i < $cnt; $i++) {

                $fid             = $_POST['fid'][$i];

                if ($fid == '') {
                    $data2 = array(
                        'offer_id'       => $edit_id,
                        'product_id'     => $_POST['product_id'][$i],
                    );
                    $this->db->insert('offer_on_product', $data2);
                } else {
                    $data2 = array(
                        'product_id'     => $_POST['product_id'][$i],

                    );
                    $this->db->where('id', $fid)->update('offer_on_product', $data2);
                }
            }

            $this->db->select('*');
            $this->db->from('offer');
            $this->db->where('offer_id', $edit_id);
            $query  = $this->db->get();
            $result = $query->row();
            $offer_image = $result->image;

            $offer_image1 = 'assets/images/offer/' . $offer_image;
            $offer_image2 = base_url($offer_image1);

            $q = $this->db->select('*');
            $q = $this->db->where('franchise_id', $login_type);
            $q = $this->db->where('token !=', '');
            $q = $this->db->get('customer');
            $rowcount = $q->num_rows();
            $data = $q->result();
            if ($rowcount > 0) {

                foreach ($data as $result) {
                    $token[]     = $result->token;
                }

                // notification title

                // print_r(json_encode($token));die();     

                $this->load->model('FirebasePushModel', 'firebase_push_model');
                $this->firebase_push_model->__set('title', $title);
                $this->firebase_push_model->__set('message', $description);
                $this->firebase_push_model->__set('image', $offer_image2);
                $this->firebase_push_model->__set('is_background', true);
                $this->firebase_push_model->__set('offer_id', $edit_id);

                $androidSettings = ['notification' => ['sound' => 'sound.mp3']];
                $this->firebase_push_model->__set('androidSettings', $androidSettings);

                $payload = array();
                $payload['app'] = 'Firebase Notify';
                $payload['version'] = '1.2';
                $payload['sound'] = 'sound.mp3';
                $this->firebase_push_model->__set('payload', $payload);

                $requestData = $this->firebase_push_model->getPush();

                $response = $this->firebase->sendMultiple($token, $requestData);

                //$response = $this->firebase->sendToTopic('global', $requestData);
                $_SESSION["response"] = $response;
                $_SESSION["json"] = $requestData;
            }
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
					<button type="button" class="close" data-dismiss="alert">×</button>
					
					<div class="alert-icon">
					 <i class="icon-check"></i>
					</div>
					<div class="alert-message">
					  <span><strong>Offer!</strong> update successfully. <a href="javascript:void();" class="alert-link"></a></span>
					</div>
				  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/offer');
        } else {
            $status = 'error';
            if (form_error('title')) {
                $errors['titleError'] = form_error('title');
            }
            if (form_error('description')) {
                $errors['descriptionError'] = form_error('description');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;

        echo json_encode($data);
    }

    /******************************  **************/

    public function upload_offer()
    {



        $config = array();
        $config['upload_path'] = "assets/images/offer/";
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['overwrite'] = TRUE;
        return $config;
    }



    public function add_offer_data()
    {
        $this->load->library('firebase');
        $login_type   = $this->session->userdata('type');

        $errors   = array();
        $message  = '';
        $redirect = '';


        $product_id  = $this->input->post('product_id');
        $title  = $this->input->post('title');
        $description  = $this->input->post('description');


        $data_offer = array(
            'franchise_id'      => $login_type,
            'title'      => $title,
            'description'      => $description,
        );

        $this->db->insert('offer', $data_offer);
        $insert_id = $this->db->insert_id();


        $files = $_FILES;

        ///////// Image ////////////////

        if (!empty($_FILES['image']['name'])) {

            $_FILES['image']['name'] = $files['image']['name'];
            $_FILES['image']['type'] = $files['image']['type'];
            $_FILES['image']['tmp_name'] = $files['image']['tmp_name'];
            $_FILES['image']['error'] = $files['image']['error'];
            $_FILES['image']['size'] = $files['image']['size'];



            $this->load->library('upload', $this->upload_offer());

            $this->upload->initialize($this->upload_offer());

            if (!$this->upload->do_upload('image')) {

                $this->upload->display_errors();

                $upload_error[] = array('error' => $this->upload->display_errors());
            } else {
                $upload_data = $this->upload->data();
                $name_array = $upload_data['file_name'];

                $insertArray1 = array(
                    'image' => $upload_data['file_name'],
                );
                $this->db->where('offer_id', $insert_id);
                $this->db->update('offer', $insertArray1);
            }
        }

        $cnt = count($product_id);
        for ($i = 0; $i < $cnt; $i++) {
            $data2 = array(
                'offer_id'              => $insert_id,
                'product_id'             => $_POST['product_id'][$i],
            );

            $this->db->insert('offer_on_product', $data2);
        }


        $this->db->select('*');
        $this->db->from('offer');
        $this->db->where('offer_id', $insert_id);
        $query  = $this->db->get();
        $result = $query->row();
        $offer_image = $result->image;

        $offer_image1 = 'assets/images/offer/' . $offer_image;
        $offer_image2 = base_url($offer_image1);



        $q = $this->db->select('*');
        $q = $this->db->where('franchise_id', $login_type);
        $q = $this->db->where('token !=', '');
        $q = $this->db->order_by('customer_id', 'ASC');
        $q = $this->db->limit('999');
        $q = $this->db->get('customer');
        $rowcount = $q->num_rows();
        $data = $q->result();
        if ($rowcount > 0) {

            foreach ($data as $result) {
                $token[]     = $result->token;
            }

            // notification title

            // print_r(json_encode($token));die();     
            $title =  $title;

            //notification message
            $message = $description;

            $this->load->model('FirebasePushModel', 'firebase_push_model');
            $this->firebase_push_model->__set('title', $title);
            $this->firebase_push_model->__set('message', $message);
            $this->firebase_push_model->__set('image', $offer_image2);
            $this->firebase_push_model->__set('is_background', true);
            $this->firebase_push_model->__set('offer_id', $insert_id);

            $androidSettings = ['notification' => ['sound' => 'sound.mp3']];
            $this->firebase_push_model->__set('androidSettings', $androidSettings);

            $payload = array();
            $payload['app'] = 'Firebase Notify';
            $payload['version'] = '1.2';
            $payload['sound'] = 'sound.mp3';
            $this->firebase_push_model->__set('payload', $payload);

            $requestData = $this->firebase_push_model->getPush();

            $response = $this->firebase->sendMultiple($token, $requestData);

            //$response = $this->firebase->sendToTopic('global', $requestData);
            $_SESSION["response"] = $response;
            $_SESSION["json"] = $requestData;
        }
        $status = 'success';
        $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Offer!</strong> add successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

        $this->session->set_flashdata('message', $message);
        $redirect = base_url('product/offer');


        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }




    /********************** Delete offer Data in offer Table  **********************
     *********************************************************************************/
    public function delete_offer()
    {
        $delete_id = $this->input->post('delete_id');

        $this->db->select('*');
        $this->db->from('offer');
        $this->db->where('offer_id', $delete_id);
        $query  = $this->db->get();
        $result = $query->row();
        $logo = $result->image;

        unlink('./assets/images/offer/' . $logo);

        $this->db->where('offer_id', $delete_id);
        $this->db->delete('offer');
        echo $delete_id;
    }


    /***************************** Delete offer onproduct  *************************************
     ******************************************************************************************/
    public function delete_offer_on_product()
    {
        $delete_id     = $this->input->post('delete_id');

        $this->db->where('id', $delete_id);
        $this->db->delete('offer_on_product');
    }

    /****************************** Notification View Page **************/

    public function notification()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $franchise_id   = $this->session->userdata('type');
            $data['all_notification'] = $this->product_model->get_all_notification_model($franchise_id);
            $this->load->view('common/header');
            $this->load->view('product/notification', $data);
            $this->load->view('common/footer');
        }
    }



    /******************************  **************/

    public function upload_notification()
    {



        $config = array();
        $config['upload_path'] = "assets/images/notification/";
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['overwrite'] = TRUE;
        return $config;
    }



    public function add_notification_data()
    {
        $this->load->library('firebase');
        $login_type   = $this->session->userdata('type');

        $errors   = array();
        $message  = '';
        $redirect = '';


        $title  = $this->input->post('title');
        $description  = $this->input->post('description');
        $current_date = date('d-m-Y');

        $data_notification = array(
            'franchise_id'      => $login_type,
            'title'      => $title,
            'description'      => $description,
            'date'      => $current_date,
        );

        $this->db->insert('notification', $data_notification);
        $insert_id = $this->db->insert_id();


        $files = $_FILES;

        ///////// Image ////////////////

        if (!empty($_FILES['image']['name'])) {

            $_FILES['image']['name'] = $files['image']['name'];
            $_FILES['image']['type'] = $files['image']['type'];
            $_FILES['image']['tmp_name'] = $files['image']['tmp_name'];
            $_FILES['image']['error'] = $files['image']['error'];
            $_FILES['image']['size'] = $files['image']['size'];



            $this->load->library('upload', $this->upload_notification());

            $this->upload->initialize($this->upload_notification());

            if (!$this->upload->do_upload('image')) {

                $this->upload->display_errors();

                $upload_error[] = array('error' => $this->upload->display_errors());
            } else {
                $upload_data = $this->upload->data();
                $name_array = $upload_data['file_name'];

                $insertArray1 = array(
                    'image' => $upload_data['file_name'],
                );
                $this->db->where('notification_id', $insert_id);
                $this->db->update('notification', $insertArray1);
            }
        }


        $this->db->select('*');
        $this->db->from('notification');
        $this->db->where('notification_id', $insert_id);
        $query  = $this->db->get();
        $result = $query->row();
        $notification_image = $result->image;

        $notification_image1 = 'assets/images/notification/' . $notification_image;
        $notification_image2 = base_url($notification_image1);



        $q = $this->db->select('*');
        $q = $this->db->where('franchise_id', $login_type);
        $q = $this->db->where('token !=', '');
        $q = $this->db->order_by('customer_id', 'ASC');
        $q = $this->db->limit('999');
        $q = $this->db->get('customer');
        $rowcount = $q->num_rows();
        $data = $q->result();
        if ($rowcount > 0) {

            foreach ($data as $result) {
                $token[]     = $result->token;
            }

            // notification title

            // print_r(json_encode($token));die();     
            $title =  $title;

            //notification message
            $message = $description;

            $this->load->model('FirebasePushModel', 'firebase_push_model');
            $this->firebase_push_model->__set('title', $title);
            $this->firebase_push_model->__set('message', $message);
            $this->firebase_push_model->__set('image', $notification_image2);
            $this->firebase_push_model->__set('is_background', true);
            $this->firebase_push_model->__set('offer_id', '0');

            $androidSettings = ['notification' => ['sound' => 'sound.mp3']];
            $this->firebase_push_model->__set('androidSettings', $androidSettings);

            $payload = array();
            $payload['app'] = 'Firebase Notify';
            $payload['version'] = '1.2';
            $payload['sound'] = 'sound.mp3';
            $this->firebase_push_model->__set('payload', $payload);

            $requestData = $this->firebase_push_model->getPush();

            $response = $this->firebase->sendMultiple($token, $requestData);

            //$response = $this->firebase->sendToTopic('global', $requestData);
            $_SESSION["response"] = $response;
            $_SESSION["json"] = $requestData;
        }
        $status = 'success';
        $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Notification!</strong> send successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

        $this->session->set_flashdata('message', $message);
        $redirect = base_url('product/notification');


        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }

    /********************** Delete Notification Data in notification Table  **********************
     *********************************************************************************/
    public function delete_notification()
    {
        $delete_id = $this->input->post('delete_id');

        $this->db->select('*');
        $this->db->from('notification');
        $this->db->where('notification_id', $delete_id);
        $query  = $this->db->get();
        $result = $query->row();
        $logo = $result->image;

        unlink('./assets/images/notification/' . $logo);

        $this->db->where('notification_id', $delete_id);
        $this->db->delete('notification');
        echo $delete_id;
    }

    /****************************** Out of Stock Product List View Page **************/

    public function out_of_stock_p()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $this->load->view('common/header');
            $this->load->view('product/out_of_stock_p');
            $this->load->view('common/footer');
        }
    }




    //////////////////////////////////AJAX OUT OF STOCK PRODUCT LIST //////////////////////////

    public function ajax_out_of_stock_list()
    {

        $columns = array(
            0 => 'product_id',
            1 => 'main_image',
            2 => 'product_name',
            3 => 'category',
            4 => 'brand',
            5 => 'qty',



        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->product_model->oos_product_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $posts = $this->product_model->oos_product_list($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $posts =  $this->product_model->oos_product_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->product_model->oos_product_search_count($search);
        }

        $data = array();
        if (!empty($posts)) {
            $i = 1;
            foreach ($posts as $post) {

                $nestedData['product_id'] = $i;
                $nestedData['product_name'] = $post->product_name;
                $nestedData['category'] = $post->name;
                $nestedData['brand'] = $post->brand_name;
                $this->db->select('*');
                $this->db->from('franchise');
                $this->db->where('franchise_id', $post->franchise_id);
                $query44  = $this->db->get();
                $result44 = $query44->row();
                $franchise_name = $result44->franchise_name;

                $nestedData['franchise'] = $franchise_name;

                if ($post->qty == '0') {
                    $nestedData['qty'] = '<span class="badge badge-danger shadow-danger m-1">Out of stock</span>';
                } else {
                    $nestedData['qty'] = $post->qty;
                }

                if ($post->main_image == '') {
                    $nestedData['main_image'] = '<a href="https://via.placeholder.com/1500x1000" data-fancybox="images" data-caption="This image has a caption">
                    							  <img src="https://via.placeholder.com/240x160" alt="lightbox" class="lightbox-thumb img-thumbnail">
                    							</a>';
                } else {
                    $nestedData['main_image'] = '<a href="' . base_url('assets/images/product/' . $post->main_image) . '" data-fancybox="images" data-caption="This image has a caption">
									           <img src="' . base_url('assets/images/product/' . $post->main_image) . '" alt="lightbox" class="lightbox-thumb img-thumbnail" style="width: 80px;">
								            	</a>';
                }


                $this->db->select('*');
                $this->db->from('product_details');
                $this->db->where('product_id', $post->product_id);
                $query444  = $this->db->get();
                $result444 = $query444->row();
                $unit_price = $result444->unit_price;
                $purchse_price = $result444->purchse_price;

                $nestedData['sales_price'] = $unit_price;
                $nestedData['purchse_price'] = $purchse_price;



                $nestedData['action'] = '';

                $nestedData['action'] = ' <div class="btn-group m-1" role="group">
                                              <button type="button" class="btn btn-dark   waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                              </button>
                                              <div class="dropdown-menu">
                                                <a href="' . base_url('product/update_product?product_id=' . $post->product_id) . '" class="dropdown-item"><i aria-hidden="true" class="fa fa-edit"></i> Edit</a>
                                                
                                                <a style="cursor:pointer;"  class="tip-top dropdown-item delete one_' . $post->product_id . '" data-original-title="Delete" id="' . "'" . $post->product_id . "'" . '"
						                           Onclick="return ConfirmDelete1(' . "'" . $post->product_id . "'" . ')">
                                                  <i aria-hidden="true" class="fa fa-sticky-note"></i> Out of stock
                                               </a>
                                               
                                                <a style="cursor:pointer;"  class="tip-top dropdown-item delete one_' . $post->product_id . '" data-original-title="Delete" id="' . "'" . $post->product_id . "'" . '"
						                           Onclick="return ConfirmDelete(' . "'" . $post->product_id . "'" . ')">
                                                  <i aria-hidden="true" class="fa fa-trash"></i> Delete
                                               </a>
                                              </div>
                                            </div>';

                $data[] = $nestedData;

                $i++;
            }
        }

        $json_data = array(
            "draw"            => intval($this->input->post('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);
    }



    /****************************** Qrcode View Page **************/

    public function qrcode()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $insert_id = '4';
            $data['qrcode'] = $this->product_model->get_qrcode_one($insert_id);
            $this->load->view('common/header');
            $this->load->view('product/qrcode', $data);
            $this->load->view('common/footer');
        }
    }

    public function add_qrcode_data()
    {
        $this->load->library('ci_qr_code');
        $this->config->load('qr_code');

        $login_type   = $this->session->userdata('type');

        $errors   = array();
        $message  = '';
        $redirect = '';

        $data_qrcode = array(
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

        $code_name = 'appqrcode';
        // get full name and user details
        $qr_details = $this->product_model->get_qrcode_one($insert_id);
        $image_name = $code_name . ".png";

        // create user content

        $codeContents = 'https://play.google.com/store/apps/details?id=com.exoticbasket.in';

        $params['data'] = $codeContents;
        $params['level'] = 'H';
        $params['size'] = 8;

        $params['savename'] = FCPATH . $qr_code_config['imagedir'] . $image_name;
        $this->ci_qr_code->generate($params);

        $this->data['qr_code_image_url'] = './assets/images/qrcode/' . $qr_code_config['imagedir'] . $image_name;

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

        $this->session->set_flashdata('message', $message);
        $redirect = base_url('product/qrcode');


        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }



    function active_sloct()

    {


        $errors   = array();
        $message  = '';
        $redirect = '';

        $this->form_validation->set_rules('flag', 'select option', 'required');
        $this->form_validation->set_message('required', '* Please select %s');

        $multiple_id  = $this->input->post('multiple_id');
        $flag  = $this->input->post('flag');
        if ($this->form_validation->run() == TRUE) {
            $slot_id = explode(",", $multiple_id);

            $i = 0;
            foreach ($slot_id as $slot_id) {
                $update_data = array(
                    'flag'                => $flag,

                );

                $this->db->where('slot_id', $slot_id)->update('slot_timing', $update_data);

                $i++;
            }

            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Slot active!</strong>  successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/slot');
        } else {
            $status = 'error';
            if (form_error('flag')) {
                $errors['flagError'] = form_error('flag');
            }
        }


        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }



    /****************************** Hot product View Page **************/

    public function hot_product()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['all_hp'] = $this->product_model->get_all_hot_product_model();
            $data['all_subcategory'] = $this->product_model->get_all_subcategory_model1();
            $this->load->view('common/header');
            $this->load->view('product/hot_product', $data);
            $this->load->view('common/footer');
        }
    }


    /****************************** web  category View Page **************/

    public function web_product()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['all_hp'] = $this->product_model->get_all_hot_product_model();
            $data['all_subcategory'] = $this->product_model->get_all_subcategory_model1();
            $this->load->view('common/header');
            $this->load->view('product/web_product', $data);
            $this->load->view('common/footer');
        }
    }

    /****************************** get web category **************/

    public function get_web_category()
    {

        $result = $this->product_model->get_web_category_list();

        $data = '';

        if ($result != null) {

            foreach ($result as $row) {

                $data .= "<tr>";
                $data .= "<td>{$row->category_id}</td><td>{$row->name}</td>";
                if ($row->web_category == 1) {
                    $data .= "<td>In-active</td>";
                    $data .= "<td><input type='checkbox' name='web_id' id='web_id' onclick='change_status(`{$row->category_id}`,`0`)'></td>";
                } else {
                    $data .= "<td>Active</td>";
                    $data .= "<td><input type='checkbox' name='web_id' id='web_id' onclick='change_status(`{$row->category_id}`,`1`)' checked></td>";
                }


                $data .= "</tr>";
            }


            $response["status"] = true;
            $response["body"] = $data;
        } else {
            $data = "<tr>No Category avaialble</tr>";
            $response["status"] = false;
            $response["body"] = $data;
        }


        echo json_encode($response);
    }


    /****************************** change web category status **************/

    public function change_status()
    {
        $category_id = $this->input->post_get('category_id');
        $status = $this->input->post_get('status');

        $data = array(
            'web_category' => $status
        );

        if ($category_id != null) {

            $this->db->where('category_id', $category_id);
            $result = $this->db->update('category', $data);
            if ($result) {
                $response["status"] = true;
            } else {
                $response["status"] = false;
            }
        } else {

            $response["status"] = false;
        }


        echo json_encode($response);
    }

    /********************** Add hot product data **************/

    public function upload_hot_product()
    {



        $config = array();
        $config['upload_path'] = "assets/images/hot_product/";
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['overwrite'] = TRUE;
        return $config;
    }
    public function add_hot_product_data()
    {
        $login_type   = $this->session->userdata('type');

        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('sub_category_id', 'sub category', 'required');
        $this->form_validation->set_message('required', '* Please select %s');

        $sub_category_id  = $this->input->post('sub_category_id');

        if ($this->form_validation->run() == TRUE) {
            $data_hot_product = array(
                'sub_category_id'   => $sub_category_id,
                'franchise_id'      => $login_type,

            );

            $this->db->insert('hot_product', $data_hot_product);
            $insert_id = $this->db->insert_id();



            $files = $_FILES;

            ///////// Logo ////////////////

            if (!empty($_FILES['logo']['name'])) {

                $_FILES['logo']['name'] = $files['logo']['name'];
                $_FILES['logo']['type'] = $files['logo']['type'];
                $_FILES['logo']['tmp_name'] = $files['logo']['tmp_name'];
                $_FILES['logo']['error'] = $files['logo']['error'];
                $_FILES['logo']['size'] = $files['logo']['size'];

                $this->load->library('upload', $this->upload_hot_product());

                $this->upload->initialize($this->upload_hot_product());

                if (!$this->upload->do_upload('logo')) {

                    $this->upload->display_errors();
                    $upload_error[] = array('error' => $this->upload->display_errors());
                } else {
                    $upload_data = $this->upload->data();
                    $name_array = $upload_data['file_name'];

                    $insertArray1 = array(
                        'image'      => $upload_data['file_name'],

                    );
                    $this->db->where('hp_id', $insert_id);
                    $this->db->update('hot_product', $insertArray1);
                }
            }

            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Hot product!</strong> add successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/hot_product');
        } else {
            $status = 'error';
            if (form_error('sub_category_id')) {
                $errors['sub_category_idError'] = form_error('sub_category_id');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }



    public function update_hot_product_data()
    {
        $errors   = array();
        $message  = '';
        $redirect = '';
        $edit_id  = $this->input->post('hp_id');
        $this->form_validation->set_rules('sub_category_id', 'subcategory name', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $sub_category_id  = $this->input->post('sub_category_id');


        $logo_old   = $this->input->post('logo_old');

        if ($this->form_validation->run() == TRUE) {
            $update_data = array(
                'sub_category_id'      => $sub_category_id,

            );
            $status = 'success';
            $this->db->where('hp_id', $edit_id)->update('hot_product', $update_data);

            $files = $_FILES;

            ///////// Main Image  ////////////////

            if (!empty($_FILES['logo']['name'])) {

                $_FILES['logo']['name'] = $files['logo']['name'];

                $_FILES['logo']['type'] = $files['logo']['type'];
                $_FILES['logo']['tmp_name'] = $files['logo']['tmp_name'];
                $_FILES['logo']['error'] = $files['logo']['error'];
                $_FILES['logo']['size'] = $files['logo']['size'];


                if ($logo_old != $_FILES['logo']['name']) {
                    unlink("./assets/images/hot_product/$logo_old");


                    $this->load->library('upload', $this->upload_hot_product());

                    $this->upload->initialize($this->upload_hot_product());

                    if (!$this->upload->do_upload('logo')) {

                        $this->upload->display_errors();

                        $upload_error[] = array('error' => $this->upload->display_errors());
                    } else {
                        $upload_data = $this->upload->data();
                        $name_array = $upload_data['file_name'];

                        $insertArray1 = array(
                            'image' => $upload_data['file_name'],
                        );
                        $this->db->where('hp_id', $edit_id);
                        $this->db->update('hot_product', $insertArray1);
                    }
                } else {
                    $insertArray1 = array(
                        'image' => $logo_old
                    );
                    $this->db->where('hp_id', $edit_id);
                    $this->db->update('hot_product', $insertArray1);
                }
            }


            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Hot product!</strong> add successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/hot_product');
        } else {
            $status = 'error';
            if (form_error('sub_category_id')) {
                $errors['sub_category_idError'] = form_error('sub_category_id');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }


    /********************** Delete hot Data in hotproduct Table  **********************
     *********************************************************************************/
    public function delete_hot_product()
    {
        $delete_id = $this->input->post('delete_id');

        $this->db->select('*');
        $this->db->from('hot_product');
        $this->db->where('hp_id', $delete_id);
        $query  = $this->db->get();
        $result = $query->row();
        $image = $result->image;

        unlink('./assets/images/hot_product/' . $image);

        $this->db->where('hp_id', $delete_id);
        $this->db->delete('hot_product');
        echo $delete_id;
    }



    /****************************** Offer View Page **************/

    public function today_offer()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $franchise_id   = $this->session->userdata('type');
            $data['all_offer'] = $this->product_model->get_all_today_offer_model($franchise_id);
            $data['all_product'] = $this->product_model->get_all_product_model($franchise_id);
            $this->load->view('common/header');
            $this->load->view('product/today_offer', $data);
            $this->load->view('common/footer');
        }
    }



    public function add_tofay_offer_data()
    {
        $login_type   = $this->session->userdata('type');

        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('offer_name', 'offer name', 'required');
        $this->form_validation->set_rules('start_time', 'start time', 'required');
        $this->form_validation->set_rules('end_time', 'end time', 'required');
        $this->form_validation->set_message('required', '* Please select %s');

        $offer_name  = $this->input->post('offer_name');
        $start_time  = date('h:i A', strtotime($this->input->post('start_time')));
        $end_time    = date('h:i A', strtotime($this->input->post('end_time')));
        $product_id  = $this->input->post('product_id');
        $date = date('d-m-Y');

        if ($this->form_validation->run() == TRUE) {
            $data_hot_product = array(
                'offer_name'   => $offer_name,
                'start_time'   => $start_time,
                'end_time'     => $end_time,
                'date'         => $date,
                'franchise_id' => $login_type,

            );

            $this->db->insert('today_offer', $data_hot_product);
            $insert_id = $this->db->insert_id();

            $cnt = count($product_id);
            for ($i = 0; $i < $cnt; $i++) {
                $data2 = array(
                    'tf_id'              => $insert_id,
                    'product_id'             => $_POST['product_id'][$i],
                );

                $this->db->insert('today_offer_product', $data2);
            }

            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Today offer !</strong> add successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('product/today_offer');
        } else {
            $status = 'error';
            if (form_error('offer_name')) {
                $errors['offer_nameError'] = form_error('offer_name');
            }
            if (form_error('start_time')) {
                $errors['start_timeError'] = form_error('start_time');
            }
            if (form_error('end_time')) {
                $errors['end_timeError'] = form_error('end_time');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }



    /********************** Delete offer Data in today offer Table  **********************
     *********************************************************************************/
    public function delete_today_offer()
    {
        $delete_id = $this->input->post('delete_id');

        $this->db->where('tf_id', $delete_id);
        $this->db->delete('today_offer');

        $this->db->where('tf_id', $delete_id);
        $this->db->delete('today_offer_product');
        echo $delete_id;
    }
    /*****************************************************************/

    public function loadNibValues()
    {
        $rawQuery = 'select * from lp_nib_master where status=1';
        $result = $this->GlobalModal->executeQuery($rawQuery);
        echo json_encode(array('status' => 200, "data" => $result));
    }

    public function loadClipValues()
    {
        $rawQuery = 'select * from lp_clip_master where status=1';
        $result = $this->GlobalModal->executeQuery($rawQuery);
        echo json_encode(array('status' => 200, "data" => $result));
    }

    public function loadMaterialValues()
    {
        $rawQuery = 'select * from lp_material_master where status=1';
        $result = $this->GlobalModal->executeQuery($rawQuery);
        echo json_encode(array('status' => 200, "data" => $result));
    }

    public function removeImages()
    {
        $delete_id = $this->input->post('id');
        $this->db->where('id', $delete_id);
        $this->db->delete('product_details');
        echo json_encode(array('status'=>200,'body'=>'image removed'));
    }
}
