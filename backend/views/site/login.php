<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\components\MyFunctions;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Login';
?>


<!-- Login page -->
<div class="login-page">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs nav-justified">
        <li class="active"><a href="#login" data-toggle="tab" class="br-lblue"><i class="fa fa-sign-in"></i> <?= Html::encode($this->title) ?></a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade active in" id="login">

            <form action="" method="post">
			<?php
			if($error=="not_login") echo '<div class="alert alert-danger">Loqin və ya şifrə düzgün daxil edilməyib.</div>';
			elseif($error=="code") echo '<div class="alert alert-danger">Kodu düzgün daxil edin.</div>';
			?>
				<div class="form-group field-loginform-username required has-error">
					<label class="control-label" for="loginform-username">Username</label>
					<input type="text" id="loginform-username" class="form-control" name="username">
				</div>
				<div class="form-group field-loginform-username required has-error">
					<label class="control-label" for="loginform-username">Password</label>
					<input type="password" id="loginform-username" class="form-control" name="password">
				</div>
				
				<div class="form-group field-loginform-username required has-error">

						<img src="<?=Yii::$app->homeUrl.'/site/captcha';?>?sid=<?php echo md5(uniqid(time())); ?>" width="120" height="30" align="absmiddle" id="image" style="float:left;" />
						<a href="#" onClick="document.getElementById('image').src = '<?=Yii::$app->homeUrl;?>/captcha/securimage_show.php?sid=' + Math.random(); return false">Yenilə</a>

					<input type="text" id="loginform-username" class="form-control" style="width:40%;float:right;" placeholder="Code" name="code">
				</div>
				
<div style="both:clear;">&nbsp;</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary" name="login-button">Login</button>
				</div>
				<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken(); ?>" />
            </form>
			
        </div>
    </div>
</div>


