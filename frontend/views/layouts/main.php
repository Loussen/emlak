<?php
use yii\helpers\Html;
use frontend\assets\AppAsset;
use frontend\assets\ElaqeAsset;
use frontend\assets\ElanVerAsset;

if(Yii::$app->controller->id=='elaqe') ElaqeAsset::register($this);
elseif(Yii::$app->controller->id=='elan-ver') ElanVerAsset::register($this);
else AppAsset::register($this);

?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<?= Html::csrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?></title>
	<meta property="fb:app_id" content="253197984814580"/>
	<meta name="google-site-verification" content="yKFYyq663aNquOlE74gEffQlfUd2i662QKGZRHczLSc" />
	<?php
	$notShow=['elanlar','view','query','seo-manual','xeberler','emlakcilar'];
	if(!in_array(Yii::$app->controller->id,$notShow)) echo '<meta name="description" content="'.$this->context->siteDescription.'" />';
	?>

	<!-- Facebook Pixel Code -->
	<script>
		!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
			n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
			n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
			t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
			document,'script','//connect.facebook.net/en_US/fbevents.js');

		fbq('init', '838218372936386');
		fbq('track', "PageView");</script>
	<noscript><img height="1" width="1" style="display:none"
				   src="https://www.facebook.com/tr?id=838218372936386&ev=PageView&noscript=1"
		/></noscript>
	<!-- End Facebook Pixel Code -->

	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
				(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-71330489-1', 'auto');
		ga('send', 'pageview');

	</script>

	<?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
<?php if(Yii::$app->controller->id=='elanlar' && Yii::$app->controller->action->id=='view') { ?>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/az_AZ/sdk.js#xfbml=1&version=v2.5&appId=250270611790127";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
	<script type="text/javascript">var switchTo5x=true;</script>
	<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
	<script type="text/javascript">stLight.options({publisher: "2259b253-6471-401c-9c44-4ad33111d31e", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
<?php } ?>



<div class="wrapper clearfix">
	<?=$this->render('/layouts/includes/top'); ?>
	<?php if((Yii::$app->controller->id=='site' && Yii::$app->controller->action->id=='index') || (Yii::$app->controller->id=='elanlar' && Yii::$app->controller->action->id=='index')) echo $this->render('/layouts/includes/search_blok'); ?>
	<?=$content; ?>
	<?=$this->render('/layouts/includes/footer'); ?>
	<?=$this->render('/layouts/includes/left_right_banner'); ?>
</div>
<?=$this->render('/layouts/includes/popups'); ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
