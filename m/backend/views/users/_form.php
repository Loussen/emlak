<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\components\MyFunctions;
use pjkui\kindeditor\KindEditor;

/* @var $this yii\web\View */
/* @var $model backend\models\Categories */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categories-form">

    <?php $form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]); ?>

    <div class="ui-element-container">
        <div id="myTabContent" class="tab-content">
            <?=$form->field($model, 'name')->textInput(); ?>
            <?=$form->field($model, 'email')->textInput(); ?>
            <?=$form->field($model, 'login')->textInput(); ?>
            <?=$form->field($model, 'password')->textInput(); ?>
            <?=$form->field($model, 'mobile')->textarea(['rows'=>3]); ?>
            <?=$form->field($model, 'address')->textInput(); ?>
            <?=$form->field($model, 'text')->textarea(); ?>
            <?=$form->field($model, 'package_announce')->textInput(['type'=>'number']); ?>
            <?=$form->field($model, 'package_foward')->textInput(['type'=>'number']); ?>
            <?=$form->field($model, 'package_search')->textInput(['type'=>'number']); ?>
            <?=$form->field($model, 'premium')->textInput(['type'=>'number']); ?>
            <?= $form->field($model, 'image')->fileInput(); ?>
            <?php if($model->image!=null) echo Html::a(Html::img(MyFunctions::getImageUrl().'/'.$model->thumb, ['width'=>150,'height'=>150]), MyFunctions::getImageUrl().'/'.$model->image, ['target'=>'_blank']); ?>
            <br /><br />
            <?= $form->field($model, 'newsletter')->checkbox(['name'=>'newsletter']); ?>
            <?= $form->field($model, 'status')->dropDownList(MyFunctions::getStatus()); ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Əlavə et' : 'Yadda saxla', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

        </div>
    </div>
    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken(); ?>" />
    <?php ActiveForm::end(); ?>
</div>