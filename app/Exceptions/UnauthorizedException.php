<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class UnauthorizedException extends CustomException
{
    public function __construct(
        string $message = 'The request was unauthorized. Check that you have the correct credentials.',
        int $code = Response::HTTP_UNAUTHORIZED,
        ?Exception $previous = null,
    ) {
        $title = 'Unauthorized';
        parent::__construct($message, $code, $previous, $title);
    }
}
