<?php

declare(strict_types=1);

namespace Bank;

use Bank\Exceptions\InvalidAmountException;
use Bank\Exceptions\InsufficientFundsException;

class BankAccount
{
    private float $balance;

    /**
     * Конструктор счета
     * @param float $initialBalance Начальный баланс
     * @throws InvalidAmountException Если начальный баланс отрицательный
     */
    public function __construct(float $initialBalance = 0.0)
    {
        if ($initialBalance < 0) {
            throw new InvalidAmountException("Начальный баланс не может быть отрицательным.");
        }
        
        $this->balance = $initialBalance;
    }

    /**
     * Возвращает текущий баланс
     * @return float Текущий баланс счета
     */
    public function getBalance(): float
    {
        return $this->balance;
    }

    /**
     * Пополняет счет
     * @param float $amount Сумма для пополнения
     * @throws InvalidAmountException Если сумма отрицательная или равна нулю
     * @return void
     */
    public function deposit(float $amount): void
    {
        if ($amount <= 0) {
            throw new InvalidAmountException("Сумма пополнения должна быть положительной.");
        }
        
        $this->balance += $amount;
    }

    /**
     * Снимает средства со счета
     * @param float $amount Сумма для снятия
     * @throws InvalidAmountException Если сумма отрицательная или равна нулю
     * @throws InsufficientFundsException Если сумма превышает баланс
     * @return void
     */
    public function withdraw(float $amount): void
    {
        if ($amount <= 0) {
            throw new InvalidAmountException("Сумма снятия должна быть положительной.");
        }
        
        if ($amount > $this->balance) {
            throw new InsufficientFundsException(
                "Невозможно снять {$amount} ₽. Доступный баланс: {$this->balance} ₽"
            );
        }
        
        $this->balance -= $amount;
    }

    /**
     * Переводит средства на другой счет
     * @param BankAccount $toAccount Счет получателя
     * @param float $amount Сумма перевода
     * @throws InvalidAmountException Если сумма отрицательная или равна нулю
     * @throws InsufficientFundsException Если сумма превышает баланс
     * @return bool True если перевод успешен
     */
    public function transfer(self $toAccount, float $amount): bool
    {
        $this->withdraw($amount);
        $toAccount->deposit($amount);
        
        return true;
    }
}
