<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sales extends CI_Controller
{


    function __construct()
    {
        parent::__construct();
        $this->load->model('sales_model');
        $this->load->model('product_model');
        $this->load->model('customer_model');
        $this->load->library('upload');
    }

    public function index()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['all_delivery_boy'] = $this->customer_model->get_all_db_model();
            $data['total_amount'] = $this->sales_model->count_today_amount();
            $data['total_amount1'] = $this->sales_model->count_today_amount1();
            $this->load->view('common/header');
            $this->load->view('sales/today_sale', $data);
            $this->load->view('common/footer');
        }
    }




    //////////////////////////////////AJAX TODAY ORDER LIST //////////////////////////

    public function ajax_today_order_list()
    {

        $login_type   = $this->session->userdata('type');

        $columns = array(
            0 => 'order_id',
            1 => 'order_generate_id',
            2 => 'count_product',
            3 => 'customer_id',
            4 => 'mobile_no',
            5 => 'order_total',
            7 => 'order_date',
            8 => 'flag',
            9 => 'action',
        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->sales_model->today_order_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $posts = $this->sales_model->today_order_list($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $posts =  $this->sales_model->today_order_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->sales_model->today_order_search_count($search);
        }

        $data = array();
        if (!empty($posts)) {
            $i = 1;
            foreach ($posts as $post) {
                if ($login_type != '0') {
                    $nestedData['order_id'] = '<input type="checkbox" class="sub_chk" data-id="' . $post->order_id . '">';
                } else {
                    $nestedData['order_id'] = $i++;
                }
                $nestedData['order_generate_id'] = '#' . $post->order_generate_id;
                $nestedData['customer_id'] = $post->first_name . ' ' . $post->last_name;
                $nestedData['order_total'] = $post->order_total;
                $nestedData['address'] = $post->deliver_address;
                $nestedData['order_date'] = date("d-m-Y h:i A", strtotime($post->entry_datetime));
                $nestedData['mobile_no'] = $post->mobile_no;
                $nestedData['franchise'] = $post->franchise_name;


                $nestedData['assign_to'] = '';

                if ($post->status == '0') {
                    $nestedData['status'] = '<span class="badge badge-danger shadow-danger m-1">Pending</span>';
                } elseif ($post->status == '1') {
                    $nestedData['status'] = '<span class="badge badge-success shadow-success m-1">Confirm</span>';
                } elseif ($post->status == '2') {
                    $nestedData['status'] = '<span class="badge badge-info shadow-info m-1">Dispatch</span>';
                } elseif ($post->status == '3') {
                    $nestedData['status'] = '<span class="badge badge-primary shadow-primary m-1">Delivered</span>';
                } elseif ($post->status == '4') {
                    $nestedData['status'] = '<span class="badge badge-danger shadow-danger m-1">Cancel</span><br> ' . $post->cancel_resion;
                }


                if ($post->payment_status == '0') {
                    $nestedData['payment_status'] = '<span class="badge badge-danger shadow-danger m-1">Unpaid</span>';
                } elseif ($post->payment_status == '1') {
                    $nestedData['payment_status'] = '<span class="badge badge-success shadow-success m-1">Paid</span>';
                }


                if ($post->flag == '0') {
                    $nestedData['flag'] = '<span class="badge badge-info shadow-info m-1">App</span>';
                } elseif ($post->flag == '1') {
                    $nestedData['flag'] = '<span class="badge badge-success shadow-success m-1">Manually</span>';
                }
                $this->db->select('COUNT(order_id) AS no_of_product');
                $this->db->from('order_detail');
                $this->db->where('order_id', $post->order_id);
                $query  = $this->db->get();
                $result = $query->row();
                $no_of_product = $result->no_of_product;


                $nestedData['count_product'] = $no_of_product;

                $nestedData['action'] = '';

                $nestedData['action'] = ' <div class="btn-group m-1" role="group">
                                              <button type="button" class="btn btn-dark   waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                              </button>
                                              <div class="dropdown-menu">
                                               
                                               
                                                <a href="' . base_url('sales/view_invoice?order_id=' . $post->order_generate_id) . '" class="dropdown-item" target="_blank"><i aria-hidden="true" class="fa fa-eye"></i> View</a>
                                                <a href="' . base_url('sales/invoice/' . $post->order_generate_id) . '" class="dropdown-item" target="_blank><i aria-hidden="true" class="fa fa-file"></i> Download Invoice</a>
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


    public function view_invoice()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $order_id = $this->input->get('order_id');
            $data['order_summary'] = $this->product_model->get_order_summary($order_id);
            $this->load->view('common/header');
            $this->load->view('sales/view_invoice', $data);
            $this->load->view('common/footer');
        }
    }


    public function assign_order()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $order_id = $this->input->get('order_id');
            $data['order_summary'] = $this->product_model->get_order_summary($order_id);
            $data['all_delivery_boy'] = $this->customer_model->get_all_db_model();
            $this->load->view('common/header');
            $this->load->view('sales/assign_order', $data);
            $this->load->view('common/footer');
        }
    }



    public function total_sales()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['pending_count'] = $this->sales_model->get_pending_count_model();
            $data['dispatch_count'] = $this->sales_model->get_dispatch_count_model();
            $data['delivered_count'] = $this->sales_model->get_delivered_count_model();
            $data['cancel_count'] = $this->sales_model->get_cancel_count_model();
            $data['all_delivery_boy'] = $this->customer_model->get_all_db_model();
            $this->load->view('common/header');
            $this->load->view('sales/total_sales', $data);
            $this->load->view('common/footer');
        }
    }




    //////////////////////////////////AJAX TOTAL ORDER LIST //////////////////////////

    public function ajax_total_order_list()
    {
        $login_type   = $this->session->userdata('type');

        $columns = array(
            0 => 'order_id',
            1 => 'order_generate_id',
            2 => 'count_product',
            3 => 'customer_id',
            4 => 'mobile_no',
            5 => 'order_total',
            6 => 'assign_to',
            7 => 'order_date',
            8 => 'flag',
            9 => 'action',


        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->sales_model->total_order_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $posts = $this->sales_model->total_order_list($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $posts =  $this->sales_model->total_order_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->sales_model->total_order_search_count($search);
        }

        $data = array();
        if (!empty($posts)) {
            $i = 1;
            foreach ($posts as $post) {

                $nestedData['order_id'] = '<input type="checkbox" class="sub_chk" data-id="' . $post->order_id . '">';
                $nestedData['order_generate_id'] = '#' . $post->order_generate_id;
                $nestedData['customer_id'] = $post->first_name . ' ' . $post->last_name;
                $nestedData['order_total'] = $post->order_total;
                $nestedData['address'] = $post->deliver_address;
                $nestedData['order_date'] = date("d-m-Y h:i A", strtotime($post->entry_datetime));
                $nestedData['franchise'] = $post->franchise_name;
                $nestedData['mobile_no'] = $post->mobile_no;


                $nestedData['slot'] = '';
                $nestedData['assign_to'] = '';

                if ($post->status == '0') {
                    $nestedData['status'] = '<span class="badge badge-danger shadow-danger m-1">Pending</span>';
                } elseif ($post->status == '1') {
                    $nestedData['status'] = '<span class="badge badge-success shadow-success m-1">Confirm</span>';
                } elseif ($post->status == '2') {
                    $nestedData['status'] = '<span class="badge badge-info shadow-info m-1">Dispatch</span>';
                } elseif ($post->status == '3') {
                    $nestedData['status'] = '<span class="badge badge-primary shadow-primary m-1">Delivered</span>';
                } elseif ($post->status == '4') {
                    $nestedData['status'] = '<span class="badge badge-danger shadow-danger m-1">Cancel</span>';
                }


                if ($post->payment_status == '0') {
                    $nestedData['payment_status'] = '<span class="badge badge-danger shadow-danger m-1">Unpaid</span>';
                } elseif ($post->payment_status == '1') {
                    $nestedData['payment_status'] = '<span class="badge badge-success shadow-success m-1">Paid</span>';
                }

                if ($post->flag == '0') {
                    $nestedData['flag'] = '<span class="badge badge-info shadow-info m-1">App</span>';
                } elseif ($post->flag == '1') {
                    $nestedData['flag'] = '<span class="badge badge-success shadow-success m-1">Manually</span>';
                }



                $this->db->select('COUNT(order_id) AS no_of_product');
                $this->db->from('order_detail');
                $this->db->where('order_id', $post->order_id);
                $query  = $this->db->get();
                $result = $query->row();
                $no_of_product = $result->no_of_product;


                $nestedData['count_product'] = $no_of_product;

                $nestedData['action'] = '';

                if ($post->flag == '1') {
                    $nestedData['action'] = ' <div class="btn-group m-1" role="group">
                                              <button type="button" class="btn btn-dark   waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                              </button>
                                              <div class="dropdown-menu">
                                               
                                               
                                                <a href="' . base_url('sales/view_invoice?order_id=' . $post->order_generate_id) . '" class="dropdown-item" target="_blank"><i aria-hidden="true" class="fa fa-eye"></i> View</a>
                                                <a href="' . base_url('sales/invoice/' . $post->order_generate_id) . '" class="dropdown-item" target="_blank><i aria-hidden="true" class="fa fa-file"></i> Download Invoice</a>
                                              </div>
                                            </div>';
                } else {
                    $nestedData['action'] = ' <div class="btn-group m-1" role="group">
                                              <button type="button" class="btn btn-dark   waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                              </button>
                                              <div class="dropdown-menu">
                                               
                                                <a href="' . base_url('sales/view_invoice?order_id=' . $post->order_generate_id) . '" class="dropdown-item" target="_blank"><i aria-hidden="true" class="fa fa-eye"></i> View</a>
                                                <a href="' . base_url('sales/invoice/' . $post->order_generate_id) . '" class="dropdown-item" target="_blank><i aria-hidden="true" class="fa fa-file"></i> Download Invoice</a>
                                              </div>
                                            </div>';
                }


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


    function add_assignproduct_data()

    {


        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('assign_to', ' delivery boy', 'required');
        $this->form_validation->set_rules('assign_date', 'date', 'required');
        $this->form_validation->set_message('required', '* Please select %s');

        $assign_to  = $this->input->post('assign_to');
        $assign_date    = date('Y-m-d h:i:A');

        $edit_id  = $this->input->post('order_id');

        if ($this->form_validation->run() == TRUE) {
            $update_data = array(
                'assign_to'      => $assign_to,
                'assign_date'        => $assign_date,

            );

            $this->db->where('order_id', $edit_id)->update('product_order', $update_data);




            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Assign product!</strong>  successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('sales/total_sales');
        } else {
            $status = 'error';
            if (form_error('assign_to')) {
                $errors['assign_toError'] = form_error('assign_to');
            }
            if (form_error('assign_date')) {
                $errors['assign_dateError'] = form_error('assign_date');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }


    public function pending_sales()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['all_delivery_boy'] = $this->customer_model->get_all_db_model();
            $this->load->view('common/header');
            $this->load->view('sales/pending_sale', $data);
            $this->load->view('common/footer');
        }
    }




    //////////////////////////////////AJAX PENDING ORDER LIST //////////////////////////

    public function ajax_pending_order_list()
    {
        $login_type   = $this->session->userdata('type');
        $columns = array(
            0 => 'order_id',
            1 => 'order_generate_id',
            2 => 'count_product',
            3 => 'customer_id',
            4 => 'order_total',
            5 => 'payment_status',
            6 => 'assign_to',
            7 => 'order_date',
            8 => 'action',


        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->sales_model->pending_order_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $posts = $this->sales_model->pending_order_list($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $posts =  $this->sales_model->pending_order_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->sales_model->pending_order_search_count($search);
        }

        $data = array();
        if (!empty($posts)) {
            $i = 1;
            foreach ($posts as $post) {

                $nestedData['order_id'] = '<input type="checkbox" class="sub_chk" data-id="' . $post->order_id . '">';
                $nestedData['order_generate_id'] = '#' . $post->order_generate_id;
                $nestedData['customer_id'] = $post->first_name . ' ' . $post->last_name;
                $nestedData['order_total'] = $post->order_total;
                $nestedData['address'] = $post->deliver_address;
                $nestedData['order_date'] = date("d-m-Y h:i A", strtotime($post->entry_datetime));
                $nestedData['franchise'] = $post->franchise_name;

                $this->db->select('*');
                $this->db->from('slot_timing');
                $this->db->where('slot_id', $post->slot_id);
                $query44  = $this->db->get();
                $rowcount = $query44->num_rows();
                if ($rowcount == 0) {
                    $day = '';
                    $slot_timing = '';
                } else {
                    $result44 = $query44->row();
                    $day = $result44->day;
                    $slot_timing = $result44->slot_timing;
                }

                $nestedData['slot'] = $day . ' ' . $slot_timing;

                if ($post->assign_to != '') {
                    $this->db->select('*');
                    $this->db->from('delivery_boy');
                    $this->db->where('db_id', $post->assign_to);
                    $query  = $this->db->get();
                    $result = $query->row();
                    $db_name = $result->name;

                    $nestedData['assign_to'] = $db_name;
                } else {
                    $nestedData['assign_to'] = '';
                }

                if ($post->status == '0') {
                    $nestedData['status'] = '<span class="badge badge-danger shadow-danger m-1">Pending</span>';
                } elseif ($post->status == '1') {
                    $nestedData['status'] = '<span class="badge badge-success shadow-success m-1">Confirm</span>';
                } elseif ($post->status == '2') {
                    $nestedData['status'] = '<span class="badge badge-info shadow-info m-1">Dispatch</span>';
                } elseif ($post->status == '3') {
                    $nestedData['status'] = '<span class="badge badge-primary shadow-primary m-1">Delivered</span>';
                } elseif ($post->status == '4') {
                    $nestedData['status'] = '<span class="badge badge-danger shadow-danger m-1">Cancel</span>';
                }


                if ($post->payment_status == '0') {
                    $nestedData['payment_status'] = '<span class="badge badge-danger shadow-danger m-1">Unpaid</span>';
                } elseif ($post->payment_status == '1') {
                    $nestedData['payment_status'] = '<span class="badge badge-success shadow-success m-1">Paid</span>';
                }



                $this->db->select('COUNT(order_id) AS no_of_product');
                $this->db->from('order_detail');
                $this->db->where('order_id', $post->order_id);
                $query  = $this->db->get();
                $result = $query->row();
                $no_of_product = $result->no_of_product;


                $nestedData['count_product'] = $no_of_product;

                $nestedData['action'] = '';

                if ($login_type != '0') {

                    $nestedData['action'] = ' <div class="btn-group m-1" role="group">
                                              <button type="button" class="btn btn-dark   waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                              </button>
                                              <div class="dropdown-menu">
                                               
                                                <a href="' . base_url('sales/view_invoice?order_id=' . $post->order_generate_id) . '" class="dropdown-item" target="_blank"><i aria-hidden="true" class="fa fa-eye"></i> View</a>
                                                <a href="' . base_url('sales/invoice/' . $post->order_generate_id) . '" class="dropdown-item" target="_blank><i aria-hidden="true" class="fa fa-file"></i> Download Invoice</a>
                                              </div>
                                            </div>';
                }
                if ($login_type == '0') {
                    $nestedData['action'] = ' <div class="btn-group m-1" role="group">
                                              <button type="button" class="btn btn-dark   waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                              </button>
                                              <div class="dropdown-menu">
                                                <a href="' . base_url('sales/view_invoice?order_id=' . $post->order_generate_id) . '" class="dropdown-item" target="_blank"><i aria-hidden="true" class="fa fa-eye"></i> View</a>
                                                <a href="' . base_url('sales/invoice/' . $post->order_generate_id) . '" class="dropdown-item" target="_blank><i aria-hidden="true" class="fa fa-file"></i> Download Invoice</a>
                                              </div>
                                            </div>';
                }

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

    public function dispatch_sales()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {

            $this->load->view('common/header');
            $this->load->view('sales/dispatch_sale');
            $this->load->view('common/footer');
        }
    }




    //////////////////////////////////AJAX DISPATCH ORDER LIST //////////////////////////

    public function ajax_dispatch_order_list()
    {

        $columns = array(
            0 => 'order_id',
            1 => 'order_generate_id',
            2 => 'count_product',
            3 => 'customer_id',
            4 => 'order_total',
            5 => 'order_date',
            6 => 'payment_status',
            7 => 'action',


        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->sales_model->dispatch_order_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $posts = $this->sales_model->dispatch_order_list($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $posts =  $this->sales_model->dispatch_order_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->sales_model->dispatch_order_search_count($search);
        }

        $data = array();
        if (!empty($posts)) {
            $i = 1;
            foreach ($posts as $post) {

                $nestedData['order_id'] = $i;
                $nestedData['order_generate_id'] = '#' . $post->order_generate_id;
                $nestedData['customer_id'] = $post->first_name . ' ' . $post->last_name;
                $nestedData['order_total'] = $post->order_total;
                $nestedData['deliver_address'] = $post->deliver_address;
                $nestedData['order_date'] = date("d-m-Y h:i A", strtotime($post->entry_datetime));


                if ($post->status == '0') {
                    $nestedData['status'] = '<span class="badge badge-danger shadow-danger m-1">Pending</span>';
                } elseif ($post->status == '1') {
                    $nestedData['status'] = '<span class="badge badge-success shadow-success m-1">Confirm</span>';
                } elseif ($post->status == '2') {
                    $nestedData['status'] = '<span class="badge badge-info shadow-info m-1">Dispatch</span>';
                } elseif ($post->status == '3') {
                    $nestedData['status'] = '<span class="badge badge-primary shadow-primary m-1">Delivered</span>';
                } elseif ($post->status == '4') {
                    $nestedData['status'] = '<span class="badge badge-danger shadow-danger m-1">Cancel</span>';
                }


                if ($post->payment_status == '0') {
                    $nestedData['payment_status'] = '<span class="badge badge-danger shadow-danger m-1">Unpaid</span>';
                } elseif ($post->payment_status == '1') {
                    $nestedData['payment_status'] = '<span class="badge badge-success shadow-success m-1">Paid</span>';
                }



                $this->db->select('COUNT(order_id) AS no_of_product');
                $this->db->from('order_detail');
                $this->db->where('order_id', $post->order_id);
                $query  = $this->db->get();
                $result = $query->row();
                $no_of_product = $result->no_of_product;


                $nestedData['count_product'] = $no_of_product;

                $nestedData['action'] = '';

                $nestedData['action'] = ' <div class="btn-group m-1" role="group">
                                              <button type="button" class="btn btn-dark   waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                              </button>
                                              <div class="dropdown-menu">
                                                <a href="' . base_url('sales/view_invoice?order_id=' . $post->order_generate_id) . '" class="dropdown-item"><i aria-hidden="true" class="fa fa-eye"></i> View</a>
                                                <a href="' . base_url('sales/invoice/' . $post->order_generate_id) . '" class="dropdown-item" target="_blank><i aria-hidden="true" class="fa fa-file"></i> Download Invoice</a>
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

    public function deliver_sales()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {

            $this->load->view('common/header');
            $this->load->view('sales/deliver_sale');
            $this->load->view('common/footer');
        }
    }




    //////////////////////////////////AJAX DLIVERED ORDER LIST //////////////////////////

    public function ajax_deliver_order_list()
    {
        $login_type   = $this->session->userdata('type');

        $columns = array(
            0 => 'order_id',
            1 => 'order_generate_id',
            2 => 'count_product',
            3 => 'customer_id',
            4 => 'order_total',
            5 => 'payment_status',
            6 => 'assign_to',
            7 => 'franchise',
            8 => 'action',


        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->sales_model->deliver_order_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $posts = $this->sales_model->deliver_order_list($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $posts =  $this->sales_model->deliver_order_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->sales_model->deliver_order_search_count($search);
        }

        $data = array();
        if (!empty($posts)) {
            $i = 1;
            foreach ($posts as $post) {

                $nestedData['order_id'] = $i;
                $nestedData['order_generate_id'] = '#' . $post->order_generate_id;
                $nestedData['customer_id'] = $post->first_name . ' ' . $post->last_name;
                $nestedData['order_total'] = $post->order_total;
                $nestedData['deliver_address'] = $post->deliver_address;
                $nestedData['franchise'] = $post->franchise_name;

                if ($post->assign_to != '') {
                    $this->db->select('*');
                    $this->db->from('delivery_boy');
                    $this->db->where('db_id', $post->assign_to);
                    $query  = $this->db->get();
                    $result = $query->row();
                    $db_name = $result->name;

                    $nestedData['assign_to'] = $db_name;
                } else {
                    $nestedData['assign_to'] = '';
                }

                if ($post->status == '0') {
                    $nestedData['status'] = '<span class="badge badge-danger shadow-danger m-1">Pending</span>';
                } elseif ($post->status == '1') {
                    $nestedData['status'] = '<span class="badge badge-success shadow-success m-1">Confirm</span>';
                } elseif ($post->status == '2') {
                    $nestedData['status'] = '<span class="badge badge-info shadow-info m-1">Dispatch</span>';
                } elseif ($post->status == '3') {
                    $nestedData['status'] = '<span class="badge badge-primary shadow-primary m-1">Delivered</span>';
                } elseif ($post->status == '4') {
                    $nestedData['status'] = '<span class="badge badge-danger shadow-danger m-1">Cancel</span>';
                }


                if ($post->payment_status == '0') {
                    $nestedData['payment_status'] = '<span class="badge badge-danger shadow-danger m-1">Unpaid</span>';
                } elseif ($post->payment_status == '1') {
                    $nestedData['payment_status'] = '<span class="badge badge-success shadow-success m-1">Paid</span>';
                }



                $this->db->select('COUNT(order_id) AS no_of_product');
                $this->db->from('order_detail');
                $this->db->where('order_id', $post->order_id);
                $query  = $this->db->get();
                $result = $query->row();
                $no_of_product = $result->no_of_product;


                $nestedData['count_product'] = $no_of_product;

                $nestedData['action'] = '';

                $nestedData['action'] = ' <div class="btn-group m-1" role="group">
                                              <button type="button" class="btn btn-dark   waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                              </button>
                                              <div class="dropdown-menu">
                                                <a href="' . base_url('sales/view_invoice?order_id=' . $post->order_generate_id) . '" class="dropdown-item"><i aria-hidden="true" class="fa fa-eye"></i> View</a>
                                                <a href="' . base_url('sales/invoice/' . $post->order_generate_id) . '" class="dropdown-item" target="_blank><i aria-hidden="true" class="fa fa-file"></i> Download Invoice</a>
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


    public function cancel_sales()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['sattel_payment'] = $this->sales_model->get_sum_refund_model();
            $data['total_cancel_payment'] = $this->sales_model->get_sum_cancel_amount_model();

            $this->load->view('common/header');
            $this->load->view('sales/cancel_sale', $data);
            $this->load->view('common/footer');
        }
    }



    public function cancel_sales1()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {

            $this->load->view('common/header');
            $this->load->view('sales/cancel_sale1');
            $this->load->view('common/footer');
        }
    }




    //////////////////////////////////AJAX CANCEL ORDER LIST //////////////////////////

    public function ajax_cancel_order_list()
    {

        $columns = array(
            0 => 'order_id',
            1 => 'order_generate_id',
            2 => 'count_product',
            3 => 'customer_id',
            4 => 'order_total',
            5 => 'payment_status',
            6 => 'refund_status',
            7 => 'franchise',


        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->sales_model->cancel_order_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $posts = $this->sales_model->cancel_order_list($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $posts =  $this->sales_model->cancel_order_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->sales_model->cancel_order_search_count($search);
        }

        $data = array();
        if (!empty($posts)) {
            $i = 1;
            foreach ($posts as $post) {

                if ($post->refund_status == '') {
                    $nestedData['order_id'] = '<input type="checkbox" class="sub_chk" data-id="' . $post->order_id . '">';
                } else {
                    $nestedData['order_id'] = '<input type="checkbox" class="sub_chk" data-id="' . $post->order_id . '" disabled>';
                }
                $nestedData['order_generate_id'] = '<a href="' . base_url('sales/view_invoice?order_id=' . $post->order_generate_id) . '">' . '#' . $post->order_generate_id . '</a>';
                $nestedData['customer_id'] = $post->first_name . ' ' . $post->last_name;
                $nestedData['order_total'] = $post->order_total;
                $nestedData['deliver_address'] = $post->deliver_address;
                $nestedData['franchise'] = $post->franchise_name;

                if ($post->assign_to != '') {
                    $this->db->select('*');
                    $this->db->from('delivery_boy');
                    $this->db->where('db_id', $post->assign_to);
                    $query  = $this->db->get();
                    $result = $query->row();
                    $db_name = $result->name;

                    $nestedData['assign_to'] = $db_name;
                } else {
                    $nestedData['assign_to'] = '';
                }

                if ($post->status == '0') {
                    $nestedData['status'] = '<span class="badge badge-danger shadow-danger m-1">Pending</span>';
                } elseif ($post->status == '1') {
                    $nestedData['status'] = '<span class="badge badge-success shadow-success m-1">Confirm</span>';
                } elseif ($post->status == '2') {
                    $nestedData['status'] = '<span class="badge badge-info shadow-info m-1">Dispatch</span>';
                } elseif ($post->status == '3') {
                    $nestedData['status'] = '<span class="badge badge-primary shadow-primary m-1">Delivered</span>';
                } elseif ($post->status == '4') {
                    $nestedData['status'] = '<span class="badge badge-danger shadow-danger m-1">Cancel</span>';
                }


                if ($post->payment_status == '0') {
                    $nestedData['payment_status'] = '<span class="badge badge-danger shadow-danger m-1">Unpaid</span>';
                } elseif ($post->payment_status == '1') {
                    $nestedData['payment_status'] = '<span class="badge badge-success shadow-success m-1">Paid</span>';
                }

                $this->db->select('*');
                $this->db->from('sattel_payment');
                $this->db->where('order_id', $post->order_id);
                $query77  = $this->db->get();
                $rowcount1 = $query77->num_rows();
                $result77 = $query77->row();
                if ($rowcount1 > 0) {
                    $payment_mode = $result77->payment_mode;

                    if ($payment_mode == 'Cash') {
                        $p_status = 'Payment Mode : Cash';
                    } else if ($payment_mode == 'Cheque') {
                        $p_status = 'Payment Mode : Cheque' . '<br>' . 'Cheque no :' . $result77->cheque_no;
                    } elseif ($payment_mode == 'Neft') {
                        $p_status = 'Payment Mode : NFT' . '<br>' . 'Transaction id' . ' ' . $result77->transaction_id;
                    } else if ($payment_mode == 'IMPS') {
                        $p_status = 'Payment Mode : IMPS' . '<br>' . 'Transaction id' . ' ' . $result77->transaction_id;
                    }
                } else {
                    $p_status = '';
                }



                if ($post->refund_status == '') {
                    $nestedData['refund_status'] = '';
                } else {
                    $nestedData['refund_status'] = '<span class="badge badge-success shadow-success m-1">Refunded</span>' . '<br>' . $p_status;
                }



                $this->db->select('COUNT(order_id) AS no_of_product');
                $this->db->from('order_detail');
                $this->db->where('order_id', $post->order_id);
                $query  = $this->db->get();
                $result = $query->row();
                $no_of_product = $result->no_of_product;


                $nestedData['count_product'] = $no_of_product;



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



    public function ajax_cancel_order_list1()
    {

        $columns = array(
            0 => 'order_id',
            1 => 'order_generate_id',
            2 => 'count_product',
            3 => 'customer_id',
            4 => 'order_total',
            5 => 'status',
            6 => 'resion',
            7 => 'franchise',


        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->sales_model->cancel_order_count1();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $posts = $this->sales_model->cancel_order_list1($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $posts =  $this->sales_model->cancel_order_search1($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->sales_model->cancel_order_search_count1($search);
        }

        $data = array();
        if (!empty($posts)) {
            $i = 1;
            foreach ($posts as $post) {

                if ($post->refund_status == '') {
                    $nestedData['order_id'] = $i++;
                } else {
                    $nestedData['order_id'] = '<input type="checkbox" class="sub_chk" data-id="' . $post->order_id . '" disabled>';
                }
                $nestedData['order_generate_id'] = '<a href="' . base_url('sales/view_invoice?order_id=' . $post->order_generate_id) . '">' . '#' . $post->order_generate_id . '</a>';
                $nestedData['customer_id'] = $post->first_name . ' ' . $post->last_name;
                $nestedData['order_total'] = $post->order_total;
                $nestedData['deliver_address'] = $post->deliver_address;
                $nestedData['franchise'] = $post->franchise_name;
                $nestedData['resion'] = $post->cancel_resion;

                if ($post->assign_to != '') {
                    $this->db->select('*');
                    $this->db->from('delivery_boy');
                    $this->db->where('db_id', $post->assign_to);
                    $query  = $this->db->get();
                    $result = $query->row();
                    $db_name = $result->name;

                    $nestedData['assign_to'] = $db_name;
                } else {
                    $nestedData['assign_to'] = '';
                }

                if ($post->status == '0') {
                    $nestedData['status'] = '<span class="badge badge-danger shadow-danger m-1">Pending</span>';
                } elseif ($post->status == '1') {
                    $nestedData['status'] = '<span class="badge badge-success shadow-success m-1">Confirm</span>';
                } elseif ($post->status == '2') {
                    $nestedData['status'] = '<span class="badge badge-info shadow-info m-1">Dispatch</span>';
                } elseif ($post->status == '3') {
                    $nestedData['status'] = '<span class="badge badge-primary shadow-primary m-1">Delivered</span>';
                } elseif ($post->status == '4') {
                    $nestedData['status'] = '<span class="badge badge-danger shadow-danger m-1">Cancel</span>';
                }


                if ($post->payment_status == '0') {
                    $nestedData['payment_status'] = '<span class="badge badge-danger shadow-danger m-1">Unpaid</span>';
                } elseif ($post->payment_status == '1') {
                    $nestedData['payment_status'] = '<span class="badge badge-success shadow-success m-1">Paid</span>';
                }

                $this->db->select('*');
                $this->db->from('sattel_payment');
                $this->db->where('order_id', $post->order_id);
                $query77  = $this->db->get();
                $rowcount1 = $query77->num_rows();
                $result77 = $query77->row();
                if ($rowcount1 > 0) {
                    $payment_mode = $result77->payment_mode;

                    if ($payment_mode == 'Cash') {
                        $p_status = 'Payment Mode : Cash';
                    } else if ($payment_mode == 'Cheque') {
                        $p_status = 'Payment Mode : Cheque' . '<br>' . 'Cheque no :' . $result77->cheque_no;
                    } elseif ($payment_mode == 'Neft') {
                        $p_status = 'Payment Mode : NFT' . '<br>' . 'Transaction id' . ' ' . $result77->transaction_id;
                    } else if ($payment_mode == 'IMPS') {
                        $p_status = 'Payment Mode : IMPS' . '<br>' . 'Transaction id' . ' ' . $result77->transaction_id;
                    }
                } else {
                    $p_status = '';
                }



                if ($post->refund_status == '') {
                    $nestedData['refund_status'] = '';
                } else {
                    $nestedData['refund_status'] = '<span class="badge badge-success shadow-success m-1">Refunded</span>' . '<br>' . $p_status;
                }



                $this->db->select('COUNT(order_id) AS no_of_product');
                $this->db->from('order_detail');
                $this->db->where('order_id', $post->order_id);
                $query  = $this->db->get();
                $result = $query->row();
                $no_of_product = $result->no_of_product;


                $nestedData['count_product'] = $no_of_product;



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


    /********************** Payment Status Upate  **********************************
     *********************************************************************************/

    public function payment_update()
    {
        $order_id = $this->input->post('order_id');
        $status = $this->input->post('status');

        $update_data = array(

            'payment_status'             => $status
        );

        $this->db->where('order_id', $order_id)->update('product_order', $update_data);

        echo $order_id;
    }

    /********************** Delivered Status Upate  **********************************
     *********************************************************************************/

    public function deliver_status()
    {
        $order_id = $this->input->post('order_id');
        $status = $this->input->post('status');



        if ($status == '2') {
            $update_data = array(
                'flag'                => '2',


            );

            $this->db->where('order_id', $order_id)->update('order_detail', $update_data);

            $update_data1 = array(

                'status'             => $status
            );

            $this->db->where('order_id', $order_id)->update('product_order', $update_data1);
        } elseif ($status == '3') {
            $this->db->select('*');
            $this->db->from('product_order');
            $this->db->where('order_id', $order_id);
            $query  = $this->db->get();
            $result = $query->row();
            $customer_id = $result->customer_id;
            $order_total = $result->order_total;
            $order_generate_id = $result->order_generate_id;


            $this->db->select('*');
            $this->db->from('customer');
            $this->db->where('customer_id', $customer_id);
            $query_cust  = $this->db->get();
            $result_cust = $query_cust->row();
            $first_name = $result_cust->first_name;
            $mobile_no = $result_cust->mobile_no;

            $update_data = array(

                'status'             => '3',
            );

            $this->db->where('order_id', $order_id)->update('product_order', $update_data);

            $sender = "EXOTIC";
            $number2 = $mobile_no;
            $msg2 = "Dear $first_name,your order successfully delivered.";

            $api_key = '55A827A192C7C6';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://www.logonutility.in/app/smsapi/index.php");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "key=" . $api_key . "&&campaign=1&routeid=20&type=text&contacts=" . $number2 . "&senderid=" . $sender . "&msg=" . $msg2);
            $response = curl_exec($ch);

            curl_close($ch);
        } elseif ($status == '4') {
            $update_data = array(

                'status'             => $status
            );

            $this->db->where('order_id', $order_id)->update('product_order', $update_data);
        }



        echo $order_id;
    }


    public function subscription()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['all_delivery_boy'] = $this->customer_model->get_all_db_model();

            $this->load->view('common/header');
            $this->load->view('sales/subscription', $data);
            $this->load->view('common/footer');
        }
    }


    //////////////////////////////////AJAX SUBSCRIPTION LIST //////////////////////////

    public function ajax_subscription_list()
    {

        $columns = array(
            0 => 'subscribe_id',
            1 => 'subscribe_generate_id',
            2 => 'customer',
            3 => 'mobile_no',
            4 => 'total_day',
            5 => 'date',
            6 => 'mode',
            7 => 'assign_to',
            8 => 'franchise',
            9 => 'action',


        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->sales_model->supscription_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $posts = $this->sales_model->supscription_list($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $posts =  $this->sales_model->supscription_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->sales_model->supscription_search_count($search);
        }

        $data = array();
        if (!empty($posts)) {
            $i = 1;
            foreach ($posts as $post) {

                $nestedData['subscribe_id'] = '<input type="checkbox" id="checkItem" class="sub_chk" data-id="' . $post->subscribe_id . '">';
                $nestedData['subscribe_generate_id'] = '<a href="' . base_url('sales/view_subscripe_details?subscribe_id=' . $post->subscribe_id) . '">' . '#' . $post->subscribe_generate_id . '</a>';
                $nestedData['customer'] = $post->first_name . ' ' . $post->last_name;
                $nestedData['date'] = date("d-m-Y", strtotime($post->from_date)) . ' To ' . date("d-m-Y", strtotime($post->to_date));
                $nestedData['mode'] = $post->subscribe_mode;
                $nestedData['address'] = $post->address;
                $nestedData['franchise'] = $post->franchise_name;
                $nestedData['mobile_no'] = $post->mobile_no;
                $nestedData['total_day'] = $post->total_day;


                if ($post->subscribe_status == '0') {
                    $nestedData['status'] = '<span class="badge badge-success shadow-success m-1">Active</span>';
                } elseif ($post->subscribe_status == '1') {
                    $nestedData['status'] = '<span class="badge badge-info shadow-info m-1">Puse</span>';
                } elseif ($post->subscribe_status == '2') {
                    $nestedData['status'] = '<span class="badge badge-danger shadow-danger m-1">End</span>';
                }

                if ($post->assign_to != '') {
                    $this->db->select('*');
                    $this->db->from('delivery_boy');
                    $this->db->where('db_id', $post->assign_to);
                    $query  = $this->db->get();
                    $result = $query->row();
                    $db_name = $result->name;

                    $nestedData['assign_to'] = $db_name;
                } else {
                    $nestedData['assign_to'] = '';
                }


                $nestedData['action'] = '<a href="' . base_url('sales/view_subscripe_details?subscribe_id=' . $post->subscribe_id) . '"><button type="button" class="btn btn-primary waves-effect waves-light m-1"> <i class="fa fa-eye"> View</i> </button> ';

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

    public function view_subscripe_details()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $subscribe_id = $this->input->get('subscribe_id');
            $data['order_summary'] = $this->sales_model->get_subscribe_summary($subscribe_id);
            $this->load->view('common/header');
            $this->load->view('sales/view_subscripe_details', $data);
            $this->load->view('common/footer');
        }
    }

    public function today_subscription()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {

            $this->load->view('common/header');
            $this->load->view('sales/today_subscription');
            $this->load->view('common/footer');
        }
    }


    //////////////////////////////////AJAX TODAY SUBSCRIPTION LIST //////////////////////////

    public function ajax_today_subscription_list()
    {
        $login_type   = $this->session->userdata('type');
        $columns = array(
            0 => 'subscribe_id',
            1 => 'subscribe_generate_id',
            2 => 'customer',
            3 => 'mobile_no',
            4 => 'total_day',
            5 => 'date',
            6 => 'mode',
            7 => 'assign_to',
            8 => 'franchise',
            9 => 'action',


        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->sales_model->today_supscription_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $posts = $this->sales_model->today_supscription_list($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $posts =  $this->sales_model->today_supscription_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->sales_model->today_supscription_search_count($search);
        }

        $data = array();
        if (!empty($posts)) {
            $i = 1;
            foreach ($posts as $post) {
                if ($login_type != '0') {
                    $nestedData['subscribe_id'] = '<input type="checkbox" class="sub_chk" data-id="' . $post->subscribe_id . '">';
                } else {
                    $nestedData['subscribe_id'] = $i++;
                }
                $nestedData['subscribe_generate_id'] = '<a href="' . base_url('sales/view_subscripe_details?subscribe_id=' . $post->subscribe_id) . '">' . '#' . $post->subscribe_generate_id . '</a>';
                $nestedData['customer'] = $post->first_name . ' ' . $post->last_name;
                $nestedData['date'] = date("d-m-Y", strtotime($post->from_date)) . ' To ' . date("d-m-Y", strtotime($post->to_date));
                $nestedData['mode'] = $post->subscribe_mode;
                $nestedData['address'] = $post->address;
                $nestedData['franchise'] = $post->franchise_name;

                $nestedData['mobile_no'] = $post->mobile_no;
                $nestedData['total_day'] = $post->total_day;


                if ($post->subscribe_status == '0') {
                    $nestedData['status'] = '<span class="badge badge-success shadow-success m-1">Active</span>';
                } elseif ($post->subscribe_status == '1') {
                    $nestedData['status'] = '<span class="badge badge-info shadow-info m-1">Puse</span>';
                } elseif ($post->subscribe_status == '2') {
                    $nestedData['status'] = '<span class="badge badge-danger shadow-danger m-1">End</span>';
                }

                if ($post->assign_to != '') {
                    $this->db->select('*');
                    $this->db->from('delivery_boy');
                    $this->db->where('db_id', $post->assign_to);
                    $query  = $this->db->get();
                    $result = $query->row();
                    $db_name = $result->name;

                    $nestedData['assign_to'] = $db_name;
                } else {
                    $nestedData['assign_to'] = '';
                }


                $nestedData['action'] = '<a href="' . base_url('sales/view_subscripe_details?subscribe_id=' . $post->subscribe_id) . '"><button type="button" class="btn btn-primary waves-effect waves-light m-1"> <i class="fa fa-eye"> View</i> </button> ';

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


    public function active_subscription()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {

            $this->load->view('common/header');
            $this->load->view('sales/active_subscription');
            $this->load->view('common/footer');
        }
    }



    //////////////////////////////////AJAX TODAY SUBSCRIPTION LIST //////////////////////////

    public function ajax_active_subscription_list()
    {

        $columns = array(
            0 => 'subscribe_id',
            1 => 'subscribe_generate_id',
            2 => 'customer',
            3 => 'product_name',
            4 => 'date',
            5 => 'mode',
            6 => 'assign_to',
            7 => 'status',
            8 => 'franchise',


        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->sales_model->active_supscription_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $posts = $this->sales_model->active_supscription_list($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $posts =  $this->sales_model->active_supscription_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->sales_model->active_supscription_search_count($search);
        }

        $data = array();
        if (!empty($posts)) {
            $i = 1;
            foreach ($posts as $post) {

                $nestedData['subscribe_id'] = $i;
                $nestedData['subscribe_generate_id'] = '<a href="' . base_url('sales/view_subscripe_details?subscribe_id=' . $post->subscribe_id) . '">' . '#' . $post->subscribe_generate_id . '</a>';
                $nestedData['customer'] = $post->first_name . ' ' . $post->last_name;
                $nestedData['date'] = $post->to_date;
                $nestedData['mode'] = $post->subscribe_mode;
                $nestedData['product_name'] = $post->product_name;
                $nestedData['franchise'] = $post->franchise_name;

                if ($post->subscribe_status == '0') {
                    $nestedData['status'] = '<span class="badge badge-success shadow-success m-1">Active</span>';
                } elseif ($post->subscribe_status == '1') {
                    $nestedData['status'] = '<span class="badge badge-info shadow-info m-1">Puse</span>';
                } elseif ($post->subscribe_status == '2') {
                    $nestedData['status'] = '<span class="badge badge-danger shadow-danger m-1">End</span>';
                }

                if ($post->assign_to != '') {
                    $this->db->select('*');
                    $this->db->from('delivery_boy');
                    $this->db->where('db_id', $post->assign_to);
                    $query  = $this->db->get();
                    $result = $query->row();
                    $db_name = $result->name;

                    $nestedData['assign_to'] = $db_name;
                } else {
                    $nestedData['assign_to'] = '';
                }



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


    public function pause_subscription()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {

            $this->load->view('common/header');
            $this->load->view('sales/pause_subscription');
            $this->load->view('common/footer');
        }
    }



    //////////////////////////////////AJAX PAUSE SUBSCRIPTION LIST //////////////////////////


    public function ajax_pause_subscription_list()
    {

        $columns = array(
            0 => 'subscribe_id',
            1 => 'subscribe_generate_id',
            2 => 'customer',
            3 => 'product_name',
            4 => 'date',
            5 => 'mode',
            6 => 'assign_to',
            7 => 'status',
            8 => 'franchise',


        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->sales_model->pause_supscription_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $posts = $this->sales_model->pause_supscription_list($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $posts =  $this->sales_model->pause_supscription_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->sales_model->pause_supscription_search_count($search);
        }

        $data = array();
        if (!empty($posts)) {
            $i = 1;
            foreach ($posts as $post) {

                $nestedData['subscribe_id'] = $i;
                $nestedData['subscribe_generate_id'] = '<a href="' . base_url('sales/view_subscripe_details?subscribe_id=' . $post->subscribe_id) . '">' . '#' . $post->subscribe_generate_id . '</a>';
                $nestedData['customer'] = $post->first_name . ' ' . $post->last_name;
                $nestedData['date'] = $post->to_date;
                $nestedData['mode'] = $post->subscribe_mode;
                $nestedData['product_name'] = $post->product_name;
                $nestedData['franchise'] = $post->franchise_name;

                if ($post->subscribe_status == '0') {
                    $nestedData['status'] = '<span class="badge badge-success shadow-success m-1">Active</span>';
                } elseif ($post->subscribe_status == '1') {
                    $nestedData['status'] = '<span class="badge badge-info shadow-info m-1">Puse</span>';
                } elseif ($post->subscribe_status == '2') {
                    $nestedData['status'] = '<span class="badge badge-danger shadow-danger m-1">End</span>';
                }

                if ($post->assign_to != '') {
                    $this->db->select('*');
                    $this->db->from('delivery_boy');
                    $this->db->where('db_id', $post->assign_to);
                    $query  = $this->db->get();
                    $result = $query->row();
                    $db_name = $result->name;

                    $nestedData['assign_to'] = $db_name;
                } else {
                    $nestedData['assign_to'] = '';
                }



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


    //////////////////////////////////AJAX END SUBSCRIPTION LIST //////////////////////////


    public function end_subscription()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {

            $this->load->view('common/header');
            $this->load->view('sales/end_subscription');
            $this->load->view('common/footer');
        }
    }

    public function ajax_end_subscription_list()
    {

        $columns = array(
            0 => 'subscribe_id',
            1 => 'subscribe_generate_id',
            2 => 'customer',
            3 => 'product_name',
            4 => 'date',
            5 => 'mode',
            6 => 'assign_to',
            7 => 'status',
            8 => 'franchise',


        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->sales_model->end_supscription_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $posts = $this->sales_model->end_supscription_list($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $posts =  $this->sales_model->end_supscription_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->sales_model->end_supscription_search_count($search);
        }

        $data = array();
        if (!empty($posts)) {
            $i = 1;
            foreach ($posts as $post) {

                $nestedData['subscribe_id'] = $i;
                $nestedData['subscribe_generate_id'] = '<a href="' . base_url('sales/view_subscripe_details?subscribe_id=' . $post->subscribe_id) . '">' . '#' . $post->subscribe_generate_id . '</a>';
                $nestedData['customer'] = $post->first_name . ' ' . $post->last_name;
                $nestedData['date'] = $post->to_date;
                $nestedData['mode'] = $post->subscribe_mode;
                $nestedData['product_name'] = $post->product_name;
                $nestedData['franchise'] = $post->franchise_name;

                if ($post->subscribe_status == '0') {
                    $nestedData['status'] = '<span class="badge badge-success shadow-success m-1">Active</span>';
                } elseif ($post->subscribe_status == '1') {
                    $nestedData['status'] = '<span class="badge badge-info shadow-info m-1">Puse</span>';
                } elseif ($post->subscribe_status == '2') {
                    $nestedData['status'] = '<span class="badge badge-danger shadow-danger m-1">End</span>';
                }

                if ($post->assign_to != '') {
                    $this->db->select('*');
                    $this->db->from('delivery_boy');
                    $this->db->where('db_id', $post->assign_to);
                    $query  = $this->db->get();
                    $result = $query->row();
                    $db_name = $result->name;

                    $nestedData['assign_to'] = $db_name;
                } else {
                    $nestedData['assign_to'] = '';
                }



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


    public function expire_subscription()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {

            $this->load->view('common/header');
            $this->load->view('sales/expire_subscription');
            $this->load->view('common/footer');
        }
    }


    //////////////////////////////////AJAX Expire SUBSCRIPTION LIST //////////////////////////

    public function ajax_expire_subscription_list()
    {

        $columns = array(
            0 => 'subscribe_id',
            1 => 'subscribe_generate_id',
            2 => 'customer',
            3 => 'date',
            4 => 'mode',
            5 => 'assign_to',
            6 => 'franchise',
            7 => 'action',


        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->sales_model->expire_supscription_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $posts = $this->sales_model->expire_supscription_list($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $posts =  $this->sales_model->expire_supscription_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->sales_model->expire_supscription_search_count($search);
        }

        $data = array();
        if (!empty($posts)) {
            $i = 1;
            foreach ($posts as $post) {

                $nestedData['subscribe_id'] = $i;
                $nestedData['subscribe_generate_id'] = '<a href="' . base_url('sales/view_subscripe_details?subscribe_id=' . $post->subscribe_id) . '">' . '#' . $post->subscribe_generate_id . '</a>';
                $nestedData['customer'] = $post->first_name . ' ' . $post->last_name;
                $nestedData['date'] = $post->to_date;
                $nestedData['mode'] = $post->subscribe_mode;
                $nestedData['address'] = $post->address;
                $nestedData['franchise'] = $post->franchise_name;


                if ($post->subscribe_status == '0') {
                    $nestedData['status'] = '<span class="badge badge-success shadow-success m-1">Active</span>';
                } elseif ($post->subscribe_status == '1') {
                    $nestedData['status'] = '<span class="badge badge-info shadow-info m-1">Puse</span>';
                } elseif ($post->subscribe_status == '2') {
                    $nestedData['status'] = '<span class="badge badge-danger shadow-danger m-1">End</span>';
                }

                if ($post->assign_to != '') {
                    $this->db->select('*');
                    $this->db->from('delivery_boy');
                    $this->db->where('db_id', $post->assign_to);
                    $query  = $this->db->get();
                    $result = $query->row();
                    $db_name = $result->name;

                    $nestedData['assign_to'] = $db_name;
                } else {
                    $nestedData['assign_to'] = '';
                }


                $nestedData['action'] = '<a href="' . base_url('sales/view_subscripe_details?subscribe_id=' . $post->subscribe_id) . '"><button type="button" class="btn btn-primary waves-effect waves-light m-1"> <i class="fa fa-eye"> View</i> </button> ';

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


    public function total_payment()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['total_payment'] = $this->sales_model->get_sum_total_model();
            $data['cash_payment'] = $this->sales_model->get_sum_cash_model();
            $data['online_payment'] = $this->sales_model->get_sum_online_model();
            $data['refund_payment'] = $this->sales_model->get_sum_refund_model();

            $this->load->view('common/header');
            $this->load->view('sales/total_payment', $data);
            $this->load->view('common/footer');
        }
    }




    //////////////////////////////////AJAX TOTAL Payment LIST //////////////////////////

    public function ajax_total_payment_list()
    {

        $columns = array(
            0 => 'order_id',
            1 => 'order_generate_id',
            2 => 'count_product',
            3 => 'customer_id',
            4 => 'order_total',
            5 => 'p_mode',
            6 => 'franchise',
            7 => 'action',


        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->sales_model->deliver_order_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $posts = $this->sales_model->deliver_order_list($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $posts =  $this->sales_model->deliver_order_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->sales_model->deliver_order_search_count($search);
        }

        $data = array();
        if (!empty($posts)) {
            $i = 1;
            foreach ($posts as $post) {

                $nestedData['order_id'] = $i;
                $nestedData['order_generate_id'] = '#' . $post->order_generate_id;
                $nestedData['customer_id'] = $post->first_name . ' ' . $post->last_name;
                $nestedData['order_total'] = $post->order_total;
                $nestedData['franchise'] = $post->franchise_name;




                if ($post->p_mode == '0') {
                    $nestedData['p_mode'] = '<span class="badge badge-info shadow-info m-1">Cash</span>';
                } elseif ($post->p_mode == '1') {
                    $nestedData['p_mode'] = '<span class="badge badge-success shadow-success m-1">Online</span>';
                } elseif ($post->p_mode == '2') {
                    $nestedData['p_mode'] = '<span class="badge badge-warning shadow-warning m-1">Swipe machine</span>';
                } elseif ($post->p_mode == '3') {
                    $nestedData['p_mode'] = '<span class="badge badge-primary shadow-primary m-1">Wallet</span>';
                }




                $this->db->select('COUNT(order_id) AS no_of_product');
                $this->db->from('order_detail');
                $this->db->where('order_id', $post->order_id);
                $query  = $this->db->get();
                $result = $query->row();
                $no_of_product = $result->no_of_product;


                $nestedData['count_product'] = $no_of_product;

                $nestedData['action'] = '';

                $nestedData['action'] = ' <div class="btn-group m-1" role="group">
                                              <button type="button" class="btn btn-dark   waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                              </button>
                                              <div class="dropdown-menu">
                                                <a href="' . base_url('sales/view_invoice?order_id=' . $post->order_generate_id) . '" class="dropdown-item"><i aria-hidden="true" class="fa fa-eye"></i> View</a>
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


    public function cash_payment()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['total_payment'] = $this->sales_model->get_sum_total_model();
            $data['cash_payment'] = $this->sales_model->get_sum_cash_model();
            $data['online_payment'] = $this->sales_model->get_sum_online_model();
            $data['refund_payment'] = $this->sales_model->get_sum_refund_model();

            $this->load->view('common/header');
            $this->load->view('sales/cash_payment', $data);
            $this->load->view('common/footer');
        }
    }




    //////////////////////////////////AJAX TOTAL Payment LIST //////////////////////////

    public function ajax_cash_payment_list()
    {

        $columns = array(
            0 => 'order_id',
            1 => 'order_generate_id',
            2 => 'count_product',
            3 => 'customer_id',
            4 => 'order_total',
            5 => 'p_mode',
            6 => 'franchise',
            7 => 'action',


        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->sales_model->cash_payment_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $posts = $this->sales_model->cash_payment_list($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $posts =  $this->sales_model->cash_payment_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->sales_model->cash_payment_search_count($search);
        }

        $data = array();
        if (!empty($posts)) {
            $i = 1;
            foreach ($posts as $post) {

                $nestedData['order_id'] = $i;
                $nestedData['order_generate_id'] = '#' . $post->order_generate_id;
                $nestedData['customer_id'] = $post->first_name . ' ' . $post->last_name;
                $nestedData['order_total'] = $post->order_total;
                $nestedData['franchise'] = $post->franchise_name;




                if ($post->p_mode == '0') {
                    $nestedData['p_mode'] = '<span class="badge badge-info shadow-info m-1">Cash</span>';
                } elseif ($post->p_mode == '1') {
                    $nestedData['p_mode'] = '<span class="badge badge-success shadow-success m-1">Online</span>';
                } elseif ($post->p_mode == '2') {
                    $nestedData['p_mode'] = '<span class="badge badge-warning shadow-warning m-1">Swipe machine</span>';
                } elseif ($post->p_mode == '3') {
                    $nestedData['p_mode'] = '<span class="badge badge-primary shadow-primary m-1">Wallet</span>';
                }



                $this->db->select('COUNT(order_id) AS no_of_product');
                $this->db->from('order_detail');
                $this->db->where('order_id', $post->order_id);
                $query  = $this->db->get();
                $result = $query->row();
                $no_of_product = $result->no_of_product;


                $nestedData['count_product'] = $no_of_product;

                $nestedData['action'] = '';

                $nestedData['action'] = ' <div class="btn-group m-1" role="group">
                                              <button type="button" class="btn btn-dark   waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                              </button>
                                              <div class="dropdown-menu">
                                                <a href="' . base_url('sales/view_invoice?order_id=' . $post->order_generate_id) . '" class="dropdown-item"><i aria-hidden="true" class="fa fa-eye"></i> View</a>
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


    public function online_payment()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['total_payment'] = $this->sales_model->get_sum_total_model();
            $data['cash_payment'] = $this->sales_model->get_sum_cash_model();
            $data['online_payment'] = $this->sales_model->get_sum_online_model();
            $data['refund_payment'] = $this->sales_model->get_sum_refund_model();

            $this->load->view('common/header');
            $this->load->view('sales/online_payment', $data);
            $this->load->view('common/footer');
        }
    }




    //////////////////////////////////AJAX Online Payment LIST //////////////////////////

    public function ajax_online_payment_list()
    {

        $columns = array(
            0 => 'order_id',
            1 => 'order_generate_id',
            2 => 'count_product',
            3 => 'customer_id',
            4 => 'order_total',
            5 => 'p_mode',
            6 => 'franchise',
            7 => 'action',


        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->sales_model->online_payment_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $posts = $this->sales_model->online_payment_list($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $posts =  $this->sales_model->online_payment_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->sales_model->online_payment_search_count($search);
        }

        $data = array();
        if (!empty($posts)) {
            $i = 1;
            foreach ($posts as $post) {

                $nestedData['order_id'] = $i;
                $nestedData['order_generate_id'] = '#' . $post->order_generate_id;
                $nestedData['customer_id'] = $post->first_name . ' ' . $post->last_name;
                $nestedData['order_total'] = $post->order_total;
                $nestedData['franchise'] = $post->franchise_name;




                if ($post->p_mode == '0') {
                    $nestedData['p_mode'] = '<span class="badge badge-info shadow-info m-1">Cash</span>';
                } elseif ($post->p_mode == '1') {
                    $nestedData['p_mode'] = '<span class="badge badge-success shadow-success m-1">Online</span>';
                } elseif ($post->p_mode == '2') {
                    $nestedData['p_mode'] = '<span class="badge badge-warning shadow-warning m-1">Swipe machine</span>';
                } elseif ($post->p_mode == '3') {
                    $nestedData['p_mode'] = '<span class="badge badge-primary shadow-primary m-1">Wallet</span>';
                }



                $this->db->select('COUNT(order_id) AS no_of_product');
                $this->db->from('order_detail');
                $this->db->where('order_id', $post->order_id);
                $query  = $this->db->get();
                $result = $query->row();
                $no_of_product = $result->no_of_product;


                $nestedData['count_product'] = $no_of_product;

                $nestedData['action'] = '';

                $nestedData['action'] = ' <div class="btn-group m-1" role="group">
                                              <button type="button" class="btn btn-dark   waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                              </button>
                                              <div class="dropdown-menu">
                                                <a href="' . base_url('sales/view_invoice?order_id=' . $post->order_generate_id) . '" class="dropdown-item"><i aria-hidden="true" class="fa fa-eye"></i> View</a>
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



    public function refund_payment()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['total_payment'] = $this->sales_model->get_sum_total_model();
            $data['cash_payment'] = $this->sales_model->get_sum_cash_model();
            $data['online_payment'] = $this->sales_model->get_sum_online_model();
            $data['refund_payment'] = $this->sales_model->get_sum_refund_model();

            $this->load->view('common/header');
            $this->load->view('sales/refund_payment', $data);
            $this->load->view('common/footer');
        }
    }



    //////////////////////////////////AJAX Refund Payment LIST //////////////////////////

    public function ajax_refund_payment_list()
    {

        $columns = array(
            0 => 'order_id',
            1 => 'order_generate_id',
            2 => 'count_product',
            3 => 'customer_id',
            4 => 'order_total',
            5 => 'p_mode',
            6 => 'franchise',
            7 => 'action',


        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->sales_model->refund_payment_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $posts = $this->sales_model->refund_payment_list($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $posts =  $this->sales_model->refund_payment_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->sales_model->refund_payment_search_count($search);
        }

        $data = array();
        if (!empty($posts)) {
            $i = 1;
            foreach ($posts as $post) {

                $nestedData['order_id'] = $i;
                $nestedData['order_generate_id'] = '#' . $post->order_generate_id;
                $nestedData['customer_id'] = $post->first_name . ' ' . $post->last_name;
                $nestedData['order_total'] = $post->order_total;
                $nestedData['franchise'] = $post->franchise_name;




                if ($post->refund_status == '') {
                    $nestedData['p_mode'] = '';
                } elseif ($post->refund_status == '1') {
                    $nestedData['p_mode'] = '<span class="badge badge-success shadow-success m-1">Refunded</span>';
                }



                $this->db->select('COUNT(order_id) AS no_of_product');
                $this->db->from('order_detail');
                $this->db->where('order_id', $post->order_id);
                $query  = $this->db->get();
                $result = $query->row();
                $no_of_product = $result->no_of_product;


                $nestedData['count_product'] = $no_of_product;

                $nestedData['action'] = '';

                $nestedData['action'] = ' <div class="btn-group m-1" role="group">
                                              <button type="button" class="btn btn-dark   waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                              </button>
                                              <div class="dropdown-menu">
                                                <a href="' . base_url('sales/view_invoice?order_id=' . $post->order_generate_id) . '" class="dropdown-item"><i aria-hidden="true" class="fa fa-eye"></i> View</a>
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



    public function invoice()
    {
        $this->load->library('Pdf');
        ob_start();

        $order_id  = $this->uri->segment(3);



        $invoice_no = 'Invoice No : #' . $order_id . '';

        $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        //set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('https://vegshopy.com/');
        $pdf->SetTitle($invoice_no);
        $pdf->SetSubject('Report generated using Codeigniter and TCPDF');
        $pdf->SetKeywords('TCPDF, PDF, MySQL, Codeigniter');

        //$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_RIGHT);

        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        //$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->SetFont('helvetica', '', 8);

        // set font
        //$pdf->SetFont('timesb', 'BI',8);


        $filename = time() . $invoice_no;

        $data['order_summary'] = $this->product_model->get_order_summary($order_id);


        //echo "<pre>";print_r($data);die();

        $html = $this->load->view('sales/invoice_pdf', $data, true);

        //$html =$this->load->view('client/residence_form_pdf.php',true);

        $pdf->AddPage();

        // output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        // reset pointer to the last page
        $pdf->lastPage();
        ob_end_clean();
        //Close and output PDF document
        $pdf->Output($invoice_no . 'pdf', 'I');
    }



    //////////////////////////////// Order Export in Excel  ///////////////////////////////////////////////////// 

    public function download_excel()
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

        $currdate = date('d-m-Y');
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:C1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Today Order List (' . $currdate . ')');


        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($top_header_style);



        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Sr.No');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'Product Name');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'Unit');
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'Qty');



        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);



        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);




        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

        $row = 3;
        $order_list  = $this->sales_model->get_export_order_data();
        //echo "<pre>";print_r($order_list);exit;
        if (is_array($order_list) || is_object($order_list)) {
            $i = 1;
            foreach ($order_list as $value) {




                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $i++);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value->product_name);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value->unit);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value->qty);

                $row++;
            }
        }
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Order list.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }


    //////////////////////////////// Order Export in Excel  ///////////////////////////////////////////////////// 

    public function download_excel_sales_report()
    {
        $from_date  = $this->input->post('from_date');
        $to_date  = $this->input->post('to_date');

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


        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:N1');
        if ($from_date == '' && $to_date == '') {
            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Today Order List');
        } else {
            $objPHPExcel->getActiveSheet()->setCellValue('A1', date("d-m-Y", strtotime($from_date)) . ' To ' . date("d-m-Y", strtotime($to_date)) . ' Order List');
        }

        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('I1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('J1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('K1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('L1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('M1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('N1')->applyFromArray($top_header_style);


        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Order id');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'Customer name');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'Mobile no');
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'Delivery address');
        $objPHPExcel->getActiveSheet()->setCellValue('E2', 'No of product');
        $objPHPExcel->getActiveSheet()->setCellValue('F2', 'Product');
        $objPHPExcel->getActiveSheet()->setCellValue('G2', 'Amount');
        $objPHPExcel->getActiveSheet()->setCellValue('H2', 'Assign order');
        $objPHPExcel->getActiveSheet()->setCellValue('I2', 'Payment mode');
        $objPHPExcel->getActiveSheet()->setCellValue('J2', 'Payment Status');
        $objPHPExcel->getActiveSheet()->setCellValue('K2', 'Order Status');
        $objPHPExcel->getActiveSheet()->setCellValue('L2', 'Order Date');
        $objPHPExcel->getActiveSheet()->setCellValue('M2', 'Slot');
        $objPHPExcel->getActiveSheet()->setCellValue('N2', 'Saller');



        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('I2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('J2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('K2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('L2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('M2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('N2')->applyFromArray($style_header);


        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(25);



        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

        $row = 3;
        $order_list  = $this->sales_model->get_export_order_data1($from_date, $to_date);
        //echo "<pre>";print_r($order_list);exit;
        if (is_array($order_list) || is_object($order_list)) {
            foreach ($order_list as $value) {

                $this->db->select('COUNT(order_id) AS no_of_product');
                $this->db->from('order_detail');
                $this->db->where('order_id', $value->order_id);
                $query  = $this->db->get();
                $result = $query->row();
                $no_of_product = $result->no_of_product;

                if ($value->assign_to != '') {
                    $this->db->select('*');
                    $this->db->from('delivery_boy');
                    $this->db->where('db_id', $value->assign_to);
                    $query  = $this->db->get();
                    $result = $query->row();
                    $db_name = $result->name;

                    $assign_to = $db_name;
                } else {
                    $assign_to = '';
                }


                if ($value->status == '0') {
                    $order_status = 'Pending';
                } elseif ($value->status == '1') {
                    $order_status = 'Confirm';
                } elseif ($value->status == '2') {
                    $order_status = 'Dispatch';
                } elseif ($value->status == '3') {
                    $order_status = 'Delivered';
                } elseif ($value->status == '4') {
                    $order_status = 'Cancel';
                }


                if ($value->payment_status == '0') {
                    $payment_status = 'Unpaid';
                } elseif ($value->payment_status == '1') {
                    $payment_status = 'Paid';
                }


                if ($value->p_mode == '0') {
                    $payment_mode = 'Cash on delivery';
                } elseif ($value->p_mode == '1') {
                    $payment_mode = 'Online';
                } elseif ($value->p_mode == '3') {
                    $payment_mode = 'Wallet';
                }

                if ($value->slot_id != '') {
                    $this->db->select('*');
                    $this->db->from('slot_timing');
                    $this->db->where('slot_id', $value->slot_id);
                    $query44  = $this->db->get();
                    $result44 = $query44->row();
                    $day = $result44->day;
                    $slot_timing = $result44->slot_timing;

                    $slot = $day . ' ' . $slot_timing;
                } else {
                    $slot = '';
                }



                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, '#' . $value->order_generate_id);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value->first_name . '  ' . $value->last_name);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value->mobile_no);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value->deliver_address);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $no_of_product);

                $order_list1  = $this->product_model->get_item_details($value->order_id);

                $product_name = array();
                foreach ($order_list1 as $r) {

                    $product_name[] = $r->product_name . ' ' . 'Qty' . '(' . $r->qty . ')';
                }
                $product_name = json_encode($product_name);

                $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $product_name);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $value->order_total);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $assign_to);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $payment_mode);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $payment_status);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $order_status);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $value->order_date);
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $row, $slot);
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $row, $value->franchise_name);


                $row++;
            }
        }
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Order list.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
    /****************************** Bulk Assign Order **************/

    public function bulk_assign_order()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['all_delivery_boy'] = $this->customer_model->get_all_db_model();
            $this->load->view('common/header');
            $this->load->view('sales/bulk_assign_order', $data);
            $this->load->view('common/footer');
        }
    }



    public function download_sales_excel()
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


        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:H1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Pending Order List');

        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($top_header_style);


        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Order id');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'Generated id');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'Customer name');
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'Mobile no');
        $objPHPExcel->getActiveSheet()->setCellValue('E2', 'Delivery address');
        $objPHPExcel->getActiveSheet()->setCellValue('F2', 'No of product');
        $objPHPExcel->getActiveSheet()->setCellValue('G2', 'Product');
        $objPHPExcel->getActiveSheet()->setCellValue('H2', 'Amount');



        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->applyFromArray($style_header);


        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(60);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);



        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

        $row = 3;
        $order_list  = $this->sales_model->pending_order_list1();
        // echo "<pre>";print_r($order_list);exit;
        if (is_array($order_list) || is_object($order_list)) {
            foreach ($order_list as $value) {

                $this->db->select('COUNT(order_id) AS no_of_product');
                $this->db->from('order_detail');
                $this->db->where('order_id', $value->order_id);
                $query  = $this->db->get();
                $result = $query->row();
                $no_of_product = $result->no_of_product;


                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $value->order_id);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, '#' . $value->order_generate_id);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value->first_name . '  ' . $value->last_name);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value->mobile_no);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $value->deliver_address);
                $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $no_of_product);

                $order_list1  = $this->product_model->get_item_details($value->order_id);

                $product_name = array();
                foreach ($order_list1 as $r) {

                    $product_name[] = $r->product_name . ' ' . 'Qty' . '(' . $r->qty . ')';
                }
                $product_name = json_encode($product_name);

                $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $product_name);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $value->order_total);



                $row++;
            }
        }
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="pending_order.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }



    /************************************ (Import) **********************************************************
     ***************************************************************************************************************/

    public function import_bulk_assign_order_data()
    {
        $this->load->library('Excel');

        $errors   = array();
        $message  = '';
        $redirect = '';

        $this->form_validation->set_rules('assign_to', 'delivry boy', 'required');

        $this->form_validation->set_message('required', '* Please select %s');


        $assign_to  = $this->input->post('assign_to');
        $current_date = date('m/d/Y');

        if ($this->form_validation->run() == TRUE) {

            if (isset($_FILES["file"]["name"])) {
                $path = $_FILES["file"]["tmp_name"];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $worksheet) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for ($row = 3; $row <= $highestRow; $row++) {
                        $order_id           = $worksheet->getCellByColumnAndRow(0, $row)->getValue();


                        $data11 = array(
                            'assign_to'      => $assign_to,
                            'assign_date'      => $current_date,
                        );

                        $this->db->where('order_id', $order_id)->update('product_order', $data11);
                    }
                }




                $status = 'success';
                $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Bulk!</strong> assign order successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

                $this->session->set_flashdata('message', $message);
                $redirect = base_url('sales/total_sales');
            }
        } else {
            $status = 'error';
            if (form_error('assign_to')) {
                $errors['assign_toError'] = form_error('assign_to');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }


    public function monthly_total_sales()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['order_list'] = $this->sales_model->get_monthly_total_sales_model();
            $data['all_delivery_boy'] = $this->customer_model->get_all_db_model();

            $this->load->view('common/header');
            $this->load->view('sales/monthly_total_sales', $data);
            $this->load->view('common/footer');
        }
    }


    public function monthly_pending_total_sales()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['all_delivery_boy'] = $this->customer_model->get_all_db_model();
            $data['order_list'] = $this->sales_model->get_monthly_pending_total_sales_model();

            $this->load->view('common/header');
            $this->load->view('sales/monthly_pending_total_sales', $data);
            $this->load->view('common/footer');
        }
    }


    public function monthly_assign_sales()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['order_list'] = $this->sales_model->get_monthly_assign_sales_model();

            $this->load->view('common/header');
            $this->load->view('sales/monthly_assign_sales', $data);
            $this->load->view('common/footer');
        }
    }



    public function monthly_delivered_sales()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['order_list'] = $this->sales_model->get_monthly_deliverd_sales_model();

            $this->load->view('common/header');
            $this->load->view('sales/monthly_delivered_sales', $data);
            $this->load->view('common/footer');
        }
    }


    public function monthly_not_delivered_sales()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['order_list'] = $this->sales_model->get_monthly_not_deliverd_sales_model();

            $this->load->view('common/header');
            $this->load->view('sales/monthly_not_delivered_sales', $data);
            $this->load->view('common/footer');
        }
    }


    public function monthly_cancel_sales()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['order_list'] = $this->sales_model->get_monthly_cancel_sales_model();

            $this->load->view('common/header');
            $this->load->view('sales/monthly_cancel_sales', $data);
            $this->load->view('common/footer');
        }
    }



    public function cash_payment_today()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['cash_payment'] = $this->sales_model->get_cash_payment_model();

            $this->load->view('common/header');
            $this->load->view('sales/cash_payment_today', $data);
            $this->load->view('common/footer');
        }
    }



    public function online_payment_today()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['online_payment'] = $this->sales_model->get_online_payment_model();

            $this->load->view('common/header');
            $this->load->view('sales/online_payment_today', $data);
            $this->load->view('common/footer');
        }
    }


    public function cancel_bill_amount()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['online_payment'] = $this->sales_model->get_cancel_bill_amount_model();

            $this->load->view('common/header');
            $this->load->view('sales/cancel_bill_amount', $data);
            $this->load->view('common/footer');
        }
    }



    public function saller_wise_bussiness_download_excel()
    {
        $from_date  = $this->input->post('from_date');
        $to_date  = $this->input->post('to_date');
        $saller_id  = $this->input->post('saller_id');


        $this->db->select('*');
        $this->db->from('saller');
        $this->db->where('saller_id', $saller_id);
        $query  = $this->db->get();
        $result = $query->row();
        $saller_name = $result->saller_name;


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


        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:N1');
        if ($from_date == '' && $to_date == '') {
            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Today Order List');
        } else {
            $objPHPExcel->getActiveSheet()->setCellValue('A1', date("d-m-Y", strtotime($from_date)) . ' To ' . date("d-m-Y", strtotime($to_date)) . ' Total Bussiness');
        }

        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('I1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('J1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('K1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('L1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('M1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('N1')->applyFromArray($top_header_style);


        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Order id');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'Customer name');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'Mobile no');
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'Delivery address');
        $objPHPExcel->getActiveSheet()->setCellValue('E2', 'No of product');
        $objPHPExcel->getActiveSheet()->setCellValue('F2', 'Product');
        $objPHPExcel->getActiveSheet()->setCellValue('G2', 'Amount');
        $objPHPExcel->getActiveSheet()->setCellValue('H2', 'Assign order');
        $objPHPExcel->getActiveSheet()->setCellValue('I2', 'Payment mode');
        $objPHPExcel->getActiveSheet()->setCellValue('J2', 'Payment Status');
        $objPHPExcel->getActiveSheet()->setCellValue('K2', 'Order Status');
        $objPHPExcel->getActiveSheet()->setCellValue('L2', 'Order Date');
        $objPHPExcel->getActiveSheet()->setCellValue('M2', 'Saller Name');
        $objPHPExcel->getActiveSheet()->setCellValue('N2', 'Franchise');



        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('I2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('J2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('K2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('L2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('M2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('N2')->applyFromArray($style_header);


        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(25);



        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

        $row = 3;
        $order_list  = $this->sales_model->saller_wise_sales_report($from_date, $to_date, $saller_id);
        // echo "<pre>";print_r($order_list);exit;
        if (is_array($order_list) || is_object($order_list)) {
            foreach ($order_list as $value) {

                $this->db->select('COUNT(order_id) AS no_of_product');
                $this->db->from('order_detail');
                $this->db->where('order_id', $value->order_id);
                $query  = $this->db->get();
                $result = $query->row();
                $no_of_product = $result->no_of_product;

                if ($value->assign_to != '') {
                    $this->db->select('*');
                    $this->db->from('delivery_boy');
                    $this->db->where('db_id', $value->assign_to);
                    $query  = $this->db->get();
                    $result = $query->row();
                    $db_name = $result->name;

                    $assign_to = $db_name;
                } else {
                    $assign_to = '';
                }


                if ($value->status == '0') {
                    $order_status = 'Pending';
                } elseif ($value->status == '1') {
                    $order_status = 'Confirm';
                } elseif ($value->status == '2') {
                    $order_status = 'Dispatch';
                } elseif ($value->status == '3') {
                    $order_status = 'Delivered';
                } elseif ($value->status == '4') {
                    $order_status = 'Cancel';
                }


                if ($value->payment_status == '0') {
                    $payment_status = 'Unpaid';
                } elseif ($value->payment_status == '1') {
                    $payment_status = 'Paid';
                }


                if ($value->p_mode == '0') {
                    $payment_mode = 'Cash on delivery';
                } elseif ($value->p_mode == '1') {
                    $payment_mode = 'Online';
                } elseif ($value->p_mode == '3') {
                    $payment_mode = 'Wallet';
                }



                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, '#' . $value->order_generate_id);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value->first_name . '  ' . $value->last_name);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value->mobile_no);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value->deliver_address);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $no_of_product);

                $order_list1  = $this->product_model->get_item_details($value->order_id);

                $product_name = array();
                foreach ($order_list1 as $r) {

                    $product_name[] = $r->product_name . ' ' . 'Qty' . '(' . $r->qty . ')';
                }
                $product_name = json_encode($product_name);

                $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $product_name);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $value->order_total);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $assign_to);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $payment_mode);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $payment_status);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $order_status);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $value->order_date);
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $row, $saller_name);
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $row, $value->franchise_name);


                $row++;
            }
        }
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Saller bussiness report.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }


    public function saller_wise_commission_download_excel()
    {
        $from_date  = $this->input->post('from_date');
        $to_date  = $this->input->post('to_date');
        $saller_id  = $this->input->post('saller_id');


        $this->db->select('*');
        $this->db->from('saller');
        $this->db->where('saller_id', $saller_id);
        $query  = $this->db->get();
        $result = $query->row();
        $saller_name = $result->saller_name;
        $commission = $result->commission;

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


        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:O1');
        if ($from_date == '' && $to_date == '') {
            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Today Order List');
        } else {
            $objPHPExcel->getActiveSheet()->setCellValue('A1', date("d-m-Y", strtotime($from_date)) . ' To ' . date("d-m-Y", strtotime($to_date)) . ' Total Commission');
        }

        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('I1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('J1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('K1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('L1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('M1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('N1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('O1')->applyFromArray($top_header_style);


        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Order id');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'Customer name');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'Mobile no');
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'Delivery address');
        $objPHPExcel->getActiveSheet()->setCellValue('E2', 'No of product');
        $objPHPExcel->getActiveSheet()->setCellValue('F2', 'Product');
        $objPHPExcel->getActiveSheet()->setCellValue('G2', 'Amount');
        $objPHPExcel->getActiveSheet()->setCellValue('H2', 'Commission');
        $objPHPExcel->getActiveSheet()->setCellValue('I2', 'Assign order');
        $objPHPExcel->getActiveSheet()->setCellValue('J2', 'Payment mode');
        $objPHPExcel->getActiveSheet()->setCellValue('K2', 'Payment Status');
        $objPHPExcel->getActiveSheet()->setCellValue('L2', 'Order Status');
        $objPHPExcel->getActiveSheet()->setCellValue('M2', 'Order Date');
        $objPHPExcel->getActiveSheet()->setCellValue('N2', 'Saller Name');
        $objPHPExcel->getActiveSheet()->setCellValue('O2', 'Saller Name');



        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('I2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('J2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('K2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('L2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('M2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('N2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('O2')->applyFromArray($style_header);


        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(25);



        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

        $row = 3;
        $order_list  = $this->sales_model->saller_wise_sales_report($from_date, $to_date, $saller_id);
        // echo "<pre>";print_r($order_list);exit;
        if (is_array($order_list) || is_object($order_list)) {
            foreach ($order_list as $value) {

                $this->db->select('COUNT(order_id) AS no_of_product');
                $this->db->from('order_detail');
                $this->db->where('order_id', $value->order_id);
                $query  = $this->db->get();
                $result = $query->row();
                $no_of_product = $result->no_of_product;

                if ($value->assign_to != '') {
                    $this->db->select('*');
                    $this->db->from('delivery_boy');
                    $this->db->where('db_id', $value->assign_to);
                    $query  = $this->db->get();
                    $result = $query->row();
                    $db_name = $result->name;

                    $assign_to = $db_name;
                } else {
                    $assign_to = '';
                }


                if ($value->status == '0') {
                    $order_status = 'Pending';
                } elseif ($value->status == '1') {
                    $order_status = 'Confirm';
                } elseif ($value->status == '2') {
                    $order_status = 'Dispatch';
                } elseif ($value->status == '3') {
                    $order_status = 'Delivered';
                } elseif ($value->status == '4') {
                    $order_status = 'Cancel';
                }


                if ($value->payment_status == '0') {
                    $payment_status = 'Unpaid';
                } elseif ($value->payment_status == '1') {
                    $payment_status = 'Paid';
                }


                if ($value->p_mode == '0') {
                    $payment_mode = 'Cash on delivery';
                } elseif ($value->p_mode == '1') {
                    $payment_mode = 'Online';
                } elseif ($value->p_mode == '3') {
                    $payment_mode = 'Wallet';
                }

                $credit_amount1 = round(($commission / 100) * $value->order_total);
                $credit_amount = $credit_amount1;

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, '#' . $value->order_generate_id);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value->first_name . '  ' . $value->last_name);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value->mobile_no);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value->deliver_address);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $no_of_product);

                $order_list1  = $this->product_model->get_item_details($value->order_id);

                $product_name = array();
                foreach ($order_list1 as $r) {

                    $product_name[] = $r->product_name . ' ' . 'Qty' . '(' . $r->qty . ')';
                }
                $product_name = json_encode($product_name);

                $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $product_name);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $value->order_total);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $credit_amount);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $assign_to);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $payment_mode);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $payment_status);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $order_status);
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $row, $value->order_date);
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $row, $saller_name);
                $objPHPExcel->getActiveSheet()->setCellValue('O' . $row, $value->franchise_name);


                $row++;
            }
        }
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Saller Commission report.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }



    public function today_subscription_order()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $data['order_list'] = $this->sales_model->get_today_subscription_order_model();

            //print_r($data['order_list']);exit;

            $this->load->view('common/header');
            $this->load->view('sales/today_subscription_order', $data);
            $this->load->view('common/footer');
        }
    }



    function assign_subscription_data()

    {


        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('assign_to', ' delivery boy', 'required');
        $this->form_validation->set_message('required', '* Please select %s');

        $assign_to  = $this->input->post('assign_to');

        $multiple_id  = $this->input->post('multiple_id');

        if ($this->form_validation->run() == TRUE) {

            $subscribe_id = explode(",", $multiple_id);
            $i = 0;
            foreach ($subscribe_id as $subscribe_id) {
                $update_data = array(
                    'assign_to'                => $assign_to,

                );

                $this->db->where('subscribe_id', $subscribe_id)->update('subscription', $update_data);

                $i++;
            }

            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Assign subscription!</strong>  successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('sales/subscription');
        } else {
            $status = 'error';
            if (form_error('assign_to')) {
                $errors['assign_toError'] = form_error('assign_to');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }



    function assign_order_data()

    {


        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('assign_to', ' delivery boy', 'required');
        $this->form_validation->set_message('required', '* Please select %s');

        $current_date = date('Y-m-d h:i:A');
        $assign_to  = $this->input->post('assign_to');

        $multiple_id  = $this->input->post('multiple_id');

        if ($this->form_validation->run() == TRUE) {

            $order_id = explode(",", $multiple_id);
            $i = 0;
            foreach ($order_id as $order_id) {
                $update_data = array(
                    'assign_to'                => $assign_to,
                    'assign_date'                => $current_date,

                );

                $this->db->where('order_id', $order_id)->update('product_order', $update_data);

                $i++;
            }

            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Assign order!</strong>  successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('sales/total_sales');
        } else {
            $status = 'error';
            if (form_error('assign_to')) {
                $errors['assign_toError'] = form_error('assign_to');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }




    function settle_refund_data()

    {


        $errors   = array();
        $message  = '';
        $redirect = '';


        $payment_mode   = $this->input->post('payment_mode');


        $amount_cash    = $this->input->post('amount_cash');
        $cheque_amount  = $this->input->post('cheque_amount');
        $neft_amount    = $this->input->post('neft_amount');
        $imps_amount    = $this->input->post('imps_amount');


        $neft_transaction_id  = $this->input->post('neft_transaction_id');
        $imps_transaction_id  = $this->input->post('imps_transaction_id');

        $pay_date       = $this->input->post('pay_date');
        $cheque_pay_date = $this->input->post('cheque_pay_date');
        $neft_pay_date   = $this->input->post('neft_pay_date');
        $imps_pay_date   = $this->input->post('imps_pay_date');


        $cheque_no      = $this->input->post('cheque_no');
        $Cheque_date    = $this->input->post('Cheque_date');
        $bank_name      = $this->input->post('bank_name');
        $bank_branch    = $this->input->post('branch');

        if ($payment_mode == 'Cash') {
            $amount = $amount_cash;
        } else if ($payment_mode == 'Cheque') {
            $amount = $cheque_amount;
        } else if ($payment_mode == 'Neft') {
            $amount = $neft_amount;
        } else if ($payment_mode == 'IMPS') {
            $amount = $imps_amount;
        }



        if ($payment_mode == 'Cash') {
            $transaction_id = '';
        } else if ($payment_mode == 'Cheque') {
            $transaction_id = '';
        } elseif ($payment_mode == 'Neft') {
            $transaction_id = $neft_transaction_id;
        } else if ($payment_mode == 'IMPS') {
            $transaction_id = $imps_transaction_id;
        }



        if ($payment_mode == 'Cash') {
            $date1 = $pay_date;
            $date  = date("d-m-Y", strtotime($date1));
        } else if ($payment_mode == 'Cheque') {
            $date1 = $cheque_pay_date;
            $date  = date("d-m-Y", strtotime($date1));
        } else if ($payment_mode == 'Neft') {
            $date1 = $neft_pay_date;
            $date  = date("d-m-Y", strtotime($date1));
        } else if ($payment_mode == 'IMPS') {
            $date1 = $imps_pay_date;
            $date  = date("d-m-Y", strtotime($date1));
        }

        $multiple_id  = $this->input->post('multiple_id');



        $order_id = explode(",", $multiple_id);
        $i = 0;
        foreach ($order_id as $order_id) {
            $update_data = array(
                'refund_status'                => '1',

            );

            $this->db->where('order_id', $order_id)->update('product_order', $update_data);


            $regData = array(
                'order_id' => $order_id,
                'payment_mode' => $payment_mode,
                'paid_amount'  => $amount,
                'pay_date'  => $date,
                'cheque_no'  => $cheque_no,
                'Cheque_date'  => $Cheque_date,
                'bank_name'  => $bank_name,
                'transaction_id'  => $transaction_id,

            );

            //print_r($regData);exit;

            $this->db->insert('sattel_payment', $regData);

            // echo $this->db->last_query();exit();





            $i++;
        }

        $status = 'success';
        $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Refund settel!</strong>  successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

        $this->session->set_flashdata('message', $message);
        $redirect = base_url('sales/cancel_sales');


        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }



    public function download_product_wise_excel()
    {
        $from_date  = $this->input->post('from_date');
        $to_date  = $this->input->post('to_date');



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


        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:E1');

        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Product Wise Sale');


        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($top_header_style);



        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Product id');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'Product name');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'No of sale');
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'Qty');
        $objPHPExcel->getActiveSheet()->setCellValue('E2', 'Saller');




        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_header);



        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(60);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);




        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

        $row = 3;
        $order_list  = $this->sales_model->product_wise_report($from_date, $to_date);
        // echo "<pre>";print_r($order_list);exit;
        if (is_array($order_list) || is_object($order_list)) {
            foreach ($order_list as $value) {
                $CI = &get_instance();
                $CI->load->model('Sales_model');
                $result = $CI->sales_model->product_id_wise_count($value->product_id, $from_date, $to_date);
                $result1 = $CI->sales_model->product_id_wise_qty_count($value->product_id, $from_date, $to_date);
                $aa = $result->total_product;
                $bb = $result1->total_qty;



                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, $value->product_id);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value->product_name);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $aa);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $bb);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $value->franchise_name);


                $row++;
            }
        }
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Product wise sale report.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }



    //////////////////////////////// Order Export in Excel  ///////////////////////////////////////////////////// 

    public function download_total_order_excel()
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


        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:N1');

        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Total Order List');


        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('I1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('J1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('K1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('L1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('M1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('N1')->applyFromArray($top_header_style);


        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Order id');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'Customer name');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'Mobile no');
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'Delivery address');
        $objPHPExcel->getActiveSheet()->setCellValue('E2', 'No of product');
        $objPHPExcel->getActiveSheet()->setCellValue('F2', 'Product');
        $objPHPExcel->getActiveSheet()->setCellValue('G2', 'Amount');
        $objPHPExcel->getActiveSheet()->setCellValue('H2', 'Assign order');
        $objPHPExcel->getActiveSheet()->setCellValue('I2', 'Payment mode');
        $objPHPExcel->getActiveSheet()->setCellValue('J2', 'Payment Status');
        $objPHPExcel->getActiveSheet()->setCellValue('K2', 'Order Status');
        $objPHPExcel->getActiveSheet()->setCellValue('L2', 'Order Date');
        $objPHPExcel->getActiveSheet()->setCellValue('M2', 'Slot');
        $objPHPExcel->getActiveSheet()->setCellValue('N2', 'Saller');



        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('I2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('J2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('K2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('L2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('M2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('N2')->applyFromArray($style_header);


        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(25);



        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

        $row = 3;
        $order_list  = $this->sales_model->get_export_total_order_data();
        //echo "<pre>";print_r($order_list);exit;
        if (is_array($order_list) || is_object($order_list)) {
            foreach ($order_list as $value) {

                $this->db->select('COUNT(order_id) AS no_of_product');
                $this->db->from('order_detail');
                $this->db->where('order_id', $value->order_id);
                $query  = $this->db->get();
                $result = $query->row();
                $no_of_product = $result->no_of_product;

                if ($value->assign_to != '') {
                    $this->db->select('*');
                    $this->db->from('delivery_boy');
                    $this->db->where('db_id', $value->assign_to);
                    $query  = $this->db->get();
                    $result = $query->row();
                    $db_name = $result->name;

                    $assign_to = $db_name;
                } else {
                    $assign_to = '';
                }


                if ($value->status == '0') {
                    $order_status = 'Pending';
                } elseif ($value->status == '1') {
                    $order_status = 'Confirm';
                } elseif ($value->status == '2') {
                    $order_status = 'Dispatch';
                } elseif ($value->status == '3') {
                    $order_status = 'Delivered';
                } elseif ($value->status == '4') {
                    $order_status = 'Cancel';
                }


                if ($value->payment_status == '0') {
                    $payment_status = 'Unpaid';
                } elseif ($value->payment_status == '1') {
                    $payment_status = 'Paid';
                }


                if ($value->p_mode == '0') {
                    $payment_mode = 'Cash on delivery';
                } elseif ($value->p_mode == '1') {
                    $payment_mode = 'Online';
                } elseif ($value->p_mode == '3') {
                    $payment_mode = 'Wallet';
                }

                if ($value->slot_id != '') {
                    $this->db->select('*');
                    $this->db->from('slot_timing');
                    $this->db->where('slot_id', $value->slot_id);
                    $query44  = $this->db->get();
                    $result44 = $query44->row();
                    $day = $result44->day;
                    $slot_timing = $result44->slot_timing;

                    $slot = $day . ' ' . $slot_timing;
                } else {
                    $slot = '';
                }



                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, '#' . $value->order_generate_id);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value->first_name . '  ' . $value->last_name);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value->mobile_no);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value->deliver_address);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $no_of_product);

                $order_list1  = $this->product_model->get_item_details($value->order_id);

                $product_name = array();
                foreach ($order_list1 as $r) {

                    $product_name[] = $r->product_name . ' ' . 'Qty' . '(' . $r->qty . ')';
                }
                $product_name = json_encode($product_name);

                $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $product_name);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $value->order_total);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $assign_to);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $payment_mode);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $payment_status);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $order_status);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $value->order_date);
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $row, $slot);
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $row, $value->franchise_name);


                $row++;
            }
        }
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Total Order list.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }



    //////////////////////////////// Pending Order Export in Excel  ///////////////////////////////////////////////////// 

    public function download_pending_order_excel()
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


        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:N1');

        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Pending Order List');



        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('I1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('J1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('K1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('L1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('M1')->applyFromArray($top_header_style);
        $objPHPExcel->getActiveSheet()->getStyle('N1')->applyFromArray($top_header_style);


        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Order id');
        $objPHPExcel->getActiveSheet()->setCellValue('B2', 'Customer name');
        $objPHPExcel->getActiveSheet()->setCellValue('C2', 'Mobile no');
        $objPHPExcel->getActiveSheet()->setCellValue('D2', 'Delivery address');
        $objPHPExcel->getActiveSheet()->setCellValue('E2', 'No of product');
        $objPHPExcel->getActiveSheet()->setCellValue('F2', 'Product');
        $objPHPExcel->getActiveSheet()->setCellValue('G2', 'Amount');
        $objPHPExcel->getActiveSheet()->setCellValue('H2', 'Assign order');
        $objPHPExcel->getActiveSheet()->setCellValue('I2', 'Payment mode');
        $objPHPExcel->getActiveSheet()->setCellValue('J2', 'Payment Status');
        $objPHPExcel->getActiveSheet()->setCellValue('K2', 'Order Status');
        $objPHPExcel->getActiveSheet()->setCellValue('L2', 'Order Date');
        $objPHPExcel->getActiveSheet()->setCellValue('M2', 'Slot');
        $objPHPExcel->getActiveSheet()->setCellValue('N2', 'Saller');



        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('I2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('J2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('K2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('L2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('M2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('N2')->applyFromArray($style_header);


        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(25);



        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

        $row = 3;
        $order_list  = $this->sales_model->get_export_pending_order_data();
        //echo "<pre>";print_r($order_list);exit;
        if (is_array($order_list) || is_object($order_list)) {
            foreach ($order_list as $value) {

                $this->db->select('COUNT(order_id) AS no_of_product');
                $this->db->from('order_detail');
                $this->db->where('order_id', $value->order_id);
                $query  = $this->db->get();
                $result = $query->row();
                $no_of_product = $result->no_of_product;

                if ($value->assign_to != '') {
                    $this->db->select('*');
                    $this->db->from('delivery_boy');
                    $this->db->where('db_id', $value->assign_to);
                    $query  = $this->db->get();
                    $result = $query->row();
                    $db_name = $result->name;

                    $assign_to = $db_name;
                } else {
                    $assign_to = '';
                }


                if ($value->status == '0') {
                    $order_status = 'Pending';
                } elseif ($value->status == '1') {
                    $order_status = 'Confirm';
                } elseif ($value->status == '2') {
                    $order_status = 'Dispatch';
                } elseif ($value->status == '3') {
                    $order_status = 'Delivered';
                } elseif ($value->status == '4') {
                    $order_status = 'Cancel';
                }


                if ($value->payment_status == '0') {
                    $payment_status = 'Unpaid';
                } elseif ($value->payment_status == '1') {
                    $payment_status = 'Paid';
                }


                if ($value->p_mode == '0') {
                    $payment_mode = 'Cash on delivery';
                } elseif ($value->p_mode == '1') {
                    $payment_mode = 'Online';
                } elseif ($value->p_mode == '3') {
                    $payment_mode = 'Wallet';
                }


                $this->db->select('*');
                $this->db->from('slot_timing');
                $this->db->where('slot_id', $value->slot_id);
                $query44  = $this->db->get();
                $result44 = $query44->row();
                $day = $result44->day;
                $slot_timing = $result44->slot_timing;

                $slot = $day . ' ' . $slot_timing;



                $objPHPExcel->getActiveSheet()->setCellValue('A' . $row, '#' . $value->order_generate_id);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $row, $value->first_name . '  ' . $value->last_name);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $row, $value->mobile_no);
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $row, $value->deliver_address);
                $objPHPExcel->getActiveSheet()->setCellValue('E' . $row, $no_of_product);

                $order_list1  = $this->product_model->get_item_details($value->order_id);

                $product_name = array();
                foreach ($order_list1 as $r) {

                    $product_name[] = $r->product_name . ' ' . 'Qty' . '(' . $r->qty . ')';
                }
                $product_name = json_encode($product_name);

                $objPHPExcel->getActiveSheet()->setCellValue('F' . $row, $product_name);
                $objPHPExcel->getActiveSheet()->setCellValue('G' . $row, $value->order_total);
                $objPHPExcel->getActiveSheet()->setCellValue('H' . $row, $assign_to);
                $objPHPExcel->getActiveSheet()->setCellValue('I' . $row, $payment_mode);
                $objPHPExcel->getActiveSheet()->setCellValue('J' . $row, $payment_status);
                $objPHPExcel->getActiveSheet()->setCellValue('K' . $row, $order_status);
                $objPHPExcel->getActiveSheet()->setCellValue('L' . $row, $value->order_date);
                $objPHPExcel->getActiveSheet()->setCellValue('M' . $row, $slot);
                $objPHPExcel->getActiveSheet()->setCellValue('N' . $row, $value->franchise_name);


                $row++;
            }
        }
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Pending Order list.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }



    public function assign_sales()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $this->load->view('common/header');
            $this->load->view('sales/assign_sales');
            $this->load->view('common/footer');
        }
    }



    //////////////////////////////////AJAX ASSIGN ORDER LIST //////////////////////////


    public function ajax_assign_order_list()
    {

        $login_type   = $this->session->userdata('type');

        $columns = array(
            0 => 'order_id',
            1 => 'order_generate_id',
            2 => 'count_product',
            3 => 'customer_id',
            4 => 'order_total',
            5 => 'payment_status',
            6 => 'assign_to',
            7 => 'order_date',
            8 => 'franchise',
            9 => 'action',


        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->sales_model->assign_order_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $posts = $this->sales_model->assign_order_list($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $posts =  $this->sales_model->assign_order_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->sales_model->assign_order_search_count($search);
        }

        $data = array();
        if (!empty($posts)) {
            $i = 1;
            foreach ($posts as $post) {

                $nestedData['order_id'] = '<input type="checkbox" class="sub_chk" data-id="' . $post->order_id . '">';
                $nestedData['order_generate_id'] = '#' . $post->order_generate_id;
                $nestedData['customer_id'] = $post->first_name . ' ' . $post->last_name;
                $nestedData['order_total'] = $post->order_total;
                $nestedData['address'] = $post->deliver_address;
                $nestedData['order_date'] = $post->order_date;
                $nestedData['franchise'] = $post->franchise_name;

                $this->db->select('*');
                $this->db->from('slot_timing');
                $this->db->where('slot_id', $post->slot_id);
                $query44  = $this->db->get();
                $rowcount = $query44->num_rows();
                if ($rowcount == 0) {
                    $day = '';
                    $slot_timing = '';
                } else {
                    $result44 = $query44->row();
                    $day = $result44->day;
                    $slot_timing = $result44->slot_timing;
                }

                $nestedData['slot'] = $day . ' ' . $slot_timing;

                if ($post->assign_to != '') {
                    $this->db->select('*');
                    $this->db->from('delivery_boy');
                    $this->db->where('db_id', $post->assign_to);
                    $query  = $this->db->get();
                    $result = $query->row();
                    $db_name = $result->name;

                    $nestedData['assign_to'] = $db_name;
                } else {
                    $nestedData['assign_to'] = '';
                }

                if ($post->status == '0') {
                    $nestedData['status'] = '<span class="badge badge-danger shadow-danger m-1">Pending</span>';
                } elseif ($post->status == '1') {
                    $nestedData['status'] = '<span class="badge badge-success shadow-success m-1">Confirm</span>';
                } elseif ($post->status == '2') {
                    $nestedData['status'] = '<span class="badge badge-info shadow-info m-1">Dispatch</span>';
                } elseif ($post->status == '3') {
                    $nestedData['status'] = '<span class="badge badge-primary shadow-primary m-1">Delivered</span>';
                } elseif ($post->status == '4') {
                    $nestedData['status'] = '<span class="badge badge-danger shadow-danger m-1">Cancel</span>';
                }


                if ($post->payment_status == '0') {
                    $nestedData['payment_status'] = '<span class="badge badge-danger shadow-danger m-1">Unpaid</span>';
                } elseif ($post->payment_status == '1') {
                    $nestedData['payment_status'] = '<span class="badge badge-success shadow-success m-1">Paid</span>';
                }



                $this->db->select('COUNT(order_id) AS no_of_product');
                $this->db->from('order_detail');
                $this->db->where('order_id', $post->order_id);
                $query  = $this->db->get();
                $result = $query->row();
                $no_of_product = $result->no_of_product;


                $nestedData['count_product'] = $no_of_product;

                $nestedData['action'] = '';

                if ($login_type != '0') {

                    $nestedData['action'] = ' <div class="btn-group m-1" role="group">
                                              <button type="button" class="btn btn-dark   waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                              </button>
                                              <div class="dropdown-menu">
                                               
                                                <a href="' . base_url('sales/view_invoice?order_id=' . $post->order_generate_id) . '" class="dropdown-item" target="_blank"><i aria-hidden="true" class="fa fa-eye"></i> View</a>
                                                <a href="' . base_url('sales/invoice/' . $post->order_generate_id) . '" class="dropdown-item" target="_blank><i aria-hidden="true" class="fa fa-file"></i> Download Invoice</a>
                                              </div>
                                            </div>';
                }
                if ($login_type == '0') {
                    $nestedData['action'] = ' <div class="btn-group m-1" role="group">
                                              <button type="button" class="btn btn-dark   waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                              </button>
                                              <div class="dropdown-menu">
                                                <a href="' . base_url('sales/view_invoice?order_id=' . $post->order_generate_id) . '" class="dropdown-item" target="_blank"><i aria-hidden="true" class="fa fa-eye"></i> View</a>
                                                <a href="' . base_url('sales/invoice/' . $post->order_generate_id) . '" class="dropdown-item" target="_blank><i aria-hidden="true" class="fa fa-file"></i> Download Invoice</a>
                                              </div>
                                            </div>';
                }

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

    public function assign_not_deliver()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $this->load->view('common/header');
            $this->load->view('sales/assign_not_deliver');
            $this->load->view('common/footer');
        }
    }



    //////////////////////////////////AJAX ASSIGN ORDER LIST //////////////////////////

    public function ajax_assign_not_deliver_list()
    {
        $login_type   = $this->session->userdata('type');
        $columns = array(
            0 => 'order_id',
            1 => 'order_generate_id',
            2 => 'count_product',
            3 => 'customer_id',
            4 => 'order_total',
            5 => 'payment_status',
            6 => 'assign_to',
            7 => 'order_date',
            8 => 'franchise',
            9 => 'action',


        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->sales_model->assign_not_deliver_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $posts = $this->sales_model->assign_not_deliver_list($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $posts =  $this->sales_model->assign_not_deliver_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->sales_model->assign_not_deliver_search_count($search);
        }

        $data = array();
        if (!empty($posts)) {
            $i = 1;
            foreach ($posts as $post) {

                $nestedData['order_id'] = '<input type="checkbox" class="sub_chk" data-id="' . $post->order_id . '">';
                $nestedData['order_generate_id'] = '#' . $post->order_generate_id;
                $nestedData['customer_id'] = $post->first_name . ' ' . $post->last_name;
                $nestedData['order_total'] = $post->order_total;
                $nestedData['address'] = $post->deliver_address;
                $nestedData['order_date'] = $post->order_date;
                $nestedData['franchise'] = $post->franchise_name;

                $this->db->select('*');
                $this->db->from('slot_timing');
                $this->db->where('slot_id', $post->slot_id);
                $query44  = $this->db->get();
                $rowcount = $query44->num_rows();
                if ($rowcount == 0) {
                    $day = '';
                    $slot_timing = '';
                } else {
                    $result44 = $query44->row();
                    $day = $result44->day;
                    $slot_timing = $result44->slot_timing;
                }

                $nestedData['slot'] = $day . ' ' . $slot_timing;

                if ($post->assign_to != '') {
                    $this->db->select('*');
                    $this->db->from('delivery_boy');
                    $this->db->where('db_id', $post->assign_to);
                    $query  = $this->db->get();
                    $result = $query->row();
                    $db_name = $result->name;

                    $nestedData['assign_to'] = $db_name;
                } else {
                    $nestedData['assign_to'] = '';
                }

                if ($post->status == '0') {
                    $nestedData['status'] = '<span class="badge badge-danger shadow-danger m-1">Pending</span>';
                } elseif ($post->status == '1') {
                    $nestedData['status'] = '<span class="badge badge-success shadow-success m-1">Confirm</span>';
                } elseif ($post->status == '2') {
                    $nestedData['status'] = '<span class="badge badge-info shadow-info m-1">Dispatch</span>';
                } elseif ($post->status == '3') {
                    $nestedData['status'] = '<span class="badge badge-primary shadow-primary m-1">Delivered</span>';
                } elseif ($post->status == '4') {
                    $nestedData['status'] = '<span class="badge badge-danger shadow-danger m-1">Cancel</span>';
                }


                if ($post->payment_status == '0') {
                    $nestedData['payment_status'] = '<span class="badge badge-danger shadow-danger m-1">Unpaid</span>';
                } elseif ($post->payment_status == '1') {
                    $nestedData['payment_status'] = '<span class="badge badge-success shadow-success m-1">Paid</span>';
                }



                $this->db->select('COUNT(order_id) AS no_of_product');
                $this->db->from('order_detail');
                $this->db->where('order_id', $post->order_id);
                $query  = $this->db->get();
                $result = $query->row();
                $no_of_product = $result->no_of_product;


                $nestedData['count_product'] = $no_of_product;

                $nestedData['action'] = '';

                if ($login_type != '0') {

                    $nestedData['action'] = ' <div class="btn-group m-1" role="group">
                                              <button type="button" class="btn btn-dark   waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                              </button>
                                              <div class="dropdown-menu">
                                               
                                                <a href="' . base_url('sales/view_invoice?order_id=' . $post->order_generate_id) . '" class="dropdown-item" target="_blank"><i aria-hidden="true" class="fa fa-eye"></i> View</a>
                                                <a href="' . base_url('sales/invoice/' . $post->order_generate_id) . '" class="dropdown-item" target="_blank><i aria-hidden="true" class="fa fa-file"></i> Download Invoice</a>
                                              </div>
                                            </div>';
                }
                if ($login_type == '0') {
                    $nestedData['action'] = ' <div class="btn-group m-1" role="group">
                                              <button type="button" class="btn btn-dark   waves-effect waves-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action
                                              </button>
                                              <div class="dropdown-menu">
                                                <a href="' . base_url('sales/view_invoice?order_id=' . $post->order_generate_id) . '" class="dropdown-item" target="_blank"><i aria-hidden="true" class="fa fa-eye"></i> View</a>
                                                <a href="' . base_url('sales/invoice/' . $post->order_generate_id) . '" class="dropdown-item" target="_blank><i aria-hidden="true" class="fa fa-file"></i> Download Invoice</a>
                                              </div>
                                            </div>';
                }

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




    public function manually_order_entry()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {

            $timestamp = date('d-m-Y');
            $current_day = date('l', strtotime($timestamp . ' +1 day'));
            $franchise_id   = $this->session->userdata('type');
            $data['slot_list'] = $this->product_model->get_slot_day_wise_model($current_day, $franchise_id);
            $data['all_product'] = $this->product_model->get_product_data();
            $data['all_zone'] = $this->product_model->get_all_zone_model();
            $this->load->view('common/header');
            $this->load->view('sales/manually_order_entry', $data);
            $this->load->view('common/footer');
        }
    }



    public function edit_order()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $franchise_id   = $this->session->userdata('type');
            $order_id = $this->input->get('order_id');
            $timestamp = date('d-m-Y');
            $current_day = date('l', strtotime($timestamp . ' +1 day'));
            $data['slot_list'] = $this->product_model->get_slot_day_wise_model($current_day, $franchise_id);
            $data['all_product'] = $this->product_model->get_product_data();
            $data['all_zone'] = $this->product_model->get_all_zone_model();
            $data['order_summary'] = $this->product_model->get_order_summary($order_id);
            $this->load->view('common/header');
            $this->load->view('sales/edit_order', $data);
            $this->load->view('common/footer');
        }
    }



    /***************************** Delete Product order  *************************************
     ******************************************************************************************/
    public function delete_order_product()
    {
        $delete_id     = $this->input->post('delete_id');


        $this->db->select('*');
        $this->db->from('order_detail');
        $this->db->where('order_d_id', $delete_id);
        $query1  = $this->db->get();
        $result = $query1->row();
        $order_id = $result->order_id;
        $product_id = $result->product_id;
        $qty = $result->qty;
        $unit = $result->unit;
        $unit_price = $result->unit_price;
        $discount = $result->discount;

        $total_price = ($unit_price * $qty);

        $discount_price = ($total_price - ($total_price * ($discount / 100)));
        $discount_amt = ($total_price * ($discount / 100));

        $this->db->select('*');
        $this->db->from('product_order');
        $this->db->where('order_id', $order_id);
        $query22  = $this->db->get();
        $result22 = $query22->row();
        $bag_discount = $result22->bag_discount;
        $order_total = $result22->order_total;
        $total_bag = $result22->total_bag;
        $product_id = $result22->product_id;



        $this->db->select('*');
        $this->db->from('vegshopy_product');
        $this->db->where('product_id', $product_id);
        $query33  = $this->db->get();
        $result33 = $query22->row();
        $stock = $result33->qty;



        $a = $total_bag - $total_price;
        $b = $bag_discount - $discount_amt;
        $c = $order_total - $discount_price;




        $update_data = array(
            'total_bag'           => $a,
            'bag_discount'        => $b,
            'order_total'         => $c,

        );
        $this->db->where('order_id', $order_id);
        $this->db->update('product_order', $update_data);

        $update_data1 = array(
            'qty'           => $stock + $qty,

        );
        $this->db->where('product_id', $product_id);
        $this->db->update('vegshopy_product', $update_data1);

        $this->db->where('order_d_id', $delete_id);
        $this->db->delete('order_detail');
    }

    public function get_unit()
    {

        $product_id = $this->input->post('product_id');
        $data     = $this->product_model->product_details_product_id_wise1($product_id);
        echo json_encode($data);
    }


    public function getproductdetails()
    {
        $id = $this->input->post('unit');

        $this->db->select('*');
        $this->db->from('product_details');
        $this->db->where('id', $id);
        $query  = $this->db->get();
        $result = $query->row();
        $unit_price = $result->unit_price;
        $discount     = $result->discount;

        echo $unit_price . "#" . $discount;
    }

    public function add_order_entry_data()
    {


        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('customer_name', 'customer name', 'required');
        $this->form_validation->set_rules('mobile_no', 'mobile no', 'required');
        $this->form_validation->set_rules('address', 'address', 'required');
        $this->form_validation->set_rules('slot_id', 'slot', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $currdate = date('d-m-Y');
        $customer_name  = $this->input->post('customer_name');
        $mobile_no  = $this->input->post('mobile_no');
        $email_id  = $this->input->post('email_id');
        $address  = $this->input->post('address');
        $slot_id  = $this->input->post('slot_id');
        $total_bag  = $this->input->post('total_bag');
        $bag_discount  = $this->input->post('bag_discount');
        $order_total  = $this->input->post('order_total');

        $assign_to  = $this->input->post('assign_to');

        $order_generate_id = mt_rand(000000, 999999);
        $franchise_id   = $this->session->userdata('type');




        if ($this->form_validation->run() == TRUE) {
            $this->db->select('*');
            $this->db->from('customer');
            $this->db->where('mobile_no', $mobile_no);
            $this->db->where('flag', '0');
            $query  = $this->db->get();
            $rowcount = $query->num_rows();
            if ($rowcount > 0) {
                $result = $query->row();
                $customer_id = $result->customer_id;
            } else {
                $regData = array(
                    'first_name'    => $customer_name,
                    'email_id'      => $email_id,
                    'mobile_no'     => $mobile_no,
                    'rdate'         => $currdate,
                    'franchise_id'  => $franchise_id,
                );

                $this->db->insert('customer', $regData);
                $customer_id = $this->db->insert_id();


                $uid = 'C' . str_pad($customer_id, 8, 0, STR_PAD_LEFT);
                $insertArray1 = array(
                    'customer_unique_id' => $uid
                );
                $this->db->where('customer_id', $customer_id);
                $this->db->update('customer', $insertArray1);
            }


            $order_entry = array(

                'customer_id'  => $customer_id,
                'total_bag'    => $total_bag,
                'bag_discount' => $bag_discount,
                'order_total'  => $order_total,
                'slot_id'      => $slot_id,
                'deliver_address'  => $address,
                'order_date'      => $currdate,
                'franchise_id'  => $franchise_id,
                'flag'                => '1',

            );

            // print_r($order_entry);die;

            $this->db->insert('product_order', $order_entry);
            $insert_id = $this->db->insert_id();

            $regData1 = array(

                'order_generate_id'  => 'EX' . $order_generate_id,

            );

            $this->db->where(array('order_id' => $insert_id))->update('product_order', $regData1);
            $cnt = count($product_id = $this->input->post('product_id'));


            //print_r($qty);exit;


            for ($i = 0; $i < $cnt; $i++) {

                $this->db->select('*');
                $this->db->from('product_details');
                $this->db->where('id', $_POST['unit'][$i]);
                $query  = $this->db->get();
                $result = $query->row();
                $title = $result->title;

                $this->db->select('*');
                $this->db->from('vegshopy_product');
                $this->db->where('product_id', $_POST['product_id'][$i]);
                $query11  = $this->db->get();
                $result11 = $query11->row();
                $avi_qty = $result11->qty;

                $stock   = $avi_qty - $_POST['qty'][$i];


                $data2 = array(
                    'order_id'       => $insert_id,
                    'product_id'     => $_POST['product_id'][$i],
                    'qty'            => $_POST['qty'][$i],
                    'unit'           => $title,
                    'unit_price'     => $_POST['unit_price'][$i],
                    'discount'       => $_POST['discount'][$i],
                    'franchise_id'   => $franchise_id,
                    'order_date'      => $currdate,

                );
                $this->db->insert('order_detail', $data2);
            }


            /*$sender="BASKET";
        			$number2 = $mobile_no;
        			$msg2="Dear $customer_name,your order placed successfully done.your Order id is #'EX'.$order_generate_id.";
        			
        			$api_key = '55A827A192C7C6';
        			$ch = curl_init();
        			curl_setopt($ch,CURLOPT_URL, "https://www.logonutility.in/app/smsapi/index.php");
        			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        			curl_setopt($ch, CURLOPT_POST, 1);
        		    curl_setopt($ch, CURLOPT_POSTFIELDS, "key=".$api_key."&&campaign=1&routeid=20&type=text&contacts=".$number2."&senderid=".$sender."&msg=".$msg2);
        		    $response = curl_exec($ch);
        	    	
        			curl_close($ch); */

            $number = $mobile_no;
            $from = "EXOTIC";
            $enmsg = "Dear%20$first_name%20,%20your%20order%20placed%20successfully%20done.your%20Order%20id%20is%20#EX$order_generate_id.%20Thank%20you%20for%20order%20with%20EXOTIC%20BASKET";

            $usrnme = 't1t1aimbeat';
            $psd = '44364836';


            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://nimbusit.co.in/api/swsendSingle.asp");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            //curl_setopt($ch, CURLOPT_POSTFIELDS, "key=".$api_key."&campaign=1&routeid=20&type=text&contacts=".$number."&senderid=".$from."&msg=".$enmsg);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "username=" . $usrnme . "&password=" . $psd . "&sender=" . $from . "&sendto=" . $number . "&message=" . $enmsg);
            $response = curl_exec($ch);


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
            $redirect = base_url('sales/total_sales');
        } else {
            $status = 'error';
            if (form_error('customer_name')) {
                $errors['customer_nameError'] = form_error('customer_name');
            }

            if (form_error('mobile_no')) {
                $errors['mobile_noError'] = form_error('mobile_no');
            }
            if (form_error('address')) {
                $errors['addressError'] = form_error('address');
            }

            if (form_error('slot_id')) {
                $errors['slot_idError'] = form_error('slot_id');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }





    public function update_order_entry_data()
    {


        $errors   = array();
        $message  = '';
        $redirect = '';
        $this->form_validation->set_rules('customer_name', 'customer name', 'required');
        $this->form_validation->set_rules('mobile_no', 'mobile no', 'required');
        $this->form_validation->set_rules('address', 'address', 'required');
        $this->form_validation->set_rules('slot_id', 'slot', 'required');
        $this->form_validation->set_message('required', '* Please add %s');

        $currdate = date('d-m-Y');
        $customer_name  = $this->input->post('customer_name');
        $mobile_no  = $this->input->post('mobile_no');
        $email_id  = $this->input->post('email_id');
        $address  = $this->input->post('address');
        $slot_id  = $this->input->post('slot_id');
        $total_bag  = $this->input->post('total_bag');
        $bag_discount  = $this->input->post('bag_discount');
        $order_total  = $this->input->post('order_total');


        $customer_id  = $this->input->post('customer_id');
        $order_id  = $this->input->post('order_id');

        $franchise_id   = $this->session->userdata('type');





        if ($this->form_validation->run() == TRUE) {



            $update_order = array(

                'customer_id'  => $customer_id,
                'total_bag'    => $total_bag,
                'bag_discount' => $bag_discount,
                'order_total'  => $order_total,
                'slot_id'      => $slot_id,
                'deliver_address'  => $address,

            );

            // print_r($order_entry);die;

            $this->db->where('order_id', $order_id);
            $this->db->update('product_order', $update_order);


            $cnt = count($product_id = $this->input->post('product_id'));
            for ($i = 0; $i < $cnt; $i++) {
                $this->db->select('*');
                $this->db->from('product_details');
                $this->db->where('id', $_POST['unit'][$i]);
                $query  = $this->db->get();
                $result = $query->row();
                $title = $result->title;


                $fid             = $_POST['fid'][$i];

                if ($fid == '') {
                    $data2 = array(
                        'order_id'       => $order_id,
                        'product_id'     => $_POST['product_id'][$i],
                        'qty'            => $_POST['qty'][$i],
                        'unit'           => $title,
                        'unit_price'     => $_POST['unit_price'][$i],
                        'discount'       => $_POST['discount'][$i],
                        'franchise_id'   => $franchise_id,

                    );
                    $this->db->insert('order_detail', $data2);

                    $this->db->select('*');
                    $this->db->from('vegshopy_product');
                    $this->db->where('product_id', $_POST['product_id'][$i]);
                    $query11  = $this->db->get();
                    $result11 = $query11->row();
                    $avi_qty = $result11->qty;

                    $stock   = $avi_qty - $_POST['qty'][$i];

                    $data22 = array(
                        'qty'       => $stock,

                    );
                    $this->db->where('product_id', $_POST['product_id'][$i]);
                    $this->db->update('vegshopy_product', $data22);
                } else {
                    $data2 = array(
                        'product_id'     => $_POST['product_id'][$i],
                        'qty'            => $_POST['qty'][$i],
                        'unit'           => $title,
                        'unit_price'     => $_POST['unit_price'][$i],
                        'discount'       => $_POST['discount'][$i],

                    );
                    $this->db->where('order_d_id', $fid)->update('order_detail', $data2);
                }
            }




            $status = 'success';
            $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
    						<button type="button" class="close" data-dismiss="alert">×</button>
    						
    						<div class="alert-icon">
    						 <i class="icon-check"></i>
    						</div>
    						<div class="alert-message">
    						  <span><strong>Order!</strong> update successfully. <a href="javascript:void();" class="alert-link"></a></span>
    						</div>
    					  </div>';

            $this->session->set_flashdata('message', $message);
            $redirect = base_url('sales/total_sales');
        } else {
            $status = 'error';
            if (form_error('customer_name')) {
                $errors['customer_nameError'] = form_error('customer_name');
            }

            if (form_error('mobile_no')) {
                $errors['mobile_noError'] = form_error('mobile_no');
            }
            if (form_error('address')) {
                $errors['addressError'] = form_error('address');
            }

            if (form_error('slot_id')) {
                $errors['slot_idError'] = form_error('slot_id');
            }
            if (form_error('zone_id')) {
                $errors['zone_idError'] = form_error('zone_id');
            }
            if (form_error('area_id')) {
                $errors['area_idError'] = form_error('area_id');
            }
        }

        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }


    public function get_product()
    {

        $all_product = $this->product_model->get_product_data();
        foreach ($all_product as $product) {
            $product_id              = $product->product_id;
            $product_name            = $product->product_name;
            $data[] = array('product_id' => $product_id, 'product_name' => $product_name);
        }
        echo json_encode(array('result' => $data));
    }


    public function get_unit_details()
    {

        $product_id = $this->input->post('product_id');
        $all_unit    = $this->product_model->product_details_product_id_wise2($product_id);


        echo '<option value="">Select unit</option>';
        foreach ($all_unit as $unit) {
            $id              = $unit->id;
            $title           = $unit->title;

            echo '<option value="' . $id . '">' . $title . '</option>';
        }
    }



    public function itemwise_pending_sales()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $this->load->view('common/header');
            $this->load->view('sales/itemwise_pending_sales');
            $this->load->view('common/footer');
        }
    }





    //////////////////////////////////AJAX ITEM WISE LIST //////////////////////////

    public function ajax_item_wise_list()
    {

        $login_type   = $this->session->userdata('type');

        $columns = array(
            0 => 'order_id',
            1 => 'customer_id',
            2 => 'product_name',
            3 => 'unit',
            4 => 'qty',
            5 => 'payment_status',
            6 => 'sttaus',
            7 => 'order_date',
            8 => 'franchise',



        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->sales_model->item_wise_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $posts = $this->sales_model->item_wise_list($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $posts =  $this->sales_model->item_wise_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->sales_model->item_wise_search_count($search);
        }

        $data = array();
        if (!empty($posts)) {
            $i = 1;
            foreach ($posts as $post) {


                $nestedData['order_id'] = '#' . $post->order_generate_id;
                $nestedData['customer_id'] = $post->first_name . ' ' . $post->last_name;
                $nestedData['order_date'] = $post->order_date;
                $nestedData['franchise'] = $post->franchise_name;
                $nestedData['product_name'] = $post->product_name;
                $nestedData['unit'] = $post->unit;
                $nestedData['qty'] = $post->qty;




                if ($post->status == '0') {
                    $nestedData['status'] = '<span class="badge badge-danger shadow-danger m-1">Pending</span>';
                } elseif ($post->status == '1') {
                    $nestedData['status'] = '<span class="badge badge-success shadow-success m-1">Confirm</span>';
                } elseif ($post->status == '2') {
                    $nestedData['status'] = '<span class="badge badge-info shadow-info m-1">Dispatch</span>';
                } elseif ($post->status == '3') {
                    $nestedData['status'] = '<span class="badge badge-primary shadow-primary m-1">Delivered</span>';
                } elseif ($post->status == '4') {
                    $nestedData['status'] = '<span class="badge badge-danger shadow-danger m-1">Cancel</span><br> ' . $post->cancel_resion;
                }


                if ($post->payment_status == '0') {
                    $nestedData['payment_status'] = '<span class="badge badge-danger shadow-danger m-1">Unpaid</span>';
                } elseif ($post->payment_status == '1') {
                    $nestedData['payment_status'] = '<span class="badge badge-success shadow-success m-1">Paid</span>';
                }




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



    public function get_customer()
    {
        $mobile_no = $this->input->post('mobile_no');

        $this->db->select('*');
        $this->db->from('customer');
        $this->db->where('mobile_no', $mobile_no);
        $query1  = $this->db->get();
        $rowcount1 = $query1->num_rows();
        if ($rowcount1 == 0) {
            echo '';
        } else {
            $result1 = $query1->row();
            $customer_name = $result1->first_name . ' ' . $result1->last_name;
            $email_id     = $result1->email_id;

            $customer_id     = $result1->customer_id;

            $this->db->select('*');
            $this->db->from('product_order');
            $this->db->where('customer_id', $customer_id);

            $query11  = $this->db->get();
            $rowcount11 = $query11->num_rows();
            if ($rowcount11 == 0) {
                $address = '';
            } else {
                $this->db->order_by("product_id", "DESC");
                $this->db->limit(1);
                $result = $query11->row();
                $address     = $result->deliver_address;
            }


            echo $customer_name . "#" . $email_id . "#" . $address;
        }
    }



    public function return_product()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {
            $this->load->view('common/header');
            $this->load->view('sales/return_product');
            $this->load->view('common/footer');
        }
    }







    //////////////////////////////////AJA RETIRN LIST //////////////////////////

    public function ajax_return_list()
    {

        $login_type   = $this->session->userdata('type');

        $columns = array(
            0 => 'order_id',
            1 => 'order_generate_id',
            2 => 'customer_id',
            3 => 'product_name',
            4 => 'unit',
            5 => 'qty',
            6 => 'sttaus',
            7 => 'order_date',
            8 => 'db_name',
            9 => 'zone',
            10 => 'franchise',



        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];

        $totalData = $this->sales_model->return_count();

        $totalFiltered = $totalData;

        if (empty($this->input->post('search')['value'])) {
            $posts = $this->sales_model->return_list($limit, $start, $order, $dir);
        } else {
            $search = $this->input->post('search')['value'];

            $posts =  $this->sales_model->return_search($limit, $start, $search, $order, $dir);

            $totalFiltered = $this->sales_model->return_search_count($search);
        }

        $data = array();
        if (!empty($posts)) {
            $i = 1;
            foreach ($posts as $post) {

                $nestedData['order_id'] = $i++;

                $nestedData['order_generate_id'] = '#' . $post->order_generate_id;
                $nestedData['customer_id'] = $post->first_name . ' ' . $post->last_name;
                $nestedData['order_date'] = $post->order_date;
                $nestedData['franchise'] = $post->franchise_name;
                $nestedData['product_name'] = $post->product_name;
                $nestedData['unit'] = $post->unit;
                $nestedData['qty'] = $post->qty;
                $nestedData['db_name'] = $post->name;
                $nestedData['zone'] = $post->zone_name;






                if ($post->flag == '0') {
                    $nestedData['status'] = '<span class="badge badge-danger shadow-danger m-1">Deliverd</span>';
                } elseif ($post->flag == '1') {
                    $nestedData['status'] = '<span class="badge badge-danger shadow-danger m-1">Cancel</span>';
                }




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




    public function warehouse()
    {
        if (!$this->session->userdata('isLoggedIn')) {
            redirect('login');
        } else {

            $submit = $this->input->post('submit');
            $order_id = $this->input->post('order_id');

            if (!empty($submit)) {

                if (!empty($order_id)) {
                    $page_data['order_summary'] = $this->sales_model->get_order_record($order_id);
                }
            }
            $page_data['submit'] = $submit;
            $page_data['order_id'] =  $order_id;
            $page_data['order_summary'] = $this->sales_model->get_order_record($order_id);
            $this->load->view('common/header');
            $this->load->view('sales/warehouse', $page_data);
            $this->load->view('common/footer');
        }
    }




    function dispatch_order_data()

    {


        $errors   = array();
        $message  = '';
        $redirect = '';

        $multiple_id  = $this->input->post('multiple_id');



        $order_d_id = explode(",", $multiple_id);
        $i = 0;
        foreach ($order_d_id as $order_d_id) {

            $this->db->select('*');
            $this->db->from('order_detail');
            $this->db->where('order_d_id', $order_d_id);
            $query1  = $this->db->get();
            $result = $query1->row();
            $order_id = $result->order_id;




            $update_data = array(
                'flag'                => '2',


            );

            $this->db->where('order_d_id', $order_d_id)->update('order_detail', $update_data);


            $update_data1 = array(
                'status'                => '2',


            );

            $this->db->where('order_id', $order_id)->update('product_order', $update_data1);


            $this->db->select('*');
            $this->db->from('product_order');
            $this->db->where('order_id', $order_id);
            $query22  = $this->db->get();
            $result22 = $query22->row();
            $customer_id = $result22->customer_id;
            $slot_id = $result22->slot_id;
            $order_generate_id = $result22->$order_generate_id;


            $this->db->select('*');
            $this->db->from('customer');
            $this->db->where('customer_id', $customer_id);
            $query33  = $this->db->get();
            $result33 = $query33->row();
            $mobile_no = $result33->mobile_no;


            $this->db->select('*');
            $this->db->from('slot_timing');
            $this->db->where('slot_id', $slot_id);
            $query44  = $this->db->get();
            $result44 = $query44->row();
            $day = $result44->slot_timing . ' ' . $result44->day;


            $number = $mobile_no;
            $from = "EXOTIC";
            $emsg = "Order%20Packed%20$order_generate_id,Your%20order%20is%20ready%20for%20dispatch.Estimated%20Delivery:%$day.";

            $usrnme = 't1t1aimbeat';
            $psd = '44364836';


            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://nimbusit.co.in/api/swsendSingle.asp");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            //curl_setopt($ch, CURLOPT_POSTFIELDS, "key=".$api_key."&campaign=1&routeid=20&type=text&contacts=".$number."&senderid=".$from."&msg=".$enmsg);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "username=" . $usrnme . "&password=" . $psd . "&sender=" . $from . "&sendto=" . $number . "&message=" . $enmsg);
            $response = curl_exec($ch);

            curl_close($ch);




            $i++;
        }

        $status = 'success';
        $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Product dispatch!</strong>  successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

        $this->session->set_flashdata('message', $message);
        $redirect = base_url('sales/warehouse');


        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }


    function dispatch_product_order_data()

    {


        $errors   = array();
        $message  = '';
        $redirect = '';


        $multiple_id  = $this->input->post('multiple_id');


        $order_id = explode(",", $multiple_id);
        $i = 0;
        foreach ($order_id as $order_id) {
            $update_data = array(
                'status'                => '2',

            );

            $this->db->where('order_id', $order_id)->update('product_order', $update_data);

            $i++;
        }

        $status = 'success';
        $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Order dispatch!</strong>  successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

        $this->session->set_flashdata('message', $message);
        $redirect = base_url('sales/pending_sales');


        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }



    function delivered_product_order_data()

    {


        $errors   = array();
        $message  = '';
        $redirect = '';


        $multiple_id  = $this->input->post('multiple_id');

        $order_d_id = explode(",", $multiple_id);
        $i = 0;
        foreach ($order_d_id as $order_d_id) {
            $this->db->select('*');
            $this->db->from('order_detail');
            $this->db->where('order_d_id', $order_d_id);
            $query1  = $this->db->get();
            $result = $query1->row();
            $order_id = $result->order_id;




            $update_data = array(
                'flag'                => '2',


            );

            $this->db->where('order_d_id', $order_d_id)->update('order_detail', $update_data);


            $update_data1 = array(
                'status'                => '2',


            );

            $this->db->where('order_id', $order_id)->update('product_order', $update_data1);


            $this->db->select('*');
            $this->db->from('product_order');
            $this->db->where('order_id', $order_id);
            $query22  = $this->db->get();
            $result22 = $query22->row();
            $customer_id = $result22->customer_id;
            $slot_id = $result22->slot_id;
            $order_generate_id = $result22->$order_generate_id;


            $this->db->select('*');
            $this->db->from('customer');
            $this->db->where('customer_id', $customer_id);
            $query33  = $this->db->get();
            $result33 = $query33->row();
            $mobile_no = $result33->mobile_no;


            $this->db->select('*');
            $this->db->from('slot_timing');
            $this->db->where('slot_id', $slot_id);
            $query44  = $this->db->get();
            $result44 = $query44->row();
            $day = $result44->slot_timing . ' ' . $result44->day;


            $number = $mobile_no;
            $from = "EXOTIC";
            $emsg = "Order%20Packed%20$order_generate_id,Your%20order%20is%20ready%20for%20dispatch.Estimated%20Delivery:%$day.";

            $usrnme = 't1t1aimbeat';
            $psd = '44364836';


            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://nimbusit.co.in/api/swsendSingle.asp");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            //curl_setopt($ch, CURLOPT_POSTFIELDS, "key=".$api_key."&campaign=1&routeid=20&type=text&contacts=".$number."&senderid=".$from."&msg=".$enmsg);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "username=" . $usrnme . "&password=" . $psd . "&sender=" . $from . "&sendto=" . $number . "&message=" . $enmsg);
            $response = curl_exec($ch);

            curl_close($ch);

            $i++;
        }

        $status = 'success';
        $message = '<br><div class="alert alert-outline-success alert-dismissible alert-round" role="alert">
						<button type="button" class="close" data-dismiss="alert">×</button>
						
						<div class="alert-icon">
						 <i class="icon-check"></i>
						</div>
						<div class="alert-message">
						  <span><strong>Order deliverd!</strong>  successfully. <a href="javascript:void();" class="alert-link"></a></span>
						</div>
					  </div>';

        $this->session->set_flashdata('message', $message);
        $redirect = base_url('sales/deliver_sales');


        $data['status']   = $status;
        $data['errors']   = $errors;
        $data['redirect'] = $redirect;
        $data['message']  = $message;
        echo json_encode($data);
    }
}
