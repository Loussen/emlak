<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use backend\components\MyFunctions;

$this->title = $searchModel::$titleNameSearch;

if($status==0) $title = 'Yeni elanlarda';
else if($status==1) $title = 'Aktiv elanlarda';
else if($status==2) $title = 'Bitmiş elanlarda';
else if($status==3) $title = 'Təsdiqlənməyən elanlarda';
else if($status==4) $title = 'Silinmiş elanlarda';
else if($status==5) $title = 'İrəli çəkilmiş elanlarda';
else if($status==6) $title = 'Təcili elanlarda';
else if($status==7) $title = 'Premium elanlarda';
else if($status==8) $title = 'Axtarışda irəli çəkilmiş elanlarda';
else if($status==9) { $this->title = 'Bütün elanlar'; $title=''; }
else if($status==10) { $this->title = 'Arxivdə görsənən elanlar'; $title=''; }
else $title = 'Bütün elanlarda';

?>
<div class="single-head">
    <h3 class="pull-left"><i class="fa fa-bars green"></i> <?= Html::encode($this->title).' / <a href="'.Url::to(['announces-search/index?status=all']).'">'.$title.'</a>'; ?> </h3>
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
        <form style="margin: 0 0 15px 0; display:none; border: 1px solid #ccc; padding: 5px; -webkit-border-radius: ;-moz-border-radius: ;border-radius: 3px;" action="<?=Url::to(['announces-search/index?status=9']); ?>" method="get" id="search_blok_all">
            <input type="hidden" name="status" value="<?=$status?>"
            <!--        <input type="hidden" name="ann_type" value="3">-->
            <div id="search" class="tabs-content s_b">
                <div class="drop-box" style="margin-bottom:10px; text-align:center;">
                    <select name="announce_type" class="SlectBox" style="width:24%; padding:8px;">
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
                    <select name="property_type" class="SlectBox" style="width:24%; padding:8px;">
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
                    <select name="repair" class="SlectBox" style="width:24%; padding:8px;">
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
                    <select name="city" style="width:24%; padding:8px;" class="SlectBox">
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
        <?php

    }

?>

