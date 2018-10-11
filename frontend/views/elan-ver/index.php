<?php
use yii\helpers\Url;
use frontend\components\MyFunctionsF;
use backend\models\Users;

$info=$this->context->getPagesInfo(15);
use backend\models\Announces;
use backend\models\ImageUpload;

$this->title=Yii::t('app','pg_title7');
/*
// test image quality
$img=new ImageUpload();
$saveParth='announces/temporary';
$file='announces/temporary/aa.jpeg';
$fileThumb='bb.jpeg';
$img->maxSize($file,Announces::MAX_IMAGE_WIDTH,Announces::MAX_IMAGE_HEIGHT);
$img->thumbExportAnnounce($file,$saveParth,$fileThumb,Announces::THUMB3_IMAGE_WIDTH,Announces::THUMB3_IMAGE_HEIGHT,'watermark.png','watermark_logo.png');
*/
?>
<link href="<?=Yii::$app->homeUrl; ?>/css/pure-min.css" rel="stylesheet">
<script src="https://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyDlYLxzojj8VNLy-xtJz5v7-AtuvxOSIyg"></script>
<script type="text/javascript" src="<?=Yii::$app->homeUrl; ?>/js/elan-ver.js"></script>
<script type="text/javascript" src="<?=Yii::$app->homeUrl; ?>/js/jquery.form.min.js"></script>
<script type="text/javascript" src="<?=Yii::$app->homeUrl; ?>/js/jquery_upload_script.js"></script>
<script type="text/javascript" src="<?=Yii::$app->homeUrl; ?>/js/jquery.filter_input.js"></script>
<script type="text/javascript" src="<?=Yii::$app->homeUrl; ?>/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?=Yii::$app->homeUrl; ?>/js/jquery.rotate.js"></script>
<script>
    $(function() {
        $( "#sortable" ).sortable();
        $( "#sortable" ).disableSelection();
    });
</script>
<style>
.h280{max-height:290px!important;}
</style>


<div class="content clearfix">
<h2 class="main-title my_color"><span><?=Yii::t('app','lang139'); ?></span></h2>
<div class="form_box">

<div class="grey_box" style="position:absolute;right:0px;background: #fff;border: none;">
<div class="right_panel" style="z-index: 999;position: relative;">
	<div class="info_text float_l">
		<p><?=Yii::t('app','lang67'); ?></p>
		<?php if(!$this->context->userInfo && $edit=='') echo '<a href="javascript:void(0);" class="yellow_label entry-links " style="margin-bottom:15px;">'.Yii::t('app','lang148').'</a>'; ?>
		<span class="white_label <?php if($edit!='') echo 'hide'; ?>" style="display:none;"><span id="balance_span"><?=$this->context->packagePrices["announce_limit"]; ?></span> <?=Yii::t('app','lang68'); ?></span>
		<span class="block_number" style="display:none;"><?=Yii::t('app','lang151'); ?></span>
	</div>
	<div class="tabs limit_full">
		<div class="i-tab">
			<div><?=Yii::t('app','lang246'); ?></div>
			<div style="display:none;">Portmanat</div>
		</div>
		<div class="tab-content">
			<div class="tabs-main">
			<form action="<?=$this->context->siteUrl; ?>/payment/saveitem.php" method="post" target="packageWindow" id="packageForm">
				<input type="hidden" name="item" id="mobile_item" value="0-mobile-">
				<input type="hidden" name="lang" value="lv" >
				<select name="cardType" class="SlectBox w290">
					<option value="v" selected="selected"><?=Yii::t('app','lang247'); ?></option>
					<option value="m"><?=Yii::t('app','lang248'); ?></option>
				</select>
				<div class="row">
					<label style="margin-right: 10px;"><input type="radio" name="amount" value="<?=$this->context->packagePrices["announce_package1"] ?>" checked="checked" /> 1 <?=Yii::t('app','lang150'); ?> / <?=$this->context->packagePrices["announce_package1"] ?> <?=Yii::t('app','lang149'); ?></label>
					<label><input type="radio" name="amount" value="<?=$this->context->packagePrices["announce_package10"] ?>" /> 10 <?=Yii::t('app','lang150'); ?> / <?=$this->context->packagePrices["announce_package10"] ?> <?=Yii::t('app','lang149'); ?></label>
					<div class="clear">&nbsp;</div>
					<label style="float:left;margin-left: 72px;    margin-top: -8px;"><input type="radio" name="amount" value="<?=$this->context->packagePrices["announce_package50"] ?>" /> 50 <?=Yii::t('app','lang150'); ?> / <?=$this->context->packagePrices["announce_package50"] ?> <?=Yii::t('app','lang149'); ?></label>
				</div>
				<div class="submit-btn">
					<div>
						<button type="button" onclick="Javascript:getPackage();" name="btn_pay"><?=Yii::t('app','lang86'); ?></button>
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
</div>

