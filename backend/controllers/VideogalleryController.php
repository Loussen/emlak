<?php

namespace backend\controllers;

use backend\models\VideogalleryInner;
use backend\models\ImageUpload;
use Yii;
use backend\models\Videogallery;
use backend\models\VideogallerySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\behaviors\SortableController;
use backend\behaviors\StatusController;
use yii\web\UploadedFile;
use backend\components\MyFunctions;
use frontend\components\MyController;

class VideogalleryController extends MyController
{
    public $modelName='backend\models\Videogallery';

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

    public function actionIndex()
    {
        $searchModel = new VideogallerySearch();
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
        $model = new Videogallery();

        if ($model->load(Yii::$app->request->post())) {
            if($model->save())
            {
                $tmp = UploadedFile::getInstance($model, 'image');
                if ($tmp != null) {
                    $saveParth='videogallery/'.date("Y-m").'/'.$model->id;
                    $imageName=MyFunctions::fileNameGenerator($model->slug).'-'.uniqid(rand(1,99)).'.'.$tmp->extension;
                    $thumbName=MyFunctions::fileNameGenerator($model->slug).'-'.uniqid(rand(1,99)).'.'.$tmp->extension;

                    $imageUpload=new ImageUpload();
                    $saved=$imageUpload->save($tmp,$saveParth,$imageName);
                    if($saved)
                    {
                        $imageUpload->maxSize($saveParth.'/'.$imageName,Videogallery::MAX_IMAGE_WIDTH,Videogallery::MAX_IMAGE_HEIGHT);
                        $imageUpload->thumbExport($saveParth.'/'.$imageName,$saveParth.'/thumb/',$thumbName,Videogallery::THUMB_IMAGE_WIDTH,Videogallery::THUMB_IMAGE_HEIGHT);

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
        $oldImage=$model->image; if($oldImage!='' && !is_file(MyFunctions::getImagePath().'/'.$oldImage)) $model->image='';
        $oldThumb=$model->thumb; if($oldThumb!='' && !is_file(MyFunctions::getImagePath().'/'.$oldThumb)) $model->thumb='';
        if ($model->load(Yii::$app->request->post())) {
            $model->image=$oldImage;
            if($oldImage!='' && !is_file(MyFunctions::getImagePath().'/'.$oldImage)) $model->image='';
            if($oldThumb!='' && !is_file(MyFunctions::getImagePath().'/'.$oldThumb)) $model->thumb='';
            if($model->save()) {
                $tmp = UploadedFile::getInstance($model, 'image');
                if ($tmp != null) {
                    $saveParth='videogallery/'.date("Y-m").'/'.$model->id;
                    $imageName=MyFunctions::fileNameGenerator($model->slug).'-'.uniqid(rand(1,99)).'.'.$tmp->extension;
                    $thumbName=MyFunctions::fileNameGenerator($model->slug).'-'.uniqid(rand(1,99)).'.'.$tmp->extension;

                    $imageUpload=new ImageUpload();
                    $saved=$imageUpload->save($tmp,$saveParth,$imageName);
                    if($saved)
                    {
                        $imageUpload->deleteOldImages([$oldImage,$oldThumb]);
                        $imageUpload->maxSize($saveParth.'/'.$imageName,Videogallery::MAX_IMAGE_WIDTH,Videogallery::MAX_IMAGE_HEIGHT);
                        $imageUpload->thumbExport($saveParth.'/'.$imageName,$saveParth.'/thumb/',$thumbName,Videogallery::THUMB_IMAGE_WIDTH,Videogallery::THUMB_IMAGE_HEIGHT);

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
            $inner=VideogalleryInner::find()->where(['parent_id'=>$id])->asArray()->all();
            $imageUpload=new ImageUpload();
            foreach($inner as $row)
            {
                $imageUpload->deleteOldImages([$row["image"],$row["thumb"]]);
                VideogalleryInner::findOne($row["id"])->delete();
            }
            $imageUpload->deleteOldImages([$info->image,$info->thumb]);

            if(is_dir(MyFunctions::getImagePath().'/videogallery/'.date("Y-m",$info->create_time).'/'.$id.'/thumb')) rmdir(MyFunctions::getImagePath().'/videogallery/'.date("Y-m",$info->create_time).'/'.$id.'/thumb');
            if(is_dir(MyFunctions::getImagePath().'/videogallery/'.date("Y-m",$info->create_time).'/'.$id)) rmdir(MyFunctions::getImagePath().'/videogallery/'.date("Y-m",$info->create_time).'/'.$id);
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
