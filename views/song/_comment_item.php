<?php
use yii\helpers\Url;
use yii\helpers\Html;
?>

<div class="comment">
    <div class="UD">
        <?= Html::a('Delete', Url::to(['deletecomment', 'id_comment' => $model->id])); ?>
    </div>
    <div class="comment-text">
        <?= Html::encode($model->text); ?>
    </div>
    <div class="author-comment">
        <?= Html::encode($model->author->first_name . ' ' . $model->author->last_name. ' '. $model->created_at);  ?>
    </div>
    <div class="clear"></div>
</div>