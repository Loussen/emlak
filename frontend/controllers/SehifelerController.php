<?php
namespace frontend\controllers;

use frontend\components\MyController;
use Yii;
use yii\helpers\Url;

class SehifelerController extends MyController
{

    public function actionView($id)
    {
        $info=$this->getPagesInfo($id);
        if(empty($info)) { return $this->redirect(Url::toRoute(['/'])); }

        return $this->render('view',[
            'info'=>$info,
        ]);
    }
}
