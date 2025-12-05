<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Bank\BankAccount;
use Bank\Exceptions\InvalidAmountException;
use Bank\Exceptions\InsufficientFundsException;

/**
 * Выводит баланс счета
 * @param BankAccount $account Объект банковского счета
 */
function displayBalance(BankAccount $account): void
{
    echo "Текущий баланс: " . number_format($account->getBalance(), 2, ',', ' ') . " ₽\n\n";
}

/**
 * Выводит разделитель
 */
function printSeparator(): void
{
    echo "========================================\n";
}

/**
 * Основная функция демонстрации
 */
function runDemo(): void
{
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
        
        // Демонстрация нового метода transfer
        printSeparator();
        echo "3. Демонстрация перевода между счетами...\n";
        try {
            $account2 = new BankAccount(500.00);
            echo "Счет 1 (до перевода): ";
            displayBalance($account);
            echo "Счет 2 (до перевода): ";
            displayBalance($account2);
            
            $account->transfer($account2, 300.00);
            echo "Переведено 300,00 ₽ со счета 1 на счет 2\n";
            
            echo "Счет 1 (после перевода): ";
            displayBalance($account);
            echo "Счет 2 (после перевода): ";
            displayBalance($account2);
        } catch (InvalidAmountException | InsufficientFundsException $e) {
            echo "Ошибка перевода: " . $e->getMessage() . "\n";
        }
        
        // Попытка снять больше, чем есть на счете
        printSeparator();
        echo "4. Попытка снять больше, чем на счете...\n";
        try {
            $account->withdraw(2000.00);
        } catch (InsufficientFundsException $e) {
            echo "Ошибка: " . $e->getMessage() . "\n";
        }
        displayBalance($account);
        
        // Проверка типов данных
        printSeparator();
        echo "5. Проверка типов данных...\n";
        try {
            // Это вызовет TypeError в strict режиме
            // $account->deposit("100"); // Раскомментируйте для теста
            
            echo "Все типы данных проверены успешно!\n";
        } catch (\TypeError $e) {
            echo "TypeError: " . $e->getMessage() . "\n";
        }
        
        printSeparator();
        echo "Итоговый ";
        displayBalance($account);
        
    } catch (Exception $e) {
        echo "Критическая ошибка: " . $e->getMessage() . "\n";
    }
}

// Запускаем демо
runDemo();

echo "\n=== Демонстрация завершена ===\n";
