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

<div class="categories-form">

    <?php $form = ActiveForm::begin(); ?>

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

                    echo $form->field($model, 'address_'.$key)->textarea(['maxlength' => true]);
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
                    echo $form->field($model, 'footer_'.$key)->widget(Kindeditor::className(),[
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

            <?php echo $form->field($model, 'email')->textInput(['maxlength' => true]); ?>
            <?php echo $form->field($model, 'facebook')->textInput(['maxlength' => true]); ?>
            <?php echo $form->field($model, 'twitter')->textInput(['maxlength' => true]); ?>
            <?php echo $form->field($model, 'vkontakte')->textInput(['maxlength' => true]); ?>
            <?php echo $form->field($model, 'linkedin')->textInput(['maxlength' => true]); ?>
            <?php echo $form->field($model, 'digg')->textInput(['maxlength' => true]); ?>
            <?php echo $form->field($model, 'flickr')->textInput(['maxlength' => true]); ?>
            <?php echo $form->field($model, 'dribbble')->textInput(['maxlength' => true]); ?>
            <?php echo $form->field($model, 'vimeo')->textInput(['maxlength' => true]); ?>
            <?php echo $form->field($model, 'myspace')->textInput(['maxlength' => true]); ?>
            <?php echo $form->field($model, 'google')->textInput(['maxlength' => true]); ?>
            <?php echo $form->field($model, 'youtube')->textInput(['maxlength' => true]); ?>
            <?php echo $form->field($model, 'instagram')->textInput(['maxlength' => true]); ?>
            <?php echo $form->field($model, 'phone')->textInput(['maxlength' => true]); ?>
            <?php echo $form->field($model, 'mobile')->textInput(['maxlength' => true]); ?>
            <?php echo $form->field($model, 'phone2')->textInput(['maxlength' => true]); ?>
            <?php echo $form->field($model, 'mobile2')->textInput(['maxlength' => true]); ?>
            <?php echo $form->field($model, 'skype')->textInput(['maxlength' => true]); ?>
            <?php echo $form->field($model, 'fax')->textInput(['maxlength' => true]); ?>
            <?php echo $form->field($model, 'reklam_phone')->textInput(['maxlength' => true]); ?>
            <?php echo $form->field($model, 'google_map')->textInput(['maxlength' => true]); ?>
            <?php echo $form->field($model, 'slug')->textInput(['maxlength' => true]); ?>

            <?php echo $form->field($model, 'status')->dropDownList(MyFunctions::getStatus()); ?>
            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Əlavə et' : 'Yadda saxla', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

        </div>
    </div>
    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken(); ?>" />
    <?php ActiveForm::end(); ?>
</div>