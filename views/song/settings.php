<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;


$this->title = Yii::t('app', 'Settings');
?>

<div class="songs-create">

    <h1><?= Yii::t('app', 'Create song') ?></h1>

<?= $this->render('_form', [
    'model' => $model,
]) ?>

</div>

<div class="user-list">
    <h1><?= Yii::t('app', 'User list')?></h1>

    <?= Gridview::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            [
                'format' => 'raw',
                'header' => Yii::t('app', 'Users'),
                'value' => function ($user) {
                    return Html::a("$user->username ($user->first_name $user->last_name)", Url::to(['site/user', 'id' => $user->id]));

                },
            ],
        ]
    ])?>
</div>