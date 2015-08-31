<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Categories;
use yii\helpers\ArrayHelper;
?>

<div class="songs-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($song, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($song, 'text')->textarea(['rows' => 6]) ?>

    <?php
    $categories = Categories::find()->all();
    $items = ArrayHelper::map($categories, 'id', 'name');
    ?>

    <?= $form->field($song, 'songsCategories')->checkboxList($items); ?>

    <div class="form-group">
        <?= Html::submitButton($song->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $song->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>