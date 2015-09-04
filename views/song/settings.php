<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\bootstrap\Progress;
use yii\bootstrap\NavBar;
use yii\bootstrap\Dropdown;
use app\models\UsersSearch;


$this->title = Yii::t('app', 'Settings');
?>

<div class="songs-create">

    <h1><?= Yii::t('app', 'Create song') ?></h1>

<?= $this->render('_create_song', [
    'song' => $song,
]) ?>

</div>

<div class="category-create">

    <h1><?= Yii::t('app', 'Create category')?></h1>

    <?= $this->render('_create_category', ['category' => $category])?>
</div>

<div class="user-list">

    <h1><?= Yii::t('app', 'User list')?></h1>

    <?= Gridview::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'format' => 'raw',
                'attribute' => 'fullName',
                'label' => Yii::t('app', 'Users'),
                'value' => function ($user) {
                    return Html::a($user->fullName, Url::to(['site/user', 'id' => $user->id]));

                },
            ],
            //'fullName',
        ]
    ])?>

</div>