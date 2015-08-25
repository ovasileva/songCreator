<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = Html::encode('SongCreator') . Yii::t('app', 'Sign up');
?>

<div class='site-login'>
    <h1><?= Yii::t('app', 'Sign up') ?></h1>

    <?php
        $form = ActiveForm::begin([
            'id' => 'login-form',
            'options' => ['class' => 'form-horizontal'],
            'fieldConfig' => [
                'labelOptions' => ['class' => 'control-label'],
            ],
        ])
    ?>

    <?= $form->field($model, Yii::t('app', 'username')) ?>
    <?= $form->field($model, 'email') ?>
    <?= $form->field($model, 'first_name') ?>
    <?= $form->field($model, 'last_name') ?>
    <?= $form->field($model, Yii::t('app', 'password'))->passwordInput() ?>
    <?= $form->field($model, Yii::t('app', 'repeat_password'))->passwordInput() ?>


    <div class="form-group sign-block">
        <?= Html::submitButton(Yii::t('app', 'Create account'), ['class' => 'btn btn-primary login-button']) ?>
    </div>

    <?php ActiveForm::end() ?>

</div>


