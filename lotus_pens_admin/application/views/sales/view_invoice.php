<div class="clearfix"></div>

<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title">Invoice</h4>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="javaScript:void();">Sales</a></li>
          <li class="breadcrumb-item"><a href="javaScript:void();">View Invoice</a></li>
          <li class="breadcrumb-item active" aria-current="page">Invoice</li>
        </ol>
      </div>
      <div class="col-sm-3">

      </div>
    </div>
    <!-- End Breadcrumb-->
    <div class="card">
      <div class="card-body">
        <!-- Content Header (Page header) -->

        <!-- Main content -->
        <section class="invoice">
          <!-- title row -->
          <div class="row mt-3">

            <div class="col-lg-2">
              <img src="https://www.lotuspens.com/image/catalog/logo.jpg" style="height:65px;    margin-top: -18px;">
            </div>
            <div class="col-lg-3">
              <h5>
                Invoice
                <small>#<?php echo $order_summary->order_generate_id; ?></small>
              </h5>
            </div>
            <div class="col-lg-2">
              <h6 class="float-sm-right">Date: <?php echo $order_summary->order_date; ?></h6>
            </div>

            <div class="col-lg-2">
              <?php
              if ($order_summary->payment_status == '0') {
                $a = 'Unpaid';
              } elseif ($order_summary->payment_status == '1') {
                $a = 'Paid';
              }
              ?>
              <select class="form-control single-select" name="payment_status" id="update_payment_status">
                <option value="<?php echo $order_summary->payment_status ?>"><?php echo $a ?></option>
                <option value="1">Paid</option>
                <option value="0">Unpaid</option>
              </select>
            </div>
            <div class="col-lg-2">
              <?php
              if ($order_summary->status == '0') {
                $ab = 'Pending';
              } elseif ($order_summary->status == '1') {
                $ab =  'Confirm';
              } elseif ($order_summary->status == '2') {
                $ab = 'Dispatch';
              } elseif ($order_summary->status == '3') {
                $ab =  'Delivered';
              } elseif ($order_summary->status == '4') {
                $ab =  'Cancel';
              }
              ?>
              <select class="form-control single-select" name="status" id="deliver_status">
                <option value="<?php echo $order_summary->status ?>"><?php echo $ab ?></option>
                <option value="2">Dispatch</option>
                <option value="4">Cancel</option>
                <option value="3">Deliver</option>
              </select>

            </div>

          </div>
          <hr>
          <div class="row invoice-info">
            <div class="col-sm-5 invoice-col">
              From
              <address>
                <strong><?php echo $order_summary->first_name . ' ' . $order_summary->last_name; ?></strong><br>
                <?php echo $order_summary->deliver_address; ?><br>
                Phone:<?php echo $order_summary->mobile_no; ?><br>
                Email: <?php echo $order_summary->email_id; ?>
              </address>
            </div><!-- /.col -->

            <div class="col-sm-4 invoice-col">
              <b>Invoice #<?php echo $order_summary->order_generate_id; ?></b><br>
              <br>
              <b>Payment Mode:</b><?php if ($order_summary->p_mode == '0') {
                                    echo 'Cash on delivery';
                                  } elseif ($order_summary->p_mode == '1') {
                                    echo 'Online payment';
                                  } elseif ($order_summary->p_mode == '3') {
                                    echo 'Wallet';
                                  } ?><br>
              </b>
            </div><!-- /.col -->
            <div class="col-sm-3 invoice-col">
              <b>Order Status :
                <?php
                if ($order_summary->status == '0') {
                  echo '<span class="badge badge-danger shadow-danger m-1">Pending</span>';
                } elseif ($order_summary->status == '1') {
                  echo  '<span class="badge badge-success shadow-success m-1">Confirm</span>';
                } elseif ($order_summary->status == '2') {
                  echo '<span class="badge badge-info shadow-info m-1">Dispatch</span>';
                } elseif ($order_summary->status == '3') {
                  echo  '<span class="badge badge-primary shadow-primary m-1">Delivered</span>';
                } elseif ($order_summary->status == '4') {
                  echo  '<span class="badge badge-danger shadow-danger m-1">Cancel</span><br>' . $order_summary->cancel_resion;
                }
                ?>

              </b><br>
              <b>Payment Status :
                <?php
                if ($order_summary->payment_status == '0') {
                  echo '<span class="badge badge-danger shadow-danger m-1">Unpaid</span>';
                } elseif ($order_summary->payment_status == '1') {
                  echo  '<span class="badge badge-success shadow-success m-1">Paid</span>';
                }
                ?>

              </b>

            </div><!-- /.col -->
          </div><!-- /.row -->

          <!-- Table row -->
          <div class="row">
            <div class="col-12 table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Qty</th>
                    <th>Product</th>
                    <th>Description</th>
                    <th>Unit Price</th>
                    <th>Discount</th>
                    <th>Subtotal</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php

                  $CI = &get_instance();
                  $CI->load->model('product_model');
                  $result = $CI->product_model->get_item_details1($order_summary->order_id);
                  $sum = 0;
                  foreach ($result as $p_detail) {
                  ?>
                    <tr>
                      <td><?php echo $p_detail->qty; ?></td>
                      <td><?php echo $p_detail->product_name; ?></td>
                      <td>
                        <p style="font-size:10px">
                          <?php echo "CLip Option:" . $p_detail->clip_option; ?>,<?php echo "CLip and Ring:" . $p_detail->clip_and_ring; ?><br>
                          <?php echo "Material:" . $p_detail->material; ?>,<?php echo "Nib:" . $p_detail->nib; ?>
                        </p>
                      </td>
                      <td><?php echo $p_detail->unit_price; ?></td>
                      <td><?php echo $p_detail->discount * $p_detail->qty; ?></td>
                      <td>
                        <?php
                        $a = ($p_detail->qty * $p_detail->unit_price);
                        if ($p_detail->discount > 0) {
                          $b = $p_detail->discount * $p_detail->qty;
                          $sum += $a - $b;
                          echo $sub_total = $a - $b;
                        } else {
                          $sum += $a;
                          echo $sub_total = $a;
                        }
                        ?>
                      </td>
                      <td>
                        <?php
                        if ($p_detail->flag == '1' && $order_summary->status == '3') {
                          echo '<span class="badge badge-danger shadow-danger m-1">Cancel </span>';
                        } elseif ($p_detail->flag == '0' && $order_summary->status == '3') {
                          echo  '<span class="badge badge-success shadow-success m-1">Deliverd</span>';
                        } elseif ($order_summary->status == '0') {
                          echo  '<span class="badge badge-warning shadow-warning m-1">Pending</span>';
                        } elseif ($p_detail->flag == '2' && $order_summary->status == '2') {
                          echo  '<span class="badge badge-info shadow-info m-1">Dispatch</span>';
                        }
                        ?>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div><!-- /.col -->
          </div><!-- /.row -->

          <div class="row">
            <!-- accepted payments column -->
            <div class="col-lg-6 payment-icons">


            </div><!-- /.col -->
            <div class="col-lg-12">
              <div class="table-responsive">
                <table class="table">
                  <tbody>

                    <tr>
                      <th colspan="4"></th>
                      <th style="width:20%">Total Unit Price:</th>
                      <td>Rs. <?php echo $order_summary->order_total; ?></td>
                    </tr>
                    <tr>
                      <th colspan="4"></th>
                      <th>Total Savings :</th>
                      <td>Rs. 0</td>
                    </tr>
                    <?php if ($order_summary->wallet_use > 0) { ?>
                      <tr>
                        <th colspan="4"></th>
                        <th>Wallet Use :</th>
                        <td>Rs. <?php echo $order_summary->wallet_use; ?> </td>
                      </tr>
                    <?php } ?>
                    <tr>
                      <th colspan="4"></th>
                      <th style="width:50%">Subtotal:</th>
                      <td>Rs. <?php echo $order_summary->order_total; ?></td>
                    </tr>
                    <tr>
                      <th colspan="4"></th>
                      <th>Delivery Charge :</th>
                      <td> <?php if ($order_summary->delivery_charges == '0') {
                              echo 'Free';
                            } else { ?>Rs. <?php echo round($order_summary->delivery_charges) . ' ' . '+';
                                          } ?></td>
                    </tr>
                    <tr>
                      <th colspan="4"></th>
                      <th style="width:50%">Grand Total :</th>
                      <td>Rs. <?php echo $order_summary->order_total; ?></td>
                    </tr>
                    
                  </tbody>
                </table>
              </div>
            </div><!-- /.col -->
          </div><!-- /.row -->

          <!-- this row will not appear when printing -->
          <hr>
        </section><!-- /.content -->
      </div>
    </div>

    <!--start overlay-->
    <div class="overlay toggle-menu"></div>
    <!--end overlay-->
  </div>
  <!-- End container-fluid-->


  <script type="text/javascript">
    $('#update_payment_status').on('change', function() {
      var order_id = <?php echo $order_summary->order_id ?>;
      var status = $('#update_payment_status').val();

      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>sales/payment_update",
        data: {
          'order_id': order_id,
          'status': status
        },
        success: function(id) {
          window.location.href = "<?php echo base_url(); ?>sales/view_invoice?order_id=<?php echo $order_summary->order_generate_id ?>";

        }
      });


    });
  </script>
  <script type="text/javascript">
    $('#deliver_status').on('change', function() {
      var order_id = <?php echo $order_summary->order_id ?>;
      var status = $('#deliver_status').val();

      $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>sales/deliver_status",
        data: {
          'order_id': order_id,
          'status': status
        },
        success: function(id) {
          window.location.href = "<?php echo base_url(); ?>sales/view_invoice?order_id=<?php echo $order_summary->order_generate_id ?>";

        }
      });


    });
  </script>