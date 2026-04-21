<?php

/**
 * @var string[]
 */
$allowedOrigins = [];
$allowedOriginsStr = env('CORS_ALLOWED_ORIGINS');
if ($allowedOriginsStr) {
    $allowedOrigins = explode(',', $allowedOriginsStr);
}

return [
    'allowed_origins' => $allowedOrigins,
    'max_age' => env('CORS_MAX_AGE', 3600), // 预检请求的有效期，单位秒
    'allowed_credentials' => env('CORS_ALLOWED_CREDENTIALS', false), // 是否允许携带cookie等凭证信息
];
