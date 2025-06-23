<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach ($categories as $category)
        <sitemap>
            <loc>{{ url('/sitemap/sitemap-news-' . $category->language . '-' . $category->slug) }}</loc>
        </sitemap>
    @endforeach
</sitemapindex>