<form action="<?=Url::toRoute(['elan-ver/add']) ?>" method="post" enctype="multipart/form-data" class="rf pure-form" id="insert_form">
<div class="grey_box" style="padding-bottom:80px;">
    <span><?=Yii::t('app','lang140'); ?></span>
    <div class="contacts_block styled">
		<?php if($edit!='' && $admin>0) { ?>
		<label class="styled_line">
            <span>360<sup>o</sup></span>
            <input value="<?php if($edit!='') echo $edit->panarama; ?>" name="panarama" type="text" class="rfield" id="panarama" note="title" title="360" />
        </label>
		<label class="styled_line">
            <span>Baxış sayı</span>
            <input value="<?php if($edit!='') echo $edit->view_count; ?>" name="view_count" type="text" class="rfield" id="view_count" note="title" title="360" />
        </label>
		<?php } ?>
        <label class="styled_line">
            <span><?=Yii::t('app','lang141'); ?></span>
            <input value="<?php if($edit!='') echo $edit->name; ?>" name="name" type="text" class="rfield" id="name" note="title" title="<?=Yii::t('app','lang146'); ?>" />
        </label>
        <label class="styled_line">
            <div class="country_choose" style="display:none;"><?=Yii::t('app','lang152'); ?></div>
            <span><?=Yii::t('app','lang142'); ?></span>

            <select name="country" id="country">
                <?php
                foreach($this->context->countries as $id=>$title)
                {
                    if($edit!='') {  if($id==$edit->country) $selected='selected="selected"'; else $selected=''; }
					elseif($id==1) $selected='selected="selected"';
					else $selected='';
                    echo '<option value="'.$id.'" '.$selected.'>'.$title.'</option>';
                }
                ?>
            </select>
        </label>
        <label class="styled_line">
            <span><?=Yii::t('app','lang42'); ?></span>
            <input value="<?=$mobile1; ?>" data-old="<?=$mobile1?>" name="mobile1" id="mobile1" type="text" class="phone_number" note="title" title="<?=Yii::t('app','lang147'); ?>" />
        </label>
        <label class="styled_line <?php if($mobile2=='') echo 'hidden-phone'; ?>">
            <span></span>
            <input value="<?=$mobile2; ?>" data-old="<?=$mobile2?>" name="mobile2" id="mobile2" type="tel" class="phone_number" />
            <span class="delete_field"></span>
        </label>
        <label class="styled_line <?php if($mobile3=='') echo 'hidden-phone'; ?>">
            <span></span>
            <input value="<?=$mobile3; ?>" data-old="<?=$mobile3?>" name="mobile3" id="mobile3" type="tel" class="phone_number" />
            <span class="delete_field"></span>
        </label>
        <label class="styled_line">
            <span></span>
            <a href="javascript:void(0);" class="add_field" <?php if($mobile3!='') echo 'style="display:none;"'; ?>><?=Yii::t('app','lang100'); ?></a>
        </label>
        <label class="styled_line">
            <span><?=Yii::t('app','lang12'); ?></span>
            <input value="<?php if($edit!='') echo $edit->email; elseif($this->context->userInfo!=false) echo $this->context->userInfo->email; ?>" type="email" note="title" name="email" id="email" title="<?=Yii::t('app','lang145'); ?>" />
        </label>
        <div class="radios_wrap">
            <span><?=Yii::t('app','lang143'); ?></span>
            <div class="radios">
                <label><input <?php if($edit!='' && $edit->announcer==1) echo 'checked="checked"'; ?> value="1" id="announcer1" type="radio" name="announcer"><b><?=Yii::t('app','announcer1'); ?></b></label>
                <label><input <?php if($edit!='' && $edit->announcer==2) echo 'checked="checked"'; ?> value="2" id="announcer2" type="radio" name="announcer"><b><?=Yii::t('app','announcer2'); ?></b></label>
            </div>
            <div class="announce_choose" style="display:none;"><?=Yii::t('app','lang152'); ?></div>
        </div>
        <div class="butt_wrap">
            <input id="davam_edin" type="submit" value="<?=Yii::t('app','lang144'); ?>" />
        </div>
    </div>

