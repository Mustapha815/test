<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

'allowed_methods' => ['*'],

'allowed_origins' => ['https://marseille-style.shop', 'http://localhost:5173', 'http://localhost:8000'],
'allowed_headers' => ['*'],

'supports_credentials' => true,

];