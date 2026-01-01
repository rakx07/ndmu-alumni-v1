<?php

return [
    'guzzle' => [
        'verify' => env('CURL_CA_BUNDLE', base_path('cacert.pem')),
    ],
];