<?php
use frontend\components\MyFunctionsF;
use backend\models\Users;
$info=$this->context->getPagesInfo(14);
//Yii::$app->homeUrl='http://kiraye-evler.az';
Yii::$app->homeUrl='https://emlak.az';
?>
<input type="hidden" value="<?=Yii::$app->homeUrl; ?>" id="baseurl" />
<div class="popup-overlay"></div>

<div class="popup reg">
    <?php
    echo '<img id="loading_gif1" class="hide" src="'.MyFunctionsF::getImageUrl().'/loading.gif" />';
    echo '<div class="alert-danger alert hide" style="font-weight: bold;"></div>';
    echo '<div class="alert-success alert hide" style="font-weight: bold;"></div>';
    ?>
    <div class="popup-main">
        <a href="javascript:void(0);" class="close"></a>
        <div class="title" style="margin: 14px;text-align: center;"><?=Yii::t('app','lang15'); ?></div>
        <div class="fb-panel">
            <a href="/" style="display:none;"><i></i><?=Yii::t('app','lang69'); ?></a>
        </div>
        <form action="" method="post" id="profil_reg_form" enctype="multipart/form-data">
            <div class="form_of_order_add">
                <div class="pull-left">
                    <label><span><sup>*</sup> <?=Yii::t('app','lang11'); ?></span><input name="reg_name" id="reg_name" type='text' value="<?=Yii::$app->session["f2_name"]; ?>" required></label>
                    <label><span><sup>*</sup> <?=Yii::t('app','lang12'); ?></span><input name="reg_email" id="reg_email" value="<?=Yii::$app->session["f2_email"]; ?>" type='email' required></label>
                    <label><span><sup>*</sup> <?=Yii::t('app','lang70'); ?></span><input name="reg_sifre" id="reg_sifre" type="password" required></label>
                    <label><span><sup>*</sup> <?=Yii::t('app','lang71'); ?></span><input name="reg_sifre_tekrar"  id="reg_sifre_tekrar" type="password" required></label>
                    <label><span class="en-info"><?=Yii::t('app','lang72'); ?> <a href="javascript:void(0);" class="istifade_sertleri"><?=Yii::t('app','lang73'); ?></a> <?=Yii::t('app','lang47'); ?></span></label>
                    <label><span class="en-info checked"><input <?php if(Yii::$app->session["f2_newsletter"]==1) echo 'checked="checked"'; ?> name="reg_newsletter" id="reg_newsletter" type="checkbox" value="1" ><?=Yii::t('app','lang74'); ?></span></label>
                    <label class="submit-label"><input id="submit_button" name="reg_submit" type="submit" value="<?=Yii::t('app','lang48'); ?>" ></label>
                    <input type="hidden" value="0" id="submit_check" />
                </div>
                <div class="pull-right">
                        <p><img id="profil_reg_img" src="<?=MyFunctionsF::getImageUrl(); ?>/unknow_man.jpg" alt="" ></p>
                        <img id="loading_gif" style="margin-left: 70px;margin-bottom: 8px;" class="hide" src="<?=MyFunctionsF::getImageUrl(); ?>/loading.gif" />
                        <button type="button" class="reg_sekli_deyis"><?=Yii::t('app','lang96'); ?></button>
                        <input name="profil_reg_img" type="file" class="inp-file-reg hide" id="file_input_image">
                        <span id="error_image_upload"><?=Yii::t('app','lang132'); ?></span>
                        <p><?=Yii::t('app','lang76'); ?> <?=Users::THUMB_IMAGE_WIDTH.'x'.Users::THUMB_IMAGE_HEIGHT; ?><?=Yii::t('app','lang77'); ?>. <?=Yii::t('app','lang78'); ?></p>
                </div>
            </div>
            <div class="rules_of_order_add" style="padding:15px;font-size:14px;margin:0px;display:none;height: 370px;overflow-y: auto;">
                <label class="submit-label entry-links"><input style="margin-left: 0px;margin-bottom:10px;padding: 3px 10px 3px 10px;" name="order_add_submit" type="button" value="&laquo; <?=Yii::t('app','lang37'); ?>"></label>
                <div class="clear"></div>
                <?=$info["text_".Yii::$app->language]; ?>
            </div>
        </form>
    </div>
</div>



