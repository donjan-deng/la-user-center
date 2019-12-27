<?php

declare(strict_types = 1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;
use Hyperf\Validation\Rule;

class RoleRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'name' => [
                'bail',
                'required',
                Rule::unique('roles')->ignore($this->routeParam('id', 0)),
            ],
            'permissions' => 'Required|Array',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => '角色名称'
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => '角色名称已存在',
        ];
    }

}
