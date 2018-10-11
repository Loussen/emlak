<?php
use frontend\components\MyFunctionsF;
use backend\components\MyFunctions;
use yii\helpers\Url;

$title=$this->context->titleGenerator('az',$elan["announce_type"],$elan["property_type"],$elan["space"],$elan["room_count"],$elan["mark"],$elan["settlement"],$elan["metro"],$elan["region"],$elan["city"],$elan["country"],$elan["address"]);

$this->title=strip_tags($title);
$slugTitle=MyFunctionsF::slugGenerator($title);

if($elan["logo_images"]=='') $elan["logo_images"]=MyFunctions::setWatermarktoImages($id);
?>
<link rel="stylesheet" href="<?=Yii::$app->homeUrl; ?>/css/fotorama.css">
<script src="<?=Yii::$app->homeUrl; ?>/js/jquery-1.10.2.min.js"></script>
<script src="<?=Yii::$app->homeUrl; ?>/js/fotorama.js"></script>
<script src="<?=Yii::$app->homeUrl; ?>/js/jquery.formstyler.js"></script>

<script type="text/javascript" src="<?=Yii::$app->homeUrl; ?>/js/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="<?=Yii::$app->homeUrl; ?>/css/jquery.fancybox.css?v=2.1.5" media="screen" />
<script type="text/javascript">
    $(document).ready(function() {
        $('.fancybox').fancybox({
            'width': 570,
            'top': 40,
        });
    });
</script>
<style>
    .fancybox-skin{padding:0px!important;}
</style>