<div class="popup entry">
    <?php
    echo '<img id="loading_gif2" class="hide" src="'.MyFunctionsF::getImageUrl().'/loading.gif" />';
    echo '<div class="alert-danger2 alert hide" style="font-weight: bold;margin-bottom: -46px;"></div>';
    echo '<div class="alert-success2 alert hide" style="font-weight: bold;margin-bottom: -46px;"></div>';
    ?>
    <div class="popup-main">
        <a href="javascript:void(0);" class="close"></a>
        <form action="" method="post" class="enter_form" id="enter_form">
            <div class="title" style="padding-left: 0px;float:left;"><?=Yii::t('app','lang14'); ?></div>
            <a href="javascript:void(0);" class="txt-right reg-links" style="margin-top: 37px;"><?=Yii::t('app','lang15'); ?></a>
            <label class="email-label"><input value="<?=Yii::$app->session["login_email"]; ?>" name="login_email" type="text" placeholder="<?=Yii::t('app','lang12'); ?>"></label>
            <label class="psw-label"><input value="" name="login_pass" type="password" placeholder="<?=Yii::t('app','lang70'); ?>"></label>
            <label class="submit-label"><input name="enter_submit" type="submit" value="<?=Yii::t('app','lang48'); ?>" ></label><a href="javascript:void(0);" class="txt-right show_forgot_form"><?=Yii::t('app','lang89'); ?></a>
        </form>

        <form action="" method="post" class="forgot_form" style="display:none;" id="forgot_form">
            <div class="title" style="padding-left: 0px;"><?=Yii::t('app','lang90'); ?></div>
            <label class="email-label"><input name="forgot_email" id="forgot_email" type="text" placeholder="<?=Yii::t('app','lang12'); ?>"></label>
            <label class="submit-label"><input name="forgot_submit" type="submit" value="<?=Yii::t('app','lang48'); ?>" ></label><a href="javascript:void(0);" class="txt-right show_enter_form"><?=Yii::t('app','lang37'); ?></a>
        </form>

        <div class="success_form hide">
            <div class="title" style="padding-left: 30px;"><?=Yii::t('app','lang90'); ?></div>
            <p class="succes"><?=Yii::t('app','lang94'); ?></p>
            <label class="submit-label"><input style="margin-left: 30px;" class="close" name="forgot_submit" type="button" value="<?=Yii::t('app','lang93'); ?>" ></label>
        </div>
    </div>
</div>


