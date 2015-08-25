<?php
use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\ListView;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Songs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="songs-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Song'), Url::to(['create']), ['class' => 'btn btn-success']) ?>
    </p>

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