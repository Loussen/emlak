<?php
use frontend\components\MyFunctionsF;
use backend\models\Users;
use yii\helpers\Url;
$this->title=$this->context->userInfo->name;
?>
<div class="content clearfix">
    <h2 class="main-title regulations_title"><span><?=Yii::t('app','lang83'); ?></span></h2>
    <?php if(Yii::$app->session->hasFlash('error')) echo '<div class="alert-danger alert">'.Yii::$app->session->getFlash('error').'</div>'; ?>
    <div class="regulations_wrap">
        <div class="photo_block">
            <form action="" method="post" id="profil_edit_form" enctype="multipart/form-data">
                <?php
                if(!is_file(MyFunctionsF::getImagePath().'/'.$this->context->userInfo->thumb)) $src='unknow_man.jpg';
                else $src=$this->context->userInfo->thumb;
                ?>
                <div><img id="profil_edit_img" src="<?=MyFunctionsF::getImageUrl().'/'.$src; ?>" alt="" width="160"></div>
                <img id="loading_gif" style="margin-left: 70px;margin-bottom: 8px;" class="hide" src="<?=MyFunctionsF::getImageUrl(); ?>/loading.gif" />
                <button type="button" class="sekli_deyis"><?=Yii::t('app','lang96'); ?></button>
                <input name="profil_edit_img" type="file" class="inp-file hide" id="file_input_image">
                <span id="error_image_upload"><?=Yii::t('app','lang132'); ?></span>
                <span><?=Yii::t('app','lang76'); ?> <?=Users::THUMB_IMAGE_WIDTH.'x'.Users::THUMB_IMAGE_HEIGHT; ?><?=Yii::t('app','lang77'); ?>. <?=Yii::t('app','lang78'); ?></span>
            </form>
        </div>
        <div class="regulations_block styled">
            <form action="<?=Url::toRoute(['profil/duzelis']); ?>" method="post">
                <label class="styled_line">
                    <span><?=Yii::t('app','lang11'); ?></span>
                    <input type="text" name="edit_name" value="<?=$name; ?>">
                </label>
                <label class="styled_line">
                    <span><?=Yii::t('app','lang98'); ?></span>
                    <input type="text" name="edit_login" id="login" value="<?=$login; ?>">
                    <input type="hidden" id="old_login" value="<?=$login; ?>">
                    <strong class="reg_info_text"><?=Yii::t('app','lang97'); ?></strong>
                </label>
                <div class="sites_links">
                    <span class="green" style="display: none;"><span>www.emlak.az/<span id="entered_login">a</span></span> <?=Yii::t('app','lang128'); ?></span>
                    <span class="red" style="margin-left: 0px;display: none;"><span>www.emlak.az/<span id="entered_login2">a</span></span> <?=Yii::t('app','lang129'); ?> <?=Yii::t('app','lang130'); ?></span>
                    <span class="red2" style="margin-left: 0px;display: none;"><span>www.emlak.az/<span id="entered_login3">a</span></span> <?=Yii::t('app','lang129'); ?> <?=Yii::t('app','lang131'); ?></span>
                </div>
                <label class="styled_line with_area">
                    <span><?=Yii::t('app','lang99'); ?></span>
                    <textarea name="edit_text"><?=$text; ?></textarea>
                </label>
                <label class="styled_line">
                    <span><?=Yii::t('app','lang28'); ?></span>
                    <input type="text" name="edit_address" value="<?=$address; ?>">
                </label>
                <label class="styled_line">
                    <span><?=Yii::t('app','lang42'); ?></span>
                    <input type="text" class="phone_number" name="edit_mobile1" value="<?=$mobile1; ?>">
                </label>
                <label class="styled_line <?php if($mobile2=='') echo 'hidden-phone'; ?>">
                    <span></span>
                    <input type="text" class="phone_number" name="edit_mobile2" value="<?=$mobile2; ?>">
                    <span class="delete_field"></span>
                </label>
                <label class="styled_line <?php if($mobile3=='') echo 'hidden-phone'; ?>">
                    <span></span>
                    <input type="text" class="phone_number" name="edit_mobile3" value="<?=$mobile3; ?>">
                    <span class="delete_field"></span>
                </label>
                <label class="styled_line">
                    <span></span>
                    <a href="javascript:void(0);" class="add_field" <?php if($mobile3!='') echo 'style="display:none;"'; ?>><?=Yii::t('app','lang100'); ?></a>
                </label>
                <label class="styled_line">
                    <span><?=Yii::t('app','lang12'); ?></span>
                    <input type="email" name="edit_email" value="<?=$email; ?>" placeholder="<?=$this->context->infoContact[0]["email"]; ?>">
                </label>
                <label class="styled_line">
                    <span><?=Yii::t('app','lang70'); ?></span>
                    <input type="text" name="edit_pass" value="" placeholder="******">
                    <strong class="reg_info_text"><?=Yii::t('app','lang126'); ?></strong>
                </label>
                <label class="styled_line">
                    <span><?=Yii::t('app','lang71'); ?></span>
                    <input type="text" name="edit_pass2" value="" placeholder="******">
                    <strong class="reg_info_text"><?=Yii::t('app','lang126'); ?></strong>
                </label>
                <div class="butt_wrap">
                    <input name="edit_submit" type="submit" value="<?=Yii::t('app','lang101'); ?>">
                </div>
            </form>
        </div><!--contacts_block-->
    </div>
</div>
<script>
    $(function () {

        $("#login").keyup(function()
        {
            var logini=$(this).val();
            var old_login=$("#old_login").val();
            var baseurl=$("#baseurl").val();

            if(logini=='') { $(".sites_links .red").hide(); $(".sites_links .green").hide(); }
            else
            {
                $.post(baseurl+"/profil/check_login",{logini:logini},function(data){
                    if(data==1) { $(".red").show(); $(".red").css('display','block'); $(".red2").hide(); $(".green").hide();  }
                    else if(data==2) { $(".red2").show(); $(".red").hide(); $(".green").hide();  }
                    else { $(".green").show(); $(".red").hide(); $(".red2").hide();  }
                    $("#entered_login").html(logini);
                    $("#entered_login2").html(logini);
                    $("#entered_login3").html(logini);
                });
            }
        });


        //add phone
        $(".add_field").click(function (e) {
            var $th = $(this);
            $th.parent().siblings(".hidden-phone").first().removeClass("hidden-phone");
            if ($('.hidden-phone').length == 0) {
                $th.hide();
            }
            e.preventDefault();
        });
        //delete phone field
        $('.delete_field').click(function () {
            $(this).parent().addClass('hidden-phone');
            $(this).parent().children('input').val('');
            if ($('.hidden-phone').length > 0) {
                $('.add_field').fadeIn();
            }
            return false;
        });
    });
</script>