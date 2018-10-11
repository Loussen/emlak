<?php

namespace backend\controllers;

use backend\models\SlidersInner;
use backend\models\SlidersInnerSearch;
use backend\models\ImageUpload;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\behaviors\StatusController;
use yii\web\UploadedFile;
use backend\components\MyFunctions;
use frontend\components\MyController;
use backend\models\Sliders;


class SlidersInnerController extends MyController
{
    public $modelName='backend\models\SlidersInner';

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

    public function actionIndex($id=0,$table_name='',$table_id=0)
    {
        $parent_info = Sliders::findOne($id);

        if(empty($parent_info))
        {
            if($table_name!='' && $table_id>0 && array_key_exists($table_name,Yii::$app->params["tableTemplates"]))
            {
                //$post_info=Posts::findOne($table_id);

                $auto_save=new Sliders();
                $auto_save->table_name=$table_name;
                $auto_save->table_id=$table_id;
                $auto_save->status=1;
                $auto_save->position=0;
                $auto_save->slug='';
                $auto_save->save(false);
                $id=$auto_save->id;
                $parent_info = Sliders::findOne($id);
            }
            else return $this->redirect(['sliders/index']);
        }

        $searchModel = new SlidersInnerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$id);

        $tmps = UploadedFile::getInstances($searchModel,'image');
        if ($tmps != null)
        {
            $imageUpload=new ImageUpload();
            foreach($tmps as $tmp)
            {
                $saveParth='sliders/'.date("Y-m").'/'.$parent_info->id;
                $title='title_'.Yii::$app->params["defaultLanguage"];
                $imageName=MyFunctions::fileNameGenerator(MyFunctions::slugGenerator($parent_info->$title)).'-'.uniqid(rand(1,99)).'.'.$tmp->extension;
                $thumbName=MyFunctions::fileNameGenerator(MyFunctions::slugGenerator($parent_info->$title)).'-'.uniqid(rand(1,99)).'.'.$tmp->extension;


                $saved=$imageUpload->save($tmp,$saveParth,$imageName);
                if($saved)
                {
                    $imageUpload->maxSize($saveParth.'/'.$imageName,SlidersInner::MAX_IMAGE_WIDTH,SlidersInner::MAX_IMAGE_HEIGHT);
                    $imageUpload->thumbExport($saveParth.'/'.$imageName,$saveParth.'/thumb/',$thumbName,SlidersInner::THUMB_IMAGE_WIDTH,SlidersInner::THUMB_IMAGE_HEIGHT);

                    $new_save=new SlidersInner();
                    $new_save->parent_id=$parent_info->id;
                    $new_save->image=$saveParth.'/'.$imageName;
                    $new_save->thumb=$saveParth.'/thumb/'.$thumbName;
                    $new_save->status=1;
                    $new_save->save(false);
                }
            }
            Yii::$app->session->setFlash('success','Məlumatlar uğurla yadda saxlanıldı');
            return $this->redirect(['index', 'id' => $parent_info->id]);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelName' => $this->modelName,
            'parent_info' => $parent_info,
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
        $model = new SlidersInner();
        $parent_info=Sliders::findOne($id);
        if ($model->load(Yii::$app->request->post())) {
            $tmp = UploadedFile::getInstance($model, 'image');
            if ($tmp != null) {
                $model->parent_id=$parent_info->id;
                if($model->save())
                {
                    $saveParth='sliders/'.date("Y-m").'/'.$parent_info->id;
                    $title='title_'.Yii::$app->params["defaultLanguage"];
                    $imageName=MyFunctions::fileNameGenerator(MyFunctions::slugGenerator($parent_info->$title)).'-'.uniqid(rand(1,99)).'.'.$tmp->extension;
                    $thumbName=MyFunctions::fileNameGenerator(MyFunctions::slugGenerator($parent_info->$title)).'-'.uniqid(rand(1,99)).'.'.$tmp->extension;

                    $imageUpload=new ImageUpload();
                    $saved=$imageUpload->save($tmp,$saveParth,$imageName);
                    if($saved)
                    {
                        $imageUpload->maxSize($saveParth.'/'.$imageName,SlidersInner::MAX_IMAGE_WIDTH,SlidersInner::MAX_IMAGE_HEIGHT);
                        $imageUpload->thumbExport($saveParth.'/'.$imageName,$saveParth.'/thumb/',$thumbName,SlidersInner::THUMB_IMAGE_WIDTH,SlidersInner::THUMB_IMAGE_HEIGHT);

                        $model->image=$saveParth.'/'.$imageName;
                        $model->thumb=$saveParth.'/thumb/'.$thumbName;
                        $model->status=1;
                        $model->save(false);

                    }
                    Yii::$app->session->setFlash('success','Məlumatlar uğurla yadda saxlanıldı');
                    return $this->redirect(['view', 'id' => $model->id]);
                }
                else Yii::$app->session->setFlash('error','Səhvlik var. Zəhmət olmasa yenidən cəhd edin.');
            }
            else Yii::$app->session->setFlash('error','Şəkil seçilməyib.');
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $parent_info=Sliders::findOne($model->parent_id);
        $oldImage=$model->image; if($oldImage!='' && !is_file(MyFunctions::getImagePath().'/'.$oldImage)) $model->image='';
        $oldThumb=$model->thumb; if($oldThumb!='' && !is_file(MyFunctions::getImagePath().'/'.$oldThumb)) $model->thumb='';
        if ($model->load(Yii::$app->request->post())) {
            $model->image=$oldImage;
            if($oldImage!='' && !is_file(MyFunctions::getImagePath().'/'.$oldImage)) $model->image='';
            if($oldThumb!='' && !is_file(MyFunctions::getImagePath().'/'.$oldThumb)) $model->thumb='';
            if($model->save()) {
                $tmp = UploadedFile::getInstance($model, 'image');
                if ($tmp != null) {
                    $saveParth='sliders/'.date("Y-m").'/'.$parent_info->id;
                    $title='title_'.Yii::$app->params["defaultLanguage"];
                    $imageName=MyFunctions::fileNameGenerator(MyFunctions::slugGenerator($parent_info->$title)).'-'.uniqid(rand(1,99)).'.'.$tmp->extension;
                    $thumbName=MyFunctions::fileNameGenerator(MyFunctions::slugGenerator($parent_info->$title)).'-'.uniqid(rand(1,99)).'.'.$tmp->extension;

                    $imageUpload=new ImageUpload();
                    $saved=$imageUpload->save($tmp,$saveParth,$imageName);
                    if($saved)
                    {
                        $imageUpload->deleteOldImages([$oldImage,$oldThumb]);
                        $imageUpload->maxSize($saveParth.'/'.$imageName,SlidersInner::MAX_IMAGE_WIDTH,SlidersInner::MAX_IMAGE_HEIGHT);
                        $imageUpload->thumbExport($saveParth.'/'.$imageName,$saveParth.'/thumb/',$thumbName,SlidersInner::THUMB_IMAGE_WIDTH,SlidersInner::THUMB_IMAGE_HEIGHT);


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
        $imageUpload=new ImageUpload();
        $imageUpload->deleteOldImages([$info->image,$info->thumb]);
        $parent_id=$info->parent_id;
        $info->delete();
        Yii::$app->session->setFlash('success','Məlumat silindi');
        return $this->redirect(['index','id'=>$parent_id]);
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
