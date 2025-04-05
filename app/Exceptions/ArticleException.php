<?php

namespace App\Exceptions;

use Exception;

class ArticleException extends Exception
{
    public function __construct($message = "Произошла ошибка при работе со статьей", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
} 