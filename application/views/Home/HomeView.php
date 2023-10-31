<div id="banner-slider">
    <?php
    if (isset($banners)) {
        foreach ($banners as $banner) { ?>
            <div class="banner-slide" style="background-image: url('<?= base_url('lotus_pens_admin/assets/images/banner/') . '/' . $banner['banner'] ?>');">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-8 col-md-6 col-sm-12"></div>
                        <div class="b-slide-item col-lg-4 col-md-6 col-sm-12">
                            <h3 class="b-slide-heading">Esotile</h3>
                            <p class="b-slide-para">New Limited Edition</p>
                            <button class="b-slide-btn">Buy Now</button>
                        </div>
                    </div>
                </div>
            </div>
    <?php }
    }
    ?>


</div>

<!-- BELOW BANNER SECTION -->
<div class="container">
    <div class="below-banner-section">
        <div class="b-banner-title-wrapper">
            <svg class="top-icon" width="27" height="21" viewBox="0 0 27 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_79_2)">
                    <path d="M22.6123 1.9585L24.48 3.60645C23.2837 4.65625 22.3071 5.66943 21.5503 6.646C20.8179 7.59814 20.354 8.31836 20.1587 8.80664C19.9634 9.29492 19.7803 9.88086 19.6094 10.5645L19.7559 10.7842C21.3916 10.7842 22.5879 11.1382 23.3447 11.8462C24.1016 12.5542 24.48 13.6528 24.48 15.1421C24.48 16.2896 24.0649 17.3271 23.2349 18.2549C22.4292 19.1826 21.416 19.6465 20.1953 19.6465C18.8037 19.6465 17.644 19.2559 16.7163 18.4746C15.7886 17.6934 15.3247 16.436 15.3247 14.7026C15.3247 12.4077 16.0327 10.0396 17.4487 7.59814C18.8892 5.13232 20.6104 3.25244 22.6123 1.9585ZM9.02588 1.9585L10.8936 3.60645C9.69727 4.65625 8.73291 5.65723 8.00049 6.60938C7.26807 7.56152 6.79199 8.29395 6.57227 8.80664C6.37695 9.31934 6.19385 9.90527 6.02295 10.5645L6.16943 10.7842C7.80518 10.7842 9.00146 11.1382 9.7583 11.8462C10.5151 12.5542 10.8936 13.6528 10.8936 15.1421C10.8936 16.2896 10.4785 17.3271 9.64844 18.2549C8.84277 19.1826 7.82959 19.6465 6.60889 19.6465C5.21729 19.6465 4.05762 19.2559 3.12988 18.4746C2.20215 17.6934 1.73828 16.436 1.73828 14.7026C1.73828 12.4077 2.44629 10.0396 3.8623 7.59814C5.30273 5.13232 7.02393 3.25244 9.02588 1.9585Z" fill="black" />
                </g>
                <defs>
                    <clipPath id="clip0_79_2">
                        <rect width="27" height="21" fill="white" />
                    </clipPath>
                </defs>
            </svg>

            <p class="b-banner-title">
                We write to taste life twice, in the moment and in retrospect.
            </p>
            <svg class="bottom-icon" width="27" height="21" viewBox="0 0 27 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_79_5)">
                    <path d="M4.3877 1.9585L2.52002 3.60645C3.71631 4.65625 4.69287 5.66943 5.44971 6.646C6.18213 7.59814 6.646 8.31836 6.84131 8.80664C7.03662 9.29492 7.21973 9.88086 7.39062 10.5645L7.24414 10.7842C5.6084 10.7842 4.41211 11.1382 3.65527 11.8462C2.89844 12.5542 2.52002 13.6528 2.52002 15.1421C2.52002 16.2896 2.93506 17.3271 3.76514 18.2549C4.5708 19.1826 5.58398 19.6465 6.80469 19.6465C8.19629 19.6465 9.35596 19.2559 10.2837 18.4746C11.2114 17.6934 11.6753 16.436 11.6753 14.7026C11.6753 12.4077 10.9673 10.0396 9.55127 7.59814C8.11084 5.13232 6.38965 3.25244 4.3877 1.9585ZM17.9741 1.9585L16.1064 3.60645C17.3027 4.65625 18.2671 5.65723 18.9995 6.60938C19.7319 7.56152 20.208 8.29395 20.4277 8.80664C20.623 9.31934 20.8062 9.90527 20.9771 10.5645L20.8306 10.7842C19.1948 10.7842 17.9985 11.1382 17.2417 11.8462C16.4849 12.5542 16.1064 13.6528 16.1064 15.1421C16.1064 16.2896 16.5215 17.3271 17.3516 18.2549C18.1572 19.1826 19.1704 19.6465 20.3911 19.6465C21.7827 19.6465 22.9424 19.2559 23.8701 18.4746C24.7979 17.6934 25.2617 16.436 25.2617 14.7026C25.2617 12.4077 24.5537 10.0396 23.1377 7.59814C21.6973 5.13232 19.9761 3.25244 17.9741 1.9585Z" fill="black" />
                </g>
                <defs>
                    <clipPath id="clip0_79_5">
                        <rect width="27" height="21" fill="white" transform="matrix(-1 0 0 1 27 0)" />
                    </clipPath>
                </defs>
            </svg>
        </div>
        <p class="b-banner-name">-Anaïs Nin</p>

        <p class="b-banner-para">
            Lotus Pens is an Indian Fountain Pen company established in the year
            2017, by Arun Singhi who re-started his career at the age of 64. Lotus
            Pens uses top notch materials and craftmanship which is the reason it
            is a well known and highly respected pen company in a short period of
            time.
        </p>
    </div>
