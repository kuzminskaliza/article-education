<?php

use console\ConsoleApp;

class m20241120200500_create_table_admins
{
    public function up(): void
    {
        $query = "
            CREATE TABLE IF NOT EXISTS admin (
                id SERIAL PRIMARY KEY,
                name VARCHAR(255),
                email VARCHAR(255),
                password TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ";

        ConsoleApp::$pdo->exec($query);

    }

    public function down(): void
    {
        $query = "DROP TABLE IF EXISTS admin";

        ConsoleApp::$pdo->exec($query);

    }
}