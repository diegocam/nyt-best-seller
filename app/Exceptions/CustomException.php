<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class CustomException extends Exception
{
    protected string $title = '';

    public function __construct(
        string $message = '',
        int $code = 0,
        ?Exception $previous = null,
        string $title = '',
    ) {
        $this->title = $title;
        parent::__construct($message, $code, $previous);
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
