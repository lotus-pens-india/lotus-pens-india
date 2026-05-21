     <!--cart section-->
     <div class="container m-bt-30" id="main_cart_page_div">
         <div class="title-wrapper">
             <p class="title-headings">Profile</p>
         </div>
         <div class="row p-3">
             <div class="shadow-lg rounded-4 text-center">
                 <form id="msform">
                     <div class="row">
                         <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs text-start">
                             <label for="fname">First Name</label>
                             <input type="text" id="fname" name="fname" value="<?= $this->session->userdata('userdata')['full_name'] ?>">
                         </div>
                         <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs text-start">
                             <label for="lname">Last Name</label>
                             <input type="text" name="lname" id="lname" value="<?= $this->session->userdata('userdata')['full_name'] ?>">
                         </div>
                         <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs text-start">
                             <label for="email">Email</label>
                             <input type="text" id="email" name="email" value="<?= $this->session->userdata('userdata')['email_id'] ?>">
                         </div>
                         <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs text-start">
                             <label for="phone">Telephone</label>
                             <input type="text" id="phone" name="phone" value="<?= $this->session->userdata('userdata')['mobile_no'] ?>">
                         </div>

                     </div>
                     <div class="row">
                         <div class="col-12 text-end">
                             <button type="submit" name="next" class="next-checkout-btn btn btn-primary float-end m-3" style="width: auto;">
                                 <h5>Next</h5>
                             </button>
                         </div>
                     </div>
                 </form>
             </div>
         </div>
     </div>