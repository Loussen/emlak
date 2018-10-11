<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\components\MyFunctions;
use backend\models\Categories;
use backend\models\Albums;
use backend\models\Authors;

/* @var $this yii\web\View */
/* @var $model backend\models\Categories */

$this->title = $model::$titleName;
?>
<div class="categories-view">
    <div class="single-head">
        <h3 class="pull-left"><i class="fa fa-bars green"></i> <?= Html::encode($this->title); ?></h3>
        <div class="clearfix"></div>
    </div>

    <p>
        <?= Html::a('Siyahı', ['index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Düzəliş et', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Sil', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Silməyə əminsinizmi?',
                'method' => 'post',
            ],
        ]) ?>
        <hr />
    </p>
    <div class="ui-element-container">
        <div id="myTabContent" class="tab-content">
            <?php
                echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'email',
            'login',
            [
                'attribute'=>'mobile',
                'value'=>str_replace("***",", ",$model->mobile)
            ],
            'address',
            [
                'attribute'=>'newsletter',
                'format'=>'raw',
                'value'=>($model->newsletter==1)?'Bəli':'Xeyr'
            ],
			'text',
			'title_',
			'keywords_',
			'desc_',
            'package_announce',
            'package_foward',
            'package_search',
			[
                'attribute'=>'premium',
                'label'=>'Əmlakçılar bölməsində',
                'format'=>'raw',
                'value'=>ceil(($model->premium-time())/86400).' gün',
            ],
            'announce_count',
            [
                'attribute'=>'image',
                'label'=>'Şəkil',
                'format'=>'raw',
                'value'=>($model->image!=null && is_file(MyFunctions::getImagePath().'/'.$model->image))?HTML::img(MyFunctions::getImageUrl().'/'.$model->thumb):'',
            ],
            [
                'attribute'=>'thumb',
                'label'=>'Şəkil (Thumb)',
                'format'=>'raw',
                'value'=>($model->thumb!=null && is_file(MyFunctions::getImagePath().'/'.$model->thumb))?HTML::img(MyFunctions::getImageUrl().'/'.$model->thumb,['width'=>70]):'',
            ],
            [
                'attribute'=>'status',
                'value' => MyFunctions::getStatus($model->status),
            ],
        ],
    ]);
    ?>
</div>
</div>
</div>