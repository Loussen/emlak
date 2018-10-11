<?php
namespace backend\controllers;

use Yii;
use backend\models\ArchiveDb;
use backend\models\MobilePackage;
use backend\models\MobilePackageSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\behaviors\SortableController;
use backend\behaviors\StatusController;
use frontend\components\MyController;

class MobilePackageController extends MyController
{
    public $modelName='backend\models\MobilePackage';

    public function actionIndex()
    {
        $deletes=MobilePackage::find()->where('balance=0')->all();
		foreach($deletes as $delete){
			$delete->delete();
		}
		
		$searchModel = new MobilePackageSearch();
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
        $model = new MobilePackage();
		$time=time();
        if ($model->load(Yii::$app->request->post())){
			$model->create_time=$time;
            if($model->save(false))
            {
				$saveArchive=new ArchiveDb(); $saveArchive->from_='Admin:'.$this->adminLoggedInfo[0]["id"]; $saveArchive->to_='Mobile:'.$model->mobile;
				$saveArchive->time_count=$model->balance; $saveArchive->operation='admin_add_package_mobile'; $saveArchive->create_time=$time;
				$saveArchive->save(false);
				
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
		$old_balance=$model->balance;
        if ($model->load(Yii::$app->request->post())) {
            if($model->save(false))
            {
                if($model->balance!=$old_balance){
				$saveArchive=new ArchiveDb(); $saveArchive->from_='Admin:'.$this->adminLoggedInfo[0]["id"]; $saveArchive->to_='Mobile:'.$model->mobile;
				$saveArchive->time_count=$model->balance; $saveArchive->operation='admin_change_package_mobile'; $saveArchive->create_time=$time;
				$saveArchive->text='Mobil Elan paketi: '.$old_balance.' -> '.$model->balance;
				$saveArchive->save(false);
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
        $find=$this->findModel($id);
			$time=time();
			$saveArchive=new ArchiveDb(); $saveArchive->from_='Admin:'.$this->adminLoggedInfo[0]["id"]; $saveArchive->to_='Mobile:'.$find->mobile;
			$saveArchive->operation='admin_delete_package_mobile'; $saveArchive->create_time=$time;
			$saveArchive->text='Mobil Elan paketi silindi: '.$find->balance.' -> 0';
			$saveArchive->save(false);
		$find->delete();
		Yii::$app->session->setFlash('success','Məlumat silindi');
        return $this->redirect(['index']);
    }


    public function findModel($id)
    {
        $modelName=$this->modelName;
        if (($model = $modelName::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

}
?>