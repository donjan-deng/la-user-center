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
use Carbon\Carbon;
use App\Request\LoginRequest;
use App\Helpers\Code;
use App\Model\User;
use App\Exception;

class IndexController extends AbstractController
{

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

    public function index()
    {
        $method = $this->request->getMethod();
        return [
            'method' => $method,
            'message' => 'hyperf',
        ];
    }

    //获取token
    public function token(LoginRequest $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');
        $user = User::where('username', '=', $username)->first();
        if (!$user) {
            throw new Exception\AppNotFoundException("用户{$username}不存在");
        }
        if (!$this->hash->check($password, $user->password)) {
            throw new Exception\AppBadRequestException("用户名或者密码错误");
        }
        if ($user->status != User::STATUS_ENABLE) {
            throw new Exception\AppNotAllowedException("用户{$username}已禁用");
        }
        $user->last_login_at = Carbon::now();
        $user->save();
        $token = (string) $this->jwt->getToken(['user_id' => $user->user_id]);
        $user['menu'] = $user->getMenu();
        $user['all_permissions'] = $user->getAllPermissions();
        return ['user' => $user, 'access_token' => $token, 'expires_in' => $this->jwt->getTTL()];
    }

    //刷新token
    public function refreshToken()
    {
        $token = $this->jwt->refreshToken();
        return ['access_token' => (string) $token, 'expires_in' => $this->jwt->getTTL()];
    }

    //退出登录
    public function logout()
    {
        try {
            $this->jwt->logout();
        } catch (\Exception $e) {
            
        }
        return $this->helper->success('success');
    }

    //验证码
    public function captcha()
    {
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
