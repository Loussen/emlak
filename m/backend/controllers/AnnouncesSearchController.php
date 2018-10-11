<?php
namespace backend\controllers;

use backend\models\AnnouncesEdited;
use backend\models\ArchiveDb;
use backend\components\MyFunctions;
use Yii;
use backend\models\AnnouncesSearch;
use yii\data\ArrayDataProvider;
use yii\db\Query;

class AnnouncesSearchController extends AnnouncesController
{
    public $modelName='backend\models\Announces';
    
	public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
	
	public function actionIndex($page=0,$id=0,$ok=0,$reasons='',$status='all',$changeStatus='',$offset=0,$limit=1)
    {
        $status=intval($status);
		$searchModel = new AnnouncesSearch();
		$where='id>0';
		if(Yii::$app->request->get()){
			extract($_GET);
			if($status>0 && $status<=4) $where.=" and status=".$status;
			elseif($status==5) $where='sort_foward>0';
			elseif($status==6) $where='urgently>0';
			elseif($status==7) $where='sort_premium>0';
			elseif($status==8) $where='sort_search>0';
		
			if(isset($AnnouncesSearch)){
				if(intval($AnnouncesSearch['id'])>0) $where.=" and id=".intval($AnnouncesSearch['id']);
				if(isset($AnnouncesSearch['email']) && htmlspecialchars($AnnouncesSearch['email'])!='') $where.=" and email like '%".htmlspecialchars($AnnouncesSearch['email'])."%'";
				if(isset($AnnouncesSearch['name']) && htmlspecialchars($AnnouncesSearch['name'])!='') $where.=" and name like '%".htmlspecialchars($AnnouncesSearch['name'])."%'";
				if(isset($AnnouncesSearch['mobile']) && htmlspecialchars($AnnouncesSearch['mobile'])!='') $where.=" and mobile like '%".htmlspecialchars($AnnouncesSearch['mobile'])."%'";
			}
		}
		
		$select=['id','announce_date','email','name','mobile','status','announcer','create_time'];
		if(isset($AnnouncesSearch)){
			$query3 = new Query; $query3->select($select)->from('announces_archive_2016')->where($where)->all();
			$query2 = new Query; $query2->select($select)->from('announces_archive_2015')->where($where)->all();
			$query1 = new Query; $query1->select($select)->from('announces_archive_2014')->where($where)->all();
			
			$query = new Query;
			$dataProvider = new ArrayDataProvider([
				'allModels' => $query->select($select)->from('announces')->where($where)
				->union($query3)
				->union($query2)
				->union($query1)
				->orderBy(['announce_date'=>SORT_DESC])
				->all(),
				'pagination' => [
					'pageSize' => 20,
				],
			]);
		}
		else{
			$AnnouncesSearch='';
			$dataProvider = $searchModel->search(Yii::$app->request->queryParams,$status);
		}

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'AnnouncesSearch' => $AnnouncesSearch,
            'modelName' => $this->modelName,
            'status' => $status,
        ]);
    }

    public function actionDeletemore()
    {
        $ids=Yii::$app->request->post('check');
        if(!empty($ids)){
            foreach ($ids as $id) {
				$this->actionDelete($id);
            }
            Yii::$app->session->removeFlash('danger');
            Yii::$app->session->setFlash('success','Məlumatlar silindi');
            Yii::$app->session->removeFlash('error');
        }
        else Yii::$app->session->setFlash('error','Heç bir seçim edilməyib.');
        return $this->redirect(['index?status=4']);

    }

    public function actionDelete($id)
    {
		$this->changeStatus($id,0,4,'',$this->adminLoggedInfo[0]["id"]);
        if(Yii::$app->session->getFlash('danger')=='') Yii::$app->session->setFlash('success','Məlumatlar silindi');
		else Yii::$app->session->setFlash('danger',Yii::$app->session->getFlash('danger'));
        return $this->redirect(['index?status=4']);
    }
	
	public function actionFull_delete($id){
		foreach(Yii::$app->params["fullAnnouncesArchives"] as $table)
		{
			$tb='backend\models\\'.$table;
			$delete=$tb::find()->where(['id'=>$id])->one();
			if(!empty($delete)) break;
		}
		if(empty($delete)){
			Yii::$app->session->setFlash('danger','Bu kodda elan tapılmadı.');
			return $this->redirect(['index']);
		}
		else{
			Yii::$app->session->setFlash('success','Məlumatlar silindi');
			$folder='announces/'.date("Y",$delete->create_time).'/'.intval(date("m",$delete->create_time)).'/'.$id;
			$folderPath=MyFunctions::getImagePath().'/'.$folder;
			$folderAddress=MyFunctions::getImageUrl().'/'.$folder;
			if(is_dir($folderPath)){
				$ac=opendir($folderPath);
				while($oxu=readdir($ac)){
					$file=$folderPath.'/'.$oxu;
					if(is_file($file)) unlink($file);
				}
				rmdir($folderPath);
			}
			$delete->delete();
			$this->getCacheUpdate();
		}
        return $this->redirect(['announces-search/index']);
    }

    public function actionStatus($id,$status,$changeStatus){
		$currentAdminId=$this->adminLoggedInfo[0]["id"];
		return $this->changeStatus($id,$status,$changeStatus,'',$currentAdminId);
    }
	
	public function actionSet_foward($id){
		foreach(Yii::$app->params["fullAnnouncesArchives"] as $real_name=>$table){
			$tb='backend\models\\'.$table;    $tb_name=$real_name;
			$announce=$tb::find()->where(['id'=>$id])->one();
			if(!empty($announce)) break;
		}
		if(empty($announce)){
			Yii::$app->session->setFlash('danger','Bu kodda elan tapılmadı.');
			return $this->redirect(['index']);
		}
		else{
			$time=time();
			Yii::$app->session->setFlash('success','Elan irəli çəkildi');
			$announce->announce_date=$time;
			$announce->status=1;
			$announce->sort_foward=$time+(3600*$this->packagePrices["announce_foward_time"]);
			$announce->save(false);
			
			$saveArchive=new ArchiveDb();
			$saveArchive->from_='Admin:'.$this->adminLoggedInfo[0]["id"];
			$saveArchive->to_='Announce:'.$id;
			$saveArchive->operation='admin_announce_foward';
			$saveArchive->mobiles=$announce->mobile;
			$saveArchive->time_count=(3600*$this->packagePrices["announce_foward_time"]);
			$saveArchive->announce_id=$id;
			$saveArchive->create_time=$time;
			$saveArchive->save(false);
			
			// elan basqa bazadadirsa onu berpa edir
			if($tb_name!='announces'){
				Yii::$app->db->createCommand("insert into announces select * from $tb_name where id='$id' ")->execute();
				Yii::$app->db->createCommand("delete from $tb_name where id='$id' ")->execute();
			}
			$this->getCacheUpdate();
		}
        return $this->redirect(['index?status=1']);
    }
	
	public function actionSet_urgently($id){
		foreach(Yii::$app->params["fullAnnouncesArchives"] as $tb_name=>$table){
			$tb='backend\models\\'.$table;
			$announce=$tb::find()->where(['id'=>$id])->one();
			if(!empty($announce)) break;
		}
		if(empty($announce)){
			Yii::$app->session->setFlash('danger','Bu kodda elan tapılmadı.');
			return $this->redirect(['index']);
		}
		else{
			$time=time();
			Yii::$app->session->setFlash('success','Elan təcili edildi');
			$announce->announce_date=$time;
			$announce->status=1;
			$announce->urgently=$time+(86400*30);
			$announce->save(false);
			
			
			$saveArchive=new ArchiveDb();
			$saveArchive->from_='Admin:'.$this->adminLoggedInfo[0]["id"];
			$saveArchive->to_='Announce:'.$id;
			$saveArchive->operation='admin_announce_urgently';
			$saveArchive->mobiles=$announce->mobile;
			$saveArchive->time_count=(86400*30);
			$saveArchive->announce_id=$id;
			$saveArchive->create_time=$time;
			$saveArchive->save(false);
			
			// elan basqa bazadadirsa onu berpa edir
			if($tb_name!='announces')
			{
				Yii::$app->db->createCommand("insert into announces select * from $tb_name where id='$id' ")->execute();
				Yii::$app->db->createCommand("delete from $tb_name where id='$id' ")->execute();
			}
	
			$this->getCacheUpdate();
		}
        return $this->redirect(['index?status=1']);
    }
	
	public function actionSet_search_foward($id){
		foreach(Yii::$app->params["fullAnnouncesArchives"] as $tb_name=>$table){
			$tb='backend\models\\'.$table;
			$announce=$tb::find()->where(['id'=>$id])->one();
			if(!empty($announce)) break;
		}
		if(empty($announce)){
			Yii::$app->session->setFlash('danger','Bu kodda elan tapılmadı.');
			return $this->redirect(['index']);
		}
		else{
			$time=time();
			Yii::$app->session->setFlash('success','Elan axtarışda irəli çəkildi');
			$announce->announce_date=$time;
			$announce->status=1;
			$announce->sort_search=$time+(86400*30);
			$announce->save(false);
			
			
			$saveArchive=new ArchiveDb();
			$saveArchive->from_='Admin:'.$this->adminLoggedInfo[0]["id"];
			$saveArchive->to_='Announce:'.$id;
			$saveArchive->operation='admin_announce_search';
			$saveArchive->mobiles=$announce->mobile;
			$saveArchive->time_count=(86400*30);
			$saveArchive->announce_id=$id;
			$saveArchive->create_time=$time;
			$saveArchive->save(false);
			
			// elan basqa bazadadirsa onu berpa edir
			if($tb_name!='announces'){
				Yii::$app->db->createCommand("insert into announces select * from $tb_name where id='$id' ")->execute();
				Yii::$app->db->createCommand("delete from $tb_name where id='$id' ")->execute();
			}
	
			$this->getCacheUpdate();
		}
        return $this->redirect(['index?status=1']);
    }

}
?>