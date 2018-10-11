<?php
use yii\helpers\Url;
use frontend\components\MyFunctionsF;
$this->title=$title;
?>
<link rel="stylesheet" href="<?=Yii::$app->homeUrl; ?>/css/fotorama.css">
<script src="<?=Yii::$app->homeUrl; ?>/js/jquery-1.10.2.min.js"></script>
<script src="<?=Yii::$app->homeUrl; ?>/js/fotorama.js"></script>
<script src="<?=Yii::$app->homeUrl; ?>/js/jquery.formstyler.js"></script>

<div class="content clearfix">
    <div class="firm_info">
        <div class="firm_image"><img src="<?=MyFunctionsF::getImageUrl().'/'.$info["logo"]; ?>" alt=""></div>
        <div class="firm_text">
            <h1><?=$info["title_".Yii::$app->language]; ?></h1>
            <span><?=$info["mobile"]; ?></span>
        </div>
        <?php /*<div class="firm_text" style="margin-left: 37px;font-size: 17px;color: #b56d10;">Baxış sayı: <b><?=$info["view_count"]?></b></div> */ ?>
        <a href="#" class="email-tr"><?=Yii::t('app','lang221'); ?></a>
    </div>
    <div style="display: flow-root; font-size: 15px; margin-top: 45px;">
        <div style="float: left; font-weight: bold;">
            <img src="http://emlak.az/images/ico/arrow.png" align="middle" style="margin-right: 5px;" />
            <a href="<?=Url::to(['/yasayis-kompleksleri'])?>" style="color: #555;">YAŞAYIŞ KOMPLEKSLƏRİ səhifəsinə qayıt</a>
        </div>
        <div style="float: right; color: #555; font-weight: 500;">
            <span>Baxış sayı: <b><?=$info["view_count"]?></b></span>
        </div>
    </div>
    <h2 class="main-title orange_title"><span><?=Yii::t('app','lang222'); ?></span></h2>
    <div class="centered_text"><?=$info["about_project_".Yii::$app->language]; ?></div>
    <div class="big_slider">
        <ul class="social_icons_set">
            <li><span class='st_facebook_large' displayText='Facebook'></span></li>
            <li><span class='st_twitter_large' displayText='Tweet'></span></li>
            <li><span class='st_googleplus_large' displayText='Google +'></span></span></li>
            <li><span class='st_email_large' displayText='Email'></span></li>
            <li><span class='st_print_large' displayText='Print'></span></li>
            <li><span class='st_sharethis_large' displayText='ShareThis'></span></li>
        </ul>
        <div class="fotorama edit_img_css" data-width="700" data-height="520" data-loop="true" data-nav="thumbs" data-thumbheight="108" data-thumbwidth="138" data-fit="contain">
            <?php
            foreach($images as $image)
            {
                if(is_file(MyFunctionsF::getImagePath().'/'.$image["image"])){
                    echo '<a href="'.MyFunctionsF::getImageUrl().'/'.$image["image"].'"><img src="'.MyFunctionsF::getImageUrl().'/'.$image["image"].'" alt=""/></a>';
                }
            }
            ?>
        </div>
    </div>
    <h2 class="main-title orange_title"><span><?=Yii::t('app','lang227'); ?></span></h2>
    <div class="big_slider">
        <div class="fotorama" data-width="700" data-height="520" data-loop="true" data-nav="thumbs" data-thumbheight="108" data-thumbwidth="138" data-fit="none">
            <?php
            foreach($images2 as $image)
            {
                if(is_file(MyFunctionsF::getImagePath().'/'.$image["image"])){
                    echo '<a href="'.MyFunctionsF::getImageUrl().'/'.$image["image"].'"><img src="'.MyFunctionsF::getImageUrl().'/'.$image["image"].'" alt=""/></a>';
                }
            }
            ?>
        </div>
    </div>
    <h2 class="main-title orange_title"><span><?=Yii::t('app','lang223'); ?></span></h2>
    <div class="centered_text"><?=$info["about_company_".Yii::$app->language]; ?></div>
    <h2 class="main-title orange_title to_top"><span><?=Yii::t('app','lang228'); ?></span></h2>
    <div class="firm_location">
        <iframe src="https://www.google.com/maps/embed/v1/place?q=<?=$info["google_map"];?>&key=AIzaSyD3qS8H5B9QsvMJH_CPOR0Sflu0Pyh8MT0" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD3qS8H5B9QsvMJH_CPOR0Sflu0Pyh8MT0&callback=initMap"
                type="text/javascript"></script>
    </div>
    <h2 class="main-title orange_title to_top"><span><?=Yii::t('app','lang224'); ?></span></h2>
    <p class="small_title alert_text"><?=Yii::t('app','lang225'); ?></p>
    <p class="small_title alert alert-success success1" style="display: none;"><?=Yii::t('app','lang229'); ?></p>
    <p class="small_title alert alert-danger error1" style="display: none;"><?=Yii::t('app','lang27'); ?></p>
    <div class="details_wrap">
        <label class="ad">
            <span><?=Yii::t('app','lang41'); ?></span>
            <input type="text" name="ad" id="ad" />
        </label>
        <label class="prefix">
            <span><?=Yii::t('app','lang42'); ?></span>
            <select name="operator" id="operator" class="prefix_number">
                <option value="050">050</option>
                <option value="051">051</option>
                <option value="055">055</option>
                <option value="070">070</option>
                <option value="077">077</option>
                <option value="012">012</option>
                <option value="018">018</option>
            </select>
        </label>
        <label class="phone">
            <span></span>
            <input type="text" name="telefon" id="telefon" />
        </label>
        <div class="buutt"><button id="etrafli_submit" type="button" class="green_button"><?=Yii::t('app','lang48'); ?></button></div>
    </div>
