<?php
use yii\helpers\Url;
use frontend\components\MyFunctionsF;

$this->title=$info["title_".Yii::$app->language];
?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/az_AZ/sdk.js#xfbml=1&version=v2.4&appId=253197984814580";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>


<div class="content clearfix">
    <div  class="prev-news"><a href="<?=Url::toRoute(Yii::$app->controller->id.'/'); ?>"> &larr; <span><?=Yii::t('app','lang31'); ?></span></a></div>
    <h2 class="main-title mtop-10"><span><?=Yii::t('app','lang3'); ?></span></h2>
    <div class="news">
        <h1 class="title"><?=$info["title_".Yii::$app->language]; ?></h1>
        <p class="date"><?=date('d.m.Y',$info["news_time"]); ?></p>
        <div class="img">
            <img src="<?=MyFunctionsF::getImageUrl().'/'.$info["thumb"]; ?>" alt="" >
        </div>
        <div class="description">
            <p>
                <?=$info["text_".Yii::$app->language]; ?>
            </p>
            <div class="bottom">
                <div style="float:left;"><div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div></div>
                <!--<ul class="soc">
                    <li><a href="/"></a></li>
                    <li><a href="/"></a></li>
                    <li><a href="/"></a></li>
                    <li><a href="/"></a></li>
                    <li><a href="/"></a></li>
                </ul>-->
                <div class="view-count">
                    <?=Yii::t('app','lang32'); ?>: <strong><?=$info["view_count"]; ?></strong>
                </div>
            </div>
        </div>
        <div class="fb-plugin">
            <div class="fb-comments" data-href="<?=$this->context->siteUrl.'/'.Yii::$app->controller->id.'/'.$info["id"];?>" data-numposts="3" data-width="900"></div>
        </div>
    </div>
</div>