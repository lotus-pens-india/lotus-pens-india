<link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>css/star-rating.css">

<?php if (isset($products) && is_array($products) && count($products) > 0) {
    $product = $products[0];
    $reviewCount = isset($reviews) && is_array($reviews) ? count($reviews) : 0;
    $priceValue = isset($price[0]['price']) ? $price[0]['price'] : 0;
    $mrpValue = isset($price[0]['mrp']) ? $price[0]['mrp'] : 0;
    $discountValue = isset($price[0]['discount']) ? $price[0]['discount'] : 0;
    $spec = null;
    if (isset($product['technical_specification']) && $product['technical_specification'] != '') {
        $spec = json_decode($product['technical_specification']);
    }
?>
    <section class="lp-listing-hero">
        <div class="container">
            <span class="lp-kicker">Product Experience</span>
            <h1><?= $product['product_name'] ?></h1>
            <p>Configure your pen, inspect the finish, and complete the purchase through the existing secure Lotus cart flow.</p>
        </div>
    </section>

    <main class="container lp-product-detail">
        <div class="lp-detail-grid">
            <aside class="lp-gallery-shell">
                <div class="product-slider">
                    <?php if (isset($details) && is_array($details) && count($details) > 0) {
                        foreach ($details as $product_details) { ?>
                            <img class="product-img" src="<?= base_url() ?>lotus_pens_admin/assets/images/thumbnail/<?= $product_details['image'] ?>" title="<?= $product['product_name'] ?>" alt="<?= $product['product_name'] ?>">
                        <?php }
                    } else { ?>
                        <img class="product-img" src="<?= base_url() ?>lotus_pens_admin/assets/images/product/<?= $product['main_image'] ?>" title="<?= $product['product_name'] ?>" alt="<?= $product['product_name'] ?>">
                    <?php } ?>
                </div>

                <?php if (isset($details) && is_array($details) && count($details) > 0) { ?>
                    <div class="prod-color-options">
                        <div class="prod-options-slider" id="parent_div_of_color">
                            <?php foreach ($details as $index => $product_details) {
                                $makeSelected = $index == 0 ? 'prod-options-slide-first' : '';
                                $makeSelectedPtag = $index == 0 ? 'selected_color' : '';
                                $colorTitle = isset($product_details['title']) && $product_details['title'] != '' ? $product_details['title'] : 'Finish ' . ($index + 1);
                            ?>
                                <div class="prod-options-slide item__boxes <?= $makeSelected ?>" id="<?= $index ?>_color" onclick="selectColor('<?= $index ?>_color')" data-slick-index="<?= $index ?>">
                                    <p class="prod-color <?= $makeSelectedPtag ?>" id="<?= $index ?>_color_text"><?= $colorTitle ?></p>
                                    <img src="<?= base_url() ?>lotus_pens_admin/assets/images/thumbnail/<?= $product_details['image'] ?>" title="<?= $colorTitle ?>" alt="<?= $colorTitle ?>">
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </aside>

            <section class="product-info">
                <div class="prod-info-title">
                    <input type="hidden" value="<?= $product['product_id'] ?>" id="product_code_text">
                    <div class="prod-info-title-name">
                        <span class="lp-kicker">Lotus Writing Instrument</span>
                        <h2 class="prod-name" id="product_name_div"><?= $product['product_name'] ?></h2>
                        <p class="prod-code">Product Code: <?= $product['product_code'] ?></p>
                    </div>
                    <button type="button" class="lp-icon-btn" onclick="addToWishlist(this)" title="Wishlist" aria-label="Wishlist">
                        <i class="fa fa-heart-o"></i>
                    </button>
                </div>

                <div class="prod-price">
                    <?php if ($discountValue != 0) { ?>
                        <span class="lp-discount-badge">-<?= $discountValue ?>%</span>
                    <?php } ?>
                    <span><?= $this->session->userdata('currency_symbol') ?></span><?= $priceValue ?>
                    <?php if ($mrpValue != 0 && $priceValue != $mrpValue) { ?>
                        <span class="lp-old-price"><?= $this->session->userdata('currency_symbol') ?><?= $mrpValue ?></span>
                    <?php } ?>
                </div>

                <div class="review-wrapper">
                    <div class="review-stars" aria-label="Product rating">
                        <?php for ($i = 0; $i < 5; $i++) { ?>
                            <svg class="review-fill" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="512" height="512">
                                <path d="M1.327,12.4,4.887,15,3.535,19.187A3.178,3.178,0,0,0,4.719,22.8a3.177,3.177,0,0,0,3.8-.019L12,20.219l3.482,2.559a3.227,3.227,0,0,0,4.983-3.591L19.113,15l3.56-2.6a3.227,3.227,0,0,0-1.9-5.832H16.4L15.073,2.432a3.227,3.227,0,0,0-6.146,0L7.6,6.568H3.231a3.227,3.227,0,0,0-1.9,5.832Z"></path>
                            </svg>
                        <?php } ?>
                    </div>
                    <p class="reviews-count"><?= $reviewCount ?> review<?= $reviewCount == 1 ? '' : 's' ?></p>
                </div>

                <p class="options-title">Clip</p>
                <div class="row">
                    <div class="col-6">
                        <div class="options-title-items active-option selected_clip" id="with_clip" onclick="selectClipOption(this.id)" style="cursor:pointer">
                            <p>With Clip</p>
                            <p><?= $this->session->userdata('currency_symbol') ?><?= $withClipAmt ?></p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="options-title-items" id="without_clip" onclick="selectClipOption(this.id)" style="cursor:pointer">
                            <p>Without Clip</p>
                        </div>
                    </div>
                </div>

                <?php if (isset($nib) && is_array($nib) && count($nib) > 0) { ?>
                    <p class="options-title">Nib</p>
                    <div class="filters">
                        <select id="nib_select" class="select-club-services" name="nib_select">
                            <?php foreach ($nib as $nib_data) { ?>
                                <option value="<?= $nib_data['id'] ?>">
                                    <?php
                                    if ($nib_data[$this->session->userdata('active_currency') . "_price"] != 0) {
                                        echo $nib_data['name'] . " (" . $this->session->userdata('currency_symbol') . "+" . $nib_data[$this->session->userdata('active_currency') . "_price"] . ")";
                                    } else {
                                        echo $nib_data['name'];
                                    }
                                    ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                <?php } ?>

                <?php if (isset($clip) && is_array($clip) && count($clip) > 0) { ?>
                    <p class="options-title">Clip and Rings</p>
                    <div class="filters">
                        <select id="clip_select" class="select-club-services" name="clip_select">
                            <?php foreach ($clip as $clip_data) { ?>
                                <option value="<?= $clip_data['id'] ?>"><?= $clip_data['name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                <?php } ?>

                <?php if (isset($matrial) && is_array($matrial) && count($matrial) > 0) { ?>
                    <p class="options-title">Material</p>
                    <div class="filters">
                        <select id="material_select" class="select-club-services" name="material_select" onchange="changeMaterialImage()">
                            <?php foreach ($matrial as $matrial_data) { ?>
                                <option value="<?= $matrial_data['id'] ?>">
                                    <?php
                                    if ($matrial_data[$this->session->userdata('active_currency') . "_price"] != 0) {
                                        echo $matrial_data['name'] . " (" . $this->session->userdata('currency_symbol') . "+" . $matrial_data[$this->session->userdata('active_currency') . "_price"] . ")";
                                    } else {
                                        echo $matrial_data['name'];
                                    }
                                    ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="lp-material-preview">
                        <div class="img-wrapper">
                            <input type="hidden" id="material_image_input" value="">
                            <img id="material_image" src="<?= base_url() ?>lotus_pens_admin/assets/images/material/<?= $matrial[0]['image'] ?>" title="<?= $matrial[0]['name'] ?>" alt="<?= $matrial[0]['name'] ?>">
                            <div class="img-overview">
                                <a class="overview-link" type="button" id="view_material_button" onclick="openQuickView('<?= base_url() ?>lotus_pens_admin/assets/images/material/<?= $matrial[0]['image'] ?>')">View Material</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <p class="options-title">Availability: <?= isset($product['qty']) && (int) $product['qty'] > 0 ? 'In Stock' : 'Made to Order' ?></p>
                <div class="lp-purchase-panel">
                    <div class="lp-quantity" aria-label="Quantity selector">
                        <button type="button" data-qty-action="decrease" data-qty-target="product_qty" aria-label="Decrease quantity"><i class="fa fa-minus"></i></button>
                        <input type="text" id="product_qty" value="1" inputmode="numeric" aria-label="Quantity">
                        <button type="button" data-qty-action="increase" data-qty-target="product_qty" aria-label="Increase quantity"><i class="fa fa-plus"></i></button>
                    </div>
                    <button class="options-title-items active-option add-cart-btn lp-add-cart-btn" onclick="addToCart()">Add to Cart</button>
                </div>

                <div class="accordion lp-detail-tabs mt-4" id="productDetailAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="reviewHeading">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#reviewsPanel" aria-expanded="false" aria-controls="reviewsPanel">Reviews</button>
                        </h2>
                        <div id="reviewsPanel" class="accordion-collapse collapse" aria-labelledby="reviewHeading" data-bs-parent="#productDetailAccordion">
                            <div class="accordion-body">
                                <?php if (isset($reviews) && is_array($reviews) && count($reviews) > 0) {
                                    foreach ($reviews as $rData) { ?>
                                        <div class="lp-review-card">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <strong><?= $rData['customer_name'] ?></strong>
                                                <div class="review-stars">
                                                    <?php for ($i = 0; $i < $rData['ratings']; $i++) { ?>
                                                        <svg class="review-fill" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="512" height="512">
                                                            <path d="M1.327,12.4,4.887,15,3.535,19.187A3.178,3.178,0,0,0,4.719,22.8a3.177,3.177,0,0,0,3.8-.019L12,20.219l3.482,2.559a3.227,3.227,0,0,0,4.983-3.591L19.113,15l3.56-2.6a3.227,3.227,0,0,0-1.9-5.832H16.4L15.073,2.432a3.227,3.227,0,0,0-6.146,0L7.6,6.568H3.231a3.227,3.227,0,0,0-1.9,5.832Z"></path>
                                                        </svg>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <p class="m-0 mt-2"><?= $rData['review'] ?></p>
                                        </div>
                                    <?php }
                                } else { ?>
                                    <p>No reviews yet.</p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="writeReviewHeading">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#writeReviewPanel" aria-expanded="false" aria-controls="writeReviewPanel">Write a Review</button>
                        </h2>
                        <div id="writeReviewPanel" class="accordion-collapse collapse" aria-labelledby="writeReviewHeading" data-bs-parent="#productDetailAccordion">
                            <div class="accordion-body">
                                <form id="rating_form">
                                    <div class="row">
                                        <div class="col-12 form-inputs">
                                            <label for="cname">Name</label>
                                            <input type="text" id="cname" name="cname">
                                        </div>
                                        <div class="col-12 form-inputs">
                                            <label for="review">Review</label>
                                            <textarea id="review" name="review"></textarea>
                                        </div>
                                        <div class="col-12 form-inputs">
                                            <label>Rating</label>
                                            <div class="lp-rating-inputs">
                                                <input type="radio" name="rating" id="rating-5">
                                                <label for="rating-5"></label>
                                                <input type="radio" name="rating" id="rating-4">
                                                <label for="rating-4"></label>
                                                <input type="radio" name="rating" id="rating-3">
                                                <label for="rating-3"></label>
                                                <input type="radio" name="rating" id="rating-2">
                                                <label for="rating-2"></label>
                                                <input type="radio" name="rating" id="rating-1">
                                                <label for="rating-1"></label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button class="btn btn-primary" type="submit">Submit Review</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <section class="description-wrapper">
            <p class="desc-title">Description</p>
            <div class="lp-product-description">
                <?= $product['description'] ?>
            </div>
        </section>

        <section class="more-details-options">
            <p class="more-details-title">Technical Specifications</p>
            <div class="details-wrapper">
                <?php
                $tsp = array('dimension', 'nib_material', 'pen_material', 'trim', 'filling_mechanism');
                $tspShow = array('Dimension', 'Nib Material', 'Pen Material', 'Trim', 'Filling Mechanism');
                if ($spec) {
                    foreach ($tsp as $index => $tspData) {
                        if (isset($spec->$tspData) && $spec->$tspData != '') { ?>
                            <div class="row mb-2">
                                <div class="col-12 col-md-4"><strong><?= $tspShow[$index] ?></strong></div>
                                <div class="col-12 col-md-8 grey-color"><?= $spec->$tspData ?></div>
                            </div>
                        <?php }
                    }
                } else { ?>
                    <p class="m-0">Specifications will be updated soon.</p>
                <?php } ?>
            </div>
        </section>

        <?php if (isset($relatedProducts) && is_array($relatedProducts) && count($relatedProducts) > 0) { ?>
            <section class="lp-section">
                <div class="lp-section-head">
                    <div>
                        <span class="lp-kicker">Related Products</span>
                        <h2 class="lp-section-title">More from this collection</h2>
                    </div>
                </div>
                <div class="related-products-slider">
                    <?php foreach ($relatedProducts as $related) { ?>
                        <div class="lp-featured-slide">
                            <article class="lp-product-card">
                                <a class="lp-product-media" href="<?= base_url() ?>product/<?= $related['product_id'] ?>">
                                    <span class="lp-product-badge">Related</span>
                                    <img src="<?= base_url('lotus_pens_admin/assets/') ?>images/product/<?= $related['main_image'] ?>" title="<?= $related['product_name'] ?>" alt="<?= $related['product_name'] ?>">
                                </a>
                                <div class="lp-product-body">
                                    <a class="lp-product-title" href="<?= base_url() ?>product/<?= $related['product_id'] ?>"><?= $related['product_name'] ?></a>
                                    <div class="lp-product-footer">
                                        <span class="lp-price"><?= $this->session->userdata('currency_symbol') . $related['unit_price'] ?></span>
                                        <a class="lp-mini-link" href="<?= base_url() ?>product/<?= $related['product_id'] ?>">Details</a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    <?php } ?>
                </div>
            </section>
        <?php } ?>
    </main>
<?php } ?>

<script src="<?= base_url('assets/') ?>js/cart.js"></script>
