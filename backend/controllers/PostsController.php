<?php

namespace backend\controllers;

use Yii;
use backend\models\Posts;
use backend\components\MyFunctions;
use backend\models\PostsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use backend\behaviors\StatusController;
use backend\models\ImageUpload;
use frontend\components\MyController;

/**
 * PostsController implements the CRUD actions for Posts model.
 */
class PostsController extends MyController
{
    public $modelName='backend\models\Posts';
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
	public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $searchModel = new PostsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
        $model = new Posts();

        if ($model->load(Yii::$app->request->post()) ) {
            if($model->save())
            {
                $tmp = UploadedFile::getInstance($model, 'image');
                if ($tmp != null) {
                    $saveParth='posts/'.date("Y-m");
                    $imageName=MyFunctions::fileNameGenerator($model->slug).'-'.uniqid(rand(1,99)).'.'.$tmp->extension;
                    $thumbName=MyFunctions::fileNameGenerator($model->slug).'-'.uniqid(rand(1,99)).'.'.$tmp->extension;

                    $imageUpload=new ImageUpload();
                    $saved=$imageUpload->save($tmp,$saveParth,$imageName);
                    if($saved)
                    {
                        $imageUpload->maxSize($saveParth.'/'.$imageName,Posts::MAX_IMAGE_WIDTH,Posts::MAX_IMAGE_HEIGHT);
                        $imageUpload->thumbExport($saveParth.'/'.$imageName,$saveParth.'/thumb/',$thumbName,Posts::THUMB_IMAGE_WIDTH,Posts::THUMB_IMAGE_HEIGHT);

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
        if($model->news_time>0) $model->news_time=date("d-m-Y",$model->news_time); else $model->news_time=date("d-m-Y");
        $oldImage=$model->image;    if($oldImage!='' && !is_file(MyFunctions::getImagePath().'/'.$oldImage)) $model->image='';
        $oldThumb=$model->thumb;    if($oldThumb!='' && !is_file(MyFunctions::getImagePath().'/'.$oldThumb)) $model->thumb='';
        if ($model->load(Yii::$app->request->post())) {
            $model->image=$oldImage;
            if($oldImage!='' && !is_file(MyFunctions::getImagePath().'/'.$oldImage)) $model->image='';
            if($oldThumb!='' && !is_file(MyFunctions::getImagePath().'/'.$oldThumb)) $model->thumb='';
            if($model->save()) {
                $tmp = UploadedFile::getInstance($model, 'image');
                if ($tmp != null) {
                    $saveParth='posts/'.date("Y-m");
                    $imageName=MyFunctions::fileNameGenerator($model->slug).'-'.uniqid(rand(1,99)).'.'.$tmp->extension;
                    $thumbName=MyFunctions::fileNameGenerator($model->slug).'-'.uniqid(rand(1,99)).'.'.$tmp->extension;

                    $imageUpload=new ImageUpload();
                    $saved=$imageUpload->save($tmp,$saveParth,$imageName);
                    if($saved)
                    {
                        $imageUpload->deleteOldImages([$oldImage,$oldThumb]);
                        $imageUpload->maxSize($saveParth.'/'.$imageName,Posts::MAX_IMAGE_WIDTH,Posts::MAX_IMAGE_HEIGHT);
                        $imageUpload->thumbExport($saveParth.'/'.$imageName,$saveParth.'/thumb/',$thumbName,Posts::THUMB_IMAGE_WIDTH,Posts::THUMB_IMAGE_HEIGHT);

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

    protected function findModel($id)
    {
        if (($model = Posts::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionStatus($id){
        $this->changeStatus($id,'1');
        return $this->redirect(['index']);
    }

    public function actions() {
        return [ 'Kupload' => [ 'class' => 'pjkui\kindeditor\KindEditorAction', ] ];
    }
}
