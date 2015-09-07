<?php

/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'SongCreator');
?>
<div class="site-index">

    <div class="jumbotron">
        <h1><?= Html::encode('SongCreator') ?></h1>
        <p><?= Yii::t('app', 'Create your own songs') ?></p>

        <p><a class="btn btn-lg btn-success" href="<?= Url::to(['signup']) ?>"><?= Yii::t('app', 'Sign up') ?></a></p>
        <img src="<?= Yii::$app->request->baseUrl ?>/img/music.jpg">
    </div>
</div>
