<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\components\MyFunctions;

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
        <?= Html::a('Siyahı', ['index', 'id' => $model->parent_id], ['class' => 'btn btn-success']) ?>
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
				'title_',
				'page_title',
				'keywords_',
				'description_',
				'sql_',
				'word_',
				[
					'attribute' => 'text_top',
					'label'=>'Text Top',
					'format' => 'raw',
					'value' => Html::decode($model->text_top),
				],
				[
					'attribute' => 'text_bottom',
					'label'=>'Text Bottom',
					'format' => 'raw',
					'value' => Html::decode($model->text_bottom),
				],
			],
		]);
		?>
</div>
</div>
</div>