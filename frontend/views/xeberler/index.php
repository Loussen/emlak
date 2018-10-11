<?php
use frontend\components\MyFunctionsF;
use yii\helpers\Url;

$this->title=Yii::t('app','pg_title3');
?>
<div class="content clearfix">
    <div class="main-title classic-margin"><span><?=Yii::t('app','lang3'); ?></span></div>
    <ul class="news-list">
        <?php
        foreach($posts as $row)
        {
            echo '<li>
            <a href="'.Url::toRoute([Yii::$app->controller->id.'/'.$row["id"]]).'/'.$row["slug"].'">';
                if(is_file(MyFunctionsF::getImagePath().'/'.$row["thumb"])) echo '<img src="'.MyFunctionsF::getImageUrl().'/'.$row["thumb"].'" alt="" >';
                echo '<p class="title">'.$row["title_".Yii::$app->language].'</p>
                <i class="date">'.date("d.m.Y",$row["news_time"]).'</i>
            </a>
        </li>';
        }
        ?>
    </ul>
    <div class="pagination">
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