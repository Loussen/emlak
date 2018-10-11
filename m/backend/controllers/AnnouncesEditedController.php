<?php
namespace backend\controllers;

use backend\components\MyFunctions;
use backend\models\AnnouncesEdited;
use backend\models\ArchiveDb;
use frontend\components\MyController;
use Yii;
use yii\helpers\Url;

class AnnouncesEditedController extends MyController
{
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
	
	public function actionJquery(){
		$url=addslashes(Yii::$app->request->post('url'));
		$adminId=$this->adminLoggedInfo[0]["ps"];
		return file_get_contents('http://emlak.az/emlak0050pro/announces-edited/index'.$url.'&adminId='.$adminId);
	}
	
	public function actionIndex($status=0,$page=0,$id=0,$ok=0,$reasons='',$changeStatus=0, $imageChanged=0, $adminId=0)
    {
		if($id>0 && $changeStatus==3)
        {
            $update=AnnouncesEdited::find()->where(['announce_id'=>$id])->one();
            if(empty($update)) {return $this->redirect('announces-edited');}
			$update->delete();
            $reasons=explode('-',$reasons);
            $text='';
            foreach($reasons as $r)
            {
                if(intval($r)>0) $text.=Yii::t('app','error_r'.$r).'***';
            }
            $message=str_replace('***','<br />',$text);
            // email gondersin
                // istifadeciye email gonderilsin qebul edilmemekle bagli...$message hazirdi
            //

            $saveArchive=new ArchiveDb();
            $saveArchive->from_=$this->adminLoggedInfo[0]["id"];
            $saveArchive->to_='Announce:'.$id;
            $saveArchive->operation='not_accept_edited';
            $saveArchive->announce_id=$id;
            $saveArchive->text=$text;
            $saveArchive->create_time=time();
            $saveArchive->save(false);
			
			Yii::$app->session->setFlash('success','Əməliyyat təsdiq edildi.');
            return $this->redirect(Url::to(['announces-edited/index?status='.$status]));
        }
        elseif($id>0 && $ok==1)
        {
            if($imageChanged>0) $imageChanged=1; else $imageChanged=0;
			return $this->acceptEdited($id, $imageChanged, $adminId);
        }

        $show=2;
        $limit=10;
        $count=AnnouncesEdited::find()->count('id');
        $max_page=ceil($count/$limit);
        if($page<1) $page=1; if($page>$max_page) $page=$max_page; if($page<1) $page=1; if($max_page==0) $max_page=1;
        $link=Yii::$app->controller->id.'/index?status='.$status;
        $start=$page*$limit-$limit;
        $editedAnnounces=AnnouncesEdited::find()->orderBy(['id'=>SORT_ASC])->offset($start)->limit($limit)->asArray()->all();
        $realAnnounces=[];
        $sameAnnounces=[];
        foreach($editedAnnounces as $id)
        {
			foreach(Yii::$app->params["fullAnnouncesArchives"] as $table)
			{
				$tb='backend\models\\'.$table;
				$realAnnounces[$id["announce_id"]]=$tb::find()->where(['id'=>$id["announce_id"]])->one();
				if(!empty($realAnnounces[$id["announce_id"]])) break;
			}
        }

        return $this->render('index', [
            'titleName' => AnnouncesEdited::$titleName,
            'editedAnnounces' => $editedAnnounces,
            'realAnnounces' => $realAnnounces,
            'sameAnnounces' => $sameAnnounces,
            'show'=>$show,
            'page'=>$page,
            'max_page'=>$max_page,
            'link'=>$link,
            'count'=>$count,
            'status'=>$status,
        ]);
    }

    public function actionShowimages($id,$rotated=0){
        $editedAnnounces=AnnouncesEdited::findOne($id);
        if(empty($editedAnnounces)) exit();
        else
        {
			foreach(Yii::$app->params["fullAnnouncesArchives"] as $table)
			{
				$tb='backend\models\\'.$table;
				$realAnnounces=$tb::findOne($editedAnnounces["announce_id"]);
				if(!empty($realAnnounces)) break;
			}

            return $this->renderPartial('showimages', [
                'editedAnnounces' => $editedAnnounces,
                'realAnnounces' => $realAnnounces,
                'rotated' => $rotated,
            ]);
        }
    }

