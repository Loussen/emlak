<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use backend\components\MyFunctions;
use yii\widgets\ActiveForm;

$this->title = $searchModel::$titleName.' - '.$parent_info->title_az;
?>
<div class="single-head">
    <h3 class="pull-left"><i class="fa fa-bars green"></i> <?= Html::encode($this->title); ?></h3>
    <div class="clearfix"></div>
</div>

<div class="categories-index">
    <p>
        <?php $form=ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>
            <?= $form->field($searchModel, 'image[]',
                ['template' => '<div class="input-group pull-left">{input}</div>',]
            )->fileInput(['multiple'=>true]); ?>
        <div class="form-group ">
            <?= Html::submitButton('Bütün şəkilləri əlavə et', ['class' => $searchModel->isNewRecord ? 'btn btn-success' : 'btn btn-primary','name'=>'add_image_save']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </p>

    <p>
        <?= Html::a('Yeni şəkil əlavə et', ['create','id'=>$id], ['class' => 'btn btn-success']) ?>
    </p>

    <form action="<?php echo Url::toRoute(['deletemore','id'=>$id]); ?>" method="post">
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
                'attribute' => 'id',
                'options' => ['width'=>90],
            ],
            [
                'header'=>'Başlıq',
                'attribute'=>'title_'.Yii::$app->params["defaultLanguage"]
            ],
            [
                'header'=>'Şəkil',
                'format'=>'image',
                'value'=>function($data)
                    {
                        if($data->image!=null && is_file(MyFunctions::getImagePath().'/'.$data->thumb)) return MyFunctions::getImageUrl().'/'.$data->thumb;
                    },
                'contentOptions'=>['class'=>'row-image'],
            ],
            [
                'attribute'=>'status',
                'filter'=>MyFunctions::getStatus(),
                'format' => 'raw',
                'value' => function($data) {
                        return Html::a('<i class="fa fa-circle white"></i> '.MyFunctions::getStatus($data->status),['sliders-inner/status/'.$data->id],['class'=>'btn '.MyFunctions::getStatusTemplate($data->status).' btn-sm']);
                    },
            ],
            [
                'class' => 'backend\components\grid\ActionColumn',
                'template' => '{up} {down}',
                'header' =>'Sıralama',
                'visible' => $searchModel::$sortableStatus,
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