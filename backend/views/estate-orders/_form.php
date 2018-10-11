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
        <!-- Heading -->
        <ul id="myTab" class="nav nav-tabs">
            <?php
            foreach(Yii::$app->params['languages'] as $key=>$lang)
            {
                break;
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

                    echo $form->field($model, 'type')->dropDownList($model::getType());
                    echo $form->field($model, 'title')->textInput(['maxlength' => true]);
                    echo $form->field($model, 'name')->textInput(['maxlength' => true]);
                    echo $form->field($model, 'phone')->textInput(['maxlength' => true]);
                    echo $form->field($model, 'text')->textarea(['rows'=>5]);

                echo '</div>';
                break;
            }
            ?>

            <?= $form->field($model, 'status')->dropDownList(MyFunctions::getStatus()); ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Əlavə et' : 'Yadda saxla', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

        </div>
    </div>
    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken(); ?>" />
    <?php ActiveForm::end(); ?>
</div>