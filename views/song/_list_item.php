<?php
use app\models\Comments;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
$comments = Comments::find()->where(['song_id'=>$model->id])->count();
$createdAt = DateTime::createFromFormat('Y-m-d H:i:s', $model->created_at);
$stringCreated = $createdAt->format('F j, Y, G:i');
?>

<div class="song">
    <div class="song-header">
        <div class="actions pull-right">
            <?= Html::a(Yii::t('app', 'Edit'), Url::to(['update', 'id' => $model->id])); ?>
            <?= Html::a(Yii::t('app', 'Delete'), Url::to(['delete', 'id' => $model->id]), ['data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this song?'),
                    'method' => 'post',
                ]
            ]); ?>
        </div>
        <div class="song-title">
            <?= Html::a(Html::tag('h3', $model->title),Url::to(['view', 'id' => $model->id])); ?>
        </div>
    </div>
    <div class="song-body">
        <div class="song-text"><pre><?= HtmlPurifier::process($model->text) ?></pre></div>
    </div>
    <div class="song-footer clearfix">
        <div class="pull-left">
            <?php if($comments % 10 == 1): ?>
                <span class="song-comments"><?= Html::encode($comments . ' ') . Yii::t('app', 'comment') ?></span>
            <?php elseif(($comments % 10 == 2 || $comments % 10 == 3 || $comments % 10 == 4) && ($comments % 100 - $comments % 10 != 10)): ?>
                <span class="song-comments"><?= Html::encode($comments . ' ') . Yii::t('app', 'comments ') ?></span>
            <?php else: ?>
                <span class="song-comments"><?= Html::encode($comments . ' ') . Yii::t('app', 'comments') ?></span>
            <?php endif; ?>
        </div>
        <div class="pull-right">
            <span class="author-date"><?= Html::encode($model->author->first_name . ' ' . $model->author->last_name. ' ('. $stringCreated . ')' )  ?></span>
        </div>
    </div>

</div>
