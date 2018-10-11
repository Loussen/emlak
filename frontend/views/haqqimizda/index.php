<?php
$this->title=Yii::t('app','pg_title1');
?>
<div class="content clearfix haqqimizda">
    <h2 class="main-title classic-margin"><span><?=$info["title_".Yii::$app->language]; ?></span></h2>
    <main class="main">
        <?=$info["text_".Yii::$app->language]; ?>
    </main>
</div>