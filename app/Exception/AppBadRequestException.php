<?php

declare(strict_types = 1);

namespace App\Exception;

use Hyperf\Server\Exception\ServerException;

class AppBadRequestException extends ServerException
{

    protected $code = 400;

    public function __construct(string $message = "")
    {
        parent::__construct($message, $this->code);
    }

}
