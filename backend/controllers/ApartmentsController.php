<?php
namespace backend\controllers;

use backend\components\MyFunctions;
use backend\models\ImageUpload;
use Yii;
use backend\models\Apartments;
use backend\models\ApartmentsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\behaviors\SortableController;
use backend\behaviors\StatusController;
use yii\web\UploadedFile;
use frontend\components\MyController;

class ApartmentsController extends MyController
{
    public $modelName='backend\models\Apartments';
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



    public function actionIndex(){
        $searchModel = new ApartmentsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelName' => $this->modelName,
        ]);
    }

    public function actionView($id){
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate(){
        $model = new Apartments();
        if ($model->load(Yii::$app->request->post()) ) {
            if($model->save()){
                $tmp = UploadedFile::getInstance($model, 'image');
                $tmp2 = UploadedFile::getInstance($model, 'logo');
                if ($tmp != null) {
                    $saveParth='apartments/'.date("Y-m").'/'.$model->id;
                    $imageName=MyFunctions::fileNameGenerator($model->slug).'-'.uniqid(rand(1,99)).'.'.$tmp->extension;
                    $thumbName=MyFunctions::fileNameGenerator($model->slug).'-'.uniqid(rand(1,99)).'.'.$tmp->extension;

                    $imageUpload=new ImageUpload();
                    $saved=$imageUpload->save($tmp,$saveParth,$imageName);
                    if($saved)
                    {
                        $imageUpload->maxSize($saveParth.'/'.$imageName,Apartments::MAX_IMAGE_WIDTH,Apartments::MAX_IMAGE_HEIGHT);
                        $imageUpload->thumbExport($saveParth.'/'.$imageName,$saveParth.'/thumb/',$thumbName,Apartments::THUMB_IMAGE_WIDTH,Apartments::THUMB_IMAGE_HEIGHT);

                        $model->image=$saveParth.'/'.$imageName;
                        $model->thumb=$saveParth.'/thumb/'.$thumbName;
                        $model->save(false);
                    }
                }
                if ($tmp2 != null) {
                    $saveParth='apartments/'.date("Y-m").'/'.$model->id;
                    $imageName=MyFunctions::fileNameGenerator($model->slug).'-'.uniqid(rand(1,99)).'.'.$tmp2->extension;
                    $thumbName=MyFunctions::fileNameGenerator($model->slug).'-'.uniqid(rand(1,99)).'.'.$tmp2->extension;

                    $imageUpload=new ImageUpload();
                    $saved=$imageUpload->save($tmp,$saveParth,$imageName);
                    if($saved)
                    {
                        $imageUpload->maxSize($saveParth.'/'.$imageName,Apartments::MAX_IMAGE_WIDTH,Apartments::MAX_IMAGE_HEIGHT);
                        $model->logo=$saveParth.'/'.$imageName;
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

    public function actionUpdate($id){
        $model = $this->findModel($id);
        $oldImage=$model->image; if($oldImage!='' && !is_file(MyFunctions::getImagePath().'/'.$oldImage)) $model->image='';
        $oldThumb=$model->thumb; if($oldThumb!='' && !is_file(MyFunctions::getImagePath().'/'.$oldThumb)) $model->thumb='';
        $oldLogo=$model->logo; if($oldLogo!='' && !is_file(MyFunctions::getImagePath().'/'.$oldLogo)) $model->logo='';
        if ($model->load(Yii::$app->request->post())) {
            $model->image=$oldImage;
            $model->logo=$oldLogo;
            if($oldImage!='' && !is_file(MyFunctions::getImagePath().'/'.$oldImage)) $model->image='';
            if($oldThumb!='' && !is_file(MyFunctions::getImagePath().'/'.$oldThumb)) $model->thumb='';
            if($model->save()){
                $tmp = UploadedFile::getInstance($model, 'image');
                $tmp2 = UploadedFile::getInstance($model, 'logo');
                if ($tmp != null) {
                    $saveParth='apartments/'.date("Y-m").'/'.$model->id;
                    $imageName=MyFunctions::fileNameGenerator($model->slug).'-'.uniqid(rand(1,99)).'.'.$tmp->extension;
                    $thumbName=MyFunctions::fileNameGenerator($model->slug).'-'.uniqid(rand(1,99)).'.'.$tmp->extension;

                    $imageUpload=new ImageUpload();
                    $saved=$imageUpload->save($tmp,$saveParth,$imageName);
                    if($saved)
                    {
                        $imageUpload->deleteOldImages([$oldImage,$oldThumb]);
                        $imageUpload->maxSize($saveParth.'/'.$imageName,Apartments::MAX_IMAGE_WIDTH,Apartments::MAX_IMAGE_HEIGHT);
                        $imageUpload->thumbExport($saveParth.'/'.$imageName,$saveParth.'/thumb/',$thumbName,Apartments::THUMB_IMAGE_WIDTH,Apartments::THUMB_IMAGE_HEIGHT);

                        $model->image=$saveParth.'/'.$imageName;
                        $model->thumb=$saveParth.'/thumb/'.$thumbName;
                        $model->save(false);
                    }
                }
                if ($tmp2 != null) {
                    $saveParth='apartments/'.date("Y-m").'/'.$model->id;
                    $imageName=MyFunctions::fileNameGenerator($model->slug).'-'.uniqid(rand(1,99)).'.'.$tmp2->extension;
                    $thumbName=MyFunctions::fileNameGenerator($model->slug).'-'.uniqid(rand(1,99)).'.'.$tmp2->extension;

                    $imageUpload=new ImageUpload();
                    $saved=$imageUpload->save($tmp2,$saveParth,$imageName);
                    if($saved)
                    {
                        $imageUpload->deleteOldImages([$oldLogo]);
                        $imageUpload->maxSize($saveParth.'/'.$imageName,Apartments::MAX_IMAGE_WIDTH,Apartments::MAX_IMAGE_HEIGHT);
                        $model->logo=$saveParth.'/'.$imageName;
                        $model->save(false);
                    }
                }
                Yii::$app->session->setFlash('success','Məlumatlar uğurla yadda saxlanıldı');
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else Yii::$app->session->setFlash('error','Səhvlik var. Zəhmət olmasa yenidən cəhd edin.');
        }
        return $this->render('update', [
            'model' => $model
        ]);
    }

    public function actionDeletemore(){
        $ids=Yii::$app->request->post('check');
        if(!empty($ids)){
            foreach ($ids as $id) {
                $this->actionDelete($id);
            }
            Yii::$app->session->setFlash('success','Məlumatlar silindi');
            Yii::$app->session->removeFlash('error');
        }
        else Yii::$app->session->setFlash('error','Hec bir secim edilməyib.');
        return $this->redirect(['index']);

    }

    public function actionDelete($id){
        $find=$this->findModel($id);
        //if($find->save_mode==0){
			/*
            $inner=Apartments::find()->where(['parent_id'=>$id])->asArray()->all();
            foreach($inner as $row){
                Apartments::findOne($row["id"])->delete();
            }
			*/
            $find->delete();
            Yii::$app->session->setFlash('success','Məlumat silindi');
        //} else Yii::$app->session->setFlash('error','Bu məlumatı silməyə icazə yoxdur');
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

    public function findModel($id){
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
?>