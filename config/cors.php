<?php

return [
    'allowed_headers' => ['Content-Type', 'Authorization', 'X-Requested-With', 'X-Refresh-Token'],
    'allowed_methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
    'allowed_origins' => ['*'],
    'max_age'         => 86400,
];
