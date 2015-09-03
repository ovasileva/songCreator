<?php
use app\models\Comments;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
$createdAt = DateTime::createFromFormat('Y-m-d H:i:s', $model->created_at);
$stringCreated = $createdAt->format('F j, Y, G:i')
?>

<div class="song-thumb">
    <div class="song-header clearfix">
        <div class="song-title">
            <?= Yii::t('app', $model->title)?>
        </div>
    </div>
    <div class="song-body">
        <div class="song-text"><pre><?= HtmlPurifier::process($model->text) ?></pre></div>
    </div>
    <div class="song-footer clearfix">
        <div class="pull-right">
            <span class="author-date"><?= Html::encode($model->author->first_name . ' ' . $model->author->last_name. ' ('. $stringCreated . ')' )  ?></span>
        </div>
    </div>

</div>
