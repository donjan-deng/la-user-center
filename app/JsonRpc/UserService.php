<?php

namespace App\JsonRpc;

use Hyperf\Di\Annotation\Inject;
use Hyperf\RpcServer\Annotation\RpcService;
use App\Model\User;
use Phper666\JwtAuth\Jwt;
use Phper666\JwtAuth\Exception\TokenValidException;

/**
 * @RpcService(name="UserService", protocol="jsonrpc-http", server="jsonrpc-http")
 */
class UserService {

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
    public function checkToken(string $token, array $permission = []) {
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
                if (count($permission) > 0) { //权限认证
                }
                return $user;
            } else {
                throw new \Exception('用户已禁用');
            }
        } catch (\Exception $e) {
            throw new TokenValidException('Token未验证通过', 401);
        }
        throw new TokenValidException('Token未验证通过', 401);
    }

}
