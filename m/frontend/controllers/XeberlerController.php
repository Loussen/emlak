<?php
namespace frontend\controllers;

use frontend\components\MyController;
use Yii;
use backend\models\Posts;
use yii\helpers\Url;

class XeberlerController extends MyController
{

    public function actionIndex($page=1)
    {
        $show=2;
        $limit=10;
        $sql=Posts::find()->where(['status'=>1])->count('id');
        $max_page=ceil($sql/$limit);
        if($page<1) $page=1; if($page>$max_page) $page=$max_page; if($page<1) $page=1;
        $link=Url::toRoute([Yii::$app->controller->id.'/']);
        $start=$page*$limit-$limit;
        $posts=Posts::find()->where(['status'=>1])->orderBy(['news_time'=>SORT_DESC])->offset($start)->limit($limit)->asArray()->all();

        return $this->render('index',[
            'posts'=>$posts,
            'show'=>$show,
            'page'=>$page,
            'max_page'=>$max_page,
            'link'=>$link,
        ]);
    }

    public function actionView($id){
        $info=Posts::findOne($id);
        if(empty($info)) {return $this->redirect(Url::toRoute([Yii::$app->controller->id.'/'])); }
        $info->view_count+=1;   $info->save(false);
        $info=Posts::find()->where(['id'=>$id,'status'=>1])->asArray()->one();
		
		$desc=mb_substr($info["text_".Yii::$app->language],0,500,"utf-8");
		Yii::$app->view->registerMetaTag(['name' => 'description','content' => $desc]);
		Yii::$app->view->registerMetaTag(['name' => 'og:description','content' => $desc]);
		//Yii::$app->view->registerMetaTag(['name' => 'keywords','content' => $keywords]);
		//Yii::$app->view->registerMetaTag(['name' => 'og:keywords','content' => $keywords]);

        return $this->render('view',[
            'info'=>$info,
        ]);
    }
}