</div><!--grey_box-->
<div class="grey_box <?php if($edit=='') echo 'with_overlay'; ?> all_add_inputs "> <!-- with_overlay -->
    <span><?=Yii::t('app','lang153'); ?></span>
    <div class="options styled">
        <label class="styled_line announce_type_row">
            <span><?=Yii::t('app','lang154'); ?></span>
            <select name="announce_type" id="announce_type">
                <option value=""></option>
                <option value="1" <?php if($edit!='' && $edit->announce_type==1) echo 'selected="selected"'; ?>><?=Yii::t('app','announce_type1'); ?></option>
                <option value="2" <?php if($edit!='' && $edit->announce_type==2) echo 'selected="selected"'; ?>><?=Yii::t('app','announce_type2'); ?></option>
            </select>
            <span class="error unvisible"><?=Yii::t('app','lang154').' '.Yii::t('app','lang103'); ?></span>
        </label>
        <label class="styled_line property_type_row">
            <span><?=Yii::t('app','lang155'); ?></span>
            <select name="property_type" id="property_type">
                <option value=""></option>
                <option value="1" <?php if($edit!='' && $edit->property_type==1) echo 'selected="selected"'; ?>><?=Yii::t('app','property_type1'); ?></option>
                <option value="2" <?php if($edit!='' && $edit->property_type==2) echo 'selected="selected"'; ?>><?=Yii::t('app','property_type2'); ?></option>
                <option value="3" <?php if($edit!='' && $edit->property_type==3) echo 'selected="selected"'; ?>><?=Yii::t('app','property_type3'); ?></option>
                <option value="10" <?php if($edit!='' && $edit->property_type==10) echo 'selected="selected"'; ?>><?=Yii::t('app','property_type10'); ?></option>
                <option value="4" <?php if($edit!='' && $edit->property_type==4) echo 'selected="selected"'; ?>><?=Yii::t('app','property_type4'); ?></option>
                <option value="5" <?php if($edit!='' && $edit->property_type==5) echo 'selected="selected"'; ?>><?=Yii::t('app','property_type5'); ?></option>
                <option value="6" <?php if($edit!='' && $edit->property_type==6) echo 'selected="selected"'; ?>><?=Yii::t('app','property_type6'); ?></option>
                <option value="7" <?php if($edit!='' && $edit->property_type==7) echo 'selected="selected"'; ?>><?=Yii::t('app','property_type7'); ?></option>
                <option value="8" <?php if($edit!='' && $edit->property_type==8) echo 'selected="selected"'; ?>><?=Yii::t('app','property_type8'); ?></option>
            </select>
            <span class="error unvisible"><?=Yii::t('app','lang155').' '.Yii::t('app','lang103'); ?></span>
        </label>
        <label class="styled_line room_count_row <?php if($edit=='' || $edit->property_type==6 || $edit->property_type==7) echo 'hide'; ?>">
            <span><?=Yii::t('app','lang160'); ?></span>
            <input value="<?php if($edit!='') echo $edit->room_count; ?>" name="room_count" id="room_count" type="text"  class="rfield" />
            <span class="error unvisible"><?=Yii::t('app','lang160').' '.Yii::t('app','lang103'); ?></span>
        </label>
        <label id="sahe_vahidi_m" class="hide"><?=Yii::t('app','lang157'); ?><sup>2</sup></label>
        <label id="sahe_vahidi_s" class="hide"><?=Yii::t('app','lang158'); ?></label>
        <label class="styled_line space_row <?php if($edit=='') echo 'hide'; ?>">
            <span>
                <?=Yii::t('app','lang156'); ?> (<label id="sahe_vahidi"><?php if($edit!='' && $edit->property_type==7) echo Yii::t('app','lang158');
                    else echo Yii::t('app','lang157').'<sup>2</sup>'; ?></label>)
            </span>
            <input value="<?php if($edit!='') echo $edit->space; ?>" type="text" name="space" id="space" class="rfield" />
            <span class="error unvisible"><?=Yii::t('app','lang156').' '.Yii::t('app','lang103'); ?></span>
        </label>
        <label class="styled_line current_floor_row <?php if($edit=='' || $edit->property_type==3 || $edit->property_type==4 || $edit->property_type==6 || $edit->property_type==7 || $edit->property_type==8) echo 'hide'; ?>">
            <span><?=Yii::t('app','lang161'); ?></span>
            <input value="<?php if($edit!='') echo $edit->current_floor; ?>" type="text" name="current_floor" id="current_floor" class="rfield">
            <span class="error unvisible floor_count_row_error0"><?=Yii::t('app','lang161').' '.Yii::t('app','lang103'); ?></span>
        </label>
        <label class="styled_line floor_count_row <?php if($edit=='' || $edit->property_type==6 || $edit->property_type==7) echo 'hide'; ?>">
            <span><?=Yii::t('app','lang162'); ?></span>
            <input value="<?php if($edit!='') echo $edit->floor_count; ?>" type="text" name="floor_count" id="floor_count" class="rfield">
            <span class="error unvisible floor_count_row_error1"><?=Yii::t('app','lang162').' '.Yii::t('app','lang103'); ?></span>
            <span class="error unvisible floor_count_row_error2"><?=Yii::t('app','lang159'); ?></span>
        </label>
        <label class="styled_line repair_row <?php if($edit=='' || $edit->property_type==7) echo 'hide'; ?>">
            <span><?=Yii::t('app','lang163'); ?></span>
            <select name="repair" id="repair">
                <option value=""></option>
                <option value="6" <?php if($edit!='' && $edit->repair==0) echo 'selected="selected"'; ?>><?=Yii::t('app','repair6'); ?></option>
                <option value="0" <?php if($edit!='' && $edit->repair==0) echo 'selected="selected"'; ?>><?=Yii::t('app','repair0'); ?></option>
                <option value="1" <?php if($edit!='' && $edit->repair==1) echo 'selected="selected"'; ?>><?=Yii::t('app','repair1'); ?></option>
                <option value="2" <?php if($edit!='' && $edit->repair==2) echo 'selected="selected"'; ?>><?=Yii::t('app','repair2'); ?></option>
                <option value="3" <?php if($edit!='' && $edit->repair==3) echo 'selected="selected"'; ?>><?=Yii::t('app','repair3'); ?></option>
                <option value="4" <?php if($edit!='' && $edit->repair==4) echo 'selected="selected"'; ?>><?=Yii::t('app','repair4'); ?></option>
                <option value="5" <?php if($edit!='' && $edit->repair==5) echo 'selected="selected"'; ?>><?=Yii::t('app','repair5'); ?></option>
            </select>
            <span class="error unvisible"><?=Yii::t('app','lang163').' '.Yii::t('app','lang103'); ?></span>
        </label>
        <label class="styled_line document_row">
            <span><?=Yii::t('app','lang170'); ?></span>
            <select name="document" id="document">
                <option value="9" <?php if($edit!='' && $edit->document==9) echo 'selected="selected"'; ?>><?=Yii::t('app','document9'); ?></option>
                <option value="0" <?php if($edit!='' && $edit->document==0) echo 'selected="selected"'; ?>><?=Yii::t('app','document0'); ?></option>
                <option value="1" <?php if($edit!='' && $edit->document==1) echo 'selected="selected"'; ?>><?=Yii::t('app','document1'); ?></option>
                <option value="2" <?php if($edit!='' && $edit->document==2) echo 'selected="selected"'; ?>><?=Yii::t('app','document2'); ?></option>
                <option value="3" <?php if($edit!='' && $edit->document==3) echo 'selected="selected"'; ?>><?=Yii::t('app','document3'); ?></option>
                <option value="4" <?php if($edit!='' && $edit->document==4) echo 'selected="selected"'; ?>><?=Yii::t('app','document4'); ?></option>
                <option value="5" <?php if($edit!='' && $edit->document==5) echo 'selected="selected"'; ?>><?=Yii::t('app','document5'); ?></option>
                <option value="6" <?php if($edit!='' && $edit->document==6) echo 'selected="selected"'; ?>><?=Yii::t('app','document6'); ?></option>
                <option value="7" <?php if($edit!='' && $edit->document==7) echo 'selected="selected"'; ?>><?=Yii::t('app','document7'); ?></option>
                <option value="8" <?php if($edit!='' && $edit->document==8) echo 'selected="selected"'; ?>><?=Yii::t('app','document8'); ?></option>
            </select>
            <span class="error unvisible"><?=Yii::t('app','lang170').' '.Yii::t('app','lang103'); ?></span>
        </label>
        <label class="styled_line price_row">
            <span><?=Yii::t('app','lang171'); ?> (<?=Yii::t('app','lang149'); ?>)</span>
            <input value="<?php if($edit!='') echo $edit->price; ?>" type="text" name="price" id="price" class="rfield" style="width:120px;" />
            <select name="rent_type" id="rent_type" class="rent_type <?php if($edit=='' || $edit->announce_type==1) echo 'hide'; ?>">
                <option value="2" <?php if($edit!='' && $edit->rent_type==2) echo 'selected="selected"'; ?>><?=Yii::t('app','rent_type2'); ?></option>
				<option value="1" <?php if($edit!='' && $edit->rent_type==1) echo 'selected="selected"'; ?>><?=Yii::t('app','rent_type1'); ?></option>
            </select>
            <span class="error unvisible"><?=Yii::t('app','lang171').' '.Yii::t('app','lang103'); ?></span>
        </label>
        <label class="styled_line txt_area text_row">
            <span><?=Yii::t('app','lang172'); ?></span>
            <textarea name="text" id="text" class="rfield" style="margin-bottom: 0px;"><?php if($edit!='') echo stripslashes($edit->text); ?></textarea>
            <span class="field_info" style="width: 260px;padding: 15px;">
                <?=Yii::t('app','lang173'); ?><br/>
                <?=Yii::t('app','lang174'); ?><br/>
                <?=Yii::t('app','lang175'); ?><br/>
                <?=Yii::t('app','lang176'); ?>
            </span>
        </label>
        <label class="styled_line city_row <?php if($edit!='' && $edit->country!=1) echo 'hide'; ?>">
            <span><?=Yii::t('app','lang164'); ?></span>
            <select name="city" id="city">
                <option value=""></option>
                <?php
                foreach($this->context->cities as $id=>$title)
                {
                    if($id>0){
                    if($edit!='') {  if($id==$edit->city) $selected='selected="selected"'; else $selected=''; } else $selected='';
                    echo '<option value="'.$id.'" '.$selected.'>'.$title.'</option>';
                    }
                }
                ?>
            </select>
            <span class="error unvisible"><?=Yii::t('app','lang164').' '.Yii::t('app','lang103'); ?></span>
        </label>
        <label class="styled_line region_row <?php if($edit=='' || $edit->city!=3) echo 'hide'; ?>">
            <span><?=Yii::t('app','lang165'); ?></span>
            <select name="region" class="width300" id="region">
                <option value=""></option>
                <?php
                foreach($this->context->regions as $id=>$title)
                {
                    if($id>0){
                    if($edit!='') {  if($id==$edit->region) $selected='selected="selected"'; else $selected=''; } else $selected='';
                    echo '<option value="'.$id.'" '.$selected.'>'.$title.'</option>';
                    }
                }
                ?>
            </select>
            <span class="error unvisible"><?=Yii::t('app','lang165').' '.Yii::t('app','lang103'); ?></span>
        </label>
        <label class="styled_line settlement_row <?php if($edit=='' || $edit->city!=3) echo 'hide'; ?>">
            <span><?=Yii::t('app','lang166'); ?></span>
            <select name="settlement" id="settlement">
                <option value=""></option>
                <?php
                foreach($this->context->settlements as $id=>$title)
                {
                    if($id>0){
                    if($edit!='') {  if($id==$edit->settlement) $selected='selected="selected"'; else $selected=''; } else $selected='';
                    echo '<option value="'.$id.'" '.$selected.'>'.$title.'</option>';
                    }
                }
                ?>
                <span class="error unvisible"><?=Yii::t('app','lang166').' '.Yii::t('app','lang103'); ?></span>
            </select>
        </label>
        <label class="styled_line metro_row <?php if($edit=='' || $edit->city!=3) echo 'hide'; ?>">
            <span><?=Yii::t('app','lang167'); ?></span>
            <select name="metro" id="metro">
                <option value=""></option>
                <?php
                foreach($this->context->metros as $id=>$title)
                {
                    if($id>0){
                    if($edit!='') {  if($id==$edit->metro) $selected='selected="selected"'; else $selected=''; } else $selected='';
                    echo '<option value="'.$id.'" '.$selected.'>'.$title.'</option>';
                    }
                }
                ?>
                <span class="error unvisible"><?=Yii::t('app','lang167').' '.Yii::t('app','lang103'); ?></span>
            </select>
        </label>
        <div class="styled_line mark_row <?php if($edit=='' || $edit->city!=3) echo 'hide'; ?>">
            <input type="hidden" value="" id="selected_marks" name="selected_marks" />
            <span><?=Yii::t('app','lang168'); ?></span>
            <div class="items_map">
                <a href="javascript:void(0);" class="area-links area-links-1"><?=Yii::t('app','lang168'); ?></a>
                <ul class="area-list">
                    <?php
                    if($edit!='' && $edit->mark!='')
                    {
                        $selectedMarks=explode("-",$edit->mark);
                        foreach($selectedMarks as $mark)
                        {
                            if(isset($this->context->marks[$mark])) echo '<li><a data-id="'.$mark.'" href="javascript:void(0);" class="remove"></a>'.$this->context->marks[$mark].'</li>';
                        }
                    }
                    else $selectedMarks='';
                    ?>
                </ul>
            </div>
        </div>
        <div class="clear mark_row <?php if($edit=='' || $edit->city!=3) echo 'hide'; ?>" style="margin-bottom: 10px;">&nbsp;</div>
        <label class="styled_line address_row">
            <span><?=Yii::t('app','lang28'); ?></span>
            <input value="<?php if($edit!='') echo $edit->address; ?>" type="text" name="address" id="address" class="rfield" />
            <span class="error unvisible"><?=Yii::t('app','lang28').' '.Yii::t('app','lang103'); ?></span>
        </label>
        <div class="clear">&nbsp;</div>

        <div class="form_group">
            <button type="button" class="map_button map_button_row" style="float:left;"><?=Yii::t('app','lang177'); ?></button>
            <span class="error unvisible map_error" style="float:left;padding-left: 15px;padding-right: 15px;margin-top:7px;margin-left:20px;"><?=Yii::t('app','lang183'); ?></span>
            <div class="clear"></div>
            <?php
            if($edit!='') $googleMap=$edit->google_map; else $googleMap='(40.40983633607086, 49.86763000488281)';
			if($googleMap=='') $googleMap='(40.40983633607086, 49.86763000488281)';
            $googleMapImg=str_replace('(','',$googleMap);   $googleMapImg=str_replace(')','',$googleMapImg);
            ?>
            <input type="hidden" value="<?=$googleMap; ?>" id="google_map" name="google_map" />
            <div class="map_content <?php if($edit=='' || $edit->google_map=='') echo 'hide'; ?>">
                <img class="map_display" src="http://maps.google.com/maps/api/staticmap?center=<?=$googleMapImg; ?>&zoom=14&size=600x230&maptype=roadmap&key=AIzaSyDlYLxzojj8VNLy-xtJz5v7-AtuvxOSIyg&markers=color:red|label:none|<?=$googleMapImg; ?>" width="600" height="230" />
            </div>
            <button type="button" class="add_photo image_count_row" ><?=Yii::t('app','lang184'); ?></button>
            <span class="error unvisible photo_error" style="float:left;padding-left: 15px;padding-right: 15px;margin-top:7px;margin-left:20px;"><?=Yii::t('app','lang179'); ?></span>
            <div class="clear"></div>

            <input type="file" id="files" name="files[]" class="hide" multiple />

            <input type="hidden" value="0" id="last_bar" />
            <input type="hidden" value="0" id="rotated" name="rotated" />
            <input type="hidden" value="<?=$edited;?>" id="edited" name="edited" />
            <input type="hidden" value="<?=$announceId;?>" id="announce_id" name="announce_id" />
            <ul class="photo_list" id="sortable">
                <?php
                if($edit!=''){
                    $editing_images=[];
                    Yii::$app->session["editing_id"]=$announceId;
                    $images=explode(",",$edit->images);
                    if($edit->logo_images!='') $logoImages=explode(",",$edit->logo_images); else $logoImages=$images;
                    $tempLogoImages=explode(",",$edit->images);
                    $count=0;
                    foreach($images as $image)
                    {
                        if(is_file(MyFunctionsF::getImagePath().'/'.$image) || $edit->cdn_server==1)
                        {
                            $fileName=explode('/',$image);    $fileName=end($fileName);

                            if(!isset($logoImages[$count])){
								$type=explode(".",$image);   $type=end($type);   $type=strtolower($type);
								$from=['png','bmp','gif','PNG','BMP','GIF','jpeg','JPEG']; $to=['jpg','jpg','jpg','jpg','jpg','jpg','jpg','jpg'];	$type=str_replace($from,$to,$type);
								$logoly_image=explode("-",$image);   unset($logoly_image[count($logoly_image)-1]);
                                $logoly_image=implode("-",$logoly_image).'.'.$type;
								$edit->logo_images=$edit->logo_images.','.$logoly_image;
								$edit->save(false);

								$logoFileName=explode('/',$logoly_image); $logoFileName=end($logoFileName);
								$logoImages_count=$logoly_image;
							}
							else { $logoImages_count=$logoImages[$count]; $logoFileName=explode('/',$logoImages[$count]); $logoFileName=end($logoFileName); }
                            $tempLogoFileName=explode('/',$tempLogoImages[$count]); $tempLogoFileName=end($tempLogoFileName);
                            if($edit->cdn_server==0)
                                copy(MyFunctionsF::getImagePath().'/'.$image,MyFunctionsF::getImagePath().'/announces/temporary/'.$fileName);

                            if($edit->cdn_server==1)
                                $src = Yii::$app->params["cdn_".Yii::$app->params['currentCDN']]['CDNSERVER_URL']."images".'/'.$logoImages_count;
                            else
                                $src = MyFunctionsF::getImageUrl().'/'.$logoImages_count;

                            if(is_file(MyFunctionsF::getImagePath().'/'.$logoImages_count)) $editing_images[$logoFileName]=$fileName;
                            else{
                                if($edit->cdn_server==1)
                                    $src=Yii::$app->params["cdn_".Yii::$app->params['currentCDN']]['CDNSERVER_URL']."images".'/'.$tempLogoImages[$count];
                                else
                                    $src=MyFunctionsF::getImageUrl().'/'.$tempLogoImages[$count];

                                $editing_images[$tempLogoFileName]=$fileName;
                            }

                            if($edit->cdn_server==1) $rotate = "";
                            else $rotate = "<a href=\"javascript:void(0);\" class=\"turn_left rotate\"></a>
                                <a href=\"javascript:void(0);\" class=\"turn_right rotate\"></a>";

                            echo '<li>
                                <div class="li_div">
                                <div class="li_div2"><img src="'.$src.'" /></div>
                                </div>
                                <a href="javascript:void(0);" degrees="0"  class="delete_photo"></a>
                                '.$rotate.'
                            </li>';
                        }
                        $count++;
                    }
                    Yii::$app->session["temporary_images_for_diff"]=$editing_images;
                    Yii::$app->session["temporary_images"]=$editing_images;
                }
                else Yii::$app->session["editing_id"]=0;
                ?>
            </ul>
            <hr class="bott_line">
            <ul class="photo_info">
                <li><?=Yii::t('app','lang179'); ?></li>
                <li><?=Yii::t('app','lang180'); ?></li>
                <li><?=Yii::t('app','lang181'); ?></li>
            </ul>
        </div>
    </div>
