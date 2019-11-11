<?php

declare(strict_types = 1);

namespace App\Helpers;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * @Constants
 */
class Code extends AbstractConstants {

    /**
     * @Message("Request Error！")
     */
    const ERROR = 0;

    /**
     * @Message("Success")
     */
    const SUCCESS = 200;

    /**
     * @Message("验证错误")
     */
    const VALIDATE_ERROR = 422;

    /**
     * @Message("无权访问该资源")
     */
    const DISALLOW = 403;

    /**
     * @Message("请求资源不存在")
     */
    const RECORD_NOT_FOUND = 404;

    /**
     * @Message("保存数据失败，请重试")
     */
    const SAVE_DATA_ERROR = 1001;

    /**
     * @Message("请先登录")
     */
    const UNAUTHENTICATED = 401;

    /**
     * @Message("QueryException")
     */
    const QUERYEXCEPTION = 1002;

    /**
     * @Message("crsf token 验证不通过 ")
     */
    const TOKENMISMATCH = 1010;

    /**
     * @Message("用户名或者密码错误")
     */
    const INCORRECT_PASSWORD = 1003;

    /**
     * @Message("请求参数错误")
     */
    const PARAMS_ERROR = 1005;

    /**
     * @Message("用户已禁用")
     */
    const USER_DISABLE = 1007;

    /**
     * @Message("短信发送失败")
     */
    const SMS_SEND_FAILED = 1009;

}
