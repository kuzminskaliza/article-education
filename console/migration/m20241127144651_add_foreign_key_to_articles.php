<?php

use console\ConsoleApp;

class m20241127144651_add_foreign_key_to_articles
{
    public function up(): void
    {
        $query = "
            ALTER TABLE article
            ADD CONSTRAINT fk_articles_category
            FOREIGN KEY (category_id) REFERENCES categories (id)
            ON DELETE SET NULL;
        ";

        ConsoleApp::$pdo->exec($query);
    }

    public function down(): void
    {
        $query = "
            ALTER TABLE article
            DROP CONSTRAINT fk_articles_category;
        ";

        ConsoleApp::$pdo->exec($query);
    }
}