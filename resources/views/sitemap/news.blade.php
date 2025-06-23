<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">
    @foreach ($news as $newsItem)
        <url>
            <loc><![CDATA[ {{ url('/news-details/'.$newsItem->slug) }} ]]></loc>
            <news:news>
                <news:publication>
                    <news:name><![CDATA[ kaptenforex ]]></news:name>
                    <news:language><![CDATA[ id ]]></news:language>
                </news:publication>
                <news:publication_date><![CDATA[ {{ $newsItem->updated_at->tz('UTC')->toAtomString() }} ]]></news:publication_date>
                <news:title><![CDATA[ {{ $newsItem->title }} ]]></news:title>
                <news:keywords><![CDATA[ {{ $newsItem->meta_keyword }} ]]></news:keywords>
            </news:news>
        </url>
    @endforeach
</urlset>
