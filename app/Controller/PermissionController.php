<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Exception;
use App\Model;
use App\Request;

class PermissionController extends AbstractController
{

    public function index()
    {
        $list = Model\Permission::getMenuList();
        return $list;
    }

    public function store(Request\PermissionRequest $request)
    {
        $data = $request->all();
        $result = Model\Permission::create($data);
        return $result;
    }

    public function show($id)
    {
        $result = Model\Permission::find($id);
        if (!$result) {
            throw new Exception\AppNotFoundException("请求资源不存在");
        }
        $result->roles;
        return $result;
    }

    public function update(Request\PermissionRequest $request, $id)
    {
        $data = $request->all();
        $result = Model\Permission::find($id);
        if (!$result) {
            throw new Exception\AppNotFoundException("请求资源不存在");
        }
        $result->update($data);
        return $result;
    }

    public function destroy($id)
    {
        $result = Model\Permission::find($id);
        if (!$result) {
            throw new Exception\AppNotFoundException("请求资源不存在");
        }
        return $result->delete();
    }

}
