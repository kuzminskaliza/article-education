<?php

use console\ConsoleApp;

class m20241127143829_add_category_id_to_article
{
    public function up(): void
    {
        $query = "
            ALTER TABLE article
            ADD COLUMN category_id INT
        ";
        ConsoleApp::$pdo->exec($query);
    }

    public function down(): void
    {
        $query = "
            ALTER TABLE article
            DROP COLUMN IF EXISTS category_id
        ";
        ConsoleApp::$pdo->exec($query);
    }
}