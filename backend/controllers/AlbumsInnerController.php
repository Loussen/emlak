<?php

namespace backend\controllers;

use backend\models\AlbumsInner;
use backend\models\AlbumsInnerSearch;
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
use backend\models\Albums;
use frontend\components\MyController;

/**
 * AlbumsController implements the CRUD actions for Albums model.
 */
class AlbumsInnerController extends MyController
{
    public $modelName='backend\models\AlbumsInner';

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

    public function actionIndex($id=0,$table_name='',$table_id=0,$field='album_id')
    {
        $parent_info = Albums::findOne($id);

        if(empty($parent_info))
        {
            if($table_name!='' && $table_id>0)
            {
                $tb='backend\models\\'.ucfirst($table_name);
                $post_info=$tb::findOne($table_id);
                $title='title_'.Yii::$app->params["defaultLanguage"];

                $auto_save=new Albums();
                $auto_save->table_name=$table_name;
                $auto_save->table_id=$table_id;
                $auto_save->status=1;
                $auto_save->position=0;
                $auto_save->slug='';
                $auto_save->$title=$post_info->$title;
                $auto_save->save(false);
                $id=$auto_save->id;
                $post_info->$field=$id; $post_info->save(false);
                $parent_info = Albums::findOne($id);
            }
            else return $this->redirect(['albums/index']);
        }

        $searchModel = new AlbumsInnerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$id);

        $tmps = UploadedFile::getInstances($searchModel,'image');
        if ($tmps != null)
        {
            $imageUpload=new ImageUpload();
            foreach($tmps as $tmp)
            {
                $saveParth='albums/'.date("Y-m").'/'.$parent_info->id;
                $imageName=MyFunctions::fileNameGenerator($parent_info->slug).'-'.uniqid(rand(1,99)).'.'.$tmp->extension;
                $thumbName=MyFunctions::fileNameGenerator($parent_info->slug).'-'.uniqid(rand(1,99)).'.'.$tmp->extension;


                $saved=$imageUpload->save($tmp,$saveParth,$imageName);
                if($saved)
                {
                    $imageUpload->maxSize($saveParth.'/'.$imageName,AlbumsInner::MAX_IMAGE_WIDTH,AlbumsInner::MAX_IMAGE_HEIGHT);
                    $imageUpload->thumbExport($saveParth.'/'.$imageName,$saveParth.'/thumb/',$thumbName,AlbumsInner::THUMB_IMAGE_WIDTH,AlbumsInner::THUMB_IMAGE_HEIGHT);

                    $new_save=new AlbumsInner();
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
        $model = new AlbumsInner();
        $parent_info=Albums::findOne($id);
        if ($model->load(Yii::$app->request->post())) {
                $tmp = UploadedFile::getInstance($model, 'image');
                if ($tmp != null) {
                    $saveParth='albums/'.date("Y-m").'/'.$parent_info->id;
                    $imageName=MyFunctions::fileNameGenerator($parent_info->slug).'-'.uniqid(rand(1,99)).'.'.$tmp->extension;
                    $thumbName=MyFunctions::fileNameGenerator($parent_info->slug).'-'.uniqid(rand(1,99)).'.'.$tmp->extension;

                    $imageUpload=new ImageUpload();
                    $saved=$imageUpload->save($tmp,$saveParth,$imageName);
                    if($saved)
                    {
                        $imageUpload->maxSize($saveParth.'/'.$imageName,AlbumsInner::MAX_IMAGE_WIDTH,AlbumsInner::MAX_IMAGE_HEIGHT);
                        $imageUpload->thumbExport($saveParth.'/'.$imageName,$saveParth.'/thumb/',$thumbName,AlbumsInner::THUMB_IMAGE_WIDTH,AlbumsInner::THUMB_IMAGE_HEIGHT);

                        $new_save=new AlbumsInner();
                        $new_save->parent_id=$parent_info->id;
                        $new_save->image=$saveParth.'/'.$imageName;
                        $new_save->thumb=$saveParth.'/thumb/'.$thumbName;
                        $new_save->status=1;
                        $inserted=$new_save->save(false);
                        if($inserted)
                        {
                            Yii::$app->session->setFlash('success','Məlumatlar uğurla yadda saxlanıldı');
                            return $this->redirect(['view', 'id' => $new_save->id]);
                        }
                        else Yii::$app->session->setFlash('error','Səhvlik var. Zəhmət olmasa yenidən cəhd edin.');
                    }

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
        $parent_info=Albums::findOne($model->parent_id);
        $oldImage=$model->image; if($oldImage!='' && !is_file(MyFunctions::getImagePath().'/'.$oldImage)) $model->image='';
        $oldThumb=$model->thumb; if($oldThumb!='' && !is_file(MyFunctions::getImagePath().'/'.$oldThumb)) $model->thumb='';
        if ($model->load(Yii::$app->request->post())) {
            $model->image=$oldImage;
            if($oldImage!='' && !is_file(MyFunctions::getImagePath().'/'.$oldImage)) $model->image='';
            if($oldThumb!='' && !is_file(MyFunctions::getImagePath().'/'.$oldThumb)) $model->thumb='';
            if($model->save()) {
                $tmp = UploadedFile::getInstance($model, 'image');
                if ($tmp != null) {
                    $saveParth='albums/'.date("Y-m").'/'.$parent_info->id;
                    $imageName=MyFunctions::fileNameGenerator($parent_info->slug).'-'.uniqid(rand(1,99)).'.'.$tmp->extension;
                    $thumbName=MyFunctions::fileNameGenerator($parent_info->slug).'-'.uniqid(rand(1,99)).'.'.$tmp->extension;

                    $imageUpload=new ImageUpload();
                    $saved=$imageUpload->save($tmp,$saveParth,$imageName);
                    if($saved)
                    {
                        $imageUpload->deleteOldImages([$oldImage,$oldThumb]);
                        $imageUpload->maxSize($saveParth.'/'.$imageName,AlbumsInner::MAX_IMAGE_WIDTH,AlbumsInner::MAX_IMAGE_HEIGHT);
                        $imageUpload->thumbExport($saveParth.'/'.$imageName,$saveParth.'/thumb/',$thumbName,AlbumsInner::THUMB_IMAGE_WIDTH,AlbumsInner::THUMB_IMAGE_HEIGHT);


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
