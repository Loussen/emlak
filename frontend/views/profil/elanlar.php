<?php
use yii\helpers\Url;
use frontend\components\MyFunctionsF;
$this->title=$this->context->userInfo->name;
?>
<script type="text/javascript" src="<?=Yii::$app->homeUrl; ?>/js/jquery.fancybox.js"></script>
<link rel="stylesheet" type="text/css" href="<?=Yii::$app->homeUrl; ?>/css/jquery.fancybox.css" media="screen" />
<style>
.fancybox-opened{visibility: inherit!important;}
</style>

<div class="content clearfix broker user ok_page">
    <?php
    if(Yii::$app->session->hasFlash('success')) echo '<div class="alert-success alert">'.Yii::$app->session->getFlash('success').'</div>';
    if(Yii::$app->session->hasFlash('warning')) echo '<div class="alert-danger alert">'.Yii::$app->session->getFlash('warning').'</div>';
    if(Yii::$app->session->hasFlash('danger')) echo '<div class="alert-danger alert">'.Yii::$app->session->getFlash('danger').'</div>';
    ?>
    <div class="panel clearfix">
        <h1>
            <?php
            if($status==0) echo Yii::t('app','lang120');
            elseif($status==2) echo Yii::t('app','lang136');
            elseif($status==3) echo Yii::t('app','lang137');
            elseif($status==4) echo Yii::t('app','lang138');
            else echo Yii::t('app','lang119');
            echo ' - ';
            echo $announces_count; ?> <?=Yii::t('app','lang190');
            ?>
       </h1>
        <select onchange="MM_jumpMenu('parent',this,0)" class="z-index120">
            <option value="<?=Url::toRoute([$link.'&sort_type=1']); ?>" <?php if($sort_type==1) echo 'selected="selected"'; ?>><?=Yii::t('app','lang191'); ?></option>
            <option <?php if($status==2 || $status==4) echo 'disabled="disabled"'; ?> value="<?=Url::toRoute([$link.'&sort_type=2']); ?>" <?php if($sort_type==2) echo 'selected="selected"'; ?>><?=Yii::t('app','lang192'); ?></option>
            <option <?php if($status==2 || $status==4) echo 'disabled="disabled"'; ?> value="<?=Url::toRoute([$link.'&sort_type=3']); ?>" <?php if($sort_type==3) echo 'selected="selected"'; ?>><?=Yii::t('app','lang193'); ?></option>
            <option <?php if($status==2 || $status==4) echo 'disabled="disabled"'; ?> value="<?=Url::toRoute([$link.'&sort_type=4']); ?>" <?php if($sort_type==4) echo 'selected="selected"'; ?>><?=Yii::t('app','lang194'); ?></option>
        </select>
        <h1 style="float: right;"><?=Yii::t('app','lang195'); ?>:&nbsp;</h1>
        <a href="<?=Url::to([$link.'&map=1']);?>"><?=Yii::t('app','lang177'); ?></a>
    </div>
    <div class="ticket-list">
        <?php
		foreach($announces as $row){
			if($row["urgently"]>0) $urgently='<span class="urgently">'.Yii::t('app','lang196').'</span>'; else $urgently='';
			$title=$this->context->titleGenerator('az',$row["announce_type"],$row["property_type"],$row["space"],$row["room_count"],$row["mark"],$row["settlement"],$row["metro"],$row["region"],$row["city"],$row["country"],$row["address"]);
			$slugTitle=MyFunctionsF::slugGenerator($title);
			$stripTitle=strip_tags($title);

			$code=MyFunctionsF::codeGeneratorforUser($row["id"]);
			
			if($row["status"]==1 or $row["status"]==3){
				$editURL='elan-ver/index?id='.$row["id"].'&code='.$code.'&status='.$status; $editURL=Url::toRoute([$editURL]);
				$editClass='tooltip';
				$editDataTitle='data-title="'.Yii::t('app','lang255').'"';
			}else{
				$editURL='javascript:void(0);';
				$editClass='ann_disabled';
				$editDataTitle='';
			}
			if($row["status"]!=0 && $row["deleted_time"]==0){
				$deleteURL='profil/elanlar/?delete='.$row["id"].'&status='.$status;	$deleteURL=Url::toRoute([$deleteURL]);
				$deleteClass='tooltip';
				$deleteDataTitle='data-title="'.Yii::t('app','lang257').'"';
			}else{
				$deleteURL='javascript:void(0);';
				$deleteClass='ann_disabled';
				$deleteDataTitle='';
			}
			
			if($row["id"]>=248262){
				$downloadClass='img_download-link tooltip';
				$downloadDataTitle='data-title="'.Yii::t('app','lang290').'"';
			}else{
				$downloadClass='ann_disabled';
				$dataTitle='';
				$downloadDataTitle='';
			}
			
			if($row["status"]==1) $dayCount=Yii::t('app','lang198').' '.$this->context->getLeftDays($row["announce_date"]).' '.Yii::t('app','lang199');
			else $dayCount='';
			
			if($row["status"]==2 or $row["status"]==4){
				$button_val=Yii::t('app','lang259');
				$popup_val=Yii::t('app','lang262').'<br />'.Yii::t('app','lang263');
			}else{
				$button_val=Yii::t('app','lang258');
				$popup_val=Yii::t('app','lang260').'<br />'.Yii::t('app','lang261');
			}

            if($row["cdn_server"]==1)
                $imageCurrentUrl = Yii::$app->params["cdn_".Yii::$app->params['currentCDN']]['CDNSERVER_URL']."images";
            else
                $imageCurrentUrl = MyFunctionsF::getImageUrl();

			echo '<div class="ticket clearfix">
			<div class="img">'.$urgently.'<a href="'.Url::to(['/'.$row["id"].'-'.$slugTitle.'.html']).'" target="_blank"><img class="profil_cover_img" src="'.$imageCurrentUrl.'/'.$row["cover"].'" alt="'.$title.'" title="'.$stripTitle.'"></a></div>
			<div class="description">
				<h6 class="title" style="width:430px;"><a href="'.Url::to(['/'.$row["id"].'-'.$slugTitle.'.html']).'">'.$title.'</a></h6>
				<div class="pull-left">
					<div class="info">
						'.MyFunctionsF::floorGenerator($row["floor_count"],$row["current_floor"],$row["property_type"]).'
						<span>'.Yii::t('app','lang170').':</span> '.Yii::t('app','document'.$row["document"].'').'
						&nbsp;&nbsp;&nbsp;&nbsp;<span>'.Yii::t('app','lang187').':</span> <span class="showCode">'.$row["id"].'</span>
					</div>
					<p>'.stripslashes(mb_substr($row["text"],0,220,"utf-8")).'...</p>
				</div>
				<p class="price">'.$row["price"].' '.Yii::t('app','lang149').'</p>
				<div class="address">
					<div class="align-right">'.$this->context->locationsGenerator($row["mark"]).'</div>
				</div>
			</div>
			<div class="pull-right">
				<ul>
					<li><a href="'.$editURL.'" class="'.$editClass.'" '.$editDataTitle.'><img src="'.MyFunctionsF::getImageUrl().'/ico/pen-ico.png" alt="" ></a></li>
					<li><a href="'.$deleteURL.'" class="'.$deleteClass.'" '.$deleteDataTitle.'><img src="'.MyFunctionsF::getImageUrl().'/ico/delete-ico.png" alt="" ></a></li>
					<li><a href="javascript:void(0);" data-idi="'.$row["id"].'" class="'.$downloadClass.'" '.$downloadDataTitle.'><img src="'.MyFunctionsF::getImageUrl().'/ico/download-ico.png" alt="" ></a></li>
				</ul>
				<p>
					'.$dayCount.'<br>
					'.Yii::t('app','lang200').': '.$row["view_count"].' '.Yii::t('app','lang201').'
				</p>
				<a href="'.Url::to(['profil/reklam/'.$row["id"]]).'" class="call-popup submit-btn" data-idi="'.$row["id"].'">'.$button_val.'</a>
			</div>
		</div>';
		}
        ?>
    </div>
    <div class="pagination">
        <ul>
            <?php
            //Paginator ///////////////////////////////////////////
            if ($page > $show + 1) echo '<li><a href="'.Url::to([$link.'&page=1']).'"> &Larr; İlk</a></li>';
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
            if ($page < $max_page - $show && $max_page > 1) echo '<li><a href="'.Url::to([$link.'&page='.$max_page]).'">Son &Rarr; </a></li>';
            //Paginator ///////////////////////////////////////////
            ?>
        </ul>
    </div>
	<?php echo Yii::$app->controller->renderPartial('/layouts/includes/tags'); ?>
