<?php
namespace frontend\controllers;

use backend\models\Users;
use frontend\components\MyController;
use frontend\components\MyFunctionsF;
use Yii;
use yii\helpers\Url;

class EmlakcilarController extends MyController
{
	public function beforeAction($action){
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    
	public function actionIndex($page=1){
        $show=2;
        $limit=50;
        $sql=Users::find()->select('id')->where('premium>0')->count();
        $max_page=ceil($sql/$limit);
        if($page<1) $page=1; if($page>$max_page) $page=$max_page; if($page<1) $page=1;
        $link=Url::toRoute([Yii::$app->controller->id.'/']);
        $start=$page*$limit-$limit;
        $emlakcilar=Users::find()->select(['id','thumb','name','announce_count','login'])->where('premium>0')->orderBy(['premium'=>SORT_DESC])->offset($start)->limit($limit)->asArray()->all();

        return $this->render('index',[
            'emlakcilar'=>$emlakcilar,
            'show'=>$show,
            'page'=>$page,
            'max_page'=>$max_page,
            'link'=>$link,
        ]);
    }
	
	public function actionMarks_select(){
		if(Yii::$app->request->post()){
			$val=Yii::$app->request->post('val');	if($val!='') {$val=explode("-",$val); $val=array_filter($val);} else $val=[];			// marks
            $val2=Yii::$app->request->post('val2'); if($val2!='') {$val2=explode("-",$val2); $val2=array_filter($val2);} else $val2=[];		// settlement
            $val3=Yii::$app->request->post('val3'); if($val3!='') {$val3=explode("-",$val3); $val3=array_filter($val3);} else $val3=[];		// metro
            $val4=Yii::$app->request->post('val4'); if($val4!='') {$val4=explode("-",$val4); $val4=array_filter($val4);} else $val4=[];		// region
            $return='';
			
			foreach($val4 as $row){
                if(isset($this->regions[$row])) $return.='<li><a data-id="'.$row.'" href="javascript:void(0);" class="remove4"></a>'.$this->regions[$row].'</li>';
            }
			foreach($val3 as $row){
                if(isset($this->metros[$row])) $return.='<li><a data-id="'.$row.'" href="javascript:void(0);" class="remove3"></a>'.$this->metros[$row].'</li>';
            }
			foreach($val2 as $row){
                if(isset($this->settlements[$row])) $return.='<li><a data-id="'.$row.'" href="javascript:void(0);" class="remove2"></a>'.$this->settlements[$row].'</li>';
            }
            foreach($val as $row){
                if(isset($this->marks[$row])) $return.='<li><a data-id="'.$row.'" href="javascript:void(0);" class="remove"></a>'.$this->marks[$row].'</li>';
            }
			
			$return2=''; $where='';
			if(count($val4)>0) $where.="region in (".implode(",",$val4).") or ";
			if(count($val3)>0) $where.="metro in (".implode(",",$val3).") or ";
			if(count($val2)>0) $where.="settlement in (".implode(",",$val2).") or ";
			if(count($val)>0){
				if(count($val)==1) $where.="mark=".$selected_marks[0].' or ';
				else{
					foreach($selected_marks as $mrk){
						$lk1='-'.$mrk.'-';		$lk2=$mrk.'-';   $lk3='-'.$mrk;
						$where.="mark like '%$lk1%' or mark like '$lk2%' or mark like '%$lk3' or mark='$mrk' or ";
					}
				}
			}
			if($where!='') { $where=substr($where,0,strlen($where)-3); $where='and ('.$where.') '; }
			$emlakcilar_email=Yii::$app->db->createCommand("select email from announces where id>0 $where group by email ")->queryAll();
			
			$mail_list='';
			foreach($emlakcilar_email as $mail){
				$mail_list.="email='".$mail["email"]."' or ";
			}
			if($mail_list!='') { $mail_list=substr($mail_list,0,strlen($mail_list)-3); $mail_list='and ('.$mail_list.') '; }
			$emlakcilar=Yii::$app->db->createCommand("select id,thumb,login,name,announce_count from users where premium>0 $mail_list order by premium desc")->queryAll();
			foreach($emlakcilar as $row){
				if(!is_file(MyFunctionsF::getImagePath().'/'.$row["thumb"])) $src='unknow_man.jpg'; else $src=$row["thumb"];
				if($row["login"]=='') $url=Url::toRoute(['emlakcilar/'.$row["id"]]);
				else $url=Url::toRoute(['/'.$row["login"]]);
				if($row["name"]=='') $name='&nbsp;'; else $name=$row["name"];
				$return2.='<li class="rows">
					<a href="'.$url.'">
						<div class="title">'.$name.'</div>
						<div class="img"><img src="'.MyFunctionsF::getImageUrl().'/'.$src.'" alt=""></div>
						<p class="upd">'.Yii::t('app','lang57').' <span class="count">('.$row["announce_count"].')</span></p>
					</a>
				</li>';
			}
            return $return.'*****'.$return2;
        }
    }

    public function actionView($login){
        if(intval($login)>0) $info=Users::find()->where(['id'=>intval($login)])->asArray()->one();
        else $info=Users::find()->where(['login'=>$login])->asArray()->one();
        if(empty($info)) return $this->redirect(Url::toRoute(['/']));

        $ts1_2_p1r1=Yii::$app->db->createCommand("select count(id) from announces where email='$info[email]' and announce_type=1 and property_type=1 and status=1 and room_count=1")->queryScalar();
		$ts1_2_p1r2=Yii::$app->db->createCommand("select count(id) from announces where email='$info[email]' and announce_type=1 and property_type=1 and status=1 and room_count=2")->queryScalar();
		$ts1_2_p1r3=Yii::$app->db->createCommand("select count(id) from announces where email='$info[email]' and announce_type=1 and property_type=1 and status=1 and room_count=3")->queryScalar();
		$ts1_2_p1r4=Yii::$app->db->createCommand("select count(id) from announces where email='$info[email]' and announce_type=1 and property_type=1 and status=1 and room_count=4")->queryScalar();
		$ts1_2_p1r5=Yii::$app->db->createCommand("select count(id) from announces where email='$info[email]' and announce_type=1 and property_type=1 and status=1 and room_count>=5")->queryScalar();
		$ts1_2_p2r1=Yii::$app->db->createCommand("select count(id) from announces where email='$info[email]' and announce_type=1 and property_type=2 and status=1 and room_count=1")->queryScalar();
		$ts1_2_p2r2=Yii::$app->db->createCommand("select count(id) from announces where email='$info[email]' and announce_type=1 and property_type=2 and status=1 and room_count=2")->queryScalar();
		$ts1_2_p2r3=Yii::$app->db->createCommand("select count(id) from announces where email='$info[email]' and announce_type=1 and property_type=2 and status=1 and room_count=3")->queryScalar();
		$ts1_2_p2r4=Yii::$app->db->createCommand("select count(id) from announces where email='$info[email]' and announce_type=1 and property_type=2 and status=1 and room_count=4")->queryScalar();
		$ts1_2_p2r5=Yii::$app->db->createCommand("select count(id) from announces where email='$info[email]' and announce_type=1 and property_type=2 and status=1 and room_count>=5")->queryScalar();
		$ts1_2=$ts1_2_p1r1+$ts1_2_p1r2+$ts1_2_p1r3+$ts1_2_p1r4+$ts1_2_p1r5+$ts1_2_p2r1+$ts1_2_p2r2+$ts1_2_p2r3+$ts1_2_p2r4+$ts1_2_p2r5;
		
		//$ts1_2=Yii::$app->db->createCommand("select count(id) from announces where email='$info[email]' and announce_type=1 and property_type in (1,2) and status=1")->queryScalar();
		$ts3=Yii::$app->db->createCommand("select count(id) from announces where email='$info[email]' and announce_type=1 and property_type=3  and status=1")->queryScalar();
		$ts4=Yii::$app->db->createCommand("select count(id) from announces where email='$info[email]' and announce_type=1 and property_type=4 and status=1")->queryScalar();
		$ts5=Yii::$app->db->createCommand("select count(id) from announces where email='$info[email]' and announce_type=1 and property_type=5 and status=1")->queryScalar();
		$ts6=Yii::$app->db->createCommand("select count(id) from announces where email='$info[email]' and announce_type=1 and property_type=6 and status=1")->queryScalar();
		$ts7=Yii::$app->db->createCommand("select count(id) from announces where email='$info[email]' and announce_type=1 and property_type=7 and status=1")->queryScalar();
		$ts8=Yii::$app->db->createCommand("select count(id) from announces where email='$info[email]' and announce_type=1 and property_type=8 and status=1")->queryScalar();
		$satis_count=$ts1_2+$ts3+$ts4+$ts5+$ts6+$ts7+$ts8;
		
		$ti1_2_p1r1=Yii::$app->db->createCommand("select count(id) from announces where email='$info[email]' and announce_type=2 and property_type=1 and status=1 and room_count=1")->queryScalar();
		$ti1_2_p1r2=Yii::$app->db->createCommand("select count(id) from announces where email='$info[email]' and announce_type=2 and property_type=1 and status=1 and room_count=2")->queryScalar();
		$ti1_2_p1r3=Yii::$app->db->createCommand("select count(id) from announces where email='$info[email]' and announce_type=2 and property_type=1 and status=1 and room_count=3")->queryScalar();
		$ti1_2_p1r4=Yii::$app->db->createCommand("select count(id) from announces where email='$info[email]' and announce_type=2 and property_type=1 and status=1 and room_count=4")->queryScalar();
		$ti1_2_p1r5=Yii::$app->db->createCommand("select count(id) from announces where email='$info[email]' and announce_type=2 and property_type=1 and status=1 and room_count>=5")->queryScalar();
		$ti1_2_p2r1=Yii::$app->db->createCommand("select count(id) from announces where email='$info[email]' and announce_type=2 and property_type=2 and status=1 and room_count=1")->queryScalar();
		$ti1_2_p2r2=Yii::$app->db->createCommand("select count(id) from announces where email='$info[email]' and announce_type=2 and property_type=2 and status=1 and room_count=2")->queryScalar();
		$ti1_2_p2r3=Yii::$app->db->createCommand("select count(id) from announces where email='$info[email]' and announce_type=2 and property_type=2 and status=1 and room_count=3")->queryScalar();
		$ti1_2_p2r4=Yii::$app->db->createCommand("select count(id) from announces where email='$info[email]' and announce_type=2 and property_type=2 and status=1 and room_count=4")->queryScalar();
		$ti1_2_p2r5=Yii::$app->db->createCommand("select count(id) from announces where email='$info[email]' and announce_type=2 and property_type=2 and status=1 and room_count>=5")->queryScalar();
		$ti1_2=$ti1_2_p1r1+$ti1_2_p1r2+$ti1_2_p1r3+$ti1_2_p1r4+$ti1_2_p1r5+$ti1_2_p2r1+$ti1_2_p2r2+$ti1_2_p2r3+$ti1_2_p2r4+$ti1_2_p2r5;
		//$ti1_2=Yii::$app->db->createCommand("select count(id) from announces where email='$info[email]' and announce_type=2 and property_type in (1,2) and status=1")->queryScalar();
		$ti3=Yii::$app->db->createCommand("select count(id) from announces where email='$info[email]' and announce_type=2 and property_type=3 and status=1")->queryScalar();
		$ti4=Yii::$app->db->createCommand("select count(id) from announces where email='$info[email]' and announce_type=2 and property_type=4 and status=1")->queryScalar();
		$ti5=Yii::$app->db->createCommand("select count(id) from announces where email='$info[email]' and announce_type=2 and property_type=5 and status=1")->queryScalar();
		$ti6=Yii::$app->db->createCommand("select count(id) from announces where email='$info[email]' and announce_type=2 and property_type=6 and status=1")->queryScalar();
		$ti7=Yii::$app->db->createCommand("select count(id) from announces where email='$info[email]' and announce_type=2 and property_type=7 and status=1")->queryScalar();
		$ti8=Yii::$app->db->createCommand("select count(id) from announces where email='$info[email]' and announce_type=2 and property_type=8 and status=1")->queryScalar();
		$icare_count=$ti1_2+$ti3+$ti4+$ti5+$ti6+$ti7+$ti8;
		
		$sort_type=0;
        if(Yii::$app->request->get('sort_type')) $sort_type=intval(Yii::$app->request->get('sort_type'));
        if($sort_type<0 || $sort_type>4) $sort_type=0;
        $page=intval(Yii::$app->request->get('page'));	if($page<1) $page=1;
        $limit=10;
        $show=2;
        $start=$page*$limit-$limit;
		$ann=intval(Yii::$app->request->get('ann'));
		$tip=htmlspecialchars(addslashes(Yii::$app->request->get('tip')));
		$room=intval(Yii::$app->request->get('room'));
		
		if(Yii::$app->request->get('map') && is_numeric(Yii::$app->request->get('map'))) {$start=0; $limit=500; $map=1; }
		
		if($info["login"]=='') $url='emlakcilar/'.$info["id"];
		else $url='/'.$info["login"];
		$link=$url;
		
		$query="select * from announces where status=1 and email='$info[email]' ";
		if($ann==2) { $query.="and announce_type=2 "; $link.='?ann=2'; } else { $query.="and announce_type=1 "; $link.='?ann=1'; }
		if($tip=='yeni_tikili') { $query.="and property_type=1 "; $link.='&tip=yeni_tikili'; }
		elseif($tip=='kohne_tikili') { $query.="and property_type=2 "; $link.='&tip=kohne_tikili'; }
		elseif($tip=='villalar') { $query.="and property_type=3 "; $link.='&tip=villalar'; }
		elseif($tip=='bag-evleri') { $query.="and property_type=4 "; $link.='&tip=bag-evleri'; }
		elseif($tip=='ofisler') { $query.="and property_type=5 "; $link.='&tip=ofisler'; }
		elseif($tip=='qarajlar') { $query.="and property_type=6 "; $link.='&tip=qarajlar'; }
		elseif($tip=='torpaqlar') { $query.="and property_type=7 "; $link.='&tip=torpaqlar'; }
		elseif($tip=='obyektler') { $query.="and property_type=8 "; $link.='&tip=obyektler'; }
		
		if($room==1){ $query.="and room_count=1 "; $link.='&room=1'; }
		elseif($room==2){ $query.="and room_count=2 "; $link.='&room=2'; }
		elseif($room==3){ $query.="and room_count=3 "; $link.='&room=3'; }
		elseif($room==5){ $query.="and room_count=4 "; $link.='&room=4'; }
		elseif($room==6){ $query.="and room_count>=5 "; $link.='&room=5'; }
		
		$query_count=str_replace('select *','select count(id)',$query);
		if($sort_type==1) $query.="order by announce_date desc";
        elseif($sort_type==2) $query.="order by space";
        elseif($sort_type==3) $query.="order by price";
        elseif($sort_type==4) $query.="order by price desc";
        else $query.=$this->setSortingDAO('search');
		
		$announces_count=Yii::$app->db->createCommand($query_count)->queryScalar();
		$query.=" limit $start, $limit"; 
		$announces=Yii::$app->db->createCommand($query)->queryAll();
		$max_page=ceil($announces_count/$limit);
        if($page>$max_page) $page=$max_page; if($page<1) $page=1;
		
		if(isset($map) && is_numeric($map)) $renderFile='map'; else $renderFile='view';
		
		$desc=$info["desc_"];
		$keywords=$info["keywords_"];
		Yii::$app->view->registerMetaTag(['name' => 'description','content' => $desc]);
		Yii::$app->view->registerMetaTag(['name' => 'og:description','content' => $desc]);
		Yii::$app->view->registerMetaTag(['name' => 'keywords','content' => $keywords]);
		Yii::$app->view->registerMetaTag(['name' => 'og:keywords','content' => $keywords]);

        return $this->render($renderFile,[
            'announces'=>$announces,
            'max_page'=>$max_page,
            'page'=>$page,
            'sort_type'=>$sort_type,
            'info'=>$info,
            'satis_count'=>$satis_count,
            'icare_count'=>$icare_count,
            'ts1_2'=>$ts1_2,
            'ts3'=>$ts3,
            'ts4'=>$ts4,
            'ts5'=>$ts5,
            'ts6'=>$ts6,
            'ts7'=>$ts7,
            'ts8'=>$ts8,
			'ti1_2'=>$ti1_2,
            'ti3'=>$ti3,
            'ti4'=>$ti4,
            'ti5'=>$ti5,
            'ti6'=>$ti6,
            'ti7'=>$ti7,
            'ti8'=>$ti8,
            'announces_count'=>$announces_count,
            'url'=>$url,
            'link'=>$link,
			'ts1_2_p1r1'=>$ts1_2_p1r1, 'ts1_2_p1r2'=>$ts1_2_p1r2, 'ts1_2_p1r3'=>$ts1_2_p1r3, 'ts1_2_p1r4'=>$ts1_2_p1r4, 'ts1_2_p1r5'=>$ts1_2_p1r5,
			'ts1_2_p2r1'=>$ts1_2_p2r1, 'ts1_2_p2r2'=>$ts1_2_p2r2, 'ts1_2_p2r3'=>$ts1_2_p2r3, 'ts1_2_p2r4'=>$ts1_2_p2r4, 'ts1_2_p2r5'=>$ts1_2_p2r5,
            'ti1_2_p1r1'=>$ti1_2_p1r1, 'ti1_2_p1r2'=>$ti1_2_p1r2, 'ti1_2_p1r3'=>$ti1_2_p1r3, 'ti1_2_p1r4'=>$ti1_2_p1r4, 'ti1_2_p1r5'=>$ti1_2_p1r5,
            'ti1_2_p2r1'=>$ti1_2_p2r1, 'ti1_2_p2r2'=>$ti1_2_p2r2, 'ti1_2_p2r3'=>$ti1_2_p2r3, 'ti1_2_p2r4'=>$ti1_2_p2r4, 'ti1_2_p2r5'=>$ti1_2_p2r5,
        ]);
    }
}
