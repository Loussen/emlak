<div class="content clearfix ok_page">
    <h2 class="main-title green_title"><span><?=Yii::t('app','lang16'); ?></span></h2>
	<?php if(Yii::$app->session->hasFlash('success')) echo '<div class="alert-success alert" style="margin-top:15px;margin-bottom:-10px;">'.Yii::$app->session->getFlash('success').'</div>'; ?>
	<?php if(Yii::$app->session->hasFlash('danger')) echo '<div class="alert-danger alert" style="margin-top:15px;margin-bottom:-10px;">'.Yii::$app->session->getFlash('danger').'</div>'; ?>
	
    <p class="order_text"><?=Yii::t('app','lang186'); ?></p>
    <p class="order_number"><?=Yii::t('app','lang187'); ?>: <span>#<?=$id; ?></span></p>
    <div class="red_title"><?=Yii::t('app','lang188'); ?><br><?=Yii::t('app','lang189'); ?></div>
    <form class="order_form" action="">
        <div class="order_type arr_p">
            <div>
                <?=Yii::t('app','lang249'); ?>
                <div class="tooltips"><?=Yii::t('app','lang274'); ?> <a href="" style="display:none;">Ətraflı oxu</a></div>
            </div>
			<?php
			$pr1=$this->context->packagePrices["announce_premium30"];
			$pr2=$this->context->packagePrices["announce_premium15"];
			$pr3=$this->context->packagePrices["announce_premium10"];
			?>
            <label class="price1"><input type="radio" onchange="" name="premium" class="radio_change" data-price="<?=$pr1;?>">30 <?=Yii::t('app','lang85'); ?> / <?=$pr1; ?> <?=Yii::t('app','lang149'); ?></label>
            <label class="price2"><input type="radio" name="premium" class="radio_change" data-price="<?=$pr2;?>">15 <?=Yii::t('app','lang85'); ?> / <?=$pr2; ?> <?=Yii::t('app','lang149'); ?></label>
            <label class="price3"><input type="radio" name="premium" class="radio_change" data-price="<?=$pr3;?>">10 <?=Yii::t('app','lang85'); ?> / <?=$pr3; ?> <?=Yii::t('app','lang149'); ?></label>
			<input type="hidden" id="premium_amount" value="0"> 
        </div>
        <ul class="more_services clearfix">
            <li class="col1 arr_p">
				<?php $pr=$this->context->packagePrices["announce_search10"]; ?>
                <label><input type="checkbox" class="search_change" data-price="<?=$pr; ?>" /><span><?=Yii::t('app','lang270'); ?> - 10 <?=Yii::t('app','lang85'); ?></span></label>
                <span> <?=$pr; ?> <?=Yii::t('app','lang149'); ?></span>
                <div class="tooltips"><?=Yii::t('app','lang275'); ?> <a href="" style="display:none;">Ətraflı oxu</a></div>
				<input type="hidden" id="search_amount" value="0"> 
            </li>
            <li class="col2 arr_p">
				<?php $pr=$this->context->packagePrices["announce_fb"]; ?>
                <label><input type="checkbox" class="fb_change" data-price="<?=$pr; ?>" /><span style="width: 210px;"><?=Yii::t('app','lang276'); ?></span></label>
                <span> <?=$pr; ?> <?=Yii::t('app','lang149'); ?></span>
                <div class="tooltips"><?=Yii::t('app','lang277'); ?> <a href="" style="display:none;">Ətraflı oxu</a></div>
				<input type="hidden" id="fb_amount" value="0"> 
            </li>
            <li class="col3 arr_p">
				<?php $pr=$this->context->packagePrices["announce_urgent"]; ?>
                <label><input type="checkbox" class="urgent_change" data-price="<?=$pr; ?>" /><span><?=Yii::t('app','lang271'); ?></span></label>
                <span> <?=$pr; ?> <?=Yii::t('app','lang149'); ?></span>
                <div class="tooltips"><?=Yii::t('app','lang278'); ?> <a href="" style="display:none;">Ətraflı oxu</a></div>
				<input type="hidden" id="urgent_amount" value="0"> 
            </li>
            <li class="col4 arr_p" style="background:#efefef;    overflow: hidden;">
                <div class="grey_box_bott" style="box-sizing: initial;border-radius:7px;">
					<div style="width:250px;">
						<p style="margin-bottom: -17px;margin-top: 4px;"><?=Yii::t('app','lang279'); ?></p>
						<span><span id="mebleg">0</span> <?=Yii::t('app','lang149'); ?> <span id="paket" style="display:none;">+ 1 <?=strtolower(Yii::t('app','lang266')); ?></span></span>
					</div>
					<button type="button" class="green_button all-link" style="float:right;margin-right: 20px;margin-top: 3px;"><?=Yii::t('app','lang280'); ?></button>
				</div>
            </li>
        </ul>
        
    </form>
</div>


<div class="popup premium all" style="margin: -230px 0 0 -300px;    width: 500px;">
    <div class="popup-main">
        <a href="/" class="close"></a>
        <div class="tabs">
            <div class="i-tab">
                <div><?=Yii::t('app','lang246'); ?></div>
                <div style="display:none;">Portmanat</div>
            </div>
            <div class="tab-content" style="width:350px;">
                <div class="tabs-main">
                    <form action="<?=$this->context->siteUrl; ?>/payment/saveitem.php" method="post" target="allWindow" id="allForm">
						<input type="hidden" name="item" id="item" value="<?=$id; ?>-all-"> 
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
		var search_amount=parseInt($("#search_amount").val());
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
					$("#paket").css('display','inline');
				}
				else {
					mebleg=parseInt(mebleg)-parseInt(search_amount);
					$("#search_amount").val(0);
					$("#paket").css('display','none');
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
	
	// premium
	$('.all-link').click(function (e) {
		var mebleg=parseInt($("#mebleg").html());
		if(mebleg>0){
			var premium_amount=parseInt($("#premium_amount").val());
			var search_amount=parseInt($("#search_amount").val());
			var fb_amount=parseInt($("#fb_amount").val());
			var urgent_amount=parseInt($("#urgent_amount").val());
			var item='<?=$id;?>-all';
			item=item+'-'+premium_amount+'prm-'+search_amount+'axt-'+fb_amount+'fb-'+urgent_amount+'tec';
			$("#item").val(item);
			
			$("#amount").val(mebleg);
			$('.popup.all, .popup-overlay').css({'opacity': '1', 'visibility': 'visible'});
			e.preventDefault();
		}
    });
});

var popup;
function doAll() {
	popup = window.open('', 'allWindow', "toolbar=no,scrollbars=no,location=no,statusbar=no,menubar=no,resizable=0,top=70,left=370,width=630,height=600");
	document.getElementById('allForm').submit();
	popup.focus();
}

function refreshParent(){
	return location.href= "http://emlak.az/elan-ver/ok/<?=$id;?>";
}
</script>