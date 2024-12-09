<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

'paths' => ['api/*', 'login'], // Adjust paths as per your routes
'allowed_origins' => ['http://localhost:5173'], // Add your frontend URL
'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE'], // Adjust allowed methods
'allowed_headers' => ['*'], // Adjust allowed headers
'exposed_headers' => [], // Expose any headers if needed
'max_age' => 0,
'supports_credentials' => false,

];
