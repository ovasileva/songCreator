<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\widgets\WLang;
use app\models\Lang;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'SongCreator',
        //'brandUrl' => Yii::$app->homeUrl,
        'brandUrl' => '/' . Lang::getCurrent()->url,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => Yii::t('app', 'Home'), 'url' => ['/site/index']],
            (!Yii::$app->user->isGuest) ?
                ['label' => Yii::t('app', 'Favorites'), 'url' => ['/song/favorites', 'user_id' => Yii::$app->user->identity->id]] :
                ['label' => '', 'visible' => false],

            (!Yii::$app->user->isGuest && Yii::$app->user->identity->role == 'admin') ?
                ['label' => Yii::t('app', 'Settings'), 'url' => ['/song/settings'], 'visible' => true] :
                ['label' => Yii::t('app', 'Settings'), 'url' => ['/song/settings'], 'visible' => false],

            Yii::$app->user->isGuest ?
                ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']] :
                [
                    'label' => Yii::t('app', 'Logout') . ' (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ],


        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'homeLink' => ['label' => Yii::t('app', 'Home'), 'url' => '/' . Lang::getCurrent()->url],
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <?= WLang::widget();?>
        <p class="pull-left">&copy; SongCreator <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
