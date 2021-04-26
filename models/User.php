<?php
namespace app\models;

use app\core\DBModel;
use app\core\Model;
use app\core\UserModel;

/**
 * Class UserModel
 * @package app\models
 */
class User extends UserModel
{
    public string $firstname = '';
    public string $lastname = '';
    public string $email = '';
    public string $password = '';
    public string $confirmPassword = '';

    public static function tableName(): string
    {
        return 'users';
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function rules(): array
    {
        return  [
            'firstname' => [self::RULE_REQUIRED],
            'lastname'  => [self::RULE_REQUIRED],
            'email'     => [self::RULE_REQUIRED, self::RULE_EMAIL, [
                self::RULE_UNIQUE, 'class' => self::class
            ]],
            'password'  => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 6]],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
        ];
    }

    public function labels(): array
    {
        return [
            'firstname' => 'First name',
            'lastname'  => 'Last name',
            'email'     => "Email",
            'password'  => "Password",
            'confirmPassword'  => "Confirm Password"
        ];
    }

    public function save()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }

    public function attributes(): array
    {
        return [ 'firstname', 'lastname', 'email', 'password' ];
    }

    public function getDisplayName(): string
    {
        return $this->firstname. ' ' . $this->lastname;
    }
}