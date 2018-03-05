<?php

namespace app\models;

use yii\base\Model;
use Yii;

/**
 * Класс для отправки письма активации
 */
class ProfileActivation extends Model
{

    public $email;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => '\app\models\User',
                'filter' => ['status' => User::STATUS_NOT_ACTIVE],
                'message' => 'There is no user with such email.'
            ],
        ];
    }

    /**
     * Отправка письма для активации
     */
    public function sendEmail()
    {
        $user = User::findOne(['email' => $this->email, 'status' => User::STATUS_NOT_ACTIVE]);
        if(!$user){
            return false;
        }
        return Yii::$app->mailer->compose(
            ['html' => 'activationMail'],
            ['user' => $user])
            ->setTo($user->email)
            ->setFrom(Yii::$app->params['supportEmail'])
            ->setSubject('Activation')
            ->send();
    }
}