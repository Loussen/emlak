<?php
namespace frontend\controllers;

use frontend\components\MyController;
use Yii;

class BlankController extends MyController
{

    public function actionIndex()
    {
        return $this->render('index');
    }
}
