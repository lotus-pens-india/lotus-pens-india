<link rel="canonical" href="<?= base_url() ?>cart">

<section class="lp-listing-hero">
    <div class="container">
        <span class="lp-kicker">Shopping Cart</span>
        <h1>Your Lotus Selection</h1>
        <p>Review finishes, quantities, coupon savings, and delivery totals before moving into secure checkout.</p>
    </div>
</section>

<main class="container" id="main_cart_page_div">
    <div class="lp-cart-layout">
        <section class="lp-cart-card">
            <div class="lp-section-head">
                <div>
                    <span class="lp-kicker">Cart Items</span>
                    <h2 class="lp-section-title">Ready for checkout</h2>
                </div>
            </div>
            <div id="cart_items_div"></div>
        </section>

        <aside class="lp-cart-card">
            <form id="cart_form">
                <div class="mb-4">
                    <span class="lp-kicker">Order Summary</span>
                    <h2 class="lp-section-title">Summary</h2>
                </div>

                <div class="accordion" id="cartSummaryAccordion">
                    <div class="accordion-item px-0" style="border: 0;">
                        <h2 class="accordion-header" id="couponHeading">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#couponPanel" aria-expanded="true" aria-controls="couponPanel">Coupon Code</button>
                        </h2>
                        <div id="couponPanel" class="accordion-collapse collapse show" aria-labelledby="couponHeading" data-bs-parent="#cartSummaryAccordion">
                            <div class="pt-3">
                                <div class="row">
                                    <div class="col-8">
                                        <input type="text" id="coupon_code" name="coupon_code" placeholder="Enter code">
                                        <input type="hidden" id="total_item_value" name="total_item_value">
                                        <span id="coupon_message" class="lp-mini-link"></span>
                                    </div>
                                    <div class="col-4">
                                        <button class="btn btn-primary w-100" type="button" id="checkCouponCodeBtn" onclick="checkCouponCode()">Apply</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="order-total mt-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Order Value</span>
                        <strong><?= $this->session->userdata('currency_symbol') ?> <span id="summary_price">0</span></strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Delivery</span>
                        <strong><?= $this->session->userdata('currency_symbol') ?> <span id="shpping_price">0</span></strong>
                    </div>
                </div>

                <div class="order-final-total">
                    <div class="d-flex justify-content-between">
                        <span>Total</span>
                        <strong><?= $this->session->userdata('currency_symbol') ?> <span id="summary_price_total">0</span></strong>
                    </div>
                </div>

                <button class="btn btn-primary w-100" type="button" onclick="processToCheckout()">Continue To Checkout</button>

                <div class="lp-feature-strip mt-4">
                    <div><i class="fa fa-lock"></i>Secure payment</div>
                    <div><i class="fa fa-gift"></i>Careful packing</div>
                    <div><i class="fa fa-truck"></i>Tracked delivery</div>
                </div>
            </form>
        </aside>
    </div>
</main>
<script src="<?= base_url('assets/') ?>js/cart.js?v=10"></script>
