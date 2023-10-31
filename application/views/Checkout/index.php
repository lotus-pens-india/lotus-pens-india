<!--checkout section-->
<style>
  .filters {
    position: relative;
    width: 100%;
  }

  .section-services .custom-select {
    height: inherit;
    padding: 0 20px;
    line-height: inherit;
    font-size: 14px;
    font-weight: bold;
    border-radius: 5px;
    padding-left: 20px;
    padding-right: 20px;
    padding-top: 5px;
    padding-bottom: 5px;
    color: #000;
  }

  .select-club-services {
    --max-scroll: 8;
    --text: #191919;
    --border: #687898;
    --borderActive: #fff;
    --background: #fff;
    --arrow: #6C7486;
    --arrowActive: #E4ECFA;
    --listText: #191919;
    --listBackground: #F9F0F4;
    --listActive: #E5BDCF;
    --listTextActive: #6C7486;
    --listBorder: none;
    --textFilled: #191919;
    width: 220px;
    position: relative;
  }

  .select-club-services select {
    display: none;
  }

  .select-club-services>span {
    cursor: pointer;
    padding: 9px 16px;
    border-radius: 5px;
    display: block;
    position: relative;
    color: var(--text);
    border: 1px solid var(--border);
    background: var(--background);
    -webkit-transition: all .3s ease;
    transition: all .3s ease;
    background-color: #fff;
    box-shadow: 0 0 3px 2px rgb(0 0 0 / 29%);
    border-radius: 5px;
  }

  .select-club-services>span:before,
  .select-club-services>span:after {
    content: '';
    display: block;
    position: absolute;
    width: 8px;
    height: 2px;
    border-radius: 1px;
    top: 50%;
    right: 15px;
    background: var(--arrow);
    -webkit-transition: all .3s ease;
    transition: all .3s ease;
  }

  .select-club-services>span:before {
    margin-right: 4px;
    -webkit-transform: scale(0.96, 0.8) rotate(50deg);
    transform: scale(0.96, 0.8) rotate(50deg);
  }

  .select-club-services>span:after {
    -webkit-transform: scale(0.96, 0.8) rotate(-50deg);
    transform: scale(0.96, 0.8) rotate(-50deg);
  }

  .select-club-services ul {
    margin: 0;
    padding: 0;
    list-style: none;
    opacity: 0;
    visibility: hidden;
    position: absolute;
    max-height: calc(var(--max-scroll) * 42px);
    top: 42px;
    left: 0;
    z-index: 1;
    right: 0;
    background: var(--listBackground);
    border-radius: 6px;
    overflow-x: hidden;
    overflow-y: auto;
    -webkit-transform-origin: 0 0;
    transform-origin: 0 0;
    -webkit-transition: opacity 0.2s ease, visibility 0.2s ease, -webkit-transform 0.3s cubic-bezier(0.4, 0.6, 0.5, 1.32);
    transition: opacity 0.2s ease, visibility 0.2s ease, -webkit-transform 0.3s cubic-bezier(0.4, 0.6, 0.5, 1.32);
    transition: opacity 0.2s ease, visibility 0.2s ease, transform 0.3s cubic-bezier(0.4, 0.6, 0.5, 1.32);
    transition: opacity 0.2s ease, visibility 0.2s ease, transform 0.3s cubic-bezier(0.4, 0.6, 0.5, 1.32), -webkit-transform 0.3s cubic-bezier(0.4, 0.6, 0.5, 1.32);
    -webkit-transform: scale(0.8) translate(0, 4px);
    transform: scale(0.8) translate(0, 4px);
    border: 1px solid var(--listBorder);
  }

  .select-club-services ul li {
    opacity: 0;
    -webkit-transform: translate(6px, 0);
    transform: translate(6px, 0);
    -webkit-transition: all .3s ease;
    transition: all .3s ease;
  }

  .select-club-services ul li a {
    cursor: pointer;
    display: block;
    padding: 10px 16px;
    color: var(--listText);
    text-decoration: none;
    outline: none;
    position: relative;
    -webkit-transition: all .3s ease;
    transition: all .3s ease;
  }

  .select-club-services ul li a:hover {
    color: var(--listTextActive);
  }

  .select-club-services ul li.active a {
    color: var(--listTextActive);
    background: var(--listActive);
  }

  .select-club-services ul li.active a:before,
  .select-club-services ul li.active a:after {
    --scale: .6;
    content: '';
    display: block;
    width: 10px;
    height: 2px;
    position: absolute;
    right: 17px;
    top: 50%;
    opacity: 0;
    background: var(--listText);
    -webkit-transition: all .2s ease;
    transition: all .2s ease;
  }

  .select-club-services ul li.active a:before {
    -webkit-transform: rotate(45deg) scale(var(--scale));
    transform: rotate(45deg) scale(var(--scale));
  }

  .select-club-services ul li.active a:after {
    -webkit-transform: rotate(-45deg) scale(var(--scale));
    transform: rotate(-45deg) scale(var(--scale));
  }

  .select-club-services ul li.active a:hover:before,
  .select-club-services ul li.active a:hover:after {
    --scale: .9;
    opacity: 1;
  }

  .select-club-services ul li:first-child a {
    border-radius: 6px 6px 0 0;
  }

  .select-club-services ul li:last-child a {
    border-radius: 0 0 6px 6px;
  }

  .select-club-services.filled>span {
    color: var(--textFilled);
  }

  .select-club-services.open>span {
    border-color: var(--borderActive);
  }

  .select-club-services.open>span:before,
  .select-club-services.open>span:after {
    background: var(--arrowActive);
  }

  .select-club-services.open>span:before {
    -webkit-transform: scale(0.96, 0.8) rotate(-50deg);
    transform: scale(0.96, 0.8) rotate(-50deg);
  }

  .select-club-services.open>span:after {
    -webkit-transform: scale(0.96, 0.8) rotate(50deg);
    transform: scale(0.96, 0.8) rotate(50deg);
  }

  .select-club-services.open ul {
    opacity: 1;
    visibility: visible;
    -webkit-transform: scale(1) translate(0, 12px);
    transform: scale(1) translate(0, 12px);
    -webkit-transition: opacity 0.3s ease, visibility 0.3s ease, -webkit-transform 0.3s cubic-bezier(0.4, 0.6, 0.5, 1.32);
    transition: opacity 0.3s ease, visibility 0.3s ease, -webkit-transform 0.3s cubic-bezier(0.4, 0.6, 0.5, 1.32);
    transition: opacity 0.3s ease, visibility 0.3s ease, transform 0.3s cubic-bezier(0.4, 0.6, 0.5, 1.32);
    transition: opacity 0.3s ease, visibility 0.3s ease, transform 0.3s cubic-bezier(0.4, 0.6, 0.5, 1.32), -webkit-transform 0.3s cubic-bezier(0.4, 0.6, 0.5, 1.32);
  }

  .select-club-services.open ul li {
    opacity: 1;
    -webkit-transform: translate(0, 0);
    transform: translate(0, 0);
  }

  .select-club-services.open ul li:nth-child(1) {
    -webkit-transition-delay: 80ms;
    transition-delay: 80ms;
  }

  .select-club-services.open ul li:nth-child(2) {
    -webkit-transition-delay: 160ms;
    transition-delay: 160ms;
  }

  .select-club-services.open ul li:nth-child(3) {
    -webkit-transition-delay: 240ms;
    transition-delay: 240ms;
  }

  .select-club-services.open ul li:nth-child(4) {
    -webkit-transition-delay: 320ms;
    transition-delay: 320ms;
  }

  .select-club-services.open ul li:nth-child(5) {
    -webkit-transition-delay: 400ms;
    transition-delay: 400ms;
  }

  .select-club-services.open ul li:nth-child(6) {
    -webkit-transition-delay: 480ms;
    transition-delay: 480ms;
  }

  .select-club-services.open ul li:nth-child(7) {
    -webkit-transition-delay: 560ms;
    transition-delay: 560ms;
  }

  .select-club-services.open ul li:nth-child(8) {
    -webkit-transition-delay: 640ms;
    transition-delay: 640ms;
  }

  .select-club-services.open ul li:nth-child(9) {
    -webkit-transition-delay: 720ms;
    transition-delay: 720ms;
  }

  .select-club-services.open ul li:nth-child(10) {
    -webkit-transition-delay: 800ms;
    transition-delay: 800ms;
  }

  select {
    --text: #3F4656;
    --border: #2F3545;
    --background: #151924;
  }

  select.select-club-services {
    padding: 9px 16px;
    border-radius: 6px;
    color: var(--text);
    border: 1px solid var(--border);
    background: var(--background);
    line-height: 22px;
    font-size: 16px;
    font-family: inherit;
    -webkit-appearance: none;
  }

  .slick-track {
    margin: 0px;
  }

  .select-club-services {
    width: auto !important;
  }

  .onoffswitch {
    position: relative;
    width: 56px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
  }

  .onoffswitch-checkbox {
    display: none;
  }

  .onoffswitch-label {
    display: block;
    overflow: hidden;
    cursor: pointer;
    border: 2px solid #FFFFFF;
    border-radius: 20px;
  }

  .onoffswitch-inner {
    display: block;
    width: 200%;
    margin-left: -100%;
    transition: margin 0.3s ease-in 0s;
  }

  .onoffswitch-inner:before,
  .onoffswitch-inner:after {
    display: block;
    float: left;
    width: 50%;
    height: 22px;
    padding: 0;
    line-height: 22px;
    font-size: 12px;
    color: black;
    font-family: Trebuchet, Arial, sans-serif;
    font-weight: bold;
    box-sizing: border-box;
  }

  .onoffswitch-inner:before {
    content: "YES";
    padding-left: 6px;
    background-color: #B4557D;
    color: white;
  }

  .onoffswitch-inner:after {
    content: "NO";
    padding-right: 6px;
    background-color: grey;
    color: white;
    text-align: right;
  }

  .onoffswitch-switch {
    display: block;
    width: 12px;
    margin: 5px;
    background: #FFFFFF;
    position: absolute;
    top: 0;
    bottom: 0;
    right: 30px;
    border: 2px solid #FFFFFF;
    border-radius: 20px;
    transition: all 0.3s ease-in 0s;
  }

  .onoffswitch-checkbox:checked+.onoffswitch-label .onoffswitch-inner {
    margin-left: 0;
  }

  .onoffswitch-checkbox:checked+.onoffswitch-label .onoffswitch-switch {
    right: 0px;
  }
