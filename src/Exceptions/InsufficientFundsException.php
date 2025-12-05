<?php

declare(strict_types=1);

namespace Bank\Exceptions;

use Exception;

class InsufficientFundsException extends Exception
{
    public function __construct(string $message = "Недостаточно средств. Сумма снятия превышает баланс.")
    {
        parent::__construct($message);
    }
}
