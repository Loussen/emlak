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
else $this->title = 'Yeni elanlar';

$bigWidth=2200;
?>
<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
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
<div class="categories-index">
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
		
		$code=MyFunctions::codeGeneratorforAdmin($announce["id"],$this->context->adminLoggedInfo[0]["ps"]);
		$editURL='../elan-ver/index?id='.$announce["id"].'&code='.$code.'&admin='.$this->context->adminLoggedInfo[0]["ps"];
			
        echo '
		<div id="ann_block_'.$announce["id"].'">
		<div class="w'.$leftWidth.' kod">
				Kod: '.$announce["id"].' -  '.date("d.m.Y H:i",$announce["announce_date"]).' - <a href="javascript:void(0);" target="_blank" title="'.date("d.m.Y H:i",$announce["announce_date"]).'"><input class="btn btn-success btn-sm" value="Arxiv" type="button" style="height: 17px;line-height: 7px;"></a>
				
				<div style="float:right;" data-idi="'.$announce["id"].'" data-edited="0">
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
		
		<div style="float:left;margin-left:17px;font-size:15px;">
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