</div>

<!-- FEATURED SECTION -->
<div class="container">
    <div class="title-wrapper view-all-btn-wrapper">
        <p class="title-headings">Featured</p>
        <a href="#" class="view-all-btn">View All ></a>
    </div>
    <div class="featured-slider">
        <div class="img-wrapper">
            <img src="<?= base_url('assets/') ?>images/image1.png" />
        </div>
        <div class="img-wrapper">
            <img src="<?= base_url('assets/') ?>images/image1.png" />
        </div>
        <div class="img-wrapper">
            <img src="<?= base_url('assets/') ?>images/image1.png" />
        </div>
        <div class="img-wrapper">
            <img src="<?= base_url('assets/') ?>images/image1.png" />
        </div>
        <div class="img-wrapper">
            <img src="<?= base_url('assets/') ?>images/image1.png" />
        </div>
        <div class="img-wrapper">
            <img src="<?= base_url('assets/') ?>images/image1.png" />
        </div>
        <div class="img-wrapper">
            <img src="<?= base_url('assets/') ?>images/image1.png" />
        </div>
    </div>
</div>

<!-- Custom Hand Painted Fountain Pens SECTION -->
<div class="container m-t-80">
    <div class="title-wrapper view-all-btn-wrapper">
        <p class="title-headings">Custom Hand Painted Fountain Pens</p>

        <a href="#" class="view-all-btn">View All ></a>
    </div>
    <div class="cards-section row">
        <div class="col-12 col-lg-5 col-md-6 col-sm-12">
            <img class="left-card" src="<?= base_url('assets/') ?>images/image4.png" />
        </div>
        <div class="col-12 col-lg-7 col-md-6 col-sm-12">
            <div class="row">
                <div class="col-12 col-lg-6 col-md-6 col-sm-12 right-card">
                    <p class="card-title">JAMAVAR</p>
                    <p class="card-subtitle">Lotus Hand Painted Series</p>
                    <a class="card-link">Buy Now</a>
                </div>
                <div class="col-12 col-lg-6 col-md-6 col-sm-12 pd-l-0 pd-r-0">
                    <img class="right-r-card" src="<?= base_url('assets/') ?>images/image5.png" />
                </div>
            </div>
            <div class="row row-mb-reverse">
                <div class="col-12 col-lg-6 col-md-6 col-sm-12 pd-l-0 pd-r-0">
                    <img class="right-l-card" src="<?= base_url('assets/') ?>images/image6.png" />
                </div>
                <div class="col-12 col-lg-6 col-md-6 col-sm-12 right-card">
                    <p class="card-title card-title2">MONUMENTS</p>
                    <p class="card-subtitle">Lotus Hand Painted Series</p>
                    <a class="card-link">Buy Now</a>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Testimonials SECTION -->
<div class="container m-t-80">
    <div class="title-wrapper">
        <p class="title-headings">Testimonials</p>
    </div>
</div>

