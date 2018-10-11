<?php

namespace backend\controllers;

use Yii;
use backend\models\Users;
use backend\models\ArchiveDb;
use backend\models\UsersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\behaviors\StatusController;
use backend\behaviors\SortableController;
use backend\models\ImageUpload;
use backend\components\MyFunctions;
use yii\web\UploadedFile;
use frontend\components\MyController;


class UsersController extends MyController
{
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
	public $modelName='backend\models\Users';
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
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Users model.
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
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Users();

        if ($model->load(Yii::$app->request->post()) ) {
            $model->mobile=str_replace("
","***",$model->mobile);
            if($model->save())
            {
                $tmp = UploadedFile::getInstance($model, 'image');
                if ($tmp != null) {
                    $saveParth='users/'.date("Y-m");
                    $imageName=MyFunctions::fileNameGenerator($model->name).'-'.uniqid(rand(1,99)).'.'.$tmp->extension;
                    $thumbName=MyFunctions::fileNameGenerator($model->name).'-'.uniqid(rand(1,99)).'.'.$tmp->extension;

                    $imageUpload=new ImageUpload();
                    $saved=$imageUpload->save($tmp,$saveParth,$imageName);
                    if($saved)
                    {
                        $imageUpload->maxSize($saveParth.'/'.$imageName,Users::MAX_IMAGE_WIDTH,Users::MAX_IMAGE_HEIGHT);
                        $imageUpload->thumbExport($saveParth.'/'.$imageName,$saveParth.'/thumb/',$thumbName,Users::THUMB_IMAGE_WIDTH,Users::THUMB_IMAGE_HEIGHT);

                        $model->image=$saveParth.'/'.$imageName;
                        $model->thumb=$saveParth.'/thumb/'.$thumbName;
                        $model->save(false);
                    }
                }
                Yii::$app->session->setFlash('success','Məlumatlar uğurla yadda saxlanıldı');
				$this->getCacheUpdate();
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
		$time=time();
        if($model->mobile!='') $model->mobile=str_replace("***","
",$model->mobile);
		$old_pass=$model->password;
		$old_email=$model->email;
		$old_premium=ceil(($model->premium-time())/86400);	if($old_premium<0) $old_premium=0;
		$old_package_announce=$model->package_announce;
		$old_package_foward=$model->package_foward;
		$old_package_search=$model->package_search;
        $oldImage=$model->image;    if($oldImage!='' && !is_file(MyFunctions::getImagePath().'/'.$oldImage)) $model->image='';
        $oldThumb=$model->thumb;    if($oldThumb!='' && !is_file(MyFunctions::getImagePath().'/'.$oldThumb)) $model->thumb='';
		if($model->premium>0) $model->premium=$old_premium;
        if ($model->load(Yii::$app->request->post())) {
            $model->image=$oldImage;
            $model->email=$old_email;
            $model->mobile=str_replace("
","***",$model->mobile);
if($model->premium>0 && ceil(($model->premium-time())/86400)!=$old_premium) $model->premium=($model->premium*86400)+$time;
            if($oldImage!='' && !is_file(MyFunctions::getImagePath().'/'.$oldImage)) $model->image='';
            if($oldThumb!='' && !is_file(MyFunctions::getImagePath().'/'.$oldThumb)) $model->thumb='';
            $model->newsletter=intval(Yii::$app->request->post('newsletter'));
			if($model->password!='') $model->password=md5(md5($model->password).'key'); else $model->password=$old_pass;
            if($model->save()) {
                
				if($model->package_announce!=$old_package_announce){
					$saveArchive=new ArchiveDb(); $saveArchive->from_='Admin:'.$this->adminLoggedInfo[0]["id"]; $saveArchive->to_='User:'.$model->email;
					$saveArchive->operation='admin_change_package_announce'; $saveArchive->create_time=$time;
					$saveArchive->text='Elan paketi: '.$old_package_announce.' -> '.$model->package_announce;
					$saveArchive->save(false);
				}
				if($model->package_foward!=$old_package_foward){
					$saveArchive=new ArchiveDb(); $saveArchive->from_='Admin:'.$this->adminLoggedInfo[0]["id"]; $saveArchive->to_='User:'.$model->email;
					$saveArchive->operation='admin_change_package_foward'; $saveArchive->create_time=$time;
					$saveArchive->text='İrəli çək paketi: '.$old_package_foward.' -> '.$model->package_foward;
					$saveArchive->save(false);
				}
				if($model->package_foward!=$old_package_foward){
					$saveArchive=new ArchiveDb(); $saveArchive->from_='Admin:'.$this->adminLoggedInfo[0]["id"]; $saveArchive->to_='User:'.$model->email;
					$saveArchive->operation='admin_change_package_foward'; $saveArchive->create_time=$time;
					$saveArchive->text='Axtarışda irəliçək paketi: '.$old_package_search.' -> '.$model->package_search;
					$saveArchive->save(false);
				}
				if($model->premium!=$old_premium){
					$saveArchive=new ArchiveDb(); $saveArchive->from_='Admin:'.$this->adminLoggedInfo[0]["id"]; $saveArchive->to_='User:'.$model->email;
					$saveArchive->operation='admin_change_premium_date'; $saveArchive->create_time=$time;
					$saveArchive->text='Əmlakçılar bölməsində: '.($old_premium-$time).' -> '.($model->premium-$time);
					$saveArchive->save(false);
				}
				
				$tmp = UploadedFile::getInstance($model, 'image');
                if ($tmp != null){
                    $saveParth='users/'.date("Y-m");
                    $imageName=MyFunctions::fileNameGenerator($model->name).'-'.uniqid(rand(1,99)).'.'.$tmp->extension;
                    $thumbName=MyFunctions::fileNameGenerator($model->name).'-'.uniqid(rand(1,99)).'.'.$tmp->extension;

                    $imageUpload=new ImageUpload();
                    $saved=$imageUpload->save($tmp,$saveParth,$imageName);
                    if($saved){
                        $imageUpload->deleteOldImages([$oldImage,$oldThumb]);
                        $imageUpload->maxSize($saveParth.'/'.$imageName,Users::MAX_IMAGE_WIDTH,Users::MAX_IMAGE_HEIGHT);
                        $imageUpload->thumbExport($saveParth.'/'.$imageName,$saveParth.'/thumb/',$thumbName,Users::THUMB_IMAGE_WIDTH,Users::THUMB_IMAGE_HEIGHT);

                        $model->image=$saveParth.'/'.$imageName;
                        $model->thumb=$saveParth.'/thumb/'.$thumbName;
                        $model->save(false);
                    }
                }
                Yii::$app->session->setFlash('success','Məlumatlar uğurla yadda saxlanıldı');
				$this->getCacheUpdate();
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else Yii::$app->session->setFlash('error','Səhvlik var. Zəhmət olmasa yenidən cəhd edin.');
        }
		$model->password='';
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
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actions() {
        return [ 'Kupload' => [ 'class' => 'pjkui\kindeditor\KindEditorAction', ] ];
    }
}
