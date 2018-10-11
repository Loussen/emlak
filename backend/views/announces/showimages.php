<?php
use backend\components\MyFunctions;
?>
<b>Şəkillər:</b><hr />
<?php
$images=explode(",",$announces->images);
foreach($images as $image)
{
    if($announces->cdn_server==1)
        $src=Yii::$app->params["cdn_".Yii::$app->params['currentCDN']]['CDNSERVER_URL']."images".'/'.$image;
    else
        $src=MyFunctions::getImageUrl().'/'.$image;

    echo '<img src="'.$src.'" height="200" style="margin-right:5px;margin-bottom:5px;float:left;" alt="" />';
}
?>
