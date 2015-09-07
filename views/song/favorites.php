<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\models\FavoriteSongs;
?>

<div class="favorite-songs">
    <h1><?= Yii::t('app', 'My favorite songs') ?></h1>

    <div class="hide-sum">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'format' => 'raw',
                    'attribute' => 'title',
                    'label' => Yii::t('app', 'Favorite songs'),
                    'value' => function ($song) {
                        return Html::a("$song->title", Url::to(['song/view', 'id' => $song->id]));

                    },
                ],
                [
                    'label' => Yii::t('app', 'Date'),
                    'format' => 'datetime',
                    'attribute' => 'created_at',
                    'value' => function ($song) {
                        return FavoriteSongs::find()->where(['user_id' => Yii::$app->user->identity->id])->andWhere(['song_id' => $song->id])->one()->created_at;
                    }
                ],
            ]
        ]);
        ?>
    </div>
</div>

