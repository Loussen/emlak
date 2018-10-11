<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\components\MyFunctions;

/* @var $this yii\web\View */
/* @var $model backend\models\Categories */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categories-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="ui-element-container">
        <div id="myTabContent" class="tab-content">
            <?= $form->field($model, 'mobile')->textInput(); ?>
            <?= $form->field($model, 'balance')->textInput(); ?>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Əlavə et' : 'Yadda saxla', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken(); ?>" />
    <?php ActiveForm::end(); ?>
</div>