<?php

use console\ConsoleApp;

class m20250115142708_add_columns_to_admins
{
    public function safeUp(): void
    {
        $query = "ALTER TABLE admin ADD COLUMN photo Varchar(255)";
        ConsoleApp::$pdo->exec($query);
    }

    public function safeDown(): void
    {
        $query = "ALTER TABLE admin DROP COLUMN IF EXISTS photo";
        ConsoleApp::$pdo->exec($query);
    }
}
