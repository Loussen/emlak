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
        <!-- Heading -->
        <ul id="myTab" class="nav nav-tabs">
            <?php
            foreach(Yii::$app->params['languages'] as $key=>$lang)
            {
                if($key==Yii::$app->params['defaultLanguage']) $class='active'; else $class='';
                echo '<li class="'.$class.'"><a href="#'.$key.'" data-toggle="tab">'.$lang.'</a></li>';
            }
            ?>
        </ul>
        <div id="myTabContent" class="tab-content">
            <?php
            foreach(Yii::$app->params['languages'] as $key=>$lang)
            {
                if($key==Yii::$app->params['defaultLanguage']) $class='in active'; else $class='';
                echo '<div class="tab-pane fade '.$class.'" id="'.$key.'">';
                $field_name='text_'.$key;
                echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'parent_id',
                'value' => $model->getParents()[$model->parent_id],
            ],
            [
                'attribute' => 'table_name',
                'value' => Yii::$app->params["tableTemplates"][$model->table_name],
            ],
            [
                'attribute' => 'title_'.$key,
                'label'=>'Başlıq',
            ],
            [
                'attribute' => 'text_'.$key,
                'label'=>'İnformasiya',
                'format' => 'raw',
                'value' => Html::decode($model->$field_name),
            ],
            'position',
            'slug',
            [
                'attribute'=>'status',
                'value' => MyFunctions::getStatus($model->status),
            ],
        ],
    ]);
    echo '</div>';
    }
    ?>
</div>
</div>
</div>