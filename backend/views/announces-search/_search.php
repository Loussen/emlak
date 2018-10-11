<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AnnouncesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="announces-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'mobile') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'cover') ?>

    <?php // echo $form->field($model, 'room_count') ?>

    <?php // echo $form->field($model, 'rent_type') ?>

    <?php // echo $form->field($model, 'property_type') ?>

    <?php // echo $form->field($model, 'announce_type') ?>

    <?php // echo $form->field($model, 'country') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'region') ?>

    <?php // echo $form->field($model, 'settlement') ?>

    <?php // echo $form->field($model, 'metro') ?>

    <?php // echo $form->field($model, 'mark') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'google_map') ?>

    <?php // echo $form->field($model, 'floor_count') ?>

    <?php // echo $form->field($model, 'current_floor') ?>

    <?php // echo $form->field($model, 'space') ?>

    <?php // echo $form->field($model, 'repair') ?>

    <?php // echo $form->field($model, 'document') ?>

    <?php // echo $form->field($model, 'text') ?>

    <?php // echo $form->field($model, 'view_count') ?>

    <?php // echo $form->field($model, 'announcer') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'insert_type') ?>

    <?php // echo $form->field($model, 'urgently') ?>

    <?php // echo $form->field($model, 'sort_search') ?>

    <?php // echo $form->field($model, 'sort_foward') ?>

    <?php // echo $form->field($model, 'sort_package') ?>

    <?php // echo $form->field($model, 'sort_premium') ?>

    <?php // echo $form->field($model, 'announce_date') ?>

    <?php // echo $form->field($model, 'visitors_count') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
