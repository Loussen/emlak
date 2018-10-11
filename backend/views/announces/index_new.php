<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\components\MyFunctions;

if($status==1) $this->title = 'Aktiv elanlar';
else if($status==2) $this->title = 'Bitmiş elanlar';
else if($status==3) $this->title = 'Təsdiqlənməyən elanlar';
else if($status==4) $this->title = 'Silinmiş elanlar';
else if($status==5) $this->title = 'İrəli çəkilmiş elanlar';
else if($status==6) $this->title = 'Təcili elanlar';
else if($status==7) $this->title = 'Premium elanlar';
else if($status==8) $this->title = 'Axtarışda irəli çəkilmiş elanlar';
else if($status==9) $this->title = 'Bütün elanlar';
else $this->title = 'Yeni elanlar';

$bigWidth=2200;
?>
<script src="https://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyDlYLxzojj8VNLy-xtJz5v7-AtuvxOSIyg"></script>
<script>
function initialize_map(id){
	setTimeout(eval('initialize'+id), 300);
}
</script>
<input type="hidden" value="<?=$status;?>" id="status">
<div class="single-head">
    <h3 class="pull-left">
        <i class="fa fa-bars green minimize pointer" title="Minimize"></i> <?= Html::encode($this->title); ?> (<?=$count;?>) &raquo;
        <a style="color: #ff8e32" href="<?=Url::to(['announces-search/index','status'=>$status]);?>">Axtarış et</a>
    </h3>
    <div class="clearfix"></div>
</div>

<?php

