<?php

namespace backend\controllers;

use backend\models\SlidersInner;
use backend\models\ImageUpload;
use Yii;
use backend\models\Sliders;
use backend\models\SlidersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\behaviors\StatusController;
use backend\components\MyFunctions;
use frontend\components\MyController;


class SlidersController extends MyController
{
    public $modelName='backend\models\Sliders';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            [
                'class' => StatusController::className(),
                'model' => $this->modelName,
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new SlidersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelName' => $this->modelName,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Sliders();

        if ($model->load(Yii::$app->request->post())) {
            if($model->save())
            {
                Yii::$app->session->setFlash('success','Məlumatlar uğurla yadda saxlanıldı');
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else Yii::$app->session->setFlash('error','Səhvlik var. Zəhmət olmasa yenidən cəhd edin.');
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            if($model->save()) {
                Yii::$app->session->setFlash('success','Məlumatlar uğurla yadda saxlanıldı');
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else Yii::$app->session->setFlash('error','Səhvlik var. Zəhmət olmasa yenidən cəhd edin.');
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDeletemore()
    {
        $ids=Yii::$app->request->post('check');
        if(!empty($ids))
        {
            foreach ($ids as $id) {
                $this->actionDelete($id);
            }
            Yii::$app->session->setFlash('success','Məlumatlar silindi');
            Yii::$app->session->removeFlash('error');
        }
        else Yii::$app->session->setFlash('error','Hec bir secim edilməyib.');
        return $this->redirect(['index']);

    }

    public function actionDelete($id)
    {
        $info=$this->findModel($id);
        if($info->save_mode==0)
        {
            $inner=SlidersInner::find()->where(['parent_id'=>$id])->asArray()->all();
            $imageUpload=new ImageUpload();
            foreach($inner as $row)
            {
                $imageUpload->deleteOldImages([$row["image"],$row["thumb"]]);
                SlidersInner::findOne($row["id"])->delete();
            }

            if(is_dir(MyFunctions::getImagePath().'/sliders/'.date("Y-m",$info->create_time).'/'.$id.'/thumb')) rmdir(MyFunctions::getImagePath().'/sliders/'.date("Y-m",$info->create_time).'/'.$id.'/thumb');
            if(is_dir(MyFunctions::getImagePath().'/sliders/'.date("Y-m",$info->create_time).'/'.$id)) rmdir(MyFunctions::getImagePath().'/sliders/'.date("Y-m",$info->create_time).'/'.$id);
            $info->delete();
            Yii::$app->session->setFlash('success','Məlumat silindi');
        } else Yii::$app->session->setFlash('error','Bu məlumatı silməyə icazə yoxdur');
        return $this->redirect(['index']);
    }

    public function actionUp($id){
        $modelName=$this->modelName;
        $condition = [];
        if($modelName::$sortableConditionStatus){
            $condition = [$modelName::$sortableConditionField];
        }
        $return=$this->move($id,'up',$condition);
        return $this->redirect(['index']);
    }

    public function actionDown($id){
        $modelName=$this->modelName;
        $condition = [];
        if($modelName::$sortableConditionStatus){
            $condition = [$modelName::$sortableConditionField];
        }
        $this->move($id,'down',$condition);
        return $this->redirect(['index']);
    }

    public function actionStatus($id){
        $this->changeStatus($id,'1');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        $modelName=$this->modelName;
        if (($model = $modelName::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actions() {
        return [ 'Kupload' => [ 'class' => 'pjkui\kindeditor\KindEditorAction', ] ];
    }
}
