<?php

declare(strict_types = 1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;
use Hyperf\HttpServer\Router\Dispatched;

class BaseRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function routeParam(string $key, $default)
    {
        $route = $this->getAttribute(Dispatched::class);
        if (is_null($route)) {
            return $default;
        }
        return array_key_exists($key, $route->params) ? $route->params[$key] : $default;
    }

}