</div>
<div class="end_block">
    <span style="color:darkgreen;">
        <input type="checkbox" value="1" name="discount" id="discount" class="cpoint" <?php if($edit!='' && $edit->discount==1) echo 'checked="checked"'; ?> /> <label for="discount"><?=Yii::t('app','lang292'); ?></label>
    </span>
	<div class="clearfix"></div>
	<span><?=Yii::t('app','lang182'); ?> <a href="javascript:void(0);" id="show_announce_rules"><?=Yii::t('app','lang46'); ?></a> <?=Yii::t('app','lang47'); ?></span>

    <div style="width: 200px;margin: auto;">
        <img class="loading_btn" src="<?=MyFunctionsF::getImageUrl(); ?>/loading2.gif" width="40" />
        <button backstatus="<?=$status; ?>" type="button" id="gonder" class="btn_submit <?php if($edit=='') echo 'disabled'; ?>"><?=Yii::t('app','lang48'); ?></button>
    </div>

    <button type="submit" id="submit_form" class="hide"></button>
</div>
</form>
</div>
</div>


<div class="popup nisangah nisangah-1">
<div class="popup-main">
<a href="/" class="close"></a>
<h3><?=Yii::t('app','lang168'); ?></h3>
<form action="" method="post" id="elan_ver_nisangah">
    <div class="wrapper-c scrollbar-dynamic">
        <div class="page-content">
            <p style="display: none;"><label><input type="checkbox" checked="checked" value="0" name="selected_marks[]" />test</label></p>
            <?php
            $col_count=ceil(count($this->context->marks)/3);
            $say=1;
            foreach($this->context->marks as $id=>$title)
            {
                if($id>0){
                if($selectedMarks!='' && in_array($id,$selectedMarks)) $checked='checked="checked"'; else $checked='';

                if($say%$col_count==1) echo '<div class="col">';
                echo '<p><label><input '.$checked.' class="nisangah_check_click" id="nisangah_checkbox'.$id.'" type="checkbox" value="'.$id.'" name="selected_marks[]" />'.$title.'</label></p>';
                if($say%$col_count==0) echo '</div>';
                $say++;
                }
            }
            if($say%$col_count!=1) echo '</div>';
            ?>
        </div>
    </div>
    <div class="bottom-box clearfix">
        <button id="rest_marks" type="reset" class="reset-btn"><?=Yii::t('app','lang169'); ?></button>
        <button type="button" name="marks_submit" class="submit-btn close"><?=Yii::t('app','lang48'); ?></button>
    </div>
