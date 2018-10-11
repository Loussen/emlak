<?php
namespace frontend\controllers;

use backend\models\Announces;
use backend\models\Currency;
use frontend\components\MyController;
use frontend\components\MyFunctionsF;
use Yii;
use yii\db\Query;
use yii\helpers\Url;

class QueryController extends MyController
{
    public function actionIndex(){
        $link_=Yii::$app->request->get("link");
		
		$checkLink=Yii::$app->db->createCommand("select * from seo where link_='$link_' ")->queryAll();
		if(empty($checkLink)) return $this->redirect(Url::to(['elanlar/?ann_type=3']));
		
		$where=$checkLink[0]["sql_"];
		$title=$checkLink[0]["title_"];
		$desc=$checkLink[0]["description_"];

		$announces_count=0; $anns=[];
		foreach(Yii::$app->params["fullAnnouncesArchives"] as $tb=>$table){
			$ann_rows=Yii::$app->db->createCommand("select count(id) from $tb where ($where) and status in (1,2) ")->queryScalar();
			$announces_count+=$ann_rows;
			$anns[]=$ann_rows;
		}
		
		if($announces_count<20){
			$newWhere=$where;
			for($i=1;$i<=4;$i++){
				$announces_count=0; $anns=[];
				$tempWhere=explode("and ",$newWhere); unset($tempWhere[count($tempWhere)-1]); $tempWhere=implode("and ",$tempWhere);
				$tempWhere=str_replace("'","",$tempWhere);
				if(Yii::$app->db->createCommand("select count(id) from seo where sql_='$tempWhere' ")->queryScalar()>0){
					$newWhere=$tempWhere;
					foreach(Yii::$app->params["fullAnnouncesArchives"] as $tb=>$table){
						$ann_rows=Yii::$app->db->createCommand("select count(id) from $tb where ($newWhere) and status in (1,2) ")->queryScalar();
						$announces_count+=$ann_rows;
						$anns[]=$ann_rows;
					}
				}
				if($announces_count>=20) break;
			}
			$where=$newWhere;
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
		$link='elan/'.$link_;
		
		Yii::$app->view->registerMetaTag(['name' => 'description','content' => $desc]);
		
        return $this->render('index',[
            'announces'=>$announces,
            'announces_count'=>$announces_count,
            'show'=>$show,
            'page'=>$page,
            'max_page'=>$max_page,
            'link'=>$link,
            'title'=>$title,
        ]);
    }

	public function beforeAction($action) {
		$this->checkMobileRedirect(intval(Yii::$app->request->get('full')));
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
}
