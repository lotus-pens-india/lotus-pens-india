<link rel="canonical" href="<?= current_url() ?>">

<?php
$categoryNames = array(
    1 => 'Custom Fountain Pen',
    2 => 'Fountain Pens',
    3 => 'Custom Hand Painted Fountain Pens',
    4 => 'Accessories'
);

$materialLabels = array(
    'ebonite' => 'Ebonite',
    'acrylic' => 'Acrylic',
    'wood' => 'Wood',
    'carbon' => 'Carbon Fibre',
    'metal' => 'Metal',
    'resin' => 'Resin',
    'other' => 'Other'
);
?>

<section class="lp-listing-hero">
    <div class="container">
        <span class="lp-kicker">Lotus Shop</span>
        <h1>Premium Writing Instruments</h1>
        <p>Explore handcrafted fountain pens, custom painted editions, accessories, and material-rich collector pieces in a refined, responsive shopping grid.</p>
    </div>
</section>

<main class="container">
    <div class="lp-shop-shell">
        <aside class="lp-filter-panel" id="lp_filter_panel" aria-label="Product filters">
            <div class="lp-filter-panel-head">
                <h2>Refine</h2>
                <button type="button" class="lp-filter-close" data-filter-close aria-label="Close filters"><i class="fa fa-times"></i></button>
            </div>
            <div class="lp-filter-group" style="border-top:0;margin-top:0;padding-top:0">
                <label for="lp_product_search">Search</label>
                <input type="search" id="lp_product_search" placeholder="Search collection">
            </div>
            <div class="lp-filter-group">
                <label for="lp_category_filter">Category</label>
                <select id="lp_category_filter">
                    <option value="">All categories</option>
                    <option value="1">Custom Fountain Pen</option>
                    <option value="2">Fountain Pens</option>
                    <option value="3">Custom Hand Painted</option>
                    <option value="4">Accessories</option>
                </select>
            </div>
            <div class="lp-filter-group">
                <label for="lp_material_filter">Material</label>
                <select id="lp_material_filter">
                    <option value="">All materials</option>
                    <?php foreach ($materialLabels as $key => $label) { ?>
                        <option value="<?= $key ?>"><?= $label ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="lp-filter-group">
                <label>Price</label>
                <div class="lp-filter-row">
                    <input type="number" id="lp_price_min" placeholder="Min">
                    <input type="number" id="lp_price_max" placeholder="Max">
                </div>
            </div>
            <div class="lp-filter-group">
                <label for="lp_availability_filter">Availability</label>
                <select id="lp_availability_filter">
                    <option value="">All</option>
                    <option value="in_stock">In stock</option>
                    <option value="made_to_order">Made to order</option>
                </select>
            </div>
        </aside>

        <section class="lp-shop-content">
            <div class="lp-shop-toolbar">
                <div>
                    <span class="lp-kicker" id="lp_result_count"><?= isset($products) && is_array($products) ? count($products) : 0 ?> items</span>
                    <p class="m-0">Choose the view that fits your browsing rhythm.</p>
                </div>
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <button type="button" class="lp-mobile-filter-toggle" data-filter-toggle aria-controls="lp_filter_panel" aria-expanded="false">
                        <i class="fa fa-sliders"></i> Filters
                    </button>
                    <select id="lp_sort" aria-label="Sort products">
                        <option value="popular">Popularity</option>
                        <option value="latest">Latest</option>
                        <option value="price_asc">Price low-high</option>
                        <option value="price_desc">Price high-low</option>
                    </select>
                    <div class="lp-layout-switcher" aria-label="Layout controls">
                        <button type="button" data-grid-layout="2" title="2-column grid" aria-label="2-column grid"><i class="fa fa-th-large"></i></button>
                        <button type="button" data-grid-layout="3" title="3-column grid" aria-label="3-column grid"><i class="fa fa-th"></i></button>
                        <button type="button" data-grid-layout="4" class="active" title="4-column grid" aria-label="4-column grid"><i class="fa fa-th"></i></button>
                        <button type="button" data-grid-layout="list" title="List view" aria-label="List view"><i class="fa fa-list"></i></button>
                    </div>
                </div>
            </div>

            <div class="lp-mobile-filter-backdrop" data-filter-backdrop hidden></div>

            <div class="lp-product-grid" data-layout="4" data-product-grid>
                <?php if (isset($products) && is_array($products) && count($products) > 0) {
                    foreach ($products as $product) {
                        $catName = isset($categoryNames[$product['category_id']]) ? $categoryNames[$product['category_id']] : 'Lotus Pens';
                        $price = isset($product['unit_price']) ? (float) $product['unit_price'] : 0;
                        $qty = isset($product['qty']) ? (int) $product['qty'] : 0;
                        $availability = $qty > 0 ? 'in_stock' : 'made_to_order';
                        $position = isset($product['position']) ? (int) $product['position'] : 0;
                        $materialText = 'other';
                        if (isset($product['technical_specification']) && $product['technical_specification'] != '') {
                            $spec = json_decode($product['technical_specification']);
                            if ($spec && isset($spec->pen_material)) {
                                $rawMaterial = strtolower(strip_tags($spec->pen_material));
                                foreach ($materialLabels as $materialKey => $materialLabel) {
                                    if ($materialKey != 'other' && strpos($rawMaterial, $materialKey) !== false) {
                                        $materialText = $materialKey;
                                        break;
                                    }
                                }
                            }
                        }
                        ?>
                        <article class="lp-product-card" data-id="<?= $product['product_id'] ?>" data-position="<?= $position ?>" data-price="<?= $price ?>" data-name="<?= strtolower($product['product_name']) ?>" data-category="<?= $product['category_id'] ?>" data-material="<?= $materialText ?>" data-availability="<?= $availability ?>">
                            <a class="lp-product-media" href="<?= base_url() ?>product/<?= $product['product_id'] ?>">
                                <span class="lp-product-badge"><?= $availability == 'in_stock' ? 'In Stock' : 'Made to Order' ?></span>
                                <img src="<?= base_url('lotus_pens_admin/assets/') ?>images/product/<?= $product['main_image'] ?>" title="<?= $product['product_name'] ?>" alt="<?= $product['product_name'] ?>">
                            </a>
                            <div class="lp-product-actions">
                                <button type="button" onclick="openQuickView('<?= base_url('lotus_pens_admin/assets/') ?>images/product/<?= $product['main_image'] ?>')" title="Quick view" aria-label="Quick view"><i class="fa fa-eye"></i></button>
                                <a href="<?= base_url() ?>product/<?= $product['product_id'] ?>" title="Explore" aria-label="Explore"><i class="fa fa-arrow-right"></i></a>
                            </div>
                            <div class="lp-product-body">
                                <p class="lp-product-category"><?= $catName ?></p>
                                <a href="<?= base_url() ?>product/<?= $product['product_id'] ?>" class="lp-product-title"><?= $product['product_name'] ?></a>
                                <div class="lp-product-footer">
                                    <span class="lp-price"><?= $this->session->userdata('currency_symbol') . $product['unit_price'] ?></span>
                                    <a class="lp-mini-link" href="<?= base_url() ?>product/<?= $product['product_id'] ?>">Details</a>
                                </div>
                            </div>
                        </article>
                    <?php }
                } ?>
            </div>

            <div class="lp-empty-state" id="lp_empty_state" hidden>
                <h2 class="lp-section-title">No matching pieces</h2>
                <p>Adjust the filters to reveal more of the Lotus collection.</p>
            </div>
        </section>
    </div>
</main>
<script src="<?= base_url('assets/') ?>js/cart.js"></script>
