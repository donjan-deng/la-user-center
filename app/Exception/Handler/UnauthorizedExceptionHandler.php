<?php

declare(strict_types = 1);

namespace App\Exception\Handler;

use Hyperf\Di\Annotation\Inject;
use Psr\Http\Message\ResponseInterface;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Throwable;
use App\Helpers\Helper;
use App\Helpers\Code;
use Donjan\Permission\Exceptions\UnauthorizedException;

class UnauthorizedExceptionHandler extends \Hyperf\Validation\ValidationExceptionHandler {

    /**
     * @Inject
     * @var Helper
     */
    protected $helper;

    public function handle(Throwable $throwable, ResponseInterface $response) {
        $this->stopPropagation();
        $result = $this->helper->error($throwable->getCode(), $throwable->getMessage());
        return $response->withStatus($throwable->getCode())
                        ->withAddedHeader('content-type', 'application/json')
                        ->withBody(new SwooleStream($this->helper->jsonEncode($result)));
    }
    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof UnauthorizedException;
    }
}
