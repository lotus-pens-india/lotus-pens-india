  <!--checkout section-->
  <div class="container m-bt-30">
      <div class="title-wrapper">
        <p class="title-headings">Checkout</p>
      </div>
      <div class="row justify-content-center shadow-lg">
        <div class="col-12 text-center p-5 mt-3 mb-2">
          <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
            <h2 id="heading">Sign Up Your User Account</h2>
            <p>Fill all form field to go to next step</p>
            <form id="msform">
              <!-- progressbar -->
              <ul id="progressbar">
                <li class="active" id="account">
                  <strong>Customer Details</strong>
                </li>
                <li id="personal"><strong>Billing Address</strong></li>
                <li id="payment"><strong>Delivery</strong></li>
                <li id="confirm"><strong>Payment</strong></li>
                <!-- <li id="confirmation"><strong>Confirmation</strong></li> -->
              </ul>
              <div class="progress">
                <div
                  class="progress-bar progress-bar-striped progress-bar-animated"
                  role="progressbar"
                  aria-valuemin="0"
                  aria-valuemax="100"
                ></div>
              </div>
              <br />
              <!-- fieldsets -->
              <fieldset>
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
                        <input type="text" id="fname" name="fname">
                    </div>
                    <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs">
                        <label for="lname">Last Name</label>
                        <input type="text" name="lname" id="lname">
                    </div>
                    <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs">
                        <label for="email">Email</label>
                        <input type="text" id="email" name="email">
                    </div>
                    <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs">
                        <label for="phone">Telephone</label>
                        <input type="text" id="phone" name="phone">
                    </div>
                    
                    <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs">
                        <label for="address_1">Address 1</label>
                        <textarea id="address_1" ></textarea>
                    </div>

                    <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs">
                        <label for="address_2">Address 2</label>
                        <textarea id="address_2"></textarea>
                    </div>

                    <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs">
                        <label for="city">Address 2</label>
                        <input type="text" id="city" name="city">
                    </div>
                    <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs">
                        <label for="postal_code">Address 2</label>
                        <input type="text"  id="postal_code" name="postal_code" placeholder="Postal Code">
                    </div>

                    <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs mt-2">
                        <div class="dropdown">
                            <button
                              class="btn dropdown-toggle options-title-items"
                              type="button"
                              id="dropdownMenuButton1"
                              data-bs-toggle="dropdown"
                              aria-expanded="false"
                            >
                              <p class="title-first">Country</p>
                            </button>
                            <ul
                              class="dropdown-menu"
                              aria-labelledby="dropdownMenuButton1"
                            >
                            <li><a class="dropdown-item">India</a></li>
                            <li><a class="dropdown-item">USA</a></li>
                            <li><a class="dropdown-item">Austrolia</a></li>
                            </ul>
                          </div>
                    </div>
                    <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs mt-2">
                        <div class="dropdown">
                            <button
                              class="btn dropdown-toggle options-title-items"
                              type="button"
                              id="dropdownMenuButton1"
                              data-bs-toggle="dropdown"
                              aria-expanded="false"
                            >
                              <p class="title-first">Region / State</p>
                            </button>
                            <ul
                              class="dropdown-menu"
                              aria-labelledby="dropdownMenuButton1"
                            >
                            <li><a class="dropdown-item">Maharashtra</a></li>
                              <li><a class="dropdown-item">Chennai</a></li>
                              <li><a class="dropdown-item">Tamilnadu</a></li>
                            </ul>
                          </div>
                     </div>
                  </div>
                  
                </div>
                <button
                  type="button"
                  name="next"
                  class="next-checkout-btn btn btn-primary float-end"
                ><h5>Next</h5></button>
              </fieldset>
              <fieldset>
                <div class="form-card">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="fs-title">Personal Information:</h2>
                    </div>
                    <div class="col-5">
                      <h2 class="steps">Step 2 - 4</h2>
                    </div>
                  </div>
                  <label class="fieldlabels">First Name: *</label>
                  <input type="text" name="fname" placeholder="First Name" />
                  <label class="fieldlabels">Last Name: *</label>
                  <input type="text" name="lname" placeholder="Last Name" />
                  <label class="fieldlabels">Contact No.: *</label>
                  <input type="text" name="phno" placeholder="Contact No." />
                  <label class="fieldlabels">Alternate Contact No.: *</label>
                  <input
                    type="text"
                    name="phno_2"
                    placeholder="Alternate Contact No."
                  />
                </div>
                <button
                  type="button"
                  name="next"
                  class="next-checkout-btn btn btn-primary float-end"
                ><h5>Next</h5></button>
                <button
                  type="button"
                  name="previous"
                  class="previous btn btn-primary float-end mx-1"
                ><h5>Previous</h5></button>
              </fieldset>
              <fieldset>
                <div class="form-card">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="fs-title">Image Upload:</h2>
                    </div>
                    <div class="col-5">
                      <h2 class="steps">Step 3 - 4</h2>
                    </div>
                  </div>
                  <label class="fieldlabels">Upload Your Photo:</label>
                  <input type="file" name="pic" accept="image/*" />
                  <label class="fieldlabels">Upload Signature Photo:</label>
                  <input type="file" name="pic" accept="image/*" />
                </div>
                <button
                  type="button"
                  name="next"
                  class="next-checkout-btn btn btn-primary float-end"
                ><h5>Submit</h5></button>
                <button
                  type="button"
                  name="previous"
                  class="previous btn btn-primary float-end mx-1"
                ><h5>Previous</h5></button>
              </fieldset>
              <fieldset>
                <div class="form-card">
                  <div class="row">
                    <div class="col-7">
                      <h2 class="fs-title">Finish:</h2>
                    </div>
                    <div class="col-5">
                      <h2 class="steps">Step 4 - 4</h2>
                    </div>
                  </div>
                  <br /><br />
                  <h2 class="purple-text text-center">
                    <strong>SUCCESS !</strong>
                  </h2>
                  <br />
                  <div class="row justify-content-center">
                    <div class="col-3">
                      <img
                        src="https://i.imgur.com/GwStPmg.png"
                        class="fit-image"
                      />
                    </div>
                  </div>
                  <br /><br />
                  <div class="row justify-content-center">
                    <div class="col-7 text-center">
                      <h5 class="purple-text text-center">
                        You Have Successfully Signed Up
                      </h5>
                    </div>
                  </div>
                </div>
              </fieldset>
            </form>
          </div>
        </div>
      </div>
    </div>