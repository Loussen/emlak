<?php
namespace frontend\controllers;

use frontend\components\MyController;
use frontend\models\ContactForm;
use Yii;

class ElaqeController extends MyController
{
    public function actionIndex()
    {
        $model=new ContactForm();
        if ($model->load(Yii::$app->request->post()) ) {
            if($model->validate())
            {
                $model->sendEmail($this->infoContact[0]["email"]);
                Yii::$app->session->setFlash('success',Yii::t('app','lang26'));
                $model=new ContactForm();
            }
            else
            {
                Yii::$app->session->setFlash('error',Yii::t('app','lang27'));
            }

        }

        return $this->render('index',[
            'model'=>$model
        ]);
    }

}
