<script src="<?=Yii::$app->homeUrl; ?>/js/jquery.formstyler.js"></script>
<script src="<?=Yii::$app->homeUrl; ?>/js/callStyler.js"></script>
<style>
.fancybox-inner{min-height:500px!important;overflow:hidden!important;}
</style>

<?php $popup_val=Yii::t('app','lang260').'<br />'.Yii::t('app','lang261'); ?>
<div class="improve" style="padding:30px;min-height:450px;">
    <div class="popup-main">
        <div class="red_title"><?=$popup_val; ?></div>
        <form class="order_form" action="" id="order_form_active" method="post">
			<input type="hidden" value="<?=$id?>" id="current_ann" name="current_ann" />
            <div class="order_type arr_p">
                <div>
					<?=Yii::t('app','lang249'); ?>
					<div class="tooltips"><?=Yii::t('app','lang274'); ?> <a href="" style="display: none;">Ətraflı oxu</a></div>
				</div>
                <?php
				$pr1=$this->context->packagePrices["announce_premium30"];
				$pr2=$this->context->packagePrices["announce_premium15"];
				$pr3=$this->context->packagePrices["announce_premium10"];
				
				if($elan->sort_premium==0){
				?>
				<label class="price1"><input type="radio" onchange="" name="premium" class="radio_change" data-price="<?=$pr1;?>">30 <?=Yii::t('app','lang85'); ?> / <?=$pr1; ?> <?=Yii::t('app','lang149'); ?></label>
				<label class="price2"><input type="radio" name="premium" class="radio_change" data-price="<?=$pr2;?>">15 <?=Yii::t('app','lang85'); ?> / <?=$pr2; ?> <?=Yii::t('app','lang149'); ?></label>
				<label class="price3"><input type="radio" name="premium" class="radio_change" data-price="<?=$pr3;?>">10 <?=Yii::t('app','lang85'); ?> / <?=$pr3; ?> <?=Yii::t('app','lang149'); ?></label>
				<?php } else echo '<label class="price1" style="line-height: 21px;padding-top: 18px;">'.Yii::t('app','lang299').' '.date("d.m.Y H:i",$elan->sort_premium).'</label>'; ?>
				<input type="hidden" id="premium_amount" value="0"> 
            </div>
            <ul class="more_services clearfix">
                <li class="col1 arr_p">
					<?php $pr=$this->context->packagePrices["announce_search10"]; ?>
					<label><input name="announce_search10" value="<?=$pr; ?>" type="checkbox" class="search_change" data-price="<?=$pr; ?>" /><span><?=Yii::t('app','lang270'); ?> - 10 <?=Yii::t('app','lang85'); ?></span></label>
					<span><?=$pr; ?> <?=Yii::t('app','lang149'); ?></span>
					<div class="tooltips">
						<?php
						if($elan->sort_search>time()){
							echo Yii::t('app','lang299').' '.date("d.m.Y H:i",$elan->sort_search).'<br /><br />';
							echo Yii::t('app','lang303').' '.date("d.m.Y H:i",time()+(10*86400)).'<br /><br />';
						}
						echo Yii::t('app','lang275');
						?>
						<a href="" style="display: none;">Ətraflı oxu</a>
					</div>
					<input type="hidden" id="search_amount" value="0"> 
				</li>
				<li class="col2 arr_p">
					<?php $pr=$this->context->packagePrices["announce_fb"]; ?>
					<label><input name="announce_fb" value="<?=$pr; ?>" type="checkbox" class="fb_change" data-price="<?=$pr; ?>" /><span style="width: 210px;"><?=Yii::t('app','lang276'); ?></span></label>
					<span><?=$pr; ?> <?=Yii::t('app','lang149'); ?></span>
					<div class="tooltips"><?=Yii::t('app','lang277'); ?> <a href="" style="display: none;">Ətraflı oxu</a></div>
					<input type="hidden" id="fb_amount" value="0"> 
				</li>
				<li class="col3 arr_p">
					<?php $pr=$this->context->packagePrices["announce_urgent"]; ?>
					<label><input name="announce_urgent" value="<?=$pr; ?>" type="checkbox" class="urgent_change" data-price="<?=$pr; ?>" /><span><?=Yii::t('app','lang271'); ?></span></label>
					<span><?=$pr; ?> <?=Yii::t('app','lang149'); ?></span>
					<div class="tooltips"><?=Yii::t('app','lang278'); ?> <a href="" style="display: none;">Ətraflı oxu</a></div>
					<input type="hidden" id="urgent_amount" value="0"> 
				</li>
                <li class="col4 arr_p">
					<?php $pr=$this->context->packagePrices["announce_foward1"]; ?>
                    <label><input name="announce_foward1" value="<?=$pr; ?>" type="checkbox" class="foward_change" data-price="<?=$pr; ?>" /><span><?=Yii::t('app','lang250'); ?></span></label>
                    <span><?=$pr; ?> <?=Yii::t('app','lang149'); ?></span>
                    <div class="tooltips"><?=Yii::t('app','lang289'); ?>. <a href="" style="display: none;">Ətraflı oxu</a></div>
					<input type="hidden" id="foward_amount" value="0"> 
                </li>
            </ul>
            <div class="grey_box_bott">
                <div>
                    <p><?=Yii::t('app','lang279'); ?></p>
                    <span><span id="mebleg">0</span> <?=Yii::t('app','lang149'); ?> <span id="paket" style="display: none;">+ 1 <?=strtolower(Yii::t('app','lang266')); ?></span></span>
                </div>
                <button type="button" class="green_button all-link" style="float:right;margin-right: 20px;margin-top: 3px;"><?=Yii::t('app','lang280'); ?></button>
            </div>
        </form>
    </div>
