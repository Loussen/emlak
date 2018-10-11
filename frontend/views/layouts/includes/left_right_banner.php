<?php
$random_banner=rand(1,1);
?>
<div class="banner-left">
	<?php
	$banners=$this->context->banners[3]["text_".Yii::$app->language]; $banners=explode('***',$banners); array_filter($banners); $rand=rand(0,count($banners)-1);
	if($random_banner==1) echo $banners[$rand];
?>
    <?php //echo $this->context->banners[3]["text_".Yii::$app->language]; ?>
</div>
<div class="banner-right">
	<?php
	$banners=$this->context->banners[4]["text_".Yii::$app->language]; $banners=explode('***',$banners); array_filter($banners);
	if($random_banner==1) echo $banners[$rand];
	?>
    <?php //echo $this->context->banners[4]["text_".Yii::$app->language]; ?>
</div>

<?php if($random_banner==2) { ?>
<script type='text/javascript'><!--//<![CDATA[
var m3_u = (location.protocol=='https:'?'https://ads2.newmedia.az/www/delivery/ajs.php':'http://ads2.newmedia.az/www/delivery/ajs.php');
var m3_r = Math.floor(Math.random()*99999999999);
if (!document.MAX_used) document.MAX_used = ',';
document.write ("<scr"+"ipt type='text/javascript' src='"+m3_u);
document.write ("?videowidth=720&amp;videoheight=auto&amp;zoneid=616");
document.write ('&amp;cb=' + m3_r);
if (document.MAX_used != ',') document.write ("&amp;exclude=" + document.MAX_used);
document.write (document.charset ? '&amp;charset='+document.charset : (document.characterSet ? '&amp;charset='+document.characterSet : ''));
document.write ("&amp;loc=" + escape(window.location));
if (document.referrer) document.write ("&amp;referer=" + escape(document.referrer));
if (document.context) document.write ("&context=" + escape(document.context));
if (document.mmm_fo) document.write ("&amp;mmm_fo=1");
document.write ("'><\/scr"+"ipt>");
//]]>--></script><noscript><a href='http://ads2.newmedia.az/www/delivery/ck.php?n=a4b81272&amp;cb=INSERT_RANDOM_NUMBER_HERE' target='_blank'><img src='http://ads2.newmedia.az/www/delivery/avw.php?zoneid=616&amp;cb=INSERT_RANDOM_NUMBER_HERE&amp;videowidth=720&amp;videoheight=auto&amp;n=a4b81272' border='0' alt='' /></a></noscript>
<?php } ?>

<style>
.banner-left iframe, .banner-right iframe{position:fixed;}
</style>