<div class="content clearfix elan">

    <div style="margin-bottom:-10px;"><?php echo Yii::$app->controller->renderPartial('/layouts/includes/2_banners'); ?></div>

    <div class="panel clearfix">
        <h1 class="title" style="width: 750px;"><?=$title; ?></h1>
        <p class="pull-right"><em><?=Yii::t('app','lang208'); ?>: </em><b><?=$id; ?></b></p>
    </div>
    <?php if(Yii::$app->session->hasFlash('success')) echo '<div class="alert-success alert">'.Yii::$app->session->getFlash('success').'</div>'; ?>
    <?php if(Yii::$app->session->hasFlash('danger')) echo '<div class="alert-danger alert">'.Yii::$app->session->getFlash('danger').'</div>'; ?>

    <div class="left-bar">
        <div class="price">
            <span class="m"><i></i> <?=number_format($elan->price,0,'.',' '); ?></span>
            <span class="d">$ <?=number_format(intval($elan->price/$currency->usd),2,'.',' '); ?></span>
        </div>
        <div class="box-panel">
            <span class="views-count"><?=Yii::t('app','lang209'); ?>: <strong><?=$elan->view_count; ?></strong></span>
            <?php
                if($elan->archive_view>0 && $elan->status==2)
                {
                    $title_current = "Yenilənmə tarixi";
                    $date_current = date('d.m.Y',$elan->archive_view);
                }
                else
                {
                    $title_current = Yii::t('app','lang210');
                    $date_current = date('d.m.Y',$elan->announce_date);
                }
            ?>
            <span class="date"><?=$title_current; ?>: <strong><?=$date_current; ?></strong></span>
            <?php
                if($elan->archive_view>0)
                {
                    ?>
                    <p style="float:none;display:none;" class="date">Yenilənmə tarixi: <strong><?=date('d.m.Y',$elan->archive_view); ?></strong></p>
                    <?php
                }
            ?>
        </div>
        <div class="desc">
            <h3><?=Yii::t('app','lang211'); ?></h3>
            <p><?=stripslashes($elan->text); ?></p>
        </div>
        <dl class="technical-characteristics">
            <?php
            if($elan->property_type==7) $space=Yii::t('app','lang158'); else $space=Yii::t('app','lang157').'<sup>2</sup>';
            ?>
            <dd><span class="label"><?=Yii::t('app','lang155'); ?></span><?=Yii::t('app','property_type'.$elan->property_type); ?></dd>
            <dd><span class="label"><?=Yii::t('app','lang156'); ?></span><?=$elan->space.' '.$space; ?></dd>
            <?php if($elan->property_type!=6 && $elan->property_type!=7){ ?>
                <dd><span class="label"><?=Yii::t('app','lang160'); ?></span><?=$elan->room_count; ?></dd>
            <?php } ?>

            <?php if($elan->property_type==1 || $elan->property_type==2 || $elan->property_type==5){ ?>
                <dd><span class="label"><?=Yii::t('app','lang161'); ?></span><?=$elan->current_floor; ?></dd>
            <?php } ?>

            <?php if($elan->property_type!=6 && $elan->property_type!=7){ ?>
                <dd><span class="label"><?=Yii::t('app','lang162'); ?></span><?=$elan->floor_count; ?></dd>
            <?php } ?>

            <?php if($elan->property_type!=7){ ?>
                <dd><span class="label"><?=Yii::t('app','lang163'); ?></span><?=Yii::t('app','repair'.$elan->repair); ?></dd>
            <?php } ?>
            <?php if($elan->document!=9){ ?>
                <dd><span class="label"><?=Yii::t('app','lang170'); ?></span><?=Yii::t('app','document'.$elan->document); ?></dd>
            <?php } ?>
        </dl>

        

        <div class='seller-data clearfix'>
            <?php
                if($this->context->userInfo==true)
                    if(strpos($this->context->userInfo->archive_ann,"-")>0)
                        $arch_ann_arr = explode("-",$this->context->userInfo->archive_ann);
                    else
                        $arch_ann_arr = [$this->context->userInfo->archive_ann];
                else
                    $arch_ann_arr = array();

            ?>
            <?php if($elan->status!=2 || ($elan->status==2 && $elan->archive_view>0 && in_array($id,$arch_ann_arr) && count($arch_ann_arr)>0)){ ?>
                <h2><?=Yii::t('app','lang213'); ?></h2>
                <div class="silver-box">
                    <p class="name-seller">
                        <?=$elan->name; ?> <span>(<?=Yii::t('app','announcer'.$elan->announcer); ?>)</span> <span class="hide show_number cpoint" data-idi="<?=$id; ?>"><?=Yii::t('app','lang294'); ?></span>
                    </p>
                    <p class="phone" style="margin-top:8px;"><?php echo str_replace("*",", ",$elan->mobile); ?></p>
                </div>
            <?php }
            elseif($elan->status==2 && $elan->archive_view>0 && $this->context->userInfo==true && $this->context->userInfo->email=='abbasov.ali@mail.ru')
            {
                ?>
                <h2><?=Yii::t('app','lang213'); ?></h2>
                <div class="silver-box">
                    <p class="name-seller">
                        <?=$elan->name; ?> <span>(<?=Yii::t('app','announcer'.$elan->announcer); ?>)</span> <span class="hide show_number cpoint" data-idi="<?=$id; ?>"><?=Yii::t('app','lang294'); ?></span>
                    </p>
                </div>
                <div class="boxed" style="margin-top: 10px;">
                    <a class="link-archive archive-ann" href="/" style="width:85%;">
                        Nömrəni əldə et
                        <span class="price">2 <?=strtolower(Yii::t('app','lang149')); ?></span>
                    </a>
                </div>
                <?php
            }
            else {
                ?>
                <div class="silver-box"><?=Yii::t('app','lang300')?></div>
            <?php } ?>
        </div>
		
		<div class="clearfix">&nbsp;</div>
		
		<div class="banner_announce">
            <?php
                $banners=$this->context->banners[5]["text_".Yii::$app->language]; $banners=explode('***',$banners); array_filter($banners); $rand=rand(0,count($banners)-1);
                echo $banners[$rand];
