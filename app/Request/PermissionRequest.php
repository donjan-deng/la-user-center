<?php

declare(strict_types = 1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

class PermissionRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'name' => [
                'bail',
                'required',
                Rule::unique('permissions')->ignore($this->routeParam('id', 0)),
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => '权限名称'
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => '权限名称已存在',
        ];
    }

}
