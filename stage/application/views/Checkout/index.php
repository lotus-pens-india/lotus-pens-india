<link rel="canonical" href="<?= base_url() ?>checkout/none">

<section class="lp-listing-hero">
  <div class="container">
    <span class="lp-kicker">Secure Checkout</span>
    <h1>Complete Your Order</h1>
    <p>A focused multi-step checkout for customer details, billing, delivery, and secure payment.</p>
  </div>
</section>

<main class="container lp-checkout-shell">
  <div class="lp-checkout-card">
    <h2 id="heading">Ready to complete your order?</h2>
    <p class="lp-section-copy">Confirm your details and choose a secure payment method.</p>

    <form id="msform">
      <ul id="progressbar">
        <li class="active" id="account"><strong>Customer Details</strong></li>
        <li id="personal"><strong>Billing Address</strong></li>
        <li id="payment"><strong>Delivery Details</strong></li>
        <li id="confirm"><strong>Payment</strong></li>
      </ul>
      <div class="progress">
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
      </div>

      <fieldset id="fs_1">
        <div class="form-card">
          <div class="row align-items-center">
            <div class="col-7">
              <h2 class="fs-title">Customer Details</h2>
            </div>
            <div class="col-5">
              <h2 class="steps">Step 1 - 4</h2>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-lg-6 form-inputs">
              <label for="fname">First Name</label>
              <input type="text" id="fname" name="fname" value="<?= $this->session->userdata('userdata')['first_name'] ?>">
            </div>
            <div class="col-12 col-lg-6 form-inputs">
              <label for="lname">Last Name</label>
              <input type="text" name="lname" id="lname" value="<?= $this->session->userdata('userdata')['last_name'] ?>">
            </div>
            <div class="col-12 col-lg-6 form-inputs">
              <label for="email">Email</label>
              <input type="text" id="email" name="email" value="<?= $this->session->userdata('userdata')['email_id'] ?>">
            </div>
            <div class="col-12 col-lg-6 form-inputs">
              <label for="phone">Telephone</label>
              <input type="text" id="phone" name="phone" value="<?= $this->session->userdata('userdata')['mobile_no'] ?>">
            </div>
          </div>
        </div>
        <button type="submit" name="next" class="next-checkout-btn btn btn-primary float-end" style="width:auto">Next <i class="fa fa-angle-right mx-2"></i></button>
      </fieldset>

      <fieldset id="fs_2">
        <div class="form-card">
          <div class="row align-items-center">
            <div class="col-7">
              <h2 class="fs-title">Billing Address</h2>
            </div>
            <div class="col-5">
              <h2 class="steps">Step 2 - 4</h2>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-lg-6 form-inputs">
              <label for="billling_company">Company</label>
              <input type="text" id="billling_company" name="billling_company">
            </div>
            <div class="col-12 col-lg-6 form-inputs">
              <label for="billing_post_code">Post Code</label>
              <input type="text" id="billing_post_code" name="billing_post_code">
            </div>
            <div class="col-12 col-lg-6 form-inputs">
              <label for="billing_address_1">Address 1</label>
              <textarea id="billing_address_1"></textarea>
            </div>
            <div class="col-12 col-lg-6 form-inputs">
              <label for="billing_address_2">Address 2</label>
              <textarea id="billing_address_2"></textarea>
            </div>
            <div class="col-12 col-lg-6 form-inputs">
              <label for="billing_city">City</label>
              <input type="text" name="billing_city" id="billing_city">
            </div>
            <div class="col-12 col-lg-6 form-inputs">
              <label for="billing_country">Country</label>
              <select id="billing_country" style="width:100%" name="billing_country" onchange="loadStates(this.value,'billing_state')"></select>
            </div>
            <div class="col-12 col-lg-6 form-inputs">
              <label for="billing_state">State</label>
              <select id="billing_state" style="width:100%" name="billing_state"></select>
            </div>
          </div>
        </div>
        <button type="submit" name="next" class="next-checkout-btn btn btn-primary float-end" style="width:auto">Next <i class="fa fa-angle-right mx-2"></i></button>
        <button type="button" name="previous" class="previous btn btn-primary float-end mx-1" style="width:auto"><i class="fa fa-angle-left mx-2"></i> Previous</button>
      </fieldset>

      <fieldset id="fs_3">
        <div class="form-card">
          <div class="row align-items-center">
            <div class="col-7">
              <h2 class="fs-title">Delivery Details</h2>
            </div>
            <div class="col-5">
              <h2 class="steps">Step 3 - 4</h2>
            </div>
          </div>
          <div class="row">
            <div class="col-12 form-inputs">
              <label class="lp-filter-check" for="myonoffswitch">
                <input type="checkbox" name="onoffswitch" id="myonoffswitch" onchange="sameAsBillingAddress(this.id)">
                Same as Billing Address
              </label>
            </div>
            <div class="col-12 col-lg-6 form-inputs">
              <label for="d_fname">First Name</label>
              <input type="text" id="d_fname" name="d_fname">
            </div>
            <div class="col-12 col-lg-6 form-inputs">
              <label for="d_lname">Last Name</label>
              <input type="text" name="d_lname" id="d_lname">
            </div>
            <div class="col-12 col-lg-6 form-inputs">
              <label for="d_company">Company</label>
              <input type="text" id="d_company" name="d_company">
            </div>
            <div class="col-12 col-lg-6 form-inputs">
              <label for="d_post_code">Post Code</label>
              <input type="text" id="d_post_code" name="d_post_code">
            </div>
            <div class="col-12 col-lg-6 form-inputs">
              <label for="d_address_1">Address 1</label>
              <textarea id="d_address_1"></textarea>
            </div>
            <div class="col-12 col-lg-6 form-inputs">
              <label for="d_address_2">Address 2</label>
              <textarea id="d_address_2"></textarea>
            </div>
            <div class="col-12 col-lg-6 form-inputs">
              <label for="d_city">City</label>
              <input type="text" name="d_city" id="d_city">
            </div>
            <div class="col-12 col-lg-6 form-inputs">
              <label for="d_country">Country</label>
              <select id="d_country" style="width:100%" name="d_country" onchange="loadStates(this.value,'d_state')"></select>
            </div>
            <div class="col-12 col-lg-6 form-inputs">
              <label for="d_state">State</label>
              <select id="d_state" style="width:100%" name="d_state"></select>
            </div>
            <div class="col-12 col-lg-6 form-inputs">
              <label for="d_note">Delivery Note</label>
              <textarea id="d_note" name="d_note"></textarea>
            </div>
          </div>
        </div>
        <button type="submit" name="next" class="next-checkout-btn btn btn-primary float-end" style="width:auto">Next <i class="fa fa-angle-right mx-2"></i></button>
        <button type="button" name="previous" class="previous btn btn-primary float-end mx-1" style="width:auto"><i class="fa fa-angle-left mx-2"></i> Previous</button>
      </fieldset>

      <fieldset id="fs_4">
        <div class="form-card">
          <div class="row align-items-center">
            <div class="col-7">
              <h2 class="fs-title">Payment</h2>
            </div>
            <div class="col-5">
              <h2 class="steps">Step 4 - 4</h2>
            </div>
          </div>
          <div class="row">
            <div class="col-12 col-lg-6 form-inputs">
              <div class="lp-payment-option text-center">
                <span class="lp-kicker">International</span>
                <div id="paypal-button">Pay with PayPal</div>
              </div>
            </div>
            <div class="col-12 col-lg-6 form-inputs">
              <div class="lp-payment-option text-center">
                <span class="lp-kicker">India</span>
                <label for="rzp-button1">Pay with Razorpay</label>
                <button id="rzp-button1" class="btn btn-outline-dark btn-lg w-100" style="background-color:#13abc4">
                  <img src="<?= base_url() ?>assets/images/Razorpay_logo.svg" style="height:30px;width:100%" alt="Razorpay">
                </button>
              </div>
            </div>
          </div>
        </div>
        <button type="button" name="previous" class="previous btn btn-primary float-end mx-1" style="width:auto"><i class="fa fa-angle-left mx-2"></i> Previous</button>
      </fieldset>
    </form>
  </div>
</main>

<script src="https://www.paypal.com/sdk/js?client-id=AXkwIGBcwPorZe1dketg2h3qdnWiyIVqd4Intr_n5BfU8apPpPLkZ7tx083MJTMm1Bw-DgigAzNIW_eV"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="<?= base_url('assets/') ?>js/checkout.js?v=4"></script>
<script src="<?= base_url('assets/') ?>js/cart.js?v=10"></script>
