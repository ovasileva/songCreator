<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
?>

<h1><?= Yii::t('app', $user->username . ' ' . '(' . $user->first_name . ' ' . $user->last_name . ')')?></h1>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'format' => 'raw',
            'header' => Yii::t('app', 'Songs'),
            'value' => function ($song) {
                return Html::a("$song->title", Url::to(['song/view', 'id' => $song->id]));

            },
        ],
        [
            'header' => Yii::t('app', 'Viewed'),
            'format' => 'text',
            'value' => function ($song, $key, $index) use ($user) {
                $viewed_songs_id = [];
                foreach ($user->viewedSongs as $viewed_song)
                {
                    array_push($viewed_songs_id, $viewed_song->id);
                }
                if (in_array($song->id, $viewed_songs_id)) return "+";
                return "-";
            }
        ],
        [
            'header' => Yii::t('app', 'Favorite'),
            'format' => 'text',
            'value' => function ($song, $key, $index) use ($user) {
                $favorite_songs_id = [];
                foreach ($user->favoriteSongs as $favorite_song)
                {
                    array_push($favorite_songs_id, $favorite_song->id);
                }
                if (in_array($song->id, $favorite_songs_id)) return "+";
                return "-";
            }
        ],
    ]
]);
