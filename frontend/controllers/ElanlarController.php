<?php
namespace frontend\controllers;

use backend\models\Announces;
use backend\models\Currency;
use frontend\components\MyController;
use frontend\components\MyFunctionsF;
use Yii;
use yii\db\Query;
use yii\helpers\Url;

class ElanlarController extends MyController
{
    public function actionRedirect($id=''){
        foreach(Yii::$app->params["fullAnnouncesArchives"] as $table){
            $tb='backend\models\\'.$table;
            $elan=$tb::find()->where(['id'=>$id])->andWhere('status=1 or status=2')->one();
            if(!empty($elan)) break;
        }
        if(empty($elan)){
            Yii::$app->session->setFlash('danger',Yii::t('app','lang254'));
            return $this->redirect(Url::to(['elanlar/?ann_type=3']));
        }
        else{
            $title=$this->titleGenerator('az',$elan["announce_type"],$elan["property_type"],$elan["space"],$elan["room_count"],$elan["mark"],$elan["settlement"],$elan["metro"],$elan["region"],$elan["city"],$elan["country"],$elan["address"]);
            $slugTitle=MyFunctionsF::slugGenerator($title);
            $this->redirect(Url::to(['/'.$elan["id"].'-'.$slugTitle.'.html']));
        }
    }

    public function actionCheck_announce_isset(){
        $id=intval(Yii::$app->request->post('id'));
        foreach(Yii::$app->params["fullAnnouncesArchives"] as $table){
            $tb='backend\models\\'.$table;
            $elan=$tb::find()->where(['id'=>$id])->andWhere('status=1 or status=2')->one();
            if(!empty($elan)) break;
        }
        if(empty($elan)) return 'empty';
        else{
            $title=$this->titleGenerator('az',$elan["announce_type"],$elan["property_type"],$elan["space"],$elan["room_count"],$elan["mark"],$elan["settlement"],$elan["metro"],$elan["region"],$elan["city"],$elan["country"],$elan["address"]);
            $slugTitle=MyFunctionsF::slugGenerator($title);
            return Url::to(['/'.$elan["id"].'-'.$slugTitle.'-do-premium.html']);
        }
    }

    public function actionGet_ann_mobile($id){
        $elan=Yii::$app->db->createCommand("select mobile,status from announces where id='$id' ")->queryAll();
        if(!empty($elan)){
            if($elan[0]["status"]==1) $return=str_replace("*",", ",$elan[0]["mobile"]);
            else $return=Yii::t('app','lang295');
            return $return;
        }
        else return '';
    }

