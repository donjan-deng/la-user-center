<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Exception;
use App\Model;
use App\Request;

class RoleController extends AbstractController
{

    public function index()
    {
        $params = $this->request->all();
        $pageSize = $this->request->input('per_page', 15);
        $params['with'] = ['permissions'];
        $list = Model\Role::getList($params, (int) $pageSize);
        return $list;
    }

    public function store(Request\RoleRequest $request)
    {
        $data = $request->all();
        $permissions = $request->input('permissions', []);
        unset($data['permissions']);
        $result = Model\Role::create($data);
        $result->permissions()->sync($permissions);
        return $result;
    }

    public function show($id)
    {
        $result = Model\Role::find($id);
        if (!$result) {
            throw new Exception\AppNotFoundException("请求资源不存在");
        }
        $result->permissions;
        return $result;
    }

    public function update(Request\RoleRequest $request, $id)
    {
        $data = $request->all();
        $permissions = $request->input('permissions', []);
        $result = Model\Role::find($id);
        if (!$result) {
            throw new Exception\AppNotFoundException("请求资源不存在");
        }
        unset($data['permissions']);
        $result->update($data);
        $result->syncPermissions($permissions);
        return $result;
    }

    public function destroy($id)
    {
        $result = Model\Role::find($id);
        if (!$result) {
            throw new Exception\AppNotFoundException("请求资源不存在");
        }
        return $result->delete();
    }

}
