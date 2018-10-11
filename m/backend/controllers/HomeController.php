<?php
namespace backend\controllers;

use Yii;
use frontend\components\MyController;
use yii\helpers\url;

class HomeController extends MyController
{

    public function actionIndex(){
        $this->redirect(Url::to(['announces/index']));
    }
}