<script>
    $(function () {

        // Login Js
        $(".show_forgot_form").click(function()
        {
            $('.forgot_form').show();
            $(".enter_form").hide();
        });
        $(".show_enter_form").click(function()
        {
            $('.forgot_form').hide();
            $(".enter_form").show();
        });
        $('#enter_form').on('submit', function (e) {
            e.preventDefault();

            var baseurl=$("#baseurl").val();
            $("#loading_gif2").removeClass('hide');
            $(".alert-danger2").html();
            $(".alert-danger2").addClass('hide');
            $(".alert-success2").html();
            $(".alert-success2").addClass('hide');
            $.ajax({
                url: baseurl+"/qeydiyyat/login",
                type: "POST",
                data: new FormData(this),
                processData: false,
                cache: false,
                contentType: false,
                success: function (res) {
                    res=res.split('---');
                    $("#loading_gif2").addClass('hide');
                    if(res[0]=='success')
                    {
                        $(".alert-danger").html(); $(".alert-danger").addClass('hide');
                        $(".alert-danger2").html(); $(".alert-danger2").addClass('hide');
                        window.location = baseurl+'/profil/';
                    }
                    else
                    {
                        $(".alert-success2").html(); $(".alert-success2").addClass('hide');
                        $(".alert-danger2").html(res[1]); $(".alert-danger2").removeClass('hide');
                    }
                }
            });
        });
        //
        $('#forgot_form').on('submit', function (e) {
            e.preventDefault();
            var baseurl=$("#baseurl").val();
            var forgot_email=$("#forgot_email").val();
            $("#loading_gif2").removeClass('hide');
            $(".alert-danger2").html();
            $(".alert-danger2").addClass('hide');
            $(".alert-success2").html();
            $(".alert-success2").addClass('hide');

			
            $.ajax({
				url: baseurl+"/qeydiyyat/forgot",
                type: "POST",
                data: new FormData(this),
                processData: false,
                cache: false,
                contentType: false,
                success: function (res) {
                    res=res.split('---');
                    $("#loading_gif2").addClass('hide');
                    if(res[0]=='success')
                    {
                        $(".success_form").removeClass('hide');
                        $(".forgot_form").hide(); $(".enter_form").hide();
                        $(".alert-danger2").html(); $(".alert-danger2").hide();
                        $(".alert-danger").html(); $(".alert-danger").hide();
                    }
                    else
                    {
                        $(".alert-success2").html(); $(".alert-success2").addClass('hide');
                        $(".alert-danger").html(); $(".alert-danger").addClass('hide');
                        $(".alert-danger2").html(res[1]); $(".alert-danger2").removeClass('hide');
                    }
                }
            });
        });


        // Reg Js
        $(".istifade_sertleri").click(function()
        {
            $('.rules_of_order_add').show();
            $(".form_of_order_add").hide();
        });
        $(".rules_of_order_add .entry-links").click(function()
        {
            $('.rules_of_order_add').hide();
            $(".form_of_order_add").show();
        });

        $(".reg_sekli_deyis").click(function()
        {
            $("#submit_check").val('0');
            $(this).siblings(".inp-file-reg").click();
        });
        $(".inp-file-reg").on('change',function()
        {
            var file_input_image=$("#file_input_image").val();
            if(file_input_image!='') $("#profil_reg_form").submit();
        });
        $("#submit_button").click(function()
        {
            $("#submit_check").val('1');
        });

        $('#profil_reg_form').on('submit', function (e) {
            e.preventDefault();
            var baseurl=$("#baseurl").val();
            var submit_check=$("#submit_check").val();
            var loc='qeydiyyat/index';
            if(submit_check!='1') { loc='qeydiyyat/image_temporary'; $("#loading_gif").removeClass('hide'); }
            else $("#loading_gif1").removeClass('hide');
            $(".alert-danger").html();
            $(".alert-danger").addClass('hide');
            $(".alert-success").html();
            $(".alert-success").addClass('hide');
			
			var reg_name=$("#reg_name").val();
			var reg_email=$("#reg_email").val();
			var reg_sifre=$("#reg_sifre").val();
			var reg_sifre_tekrar=$("#reg_sifre_tekrar").val();
			var reg_newsletter=$("#reg_newsletter").val();
			
			$.post(baseurl+"/qeydiyyat/index",{reg_submit:'1',reg_name:reg_name,reg_email:reg_email,reg_sifre:reg_sifre,reg_sifre_tekrar:reg_sifre_tekrar,reg_newsletter:reg_newsletter},function(res){
					res=res.split('---');
                    $("#loading_gif").addClass('hide');
                    $("#loading_gif1").addClass('hide');
                    if(res[0]=='image')
                    {
                        $("#profil_reg_img").attr('src',res[1]); $("#error_image_upload").css('display','none');
                        $("#file_input_image").val('');
                    }
                    else if(res[0]=='error_image')
                    {
                        $("#error_image_upload").css('display','block');
                        $("#file_input_image").val('');
                    }
                    else if(res[0]=='success')
                    {
                        $(".alert-success").html(res[1]); $(".alert-success").removeClass('hide');
                        $(".alert-danger2").html(); $(".alert-danger2").hide();
                        $(".alert-danger").html(); $(".alert-danger").hide();
                        window.location = baseurl+'/profil/';
                    }
                    else
                    {
                        $(".alert-success").html(); $(".alert-success").addClass('hide');
                        $(".alert-danger2").html(); $(".alert-danger2").addClass('hide');
                        $(".alert-danger").html(res[1]); $(".alert-danger").removeClass('hide');
                    }
			});
			
			
			/*
            $.ajax({
                url: baseurl+"/"+loc,
                type: "POST",
                data: new FormData(this),
                processData: false,
                cache: false,
                contentType: false,
                success: function (res) {
                    res=res.split('---');
                    $("#loading_gif").addClass('hide');
                    $("#loading_gif1").addClass('hide');
                    if(res[0]=='image')
                    {
                        $("#profil_reg_img").attr('src',res[1]); $("#error_image_upload").css('display','none');
                        $("#file_input_image").val('');
                    }
                    else if(res[0]=='error_image')
                    {
                        $("#error_image_upload").css('display','block');
                        $("#file_input_image").val('');
                    }
                    else if(res[0]=='success')
                    {
                        $(".alert-success").html(res[1]); $(".alert-success").removeClass('hide');
                        $(".alert-danger2").html(); $(".alert-danger2").hide();
                        $(".alert-danger").html(); $(".alert-danger").hide();
                        window.location = baseurl+'/profil/';
                    }
                    else
                    {
                        $(".alert-success").html(); $(".alert-success").addClass('hide');
                        $(".alert-danger2").html(); $(".alert-danger2").addClass('hide');
                        $(".alert-danger").html(res[1]); $(".alert-danger").removeClass('hide');
                    }
                }
            });
			*/
        });
        //



    });
</script>




<script type="text/javascript">
adroll_adv_id = "2GPGJWAPK5FZ7NHN3PRGNL";
adroll_pix_id = "FEIJCW323VDTRJSOTY6JCW";
adroll_email = "ali.abasov@emlak.az"; // OPTIONAL: provide email to improve user identification
(function () {
	var _onload = function(){
		if (document.readyState && !/loaded|complete/.test(document.readyState)){setTimeout(_onload, 10);return}
		if (!window.__adroll_loaded){__adroll_loaded=true;setTimeout(_onload, 50);return}
		var scr = document.createElement("script");
		var host = (("https:" == document.location.protocol) ? "https://s.adroll.com" : "http://a.adroll.com");
		scr.setAttribute('async', 'true');
		scr.type = "text/javascript";
		scr.src = host + "/j/roundtrip.js";
		((document.getElementsByTagName('head') || [null])[0] ||
			document.getElementsByTagName('script')[0].parentNode).appendChild(scr);
	};
	if (window.addEventListener) {window.addEventListener('load', _onload, false);}
	else {window.attachEvent('onload', _onload)}
}());
</script>


<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 957301311;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/957301311/?value=0&amp;guid=ON&amp;script=0"/>
</div>
</noscript>