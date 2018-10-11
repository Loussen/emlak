<?php
namespace backend\controllers;

use Yii;
use frontend\components\MyController;
use backend\models\AnnouncesShare;
use backend\models\AnnouncesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use backend\models\ArchiveDb;
use yii\data\ArrayDataProvider;
use yii\db\Query;

class DoShareController extends MyController
{
    public $modelName='backend\models\AnnouncesShare';

    public function actionIndex()
    {
        $searchModel = new AnnouncesSearch();
		$time=time();
		$where="id>0";
		if(Yii::$app->request->get()){
			extract($_GET);
			if(isset($AnnouncesSearch)){
				if(intval($AnnouncesSearch['id'])>0) $where.=" and announce_id=".intval($AnnouncesSearch['id']);
			}
		}
			$query = new Query;
			$dataProvider = new ArrayDataProvider([
				'allModels' => $query->select('*')->from('announces_share')->where($where)->all(),
				'pagination' => [
					'pageSize' => 20,
				],
			]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelName' => $this->modelName,
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
        else Yii::$app->session->setFlash('error','Heç bir seçim edilməyib.');
        return $this->redirect(['index']);

    }

    public function actionDelete($id){
        $announces=$this->findModel($id);
		
		$saveArchive=new ArchiveDb();
		$saveArchive->from_='Admin:'.$this->adminLoggedInfo[0]["id"];
		$saveArchive->to_='Announce:'.$announces->announce_id;
		$saveArchive->operation='admin_remove_share';
		$saveArchive->announce_id=$announces->announce_id;
		$saveArchive->create_time=time();
		$saveArchive->save(false);
		
		$announces->delete();
		Yii::$app->session->setFlash('success','Paylaşım ləğv edildi.');

		$this->getCacheUpdate();
        $this->redirect(['index']);
    }

    public function findModel($id){
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