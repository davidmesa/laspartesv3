<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9 ">

<?php 
    foreach( $urls as $url )
    {
?>
    <url>
        <loc><?php echo $url->loc; ?></loc>
        <?php if( isset ( $url->lastmod ) ) { ?>
            <lastmod><?php echo $url->lastmod; ?></lastmod>
        <?php } ?>
        <changefreq><?php echo $url->changefreq; ?></changefreq>
        <priority><?php echo $url->priority; ?></priority>
    </url>
<?php
    }
?>
</urlset>