<?php
use frontend\components\MyFunctionsF;
use yii\helpers\Url;
$this->title = $this->context->siteTitle;
?>
<div class="content clearfix">
    <?php
    if(Yii::$app->session->hasFlash('success')) echo '<div class="alert-success alert" style="margin-bottom:0px;">'.Yii::$app->session->getFlash('success').'</div>';
    if(Yii::$app->session->hasFlash('danger')) echo '<div class="alert-danger alert" style="margin-bottom:0px;">'.Yii::$app->session->getFlash('danger').'</div>';
    if(Yii::$app->session->hasFlash('success') or Yii::$app->session->hasFlash('danger'))
    {
        echo "<script>
    $(document).ready(function()
    {
        $('html, body').animate({ scrollTop: 280 }, 'fast');
    });
    </script>";
    }
    ?>


    <?php echo Yii::$app->controller->renderPartial('/layouts/includes/2_banners'); ?>

<!--    <div>-->
<!--        <img src="" style="border: 1px solid #000;">-->
<!--    </div>-->

    <div class="tabs clearfix">
        <div class="tabs-panel">
            <div class="title"><?=Yii::t('app','lang216'); ?></div>
            <ul class="rat">
                <li></li>
                <li></li>
                <li></li>
            </ul>
            <div class="i-tab clearfix">
                <div><span><?=Yii::t('app','lang59'); ?></span></div>
                <div class="rent_btn" data-info="vip"><span><?=Yii::t('app','lang60'); ?></span></div>
            </div>
        </div>
        <div class="tab-content">
            <div class="tabs-main">
                <div class="items">
                    <div class="ticket-item premium-ticket">
                        <div class="ticket-photo pr"><a href="javascript:void(0);" class="premium-l"><?=Yii::t('app','lang249'); ?></a></div>
                        <div class="price-ticket"><?=$this->context->packagePrices["announce_premium10"]; ?> <?=Yii::t('app','lang285'); ?></div>
                        <div class="description-ticket"><?=Yii::t('app','lang286'); ?></div>
                    </div>
                    <?php
                    $time=time();
                    foreach($vip1 as $row)
                    {
                        if($row["urgently"]>0) $urgently='<span class="urgently">'.Yii::t('app','lang196').'</span>'; else $urgently='';
                        $title=$this->context->titleGenerator('az',$row["announce_type"],$row["property_type"],$row["space"],$row["room_count"],$row["mark"],$row["settlement"],$row["metro"],$row["region"],$row["city"],$row["country"],$row["address"]);
                        $slugTitle=MyFunctionsF::slugGenerator($title);
                        $stripTitle=strip_tags($title);

                        $infos='';
                        if($row["room_count"]>0) $infos.=$row["room_count"].' '.Yii::t('app','lang185').' '.Yii::t('app','property_type'.$row["property_type"]);
                        elseif($row["property_type"]==6 || $row["property_type"]==8) $infos.=$row["space"].' '.Yii::t('app','lang217').' '.Yii::t('app','property_type'.$row["property_type"]);
                        elseif($row["property_type"]==7) $infos.=$row["space"].' '.Yii::t('app','lang158').' '.Yii::t('app','property_type'.$row["property_type"]);
                        else $infos.=Yii::t('app','property_type'.$row["property_type"]);
                        $infos.=', ';

                        if($row["settlement"]>0) $infos.=$this->context->settlements[$row["settlement"]];
                        elseif($row["metro"]>0) $infos.=$this->context->metros[$row["metro"]];
                        elseif($row["region"]>0) $infos.=$this->context->regions[$row["region"]];
                        else $infos.=$this->context->cities[$row["city"]];

                        if($row["panarama"]!=''){
                            $panarama='<a href="'.Url::to(['/'.$row["id"].'-'.$slugTitle.'.html']).'" target="_blank"><img src="'.MyFunctionsF::getImageUrl().'/360_1.png" alt="" title="'.$stripTitle.'" style="margin-left: 54px;position: absolute;margin-top: -100px;"></a>';
                            $class_pan='class_pan';
                        }
                        else{ $panarama=''; $class_pan=''; }

                        if($row["sort_premium"]>$time) echo '<div class="ticket-item">
                    <a href="'.Url::to(['/'.$row["id"].'-'.$slugTitle.'.html']).'" title="'.$stripTitle.'" target="_blank">
                        '.$urgently.'
                        <div class="ticket-photo '.$class_pan.' ">
                            <img src="'.MyFunctionsF::getImageUrl().'/'.$row["cover"].'" alt="'.$stripTitle.'" title="'.$stripTitle.'" />
                        </div>
						'.$panarama.'
                        <div class="price-ticket">'.number_format($row["price"],0,'.',' ').' '.Yii::t('app','lang149').'</div>
                        <div class="description-ticket">'.$infos.'</div>
                    </a>
                </div>';
                    }
                    ?>
                </div>
            </div>
            <div class="tabs-main">
                <div class="items" id="vip_rent">
                    <div class="ticket-item">
                        <img class="bx_loader" src="<?=MyFunctionsF::getImageUrl().'/bx_loader.gif';?>" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tabs clearfix">
        <div class="tabs-panel">
            <div class="title"><?=Yii::t('app','lang216'); ?></div>
            <ul class="rat">
                <li></li>
                <li></li>
                <li></li>
            </ul>
            <div class="i-tab clearfix not_select">
                <div class="rent_btn" data-info="vip2"><span><?=Yii::t('app','lang59'); ?></span></div>
                <div class="active"><span><?=Yii::t('app','lang60'); ?></span></div>
            </div>
        </div>
        <div class="tab-content">
            <div class="tabs-main not_select">
                <div class="items" id="vip2_rent">
                    <img class="bx_loader" src="<?=MyFunctionsF::getImageUrl().'/bx_loader.gif';?>" />
                </div>
            </div>
            <div class="tabs-main show_this">
                <div class="items">
                    <div class="ticket-item premium-ticket">
                        <div class="ticket-photo pr"><a href="javascript:void(0);" class="premium-l"><?=Yii::t('app','lang249'); ?></a></div>
                        <div class="price-ticket"><?=$this->context->packagePrices["announce_premium10"]; ?> <?=Yii::t('app','lang285'); ?></div>
                        <div class="description-ticket"><?=Yii::t('app','lang286'); ?></div>
                    </div>
                    <?php
                    foreach($vip2 as $row)
                    {
                        if($row["urgently"]>0) $urgently='<span class="urgently">'.Yii::t('app','lang196').'</span>'; else $urgently='';
                        $title=$this->context->titleGenerator('az',$row["announce_type"],$row["property_type"],$row["space"],$row["room_count"],$row["mark"],$row["settlement"],$row["metro"],$row["region"],$row["city"],$row["country"],$row["address"]);
                        $slugTitle=MyFunctionsF::slugGenerator($title);
                        $stripTitle=strip_tags($title);

                        $infos='';
                        if($row["room_count"]>0) $infos.=$row["room_count"].' '.Yii::t('app','lang185').' '.Yii::t('app','property_type'.$row["property_type"]);
                        elseif($row["property_type"]==6 || $row["property_type"]==8) $infos.=$row["space"].' '.Yii::t('app','lang217').' '.Yii::t('app','property_type'.$row["property_type"]);
                        elseif($row["property_type"]==7) $infos.=$row["space"].' '.Yii::t('app','lang158').' '.Yii::t('app','property_type'.$row["property_type"]);
                        else $infos.=Yii::t('app','property_type'.$row["property_type"]);
                        $infos.=', ';

                        if($row["settlement"]>0) $infos.=$this->context->settlements[$row["settlement"]];
                        elseif($row["metro"]>0) $infos.=$this->context->metros[$row["metro"]];
                        elseif($row["region"]>0) $infos.=$this->context->regions[$row["region"]];
                        else $infos.=$this->context->cities[$row["city"]];

                        if($row["announce_type"]==2)
                        {
                            if($row["rent_type"]==1)
                                $rent_type = " / gün";
                            elseif($row["rent_type"]==2)
                                $rent_type = " / ay";
                            else
                                $rent_type = "";
                        }
                        else
                            $rent_type = "";

                        if($row["sort_premium"]>$time) echo '<div class="ticket-item">
                    <a href="'.Url::to(['/'.$row["id"].'-'.$slugTitle.'.html']).'" title="'.$stripTitle.'" target="_blank">
                        '.$urgently.'
                        <div class="ticket-photo">
                            <img src="'.MyFunctionsF::getImageUrl().'/'.$row["cover"].'" alt="'.$stripTitle.'" title="'.$stripTitle.'" >
                        </div>
                        <div class="price-ticket">'.number_format($row["price"],0,'.',' ').' '.Yii::t('app','lang149').$rent_type.'</div>
                        <div class="description-ticket">'.$infos.'</div>
                    </a>
                </div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php

$list = [1,2,3,10,4,5,6,7,8,9];

foreach($list as $i){
    $ptype='property_type'.$i;  if($i==9) $ptype='property__typeX';

    $view_all1='ts'.$i;			if($i==9) $view_all1='tsx';
    $view_all2='ti'.$i;			if($i==9) $view_all2='tix';

    $val1=$this->context->$view_all1;
    $val2=$this->context->$view_all2;

    echo '<div class="tabs clearfix green-tabs">
    <div class="tabs-panel">
        <div class="title">'.Yii::t('app',$ptype).'</div>
        <div class="i-tab clearfix">
            <div class="change_all_count" data-info="'.$i.'" data-val="'.$val1.'" data-ann="1"><span>'.Yii::t('app','lang59').'</span></div>
            <div class="rent_btn change_all_count" data-info="'.$i.'" data-val="'.$val2.'" data-ann="2"><span>'.Yii::t('app','lang60').'</span></div>
        </div>
        <a href="'.Url::to(['elanlar/?ann_type=1&tip[]='.$i]).'" class="more" id="view_all_href'.$i.'">'.Yii::t('app','lang253').' (<label id="view_all'.$i.'">'.$val1.'</label>)</a>
    </div>
    <div class="tab-content">
        <div class="tabs-main">
            <div class="items" id="'.$i.'_sale">';
    $var='tip'.$i;
    foreach($$var as $row){
        if($row["urgently"]>0) $urgently='<span class="urgently">'.Yii::t('app','lang196').'</span>'; else $urgently='';
        $title=$this->context->titleGenerator('az',$row["announce_type"],$row["property_type"],$row["space"],$row["room_count"],$row["mark"],$row["settlement"],$row["metro"],$row["region"],$row["city"],$row["country"],$row["address"]);
        $slugTitle=MyFunctionsF::slugGenerator($title);
        $stripTitle=strip_tags($title);

        $infos='';
        if($row["room_count"]>0) $infos.=$row["room_count"].' '.Yii::t('app','lang185').' '.Yii::t('app','property_type'.$row["property_type"]);
        elseif($row["property_type"]==6 || $row["property_type"]==8) $infos.=$row["space"].' '.Yii::t('app','lang217').' '.Yii::t('app','property_type'.$row["property_type"]);
        elseif($row["property_type"]==7) $infos.=$row["space"].' '.Yii::t('app','lang158').' '.Yii::t('app','property_type'.$row["property_type"]);
        else $infos.=Yii::t('app','property_type'.$row["property_type"]);
        $infos.=', ';

        if($row["settlement"]>0) $infos.=$this->context->settlements[$row["settlement"]];
        elseif($row["metro"]>0) $infos.=$this->context->metros[$row["metro"]];
        elseif($row["region"]>0) $infos.=$this->context->regions[$row["region"]];
        else $infos.=$this->context->cities[$row["city"]];

        echo '<div class="ticket-item">
                    <a href="'.Url::to(['/'.$row["id"].'-'.$slugTitle.'.html']).'" title="'.$stripTitle.'" target="_blank">
                        '.$urgently.'
                        <div class="ticket-photo">
                            <img src="'.MyFunctionsF::getImageUrl().'/'.$row["cover"].'" alt="'.$stripTitle.'" title="'.$stripTitle.'" >
                        </div>
                        <div class="price-ticket">'.number_format($row["price"],0,'.',' ').' '.Yii::t('app','lang149').'</div>
                        <div class="description-ticket">'.$infos.'</div>
                    </a>
                </div>';
    }

    echo '</div>
        </div>
        <div class="tabs-main">
            <div class="items" id="'.$i.'_rent">
                <img class="bx_loader" src="'.MyFunctionsF::getImageUrl().'/bx_loader.gif" />
            </div>
        </div>
    </div>
</div>
<div class="pagination">
    <ul>';

    for($i_2=1;$i_2<=5;$i_2++):

        $activeClass = $i_2==1 ? 'active' : '';
        echo '<li data-tip="'.$i.'" data-page="'.$i_2.'" class="page_li '.$activeClass.'"><a>'.$i_2.'</a></li>';

    endfor;


echo ' </ul>
</div>';
}
?>


<?php $text33=$this->context->getPagesInfo(33); ?>
<div class="popup premium premium_et" style="margin: -230px 0 0 -300px;    width: 600px;">
    <div class="popup-main">
        <a href="/" class="close"></a>
        <div class="title"><?=$text33["title_".Yii::$app->language]; ?></div>
        <div class="info" style="background:none;"><?=Yii::t('app','lang283'); ?></div>
        <div class="tabs">
            <div class="tab-content" style="width:450px;">
                <div class="tabs-main">
                    <form action="<?=$this->context->siteUrl; ?>/payment/saveitem.php" method="post" target="premiumWindow" id="premiumForm">
                        <?php echo '<div class="alert-danger alert empty_premium_ann" style="margin-bottom:0px;display:none;">'.Yii::t('app','lang284').'</div>'; ?>
                        <center style="margin-top:15px;"><input type="text" id="ann_idi" value="" /></center>
                        <div class="submit-btn">
                            <div>
                                <button type="button" id="set_premium_home" name="btn_pay"><?=Yii::t('app','lang281'); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        // premium
        $(document).delegate('.premium-l', 'click',function(){
            $('.popup.premium_et, .popup-overlay').css({'opacity': '1', 'visibility': 'visible'});
        });

        $("#set_premium_home").click(function() {
            var baseurl=$("#baseurl").val();
            var id=$("#ann_idi").val();
            if(id!=''){
                $.post(baseurl+"/elanlar/check_announce_isset",{id:id},function(data){
                    if(data=='empty') $(".empty_premium_ann").show();
                    else {
                        $(".empty_premium_ann").hide();
                        window.location.href = data;
                    }
                });
            }
        });
    });
</script>