<div class="testimonials-slider">
    <?php

    if (isset($testimonials) && $testimonials != false && count($testimonials) > 0) {
        foreach ($testimonials as $testimonialsDetails) { ?>
            <div class="testimonials-slide shadow-lg rounded-4">
                <div class="review-text-wrapper">
                    <svg class="review-top-icon" width="27" height="21" viewBox="0 0 27 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_79_2)">
                            <path d="M22.6123 1.9585L24.48 3.60645C23.2837 4.65625 22.3071 5.66943 21.5503 6.646C20.8179 7.59814 20.354 8.31836 20.1587 8.80664C19.9634 9.29492 19.7803 9.88086 19.6094 10.5645L19.7559 10.7842C21.3916 10.7842 22.5879 11.1382 23.3447 11.8462C24.1016 12.5542 24.48 13.6528 24.48 15.1421C24.48 16.2896 24.0649 17.3271 23.2349 18.2549C22.4292 19.1826 21.416 19.6465 20.1953 19.6465C18.8037 19.6465 17.644 19.2559 16.7163 18.4746C15.7886 17.6934 15.3247 16.436 15.3247 14.7026C15.3247 12.4077 16.0327 10.0396 17.4487 7.59814C18.8892 5.13232 20.6104 3.25244 22.6123 1.9585ZM9.02588 1.9585L10.8936 3.60645C9.69727 4.65625 8.73291 5.65723 8.00049 6.60938C7.26807 7.56152 6.79199 8.29395 6.57227 8.80664C6.37695 9.31934 6.19385 9.90527 6.02295 10.5645L6.16943 10.7842C7.80518 10.7842 9.00146 11.1382 9.7583 11.8462C10.5151 12.5542 10.8936 13.6528 10.8936 15.1421C10.8936 16.2896 10.4785 17.3271 9.64844 18.2549C8.84277 19.1826 7.82959 19.6465 6.60889 19.6465C5.21729 19.6465 4.05762 19.2559 3.12988 18.4746C2.20215 17.6934 1.73828 16.436 1.73828 14.7026C1.73828 12.4077 2.44629 10.0396 3.8623 7.59814C5.30273 5.13232 7.02393 3.25244 9.02588 1.9585Z" fill="black" />
                        </g>
                        <defs>
                            <clipPath id="clip0_79_2">
                                <rect width="27" height="21" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>

                    <p class="review">
                        <?= $testimonialsDetails['review'] ?>
                    </p>
                    <svg class="review-bottom-icon" width="27" height="21" viewBox="0 0 27 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_79_5)">
                            <path d="M4.3877 1.9585L2.52002 3.60645C3.71631 4.65625 4.69287 5.66943 5.44971 6.646C6.18213 7.59814 6.646 8.31836 6.84131 8.80664C7.03662 9.29492 7.21973 9.88086 7.39062 10.5645L7.24414 10.7842C5.6084 10.7842 4.41211 11.1382 3.65527 11.8462C2.89844 12.5542 2.52002 13.6528 2.52002 15.1421C2.52002 16.2896 2.93506 17.3271 3.76514 18.2549C4.5708 19.1826 5.58398 19.6465 6.80469 19.6465C8.19629 19.6465 9.35596 19.2559 10.2837 18.4746C11.2114 17.6934 11.6753 16.436 11.6753 14.7026C11.6753 12.4077 10.9673 10.0396 9.55127 7.59814C8.11084 5.13232 6.38965 3.25244 4.3877 1.9585ZM17.9741 1.9585L16.1064 3.60645C17.3027 4.65625 18.2671 5.65723 18.9995 6.60938C19.7319 7.56152 20.208 8.29395 20.4277 8.80664C20.623 9.31934 20.8062 9.90527 20.9771 10.5645L20.8306 10.7842C19.1948 10.7842 17.9985 11.1382 17.2417 11.8462C16.4849 12.5542 16.1064 13.6528 16.1064 15.1421C16.1064 16.2896 16.5215 17.3271 17.3516 18.2549C18.1572 19.1826 19.1704 19.6465 20.3911 19.6465C21.7827 19.6465 22.9424 19.2559 23.8701 18.4746C24.7979 17.6934 25.2617 16.436 25.2617 14.7026C25.2617 12.4077 24.5537 10.0396 23.1377 7.59814C21.6973 5.13232 19.9761 3.25244 17.9741 1.9585Z" fill="black" />
                        </g>
                        <defs>
                            <clipPath id="clip0_79_5">
                                <rect width="27" height="21" fill="white" transform="matrix(-1 0 0 1 27 0)" />
                            </clipPath>
                        </defs>
                    </svg>
                </div>
                <div class="review-stars test-review-stars">
                    <?php
                    for ($i = 0; $i < $testimonialsDetails['rating']; $i++) { ?>
                        <svg class="review-fill" xmlns="http://www.w3.org/2000/svg" id="Filled" viewBox="0 0 24 24" width="512" height="512">
                            <path d="M1.327,12.4,4.887,15,3.535,19.187A3.178,3.178,0,0,0,4.719,22.8a3.177,3.177,0,0,0,3.8-.019L12,20.219l3.482,2.559a3.227,3.227,0,0,0,4.983-3.591L19.113,15l3.56-2.6a3.227,3.227,0,0,0-1.9-5.832H16.4L15.073,2.432a3.227,3.227,0,0,0-6.146,0L7.6,6.568H3.231a3.227,3.227,0,0,0-1.9,5.832Z" />
                        </svg>
                    <?php }
                    ?>
                </div>
                <p class="reviewer-name">- <?= $testimonialsDetails['author'] ?></p>
            </div>
    <?php }
    }
    ?>
