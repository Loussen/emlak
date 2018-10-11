<?php
namespace backend\controllers;

use backend\components\MyFunctions;
use backend\models\Announces;
use backend\models\AnnouncesArchive2014;
use backend\models\AnnouncesArchive2015;
use backend\models\AnnouncesEdited;
use backend\models\ArchiveDb;
use backend\models\PackagePrices;
use frontend\components\MyController;
use Yii;
use yii\helpers\Url;

class AnnouncesController extends MyController
{
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
	
	public function actionJquery(){
		$url=addslashes(Yii::$app->request->post('url')); // ?id=256353&ok=1&status=0&changeStatus=1&imageChanged=0
		$currentAdminId=$this->getUserInfoAdmin('id');
		return file_get_contents('http://emlak.az/emlak0050pro/announces/index'.$url.'&currentAdminId='.$currentAdminId);
	}
	
	public $modelName='backend\models\Announces';
	
    public function actionIndex($page=0,$id=0,$ok=0,$reasons='',$status=0,$changeStatus='',$offset=0,$limit=1){
		if(isset($_GET["count"]) && $_GET["count"]==1) $this->checkCountWrite();
		
		if(Yii::$app->request->get("cacheUpdate")){
			Yii::$app->cache->flush();
		}
		
		$currentAdminId=intval(Yii::$app->request->get('currentAdminId'));
		
		$ids='2503203333';
		if($offset>=0){
			$eee=Announces::find()->where('id in ('.$ids.') ')->offset($offset)->limit($limit)->orderBy(['id'=>SORT_ASC])->asArray()->all();
			foreach($eee as $aaa){
				$a=MyFunctions::setWatermarktoImages($aaa["id"],$offset,$limit);
				//return $a;
			}
		}
        if($id>0 && $ok==1 && $changeStatus==1){
            return $this->changeStatus($id,$status,$changeStatus,'',$currentAdminId);
        }
        elseif($id>0 && $changeStatus==3){
            return $this->changeStatus($id,$status,$changeStatus,$reasons,$currentAdminId);
        }
        elseif($changeStatus==4){
            return $this->changeStatus($id,$status,$changeStatus,$reasons,$currentAdminId);
        }
        $show=2;
        $limit=10;
		
		if($id>0){
			$count=1; $max_page=1; $page=1; $link=Yii::$app->controller->id.'/index?status='.$status;
			foreach(Yii::$app->params["fullAnnouncesArchives"] as $table)
			{
				$tb='backend\models\\'.$table;
				$announces=$tb::find()->where(['id'=>$id])->asArray()->all();
				if(!empty($announces)) break;
			}
			$sameAnnounces=[];
		}
		else{
			$link=Yii::$app->controller->id.'/index?status='.$status;
			
			if($status<5){
				if($status==0) $limit=5;
				$count=Announces::find()->where(['status'=>$status])->count('id'); $max_page=ceil($count/$limit);
				$start=$page*$limit-$limit;
				if($page<1) $page=1; if($page>$max_page) $page=$max_page; if($page<1) $page=1; if($max_page==0) $max_page=1;
				$announces=Announces::find()->where(['status'=>$status]);
				if($status==4) $announces->orderBy(['deleted_time'=>SORT_DESC]);
				elseif($status==0) $announces->orderBy(['announce_date'=>SORT_ASC]);
				else $announces->orderBy(['announce_date'=>SORT_DESC]);
				$announces=$announces->offset($start)->limit($limit)->asArray()->all();
			}
			elseif($status==5){
				$count=Announces::find()->where('sort_foward>0')->count('id'); $max_page=ceil($count/$limit);
				$start=$page*$limit-$limit;
				if($page<1) $page=1; if($page>$max_page) $page=$max_page; if($page<1) $page=1; if($max_page==0) $max_page=1;
				$announces=Announces::find()->where('sort_foward>0')->orderBy(['announce_date'=>SORT_DESC])->offset($start)->limit($limit)->asArray()->all();
			}
			elseif($status==6){
				$count=Announces::find()->where('urgently>0')->count('id'); $max_page=ceil($count/$limit);
				$start=$page*$limit-$limit;
				if($page<1) $page=1; if($page>$max_page) $page=$max_page; if($page<1) $page=1; if($max_page==0) $max_page=1;
				$announces=Announces::find()->where('urgently>0')->orderBy(['announce_date'=>SORT_DESC])->offset($start)->limit($limit)->asArray()->all();
			}
			elseif($status==7){
				$count=Announces::find()->where('sort_premium>0')->count('id'); $max_page=ceil($count/$limit);
				$start=$page*$limit-$limit;
				if($page<1) $page=1; if($page>$max_page) $page=$max_page; if($page<1) $page=1; if($max_page==0) $max_page=1;
				$announces=Announces::find()->where('sort_premium>0')->orderBy(['announce_date'=>SORT_DESC])->offset($start)->limit($limit)->asArray()->all();
			}
			elseif($status==8){
				$count=Announces::find()->where('sort_search>0')->count('id'); $max_page=ceil($count/$limit);
				$start=$page*$limit-$limit;
				if($page<1) $page=1; if($page>$max_page) $page=$max_page; if($page<1) $page=1; if($max_page==0) $max_page=1;
				$announces=Announces::find()->where('sort_search>0')->orderBy(['announce_date'=>SORT_DESC])->offset($start)->limit($limit)->asArray()->all();
			}
			$sameAnnounces=[];
		}
			if($status==0) $renderFile='index_new'; else $renderFile='index';

			return $this->render($renderFile, [
				'titleName' => Announces::$titleName,
				'announces' => $announces,
				'sameAnnounces' => $sameAnnounces,
				'show'=>$show,
				'page'=>$page,
				'max_page'=>$max_page,
				'link'=>$link,
				'status'=>$status,
				'count'=>$count,
				'id'=>$id,
			]);
		
	}
    public function changeStatus($id,$status,$changeStatus,$reasons='',$currentAdminId){
        if($changeStatus==1)
        {
            if(AnnouncesEdited::find()->where(['announce_id'=>$id])->count('id')>0)
            {
                Yii::$app->session->setFlash('danger','Bu elan düzəliş edilməsi üçün sorğu göndərib. Düzəlişi tamamlanmamış elanı aktiv etmək olmaz.');
                return $this->redirect(Url::to([Yii::$app->controller->id.'/index?status='.$status]));
            }
            else
            {
				$time=time();
				foreach(Yii::$app->params["fullAnnouncesArchives"] as $tb_name=>$table){
					$tb='backend\models\\'.$table;
					$update=$tb::find()->where(['id'=>$id])->one();
					if(!empty($update)) break;
				}
                if(empty($update)){
                    Yii::$app->session->setFlash('danger','Bu kodda elan tapılmadı.');
                    return $this->redirect(Url::to([Yii::$app->controller->id.'/index?status='.$status]));
                }
                if($update->status==1)
                {
                    Yii::$app->session->setFlash('danger','Aktiv elanı yenidən aktiv etmək istəyirsən? Are you clever?');
                    return $this->redirect(Url::to([Yii::$app->controller->id.'/index?status='.$status]));
                }
				else if($update->status==2 && $update->announce_date<($time-($this->packagePrices["announce_time"]*86400)))
                {
                    Yii::$app->session->setFlash('danger','Elanın vaxtı bitdiyinə görə aktiv edilə bilmir. Aktiv etmək üçün irəli çəkə bilərsiz.');
                    return $this->redirect(Url::to(['announces-search/index?AnnouncesSearch[id]='.$id]));
                }
                else
                {
					MyFunctions::setWatermarktoImages($id);
                    $saveArchive=new ArchiveDb();
                    $saveArchive->from_='Admin:'.$currentAdminId;
                    $saveArchive->to_='Announce:'.$id;
                    if($update->status==0) $saveArchive->operation='accept'; else $saveArchive->operation='active';
                    $saveArchive->mobiles=$update->mobile;
                    if($time-$update->create_time<(86400*3)) $saveArchive->time_count=$this->packagePrices["announce_time"];
                    $saveArchive->announce_id=$id;
                    $saveArchive->create_time=$time;
                    $saveArchive->save(false);

                    $update->status=1;
                    $update->reasons='-';
                    if($time-$update->create_time<(86400*3) or $update->create_time==$update->announce_date) $update->announce_date=$time;
                    $update->save(false);
					
					// elan basqa bazadadirsa onu berpa edir
                    if($tb_name!='announces'){
						Yii::$app->db->createCommand("insert into announces select * from $tb_name where id='$id' ")->execute();
						Yii::$app->db->createCommand("delete from $tb_name where id='$id' ")->execute();
                    }

                    // email gondersin
                        // istifadeciye email gonderilsin qebul edilmekle bagli...$message hazirla
                    //
					$this->getCacheUpdate($update->email);
                    Yii::$app->session->setFlash('success','Elan aktiv edildi.');
                    return $this->redirect(Url::to([Yii::$app->controller->id.'/index?status='.$status]));
                }
            }
        } // end if $changeStatus==1
        else if($changeStatus==3){
			foreach(Yii::$app->params["fullAnnouncesArchives"] as $table){
				$tb='backend\models\\'.$table;
				$update=$tb::find()->where(['id'=>$id])->one();
				if(!empty($update)) break;
			}
            if(empty($update)){
                Yii::$app->session->setFlash('danger','Bu kodda elan tapılmadı.');
                return '';
            }
			
            $update->reasons=$reasons;
            $update->status=3;
            //$update->urgently=0;
            //$update->sort_search=0;
            //$update->sort_foward=0;
            //$update->sort_package=0;
            //$update->sort_premium=0;
            $update->save(false);

            $reasons=explode('-',$reasons);
            $text='';
            foreach($reasons as $r){
                if(intval($r)>0) $text.=Yii::t('app','error_r'.$r).'***';
            }
            $message=str_replace('***','<br />',$text);
            // email gondersin
            // istifadeciye email gonderilsin qebul edilmemekle bagli...$message hazirdi qabagina artir birce, elaniniz deaktiv edildi..
            //

            $saveArchive=new ArchiveDb();
            $saveArchive->from_='Admin:'.$currentAdminId;
            $saveArchive->to_='Announce:'.$id;
            if($update->status==0) $saveArchive->operation='not_accept'; else $saveArchive->operation='deactive';
            $saveArchive->announce_id=$id;
            $saveArchive->text=$text;
            $saveArchive->create_time=time();
            $saveArchive->save(false);
			
			$this->getCacheUpdate($update->email);
            Yii::$app->session->setFlash('success','Əməliyyat təsdiq edildi');
			MyFunctions::setWatermarktoImages($id);
			
            return $this->redirect(Url::toRoute([Yii::$app->controller->id.'/index?status='.$status]));
        } // end if $changeStatus==3
        else if($changeStatus==4){
			MyFunctions::setWatermarktoImages($id);
			
			foreach(Yii::$app->params["fullAnnouncesArchives"] as $table){
				$tb='backend\models\\'.$table;
				$update=$tb::find()->where(['id'=>$id])->one();
				if(!empty($update)) break;
			}
            if(empty($update)){
                Yii::$app->session->setFlash('danger','Bu kodda elan tapılmadı.');
                return $this->redirect(Url::to([Yii::$app->controller->id.'/index?status='.$status]));
            }
            if($update->status==4 or ($update->status==2 && $update->deleted_time>0) )
            {
                Yii::$app->session->setFlash('danger','Silinmiş elanı yenidən silmək istəyirsən? Are you clever?');
                return $this->redirect(Url::to([Yii::$app->controller->id.'/index?status='.$status]));
            }
            $update->reasons=$reasons;
			$update->deleted_time=time();
            $update->status=4;
            $update->save(false);

            $reasons=explode('-',$reasons);
            $text='';
            foreach($reasons as $r){
                if(intval($r)>0) $text.=Yii::t('app','error_r'.$r).'***';
            }
            $message=str_replace('***','<br />',$text);
            // email gondersin
            // istifadeciye email gonderilsin silinmekle bagli...$message hazirdiş qabagina artir birce, elaniniz silindi..
            //

            $saveArchive=new ArchiveDb();
            $saveArchive->from_=$this->adminLoggedInfo[0]["id"];
            $saveArchive->to_='Announce:'.$id;
            $saveArchive->operation='admin_deleted';
            $saveArchive->announce_id=$id;
            $saveArchive->text=$text;
            $saveArchive->create_time=time();
            $saveArchive->save(false);
			
			$this->getCacheUpdate($update->email);
            Yii::$app->session->setFlash('success','Əməliyyat təsdiq edildi');
            return $this->redirect(Url::toRoute([Yii::$app->controller->id.'/index?status='.$status]));
        } // end if $changeStatus==4
    }

    public function actionShowimages($id){
        $announces=Announces::findOne($id);
        if(empty($announces)) exit();
        else{
            return $this->renderPartial('showimages', [
                'announces' => $announces,
            ]);
        }
    }
	
	public function actionShowmap($id){
        $announces=Announces::findOne($id);
        if(empty($announces)) exit();
        else
        {
            return $this->renderPartial('showimages', [
                'announces' => $announces,
            ]);
        }
    }

}
?>