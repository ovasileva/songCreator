<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\helpers\Url;
use app\models\Songs;
use yii\widgets\ListView;
use yii\helpers\HtmlPurifier;

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Songs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="songs-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
        //var_dump(implode(', ', $model->categories));
        if(!Yii::$app->user->identity->getFavoriteSong($model->id))
        echo Html::a(Yii::t('app', 'Add to Favorites'), Url::to(['addfavorite', 'id' => $model->id]));
        else echo Html::a(Yii::t('app', 'Delete from Favorites'), Url::to(['deletefavorite', 'id' => $model->id]));
        ?>

        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
        <div class="song-text"><?= Yii::t('app', Html::encode($model->text)) ?></div>
    </div>
    <div class="song-footer clearfix">
        <div class="pull-right">
            <span class="author-date"><?= Html::encode($model->author->first_name . ' ' . $model->author->last_name. ' ('. $stringCreated . ')' )  ?></span>
        </div>
    </div>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'text:ntext',
            'created_at',
            'author.first_name',
            'categories',
        ],
    ]) ?>

</div>

<div class="comments">

    <h4><?= Html::encode('Comments') ?></h4>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'text:ntext',
            'author.first_name',
            'created_at',
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons'=>[
                    'delete' => function ($url, $model, $key) {
                        return Html::a(Yii::t('app', 'Delete'),  Url::to(['song/deletecomment', 'id_comment' => $key]), [
                            'data' => [
                                'confirm' => Yii::t('app', 'Are you sure you want to delete this comment?'),
                                'method' => 'post',
                            ]
                        ]);
                    }
                ],
            ],
        ],
    ]);
    ?>

    <?=
    $this->render('_comments', [
        'model_comments' => $model_comments,
    ]) ?>

</div>