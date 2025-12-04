<?php

require_once __DIR__ . '/vendor/autoload.php';

use Bank\BankAccount;
use Bank\Exceptions\InvalidAmountException;
use Bank\Exceptions\InsufficientFundsException;

function displayBalance(BankAccount $account): void
{
    echo "Текущий баланс: " . number_format($account->getBalance(), 2, ',', ' ') . " ₽\n\n";
}

function printSeparator(): void
{
    echo "========================================\n";
}

try {
    echo "=== Демонстрация работы банковского счета ===\n\n";
    
    // Создаем банковский счет с начальным балансом
    printSeparator();
    echo "1. Создание счета с начальным балансом...\n";
    $account = new BankAccount(1000.00);
    displayBalance($account);
    
    // Успешное пополнение
    printSeparator();
    echo "2. Пополнение счета...\n";
    try {
        $account->deposit(500.00);
        echo "Успешно пополнено: 500,00 ₽\n";
        displayBalance($account);
    } catch (InvalidAmountException $e) {
        echo "Ошибка при пополнении: " . $e->getMessage() . "\n";
    }
    
    // Попытка пополнить отрицательной суммой
    printSeparator();
    echo "3. Попытка пополнить отрицательной суммой...\n";
    try {
        $account->deposit(-100.00);
    } catch (InvalidAmountException $e) {
        echo "Ошибка: " . $e->getMessage() . "\n";
    }
    displayBalance($account);
    
    // Успешное снятие
    printSeparator();
    echo "4. Снятие средств...\n";
    try {
        $account->withdraw(300.00);
        echo "Успешно снято: 300,00 ₽\n";
        displayBalance($account);
    } catch (InvalidAmountException | InsufficientFundsException $e) {
        echo "Ошибка при снятии: " . $e->getMessage() . "\n";
    }
    
    // Попытка снять больше, чем есть на счете
    printSeparator();
    echo "5. Попытка снять больше, чем на счете...\n";
    try {
        $account->withdraw(2000.00);
    } catch (InsufficientFundsException $e) {
        echo "Ошибка: " . $e->getMessage() . "\n";
    } catch (InvalidAmountException $e) {
        echo "Ошибка: " . $e->getMessage() . "\n";
    }
    displayBalance($account);
    
    // Попытка снять отрицательную сумму
    printSeparator();
    echo "6. Попытка снять отрицательную сумму...\n";
    try {
        $account->withdraw(-50.00);
    } catch (InvalidAmountException $e) {
        echo "Ошибка: " . $e->getMessage() . "\n";
    }
    displayBalance($account);
    
    // Попытка снять ноль
    printSeparator();
    echo "7. Попытка снять ноль...\n";
    try {
        $account->withdraw(0.00);
    } catch (InvalidAmountException $e) {
        echo "Ошибка: " . $e->getMessage() . "\n";
    }
    displayBalance($account);
    
    // Дополнительные операции
    printSeparator();
    echo "8. Дополнительные операции...\n";
    
    try {
        $account->deposit(250.75);
        echo "Пополнено: 250,75 ₽\n";
        
        $account->withdraw(100.25);
        echo "Снято: 100,25 ₽\n";
        
        displayBalance($account);
    } catch (InvalidAmountException | InsufficientFundsException $e) {
        echo "Ошибка операции: " . $e->getMessage() . "\n";
    }
    
    // Тест создания счета с отрицательным балансом
    printSeparator();
    echo "9. Тест создания счета с отрицательным балансом...\n";
    try {
        $testAccount = new BankAccount(-500.00);
    } catch (InvalidAmountException $e) {
        echo "Ошибка при создании счета: " . $e->getMessage() . "\n";
    }
    
    printSeparator();
    echo "Итоговый ";
    displayBalance($account);
    
} catch (Exception $e) {
    echo "Критическая ошибка: " . $e->getMessage() . "\n";
}

echo "\n=== Демонстрация завершена ===\n";