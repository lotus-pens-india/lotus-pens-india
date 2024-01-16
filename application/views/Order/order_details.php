     <!--cart section-->
     <div class="container m-bt-30" id="main_cart_page_div">
         <div class="title-wrapper">
             <p class="title-headings">My Orders</p>
         </div>
         <div class="row p-3">
             <div class=" text-center">
                 <div class="row shadow-lg rounded-4 p-4 m-2">
                    <?php
                    var_dump($orderData[0]);
                    ?>
                     <div class="col-sm-12 col-md-12 col-lg-6 p-0 text-start">
                         <h5>Order Number : <?= $orderData[0]['order_generate_id']?$orderData[0]['order_generate_id']:''?></h5>
                     </div>
                     <div class="col-sm-12 col-md-12 col-lg-6 p-0 text-start text-xs-start text-sm-start text-md-start text-lg-end">
                         <h5>Order Date : <?= date('d-m-Y',$orderData[0]['order_date'])?></h5>
                     </div>
                     <div class="col-sm-12 col-md-12 col-lg-6 p-0 text-start">
                         <h5>Billing Address</h5>
                         <p>asdkjfsdf
                             sdfjbskjdfm
                             kjsgdfgsdf
                             jbhjdsfj
                         </p>
                     </div>
                     <div class="col-sm-12 col-md-12 col-lg-6 p-0 text-start text-xs-start text-sm-start text-md-start text-lg-end">
                         <h5>Shipping Address</h5>
                         <p>asdkjfsdf
                             sdfjbskjdfm
                             kjsgdfgsdf
                             jbhjdsfj
                         </p>
                     </div>
                     <div class="col-12 text-start p-0">
                         <table style="width: 100%" class="p-2 m-2">
                             <tr>
                                 <td width="15%"> <img src="<?= base_url() ?>lotus_pens_admin/assets/images/product/sand1.jpg" style="width:100px;height:100px"></td>
                                 <td width="10%"> 1</td>
                                 <td width="20%"> LOTUS SHIKHAR IN SANDALWOOD</td>
                                 <td width="30%">
                                     <p>With Clip,JOWo FE, Black, Black Stain</p>
                                 </td>
                                 <td width="10%">2</td>
                                 <td width="15%">130</td>
                             </tr>
                             <tr>

                                 <td colspan="4">

                                 </td>
                                 <td>
                                     <h5>Total</h5>
                                 </td>
                                 <td>
                                     <h5>130</h5>
                                 </td>
                             </tr>
                         </table>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     </div>