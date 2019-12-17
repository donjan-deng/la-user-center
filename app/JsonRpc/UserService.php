<?php

namespace App\JsonRpc;

use Hyperf\Di\Annotation\Inject;
use Hyperf\RpcServer\Annotation\RpcService;
use App\Model\User;
use App\Model\Permission;
use Phper666\JwtAuth\Jwt;
use Phper666\JwtAuth\Exception\TokenValidException;
use Donjan\Permission\Exceptions\UnauthorizedException;

/**
 * @RpcService(name="UserService", protocol="jsonrpc-http", server="jsonrpc-http")
 */
class UserService
{

    /**
     * @Inject
     * @var Jwt
     */
    protected $jwt;

    /**
     * 
     * @param string $token
     * @param array $permission
     * @return App\Model\User
     * @throws TokenValidException
     * @throws \Exception
     */
    public function checkToken(string $token, array $permission = [])
    {
        $user = $this->getUser($token);
        $this->checkPermission($user, $permission);
        return $user;
    }

    protected function getUser($token)
    {
        try {
            $token = $this->jwt->getParser()->parse($token);
            if ($this->jwt->enalbed) {
                $claims = $this->jwt->claimsToArray($token->getClaims());
                // 验证token是否存在黑名单
                if ($this->jwt->blacklist->has($claims)) {
                    throw new TokenValidException('Token authentication does not pass', 401);
                }
            }
            if (!$this->jwt->validateToken($token)) {
                throw new TokenValidException('Token authentication does not pass', 401);
            }
            if (!$this->jwt->verifyToken($token)) {
                throw new TokenValidException('Token authentication does not pass', 401);
            }
            $userId = $token->getClaim('user_id');
            $user = User::where('user_id', $userId)->where('status', User::STATUS_ENABLE)->first();
            if ($user) {
                return $user;
            } else {
                throw new TokenValidException('用户已禁用', 401);
            }
        } catch (\Exception $e) {
            throw new TokenValidException('Token未验证通过', 401);
        }
        throw new TokenValidException('Token未验证通过', 401);
    }

    protected function checkPermission($user, $permission)
    {
        $allPermissions = Permission::getPermissions();
        $permissions = $allPermissions->filter(function ($value, $key)use($permission) {
                    return in_array($value->name, $permission);
                })->all();
        if (count($permissions) > 0 && !$user->hasAnyPermission($permissions)) {
            throw new UnauthorizedException('无权进行该操作', 403);
        }
    }

}
