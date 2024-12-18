<?php

use console\ConsoleApp;

class m20241210191341_delete_column_category_id_from_table_article
{
    public function safeUp(): void
    {
        $query = "
             INSERT INTO article_category (article_id, category_id)
            SELECT id, category_id
            FROM article
            WHERE category_id IS NOT NULL;
        ";

        ConsoleApp::$pdo->exec($query);
        $query = "ALTER TABLE article DROP CONSTRAINT IF EXISTS fk_articles_category";
        ConsoleApp::$pdo->exec($query);

        $query = "ALTER TABLE article DROP COLUMN category_id";
        ConsoleApp::$pdo->exec($query);
    }

    public function safeDown(): void
    {
        $query = "ALTER TABLE article ADD COLUMN category_id INT NULL;";
        ConsoleApp::$pdo->exec($query);

        $query = "
            ALTER TABLE article
            ADD CONSTRAINT fk_articles_category
            FOREIGN KEY (category_id) REFERENCES category (id)
            ON DELETE SET NULL;
        ";
        ConsoleApp::$pdo->exec($query);
    }
}
