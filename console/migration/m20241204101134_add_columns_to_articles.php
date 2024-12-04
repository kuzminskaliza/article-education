<?php

use console\ConsoleApp;

class m20241204101134_add_columns_to_articles
{
    public function up(): void
    {
        $query = "ALTER TABLE article ADD COLUMN category_id INT";
        ConsoleApp::$pdo->exec($query);

        $query = "
            ALTER TABLE article
            ADD CONSTRAINT fk_articles_category
            FOREIGN KEY (category_id) REFERENCES category (id)
            ON DELETE SET NULL;
        ";
        ConsoleApp::$pdo->exec($query);

        $query = "ALTER TABLE article ADD COLUMN status_id INT";
        ConsoleApp::$pdo->exec($query);

        $query = "ALTER TABLE article
            ADD CONSTRAINT fk_article_status
            FOREIGN KEY (status_id)
            REFERENCES article_status (id)
            ON DELETE RESTRICT";
        ConsoleApp::$pdo->exec($query);
    }

    public function down(): void
    {
        $query = "ALTER TABLE article DROP CONSTRAINT IF EXISTS fk_articles_category";
        ConsoleApp::$pdo->exec($query);

        $query = "ALTER TABLE article DROP COLUMN IF EXISTS category_id";
        ConsoleApp::$pdo->exec($query);

        $query = "ALTER TABLE article DROP CONSTRAINT IF EXISTS fk_article_status";
        ConsoleApp::$pdo->exec($query);

        $query = "ALTER TABLE article DROP COLUMN IF EXISTS status_id";
        ConsoleApp::$pdo->exec($query);
    }
}