<?php

namespace App\Exceptions;

use Exception;

class ServerNotFoundException extends Exception
{
    const DEFAULT_MESSAGE = 'Server not found';

    /**
     * Logs an exception.
     *
     * @return void
     */
    public function log()
    {
        \Log::debug(self::DEFAULT_MESSAGE);
    }
}
