<?php

namespace Bank\Exceptions;

use Exception;

class InvalidAmountException extends Exception
{
    public function __construct(string $message = "Некорректная сумма. Сумма должна быть положительной.")
    {
        parent::__construct($message);
    }
}