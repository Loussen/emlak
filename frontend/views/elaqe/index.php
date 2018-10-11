<?php
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

$this->title=Yii::t('app','pg_title6');
?>
<div class="content clearfix contacts">
    <h2 class="main-title classic-margin"><span><?=Yii::t('app','lang18'); ?></span></h2>
    <div class="main clearfix">
        <div class="pull-left">
            <p class="phone"><i></i><span><?=$this->context->infoContact[0]['phone']; ?></span></p>
            <p class="mobile"><i></i><span><?=$this->context->infoContact[0]['mobile']; ?></span></p>
            <p class="small-desc">
                <?=Yii::t('app','lang20').': '.Yii::t('app','lang21'); ?><br>
                <?=Yii::t('app','lang22'); ?>
            </p>
            <p class="email">
                <a href="mailto:<?=$this->context->infoContact[0]["email"]; ?>"><i></i><?=$this->context->infoContact[0]["email"]; ?></a>
            </p>
            <p class="address">
                <i></i>
                <?=nl2br($this->context->infoContact[0]["address_".Yii::$app->language]); ?>
            </p>
        </div>
        <div class="pull-right">
            <style>
                .form-group {float:right;}
            </style>
            <?php
            if(Yii::$app->session->hasFlash('error')) echo '<div class="alert-danger alert">'.Yii::$app->session->getFlash('error').'</div>';
            if(Yii::$app->session->hasFlash('success')) echo '<div class="alert-success alert">'.Yii::$app->session->getFlash('success').'</div>';
            ?>
            <div class="title"><?=Yii::t('app','lang9'); ?></div>

            <?php $form=ActiveForm::begin(); ?>
                <label>
                    <span><sup>*</sup><?=Yii::t('app','lang11'); ?></span>
                    <?= $form->field($model, 'name')->textInput(['style'=>'width:320px;'])->label(false); ?>
                </label>
            <div class="clear margin-bottom-5"></div>
                <label>
                    <span><sup>*</sup><?=Yii::t('app','lang12'); ?></span>
                    <?= $form->field($model, 'email')->textInput(['style'=>'width:320px;'])->label(false); ?>
                </label>
            <div class="clear margin-bottom-5"></div>
                <label>
                    <span class="align-top"><sup>*</sup><?=Yii::t('app','lang23'); ?></span>
                    <?= $form->field($model, 'body')->textarea()->label(false); ?>
                </label>
            <div class="clear margin-bottom-5"></div>
                <label>
                    <span class="align-top" style="float:left;"><sup>*</sup><?=Yii::t('app','lang25'); ?></span>
                    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div style="float:left;width:120px;margin-right:15px;">{image}</div><div class="verify_code">{input}</div>',
                    ])->label(false); ?>
                </label>
            <div class="clear margin-bottom-5"></div>
                <label class="submit-label">
                    <input style="margin-top:10px;" type="submit" value="<?=Yii::t('app','lang24'); ?>">
                </label>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="boxed">
        <div class="map">
            <div class="maps-address">
                <h3>
                    <span><?=Yii::t('app','lang28'); ?></span>
                    <?=$this->context->infoContact[0]["address_".Yii::$app->language]; ?>
                </h3>
            </div>
            <div id="map-canvas" style="width:970px;height:290px;"> </div>
        </div>
    </div>
</div>


<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script>
    function initialize() {
        var myLatlng = new google.maps.LatLng(<?php echo $this->context->infoContact[0]["google_map"]; ?>);
        var mapOptions = {
            zoom:16,
            center: myLatlng
        }
        var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            title: 'Hello World!'
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>