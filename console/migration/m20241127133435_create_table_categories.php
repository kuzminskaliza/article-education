<?php

use console\ConsoleApp;

class m20241127133435_create_table_categories
{
    public function up(): void
    {
        $query = "
            CREATE TABLE IF NOT EXISTS category (
                id SERIAL PRIMARY KEY,
                name VARCHAR(255) NOT NULL UNIQUE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ";

        ConsoleApp::$pdo->exec($query);
    }

    public function down(): void
    {
        $query = "DROP TABLE IF EXISTS category";
        ConsoleApp::$pdo->exec($query);
    }
}
