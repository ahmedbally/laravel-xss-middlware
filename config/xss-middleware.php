<?php

return [
    /*
     |--------------------------------------------------------------------------
     | enable auto register middleware for all requests
     |--------------------------------------------------------------------------
     |
     | if you want auto register for custom middleware group
     |      'auto_register_middleware' => ['web'], // for web group only
     |      'auto_register_middleware' => true, //  all groups
     |      'auto_register_middleware' => false, // none
     */
    'auto_register_middleware' => true,

    /*
     * The middleware will used to filter xss
     */
    'middleware' => \Alkhwlani\XssMiddleware\XSSFilterMiddleware::class,

    /*
     * Field names that should be skipped entirely (no sanitisation, no
     * invisible-character stripping). Useful for fields that intentionally
     * carry HTML/markdown payloads, e.g. rich-text editor content or webhook
     * bodies.
     */
    'except' => [],

    /*
     |--------------------------------------------------------------------------
     | Evil attributes / tags
     |--------------------------------------------------------------------------
     |
     | Additional HTML attributes and tags that should always be stripped from
     | the input, on top of voku/anti-xss's built-in evil list. Set to null to
     | use only the defaults.
     |
     |     'evil' => [
     |         'attributes' => ['style', 'srcdoc'],
     |         'tags'       => ['svg', 'math'],
     |     ],
     */
    'evil' => [
        'attributes' => null,
        'tags'       => null,
    ],

    /*
     |--------------------------------------------------------------------------
     | Replacement string
     |--------------------------------------------------------------------------
     |
     | The string used to replace removed portions of input where XSS was
     | detected. Null preserves voku's default (empty string).
     */
    'replacement' => null,
];
