<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use backend\components\MyFunctions;

$this->title = 'Facebook və instagramda paylaşım etmək istəyənlər';
?>
<div class="single-head">
    <h3 class="pull-left"><i class="fa fa-bars green"></i> <?= Html::encode($this->title); ?></h3>
    <div class="clearfix"></div>
</div>

<div class="categories-index">
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
				'header' =>'Elanın kodu',
                'options' => ['width'=>200],
				'format'=>'raw',
                'value' =>function($data){
                        $return ='<div class="go_view">info</div>';
                        return $data["announce_id"].'<a href="'.Url::toRoute(['announces/index?status=7&id='.$data["announce_id"]]).'">'.$return.'</a>';
                    }
            ],
            [
                'attribute'=>'create_time',
				'header' =>'Tarix',
                'value' =>function($data){
                        return date('d.m.Y H:i',$data["create_time"]);
                    }
            ],
            [
                'header' =>'Əməliyyatlar',
                'format' => 'raw',
                'value' => function($data){
						$viewURL='../'.$data["announce_id"].'-adminView.html';
						$deleteURL='do-share/delete/'.$data["id"];
						
                        return '
						<a target="_blank" class="btn btn-success btn-xs" href="'.Url::toRoute([$viewURL]).'" title="Bax" aria-label="Bax" data-pjax="0"><span class="glyphicon glyphicon-eye-open white"></span></a>
						<a class="btn btn-warning btn-xs" href="'.Url::toRoute([$deleteURL]).'" title="Sil" aria-label="Sil" data-confirm="Bu elementi silmək istədiyinizə əminsinizmi?" data-method="post" data-pjax="0"><span class="glyphicon glyphicon-trash white"></span></a>
                        ';
                    },
            ],
        ],
    ]); ?>
        <?= Html::submitButton('Seçilmişləri sil',['class'=>'btn btn-danger','data-confirm'=>'Əminsinizmi?']); ?>
        <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken(); ?>" />
    </form>
</div>