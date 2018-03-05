<?php

namespace app\models;

use yii\base\Model;
use yii\base\InvalidParamException;

/**
 * Форма сброса пароля
 */
class ResetPasswordForm extends Model
{

    public $password;

    /**
     * @var \app\models\User
     */
    private $_user;

    /**
     * Создание модели с заданым токеном
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException Если токен пустой или некорректный
     */
    public function __construct($token, $config = [])
    {

        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Password reset token cannot be blank.');
        }

        $this->_user = User::findByPasswordResetToken($token);

        if (!$this->_user) {
            throw new InvalidParamException('Wrong password reset token.');
        }

        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Сбрасываем пароль
     *
     * @return bool возвращаем в случае успеха
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();
        return $user->save(false);
    }

}