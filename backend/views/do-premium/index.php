<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use backend\components\MyFunctions;

$this->title = 'Premium elan yerləşdir';
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
                'header' =>'123456, user, admin',
				'attribute' => 'id',
                'options' => ['width'=>200],
				'format'=>'raw',
                'value' =>function($data){
                        $return ='<div class="go_view">info</div>';
						if(($data["sort_premium"]%2)==1) $who='Admin'; else $who='User';
                        return $data["id"].' / <b>'.$who.'</b><a href="'.Url::toRoute(['announces/index?status=7&id='.$data["id"]]).'">'.$return.'</a>';
                    }
            ],
            [
                'header'=>'Qalan müddət',
                'value' =>function($data){
                        return floor(($data["sort_premium"]-time())/86400).' gün '.(floor(($data["sort_premium"]-time())/3600)%24).' saat '.(floor(($data["sort_premium"]-time())/60)%60).' dəqiqə';
                    }
            ],
            [
                'header' =>'Əməliyyatlar',
                'format' => 'raw',
                'value' => function($data){
						$viewURL='../'.$data["id"].'-adminView.html';
						$deleteURL='do-premium/delete/'.$data["id"];
						
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