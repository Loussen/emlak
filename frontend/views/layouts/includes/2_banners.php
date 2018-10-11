<div class="tabs clearfix" style="text-align: center;">
<?php
$banners=$this->context->banners[7]["text_".Yii::$app->language]; $banners=explode('***',$banners); array_filter($banners); $banner=rand(0,count($banners));
echo '<div class="home_banner1">'.$banners[rand(0,count($banners)-1)].'</div>';

$banners=$this->context->banners[8]["text_".Yii::$app->language]; $banners=explode('***',$banners); array_filter($banners); $banner=rand(0,count($banners));
echo '<div class="home_banner2">'.$banners[rand(0,count($banners)-1)].'</div>';
?>
</div>