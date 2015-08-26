<?php

use Picturae\Mediabank\Client;
use Picturae\Mediabank\URL;

// Make sure you run composer install first
require __DIR__ . '/../../vendor/autoload.php';

// Change to your API key
$apiKey = '84fb6dde-1718-11e4-abe0-fff30396f5b7';

$url = new URL;
$client = new Client($apiKey);
$media = null;
if ($url->isDetail()) {
    $id = $url->getUUID();
    $media = $client->getMedia($id);
    $asset = $url->getMediaUUID();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset=utf-8 />
        <title>Mediabank demo</title>

        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="//images.memorix.nl/topviewer/1.0/src/topviewer.compressed.js?v=1.0" type="text/javascript"></script>
        <script src="//webservices.picturae.com/mediabank/2.0/dist/js/mediabank-deps.min.js" type="text/javascript"></script>
        <script src="//webservices.picturae.com/mediabank/2.0/dist/js/mediabank-partials.min.js" type="text/javascript"></script>
        <script src="//webservices.picturae.com/mediabank/2.0/dist/js/mediabank.min.js" type="text/javascript"></script>
        <script>
            angular.element(document).ready(function () {
                angular.module('Mediabank.Boot')
                .run(
                    function (gettextCatalog, MediabankConfig) {
                        gettextCatalog.setCurrentLanguage('nl');

                        //========================
                        // Config examples
                        //========================

                        MediabankConfig.whenInitialized().then(
                            function () {

                                //========================
                                //If you want to test an example, just uncomment the respective code block
                                //and refresh
                                //========================
                                //Example 1:
                                //========================
                                //Focus on the comments tab by default in the detail view.
                                //
                                // MediabankConfig.setOption('detail.focus', 'comments');
                                //
                                //========================
                                //Example 2:
                                //========================
                                //Hide facets
                                //
                                //MediabankConfig.setOption('sections.facets', false);
                                //
                                //========================
                                //Example 3:
                                //========================
                                // Modify webshop behavior from link to popup.
                                //
                                //MediabankConfig.setOption('detail.webshop', 'popup');
                                //
                                //========================
                                //Example 4:
                                //========================
                                //Enable endless pagination, change top & bottom to count
                                //only.
                                //
                                //MediabankConfig.setOption('gallery.pagination.endless', true)
                                //  .setOption('gallery.pagination.topTemplate','pagination/views/directives/pagination-count.html' )
                                //  .setOption('gallery.pagination.bottomTemplate', 'pagination/views/directives/pagination-count.html');
                                //
                                //========================
                                //Example 5:
                                //========================
                                //Display only horizontal gallery.
                                //
                                // var galleryModes = MediabankConfig.getOption('gallery.modes');
                                // MediabankConfig.setOption(
                                //     'gallery.modes',
                                //     _.filter(
                                //         galleryModes,
                                //         {id: 'horizontal'}
                                //     )
                                // )
                                //     .setOption('gallery.default', 'horizontal');
                                //
                                //========================
                                //Example 6:
                                //========================
                                // Display only metadata detail tab.
                                //
                                // var detailModes = MediabankConfig.getOption('detail.modes');
                                // MediabankConfig.setOption(
                                //     'detail.modes',
                                //     _.filter(
                                //         detailModes,
                                //         {id: 'metadata'}
                                //     )
                                // );
                                //
                                //========================
                                //Example 7:
                                //========================
                                // Add a custom detail button with behavior
                                //
                                // var detailModes = MediabankConfig.getOption('detail.modes');
                                // detailModes.push(
                                //     {
                                //         'id': 'placeholder',
                                //         'label': 'Custom mode',
                                //         'action': function (detailContext) {
                                //             alert('We can do anything here, ');
                                //         }
                                //     }
                                // )
                                // MediabankConfig.setOption(
                                //     'detail.modes',
                                //     detailModes
                                // );
                                //
                                //========================
                                //Example 8:
                                //========================
                                // Enable tooltips

                                MediabankConfig.setOption('gallery.tooltips', true);

                                //========================
                                //Example 9:
                                //========================
                                // Enable Help and set custom url
                                //MediabankConfig.setOption('search.help', true)
                                //MediabankConfig.setOption('search.helpUrl', '#');
                                //========================

                                //Example 10:
                                //========================
                                // Add watermark to topviewer

                                MediabankConfig.setOption('detail.topviewer.watermark',
                                    {
                                        'addWatermarkSrc': 'http://www.beeldbankgroningen.nl/templates/beeldbank_groningen/images/watermerk.png',
                                        'watermarkPosition': 'center center'
                                    }
                                );

                                //========================
                                //Example 11:
                                //========================
                                // Configure topviewer buttons

                                MediabankConfig.setOption('detail.topviewer.buttons',
                                    [
                                        'zoomIn', 'zoomOut', 'rotatePlus90',
                                        'fullscreen', 'navigator', 'paginationLeft',
                                        'paginationRight', 'zoomingSlider'
                                    ]
                                );
                            }
                        );
                    }

                );

                angular.bootstrap(document, ['Mediabank.Boot']);
        });

        </script>



        <link rel="stylesheet" href="https://webservices.picturae.com/mediabank/2.0/dist/css/vendors.css" type="text/css" />
        <link rel="stylesheet" href="https://webservices.picturae.com/mediabank/2.0/dist/css/mediabank.css" type="text/css" />

        <!--[if lte IE 9]>
            <script type="text/javascript" src="http://webservices.picturae.com/mediabank/js/xdomain/xdomain.min.js"></script>
            <script>
                xdomain.slaves({
                    "http://webservices.picturae.com": "/mediabank/proxy.html"
                });
            </script>
        <![endif]-->

        <!-- change this to your domain and add path if it's served from a subdirectory -->
        <base href="/" />

        <?php if (!empty($media->title)): // add opengraph title  ?>
            <meta property="og:title" content="<?= htmlspecialchars($media->title) ?>" />
        <?php endif; ?>

        <?php if (!empty($media->asset[0]->thumb->large)): // add opengraph image  ?>
            <meta property="og:image" content="<?= $media->asset[0]->thumb->large ?>" />
        <?php endif; ?>
    </head>
    <body>
        <noscript>
            <h1><?=htmlspecialchars($media->title)?></h1>
            <ul>
                <?php foreach ($media->metadata as $data):?>
                    <li>
                        <span class="label"><?=htmlspecialchars($data->label)?></span>
                        <?php if (is_string($data->value)) :?>
                            <span class="value"><?=htmlspecialchars($data->value)?></span>
                        <?php endif;?>
                        <?php if (is_array($data->value)) :?>
                            <span class="value"><?=htmlspecialchars(implode(',', $data->value))?></span>
                        <?php endif;?>
                    </li>
                <?php endforeach;?>
            </ul>
        </noscript>
    <pic-mediabank
        data-api-key="<?= $apiKey ?>"
        data-api-url="https://webservices.picturae.com/mediabank/"
        />
</body>
</html>