<?php

namespace backend\controllers;

use Yii;
use backend\models\Services;
use backend\models\ServicesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\behaviors\StatusController;
use backend\behaviors\SortableController;
use backend\models\ImageUpload;
use backend\components\MyFunctions;
use yii\web\UploadedFile;
use frontend\components\MyController;

/**
 * ServicesController implements the CRUD actions for Services model.
 */
class ServicesController extends MyController
{
    public $modelName='backend\models\Services';
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
            [
                'class' => SortableController::className(),
                'model' => $this->modelName,
            ],
        ];
    }

    /**
     * Lists all Services models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ServicesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Services model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Services model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Services();

        if ($model->load(Yii::$app->request->post()) ) {
            if($model->save())
            {
                $tmp = UploadedFile::getInstance($model, 'image');
                if ($tmp != null) {
                    $saveParth='services/'.date("Y-m");
                    $imageName=MyFunctions::fileNameGenerator($model->slug).'-'.uniqid(rand(1,99)).'.'.$tmp->extension;
                    $thumbName=MyFunctions::fileNameGenerator($model->slug).'-'.uniqid(rand(1,99)).'.'.$tmp->extension;

                    $imageUpload=new ImageUpload();
                    $saved=$imageUpload->save($tmp,$saveParth,$imageName);
                    if($saved)
                    {
                        $imageUpload->maxSize($saveParth.'/'.$imageName,Services::MAX_IMAGE_WIDTH,Services::MAX_IMAGE_HEIGHT);
                        $imageUpload->thumbExport($saveParth.'/'.$imageName,$saveParth.'/thumb/',$thumbName,Services::THUMB_IMAGE_WIDTH,Services::THUMB_IMAGE_HEIGHT);

                        $model->image=$saveParth.'/'.$imageName;
                        $model->thumb=$saveParth.'/thumb/'.$thumbName;
                        $model->save(false);
                    }
                }
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
        $oldImage=$model->image;    if($oldImage!='' && !is_file(MyFunctions::getImagePath().'/'.$oldImage)) $model->image='';
        $oldThumb=$model->thumb;    if($oldThumb!='' && !is_file(MyFunctions::getImagePath().'/'.$oldThumb)) $model->thumb='';
        if ($model->load(Yii::$app->request->post())) {
            $model->image=$oldImage;
            if($oldImage!='' && !is_file(MyFunctions::getImagePath().'/'.$oldImage)) $model->image='';
            if($oldThumb!='' && !is_file(MyFunctions::getImagePath().'/'.$oldThumb)) $model->thumb='';
            if($model->save()) {
                $tmp = UploadedFile::getInstance($model, 'image');
                if ($tmp != null) {
                    $saveParth='services/'.date("Y-m");
                    $imageName=MyFunctions::fileNameGenerator($model->slug).'-'.uniqid(rand(1,99)).'.'.$tmp->extension;
                    $thumbName=MyFunctions::fileNameGenerator($model->slug).'-'.uniqid(rand(1,99)).'.'.$tmp->extension;

                    $imageUpload=new ImageUpload();
                    $saved=$imageUpload->save($tmp,$saveParth,$imageName);
                    if($saved)
                    {
                        $imageUpload->deleteOldImages([$oldImage,$oldThumb]);
                        $imageUpload->maxSize($saveParth.'/'.$imageName,Services::MAX_IMAGE_WIDTH,Services::MAX_IMAGE_HEIGHT);
                        $imageUpload->thumbExport($saveParth.'/'.$imageName,$saveParth.'/thumb/',$thumbName,Services::THUMB_IMAGE_WIDTH,Services::THUMB_IMAGE_HEIGHT);

                        $model->image=$saveParth.'/'.$imageName;
                        $model->thumb=$saveParth.'/thumb/'.$thumbName;
                        $model->save(false);
                    }
                }
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
        }
        else Yii::$app->session->setFlash('error','Hec bir secim edilməyib.');
        return $this->redirect(['index']);

    }

    public function actionDelete($id)
    {
        $find=$this->findModel($id);
        $image=$find->image; $thumb=$find->thumb;
        if($find->delete())
        {
            if(is_file(MyFunctions::getImagePath().'/'.$image)) unlink(MyFunctions::getImagePath().'/'.$image);
            if(is_file(MyFunctions::getImagePath().'/'.$thumb)) unlink(MyFunctions::getImagePath().'/'.$thumb);
        }
        Yii::$app->session->setFlash('success','Məlumat silindi');
        return $this->redirect(['index']);
    }

    public function actionUp($id){
        $modelName=$this->modelName;
        $condition = [];
        if($modelName::$sortableConditionStatus){
            $condition = [$modelName::$sortableConditionField];
        }
        $this->move($id,'up',$condition);
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

    /**
     * Finds the Services model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Services the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Services::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actions() {
        return [ 'Kupload' => [ 'class' => 'pjkui\kindeditor\KindEditorAction', ] ];
    }
}
