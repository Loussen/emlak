<?php
use backend\components\MyFunctions;
?>
<?php if($rotated==0){ ?>
<b>Köhnə:</b><hr />
<?php
$images=explode(",",$realAnnounces->images);
foreach($images as $image)
{
    $src=MyFunctions::getImageUrl().'/'.$image;
    echo '<img src="'.$src.'" height="200" style="margin-right:5px;margin-bottom:5px;float:left;" alt="" />';
}
?>
<div style="clear: both"></div>
<br /><hr />
<?php } ?>
<b>Yeni:</b><hr />
<?php
$images=explode(",",$editedAnnounces->images);
foreach($images as $image)
{
    $src=MyFunctions::getImageUrl().'/'.$image;
    echo '<img src="'.$src.'" height="200" style="margin-right:5px;margin-bottom:5px;float:left;" alt="" />';
}
?>
