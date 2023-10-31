     <!--cart section-->
     <div class="container m-bt-30" id="main_cart_page_div">
         <div class="title-wrapper">
             <p class="title-headings">My Orders</p>
         </div>
         <div class="row p-3">
             <div class=" text-center">
                 <div class="row">
                     <?php
                        if (isset($orderData) && count($orderData) > 0) {
                            foreach ($orderData as $orderDetails) { ?>
                             <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs text-start p-0">
                                 <div class="shadow-lg rounded-4 p-4 m-2">
                                     <h4>Order Id : <?= $orderDetails['order_generate_id'] ?></h4>
                                     <h6>Order Date : <?= date_format(date_create($orderDetails['order_date']), 'Y-m-d') ?></h6>
                                     <h6>Total Items : <?= $orderDetails['total_items'] ?></h6>
                                     <h6>Order Total : <?= $orderDetails['order_total'] ?></h6>
                                     <h6>On the Way</h6>
                                 </div>
                             </div>
                     <?php }
                        }
                        ?>

                 </div>
             </div>
         </div>
     </div>