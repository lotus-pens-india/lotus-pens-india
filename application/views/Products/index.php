     <!--cart section-->
     <div class="container m-bt-30">
         <div class="title-wrapper">
             <p class="title-headings">Products</p>
         </div>
         <div class="row product-wrapper">
             <?php
                if (isset($products) && is_array($products)) {

                    foreach ($products as $product) {
                ?>


                     <div class="col-xs-6 col-sm-6 col-md-6 col-lg-3">
                         <div class="img-wrapper">
                             <img src="<?= base_url('lotus_pens_admin/assets/') ?>images/product/<?= $product['main_image'] ?>" />
                             <div class="img-overview">
                                 <a class="overview-link" type="button" onclick="openQuickView('<?= base_url('lotus_pens_admin/assets/') ?>images/product/<?= $product['main_image'] ?>')">Quick View</a>
                                 <a class="overview-link" href="<?= base_url() ?>product/<?= $product['product_id'] ?>">Explore</a>
                             </div>
                         </div>
                         <a href="<?= base_url() ?>product/<?= $product['product_id'] ?>" style="cursor:pointer;text-decoration:none;color:black">
                             <!-- <p class="best-seller-title">Bestseller</p> -->
                             <p class="product-name"><?= $product['product_name'] ?></p>
                             <!-- <p class="product-colors">4 Colours</p> -->
                             <p class="product-amount"><?= $this->session->userdata('currency_symbol') . "" . $product['unit_price'] ?></p>
                         </a>
                     </div>

             <?php }
                }
                ?>

         </div>
     </div>
     <script src="<?= base_url('assets/') ?>lib/js/jquery-3.6.4.min.js"></script>
     <script src="<?= base_url('assets/') ?>js/cart.js"></script>