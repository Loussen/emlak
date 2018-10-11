<?php
namespace frontend\controllers;

use frontend\components\MyController;
use Yii;
use yii\helpers\Url;

class ReklamController extends MyController
{

    public function actionIndex()
    {
        $info=$this->getPagesInfo(8);
        if(empty($info)) { return $this->redirect(Url::toRoute(['/'])); }

        return $this->render('index',[
            'info'=>$info,
        ]);
    }
}
