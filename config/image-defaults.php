<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Image Paths and Settings
    |--------------------------------------------------------------------------
    |
    |
    | We set the config here so that we can keep our controllers clean.
    | Configure each image type with an image path.
    |
    */

        'marketingImage' => [

            'destinationFolder'     => '/imgs/marketing/',
            'destinationThumbnail'      => '/imgs/marketing/thumbnails/',
            'thumbPrefix'           => 'thumb-',
            'imagePath'             => '/imgs/marketing/',
            'thumbnailPath'         => '/imgs/marketing/thumbnails/thumb-',
            'thumbHeight'           => 60,
            'thumbWidth'            => 60,

        ],


];