</div>


<div class="popup premium all" style="margin: -230px 0 0 -300px;    width: 500px;">
    <div class="popup-main">
        <a href="javascript:void(0);" class="close"></a>
        <div class="tabs">
            <div class="i-tab">
                <div><?=Yii::t('app','lang246'); ?></div>
                <div style="display: none;">Portmanat</div>
            </div>
            <div class="tab-content" style="width:350px;">
                <div class="tabs-main" style="display:block">
                    <form action="<?=$this->context->siteUrl; ?>/payment/saveitem.php" method="post" target="allWindow" id="allForm">
						<input type="hidden" name="item" id="item" value="0-allreklam-"> 
						<input type="hidden" name="lang" value="lv" >
						<input type="hidden" name="amount" id="amount" value="0" >
                        <select name="cardType" class="SlectBox w290">
                            <option value="v"><?=Yii::t('app','lang247'); ?></option>
                            <option value="m"><?=Yii::t('app','lang248'); ?></option>
                        </select>
                        <div class="submit-btn">
                            <div>
                                <button type="button" onclick="Javascript:doAll();" name="btn_pay"><?=Yii::t('app','lang86'); ?></button>
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

<script>
$(function () {
	$('.popup .close, .popup-overlay').click(function () {
        $('body').removeClass('themodal-lock');
        $('.popup, .popup-overlay').css({'opacity': '0', 'visibility': 'hidden'});
		$(".fancybox-close").trigger("click");
        return false;
    });
	
	$(".jq-radio.radio_change").click(function(){
		var mebleg=parseInt($("#mebleg").html());
		var price=parseInt($(this).children('input').attr('data-price'));
		var premium_amount=parseInt($("#premium_amount").val());
		if($(this).children('input').is(':checked')==true){
			if(premium_amount==0){
				mebleg=parseInt(mebleg)+parseInt(price);
				$("#premium_amount").val(price);
			}
			else{
				mebleg=parseInt(mebleg)-parseInt(premium_amount);
				mebleg=parseInt(mebleg)+parseInt(price);
				$("#premium_amount").val(price);
			}
		}
		else {
			mebleg=parseInt(mebleg)-parseInt(premium_amount);
			$("#premium_amount").val(0);
		}
		$("#mebleg").html(mebleg);
	});
	
	$(".jq-checkbox.search_change").click(function(){
		var mebleg=parseInt($("#mebleg").html());
		var price=parseInt($(this).children('input').attr('data-price'));
		var search_amount=parseInt($("#search_amount").val());				var foward_amount=parseInt($("#foward_amount").val());
		var baseurl=$("#baseurl").val();
		var obj=$(this);
		$.post(baseurl+"/callback/check_package_search_foward",function(data){
			if(data=='no_package'){
				if(obj.children('input').is(':checked')==true){
					if(search_amount==0){
						mebleg=parseInt(mebleg)+parseInt(price);
						$("#search_amount").val(price);
					}
					else{
						mebleg=parseInt(mebleg)-parseInt(search_amount);
						mebleg=parseInt(mebleg)+parseInt(price);
						$("#search_amount").val(price);
					}
				}
				else {
					mebleg=parseInt(mebleg)-parseInt(search_amount);
					$("#search_amount").val(0);
				}
				$("#mebleg").html(mebleg);
				$("#paket").css('display','none');
			}
			else{
				if(obj.children('input').is(':checked')==true){
					if(search_amount==0){
						mebleg=parseInt(mebleg)+parseInt(price);
						$("#search_amount").val(price);
					}
					else{
						mebleg=parseInt(mebleg)-parseInt(search_amount);
						mebleg=parseInt(mebleg)+parseInt(price);
						$("#search_amount").val(price);
					}
					if(foward_amount>0) { var paketText=$("#paket").html(); paketText=paketText.replace('1','2');	$("#paket").html(paketText); }
					$("#paket").css('display','inline');
				}
				else {
					mebleg=parseInt(mebleg)-parseInt(search_amount);
					$("#search_amount").val(0);
					if(foward_amount>0) { var paketText=$("#paket").html(); paketText=paketText.replace('2','1');	$("#paket").html(paketText); }
					else $("#paket").css('display','none');
				}
			}
		});
	});
	
	$(".jq-checkbox.fb_change").click(function(){
		var mebleg=parseInt($("#mebleg").html());
		var price=parseInt($(this).children('input').attr('data-price'));
		var fb_amount=parseInt($("#fb_amount").val());
		if($(this).children('input').is(':checked')==true){
			if(fb_amount==0){
				mebleg=parseInt(mebleg)+parseInt(price);
				$("#fb_amount").val(price);
			}
			else{
				mebleg=parseInt(mebleg)-parseInt(fb_amount);
				mebleg=parseInt(mebleg)+parseInt(price);
				$("#fb_amount").val(price);
			}
		}
		else {
			mebleg=parseInt(mebleg)-parseInt(fb_amount);
			$("#fb_amount").val(0);
		}
		$("#mebleg").html(mebleg);
	});
	
	$(".jq-checkbox.urgent_change").click(function(){
		var mebleg=parseInt($("#mebleg").html());
		var price=parseInt($(this).children('input').attr('data-price'));
		var urgent_amount=parseInt($("#urgent_amount").val());
		if($(this).children('input').is(':checked')==true){
			if(urgent_amount==0){
				mebleg=parseInt(mebleg)+parseInt(price);
				$("#urgent_amount").val(price);
			}
			else{
				mebleg=parseInt(mebleg)-parseInt(urgent_amount);
				mebleg=parseInt(mebleg)+parseInt(price);
				$("#urgent_amount").val(price);
			}
		}
		else {
			mebleg=parseInt(mebleg)-parseInt(urgent_amount);
			$("#urgent_amount").val(0);
		}
		$("#mebleg").html(mebleg);
	});
	
	$(".jq-checkbox.foward_change").click(function(){
		var mebleg=parseInt($("#mebleg").html());
		var price=parseInt($(this).children('input').attr('data-price'));
		var foward_amount=parseInt($("#foward_amount").val());				var search_amount=parseInt($("#search_amount").val());
		var baseurl=$("#baseurl").val();
		var obj=$(this);
		$.post(baseurl+"/callback/check_package_foward",function(data){
			if(data=='no_package'){
				if(obj.children('input').is(':checked')==true){
					mebleg=parseInt(mebleg)+parseInt(price);
					$("#foward_amount").val(price);
				}
				else {
					mebleg=parseInt(mebleg)-parseInt(foward_amount);
					$("#foward_amount").val(0);
				}
				$("#mebleg").html(mebleg);
				if(search_amount==0) $("#paket").css('display','none');
			}
			else{
				if(obj.children('input').is(':checked')==true){
					mebleg=parseInt(mebleg)+parseInt(price);
					$("#foward_amount").val(price);
				
					if(search_amount>0) { var paketText=$("#paket").html(); paketText=paketText.replace('1','2');	$("#paket").html(paketText); }
					$("#paket").css('display','inline');
				}
				else {
					mebleg=parseInt(mebleg)-parseInt(foward_amount);
					$("#foward_amount").val(0);
					if(search_amount>0) { var paketText=$("#paket").html(); paketText=paketText.replace('2','1');	$("#paket").html(paketText); }
					else $("#paket").css('display','none');
				}
			}
		});
	});
	
	// premium
	$('.all-link').click(function (e) {
		var mebleg=parseInt($("#mebleg").html());
		var a=$("#paket").attr('style');	// paketin secilib ya secilmemesini yoxlayir...
		if(mebleg>0){
			var current_ann=$("#current_ann").val();
			var premium_amount=parseInt($("#premium_amount").val());
			var search_amount=parseInt($("#search_amount").val());
			var fb_amount=parseInt($("#fb_amount").val());
			var urgent_amount=parseInt($("#urgent_amount").val());
			var foward_amount=parseInt($("#foward_amount").val());
			var item=current_ann+'-allreklam';
			item=item+'-'+premium_amount+'prm-'+search_amount+'axt-'+fb_amount+'fb-'+urgent_amount+'tec-'+foward_amount+'irl';
			$("#item").val(item);
			
			$("#amount").val(mebleg);
			$('.popup.improve, .popup-overlay').css({'opacity': '0', 'visibility': 'hidden'});
			$('.popup.all, .popup-overlay').css({'opacity': '1', 'visibility': 'visible'});
			e.preventDefault();
		}
		else if(a!='display: none;'){
			$("#order_form_active").submit();
		}
    });
});
</script>