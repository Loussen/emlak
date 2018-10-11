<?php
use yii\helpers\Url;

$checked = '';
extract($_GET);

if(isset($search_type_check) && !empty($search_type_check)) $search_type_check=intval($search_type_check); else $search_type_check=0;
if(isset($yotaq) && is_array($yotaq) && count($yotaq)>0) $yotaq=$yotaq; else $yotaq=array();
if(isset($kotaq) && is_array($kotaq) && count($kotaq)>0) $kotaq=$kotaq; else $kotaq=array();
if(isset($tip) && is_array($tip) && count($tip)>0) $tip=$tip; else $tip=array();
if(isset($rent_type_gun) && !empty($rent_type_gun)) $rent_type_gun=intval($rent_type_gun); else $rent_type_gun=0;
if(isset($ann_type) && !empty($ann_type)) { $ann_type=intval($ann_type); $ann_type_curr=$ann_type-1; } else { $ann_type=0;  $ann_type_curr=0; }
if(isset($selected_regions) && is_array($selected_regions) && count($selected_regions)>0) $selected_regions=$selected_regions; else $selected_regions=array();
if(isset($selected_metros) && is_array($selected_metros) && count($selected_metros)>0) $selected_metros=$selected_metros; else $selected_metros=array();
if(isset($selected_settlements) && is_array($selected_settlements) && count($selected_settlements)>0) $selected_settlements=$selected_settlements; else $selected_settlements=array();
if(isset($selected_marks) && is_array($selected_marks) && count($selected_marks)>0) $selected_marks=$selected_marks; else $selected_marks=array();
if(isset($property_type) && !empty($property_type)) { $property_type=intval($property_type); } else { $property_type=0; }
if(isset($repair) && $repair>=0) { $repair=intval($repair); } else { $repair=-1; }
if(isset($space_min) && !empty($space_min)) { $space_min=intval($space_min); } else { $space_min=""; }
if(isset($space_max) && !empty($space_max)) { $space_max=intval($space_max); } else { $space_max=""; }
if(isset($city) && !empty($city)) { $city=intval($city); } else { $city=0; }
if(isset($document) && !empty($document)) { $document=intval($document); } else { $document=0; }
if(isset($room_min) && !empty($room_min)) { $room_min=intval($room_min); } else { $room_min=""; }
if(isset($room_max) && !empty($room_max)) { $room_max=intval($room_max); } else { $room_max=""; }
if(isset($price_min) && !empty($price_min)) { $price_min=intval($price_min); } else { $price_min=""; }
if(isset($price_max) && !empty($price_max)) { $price_max=intval($price_max); } else { $price_max=""; }
if(isset($announce_type) && !empty($announce_type)) { $announce_type=$announce_type; } else { $announce_type=0; }
?>
<form action="<?=Url::to(['elanlar/']); ?>" method="get" id="search_blok">
    <div>
        <div class="search-form clearfix">
            <a href="<?=Url::to(['yasayis-kompleksleri/']); ?>" class="more-ob"><?=Yii::t('app','lang218'); ?> (<?=$this->context->yasayis; ?>)</a>
            <ul id="info-nav" class="clearfix">
                <script>
                    var current_nav = "<?=$ann_type_curr?>";
                </script>
                <li data-id="1"><a href="#sale"><?=Yii::t('app','lang59'); ?></a></li>
                <li data-id="2"><a href="#sale"><?=Yii::t('app','lang60'); ?></a></li>
                <li data-id="3"><a href="#search"><?=Yii::t('app','lang231'); ?></a></li>
            </ul>
            <div id="info">
                <input type="hidden" value="<?=($ann_type==0) ? 1 : 3; ?>" id="ann_type" name="ann_type" />
                <div id="sale" class="tabs-content">
                    <div class="column-table">
                        <div class="col">
                            <label style="display:none;" id="ts1" name="ts1"><?=$this->context->ts1; ?></label>
                            <label style="display:none;" id="ti1" name="ti1"><?=$this->context->ti1; ?></label>

                            <div class="title"><?=Yii::t('app','property_type1'); ?> (<label id="t_1"><?=$this->context->ts1; ?></label>)</div>
                            <p><label><input class="s_b y_otaq" type="checkbox" <?= (in_array(1,$yotaq) && !in_array(9,$tip)) ? "checked" : "" ?> name="yotaq[]" value="1" /><span>1 <?=Yii::t('app','lang185'); ?></span></label></p>
                            <p><label><input class="s_b y_otaq" type="checkbox" <?= (in_array(2,$yotaq) && !in_array(9,$tip)) ? "checked" : "" ?> name="yotaq[]" value="2" /><span>2 <?=Yii::t('app','lang185'); ?></span></label></p>
                            <p><label><input class="s_b y_otaq" type="checkbox" <?= (in_array(3,$yotaq) && !in_array(9,$tip)) ? "checked" : "" ?> name="yotaq[]" value="3" /><span>3 <?=Yii::t('app','lang185'); ?></span></label></p>
                            <p><label><input class="s_b y_otaq" type="checkbox" <?= (in_array(4,$yotaq) && !in_array(9,$tip)) ? "checked" : "" ?> name="yotaq[]" value="4" /><span>4 <?=Yii::t('app','lang185'); ?></span></label></p>
                            <p><label><input class="s_b y_otaq" type="checkbox" <?= (in_array(5,$yotaq) && !in_array(9,$tip)) ? "checked" : "" ?> name="yotaq[]" value="5" /><span>5+ <?=Yii::t('app','lang185'); ?></span></label></p>
                        </div>
                        <div class="col">
                            <label style="display:none;" id="ts2" name="ts2"><?=$this->context->ts2; ?></label>
                            <label style="display:none;" id="ti2" name="ti2"><?=$this->context->ti2; ?></label>

                            <div class="title"><?=Yii::t('app','property_type2'); ?> (<label id="t_2"><?=$this->context->ts2; ?></label>)</div>
                            <p><label><input class="s_b k_otaq" type="checkbox" <?= (in_array(1,$kotaq) && !in_array(9,$tip)) ? "checked" : "" ?> name="kotaq[]" value="1" /><span>1 <?=Yii::t('app','lang185'); ?></span></label></p>
                            <p><label><input class="s_b k_otaq" type="checkbox" <?= (in_array(2,$kotaq) && !in_array(9,$tip)) ? "checked" : "" ?> name="kotaq[]" value="2" /><span>2 <?=Yii::t('app','lang185'); ?></span></label></p>
                            <p><label><input class="s_b k_otaq" type="checkbox" <?= (in_array(3,$kotaq) && !in_array(9,$tip)) ? "checked" : "" ?> name="kotaq[]" value="3" /><span>3 <?=Yii::t('app','lang185'); ?></span></label></p>
                            <p><label><input class="s_b k_otaq" type="checkbox" <?= (in_array(4,$kotaq) && !in_array(9,$tip)) ? "checked" : "" ?> name="kotaq[]" value="4" /><span>4 <?=Yii::t('app','lang185'); ?></span></label></p>
                            <p><label><input class="s_b k_otaq" type="checkbox" <?= (in_array(5,$kotaq) && !in_array(9,$tip)) ? "checked" : "" ?> name="kotaq[]" value="5" /><span>5+ <?=Yii::t('app','lang185'); ?></span></label></p>
                        </div>
                        <div class="col">
                            <?php
                            $alls=$this->context->ts3+$this->context->ts4+$this->context->ts5+$this->context->ts6+$this->context->ts7+$this->context->ts8+$this->context->tsx;
                            $alli=$this->context->ti3+$this->context->ti4+$this->context->ti5+$this->context->ti6+$this->context->ti7+$this->context->ti8+$this->context->tix;
                            $fulls=$alls+$this->context->ts1+$this->context->ts2;
                            $fulli=$alli+$this->context->ti1+$this->context->ti2;
                            ?>
                            <label style="display:none;" id="alls" name="alls"><?=$alls; ?></label>
                            <label style="display:none;" id="alli" name="alli"><?=$alli; ?></label>

                            <label style="display:none;" id="fulls"><?=$fulls; ?></label>
                            <label style="display:none;" id="fulli"><?=$fulli; ?></label>
                            <label style="display:none;" id="fullAll"><?=($fulls+$fulli); ?></label>

                            <div class="title"><?=Yii::t('app','lang232'); ?> (<label id="all_l"><?php echo $alls; ?></label>)</div>
                            <p><label><input class="s_b tip_emlak" type="checkbox" <?= (in_array(2,$tip) && !in_array(9,$tip)) ? "checked" : "" ?> name="tip[]" value="3" /><span><?=Yii::t('app','property_type3'); ?></span></label></p>
                            <p><label><input class="s_b tip_emlak" type="checkbox" <?= (in_array(10,$tip) && !in_array(9,$tip)) ? "checked" : "" ?> name="tip[]" value="10" /><span><?=Yii::t('app','property_type10'); ?></span></label></p>
                            <p><label><input class="s_b tip_emlak" type="checkbox" <?= (in_array(4,$tip) && !in_array(9,$tip)) ? "checked" : "" ?> name="tip[]" value="4" /><span><?=Yii::t('app','property_type4'); ?></span></label></p>
                            <p><label><input class="s_b tip_emlak" type="checkbox" <?= (in_array(5,$tip) && !in_array(9,$tip)) ? "checked" : "" ?> name="tip[]" value="5" /><span><?=Yii::t('app','property_type5'); ?></span></label></p>
                            <p><label><input class="s_b tip_emlak" type="checkbox" <?= (in_array(6,$tip) && !in_array(9,$tip)) ? "checked" : "" ?> name="tip[]" value="6" /><span><?=Yii::t('app','property_type6'); ?></span></label></p>
                            <p><label><input class="s_b tip_emlak" type="checkbox" <?= (in_array(7,$tip) && !in_array(9,$tip)) ? "checked" : "" ?> name="tip[]" value="7" /><span><?=Yii::t('app','property_type7'); ?></span></label></p>
                            <p><label><input class="s_b tip_emlak" type="checkbox" <?= (in_array(8,$tip) && !in_array(9,$tip)) ? "checked" : "" ?> name="tip[]" value="8" /><span><?=Yii::t('app','property_type8'); ?></span></label></p>
                            <p class="tip_ch"><label><input class="s_b" type="checkbox" <?= (in_array(9,$tip)) ? "checked" : "" ?> name="tip[]" value="9" /><span><?=Yii::t('app','property__typeX'); ?></span></label></p>
                            <p class="rent_ch" style="display: none;"><label><input class="s_b" type="checkbox" <?= ($rent_type_gun==1 && !in_array(9,$tip)) ? "checked" : "" ?> name="rent_type_gun" value="1" /><span>Kirayə günlük</span></label></p>
                        </div>
                        <div class="col">
                            <div class="title"><?=Yii::t('app','lang234'); ?></div>
                            <div class="w-50">
                                <?php
                                $say=0;
                                foreach($this->context->regions as $id=>$title)
                                {
                                    if($id>0){
//                                        $checked='';
                                        if(in_array($id,$selected_regions) && !in_array(9,$tip)) $checked = 'checked';
                                        else $checked = '';
                                        echo '<p><label><input '.$checked.' type="checkbox" class="rayon_home_check_click s_b" id="s_rayon_checkbox'.$id.'" value="'.$id.'" data-id="'.$id.'" /><span>'.$title.'</span></label></p>';
                                        $say++;
                                        if($say==6) break;
                                    }
                                }
                                ?>
                            </div>
                            <div class="w-50">
                                <?php
                                $say=0;
                                foreach($this->context->regions as $id=>$title)
                                {
                                    if($id>0){
                                        if($say>=6){
                                            if(in_array($id,$selected_regions) && !in_array(9,$tip)) $checked = 'checked';
                                            else $checked = '';
                                            echo '<p><label><input '.$checked.' type="checkbox" class="rayon_home_check_click s_b" id="s_rayon_checkbox'.$id.'" value="'.$id.'" data-id="'.$id.'" /><span>'.$title.'</span></label></p>';
                                        }
                                        $say++;
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col last_col">
                            <a href="/" class="area-links area-links-2"><?=Yii::t('app','lang168'); ?></a>
                            <ul class="area-list">
                                <div class="area-list-regions">
                                    <!-- <li><a href="/" class="remove"></a>Akademiyas metrosu.</li> -->
                                </div>
                                <div class="area-list-metros">

                                </div>
                                <div class="area-list-settlements">

                                </div>
                                <div class="area-list-marks">

                                </div>
                            </ul>
                            <button class="btn-search" type="submit"><?=Yii::t('app','lang233'); ?> <label class="goster_button">(<?=$fulls; ?>)</label></button>
                        </div>

                        <div class="clear"></div>

                    </div>
                </div>
                <div id="search" class="tabs-content s_b">
                    <div class="drop-box">
                        <select name="announce_type" class="SlectBox">
                            <option disabled="disabled" value="0" selected="selected"><?=Yii::t('app','lang154'); ?></option>
                            <option <?=($announce_type==18880 || $ann_type==1) ? "selected" : ""; ?> value="18880"><?=Yii::t('app','announce_type1'); ?></option>
                            <!--                            <option value="2">--><?//=Yii::t('app','announce_type2'); ?><!--</option>-->
                            <option <?=(($announce_type==28882 || $ann_type==2) && !in_array(9,$tip)) ? "selected" : ""; ?> value="28882">Kirayə aylıq</option>
                            <option <?=($announce_type==28881 || $rent_type_gun==1 && !in_array(9,$tip)) ? "selected" : ""; ?> value="28881">Kirayə günlük</option>
                        </select>
                        <input type="hidden" name="search_type_check" id="search_type_check" value="<?=$search_type_check?>">
                        <select name="property_type" class="SlectBox">
                            <option disabled="disabled" value="0" selected="selected"><?=Yii::t('app','lang155'); ?></option>
                            <?php
                            for($i=1;$i<=10;$i++){
                            
                                if($i !=9) 
                                {
                                    if(($property_type==$i) || (count($yotaq)>0 && $i==1 && count($kotaq)==0 && count($tip)==0 && $search_type_check==0) || (count($kotaq)>0 && $i==2 && count($tip)==0 && $search_type_check==0) || ($i==end($tip) && count($tip)>0 && $search_type_check==0) && (!in_array(9,$tip) || $ann_type==3)) $selected = " selected"; else $selected = "";
    //                                if(count($yotaq)>0)
    //                                {
    //                                    $i=1;
    //                                    $selected = " selected";
    //                                }
    //                                if(count($kotaq)>0)
    //                                {
    //                                    $i=2;
    //                                    $selected = ' selected';
    //                                }

                                    echo '<option value="'.$i.'" '.$selected.'>'.Yii::t('app','property_type'.$i).'</option>';
                                }
                                
                            }
                            ?>
                        </select>
                        <select name="repair" class="SlectBox">
                            <option disabled="disabled" value="-1" selected="selected"><?=Yii::t('app','lang163'); ?></option>
                            <?php
                            for($i=0;$i<=5;$i++){
                                if($repair==$i && (!in_array(9,$tip) || $ann_type==3)) $selected = " selected"; else $selected = "";
                                echo '<option value="'.$i.'" '.$selected.'>'.Yii::t('app','repair'.$i).'</option>';
                            }
                            ?>
                        </select>
                        <select name="city" class="SlectBox">
                            <option disabled="disabled" value="dis" selected="selected"><?=Yii::t('app','lang164'); ?></option>
                            <?php
                            foreach($this->context->cities as $id=>$name){
                                if($city==$id && (!in_array(9,$tip) || $ann_type==3)) $selected = " selected"; else $selected = "";
                                if($id>0) echo '<option value="'.$id.'" '.$selected.'>'.$name.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="middle-box">
                        <div class="row">
                            <?php
                                $room_min_val = $room_max_val = '';
                                if(!in_array(9,$tip) || $ann_type==3){
                                    if($search_type_check==0)
                                    {
                                        if(count($yotaq)>0)
                                        {
                                            $room_min_val = min($yotaq);
                                            $room_max_val = max($yotaq);
                                        }
                                        elseif(count($kotaq)>0)
                                        {
                                            $room_min_val = min($kotaq);
                                            $room_max_val = max($kotaq);
                                        }
										else
										{
											$room_min_val = $room_min;
											$room_max_val = $room_max;
										}
                                    }
                                    else
                                    {
                                        $room_min_val = $room_min;
                                        $room_max_val = $room_max;
                                    }
								}
                            ?>

                            <?=Yii::t('app','lang235'); ?>
                            <input type="text" value="<?=$room_min_val?>" placeholder="<?=Yii::t('app','lang237'); ?>" name="room_min" class="m-left" >
                            <span>&HorizontalLine;</span>
                            <input type="text" value="<?=$room_max_val?>" placeholder="<?=Yii::t('app','lang238'); ?>" name="room_max" >
                        </div>
                        <div class="row">
                            <?=Yii::t('app','lang236'); ?>
                            <input type="text" value="<?=(!in_array(9,$tip) || $ann_type==3) ? $space_min : ""?>" placeholder="<?=Yii::t('app','lang239'); ?>" name="space_min" class="m-left" >
                            <span>&HorizontalLine;</span>
                            <input type="text" value="<?=(!in_array(9,$tip) || $ann_type==3) ? $space_max : ""?>" placeholder="<?=Yii::t('app','lang240'); ?>" name="space_max" >
                        </div>
                        <div class="row">
                            <?=Yii::t('app','lang171'); ?>
                            <input type="text" value="<?=(!in_array(9,$tip) || $ann_type==3) ? $price_min : ""?>" placeholder="<?=Yii::t('app','lang241'); ?>" name="price_min" class="m-left" >
                            <span>&HorizontalLine;</span>
                            <input type="text" value="<?=(!in_array(9,$tip) || $ann_type==3) ? $price_max : ""?>" placeholder="<?=Yii::t('app','lang242'); ?>" name="price_max" >
                        </div>
                        <div class="row"><label class="check-label"><input name="document" <?=($document==1 && (!in_array(9,$tip) || $ann_type==3)) ? "checked" : "";?> value="1" type="checkbox" /><?=Yii::t('app','lang243'); ?></label></div>
                        <div class="row"><button type="reset" class="reset-btn"><?=Yii::t('app','lang244'); ?></button></div>
                    </div>
                    <div class="right-box">
                        <a class="area-links area-links-2" href="/"><?=Yii::t('app','lang168'); ?></a>
                        <ul class="area-list">
                            <div class="area-list-regions">
                                <!-- <li><a href="/" class="remove"></a>Akademiyas metrosu.</li> -->
                            </div>
                            <div class="area-list-metros">

                            </div>
                            <div class="area-list-settlements">

                            </div>
                            <div class="area-list-marks">

                            </div>
                        </ul>
                        <button class="btn-search" type="submit" style="margin-top: 0px;"><?=Yii::t('app','lang233'); ?> <label class="goster_button">(0)</label></button>
                    </div>
                </div>
            </div>
            <div class="search-bottom"></div>
        </div>
    </div>



    <div class="popup nisangah nisangah-2">
        <div class="popup-main">
            <a href="/" class="close"></a>
            <div class="pull-left">
                <div class="title"><?=Yii::t('app','lang165'); ?></div>
                <div class="wrapper-c scrollbar-dynamic">
                    <div class="page-content">
                        <div class="col">
                            <?php
                            foreach($this->context->regions as $id=>$title)
                            {
                                if($id>0){
                                    if(in_array($id,$selected_regions)) $checked = 'checked';
                                    else $checked = '';
                                    echo '<p><label><input '.$checked.' type="checkbox" class="rayon_check_click" id="rayon_checkbox'.$id.'" value="'.$id.'" data-id="'.$id.'" name="selected_regions[]" /><span>'.$title.'</span></label></p>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pull-left">
                <div class="title"><?=Yii::t('app','lang167'); ?></div>
                <div class="wrapper-c scrollbar-dynamic">
                    <div class="page-content">
                        <div class="col">
                            <?php
                            foreach($this->context->metros as $id=>$title)
                            {
                                if($id>0){
                                    if(in_array($id,$selected_metros)) $checked = 'checked';
                                    else $checked = '';
                                    echo '<p><label><input '.$checked.' type="checkbox" class="metro_check_click" id="metro_checkbox'.$id.'" value="'.$id.'" name="selected_metros[]" /><span>'.$title.'</span></label></p>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pull-left">
                <div class="title"><?=Yii::t('app','lang166'); ?></div>
                <div class="wrapper-c scrollbar-dynamic">
                    <div class="page-content">
                        <div class="col">
                            <?php
                            foreach($this->context->settlements as $id=>$title)
                            {
                                if($id>0){
                                    if(in_array($id,$selected_settlements)) $checked = 'checked';
                                    else $checked = '';
                                    echo '<p><label><input '.$checked.' type="checkbox" class="qesebe_check_click" id="qesebe_checkbox'.$id.'" value="'.$id.'" name="selected_settlements[]" /><span>'.$title.'</span></label></p>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pull-left" style="margin-right:0%;max-width:33%;">
                <div class="title"><?=Yii::t('app','lang168'); ?></div>
                <div class="wrapper-c scrollbar-dynamic">
                    <div class="page-content">
                        <div class="col">
                            <?php
                            foreach($this->context->marks as $id=>$title)
                            {
                                if($id>0){
                                    if(in_array($id,$selected_marks)) $checked = 'checked';
                                    else $checked = '';
                                    echo '<p><label><input '.$checked.' class="nisangah_check_click" id="nisangah_checkbox'.$id.'" type="checkbox" value="'.$id.'" name="selected_marks[]" /><span>'.$title.'</span></label></p>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>
            <div class="bottom-box clearfix">
                <button type="button" class="reset-btn-mark"><?=Yii::t('app','lang169'); ?></button>
                <button type="button"  class="submit-btn close"><?=Yii::t('app','lang48'); ?></button>
            </div>
        </div>
    </div>

</form>

<script>
    $(function () {
        $(".rayon_home_check_click").click(function (e) {
            e.preventDefault();
            var idi=$(this).children('input').data('id');
            var chck=$("#s_rayon_checkbox"+idi).prop('checked');
            if(chck==true){
                $("#rayon_checkbox"+idi+"-styler").addClass('checked');
                $("#rayon_checkbox"+idi).prop('checked',true);
            }
            else{
                $("#rayon_checkbox"+idi+"-styler").removeClass('checked');
                $("#rayon_checkbox"+idi).prop('checked',false);
            }

            var baseurl=$("#baseurl").val();
            var val='-';
            $( ".rayon_check_click:checked" ).each(function(){
                val+=$(this).val()+'-';
            });

            $.post(baseurl+"/site/regions_select",{val:val},function(data){
                $(".area-list-regions").html(data);
                updateCountSearchBlok();
            });
            return false;
        });

        $(".rayon_check_click").click(function (e) {
            e.preventDefault();
            var idi=$(this).children('input').data('id');
            var chck=$("#rayon_checkbox"+idi).prop('checked');
            if(chck==true){
                $("#s_rayon_checkbox"+idi+"-styler").addClass('checked');
                $("#s_rayon_checkbox"+idi).prop('checked',true);
            }
            else{
                $("#s_rayon_checkbox"+idi+"-styler").removeClass('checked');
                $("#s_rayon_checkbox"+idi).prop('checked',false);
            }


            var baseurl=$("#baseurl").val();
            var val='-';
            $( ".rayon_check_click:checked" ).each(function(){
                val+=$(this).val()+'-';
            });
            $.post(baseurl+"/site/regions_select",{val:val},function(data){
                $(".area-list-regions").html(data);
                updateCountSearchBlok();
            });
            return false;
        });

        var baseurl=$("#baseurl").val();
        var val='-';
        $( ".rayon_check_click:checked" ).each(function(){
            val+=$(this).val()+'-';
        });

        $.post(baseurl+"/site/regions_select",{val:val},function(data){
            $(".area-list-regions").html(data);
            updateCountSearchBlok();
        });

        $(".metro_check_click").click(function(e){
            e.preventDefault();
            var baseurl=$("#baseurl").val();
            var val='-';
            $( ".metro_check_click:checked" ).each(function(){
                val+=$(this).val()+'-';
            });

            $.post(baseurl+"/site/metros_select",{val:val},function(data)
            {
                $(".area-list-metros").html(data);
                updateCountSearchBlok();
            });
        });

        var val='-';
        $( ".metro_check_click:checked" ).each(function(){
            val+=$(this).val()+'-';
        });

        $.post(baseurl+"/site/metros_select",{val:val},function(data)
        {
            $(".area-list-metros").html(data);
            updateCountSearchBlok();
        });

        $(".qesebe_check_click").click(function(e){
            e.preventDefault();
            var baseurl=$("#baseurl").val();
            var val='-';
            $( ".qesebe_check_click:checked" ).each(function(){
                val+=$(this).val()+'-';
            });

            $.post(baseurl+"/site/settlements_select",{val:val},function(data)
            {
                $(".area-list-settlements").html(data);
                updateCountSearchBlok();
            });
        });

        var val='-';
        $( ".qesebe_check_click:checked" ).each(function(){
            val+=$(this).val()+'-';
        });

        $.post(baseurl+"/site/settlements_select",{val:val},function(data)
        {
            $(".area-list-settlements").html(data);
            updateCountSearchBlok();
        });

        $(".nisangah_check_click").click(function(e){
            e.preventDefault();
            var baseurl=$("#baseurl").val();
            var val='-';
            $( ".nisangah_check_click:checked" ).each(function(){
                val+=$(this).val()+'-';
            });

            $.post(baseurl+"/site/marks_select",{val:val},function(data)
            {
                $(".area-list-marks").html(data);
                updateCountSearchBlok();
            });
        });

        var val='-';
        $( ".nisangah_check_click:checked" ).each(function(){
            val+=$(this).val()+'-';
        });

        $.post(baseurl+"/site/marks_select",{val:val},function(data)
        {
            $(".area-list-marks").html(data);
            updateCountSearchBlok();
        });

        $(".reset-btn").click(function (e) {
            e.preventDefault();
            var baseurl=$("#baseurl").val();
            var val='-';

            $(".area-list").html('<div class="area-list-regions"></div><div class="area-list-metros"></div><div class="area-list-settlements"></div><div class="area-list-marks"></div>');

            updateCountSearchBlok();
        });
        $(".reset-btn-mark").click(function (e) {
            e.preventDefault();
            var baseurl=$("#baseurl").val();
            var val='-';
            $(".rayon_home_check_click").removeClass('checked');    $(".rayon_home_check_click").prop('checked',false);
            $(".rayon_check_click").removeClass('checked');         $(".rayon_check_click").prop('checked',false);

            $(".area-list").html('<div class="area-list-regions"></div><div class="area-list-metros"></div><div class="area-list-settlements"></div><div class="area-list-marks"></div>');

            updateCountSearchBlok();
        });

        // delete area list
        $(document).delegate('.area-list li .remove.ryn', 'click',function(e)
        {
            e.preventDefault();
            $("#rayon_checkbox"+$(this).data('id')+"-styler").trigger('click');
            $(this).parent().remove();

            updateCountSearchBlok();
        });
        $(document).delegate('.area-list li .remove.mtr', 'click',function(e)
        {
            e.preventDefault();
            $("#metro_checkbox"+$(this).data('id')+"-styler").trigger('click');
            $(this).parent().remove();

            updateCountSearchBlok();
        });
        $(document).delegate('.area-list li .remove.qsb', 'click',function(e)
        {
            e.preventDefault();
            $("#qesebe_checkbox"+$(this).data('id')+"-styler").trigger('click');
            $(this).parent().remove();

            updateCountSearchBlok();
        });
        $(document).delegate('.area-list li .remove.nsgh', 'click',function(e)
        {
            e.preventDefault();
            $("#nisangah_checkbox"+$(this).data('id')+"-styler").trigger('click');
            $(this).parent().remove();

            updateCountSearchBlok();
        });


        // new

        $("input.y_otaq,input.k_otaq,input.tip_emlak").change(function () {
            $("input#search_type_check").val(0);
        });

        $("select[name=property_type],input[name=room_min],input[name=room_max]").change(function (){
            $("input#search_type_check").val(1);
        });

    });
</script>