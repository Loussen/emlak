<?php
namespace backend\controllers;

use Yii;
use backend\models\PackagePrices;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use frontend\components\MyController;

class PackagePricesController extends MyController
{
    public $modelName='backend\models\PackagePrices';

    public function actionIndex()
    {
        $model = $this->findModel(1);
        if ($model->load(Yii::$app->request->post())) {
            if($model->save())
            {
                Yii::$app->session->setFlash('success','Məlumatlar uğurla yadda saxlanıldı');
                return $this->redirect(['index']);
            }
            else Yii::$app->session->setFlash('error','Səhvlik var. Zəhmət olmasa yenidən cəhd edin.');
        }

        return $this->render('index', [
            'model' => $model,
            'modelName' => $this->modelName,
        ]);
    }

    public function findModel($id)
    {
        $modelName=$this->modelName;
        if (($model = $modelName::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
?>