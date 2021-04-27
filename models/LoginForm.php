<?php


namespace app\models;


use app\core\Application;
use app\core\Model;

class LoginForm extends Model
{
    public string $email = '';
    public string $password = '';

    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED],
            'password'  => [self::RULE_REQUIRED]
        ];
    }

    public function login()
    {
        $user = (new User)->findOne(['email' => $this->email]);

        if (!$user) {
            $this->addError('email', 'User does not exist with this email');
            return false;
        }

        if (!password_verify( $this->password, $user->password)) {
            $this->addError('password', 'Password is incorrect');
            return false;
        }

        return Application::$app->login($user);
    }

    public function labels(): array
    {
        return [
            'email' => 'Login',
            'password'  => 'Password'
        ];
    }
}