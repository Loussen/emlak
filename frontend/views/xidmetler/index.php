<?php
use frontend\components\MyFunctionsF;

$this->title=Yii::t('app','pg_title5');
?>
<div class="content clearfix">
    <h2 class="main-title classic-margin"><span><?=Yii::t('app','lang17'); ?></span></h2>
    <ul class="service-list">
        <?php
        foreach($info as $row)
        {
            echo '<li>
            <div class="pull-left">
                <a href="javascript:void(0);"><img src="'.MyFunctionsF::getImageUrl().'/'.$row["thumb"].'" alt="" ></a>
            </div>
            <div class="pull-right">
                <h3><a href="javascript:void(0);">'.$row["title_".Yii::$app->language].'</span></a></h3>
                '.$row["short_text_".Yii::$app->language].'
            </div>
        </li>';
        }
        ?>
    </ul>
</div>