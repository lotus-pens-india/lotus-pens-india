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
</style>
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
                    if (isset($details) && count($details) > 0) {
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
                    <p class="prod-price"><?= $price[0]['mrp'] ?><span><?= $this->session->userdata('currency_symbol') ?></span></p>
                    <div class="prod-color-options">
                        <div class="prod-options-slider " id="parent_div_of_color">

                            <?php
                            if (isset($details) && count($details) > 0) {
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
                    if (isset($nib) && count($nib) > 0) { ?>

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
                    if (isset($clip) && count($clip) > 0) { ?>

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
                    if (isset($matrial) && count($matrial) > 0) { ?>

                        <div class="row">
                            <p class="options-title mb-0">Material</p>
                            <div class="col-12">
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

                <p class="options-title write-link">Write a Review</p>
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
<script src="<?= base_url('assets/') ?>js/cart.js"></script>