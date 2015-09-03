<?php
use yii\helpers\Url;
use yii\helpers\Html;

$createdAt = DateTime::createFromFormat('Y-m-d H:i:s', $model->created_at);
$stringCreated = $createdAt->format('F j, Y, G:i');
?>

<div class="comment">
    <div class="comment-text">
        <?= Html::encode($model->text); ?>
    </div>
    <div class="UD-comment">
        <?= (Yii::$app->user->id === $model->author->id) ? Html::a(Yii::t('app', 'Delete'), Url::to(['deletecomment', 'id_comment' => $model->id]), ['data' => [
            'confirm' => Yii::t('app', 'Are you sure you want to delete this comment?'),
            'method' => 'post',
        ]
        ]) : false; ?>
    </div>
    <div class="author-comment">
        <?= Html::encode($model->author->first_name . ' ' . $model->author->last_name. ' ('. $stringCreated) . ')' ?>
    </div>
    <div class="clear"></div>
</div>