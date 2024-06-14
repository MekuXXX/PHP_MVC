<?php

use App\Core\Application;

class m0001_initial {
    public function up()
    {
        Application::$app->db->pdo->exec("
            CREATE TABLE users (
                id SERIAL PRIMARY KEY,
                email VARCHAR(255) NOT NULL,
                first_name VARCHAR(255) NOT NULL,
                last_name VARCHAR(255) NOT NULL,
                status SMALLINT DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );");
    }

    public function down()
    {
        Application::$app->db->pdo->exec("DROP TABLE users");
    }
}