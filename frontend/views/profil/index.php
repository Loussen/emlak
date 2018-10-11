<?php
use frontend\components\MyFunctionsF;
use backend\models\Users;
use yii\helpers\Url;
$this->title=$this->context->userInfo->name;
?>
<div class="content clearfix">
    <h2 class="main-title regulations_title"><span><?=Yii::t('app','lang83'); ?></span></h2>
    <div class="top_info_block">
        <?php
        if(Yii::$app->session->hasFlash('success')) echo '<div class="alert-success alert">'.Yii::$app->session->getFlash('success').'</div>';
        if(Yii::$app->session->hasFlash('danger')) echo '<div class="alert-danger alert">'.Yii::$app->session->getFlash('danger').'</div>';
        ?>
        <div class="left_panel">
            <div class="info_panel">
			<?php
			$gun=ceil(($this->context->userInfo->premium-time())/86400);	if($gun<0) $gun=0;
			?>
                <?=Yii::t('app','lang84'); ?> (<?=$gun;?>  <?=Yii::t('app','lang85'); ?>)
                <a href="javascript:void(0);" class="green_button"><?=Yii::t('app','lang86'); ?></a>
            </div>
            <div class="tabs">
                <div class="i-tab">
                    <div><?=Yii::t('app','lang246'); ?></div>
					<div style="display:none;">Portmanat</div>
                </div>
                <div class="tab-content" style="width:450px;">
                    <div class="tabs-main">
					<form action="<?=$this->context->siteUrl; ?>/payment/saveitem.php" method="post" target="rieltorPackageWindow" id="rieltorPackageForm">
						<input type="hidden" name="item" id="mobile_item" value="<?=$this->context->userInfo->id; ?>-rieltorPaket"> 
						<input type="hidden" name="lang" value="lv" >
						<select name="cardType" class="SlectBox w290">
							<option value="v" selected="selected"><?=Yii::t('app','lang247'); ?></option>
							<option value="m"><?=Yii::t('app','lang248'); ?></option>
						</select>
						<div class="row">
							<label style="margin-right: 10px;"><input type="radio" name="amount" value="<?=$this->context->packagePrices["realtor_premium1"] ?>" checked="checked" /> 1 <?=Yii::t('app','lang287'); ?> / <?=$this->context->packagePrices["realtor_premium1"] ?> <?=Yii::t('app','lang149'); ?></label>
							<label><input type="radio" name="amount" value="<?=$this->context->packagePrices["realtor_premium3"] ?>" /> 3 <?=Yii::t('app','lang287'); ?> / <?=$this->context->packagePrices["realtor_premium3"] ?> <?=Yii::t('app','lang149'); ?></label>
							<label style="margin-right: 10px;"><input type="radio" name="amount" value="<?=$this->context->packagePrices["realtor_premium6"] ?>" /> 6 <?=Yii::t('app','lang287'); ?> / <?=$this->context->packagePrices["realtor_premium6"] ?> <?=Yii::t('app','lang149'); ?></label>
						</div>
						<div class="submit-btn">
							<div>
								<button type="button" onclick="Javascript:getRieltorPackage();" name="btn_pay"><?=Yii::t('app','lang86'); ?></button>
							</div>
						</div>
					</form>
					</div>
                    <div class="tabs-main">
                        tabs 2
                    </div>
                </div>
            </div>
        </div>
        <div class="right_panel">
            <div class="info_panel">
                <?=$this->context->userInfo->package_announce; ?> <?=Yii::t('app','lang87'); ?>
                <a href="javascript:void(0);" class="green_button"><?=Yii::t('app','lang95'); ?></a>
            </div>
            <div class="tabs">
                <div class="i-tab">
                    <div><?=Yii::t('app','lang246'); ?></div>
					<div style="display:none;">Portmanat</div>
                </div>
                <div class="tab-content" style="width:450px;">
                    <div class="tabs-main">
					<form action="<?=$this->context->siteUrl; ?>/payment/saveitem.php" method="post" target="profilePackageWindow" id="profilePackageForm">
						<input type="hidden" name="item" id="mobile_item" value="<?=$this->context->userInfo->id; ?>-profilPaket"> 
						<input type="hidden" name="lang" value="lv" >
						<select name="cardType" class="SlectBox w290">
							<option value="v" selected="selected"><?=Yii::t('app','lang247'); ?></option>
							<option value="m"><?=Yii::t('app','lang248'); ?></option>
						</select>
						<div class="row">
							<label style="margin-right: 10px;"><input type="radio" name="amount" value="<?=$this->context->packagePrices["announce_package1"] ?>" checked="checked" /> 1 <?=Yii::t('app','lang150'); ?> / <?=$this->context->packagePrices["announce_package1"] ?> <?=Yii::t('app','lang149'); ?></label>
							<label><input type="radio" name="amount" value="<?=$this->context->packagePrices["announce_package10"] ?>" /> 10 <?=Yii::t('app','lang150'); ?> / <?=$this->context->packagePrices["announce_package10"] ?> <?=Yii::t('app','lang149'); ?></label>
							<label style="margin-right: 10px;"><input type="radio" name="amount" value="<?=$this->context->packagePrices["announce_package50"] ?>" /> 50 <?=Yii::t('app','lang150'); ?> / <?=$this->context->packagePrices["announce_package50"] ?> <?=Yii::t('app','lang149'); ?></label>
						</div>
						<div class="submit-btn">
							<div>
								<button type="button" onclick="Javascript:getProfilePackage();" name="btn_pay"><?=Yii::t('app','lang86'); ?></button>
							</div>
						</div>
					</form>
					</div>
                    <div class="tabs-main">
                        tabs 2
                    </div>
                </div>
            </div>
        </div><!--right_panel-->
    </div>
	<div class="top_info_block">
        <div class="left_panel">
            <div class="info_panel">
			<?php
			$gun=ceil(($this->context->userInfo->premium-time())/86400);	if($gun<0) $gun=0;
			?>
                <?=$this->context->userInfo->package_foward; ?> <?=Yii::t('app','lang301'); ?>
                <a href="javascript:void(0);" class="green_button"><?=Yii::t('app','lang95'); ?></a>
            </div>
            <div class="tabs">
                <div class="i-tab">
                    <div><?=Yii::t('app','lang246'); ?></div>
					<div style="display:none;">Portmanat</div>
                </div>
                <div class="tab-content" style="width:450px;">
                    <div class="tabs-main">
					<form action="<?=$this->context->siteUrl; ?>/payment/saveitem.php" method="post" target="fowardWindow" id="fowardForm">
						<input type="hidden" name="item" value="<?=$this->context->userInfo->id; ?>-fowardPackage"> 
						<input type="hidden" name="lang" value="lv" >
                        <select name="cardType" class="SlectBox w290">
                            <option value="v"><?=Yii::t('app','lang247'); ?></option>
                            <option value="m"><?=Yii::t('app','lang248'); ?></option>
                        </select>
                        <div class="row">
                            <label style="margin-right: 12px;"><input checked="checked" type="radio" name="amount" value="<?=$this->context->packagePrices["announce_foward1"]; ?>"> 1 <?=Yii::t('app','lang150'); ?> / <?=$this->context->packagePrices["announce_foward1"]; ?> <?=Yii::t('app','lang149'); ?></label>
                            <label <?php if($this->context->userInfo==false) echo 'style="display:none;"'; ?>><input type="radio" name="amount" value="<?=$this->context->packagePrices["announce_foward20"]; ?>"> 20 <?=Yii::t('app','lang150'); ?> / <?=$this->context->packagePrices["announce_foward20"]; ?> <?=Yii::t('app','lang149'); ?></label>
                            <label <?php if($this->context->userInfo==false) echo 'style="display:none;"'; ?>><input type="radio" name="amount" value="<?=$this->context->packagePrices["announce_foward50"]; ?>"> 50 <?=Yii::t('app','lang150'); ?> / <?=$this->context->packagePrices["announce_foward50"]; ?> <?=Yii::t('app','lang149'); ?></label>
                        </div>
                        <div class="submit-btn">
                            <div>
                                <button type="button" onclick="Javascript:getFowardPackage();" name="btn_pay"><?=Yii::t('app','lang86'); ?></button>
                            </div>
                        </div>
                    </form>
					</div>
                    <div class="tabs-main">
                        tabs 2
                    </div>
                </div>
            </div>
        </div>
        <div class="right_panel">
            <div class="info_panel">
                <?=$this->context->userInfo->package_search; ?> <?=Yii::t('app','lang302'); ?>
                <a href="javascript:void(0);" class="green_button"><?=Yii::t('app','lang95'); ?></a>
            </div>
            <div class="tabs">
                <div class="i-tab">
                    <div><?=Yii::t('app','lang246'); ?></div>
					<div style="display:none;">Portmanat</div>
                </div>
                <div class="tab-content" style="width:450px;">
                    <div class="tabs-main">
					<form action="<?=$this->context->siteUrl; ?>/payment/saveitem.php" method="post" target="searchFowardWindow" id="searchFowardForm">
						<input type="hidden" name="item" value="<?=$this->context->userInfo->id; ?>-searchFowardPackage"> 
						<input type="hidden" name="lang" value="lv" >
                        <select name="cardType" class="SlectBox w290">
                            <option value="v"><?=Yii::t('app','lang247'); ?></option>
                            <option value="m"><?=Yii::t('app','lang248'); ?></option>
                        </select>
                        <div class="row">
                            <label><input checked="checked" type="radio" name="amount" value="<?=$this->context->packagePrices["announce_search10"]; ?>"> 1 <?=Yii::t('app','lang150'); ?> / <?=$this->context->packagePrices["announce_search10"]; ?> <?=Yii::t('app','lang149'); ?></label>
                            <label></label>
                        </div>
                        <div class="submit-btn">
                            <div>
                                <button type="button" onclick="Javascript:getFowardSearchPackage();" name="btn_pay"><?=Yii::t('app','lang86'); ?></button>
                            </div>
                        </div>
                    </form>
					</div>
                    <div class="tabs-main">
                        tabs 2
                    </div>
                </div>
            </div>
        </div><!--right_panel-->
    </div>
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
        <div class="userInfo">
            <div class="user_name"><?=$this->context->userInfo->name; ?></div>
            <div class="user_decr"><?=$this->context->userInfo->text; ?></div>
                <?php
                $mobiles=explode("***",$this->context->userInfo->mobile);
                $echo_mobile='';
                foreach($mobiles as $mobile)
                {
                    if($mobile!='') $echo_mobile.= '<p>'.$mobile.'</p>';
                }
                if($echo_mobile!='') echo '<div class="user_phones">'.$echo_mobile.'</div>';
                ?>
            <div class="user_email">
                <p>
                <?php
                if($this->context->userInfo->login=='') echo '<a href="'.Url::toRoute(['emlakcilar/'.$this->context->userInfo->id]).'">emlak.az/emlakcilar/'.$this->context->userInfo->id.'</a>';
                else echo '<a href="'.Url::toRoute(['/'.$this->context->userInfo->login]).'">emlak.az/'.$this->context->userInfo->login.'</a>';
                ?>
                </p>
            </div>
            <?php if($this->context->userInfo->address!='') echo '<div class="user_addres">'.$this->context->userInfo->address.'</div>'; ?>
        </div>
        <a href="<?=Url::toRoute([Yii::$app->controller->id.'/duzelis']); ?>" class="edit_info"><?=Yii::t('app','lang88'); ?></a>
    </div>
</div>

<script>
var popup;

function getProfilePackage() {
	popup = window.open('', 'profilePackageWindow', "toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=0,top=70,left=370,width=630,height=600");
	$('#profilePackageForm').submit();
	popup.focus();
}
function getRieltorPackage() {
	popup = window.open('', 'rieltorPackageWindow', "toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=0,top=70,left=370,width=630,height=600");
	$('#rieltorPackageForm').submit();
	popup.focus();
}
function getFowardPackage() {
	popup = window.open('', 'fowardWindow', "toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=0,top=70,left=370,width=630,height=600");
	$('#fowardForm').submit();
	popup.focus();
}
function getFowardSearchPackage() {
	popup = window.open('', 'searchFowardWindow', "toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=0,top=70,left=370,width=630,height=600");
	$('#searchFowardForm').submit();
	popup.focus();
}

function refreshParent(){
	return location.href= "<?=$this->context->siteUrl;?>/profil/";
}
</script>