//                echo $this->context->banners[5]["text_".Yii::$app->language];
            ?>
        </div>
		
        

        <?php if($elan->discount>0) echo '<div class="clearfix" style="color:#d92500; font-weight:bold;">'.Yii::t('app','lang296').'</div>'; ?>


        <div class='offer-links'>
            <a href="javascript:void(0);" class="complaint-reason">Şikayət etmək</a>
            <a href="javascript:void(0);" class="fr-send">Dostuna göndər</a>
        </div>
        <a href="javascript:void(0);" class="soc-pub share-link">
            <?=Yii::t('app','lang276'); ?> <span class="price"><?=$this->context->packagePrices["announce_fb"]; ?> <?=strtolower(Yii::t('app','lang149')); ?></span>
        </a>
    </div>
    <div class="container">
        <div class="top-panel">
            <a class="premium-link cpoint"><?=Yii::t('app','lang249'); ?><span class="price"><?=$this->context->packagePrices["announce_premium10"]; ?> <?=strtolower(Yii::t('app','lang149')); ?></span>
            </a>
            <a class="gg-link cpoint"><?=Yii::t('app','lang250'); ?><span class="price"><?=$this->context->packagePrices["announce_foward1"]; ?> <?=strtolower(Yii::t('app','lang149')); ?></span>
            </a>
        </div>
        <div class="item-slider">
            <?php if($elan->urgently>0) echo '<span class="urgently">'.Yii::t('app','lang196').'</span>'; ?>
            <?php if($elan["panarama"]!='') echo '<a class="panarama-link" style="cursor:pointer;" target="_blank"><img src="'.MyFunctionsF::getImageUrl().'/360_2.png" alt="" style="margin-left: 210px;z-index: 9;    position: absolute;margin-top: 140px;"></a>'; ?>
            <div class="fotorama" data-width="560" data-height="420" data-loop="true" data-nav="thumbs" data-thumbheight="108" data-thumbwidth="138" data-fit="none">
                <?php
                $images=explode(",",$elan->logo_images);
                $images_org=explode(",",$elan->images);
                $say=0;

                if($elan->cdn_server==1)
                {
                    $imageCurrentPath = Yii::$app->params["cdn_".Yii::$app->params['currentCDN']]['CDNSERVER_URL']."images";
                    $imageCurrentUrl = Yii::$app->params["cdn_".Yii::$app->params['currentCDN']]['CDNSERVER_URL']."images";
                }
                else
                {
                    $imageCurrentPath = MyFunctionsF::getImagePath();
                    $imageCurrentUrl = MyFunctionsF::getImageUrl();
                }

                foreach($images as $image)
                {
                    if($elan->cdn_server==1)
                    {
                        if(strpos($image,'resized')==''){
                            echo '<a href="'.$imageCurrentUrl.'/'.$image.'"><img src="'.$imageCurrentUrl.'/'.$image.'" alt=""/></a>';
                        }
                        elseif(isset($images_org[$say]) && intval(strpos($images_org[$say],'esized'))==0){
                            echo '<a href="'.$imageCurrentUrl.'/'.$images_org[$say].'"><img src="'.$imageCurrentUrl.'/'.$images_org[$say].'" alt=""/></a>';
                        }
                    }
                    else
                    {
                        if(is_file($imageCurrentPath.'/'.$image) && strpos($image,'resized')==''){
                            echo '<a href="'.$imageCurrentUrl.'/'.$image.'"><img src="'.$imageCurrentUrl.'/'.$image.'" alt=""/></a>';
                        }
                        elseif(isset($images_org[$say]) && is_file($imageCurrentPath.'/'.$images_org[$say]) && intval(strpos($images_org[$say],'esized'))==0){
                            echo '<a href="'.$imageCurrentUrl.'/'.$images_org[$say].'"><img src="'.$imageCurrentUrl.'/'.$images_org[$say].'" alt=""/></a>';
                        }
                    }
                    $say++;
                }
                ?>
            </div>
        </div>
        <div class='boxed'>
            <div class="item">
                <a class="link-1 secilen-link" href="/">
                    <?=Yii::t('app','lang270'); ?> / 10 <?=Yii::t('app','lang85'); ?>
                    <span class="price"><?=$this->context->packagePrices["announce_search10"]; ?> <?=strtolower(Yii::t('app','lang149')); ?></span>
                </a>
            </div>
            <div class="item">
                <a class="link-2 tecili-link" href="/">
                    <?=Yii::t('app','lang271'); ?>
                    <span class="price"><?=$this->context->packagePrices["announce_urgent"]; ?> <?=strtolower(Yii::t('app','lang149')); ?></span>
                </a>
            </div>
        </div>

        <div style="margin-top:10px;width: 100%;float: left;">
            <?php echo $this->context->banners[6]["text_".Yii::$app->language]; ?>
        </div>

        <div class="soc-panel">
            <div class="fb-like" data-href="<?=$this->context->siteUrl.'/'.$elan["id"].'-'.$slugTitle.'.html';?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
        </div>
        <div class="map-address">
            <h4><?=Yii::t('app','lang28'); ?>: <?=$elan->address; ?></h4>
            <div class="map show_map_google <?php if($elan->google_map=='') echo 'hide'; ?>">
                <img src="http://maps.googleapis.com/maps/api/staticmap?center=<?=str_replace(["(",")"," "],"",$elan->google_map)?>&zoom=14&scale=false&size=560x170&maptype=roadmap&format=png&visual_refresh=true&markers=<?=str_replace(["(",")"," "],"",$elan->google_map)?>&sensor=false&key=AIzaSyDlYLxzojj8VNLy-xtJz5v7-AtuvxOSIyg" alt="" >
                <input type="hidden" value="<?=$elan->google_map; ?>" id="google_map" />
            </div>
            <div class="tag">
                <?=$this->context->locationsGenerator($elan->mark,'elan_view');?>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="main-title mtop-10">
        <span><?=Yii::t('app','lang214'); ?></span>
    </div>
    <div class="ticket-list">
        <?php
        foreach($oxsar_elanlar as $row)
        {
            if($row["urgently"]>0) $urgently='<span class="urgently">'.Yii::t('app','lang196').'</span>'; else $urgently='';
            $title=$this->context->titleGenerator('az',$row["announce_type"],$row["property_type"],$row["space"],$row["room_count"],$row["mark"],$row["settlement"],$row["metro"],$row["region"],$row["city"],$row["country"],$row["address"]);
            $slugTitle=MyFunctionsF::slugGenerator($title);
            $stripTitle=strip_tags($title);

            if($row["sort_search"]>0) $pinned='pinned'; else $pinned='';
            if($row["panarama"]!='') $panarama='<a href="'.Url::to(['/'.$row["id"].'-'.$slugTitle.'.html']).'" target="_blank"><img src="'.MyFunctionsF::getImageUrl().'/360_1.png" alt="" style="margin-left: -127px;position: absolute;margin-top: 30px;"></a>'; else $panarama='';

            if(strlen($row["text"])>220) $str=mb_substr($row["text"],0,220,"utf-8").'...'; else $str=$row["text"];

            echo '<div class="ticket clearfix '.$pinned.'">
                    <div class="img">'.$urgently.'<a href="'.Url::to(['/'.$row["id"].'-'.$slugTitle.'.html']).'" target="_blank"><img src="'.MyFunctionsF::getImageUrl().'/'.$row["cover"].'" alt="'.$stripTitle.'" title="'.$stripTitle.'"></a></div>
					'.$panarama.'
                    <div class="description">
                        <h6 class="title"><a href="'.Url::to(['/'.$row["id"].'-'.$slugTitle.'.html']).'">'.$title.'</a></h6>
                        <div class="pull-left">
                            <div class="info">
                                '.MyFunctionsF::floorGenerator($row["floor_count"],$row["current_floor"],$row["property_type"]).'
                                <span>'.Yii::t('app','lang170').':</span> '.Yii::t('app','document'.$row["document"].'').'
                            </div>
                            <p>'.$str.'</p>
                        </div>
                        <p class="price">'.number_format($row["price"],0,'.',' ').' '.Yii::t('app','lang149').'</p>
                        <div class="address">
                            <a style="display:none;" href="'.Url::to(['/'.$row["id"].'-'.$slugTitle.'.html']).'" class="m-trig">'.Yii::t('app','lang215').' &rarr;</a>
                            <div class="align-right">'.$this->context->locationsGenerator($row["mark"]).'</div>
                        </div>
                    </div>
                </div>';
        }
        ?>
    </div>
