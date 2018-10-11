<?php
use yii\helpers\Url;
use frontend\components\MyFunctionsF;
$this->title = $this->context->siteTitle;

if($q=='') $title=Yii::t('app','lang245'); else $title=$q;
?>
<div class="content clearfix broker">
    <?php echo Yii::$app->controller->renderPartial('/layouts/includes/2_banners'); ?>

    <div class="panel clearfix">
        <h1 class="title"><?=$title; ?><span> / <?=$announces_count; ?> <?=Yii::t('app','lang190'); ?></span></h1>
        <select onchange="MM_jumpMenu('parent',this,0)" class="z-index120">
            <option value="<?=Url::toRoute([$link.'&sort_type=1']); ?>" <?php if($sort_type==1) echo 'selected="selected"'; ?>><?=Yii::t('app','lang191'); ?></option>
            <option value="<?=Url::toRoute([$link.'&sort_type=2']); ?>" <?php if($sort_type==2) echo 'selected="selected"'; ?>><?=Yii::t('app','lang192'); ?></option>
            <option value="<?=Url::toRoute([$link.'&sort_type=3']); ?>" <?php if($sort_type==3) echo 'selected="selected"'; ?>><?=Yii::t('app','lang193'); ?></option>
            <option value="<?=Url::toRoute([$link.'&sort_type=4']); ?>" <?php if($sort_type==4) echo 'selected="selected"'; ?>><?=Yii::t('app','lang194'); ?></option>
        </select>
        <span class="span_h1"><?=Yii::t('app','lang195'); ?>:&nbsp;</span>
        <a href="<?=Url::to([$link.'&map=1']);?>"><?=Yii::t('app','lang177'); ?></a>
    </div>

    <?php if(Yii::$app->session->hasFlash('danger')) echo '<div class="alert-danger alert" style="margin-bottom:0px;">'.Yii::$app->session->getFlash('danger').'</div>'; ?>

    <div class="ticket-list">
        <?php
        $to=[];
        if($showColor==true){
            foreach($searchWord as $w){
                $to[]='<label class="q_word">'.$w.'</label>';
            }
        }

        $say=1;
        foreach($announces as $row)
        {

            if($this->context->userInfo==true)
                if(strpos($this->context->userInfo->archive_ann,"-")>0)
                    $arch_ann_arr = explode("-",$this->context->userInfo->archive_ann);
                else
                    $arch_ann_arr = [$this->context->userInfo->archive_ann];
            else
                $arch_ann_arr = array();

            if(in_array($row["id"],$arch_ann_arr) && count($arch_ann_arr)>0) $color = "green";
            else $color = "#A9A9A9";

            if($row["urgently"]>0) $urgently='<span class="urgently">'.Yii::t('app','lang196').'</span>'; else $urgently='';
            if($row["archive_view"]>0 && $row["status"]==2 ) $archive_view='<span class="urgently" style="background: '.$color.';">Arxiv</span>'; else $archive_view='';
            $title=$this->context->titleGenerator('az',$row["announce_type"],$row["property_type"],$row["space"],$row["room_count"],$row["mark"],$row["settlement"],$row["metro"],$row["region"],$row["city"],$row["country"],$row["address"]);
            $slugTitle=MyFunctionsF::slugGenerator($title);
            $stripTitle=strip_tags($title);

            if($row["sort_search"]>0) $pinned='pinned'; else $pinned='';
            if($row["panarama"]!='') $panarama='<a href="'.Url::to(['/'.$row["id"].'-'.$slugTitle.'.html']).'" target="_blank"><img src="'.MyFunctionsF::getImageUrl().'/360_1.png" alt="" title="'.$stripTitle.'" style="margin-left: -127px;position: absolute;margin-top: 30px;"></a>'; else $panarama='';

            if(strlen($row["text"])>220) $str=mb_substr($row["text"],0,220,"utf-8").'...'; else $str=$row["text"];

            if($showColor==true) $str=str_replace($searchWord,$to,$str);

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

            if($row["cdn_server"]==1)
                $imageCurrentUrl = Yii::$app->params["cdn_".Yii::$app->params['currentCDN']]['CDNSERVER_URL']."images";
            else
                $imageCurrentUrl = MyFunctionsF::getImageUrl();

            Yii::$app->cache->flush();

            echo '<div class="ticket clearfix '.$pinned.'">
					<div class="img">'.$urgently.$archive_view.'<a href="'.Url::to(['/'.$row["id"].'-'.$slugTitle.'.html']).'" target="_blank"><img src="'.$imageCurrentUrl.'/'.$row["cover"].'" alt="'.$stripTitle.'" title="'.$stripTitle.'"></a></div>
					'.$panarama.'
					<div class="description">
						<h6 class="title"><a href="'.Url::to(['/'.$row["id"].'-'.$slugTitle.'.html']).'" target="_blank">'.$title.'</a></h6>
						<div class="pull-left">
							<div class="info">
								'.MyFunctionsF::floorGenerator($row["floor_count"],$row["current_floor"],$row["property_type"]).'
								<span>'.Yii::t('app','lang170').':</span> '.Yii::t('app','document'.$row["document"].'').'
							</div>
							<p>'.$str.'</p>
						</div>
						<p class="price">'.number_format($row["price"],0,'.',' ').' '.Yii::t('app','lang149').$rent_type.'</p>
						<div class="address">
							<a style="display:none;" href="'.Url::to(['/'.$row["id"].'-'.$slugTitle.'.html']).'" class="m-trig">'.Yii::t('app','lang215').' &rarr;</a>
							<div class="align-right">'.$this->context->locationsGenerator($row["mark"]).'</div>
						</div>
					</div>
				</div>';
            if($say==4 && strlen($this->context->banners[9]["text_".Yii::$app->language])>0){
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
            if($page<3) $show=5;
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

    $(document).ready(function(){
        $('#info .tabs-content').hide();
        $('#info-nav .current').removeClass("current");
        $('#info-nav li').eq(2).addClass('current');
        $('#info #search').show();
    });
</script>