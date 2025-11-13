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

    'paths' => [
        'api/*', // Cho phép mọi route /api/
        'login',    // Cho phép route /login
        'register', // Cho phép route /register
        'logout',   // Cho phép route /logout
        'sanctum/csrf-cookie', // Cho phép route lấy cookie
    ],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'http://localhost:5173', // Domain của Vue app
        // env('FRONTEND_URL', 'http://localhost:5173'), // Cách "pro" là dùng file .env
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true, //Bắt buộc để cho phép trình duyệt gửi cookie (chứa session) qua các domain khác nhau (từ 5173 -> 8000).

];
