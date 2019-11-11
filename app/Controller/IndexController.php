<?php

declare(strict_types = 1);

namespace App\Controller;

use Hyperf\Di\Annotation\Inject;
use Illuminate\Hashing\BcryptHasher;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\HttpMessage\Cookie\Cookie;
use Phper666\JwtAuth\Jwt;
use App\Request\LoginRequest;
use App\Model\User;
use App\Helpers\Code;
use Hyperf\Utils\ApplicationContext;

class IndexController extends AbstractController {

    /**
     * @Inject
     * @var BcryptHasher
     */
    protected $hash;

    /**
     * @Inject
     * @var Jwt
     */
    protected $jwt;

    public function index() {
        $user = $this->request->input('user', 'Hyperf');
        $method = $this->request->getMethod();
        return [
            'method' => $method,
            'message' => "Hello {$user}.",
            'config' => $this->config->get('databases.default.username'),
            'password' => $this->hash->make('123456'),
            'captcha' => $this->cache->get($this->request->cookie('captcha', '')),
            'user' => $this->request->user
        ];
    }

    //获取token
    public function token(Jwt $jwt, LoginRequest $request) {
        $username = $request->input('username');
        $password = $request->input('password');
        $user = User::where('username', '=', $username)->first();
        if (!$user) {
            return $this->helper->error(Code::ERROR, "用户{$username}不存在");
        }
        if (!$this->hash->check($password, $user->password)) {
            return $this->helper->error(Code::INCORRECT_PASSWORD);
        }
        if ($user->status != User::STATUS_ENABLE) {
            return $this->helper->error(Code::USER_DISABLE);
        }
        $token = (string) $this->jwt->getToken(['user_id' => $user->user_id]);
        return $this->helper->success(['access_token' => $token, 'expires_in' => $jwt->getTTL()]);
    }

    //刷新token
    public function refreshToken() {
        $token = $this->jwt->refreshToken();
        return $this->helper->success(['access_token' => (string) $token, 'expires_in' => $jwt->getTTL()]);
    }

    //退出登录
    public function logout() {
        try {
            $this->jwt->logout();
        } catch (\Exception $e) {
            
        }
        return $this->helper->success('success');
    }

    //验证码
    public function captcha() {
        $length = $this->request->input('length', 4);
        $width = $this->request->input('width', 80);
        $height = $this->request->input('height', 35);
        $phraseBuilder = new PhraseBuilder($length);
        $builder = new CaptchaBuilder(null, $phraseBuilder);
        $builder->build($width, $height);
        $phrase = $builder->getPhrase();
        $captchaId = uniqid();
        $this->cache->set($captchaId, $phrase, 300);
        $cookie = new Cookie('captcha', $captchaId);
        $output = $builder->get();
        return $this->response
                        ->withCookie($cookie)
                        ->withAddedHeader('content-type', 'image/jpeg')
                        ->withBody(new SwooleStream($output));
    }

}