</div>



<div class="popup subscription email-sb">
    <div class="popup-main">
        <a href="/" class="close"></a>
        <div class="title">
            <div class="title-h3"><?=Yii::t('app','lang221'); ?></div>
            <p class="dostuna_gonder_text" style="margin-bottom: 10px;"><?=Yii::t('app','lang226'); ?></p>
            <p class="small_title alert alert-success success2" style="display: none;"><?=Yii::t('app','lang229'); ?></p>
            <p class="small_title alert alert-danger danger2" style="display: none;"><?=Yii::t('app','lang230'); ?></p>
        </div>
        <form action="" method="post" id="dostuna_gonder_form">
            <label>
                <input type="text" placeholder="<?=Yii::t('app','lang12'); ?>" name="email" id="email">
            </label>
        </form>
        <div class="submit-btn"><button id="dostuna_gonder_submit" type="button" class=""><?=Yii::t('app','lang24'); ?></button></div>
    </div>
</div>

<script>
    $(function () {
        $("#etrafli_submit").click(function()
        {
            var baseurl=$("#baseurl").val();
            var ad=$("#ad").val();
            var operator=$("#operator").val();
            var telefon=$("#telefon").val();
            $.post(baseurl+"/yasayis-kompleksleri/etrafli_melumat_al",{ad:ad,operator:operator,telefon:telefon},function(data)
            {
                if(data=='ok'){
                    $(".success1").show('fast');
                    $(".alert_text").hide('fast');
                    $(".details_wrap").hide('fast');
                    $(".error1").hide('fast');
                    $("#ad").val('');
                    $("#telefon").val('');
                    return false;
                }
                else{
                    $(".success1").hide('fast');
                    $(".error1").show('fast');
                    $(".alert_text").hide('fast');
                    return false;
                }
            });
        });


        $("#dostuna_gonder_submit").click(function()
        {
            var baseurl=$("#baseurl").val();
            var email=$("#email").val();
            $.post(baseurl+"/yasayis-kompleksleri/dostuna_gonder",{email:email},function(data)
            {
                if(data=='ok'){
                    $(".success2").show('fast');
                    $(".danger2").hide('fast');
                    $("#dostuna_gonder_submit").hide('fast');
                    $("#dostuna_gonder_form").hide('fast');
                    $("#email").val('');
                }
                else{
                    $(".success2").hide('fast');
                    $(".danger2").show('fast');
                }
            });
        });

    });
</script>