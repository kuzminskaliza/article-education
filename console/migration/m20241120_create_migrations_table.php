<?php

use console\ConsoleApp;

class m20241120_create_migrations_table
{
    public function up(): void
    {
        // Код для створення таблиці migrations
        $query = "
            CREATE TABLE IF NOT EXISTS migration (
                id SERIAL PRIMARY KEY,
                version VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ";

        // Виконання SQL запиту
        ConsoleApp::$pdo->exec($query);

        echo "Таблиця `migration` успішно створена.\n";
    }

    public function down(): void
    {
        // Код для видалення таблиці migrations
        $query = "DROP TABLE IF EXISTS migration";

        // Виконання SQL запиту
        ConsoleApp::$pdo->exec($query);

        echo "Таблиця `migration` успішно видалена.\n";
    }
}