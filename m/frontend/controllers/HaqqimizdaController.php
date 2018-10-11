<?php
namespace frontend\controllers;

use frontend\components\MyController;
use Yii;
use yii\helpers\Url;

class HaqqimizdaController extends MyController
{

    public function actionIndex()
    {
        $cacheName='about'; $info=Yii::$app->cache->get($cacheName);
        if($info===false)
        {
            $info=$this->getPagesInfo(12);
            Yii::$app->cache->set($cacheName,$info,$this->cacheTime);
        }
        if(empty($info)) { return $this->redirect(Url::toRoute(['/'])); }

        return $this->render('index',[
            'info'=>$info,
        ]);
    }
}
