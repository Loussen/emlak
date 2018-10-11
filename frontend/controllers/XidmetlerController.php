<?php
namespace frontend\controllers;

use frontend\components\MyController;
use Yii;
use backend\models\Services;

class XidmetlerController extends MyController
{

    public function actionIndex()
    {
        $info=Services::find()->where(['status'=>1])->orderBy(['position'=>SORT_ASC])->asArray()->all();

        return $this->render('index',[
            'info'=>$info
        ]);
    }
}
