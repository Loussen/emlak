<?php
namespace frontend\controllers;

use backend\models\Announces;
use backend\models\AnnouncesArchive2015;
use frontend\components\MyController;
use frontend\components\MyFunctionsF;
use Yii;
use common\models\LoginForm;
use yii\helpers\Url;

/**
 * Site controller
 */
class SiteController extends MyController
{
    public function actionRegions_select(){
        if(Yii::$app->request->post()){
            $val=Yii::$app->request->post('val'); $val=explode("-",$val); $val=array_filter($val);
            $return='';
            $imported=[];
            foreach($val as $row){
                if(isset($this->regions[$row]) && !in_array($row,$imported) ){
                    $return.='<li><a data-id="'.$row.'" href="javascript:void(0);" class="remove ryn"></a>'.$this->regions[$row].'</li>';
                    $imported[]=$row;
                }
            }
            return $return;
        }
    }
    public function actionMetros_select(){
        if(Yii::$app->request->post()){
            $val=Yii::$app->request->post('val'); $val=explode("-",$val); $val=array_filter($val);
            $return='';
            foreach($val as $row){
                if(isset($this->metros[$row])) $return.='<li><a data-id="'.$row.'" href="javascript:void(0);" class="remove mtr"></a>'.$this->metros[$row].'</li>';
            }
            return $return;
        }
    }
    public function actionSettlements_select(){
        if(Yii::$app->request->post()){
            $val=Yii::$app->request->post('val'); $val=explode("-",$val); $val=array_filter($val);
            $return='';
            foreach($val as $row){
                if(isset($this->settlements[$row])) $return.='<li><a data-id="'.$row.'" href="javascript:void(0);" class="remove qsb"></a>'.$this->settlements[$row].'</li>';
            }
            return $return;
        }
    }
    public function actionMarks_select(){
        if(Yii::$app->request->post()){
            $val=Yii::$app->request->post('val'); $val=explode("-",$val); $val=array_filter($val);
            $return='';
            foreach($val as $row){
                if(isset($this->marks[$row])) $return.='<li><a data-id="'.$row.'" href="javascript:void(0);" class="remove nsgh"></a>'.$this->marks[$row].'</li>';
            }
            return $return;
        }
    }

    public function actionIndex($cacheUpdate=1)
    {
        if($cacheUpdate==1) Yii::$app->cache->flush();

        $cacheName='vip1'; $vip1=Yii::$app->cache->get($cacheName);
        if($vip1===false){
            $vip1=Announces::find()->where('sort_premium>0 and status=1 and announce_type=1')->orderBy(['announce_date'=>SORT_DESC])->asArray()->all();
            Yii::$app->cache->set($cacheName,$vip1,$this->cacheTimeDay);
        }
        $cacheName='vip2'; $vip2=Yii::$app->cache->get($cacheName);
        if($vip2===false){
            $vip2=Announces::find()->where('sort_premium>0 and status=1 and announce_type=2')->orderBy(['announce_date'=>SORT_DESC])->asArray()->all();
            Yii::$app->cache->set($cacheName,$vip2,$this->cacheTimeDay);
        }

        for($i=1;$i<=10;$i++){
            $cacheName='tip'.$i; $var='tip'.$i; $$var=Yii::$app->cache->get($cacheName);
            if($$var===false){
                if($i<9 || $i==10) $$var=Announces::find()->where('status=1 and property_type='.$i.' and announce_type=1');
                else $$var=Announces::find()->where('status=1 and country!=1 and cover !="" and announce_type=1');
                $$var=$this->setSorting($$var,'home'); $$var=$$var->asArray()->limit(5)->all();
                Yii::$app->cache->set($cacheName,$$var,$this->cacheTimeDay);
            }
        }

        return $this->render('index',[
            'vip1'=>$vip1,
            'vip2'=>$vip2,
            'tip1'=>$tip1,
            'tip2'=>$tip2,
            'tip3'=>$tip3,
            'tip4'=>$tip4,
            'tip5'=>$tip5,
            'tip6'=>$tip6,
            'tip7'=>$tip7,
            'tip8'=>$tip8,
            'tip9'=>$tip9,
            'tip10'=>$tip10,
        ]);
    }

