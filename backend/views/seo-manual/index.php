<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use backend\components\MyFunctions;

$this->title = $searchModel::$titleName;
?>
<div class="single-head">
    <h3 class="pull-left"><i class="fa fa-bars green"></i> <?= Html::encode($this->title); ?></h3>
    <div class="clearfix"></div>
</div>

<div class="categories-index">
    <p>
        <?= Html::a('<i class="fa fa-plus"></i> Əlavə et', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <form action="<?php echo Url::toRoute('deletemore'); ?>" method="post">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => "{errors}\n{summary}\n{items}\n{summary}\n{pager}",
        'showFooter' =>false,
        'options' => [
            'class' => 'table-responsive',
        ],
        'tableOptions' => [
            'class' => 'table table-hover table-bordered',
        ],
        'columns' => [
            [
                'class'=>'yii\grid\CheckboxColumn',
                'name'=>'check[]',
            ],
            [
                'attribute'=>'title_',
                'header'=>'Title',
				'format'=>'raw',
				'value'=>function($data){
					return '<a style="color:blue;" href="'.Url::toRoute(['seo-manual-inner/index/'.$data->id]).'">'.$data->title_.'</a>';
				},
            ],
            [
                'class' => 'backend\components\grid\ActionColumn',
                'header' =>'Əməliyyatlar',
            ],
        ],
    ]); ?>
        <?= Html::submitButton('Seçilmişləri sil',['class'=>'btn btn-danger','data-confirm'=>'Əminsinizmi?']); ?>
        <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken(); ?>" />
    </form>
</div>