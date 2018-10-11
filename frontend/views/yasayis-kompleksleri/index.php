<?php
use yii\helpers\Url;
use frontend\components\MyFunctionsF;
$text16=$this->context->getPagesInfo(16);
?>
<div class="content clearfix residential">
    <div class="in-panel">
        <h1 class="title"><?=Yii::t('app','lang218'); ?></h1>
        <a href="/" class="popup-trigger"><?=Yii::t('app','lang220'); ?></a>
    </div>
    <ul class="residential-list">
        <?php
        foreach($kompleksler as $row){
$url='yasayis-kompleksleri/'.$row["id"].'-'.\frontend\components\MyFunctionsF::slugGenerator($row["title_".Yii::$app->language]).'.html';
            echo '<li>
            <div class="price"><span>'.Yii::t('app','lang219').'</span>'.$row["price"].' '.Yii::t('app','lang149').'</div>
            <div class="img">
                <a href="'.Url::to($url).'">
                    <img src="'.\frontend\components\MyFunctionsF::getImageUrl().'/'.$row["thumb"].'" alt="" >
                    <h3 class="title">'.$row["title_".Yii::$app->language].'<span>'.$row["address_".Yii::$app->language].'</span>
                    </h3>
                </a>
                <div class="hidden-box">
                    <h3>'.$row["title_".Yii::$app->language].'</h3>
                    <span>'.$row["address_".Yii::$app->language].'</span>
                    <p>'.$row["short_text_".Yii::$app->language].'</p>
                    <a href="'.Url::to($url).'" class="btn">'.Yii::t('app','lang215').' &rarr;</a>
                </div>
            </div>
        </li>';
        }
        ?>
    </ul>
</div>


<div class="popup apartment">
    <div class="popup-main">
        <a href="/" class="close"></a>
        <div class="title"><?=$text16["title_".Yii::$app->language]; ?></div>
        <div class="info">
            <?=$text16["text_".Yii::$app->language]; ?>
        </div>
        <div class="phone">
            <p><img src="<?=MyFunctionsF::getImageUrl(); ?>/ico/popup-ico-1.png" alt="" ><?=$this->context->infoContact[0]["phone2"]; ?></p>
            <p><img src="<?=MyFunctionsF::getImageUrl(); ?>/ico/popup-ico-2.png" alt="" ><?=$this->context->infoContact[0]["mobile2"]; ?></p>
        </div>
        <em>
            <?=nl2br($text16["short_text_".Yii::$app->language]); ?>
        </em>
    </div>
</div>