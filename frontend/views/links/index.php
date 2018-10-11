<?php
use yii\helpers\Url;
$this->title = $this->context->siteTitle;
?>
<div class="content clearfix broker">
    <div class="panel clearfix">
        <h1 class="title"><?php if($tip==1) Yii::t('app','lang288'); else echo Yii::t('app','lang297'); ?></h1>
    </div>

    <div class="ticket-list">
        <?php
		if($tip==1) $url='elan'; else $url='elans';
        foreach($links as $row){
            echo '<div class="site_inner_link"><a href="'.Url::to([$url.'/'.$row["link_"]]).'">'.$row["title_"].'</a></div>';
        }
        ?>
    </div>
    <div class="pagination">
        <ul>
            <?php
            //Paginator ///////////////////////////////////////////
			if($page<3) $show=5;
            if($page>1) echo '<li><a href="'.Url::to([$link.'&tip='.$tip.'&page='.($page-1)]).'"> &larr; '.Yii::t('app','lang29').'</a></li>';
            for($i=$page-$show;$i<=$page+$show;$i++)
            {
                if($i>0 && $i<=$max_page)
                {
                    if($i==$page) echo '<li class="active"><a href="javascript:void(0);">'.$i.'</a></li>';
                    else echo '<li><a href="'.Url::to([$link.'&tip='.$tip.'&page='.$i]).'">'.$i.'</a></li>';
                }
            }
            if($page<$max_page) echo '<li><a href="'.Url::to([$link.'&tip='.$tip.'&page='.($page+1)]).'">'.Yii::t('app','lang30').' &rarr; </a></li>';
            //Paginator ///////////////////////////////////////////
            ?>
        </ul>
    </div>
</div>