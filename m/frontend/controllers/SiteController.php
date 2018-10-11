<?php
namespace frontend\controllers;

use backend\models\Announces;
use backend\models\AnnouncesArchive2015;
use frontend\components\MyController;
use frontend\components\MyFunctionsF;
use Yii;
use common\models\LoginForm;
use yii\helpers\Url;

/**
 * Site controller
 */
class SiteController extends MyController
{
    public function actionRegions_select(){
        if(Yii::$app->request->post()){
            $val=Yii::$app->request->post('val'); $val=explode("-",$val); $val=array_filter($val);
            $return='';
            $imported=[];
            foreach($val as $row){
                if(isset($this->regions[$row]) && !in_array($row,$imported) ){
                    $return.='<li><a data-id="'.$row.'" href="javascript:void(0);" class="remove ryn"></a>'.$this->regions[$row].'</li>';
                    $imported[]=$row;
                }
            }
            return $return;
        }
    }
    public function actionMetros_select(){
        if(Yii::$app->request->post()){
            $val=Yii::$app->request->post('val'); $val=explode("-",$val); $val=array_filter($val);
            $return='';
            foreach($val as $row){
                if(isset($this->metros[$row])) $return.='<li><a data-id="'.$row.'" href="javascript:void(0);" class="remove mtr"></a>'.$this->metros[$row].'</li>';
            }
            return $return;
        }
    }
    public function actionSettlements_select(){
        if(Yii::$app->request->post()){
            $val=Yii::$app->request->post('val'); $val=explode("-",$val); $val=array_filter($val);
            $return='';
            foreach($val as $row){
                if(isset($this->settlements[$row])) $return.='<li><a data-id="'.$row.'" href="javascript:void(0);" class="remove qsb"></a>'.$this->settlements[$row].'</li>';
            }
            return $return;
        }
    }
    public function actionMarks_select(){
        if(Yii::$app->request->post()){
            $val=Yii::$app->request->post('val'); $val=explode("-",$val); $val=array_filter($val);
            $return='';
            foreach($val as $row){
                if(isset($this->marks[$row])) $return.='<li><a data-id="'.$row.'" href="javascript:void(0);" class="remove nsgh"></a>'.$this->marks[$row].'</li>';
            }
            return $return;
        }
    }

    public function actionIndex($cacheUpdate=1)
    {
		if($cacheUpdate==1) Yii::$app->cache->flush();
		
		$vip1=Yii::$app->db->createCommand("select * from announces where sort_premium>0 and status=1 and announce_type=1 order by rand() limit 50")->queryAll();
		$vip2=Yii::$app->db->createCommand("select * from announces where sort_premium>0 and status=1 and announce_type=2 order by rand() limit 50")->queryAll();
		
        return $this->render('index',[
            'vip1'=>$vip1,
            'vip2'=>$vip2,
        ]);
    }

    public function actionError(){
		return $this->redirect(Url::to(['/']));
        //return $this->render('error');
    }

    public function actionLang($lang){
		if(is_dir(Yii::$app->basePath.'/../common/messages/'.$lang) && !empty($lang) ) { Yii::$app->session["language"]=$lang; Yii::$app->cache->flush(); }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionLogout(){
        Yii::$app->user->logout();
        return $this->goHome();
    }
	
	public function actions(){
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
}
