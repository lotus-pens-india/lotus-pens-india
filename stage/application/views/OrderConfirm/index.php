   <div class="container m-bt-30" id="main_cart_page_div">
       <div class="title-wrapper">
           <p class="title-headings">Order Confirm</p>
       </div>
       <div class="row p-3">
           <div class="shadow-lg rounded-4 text-center">
               <div class="col-12 p-4">
                   <img src='<?= base_url() ?>assets/images/order_confirm.svg' style="width:100%" />
               </div>

               <div class="col-12 ">
                   <h5 style="word-wrap:break-word">Order #<?= $order_number ?> Confirmed</h5>
                   <p>Order #<?= $order_number ?> is confirmed! Your items are on their way to you. If you need updates, our customer service team is here to assist you.</p>
               </div>

               <div class="col-12 pt-3 pb-3"><a class="btn btn-primary" href="<?= base_url() ?>">Explore Products</a></div>
           </div>
       </div>
   </div>