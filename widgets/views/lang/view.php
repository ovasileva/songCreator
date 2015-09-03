<?php
use yii\helpers\Html;
?>
<div id="lang">
    <span id="current-lang">
        <?= $current->name;?>
    </span>

    <?php foreach ($langs as $lang):?>
        <span class="item-lang">
            | <?= Html::a($lang->name, '/'.$lang->url.Yii::$app->getRequest()->getLangUrl()) ?>
        </span>
    <?php endforeach;?>
</div>