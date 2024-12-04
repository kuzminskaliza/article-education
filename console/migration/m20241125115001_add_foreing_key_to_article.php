<?php

use console\ConsoleApp;

class m20241125115001_add_foreing_key_to_article
{
    public function up(): void
    {
        $query = "ALTER TABLE article
            ADD CONSTRAINT fk_article_status
            FOREIGN KEY (status)
            REFERENCES article_status (id)
            ON DELETE RESTRICT
            ON UPDATE CASCADE";

        ConsoleApp::$pdo->exec($query);
    }

    public function down(): void
    {
        $query = "ALTER TABLE article DROP CONSTRAINT IF EXISTS fk_article_status";

        ConsoleApp::$pdo->exec($query);
    }
}