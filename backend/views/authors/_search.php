<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AuthorsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="authors-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'about_az') ?>

    <?= $form->field($model, 'about_en') ?>

    <?= $form->field($model, 'about_ru') ?>

    <?php // echo $form->field($model, 'image') ?>

    <?php // echo $form->field($model, 'post_count') ?>

    <?php // echo $form->field($model, 'last_post_time') ?>

    <?php // echo $form->field($model, 'slug') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