</div>

<!-- Products SECTION -->
<div class="container product-section m-t-80">
    <div class="title-wrapper view-all-btn-wrapper">
        <p class="title-headings">Products</p>
        <a href="<?= base_url() ?>products" class="view-all-btn">View All ></a>
    </div>
    <div class="row product-wrapper">
        <?php
        if (isset($products)) {

            foreach ($products as $product) {
        ?>


                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-3">
                    <div class="img-wrapper">
                        <img src="<?= base_url('lotus_pens_admin/assets/') ?>images/product/<?= $product['main_image'] ?>" />
                        <div class="img-overview">
                            <a class="overview-link" type="button" onclick="openQuickView('<?= base_url('lotus_pens_admin/assets/') ?>images/product/<?= $product['main_image'] ?>')">Quick View</a>
                            <a class="overview-link" href="<?= base_url() ?>product/<?= $product['product_id'] ?>">Explore</a>
                        </div>
                    </div>
                    <a href="product/<?= $product['product_id'] ?>" style="cursor:pointer;text-decoration:none;color:black">
                        <!-- <p class="best-seller-title">Bestseller</p> -->
                        <p class="product-name"><?= $product['product_name'] ?></p>
                        <!-- <p class="product-colors">4 Colours</p> -->
                        <p class="product-amount"><?= $this->session->userdata('currency_symbol') . "" . $product['unit_price'] ?></p>
                    </a>
                </div>

        <?php }
        }
        ?>

    </div>

</div>


<!-- ABOUT SECTION -->
<div class="container about-section m-t-80">
    <div class="title-wrapper">
        <p class="title-headings">About Us</p>
    </div>
</div>
<div class="about-us-wrapper">
    <div class="container">
        <div class="row about-us-section">
            <div class="col-12 col-lg-8 col-md-6 col-sm-12">
                <div class="about-us-content">
                    <h3 class="about-heading">About Arun Singhi</h3>
                    <p class="about-subheading">Founder director Lotus Pens</p>
                    <p class="about-para">
                        Lotus all happened because of my passion for pens. I always wanted to create. Lotus is my baby. I am in this industry from past 5 decades. But always felt incomplete and no mental satisfaction in job. In the urge for making something from scratch lotus started in the year 2015.
                    </p>
                    <p class="about-para">
                        My first order was for 5 Ganesha Hand painted roller metal pens from Mr.Harmesh Modi of Mumbai On date 3rd January 2015 We first started with painted pens. We use the best quality material and expertise in painting we than spread our wings to metal pens and now to Ebonite fountain pen.
                    </p>
                    <p class="about-para">
                        Each fountain pen is 100% handmade. We use the best of material and we totally believe in giving what our patron is looking for.

                        Meeting fountain pen connoisseur and learning from them everyday made me execute well. I have a long way to go, i will reach the pinnacle with my willingness to learn every moment.
                    </p>
                </div>
            </div>
            <div class="col-12 col-lg-4 col-md-6 col-sm-12">
                <img class="about-img" src="<?= base_url('assets/') ?>images/image2.png" />
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row about-us-section">
            <div class="col-12 col-lg-6 col-md-6 col-sm-12">
                <img class="about-img" src="<?= base_url('assets/') ?>images/image3.png" />
            </div>
            <div class="col-12 col-lg-6 col-md-6 col-sm-12">
                <p class="about-sub-section-heading">
                    We have a long way to go, we will reach the pinnacle with my willingness
                    to learn every moment.
                </p>
            </div>
        </div>
    </div>
</div>

<!-- FAQ SECTION -->
<div class="container m-t-80">
    <div class="title-wrapper">
        <p class="title-headings">FAQs</p>
    </div>
