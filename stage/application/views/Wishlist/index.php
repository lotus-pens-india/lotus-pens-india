<section class="lp-listing-hero">
    <div class="container">
        <span class="lp-kicker">Wishlist</span>
        <h1>Saved Lotus Pieces</h1>
        <p>Return to the handcrafted pens you marked for another look.</p>
    </div>
</section>

<main class="container">
    <section class="lp-section">
        <div class="lp-product-grid" data-layout="4" id="wishlist_products_div"></div>
        <div class="lp-empty-state" id="wishlist_empty_state" hidden>
            <h2 class="lp-section-title">No saved pieces yet</h2>
            <p>Use the heart action on a product page to save it here.</p>
            <a href="<?= base_url() ?>products" class="btn btn-primary mt-3">Explore Products</a>
        </div>
    </section>
</main>

<script src="<?= base_url() ?>assets/js/wishlist.js"></script>
