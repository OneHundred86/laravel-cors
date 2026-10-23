# cors for laravel

## 一、安装

```shell
composer require oh86/laravel-cors

php artisan vendor:publish --provider='Oh86\LaravelCors\CorsServiceProvider'

```

## 二、配置env

```dotenv
# cors
# 域名支持精准配置，也支持正则表达式(需要携带分割符)配置
CORS_ALLOWED_ORIGINS=http://a.laravel8.local,#http://.*\.laravel8\.local$#
CORS_ALLOWED_CREDENTIALS=true
CORS_MAX_AGE=7200

```

`config/cors.php` 中的 `allowed_origins` 支持混合配置完整 Origin 和带分隔符的 PHP 正则表达式。建议使用 `^`、`$` 限定整个 Origin：

```php
'allowed_origins' => [
    'https://example.com',
    '#^https://[a-z0-9-]+\.example\.com$#',
],
```

## 三、使用示例

```php
use Oh86\LaravelCors\Middlewares\EnableCors;

// 注意：建议手动添加options方法，有可能会触发preflight预检请求
// 如果使用options方法请求，而路由没有注册该方法，laravel的响应会提示错误（Allow响应头提示允许的请求方法）（比如：status：200，响应头Allow: GET,HEAD）
Route::match(['get', 'options'], 'cors/demo1', [CorsController::class, 'demo1'])->middleware(EnableCors::class);

// any会给路由注册所有方法，包括options
Route::any('cors/demo2', [CorsController::class, 'demo2'])->middleware(EnableCors::class);

```
