<?php
if (isset($products)) { ?>
    <div class="container m-bt-30">
        <div class="title-wrapper">
            <p class="title-headings">Product Details</p>
        </div>
        <div class="row">
            <div class="col-12 col-lg-6 col-md-12 col-sm-12">
                <div class="product-slider">
                    <img class="product-img" src="<?= base_url('assets/') ?>images/Pen 2.png" />
                    <img class="product-img" src="<?= base_url('assets/') ?>images/Pen 3.png" />
                    <img class="product-img" src="<?= base_url('assets/') ?>images/Pen 4.png" />
                    <img class="product-img" src="<?= base_url('assets/') ?>images/Pen 5.png" />
                    <img class="product-img" src="<?= base_url('assets/') ?>images/Pen 6.png" />
                    <img class="product-img" src="<?= base_url('assets/') ?>images/product-img.png" />
                </div>
            </div>
            <div class="col-12 col-lg-6 col-md-12 col-sm-12">
                <div class="product-info">
                    <div class="prod-info-title">
                        <div class="prod-info-title-name">
                            <p class="prod-name"><?= $products[0]['product_name'] ?></p>
                            <p class="prod-code">Product Code: <?= $products[0]['product_id'] ?></p>
                        </div>
                        <div class="prod-icons">
                            <svg class="heart-icon" xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="512" height="512">
                                <path d="M17.5.917a6.4,6.4,0,0,0-5.5,3.3A6.4,6.4,0,0,0,6.5.917,6.8,6.8,0,0,0,0,7.967c0,6.775,10.956,14.6,11.422,14.932l.578.409.578-.409C13.044,22.569,24,14.742,24,7.967A6.8,6.8,0,0,0,17.5.917Z" />
                            </svg>
                            <svg class="exchange-icon" xmlns="http://www.w3.org/2000/svg" id="arrow-circle-down" viewBox="0 0 24 24" width="512" height="512">
                                <g>
                                    <path d="M23,16H2.681l.014-.015L4.939,13.7a1,1,0,1,0-1.426-1.4L1.274,14.577c-.163.163-.391.413-.624.676a2.588,2.588,0,0,0,0,3.429c.233.262.461.512.618.67l2.245,2.284a1,1,0,0,0,1.426-1.4L2.744,18H23a1,1,0,0,0,0-2Z" />
                                    <path d="M1,8H21.255l-2.194,2.233a1,1,0,1,0,1.426,1.4l2.239-2.279c.163-.163.391-.413.624-.675a2.588,2.588,0,0,0,0-3.429c-.233-.263-.461-.513-.618-.67L20.487,2.3a1,1,0,0,0-1.426,1.4l2.251,2.29L21.32,6H1A1,1,0,0,0,1,8Z" />
                                </g>
                            </svg>
                        </div>
                    </div>
                    <p class="prod-price"><?= $products[0]['unit_price'] ?><span>$</span></p>
                    <div class="prod-color-options">
                        <div class="prod-options-slider " id="parent_div_of_color">
                            <div class="prod-options-slide item__boxes" id="1_color" onclick="selectColor('1_color')" data-slick-index="0">
                                <p class="prod-color">Maroon</p>
                                <img src="<?= base_url('assets/') ?>images/Pen 2.png" />
                            </div>
                            <div class="prod-options-slide item__boxes" id="2_color" onclick="selectColor('2_color')" data-slick-index="1">
                                <p class="prod-color">Maroon</p>
                                <img src="<?= base_url('assets/') ?>images/Pen 3.png" />
                            </div>
                            <div class="prod-options-slide item__boxes" id="3_color" onclick="selectColor('3_color')" data-slick-index="2">
                                <p class="prod-color">Maroon</p>
                                <img src="<?= base_url('assets/') ?>images/Pen 4.png" />
                            </div>
                            <div class="prod-options-slide item__boxes" id="4_color" onclick="selectColor('4_color')" data-slick-index="3">
                                <p class="prod-color">Maroon</p>
                                <img src="<?= base_url('assets/') ?>images/Pen 5.png" />
                            </div>
                            <div class="prod-options-slide item__boxes" id="5_color" onclick="selectColor('5_color')" data-slick-index="4">
                                <p class="prod-color">Maroon</p>
                                <img src="<?= base_url('assets/') ?>images/Pen 6.png" />
                            </div>
                        </div>
                    </div>

                    <div class="review-wrapper">
                        <p class="reviews-count">Reviews(17)</p>
                        <div class="review-stars">
                            <svg class="review-fill" xmlns="http://www.w3.org/2000/svg" id="Filled" viewBox="0 0 24 24" width="512" height="512">
                                <path d="M1.327,12.4,4.887,15,3.535,19.187A3.178,3.178,0,0,0,4.719,22.8a3.177,3.177,0,0,0,3.8-.019L12,20.219l3.482,2.559a3.227,3.227,0,0,0,4.983-3.591L19.113,15l3.56-2.6a3.227,3.227,0,0,0-1.9-5.832H16.4L15.073,2.432a3.227,3.227,0,0,0-6.146,0L7.6,6.568H3.231a3.227,3.227,0,0,0-1.9,5.832Z" />
                            </svg>

                            <svg class="review-fill" xmlns="http://www.w3.org/2000/svg" id="Filled" viewBox="0 0 24 24" width="512" height="512">
                                <path d="M1.327,12.4,4.887,15,3.535,19.187A3.178,3.178,0,0,0,4.719,22.8a3.177,3.177,0,0,0,3.8-.019L12,20.219l3.482,2.559a3.227,3.227,0,0,0,4.983-3.591L19.113,15l3.56-2.6a3.227,3.227,0,0,0-1.9-5.832H16.4L15.073,2.432a3.227,3.227,0,0,0-6.146,0L7.6,6.568H3.231a3.227,3.227,0,0,0-1.9,5.832Z" />
                            </svg>

                            <svg class="review-fill" xmlns="http://www.w3.org/2000/svg" id="Filled" viewBox="0 0 24 24" width="512" height="512">
                                <path d="M1.327,12.4,4.887,15,3.535,19.187A3.178,3.178,0,0,0,4.719,22.8a3.177,3.177,0,0,0,3.8-.019L12,20.219l3.482,2.559a3.227,3.227,0,0,0,4.983-3.591L19.113,15l3.56-2.6a3.227,3.227,0,0,0-1.9-5.832H16.4L15.073,2.432a3.227,3.227,0,0,0-6.146,0L7.6,6.568H3.231a3.227,3.227,0,0,0-1.9,5.832Z" />
                            </svg>

                            <svg class="review-fill" xmlns="http://www.w3.org/2000/svg" id="Filled" viewBox="0 0 24 24" width="512" height="512">
                                <path d="M1.327,12.4,4.887,15,3.535,19.187A3.178,3.178,0,0,0,4.719,22.8a3.177,3.177,0,0,0,3.8-.019L12,20.219l3.482,2.559a3.227,3.227,0,0,0,4.983-3.591L19.113,15l3.56-2.6a3.227,3.227,0,0,0-1.9-5.832H16.4L15.073,2.432a3.227,3.227,0,0,0-6.146,0L7.6,6.568H3.231a3.227,3.227,0,0,0-1.9,5.832Z" />
                            </svg>

                            <svg xmlns="http://www.w3.org/2000/svg" id="Filled" viewBox="0 0 24 24" width="512" height="512">
                                <path d="M1.327,12.4,4.887,15,3.535,19.187A3.178,3.178,0,0,0,4.719,22.8a3.177,3.177,0,0,0,3.8-.019L12,20.219l3.482,2.559a3.227,3.227,0,0,0,4.983-3.591L19.113,15l3.56-2.6a3.227,3.227,0,0,0-1.9-5.832H16.4L15.073,2.432a3.227,3.227,0,0,0-6.146,0L7.6,6.568H3.231a3.227,3.227,0,0,0-1.9,5.832Z" />
                            </svg>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-lg-4 col-md-6 col-sm-12">
                            <p class="options-title">Clip</p>
                            <div class="options-title-items active-option">
                                <p>With Clip</p>
                                <p>$5.00</p>
                            </div>
                            <div class="options-title-items">
                                <p>Without Clip</p>
                                <p>$5.00</p>
                            </div>
                        </div>
                        <?php
                        if (isset($nib)) { ?>
                            <div class="col-12 col-lg-8 col-md-6 col-sm-12">
                                <p class="options-title">Nib</p>
                                <!-- <div class="options-title-items">
                                <p>With Clip</p>
                                <p>$5.00</p>
                            </div> -->
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle options-title-items" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <p class="title-first">--Plese Select--</p>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

                                        <?php
                                        foreach ($nib as $nib_data) { ?>
                                            <li><a class="dropdown-item"><?= $nib_data['name'] ?></a></li>
                                        <?php }
                                        ?>


                                    </ul>
                                </div>
                            </div>
                        <?php }
                        ?>

                    </div>

                    <p class="options-title">Availability: In Stock</p>
                    <button class="options-title-items active-option">
                        Add to Cart
                    </button>

                    <p class="options-title write-link">Write a Review</p>
                </div>
            </div>
        </div>
        <div class="description-wrapper">
            <p class="desc-title">Description</p>
            <p>
                <?= $products[0]['description'] ?>
            </p>
        </div>
        <div class="row">
            <div class="col-12 col-lg-6 col-md-4 col-sm-12">
                <div class="more-details-options">
                    <p class="more-details-title" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                        <span>Details</span><svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_85_6)">
                                <path d="M3.93182 5.78977H3.25L0.454545 0.301137H1.54545L3.57386 4.51136L3.50568 4.47727H3.67614L3.60795 4.51136L5.63636 0.301137H6.72727L3.93182 5.78977Z" fill="#D77FA6" />
                            </g>
                            <defs>
                                <clipPath id="clip0_85_6">
                                    <rect width="7.2" height="6" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                    </p>
                    <div class="details-wrapper" id="collapseOne">
                        <div class="row">
                            <div class="col-lg-6">Material of Nib:</div>
                            <div class="col-lg-6 grey-color">Japanese Nikko Ebonite</div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">Nib:</div>
                            <div class="col-lg-6 grey-color">
                                Fitted with C/C type Gold Platted Jovo #6 type Available in
                                F/M/B
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">Material of Nib:</div>
                            <div class="col-lg-6 grey-color">Japanese Nikko Ebonite</div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">Clip:</div>
                            <div class="col-lg-6 grey-color">Japanese Nikko Ebonite</div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">Material of Nib:</div>
                            <div class="col-lg-6 grey-color">Japanese Nikko Ebonite</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-md-4 col-sm-12">
                <div class="more-details-options">
                    <p class="more-details-title" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                        <span>Specifications</span><svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_85_6)">
                                <path d="M3.93182 5.78977H3.25L0.454545 0.301137H1.54545L3.57386 4.51136L3.50568 4.47727H3.67614L3.60795 4.51136L5.63636 0.301137H6.72727L3.93182 5.78977Z" fill="#D77FA6" />
                            </g>
                            <defs>
                                <clipPath id="clip0_85_6">
                                    <rect width="7.2" height="6" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                    </p>
                    <div class="details-wrapper" id="collapseTwo">
                        <div class="row">
                            <div class="col-lg-6">Material of Nib:</div>
                            <div class="col-lg-6 grey-color">Japanese Nikko Ebonite</div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">Nib:</div>
                            <div class="col-lg-6 grey-color">
                                Fitted with C/C type Gold Platted Jovo #6 type Available in
                                F/M/B
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">Material of Nib:</div>
                            <div class="col-lg-6 grey-color">Japanese Nikko Ebonite</div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">Clip:</div>
                            <div class="col-lg-6 grey-color">Japanese Nikko Ebonite</div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">Material of Nib:</div>
                            <div class="col-lg-6 grey-color">Japanese Nikko Ebonite</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }
?>