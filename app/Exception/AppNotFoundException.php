<?php

declare(strict_types = 1);

namespace App\Exception;

use Hyperf\Server\Exception\ServerException;

class AppNotFoundException extends ServerException
{

    protected $code = 404;

    public function __construct(string $message = "")
    {
        parent::__construct($message, $this->code);
    }

}