</style>
<div class="container m-bt-30">
  <div class="title-wrapper">
    <p class="title-headings">Checkout</p>
  </div>
  <div class="row p-3">
    <div class="col-12 text-center shadow-lg rounded-4 p-3">
      <div class="card">
        <h2 id="heading">Ready to complete your order? Let's make it official.</h2>
        <p>Fill all form field to go to next step</p>
        <form id="msform">
          <!-- progressbar -->
          <ul id="progressbar">
            <li class="active" id="account">
              <strong>Customer Details</strong>
            </li>
            <li id="personal"><strong>Billing Address</strong></li>
            <li id="payment"><strong>Delivery Details</Details></strong></li>
            <li id="confirm"><strong>Payment</strong></li>
            <!-- <li id="confirmation"><strong>Confirmation</strong></li> -->
          </ul>
          <div class="progress">
            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
          </div>
          <br />
          <!-- fieldsets -->
          <fieldset id="fs_1">
            <div class="form-card">
              <div class="row">
                <div class="col-7">
                  <h2 class="fs-title">Customer Details</h2>
                </div>
                <div class="col-5">
                  <h2 class="steps">Step 1 - 4</h2>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs">
                  <label for="fname">First Name</label>
                  <input type="text" id="fname" name="fname" value="<?= $this->session->userdata('userdata')['full_name'] ?>">
                </div>
                <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs">
                  <label for="lname">Last Name</label>
                  <input type="text" name="lname" id="lname" value="<?= $this->session->userdata('userdata')['full_name'] ?>">
                </div>
                <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs">
                  <label for="email">Email</label>
                  <input type="text" id="email" name="email" value="<?= $this->session->userdata('userdata')['email_id'] ?>">
                </div>
                <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs">
                  <label for="phone">Telephone</label>
                  <input type="text" id="phone" name="phone" value="<?= $this->session->userdata('userdata')['mobile_no'] ?>">
                </div>
              </div>

            </div>
            <button type="submit" name="next" class="next-checkout-btn btn btn-primary float-end" style="width: auto;">
              <h5>Next</h5>
            </button>
          </fieldset>
          <fieldset id="fs_2">
            <div class="form-card">
              <div class="row">
                <div class="col-7">
                  <h2 class="fs-title">Billing Address:</h2>
                </div>
                <div class="col-5">
                  <h2 class="steps">Step 2 - 4</h2>
                </div>
              </div>


              <div class="row">
                <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs">
                  <label for="billling_company">Company</label>
                  <input type="text" id="billling_company" name="billling_company">
                </div>
                <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs">
                  <label for="billing_post_code">Post Code</label>
                  <input type="number" id="billing_post_code" name="billing_post_code">
                </div>
                <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs">
                  <label for="billing_address_1">Address 1</label>
                  <textarea id="billing_address_1"></textarea>
                </div>
                <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs">
                  <label for="billing_address_2">Address 2</label>
                  <textarea id="billing_address_2"></textarea>
                </div>
                <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs">
                  <label for="billing_city">City</label>
                  <input type="text" name="billing_city" id="billing_city">
                </div>
                <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs">
                  <label for="billing_country">Country</label>
                  <select id="billing_country" class="" style="width: 100%;" name="billing_country" onchange="loadStates(this.value,'billing_state')">
                  </select>
                </div>
                <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs">
                  <label for="billing_state">State</label>
                  <select id="billing_state" class="" style="width: 100%;" name="billing_state">
                  </select>
                </div>
              </div>
            </div>
            <button type="submit" name="next" class="next-checkout-btn btn btn-primary float-end" style="width: auto;">
              <h5>Next</h5>
            </button>
            <button type="button" name="previous" class="previous btn btn-primary float-end mx-1" style="width: auto;">
              <h5>Previous</h5>
            </button>
          </fieldset>
          <fieldset id="fs_3">
            <div class="form-card">
              <div class="row">
                <div class="col-7">
                  <h2 class="fs-title">Delivery Details:</h2>
                </div>
                <div class="col-5">
                  <h2 class="steps">Step 3 - 4</h2>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <table>
                    <tr>
                      <td>
                        <div class="onoffswitch">
                          <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch" onchange="sameAsBillingAddress(this.id)">
                          <label class="onoffswitch-label" for="myonoffswitch">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                          </label>
                        </div>
                      </td>
                      <td><label for="myonoffswitch">Same as Billing Address</label></td>
                    </tr>
                  </table>
                </div>
                <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs">
                  <label for="d_fname">First Name</label>
                  <input type="text" id="d_fname" name="d_fname">
                </div>
                <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs">
                  <label for="d_lname">Last Name</label>
                  <input type="text" name="d_lname" id="d_lname">
                </div>
                <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs">
                  <label for="d_company">Company</label>
                  <input type="text" id="d_company" name="d_company">
                </div>
                <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs">
                  <label for="d_post_code">Post Code</label>
                  <input type="number" id="d_post_code" name="d_post_code">
                </div>
                <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs">
                  <label for="d_address_1">Address 1</label>
                  <textarea id="d_address_1"></textarea>
                </div>
                <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs">
                  <label for="d_address_2">Address 2</label>
                  <textarea id="d_address_2"></textarea>
                </div>
                <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs">
                  <label for="d_city">City</label>
                  <input type="text" name="d_city" id="d_city">
                </div>
                <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs">
                  <label for="d_country">Country</label>
                  <select id="d_country" class="" style="width: 100%;" name="d_country" onchange="loadStates(this.value,'d_state')">
                  </select>
                </div>
                <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs">
                  <label for="d_state">State</label>
                  <select id="d_state" class="" style="width: 100%;" name="d_state">
                  </select>
                </div>
                <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs">
                  <label for="d_note">Delivery Note</label>
                  <textarea id="d_note" name="d_note"></textarea>
                </div>
              </div>

            </div>
            <button type="submit" name="next" class="next-checkout-btn btn btn-primary float-end" style="width: auto;">
              <h5>Submit</h5>
            </button>
            <button type="button" name="previous" class="previous btn btn-primary float-end mx-1" style="width: auto;">
              <h5>Previous</h5>
            </button>
          </fieldset>
          <fieldset id="fs_4">
            <div class="form-card">
              <div class="row">
                <div class="col-7">
                  <h2 class="fs-title">Payment:</h2>
                </div>
                <div class="col-5">
                  <h2 class="steps">Step 4 - 4</h2>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs test-review-stars text-center">
                  <div id="paypal-button">Pay with PayPal</div>
                </div>
              </div>
            </div>
            <button type="submit" name="next" class="next-checkout-btn btn btn-primary float-end" style="width: auto;">
              <h5>Submit</h5>
            </button>
            <button type="button" name="previous" class="previous btn btn-primary float-end mx-1" style="width: auto;">
              <h5>Previous</h5>
            </button>
          </fieldset>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url('assets/')?>lib/js/jquery-3.6.4.min.js"></script>
<script src="https://www.paypal.com/sdk/js?client-id=Aa8Xurxp1RU5ywRKg-gP1E2RHuCUw7AAm3WOqMJEn1x-5jGKC0kNgSZnaYXsFJKeraV6i8Jb8xPQLWIn"></script>
<script src="<?= base_url('assets/')?>js/checkout.js"></script>
<script src="<?= base_url('assets/') ?>js/cart.js"></script>