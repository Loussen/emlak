<?php
namespace frontend\controllers;

use backend\models\EstateOrders;
use frontend\components\MyController;
use Yii;
use backend\models\About;
use yii\helpers\Url;

class SifarislerController extends MyController
{

    public function actionIndex($tab=0,$page=1)
    {
        if($tab!=1 && $tab!=2) $tab=0;
        $show=2;
        $limit=10;
        $query=EstateOrders::find()->where(['status'=>1]);
        if($tab>0) $query->andFilterWhere(['type' => $tab]);
        $query->orderBy(['position'=>SORT_DESC]);
        $count=$query->count();
        $max_page=ceil($count/$limit);
        if($page<1) $page=1; if($page>$max_page) $page=$max_page; if($page<1) $page=1;
        $link=Url::toRoute([Yii::$app->controller->id.'/?tab='.$tab]);
        $start=$page*$limit-$limit;
        $query->offset($start)->limit($limit);
        $orders=$query->asArray()->all();

        $tip1_count=EstateOrders::find()->select(['id'])->where(['status'=>1,'type' => 1])->count();
        $tip2_count=EstateOrders::find()->select(['id'])->where(['status'=>1,'type' => 2])->count();

        return $this->render('index',[
            'tab'=>$tab,
            'page'=>$page,
            'orders'=>$orders,
            'show'=>$show,
            'max_page'=>$max_page,
            'tip1_count'=>$tip1_count,
            'tip2_count'=>$tip2_count,
            'link'=>$link,
        ]);
    }

    public function actionOrder_insert(){
        if(Yii::$app->request->post('order_add_submit'))
        {
            $type=intval(Yii::$app->request->post('type'));
            $name=Yii::$app->request->post('name');
            $phone=Yii::$app->request->post('phone');
            $title=Yii::$app->request->post('title');
            $text=Yii::$app->request->post('text');

            if($type!=1 && $type!=2) return 'error---'.Yii::t('app','lang49');
            elseif($name=='') return 'error---'.Yii::t('app','lang50');
            elseif($phone=='') return 'error---'.Yii::t('app','lang51');
            elseif($title=='') return 'error---'.Yii::t('app','lang52');
            elseif($text=='') return 'error---'.Yii::t('app','lang53');
            else
            {
                $model=new EstateOrders();
                $model->type=$type;
                $model->title=$title;
                $model->text=$text;
                $model->name=$name;
                $model->phone=$phone;
                $model->create_time=time();
                $model->status=0;
                $model->save();
                return 'success---'.Yii::t('app','lang54');
            }
        }
    }

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
}
