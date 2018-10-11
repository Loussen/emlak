<?php
use yii\helpers\Url;
use frontend\components\MyFunctionsF;
use backend\models\EstateOrders;

$this->title=Yii::t('app','pg_title2');
?>
<div class="content clearfix customer_order">
    <h2 class="main-title"><span><?=Yii::t('app','lang2'); ?></span></h2>
    <div class="tabs">
    <div class="order_tab_div">
        <a href="<?=Url::toRoute(['sifarisler/']) ?>"><div <?php if($tab==0) echo 'class="active"'; ?>><?=Yii::t('app','lang33'); ?> (<?=($tip1_count+$tip2_count); ?>)</div></a>
        <a href="<?=Url::toRoute(['sifarisler?tab=1/']) ?>"><div <?php if($tab==1) echo 'class="active"'; ?>><?=Yii::t('app','lang34'); ?> (<?=$tip1_count; ?>)</div></a>
        <a href="<?=Url::toRoute(['sifarisler?tab=2/']) ?>"><div <?php if($tab==2) echo 'class="active"'; ?>><?=Yii::t('app','lang35'); ?> (<?=$tip2_count; ?>)</div></a>
        <button type="button"><?=Yii::t('app','lang36'); ?></button>
    </div>
    <div class="tab-content" >
    <div class="tabs-main" style="display:block;">
        <ol class="upd-list">
            <?php
            foreach($orders as $row)
            {
                echo '<li>
                <div class="pull-left">
                    <div class="title"><h3>'.$row["title"].'</h3><span>'.EstateOrders::getType($row["type"]).'</span></div>
                    <p>'.$row["text"].'</p>
                </div>
                <div class="contacts">
                    <div class="img"><img src="'.MyFunctionsF::getImageUrl().'/bar/user-img.png" alt="" ></div>
                    <div class="inline">
                        '.$row["name"].'
                        <strong>'.$row["phone"].'</strong>
                    </div>
                </div>
            </li>';
            }
            ?>
        </ol>
    </div>

        <div class="pagination">
            <ul>
                <?php
                //Paginator ///////////////////////////////////////////
                if($page>1) echo '<li><a href="'.$link.'&page='.($page-1).'"> &larr; '.Yii::t('app','lang29').'</a></li>';
                for($i=$page-$show;$i<=$page+$show;$i++)
                {
                    if($i>0 && $i<=$max_page)
                    {
                        if($i==$page) echo '<li class="active"><a href="javascript:void(0);">'.$i.'</a></li>';
                        else echo '<li><a href="'.$link.'&page='.$i.'">'.$i.'</a></li>';
                    }
                }
                if($page<$max_page) echo '<li><a href="'.$link.'&page='.($page+1).'">'.Yii::t('app','lang30').' &rarr; </a></li>';
                //Paginator ///////////////////////////////////////////
                ?>
            </ul>
        </div>
    </div>
    </div>
</div>


<div class="popup upd-popup">
    <?php
    echo '<img id="loading_gif" class="hide" src="'.MyFunctionsF::getImageUrl().'/loading.gif" />';
    echo '<div class="alert-danger alert hide" style="font-weight: bold;"></div>';
    echo '<div class="alert-success alert hide" style="font-weight: bold;"></div>';
    $info=$this->context->getPagesInfo(6);
    ?>
    <div class="popup-main ">
        <a href="javascript:void(0);" class="close"></a>
        <div class="title" style="margin: 14px 14px 0px 14px;text-align: center;"><?=Yii::t('app','lang38'); ?></div>
        <form action="" method="post" id="sifaris_form">
            <input type="hidden" name="order_hidden" value="order_add" />
            <div class="pull-left form_of_order_add">
                <label><span></span>
                    <p class="radio-box">
                        <label><input <?php if(Yii::$app->session["f1_type"]==1) echo 'checked="checked"'; ?> type='radio' name='type' value="1" ><?=Yii::t('app','lang39'); ?></label>
                        <label class="align-right"><input <?php if(Yii::$app->session["f1_type"]==2) echo 'checked="checked"'; ?> type='radio' name='type' value="2" ><?=Yii::t('app','lang40'); ?></label>
                    </p>
                </label>
                <label><span><sup>*</sup> <?=Yii::t('app','lang41'); ?> </span><input type='text' name="name" value="<?=Yii::$app->session["f1_name"]; ?>" ></label>
                <label><span><sup>*</sup> <?=Yii::t('app','lang42'); ?> </span><input type='text' name="phone" value="<?=Yii::$app->session["f1_phone"]; ?>" ></label>
                <label><span><sup>*</sup> <?=Yii::t('app','lang43'); ?> </span><input type='text' name="title" value="<?=Yii::$app->session["f1_title"]; ?>" ></label>
                <label><span><sup>*</sup> <?=Yii::t('app','lang44'); ?> </span><textarea name="text"><?=Yii::$app->session["f1_text"]; ?></textarea></label>
                <label><span> </span><p class="en-info"><?=Yii::t('app','lang45'); ?> <a href="javascript:void(0);" class="istifade_sertleri"><?=Yii::t('app','lang46'); ?></a> <?=Yii::t('app','lang47'); ?></p></label>
                <label class="submit-label"><input id="sifaris_submit" name="order_add_submit" type="submit" value="<?=Yii::t('app','lang48'); ?>" ></label>
            </div>
            <div class="rules_of_order_add" style="padding:15px;font-size:14px;margin:0px;display:none;height: 370px;overflow-y: auto;">
                <label class="submit-label entry-links"><input style="margin-left: 0px;margin-bottom:10px;padding: 3px 10px 3px 10px;" name="order_add_submit" type="button" value="&laquo; <?=Yii::t('app','lang37'); ?>"></label>
                <div class="clear"></div>
                <?=$info["text_".Yii::$app->language]; ?>
            </div>
        </form>
    </div>
</div>

<script>
    $(function () {
        $(".istifade_sertleri").click(function()
        {
            $('.rules_of_order_add').show();
            $(".form_of_order_add").hide();
        });
        $(".rules_of_order_add .entry-links").click(function()
        {
            $('.rules_of_order_add').hide();
            $(".form_of_order_add").show();
        });

        $('#sifaris_form').on('submit', function (e) {
            e.preventDefault();

            var baseurl=$("#baseurl").val();
            $("#loading_gif").removeClass('hide');
            $.ajax({
                url: baseurl+"/sifarisler/order_insert",
                type: "POST",
                data: new FormData(this),
                processData: false,
                cache: false,
                contentType: false,
                success: function (res) {
                    res=res.split('---');
                    $("#loading_gif").addClass('hide');
                    if(res[0]=='success')
                    {
                        $('#sifaris_form').trigger("reset");

                        $(".alert-danger").addClass('hide');
                        $(".alert-success").removeClass('hide');
                        $(".alert-success").html(res[1]);
                    }
                    else
                    {
                        $(".alert-danger").removeClass('hide');
                        $(".alert-success").addClass('hide');
                        $(".alert-danger").html(res[1]);
                    }
                }
            });
        });

    });
</script>