<div class="categories-index">
    <form action="<?php echo Url::toRoute('deletemore'); ?>" method="post">
	<?php
	if($AnnouncesSearch=='') $layout="{errors}\n{items}\n{pager}"; else $layout="{errors}\n{summary}\n{items}\n{summary}\n{pager}";
	?>
    <?php
        if($status!=9 && $status!=10) {
    ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => $layout,
            'showFooter' =>false,
            'options' => [
                'class' => 'table-responsive',
            ],
            'tableOptions' => [
                'class' => 'table table-hover table-bordered',
            ],
            'columns' => [
                [
                    'class'=>'yii\grid\CheckboxColumn',
                    'name'=>'check[]',
                    'options' => ['width'=>30],
                    'checkboxOptions' => function ($data) {
                        return ['value' => $data["id"]];
                    }
                ],
                [
                    'attribute' => 'id',
                    'options' => ['width'=>90],
                    'format'=>'raw',
                    'value' =>function($data){
                            $return ='<div class="go_view">info</div>';
                            return $data["id"].'<a href="'.Url::toRoute(['announces/index?status='.$data["status"].'&id='.$data["id"]]).'">'.$return.'</a>';
                        }
                ],
                [
                    'attribute' => 'announce_date',
                    'options' => ['width'=>120],
                    'value' => function($data)
                        {
                            return date("d.m.Y H:i",$data["announce_date"]);
                        },
                ],
                [
                    'attribute' => 'email',
                    'options' => ['width'=>120],
                ],
                [
                    'attribute' => 'name',
                    'options' => ['width'=>120],
                    'value' =>function($data)
                        {
                            if($data["announcer"]==1) $who='Mülkiyyətçi'; else $who='Vasitəçi';
                            return html_entity_decode($data["name"]).' ('.$who.')';
                        }
                ],
                [
                    'attribute' => 'mobile',
                    'options' => ['width'=>130],
                    'value' =>function($data){
                        return str_replace('*',', ',$data["mobile"]);
                    }
                ],
                [
                    'attribute'=>'status',
                    'options' => ['width'=>100],
                    'filter'=>MyFunctions::getStatus(),
                    'format' => 'raw',
                    'value' => function($data) {
                            if($data["status"]==0) return Html::a('<i class="fa fa-circle white"></i> Gözləyir',Url::toRoute(['status?id='.$data["id"].'&status=0&changeStatus=1']),['class'=>'btn '.MyFunctions::getStatusTemplate($data["status"]).' btn-sm']);
                            else if($data["status"]==1) return Html::a('<i class="fa fa-circle white"></i> Aktivdir',Url::toRoute(['status?id='.$data["id"].'&status=0&changeStatus=3']),['class'=>'btn '.MyFunctions::getStatusTemplate($data["status"]).' btn-sm']);
                            else if($data["status"]==2 && $data["announce_date"]!=$data["create_time"]) return Html::a('<i class="fa fa-circle white"></i> Bitib',Url::toRoute(['status?id='.$data["id"].'&status=2&changeStatus=1']),['class'=>'btn '.MyFunctions::getStatusTemplate($data["status"]).' btn-sm']);
                            else if($data["status"]==3) return Html::a('<i class="fa fa-circle white"></i> deAktiv',Url::toRoute(['status?id='.$data["id"].'&status=0&changeStatus=1']),['class'=>'btn '.MyFunctions::getStatusTemplate($data["status"]).' btn-sm']);
                            else if($data["status"]==4 or ($data["status"]==2 && $data["announce_date"]==$data["create_time"]) ) return Html::a('<i class="fa fa-circle white"></i> Silinib',Url::toRoute(['status?id='.$data["id"].'&status=0&changeStatus=1']),['class'=>'btn '.MyFunctions::getStatusTemplate($data["status"]).' btn-sm']);
                            else return 'status aktivdir';
                        },
                ],
                [
                    'attribute'=>'SMS',
                    'options' => ['width'=>100],
                    'filter'=>MyFunctions::getSmsStatus(),
                    'format' => 'raw',
                    'value' => function($data) {
                        if($data["sms_status"]=="true") return Html::a('<i class="fa fa-circle white"></i> Aktivdir',Url::toRoute(['smstatus?id='.$data["id"].'&status=0&changeStatus=false']),['class'=>'btn '.MyFunctions::getStatusTemplate(1).' btn-sm']);
                        else return Html::a('<i class="fa fa-circle white"></i> deAktiv',Url::toRoute(['smstatus?id='.$data["id"].'&status=0&changeStatus=true']),['class'=>'btn '.MyFunctions::getStatusTemplate(0).' btn-sm']);
                    },
                ],
                [
                    'header' =>'Əməliyyatlar',
                    'format' => 'raw',
                    'options' => ['width'=>130],
                    'value' => function($data){
                            $code=MyFunctions::codeGeneratorforAdmin($data["id"],$this->context->adminLoggedInfo[0]["id"]);
                            $editURL='../elan-ver/index?id='.$data["id"].'&code='.$code.'&admin='.$this->context->adminLoggedInfo[0]["id"];
                            $endedURL='../cron/cron.php?process_type=ann&id='.$data["id"].'&code='.$code.'&admin='.$this->context->adminLoggedInfo[0]["id"];
                            //$title=$this->context->titleGenerator('az',$data["announce_type"],$data["property_type"],$data["space"],$data["room_count"],$data["mark"],$data["settlement"],$data["metro"],$data["region"],$data["city"],$data["address"]);
                            //$viewURL='../'.$data["id"].'-'.MyFunctions::slugGenerator($title).'.html';
                            $viewURL='../'.$data["id"].'-adminView.html';
                            $deleteURL='announces-search/delete/'.$data["id"];
                            $fullDeleteURL='announces-search/full_delete/'.$data["id"];

                            $fowardURL='announces-search/set_foward/'.$data["id"];
                            $urgentURL='announces-search/set_urgently/'.$data["id"];
                            $premiumURL='do-premium/create?id='.$data["id"];
                            $searchFowardURL='announces-search/set_search_foward/'.$data["id"];


                            return '
                            <a class="btn btn-warning btn-xs" href="'.Url::toRoute([$deleteURL]).'" title="Sil" aria-label="Sil" data-confirm="Bu elementi silmək istədiyinizə əminsinizmi?" data-method="post" data-pjax="0"><span class="glyphicon glyphicon-trash white"></span></a>
                            <a target="_blank" class="btn btn-success btn-xs" href="'.Url::toRoute([$viewURL]).'" title="Bax" aria-label="Bax" data-pjax="0"><span class="glyphicon glyphicon-eye-open white"></span></a>
                            <a target="_blank" class="btn btn-primary btn-xs" href="'.Url::toRoute([$editURL]).'" title="Yenilə" aria-label="Yenilə" data-pjax="0"><span class="glyphicon glyphicon-pencil white"></span></a>
                            <a class="btn btn-danger btn-xs" href="'.Url::toRoute([$fullDeleteURL]).'" title="Sil" aria-label="Sil" data-confirm="Bu elementi silmək istədiyinizə əminsinizmi?" data-method="post" data-pjax="0"><span class="glyphicon glyphicon-trash white"></span></a>
                            
                            <br />
                            <a class="btn btn-primary btn-xs" href="'.Url::toRoute([$fowardURL]).'" title="İrəli çək" aria-label="İrəli çək" data-pjax="0"><span class="glyphicon glyphicon-fast-forward white"></span></a>
                            <a class="btn btn-primary btn-xs" href="'.Url::toRoute([$urgentURL]).'" title="Təcili et" aria-label="Təcili et" data-pjax="0"><span class="glyphicon glyphicon-flash white"></span></a>
                            <a class="btn btn-primary btn-xs" href="'.Url::toRoute([$premiumURL]).'" title="Premium et" aria-label="Premium et" data-pjax="0"><span class="glyphicon glyphicon-star white"></span></a>
                            <a class="btn btn-primary btn-xs" href="'.Url::toRoute([$searchFowardURL]).'" title="Axtarışda irəli çək" aria-label="Axtarışda irəli çək" data-pjax="0"><span class="glyphicon glyphicon-search white"></span></a>
                            <a class="btn btn-primary btn-xs" href="'.Url::toRoute([$endedURL]).'" target="_blank" title="Elanı bitir" aria-label="Elanı bitir" data-pjax="0"><span class="glyphicon glyphicon-time white"></span></a>
                            ';
                        },
                ],
            ],
        ]); ?>
    <?php } elseif($status==9) { ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => $layout,
            'showFooter' =>false,
            'options' => [
                'class' => 'table-responsive',
            ],
            'tableOptions' => [
                'class' => 'table table-hover table-bordered',
            ],
            'columns' => [
                [
                    'class'=>'yii\grid\CheckboxColumn',
                    'name'=>'check[]',
                    'options' => ['width'=>30],
                    'checkboxOptions' => function ($data) {
                        return ['value' => $data["id"]];
                    }
                ],
                [
                    'attribute' => 'id',
                    'options' => ['width'=>90],
                    'format'=>'raw',
                    'value' =>function($data){
                        $return ='<div class="go_view">info</div>';
                        return $data["id"].'<a href="'.Url::toRoute(['announces/index?status='.$data["status"].'&id='.$data["id"]]).'">'.$return.'</a>';
                    }
                ],
                [
                    'attribute' => 'announce_date',
                    'options' => ['width'=>100],
                    'value' => function($data)
                    {
                        return date("d.m.Y H:i",$data["announce_date"]);
                    },
                ],
                [
                    'attribute' => 'create_time',
                    'options' => ['width'=>100],
                    'value' => function($data)
                    {
                        return date("d.m.Y H:i",$data["create_time"]);
                    },
                ],
                [
                    'attribute' => 'email',
                    'options' => ['width'=>100],
                ],
                [
                    'attribute' => 'name',
                    'options' => ['width'=>100],
                    'value' =>function($data)
                    {
                        if($data["announcer"]==1) $who='Mülkiyyətçi'; else $who='Vasitəçi';
                        return html_entity_decode($data["name"]).' ('.$who.')';
                    }
                ],
                [
                    'attribute' => 'mobile',
                    'options' => ['width'=>120],
                    'value' =>function($data){
                        return str_replace('*',', ',$data["mobile"]);
                    }
                ],
                [
                    'attribute'=>'status',
                    'options' => ['width'=>100],
                    'filter'=>MyFunctions::getStatus(),
                    'format' => 'raw',
                    'value' => function($data) {
                        if($data["status"]==0) return Html::a('<i class="fa fa-circle white"></i> Gözləyir',Url::toRoute(['status?id='.$data["id"].'&status=9&changeStatus=1']),['class'=>'btn '.MyFunctions::getStatusTemplate($data["status"]).' btn-sm']);
                        else if($data["status"]==1) return Html::a('<i class="fa fa-circle white"></i> Aktivdir',Url::toRoute(['status?id='.$data["id"].'&status=9&changeStatus=3']),['class'=>'btn '.MyFunctions::getStatusTemplate($data["status"]).' btn-sm']);
                        else if($data["status"]==2 && $data["announce_date"]!=$data["create_time"]) return Html::a('<i class="fa fa-circle white"></i> Bitib',Url::toRoute(['status?id='.$data["id"].'&status=2&changeStatus=1']),['class'=>'btn '.MyFunctions::getStatusTemplate($data["status"]).' btn-sm']);
                        else if($data["status"]==3) return Html::a('<i class="fa fa-circle white"></i> deAktiv',Url::toRoute(['status?id='.$data["id"].'&status=9&changeStatus=1']),['class'=>'btn '.MyFunctions::getStatusTemplate($data["status"]).' btn-sm']);
                        else if($data["status"]==4 or ($data["status"]==2 && $data["announce_date"]==$data["create_time"]) ) return Html::a('<i class="fa fa-circle white"></i> Silinib',Url::toRoute(['status?id='.$data["id"].'&status=9&changeStatus=1']),['class'=>'btn '.MyFunctions::getStatusTemplate($data["status"]).' btn-sm']);
                        else return 'status aktivdir';
                    },
                ],
                [
                    'attribute' => 'archive_view',
                    'options' => ['width'=>100],
                    'value' => function($data)
                    {
                        if($data["archive_view"]>0) return date("d.m.Y H:i",$data["archive_view"]);
                        else return '';
                    },
                ],
                [
                    'attribute'=>'archive_view',
                    'options' => ['width'=>80],
                    'format' => 'raw',
                    'value' => function($data) {
                        return Html::a('<i class="fa fa-circle white"></i> Arxiv et',Url::toRoute(['archiveview?id='.$data["id"].'&status=1&red_status=9']),['class'=>'btn '.MyFunctions::getStatusTemplate(1).' btn-sm']);
                    },
                ],
                [
                    'attribute'=>'archive_view',
                    'options' => ['width'=>80],
                    'format' => 'raw',
                    'value' => function($data) {
                        return Html::a('<i class="fa fa-circle white"></i> Arxiv imtina',Url::toRoute(['archiveview?id='.$data["id"].'&status=0&red_status=9']),['class'=>'btn '.MyFunctions::getStatusTemplate(0).' btn-sm']);
                    },
                ],
                [
                    'header' =>'Əməliyyatlar',
                    'format' => 'raw',
                    'options' => ['width'=>130],
                    'value' => function($data){
                        $code=MyFunctions::codeGeneratorforAdmin($data["id"],$this->context->adminLoggedInfo[0]["id"]);
                        $editURL='../elan-ver/index?id='.$data["id"].'&code='.$code.'&admin='.$this->context->adminLoggedInfo[0]["id"];
                        $endedURL='../cron/cron.php?process_type=ann&id='.$data["id"].'&code='.$code.'&admin='.$this->context->adminLoggedInfo[0]["id"];
                        //$title=$this->context->titleGenerator('az',$data["announce_type"],$data["property_type"],$data["space"],$data["room_count"],$data["mark"],$data["settlement"],$data["metro"],$data["region"],$data["city"],$data["address"]);
                        //$viewURL='../'.$data["id"].'-'.MyFunctions::slugGenerator($title).'.html';
                        $viewURL='../'.$data["id"].'-adminView.html';
                        $deleteURL='announces-search/delete/'.$data["id"];
                        $fullDeleteURL='announces-search/full_delete/'.$data["id"];

                        $fowardURL='announces-search/set_foward/'.$data["id"];
                        $urgentURL='announces-search/set_urgently/'.$data["id"];
                        $premiumURL='do-premium/create?id='.$data["id"];
                        $searchFowardURL='announces-search/set_search_foward/'.$data["id"];


                        return '
                            <a class="btn btn-warning btn-xs" href="'.Url::toRoute([$deleteURL]).'" title="Sil" aria-label="Sil" data-confirm="Bu elementi silmək istədiyinizə əminsinizmi?" data-method="post" data-pjax="0"><span class="glyphicon glyphicon-trash white"></span></a>
                            <a target="_blank" class="btn btn-success btn-xs" href="'.Url::toRoute([$viewURL]).'" title="Bax" aria-label="Bax" data-pjax="0"><span class="glyphicon glyphicon-eye-open white"></span></a>
                            <a target="_blank" class="btn btn-primary btn-xs" href="'.Url::toRoute([$editURL]).'" title="Yenilə" aria-label="Yenilə" data-pjax="0"><span class="glyphicon glyphicon-pencil white"></span></a>
                            <a class="btn btn-danger btn-xs" href="'.Url::toRoute([$fullDeleteURL]).'" title="Sil" aria-label="Sil" data-confirm="Bu elementi silmək istədiyinizə əminsinizmi?" data-method="post" data-pjax="0"><span class="glyphicon glyphicon-trash white"></span></a>
                            
                            <br />
                            <a class="btn btn-primary btn-xs" href="'.Url::toRoute([$fowardURL]).'" title="İrəli çək" aria-label="İrəli çək" data-pjax="0"><span class="glyphicon glyphicon-fast-forward white"></span></a>
                            <a class="btn btn-primary btn-xs" href="'.Url::toRoute([$urgentURL]).'" title="Təcili et" aria-label="Təcili et" data-pjax="0"><span class="glyphicon glyphicon-flash white"></span></a>
                            <a class="btn btn-primary btn-xs" href="'.Url::toRoute([$premiumURL]).'" title="Premium et" aria-label="Premium et" data-pjax="0"><span class="glyphicon glyphicon-star white"></span></a>
                            <a class="btn btn-primary btn-xs" href="'.Url::toRoute([$searchFowardURL]).'" title="Axtarışda irəli çək" aria-label="Axtarışda irəli çək" data-pjax="0"><span class="glyphicon glyphicon-search white"></span></a>
                            <a class="btn btn-primary btn-xs" href="'.Url::toRoute([$endedURL]).'" target="_blank" title="Elanı bitir" aria-label="Elanı bitir" data-pjax="0"><span class="glyphicon glyphicon-time white"></span></a>
                            ';
                    },
                ],
            ],
        ]); ?>
    <?php } elseif($status==10) { ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => $layout,
            'showFooter' =>false,
            'options' => [
                'class' => 'table-responsive',
            ],
            'tableOptions' => [
                'class' => 'table table-hover table-bordered',
            ],
            'columns' => [
                [
                    'class'=>'yii\grid\CheckboxColumn',
                    'name'=>'check[]',
                    'options' => ['width'=>30],
                    'checkboxOptions' => function ($data) {
                        return ['value' => $data["id"]];
                    }
                ],
                [
                    'attribute' => 'id',
                    'options' => ['width'=>90],
                    'format'=>'raw',
                    'value' =>function($data){
                        $return ='<div class="go_view">info</div>';
                        return $data["id"].'<a href="'.Url::toRoute(['announces/index?status='.$data["status"].'&id='.$data["id"]]).'">'.$return.'</a>';
                    }
                ],
                [
                    'attribute' => 'announce_date',
                    'options' => ['width'=>120],
                    'value' => function($data)
                    {
                        return date("d.m.Y H:i",$data["announce_date"]);
                    },
                ],
                [
                    'attribute' => 'email',
                    'options' => ['width'=>120],
                ],
                [
                    'attribute' => 'name',
                    'options' => ['width'=>120],
                    'value' =>function($data)
                    {
                        if($data["announcer"]==1) $who='Mülkiyyətçi'; else $who='Vasitəçi';
                        return html_entity_decode($data["name"]).' ('.$who.')';
                    }
                ],
                [
                    'attribute' => 'mobile',
                    'options' => ['width'=>130],
                    'value' =>function($data){
                        return str_replace('*',', ',$data["mobile"]);
                    }
                ],
                [
                    'attribute'=>'status',
                    'options' => ['width'=>100],
                    'filter'=>MyFunctions::getStatus(),
                    'format' => 'raw',
                    'value' => function($data) {
                        if($data["status"]==0) return Html::a('<i class="fa fa-circle white"></i> Gözləyir',Url::toRoute(['status?id='.$data["id"].'&status=10&changeStatus=1']),['class'=>'btn '.MyFunctions::getStatusTemplate($data["status"]).' btn-sm']);
                        else if($data["status"]==1) return Html::a('<i class="fa fa-circle white"></i> Aktivdir',Url::toRoute(['status?id='.$data["id"].'&status=10&changeStatus=3']),['class'=>'btn '.MyFunctions::getStatusTemplate($data["status"]).' btn-sm']);
                        else if($data["status"]==2 && $data["announce_date"]!=$data["create_time"]) return Html::a('<i class="fa fa-circle white"></i> Bitib',Url::toRoute(['status?id='.$data["id"].'&status=2&changeStatus=1']),['class'=>'btn '.MyFunctions::getStatusTemplate($data["status"]).' btn-sm']);
                        else if($data["status"]==3) return Html::a('<i class="fa fa-circle white"></i> deAktiv',Url::toRoute(['status?id='.$data["id"].'&status=10&changeStatus=1']),['class'=>'btn '.MyFunctions::getStatusTemplate($data["status"]).' btn-sm']);
                        else if($data["status"]==4 or ($data["status"]==2 && $data["announce_date"]==$data["create_time"]) ) return Html::a('<i class="fa fa-circle white"></i> Silinib',Url::toRoute(['status?id='.$data["id"].'&status=10&changeStatus=1']),['class'=>'btn '.MyFunctions::getStatusTemplate($data["status"]).' btn-sm']);
                        else return 'status aktivdir';
                    },
                ],
                [
                    'attribute' => 'archive_view',
                    'options' => ['width'=>120],
                    'value' => function($data)
                    {
                        if($data["archive_view"]>0) return date("d.m.Y H:i",$data["archive_view"]);
                        else return '';
                    },
                ],
                [
                    'attribute'=>'archive_view',
                    'options' => ['width'=>80],
                    'format' => 'raw',
                    'value' => function($data) {
                        return Html::a('<i class="fa fa-circle white"></i> Arxiv et',Url::toRoute(['archiveview?id='.$data["id"].'&status=1&red_status=10']),['class'=>'btn '.MyFunctions::getStatusTemplate(1).' btn-sm']);
                    },
                ],
                [
                    'attribute'=>'archive_view',
                    'options' => ['width'=>80],
                    'format' => 'raw',
                    'value' => function($data) {
                        return Html::a('<i class="fa fa-circle white"></i> Arxiv imtina',Url::toRoute(['archiveview?id='.$data["id"].'&status=0&red_status=10']),['class'=>'btn '.MyFunctions::getStatusTemplate(0).' btn-sm']);
                    },
                ],
                [
                    'header' =>'Əməliyyatlar',
                    'format' => 'raw',
                    'options' => ['width'=>130],
                    'value' => function($data){
                        $code=MyFunctions::codeGeneratorforAdmin($data["id"],$this->context->adminLoggedInfo[0]["id"]);
                        $editURL='../elan-ver/index?id='.$data["id"].'&code='.$code.'&admin='.$this->context->adminLoggedInfo[0]["id"];
                        $endedURL='../cron/cron.php?process_type=ann&id='.$data["id"].'&code='.$code.'&admin='.$this->context->adminLoggedInfo[0]["id"];
                        //$title=$this->context->titleGenerator('az',$data["announce_type"],$data["property_type"],$data["space"],$data["room_count"],$data["mark"],$data["settlement"],$data["metro"],$data["region"],$data["city"],$data["address"]);
                        //$viewURL='../'.$data["id"].'-'.MyFunctions::slugGenerator($title).'.html';
                        $viewURL='../'.$data["id"].'-adminView.html';
                        $deleteURL='announces-search/delete/'.$data["id"];
                        $fullDeleteURL='announces-search/full_delete/'.$data["id"];

                        $fowardURL='announces-search/set_foward/'.$data["id"];
                        $urgentURL='announces-search/set_urgently/'.$data["id"];
                        $premiumURL='do-premium/create?id='.$data["id"];
                        $searchFowardURL='announces-search/set_search_foward/'.$data["id"];


                        return '
                            <a class="btn btn-warning btn-xs" href="'.Url::toRoute([$deleteURL]).'" title="Sil" aria-label="Sil" data-confirm="Bu elementi silmək istədiyinizə əminsinizmi?" data-method="post" data-pjax="0"><span class="glyphicon glyphicon-trash white"></span></a>
                            <a target="_blank" class="btn btn-success btn-xs" href="'.Url::toRoute([$viewURL]).'" title="Bax" aria-label="Bax" data-pjax="0"><span class="glyphicon glyphicon-eye-open white"></span></a>
                            <a target="_blank" class="btn btn-primary btn-xs" href="'.Url::toRoute([$editURL]).'" title="Yenilə" aria-label="Yenilə" data-pjax="0"><span class="glyphicon glyphicon-pencil white"></span></a>
                            <a class="btn btn-danger btn-xs" href="'.Url::toRoute([$fullDeleteURL]).'" title="Sil" aria-label="Sil" data-confirm="Bu elementi silmək istədiyinizə əminsinizmi?" data-method="post" data-pjax="0"><span class="glyphicon glyphicon-trash white"></span></a>
                            
                            <br />
                            <a class="btn btn-primary btn-xs" href="'.Url::toRoute([$fowardURL]).'" title="İrəli çək" aria-label="İrəli çək" data-pjax="0"><span class="glyphicon glyphicon-fast-forward white"></span></a>
                            <a class="btn btn-primary btn-xs" href="'.Url::toRoute([$urgentURL]).'" title="Təcili et" aria-label="Təcili et" data-pjax="0"><span class="glyphicon glyphicon-flash white"></span></a>
                            <a class="btn btn-primary btn-xs" href="'.Url::toRoute([$premiumURL]).'" title="Premium et" aria-label="Premium et" data-pjax="0"><span class="glyphicon glyphicon-star white"></span></a>
                            <a class="btn btn-primary btn-xs" href="'.Url::toRoute([$searchFowardURL]).'" title="Axtarışda irəli çək" aria-label="Axtarışda irəli çək" data-pjax="0"><span class="glyphicon glyphicon-search white"></span></a>
                            <a class="btn btn-primary btn-xs" href="'.Url::toRoute([$endedURL]).'" target="_blank" title="Elanı bitir" aria-label="Elanı bitir" data-pjax="0"><span class="glyphicon glyphicon-time white"></span></a>
                            ';
                    },
                ],
            ],
        ]); ?>
    <?php } ?>
        <?= Html::submitButton('Seçilmişləri sil',['class'=>'btn btn-danger','data-confirm'=>'Əminsinizmi?']); ?>
        <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken(); ?>" />
    </form>
</div>