<?php

use console\ConsoleApp;

class m20241209080323_delete_status_from_article_table
{
    public function up(): void
    {
        $query = "ALTER TABLE article DROP COLUMN status";
        ConsoleApp::$pdo->exec($query);
    }

    public function down(): void
    {
        $query = "ALTER TABLE article ADD COLUMN status VARCHAR(255)";
        ConsoleApp::$pdo->exec($query);
    }
}