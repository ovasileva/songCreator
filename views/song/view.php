<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;


$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Songs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="songs-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <h3><?=Yii::t('app', 'Categories')?>: <?= implode(', ', $model->getCategories()->select(['name'])->asArray()->column())?></h3>

    <p>
        <?php
        if(!Yii::$app->user->identity->getFavoriteSongs()->where(['id' => $model->id])->one())
        echo Html::a(Yii::t('app', 'Add to Favorites'), Url::to(['addfavorite', 'id' => $model->id]));
        else echo Html::a(Yii::t('app', 'Delete from Favorites'), Url::to(['deletefavorite', 'id' => $model->id]));
        ?>

        <?= Html::a(Yii::t('app', 'Edit'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this song?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>


    <?php
    $createdAt = DateTime::createFromFormat('Y-m-d H:i:s', $model->created_at);
    $stringCreated = $createdAt->format('F j, Y, G:i')
    ?>

    <div class="song-header clearfix">
        <div class="song-title">
            <?= Yii::t('app', $model->title)?>
        </div>
    </div>
    <div class="song-body">
        <div class="song-text-view"><pre><?= Yii::t('app', Html::encode($model->text)) ?></pre></div>
    </div>
    <div class="song-footer clearfix">
        <div class="pull-right">
            <span class="author-date"><?= Html::encode($model->author->first_name . ' ' . $model->author->last_name. ' ('. $stringCreated . ')' )  ?></span>
        </div>
    </div>

</div>

<div class="comments hide-sum">

    <h4><?= Yii::t('app', Html::encode('Comments')) ?></h4>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => '_comment_item',
        ]);
    ?>

    <?=
    $this->render('_comments', [
        'model_comments' => $model_comments,
    ]) ?>

</div>