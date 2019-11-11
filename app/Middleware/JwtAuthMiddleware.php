<?php

declare(strict_types = 1);

namespace App\Middleware;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use \Hyperf\Utils\Context;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Phper666\JwtAuth\Jwt;
use Phper666\JwtAuth\Exception\TokenValidException;
use App\Model\User;

class JwtAuthMiddleware implements MiddlewareInterface {

    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;

    /**
     * @Inject
     * @var Jwt
     */
    protected $jwt;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface {
        try {
            $token = $this->jwt->getTokenObj();
            if ($this->jwt->checkToken()) {
                $userId = $token->getClaim('user_id');
                $user = User::where('user_id', $userId)->where('status', User::STATUS_ENABLE)->first();
                if ($user) {
                    $this->request->user = $user;
                    return $handler->handle($request);
                }
            }
        } catch (\Exception $e) {
            throw new TokenValidException('Token未验证通过', 401);
        }
        throw new TokenValidException('Token未验证通过', 401);
    }

}