    public function actionIndex(){
//        echo MyFunctionsF::elnur;
        extract($_GET);
        $showColor=false;	$searchWord=[];		if(isset($q)) $q=str_replace("'",'',$q);
        if(isset($q) && is_numeric($q)){
            foreach(Yii::$app->params["fullAnnouncesArchives"] as $table){
                $tb='backend\models\\'.$table;
                $elan=$tb::find()->where(['id'=>$q])->andWhere('status=1 or status=2')->one();
                if(!empty($elan)) break;
            }
            if(empty($elan)){
                Yii::$app->session->setFlash('danger',Yii::t('app','lang254'));
                return $this->redirect(Url::to(['elanlar/?ann_type=3']));
            }
            else{
                $title=$this->titleGenerator('az',$elan["announce_type"],$elan["property_type"],$elan["space"],$elan["room_count"],$elan["mark"],$elan["settlement"],$elan["metro"],$elan["region"],$elan["city"],$elan["country"],$elan["address"]);
                $slugTitle=MyFunctionsF::slugGenerator($title);
                $this->redirect(Url::to(['/'.$elan["id"].'-'.$slugTitle.'.html']));
            }
        }
        elseif(isset($q)){		// axtarisda soz yazarsa
            $check_q_link=MyFunctionsF::slugGenerator($q,'-',false);
            $check_info=Yii::$app->db->createCommand("select sql_,word_ from seo_manual_inner where link_='$check_q_link' ")->queryAll();
            if(empty($check_info)){
                $exp=explode(" ",$q); $add_wh='';
                foreach($exp as $w){
                    if($w!='' && $w!="'") $add_wh.="text REGEXP '$w' or ";
                }
                $add_wh=substr($add_wh,0,-3);	if($add_wh!='') $add_wh="and ($add_wh) "; else $add_wh='';
                $query_text="select * from announces where status=1 $add_wh ";
                $showColor=true;	$searchWord=$exp;
            }
            else{
                $exp=explode(" ",$q); 	$showColor=true; $searchWord=$exp;
                if($check_info[0]["sql_"]!=''){
                    $wh=$check_info[0]["sql_"]; $query_text="select * from announces where status=1 and $wh ";
                }
                elseif($check_info[0]["word_"]!=''){
                    $word=$check_info[0]["word_"];
                    $exp_own=explode(" ",$word);
                    $add_wh='';
                    foreach($exp_own as $w){
                        if($w!='' && $w!="'"){
                            $add_wh.="text REGEXP '$w' or ";
                            $searchWord[]=$w;
                        }
                    }
                    $add_wh=substr($add_wh,0,-3); if($add_wh!='') $add_wh="and ($add_wh) "; else $add_wh='';
                    $query_text="select * from announces where status=1 $add_wh ";
                }
                else{
                    $add_wh='';
                    foreach($exp as $w){
                        if($w!='' && $w!="'") $add_wh.="text REGEXP '$w' or ";
                    }
                    $add_wh=substr($add_wh,0,-3); if($add_wh!='') $add_wh="and ($add_wh) "; else $add_wh='';
                    $query_text="select * from announces where status=1 $add_wh ";
                }
            }
        }
        else{
            $q='';
            $query_text='';
        }	// axtarisda soz yazarsa

        if(isset($ann_type)) $ann_type=intval($ann_type); else $ann_type=3;


        if(!isset($selected_regions)) $selected_regions='';
        if(!isset($selected_metros)) $selected_metros='';
        if(!isset($selected_settlements)) $selected_settlements='';
        if(!isset($selected_marks)) $selected_marks='';

        if($query_text=='') $link='elanlar/?ann_type='.$ann_type;
        else $link='elanlar/?q='.$check_q_link;

//        var_dump($this->userInfo->email);

        if($this->userInfo!=false)
        {
            if($this->userInfo->id==667 ||  $this->userInfo->id==4256 && !isset($ajax))
                $query="select * from announces where status=1 or (archive_view>0 and status!=1) ";
            else
                $query="select * from announces where status=1 ";
        }
        else
            $query="select * from announces where status=1 ";

//        if($this->userInfo!=false && $this->userInfo->id==667 || $this->userInfo->id==4256) $query="select * from announces where archive_view>0 ";
//        else $query="select * from announces where status=1 ";
//        $query="select * from announces where status=1 ";

        if(!isset($tip)) $tip=array();

        if(!in_array(9,$tip) || (isset($ajax) && is_numeric($ajax)) || $ann_type==2 || $ann_type==3)
        {
            if($ann_type==3 && $query_text==''){
                // etrafli axtaris
//            if(isset($announce_type)) $announce_type=intval($announce_type); else $announce_type=0;

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

                if($announce_type>0) { $query.=" and rent_type=".$announce_type_exp[1]." and announce_type=".$announce_type_exp[0]; $link.='&announce_type='.$announce_type; }
                if($property_type>0) { $query.=" and property_type=".$property_type; $link.='&property_type='.$property_type; }
                if($repair>=0) { $query.=" and repair=".$repair; $link.='&repair='.$repair; }
                if($city>0) { $query.=" and city=".$city; $link.='&city='.$city; }
                if($room_min>0) { $query.=" and room_count>=".$room_min; $link.='&room_min='.$room_min; }
                if($room_max>0) { $query.=" and room_count<=".$room_max; $link.='&room_max='.$room_max; }
                if($space_min>0) { $query.=" and space>=".$space_min; $link.='&space_min='.$space_min; }
                if($space_max>0) { $query.=" and space<=".$space_max; $link.='&space_max='.$space_max; }
                if($price_min>0) { $query.=" and price>=".$price_min; $link.='&price_min='.$price_min; }
                if($price_max>0) { $query.=" and price<=".$price_max; $link.='&price_max='.$price_max; }
                if($document>0) { $query.=" and document=1"; $link.='&document=1'; }
                if($day==1) { $dat_time=time()-86400;  $query.=" and announce_date>".$dat_time; $link.='&day=1'; }
                if($day==7) { $dat_time=time()-(86400*7); $query.=" and announce_date>".$dat_time; $link.='&day=7'; }
                if($day==30) { $dat_time=time()-(86400*30); $query.=" and announce_date>".$dat_time; $link.='&day=30'; }
            }
            elseif($query_text==''){
                // sade axtaris
                $query.=" and announce_type=".$ann_type;
                //if(in_array(9,$tip) && count($tip)==1 ) $query.=" and country>1 ";
                if(!isset($yotaq)) $yotaq='';
                if(!isset($kotaq)) $kotaq='';
                if(!isset($tip)) $tip='';
                $where='';
                if(is_array($yotaq) && count($yotaq)>0){
                    $addQ='(property_type=1 and (';
                    foreach($yotaq as $otq){
                        if($otq>=5) $addQ.="room_count>=".$otq." or "; else $addQ.="room_count=".$otq." or ";
                        $link.='&yotaq[]='.$otq;
                    }
                    $addQ=substr($addQ,0,strlen($addQ)-3).'))';
                    $where.="( ".$addQ." or ";
                }

                if(is_array($kotaq) && count($kotaq)>0){
                    $addQ='(property_type=2 and (';
                    foreach($kotaq as $otq){
                        if($otq>=5) $addQ.="room_count>=".$otq." or "; else $addQ.="room_count=".$otq." or ";
                        $link.='&kotaq[]='.$otq;
                    }
                    $addQ=substr($addQ,0,strlen($addQ)-3);  $addQ.='))';
                    if($where=='') $prefixx='( '; else $prefixx='';
                    $where.=$prefixx.$addQ." or ";
                }

                if(is_array($tip) && count($tip)>0){
                    $addQ='';
                    foreach($tip as $tp){
                        if($tp!=9) $addQ.="property_type=".$tp." or ";
                        else $addQ.="country>1 or ";
                        $link.='&tip[]='.$tp;
                    }
                    $addQ=substr($addQ,0,strlen($addQ)-3);
                    if($where=='') $prefixx='( '; else $prefixx='';
                    $where.=$prefixx.$addQ." or ";
                }

                if($where!='') { $where=substr($where,0,strlen($where)-3); $where.=')'; $query.=" and ".$where; }
                if(!is_array($tip) or !in_array(9,$tip) ) $query.=" and country=1";
                if(isset($rent_type_gun) && $rent_type_gun==1 && $ann_type==2)
                {
                    $query.=" and rent_type=1";
                    $link.='&rent_type_gun=1';
                }
                //echo $query;
            }
            else $query=$query_text; // en son halda sozle axtarisi gotursun...
        }
        else
        {
            $query .= " and country>1";
            $link.='&tip[]=9';
        }

        if(!in_array(9,$tip))
        {
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
                $query.=" and ($addQ) ";
            }
        }


