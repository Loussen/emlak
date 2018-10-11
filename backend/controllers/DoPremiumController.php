<?php
namespace backend\controllers;

use Yii;
use frontend\components\MyController;
use backend\models\Announces;
use backend\models\AnnouncesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use backend\models\ArchiveDb;
use yii\data\ArrayDataProvider;
use yii\db\Query;

class DoPremiumController extends MyController
{
    public $modelName='backend\models\Announces';

    public function actionIndex()
    {
        $searchModel = new AnnouncesSearch();
		$time=time();
		$where="sort_premium>0 and sort_premium>'$time' ";
		if(Yii::$app->request->get()){
			extract($_GET);
			if(isset($AnnouncesSearch)){
				if(intval($AnnouncesSearch['id'])>0) $where.=" and id=".intval($AnnouncesSearch['id']);
				if($AnnouncesSearch['id']=='admin') $where.=" and sort_premium like '%1' ";
				if($AnnouncesSearch['id']=='user') $where.=" and sort_premium like '%0' ";
			}
		}
			$query = new Query;
			$dataProvider = new ArrayDataProvider([
				'allModels' => $query->select('id,sort_premium')->from('announces')->where($where)->orderBy(['announce_date'=>SORT_DESC])->all(),
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

    public function actionCreate(){
		if(Yii::$app->request->get("id")) $id=intval(Yii::$app->request->get("id")); else $id=0;
		
		if(Yii::$app->request->post()){
			$id=Yii::$app->request->post('id');
			$time_count=intval(Yii::$app->request->post('muddet'));		$time=time();
			$muddet=$time_count*86400;			$muddet+=$time;
			
			foreach(Yii::$app->params["fullAnnouncesArchives"] as $tb_name=>$table){
				$tb='backend\models\\'.$table;
				$announces=$tb::find()->where(['id'=>$id])->one();
				if(!empty($announces)) break;
			}
			
			if(empty($announces)){
				Yii::$app->session->setFlash('danger','Bu kodda elan tapılmadı.');
			}
			elseif($time_count==0) Yii::$app->session->setFlash('danger','Müddət daxil edilməyib');
			else {
				$aa=ceil($muddet/10);		$aa=$aa*10;		$muddet=$muddet+($aa-$muddet);
				$muddet++;
				$announces->sort_premium=$muddet;
				$announces->status=1;
				$announces->announce_date=$time;
				$announces->save(false);
				
				$saveArchive=new ArchiveDb();
				$saveArchive->from_='Admin:'.$this->adminLoggedInfo[0]["id"];
				$saveArchive->to_='Announce:'.$id;
				$saveArchive->operation='admin_do_premium';
				$saveArchive->mobiles=$announces->mobile;
				$saveArchive->time_count=$time_count;
				$saveArchive->announce_id=$id;
				$saveArchive->create_time=date("Y-m-d H:i:s");
				$saveArchive->save(false);
				
				if($tb_name!='announces'){
					Yii::$app->db->createCommand("insert into announces select * from $tb_name where id='$id' ")->execute();
					Yii::$app->db->createCommand("delete from $tb_name where id='$id' ")->execute();
				}
				
				Yii::$app->session->setFlash('success','Elan premium edildi.');
				$this->getCacheUpdate();
				return $this->redirect(['index']);
			}
		}
		
		return $this->render('create', [
			'id' => $id,
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
		$announces->sort_premium=0;
		$announces->save(false);
		Yii::$app->session->setFlash('success','Premium ləğv edildi.');
		
		$saveArchive=new ArchiveDb();
		$saveArchive->from_='Admin:'.$this->adminLoggedInfo[0]["id"];
		$saveArchive->to_='Announce:'.$id;
		$saveArchive->operation='admin_remove_premium';
		$saveArchive->mobiles=$announces->mobile;
		$saveArchive->announce_id=$id;
		$saveArchive->create_time=date("Y-m-d H:i:s");
		$saveArchive->save(false);
		
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