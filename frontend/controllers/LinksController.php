<?php
namespace frontend\controllers;

use frontend\components\MyController;
use Yii;
use yii\db\Query;
use yii\helpers\Url;

class LinksController extends MyController
{
    public function actionIndex($tip=1){
		$tip=intval($tip);
		
		if($tip==1){
			$table='seo';
			$link='links/index?tip=1';
		}
		else{
			$table='seo_manual_inner';
			$link='links/index?tip=1';
		}
        $count=Yii::$app->db->createCommand("select count(id) from $table")->queryScalar();
		$page=intval(Yii::$app->request->get('page'));
		$limit=200; $show=2;
		$max_page=ceil($count/$limit); if($page>$max_page) $page=$max_page; if($page<1) $page=1;
        $start=$page*$limit-$limit;
		$links=Yii::$app->db->createCommand("select * from $table order by id desc limit $start,$limit")->queryAll();
		
		
        return $this->render('index',[
            'links'=>$links,
            'count'=>$count,
            'show'=>$show,
            'page'=>$page,
            'max_page'=>$max_page,
            'link'=>$link,
            'tip'=>$tip,
        ]);
    }

	public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
}
