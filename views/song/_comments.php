<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="songs-comments">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model_comments, Yii::t('app', 'text'))->textarea(['rows' => 6, 'placeholder' => 'Enter your comment here'])?>

    <?= $form->field($model_comments, Yii::t('app', 'song_id'))->hiddenInput()->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Send'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>