</div>
<div class="faq-section">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8 col-md-12 col-sm-12">
                <div class="faq-wrapper">
                    <div class="faq-item">
                        <div class="faq-question">
                            <p>How do I place an order ?</p>
                            <svg width="80" height="81" viewBox="0 0 80 81" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect y="80.0039" width="80" height="80" rx="40" transform="rotate(-90 0 80.0039)" fill="#D77FA6" />
                                <path d="M50.3923 34.0039L40 52.0039L29.6077 34.0039L50.3923 34.0039Z" fill="#D77FA6" stroke="white" stroke-width="3" />
                                <rect x="44.6035" y="41.1191" width="9.88609" height="15.5685" transform="rotate(-150.49 44.6035 41.1191)" fill="#D77FA6" />
                                <rect x="34.8496" y="40.0918" width="10" height="15.5685" transform="rotate(-120 34.8496 40.0918)" fill="#D77FA6" />
                            </svg>
                        </div>
                        <div class="faq-answer">
                            <p class="faq-ans">
                                Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                                Eos molestiae optio error nemo provident tempora sequi
                                excepturi, et expedita necessitatibus omnis reiciendis
                                aspernatur, at cupiditate? Quia quod dicta eos libero.
                            </p>
                            <div class="faq-ans-footer"></div>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">
                            <p>How do I place an order ?</p>
                            <svg width="80" height="81" viewBox="0 0 80 81" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect y="80.0039" width="80" height="80" rx="40" transform="rotate(-90 0 80.0039)" fill="#D77FA6" />
                                <path d="M50.3923 34.0039L40 52.0039L29.6077 34.0039L50.3923 34.0039Z" fill="#D77FA6" stroke="white" stroke-width="3" />
                                <rect x="44.6035" y="41.1191" width="9.88609" height="15.5685" transform="rotate(-150.49 44.6035 41.1191)" fill="#D77FA6" />
                                <rect x="34.8496" y="40.0918" width="10" height="15.5685" transform="rotate(-120 34.8496 40.0918)" fill="#D77FA6" />
                            </svg>
                        </div>
                        <div class="faq-answer">
                            <p class="faq-ans">
                                Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                                Eos molestiae optio error nemo provident tempora sequi
                                excepturi, et expedita necessitatibus omnis reiciendis
                                aspernatur, at cupiditate? Quia quod dicta eos libero.
                            </p>
                            <div class="faq-ans-footer"></div>
                        </div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-question">
                            <p>How do I place an order ?</p>
                            <svg width="80" height="81" viewBox="0 0 80 81" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect y="80.0039" width="80" height="80" rx="40" transform="rotate(-90 0 80.0039)" fill="#D77FA6" />
                                <path d="M50.3923 34.0039L40 52.0039L29.6077 34.0039L50.3923 34.0039Z" fill="#D77FA6" stroke="white" stroke-width="3" />
                                <rect x="44.6035" y="41.1191" width="9.88609" height="15.5685" transform="rotate(-150.49 44.6035 41.1191)" fill="#D77FA6" />
                                <rect x="34.8496" y="40.0918" width="10" height="15.5685" transform="rotate(-120 34.8496 40.0918)" fill="#D77FA6" />
                            </svg>
                        </div>
                        <div class="faq-answer">
                            <p class="faq-ans">
                                Lorem ipsum, dolor sit amet consectetur adipisicing elit.
                                Eos molestiae optio error nemo provident tempora sequi
                                excepturi, et expedita necessitatibus omnis reiciendis
                                aspernatur, at cupiditate? Quia quod dicta eos libero.
                            </p>
                            <div class="faq-ans-footer"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CONTACT US SECTION -->
