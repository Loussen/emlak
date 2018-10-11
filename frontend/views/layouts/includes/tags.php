<?php
use yii\helpers\Url;

echo '<div class="tag-cloud-list">';
$tags=$this->context->getTags(10);
foreach($tags as $tag){
	echo '<a href="'.Url::to(['/elans/'.$tag["link_"]]).'">'.$tag["title_"].'</a>';
}
echo '</div>';
?>