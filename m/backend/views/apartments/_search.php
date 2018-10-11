<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ApartmentsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="apartments-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'album_id') ?>

    <?= $form->field($model, 'title_az') ?>

    <?= $form->field($model, 'title_en') ?>

    <?= $form->field($model, 'title_ru') ?>

    <?php // echo $form->field($model, 'title_tr') ?>

    <?php // echo $form->field($model, 'short_text_az') ?>

    <?php // echo $form->field($model, 'short_text_en') ?>

    <?php // echo $form->field($model, 'short_text_ru') ?>

    <?php // echo $form->field($model, 'short_text_tr') ?>

    <?php // echo $form->field($model, 'about_project_az') ?>

    <?php // echo $form->field($model, 'about_project_en') ?>

    <?php // echo $form->field($model, 'about_project_ru') ?>

    <?php // echo $form->field($model, 'about_project_tr') ?>

    <?php // echo $form->field($model, 'about_company_az') ?>

    <?php // echo $form->field($model, 'about_company_en') ?>

    <?php // echo $form->field($model, 'about_company_ru') ?>

    <?php // echo $form->field($model, 'about_company_tr') ?>

    <?php // echo $form->field($model, 'google_map') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'mobile') ?>

    <?php // echo $form->field($model, 'image') ?>

    <?php // echo $form->field($model, 'thumb') ?>

    <?php // echo $form->field($model, 'slug') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
