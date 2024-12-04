<?php

use console\ConsoleApp;

class m20241125114337_update_status_column_type
{
    public function up(): void
    {
        $query = "
            ALTER TABLE article
            ALTER COLUMN status TYPE INTEGER USING status::INTEGER
        ";

        ConsoleApp::$pdo->exec($query);
    }

    public function down(): void
    {
        $query = "
            ALTER TABLE article
            ALTER COLUMN status TYPE VARCHAR(255) USING status::VARCHAR
        ";

        ConsoleApp::$pdo->exec($query);
    }
}