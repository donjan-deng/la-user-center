<?php

declare(strict_types = 1);

namespace App\Model;

class User extends Model {

    protected $table = 'user';
    protected $primaryKey = 'user_id';
    protected $guarded = ['created_at', 'last_login_at', 'updated_at'];
    protected $attributes = [
        'status' => 1,
    ];
    public static $sex = [
        0 => '未知',
        1 => '男',
        2 => '女',
    ];

    public function getSexTextAttribute() {
        return $this->attributes['sex_text'] = get_format_state($this->attributes['sex'], self::$sex);
    }

    public function getStatusTextAttribute() {
        return $this->attributes['status_text'] = get_format_state($this->attributes['status'], self::$status);
    }

    protected $fillable = [
        'username', 'email', 'phone', 'password',
    ];
    protected $hidden = [
        'password', 'remember_token', 'updated_at'
    ];

    protected function getList($params, $pageSize) {
        $query = $this->with('roles')->where('user_id', '<>', config('app.super_admin'));
        (isset($params['status']) && $params['status'] !== "") && $query->where('status', '=', $params['status']);
        (isset($params['username']) && !empty($params['username'])) && $query->where('username', 'like', "%{$params['username']}%");
        (isset($params['phone']) && !empty($params['phone'])) && $query->where('phone', 'like', "%{$params['phone']}%");
        if (isset($params['start_time']) && isset($params['end_time']) && !empty($params['start_time']) && !empty($params['end_time'])) {
            $query->where('created_at', '>=', $params['start_time'])->where('created_at', '<=', $params['end_time']);
        }
        if (!isset($params['sort_name']) || empty($params['sort_name'])) {
            $params['sort_name'] = $this->primaryKey;
        }
        $params['sort_value'] = isset($params['sort_value']) ? ($params['sort_value'] == 'descend' ? 'desc' : 'asc') : 'desc';
        $list = $query->orderBy($params['sort_name'], $params['sort_value'])->paginate($pageSize);
        foreach ($list as &$value) {
            $value->sex_text;
            $value->status_text;
        }
        return $list;
    }

}
