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
    <?php $form = ActiveForm::begin(); ?>
    <div class="ui-element-container">
        <div id="myTabContent" class="tab-content">
            <?= $form->field($model, 'title_')->textarea(); ?>
			<?= $form->field($model, 'page_title')->textInput(); ?>
			<?= $form->field($model, 'keywords_')->textInput(); ?>
            <?= $form->field($model, 'description_')->textInput(); ?>
            <?= $form->field($model, 'sql_')->textInput(); ?>
            <?= $form->field($model, 'word_')->textInput(); ?>
			<?php echo $form->field($model, 'text_top')->widget(Kindeditor::className(),[
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
                ]); ?>
			<?php echo $form->field($model, 'text_bottom')->widget(Kindeditor::className(),[
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
                ]); ?>
				
			<?= $form->field($model, 'status')->dropDownList(MyFunctions::getStatus('all','desc')); ?>
				
				
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Əlavə et' : 'Yadda saxla', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken(); ?>" />
    <?php ActiveForm::end(); ?>
</div>