</form>
</div>
</div>

<div class="popup google_map" style="opacity: 0;">
    <div class="popup-main">
        <a href="/" class="close"></a>
        <h3><?=Yii::t('app','lang178'); ?></h3>
        <div id="map-canvas" style="width:750px;height:400px;margin-bottom:20px;display:static"></div>
        <button type="button" class="map_ok_button close" style="width:155px;"><?=Yii::t('app','lang48'); ?></button>
    </div>
</div>

<div class="popup announce_rules">
    <div class="popup-main">
        <a href="javascript:void(0);" class="close"></a>
        <div class="title" style="margin: 14px;text-align: center;"><?=$info["title_".Yii::$app->language]; ?></div>
        <div style="padding:15px;font-size:14px;margin:0px;height: 370px;overflow-y: auto;">
            <?=$info["text_".Yii::$app->language]; ?>
        </div>
    </div>
</div>

<script>
var popup;
function getPackage() {
	var name=$("#name").val();
    var country=parseInt($("#country").val());
    var mobile1=$("#mobile1").val(); var mobile2=$("#mobile2").val(); var mobile3=$("#mobile3").val();
    var email=$("#email").val();		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    var announcer1=$("#announcer1").val(); var elan1_checked=$("#announcer1").prop("checked");
    var announcer2=$("#announcer2").val(); var elan2_checked=$("#announcer2").prop("checked");
    var announce_id=$("#announce_id").val();
    var baseurl=$("#baseurl").val();
    $.post(baseurl+"/elan-ver/check_phone",{mobile1:mobile1,mobile2:mobile2,mobile3:mobile3,email:email,country:country,announce_id:announce_id},function(data)
    {
        //alert(data);
        var tel_result=data;
        tel_result=tel_result.split('***');
        //$result[0]=> nomrenin duzgun ve ya yanliw olmagi...
        //$result[3]=> nomrenin qara siyahida olub olmamasini deyir...

        if(tel_result[3]!=1 && (mobile1!='' || mobile2!='' || mobile3!='') && tel_result[0]>0 ){
            var mobile_item='0-mobile-mm';
			if(mobile1!='') mobile_item=mobile_item+mobile1+'mm';
			if(mobile2!='') mobile_item=mobile_item+mobile2+'mm';
			if(mobile3!='') mobile_item=mobile_item+mobile3+'mm';
			$("#mobile_item").val(mobile_item);

			popup = window.open('', 'packageWindow', "toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=0,top=70,left=370,width=630,height=600");
			$('#packageForm').submit();
			popup.focus();
        }
        else {
            console.debug();
			$(".limit_full").fadeOut('fast');
            $(".all_add_inputs").addClass('with_overlay'); $("#gonder").addClass('disabled');
            $('html, body').animate({ scrollTop: 280 }, 'slow');
        }
    });
}
function refreshParent(){
	$("#davam_edin").trigger('click');
	//return location.href= "http://emlak.az/profil";
}
</script>