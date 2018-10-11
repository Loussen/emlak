<?php
namespace frontend\controllers;

use backend\models\Announces;
use backend\models\Currency;
use frontend\components\MyController;
use frontend\components\MyFunctionsF;
use Yii;
use yii\db\Query;
use yii\helpers\Url;

class SeoManualController extends MyController
{
    public function actionIndex(){
		extract($_GET);
		$link_=Yii::$app->request->get("link");
		$link_=MyFunctionsF::slugGenerator($link_,'-',false);
		
		$checkLink=Yii::$app->db->createCommand("select sql_,word_,title_,description_,keywords_,page_title,text_top,text_bottom from seo_manual_inner where link_='$link_' ")->queryAll();
		if(empty($checkLink)) return $this->redirect(Url::to(['elanlar/?ann_type=3']));
		
		$where2='';
		$exp=explode("-",$link_); 	$showColor=true;
		if($checkLink[0]["sql_"]!=''){
			$searchWord=$exp;
			$where=$checkLink[0]["sql_"];
		}
		elseif($checkLink[0]["word_"]!=''){
			$searchWord=[];
			$word=$checkLink[0]["word_"];
			$exp_own=explode(", ",$word);
			$where='';
			foreach($exp_own as $w){
				$where.="text REGEXP '$w' or ";
				$searchWord[]=$w;
			}
			$where=substr($where,0,strlen($where)-3);
		}
		else{
			$searchWord=$exp;
			$where='';
			foreach($exp as $w){
				$where.="text REGEXP '$w' or ";
			}
			$where=substr($where,0,strlen($where)-3);
		}

		$title=$checkLink[0]["title_"];
		$desc=$checkLink[0]["description_"];
		$keywords=$checkLink[0]["keywords_"];

		$announces_count=0; $anns=[];
		foreach(Yii::$app->params["fullAnnouncesArchives"] as $tb=>$table){
			$ann_rows=Yii::$app->db->createCommand("select count(id) from $tb where ($where) and status in (1,2) ")->queryScalar();
			$announces_count+=$ann_rows;
			$anns[]=$ann_rows;
		}

		$page=intval(Yii::$app->request->get('page'));	if($page<1) $page=1;
        $limit=10; $gosterilecek=$limit; $show=2;
        $start=$page*$limit-$limit;
		$minLazim=$start; $lazim=$start+$gosterilecek;
		$key=0;		$announces=[];
		foreach(Yii::$app->params["fullAnnouncesArchives"] as $tb=>$table){
			if(isset($anns[$key])){
				if($anns[$key]>=$lazim){
					$ann_rows=Yii::$app->db->createCommand("select * from $tb where ($where) and status in (1,2) order by announce_date desc limit $start,$gosterilecek")->queryAll();
					$announces=array_merge($announces,$ann_rows);
					break;
				}
				else{
					if($anns[$key]>$minLazim){
						$ann_rows=Yii::$app->db->createCommand("select * from $tb where ($where) and status in (1,2) order by announce_date desc limit $start,$gosterilecek")->queryAll();
						$announces=array_merge($announces,$ann_rows);
						$gosterilecek-=count($ann_rows);
						$start=0;
						$lazim=$start+$gosterilecek;
					}
					else{
						$start=$minLazim-$anns[$key];
						$minLazim=$start;
					}
				}
			}
			$key++;
		}

        $max_page=ceil($announces_count/$limit);
        if($page<1) $page=1; if($page>$max_page) $page=$max_page; if($page<1) $page=1;
		$link='elans/'.$link_;
		
		Yii::$app->view->registerMetaTag(['name' => 'description','content' => $desc]);
		Yii::$app->view->registerMetaTag(['name' => 'keywords','content' => $keywords]);
		
        return $this->render('index',[
            'announces'=>$announces,
            'announces_count'=>$announces_count,
            'show'=>$show,
            'page'=>$page,
            'max_page'=>$max_page,
            'link'=>$link,
            'title'=>$title,
            'showColor'=>$showColor,
            'searchWord'=>$searchWord,
            'checkLink'=>$checkLink,
        ]);
    }

	public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
}
