<?php

declare(strict_types = 1);

namespace App\Controller;

use Hyperf\Di\Annotation\Inject;
use Illuminate\Hashing\BcryptHasher;
use App\Exception;
use App\Model;
use App\Request;

class UserController extends AbstractController
{

    /**
     * @Inject
     * @var BcryptHasher
     */
    protected $hash;

    //get
    public function index()
    {
        $params = $this->request->all();
        $pageSize = $this->request->input('per_page', 15);
        $list = Model\User::getList($params, (int) $pageSize);
        return $list;
    }

    //post create
    public function store(Request\UserRequest $request)
    {
        $data = $request->all();
        if (empty($data['password'])) {
            throw new Exception\AppBadRequestException('请填写密码');
        }
        $data['password'] = $this->hash->make($data['password']);
        $user = Model\User::create($data);
        return $user;
    }

    // get
    public function show($id)
    {
        $user = Model\User::where('user_id', '<>', config('app.super_admin'))->find($id);
        if (!$user) {
            throw new Exception\AppNotFoundException("用户ID：{$id}不存在");
        }
        return $user;
    }

    // put
    public function update(Request\UserRequest $request, $id)
    {
        $data = $request->all();
        $user = Model\User::where('user_id', '<>', config('app.super_admin'))->find($id);
        if (!$user) {
            throw new Exception\AppNotFoundException("用户ID：{$id}不存在");
        }
        if (isset($data['username'])) {
            unset($data['username']);
        }
        if (isset($data['password']) && empty($data['password'])) {
            unset($data['password']);
        } elseif (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = $this->hash->make($data['password']);
        }
        $user->update($data);
        return $user;
    }

    // delete
    public function destroy($id)
    {
        
    }

    public function roles($id)
    {
        $roles = $this->request->input('roles', []);
        $model = Model\User::where('user_id', '<>', config('app.super_admin'))->find($id);
        if (!$model) {
            throw new Exception\AppNotFoundException("用户ID：{$id}不存在");
        }
        $model->syncRoles($roles);
        return $model;
    }

}
