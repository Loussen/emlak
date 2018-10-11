<?php
namespace backend\controllers;

use backend\models\Announces;
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
            elseif($status==10) $where='archive_view>0';

            if(isset($AnnouncesSearch)){
                if(intval($AnnouncesSearch['id'])>0) $where.=" and id=".intval($AnnouncesSearch['id']);
                if(isset($AnnouncesSearch['email']) && htmlspecialchars($AnnouncesSearch['email'])!='') $where.=" and email like '%".htmlspecialchars($AnnouncesSearch['email'])."%'";
                if(isset($AnnouncesSearch['name']) && htmlspecialchars($AnnouncesSearch['name'])!='') $where.=" and name like '%".htmlspecialchars($AnnouncesSearch['name'])."%'";
                if(isset($AnnouncesSearch['mobile']) && htmlspecialchars($AnnouncesSearch['mobile'])!='') $where.=" and mobile like '%".htmlspecialchars($AnnouncesSearch['mobile'])."%'";
            }
        }

        $select=['id','announce_date','email','name','mobile','status','announcer','create_time','sms_status','archive_view'];
        if(isset($AnnouncesSearch) || $status==10){
            $query5 = new Query; $query5->select($select)->from('announces_archive_2018')->where($where)->all();
            $query4 = new Query; $query4->select($select)->from('announces_archive_2017')->where($where)->all();
            $query3 = new Query; $query3->select($select)->from('announces_archive_2016')->where($where)->all();
            $query2 = new Query; $query2->select($select)->from('announces_archive_2015')->where($where)->all();
            $query1 = new Query; $query1->select($select)->from('announces_archive_2014')->where($where)->all();

            $query = new Query;
            $dataProvider = new ArrayDataProvider([
                'allModels' => $query->select($select)->from('announces')->where($where)
                    ->union($query5)
                    ->union($query4)
                    ->union($query3)
                    ->union($query2)
                    ->union($query1)
                    ->orderBy(['archive_view'=>SORT_DESC])
                    ->all(),
                'pagination' => [
                    'pageSize' => 20,
                ],
            ]);

            if($status==10 and !isset($AnnouncesSearch))  $AnnouncesSearch='';
        }
        elseif($status==9)
        {
            extract($_GET);
            $query_w = 'id>0'; $link = '';
            if(isset($announce_type)) $announce_type_exp=explode("888",$announce_type); else $announce_type=0;
            if(isset($property_type)) $property_type=intval($property_type); else $property_type=0;
            if(isset($repair)) $repair=intval($repair); else $repair=-1;
            if(isset($city)) $city=intval($city); else $city=0;
            if(isset($room_min)) $room_min=intval($room_min); else $room_min=0;
            if(isset($room_max)) $room_max=intval($room_max); else $room_max=0;
            if(isset($space_min)) $space_min=intval($space_min); else $space_min=0;
            if(isset($space_max)) $space_max=intval($space_max); else $space_max=0;
            if(isset($price_min)) $price_min=intval($price_min); else $price_min=0;
            if(isset($price_max)) $price_max=intval($price_max); else $price_max=0;
            if(isset($document)) $document=intval($document); else $document=0;
            if(isset($day)) $day=intval($day); else $day=0;
            if(!isset($selected_regions)) $selected_regions='';
            if(!isset($selected_metros)) $selected_metros='';
            if(!isset($selected_settlements)) $selected_settlements='';
            if(!isset($selected_marks)) $selected_marks='';

//            if($announce_type>0) { $query.=" and announce_type=".$announce_type; $link.='&announce_type='.$announce_type; }

            if($announce_type>0) { $query_w.=" and rent_type=".$announce_type_exp[1]." and announce_type=".$announce_type_exp[0]; $link.='&announce_type='.$announce_type; }
            if($property_type>0) { $query_w.=" and property_type=".$property_type; $link.='&property_type='.$property_type; }
            if($repair>=0) { $query_w.=" and repair=".$repair; $link.='&repair='.$repair; }
            if($city>0) { $query_w.=" and city=".$city; $link.='&city='.$city; }
            if($room_min>0) { $query_w.=" and room_count>=".$room_min; $link.='&room_min='.$room_min; }
            if($room_max>0) { $query_w.=" and room_count<=".$room_max; $link.='&room_max='.$room_max; }
            if($space_min>0) { $query_w.=" and space>=".$space_min; $link.='&space_min='.$space_min; }
            if($space_max>0) { $query_w.=" and space<=".$space_max; $link.='&space_max='.$space_max; }
            if($price_min>0) { $query_w.=" and price>=".$price_min; $link.='&price_min='.$price_min; }
            if($price_max>0) { $query_w.=" and price<=".$price_max; $link.='&price_max='.$price_max; }
            if($document>0) { $query_w.=" and document=1"; $link.='&document=1'; }
            if($day==1) { $dat_time=time()-86400;  $query_w.=" and announce_date>".$dat_time; $link.='&day=1'; }
            if($day==7) { $dat_time=time()-(86400*7); $query_w.=" and announce_date>".$dat_time; $link.='&day=7'; }
            if($day==30) { $dat_time=time()-(86400*30); $query_w.=" and announce_date>".$dat_time; $link.='&day=30'; }

            $addQ='';
            if(is_array($selected_regions) && count($selected_regions)>0){
                $addQ.="region IN(".implode(",",$selected_regions).") or ";
                foreach($selected_regions as $item){
                    $link.='&selected_regions[]='.$item;
                }
            }
            if(is_array($selected_metros) && count($selected_metros)>0){
                $addQ.="metro IN(".implode(",",$selected_metros).") or ";
                foreach($selected_metros as $item){
                    $link.='&selected_metros[]='.$item;
                }
            }
            if(is_array($selected_settlements) && count($selected_settlements)>0){
                $addQ.="settlement IN(".implode(",",$selected_settlements).") or ";
                foreach($selected_settlements as $item){
                    $link.='&selected_settlements[]='.$item;
                }
            }
            if(is_array($selected_marks) && count($selected_marks)>0){
                if(count($selected_marks)==1) $addQ.="mark=".$selected_marks[0]." or ";
                else{
                    foreach($selected_marks as $mrk){
                        $lk1='-'.$mrk.'-';		$lk2=$mrk.'-';   $lk3='-'.$mrk;
                        $addQ.="mark like '%$lk1%' or mark like '$lk2%' or mark like '%$lk3' or mark='$mrk' or ";
                        $link.='&selected_marks[]='.$mrk;
                    }
                }
            }
            if($addQ!=''){
                $addQ=substr($addQ,0,strlen($addQ)-3);
                $query_w.=" and ($addQ) ";
            }

            $query5 = new Query; $query5->select($select)->from('announces_archive_2018')->where($query_w)->all();
            $query4 = new Query; $query4->select($select)->from('announces_archive_2017')->where($query_w)->all();
            $query3 = new Query; $query3->select($select)->from('announces_archive_2016')->where($query_w)->all();
            $query2 = new Query; $query2->select($select)->from('announces_archive_2015')->where($query_w)->all();
            $query1 = new Query; $query1->select($select)->from('announces_archive_2014')->where($query_w)->all();

            $query = new Query;
            $dataProvider = new ArrayDataProvider([
                'allModels' => $query->select($select)->from('announces')->where($query_w)
                    ->union($query5)
                    ->union($query4)
                    ->union($query3)
                    ->union($query2)
                    ->union($query1)
                    ->orderBy(['create_time'=>SORT_DESC])
                    ->all(),
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
            $AnnouncesSearch='';
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
        $update=Announces::find()->where(['id'=>$id])->one();
        $this->changeStatus($id,0,4,'',$this->adminLoggedInfo[0]["id"],$update->sms_status);
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
            $time=time();
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

            $saveArchive=new ArchiveDb();
            $saveArchive->from_='Admin:'.$this->adminLoggedInfo[0]["id"];
            $saveArchive->to_='Announce:'.$id;
            $saveArchive->operation='admin_full_deleted';
            $saveArchive->announce_id=$id;
            $saveArchive->create_time=date("Y-m-d H:i:s");
            $saveArchive->save(false);

            $delete->delete();
            $this->getCacheUpdate();
        }
        return $this->redirect(['announces-search/index']);
    }

    public function actionFull_delete2($id){
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
            $time=time();
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

            $saveArchive=new ArchiveDb();
            $saveArchive->from_='Admin:'.$this->adminLoggedInfo[0]["id"];
            $saveArchive->to_='Announce:'.$id;
            $saveArchive->operation='admin_full_deleted';
            $saveArchive->announce_id=$id;
            $saveArchive->create_time=date("Y-m-d H:i:s");
            $saveArchive->save(false);

            $delete->delete();
        }
        $table='AnnouncesArchive2016';
        $tb='backend\models\\'.$table;
        $delete=$tb::find()->where(['status'=>4])->one();
        $returnUri='https://emlak.az/emlak0050pro/announces-search/full_delete2/'.$delete->id;
        header('Refresh:1;url='. $returnUri);
    }

    public function actionStatus($id,$status,$changeStatus){
        $currentAdminId=$this->adminLoggedInfo[0]["id"];
        $update=Announces::find()->where(['id'=>$id])->one();
        return $this->changeStatus($id,$status,$changeStatus,'',$currentAdminId,$update->sms_status);
    }

    public function actionSmstatus($id,$status,$changeStatus){
        $currentAdminId=$this->adminLoggedInfo[0]["id"];
        return $this->changeSmstatus($id,$status,'','',$currentAdminId,$changeStatus);
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
            $saveArchive->create_time=date("Y-m-d H:i:s");
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
            $saveArchive->create_time=date("Y-m-d H:i:s");
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
            $announce->sort_search=$time+(86400*10);
            $announce->save(false);


            $saveArchive=new ArchiveDb();
            $saveArchive->from_='Admin:'.$this->adminLoggedInfo[0]["id"];
            $saveArchive->to_='Announce:'.$id;
            $saveArchive->operation='admin_announce_search';
            $saveArchive->mobiles=$announce->mobile;
            $saveArchive->time_count=(86400*10);
            $saveArchive->announce_id=$id;
            $saveArchive->create_time=date("Y-m-d H:i:s");
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

    public function actionArchiveview($id,$status,$red_status)
    {
        foreach(Yii::$app->params["fullAnnouncesArchives"] as $tb_name=>$table)
        {
            $tb='backend\models\\'.$table;
            $find=$tb::find()->where(['id'=>$id])->one();
            $count = Yii::$app->db->createCommand("select count(id) from announces where id='$id'")->queryScalar();

            if($tb_name!='announces')
            {
                $count2=$tb::find()->where(['id'=>$id])->one();
            }

            if(!empty($find))
            {
                if($count==0 && $status==1)
                {
//                    Yii::$app->db->createCommand("insert into announces select * from $tb_name where id='$id' ")->execute();

                    $save_ann = new Announces();
                    $save_ann->id = $find->id;
                    $save_ann->email = $find->email;
                    $save_ann->mobile = $find->mobile;
                    $save_ann->name = $find->name;
                    $save_ann->price = $find->price;
                    $save_ann->cover = $find->cover;
                    $save_ann->images = $find->images;
                    $save_ann->logo_images = $find->logo_images;
                    $save_ann->room_count = $find->room_count;
                    $save_ann->rent_type = $find->rent_type;
                    $save_ann->property_type = $find->property_type;
                    $save_ann->announce_type = $find->announce_type;
                    $save_ann->country = $find->country;
                    $save_ann->city = $find->city;
                    $save_ann->region = $find->region;
                    $save_ann->settlement = $find->settlement;
                    $save_ann->metro = $find->metro;
                    $save_ann->mark = $find->mark;
                    $save_ann->address = $find->address;
                    $save_ann->google_map = $find->google_map;
                    $save_ann->floor_count = $find->floor_count;
                    $save_ann->current_floor = $find->current_floor;
                    $save_ann->space = $find->space;
                    $save_ann->repair = $find->repair;
                    $save_ann->document = $find->document;
                    $save_ann->text = $find->text;
                    $save_ann->view_count = $find->view_count;
                    $save_ann->announcer = $find->announcer;
                    $save_ann->status = $find->status;
                    $save_ann->insert_type = $find->insert_type;
                    $save_ann->urgently = $find->urgently;
                    $save_ann->sort_search = $find->sort_search;
                    $save_ann->sort_foward = $find->sort_foward;
                    $save_ann->sort_package = $find->sort_package;
                    $save_ann->sort_premium = $find->sort_premium;
                    $save_ann->announce_date = $find->announce_date;
                    $save_ann->create_time = $find->create_time;
                    $save_ann->deleted_time = $find->deleted_time;
                    $save_ann->reasons = $find->reasons;
                    $save_ann->discount = $find->discount;
                    $save_ann->panarama = $find->panarama;
                    $save_ann->sms_status = $find->sms_status;
//                    $save_ann->archive_view = $find->archive_view;
                    $save_ann->save(false);
                }
                elseif($count>0 && $status==0)
                {
                    if(!empty($count2))
                        Yii::$app->db->createCommand("delete from announces where id='$id' and archive_view>0 ")->execute();
                    else
                        Yii::$app->db->createCommand("update announces set archive_view=0 where id='$id' and archive_view>0")->execute();
                }

                if($status==1)
                    Yii::$app->db->createCommand("update announces set archive_view='".time()."' where id='$id' ")->execute();

                break;
            }
        }

//        echo Yii::$app->request->urlReferrer;
        return $this->redirect(['index?status='.$red_status]);
    }

}
?>
