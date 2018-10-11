<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Categories */

$this->title = 'Premium elan əlavəsi';
?>
<div class="categories-create">
    <div class="single-head">
        <h3 class="pull-left"><i class="fa fa-bars green"></i> <?= Html::encode($this->title); ?></h3>
        <div class="clearfix"></div>
    </div>
	
	<div class="categories-form">
		<form action="" method="post">
			<div class="ui-element-container">
				<div id="myTabContent" class="tab-content">
					<div class="form-group">
						<label class="control-label" for="packageprices-announce_limit">Kod</label>
						<input type="text" class="form-control" name="id" value="<?php if($id>0) echo $id; ?>" />
					</div>
					<div class="form-group">
						<label class="control-label" for="packageprices-announce_limit">Müddəti daxil edin (gün)</label>
						<input type="text" class="form-control" name="muddet" value="" />
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary">Yadda saxla</button>
					</div>
				</div>
			</div>
		</form>
	</div>
	
</div>