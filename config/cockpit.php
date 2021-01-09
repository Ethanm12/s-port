<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cockpit URI
    |--------------------------------------------------------------------------
    |
    | The URI for your Cockpit installation.
    |
    */

    'uri' => env('CMS_URI', '/'),

    /*
    |--------------------------------------------------------------------------
    | API Key
    |--------------------------------------------------------------------------
    |
    | The API key for Cockpit. Sent with all requests to Cockpit.
    | You can get this from Settings > API Access, or generate a user-specific key.
    |
    */

    'token' => env('CMS_KEY', null),

    /*
    |--------------------------------------------------------------------------
    | CMS Caching
    |--------------------------------------------------------------------------
    |
    | Whether or not to cache data. By default, we cache the data using
    | whatever driver the user has specified. This will cache the Cockpit
    | data on your server. If you don't set this to false, be sure to
    | set up a webhook on Cockpit so that the cache will be busted when new
    | data is input. You can also specify the cache length.
    |
    */

    'caches' => env('CMS_CACHE', true),
    'cache_length' => env('CMS_CACHE_LENGTH', 1000),

    /*
    |--------------------------------------------------------------------------
    | Cockpit Resources
    |--------------------------------------------------------------------------
    |
    | Your Cockpit resources. This is what the wrapper "cares" about.
    | The keys are what you pass to the wrapper's get() method, and the values
    | are the URLs of the collection relative to the Cockpit root.
    |
    | An example has been provided.
    |
    */

    'resources' => [
        'pages'     => '/api/collections/get/pages',
        'contact'   => '/api/collections/get/contact',
        'home'      => '/api/collections/get/home',
    ],

    /*
    |--------------------------------------------------------------------------
    | Processors
    |--------------------------------------------------------------------------
    |
    | The processors for each field type. A processor is a simple class that
    | takes a string in and outputs a string. Here we include a few default
    | processors that prefix URLs with your Cockpit URL.
    |
    */

    'processors' => [
        'wysiwyg' => [
            \Cockpit\Processors\ImageTagPrefixProcessor::class,
        ],
        'image' => [
            \Cockpit\Processors\AssetPrefixProcessor::class,
        ],
        'file' => [
            \Cockpit\Processors\AssetPrefixProcessor::class,
        ]
    ],
];