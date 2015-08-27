<?php
use app\models\Comments;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
$comments = Comments::find()->where(['song_id'=>$model->id])->count();
$createdAt = DateTime::createFromFormat('Y-m-d H:i:s', $model->created_at);
$stringCreated = $createdAt->format('F j, Y, G:i')
?>

<div class="song-thumb">
    <div class="song-header clearfix">
        <div class="actions pull-right">
            <?= Html::a(Yii::t('app', 'Edit'), Url::to(['update', 'id' => $model->id])); ?>
            <?= Html::a(Yii::t('app', 'Delete'), Url::to(['delete', 'id' => $model->id])); ?>
        </div>
        <div class="song-title">
            <?= Html::a(Html::tag('h3', $model->title),Url::to(['view', 'id' => $model->id])); ?>
        </div>
    </div>
    <div class="song-body">
        <div class="song-text"><?= HtmlPurifier::process($model->text) ?></div>
    </div>
    <div class="song-footer clearfix">
        <div class="pull-left">
            <?php if($comments != 1): ?>
                <span class="song-comments"><?= Html::encode($comments . ' ') . Yii::t('app', 'comments') ?></span>
            <?php else: ?>
                <span class="song-comments"><?= Html::encode($comments . ' ') . Yii::t('app', 'comment') ?></span>
            <?php endif; ?>
        </div>
        <div class="pull-right">
            <span class="author-date"><?= Html::encode($model->author->first_name . ' ' . $model->author->last_name. ' ('. $stringCreated . ')' )  ?></span>
        </div>
    </div>

</div>
