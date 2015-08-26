<?php

use Picturae\Mediabank\Client;
use Picturae\Mediabank\URL;
use Sitemap\Collection;
use Sitemap\Formatter\XML\SitemapIndex;
use Sitemap\Formatter\XML\URLSet;
use Sitemap\Sitemap\SitemapEntry;

require_once 'vendor/autoload.php';

$url = new URL;
$link = $url->getCurrentURL();

// Change to your API key
$apiKey = '84fb6dde-1718-11e4-abe0-fff30396f5b7';

// Your base url for the mediabank application /detail/{id} is the route for the permalink
// your application would be installed under http://demo.webservices.picturae.pro/mediabank/
$baseURL = 'http://demo.webservices.picturae.pro/mediabank/detail/';

$client = new Client($apiKey);

// This part should be cached to avoid the extra request
$rows = 100;
$result = $client->search(['rows' => $rows]);
$pages = $result->metadata->pagination->pages;

$currentPage = null;
if (isset($_GET['page'])) {
    $currentPage = (int)$_GET['page'];
}

$collection = new Collection;

if ($currentPage) {

    // Render the sitemap for the current page
    $result = $client->search([
        'rows' => $rows,
        'page' => $currentPage
    ]);

    foreach ($result->media as $media) {
        $basic = new SitemapEntry($baseURL . $media->id);
        $collection->addSitemap($basic);
    }

} else {

    // Render the sitemap with all other sitemap
    for ($index = 0; $index < $pages; $index++) {
        $basic = new SitemapEntry($url->getCurrentURL() . '?page=' . ($index + 1));
        $collection->addSitemap($basic);
    }

}

$collection->setFormatter(new URLSet);
$collection->setFormatter(new SitemapIndex);

header("Content-type: text/xml; charset=utf-8");
echo $collection->output();