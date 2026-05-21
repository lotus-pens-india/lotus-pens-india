<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    
    <?php 
    
    foreach ($pages as $page): ?>
        <url>
            <loc><?php echo base_url($page['slug']); ?></loc> 
            <lastmod><?php echo date('Y-m-d', strtotime($page['updated_at'])); ?></lastmod>
            <changefreq>daily</changefreq>
            <priority>0.5</priority>
        </url>
    <?php endforeach; ?>
</urlset>
