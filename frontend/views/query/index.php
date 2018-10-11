<?php
use yii\helpers\Url;
use frontend\components\MyFunctionsF;
$this->title = $title;
?>
<div class="content clearfix broker">
    <div class="panel clearfix">
        <h1 style="width: 444px;" class="title"><?=$title; ?><span> / <?=$announces_count; ?> <?=Yii::t('app','lang190'); ?></span></h1>
        <select onchange="MM_jumpMenu('parent',this,0)" class="z-index120" style="display:none;">
            <option value="<?=Url::toRoute([$link.'&sort_type=1']); ?>"><?=Yii::t('app','lang191'); ?></option>
            <option disabled="disabled" value="<?=Url::toRoute([$link.'&sort_type=2']); ?>"><?=Yii::t('app','lang192'); ?></option>
            <option disabled="disabled" value="<?=Url::toRoute([$link.'&sort_type=3']); ?>"><?=Yii::t('app','lang193'); ?></option>
            <option disabled="disabled" value="<?=Url::toRoute([$link.'&sort_type=4']); ?>"><?=Yii::t('app','lang194'); ?></option>
        </select>
        <span class="span_h1"><?=Yii::t('app','lang195'); ?>:&nbsp;</span>
        <a href="javascript:void(0);"><?=Yii::t('app','lang177'); ?></a>
    </div>
	
	<?php if(Yii::$app->session->hasFlash('danger')) echo '<div class="alert-danger alert" style="margin-bottom:0px;">'.Yii::$app->session->getFlash('danger').'</div>'; ?>
	
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
                        <div class="img">'.$urgently.'<a href="'.Url::to(['/'.$row["id"].'-'.$slugTitle.'.html']).'"><img src="'.MyFunctionsF::getImageUrl().'/'.$row["cover"].'" alt="'.$stripTitle.'" title="'.$stripTitle.'"></a></div>
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
			if($page<3) $show=5;
            if($page>1) echo '<li><a href="'.Url::to([$link.'?page='.($page-1)]).'"> &larr; '.Yii::t('app','lang29').'</a></li>';
            for($i=$page-$show;$i<=$page+$show;$i++)
            {
                if($i>0 && $i<=$max_page)
                {
                    if($i==$page) echo '<li class="active"><a href="javascript:void(0);">'.$i.'</a></li>';
                    else echo '<li><a href="'.Url::to([$link.'?page='.$i]).'">'.$i.'</a></li>';
                }
            }
            if($page<$max_page) echo '<li><a href="'.Url::to([$link.'?page='.($page+1)]).'">'.Yii::t('app','lang30').' &rarr; </a></li>';
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