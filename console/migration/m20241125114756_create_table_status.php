<?php

use console\ConsoleApp;

class m20241125114756_create_table_status
{
    public function up(): void
    {
        $query = "
            CREATE TABLE IF NOT EXISTS article_status (
                id SERIAL PRIMARY KEY,
                title VARCHAR(255) NOT NULL UNIQUE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ";

        ConsoleApp::$pdo->exec($query);
    }

    public function down(): void
    {
        $query = "DROP TABLE IF EXISTS article_status";
        ConsoleApp::$pdo->exec($query);
    }
}