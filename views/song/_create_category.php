<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Categories;
use yii\helpers\ArrayHelper;
?>

<div class="songs-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($category, 'name')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($category->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $category->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>