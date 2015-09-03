<?php
use yii\helpers\Html;

$this->title = Yii::t('app', 'Update Song: ', [
        'modelClass' => 'Songs',
    ]) . ' ' . $song->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Songs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $song->title, 'url' => ['view', 'id' => $song->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="songs-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_create_song', [
        'song' => $song,
    ]) ?>

</div>