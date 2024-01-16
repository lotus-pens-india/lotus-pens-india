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
        --border: #fff;
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
</style>
<link rel="stylesheet" type="text/css" href="<?= base_url('assets/') ?>css/star-rating.css" />
<?php
if (isset($products)) { ?>
    <div class="container m-bt-30">
        <div class="title-wrapper">
            <p class="title-headings">Product Details</p>
        </div>
        <div class="row">
            <div class="col-12 col-lg-6 col-md-12 col-sm-12">
                <div class="product-slider">
                    <?php
                    if (isset($details) && is_array($details)) {
                        foreach ($details as $product_details) { ?>
                            <img class="product-img" src="<?= base_url() ?>lotus_pens_admin/assets/images/thumbnail/<?= $product_details['image'] ?>" />
                    <?php }
                    }
                    ?>
                </div>
            </div>
            <div class="col-12 col-lg-6 col-md-12 col-sm-12">
                <div class="product-info">
                    <div class="prod-info-title">
                        <input type="hidden" value="<?= $products[0]['product_id'] ?>" id="product_code_text">
                        <div class="prod-info-title-name">
                            <p class="prod-name" id="product_name_div"><?= $products[0]['product_name'] ?></p>
                            <p class="prod-code">Product Code: <?= $products[0]['product_code'] ?></p>
                        </div>
                        <div class="prod-icons" id="wishlist_btn_div_<?= $products[0]['product_id'] ?>">
                            <!-- <svg class="exchange-icon" xmlns="http://www.w3.org/2000/svg" id="arrow-circle-down" viewBox="0 0 24 24" width="512" height="512">
                                <g>
                                    <path d="M23,16H2.681l.014-.015L4.939,13.7a1,1,0,1,0-1.426-1.4L1.274,14.577c-.163.163-.391.413-.624.676a2.588,2.588,0,0,0,0,3.429c.233.262.461.512.618.67l2.245,2.284a1,1,0,0,0,1.426-1.4L2.744,18H23a1,1,0,0,0,0-2Z" />
                                    <path d="M1,8H21.255l-2.194,2.233a1,1,0,1,0,1.426,1.4l2.239-2.279c.163-.163.391-.413.624-.675a2.588,2.588,0,0,0,0-3.429c-.233-.263-.461-.513-.618-.67L20.487,2.3a1,1,0,0,0-1.426,1.4l2.251,2.29L21.32,6H1A1,1,0,0,0,1,8Z" />
                                </g>
                            </svg> -->
                        </div>
                    </div>
                    <p class="prod-price">
                    <?php
                    if(isset($price[0]['discount']) && $price[0]['discount']!=0){?>
                        <span style="color:#c90000">-<?=$price[0]['discount']?>%</span> 
                    <?php }
                    ?>    
                     
                    <?= $price[0]['price'] ?><span><?= $this->session->userdata('currency_symbol') ?></span>
                    <?php if((isset($price[0]['mrp']) && isset($price[0]['price'])) && ($price[0]['price']!=$price[0]['mrp'])){?>
                        <span style="text-decoration"><s><?= $price[0]['mrp'] ?> <?= $this->session->userdata('currency_symbol') ?></s></span> 
                    <?php }
                    ?> 
                    </p>
                     
                    <div class="prod-color-options">
                        <div class="prod-options-slider " id="parent_div_of_color">

                            <?php
                            if (isset($details) && is_array($details)) {
                                foreach ($details as $index => $product_details) {
                                    $makeSelected = $index == 0 ? 'prod-options-slide-first' : '';
                                    $makeSelectedPtag = $index == 0 ? 'selected_color' : '';
                            ?>
                                    <div class="prod-options-slide item__boxes <?= $makeSelected ?>" id="<?= $index ?>_color" onclick="selectColor('<?= $index ?>_color')" data-slick-index="<?= $index ?>">
                                        <p class="prod-color <?= $makeSelectedPtag ?>" id="<?= $index ?>_color_text"><?= $product_details['title'] ?></p>
                                        <img src="<?= base_url() ?>lotus_pens_admin/assets/images/thumbnail/<?= $product_details['image'] ?>" />
                                    </div>
                            <?php }
                            }
                            ?>
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
                        <div class="col">
                            <p class="options-title mb-0">Clip</p>
                        </div>
                    </div>
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
                    <?php
                    if (isset($nib) && is_array($nib) && count($nib) > 0) { ?>

                        <div class="row">
                            <div class="col-12">
                                <p class="options-title mb-0">Nib</p>
                                <div class="dropdown">
                                    <div class="filters">
                                        <select id="nib_select" class="select-club-services" style="width: fit-content;" name="nib_select">
                                            <?php
                                            foreach ($nib as $nib_data) { ?>
                                                <option value="<?= $nib_data['id'] ?>">
                                                    <?php
                                                    if ($nib_data[$this->session->userdata('active_currency') . "_price"] != 0) {
                                                        echo  $nib_data['name'] . "（" . $this->session->userdata('currency_symbol') . "+" . $nib_data[$this->session->userdata('active_currency') . "_price"] . "）";
                                                    } else {
                                                        echo  $nib_data['name'];
                                                    }
                                                    ?>

                                                </option>

                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }
                    ?>

                    <?php
                    if (isset($clip) && is_array($clip) && count($clip) > 0) { ?>

                        <div class="row">

                            <div class="col-12">
                                <p class="options-title mb-0">Clip and Rings</p>
                                <div class="dropdown">
                                    <div class="filters">
                                        <select id="clip_select" class="select-club-services" style="width: fit-content;" name="clip_select">
                                            <?php
                                            foreach ($clip as $clip_data) { ?>
                                                <option value="<?= $clip_data['id'] ?>"><?= $clip_data['name'] ?></option>

                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }
                    ?>


                    <?php
                    if (isset($matrial) && is_array($matrial) && count($matrial) > 0) { ?>

                        <div class="row">
                            <div class="col-12">
                            <p class="options-title mb-0">Material</p>
                                <div class="dropdown">
                                    <div class="filters">
                                        <select id="material_select" class="select-club-services" style="width: fit-content;" name="material_select">
                                            <?php
                                            foreach ($matrial as $matrial_data) { ?>
                                                <option value="<?= $matrial_data['id'] ?>">

                                                    <?php
                                                    if ($matrial_data[$this->session->userdata('active_currency') . "_price"] != 0) {
                                                        echo  $matrial_data['name'] . "（" . $this->session->userdata('currency_symbol') . "+" . $matrial_data[$this->session->userdata('active_currency') . "_price"] . "）";
                                                    } else {
                                                        echo  $matrial_data['name'];
                                                    }
                                                    ?>
                                                </option>
                                            <?php }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php }
                    ?>

                </div>

                <p class="options-title">Availability: In Stock</p>
                <button class="options-title-items active-option add-cart-btn" onclick="addToCart()">
                    Add to Cart
                </button>

                <div class="row">
                    <div class="col-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <span class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <p class="options-title write-link" style="cursor: pointer;font-size:1.1rem!important;">Reviews</p>
                                    </span>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <?php
                                        if (isset($reviews) && is_array($reviews) && count($reviews) > 0) {
                                            foreach ($reviews as $rData) { ?>
                                                <div class="row" style="">
                                                    <div class="col-12 col-lg-12 col-md-12 col-sm-12">
                                                        <span>
                                                            <div class="review-stars ">
                                                                <h6 style="margin-right: 5px;"><?= $rData['customer_name'] ?></h6>
                                                                <?php
                                                                $ratings = $rData['ratings'];
                                                                if ($ratings != 0) {
                                                                    for ($i = 1; $i < $ratings; $i++) { ?>
                                                                        <svg class="review-fill" xmlns="http://www.w3.org/2000/svg" id="Filled" viewBox="0 0 24 24" width="512" height="512">
                                                                            <path d="M1.327,12.4,4.887,15,3.535,19.187A3.178,3.178,0,0,0,4.719,22.8a3.177,3.177,0,0,0,3.8-.019L12,20.219l3.482,2.559a3.227,3.227,0,0,0,4.983-3.591L19.113,15l3.56-2.6a3.227,3.227,0,0,0-1.9-5.832H16.4L15.073,2.432a3.227,3.227,0,0,0-6.146,0L7.6,6.568H3.231a3.227,3.227,0,0,0-1.9,5.832Z"></path>
                                                                        </svg>
                                                                <?php }
                                                                }
                                                                ?>
                                                                <h6 class="mx-2"><?= $rData['created_at'] ?></h6>
                                                            </div>
                                                        </span>
                                                    </div>
                                                    <div class="col-12 col-lg-8 col-md-6 col-sm-12 mx-3" style="background-image:linear-gradient(to right, #f1f1f1, #fff);">
                                                        <div class="">
                                                            <p class="about-para">
                                                                <?= $rData['review'] ?>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                        <?php }
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <span class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        <p class="options-title write-link" style="cursor: pointer;font-size:1.1rem!important;">Write a Review</p>
                                    </span>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <form id="rating_form">
                                            <div class="row">
                                                <div class="col-12 col-lg-12 col-md-12 col-sm-12 form-inputs">
                                                    <label for="cname" class="float-start">Your Name</label>
                                                    <input type="text" id="cname" name="cname" value="<?= $this->session->userdata('userdata')['first_name'] ?> <?= $this->session->userdata('userdata')['last_name'] ?>">
                                                </div>

                                                <div class="col-12 col-lg-12 col-md-12 col-sm-12 form-inputs">
                                                    <label for="review" class="float-start">Your review</label>
                                                    <textarea id="review" name="review"></textarea>
                                                </div>

                                                <div class="col-12 col-lg-12 col-md-12 col-sm-12 form-inputs">
                                                    <h6 class="float-start">Ratings</h6>
                                                </div>
                                                <div class="col-12 col-lg-12 col-md-12 col-sm-12 form-inputs">
                                                    <div class="float-start">
                                                        <div class="rating">
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
                                                            <div class="emoji-wrapper">
                                                                <div class="emoji">
                                                                    <svg class="rating-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                        <circle cx="256" cy="256" r="256" fill="#ffd93b" />
                                                                        <path d="M512 256c0 141.44-114.64 256-256 256-80.48 0-152.32-37.12-199.28-95.28 43.92 35.52 99.84 56.72 160.72 56.72 141.36 0 256-114.56 256-256 0-60.88-21.2-116.8-56.72-160.72C474.8 103.68 512 175.52 512 256z" fill="#f4c534" />
                                                                        <ellipse transform="scale(-1) rotate(31.21 715.433 -595.455)" cx="166.318" cy="199.829" rx="56.146" ry="56.13" fill="#fff" />
                                                                        <ellipse transform="rotate(-148.804 180.87 175.82)" cx="180.871" cy="175.822" rx="28.048" ry="28.08" fill="#3e4347" />
                                                                        <ellipse transform="rotate(-113.778 194.434 165.995)" cx="194.433" cy="165.993" rx="8.016" ry="5.296" fill="#5a5f63" />
                                                                        <ellipse transform="scale(-1) rotate(31.21 715.397 -1237.664)" cx="345.695" cy="199.819" rx="56.146" ry="56.13" fill="#fff" />
                                                                        <ellipse transform="rotate(-148.804 360.25 175.837)" cx="360.252" cy="175.84" rx="28.048" ry="28.08" fill="#3e4347" />
                                                                        <ellipse transform="scale(-1) rotate(66.227 254.508 -573.138)" cx="373.794" cy="165.987" rx="8.016" ry="5.296" fill="#5a5f63" />
                                                                        <path d="M370.56 344.4c0 7.696-6.224 13.92-13.92 13.92H155.36c-7.616 0-13.92-6.224-13.92-13.92s6.304-13.92 13.92-13.92h201.296c7.696.016 13.904 6.224 13.904 13.92z" fill="#3e4347" />
                                                                    </svg>
                                                                    <svg class="rating-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                        <circle cx="256" cy="256" r="256" fill="#ffd93b" />
                                                                        <path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534" />
                                                                        <path d="M328.4 428a92.8 92.8 0 0 0-145-.1 6.8 6.8 0 0 1-12-5.8 86.6 86.6 0 0 1 84.5-69 86.6 86.6 0 0 1 84.7 69.8c1.3 6.9-7.7 10.6-12.2 5.1z" fill="#3e4347" />
                                                                        <path d="M269.2 222.3c5.3 62.8 52 113.9 104.8 113.9 52.3 0 90.8-51.1 85.6-113.9-2-25-10.8-47.9-23.7-66.7-4.1-6.1-12.2-8-18.5-4.2a111.8 111.8 0 0 1-60.1 16.2c-22.8 0-42.1-5.6-57.8-14.8-6.8-4-15.4-1.5-18.9 5.4-9 18.2-13.2 40.3-11.4 64.1z" fill="#f4c534" />
                                                                        <path d="M357 189.5c25.8 0 47-7.1 63.7-18.7 10 14.6 17 32.1 18.7 51.6 4 49.6-26.1 89.7-67.5 89.7-41.6 0-78.4-40.1-82.5-89.7A95 95 0 0 1 298 174c16 9.7 35.6 15.5 59 15.5z" fill="#fff" />
                                                                        <path d="M396.2 246.1a38.5 38.5 0 0 1-38.7 38.6 38.5 38.5 0 0 1-38.6-38.6 38.6 38.6 0 1 1 77.3 0z" fill="#3e4347" />
                                                                        <path d="M380.4 241.1c-3.2 3.2-9.9 1.7-14.9-3.2-4.8-4.8-6.2-11.5-3-14.7 3.3-3.4 10-2 14.9 2.9 4.9 5 6.4 11.7 3 15z" fill="#fff" />
                                                                        <path d="M242.8 222.3c-5.3 62.8-52 113.9-104.8 113.9-52.3 0-90.8-51.1-85.6-113.9 2-25 10.8-47.9 23.7-66.7 4.1-6.1 12.2-8 18.5-4.2 16.2 10.1 36.2 16.2 60.1 16.2 22.8 0 42.1-5.6 57.8-14.8 6.8-4 15.4-1.5 18.9 5.4 9 18.2 13.2 40.3 11.4 64.1z" fill="#f4c534" />
                                                                        <path d="M155 189.5c-25.8 0-47-7.1-63.7-18.7-10 14.6-17 32.1-18.7 51.6-4 49.6 26.1 89.7 67.5 89.7 41.6 0 78.4-40.1 82.5-89.7A95 95 0 0 0 214 174c-16 9.7-35.6 15.5-59 15.5z" fill="#fff" />
                                                                        <path d="M115.8 246.1a38.5 38.5 0 0 0 38.7 38.6 38.5 38.5 0 0 0 38.6-38.6 38.6 38.6 0 1 0-77.3 0z" fill="#3e4347" />
                                                                        <path d="M131.6 241.1c3.2 3.2 9.9 1.7 14.9-3.2 4.8-4.8 6.2-11.5 3-14.7-3.3-3.4-10-2-14.9 2.9-4.9 5-6.4 11.7-3 15z" fill="#fff" />
                                                                    </svg>
                                                                    <svg class="rating-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                        <circle cx="256" cy="256" r="256" fill="#ffd93b" />
                                                                        <path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534" />
                                                                        <path d="M336.6 403.2c-6.5 8-16 10-25.5 5.2a117.6 117.6 0 0 0-110.2 0c-9.4 4.9-19 3.3-25.6-4.6-6.5-7.7-4.7-21.1 8.4-28 45.1-24 99.5-24 144.6 0 13 7 14.8 19.7 8.3 27.4z" fill="#3e4347" />
                                                                        <path d="M276.6 244.3a79.3 79.3 0 1 1 158.8 0 79.5 79.5 0 1 1-158.8 0z" fill="#fff" />
                                                                        <circle cx="340" cy="260.4" r="36.2" fill="#3e4347" />
                                                                        <g fill="#fff">
                                                                            <ellipse transform="rotate(-135 326.4 246.6)" cx="326.4" cy="246.6" rx="6.5" ry="10" />
                                                                            <path d="M231.9 244.3a79.3 79.3 0 1 0-158.8 0 79.5 79.5 0 1 0 158.8 0z" />
                                                                        </g>
                                                                        <circle cx="168.5" cy="260.4" r="36.2" fill="#3e4347" />
                                                                        <ellipse transform="rotate(-135 182.1 246.7)" cx="182.1" cy="246.7" rx="10" ry="6.5" fill="#fff" />
                                                                    </svg>
                                                                    <svg class="rating-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                        <circle cx="256" cy="256" r="256" fill="#ffd93b" />
                                                                        <path d="M407.7 352.8a163.9 163.9 0 0 1-303.5 0c-2.3-5.5 1.5-12 7.5-13.2a780.8 780.8 0 0 1 288.4 0c6 1.2 9.9 7.7 7.6 13.2z" fill="#3e4347" />
                                                                        <path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534" />
                                                                        <g fill="#fff">
                                                                            <path d="M115.3 339c18.2 29.6 75.1 32.8 143.1 32.8 67.1 0 124.2-3.2 143.2-31.6l-1.5-.6a780.6 780.6 0 0 0-284.8-.6z" />
                                                                            <ellipse cx="356.4" cy="205.3" rx="81.1" ry="81" />
                                                                        </g>
                                                                        <ellipse cx="356.4" cy="205.3" rx="44.2" ry="44.2" fill="#3e4347" />
                                                                        <g fill="#fff">
                                                                            <ellipse transform="scale(-1) rotate(45 454 -906)" cx="375.3" cy="188.1" rx="12" ry="8.1" />
                                                                            <ellipse cx="155.6" cy="205.3" rx="81.1" ry="81" />
                                                                        </g>
                                                                        <ellipse cx="155.6" cy="205.3" rx="44.2" ry="44.2" fill="#3e4347" />
                                                                        <ellipse transform="scale(-1) rotate(45 454 -421.3)" cx="174.5" cy="188" rx="12" ry="8.1" fill="#fff" />
                                                                    </svg>
                                                                    <svg class="rating-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                        <circle cx="256" cy="256" r="256" fill="#ffd93b" />
                                                                        <path d="M512 256A256 256 0 0 1 56.7 416.7a256 256 0 0 0 360-360c58.1 47 95.3 118.8 95.3 199.3z" fill="#f4c534" />
                                                                        <path d="M232.3 201.3c0 49.2-74.3 94.2-74.3 94.2s-74.4-45-74.4-94.2a38 38 0 0 1 74.4-11.1 38 38 0 0 1 74.3 11.1z" fill="#e24b4b" />
                                                                        <path d="M96.1 173.3a37.7 37.7 0 0 0-12.4 28c0 49.2 74.3 94.2 74.3 94.2C80.2 229.8 95.6 175.2 96 173.3z" fill="#d03f3f" />
                                                                        <path d="M215.2 200c-3.6 3-9.8 1-13.8-4.1-4.2-5.2-4.6-11.5-1.2-14.1 3.6-2.8 9.7-.7 13.9 4.4 4 5.2 4.6 11.4 1.1 13.8z" fill="#fff" />
                                                                        <path d="M428.4 201.3c0 49.2-74.4 94.2-74.4 94.2s-74.3-45-74.3-94.2a38 38 0 0 1 74.4-11.1 38 38 0 0 1 74.3 11.1z" fill="#e24b4b" />
                                                                        <path d="M292.2 173.3a37.7 37.7 0 0 0-12.4 28c0 49.2 74.3 94.2 74.3 94.2-77.8-65.7-62.4-120.3-61.9-122.2z" fill="#d03f3f" />
                                                                        <path d="M411.3 200c-3.6 3-9.8 1-13.8-4.1-4.2-5.2-4.6-11.5-1.2-14.1 3.6-2.8 9.7-.7 13.9 4.4 4 5.2 4.6 11.4 1.1 13.8z" fill="#fff" />
                                                                        <path d="M381.7 374.1c-30.2 35.9-75.3 64.4-125.7 64.4s-95.4-28.5-125.8-64.2a17.6 17.6 0 0 1 16.5-28.7 627.7 627.7 0 0 0 218.7-.1c16.2-2.7 27 16.1 16.3 28.6z" fill="#3e4347" />
                                                                        <path d="M256 438.5c25.7 0 50-7.5 71.7-19.5-9-33.7-40.7-43.3-62.6-31.7-29.7 15.8-62.8-4.7-75.6 34.3 20.3 10.4 42.8 17 66.5 17z" fill="#e24b4b" />
                                                                    </svg>
                                                                    <svg class="rating-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                                        <g fill="#ffd93b">
                                                                            <circle cx="256" cy="256" r="256" />
                                                                            <path d="M512 256A256 256 0 0 1 56.8 416.7a256 256 0 0 0 360-360c58 47 95.2 118.8 95.2 199.3z" />
                                                                        </g>
                                                                        <path d="M512 99.4v165.1c0 11-8.9 19.9-19.7 19.9h-187c-13 0-23.5-10.5-23.5-23.5v-21.3c0-12.9-8.9-24.8-21.6-26.7-16.2-2.5-30 10-30 25.5V261c0 13-10.5 23.5-23.5 23.5h-187A19.7 19.7 0 0 1 0 264.7V99.4c0-10.9 8.8-19.7 19.7-19.7h472.6c10.8 0 19.7 8.7 19.7 19.7z" fill="#e9eff4" />
                                                                        <path d="M204.6 138v88.2a23 23 0 0 1-23 23H58.2a23 23 0 0 1-23-23v-88.3a23 23 0 0 1 23-23h123.4a23 23 0 0 1 23 23z" fill="#45cbea" />
                                                                        <path d="M476.9 138v88.2a23 23 0 0 1-23 23H330.3a23 23 0 0 1-23-23v-88.3a23 23 0 0 1 23-23h123.4a23 23 0 0 1 23 23z" fill="#e84d88" />
                                                                        <g fill="#38c0dc">
                                                                            <path d="M95.2 114.9l-60 60v15.2l75.2-75.2zM123.3 114.9L35.1 203v23.2c0 1.8.3 3.7.7 5.4l116.8-116.7h-29.3z" />
                                                                        </g>
                                                                        <g fill="#d23f77">
                                                                            <path d="M373.3 114.9l-66 66V196l81.3-81.2zM401.5 114.9l-94.1 94v17.3c0 3.5.8 6.8 2.2 9.8l121.1-121.1h-29.2z" />
                                                                        </g>
                                                                        <path d="M329.5 395.2c0 44.7-33 81-73.4 81-40.7 0-73.5-36.3-73.5-81s32.8-81 73.5-81c40.5 0 73.4 36.3 73.4 81z" fill="#3e4347" />
                                                                        <path d="M256 476.2a70 70 0 0 0 53.3-25.5 34.6 34.6 0 0 0-58-25 34.4 34.4 0 0 0-47.8 26 69.9 69.9 0 0 0 52.6 24.5z" fill="#e24b4b" />
                                                                        <path d="M290.3 434.8c-1 3.4-5.8 5.2-11 3.9s-8.4-5.1-7.4-8.7c.8-3.3 5.7-5 10.7-3.8 5.1 1.4 8.5 5.3 7.7 8.6z" fill="#fff" opacity=".2" />
                                                                    </svg>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-lg-12 col-md-12 col-sm-12 my-2">
                                                    <button class="btn btn-primary" ">
                                                        Submit
                                                    </button>
                                                </div>
                                            </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class=" description-wrapper container m-bt-30">
                                                        <p class="desc-title">Description</p>
                                                        <p style="font-family:'estre', sans-serif!important;font-size:18px">
                                                            <?= $products[0]['description'] ?>
                                                        </p>
                                                </div>
                                                <div class="container m-bt-30">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="more-details-options">
                                                            <p class="more-details-title" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                                                <span>Technical Specifications</span><svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                                                            <div class="details-wrapper" id="collapseThree">
                                                                <?php
                                                               

                                                                            $tsp = ['dimension', 'nib_material', 'pen_material', 'trim', 'filling_mechanism'];
                                                                            $tspShow = ['Dimension', 'Nib Material', 'Pen Material', 'Trim', 'Filling Mechanism'];
                                                                            // var_dump($products);
                                                                            if($products[0]['technical_specification']!='' && $products[0]['technical_specification']!=null){
                                                                                
                                                                            $productTsp=json_decode($products[0]['technical_specification']);
                                                                            foreach($tsp as $index=> $tspData){?>
                                                                            
                                                                            <div class="row">
                                                                    <div class="col"><?= $tspShow[$index]?>: <span class="grey-color"><?= $productTsp->$tspData?></span></div>
                                                                   
                                                                </div>
									                            <?php }}?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php }
                                        ?>
                                        <script src="<?= base_url('assets/') ?>js/cart.js"></script>