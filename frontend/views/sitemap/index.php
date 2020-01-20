<?php

/* @var $siteMaps */

echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php foreach ($siteMaps as $siteMap): ?>
        <sitemap>
            <loc><?= Yii::$app->request->hostInfo.'/'.$siteMap.'.xml' ?></loc>
        </sitemap>
    <?php endforeach; ?>
</sitemapindex>