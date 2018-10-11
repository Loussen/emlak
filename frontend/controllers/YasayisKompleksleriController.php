<?php
namespace frontend\controllers;

use backend\models\AlbumsInner;
use backend\models\Apartments;
use frontend\components\MyController;
use frontend\components\MyFunctionsF;
use Yii;

class YasayisKompleksleriController extends MyController
{

    public function actionIndex()
    {
        $kompleksler=Apartments::find()->where(['status'=>1])->orderBy('position desc')->asArray()->all();

        return $this->render('index',[
            'kompleksler'=>$kompleksler,
        ]);
    }

    public function actionView($id)
    {
        $info=Apartments::findOne($id);
		$info->view_count=$info->view_count+1;
		$info->save();
		
        $images=AlbumsInner::find()->where(['parent_id'=>$info->album_id,'status'=>1])->orderBy('position')->asArray()->all();
        $images2=AlbumsInner::find()->where(['parent_id'=>$info->album_id2,'status'=>1])->orderBy('position')->asArray()->all();
		
		$title=$info["title_".Yii::$app->language];
		$desc=strip_tags($info["about_project_".Yii::$app->language]);
		Yii::$app->view->registerMetaTag(['name' => 'description','content' => $desc]);
		Yii::$app->view->registerMetaTag(['name' => 'keywords','content' => $title]);
		Yii::$app->view->registerMetaTag(['name' => 'og:description','content' => $desc]);
		Yii::$app->view->registerMetaTag(['name' => 'og:keywords','content' => $title]);
		Yii::$app->view->registerMetaTag(['name' => 'og:image','content' => $this->siteUrl.'/images/'.$info->image]);

        return $this->render('view',[
            'info'=>$info,
            'images'=>$images,
            'images2'=>$images2,
            'title'=>$title,
        ]);
    }

    public function actionEtrafli_melumat_al(){
        $ad=Yii::$app->request->post('ad');
        $operator=Yii::$app->request->post('operator');
        $telefon=Yii::$app->request->post('telefon');

        if($ad!='' && $telefon!=''){
            return 'ok';
        }
        else return 'error';
    }

    public function actionDostuna_gonder(){
        $email=Yii::$app->request->post('email');
        if(filter_var($email,FILTER_VALIDATE_EMAIL)){
            return 'ok';
        }
        else return 'error';
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
}