</div>





<div class="popup complain">
    <div class="popup-main">
        <a href="/" class="close"></a>
        <h3>Şikayət et</h3>
        <p>Telefon nömrənizi daxil etməklə Sizi<br> maraqlandıran yeni elanlardan dərhal xəbərdar olun</p>
        <form>
            <div class="pull-left">
                <label><span><sup class="opacity-none">*</sup> </span><input type='text' placeholder='Telefon (məcburi deyil)'></label>
                <label><span><sup>*</sup> </span>
                    <select>
                        <option disabled="disabled" value="dis" selected="selected">Səbəb</option>
                        <option>Səbəb</option>
                        <option>Səbəb</option>
                    </select>
                </label>
                <label><span><sup>*</sup> </span><textarea placeholder="Mesaj"></textarea></label>
                <label class="submit-label"><input type="submit" value="Göndər" ></label>
            </div>
        </form>
    </div>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDlYLxzojj8VNLy-xtJz5v7-AtuvxOSIyg"></script>
<script>
    function showMap(){}
    $('.show_map_google').click(function (e) {
        $('body').addClass('themodal-lock');
        $('.popup.google_map, .popup-overlay').css({'opacity': '1', 'visibility': 'visible'});
        e.preventDefault();
    });
    function initialize() {
        var google_map=$("#google_map").val();
        google_map=google_map.replace('(','');
        google_map=google_map.replace(')','');
        google_map=google_map.split(', ');

        var latLng = new google.maps.LatLng(google_map[0], google_map[1]);
        var map = new google.maps.Map(document.getElementById('map-canvas'), {
            zoom: 14,
            center: latLng,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });
        var marker = new google.maps.Marker({
            position: latLng,
            title: 'Point A',
            map: map,
            draggable: false
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>
<div class="popup google_map" style="opacity: 0;">
    <div class="popup-main">
        <a href="javascript:void(0);" class="close"></a>
        <h3><?=Yii::t('app','lang251'); ?></h3>
        <div id="map-canvas" style="width:750px;height:400px;margin-bottom:20px;display:static"></div>
        <button type="button" class="map_ok_button close" style="width:155px;"><?=Yii::t('app','lang93'); ?></button>
    </div>
</div>

<div class="popup send_friend">
    <div class="popup-main">
        <a href="/" class="close"></a>
        <h3>Dostuna göndər</h3>
        <form>
            <div class="pull-left">
                <label><span><sup class="opacity-none">*</sup> </span><input type='text' placeholder='Email'></label>
                <label class="submit-label"><input type="submit" value="Göndər" style="margin-left: 130px;" ></label>
            </div>
        </form>
    </div>
</div>


<?php $text33=$this->context->getPagesInfo(33); ?>
<div class="popup premium premium_et" style="margin: -230px 0 0 -300px;    width: 600px;">
    <div class="popup-main">
        <a href="/" class="close"></a>
        <div class="title"><?=$text33["title_".Yii::$app->language]; ?></div>
        <div class="info">
            <?php
            if($elan->sort_premium<time()) echo $text33["text_".Yii::$app->language];
            else echo Yii::t('app','lang299').' '.date("d.m.Y H:i",$elan->sort_premium);
            ?>
        </div>
        <?php if($elan->sort_premium<time()) { ?>
            <div class="tabs">
                <div class="i-tab">
                    <div><?=Yii::t('app','lang246'); ?></div>
                    <div style="display:none;">Portmanat</div>
                </div>
                <div class="tab-content" style="width:450px;">
                    <div class="tabs-main">
                        <form action="<?=$this->context->siteUrl; ?>/payment/saveitem.php" method="post" target="premiumWindow" id="premiumForm">
                            <input type="hidden" name="item" value="<?=$id; ?>-premium">
                            <input type="hidden" name="lang" value="lv" >
                            <select name="cardType" class="SlectBox w290">
                                <option value="v"><?=Yii::t('app','lang247'); ?></option>
                                <option value="m"><?=Yii::t('app','lang248'); ?></option>
                            </select>
                            <div class="row">
                                <label style="margin-right: 12px;"><input checked="checked" type="radio" name="amount" value="<?=$this->context->packagePrices["announce_premium10"]; ?>"> 10 <?=Yii::t('app','lang85'); ?> / <?=$this->context->packagePrices["announce_premium10"]; ?> <?=Yii::t('app','lang149'); ?></label>
                                <label><input type="radio" name="amount" value="<?=$this->context->packagePrices["announce_premium15"]; ?>"> 15 <?=Yii::t('app','lang85'); ?> / <?=$this->context->packagePrices["announce_premium15"]; ?> <?=Yii::t('app','lang149'); ?></label>
                                <label><input type="radio" name="amount" value="<?=$this->context->packagePrices["announce_premium30"]; ?>"> 30 <?=Yii::t('app','lang85'); ?> / <?=$this->context->packagePrices["announce_premium30"]; ?> <?=Yii::t('app','lang149'); ?></label>
                            </div>
                            <div class="submit-btn">
                                <div>
                                    <button type="button" onclick="Javascript:doPremium();" name="btn_pay"><?=Yii::t('app','lang86'); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tabs-main">
                        tabs 2
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<?php $text34=$this->context->getPagesInfo(34); ?>
<div class="popup premium irelicek" style="margin: -230px 0 0 -300px;    width: 600px;">
    <div class="popup-main">
        <a href="/" class="close"></a>
        <div class="title"><?=$text34["title_".Yii::$app->language]; ?></div>
        <div class="info"><?=$text34["text_".Yii::$app->language]; ?></div>
        <div class="tabs">
            <div class="i-tab">
                <div><?=Yii::t('app','lang246'); ?></div>
                <div <?php if($this->context->userInfo==false) echo 'style="display:none;"'; ?>><?=Yii::t('app','lang266'); ?></div>
                <div style="display:none;">Portmanat</div>
            </div>
            <div class="tab-content" style="width:450px;">
                <div class="tabs-main">
                    <form action="<?=$this->context->siteUrl; ?>/payment/saveitem.php" method="post" target="fowardWindow" id="fowardForm">
                        <input type="hidden" name="item" value="<?=$id; ?>-foward">
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
                                <button type="button" onclick="Javascript:doFoward();" name="btn_pay"><?=Yii::t('app','lang86'); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tabs-main">
                    <form action="<?=$this->context->siteUrl; ?>/callback/foward" method="post">
                        <input type="hidden" name="item" value="<?=$id; ?>">
                        <div class="row" style="margin-bottom:10px;">
                            <?=Yii::t('app','lang267'); ?>:
                            <b><?php if($this->context->userInfo!=false) echo $this->context->userInfo->package_foward; ?></b>
                        </div>
                        <div class="row">
                            <label>1 <?=Yii::t('app','lang150'); ?> / 1 paket</label>
                            <label></label>
                        </div>
                        <div class="submit-btn">
                            <div><button type="submit" name="btn_pay"><?=Yii::t('app','lang281'); ?></button></div>
                        </div>
                    </form>
                </div>
                <div class="tabs-main">
                    portmanat
                </div>
            </div>
        </div>
    </div>
</div>

<?php $text35=$this->context->getPagesInfo(35); ?>
<div class="popup premium secilen" style="margin: -230px 0 0 -300px;    width: 500px;">
    <div class="popup-main">
        <a href="/" class="close"></a>
        <div class="title"><?=$text35["title_".Yii::$app->language]; ?></div>
        <div class="info">
            <?php
            if($elan->sort_search>time()){
				echo Yii::t('app','lang299').' '.date("d.m.Y H:i",$elan->sort_search).'<br /><br />';
				echo Yii::t('app','lang303').' '.date("d.m.Y H:i",time()+(10*86400)).'<br /><br />';
			}
			echo $text35["text_".Yii::$app->language];
            ?>
        </div>
		<div class="tabs">
			<div class="i-tab">
				<div><?=Yii::t('app','lang246'); ?></div>
				<div <?php if($this->context->userInfo==false) echo 'style="display:none;"'; ?>><?=Yii::t('app','lang266'); ?></div>
				<div style="display:none;">Portmanat</div>
			</div>
			<div class="tab-content" style="width:350px;">
				<div class="tabs-main">
					<form action="<?=$this->context->siteUrl; ?>/payment/saveitem.php" method="post" target="searchFowardWindow" id="searchFowardForm">
						<input type="hidden" name="item" value="<?=$id; ?>-searchFoward">
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
								<button type="button" onclick="Javascript:doSearchFoward();" name="btn_pay"><?=Yii::t('app','lang86'); ?></button>
							</div>
						</div>
					</form>
				</div>
				<div class="tabs-main">
					<form action="<?=$this->context->siteUrl; ?>/callback/search" method="post">
						<input type="hidden" name="item" value="<?=$id; ?>">
						<div class="row" style="margin-bottom:10px;">
							<?=Yii::t('app','lang267'); ?>:
							<b><?php if($this->context->userInfo!=false) echo $this->context->userInfo->package_search; ?></b>
						</div>
						<div class="row">
							<label>1 <?=Yii::t('app','lang150'); ?> / 1 paket</label>
							<label></label>
						</div>
						<div class="submit-btn">
							<div><button type="submit" name="btn_pay"><?=Yii::t('app','lang281'); ?></button></div>
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

<?php $text36=$this->context->getPagesInfo(36); ?>
<div class="popup premium tecili" style="margin: -230px 0 0 -300px;    width: 500px;">
    <div class="popup-main">
        <a href="/" class="close"></a>
        <div class="title"><?=$text36["title_".Yii::$app->language]; ?></div>
        <div class="info"><?=$text36["text_".Yii::$app->language]; ?></div>
        <div class="tabs">
            <div class="i-tab">
                <div><?=Yii::t('app','lang246'); ?></div>
                <div style="display:none;">Portmanat</div>
            </div>
            <div class="tab-content" style="width:350px;">
                <div class="tabs-main">
                    <form action="<?=$this->context->siteUrl; ?>/payment/saveitem.php" method="post" target="urgentlyWindow" id="urgentlyForm">
                        <input type="hidden" name="item" value="<?=$id; ?>-urgently">
                        <input type="hidden" name="lang" value="lv" >
                        <select name="cardType" class="SlectBox w290">
                            <option value="v"><?=Yii::t('app','lang247'); ?></option>
                            <option value="m"><?=Yii::t('app','lang248'); ?></option>
                        </select>
                        <div class="row">
                            <label><input checked="checked" type="radio" name="amount" value="<?=$this->context->packagePrices["announce_urgent"]; ?>"> 1 <?=Yii::t('app','lang150'); ?> / <?=$this->context->packagePrices["announce_urgent"]; ?> <?=Yii::t('app','lang149'); ?></label>
                            <label></label>
                        </div>
                        <div class="submit-btn">
                            <div>
                                <button type="button" onclick="Javascript:doUrgently();" name="btn_pay"><?=Yii::t('app','lang86'); ?></button>
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

<div class="popup premium archive ann" style="margin: -230px 0 0 -300px;    width: 500px;">
    <div class="popup-main">
        <a href="/" class="close"></a>
        <div class="title">Əlaqə vasitəsini gör</div>
        <div class="info">Bu funksiyadan istifadə edərək, elanın sahibinin nömrəsini görüntülü edə bilərsiniz.</div>
        <div class="tabs">
            <div class="i-tab">
                <div><?=Yii::t('app','lang246'); ?></div>
                <div style="display:none;">Portmanat</div>
            </div>
            <div class="tab-content" style="width:350px;">
                <div class="tabs-main">
                    <form action="<?=$this->context->siteUrl; ?>/payment/saveitem.php" method="post" target="archiveAnnWindow" id="archiveAnnForm">
                        <input type="hidden" name="item" value="<?=$id; ?>-archiveAnn">
                        <input type="hidden" name="lang" value="lv" >
                        <select name="cardType" class="SlectBox w290">
                            <option value="v"><?=Yii::t('app','lang247'); ?></option>
                            <option value="m"><?=Yii::t('app','lang248'); ?></option>
                        </select>
                        <div class="row">
                            <label><input checked="checked" type="radio" name="amount" value="2">2 <?=Yii::t('app','lang149'); ?></label>
                            <label></label>
                        </div>
                        <div class="submit-btn">
                            <div>
                                <button type="button" onclick="Javascript:doArchiveAnn();" name="btn_pay"><?=Yii::t('app','lang86'); ?></button>
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

<?php $text38=$this->context->getPagesInfo(38); ?>
<div class="popup premium share" style="margin: -230px 0 0 -300px;    width: 500px;">
    <div class="popup-main">
        <a href="/" class="close"></a>
        <div class="title"><?=$text38["title_".Yii::$app->language]; ?></div>
        <div class="info"><?=$text38["text_".Yii::$app->language]; ?></div>
        <div class="tabs">
            <div class="i-tab">
                <div><?=Yii::t('app','lang246'); ?></div>
                <div style="display:none;">Portmanat</div>
            </div>
            <div class="tab-content" style="width:350px;">
                <div class="tabs-main">
                    <form action="<?=$this->context->siteUrl; ?>/payment/saveitem.php" method="post" target="shareWindow" id="shareForm">
                        <input type="hidden" name="item" value="<?=$id; ?>-share">
                        <input type="hidden" name="lang" value="lv" >
                        <select name="cardType" class="SlectBox w290">
                            <option value="v"><?=Yii::t('app','lang247'); ?></option>
                            <option value="m"><?=Yii::t('app','lang248'); ?></option>
                        </select>
                        <div class="row">
                            <label><input checked="checked" type="radio" name="amount" value="<?=$this->context->packagePrices["announce_fb"]; ?>"> 1 <?=Yii::t('app','lang150'); ?> / <?=$this->context->packagePrices["announce_fb"]; ?> <?=Yii::t('app','lang149'); ?></label>
                            <label></label>
                        </div>
                        <div class="submit-btn">
                            <div>
                                <button type="button" onclick="Javascript:doShare();" name="btn_pay"><?=Yii::t('app','lang86'); ?></button>
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

<div class="popup premium panarama_goster" style="margin: -300px 0px 0px -508px;width: 1000px;padding-top:20px;">
    <div class="popup-main">
        <a href="/" class="close"></a>
        <div>
            <iframe src="<?=$elan->panarama?>" style="width:100%;height:550px;"></iframe>
        </div>
    </div>
</div>

<?php
$row=$elan;
$title=$this->context->titleGenerator('az',$row["announce_type"],$row["property_type"],$row["space"],$row["room_count"],$row["mark"],$row["settlement"],$row["metro"],$row["region"],$row["city"],$row["country"],$row["address"]);
$slugTitle=MyFunctionsF::slugGenerator($title);

$relativeHomeUrl = Url::current();
if(intval(strpos($relativeHomeUrl,'-do-premium'))>0) $do_premium_click=true; else $do_premium_click=false;
?>

<script>
    $(function () {
        $(".show_number").click(function()
        {
            var baseurl=$("#baseurl").val();
            var idi=$(this).attr('data-idi');
            $(this).hide();
            $.post(baseurl+"/elanlar/get_ann_mobile?id="+idi,function(data){
                $(".phone").html(data);
            });
        });


        // premium
        <?php
        if($do_premium_click==true){
            echo "$('.popup.premium_et, .popup-overlay').css({'opacity': '1', 'visibility': 'visible'});";
        }
        ?>

        $('.premium-link').click(function (e) {
            $('.popup.premium_et, .popup-overlay').css({'opacity': '1', 'visibility': 'visible'});
            e.preventDefault();
        });
        $('.panarama-link').click(function (e) {
            $('.popup.panarama_goster, .popup-overlay').css({'opacity': '1', 'visibility': 'visible'});
            $('iframe').volume = 0.0;
            e.preventDefault();
        });

        // irelicek
        $('.gg-link').click(function (e) {
            $('.popup.irelicek, .popup-overlay').css({'opacity': '1', 'visibility': 'visible'});
            e.preventDefault();
        });
        // secilen
        $('.secilen-link').click(function (e) {
            $('.popup.secilen, .popup-overlay').css({'opacity': '1', 'visibility': 'visible'});
            e.preventDefault();
        });
        // tecili
        $('.tecili-link').click(function (e) {
            $('.popup.tecili, .popup-overlay').css({'opacity': '1', 'visibility': 'visible'});
            e.preventDefault();
        });
        // share
        $('.share-link').click(function (e) {
            $('.popup.share, .popup-overlay').css({'opacity': '1', 'visibility': 'visible'});
            e.preventDefault();
        });
        //archive ann
        $('.archive-ann').click(function (e) {
            $('.popup.archive, .popup-overlay').css({'opacity': '1', 'visibility': 'visible'});
            e.preventDefault();
        });
    });

    var popup;
    function doPremium() {
        popup = window.open('', 'premiumWindow', "toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=0,top=70,left=370,width=630,height=600");
        document.getElementById('premiumForm').submit();
        popup.focus();
    }
    function doFoward() {
        popup = window.open('', 'fowardWindow', "toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=0,top=70,left=370,width=630,height=600");
        document.getElementById('fowardForm').submit();
        popup.focus();
    }
    function doSearchFoward() {
        popup = window.open('', 'searchFowardWindow', "toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=0,top=70,left=370,width=630,height=600");
        document.getElementById('searchFowardForm').submit();
        popup.focus();
    }
    function doUrgently() {
        popup = window.open('', 'urgentlyWindow', "toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=0,top=70,left=370,width=630,height=600");
        document.getElementById('urgentlyForm').submit();
        popup.focus();
    }
    function doShare() {
        popup = window.open('', 'shareWindow', "toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=0,top=70,left=370,width=630,height=600");
        document.getElementById('shareForm').submit();
        popup.focus();
    }
    function doArchiveAnn() {
        popup = window.open('', 'archiveAnnWindow', "toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=0,top=70,left=370,width=630,height=600");
        document.getElementById('archiveAnnForm').submit();
        popup.focus();
    }
    function refreshParent(){
        return location.href= "http://emlak.az/<?=$row["id"].'-'.$slugTitle.'.html';?>";
    }
</script>