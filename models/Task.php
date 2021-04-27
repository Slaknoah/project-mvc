<?php


namespace app\models;


use app\core\DBModel;

class Task extends DBModel
{
    public string $email = '';
    public string $name = '';
    public string $title = '';
    public string $description = '';
    public int $is_completed = 0;

    public static int $per_page = 3;

    public function rules(): array
    {
        return [
            'name'  => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'title' => [self::RULE_REQUIRED]
        ];
    }

    public function labels(): array
    {
        return  [
            'name' => 'User name',
            'email'=> 'Email',
            'title'=> 'Task title',
            'description' => 'Task description',
            'is_completed' => 'Status(completed) '
        ];
    }

    public static function tableName(): string
    {
        return 'tasks';
    }

    public function attributes(): array
    {
        return ['name', 'email', 'title', 'description', 'is_completed'];
    }

    public static function primaryKey(): string
    {
        return 'id';
    }
}