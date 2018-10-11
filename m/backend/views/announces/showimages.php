<?php
use backend\components\MyFunctions;
?>
<b>Şəkillər:</b><hr />
<?php
$images=explode(",",$announces->images);
foreach($images as $image)
{
    $src=MyFunctions::getImageUrl().'/'.$image;
    echo '<img src="'.$src.'" height="200" style="margin-right:5px;margin-bottom:5px;float:left;" alt="" />';
}
?>
