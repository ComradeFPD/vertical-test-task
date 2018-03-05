<?php
use yii\helpers\Html;
use yii\helpers\Url;

$activationLink = Yii::$app->urlManager->createAbsoluteUrl(['site/activation', 'activation_key' => $user->activation_key]);
?>

<div class="password-reset">
    <p>Hello <?= Html::encode($user->username) ?>,</p>
    <p>Follow the link below to activate your profile:</p>
    <p><?= Html::a(Html::encode($activationLink), $activationLink)?></p>
</div>