if($status==9)
{
    $checked = '';
    extract($_GET);

    if(isset($announce_type) and !empty($announce_type)) $announce_type=intval($announce_type); else $announce_type='';
    if(isset($property_type) and !empty($property_type)) $property_type=intval($property_type); else $property_type='';
    if(isset($repair) and !empty($repair)) $repair=intval($repair); else $repair=-1;
    if(isset($city) and !empty($city)) $city=intval($city); else $city='';
    if(isset($room_min) and !empty($room_min)) $room_min=intval($room_min); else $room_min='';
    if(isset($room_max) and !empty($room_max)) $room_max=intval($room_max); else $room_max='';
    if(isset($space_min) and !empty($space_min)) $space_min=intval($space_min); else $space_min='';
    if(isset($space_max) and !empty($space_max)) $space_max=intval($space_max); else $space_max='';
    if(isset($price_min) and !empty($price_min)) $price_min=intval($price_min); else $price_min='';
    if(isset($price_max) and !empty($price_max)) $price_max=intval($price_max); else $price_max='';
    if(isset($document) and !empty($document)) {$document=intval($document); $checked = ' checked';}        else $document='';
    if(isset($announcer) and !empty($announcer)) $announcer=intval($announcer); else $announcer='';

    if(isset($selected_metros) && is_array($selected_metros) && count($selected_metros)>0) $selected_metros = $selected_metros;
    else $selected_metros = array();

    if(isset($selected_regions) && is_array($selected_regions) && count($selected_regions)>0) $selected_regions = $selected_regions;
    else $selected_regions = array();

    if(isset($selected_settlements) && is_array($selected_settlements) && count($selected_settlements)>0) $selected_settlements = $selected_settlements;
    else $selected_settlements = array();

    if(isset($selected_marks) && is_array($selected_marks) && count($selected_marks)>0) $selected_marks = $selected_marks;
    else $selected_marks = array();


    if(!isset($yotaq)) $yotaq=''; else {$room_min=$room_max=$yotaq[0];$property_type=1;}
    if(!isset($kotaq)) $kotaq=''; else {$room_min=$room_max=$kotaq[0];$property_type=2;}
    if(!isset($tip)) $tip=''; else $property_type=$tip[0];
    if(!isset($ann_type) or $ann_type==3) $ann_type=''; else $announce_type=$ann_type;
    ?>
    <button class="btn-search search_toggle_all" style="margin-top: 0px;
    width: 100%;
    border-radius: 3px;
    background: #7EC136;
    color: #fff;
    border: 0;
    padding: 5px;
    margin-bottom: 5px;"><?=Yii::t('app','lang231'); ?></button>
    <form style="margin-bottom: 15px !important; display:none; border: 1px solid #ccc; padding: 5px; -webkit-border-radius: ;-moz-border-radius: ;border-radius: 3px;" action="<?=Url::to(['announces/index?status=9']); ?>" method="get" id="search_blok_all">
        <input type="hidden" name="status" value="<?=$status?>">
        <div id="search" class="tabs-content s_b">
            <div class="drop-box" style="margin-bottom:10px; text-align:center;">
                <select name="announce_type" class="SlectBox" style="width:19%; padding:8px;">
                    <option disabled="disabled" value="0" selected="selected"><?=Yii::t('app','lang154'); ?></option>
                    <?php
                    $selected1 = $selected2 = $selected3 = '';
                    if(isset($announce_type) and $announce_type>0 && strpos($announce_type,"888")>0)
                    {
                        $ann_type_exp = explode("888",$announce_type);
                        if($ann_type_exp[0]==1 && $ann_type_exp[1]==0)
                            $selected1 = "selected=\"selected\"";
                        elseif($ann_type_exp[0]==2 && $ann_type_exp[1]==2)
                            $selected2 = "selected=\"selected\"";
                        elseif($ann_type_exp[0]==2 && $ann_type_exp[1]==1)
                            $selected3 = "selected=\"selected\"";
                    }
                    else
                    {
                        if($ann_type==2)
                            $selected3 = "selected=\"selected\"";
                        else
                            $selected1 = "selected=\"selected\"";
                    }


                    ?>
                    <option <?=$selected1?> value="18880"><?=Yii::t('app','announce_type1'); ?></option>
                    <!--                    <option --><?//=$selected2?><!-- value="2">--><?//=Yii::t('app','announce_type2'); ?><!--</option>-->
                    <option <?=$selected2?> value="28882">Kirayə aylıq</option>
                    <option <?=$selected3?> value="28881">Kirayə günlük</option>
                </select>
                <select name="property_type" class="SlectBox" style="width:19%; padding:8px;">
                    <option disabled="disabled" value="0" selected="selected"><?=Yii::t('app','lang155'); ?></option>
                    <?php
                    for($i=1;$i<=8;$i++){
                        if($property_type==$i)
                            $selected = "selected=\"selected\"";
                        else
                            $selected = '';
                        echo '<option '.$selected.' value="'.$i.'">'.Yii::t('app','property_type'.$i).'</option>';
                    }
                    ?>
                </select>
                <select name="repair" class="SlectBox" style="width:19%; padding:8px;">
                    <option disabled="disabled" value="-1" selected="selected"><?=Yii::t('app','lang163'); ?></option>
                    <?php
                    for($i=0;$i<=5;$i++){
                        if($repair==$i)
                            $selected = "selected=\"selected\"";
                        else
                            $selected = '';
                        echo '<option '.$selected.' value="'.$i.'">'.Yii::t('app','repair'.$i).'</option>';
                    }
                    ?>
                </select>
                <select name="city" style="width:19%; padding:8px;" class="SlectBox">
                    <option disabled="disabled" value="dis" selected="selected"><?=Yii::t('app','lang164'); ?></option>
                    <?php
                    foreach($this->context->cities as $id=>$name){
                        if($city==$id)
                            $selected = "selected=\"selected\"";
                        else
                            $selected = '';
                        if($id>0) echo '<option '.$selected.' value="'.$id.'">'.$name.'</option>';
                    }
                    ?>
                </select>
                <select name="announcer" class="SlectBox" style="width:19%; padding:8px;">
                    <option disabled="disabled" value="0" selected="selected">Əmlak sahibi</option>
                    <?php
                        $selected1 = $selected2 = '';
                        if($announcer==1) $selected1 = 'selected';
                        elseif($announcer==2) $selected2 = 'selected';
                    ?>
                    <option value="1" <?=$selected1?>>Mülkiyyətçi</option>
                    <option value="2" <?=$selected2?>>Vasitəçi</option>
                </select>
            </div>
            <div class="middle-box">
                <div class="row" style="margin:0 0 5px 0;">
                    <input style="width: 49%; font-size:13px; float:left; padding:5px;" type="text" placeholder="<?=Yii::t('app','lang235').'-'.Yii::t('app','lang237'); ?>" name="room_min" class="m-left" value="<?=$room_min?>" >
                    <input style="width: 49%; font-size:13px; float:right; padding:5px;" type="text" placeholder="<?=Yii::t('app','lang235').'-'.Yii::t('app','lang238'); ?>" name="room_max" value="<?=$room_max?>" >
                </div>
                <div class="row" style="margin:0 0 5px 0;">
                    <input style="width: 49%; font-size:13px;float:left; padding:5px;" type="text" placeholder="<?=Yii::t('app','lang236').'-'.Yii::t('app','lang239'); ?>" name="space_min" class="m-left" value="<?=$space_min?>" >
                    <input style="width: 49%; font-size:13px;float:right; padding:5px;" type="text" placeholder="<?=Yii::t('app','lang236').'-'.Yii::t('app','lang240'); ?>" name="space_max" value="<?=$space_max?>" >
                </div>
                <div class="row" style="margin:0 0 5px 0;">
                    <input style="width: 49%; font-size:13px;float:left; padding:5px;" type="text" placeholder="<?=Yii::t('app','lang171').'-'.Yii::t('app','lang241'); ?>" name="price_min" class="m-left" value="<?=$price_min?>" >
                    <input style="width: 49%; font-size:13px;float:right; padding:5px;" type="text" placeholder="<?=Yii::t('app','lang171').'-'.Yii::t('app','lang242'); ?>" name="price_max" value="<?=$price_max?>" >
                </div>
                <div class="row" style="margin: 0 0 15px 0;">
                    <label class="check-label"><input name="document" value="1" type="checkbox" <?=$checked?> /> <?=Yii::t('app','lang243'); ?></label>
                </div>
                <div class="nishangahlar">
                    <div class="row multiselect" style="margin:0 0 5px 0; border:1px solid #ddd; padding:5px;">
                        <h2 align="center"><?=Yii::t('app','lang165'); ?></h2>
                        <?php
                        foreach($this->context->regions as $id=>$name)
                        {
                            if($id==0)
                                continue;

                            if(in_array($id,$selected_regions))
                                $checked = ' checked';
                            else
                                $checked = '';
                            ?>
                            <label style="width:20%; margin:5px;"><input<?=$checked?> type="checkbox" name="selected_regions[]" value="<?=$id?>" /> <?=$name?></label>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="row multiselect" style="margin:0 0 5px 0; border:1px solid #ddd; padding:5px;">
                        <h2 align="center"><?=Yii::t('app','lang167'); ?></h2>
                        <?php
                        foreach($this->context->metros as $id=>$name)
                        {
                            if($id==0)
                                continue;

                            if(in_array($id,$selected_metros))
                                $checked = ' checked';
                            else
                                $checked = '';
                            ?>
                            <label style="width:20%; margin:5px;"><input<?=$checked?> type="checkbox" name="selected_metros[]" value="<?=$id?>" /> <?=$name?></label>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="row multiselect" style="margin:0 0 5px 0; border:1px solid #ddd; padding:5px;">
                        <h2 align="center"><?=Yii::t('app','lang166')?></h2>
                        <?php
                        foreach($this->context->settlements as $id=>$name)
                        {
                            if($id==0)
                                continue;

                            if(in_array($id,$selected_settlements))
                                $checked = ' checked';
                            else
                                $checked = '';
                            ?>
                            <label style="width:20%; margin:5px;"><input<?=$checked?> type="checkbox" name="selected_settlements[]" value="<?=$id?>" /> <?=$name?></label>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="row multiselect" style="margin:0 0 5px 0; border:1px solid #ddd; padding:5px;">
                        <h2 align="center"><?=Yii::t('app','lang168')?></h2>
                        <?php
                        foreach($this->context->marks as $id=>$name)
                        {
                            if($id==0)
                                continue;

                            if(in_array($id,$selected_marks))
                                $checked = ' checked';
                            else
                                $checked = '';
                            ?>
                            <label style="width:20%; margin:5px;"><input<?=$checked?> type="checkbox" name="selected_marks[]" value="<?=$id?>" /> <?=$name?></label>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="row" style="margin:0 0 5px 0; border:1px solid #ddd; padding:5px;"><button type="reset" class="reset-btn" style="float:left;width:49%;"><?=Yii::t('app','lang244'); ?></button> <button class="btn-search" type="submit" style="margin-top: 0px;width:49%; float:right;"><?=Yii::t('app','lang233'); ?></button></div>
            </div>
        </div>
    </form>
    <br />
    <?php

}

?>

<div class="categories-index" style="background: #fff;">
    <div>
    <?php
	$leftWidth=250;
    foreach($announces as $announce)
    {
        $s16='<input class="btn btn-success btn-sm showMyModal" data-id="modalText'.$announce["id"].'" value=" &nbsp; Bax &nbsp; " type="button">';
        if($announce["google_map"]!='') $s23='<input class="btn btn-success btn-sm showMyModal" data-id="modalMap'.$announce["id"].'" onclick="javascript:initialize_map('.$announce["id"].');" value=" &nbsp; Xəritə &nbsp; " type="button">'; else $s23='';
        $s24='<input class="btn btn-success btn-sm" value=" &nbsp; Şəkillər &nbsp; " type="button">';


        if($sameAnnounces=='tekrar_elan_varsa')
        {$class='danger'; $word='Təkrardır';} else {$class='success'; $word='Təkrar deyil';}
        $s25='<input class="btn btn-'.$class.' btn-sm showMyModal" data-id="modalRepeat'.$announce["id"].'" btn-sm" value=" &nbsp; '.$word.' &nbsp; " type="button">';

        $reasons=explode('-',$announce["reasons"]);
		
		if($announce["property_type"]!=7) $repair=Yii::t('app','repair'.$announce["repair"]); else $repair='';
		if($announce["announce_type"]==2) $rentType=Yii::t('app','rent_type'.$announce["rent_type"]); else $rentType='';
		if($announce["property_type"]!=7) $spaceType='m<sup>2</sup>'; else $spaceType='sot';
		
		$mertebe=[];
		if($announce["current_floor"]>0) $mertebe[]=$announce["current_floor"];
		if($announce["floor_count"]>0) $mertebe[]=$announce["floor_count"];
		$mertebe=implode(" / ",$mertebe).' mərtəbəli';
		
		if($announce["discount"]>0) $discount=Yii::t('app','lang293').' var'; else $discount=Yii::t('app','lang293').' yoxdur';
		
		$code=MyFunctions::codeGeneratorforAdmin($announce["id"],$this->context->adminLoggedInfo[0]["id"]);
		$editURL='../elan-ver/index?id='.$announce["id"].'&code='.$code.'&admin='.$this->context->adminLoggedInfo[0]["id"];

        if($announce['archive_view']>0)
            $archive_check = date("d.m.Y H:i",$announce["archive_view"]).' - ';
        else
            $archive_check = '';

        if($status==9)
        {
            $archive_check .= ' '.Html::a('<i class="fa fa-circle white"></i> Arxiv et',Url::toRoute(['archiveview?id='.$announce["id"].'&status=1&redirect_status=9']),['class'=>'btn '.MyFunctions::getStatusTemplate(1).' btn-sm']);

            $archive_check .= ' '.Html::a('<i class="fa fa-circle white"></i> Arxiv imtina',Url::toRoute(['archiveview?id='.$announce["id"].'&status=0&redirect_status=9']),['class'=>'btn '.MyFunctions::getStatusTemplate(0).' btn-sm']);

        }
        else
        {
            //$archive_check = 'Arxiv et <input type="checkbox" name="archive_view">';
            $archive_check .= ' '.Html::a('<i class="fa fa-circle white"></i> Arxiv et',Url::toRoute(['archiveview?id='.$announce["id"].'&status=1']),['class'=>'btn '.MyFunctions::getStatusTemplate(1).' btn-sm']);

            $archive_check .= ' '.Html::a('<i class="fa fa-circle white"></i> Arxiv imtina',Url::toRoute(['archiveview?id='.$announce["id"].'&status=0']),['class'=>'btn '.MyFunctions::getStatusTemplate(0).' btn-sm']);
        }
			
        echo '
		<div id="ann_block_'.$announce["id"].'">
		<div style="height:auto;" class="w'.$leftWidth.' kod">
				Kod: '.$announce["id"].' -  '.date("d.m.Y H:i",$announce["announce_date"]).' - <a href="javascript:void(0);" onclick="window.open(\''.Url::toRoute(['announces/showarchive','id'=>$announce["id"]]).'\', \'_blank\', \'resizable=0,toolbar=0,location=0,menubar=0,width=900, height=500\');" title="'.date("d.m.Y H:i",$announce["announce_date"]).'"><input class="btn btn-success btn-sm" value="Arxiv" type="button" style="height: 17px;line-height: 7px;"></a>
				
				<div style="float:right;" data-idi="'.$announce["id"].'" data-edited="0">
				
				    '.$archive_check.'
				    Send sms <input type="checkbox" name="sms_check">
					<a target="_blank" href="'.Url::toRoute($editURL).'"><img class="edit" src="'.MyFunctions::getImageUrl().'/ico/edit-icon.png" alt="" width="17" /></a>&nbsp;
					<img class="edited_save" src="'.MyFunctions::getImageUrl().'/ico/ok-icon.png" alt="" width="17" />&nbsp;
					<img class="edited_not_save" src="'.MyFunctions::getImageUrl().'/ico/close-icon.png" alt="" width="17" />&nbsp;
					<img class="delete_announce" src="'.MyFunctions::getImageUrl().'/ico/delete-icon.png" alt="" width="17" />&nbsp;
				</div>
        </div>
		<div class="clearfix"></div>
		
		<div style="border: none;font-size:15px;float:left;width:'.$leftWidth.'px;" class="main_div" data-idi="'.$announce["id"].'">
			<div class="w'.$leftWidth.' '.((in_array(4,$reasons))?'lightpink':'').' "><div class="reasons_x" r="4">x</div><span title="'.$announce["email"].'">'.$announce["email"].'</span>'.'</div>
			<div class="w'.$leftWidth.' '.((in_array(1,$reasons))?'lightpink':'').'"><div class="reasons_x" r="1">x</div><span title="'.$announce["name"].'">'.$announce["name"].' ('.Yii::t('app','announcer'.$announce["announcer"]).')</span>'.'</div>
            <div class="w'.$leftWidth.' '.((in_array(2,$reasons))?'lightpink':'').'"><div class="reasons_x" r="2">x</div>'.$this->context->countries[$announce["country"]].'</div>
            <div class="w'.$leftWidth.' '.((in_array(3,$reasons))?'lightpink':'').'"><div class="reasons_x" r="3">x</div>'.str_replace('*',', ',$announce["mobile"]).'</div>
			
			
			<div class="w'.$leftWidth.' '.((in_array(23,$reasons))?'lightpink':'').'"><div class="reasons_x" r="23">x</div>'.$s23.'</div>
                <div id="modalMap'.$announce["id"].'" class="myModal" style="width:875px;">
                    <span class="blue">Xəritə:</span><br />
					<div id="map-canvas'.$announce["id"].'" style="width:830px;height:520px;display:static"></div>
                    <hr />
                    <input class="btn btn-success btn-sm closeMyModal" value=" &nbsp; Bağla &nbsp; " type="button">
					<input type="hidden" value="0" id="showed_map'.$announce["id"].'" />
                </div>
				<script>
				function initialize'.$announce["id"].'(){
					var showed_map=parseInt($("#showed_map"+'.$announce["id"].').val());
					if(showed_map==0){
						$("#showed_map"+'.$announce["id"].').val(1);
					var google_map="'.$announce["google_map"].'";
					google_map=google_map.replace("(","");
					google_map=google_map.replace(")","");
					google_map=google_map.split(", ");
					var latLng = new google.maps.LatLng(google_map[0], google_map[1]);
					var map = new google.maps.Map(document.getElementById("map-canvas'.$announce["id"].'"), {
						zoom: 14,
						center: latLng,
						mapTypeId: google.maps.MapTypeId.ROADMAP
					});
					var marker = new google.maps.Marker({
						position: latLng,
						title: "Point A",
						map: map,
						draggable: false
					});
					}
				}
				</script>
            
            
            <div class="w'.$leftWidth.' '.((in_array(6,$reasons))?'lightpink':'').'"><div class="reasons_x" r="6">x</div>'.Yii::t('app','announce_type'.$announce["announce_type"]).'</div>
            <div class="w'.$leftWidth.' '.((in_array(7,$reasons))?'lightpink':'').'"><div class="reasons_x" r="7">x</div>'.Yii::t('app','property_type'.$announce["property_type"]).'</div>
            <div class="w'.$leftWidth.' '.((in_array(8,$reasons))?'lightpink':'').'"><div class="reasons_x" r="8">x</div>'.$announce["room_count"].' otaqlı</div>
            <div class="w'.$leftWidth.' '.((in_array(9,$reasons))?'lightpink':'').'"><div class="reasons_x" r="9">x</div>'.$announce["space"].' '.$spaceType.'</div>
            <div class="w'.$leftWidth.' '.((in_array(12,$reasons))?'lightpink':'').'"><div class="reasons_x" r="12">x</div>'.$repair.'</div>
			<div class="clearfix" style="margin-bottom:5px;"></div>
			
            <div class="w'.$leftWidth.' '.((in_array(13,$reasons))?'lightpink':'').'"><div class="reasons_x" r="13">x</div>Sənədi: '.Yii::t('app','document'.$announce["document"]).'</div>
            <div class="w'.$leftWidth.' '.((in_array(14,$reasons))?'lightpink':'').'"><div class="reasons_x" r="14">x</div>'.$announce["price"].' azn '.$rentType.'</div>
			<div class="w'.$leftWidth.' '.((in_array(22,$reasons))?'lightpink':'').'"><div class="reasons_x" r="22">x</div><span title="'.$announce["address"].'">Ünvan: '.$announce["address"].'</span></div>
            <div class="w'.$leftWidth.' '.((in_array(17,$reasons))?'lightpink':'').'"><div class="reasons_x" r="17">x</div>'.$this->context->cities[$announce["city"]].'</div>
            <div class="w'.$leftWidth.' '.((in_array(18,$reasons))?'lightpink':'').'"><div class="reasons_x" r="18">x</div>Rayon: '.$this->context->regions[$announce["region"]].'</div>
            
			
			<div class="w'.$leftWidth.' '.((in_array(19,$reasons))?'lightpink':'').'"><div class="reasons_x" r="19">x</div>Qəsəbə: '.$this->context->settlements[$announce["settlement"]].'</div>
            <div class="w'.$leftWidth.' '.((in_array(20,$reasons))?'lightpink':'').'"><div class="reasons_x" r="20">x</div>Metro: '.$this->context->metros[$announce["metro"]].'</div>
            <div class="w'.$leftWidth.' '.((in_array(21,$reasons))?'lightpink':'').'"><div class="reasons_x" r="21">x</div>
				<span>Nişangah:</span><br />'.$this->context->locationsGenerator($announce["mark"],'backend').'
			</div>
			<div class="w'.$leftWidth.' '.((in_array(11,$reasons))?'lightpink':'').'"><div class="reasons_x" r="10">x</div>'.$mertebe.'</div>
			<div class="w'.$leftWidth.'">'.$discount.'</div>
            <div class="hide w'.$leftWidth.' '.((in_array(25,$reasons))?'lightpink':'').'"><div class="reasons_x" r="25">x</div>'.$s25.'</div>
            <div id="modalRepeat'.$announce["id"].'" class="myModal">
                <span class="blue">Təkrar elanların kodlari:</span><br />
                178996, 489874, 487894<hr />
                <input class="btn btn-success btn-sm closeMyModal" value=" &nbsp; Bağla &nbsp; " type="button">
            </div>
			<input type="hidden" value="'.$announce["reasons"].'" id="reasons'.$announce["id"].'" name="reasons'.$announce["id"].'" />
        </div>
		
		<div style="float:left;margin-left:17px;font-size:15px;" class="main_div" data-idi="'.$announce["id"].'">
			<div class="w'.$leftWidth.' '.((in_array(16,$reasons))?'lightpink':'').'" style="width:760px;line-height: 20px;"><div class="reasons_x" r="16">x</div>'.$announce["text"].'</div>
			<div class="clearfix"></div>
			
			<div class="w'.$leftWidth.' '.((in_array(24,$reasons))?'lightpink':'').'" style="width:760px;"><div class="reasons_x" r="24">x</div>';
			$images=explode(",",$announce["images"]);
			foreach($images as $image)
			{
				$src=MyFunctions::getImageUrl().'/'.$image;
				echo '<img src="'.$src.'" height="200" style="margin-right:5px;margin-bottom:5px;float:left;" alt="" />';
			}
			echo '</div>
		</div>
        <div class="clearfix" style="margin-bottom:35px;"></div>
		</div>';
    }
    ?>
    </div>
	<input type="hidden" value="<?=$page?>" id="page" />
    <ul class="pagination" <?php if($count==0) echo 'style="display:none;"'; ?>>
        <?php
        //Paginator ///////////////////////////////////////////
		echo '<li class="next"><a href="'.Url::to([$link.'&page=1']).'">İlk</a></li>';
        if($page>1) echo '<li class="prev"><a href="'.Url::to([$link.'&page='.($page-1)]).'">«</a></li>';
        else echo '<li class="prev disabled"><span>«</span></li>';
        for($i=$page-$show;$i<=$page+$show;$i++)
        {
            if($i>0 && $i<=$max_page)
            {
                if($i==$page) echo '<li class="active"><a href="javascript:void(0);">'.$i.'</a></li>';
                else echo '<li><a href="'.Url::to([$link.'&page='.$i]).'">'.$i.'</a></li>';
            }
        }
        if($page<$max_page) echo '<li class="next"><a href="'.Url::to([$link.'&page='.($page+1)]).'">»</a></li>';
        else echo '<li class="prev disabled"><span>»</span></li>';
		echo '<li class="next"><a href="'.Url::to([$link.'&page='.$max_page]).'">Son</a></li>';
        //Paginator ///////////////////////////////////////////
        ?>
    </ul>
</div>