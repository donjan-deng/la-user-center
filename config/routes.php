<?php

declare(strict_types = 1);

/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */
use Hyperf\HttpServer\Router\Router;

$middleware = [
    App\Middleware\JwtAuthMiddleware::class
];

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');
Router::get('/captcha', 'App\Controller\IndexController@captcha');
Router::post('/token', 'App\Controller\IndexController@token');
Router::post('/refresh_token', 'App\Controller\IndexController@refreshToken', ['middleware' => [App\Middleware\JwtAuthMiddleware::class]]);
Router::addRoute(['GET', 'POST'], '/logout', 'App\Controller\IndexController@logout');
