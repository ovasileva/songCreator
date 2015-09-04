<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
?>

<h1><?= Yii::t('app', $user->username . ' ' . '(' . $user->first_name . ' ' . $user->last_name . ')')?></h1>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'format' => 'raw',
            'attribute' => 'viewedSongs',
            'label' => Yii::t('app', 'Viewed songs'),
            'value' => function ($song) {
                return Html::a("$song->title", Url::to(['song/view', 'id' => $song->id]));

            },
        ],
        /*[
            'header' => Yii::t('app', 'Viewed'),
            'format' => 'text',
            'value' => function ($song, $key, $index) use ($user) {
                foreach ($user->viewedSongs as $viewed_song)
                {
                    if ($song->id == $viewed_song->id) return '+';
                }
                return "-";
            }
        ],*/
        [
            'label' => Yii::t('app', 'Favorite'),
            'format' => 'text',
            'value' => function ($song, $key, $index) use ($user) {
                $favorite_song = $user->getFavoriteSong($song->id);
                if ($favorite_song) return '+ (' . $favorite_song->created_at . ')';
                return '-';
            }
        ],
        [
            'label' => Yii::t('app', 'Last comment from {username}', ['username' => $user->username]),
            'format' => 'raw',
            'value' => function ($song) use ($user)
            {
                if ($user->getLastComment($song->id)) {
                    return $user->getLastComment($song->id)->text . Html::a(' ...' . Yii::t('app', 'view all comments'), Url::to(['song/view', 'id' => $song->id]));
                };
                return Yii::t('app', 'no comments from this user');
            }
        ],
    ]
]);
