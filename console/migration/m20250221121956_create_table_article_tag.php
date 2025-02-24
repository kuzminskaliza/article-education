<?php

use console\ConsoleApp;

class m20250221121956_create_table_article_tag
{
    public function safeUp(): void
    {
        $query = "CREATE TABLE IF NOT EXISTS article_tag (
                id SERIAL PRIMARY KEY,
                article_id INT NOT NULL,
                title VARCHAR(50) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE
            )
        ";

        ConsoleApp::$pdo->exec($query);

        $query = "CREATE INDEX idx_article_id ON article_tag (article_id)";
        ConsoleApp::$pdo->exec($query);

    }

    public function safeDown(): void
    {
        $query = "DROP TABLE IF EXISTS article_tag";
        ConsoleApp::$pdo->exec($query);
    }
}
