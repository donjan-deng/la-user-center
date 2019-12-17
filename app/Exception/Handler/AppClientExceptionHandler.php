<?php

declare(strict_types = 1);

namespace App\Exception\Handler;

use Hyperf\Di\Annotation\Inject;
use Psr\Http\Message\ResponseInterface;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Throwable;
use App\Helpers\Helper;
use App\Helpers\Code;
use App\Exception;

class AppClientExceptionHandler extends ExceptionHandler
{

    /**
     * @Inject
     * @var Helper
     */
    protected $helper;

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        $this->stopPropagation();
        $result = $this->helper->error($throwable->getCode(), $throwable->getMessage(), $throwable->getMessage());
        return $response->withStatus($throwable->getCode())
                        ->withAddedHeader('content-type', 'application/json')
                        ->withBody(new SwooleStream($this->helper->jsonEncode($result)));
    }

    public function isValid(Throwable $throwable): bool
    {
        return ($throwable instanceof Exception\AppBadRequestException) ||
                ($throwable instanceof Exception\AppNotFoundException) ||
                ($throwable instanceof Exception\AppNotAllowedException);
    }

}
