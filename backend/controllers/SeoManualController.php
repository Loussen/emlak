<?php

namespace backend\controllers;

use backend\models\SeoManualInner;
use backend\models\ImageUpload;
use Yii;
use backend\models\SeoManual;
use backend\models\SeoManualSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\behaviors\SortableController;
use backend\behaviors\StatusController;
use yii\web\UploadedFile;
use backend\components\MyFunctions;
use frontend\components\MyController;

class SeoManualController extends MyController
{
    public $modelName='backend\models\SeoManual';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new SeoManualSearch();
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
        $model = new SeoManual();

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
		$inner=SeoManualInner::find()->where(['parent_id'=>$id])->asArray()->all();
		foreach($inner as $row){
			SeoManualInner::findOne($row["id"])->delete();
		}
		$info->delete();
		Yii::$app->session->setFlash('success','Məlumat silindi');
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