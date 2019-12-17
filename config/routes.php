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
    App\Middleware\JwtAuthMiddleware::class,
    App\Middleware\PermissionMiddleware::class,
];

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');
Router::get('/captcha', 'App\Controller\IndexController@captcha');
Router::post('/token', 'App\Controller\IndexController@token');
Router::post('/refresh_token', 'App\Controller\IndexController@refreshToken', ['middleware' => [App\Middleware\JwtAuthMiddleware::class]]);
Router::addRoute(['GET', 'POST'], '/logout', 'App\Controller\IndexController@logout');
//User
Router::get('/users', 'App\Controller\UserController@index', ['middleware' => $middleware]);
Router::post('/users', 'App\Controller\UserController@store', ['middleware' => $middleware]);
Router::put('/users/{id:\d+}', 'App\Controller\UserController@update', ['middleware' => $middleware]);
Router::get('/users/{id:\d+}', 'App\Controller\UserController@show', ['middleware' => $middleware]);
Router::delete('/users/{id:\d+}', 'App\Controller\UserController@delete', ['middleware' => $middleware]);
Router::put('/users/roles', 'App\Controller\UserController@roles', ['middleware' => $middleware]);
//Role
Router::get('/roles', 'App\Controller\RoleController@index', ['middleware' => $middleware]);
Router::post('/roles', 'App\Controller\RoleController@store', ['middleware' => $middleware]);
Router::put('/roles/{id:\d+}', 'App\Controller\RoleController@update', ['middleware' => $middleware]);
Router::get('/roles/{id:\d+}', 'App\Controller\RoleController@show', ['middleware' => $middleware]);
Router::delete('/roles/{id:\d+}', 'App\Controller\RoleController@delete', ['middleware' => $middleware]);
//Permission
Router::get('/permissions', 'App\Controller\PermissionController@index', ['middleware' => $middleware]);
Router::post('/permissions', 'App\Controller\PermissionController@store', ['middleware' => $middleware]);
Router::put('/permissions/{id:\d+}', 'App\Controller\PermissionController@update', ['middleware' => $middleware]);
Router::get('/permissions/{id:\d+}', 'App\Controller\PermissionController@show', ['middleware' => $middleware]);
Router::delete('/permissions/{id:\d+}', 'App\Controller\PermissionController@delete', ['middleware' => $middleware]);