<div class="container m-t-80 m-b-80">
    <div class="title-wrapper">
        <p class="title-headings">Contact Us</p>
    </div>
    <p class="contact-subtitle">
        We’re here to help! Contact us with any question and we will do our best
        to reply as soon as we can.
    </p>
    <!-- <div class="contact-us-section"></div> -->
    <div class="row contact-us-form-section rounded-4 shadow-lg">
        <div class="col-12 col-lg-8 col-md-6 col-sm-12">
            <div class="form-wrapper">
                <div class="form-headings">
                    <p class="form-title">
                        <span>Write to us</span><svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
                            <title />
                            <g id="Mail">
                                <path d="M62,12a.9275.9275,0,0,0-.0251-.1243.7565.7565,0,0,0-.1329-.3827.95.95,0,0,0-.0583-.1146c-.0124-.0156-.0308-.0223-.0439-.0369a1.1348,1.1348,0,0,0-.6846-.33C61.0359,11.01,61.02,11,61,11H3c-.02,0-.0372.01-.0571.0115a.9871.9871,0,0,0-.1961.04.9863.9863,0,0,0-.1794.0567.9837.9837,0,0,0-.1481.1.9746.9746,0,0,0-.1592.1339c-.0132.0146-.0314.0213-.0438.0368a.95.95,0,0,0-.0583.1146.7565.7565,0,0,0-.1329.3827A.9275.9275,0,0,0,2,12V52c0,.0229.0115.0422.0131.0648a.8641.8641,0,0,0,.2027.5279.9678.9678,0,0,0,.135.1534c.0172.0151.0257.0362.0442.05a.9616.9616,0,0,0,.139.0732.9493.9493,0,0,0,.1116.0588A.9936.9936,0,0,0,2.999,53H61.001a.9936.9936,0,0,0,.3534-.0716.9493.9493,0,0,0,.1116-.0588.9616.9616,0,0,0,.139-.0732c.0185-.0141.027-.0352.0442-.05a1.0935,1.0935,0,0,0,.3377-.6813C61.9885,52.0422,62,52.0229,62,52ZM4,14.07,20.5786,27.2183,4,49.0314Zm37.441,12.166c-.005.0037-.0112.0041-.0162.0079s-.0087.0119-.0146.0166L32,33.7236,22.59,26.26c-.0059-.0047-.0084-.0119-.0146-.0166s-.0112-.0042-.0162-.0079L5.8705,13H58.13ZM22.1461,28.4615l9.2323,7.3222a1.0013,1.0013,0,0,0,1.2432,0l9.2323-7.3222L58.9838,51H5.0162Zm21.2753-1.2432L60,14.07V49.0314Z" />
                            </g>
                        </svg>
                    </p>
                </div>
                <form id="contact_us" name="contact_us"class="contact-form">
                    <div class="row">
                        <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs">
                            <input type="text" name="fname" placeholder="First Name" />
                        </div>
                        <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs">
                            <input type="text" name="lname" placeholder="Last Name" />
                        </div>
                        <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs">
                            <input type="tel" name="phone" placeholder="Phone" />
                        </div>
                        <div class="col-12 col-lg-6 col-md-6 col-sm-12 form-inputs">
                            <input type="email" name="email" placeholder="Email" />
                        </div>
                        <div class="col-12 col-lg-12 col-md-12 col-sm-12 form-inputs">
                            <input type="text" name="address" placeholder="Address" />
                        </div>
                        <div class="col-12 col-lg-12 col-md-12 col-sm-12 form-inputs">
                            <textarea name="enquiry" placeholder="Enquiry"></textarea>
                        </div>
                        <div class="col-12 col-lg-12 col-md-12 col-sm-12 form-inputs btn-input">
                            <input type="submit" name="submit" value="Submit" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-12 col-lg-4 col-md-6 col-sm-12 contact-info">
            <img class="cont-logo" src="<?= base_url('assets/') ?>images/Lotus_Logo.png" />
            <p class="cont-info-title">Contact Information</p>
            <p class="cont-info-add">Borivali West, Mumbai.</p>
            <p class="cont-info-time">Call us 24/7: 10am to 8pm IST.</p>
            <p class="cont-info-num">
                <svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M24.95 28.6349C22.6123 26.7127 21.0514 24.3408 20.2308 22.9911L19.6186 21.8371C19.8327 21.6075 21.4648 19.8598 22.1721 18.9115C23.061 17.7207 21.7723 16.6453 21.7723 16.6453C21.7723 16.6453 18.1461 13.0186 17.3197 12.2993C16.4933 11.5789 15.542 11.979 15.542 11.979C13.8051 13.1012 12.0045 14.077 11.8965 18.7695C11.8925 23.1629 15.2275 27.6942 18.834 31.2023C22.4463 35.1641 27.406 39.1349 32.201 39.1304C36.893 39.0234 37.8685 37.223 38.9908 35.4861C38.9908 35.4861 39.3911 34.5356 38.6715 33.7084C37.9513 32.8815 34.3242 29.2546 34.3242 29.2546C34.3242 29.2546 33.2495 27.9657 32.0585 28.8553C31.1709 29.5188 29.577 30.9945 29.193 31.3523C29.1938 31.3536 26.5275 29.9322 24.95 28.6349Z" fill="black" />
                    <rect x="1" y="1" width="48" height="48" rx="24" stroke="black" stroke-width="2" />
                </svg>
                <span>+91-92233-07766</span>
            </p>
            <p class="cont-info-mail">
                <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg">
                    <title />
                    <g id="Mail">
                        <path d="M62,12a.9275.9275,0,0,0-.0251-.1243.7565.7565,0,0,0-.1329-.3827.95.95,0,0,0-.0583-.1146c-.0124-.0156-.0308-.0223-.0439-.0369a1.1348,1.1348,0,0,0-.6846-.33C61.0359,11.01,61.02,11,61,11H3c-.02,0-.0372.01-.0571.0115a.9871.9871,0,0,0-.1961.04.9863.9863,0,0,0-.1794.0567.9837.9837,0,0,0-.1481.1.9746.9746,0,0,0-.1592.1339c-.0132.0146-.0314.0213-.0438.0368a.95.95,0,0,0-.0583.1146.7565.7565,0,0,0-.1329.3827A.9275.9275,0,0,0,2,12V52c0,.0229.0115.0422.0131.0648a.8641.8641,0,0,0,.2027.5279.9678.9678,0,0,0,.135.1534c.0172.0151.0257.0362.0442.05a.9616.9616,0,0,0,.139.0732.9493.9493,0,0,0,.1116.0588A.9936.9936,0,0,0,2.999,53H61.001a.9936.9936,0,0,0,.3534-.0716.9493.9493,0,0,0,.1116-.0588.9616.9616,0,0,0,.139-.0732c.0185-.0141.027-.0352.0442-.05a1.0935,1.0935,0,0,0,.3377-.6813C61.9885,52.0422,62,52.0229,62,52ZM4,14.07,20.5786,27.2183,4,49.0314Zm37.441,12.166c-.005.0037-.0112.0041-.0162.0079s-.0087.0119-.0146.0166L32,33.7236,22.59,26.26c-.0059-.0047-.0084-.0119-.0146-.0166s-.0112-.0042-.0162-.0079L5.8705,13H58.13ZM22.1461,28.4615l9.2323,7.3222a1.0013,1.0013,0,0,0,1.2432,0l9.2323-7.3222L58.9838,51H5.0162Zm21.2753-1.2432L60,14.07V49.0314Z" />
                    </g>
                </svg><span>lotuspens@gmail.com</span>
            </p>
            <div class="social-media-icons">
                <a href="#"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 24 24" style="enable-background: new 0 0 24 24" xml:space="preserve" width="512" height="512">
                        <g>
                            <path d="M24,12.073c0,5.989-4.394,10.954-10.13,11.855v-8.363h2.789l0.531-3.46H13.87V9.86c0-0.947,0.464-1.869,1.95-1.869h1.509   V5.045c0,0-1.37-0.234-2.679-0.234c-2.734,0-4.52,1.657-4.52,4.656v2.637H7.091v3.46h3.039v8.363C4.395,23.025,0,18.061,0,12.073   c0-6.627,5.373-12,12-12S24,5.445,24,12.073z" />
                        </g>
                    </svg></a>
                <a href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 24 24" style="enable-background: new 0 0 24 24" xml:space="preserve" width="512" height="512">
                        <g>
                            <path d="M12,2.162c3.204,0,3.584,0.012,4.849,0.07c1.308,0.06,2.655,0.358,3.608,1.311c0.962,0.962,1.251,2.296,1.311,3.608   c0.058,1.265,0.07,1.645,0.07,4.849c0,3.204-0.012,3.584-0.07,4.849c-0.059,1.301-0.364,2.661-1.311,3.608   c-0.962,0.962-2.295,1.251-3.608,1.311c-1.265,0.058-1.645,0.07-4.849,0.07s-3.584-0.012-4.849-0.07   c-1.291-0.059-2.669-0.371-3.608-1.311c-0.957-0.957-1.251-2.304-1.311-3.608c-0.058-1.265-0.07-1.645-0.07-4.849   c0-3.204,0.012-3.584,0.07-4.849c0.059-1.296,0.367-2.664,1.311-3.608c0.96-0.96,2.299-1.251,3.608-1.311   C8.416,2.174,8.796,2.162,12,2.162 M12,0C8.741,0,8.332,0.014,7.052,0.072C5.197,0.157,3.355,0.673,2.014,2.014   C0.668,3.36,0.157,5.198,0.072,7.052C0.014,8.332,0,8.741,0,12c0,3.259,0.014,3.668,0.072,4.948c0.085,1.853,0.603,3.7,1.942,5.038   c1.345,1.345,3.186,1.857,5.038,1.942C8.332,23.986,8.741,24,12,24c3.259,0,3.668-0.014,4.948-0.072   c1.854-0.085,3.698-0.602,5.038-1.942c1.347-1.347,1.857-3.184,1.942-5.038C23.986,15.668,24,15.259,24,12   c0-3.259-0.014-3.668-0.072-4.948c-0.085-1.855-0.602-3.698-1.942-5.038c-1.343-1.343-3.189-1.858-5.038-1.942   C15.668,0.014,15.259,0,12,0z" />
                            <path d="M12,5.838c-3.403,0-6.162,2.759-6.162,6.162c0,3.403,2.759,6.162,6.162,6.162s6.162-2.759,6.162-6.162   C18.162,8.597,15.403,5.838,12,5.838z M12,16c-2.209,0-4-1.791-4-4s1.791-4,4-4s4,1.791,4,4S14.209,16,12,16z" />
                            <circle cx="18.406" cy="5.594" r="1.44" />
                        </g>
                    </svg></a>
            </div>
        </div>
    </div>
