<?php
use frontend\components\MyFunctionsF;
use yii\helpers\Url;
?>
<header class="header">
    <div class="logo">
        <a href="<?=Yii::$app->request->baseUrl; ?>/">
            <img src="<?=MyFunctionsF::getImageUrl(); ?>/bar/logo.png" alt="" >
            <span><?=Yii::t('app','lang19'); ?></span>
        </a>
    </div>
    <div class="right">
        <div class="banners">
            <?php
            echo $this->context->banners[0]["text_".Yii::$app->language];
            echo $this->context->banners[2]["text_".Yii::$app->language];
            echo $this->context->banners[1]["text_".Yii::$app->language];
            ?>
        </div>
        <div class="navbar">
            <div class="lang">
			<?php
			if(Yii::$app->language=='az') $title='Azərbaycanca';
			elseif(Yii::$app->language=='en') $title='English';
			elseif(Yii::$app->language=='ru') $title='Русский';
			elseif(Yii::$app->language=='tr') $title='Türkce';
			?>
                <a title="<?=$title;?>" href="<?=Yii::$app->request->baseUrl.'/site/lang?lang='.Yii::$app->language; ?>" class="active <?=Yii::$app->language; ?>"><img src="<?=MyFunctionsF::getImageUrl(); ?>/ico/lang_<?=Yii::$app->language; ?>.gif" alt="" ></a>
                <?php
                if(Yii::$app->language!='az') echo '<a href="'.Yii::$app->request->baseUrl.'/site/lang?lang=az" class="az hide" title="Azərbaycanca"><img src="'.MyFunctionsF::getImageUrl().'/ico/lang_az.gif" alt="" ></a>';
                if(Yii::$app->language!='en') echo '<a href="'.Yii::$app->request->baseUrl.'/site/lang?lang=en" class="en hide" title="English"><img src="'.MyFunctionsF::getImageUrl().'/ico/lang_en.gif" alt="" ></a>';
                if(Yii::$app->language!='ru') echo '<a href="'.Yii::$app->request->baseUrl.'/site/lang?lang=ru" class="ru hide" title="Русский"><img src="'.MyFunctionsF::getImageUrl().'/ico/lang_ru.gif" alt="" ></a>';
                if(Yii::$app->language!='tr') echo '<a href="'.Yii::$app->request->baseUrl.'/site/lang?lang=tr" class="tr hide" title="Türkce"><img src="'.MyFunctionsF::getImageUrl().'/ico/lang_tr.gif" alt="" ></a>';
                ?>
            </div>
            <nav class="navi">
                <ul>
                    <li><a href="<?=Yii::$app->request->baseUrl.'/haqqimizda'; ?>"><?=Yii::t('app','lang1'); ?></a></li>
                    <li><a href="<?=Yii::$app->request->baseUrl.'/sifarisler'; ?>"><?=Yii::t('app','lang2'); ?></a></li>
                    <li><a href="<?=Yii::$app->request->baseUrl.'/xeberler'; ?>"><?=Yii::t('app','lang3'); ?></a></li>
                    <li><a href="<?=Yii::$app->request->baseUrl.'/emlakcilar'; ?>"><?=Yii::t('app','lang4'); ?></a></li>
                    <li><a href="<?=Yii::$app->request->baseUrl.'/xidmetler'; ?>"><?=Yii::t('app','lang5'); ?></a></li>
                    <li><a href="<?=Yii::$app->request->baseUrl.'/elaqe'; ?>"><?=Yii::t('app','lang6'); ?></a></li>
                </ul>
            </nav>
            <div class="search">
                <form action="<?=Url::to(['elanlar/']); ?>" method="get">
                    <input name="q" type="text" placeholder="<?=Yii::t('app','lang7'); ?>">
                    <input type="submit" value="" >
                </form>
            </div>
        </div>
    </div>
    <div class="head-panel">
        <div class="info">
            <p>
                <?=Yii::t('app','lang8'); ?>: <strong><?=$this->context->infoContact[0]["phone"]; ?></strong>
                <?=Yii::t('app','lang10'); ?>: <strong><?=$this->context->infoContact[0]["reklam_phone"]; ?></strong>
            </p>
            <i><?=Yii::t('app','lang20').': '.Yii::t('app','lang21').', '.Yii::t('app','lang22'); ?></i>
        </div>
        <?php
        if(!$this->context->userInfo)
        {
            echo '<a href="javascript:void(0);" class="sms-links" style="opacity:0;">'.Yii::t('app','lang13').'</a>
        <a href="javascript:void(0);" class="entry-links">'.Yii::t('app','lang14').'</a>
        <a href="javascript:void(0);" class="reg-links">'.Yii::t('app','lang15').'</a>';
        }
        ?>
        <a href="<?php echo Yii::$app->request->baseUrl.'/elan-ver'; ?>" class="add-advert"><img src="<?=MyFunctionsF::getImageUrl(); ?>/ico/sas.png" alt="" > <?=Yii::t('app','lang16'); ?></a>
        <?php
        if($this->context->userInfo)
        {
            $toplam_elanlar=$this->context->userAnnounces0+$this->context->userAnnounces1+$this->context->userAnnounces2+$this->context->userAnnounces3+$this->context->userAnnounces4;
        echo '<a href="'.Url::toRoute(['qeydiyyat/logout']).'" class="logout-link">'.Yii::t('app','lang118').'</a>
        <div class="dropbox">
            <div class="user"> <a href="javascript:void(0);">'.$this->context->userInfo->name.' ('.$toplam_elanlar.')  <i></i></a></div>
            <div class="drop-list">
                <a href="'.Url::toRoute(['profil/elanlar?status=1']).'">'.Yii::t('app','lang119').' ('.$this->context->userAnnounces1.')</a>
                <a href="'.Url::toRoute(['profil/elanlar?status=0']).'">'.Yii::t('app','lang120').' ('.$this->context->userAnnounces0.')</a>
                <a href="'.Url::toRoute(['profil/elanlar?status=2']).'">'.Yii::t('app','lang136').' ('.$this->context->userAnnounces2.')</a>
                <a href="'.Url::toRoute(['profil/elanlar?status=3']).'">'.Yii::t('app','lang137').' ('.$this->context->userAnnounces3.')</a>
                <a href="'.Url::toRoute(['profil/elanlar?status=4']).'">'.Yii::t('app','lang138').' ('.$this->context->userAnnounces4.')</a>
                <a href="'.Url::toRoute(['profil/']).'">'.Yii::t('app','lang83').'</a>
            </div>
        </div>';
        }
        ?>
    </div>
</header>