<?php

return [
    'credentials' => [
        'key'    => env('BM_AWS_DYNAMO_KEY'),
        'secret' => env('BM_AWS_DYNAMO_SECRET'),
    ],
    'region'   => env('BM_AWS_DYNAMO_REGION'),
    'version'  => env('BM_AWS_DYNAMO_VERSION'),
];