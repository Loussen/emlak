<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use backend\components\MyFunctions;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\AlbumsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $searchModel::$titleName;
?>
<div class="single-head">
    <h3 class="pull-left"><i class="fa fa-bars green"></i> <?= Html::encode($this->title); ?></h3>
    <div class="clearfix"></div>
</div>

<div class="albums-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Əlavə et', ['create'], ['class' => 'btn btn-success']) ?>
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
                    'attribute' => 'id',
                    'options' => ['width'=>90],
                ],
                [
                    'header'=>'Başlıq',
                    'attribute'=>'title_'.Yii::$app->params["defaultLanguage"],
                ],
                [
                    'header'=>'Şəkil',
                    'format'=>'raw',
                    'value'=>function($data)
                        {
                            if($data->image!=null && is_file(MyFunctions::getImagePath().'/'.$data->thumb))
                            {
                                return Html::a(HTML::img(MyFunctions::getImageUrl().'/'.$data->thumb),'../albums-inner/index/'.$data->id);
                                //return MyFunctions::getImageUrl().'/'.$data->thumb;
                            }
                        },
                    'contentOptions'=>['class'=>'row-image'],
                ],
                [
                    'attribute'=>'status',
                    'filter'=>MyFunctions::getStatus(),
                    'format' => 'raw',
                    'value' => function($data) {
                            return Html::a('<i class="fa fa-circle white"></i> '.MyFunctions::getStatus($data->status),'status/'.$data->id,['class'=>'btn '.MyFunctions::getStatusTemplate($data->status).' btn-sm']);
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
