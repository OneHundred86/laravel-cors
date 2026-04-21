# cors for laravel

## 一、安装

```shell
composer require oh86/laravel-cors

php artisan vendor:publish --provider='Oh86\LaravelCors\CorsServiceProvider'

```

## 二、配置env

```dotenv
# cors
CORS_ALLOWED_ORIGINS=http://a.laravel8.local,http://b.laravel8.local
CORS_ALLOWED_CREDENTIALS=true
CORS_MAX_AGE=7200

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
