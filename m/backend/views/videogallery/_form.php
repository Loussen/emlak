<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use pjkui\kindeditor\KindEditor;
use backend\components\MyFunctions;

/* @var $this yii\web\View */
/* @var $model backend\models\Albums */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="albums-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

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

                echo $form->field($model, 'title_'.$key)->textInput();
                echo $form->field($model, 'text_'.$key)->widget(Kindeditor::className(),[
                    'clientOptions'=>[
                        'allowFileManager'=>'true',
                        'allowUpload'=>'true',
                        'langType' => 'en',
                        /*
                        'items' => [
                            'undo','redo'
                        ]
                        */
                    ],
                ]);

                echo '</div>';
            }
            ?>
            <?= $form->field($model, 'image')->fileInput(); ?>
            <?php if($model->image!=null) echo Html::a(Html::img(MyFunctions::getImageUrl().'/'.$model->thumb, ['width'=>150,'height'=>150]), MyFunctions::getImageUrl().'/'.$model->image, ['target'=>'_blank']); ?>

            <?= $form->field($model, 'slug')->textInput(); ?>
            <?= $form->field($model, 'status')->dropDownList(MyFunctions::getStatus()); ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Əlavə et' : 'Yadda saxla', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken(); ?>" />
    <?php ActiveForm::end(); ?>

</div>
