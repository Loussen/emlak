<?php
use yii\helpers\Html;
use yii\helpers\Url;
use backend\components\MyFunctions;

$this->title = $titleName;

$bigWidth=2800;
?>
<div class="single-head">
    <h3 class="pull-left"><i class="fa fa-bars green"></i> <?= Html::encode($this->title); ?></h3>
    <div class="clearfix"></div>
</div>

<div class="categories-index">
    <?php if($count==0) echo 'Yeni məlumat yoxdur'; ?>
    <div class="responsiv_div" style="border: none;<?php if($count==0) echo 'display:none;'; ?>">
        <div style="font-weight: bold;border: none;width:<?=$bigWidth;?>px;max-height: 25px!important;overflow: hidden;">
            <div class="w60">Kod</div>
            <div class="w150">Ad</div>
<!--            <div class="w80">Ölkə</div>-->
            <div class="w120">Telefon</div>
            <div class="w170">Email</div>
            <div class="w110">Elan yerləşdirən</div>
            <div class="w80">Elanın növü</div>
            <div class="w90">Əmlakın növü</div>
            <div class="w70">Otaq sayı</div>
            <div class="w70">Sahəsi</div>
            <div class="w120">Yerləşdiyi mərtəbə</div>
            <div class="w90">Mərtəbə sayı</div>
            <div class="w70">Təmiri</div>
            <div class="w80">Sənədin tipi</div>
            <div class="w70">Qiymət</div>
            <div class="w100">İcarə müddəti</div>
            <div class="w100">Əmlakın təsviri</div>
            <div class="w120">Şəhər</div>
            <div class="w120">Rayon</div>
            <div class="w120">Qəsəbə</div>
            <div class="w120">Metro</div>
            <div class="w100">Nişangah</div>
            <div class="w170">Ünvan</div>
            <div class="w100">Endirim</div>
            <div class="w100">Xəritə</div>
            <div class="w100">Şəkillər</div>
            <div class="w100">Status</div>
            <div class="w90"></div>
        </div>
        <div class="clearfix"></div>
        <?php
        foreach($editedAnnounces as $announce)
        {
            $changed=false;
            if($realAnnounces[$announce["announce_id"]]["name"]!=$announce["name"]) {$s1='<hr /><span class="diff" title="'.$announce["name"].'">'.$announce["name"].'</span>'; $changed=true;} else $s1='';
//            if($realAnnounces[$announce["announce_id"]]["country"]!=$announce["country"]) {$s2='<hr /><span class="diff">'.$this->context->countries[$announce["country"]].'</span>'; $changed=true;} else $s2='';
            if($realAnnounces[$announce["announce_id"]]["mobile"]!=$announce["mobile"]) {$s3='<hr /><span class="diff" title="'.str_replace('*',',',$announce["mobile"]).'">'.str_replace('*',',',$announce["mobile"]).'</span>'; $changed=true;} else $s3='';
            if($realAnnounces[$announce["announce_id"]]["email"]!=$announce["email"]) {$s4='<hr /><span class="diff" title="'.$announce["email"].'">'.$announce["email"].'</span>'; $changed=true;} else $s4='';
            if($realAnnounces[$announce["announce_id"]]["announcer"]!=$announce["announcer"]) {$s5='<hr /><span class="diff">'.Yii::t('app','announcer'.$announce["announcer"]).'</span>'; $changed=true;} else $s5='';
            if($realAnnounces[$announce["announce_id"]]["announce_type"]!=$announce["announce_type"]) {$s6='<hr /><span class="diff">'.Yii::t('app','announce_type'.$announce["announce_type"]).'</span>'; $changed=true;} else $s6='';
            if($realAnnounces[$announce["announce_id"]]["property_type"]!=$announce["property_type"]) {$s7='<hr /><span class="diff">'.Yii::t('app','property_type'.$announce["property_type"]).'</span>'; $changed=true;} else $s7='';
            if($realAnnounces[$announce["announce_id"]]["room_count"]!=$announce["room_count"]) {$s8='<hr /><span class="diff">'.$announce["room_count"].'</span>'; $changed=true;} else $s8='';
            if($realAnnounces[$announce["announce_id"]]["space"]!=$announce["space"]) {$s9='<hr /><span class="diff">'.$announce["space"].'</span>'; $changed=true;} else $s9='';
            if($realAnnounces[$announce["announce_id"]]["current_floor"]!=$announce["current_floor"]) {$s10='<hr /><span class="diff">'.$announce["current_floor"].'</span>'; $changed=true;} else $s10='';
            if($realAnnounces[$announce["announce_id"]]["floor_count"]!=$announce["floor_count"]) {$s11='<hr /><span class="diff">'.$announce["floor_count"].'</span>'; $changed=true;} else $s11='';
            if($realAnnounces[$announce["announce_id"]]["repair"]!=$announce["repair"]) {$s12='<hr /><span class="diff">'.Yii::t('app','repair'.$announce["repair"]).'</span>'; $changed=true;} else $s12='';
            if($realAnnounces[$announce["announce_id"]]["document"]!=$announce["document"]) {$s13='<hr /><span class="diff">'.Yii::t('app','document'.$announce["document"]).'</span>'; $changed=true;} else $s13='';
            if($realAnnounces[$announce["announce_id"]]["price"]!=$announce["price"]) {$s14='<hr /><span class="diff">'.$announce["price"].'</span>'; $changed=true;} else $s14='';

            if($realAnnounces[$announce["announce_id"]]["announce_type"]==2) $s15=Yii::t('app','rent_type'.$realAnnounces[$announce["announce_id"]]["rent_type"]); else $s15='';
            if($realAnnounces[$announce["announce_id"]]["rent_type"]!=$announce["rent_type"]) {$s15.='<hr /><span class="diff">'.Yii::t('app','rent_type'.$announce["rent_type"]).'</span>'; $changed=true;} else $s15.='';

            if(trim($realAnnounces[$announce["announce_id"]]["text"])!=trim($announce["text"]) )
            {$class='danger'; $word='Dəyişilib'; $changed=true;} else {$class='success'; $word='Bax';}
            $s16='<input class="btn btn-'.$class.' btn-sm showMyModal" data-id="modalText'.$announce["announce_id"].'" value=" &nbsp; '.$word.' &nbsp; " type="button">';

            if($realAnnounces[$announce["announce_id"]]["city"]!=$announce["city"]) {$s17='<hr /><span class="diff">'.$this->context->cities[$announce["city"]].'</span>'; $changed=true;} else $s17='';
            if($realAnnounces[$announce["announce_id"]]["region"]!=$announce["region"]) {$s18='<hr /><span class="diff">'.$this->context->regions[$announce["region"]].'</span>'; $changed=true;} else $s18='';
            if($realAnnounces[$announce["announce_id"]]["settlement"]!=$announce["settlement"]) {$s19='<hr /><span class="diff">'.$this->context->settlements[$announce["settlement"]].'</span>'; $changed=true;} else $s19='';
            if($realAnnounces[$announce["announce_id"]]["metro"]!=$announce["metro"]) {$s20='<hr /><span class="diff">'.$this->context->metros[$announce["metro"]].'</span>'; $changed=true;} else $s20='';

            if($realAnnounces[$announce["announce_id"]]["mark"]!=$announce["mark"])
            {$class='danger'; $word='Dəyişilib'; $changed=true;} else {$class='success'; $word='Bax';}
            $s21='<input class="btn btn-'.$class.' btn-sm showMyModal" data-id="modalMark'.$announce["announce_id"].'" value=" &nbsp; '.$word.' &nbsp; " type="button">';
            if($realAnnounces[$announce["announce_id"]]["address"]!=$announce["address"]) {$s22='<hr /><span class="diff" title="'.$announce["address"].'">'.$announce["address"].'</span>'; $changed=true;} else $s22='';

            if($realAnnounces[$announce["announce_id"]]["discount"]!=$announce["discount"]) {$s25='<hr /><span class="diff">'.Yii::t('app','discount'.$announce["discount"]).'</span>'; $changed=true;} else $s25='';

            if($realAnnounces[$announce["announce_id"]]["google_map"]!=$announce["google_map"])
            {$class='danger'; $word='Dəyişilib'; $changed=true;} else {$class='success'; $word='Bax';}
            $s23='<input class="btn btn-'.$class.' btn-sm showMyModal" data-id="modalMap'.$announce["announce_id"].'" value=" &nbsp; '.$word.' &nbsp; " type="button">';

            if($realAnnounces[$announce["announce_id"]]["images"]!=$announce["images"])
            {$class='danger'; $word='Dəyişilib'; $changed=true;} else {$class='success'; $word='Bax';}
            if($changed==false) { $s24='<input class="btn btn-danger btn-sm imageChanged" value="Çevrilib" type="button">'; $rotatedUrl='&rotated=1'; }
            else  { $s24='<input class="btn btn-'.$class.' btn-sm imageChanged" value=" &nbsp; '.$word.' &nbsp; " type="button">'; $rotatedUrl=''; }

            $reasons=explode('-',$announce["reasons"]);

            if($realAnnounces[$announce["announce_id"]]["status"]==0)
                $status = "Gözləmədə";
            elseif($realAnnounces[$announce["announce_id"]]["status"]==1)
                $status = "Aktiv";
            elseif($realAnnounces[$announce["announce_id"]]["status"]==2)
                $status = "Bitmiş";
            elseif($realAnnounces[$announce["announce_id"]]["status"]==3)
                $status = "Təsdiqlənməmiş";
            elseif($realAnnounces[$announce["announce_id"]]["status"]==4)
                $status = "Silinmiş";

            echo '<div style="border: none;width:'.$bigWidth.'px;" class="main_div" data-idi="'.$announce["announce_id"].'" id="ann_block_'.$announce["announce_id"].'">
            <div class="w60">'.$realAnnounces[$announce["announce_id"]]["id"].'<hr style="margin-top: 2px;margin-bottom: 3px;" />
            <a href="javascript:void(0);" onclick="window.open(\''.Url::toRoute(['announces/showarchive','id'=>$realAnnounces[$announce["announce_id"]]["id"]]).'\', \'_blank\', \'resizable=0,toolbar=0,location=0,menubar=0,width=900, height=500\');" title="'.date("d.m.Y H:i",$announce["create_time"]).'"><input class="btn btn-success btn-sm" value="Arxiv" type="button" style="height: 18px;line-height: 7px;"></a>
            </div>
            <div class="w150 '.((in_array(1,$reasons))?'lightpink':'').'"><div class="reasons_x" r="1">x</div><span title="'.$realAnnounces[$announce["announce_id"]]["name"].'">'.$realAnnounces[$announce["announce_id"]]["name"].'</span>'.$s1.'</div>
            
            <div class="w120 '.((in_array(3,$reasons))?'lightpink':'').'"><div class="reasons_x" r="3">x</div><div style="max-height:27px;overflow:hidden;" title="'.str_replace('*',',',$realAnnounces[$announce["announce_id"]]["mobile"]).'">'.str_replace('*',',',$realAnnounces[$announce["announce_id"]]["mobile"]).'</div>
			'.$s3.'</div>
            <div class="w170 '.((in_array(4,$reasons))?'lightpink':'').'"><div class="reasons_x" r="4">x</div><span title="'.$realAnnounces[$announce["announce_id"]]["email"].'">'.$realAnnounces[$announce["announce_id"]]["email"].'</span>'.$s4.'</div>
            <div class="w110 '.((in_array(5,$reasons))?'lightpink':'').'"><div class="reasons_x" r="5">x</div>'.Yii::t('app','announcer'.$realAnnounces[$announce["announce_id"]]["announcer"]).$s5.'</div>
            <div class="w80 '.((in_array(6,$reasons))?'lightpink':'').'"><div class="reasons_x" r="6">x</div>'.Yii::t('app','announce_type'.$realAnnounces[$announce["announce_id"]]["announce_type"]).$s6.'</div>
            <div class="w90 '.((in_array(7,$reasons))?'lightpink':'').'"><div class="reasons_x" r="7">x</div>'.Yii::t('app','property_type'.$realAnnounces[$announce["announce_id"]]["property_type"]).$s7.'</div>
            <div class="w70 '.((in_array(8,$reasons))?'lightpink':'').'"><div class="reasons_x" r="8">x</div>'.$realAnnounces[$announce["announce_id"]]["room_count"].$s8.'</div>
            <div class="w70 '.((in_array(9,$reasons))?'lightpink':'').'"><div class="reasons_x" r="9">x</div>'.$realAnnounces[$announce["announce_id"]]["space"].$s9.'</div>
            <div class="w120 '.((in_array(10,$reasons))?'lightpink':'').'"><div class="reasons_x" r="10">x</div>'.$realAnnounces[$announce["announce_id"]]["current_floor"].$s10.'</div>
            <div class="w90 '.((in_array(11,$reasons))?'lightpink':'').'"><div class="reasons_x" r="11">x</div>'.$realAnnounces[$announce["announce_id"]]["floor_count"].$s11.'</div>
            <div class="w70 '.((in_array(12,$reasons))?'lightpink':'').'"><div class="reasons_x" r="12">x</div>'.Yii::t('app','repair'.$realAnnounces[$announce["announce_id"]]["repair"]).$s12.'</div>
            <div class="w80 '.((in_array(13,$reasons))?'lightpink':'').'"><div class="reasons_x" r="13">x</div>'.Yii::t('app','document'.$realAnnounces[$announce["announce_id"]]["document"]).$s13.'</div>
            <div class="w70 '.((in_array(14,$reasons))?'lightpink':'').'"><div class="reasons_x" r="14">x</div>'.$realAnnounces[$announce["announce_id"]]["price"].$s14.'</div>
            <div class="w100 '.((in_array(15,$reasons))?'lightpink':'').'"><div class="reasons_x" r="15">x</div>'.$s15.'</div>
            <div class="w100 '.((in_array(16,$reasons))?'lightpink':'').'"><div class="reasons_x" r="16">x</div>'.$s16.'</div>
                <div id="modalText'.$announce["announce_id"].'" class="myModal">
                    <span class="blue">Köhnə:</span><br />'.$realAnnounces[$announce["announce_id"]]["text"].'<br /><hr />
                    <span class="blue">Yeni:</span><br />
                    '.$announce["text"].'<hr />
                    <input class="btn btn-success btn-sm closeMyModal" value=" &nbsp; Bağla &nbsp; " type="button">
                </div>
            <div class="w120 '.((in_array(17,$reasons))?'lightpink':'').'"><div class="reasons_x" r="17">x</div>'.$this->context->cities[$realAnnounces[$announce["announce_id"]]["city"]].$s17.'</div>
            <div class="w120 '.((in_array(18,$reasons))?'lightpink':'').'"><div class="reasons_x" r="18">x</div>'.$this->context->regions[$realAnnounces[$announce["announce_id"]]["region"]].$s18.'</div>
            <div class="w120 '.((in_array(19,$reasons))?'lightpink':'').'"><div class="reasons_x" r="19">x</div>'.$this->context->settlements[$realAnnounces[$announce["announce_id"]]["settlement"]].$s19.'</div>
            <div class="w120 '.((in_array(20,$reasons))?'lightpink':'').'"><div class="reasons_x" r="20">x</div>'.$this->context->metros[$realAnnounces[$announce["announce_id"]]["metro"]].$s20.'</div>
            <div class="w100 '.((in_array(21,$reasons))?'lightpink':'').'"><div class="reasons_x" r="21">x</div>'.$s21.'</div>
                <div id="modalMark'.$announce["announce_id"].'" class="myModal">
                    <span class="blue">Köhnə:</span><br />'.$this->context->locationsGenerator($realAnnounces[$announce["announce_id"]]["mark"],'backend').'<br /><hr />
                    <span class="blue">Yeni:</span><br />'.$this->context->locationsGenerator($announce["mark"],'backend').'<hr />
                    <input class="btn btn-success btn-sm closeMyModal" value=" &nbsp; Bağla &nbsp; " type="button">
                </div>

            <div class="w170 '.((in_array(22,$reasons))?'lightpink':'').'"><div class="reasons_x" r="22">x</div><span title="'.$realAnnounces[$announce["announce_id"]]["address"].'">'.$realAnnounces[$announce["announce_id"]]["address"].'</span>'.$s22.'</div>
			
            <div class="w100"><span title="'.Yii::t('app','discount'.$announce["discount"]).'">'.Yii::t('app','discount'.$realAnnounces[$announce["announce_id"]]["discount"]).'</span>'.$s25.'</div>
			
            <div class="w100 '.((in_array(23,$reasons))?'lightpink':'').'"><div class="reasons_x" r="23">x</div>'.$s23.'</div>
                <div id="modalMap'.$announce["announce_id"].'" class="myModal">
                    <span class="blue">Köhnə:</span><br />
                    
                    <iframe src="https://www.google.com/maps/embed/v1/place?q='.$realAnnounces[$announce["announce_id"]]["google_map"].'&key=AIzaSyD3qS8H5B9QsvMJH_CPOR0Sflu0Pyh8MT0" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
                    <br /><hr />
                    <span class="blue">Yeni:</span><br />
                    
                    <iframe src="https://www.google.com/maps/embed/v1/place?q='.$announce["google_map"].'&key=AIzaSyD3qS8H5B9QsvMJH_CPOR0Sflu0Pyh8MT0" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen></iframe><hr />
                    <input class="btn btn-success btn-sm closeMyModal" value=" &nbsp; Bağla &nbsp; " type="button">
                </div>
            <div class="w100 '.((in_array(24,$reasons))?'lightpink':'').'"><div class="reasons_x" r="24">x</div><a onclick="window.open(\''.Url::toRoute(['announces-edited/showimages?id='.$announce["id"].$rotatedUrl]).'\', \'_blank\', \'resizable=0,toolbar=0,location=0,menubar=0,width=900, height=500\');" href="javascript:void(0);" target="_blank">'.$s24.'</a></div>
            <div class="w100">'.$status.'</div>
			';

            $code=MyFunctions::codeGeneratorforAdmin($announce["announce_id"],$this->context->adminLoggedInfo[0]["id"]);
            $editURL='../elan-ver/index?id='.$announce["announce_id"].'&code='.$code.'&admin='.$this->context->adminLoggedInfo[0]["id"].'&edited=1';

            echo '
            <div class="w90" data-idi="'.$announce["announce_id"].'" data-edited="1">
                <a target="_blank" href="'.Url::toRoute($editURL).'"><img class="edit" src="'.MyFunctions::getImageUrl().'/ico/edit-icon.png" alt="" width="20" /></a> &nbsp;
                <img class="edited_save" src="'.MyFunctions::getImageUrl().'/ico/ok-icon.png" alt="" width="20" /> &nbsp;
                <img class="edited_not_save" src="'.MyFunctions::getImageUrl().'/ico/close-icon.png" alt="" width="20" /> &nbsp;
            </div>
            <input type="hidden" value="-" id="reasons'.$announce["announce_id"].'" />
			<div class="clearfix" style="margin-bottom:5px;"></div>
        </div>';
        }
        ?>
    </div>
    <input type="hidden" value="<?=$status;?>" id="status" />

    <ul class="pagination" <?php if($count==0) echo 'style="display:none;"'; ?>>
        <?php
        //Paginator ///////////////////////////////////////////
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
        if($page<$max_page) echo '<li class="next"><a href="'.Url::to([$link.'&page='.($page+1)]).'">«</a></li>';
        else echo '<li class="prev disabled"><span>»</span></li>';
        //Paginator ///////////////////////////////////////////
        ?>
    </ul>


    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken(); ?>" />
</div>
<?php /*
    Maps old code

 <img src="http://maps.google.com/maps/api/staticmap?center='.$realAnnounces[$announce["announce_id"]]["google_map"].'&zoom=14&size=530x230&maptype=roadmap&sensor=false&language=&markers=color:red|label:none|'.$realAnnounces[$announce["announce_id"]]["google_map"].'" alt="" />

 */ ?>