<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($tags as $tag)
        <url>
            <loc>{{ url('/news?tag=' . str_replace(' ', '%20', $tag->name)) }}</loc>
            <lastmod>{{ $tag->created_at->toAtomString() }}</lastmod>
            <changefreq>weekly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
</urlset>
