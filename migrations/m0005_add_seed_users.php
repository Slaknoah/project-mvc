<?php


class m0005_add_seed_users
{
    public function up()
    {
        $db = \app\core\Application::$app->db;
        $password = password_hash('123', PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (`firstname`, `lastname`, `email`, `password`) VALUES
        ('Admin', '', 'admin', '{$password}' ) ";
        $db->pdo->exec($sql);
    }

    public function down() {
        $db = \app\core\Application::$app->db;
        $db->pdo->exec("DELETE FROM users");
    }
}