    public function acceptEdited($id, $imageChanged, $adminId){
        $update=AnnouncesEdited::find()->where(['announce_id'=>$id])->one();
        if(empty($update)) $this->redirect('announces-edited');
        // find original announce
		foreach(Yii::$app->params["fullAnnouncesArchives"] as $table)
		{
			$tb='backend\models\\'.$table;
			$realAnnounces=$tb::find()->where(['id'=>$id])->one();
			if(!empty($realAnnounces)) break;
		}

        $cover=explode(",",$update->logo_images);   $cover=$cover[0];
        $type=explode(".",$cover);   $type=end($type);   $type=strtolower($type); $cover=explode("-",$cover);   unset($cover[count($cover)-1]);
        $cover=implode("-",$cover).'.'.$type;


        $realAnnounces->email=$update->email;
        $realAnnounces->mobile=$update->mobile;
        $realAnnounces->name=$update->name;
        $realAnnounces->price=$update->price;
        if($imageChanged==1 && $id>248249) $realAnnounces->cover=$cover;
        if($imageChanged==1) $realAnnounces->images=$update->images;
        if($imageChanged==1) $realAnnounces->logo_images=$update->logo_images;
        $realAnnounces->room_count=$update->room_count;
        $realAnnounces->rent_type=$update->rent_type;
        $realAnnounces->property_type=$update->property_type;
        $realAnnounces->announce_type=$update->announce_type;
        $realAnnounces->country=$update->country;
        $realAnnounces->city=$update->city;
        $realAnnounces->region=$update->region;
        $realAnnounces->settlement=$update->settlement;
        $realAnnounces->metro=$update->metro;
        $realAnnounces->mark=$update->mark;
        $realAnnounces->address=$update->address;
        $realAnnounces->google_map=$update->google_map;
        $realAnnounces->floor_count=$update->floor_count;
        $realAnnounces->current_floor=$update->current_floor;
        $realAnnounces->space=$update->space;
        $realAnnounces->repair=$update->repair;
        $realAnnounces->document=$update->document;
        $realAnnounces->text=$update->text;
        $realAnnounces->announcer=$update->announcer;
        $realAnnounces->discount=$update->discount;
        if($update->announce_type==1) $realAnnounces->rent_type=0;
        if($update->country!=1){ $realAnnounces->city=0; $realAnnounces->region=0; $realAnnounces->settlement=0; $realAnnounces->metro=0; $realAnnounces->mark='';}
        elseif($update->city!=3){$realAnnounces->region=0; $realAnnounces->settlement=0; $realAnnounces->metro=0; $realAnnounces->mark='';}
        if($update->property_type==3 || $update->property_type==4 || $update->property_type==8) {$realAnnounces->current_floor=0;}
        if($update->property_type==6) {$realAnnounces->current_floor=0; $realAnnounces->floor_count=0;}
        if($update->property_type==7) {$realAnnounces->current_floor=0; $realAnnounces->floor_count=0; $realAnnounces->repair=0;}
        $realAnnounces->save(false);
        if($imageChanged==1) MyFunctions::setWatermarktoImages($id);
		
		Yii::$app->db->createCommand("insert into archive_db (from_,to_,operation,announce_id,create_time) values (
		'Admin:".$adminId."',
		'Announce:".$id."',
		'accept_edited',
		'".$id."',
		'".time()."'
		) ")->execute();
		/*
        $saveArchive=new ArchiveDb();
        $saveArchive->from_=$this->adminLoggedInfo[0]["id"];
        $saveArchive->to_='Announce:'.$id;
        $saveArchive->operation='accept_edited';
        $saveArchive->announce_id=$id;
        $saveArchive->create_time=time();
        $saveArchive->save(false);
		*/
        $update->delete();

        // email gondersin
        // istifadeciye email gonderilsin qebul edilmekle bagli...$message hazirla
        //
		Yii::$app->session->setFlash('success','Əməliyyat təsdiq edildi.');
		return $this->redirect(Url::to(['announces-edited/index']));
    }
}
?>