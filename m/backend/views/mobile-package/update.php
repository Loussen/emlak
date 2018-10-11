<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Categories */

$this->title = $model::$titleName.' - Düzəliş et';
?>
<div class="categories-update">

    <div class="single-head">
        <h3 class="pull-left"><i class="fa fa-bars green"></i> <?= Html::encode($this->title); ?></h3>
        <div class="clearfix"></div>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
