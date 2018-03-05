<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * Класс для регистрации пользователей
 */
class SignupForm extends Model
{
    /**
     * @var string $username Имя пользователя
     */
    public $username;
    /**
     * @var string $password Пароль пользователя
     */
    public $password;

    /**
     * @var string $email Электронная почта пользователя
     */
    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Авторизация
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {

        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateActivationKey();
        return $user->save() ? $user : null;
    }

}