        $query_count=str_replace('select *','select count(id)',$query);
        $announces_count=Yii::$app->db->createCommand($query_count)->queryScalar();		if(isset($ajax) && is_numeric($ajax)) return $announces_count;

        $sort_type=0;
        if(Yii::$app->request->get('sort_type')) $sort_type=intval(Yii::$app->request->get('sort_type'));
        if($sort_type<0 || $sort_type>4) $sort_type=0;
        $page=intval(Yii::$app->request->get('page'));	if($page<1) $page=1;
        $limit=20;
        $show=2;
        $start=$page*$limit-$limit;
        $link.='&sort_type='.$sort_type.'&page='.$page;
        if(isset($map) && is_numeric($map)) {$start=0; $limit=500;}

        if($sort_type==1) $query.=" order by announce_date desc";
        elseif($sort_type==2) $query.=" order by space";
        elseif($sort_type==3) $query.=" order by price";
        elseif($sort_type==4) $query.=" order by price desc";
        else $query.=' '.$this->setSortingDAO('search');

        $query.=" limit $start, $limit";
        $announces=Yii::$app->db->createCommand($query)->queryAll();

        $max_page=ceil($announces_count/$limit);
        if($page<1) $page=1; if($page>$max_page) $page=$max_page; if($page<1) $page=1;

        if(isset($map) && is_numeric($map)) $renderFile='map'; else $renderFile='index';

        return $this->render($renderFile,[
            'announces'=>$announces,
            'announces_count'=>$announces_count,
            'sort_type'=>$sort_type,
            'show'=>$show,
            'page'=>$page,
            'max_page'=>$max_page,
            'link'=>$link,
            'q'=>$q,
            'showColor'=>$showColor,
            'searchWord'=>$searchWord,
        ]);
    }

    public function actionView($id){
        $currency=Currency::findOne(1);
        foreach(Yii::$app->params["fullAnnouncesArchives"] as $table){
            $tb='backend\models\\'.$table;
            $elan=$tb::find()->where(['id'=>$id])->andWhere('status=1 or status=2')->one();
            if(!empty($elan)) break;
        }

        if(empty($elan)){
            Yii::$app->session->setFlash("danger",Yii::t('app','lang207'));
            return $this->redirect(Url::to(['/']));
        }
        $elan->view_count+=1; $elan->save(false);

        $oxsar_elanlar=Announces::find()->select('*')->where(['property_type'=>$elan->property_type,'announce_type'=>$elan->announce_type,'status'=>1]);
        if($elan->property_type!=6 && $elan->property_type!=7) $oxsar_elanlar->andWhere(['room_count'=>$elan->room_count]);
        $oxsar_elanlar->andWhere('id!='.$id);
        $oxsar_elanlar=$oxsar_elanlar->orderBy(['sort_search'=>SORT_DESC,'sort_foward'=>SORT_DESC,'sort_package'=>SORT_DESC,'sort_premium'=>SORT_DESC,'announce_date'=>SORT_DESC])->limit(10)->all();

        $desc=$this->descGenerator(Yii::$app->language,$elan->metro,$elan->settlement,$elan->region,$elan->city,$elan->repair,$elan->document,$elan->announce_type,$elan->announce_type,$elan->space,$elan->room_count,$elan->country);
        Yii::$app->view->registerMetaTag(['name' => 'description','content' => $desc]);

        $first_img=explode(",",$elan["logo_images"]);	$first_img=$this->siteUrl.'/images/'.$first_img[0];
        Yii::$app->view->registerMetaTag(['property' => 'og:image','content' => $first_img]);

        return $this->render('view', [
            'elan'=>$elan,
            'oxsar_elanlar'=>$oxsar_elanlar,
            'id'=>$id,
            'currency'=>$currency,
            'first_img'=>$first_img,
        ]);
    }

    public function beforeAction($action) {
        $this->checkMobileRedirect(intval(Yii::$app->request->get('full')));
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
}