    public function actionGet_home_announces($property_type,$announce_type,$limit,$page=1){
        $cacheName='HomeAnnounces_'.$property_type.'_'.$announce_type.'_'.$limit.'_'.$page;
        $start=$page*$limit-$limit;
        $announces=Yii::$app->cache->get($cacheName);
        if($announces===false){
            $announces=Announces::find()->where(['status'=>1,'announce_type'=>$announce_type]);
            if($property_type=='vip' || $property_type=='vip2') $announces->andWhere('sort_premium>0')->orderBy(['announce_date'=>SORT_DESC]);
            else{
                $announces=$this->setSorting($announces,'home');
                if($property_type<9 || $property_type==10) $announces=$announces->andWhere(['property_type'=>$property_type]);
                else $announces=$announces->andWhere('country!=1 and cover !=""');
                $announces=$announces->offset($start)->limit($limit);
            }
            $announces=$announces->asArray()->all();
            Yii::$app->cache->set($cacheName,$announces,$this->cacheTimeDay);
        }

        $return='';
        if($property_type=='vip' || $property_type=='vip2') $return.='<div class="ticket-item premium-ticket">
			<div class="ticket-photo pr"><a href="javascript:void(0);" class="premium-l">'.Yii::t('app','lang249').'</a></div>
			<div class="price-ticket">'.$this->packagePrices["announce_premium10"].' '.Yii::t('app','lang285').'</div>
			<div class="description-ticket">'.Yii::t('app','lang286').'</div>
		</div>';
        foreach($announces as $row)
        {
            if($row["urgently"]>0) $urgently='<span class="urgently">'.Yii::t('app','lang196').'</span>'; else $urgently='';
            $title=$this->titleGenerator('az',$row["announce_type"],$row["property_type"],$row["space"],$row["room_count"],$row["mark"],$row["settlement"],$row["metro"],$row["region"],$row["city"],$row["country"],$row["address"]);
            $slugTitle=MyFunctionsF::slugGenerator($title);
            $stripTitle=strip_tags($title);

            $infos='';
            if($row["room_count"]>0) $infos.=$row["room_count"].' '.Yii::t('app','lang185').' '.Yii::t('app','property_type'.$row["property_type"]);
            elseif($row["property_type"]==6 || $row["property_type"]==8) $infos.=$row["space"].' '.Yii::t('app','lang217').' '.Yii::t('app','property_type'.$row["property_type"]);
            elseif($row["property_type"]==7) $infos.=$row["space"].' '.Yii::t('app','lang158').' '.Yii::t('app','property_type'.$row["property_type"]);
            else $infos.=Yii::t('app','property_type'.$row["property_type"]);
            $infos.=', ';

            if($row["settlement"]>0) $infos.=$this->settlements[$row["settlement"]];
            elseif($row["metro"]>0) $infos.=$this->metros[$row["metro"]];
            elseif($row["region"]>0) $infos.=$this->regions[$row["region"]];
            else $infos.=$this->cities[$row["city"]];

            if($row["announce_type"]==2)
            {
                if($row["rent_type"]==1)
                    $rent_type = " / gün";
                elseif($row["rent_type"]==2)
                    $rent_type = " / ay";
                else
                    $rent_type = "";
            }
            else
                $rent_type = "";

            $return.='<div class="ticket-item">
                <a href="'.Url::to(['/'.$row["id"].'-'.$slugTitle.'.html']).'" title="'.$stripTitle.'">
                    '.$urgently.'
                    <div class="ticket-photo">
                        <img src="'.MyFunctionsF::getImageUrl().'/'.$row["cover"].'" alt="'.$stripTitle.'" title="'.$stripTitle.'" >
                    </div>
                    <div class="price-ticket">'.number_format($row["price"],0,'.',' ').' '.Yii::t('app','lang149').$rent_type.'</div>
                    <div class="description-ticket">'.$infos.'</div>
                </a>
            </div>';
        }
        return $return;
    }


    public function actionError(){
        return $this->redirect(Url::to(['/']));
        //return $this->render('error');
    }

    public function actionLang($lang){
        if(is_dir(Yii::$app->basePath.'/../common/messages/'.$lang) && !empty($lang) ) { Yii::$app->session["language"]=$lang; Yii::$app->cache->flush(); }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionLogout(){
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actions(){
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function beforeAction($action) {
        $this->checkMobileRedirect(intval(Yii::$app->request->get('full')));
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
}
