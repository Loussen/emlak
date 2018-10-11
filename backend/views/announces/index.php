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
if($status==0 && $id==0){
	//$hideClass='hide';
	$hideClass='';
	//$bigWidth=1270;
}
else $hideClass='';
?>
<div class="categories-index">
    <?php if($count==0) echo 'Yeni məlumat yoxdur'; ?>
    <div class="responsiv_div" style="border: none;<?php if($count==0) echo 'display:none;'; ?>">
            <div style="font-weight: bold;border: none;width:<?=$bigWidth;?>px;max-height: 25px!important;overflow: hidden;">
                <div class="w60">Kod</div>
                <div class="w90">Ad</div>
                <div class="w80">Ölkə</div>
                <div class="w120">Telefon</div>
                <div class="w150 <?=$hideClass?>">Email</div>
                <div class="w80 <?=$hideClass?>">Elan verən</div>
                <div class="w50">Elan</div>
                <div class="w90">Əmlakın növü</div>
                <div class="w40 <?=$hideClass?>">Ot.S</div>
                <div class="w50">Sahə</div>
                <div class="w70 <?=$hideClass?>">Təmiri</div>
                <div class="w80 <?=$hideClass?>">Sənədin tipi</div>
                <div class="w70">Qiymət</div>
                <div class="w50 <?=$hideClass?>">İcarə</div>
                <div class="w70">Mətn</div>
                <div class="w80">Şəhər</div>
                <div class="w100 <?=$hideClass?>">Rayon</div>
                <div class="w100 <?=$hideClass?>">Qəsəbə</div>
                <div class="w100 <?=$hideClass?>">Metro</div>
                <div class="w70 <?=$hideClass?>">Nişan</div>
                <div class="w170">Ünvan</div>
                <div class="w70">Xəritə</div>
				<div class="w60">Mər.</div>
                <div class="w70">Şəkillər</div>
                <div class="w120 <?=$hideClass?>">Oxşar elan</div>
                <div class="w100"></div>
            </div>
            <div class="clearfix"></div>
    <?php
    foreach($announces as $announce)
    {
        $s16='<input class="btn btn-success btn-sm showMyModal" data-id="modalText'.$announce["id"].'" value=" &nbsp; Bax &nbsp; " type="button">';
        if($announce["mark"]!='') $s21='<input class="btn btn-success btn-sm showMyModal" data-id="modalMark'.$announce["id"].'" value=" &nbsp; Bax &nbsp; " type="button">'; else $s21='';
        if($announce["google_map"]!='') $s23='<input class="btn btn-success btn-sm showMyModal" data-id="modalMap'.$announce["id"].'" onclick="javascript:initialize_map('.$announce["id"].');" value=" &nbsp; Bax &nbsp; " type="button">'; else $s23='';
        $s24='<input class="btn btn-success btn-sm" value=" &nbsp; Bax &nbsp; " type="button">';


        if($sameAnnounces=='tekrar_elan_varsa')
        {$class='danger'; $word='Təkrardır';} else {$class='success'; $word='Təkrar deyil';}
        $s25='<input class="btn btn-'.$class.' btn-sm showMyModal" data-id="modalRepeat'.$announce["id"].'" btn-sm" value=" &nbsp; '.$word.' &nbsp; " type="button">';

        $reasons=explode('-',$announce["reasons"]);
		
		if($announce["property_type"]!=7) $repair=Yii::t('app','repair'.$announce["repair"]); else $repair='';
		if($announce["announce_type"]==2) $rentType=Yii::t('app','rent_type'.$announce["rent_type"]); else $rentType='';
        echo '<div style="border: none;width:'.$bigWidth.'px;" class="main_div" data-idi="'.$announce["id"].'" id="ann_block_'.$announce["id"].'">
            <div class="w60">'.$announce["id"].'<hr style="margin-top: 2px;margin-bottom: 3px;" />
            <a href="javascript:void(0);" onclick="window.open(\''.Url::toRoute(['announces/showarchive','id'=>$announce["id"]]).'\', \'_blank\', \'resizable=0,toolbar=0,location=0,menubar=0,width=900, height=500\');" title="'.date("d.m.Y H:i",$announce["announce_date"]).'"><input class="btn btn-success btn-sm" value="Arxiv" type="button" style="height: 18px;line-height: 7px;"></a>
            </div>
            <div class="w90 '.((in_array(1,$reasons))?'lightpink':'').'"><div class="reasons_x" r="1">x</div><span title="'.$announce["name"].'">'.$announce["name"].'</span>'.'</div>
            <div class="w80 '.((in_array(2,$reasons))?'lightpink':'').'"><div class="reasons_x" r="2">x</div>'.$this->context->countries[$announce["country"]].'</div>
            <div class="w120 '.((in_array(3,$reasons))?'lightpink':'').'"><div class="reasons_x" r="3">x</div>'.str_replace('*',',',$announce["mobile"]).'</div>
            <div class="w150 '.((in_array(4,$reasons))?'lightpink':'').' '.$hideClass.'"><div class="reasons_x" r="4">x</div><span title="'.$announce["email"].'">'.$announce["email"].'</span>'.'</div>
            <div class="w80 '.((in_array(5,$reasons))?'lightpink':'').' '.$hideClass.'"><div class="reasons_x" r="5">x</div>'.Yii::t('app','announcer'.$announce["announcer"]).'</div>
            <div class="w50 '.((in_array(6,$reasons))?'lightpink':'').'"><div class="reasons_x" r="6">x</div>'.Yii::t('app','announce_type'.$announce["announce_type"]).'</div>
            <div class="w90 '.((in_array(7,$reasons))?'lightpink':'').'"><div class="reasons_x" r="7">x</div>'.Yii::t('app','property_type'.$announce["property_type"]).'</div>
            <div class="w40 '.((in_array(8,$reasons))?'lightpink':'').' '.$hideClass.'"><div class="reasons_x" r="8">x</div>'.$announce["room_count"].'</div>
            <div class="w50 '.((in_array(9,$reasons))?'lightpink':'').'"><div class="reasons_x" r="9">x</div>'.$announce["space"].'</div>
            
            
            <div class="w70 '.((in_array(12,$reasons))?'lightpink':'').' '.$hideClass.'"><div class="reasons_x" r="12">x</div>'.$repair.'</div>
            <div class="w80 '.((in_array(13,$reasons))?'lightpink':'').' '.$hideClass.'"><div class="reasons_x" r="13">x</div>'.Yii::t('app','document'.$announce["document"]).'</div>
            <div class="w70 '.((in_array(14,$reasons))?'lightpink':'').'"><div class="reasons_x" r="14">x</div>'.$announce["price"].'</div>
            <div class="w50 '.((in_array(15,$reasons))?'lightpink':'').' '.$hideClass.'"><div class="reasons_x" r="15">x</div>'.$rentType.'</div>
            <div class="w70 '.((in_array(16,$reasons))?'lightpink':'').'"><div class="reasons_x" r="16">x</div>'.$s16.'</div>
                <div id="modalText'.$announce["id"].'" class="myModal">
                    <span class="blue">Mətn:</span><br />
                    '.$announce["text"].'<hr />
                    <input class="btn btn-success btn-sm closeMyModal" value=" &nbsp; Bağla &nbsp; " type="button">
                </div>
            <div class="w80 '.((in_array(17,$reasons))?'lightpink':'').'"><div class="reasons_x" r="17">x</div>'.$this->context->cities[$announce["city"]].'</div>
            <div class="w100 '.((in_array(18,$reasons))?'lightpink':'').' '.$hideClass.'"><div class="reasons_x" r="18">x</div>'.$this->context->regions[$announce["region"]].'</div>
            <div class="w100 '.((in_array(19,$reasons))?'lightpink':'').' '.$hideClass.'"><div class="reasons_x" r="19">x</div>'.$this->context->settlements[$announce["settlement"]].'</div>
            <div class="w100 '.((in_array(20,$reasons))?'lightpink':'').' '.$hideClass.'"><div class="reasons_x" r="20">x</div>'.$this->context->metros[$announce["metro"]].'</div>
            <div class="w70 '.((in_array(21,$reasons))?'lightpink':'').' '.$hideClass.'"><div class="reasons_x" r="21">x</div>'.$s21.'</div>
                <div id="modalMark'.$announce["id"].'" class="myModal">
                    <span class="blue">Nişangah:</span><br />'.$this->context->locationsGenerator($announce["mark"],'backend').'<hr />
                    <input class="btn btn-success btn-sm closeMyModal" value=" &nbsp; Bağla &nbsp; " type="button">
                </div>

            <div class="w170 '.((in_array(22,$reasons))?'lightpink':'').'"><div class="reasons_x" r="22">x</div><span title="'.$announce["address"].'">'.$announce["address"].'</span></div>
            <div class="w70 '.((in_array(23,$reasons))?'lightpink':'').'"><div class="reasons_x" r="23">x</div>'.$s23.'</div>
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
			
			<div class="w60 '.((in_array(10,$reasons))?'lightpink':'').'"><div class="reasons_x" r="10">x</div>'.$announce["current_floor"].' / '.$announce["floor_count"].'</div>
			
            <div class="w70 '.((in_array(24,$reasons))?'lightpink':'').'"><div class="reasons_x" r="24">x</div><a onclick="window.open(\''.Url::toRoute(['announces/showimages','id'=>$announce["id"]]).'\', \'_blank\', \'resizable=0,toolbar=0,location=0,menubar=0,width=900, height=500\');" href="javascript:void(0);" target="_blank">'.$s24.'</a></div>

            <div class="w120 '.((in_array(25,$reasons))?'lightpink':'').' '.$hideClass.'"><div class="reasons_x" r="25">x</div>'.$s25.'</div>
            <div id="modalRepeat'.$announce["id"].'" class="myModal">
                <span class="blue">Təkrar elanların kodlari:</span><br />
                178996, 489874, 487894<hr />
                <input class="btn btn-success btn-sm closeMyModal" value=" &nbsp; Bağla &nbsp; " type="button">
            </div>';

		$code=MyFunctions::codeGeneratorforAdmin($announce["id"],$this->context->adminLoggedInfo[0]["id"]);
		$editURL='../elan-ver/index?id='.$announce["id"].'&code='.$code.'&admin='.$this->context->adminLoggedInfo[0]["id"];
		$fullDeleteURL='announces-search/full_delete/'.$announce["id"];
		
        echo '
            <div class="w100" data-idi="'.$announce["id"].'" data-edited="0">
                <a target="_blank" href="'.Url::toRoute($editURL).'"><img class="edit" src="'.MyFunctions::getImageUrl().'/ico/edit-icon.png" alt="" width="17" /></a>&nbsp;
                <img class="edited_save" src="'.MyFunctions::getImageUrl().'/ico/ok-icon.png" alt="" width="17" />&nbsp;
                <img class="edited_not_save" src="'.MyFunctions::getImageUrl().'/ico/close-icon.png" alt="" width="17" />&nbsp;
                <img class="delete_announce" src="'.MyFunctions::getImageUrl().'/ico/delete-icon.png" alt="" width="17" />&nbsp;
                <a class="btn btn-danger btn-xs hide" href="'.Url::toRoute([$fullDeleteURL]).'" title="Sil" aria-label="Sil" data-confirm="Bu elementi silmək istədiyinizə əminsinizmi?" data-method="post" data-pjax="0"><span class="glyphicon glyphicon-trash white"></span></a>
            </div>
            <input type="hidden" value="'.$announce["reasons"].'" id="reasons'.$announce["id"].'" name="reasons'.$announce["id"].'" />
			<div class="clearfix" style="margin-bottom:5px;"></div>
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


    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken(); ?>" />
</div>