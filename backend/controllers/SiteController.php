<?php
namespace backend\controllers;

use common\models\User;
use Yii;
use yii\helpers\Url;
use frontend\components\MyController;
use backend\components\Securimage;

class SiteController extends MyController
{

    public $layout = 'auth';
	
	public function actionCaptcha(){
		$img = new Securimage();
		return $img->show();
	}
	
	public function actionIndex(){
		$ses_ps=self::safe(Yii::$app->session['logged_admin_password']);
		if(count($this->adminLoggedInfo)>0 && $ses_ps==md5(md5($this->adminLoggedInfo[0]["ps"]).date('d.m.Y'))){
			return $this->redirect(Url::to(['announces/index']));
			exit(); die();
		}
		else return $this->redirect(Url::to(['site/login']));
	}

    public function actionLogin(){
		$ses_ps=self::safe(Yii::$app->session['logged_admin_password']);
		
		if(count($this->adminLoggedInfo)>0 && $ses_ps==md5(md5($this->adminLoggedInfo[0]["ps"]).date('d.m.Y'))){
			return $this->redirect(Url::to(['announces/index']));
			exit(); die();
		}

		$error='';
        if (Yii::$app->request->post()){
			$img = new Securimage();
			@$valid = $img->check(Yii::$app->request->post('code'));
			if($valid == true){
				$username=MyController::safe(Yii::$app->request->post('username'));
				$password=md5(md5(MyController::safe(Yii::$app->request->post('password'))));
				
				$find=User::find()->where(['username'=>$username,'ps'=>$password])->one();
				if(!empty($find)){
					Yii::$app->session['logged_admin_password']=md5(md5($password).date("d.m.Y"));
					Yii::$app->session['logged_admin_id']=$find->id;
					return $this->redirect(Url::to(['announces/index']));
				}
				else $error="not_login";
			}
			else $error="code";
        }
		
		return $this->render('login',[
			'error'=>$error
		]
		);
        
    }

    public function actionLogout()
    {
        Yii::$app->session['logged_admin_password']='';
        Yii::$app->session['logged_admin_id']=0;
        return $this->redirect(Url::to(['site/login']));
    }
	
	public function actionError(){
		return $this->redirect(Url::to(['site/login']));
	}
}
