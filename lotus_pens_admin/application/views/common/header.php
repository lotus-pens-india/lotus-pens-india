    <?php

    $login_type       = $this->session->userdata('type');
    $company_name     = $this->session->userdata('company_name');
    $company_email    = $this->session->userdata('company_email');
    $company_phone    = $this->session->userdata('company_phone');
    $employee_id    = $this->session->userdata('employee_id');

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <meta name="description" content="" />
      <meta name="author" content="" />
      <title>Lotus Pens - Admin Dashboard</title>
      <!--favicon-->
      <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
      <!-- Vector CSS -->
      <link href="<?php echo base_url(); ?>assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet" />
      <!-- simplebar CSS-->
      <link href="<?php echo base_url(); ?>assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
      <!-- Bootstrap core CSS-->
      <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" />
      <!-- animate CSS-->
      <link href="<?php echo base_url(); ?>assets/css/animate.css" rel="stylesheet" type="text/css" />
      <!-- Icons CSS-->
      <link href="<?php echo base_url(); ?>assets/css/icons.css" rel="stylesheet" type="text/css" />
      <!-- Sidebar CSS-->
      <link href="<?php echo base_url(); ?>assets/css/sidebar-menu.css" rel="stylesheet" />
      <!-- Custom Style-->
      <link href="<?php echo base_url(); ?>assets/css/app-style.css" rel="stylesheet" />
      <!--Data Tables -->
      <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-datatable/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css">
      <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-datatable/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css">
      <!--Select Plugins-->
      <link href="<?php echo base_url(); ?>assets/plugins/select2/css/select2.min.css" rel="stylesheet" />

      <link href="<?php echo base_url(); ?>assets/plugins/jquery-multi-select/multi-select.css" rel="stylesheet" type="text/css">
      <!--Lightbox Css-->
      <link href="<?php echo base_url(); ?>assets/plugins/fancybox/css/jquery.fancybox.min.css" rel="stylesheet" type="text/css" />
      <!--Switchery-->
      <link href="<?php echo base_url(); ?>assets/plugins/switchery/css/switchery.min.css" rel="stylesheet" />
      <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-switch/bootstrap-switch.min.css" rel="stylesheet">
      <!--Bootstrap Datepicker-->
      <link href="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/3.2.0/css/bootstrap-colorpicker.min.css" rel="stylesheet" type="text/css">
      <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <!--Bootstrap Datepicker Js-->
      <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>





    </head>

    <body onload=display_ct();>
      <input type="hidden" value="<?= base_url() ?>" id="base_url_textbox">
      <!-- Start wrapper-->
      <div id="wrapper">

        <!--Start sidebar-wrapper-->
        <div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">
          <div class="brand-logo">
            <a href="<?php echo base_url(); ?>dashboard">
              <img src="https://www.lotuspens.com/image/catalog/logo.jpg" class="logo-icon" alt="logo icon">
              <label for="">Lotus Pens</label>
            </a>
          </div>

          <?php if ($employee_id == '0') { ?>
            <ul class="sidebar-menu do-nicescrol">

              <li>
                <a href="<?php echo base_url(); ?>dashboard" class="waves-effect">
                  <i class="icon-home"></i> <span>Dashboard</span>
                </a>

              </li>
              <?php if ($login_type == '0' && $employee_id == '0') { ?>
                <li>
                  <a href="<?php echo base_url(); ?>product/franchise" class="waves-effect">
                    <i class="icon-event"></i> <span>Saller</span>
                  </a>

                </li>
              <?php } ?>

              <?php if ($login_type != '0' && $employee_id == '0') { ?>
                <li>
                  <a href="javaScript:void();" class="waves-effect">
                    <i class="icon-settings"></i>
                    <span>Setting</span> <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="sidebar-submenu">
                    <!-- <li><a href="<?php echo base_url(); ?>product/qrcode"><i class="fa fa-circle-o"></i>App QRcode</a></li>
                    <li><a href="<?php echo base_url(); ?>product/designation"><i class="fa fa-circle-o"></i>Designation master</a></li>
                    <li><a href="<?php echo base_url(); ?>product/employee"><i class="fa fa-circle-o"></i>Employee master</a></li> -->
                    <!--<li><a href="<?php echo base_url(); ?>product/zone"><i class="fa fa-circle-o"></i>Zone master</a></li>     
          <li><a href="<?php echo base_url(); ?>product/area"><i class="fa fa-circle-o"></i>Area master</a></li> -->
                    <li><a href="<?php echo base_url(); ?>product/banner"><i class="fa fa-circle-o"></i> Banner</a></li>
                    <li><a href="<?php echo base_url(); ?>product/brands"><i class="fa fa-circle-o"></i> Brand</a></li>
                    <li><a href="<?php echo base_url(); ?>product/category"><i class="fa fa-circle-o"></i> Category</a></li>
                    <li><a href="<?php echo base_url(); ?>product/subcategory"><i class="fa fa-circle-o"></i> Subcategory</a></li>
                    <!-- <li><a href="<?php echo base_url(); ?>product/sub_subcategory"><i class="fa fa-circle-o"></i> Sub Subcategory</a></li> -->
                    <!--<li><a href="<?php echo base_url(); ?>product/slot_time"><i class="fa fa-circle-o"></i> Slot Timing</a></li>-->
                    <!-- <li><a href="<?php echo base_url(); ?>product/slot"><i class="fa fa-circle-o"></i> Slot Timing</a></li>
                    <li><a href="<?php echo base_url(); ?>product/pickup_point"><i class="fa fa-circle-o"></i>Pickup point</a></li>
                    <li><a href="<?php echo base_url(); ?>product/pincode"><i class="fa fa-circle-o"></i> Pincode</a></li>
                    <li><a href="<?php echo base_url(); ?>product/coupon"><i class="fa fa-circle-o"></i>Coupon</a></li>
                    <li><a href="<?php echo base_url(); ?>product/set_min_limit"><i class="fa fa-circle-o"></i>Set Min Limit</a></li>
                    <li><a href="<?php echo base_url(); ?>product/order_limit"><i class="fa fa-circle-o"></i>Order Limit</a></li>

                    <li><a href="<?php echo base_url(); ?>product/notification"><i class="fa fa-circle-o"></i>Notification</a></li> -->


                  </ul>
                </li>
                <!-- <li>
                  <a href="javaScript:void();" class="waves-effect">
                    <i class="icon-briefcase"></i>
                    <span>Offer & Hot Product </span> <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="sidebar-submenu">

                    <li><a href="<?php echo base_url(); ?>product/offer"><i class="fa fa-circle-o"></i>Offer</a></li>
                    <li><a href="<?php echo base_url(); ?>product/today_offer"><i class="fa fa-circle-o"></i>Today's Offer</a></li>
                    <li><a href="<?php echo base_url(); ?>product/hot_product"><i class="fa fa-circle-o"></i>Hot Product</a></li>
                    <li><a href="<?php echo base_url(); ?>product/web_product"><i class="fa fa-circle-o"></i>Web Category</a></li>
                  </ul>
                </li> -->

                <li>
                  <a href="javaScript:void();" class="waves-effect">
                    <i class="icon-briefcase"></i>
                    <span>Product</span> <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="sidebar-submenu">

                    <li><a href="<?php echo base_url(); ?>product/upload_product"><i class="fa fa-circle-o"></i> Upload Product</a></li>
                    <li><a href="<?php echo base_url(); ?>product/product_list"><i class="fa fa-circle-o"></i> Product List</a></li>
                    <li><a href="<?php echo base_url(); ?>product/out_of_stock_p"><i class="fa fa-circle-o"></i>Out of stock product</a></li>
                    <!--<li><a href="<?php echo base_url(); ?>product/import_product"><i class="fa fa-circle-o"></i> Bulk Product Upload</a></li>--->
                    <li><a href="<?php echo base_url(); ?>product/out_of_stock_product"><i class="fa fa-circle-o"></i> Bulk Stock Update</a></li>
                    <li><a href="<?php echo base_url(); ?>product/bulk_price_product"><i class="fa fa-circle-o"></i> Bulk Price Update</a></li>
                  </ul>
                </li>

              <?php } ?>


              <!--<li>
        <a href="javaScript:void();" class="waves-effect">
          <i class="icon-briefcase"></i>
          <span>Purchase </span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="sidebar-submenu">
           <?php if ($login_type != '0' && $employee_id == '0') { ?>   
  		  <li><a href="<?php echo base_url(); ?>purchse/supplier"><i class="fa fa-circle-o"></i>Supplier master</a></li>
  		  <li><a href="<?php echo base_url(); ?>purchse/purchse_entry"><i class="fa fa-circle-o"></i> Add purchase entry</a></li>
  		  <?php } ?>
  		  <li><a href="<?php echo base_url(); ?>purchse/purchse_list"><i class="fa fa-circle-o"></i>purchase list</a></li>
  		  <li><a href="<?php echo base_url(); ?>purchse/stock"><i class="fa fa-circle-o"></i>Avilable Stock</a></li>
        </ul>
      </li>-->

              <li>
                <a href="javaScript:void();" class="waves-effect">
                  <i class="icon-layers"></i>
                  <span>Order</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                  <?php $login_type   = $this->session->userdata('type');
                  if ($login_type != '0') { ?>
                    <li><a href="<?php echo base_url(); ?>sales/manually_order_entry"><i class="fa fa-circle-o"></i>Manually Order Entry </a></li>
                  <?php } ?>
                  <li><a href="<?php echo base_url(); ?>sales"><i class="fa fa-circle-o"></i>Today Order</a></li>
                  <li><a href="<?php echo base_url(); ?>sales/total_sales"><i class="fa fa-circle-o"></i>Total Order </a></li>
                  <li><a href="<?php echo base_url(); ?>sales/pending_sales"><i class="fa fa-circle-o"></i>Pending Order </a></li>
                  <li><a href="<?php echo base_url(); ?>sales/dispatch_sales"><i class="fa fa-circle-o"></i>Dispatch Order </a></li>
                  <li><a href="<?php echo base_url(); ?>sales/deliver_sales"><i class="fa fa-circle-o"></i>Dlivered Order </a></li>
                  <li><a href="<?php echo base_url(); ?>sales/itemwise_pending_sales"><i class="fa fa-circle-o"></i>Item Wise Pending Order </a></li>
                  <li><a href="<?php echo base_url(); ?>sales/assign_sales"><i class="fa fa-circle-o"></i>Assign Order </a></li>
                  <li><a href="<?php echo base_url(); ?>sales/assign_not_deliver"><i class="fa fa-circle-o"></i>Assign but not deliverd</a></li>
                  <li><a href="<?php echo base_url(); ?>sales/cancel_sales"><i class="fa fa-circle-o"></i>Cancel Order (Paid) </a></li>
                  <li><a href="<?php echo base_url(); ?>sales/cancel_sales1"><i class="fa fa-circle-o"></i>Cancel Order (Unpaid) </a></li>
                  <li><a href="<?php echo base_url(); ?>sales/return_product"><i class="fa fa-circle-o"></i>Return product list </a></li>

                </ul>
              </li>

              <li>
                <a href="javaScript:void();" class="waves-effect">
                  <i class="icon-user"></i>
                  <span>Customer</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                  <li><a href="<?php echo base_url(); ?>customer"><i class="fa fa-circle-o"></i>Customer List</a></li>
                  <li><a href="<?php echo base_url(); ?>customer/inactive_customer"><i class="fa fa-circle-o"></i>Inactive Customer List</a></li>
                  <li><a href="<?php echo base_url(); ?>customer/credit_wallet"><i class="fa fa-circle-o"></i>Credit customer wallet</a></li>
                </ul>
              </li>


              <li>
                <a href="javaScript:void();" class="waves-effect">
                  <i class="icon-briefcase"></i>
                  <span>Payment Details</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                  <li><a href="<?php echo base_url(); ?>sales/total_payment"><i class="fa fa-circle-o"></i>Total Payment</a></li>
                  <li><a href="<?php echo base_url(); ?>sales/cash_payment"><i class="fa fa-circle-o"></i>Cash Payment</a></li>
                  <li><a href="<?php echo base_url(); ?>sales/online_payment"><i class="fa fa-circle-o"></i> Online Payment</a></li>
                  <li><a href="<?php echo base_url(); ?>sales/refund_payment"><i class="fa fa-circle-o"></i> Refund Payment</a></li>
                </ul>
              </li>

              <li>
                <a href="javaScript:void();" class="waves-effect">
                  <i class="icon-docs"></i>
                  <span>Report</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                  <li><a href="<?php echo base_url(); ?>report/sales_report"><i class="fa fa-circle-o"></i>Sales Report</a></li>
                  <li><a href="<?php echo base_url(); ?>report/product_wise_report"><i class="fa fa-circle-o"></i>Product Wise Report </a></li>
                  <!--<li><a href="<?php echo base_url(); ?>report/saller_wise_sales_report"><i class="fa fa-circle-o"></i>Saller Wise Sale  </a></li>-->
                  <!--<li><a href="<?php echo base_url(); ?>report/saller_commisssion_report"><i class="fa fa-circle-o"></i>Saller Commison Report  </a></li>-->
                  <!--
  		  <li><a href="<?php echo base_url(); ?>report/purchse_report"><i class="fa fa-circle-o"></i>Purchase Report</a></li>
  		  <li><a href="<?php echo base_url(); ?>report/purchse_report1"><i class="fa fa-circle-o"></i>Total Purchase Stock</a></li>-->
                </ul>
              </li>



              <li>
                <a href="<?php echo base_url(); ?>product/change_password" class="waves-effect">
                  <i class="icon-share"></i> <span>Change password</span>
                </a>

              </li>
              <li><a href="<?php echo base_url(); ?>login/admin_logout" class="waves-effect"><i class="icon-logout"></i> <span>Logout</span></a></li>
            </ul>
          <?php } else { ?>

            <?php
            $CI = &get_instance();
            $CI->load->model('Product_model');
            $result1 = $CI->Product_model->get_emp_access($employee_id);
            ?>


            <ul class="sidebar-menu do-nicescrol">
              <li>
                <a href="<?php echo base_url(); ?>dashboard" class="waves-effect">
                  <i class="icon-home"></i> <span>Dashboard</span>
                </a>

              </li>
              <li>
                <a href="javaScript:void();" class="waves-effect">
                  <i class="icon-settings"></i>
                  <span>Setting</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                  <?php if ($result1->d_master == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>product/designation"><i class="fa fa-circle-o"></i>Designation master</a></li>
                  <?php } ?>
                  <?php if ($result1->e_master == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>product/employee"><i class="fa fa-circle-o"></i>Employee master</a></li>
                  <?php } ?>
                  <?php if ($result1->z_master == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>product/zone"><i class="fa fa-circle-o"></i>Zone master</a></li>
                  <?php } ?>
                  <?php if ($result1->a_master == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>product/area"><i class="fa fa-circle-o"></i>Area master</a></li>
                  <?php } ?>
                  <?php if ($result1->banner == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>product/banner"><i class="fa fa-circle-o"></i> Banner</a></li>
                  <?php } ?>
                  <?php if ($result1->brand == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>product/brands"><i class="fa fa-circle-o"></i> Brand</a></li>
                  <?php } ?>
                  <?php if ($result1->category == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>product/category"><i class="fa fa-circle-o"></i> Category</a></li>
                  <?php } ?>
                  <?php if ($result1->subcategory == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>product/subcategory"><i class="fa fa-circle-o"></i> Subcategory</a></li>
                  <?php } ?>
                  <?php if ($result1->sub_subcategory == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>product/sub_subcategory"><i class="fa fa-circle-o"></i> Sub Subcategory</a></li>
                  <?php } ?>
                  <?php if ($result1->slot == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>product/slot_time"><i class="fa fa-circle-o"></i> Slot Timing</a></li>
                  <?php } ?>
                  <?php if ($result1->pickup == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>product/pickup_point"><i class="fa fa-circle-o"></i>Pickup point</a></li>
                  <?php } ?>
                  <?php if ($result1->pincode == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>product/pincode"><i class="fa fa-circle-o"></i> Pincode</a></li>
                  <?php } ?>
                  <?php if ($result1->coupon == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>product/coupon"><i class="fa fa-circle-o"></i>Coupon</a></li>
                  <?php } ?>
                  <?php if ($result1->minlimit == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>product/set_min_limit"><i class="fa fa-circle-o"></i>Set Min Limit</a></li>
                  <?php } ?>
                  <?php if ($result1->olimit == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>product/order_limit"><i class="fa fa-circle-o"></i>Order Limit</a></li>
                  <?php } ?>

                </ul>
              </li>


              <li>
                <a href="javaScript:void();" class="waves-effect">
                  <i class="icon-briefcase"></i>
                  <span>Product</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                  <?php if ($result1->u_product == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>product/upload_product"><i class="fa fa-circle-o"></i> Upload Product</a></li>
                  <?php } ?>
                  <?php if ($result1->l_product == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>product/product_list"><i class="fa fa-circle-o"></i> Product List</a></li>
                  <?php } ?>
                  <?php if ($result1->stock_update == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>product/out_of_stock_product"><i class="fa fa-circle-o"></i> Bulk Stock Update</a></li>
                  <?php } ?>
                  <?php if ($result1->price_update == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>product/bulk_price_product"><i class="fa fa-circle-o"></i> Bulk Price Update</a></li>
                  <?php } ?>

                </ul>
              </li>



              <li>
                <a href="javaScript:void();" class="waves-effect">
                  <i class="icon-briefcase"></i>
                  <span>Purchase </span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                  <?php if ($result1->supplier == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>purchse/supplier"><i class="fa fa-circle-o"></i>Supplier master</a></li>
                  <?php } ?>
                  <?php if ($result1->purchse_entry == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>purchse/purchse_entry"><i class="fa fa-circle-o"></i> Add purchase entry</a></li>
                  <?php } ?>
                  <?php if ($result1->purchse_list == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>purchse/purchse_list"><i class="fa fa-circle-o"></i>purchase list</a></li>
                  <?php } ?>
                  <?php if ($result1->stock_list == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>purchse/stock"><i class="fa fa-circle-o"></i>Avilable Stock</a></li>
                  <?php } ?>
                </ul>
              </li>


              <li>
                <a href="javaScript:void();" class="waves-effect">
                  <i class="icon-layers"></i>
                  <span>Order</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                  <?php if ($result1->manually == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>sales/manually_order_entry"><i class="fa fa-circle-o"></i>Manually Order Entry </a></li>
                  <?php } ?>
                  <?php if ($result1->t_order == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>sales"><i class="fa fa-circle-o"></i>Today Order</a></li>
                  <?php } ?>
                  <?php if ($result1->to_order == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>sales/total_sales"><i class="fa fa-circle-o"></i>Total Order </a></li>
                  <?php } ?>
                  <?php if ($result1->p_order == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>sales/pending_sales"><i class="fa fa-circle-o"></i>Pending Order </a></li>
                  <?php } ?>
                  <?php if ($result1->i_order == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>sales/itemwise_pending_sales"><i class="fa fa-circle-o"></i>Item Wise Pending Order </a></li>
                  <?php } ?>
                  <?php if ($result1->a_order == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>sales/assign_sales"><i class="fa fa-circle-o"></i>Assign Order </a></li>
                  <?php } ?>
                  <?php if ($result1->a_n_order == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>sales/assign_not_deliver"><i class="fa fa-circle-o"></i>Assign but not deliverd</a></li>
                  <?php } ?>
                  <?php if ($result1->dis_order == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>sales/dispatch_sales"><i class="fa fa-circle-o"></i>Dispatch Order </a></li>
                  <?php } ?>
                  <?php if ($result1->d_order == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>sales/deliver_sales"><i class="fa fa-circle-o"></i>Dlivered Order </a></li>
                  <?php } ?>
                  <?php if ($result1->c_order == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>sales/cancel_sales"><i class="fa fa-circle-o"></i>Cancel Order (Paid) </a></li>
                  <?php } ?>
                  <?php if ($result1->cc_order == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>sales/cancel_sales1"><i class="fa fa-circle-o"></i>Cancel Order (Unpaid) </a></li>
                  <?php } ?>
                  <?php if ($result1->r_order == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>sales/return_product"><i class="fa fa-circle-o"></i>Wastage product list </a></li>
                  <?php } ?>

                </ul>
              </li>


              <?php if ($result1->warehouse == 'Y') { ?>
                <li>
                  <a href="<?php echo base_url(); ?>sales/warehouse" class="waves-effect">
                    <i class="icon-folder-alt"></i> <span>Warehouse</span>
                  </a>

                </li>
              <?php } ?>



              <?php if ($result1->customer == 'Y') { ?>
                <li>
                  <a href="<?php echo base_url(); ?>Customer" class="waves-effect">
                    <i class="icon-user"></i> <span>Customer</span>
                  </a>

                </li>
              <?php } ?>



              <li>
                <a href="javaScript:void();" class="waves-effect">
                  <i class="icon-briefcase"></i>
                  <span>Payment Details</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                  <?php if ($result1->t_payment == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>sales/total_payment"><i class="fa fa-circle-o"></i>Total Payment</a></li>
                  <?php } ?>
                  <?php if ($result1->c_payment == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>sales/cash_payment"><i class="fa fa-circle-o"></i>Cash Payment</a></li>
                  <?php } ?>
                  <?php if ($result1->o_payment == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>sales/online_payment"><i class="fa fa-circle-o"></i> Online Payment</a></li>
                  <?php } ?>
                  <?php if ($result1->r_payment == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>sales/refund_payment"><i class="fa fa-circle-o"></i> Refund Payment</a></li>
                  <?php } ?>
                </ul>
              </li>

              <li>
                <a href="javaScript:void();" class="waves-effect">
                  <i class="icon-docs"></i>
                  <span>Report</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                  <?php if ($result1->s_report == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>report/sales_report"><i class="fa fa-circle-o"></i>Sales Report</a></li>
                    <li><a href="<?php echo base_url(); ?>report/purchse_report"><i class="fa fa-circle-o"></i>Purchase Report</a></li>
                    <li><a href="<?php echo base_url(); ?>report/purchse_report1"><i class="fa fa-circle-o"></i>Total Purchase Stock</a></li>
                  <?php } ?>
                  <?php if ($result1->p_report == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>report/product_wise_report"><i class="fa fa-circle-o"></i>Product Wise Report </a></li>
                  <?php } ?>
                </ul>
              </li>


              <li>
                <a href="javaScript:void();" class="waves-effect">
                  <i class="icon-note"></i>
                  <span>Bulk SMS</span> <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="sidebar-submenu">
                  <?php if ($result1->sms_customer == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>product/customer_sms"><i class="fa fa-circle-o"></i>Customer</a></li>
                  <?php } ?>
                  <?php if ($result1->sms_db == 'Y') { ?>
                    <li><a href="<?php echo base_url(); ?>product/db_sms"><i class="fa fa-circle-o"></i>Delivery boy </a></li>
                  <?php } ?>
                </ul>
              </li>

              <li>
                <a href="<?php echo base_url(); ?>product/change_password" class="waves-effect">
                  <i class="icon-share"></i> <span>Change password</span>
                </a>

              </li>
              <li><a href="<?php echo base_url(); ?>login/admin_logout" class="waves-effect"><i class="icon-logout"></i> <span>Logout</span></a></li>

            </ul>

          <?php } ?>

        </div>
        <!--End sidebar-wrapper-->

        <!--Start topbar header-->
        <header class="topbar-nav">
          <nav class="navbar navbar-expand fixed-top bg-white" style="background-color: #fff;
    box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16), 0 2px 10px 0 rgba(0,0,0,0.12);
    background: #010066;
    background-image: linear-gradient(to left bottom, #fdecf3, #fcf1f8, #fbf6fc, #fcfbfe, #ffffff);">
            <ul class="navbar-nav mr-auto align-items-center">
              <li class="nav-item">
                <a class="nav-link toggle-menu" href="javascript:void();">
                  <i class="icon-menu menu-icon" style="color:#E21476"></i>
                </a>
              </li>
              <li><?php if ($login_type == '0') { ?> <h1 style="font-size: 20px;color: #1476;margin-top: 7px;text-transform: uppercase;">Super adminpanel</h1> <?php } else { ?><h1 style="font-size: 20px;text-transform: uppercase;color: #E21476;margin-top: 7px;">Welcome to <?php echo $company_name ?></h1><?php } ?></li>
              <li>
                <div id="digital-clock" style="font-size: 20px;margin-left: 10px;color: #E21476;"></div>
              </li>

            </ul>

            <ul class="navbar-nav align-items-center right-nav-link">

              <li class="nav-item">
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown" href="#">
                  <span class="user-profile"><img src="https://www.lotuspens.com/image/catalog/logo.jpg" class="img-circle" alt="user avatar"></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-right">
                  <li class="dropdown-item user-details">
                    <a href="javaScript:void();">
                      <div class="media">
                        <div class="avatar"><img class="align-self-start mr-3" src="<?php echo base_url(); ?>assets/images/login.jpg" alt="user avatar"></div>
                        <div class="media-body">
                          <h6 class="mt-2 user-title"><?php echo $company_name ?></h6>
                          <p class="user-subtitle"><?php echo $company_phone ?></p>
                          <p class="user-subtitle"><?php echo $company_email ?></p>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li class="dropdown-divider"></li>

                  <a href="<?php echo base_url(); ?>login/admin_logout">
                    <li class="dropdown-item"><i class="icon-power mr-2"></i> Logout</li>
                  </a>
                </ul>
              </li>
            </ul>
          </nav>
        </header>