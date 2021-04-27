<?php


class m0004_add_task_status_to_tasks_table
{
    public function up()
    {
        $db = \app\core\Application::$app->db;
        $db->pdo->exec("ALTER TABLE tasks ADD COLUMN is_completed BOOLEAN DEFAULT false");

        // Insert sample data to db
        $sql = "INSERT INTO tasks (`name`, `email`, `title`, `description`, `is_completed`) VALUES
            ('David Deacon', 'daviddeacon@mail.com', 'Some random task', 'long task description here', false),
            ('David Deacon', 'daviddeacon@mail.com', 'random random task', 'long task description here', true),
            ('David Deacon', 'adaviddeacon@mail.com', 'Some random task', 'long task description here', false),
            ('David Deacon', 'daviddeacon@mail.com', 'Some random task', 'long task description here', false),
            ('Deacon Deacon', 'daviddeacon@mail.com', 'Some random task', 'long task description here', false),
            ('David Deacon', 'daviddeacon@mail.com', 'Some random task', 'long task description here', false),
            ('David Deacon', 'daviddeacon@mail.com', 'Some random task', 'long task description here', true),
            ('David Deacon', 'daviddeacon@mail.com', 'Some random task', 'long task description here', false),
            ('David Deacon', 'adaviddeacon@mail.com', 'Some random task', 'long task description here', false),
            ('David Deacon', 'daviddeacon@mail.com', 'Some random task', 'long task description here', true),
            ('Deacon David', 'daviddeacon@mail.com', 'Some random task', 'long task description here', false),
            ('David Deacon', 'zdaviddeacon@mail.com', 'Some random task', 'long task description here', false),
            ('David Deacon', 'daviddeacon@mail.com', 'Some random task', 'long task description here', false)
        ";

        $db->pdo->exec($sql);
    }

    public function down()
    {
        $db = \app\core\Application::$app->db;
        $db->pdo->exec("ALTER TABLE tasks DROP COLUMN is_completed");
    }
}