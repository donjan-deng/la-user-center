<?php

declare(strict_types = 1);

namespace App\Helpers;

use App\Helpers\Code;

Class Helper {

    //返回成功
    public function success($data) {
        return $this->result(Code::SUCCESS, Code::getMessage(Code::SUCCESS), $data);
    }

    //返回错误
    public function error($code = 422, $message = '', $data = []) {
        if (empty($message)) {
            return $this->result($code, Code::getMessage($code), $data);
        } else {
            return $this->result($code, $message, $data);
        }
    }

    public function result($code, $message, $data) {
        return ['code' => $code, 'message' => $message, 'data' => $data];
    }

    public function jsonEncode($data) {
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 生成随机数
     * @param number $length
     * @return number
     */
    public function generateNumber($length = 6) {
        return rand(pow(10, ($length - 1)), pow(10, $length) - 1);
    }

    /**
     * 生成随机字符串
     * @param number $length
     * @param string $chars
     * @return string
     */
    public function generateString($length = 6, $chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz') {
        $chars = str_split($chars);

        $chars = array_map(function($i) use($chars) {
            return $chars[$i];
        }, array_rand($chars, $length));

        return implode($chars);
    }

    /**
     * xml to array 转换
     * @param type $xml
     * @return type
     */
    public function xml2array($xml) {
        return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    }

}