</div>

<div class="about-main-section">
    <div class="container">
        <div class="about-main-wrapper">
            <p class="page-title">About</p>
            <p class="page-subtitle">Fountain Pens</p>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-12 col-lg-8 col-md-8 col-sm-12 about-text-wrapper">
            <p class="about-text">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi
                aliquam laudantium a amet hic, minus vel quam tempora repellendus
                harum quae impedit quo obcaecati, doloribus assumenda, minima
                blanditiis cupiditate ex? Lorem ipsum, dolor sit amet consectetur
                adipisicing elit. Blanditiis velit cum dolore modi sit explicabo
                eum, magnam quas voluptatem necessitatibus sed numquam earum
                excepturi mollitia, inventore molestiae illum itaque. Ratione.
            </p>
            <p class="about-text">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi
                aliquam laudantium a amet hic, minus vel quam tempora repellendus
                harum quae impedit quo obcaecati, doloribus assumenda, minima
                blanditiis cupiditate ex? Lorem ipsum, dolor sit amet consectetur
                adipisicing elit. Blanditiis velit cum dolore modi sit explicabo
                eum, magnam quas voluptatem necessitatibus sed numquam earum
                excepturi mollitia, inventore molestiae illum itaque. Ratione.
            </p>
            <p class="about-text">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi
                aliquam laudantium a amet hic, minus vel quam tempora repellendus
                harum quae impedit quo obcaecati, doloribus assumenda, minima
                blanditiis cupiditate ex? Lorem ipsum, dolor sit amet consectetur
                adipisicing elit. Blanditiis velit cum dolore modi sit explicabo
                eum, magnam quas voluptatem necessitatibus sed numquam earum
                excepturi mollitia, inventore molestiae illum itaque. Ratione.
            </p>
            <p class="about-text about-colored-text">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Vitae id
                ut, eaque ipsa iste eligendi odio? Cumque perferendis velit, iusto,
                impedit soluta atque placeat, eligendi ipsa mollitia sed delectus
                molestiae.
            </p>
            <p class="about-text">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi
                aliquam laudantium a amet hic, minus vel quam tempora repellendus
                harum quae impedit quo obcaecati, doloribus assumenda, minima
                blanditiis cupiditate ex? Lorem ipsum, dolor sit amet consectetur
                adipisicing elit. Blanditiis velit cum dolore modi sit explicabo
                eum, magnam quas voluptatem necessitatibus sed numquam earum
                excepturi mollitia, inventore molestiae illum itaque. Ratione.
            </p>
            <p class="about-text">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi
                aliquam laudantium a amet hic, minus vel quam tempora repellendus
                harum quae impedit quo obcaecati, doloribus assumenda, minima
                blanditiis cupiditate ex? Lorem ipsum, dolor sit amet consectetur
                adipisicing elit. Blanditiis velit cum dolore modi sit explicabo
                eum, magnam quas voluptatem necessitatibus sed numquam earum
                excepturi mollitia, inventore molestiae illum itaque. Ratione.
            </p>
            <p class="about-text">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi
                aliquam laudantium a amet hic, minus vel quam tempora repellendus
                harum quae impedit quo obcaecati, doloribus assumenda, minima
                blanditiis cupiditate ex? Lorem ipsum, dolor sit amet consectetur
                adipisicing elit. Blanditiis velit cum dolore modi sit explicabo
                eum, magnam quas voluptatem necessitatibus sed numquam earum
                excepturi mollitia, inventore molestiae illum itaque. Ratione.
            </p>
        </div>
        <div class="col-12 col-lg-4 col-md-4 col-sm-12">
            <img class="about-side-img" src="<?= base_url('assets/') ?>images/product-img.png" />
        </div>
    </div>
</div>
<div class="container m-t-80">
    <div class="title-wrapper">
        <p class="title-headings">Anatomy of Fountain Pen</p>
    </div>
    <p class="about-text">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Eligendi
        aliquam laudantium a amet hic, minus vel quam tempora repellendus harum
        quae impedit quo obcaecati, doloribus assumenda, minima blanditiis
        cupiditate ex? Lorem ipsum, dolor sit amet consectetur adipisicing elit.
        Blanditiis velit cum dolore modi sit explicabo eum, magnam quas
        voluptatem necessitatibus sed numquam earum excepturi mollitia,
        inventore molestiae illum itaque. Ratione.
    </p>
    <img class="anatomy-img" src="<?= base_url('assets/') ?>images/bg-img.png" />
</div>