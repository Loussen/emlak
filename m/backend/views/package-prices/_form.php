<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\components\MyFunctions;

/* @var $this yii\web\View */
/* @var $model backend\models\About */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="About-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="ui-element-container">
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade in active">
            <?php
                echo $form->field($model, 'announce_limit')->textInput();
                echo $form->field($model, 'announce_time')->textInput(['maxlength'=>3]);
                echo $form->field($model, 'announce_package1')->textInput();
                echo $form->field($model, 'announce_package10')->textInput();
                echo $form->field($model, 'announce_package50')->textInput();
                echo $form->field($model, 'announce_premium10')->textInput();
                echo $form->field($model, 'announce_premium15')->textInput();
                echo $form->field($model, 'announce_premium30')->textInput();
                echo $form->field($model, 'announce_foward1')->textInput();
                echo $form->field($model, 'announce_foward20')->textInput();
                echo $form->field($model, 'announce_foward50')->textInput();
                echo $form->field($model, 'announce_foward_time')->textInput();
                echo $form->field($model, 'announce_fb')->textInput();
                echo $form->field($model, 'announce_download')->textInput();
                echo $form->field($model, 'announce_search10')->textInput();
                echo $form->field($model, 'announce_urgent')->textInput();
                echo $form->field($model, 'realtor_premium1')->textInput();
                echo $form->field($model, 'realtor_premium3')->textInput();
                echo $form->field($model, 'realtor_premium6')->textInput();
            ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Əlavə et' : 'Yadda saxla', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

        </div>
    </div>
    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken(); ?>" />
    <?php ActiveForm::end(); ?>
</div>