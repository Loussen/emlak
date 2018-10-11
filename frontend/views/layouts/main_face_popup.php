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

<!-- facebook like box starts -->
<!-- popup box stylings -->
<style type="text/css">
    #fb-back { display: none; background: rgba(0,0,0,0.8);   width: 100%; height: 100%; position: fixed; top: 0;   left: 0; z-index: 99999;}
    #fb-exit { width: 100%; height: 100%; }
    .fb-box-inner { width:300px; position: relative; display:block; padding: 30px 0px 0px; margin:0 auto; text-align:center; }
    #fb-close { cursor: pointer; position: absolute; top: 5px; right: 5px; font-size: 18px; font-weight:700; color: #000; z-index: 99999; display:inline-block; line-height: 18px; height:18px;width: 18px; }
    #fb-close:hover { color:#06c; }
    #fb-box { min-width: 340px; /*min-height: 360px;*/ position: absolute; top: 50%; left: 50%; margin: -220px 0 0 -170px; -webkit-box-shadow: 0px 0px 16px #000; -moz-box-shadow: 0px 0px 16px #000; box-shadow: 0px 0px 16px #000; -webkit-border-radius: 8px;-moz-border-radius: 8px; border-radius: 8px;
        background: #fff; /* pop up box bg color */
        border-bottom: 40px solid #f0f0f0;  /* pop up bottom border color/size */
    }
    .fb-box-inner h3 { line-height: 1; margin:0 auto; text-transform:none;letter-spacing:none;
        font-size: 23px!important;  /* header size */
        color:#06c!important; /* header color */
    }
    .fb-box-inner p { line-height: 1; margin:0 auto 20px;text-transform:none;letter-spacing:none;
        font-size: 13px!important; /* header size  */
        color:#333!important; /* text color */
    }
    a.fb-link { position:relative;margin: 0 auto; display: block; text-align:center; color: #333; /* link color */
        bottom: -30px;
    }
    #fb-box h3,#fb-box p, a.fb-link { max-width:290px; padding:0; }
</style>

<!-- facebook plugin -->
<div id='fb-back'>
    <div id="fb-exit"> </div>
    <div id='fb-box'>
        <div class="fb-box-inner">
            <div id="fb-close">X</div>
            <!-- edit your popup header text here -->
            <!--				<h3>Like This Template?</h3>-->
            <!-- edit your supporting text here  -->
            <!--				<p>Show your Support. Become a <b>FAN!</b></p>-->
            <!-- edit your fb name below -->
            <iframe allowtransparency='true' frameborder='0' scrolling='no' src='//www.facebook.com/plugins/likebox.php?href=https://www.facebook.com/3w.emlak.az/&width=290&height=275&colorscheme=light&show_faces=true&border_color=%23ffffff&stream=false&header=false'style='border: 0 none; overflow: hidden; width: 290px; height: 270px;text-align:center;margin:0 auto;'></iframe>
            <!-- edit your supporting link here  -->
            <!--				<a class="fb-link" href="//YOUR_BLOG_NAME.blogspot.com">Contact Us</a>-->
        </div>
    </div>
</div>
<!-- popup plug-in snippet  -->
<script type='text/javascript'>
    //<![CDATA[
    //grab user's browser info and calculates/saves first visit
    jQuery.cookie = function (key, value, options) { if (arguments.length > 1 && String(value) !== "[object Object]") { options = jQuery.extend({}, options); if (value === null || value === undefined) { options.expires = -1; }
        if (typeof options.expires === 'number') { var days = options.expires,  t = options.expires = new Date();  t.setDate(t.getDate() + days); } value = String(value); return (document.cookie = [encodeURIComponent(key), '=', options.raw ? value : encodeURIComponent(value), options.expires ? '; expires=' + options.expires.toUTCString() : '', options.path ? '; path=' + options.path : '', options.domain ? '; domain=' + options.domain : '', options.secure ? '; secure' : ''].join('')); }
        options = value || {}; var result, decode = options.raw ? function (s) { return s; } : decodeURIComponent; return (result = new RegExp('(?:^|; )' + encodeURIComponent(key) + '=([^;]*)').exec(document.cookie)) ? decode(result[1]) : null; };
    // the pop up actions
    $(function ($) {
        if ($.cookie('popup_fb') != 'yes') {
            $('#fb-back').delay(400).fadeIn("fast"); // options slow or fast
            $('#fb-close, #fb-exit').click(function () {
                $('#fb-back').stop().fadeOut("fast"); // options slow or fast
            });
        }
//initiate popup function by setting up the cookie expiring time
        $.cookie('popup_fb', 'yes', { path: '/', expires: 3 });
    });
    //]]>
</script>
<!-- facebook like box ends -->
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
    <?php if(Yii::$app->controller->id=='site' && Yii::$app->controller->action->id=='index') echo $this->render('/layouts/includes/search_blok'); ?>
    <?=$content; ?>
    <?=$this->render('/layouts/includes/footer'); ?>
    <?=$this->render('/layouts/includes/left_right_banner'); ?>
</div>
<?=$this->render('/layouts/includes/popups'); ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
