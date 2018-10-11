<?php

namespace frontend\controllers;

use yii\web\Controller;
use Yii;

class SetLanguageController extends Controller {

    public function actionIndex($lang){
        if(is_dir(Yii::$app->basePath.'/messages/'.$lang) && !empty($lang) ) Yii::$app->session["language"]=$lang;
        return $this->redirect(Yii::$app->request->UrlReferrer);
    }

} 