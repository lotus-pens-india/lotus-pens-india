<link rel="canonical" href="<?= base_url() ?>featured">

<section class="lp-listing-hero">
    <div class="container">
        <span class="lp-kicker">Featured</span>
        <h1>Collector Highlights</h1>
        <p>A polished showcase of selected Lotus pieces, designed for quick discovery and a richer visual browse.</p>
    </div>
</section>

<main class="container">
    <section class="lp-section">
        <?php if (is_array($featured) && count($featured) > 0) { ?>
            <div class="lp-featured-slider">
                <?php foreach ($featured as $fData) { ?>
                    <div class="lp-featured-slide">
                        <a class="lp-featured-card" href="<?= base_url() ?>product/<?= $fData['product_id'] ?>">
                            <img src="<?= base_url('lotus_pens_admin/assets/') ?>images/featured/<?= $fData['image'] ?>" title="Featured Lotus Pen" alt="Featured Lotus Pen">
                            <span>Explore Piece <i class="fa fa-arrow-right"></i></span>
                        </a>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <div class="lp-empty-state">
                <h2 class="lp-section-title">No featured pieces</h2>
                <p>Please check back soon for new collector highlights.</p>
            </div>
        <?php } ?>
    </section>
</main>
