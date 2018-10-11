<?php
use yii\helpers\Url;
use frontend\components\MyFunctionsF;

$this->title=$info["title_"];
?>
<div class="content clearfix broker">
    <div class="in-panel">
        <a href="<?=Url::toRoute(['emlakcilar/']); ?>" class="prev">&ShortLeftArrow; <?=Yii::t('app','lang133'); ?></a>
        <h1><?=$info["name"]; ?></h1>
    </div>
    <div class="broker-info clearfix">
        <div class="img">
            <?php
            if(!is_file(MyFunctionsF::getImagePath().'/'.$info["thumb"])) $src='unknow_man.jpg';
            else $src=$info["thumb"];
            ?>
            <img src="<?=MyFunctionsF::getImageUrl().'/'.$src; ?>" alt="">
        </div>
        <div class="desc" style="margin-left: 15px;">
            <div class="title"><?=Yii::t('app','lang99'); ?></div>
            <p><?=$info["text"]; ?></p>
            <div class="tabs">
                <div class="i-tab">
                    <div><?=Yii::t('app','lang59'); ?> (<?=$satis_count; ?>)</div>
                    <div><?=Yii::t('app','lang60'); ?> (<?=$icare_count; ?>)</div>
                </div>
                <div class="tab-content" style="width:730px;padding: 15px 15px;">
                    <div class="tabs-main">
						<b style="float:left;width:100px;margin-right:7px;"><?=Yii::t('app','property_type1'); ?>:</b>
                        <a href="<?=Url::to([$url.'?ann=1&tip=yeni_tikili&room=1']); ?>">1 <?=Yii::t('app','lang185'); ?> (<?=$ts1_2_p1r1;?>) </a>
                        <a href="<?=Url::to([$url.'?ann=1&tip=yeni_tikili&room=2']); ?>">2 <?=Yii::t('app','lang185'); ?> (<?=$ts1_2_p1r2;?>) </a>
                        <a href="<?=Url::to([$url.'?ann=1&tip=yeni_tikili&room=3']); ?>">3 <?=Yii::t('app','lang185'); ?> (<?=$ts1_2_p1r3;?>) </a>
                        <a href="<?=Url::to([$url.'?ann=1&tip=yeni_tikili&room=5']); ?>">4 <?=Yii::t('app','lang185'); ?> (<?=$ts1_2_p1r4;?>) </a>
                        <a href="<?=Url::to([$url.'?ann=1&tip=yeni_tikili&room=6']); ?>">5+ <?=Yii::t('app','lang185'); ?> (<?=$ts1_2_p1r5;?>) </a>
						<br />
						<b style="float:left;width:100px;margin-right:7px;"><?=Yii::t('app','property_type2'); ?>:</b>
                        <a href="<?=Url::to([$url.'?ann=1&tip=kohne_tikili&room=1']); ?>">1 <?=Yii::t('app','lang185'); ?> (<?=$ts1_2_p2r1;?>) </a>
                        <a href="<?=Url::to([$url.'?ann=1&tip=kohne_tikili&room=2']); ?>">2 <?=Yii::t('app','lang185'); ?> (<?=$ts1_2_p2r2;?>) </a>
                        <a href="<?=Url::to([$url.'?ann=1&tip=kohne_tikili&room=3']); ?>">3 <?=Yii::t('app','lang185'); ?> (<?=$ts1_2_p2r3;?>) </a>
                        <a href="<?=Url::to([$url.'?ann=1&tip=kohne_tikili&room=4']); ?>">4 <?=Yii::t('app','lang185'); ?> (<?=$ts1_2_p2r4;?>) </a>
                        <a href="<?=Url::to([$url.'?ann=1&tip=kohne_tikili&room=5']); ?>">5+ <?=Yii::t('app','lang185'); ?> (<?=$ts1_2_p2r5;?>) </a>
						<br />
						<b style="float:left;width:100px;margin-right:7px;"><?=Yii::t('app','lang232'); ?>:</b>
                        <a href="<?=Url::to([$url.'?ann=1&tip=villalar']); ?>"><?=Yii::t('app','property__type3'); ?> (<?=$ts3;?>)</a>
                        <a href="<?=Url::to([$url.'?ann=1&tip=bag-evleri']); ?>"><?=Yii::t('app','property__type4'); ?> (<?=$ts4;?>)</a>
                        <a href="<?=Url::to([$url.'?ann=1&tip=ofisler']); ?>"><?=Yii::t('app','property__type5'); ?> (<?=$ts5;?>)</a>
                        <a href="<?=Url::to([$url.'?ann=1&tip=qarajlar']); ?>"><?=Yii::t('app','property__type6'); ?> (<?=$ts6;?>)</a>
                        <a href="<?=Url::to([$url.'?ann=1&tip=torpaqlar']); ?>"><?=Yii::t('app','property__type7'); ?> (<?=$ts7;?>)</a>
                        <a href="<?=Url::to([$url.'?ann=1&tip=obyektler']); ?>"><?=Yii::t('app','property__type8'); ?> (<?=$ts8;?>)</a>
                    </div>
                    <div class="tabs-main">
						<b style="float:left;width:100px;margin-right:7px;"><?=Yii::t('app','property_type1'); ?>:</b>
                        <a href="<?=Url::to([$url.'?ann=2&tip=yeni_tikili&room=1']); ?>">1 <?=Yii::t('app','lang185'); ?> (<?=$ti1_2_p1r1;?>) </a>
                        <a href="<?=Url::to([$url.'?ann=2&tip=yeni_tikili&room=2']); ?>">2 <?=Yii::t('app','lang185'); ?> (<?=$ti1_2_p1r2;?>) </a>
                        <a href="<?=Url::to([$url.'?ann=2&tip=yeni_tikili&room=3']); ?>">3 <?=Yii::t('app','lang185'); ?> (<?=$ti1_2_p1r3;?>) </a>
                        <a href="<?=Url::to([$url.'?ann=2&tip=yeni_tikili&room=5']); ?>">4 <?=Yii::t('app','lang185'); ?> (<?=$ti1_2_p1r4;?>) </a>
                        <a href="<?=Url::to([$url.'?ann=2&tip=yeni_tikili&room=6']); ?>">5+ <?=Yii::t('app','lang185'); ?> (<?=$ti1_2_p1r5;?>) </a>
						<br />
						<b style="float:left;width:100px;margin-right:7px;"><?=Yii::t('app','property_type2'); ?>:</b>
                        <a href="<?=Url::to([$url.'?ann=2&tip=kohne_tikili&room=1']); ?>">1 <?=Yii::t('app','lang185'); ?> (<?=$ti1_2_p2r1;?>) </a>
                        <a href="<?=Url::to([$url.'?ann=2&tip=kohne_tikili&room=2']); ?>">2 <?=Yii::t('app','lang185'); ?> (<?=$ti1_2_p2r2;?>) </a>
                        <a href="<?=Url::to([$url.'?ann=2&tip=kohne_tikili&room=3']); ?>">3 <?=Yii::t('app','lang185'); ?> (<?=$ti1_2_p2r3;?>) </a>
                        <a href="<?=Url::to([$url.'?ann=2&tip=kohne_tikili&room=4']); ?>">4 <?=Yii::t('app','lang185'); ?> (<?=$ti1_2_p2r4;?>) </a>
                        <a href="<?=Url::to([$url.'?ann=2&tip=kohne_tikili&room=5']); ?>">5+ <?=Yii::t('app','lang185'); ?> (<?=$ti1_2_p2r5;?>) </a>
						<br />
						<b style="float:left;width:100px;margin-right:7px;"><?=Yii::t('app','lang232'); ?>:</b>
                        <a href="<?=Url::to([$url.'?ann=2&tip=villalar']); ?>"><?=Yii::t('app','property__type3'); ?> (<?=$ti3;?>)</a>
                        <a href="<?=Url::to([$url.'?ann=2&tip=bag-evleri']); ?>"><?=Yii::t('app','property__type4'); ?> (<?=$ti4;?>)</a>
                        <a href="<?=Url::to([$url.'?ann=2&tip=ofisler']); ?>"><?=Yii::t('app','property__type5'); ?> (<?=$ti5;?>)</a>
                        <a href="<?=Url::to([$url.'?ann=2&tip=qarajlar']); ?>"><?=Yii::t('app','property__type6'); ?> (<?=$ti6;?>)</a>
                        <a href="<?=Url::to([$url.'?ann=2&tip=torpaqlar']); ?>"><?=Yii::t('app','property__type7'); ?> (<?=$ti7;?>)</a>
                        <a href="<?=Url::to([$url.'?ann=2&tip=obyektler']); ?>"><?=Yii::t('app','property__type8'); ?> (<?=$ti8;?>)</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="contacts">
            <?php
            $mobiles=explode("***",$info["mobile"]);
            $echo_mobile='';
            foreach($mobiles as $mobile)
            {
                if($mobile!='') $echo_mobile.= '<p>'.$mobile.'</p>';
            }
            if($echo_mobile!='') echo '<div class="user_phones" style="margin-top: -7px;">'.$echo_mobile.'</div>';
            ?>
			
			<div class="user_email" style="margin-top: -12px;">
			<?php
			if($info["login"]=='') echo '<a href="'.Url::toRoute([$url]).'">emlak.az/emlakcilar/'.$info["id"].'</a>';
			else echo '<a href="'.Url::toRoute([$url]).'">emlak.az/'.$info["login"].'</a>';
			?>
            </div>
			<div class="clearfix"></div>
            <?php if($info["address"]!='') echo '<div class="address" style="margin-left: -42px;margin-top: 12px;line-height: 16px;padding-top: 4px;">'.$info["address"].'</div>'; ?>
        </div>
		<div class="clearfix">&nbsp;</div>
    </div>
    <div class="panel clearfix">
        <h1 class="title"><?=Yii::t('app','lang134'); ?><span> / <?=$announces_count; ?> <?=Yii::t('app','lang190'); ?></span></h1>
        <select onchange="MM_jumpMenu('parent',this,0)" class="z-index120">
            <option value="<?=Url::toRoute([$link.'&sort_type=1']); ?>" <?php if($sort_type==1) echo 'selected="selected"'; ?>><?=Yii::t('app','lang191'); ?></option>
            <option value="<?=Url::toRoute([$link.'&sort_type=2']); ?>" <?php if($sort_type==2) echo 'selected="selected"'; ?>><?=Yii::t('app','lang192'); ?></option>
            <option value="<?=Url::toRoute([$link.'&sort_type=3']); ?>" <?php if($sort_type==3) echo 'selected="selected"'; ?>><?=Yii::t('app','lang193'); ?></option>
            <option value="<?=Url::toRoute([$link.'&sort_type=4']); ?>" <?php if($sort_type==4) echo 'selected="selected"'; ?>><?=Yii::t('app','lang194'); ?></option>
        </select>
        <h1 style="float: right;"><?=Yii::t('app','lang195'); ?>:&nbsp;</h1>
        <a href="<?=Url::to([$link.'&map=1']);?>"><?=Yii::t('app','lang177'); ?></a>
    </div>
    <div class="ticket-list">
        <?php
		$say=1;
        foreach($announces as $row)
        {
            if($row["urgently"]>0) $urgently='<span class="urgently">'.Yii::t('app','lang196').'</span>'; else $urgently='';
            $title=$this->context->titleGenerator('az',$row["announce_type"],$row["property_type"],$row["space"],$row["room_count"],$row["mark"],$row["settlement"],$row["metro"],$row["region"],$row["city"],$row["country"],$row["address"]);
            $slugTitle=MyFunctionsF::slugGenerator($title);
            $stripTitle=strip_tags($title);
			
			if($row["sort_search"]>0) $pinned='pinned'; else $pinned='';
			
			if(strlen($row["text"])>220) $str=mb_substr($row["text"],0,220,"utf-8").'...'; else $str=$row["text"];
			
            echo '<div class="ticket clearfix '.$pinned.'">
                        <div class="img">'.$urgently.'<a href="'.Url::to(['/'.$row["id"].'-'.$slugTitle.'.html']).'" target="_blank"><img src="'.MyFunctionsF::getImageUrl().'/'.$row["cover"].'" alt="'.$stripTitle.'" title="'.$stripTitle.'"></a></div>
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
			if($say==4){
				$banners=$this->context->banners[9]["text_".Yii::$app->language]; $banners=explode('***',$banners); array_filter($banners); $banner=rand(0,count($banners));
				echo '<div class="banner_search">'.$banners[rand(0,count($banners)-1)].'</div>';
			}
			$say++;
        }
        ?>
    </div>
    <div class="pagination">
        <ul>
            <?php
            //Paginator ///////////////////////////////////////////
			if($page<3) $show=5; else $show=3;
            if($page>1) echo '<li><a href="'.Url::to([$link.'&page='.($page-1)]).'"> &larr; '.Yii::t('app','lang29').'</a></li>';
            for($i=$page-$show;$i<=$page+$show;$i++)
            {
                if($i>0 && $i<=$max_page)
                {
                    if($i==$page) echo '<li class="active"><a href="javascript:void(0);">'.$i.'</a></li>';
                    else echo '<li><a href="'.Url::to([$link.'&page='.$i]).'">'.$i.'</a></li>';
                }
            }
            if($page<$max_page) echo '<li><a href="'.Url::to([$link.'&page='.($page+1)]).'">'.Yii::t('app','lang30').' &rarr; </a></li>';
            //Paginator ///////////////////////////////////////////
            ?>
        </ul>
    </div>
	<?php echo Yii::$app->controller->renderPartial('/layouts/includes/tags'); ?>
</div>



<script type="text/JavaScript">
    function MM_jumpMenu(targ,selObj,restore){ //v3.0
        eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
        if (restore) selObj.selectedIndex=0;
    }
</script>