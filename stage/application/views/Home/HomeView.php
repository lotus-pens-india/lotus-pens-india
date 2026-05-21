<link rel="canonical" href="<?= base_url() ?>">
<script>
    document.body.classList.add("lp-homepage-luxe");
</script>

<?php
$categoryNames = array(
    1 => 'Custom Fountain Pen',
    2 => 'Fountain Pens',
    3 => 'Hand Painted',
    4 => 'Accessories'
);

$homepageProducts = (isset($products) && is_array($products)) ? array_slice($products, 0, 7) : array();
$heroProduct = count($homepageProducts) > 0 ? $homepageProducts[0] : null;
$editorialProducts = count($homepageProducts) > 1 ? array_slice($homepageProducts, 1, 4) : array();
$cabinetProducts = count($homepageProducts) > 5 ? array_slice($homepageProducts, 5, 2) : array_slice($homepageProducts, 0, 2);
?>

<main class="lp-home lp-home-luxe">
    <section class="lp-hero-slider lp-luxe-hero" aria-label="Lotus Pens luxury collections">
        <?php if (isset($banners) && is_array($banners) && count($banners) > 0) {
            foreach ($banners as $banner) {
                $bannerLink = isset($banner['category_id']) ? base_url() . 'product/' . $banner['category_id'] : base_url() . 'products';
                ?>
                <article class="lp-hero-slide lp-luxe-slide">
                    <img src="<?= base_url('lotus_pens_admin/assets/images/banner/') . '/' . $banner['banner'] ?>" title="Lotus Pens - Crafting Exquisite Handmade Pens" alt="Lotus Pens handcrafted fountain pens">
                    <div class="lp-luxe-hero-content">
                        <div class="lp-luxe-hero-copy">
                            <span class="lp-luxe-kicker">Lotus Pens atelier</span>
                            <h1>Handcrafted writing instruments for modern collectors.</h1>
                            <p><?= $banner['tag'] ?></p>
                            <div class="lp-luxe-hero-actions">
                                <a href="<?= $bannerLink ?>" class="lp-luxe-btn lp-luxe-btn-gold">Discover the Collection</a>
                                <a href="<?= base_url() ?>custom_hand_painted" class="lp-luxe-btn lp-luxe-btn-glass">Commission Custom Art</a>
                            </div>
                        </div>
                        <aside class="lp-luxe-hero-card" aria-label="Lotus Pens craft details">
                            <span>Est. 2017</span>
                            <strong>Made by hand, tuned for the collector's desk.</strong>
                            <div class="lp-luxe-hero-metrics">
                                <div>
                                    <b>3-4</b>
                                    <small>Weeks craft time</small>
                                </div>
                                <div>
                                    <b>Global</b>
                                    <small>Collector shipping</small>
                                </div>
                            </div>
                        </aside>
                    </div>
                    <div class="lp-luxe-vertical-label">Limited runs / Bespoke finishes / Fine materials</div>
                </article>
            <?php }
        } else { ?>
            <article class="lp-hero-slide lp-luxe-slide">
                <img src="<?= base_url('assets/') ?>images/bg-img.png" title="Lotus Pens" alt="Lotus Pens premium writing instruments">
                <div class="lp-luxe-hero-content">
                    <div class="lp-luxe-hero-copy">
                        <span class="lp-luxe-kicker">Premium writing instruments</span>
                        <h1>Handcrafted writing instruments for modern collectors.</h1>
                        <p>Custom fountain pens shaped with premium materials, artistic finishes, and a collector-first writing experience.</p>
                        <div class="lp-luxe-hero-actions">
                            <a href="<?= base_url() ?>products" class="lp-luxe-btn lp-luxe-btn-gold">Shop the Atelier</a>
                            <a href="<?= base_url() ?>custom_hand_painted" class="lp-luxe-btn lp-luxe-btn-glass">Custom Hand Painted</a>
                        </div>
                    </div>
                    <aside class="lp-luxe-hero-card" aria-label="Lotus Pens craft details">
                        <span>Est. 2017</span>
                        <strong>Small-batch instruments with a personal signature.</strong>
                        <div class="lp-luxe-hero-metrics">
                            <div>
                                <b>Art</b>
                                <small>Hand painted</small>
                            </div>
                            <div>
                                <b>Fine</b>
                                <small>Materials</small>
                            </div>
                        </div>
                    </aside>
                </div>
                <div class="lp-luxe-vertical-label">Limited runs / Bespoke finishes / Fine materials</div>
            </article>
        <?php } ?>
    </section>

    <section class="lp-luxe-intro lp-section">
        <div class="container">
            <div class="lp-luxe-intro-grid">
                <div class="lp-luxe-intro-copy">
                    <span class="lp-luxe-kicker">The house of Lotus</span>
                    <h2>Quiet luxury for people who still believe writing is ritual.</h2>
                </div>
                <div class="lp-luxe-intro-text">
                    <p>Lotus Pens is an Indian atelier founded by Arun Singhi in 2017. Each piece is shaped around proportion, balance, finish, and the emotional character of a handmade object.</p>
                    <div class="lp-luxe-signature-row">
                        <span><i class="fa fa-diamond"></i> Premium materials</span>
                        <span><i class="fa fa-paint-brush"></i> Bespoke artistry</span>
                        <span><i class="fa fa-globe"></i> Worldwide orders</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php if ($heroProduct) {
        $heroCatName = isset($categoryNames[$heroProduct['category_id']]) ? $categoryNames[$heroProduct['category_id']] : 'Lotus Pens';
        $heroQty = isset($heroProduct['qty']) ? (int) $heroProduct['qty'] : 0;
        ?>
        <section class="lp-luxe-product-showcase lp-section" aria-labelledby="signature-instruments-title">
            <div class="container">
                <div class="lp-luxe-section-head">
                    <span class="lp-luxe-kicker">Featured instruments</span>
                    <h2 id="signature-instruments-title">The collector's selection.</h2>
                    <p>Signature pieces presented with the presence of jewelry, the precision of a tool, and the warmth of handcraft.</p>
                </div>

                <div class="lp-luxe-showcase-grid">
                    <article class="lp-luxe-feature-product">
                        <a class="lp-luxe-feature-media" href="<?= base_url() ?>product/<?= $heroProduct['product_id'] ?>">
                            <span class="lp-luxe-product-badge"><?= $heroQty > 0 ? 'Available now' : 'Made to order' ?></span>
                            <img src="<?= base_url('lotus_pens_admin/assets/') ?>images/product/<?= $heroProduct['main_image'] ?>" title="<?= $heroProduct['product_name'] ?>" alt="<?= $heroProduct['product_name'] ?>">
                        </a>
                        <div class="lp-luxe-feature-copy">
                            <span><?= $heroCatName ?></span>
                            <h3><?= $heroProduct['product_name'] ?></h3>
                            <p>A refined expression of Lotus craftsmanship, selected as the lead piece for the current atelier edit.</p>
                            <div class="lp-luxe-feature-footer">
                                <strong><?= $this->session->userdata('currency_symbol') . $heroProduct['unit_price'] ?></strong>
                                <a href="<?= base_url() ?>product/<?= $heroProduct['product_id'] ?>" class="lp-luxe-text-link">View Details <i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </article>

                    <?php if (count($editorialProducts) > 0) { ?>
                        <div class="lp-luxe-product-rail">
                            <?php foreach ($editorialProducts as $product) {
                                $catName = isset($categoryNames[$product['category_id']]) ? $categoryNames[$product['category_id']] : 'Lotus Pens';
                                $qty = isset($product['qty']) ? (int) $product['qty'] : 0;
                                ?>
                                <article class="lp-luxe-product-card">
                                    <a class="lp-luxe-product-media" href="<?= base_url() ?>product/<?= $product['product_id'] ?>">
                                        <span class="lp-luxe-product-badge"><?= $qty > 0 ? 'In Stock' : 'Made to Order' ?></span>
                                        <img src="<?= base_url('lotus_pens_admin/assets/') ?>images/product/<?= $product['main_image'] ?>" title="<?= $product['product_name'] ?>" alt="<?= $product['product_name'] ?>">
                                    </a>
                                    <div class="lp-luxe-product-actions">
                                        <button type="button" onclick="openQuickView('<?= base_url('lotus_pens_admin/assets/') ?>images/product/<?= $product['main_image'] ?>')" title="Quick view" aria-label="Quick view"><i class="fa fa-eye"></i></button>
                                        <a href="<?= base_url() ?>product/<?= $product['product_id'] ?>" title="Explore" aria-label="Explore"><i class="fa fa-arrow-right"></i></a>
                                    </div>
                                    <div class="lp-luxe-product-body">
                                        <p><?= $catName ?></p>
                                        <a href="<?= base_url() ?>product/<?= $product['product_id'] ?>"><?= $product['product_name'] ?></a>
                                        <div>
                                            <strong><?= $this->session->userdata('currency_symbol') . $product['unit_price'] ?></strong>
                                            <span><?= $qty > 0 ? 'Ready to ship' : 'Atelier order' ?></span>
                                        </div>
                                    </div>
                                </article>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>
    <?php } ?>

    <section class="lp-luxe-category-showcase lp-section" aria-labelledby="craft-categories-title">
        <div class="container">
            <div class="lp-luxe-section-head lp-luxe-section-head-light">
                <span class="lp-luxe-kicker">Shop by craft</span>
                <h2 id="craft-categories-title">Three ways into the atelier.</h2>
                <p>Move through art, instrument, or material with cinematic collection spaces designed for discovery.</p>
            </div>
            <div class="lp-luxe-category-mosaic">
                <a class="lp-luxe-category-tile lp-luxe-category-tile-large" href="<?= base_url() ?>custom_hand_painted">
                    <img src="<?= base_url('lotus_pens_admin/assets/') ?>images/thumbnail/SHIVJI-1.JPG" title="Custom Hand Painted Fountain Pens" alt="Custom hand painted fountain pens">
                    <span class="lp-luxe-category-content">
                        <small>Custom art</small>
                        <strong>Custom Hand Painted Fountain Pens</strong>
                        <em>Personal mythology, portraits, symbols, and stories painted by hand.</em>
                        <b>Explore the art <i class="fa fa-angle-right"></i></b>
                    </span>
                </a>
                <a class="lp-luxe-category-tile" href="<?= base_url() ?>products">
                    <img src="<?= base_url('lotus_pens_admin/assets/') ?>images/product/SARAL_REDSTARDUST-1.jpg" title="Fountain Pens" alt="Lotus fountain pens">
                    <span class="lp-luxe-category-content">
                        <small>Writing instruments</small>
                        <strong>Fountain Pens</strong>
                        <em>Balanced profiles, expressive nibs, and collector-grade finishes.</em>
                        <b>View pieces <i class="fa fa-angle-right"></i></b>
                    </span>
                </a>
                <a class="lp-luxe-category-tile" href="<?= base_url() ?>products">
                    <img src="<?= base_url('lotus_pens_admin/assets/') ?>images/material/nikko_eboniye_rod.avif" title="Fountain pen material" alt="Premium fountain pen material">
                    <span class="lp-luxe-category-content">
                        <small>Material library</small>
                        <strong>Material</strong>
                        <em>Ebonite, acrylic, wood, carbon fibre, and rare premium blanks.</em>
                        <b>Browse materials <i class="fa fa-angle-right"></i></b>
                    </span>
                </a>
            </div>
        </div>
    </section>

    <section class="lp-luxe-story lp-section" aria-labelledby="craft-story-title">
        <div class="container">
            <div class="lp-luxe-story-grid">
                <div class="lp-luxe-story-media">
                    <img class="lp-luxe-story-primary" src="<?= base_url('assets/') ?>images/about_page_pen.png" title="Lotus Pens craftsmanship" alt="Lotus Pens handmade fountain pen">
                    <img class="lp-luxe-story-secondary" src="<?= base_url('assets/') ?>images/arun.jpeg" title="Lotus Pens founder Arun Singhi" alt="Arun Singhi founder of Lotus Pens">
                </div>
                <div class="lp-luxe-story-copy">
                    <span class="lp-luxe-kicker">Craftsmanship</span>
                    <h2 id="craft-story-title">From raw material to heirloom object.</h2>
                    <p>Each Lotus pen begins with a conversation between material, hand, and writing habit. The result is not a mass-produced accessory, but a personal instrument with weight, tactility, and a quiet sense of occasion.</p>
                    <div class="lp-luxe-story-points">
                        <div>
                            <strong>01</strong>
                            <span>Material selected for depth, feel, and long-term character.</span>
                        </div>
                        <div>
                            <strong>02</strong>
                            <span>Form shaped for comfort, balance, and distinctive presence.</span>
                        </div>
                        <div>
                            <strong>03</strong>
                            <span>Details refined for a writing experience that feels personal.</span>
                        </div>
                    </div>
                    <a href="<?= base_url() ?>about_a_us" class="lp-luxe-text-link">Enter the story <i class="fa fa-angle-right"></i></a>
                </div>
            </div>
        </div>
    </section>

    <?php if (isset($featured) && is_array($featured) && count($featured) > 0) { ?>
        <section class="lp-luxe-featured-carousel lp-section" aria-labelledby="collector-highlights-title">
            <div class="container">
                <div class="lp-luxe-section-head">
                    <span class="lp-luxe-kicker">Collector highlights</span>
                    <h2 id="collector-highlights-title">Objects of desire.</h2>
                    <p>Selected featured pieces from the Lotus cabinet, framed for slow looking and decisive collecting.</p>
                    <a href="<?= base_url() ?>featured" class="lp-luxe-text-link">View All <i class="fa fa-angle-right"></i></a>
                </div>
                <div class="lp-featured-slider lp-luxe-featured-slider">
                    <?php foreach ($featured as $fData) { ?>
                        <div class="lp-featured-slide">
                            <a class="lp-featured-card lp-luxe-featured-card" href="<?= base_url() ?>product/<?= $fData['product_id'] ?>">
                                <img src="<?= base_url('lotus_pens_admin/assets/') ?>images/featured/<?= $fData['image'] ?>" title="High Quality Indian Hand Made Pens" alt="Custom handmade Lotus pen">
                                <span>Featured Piece <i class="fa fa-arrow-right"></i></span>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </section>
    <?php } elseif (count($cabinetProducts) > 0) { ?>
        <section class="lp-luxe-featured-carousel lp-section" aria-labelledby="collector-highlights-title">
            <div class="container">
                <div class="lp-luxe-section-head">
                    <span class="lp-luxe-kicker">Collector highlights</span>
                    <h2 id="collector-highlights-title">Objects of desire.</h2>
                    <p>A quiet cabinet of handcrafted pieces currently leading the Lotus edit.</p>
                </div>
                <div class="lp-luxe-cabinet-grid">
                    <?php foreach ($cabinetProducts as $product) { ?>
                        <a class="lp-luxe-cabinet-card" href="<?= base_url() ?>product/<?= $product['product_id'] ?>">
                            <img src="<?= base_url('lotus_pens_admin/assets/') ?>images/product/<?= $product['main_image'] ?>" title="<?= $product['product_name'] ?>" alt="<?= $product['product_name'] ?>">
                            <span><?= $product['product_name'] ?></span>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </section>
    <?php } ?>

    <?php if (isset($testimonials) && $testimonials != false && count($testimonials) > 0) { ?>
        <section class="lp-luxe-testimonials lp-section" aria-labelledby="collector-notes-title">
            <div class="container">
                <div class="lp-luxe-section-head lp-luxe-section-head-light">
                    <span class="lp-luxe-kicker">Collector notes</span>
                    <h2 id="collector-notes-title">What owners remember.</h2>
                    <p>Short letters from people who chose Lotus for the feeling of a handmade writing instrument.</p>
                </div>
            </div>
            <div class="testimonials-slider lp-luxe-testimonials-slider">
                <?php foreach ($testimonials as $testimonialsDetails) { ?>
                    <article class="testimonials-slide lp-luxe-testimonial-card">
                        <div class="lp-luxe-quote-mark">"</div>
                        <div class="review-text-wrapper">
                            <p class="review"><?= $testimonialsDetails['review'] ?></p>
                        </div>
                        <div class="review-stars test-review-stars">
                            <?php for ($i = 0; $i < $testimonialsDetails['rating']; $i++) { ?>
                                <svg class="review-fill" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="512" height="512">
                                    <path d="M1.327,12.4,4.887,15,3.535,19.187A3.178,3.178,0,0,0,4.719,22.8a3.177,3.177,0,0,0,3.8-.019L12,20.219l3.482,2.559a3.227,3.227,0,0,0,4.983-3.591L19.113,15l3.56-2.6a3.227,3.227,0,0,0-1.9-5.832H16.4L15.073,2.432a3.227,3.227,0,0,0-6.146,0L7.6,6.568H3.231a3.227,3.227,0,0,0-1.9,5.832Z"></path>
                                </svg>
                            <?php } ?>
                        </div>
                        <p class="reviewer-name"><?= $testimonialsDetails['author'] ?></p>
                    </article>
                <?php } ?>
            </div>
        </section>
    <?php } ?>
</main>
