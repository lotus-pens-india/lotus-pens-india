     <!--cart section-->
     <div class="container m-bt-30" id="main_cart_page_div">
         <div class="title-wrapper">
             <p class="title-headings">Shopping Cart</p>
         </div>
         <div class="row cart">
             <div class="col-12 col-lg-8 col-md-8 col-sm-12 ">
                 <div class="shadow-lg  rounded-4 my-2 p-2" id="cart_items_div">
                 </div>
             </div>
             <div class="col-12 col-lg-4 col-md-4 col-sm-12">
                 <div class="shadow-lg rounded-4 my-2 p-2">
                     <form id="cart_form">
                         <div class="container">
                             <div class="accordion" id="accordionExample">
                                 <div class="accordion-item px-2" style="border: 0;">
                                     <h2 class="accordion-header" id="headingOne" style="border: 0;text-align-last: start">
                                         <label data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                             <h5>Use Coupon Code ></h5>
                                         </label>
                                     </h2>
                                     <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                         <div class="">
                                             <div class="col-12 col-lg-12 col-md-12 col-sm-12 form-inputs">
                                                 <div class="row">
                                                     <div class="col-8 col-lg-8 col-md-12 col-sm-12">
                                                         <input type="text" id="coupon_code" name="coupon_code">
                                                     </div>
                                                     <div class="col-4 col-lg-4 col-md-12 col-sm-12">
                                                         <button class="btn btn-primary">Apply</button>
                                                     </div>
                                                 </div>
                                                 </span>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <hr>
                                 <!-- <div class="accordion-item px-2" style="border: 0;">
                                     <h2 class="accordion-header" id="headingOne" style="border: 0;text-align-last: start">
                                         <label data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                             <h5>Estimate Shipping and Taxes ></h5>
                                         </label> 
                                     </h2>
                                     <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                         <div class="">
                                             <div class="col-12 col-lg-12 col-md-12 col-sm-12 form-inputs">
                                                 <div class="col-12 col-lg-12 col-md-12 col-sm-12 form-inputs mt-2">
                                                     <div class="dropdown">
                                                         <button class="btn dropdown-toggle options-title-items" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                             <p class="title-first">Country</p>
                                                         </button>
                                                         <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                             <li><a class="dropdown-item">India</a></li>
                                                             <li><a class="dropdown-item">USA</a></li>
                                                             <li><a class="dropdown-item">Austrolia</a></li>
                                                         </ul>
                                                     </div>
                                                 </div>
                                                 <div class="col-12 col-lg-12 col-md-12 col-sm-12 form-inputs mt-2">
                                                     <div class="dropdown">
                                                         <button class="btn dropdown-toggle options-title-items" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                             <p class="title-first">Region / State</p>
                                                         </button>
                                                         <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                             <li><a class="dropdown-item">Maharashtra</a></li>
                                                             <li><a class="dropdown-item">Chennai</a></li>
                                                             <li><a class="dropdown-item">Tamilnadu</a></li>
                                                         </ul>
                                                     </div>
                                                 </div>
                                                 <div class="col-12 col-lg-12 col-md-12 col-sm-12 form-inputs mt-2">
                                                     <label for="postal_code_cart">Postal Code</label>
                                                     <input type="text" id="postal_code_cart" name="postal_code_cart">
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <hr> -->
                                 <div class="accordion-item px-2" style="border: 0;">
                                     <h2 class="accordion-header" id="headingOne" style="border: 0;text-align-last: start">
                                         <label data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                             <h5>Use Gift Card ></h5>
                                         </label>
                                     </h2>
                                     <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                         <div class="">
                                             <div class="col-12 col-lg-12 col-md-12 col-sm-12 form-inputs">
                                                 <input type="text" id="coupon_code" name="coupon_code">
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <hr>
                                 <div class="order-total">
                                     <div class="w-100">
                                         <label>
                                             <h5>Order Value</h5>
                                         </label>
                                         <label class="float-end">
                                             <h5><?= $this->session->userdata('currency_symbol') ?> <span id="summary_price">0</span></h5>
                                         </label>
                                     </div>
                                     <div class="w-100">
                                         <label>
                                             <h5>Delivery</h5>
                                         </label>
                                         <label class="float-end">
                                             <h5>Free</h5>
                                         </label>
                                     </div>
                                 </div>
                                 <div class="order-final-total">
                                     <div class="w-100">
                                         <label>
                                             <h4>Total</h4>
                                         </label>
                                         <label class="float-end">
                                             <h4><?= $this->session->userdata('currency_symbol') ?> <span id="summary_price_total">0</span></h4>
                                         </label>
                                     </div>

                                 </div>
                                 <div class="w-100">
                                     <button class="btn btn-primary w-100" type="button" onclick="processToCheckout()">
                                         <h5>Continue To Checkout</h5>
                                     </button>
                                 </div>
                             </div>
                         </div>
                     </form>
                 </div>
             </div>
         </div>
     </div>
     <script src="<?= base_url('assets/') ?>lib/js/jquery-3.6.4.min.js"></script>
     <script src="<?= base_url('assets/') ?>js/cart.js"></script>