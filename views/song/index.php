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

    <?php
//    $categories = Categories::find()->all();
//    $items = ArrayHelper::map($categories, 'id', 'name');
    ?>


    <?php $form = ActiveForm::begin(); ?>

    <?php
    $categories = Categories::find()->all();
    $items = ArrayHelper::map($categories, 'id', 'name');
    ?>


    <?= $form->field($model, 'category_id')->dropDownList($items, ['prompt' => Yii::t('app', 'All')])->label(Yii::t('app', 'Category'))?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Choose') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>


    <?php// Html::activeDropDownList($model, 'song_id', $items) ?>

    <?php //Html::activeDropDownList($model, 'song_id', $items) ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => '_list_item',
        //'pager' => ['class' => kop\y2sp\ScrollPager::className(),'negativeMargin' => 500]
//        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
//
//            'title',
//            'text',
//            'author.first_name',
//            'create_at',
//
//            ['class' => 'yii\grid\ActionColumn',
//                //'template' => '{view} {update} {delete}',
//
//                'buttons'=>[
//                    'view' => function ($url, $model, $key) {
//                        return Html::a(Yii::t('app', 'View'), Url::to(['notice/view', 'id' => $model->id, 'group_identifier' => Groups::findOne($model->group_id)->identifier]));
//
//                        },
//
//                    'update' => function ($url, $model, $group) {
//                        return Html::a(Yii::t('app', 'Update'), Url::to(['notice/update', 'id' => $model->id, 'group_identifier' => Groups::findOne($model->group_id)->identifier]));
//
//                    },
//
//                    'delete' => function ($url, $model, $group) {
//                        return Html::a(Yii::t('app', 'Delete'), Url::to(['notice/delete', 'id' => $model->id, 'group_identifier' => Groups::findOne($model->group_id)->identifier]), [
//                            //'class' => 'btn btn-danger',
//                            'data' => [
//                                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
//                                'method' => 'post',
//                            ]
//                        ]);
//                    }
//                ],
//            ],
//        ],
    ]); ?>

</div>