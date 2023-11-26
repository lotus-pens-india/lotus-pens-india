<div class="container">
    <div class="title-wrapper view-all-btn-wrapper">
        <p class="title-headings">Featured</p>
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