<?php
use frontend\components\MyFunctionsF;
use yii\helpers\Url;

$this->title=Yii::t('app','pg_title4');
?>
<div class="content clearfix brokers">
    <h2 class="main-title"><span><?=Yii::t('app','lang4'); ?></span></h2>
    <div class="panel">
        <a class="area-links area-links-emlakcilar" href="/"><?=Yii::t('app','lang135'); ?></a>
        <ul class="area-list" style="min-height: 24px;">
        </ul>
    </div>
	<ul class="brokers-list clearfix" style="display:none;" id="wait_change">
		<li style="background:none;" >
			<img src="<?=MyFunctionsF::getImageUrl().'/bx_loader.gif';?>" />
		</li>
	</ul>
    <ul class="brokers-list clearfix emlakcilar_ul">
        <?php
        foreach($emlakcilar as $row){
            if(!is_file(MyFunctionsF::getImagePath().'/'.$row["thumb"])) $src='unknow_man.jpg'; else $src=$row["thumb"];
            if($row["login"]=='') $url=Url::toRoute(['emlakcilar/'.$row["id"]]);
            else $url=Url::toRoute(['/'.$row["login"]]);
			if($row["name"]=='') $name='&nbsp;'; else $name=$row["name"];
            echo '<li class="rows">
				<a href="'.$url.'">
					<div class="title">'.$name.'</div>
					<div class="img"><img src="'.MyFunctionsF::getImageUrl().'/'.$src.'" alt=""></div>
					<p class="upd">'.Yii::t('app','lang57').' <span class="count">('.$row["announce_count"].')</span></p>
				</a>
			</li>';
        }
        ?>
    </ul>
    <div class="pagination hide">
        <ul>
            <?php
            //Paginator ///////////////////////////////////////////
            if($page>1) echo '<li><a href="'.$link.'?page='.($page-1).'"> &larr; '.Yii::t('app','lang29').'</a></li>';
            for($i=$page-$show;$i<=$page+$show;$i++)
            {
                if($i>0 && $i<=$max_page)
                {
                    if($i==$page) echo '<li class="active"><a href="javascript:void(0);">'.$i.'</a></li>';
                    else echo '<li><a href="'.$link.'?page='.$i.'">'.$i.'</a></li>';
                }
            }
            if($page<$max_page) echo '<li><a href="'.$link.'?page='.($page+1).'">'.Yii::t('app','lang30').' &rarr; </a></li>';
            //Paginator ///////////////////////////////////////////
            ?>
        </ul>
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
                                $checked='';
                            echo '<p><label><input '.$checked.' type="checkbox" class="rayon_check_click emlakcilar_erazi" id="rayon_checkbox'.$id.'" value="'.$id.'" data-id="'.$id.'" name="selected_regions[]" /><span>'.$title.'</span></label></p>';
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
                                $checked='';
                            echo '<p><label><input '.$checked.' type="checkbox" class="metro_check_click emlakcilar_erazi" id="metro_checkbox'.$id.'" value="'.$id.'" name="selected_metros[]" /><span>'.$title.'</span></label></p>';
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
                                $checked='';
                            echo '<p><label><input '.$checked.' type="checkbox" class="qesebe_check_click emlakcilar_erazi" id="qesebe_checkbox'.$id.'" value="'.$id.'" name="selected_settlements[]" /><span>'.$title.'</span></label></p>';
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="pull-left">
            <div class="title"><?=Yii::t('app','lang168'); ?></div>
            <div class="wrapper-c scrollbar-dynamic">
                <div class="page-content">
                    <div class="col">
                        <?php
                        foreach($this->context->marks as $id=>$title)
                        {
                            if($id>0){
                                $checked='';
                            echo '<p><label><input '.$checked.' class="nisangah_check_click emlakcilar_erazi" id="nisangah_checkbox'.$id.'" type="checkbox" value="'.$id.'" name="selected_marks[]" /><span>'.$title.'</span></label></p>';
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

<script>
$(function () {
//            popup nisangah2
    $('.area-links-emlakcilar').click(function (e) {
        $('body').addClass('themodal-lock');
        $('.popup.nisangah-2, .popup-overlay').css({'opacity': '1', 'visibility': 'visible'});
        e.preventDefault();
    });
	
	$(".emlakcilar_erazi").click(function (e) {
        e.preventDefault();
		$(".rows").remove(); $("#wait_change").show();
        var baseurl=$("#baseurl").val();
        var val='-';  $( ".nisangah_check_click:checked" ).each(function( ) { val+=$(this).val()+'-'; });	// marks
        var val2='-';  $( ".qesebe_check_click:checked" ).each(function( ) { val2+=$(this).val()+'-'; }); // settlement
        var val3='-';  $( ".metro_check_click:checked" ).each(function( ) { val3+=$(this).val()+'-'; }); // metro
        var val4='-';  $( ".rayon_check_click:checked" ).each(function( ) { val4+=$(this).val()+'-'; }); // region

        $.post(baseurl+"/emlakcilar/marks_select",{val:val,val2:val2,val3:val3,val4:val4},function(data){
            console.debug(data);
			data=data.split('*****');
			$(".area-list").html(data[0]);
			$(".emlakcilar_ul").html(data[1]);
			$("#wait_change").hide();
        });
    });
    $("#rest_marks").click(function (e) {
        e.preventDefault();
        var baseurl=$("#baseurl").val();
        var val='-';  var val2='-';  var val3='-';  var val4='-';
        $.post(baseurl+"/emlakcilar/marks_select",{val:val,val2:val2,val3:val3,val4:val4},function(data){
			data=data.split('*****');
			$(".area-list").html(data[0]);
        });
    });
	
	// delete area list
    $(document).delegate('.area-list li .remove', 'click',function(e){
        e.preventDefault();
        $("#nisangah_checkbox"+$(this).data('id')+"-styler").trigger('click');
        $(this).parent().remove();
    });
	$(document).delegate('.area-list li .remove2', 'click',function(e){
        e.preventDefault();
        $("#qesebe_checkbox"+$(this).data('id')+"-styler").trigger('click');
        $(this).parent().remove();
    });
	$(document).delegate('.area-list li .remove3', 'click',function(e){
        e.preventDefault();
        $("#metro_checkbox"+$(this).data('id')+"-styler").trigger('click');
        $(this).parent().remove();
    });
	$(document).delegate('.area-list li .remove4', 'click',function(e){
        e.preventDefault();
        $("#rayon_checkbox"+$(this).data('id')+"-styler").trigger('click');
        $(this).parent().remove();
    });
	
});
</script>