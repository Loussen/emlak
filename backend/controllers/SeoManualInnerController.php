<?php

namespace backend\controllers;

use backend\models\SeoManualInner;
use backend\models\SeoManualInnerSearch;
use backend\models\ImageUpload;
use backend\models\Posts;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\behaviors\SortableController;
use backend\behaviors\StatusController;
use yii\web\UploadedFile;
use backend\components\MyFunctions;
use backend\models\SeoManual;
use frontend\components\MyController;

/**
 * SeoManualController implements the CRUD actions for SeoManual model.
 */
class SeoManualInnerController extends MyController
{
    public $modelName='backend\models\SeoManualInner';

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
                'class' => SortableController::className(),
                'model' => $this->modelName,
            ],
            [
                'class' => StatusController::className(),
                'model' => $this->modelName,
            ],
        ];
    }

    public function actionIndex($id=0) //$id=0
    {
        /*
		$parent_info = SeoManual::findOne($id);

        if(empty($parent_info)){
            return $this->redirect(['seo-manual/index']);
        }
		*/
        $searchModel = new SeoManualInnerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelName' => $this->modelName,
            //'parent_info' => $parent_info,
            'id' => $id,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate($id)
    {
        /*
		$model = new SeoManualInner();
        $parent_info=SeoManual::findOne($id);
        if ($model->load(Yii::$app->request->post())) {
			$model->parent_id=$parent_info->id;
			$model->link_=MyFunctions::slugGenerator($model->title_,'-',false);
			if($model->save())
            {
                Yii::$app->session->setFlash('success','Məlumatlar uğurla yadda saxlanıldı');
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else Yii::$app->session->setFlash('error','Səhvlik var. Zəhmət olmasa yenidən cəhd edin.');
        }
		*/
		$model = new SeoManualInner();
        //$parent_info=SeoManual::findOne($id);
        if ($model->load(Yii::$app->request->post())) {
			$exp=explode("
",$model->title_);
			foreach($exp as $title){
				if($title!=''){
					$title=trim($title);
					$lnk=MyFunctions::slugGenerator($title,'-',false);
					$chck=Yii::$app->db->createCommand("select count(id) from seo_manual_inner where link_='$lnk' ")->queryScalar();
					if($chck==0){
						$save=new SeoManualInner();
						$save->parent_id=0;
						$save->link_=MyFunctions::slugGenerator($title,'-',false);
						$save->title_=$title;
						$save->description_=$title;
						$save->keywords_=$title;
						$save->page_title=$title;
						$save->status=$model->status;
						$save->save();
					}
				}
			}
			Yii::$app->session->setFlash('success','Məlumatlar uğurla yadda saxlanıldı');
            return $this->redirect(['index']);
        }
		
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        //$parent_info=SeoManual::findOne($model->parent_id);

        if ($model->load(Yii::$app->request->post())) {
			//$model->parent_id=$parent_info->id;
			$model->link_=MyFunctions::slugGenerator($model->title_,'-',false);
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

    public function actionDeletemore($id)
    {
        $parent_id=$id;
        $ids=Yii::$app->request->post('check');
        if(!empty($ids))
        {
            foreach ($ids as $id) {
                $this->actionDelete($id);
            }
            Yii::$app->session->setFlash('success','Məlumatlar silindi');
        }
        else Yii::$app->session->setFlash('error','Hec bir secim edilməyib.');
        return $this->redirect(['index','id'=>$parent_id]);

    }

    public function actionDelete($id)
    {
        $info=$this->findModel($id);
        $parent_id=$info->parent_id;
        $info->delete();
        Yii::$app->session->setFlash('success','Məlumat silindi');
        return $this->redirect(['index','id'=>$parent_id]);
    }

    public function actionUp($id){
        $modelName=$this->modelName;
        $condition = [];
        if($modelName::$sortableConditionStatus){
            $condition = [$modelName::$sortableConditionField];
        }
        $return=$this->move($id,'up',$condition);
        $info=$this->findModel($id);
        return $this->redirect(['index','id'=>$info->parent_id]);
    }

    public function actionDown($id){
        $modelName=$this->modelName;
        $condition = [];
        if($modelName::$sortableConditionStatus){
            $condition = [$modelName::$sortableConditionField];
        }
        $this->move($id,'down',$condition);
        $info=$this->findModel($id);
        return $this->redirect(['index','id'=>$info->parent_id]);
    }

    public function actionStatus($id){
        $this->changeStatus($id,'1');
        $info=$this->findModel($id);
        return $this->redirect(['index','id'=>$info->parent_id]);
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
