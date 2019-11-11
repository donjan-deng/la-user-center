<?php

declare(strict_types = 1);

namespace App\Exception\Handler;

use Hyperf\Di\Annotation\Inject;
use Psr\Http\Message\ResponseInterface;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Throwable;
use App\Helpers\Helper;
use App\Helpers\Code;

class AppValidationExceptionHandler extends \Hyperf\Validation\ValidationExceptionHandler {

    /**
     * @Inject
     * @var Helper
     */
    protected $helper;

    public function handle(Throwable $throwable, ResponseInterface $response) {
        $this->stopPropagation();
        /** @var \Hyperf\Validation\ValidationException $throwable */
        $message = $throwable->validator->errors()->first();
        $errors = $throwable->validator->errors();
        $result = $this->helper->error(Code::VALIDATE_ERROR, $message, $errors);
        return $response->withStatus($throwable->status)
                        ->withAddedHeader('content-type', 'application/json')
                        ->withBody(new SwooleStream($this->helper->jsonEncode($result)));
    }

}
