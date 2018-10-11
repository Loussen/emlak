<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use backend\components\MyFunctions;

$this->title = $searchModel::$titleNameSearch;

if($status==0) $title = 'Yeni elanlarda';
else if($status==1) $title = 'Aktiv elanlarda';
else if($status==2) $title = 'Bitmiş elanlarda';
else if($status==3) $title = 'Təsdiqlənməyən elanlarda';
else if($status==4) $title = 'Silinmiş elanlarda';
else if($status==5) $title = 'İrəli çəkilmiş elanlarda';
else if($status==6) $title = 'Təcili elanlarda';
else if($status==7) $title = 'Premium elanlarda';
else if($status==8) $title = 'Axtarışda irəli çəkilmiş elanlarda';
else $title = 'Bütün elanlarda';

?>
<div class="single-head">
    <h3 class="pull-left"><i class="fa fa-bars green"></i> <?= Html::encode($this->title).' / <a href="'.Url::to(['announces-search/index?status=all']).'">'.$title.'</a>'; ?> </h3>
    <div class="clearfix"></div>
</div>

<div class="categories-index">
    <form action="<?php echo Url::toRoute('deletemore'); ?>" method="post">
	<?php
	if($AnnouncesSearch=='') $layout="{errors}\n{items}\n{pager}"; else $layout="{errors}\n{summary}\n{items}\n{summary}\n{pager}";
	?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => $layout,
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
				'options' => ['width'=>30],
				'checkboxOptions' => function ($data) {
					return ['value' => $data["id"]];
				}
            ],
            [
                'attribute' => 'id',
                'options' => ['width'=>90],
                'format'=>'raw',
                'value' =>function($data){
                        $return ='<div class="go_view">info</div>';
                        return $data["id"].'<a href="'.Url::toRoute(['announces/index?status='.$data["status"].'&id='.$data["id"]]).'">'.$return.'</a>';
                    }
            ],
            [
                'attribute' => 'announce_date',
                'options' => ['width'=>120],
                'value' => function($data)
                    {
                        return date("d.m.Y H:i",$data["announce_date"]);
                    },
            ],
            [
                'attribute' => 'email',
                'options' => ['width'=>120],
            ],
            [
                'attribute' => 'name',
                'options' => ['width'=>120],
                'value' =>function($data)
                    {
                        if($data["announcer"]==1) $who='Mülkiyyətçi'; else $who='Vasitəçi';
                        return html_entity_decode($data["name"]).' ('.$who.')';
                    }
            ],
            [
                'attribute' => 'mobile',
                'options' => ['width'=>130],
				'value' =>function($data){
					return str_replace('*',', ',$data["mobile"]);
				}
            ],
            [
                'attribute'=>'status',
                'options' => ['width'=>100],
                'filter'=>MyFunctions::getStatus(),
                'format' => 'raw',
                'value' => function($data) {
                        if($data["status"]==0) return Html::a('<i class="fa fa-circle white"></i> Gözləyir',Url::toRoute(['status?id='.$data["id"].'&status=0&changeStatus=1']),['class'=>'btn '.MyFunctions::getStatusTemplate($data["status"]).' btn-sm']);
                        else if($data["status"]==1) return Html::a('<i class="fa fa-circle white"></i> Aktivdir',Url::toRoute(['status?id='.$data["id"].'&status=0&changeStatus=3']),['class'=>'btn '.MyFunctions::getStatusTemplate($data["status"]).' btn-sm']);
                        else if($data["status"]==2 && $data["announce_date"]!=$data["create_time"]) return Html::a('<i class="fa fa-circle white"></i> Bitib',Url::toRoute(['status?id='.$data["id"].'&status=2&changeStatus=1']),['class'=>'btn '.MyFunctions::getStatusTemplate($data["status"]).' btn-sm']);
                        else if($data["status"]==3) return Html::a('<i class="fa fa-circle white"></i> deAktiv',Url::toRoute(['status?id='.$data["id"].'&status=0&changeStatus=1']),['class'=>'btn '.MyFunctions::getStatusTemplate($data["status"]).' btn-sm']);
                        else if($data["status"]==4 or ($data["status"]==2 && $data["announce_date"]==$data["create_time"]) ) return Html::a('<i class="fa fa-circle white"></i> Silinib',Url::toRoute(['status?id='.$data["id"].'&status=0&changeStatus=1']),['class'=>'btn '.MyFunctions::getStatusTemplate($data["status"]).' btn-sm']);
                        else return 'status aktivdir';
                    },
            ],
            [
                'header' =>'Əməliyyatlar',
                'format' => 'raw',
				'options' => ['width'=>130],
                'value' => function($data){
                        $code=MyFunctions::codeGeneratorforAdmin($data["id"],$this->context->adminLoggedInfo[0]["id"]);
                        $editURL='../elan-ver/index?id='.$data["id"].'&code='.$code.'&admin='.$this->context->adminLoggedInfo[0]["id"];
						$endedURL='../cron/clear_ended_announces.php?id='.$data["id"].'&code='.$code.'&admin='.$this->context->adminLoggedInfo[0]["id"];
						//$title=$this->context->titleGenerator('az',$data["announce_type"],$data["property_type"],$data["space"],$data["room_count"],$data["mark"],$data["settlement"],$data["metro"],$data["region"],$data["city"],$data["address"]);
                        //$viewURL='../'.$data["id"].'-'.MyFunctions::slugGenerator($title).'.html';
						$viewURL='../'.$data["id"].'-adminView.html';
						$deleteURL='announces-search/delete/'.$data["id"];
						$fullDeleteURL='announces-search/full_delete/'.$data["id"];
						
						$fowardURL='announces-search/set_foward/'.$data["id"];
						$urgentURL='announces-search/set_urgently/'.$data["id"];
						$premiumURL='do-premium/create?id='.$data["id"];
						$searchFowardURL='announces-search/set_search_foward/'.$data["id"];
						
						
                        return '
						<a class="btn btn-warning btn-xs" href="'.Url::toRoute([$deleteURL]).'" title="Sil" aria-label="Sil" data-confirm="Bu elementi silmək istədiyinizə əminsinizmi?" data-method="post" data-pjax="0"><span class="glyphicon glyphicon-trash white"></span></a>
                        <a target="_blank" class="btn btn-success btn-xs" href="'.Url::toRoute([$viewURL]).'" title="Bax" aria-label="Bax" data-pjax="0"><span class="glyphicon glyphicon-eye-open white"></span></a>
                        <a target="_blank" class="btn btn-primary btn-xs" href="'.Url::toRoute([$editURL]).'" title="Yenilə" aria-label="Yenilə" data-pjax="0"><span class="glyphicon glyphicon-pencil white"></span></a>
                        <a class="btn btn-danger btn-xs" href="'.Url::toRoute([$fullDeleteURL]).'" title="Sil" aria-label="Sil" data-confirm="Bu elementi silmək istədiyinizə əminsinizmi?" data-method="post" data-pjax="0"><span class="glyphicon glyphicon-trash white"></span></a>
						
						<br />
						<a class="btn btn-primary btn-xs" href="'.Url::toRoute([$fowardURL]).'" title="İrəli çək" aria-label="İrəli çək" data-pjax="0"><span class="glyphicon glyphicon-fast-forward white"></span></a>
						<a class="btn btn-primary btn-xs" href="'.Url::toRoute([$urgentURL]).'" title="Təcili et" aria-label="Təcili et" data-pjax="0"><span class="glyphicon glyphicon-flash white"></span></a>
						<a class="btn btn-primary btn-xs" href="'.Url::toRoute([$premiumURL]).'" title="Premium et" aria-label="Premium et" data-pjax="0"><span class="glyphicon glyphicon-star white"></span></a>
						<a class="btn btn-primary btn-xs" href="'.Url::toRoute([$searchFowardURL]).'" title="Axtarışda irəli çək" aria-label="Axtarışda irəli çək" data-pjax="0"><span class="glyphicon glyphicon-search white"></span></a>
						<a class="btn btn-primary btn-xs" href="'.Url::toRoute([$endedURL]).'" target="_blank" title="Elanı bitir" aria-label="Elanı bitir" data-pjax="0"><span class="glyphicon glyphicon-time white"></span></a>
                        ';
                    },
            ],
        ],
    ]); ?>
        <?= Html::submitButton('Seçilmişləri sil',['class'=>'btn btn-danger','data-confirm'=>'Əminsinizmi?']); ?>
        <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken(); ?>" />
    </form>
</div>