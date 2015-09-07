<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\ListView;
use yii\helpers\Url;
use app\models\Categories;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\bootstrap\ButtonDropdown;


$this->title = Yii::t('app', 'Songs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="songs-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="selector">
        <?php $form = ActiveForm::begin(); ?>

        <?php
        $categories = Categories::find()->all();
        $items = ArrayHelper::map($categories, 'id', 'name');
        ?>

        <?= $form->field($model, 'category_id')->dropDownList($items, ['prompt' => Yii::t('app', 'All')])->label(Yii::t('app', 'Category')) ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Choose'), ['class' => 'btn btn-success']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

    <div class="song-list hide-sum"">
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => '_list_item',
    ]); ?>
    </div>

</div>