</div>

<?php $text39=$this->context->getPagesInfo(39); ?>
<div class="popup premium img_download" style="margin: -230px 0 0 -300px;    width: 600px;">
    <div class="popup-main">
        <a href="/" class="close"></a>
        <div class="title"><?=$text39["title_".Yii::$app->language]; ?></div>
        <div class="info"><?=$text39["text_".Yii::$app->language]; ?></div>
        <div class="tabs">
            <div class="i-tab">
                <div><?=Yii::t('app','lang246'); ?></div>
                <div style="display: none;">Portmanat</div>
            </div>
            <div class="tab-content" style="width:450px;">
                <div class="tabs-main">
                    <form action="<?=$this->context->siteUrl; ?>/payment/saveitem.php" method="post" target="downloadWindow" id="downloadForm">
						<input type="hidden" name="item" id="itemImgDownload" value="0-imgDownload"> 
						<input type="hidden" name="lang" value="lv" >
                        <select name="cardType" class="SlectBox w290">
                            <option value="v"><?=Yii::t('app','lang247'); ?></option>
                            <option value="m"><?=Yii::t('app','lang248'); ?></option>
                        </select>
                        <div class="row">
                            <label style="margin-right: 12px;"><input checked="checked" type="radio" name="amount" value="<?=$this->context->packagePrices["announce_download"]; ?>"> 1 <?=Yii::t('app','lang150'); ?> / <?=$this->context->packagePrices["announce_download"]; ?> <?=Yii::t('app','lang149'); ?></label>
                            <label> </label>
                        </div>
                        <div class="submit-btn">
                            <div>
                                <button type="button" onclick="Javascript:doDownload();" name="btn_pay"><?=Yii::t('app','lang86'); ?></button>
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


<script type="text/JavaScript">
    function MM_jumpMenu(targ,selObj,restore){ //v3.0
        eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
        if (restore) selObj.selectedIndex=0;
    }
</script>


<script>
var popup;
function doDownload() {
	var current_ann=$("#current_ann").val(); var item=current_ann+'-imgDownload'; $("#itemImgDownload").val(item);
	popup = window.open('', 'downloadWindow', "toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=0,top=70,left=370,width=630,height=600");
	document.getElementById('downloadForm').submit(); popup.focus();
}
	
$(function () {
	$('.img_download-link').click(function (e) {
		$("#current_ann").val($(this).attr('data-idi'));
        $('.popup.img_download, .popup-overlay').css({'opacity': '1', 'visibility': 'visible'});
        e.preventDefault();
    });
});

var popup;
function doAll() {
	popup = window.open('', 'allWindow', "toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=0,top=70,left=370,width=630,height=600");
	document.getElementById('allForm').submit();
	popup.focus();
}

function refreshParent(){
	return location.href= "http://emlak.az/profil/elanlar/?status=<?=$status;?>";
}
</script>