<div id="banner-slider">
    <?php
    if (isset($banners)) {
        foreach ($banners as $banner) { ?>
            <div class="banner-slide" style="background-image: url('<?= base_url('lotus_pens_admin/assets/images/banner/') . '/' . $banner['banner'] ?>');">
                <div class="container">
                    <div class="row">
                        <?php
                        if ($banner['text_position'] == 0) { ?>
                            <div class="b-slide-item col-lg-4 col-md-6 col-sm-12 text-left">
                                <h3 class="b-slide-heading"><?= $banner['tag'] ?></h3>
                                <p class="b-slide-para"><?= $banner['banner_name'] ?></p>
                                <button onclick="location.href='<?= base_url() . "products/" ?><?= $banner['category_id'] ?>'" class="b-slide-btn" style="text-decoration:none">Buy Now</button>
                            </div>
                            <div class="col-12 col-lg-8 col-md-6 col-sm-12"></div>
                        <?php } else { ?>
                            <div class="col-12 col-lg-8 col-md-6 col-sm-12"></div>
                            <div class="b-slide-item col-lg-4 col-md-6 col-sm-12 text-left">
                                <h3 class="b-slide-heading"><?= $banner['tag'] ?></h3>
                                <p class="b-slide-para"><?= $banner['banner_name'] ?></p>
                                <button onclick="location.href='<?= base_url() . "products/" ?><?= $banner['category_id'] ?>'" class="b-slide-btn" style="text-decoration:none">Buy Now</button>
                            </div>
                        <?php }
                        ?>

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

<?php
if (isset($featured) && is_array($featured)) { ?>
    <div class="container">
        <div class="title-wrapper view-all-btn-wrapper">
            <p class="title-headings">Featured</p>
            <a href="<?= base_url() ?>featured" class="view-all-btn">View All ></a>
        </div>
        <div class="featured-slider">
            <?php
            if (is_array($featured) && count($featured) > 0) {
                foreach ($featured as $fData) { ?>
                    <a href="<?= base_url() ?>product/<?= $fData['product_id'] ?>">
                        <div class="img-wrapper">
                            <img src="<?= base_url('lotus_pens_admin/assets/') ?>images/featured/<?= $fData['image'] ?>" />
                        </div>
                    </a>
            <?php }
            }
            ?>
        </div>
    </div>

<?php }
?>




<!-- Custom Hand Painted Fountain Pens SECTION -->
<div class="container m-t-80">
    <div class="title-wrapper view-all-btn-wrapper">
        <p class="title-headings">Custom Hand Painted Fountain Pens</p>

        <a href="<?= base_url() ?>custom_hand_painted" class="view-all-btn">View All ></a>
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