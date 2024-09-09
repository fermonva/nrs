<?php

namespace App\Exceptions;

use Exception;

class ClientCreationException extends Exception
{
    public function __construct($message = 'Client creation failed', $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ClientCreationException) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }

        return parent::render($request, $exception);
    }
}
