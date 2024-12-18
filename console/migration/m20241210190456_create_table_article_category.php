<?php

use console\ConsoleApp;

class m20241210190456_create_table_article_category
{
    public function safeUp(): void
    {
        $query = "
            CREATE TABLE IF NOT EXISTS article_category (
                article_id INT NOT NULL,
                category_id INT NOT NULL,
                PRIMARY KEY (article_id, category_id),
                FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE,
                FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE
            )
        ";

        ConsoleApp::$pdo->exec($query);
    }

    public function safeDown(): void
    {
        $query = "DROP TABLE IF EXISTS article_category";
        ConsoleApp::$pdo->exec($query);
    }
}
