<?php

namespace Dockent\exceptions;

use ErrorException;

/**
 * Trait ErrorExceptionHandler
 * @package Dockent\exceptions
 */
trait ErrorExceptionHandler
{
    /**
     * @param int $severity
     * @param string $message
     * @param string $file
     * @param int $line
     * @throws ErrorException
     */
    private function exceptionErrorHandler(int $severity, string $message, string $file, int $line)
    {
        if (!(error_reporting() & $severity)) {
            return;
        }
        throw new ErrorException($message, 0, $severity, $file, $line);
    }
}