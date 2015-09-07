<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use app\models\FavoriteSongs;
?>

<h1><?= Yii::t('app', $user->fullName)?></h1>

<div class="user-actions-list hide-sum">
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel'=> $searchModel,
    'columns' => [
        [
            'format' => 'raw',
            'attribute' => 'title',
            'label' => Yii::t('app', 'Viewed songs'),
            'value' => function ($song) {
                return Html::a("$song->title", Url::to(['song/view', 'id' => $song->id]));

            },
        ],
        [
            'label' => Yii::t('app', 'Favorite'),
            'format' => 'text',
            'value' => function ($song) use ($user) {
                $favorite_song = FavoriteSongs::find()->where(['song_id' => $song->id])->andWhere(['user_id' => $user->id])->one();
                if ($favorite_song) return '+ (' . $favorite_song->created_at . ')';
                return '-';
            }
        ],
        [
            'label' => Yii::t('app', 'Last comment from {username}', ['username' => $user->username]),
            'format' => 'raw',
            'value' => function ($song) use ($user)
            {
                $last_comment = $user->getLastComment($song->id);
                 if ($user->getLastComment($song->id)) {
                    return $last_comment->text . ' ('. $last_comment->created_at . ')' . Html::a(' ...' . Yii::t('app', 'view all comments'), Url::to(['song/view', 'id' => $song->id]));
                };
                return Yii::t('app', 'no comments from this user');
            }
        ],
    ]
]);
?>
</div>
