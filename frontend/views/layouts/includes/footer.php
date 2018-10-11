<?php
use yii\helpers\Url;
use frontend\components\MyFunctionsF;
?>
<footer class="footer">
    <div class="footer-box clearfix">
        <div class="pull-left">
            <div class="nav">
                <div class="title"><?=Yii::t('app','lang55'); ?></div>
                <ul>
                    <li><a href="<?=Url::toRoute(["/"]); ?>"><?=Yii::t('app','lang56'); ?></a></li>
                    <li><a href="<?=Url::toRoute(["sifarisler/"]); ?>"><?=Yii::t('app','lang2'); ?></a></li>
                    <li><a href="<?=Url::toRoute(["xeberler/"]); ?>"><?=Yii::t('app','lang3'); ?></a></li>
                    <li><a href="<?=Url::toRoute(["emlakcilar/"]); ?>"><?=Yii::t('app','lang4'); ?></a></li>
                    <li><a href="<?=Url::toRoute(["xidmetler/"]); ?>"><?=Yii::t('app','lang5'); ?></a></li>
                </ul>
            </div>
            <div class="nav">
                <div class="title"><?=Yii::t('app','lang57'); ?></div>
                <ul>
                    <li><a href="<?=Url::toRoute(["/"]); ?>"><?=Yii::t('app','lang57'); ?></a></li>
                    <li><a href="<?=Url::toRoute(["elan-ver/"]); ?>"><?=Yii::t('app','lang58'); ?></a></li>
                    <li><a href="<?=Url::toRoute(["/?satis"]); ?>"><?=Yii::t('app','lang59'); ?></a></li>
                    <li><a href="<?=Url::toRoute(["/?icare"]); ?>"><?=Yii::t('app','lang60'); ?></a></li>
                </ul>
            </div>
            <div class="nav">
                <div class="title"><?=Yii::t('app','lang18'); ?></div>
                <ul>
                    <li><a href="<?=Url::toRoute(["elaqe/"]); ?>"><?=Yii::t('app','lang8'); ?></a></li>
                    <li><a href="<?=Url::toRoute(["reklam/"]); ?>"><?=Yii::t('app','lang61'); ?></a></li>
                    <li><a href="<?=Url::toRoute(["haqqimizda/"]); ?>"><?=Yii::t('app','lang62'); ?></a></li>
                    <li><a href="<?=Url::toRoute(["partnyorlar/"]); ?>"><?=Yii::t('app','lang63'); ?></a></li>
                    <li><a href="<?=Url::toRoute(["links/index?tip=2"]); ?>"><?=Yii::t('app','lang297'); ?></a></li>
                    <li><a href="<?=Url::toRoute(["links/index?tip=1"]); ?>"><?=Yii::t('app','lang298'); ?></a></li>
                </ul>
            </div>
        </div>
        <div class="counter">
            <!--LiveInternet counter--><script type="text/javascript"><!--
			document.write("<a href='//www.liveinternet.ru/click' "+
			"target=_blank><img src='//counter.yadro.ru/hit?t29.6;r"+
			escape(document.referrer)+((typeof(screen)=="undefined")?"":
			";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
			screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
			";"+Math.random()+
			"' alt='' title='LiveInternet: number of visitors and pageviews"+
			" is shown' "+
			"border='0' width='88' height='120'><\/a>")
			//--></script><!--/LiveInternet-->

			<!-- Yandex.Metrika counter --><script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter31365888 = new Ya.Metrika({ id:31365888, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true, trackHash:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="https://mc.yandex.ru/watch/31365888" style="position:absolute; left:-9999px;" alt="" /></div></noscript><!-- /Yandex.Metrika counter -->
        </div>
        <div class="pull-right">
            <div class="tabs">
                <div class="i-tab">
                    <div><?=Yii::t('app','lang55'); ?></div>
                    <div><?=Yii::t('app','lang64'); ?></div>
                    <div><?=Yii::t('app','lang65'); ?></div>
                    <div><?=Yii::t('app','lang66'); ?></div>
                </div>
                <div class="tab-content">
                    <div class="tabs-main">
                        <div class="w-50">
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=1']);?>"><?=Yii::t('app','property_type1'); ?> (<?=$this->context->umumi1; ?>)</a></p>
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=2']);?>"><?=Yii::t('app','property_type2'); ?> (<?=$this->context->umumi2; ?>)</a></p>
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=3']);?>"><?=Yii::t('app','property_type3'); ?> (<?=$this->context->umumi3; ?>)</a></p>
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=4']);?>"><?=Yii::t('app','property_type4'); ?> (<?=$this->context->umumi4; ?>)</a></p>
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=5']);?>"><?=Yii::t('app','property_type5'); ?> (<?=$this->context->umumi5; ?>)</a></p>
                        </div>
                        <div class="w-50">
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=6']);?>"><?=Yii::t('app','property_type6'); ?> (<?=$this->context->umumi6; ?>)</a></p>
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=7']);?>"><?=Yii::t('app','property_type7'); ?> (<?=$this->context->umumi7; ?>)</a></p>
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=8']);?>"><?=Yii::t('app','property_type8'); ?> (<?=$this->context->umumi8; ?>)</a></p>
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=9']);?>"><?=Yii::t('app','property__typeX'); ?> (<?=$this->context->umumix; ?>)</a></p>
                        </div>
                    </div>
                    <div class="tabs-main">
                        <div class="w-50">
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=1&day=1']);?>"><?=Yii::t('app','property_type1'); ?> (<?=$this->context->s24_1; ?>)</a></p>
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=2&day=1']);?>"><?=Yii::t('app','property_type2'); ?> (<?=$this->context->s24_2; ?>)</a></p>
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=3&day=1']);?>"><?=Yii::t('app','property_type3'); ?> (<?=$this->context->s24_3; ?>)</a></p>
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=4&day=1']);?>"><?=Yii::t('app','property_type4'); ?> (<?=$this->context->s24_4; ?>)</a></p>
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=5&day=1']);?>"><?=Yii::t('app','property_type5'); ?> (<?=$this->context->s24_5; ?>)</a></p>
                        </div>
                        <div class="w-50">
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=6&day=1']);?>"><?=Yii::t('app','property_type6'); ?> (<?=$this->context->s24_6; ?>)</a></p>
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=7&day=1']);?>"><?=Yii::t('app','property_type7'); ?> (<?=$this->context->s24_7; ?>)</a></p>
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=8&day=1']);?>"><?=Yii::t('app','property_type8'); ?> (<?=$this->context->s24_8; ?>)</a></p>
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=9&day=1']);?>"><?=Yii::t('app','property__typeX'); ?> (<?=$this->context->s24_x; ?>)</a></p>
                        </div>
                    </div>
                    <div class="tabs-main">
                        <div class="w-50">
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=1&day=7']);?>"><?=Yii::t('app','property_type1'); ?> (<?=$this->context->s7_1; ?>)</a></p>
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=2&day=7']);?>"><?=Yii::t('app','property_type2'); ?> (<?=$this->context->s7_2; ?>)</a></p>
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=3&day=7']);?>"><?=Yii::t('app','property_type3'); ?> (<?=$this->context->s7_3; ?>)</a></p>
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=4&day=7']);?>"><?=Yii::t('app','property_type4'); ?> (<?=$this->context->s7_4; ?>)</a></p>
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=5&day=7']);?>"><?=Yii::t('app','property_type5'); ?> (<?=$this->context->s7_5; ?>)</a></p>
                        </div>
                        <div class="w-50">
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=6&day=7']);?>"><?=Yii::t('app','property_type6'); ?> (<?=$this->context->s7_6; ?>)</a></p>
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=7&day=7']);?>"><?=Yii::t('app','property_type7'); ?> (<?=$this->context->s7_7; ?>)</a></p>
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=8&day=7']);?>"><?=Yii::t('app','property_type8'); ?> (<?=$this->context->s7_8; ?>)</a></p>
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=9&day=7']);?>"><?=Yii::t('app','property__typeX'); ?> (<?=$this->context->s7_x; ?>)</a></p>
                        </div>
                    </div>
                    <div class="tabs-main">
                        <div class="w-50">
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=1&day=30']);?>"><?=Yii::t('app','property_type1'); ?> (<?=$this->context->s30_1; ?>)</a></p>
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=2&day=30']);?>"><?=Yii::t('app','property_type2'); ?> (<?=$this->context->s30_2; ?>)</a></p>
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=3&day=30']);?>"><?=Yii::t('app','property_type3'); ?> (<?=$this->context->s30_3; ?>)</a></p>
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=4&day=30']);?>"><?=Yii::t('app','property_type4'); ?> (<?=$this->context->s30_4; ?>)</a></p>
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=5&day=30']);?>"><?=Yii::t('app','property_type5'); ?> (<?=$this->context->s30_5; ?>)</a></p>
                        </div>
                        <div class="w-50">
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=6&day=30']);?>"><?=Yii::t('app','property_type6'); ?> (<?=$this->context->s30_6; ?>)</a></p>
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=7&day=30']);?>"><?=Yii::t('app','property_type7'); ?> (<?=$this->context->s30_7; ?>)</a></p>
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=8&day=30']);?>"><?=Yii::t('app','property_type8'); ?> (<?=$this->context->s30_8; ?>)</a></p>
                            <p><a href="<?=Url::to(['elanlar/?ann_type=3&property_type=9&day=30']);?>"><?=Yii::t('app','property__typeX'); ?> (<?=$this->context->s30_x; ?>)</a></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="copy">
        <p>© Emlak.az Müəllif hüquqları qorunur</p>
        Saytın rəhbərliyi reklam bannerlərinin və yerləşdirilmiş elanların məzmununa görə məsuliyyət daşımır
    </div>
</footer>