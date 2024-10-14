<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class BadRequestException extends CustomException
{
    public function __construct(
        string $message = 'There was an issue processing this request. Check that the endpoint and parameters given are correct.',
        int $code = Response::HTTP_BAD_REQUEST,
        ?Exception $previous = null
    ) {
        $title = 'Bad Request';
        parent::__construct($message, $code, $previous, $title);
    }
}
