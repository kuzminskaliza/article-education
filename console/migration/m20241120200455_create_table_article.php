<?php

use console\ConsoleApp;

class m20241120200455_create_table_article
{
    public function up(): void
    {
        $query = "
            CREATE TABLE IF NOT EXISTS article (
                id SERIAL PRIMARY KEY,
                title VARCHAR(255),
                status VARCHAR(255),
                description TEXT,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ";

        ConsoleApp::$pdo->exec($query);

    }

    public function down(): void
    {
        $query = "DROP TABLE IF EXISTS article";

        ConsoleApp::$pdo->exec($query);

    }
}