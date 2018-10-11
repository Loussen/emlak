<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Categories;
use backend\components\MyFunctions;
use pjkui\kindeditor\KindEditor;

/* @var $this yii\web\View */
/* @var $model backend\models\Categories */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="apartments-form">

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
                echo $form->field($model, 'address_'.$key)->textInput();
                echo $form->field($model, 'short_text_'.$key)->textarea();
                echo $form->field($model, 'about_project_'.$key)->widget(Kindeditor::className(),[
                    'clientOptions'=>[
                        'allowFileManager'=>'true',
                        'allowUpload'=>'true',
                        'langType' => 'en',
                    ],
                ]);
                echo $form->field($model, 'about_company_'.$key)->widget(Kindeditor::className(),[
                    'clientOptions'=>[
                        'allowFileManager'=>'true',
                        'allowUpload'=>'true',
                        'langType' => 'en',
                    ],
                ]);

                echo '</div>';
            }
            ?>

            <?= $form->field($model, 'image')->fileInput(); ?>
            <?php if($model->image!=null) echo Html::a(Html::img(MyFunctions::getImageUrl().'/'.$model->thumb, ['width'=>150,'height'=>150]), MyFunctions::getImageUrl().'/'.$model->image, ['target'=>'_blank']); ?>

            <?= $form->field($model, 'slug')->textInput(['maxlength' => true]); ?>
            <?= $form->field($model, 'price')->textInput(['maxlength' => true]); ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]); ?>
            <?= $form->field($model, 'mobile')->textInput(['maxlength' => true]); ?>
            <?= $form->field($model, 'google_map')->textInput(['maxlength' => true]); ?>

            <?= $form->field($model, 'logo')->fileInput(); ?>
            <?php if($model->logo!=null) echo Html::a(Html::img(MyFunctions::getImageUrl().'/'.$model->logo, ['width'=>150,'height'=>150]), MyFunctions::getImageUrl().'/'.$model->logo, ['target'=>'_blank']); ?>

            <?= $form->field($model, 'status')->dropDownList(MyFunctions::getStatus()); ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Əlavə et' : 'Yadda saxla', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

        </div>
    </div>
    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken(); ?>" />
    <?php ActiveForm::end(); ?>
</div>