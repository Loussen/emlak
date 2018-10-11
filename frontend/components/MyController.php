<?php

namespace frontend\components;
use backend\models\Cities;
use backend\models\Countries;
use backend\models\Announces;
use backend\models\Metros;
use backend\models\PackagePrices;
use backend\models\Regions;
use backend\models\Settlements;
use backend\models\Users;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use backend\models\Settings;
use backend\models\Banners;
use backend\models\Contact;
use backend\models\Pages;
use backend\models\Marks;
use backend\models\CountAnnounces;
use backend\models\Apartments;
use yii\helpers\Url;


class MyController extends Controller {

    public $banners;
    public $infoContact;
    public $userInfo=false;
    public $userAnnounces0;    // gozlemede
    public $userAnnounces1;    // aktiv
    public $userAnnounces2;    // bitmis
    public $userAnnounces2_rows=[];    // bitmis
    public $userAnnounces3;    // tesdiq edilmemiw
    public $userAnnounces4;   			 // silinmiw
	public $userAnnounces4_rows=[];    // silinmiw
    public $cacheTime=600;
    public $cacheTimeHour=600;
    public $cacheTimeDay=86400;
    public $cacheTimeHalfDay=43200;
    public $countries=[];
    public $cities=[];
    public $regions=[];
    public $settlements=[];
    public $metros=[];
    public $marks=[];
    public $packagePrices;
	public $siteUrl='https://emlak.az';
	public $mobileSiteUrl='https://m.emlak.az';
	public $getImageUrl='https://emlak.az/images';
	public $siteTitle;
	public $siteDescription;
	public $siteKeywords;
	public $menuAnnouncesCount0=0;
	public $menuAnnouncesCount1=0;
	public $menuAnnouncesCount2=0;
	public $menuAnnouncesCount3=0;
	public $menuAnnouncesCount4=0;
	public $menuAllAnnouncesCount=0;
	public $menuAnnouncesCountEdited=0;
	public $newFbShared=0;
	public $newFoward=0;
	public $newSearchFoward=0;
	public $newUrgently=0;
	public $newPremium=0;
	public $adminLoggedInfo=[];
	
	public $ys1; public $ys2; public $ys3; public $ys4; public $ys5; public $yi1; public $yi2; public $yi3; public $yi4; public $yi5;
	public $ks1; public $ks2; public $ks3; public $ks4; public $ks5; public $ki1; public $ki2; public $ki3; public $ki4; public $ki5;
	public $ts1; public $ts2; public $ts3; public $ts4; public $ts5; public $ts6; public $ts7; public $ts8;public $ts10; public $tsx; public $tops; public $topi;
	public $ti1; public $ti2; public $ti3; public $ti4; public $ti5; public $ti6; public $ti7; public $ti8;public $ti10; public $tix; public $yasayis;
	public $s24_1; public $s24_2; public $s24_3; public $s24_4; public $s24_5; public $s24_6; public $s24_7; public $s24_8; public $s24_x;
	public $s7_1; public $s7_2; public $s7_3; public $s7_4; public $s7_5; public $s7_6; public $s7_7; public $s7_8; public $s7_x;
	public $s30_1; public $s30_2; public $s30_3; public $s30_4; public $s30_5; public $s30_6; public $s30_7; public $s30_8; public $s30_x;
	public $umumi1; public $umumi2; public $umumi3; public $umumi4; public $umumi5; public $umumi6; public $umumi7; public $umumi8; public $umumi10; public $umumix;

    public function init(){
        $this->getCurrentLanguage();
        $this->getBanners();
        $this->getContacts();
		if(isset(Yii::$app->session["logged_id"]) && isset(Yii::$app->session["logged_password"]) ) $this->getUserInfo();
		if(isset(Yii::$app->session["logged_admin_id"]) && isset(Yii::$app->session["logged_admin_password"]) ) $this->getUserInfoAdmin();
        
        $this->getCountries();
        $this->getCities();
        $this->getRegions();
        $this->getSettlements();
        $this->getMetros();
        $this->getMarks();
			//$this->getClearTempImages();
			//$this->getEndedAnnounces();
        $this->getCountInfos();
		$this->getPackagePrices();
        //$this->getCountWrite();
    }
	
	public function checkMobileRedirect($full=0){
		if($full==1) Yii::$app->session["comp_permission"]=1;
		if(!Yii::$app->mobileDetect->isDescktop() && Yii::$app->session["comp_permission"]==''){
			return $this->redirect($this->mobileSiteUrl.Url::current());
		}
	}
	
	public function getTags($limit){
		$case_order = 'CASE WHEN status>0 then status END DESC, rand()';
		$tags=Yii::$app->db->createCommand("select link_, title_ from seo_manual_inner order by $case_order limit $limit")->queryAll();
		return $tags;
	}
	
	public function getUserInfoAdmin($arg=''){
		$id=intval(Yii::$app->session["logged_admin_id"]);
		$ps=self::safe(Yii::$app->session["logged_admin_password"]);
		$check=Yii::$app->db->createCommand("select * from user where id='$id' ")->queryAll();
		if(!empty($check)){
			if($ps==md5(md5($check[0]["ps"]).date("d.m.Y"))) $this->adminLoggedInfo=$check;
			if($arg!='') return $this->adminLoggedInfo[0][$arg];
		}
	}
	
	public static function safe( $value ) {
      $value=htmlentities( $value, ENT_QUOTES, 'utf-8' );
	  $value=addslashes($value);
	  $value=strip_tags($value);
	  $value=html_entity_decode($value);
	  $value=htmlspecialchars($value);
	  $from=['\\', "\0", "\n", "\r", "'", '"', "\x1a", "\x00"]; $to=['\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z',"\\0"];
	  $value=str_replace($from, $to, $value);
      return $value;					
    }
	
	public function getNewCount(){
		$this->menuAnnouncesCount0=Yii::$app->db->createCommand("select count(id) from announces where status=0")->queryScalar();
		$this->menuAnnouncesCount1=Yii::$app->db->createCommand("select count(id) from announces where status=1")->queryScalar();
		$this->menuAnnouncesCount2=Yii::$app->db->createCommand("select count(id) from announces where status=2")->queryScalar();
		$this->menuAnnouncesCount3=Yii::$app->db->createCommand("select count(id) from announces where status=3")->queryScalar();
		$this->menuAnnouncesCount4=Yii::$app->db->createCommand("select count(id) from announces where status=4")->queryScalar();
		$this->menuAnnouncesCountEdited=Yii::$app->db->createCommand("select count(id) from announces_edited")->queryScalar();
		$this->newFbShared=Yii::$app->db->createCommand("select count(id) from announces_share")->queryScalar();
		$this->newFoward=Yii::$app->db->createCommand("select count(id) from announces where sort_foward>0")->queryScalar();
		$this->newSearchFoward=Yii::$app->db->createCommand("select count(id) from announces where sort_search>0")->queryScalar();
		$this->newUrgently=Yii::$app->db->createCommand("select count(id) from announces where urgently>0")->queryScalar();
		$this->newPremium=Yii::$app->db->createCommand("select count(id) from announces where sort_premium>0")->queryScalar();

        $count = 0;
        foreach(Yii::$app->params["fullAnnouncesArchives"] as $table)
        {
            $tb='backend\models\\'.$table;

            $announces_count=$tb::find()->count('id');
            $count+=$announces_count;
        }
        $this->menuAllAnnouncesCount = $count;
	}
	
	function getCountWrite(){
		$time=time(); $son24=$time-86400; $son7=$time-604800; $son30=$time-2592000;
		
		$ys1=Yii::$app->db->createCommand("select count(id) from announces where property_type=1 and status=1 and announce_type=1 and country=1 and room_count=1")->queryScalar();
        $ys2=Yii::$app->db->createCommand("select count(id) from announces where property_type=1 and status=1 and announce_type=1 and country=1 and room_count=2")->queryScalar();
        $ys3=Yii::$app->db->createCommand("select count(id) from announces where property_type=1 and status=1 and announce_type=1 and country=1 and room_count=3")->queryScalar();
        $ys4=Yii::$app->db->createCommand("select count(id) from announces where property_type=1 and status=1 and announce_type=1 and country=1 and room_count=4")->queryScalar();
        $ys5=Yii::$app->db->createCommand("select count(id) from announces where property_type=1 and status=1 and announce_type=1 and country=1 and room_count>=5")->queryScalar();
		
		$yi1=Yii::$app->db->createCommand("select count(id) from announces where property_type=1 and status=1 and announce_type=2 and country=1 and room_count=1")->queryScalar();
		$yi2=Yii::$app->db->createCommand("select count(id) from announces where property_type=1 and status=1 and announce_type=2 and country=1 and room_count=2")->queryScalar();
		$yi3=Yii::$app->db->createCommand("select count(id) from announces where property_type=1 and status=1 and announce_type=2 and country=1 and room_count=3")->queryScalar();
		$yi4=Yii::$app->db->createCommand("select count(id) from announces where property_type=1 and status=1 and announce_type=2 and country=1 and room_count=4")->queryScalar();
		$yi5=Yii::$app->db->createCommand("select count(id) from announces where property_type=1 and status=1 and announce_type=2 and country=1 and room_count>=5")->queryScalar();
		
		$ks1=Yii::$app->db->createCommand("select count(id) from announces where property_type=2 and status=1 and announce_type=1 and country=1 and room_count=1")->queryScalar();
		$ks2=Yii::$app->db->createCommand("select count(id) from announces where property_type=2 and status=1 and announce_type=1 and country=1 and room_count=2")->queryScalar();
		$ks3=Yii::$app->db->createCommand("select count(id) from announces where property_type=2 and status=1 and announce_type=1 and country=1 and room_count=3")->queryScalar();
		$ks4=Yii::$app->db->createCommand("select count(id) from announces where property_type=2 and status=1 and announce_type=1 and country=1 and room_count=4")->queryScalar();
		$ks5=Yii::$app->db->createCommand("select count(id) from announces where property_type=2 and status=1 and announce_type=1 and country=1 and room_count>=5")->queryScalar();
		
		$ki1=Yii::$app->db->createCommand("select count(id) from announces where property_type=2 and status=1 and announce_type=2 and country=1 and room_count=1")->queryScalar();
		$ki2=Yii::$app->db->createCommand("select count(id) from announces where property_type=2 and status=1 and announce_type=2 and country=1 and room_count=2")->queryScalar();
		$ki3=Yii::$app->db->createCommand("select count(id) from announces where property_type=2 and status=1 and announce_type=2 and country=1 and room_count=3")->queryScalar();
		$ki4=Yii::$app->db->createCommand("select count(id) from announces where property_type=2 and status=1 and announce_type=2 and country=1 and room_count=4")->queryScalar();
		$ki5=Yii::$app->db->createCommand("select count(id) from announces where property_type=2 and status=1 and announce_type=2 and country=1 and room_count>=5")->queryScalar();
		
		$tops=Yii::$app->db->createCommand("select count(id) from announces where property_type>2 and status=1 and announce_type=1")->queryScalar();
		$topi=Yii::$app->db->createCommand("select count(id) from announces where property_type>2 and status=1 and announce_type=2")->queryScalar();
		$yasayis=Yii::$app->db->createCommand("select count(id) from apartments where status=1")->queryScalar();
		
		$ts1=$ys1+$ys2+$ys3+$ys4+$ys5; $ts2=$ks1+$ks2+$ks3+$ks4+$ks5;
		$ts3=Yii::$app->db->createCommand("select count(id) from announces where property_type=3 and status=1 and announce_type=1 and country=1")->queryScalar();
		$ts4=Yii::$app->db->createCommand("select count(id) from announces where property_type=4 and status=1 and announce_type=1 and country=1")->queryScalar();
		$ts5=Yii::$app->db->createCommand("select count(id) from announces where property_type=5 and status=1 and announce_type=1 and country=1")->queryScalar();
		$ts6=Yii::$app->db->createCommand("select count(id) from announces where property_type=6 and status=1 and announce_type=1 and country=1")->queryScalar();
		$ts7=Yii::$app->db->createCommand("select count(id) from announces where property_type=7 and status=1 and announce_type=1 and country=1")->queryScalar();
		$ts8=Yii::$app->db->createCommand("select count(id) from announces where property_type=8 and status=1 and announce_type=1 and country=1")->queryScalar();
		$ts10=Yii::$app->db->createCommand("select count(id) from announces where property_type=10 and status=1 and announce_type=1 and country=1")->queryScalar();
		$tsx=Yii::$app->db->createCommand("select count(id) from announces where status=1 and announce_type=1 and country>1")->queryScalar();
		
		$ti1=$yi1+$yi2+$yi3+$yi4+$yi5; $ti2=$ki1+$ki2+$ki3+$ki4+$ki5;
		$ti3=Yii::$app->db->createCommand("select count(id) from announces where property_type=3 and status=1 and announce_type=2 and country=1")->queryScalar();
		$ti4=Yii::$app->db->createCommand("select count(id) from announces where property_type=4 and status=1 and announce_type=2 and country=1")->queryScalar();
		$ti5=Yii::$app->db->createCommand("select count(id) from announces where property_type=5 and status=1 and announce_type=2 and country=1")->queryScalar();
		$ti6=Yii::$app->db->createCommand("select count(id) from announces where property_type=6 and status=1 and announce_type=2 and country=1")->queryScalar();
		$ti7=Yii::$app->db->createCommand("select count(id) from announces where property_type=7 and status=1 and announce_type=2 and country=1")->queryScalar();
		$ti8=Yii::$app->db->createCommand("select count(id) from announces where property_type=8 and status=1 and announce_type=2 and country=1")->queryScalar();
		$ti10=Yii::$app->db->createCommand("select count(id) from announces where property_type=10 and status=1 and announce_type=2 and country=1")->queryScalar();
		$tix=Yii::$app->db->createCommand("select count(id) from announces where status=1 and announce_type=2 and country>1")->queryScalar();

		$umumi1=$ts1+$ti1; $umumi2=$ts2+$ti2; $umumi3=$ts3+$ti3; $umumi4=$ts4+$ti4; $umumi5=$ts5+$ti5; $umumi6=$ts6+$ti6; $umumi7=$ts7+$ti7;
		$umumi8=$ts8+$ti8; $umumi10=$ts10+$ti10; $umumix=$tsx+$tix;

		$s24_1=Yii::$app->db->createCommand("select count(id) from announces where property_type=1 and status=1 and country=1 and announce_date>'$son24' ")->queryScalar();
		$s24_2=Yii::$app->db->createCommand("select count(id) from announces where property_type=2 and status=1 and country=1 and announce_date>'$son24' ")->queryScalar();
		$s24_3=Yii::$app->db->createCommand("select count(id) from announces where property_type=3 and status=1 and country=1 and announce_date>'$son24' ")->queryScalar();
		$s24_4=Yii::$app->db->createCommand("select count(id) from announces where property_type=4 and status=1 and country=1 and announce_date>'$son24' ")->queryScalar();
		$s24_5=Yii::$app->db->createCommand("select count(id) from announces where property_type=5 and status=1 and country=1 and announce_date>'$son24' ")->queryScalar();
		$s24_6=Yii::$app->db->createCommand("select count(id) from announces where property_type=6 and status=1 and country=1 and announce_date>'$son24' ")->queryScalar();
		$s24_7=Yii::$app->db->createCommand("select count(id) from announces where property_type=7 and status=1 and country=1 and announce_date>'$son24' ")->queryScalar();
		$s24_8=Yii::$app->db->createCommand("select count(id) from announces where property_type=8 and status=1 and country=1 and announce_date>'$son24' ")->queryScalar();
		$s24_x=Yii::$app->db->createCommand("select count(id) from announces where country>1 and status=1 and announce_date>'$son24' ")->queryScalar();
		
		$s7_1=Yii::$app->db->createCommand("select count(id) from announces where property_type=1 and status=1 and country=1 and announce_date>'$son7' ")->queryScalar();
		$s7_2=Yii::$app->db->createCommand("select count(id) from announces where property_type=2 and status=1 and country=1 and announce_date>'$son7' ")->queryScalar();
		$s7_3=Yii::$app->db->createCommand("select count(id) from announces where property_type=3 and status=1 and country=1 and announce_date>'$son7' ")->queryScalar();
		$s7_4=Yii::$app->db->createCommand("select count(id) from announces where property_type=4 and status=1 and country=1 and announce_date>'$son7' ")->queryScalar();
		$s7_5=Yii::$app->db->createCommand("select count(id) from announces where property_type=5 and status=1 and country=1 and announce_date>'$son7' ")->queryScalar();
		$s7_6=Yii::$app->db->createCommand("select count(id) from announces where property_type=6 and status=1 and country=1 and announce_date>'$son7' ")->queryScalar();
		$s7_7=Yii::$app->db->createCommand("select count(id) from announces where property_type=7 and status=1 and country=1 and announce_date>'$son7' ")->queryScalar();
		$s7_8=Yii::$app->db->createCommand("select count(id) from announces where property_type=8 and status=1 and country=1 and announce_date>'$son7' ")->queryScalar();
		$s7_x=Yii::$app->db->createCommand("select count(id) from announces where country>1 and status=1 and announce_date>'$son7' ")->queryScalar();
		
		$s30_1=Yii::$app->db->createCommand("select count(id) from announces where property_type=1 and status=1 and country=1 and announce_date>'$son30' ")->queryScalar();
		$s30_2=Yii::$app->db->createCommand("select count(id) from announces where property_type=2 and status=1 and country=1 and announce_date>'$son30' ")->queryScalar();
		$s30_3=Yii::$app->db->createCommand("select count(id) from announces where property_type=3 and status=1 and country=1 and announce_date>'$son30' ")->queryScalar();
		$s30_4=Yii::$app->db->createCommand("select count(id) from announces where property_type=4 and status=1 and country=1 and announce_date>'$son30' ")->queryScalar();
		$s30_5=Yii::$app->db->createCommand("select count(id) from announces where property_type=5 and status=1 and country=1 and announce_date>'$son30' ")->queryScalar();
		$s30_6=Yii::$app->db->createCommand("select count(id) from announces where property_type=6 and status=1 and country=1 and announce_date>'$son30' ")->queryScalar();
		$s30_7=Yii::$app->db->createCommand("select count(id) from announces where property_type=7 and status=1 and country=1 and announce_date>'$son30' ")->queryScalar();
		$s30_8=Yii::$app->db->createCommand("select count(id) from announces where property_type=8 and status=1 and country=1 and announce_date>'$son30' ")->queryScalar();
		$s30_x=Yii::$app->db->createCommand("select count(id) from announces where country>1 and status=1 and announce_date>'$son30' ")->queryScalar();

		$write=
		'tops='.$tops.'-'.'topi='.$topi.'-'.'yasayis='.$yasayis.'-'.
		'ys1='.$ys1.'-'.'ys2='.$ys2.'-'.'ys3='.$ys3.'-'.'ys4='.$ys4.'-'.'ys5='.$ys5.'-'.
		'yi1='.$yi1.'-'.'yi2='.$yi2.'-'.'yi3='.$yi3.'-'.'yi4='.$yi4.'-'.'yi5='.$yi5.'-'.
		'ks1='.$ks1.'-'.'ks2='.$ks2.'-'.'ks3='.$ks3.'-'.'ks4='.$ks4.'-'.'ks5='.$ks5.'-'.
		'ki1='.$ki1.'-'.'ki2='.$ki2.'-'.'ki3='.$ki3.'-'.'ki4='.$ki4.'-'.'ki5='.$ki5.'-'.
		'ts1='.$ts1.'-'.'ts2='.$ts2.'-'.'ts3='.$ts3.'-'.'ts4='.$ts4.'-'.'ts5='.$ts5.'-'.'ts6='.$ts6.'-'.'ts7='.$ts7.'-'.'ts8='.$ts8.'-'.'ts10='.$ts10.'-'.'tsx='.$tsx.'-'.
		'ti1='.$ti1.'-'.'ti2='.$ti2.'-'.'ti3='.$ti3.'-'.'ti4='.$ti4.'-'.'ti5='.$ti5.'-'.'ti6='.$ti6.'-'.'ti7='.$ti7.'-'.'ti8='.$ti8.'-'.'ti10='.$ti10.'-'.'tix='.$tix.'-'.
		'umumi1='.$umumi1.'-'.'umumi2='.$umumi2.'-'.'umumi3='.$umumi3.'-'.'umumi4='.$umumi4.'-'.
		's24_1='.$s24_1.'-'.'s24_2='.$s24_2.'-'.'s24_3='.$s24_3.'-'.'s24_4='.$s24_4.'-'.'s24_5='.$s24_5.'-'.'s24_6='.$s24_6.'-'.'s24_7='.$s24_7.'-'.'s24_8='.$s24_8.'-'.'s24_x='.$s24_x.'-'.
        's7_1='.$s7_1.'-'.'s7_2='.$s7_2.'-'.'s7_3='.$s7_3.'-'.'s7_4='.$s7_4.'-'.'s7_5='.$s7_5.'-'.'s7_6='.$s7_6.'-'.'s7_7='.$s7_7.'-'.'s7_8='.$s7_8.'-'.'s7_x='.$s7_x.'-'.
        'umumi5='.$umumi5.'-'.'umumi6='.$umumi6.'-'.'umumi7='.$umumi7.'-'.'umumi8='.$umumi8.'-'.'umumi10='.$umumi10.'-'.'umumix='.$umumix.'-'.
        's30_1='.$s30_1.'-'.'s30_2='.$s30_2.'-'.'s30_3='.$s30_3.'-'.'s30_4='.$s30_4.'-'.'s30_5='.$s30_5.'-'.'s30_6='.$s30_6.'-'.'s30_7='.$s30_7.'-'.'s30_8='.$s30_8.'-'.'s30_x='.$s30_x;
		Yii::$app->db->createCommand("update count_announces set count_announces='$write' where id=1 ")->execute();
	}
	
	public function getCountInfos(){
		$cacheName='count_announces'; $count_announces=Yii::$app->cache->get($cacheName);
        if($count_announces===false){
            $count_announces=CountAnnounces::findOne(1); $count_announces=explode("-",$count_announces->count_announces);
			Yii::$app->cache->set($cacheName,$count_announces,$this->cacheTimeDay);
        }
		foreach($count_announces as $key){
			$seprator=explode("=",$key);
			$this->$seprator[0]=$seprator[1];
		}
	}

	public function getCacheUpdate($userEmail=''){
		if($userEmail!=''){
			$announce_count=Yii::$app->db->createCommand("select count(id) from announces where email='$userEmail' and status=1")->queryScalar();
			Yii::$app->db->createCommand("update users set announce_count='$announce_count' where email='$userEmail' ")->execute();
		}
		
		//file_get_contents($this->siteUrl.'/?cacheUpdate=1');
		Yii::$app->cache->flush();
		$this->getCountWrite();
	}
	
	public function getClearTempImages(){
        $cacheName='clearTempImages'; $cron=Yii::$app->cache->get($cacheName);
        if($cron===false){
            $cron=time(); Yii::$app->cache->set($cacheName,$cron,$this->cacheTimeHalfDay);
			file_get_contents($this->siteUrl.'/cron/cron.php?process_type=images');
        }
    }
	public function getEndedAnnounces(){
        $cacheName='getEndedAnnounces'; $cron=Yii::$app->cache->get($cacheName);
        if($cron===false){
            $cron=time(); Yii::$app->cache->set($cacheName,$cron,$this->cacheTimeDay);
			file_get_contents($this->siteUrl.'/cron/cron.php?process_type=ann');
        }
    }

    public function getCurrentLanguage(){
        $cacheName='settings'; $settings=Yii::$app->cache->get($cacheName);
        if($settings===false){
            $settings=Settings::findOne(1);
            Yii::$app->cache->set($cacheName,$settings,$this->cacheTimeDay);
        }
        $current_lang=Yii::$app->session["language"];
        if(!is_dir(Yii::$app->basePath.'/../common/messages/'.$current_lang) || empty($current_lang) ) $current_lang=$settings->default_language;
		$this->siteTitle=$settings->s_title;
		$this->siteDescription=$settings->s_description;
		$this->siteKeywords=$settings->s_keywords;

        Yii::$app->session["language"]=strtolower($current_lang);
        Yii::$app->language=$current_lang;
    }

    public function getBanners(){
        $cacheName='banners'; $this->banners=Yii::$app->cache->get($cacheName);
        if($this->banners===false)
        {
            $this->banners=Banners::find()->orderBy(['id'=>SORT_ASC])->asArray()->all();
            Yii::$app->cache->set($cacheName,$this->banners,$this->cacheTimeDay);
        }
    }

    public function getContacts(){
        $cacheName='contact'; $this->infoContact=Yii::$app->cache->get($cacheName);
        if($this->infoContact===false)
        {
            $this->infoContact=Contact::find()->orderBy(['position'=>SORT_ASC])->asArray()->all();
            Yii::$app->cache->set($cacheName,$this->infoContact,$this->cacheTimeDay);
        }
    }

    public function getPagesInfo($id){
        $cacheName='pages_'.$id; $return=Yii::$app->cache->get($cacheName);
        if($return===false)
        {
            $return=Pages::find()->where(['id'=>$id])->asArray()->one();
            Yii::$app->cache->set($cacheName,$return,$this->cacheTimeDay);
        }
        return $return;
    }

    public function getUserInfo(){
        $cacheName='userInfo'.intval(Yii::$app->session["logged_id"]); $userInfo=Yii::$app->cache->get($cacheName);
        if($userInfo===false){
            $userInfo=Users::find()->where(['id'=>intval(Yii::$app->session["logged_id"]),'password'=>Yii::$app->session["logged_password"]])->one();
            Yii::$app->cache->set($cacheName,$userInfo,$this->cacheTimeDay);
        }
        if(!empty($userInfo) && $userInfo->id==Yii::$app->session["logged_id"] && $userInfo->password==Yii::$app->session["logged_password"]){
            $this->userInfo=$userInfo;
			
			$cacheName='userAnnounces0_'.intval(Yii::$app->session["logged_id"]); $this->userAnnounces0=Yii::$app->cache->get($cacheName);	// gozlemede
			if($this->userAnnounces0===false){
				$this->userAnnounces0=Announces::find()->where(['email'=>$this->userInfo->email,'status'=>0])->count('id');
				Yii::$app->cache->set($cacheName,$this->userAnnounces0,$this->cacheTimeDay);
			}
			$cacheName='userAnnounces1_'.intval(Yii::$app->session["logged_id"]); $this->userAnnounces1=Yii::$app->cache->get($cacheName);	// aktiv
			if($this->userAnnounces1===false){
				$this->userAnnounces1=Announces::find()->where(['email'=>$this->userInfo->email,'status'=>1])->count('id');
				Yii::$app->cache->set($cacheName,$this->userAnnounces1,$this->cacheTimeDay);
			}
			$cacheName='userAnnounces3_'.intval(Yii::$app->session["logged_id"]); $this->userAnnounces3=Yii::$app->cache->get($cacheName);	// tesdiqlenmemiw
			if($this->userAnnounces3===false){
				$this->userAnnounces3=Announces::find()->where(['email'=>$this->userInfo->email,'status'=>3])->count('id');
				Yii::$app->cache->set($cacheName,$this->userAnnounces3,$this->cacheTimeDay);
			}
			
			$cacheName='userAnnounces2_'.intval(Yii::$app->session["logged_id"]); $this->userAnnounces2=Yii::$app->cache->get($cacheName);	// bitmiw
$cacheName2='userAnnounces2_rows_'.intval(Yii::$app->session["logged_id"]); $this->userAnnounces2_rows=Yii::$app->cache->get($cacheName2);	// bitmiw_rows
			if($this->userAnnounces2===false or $this->userAnnounces2_rows===false){
				$count=0;
				$anns=[];
				foreach(Yii::$app->params["fullAnnouncesArchives"] as $table){
					$tb='backend\models\\'.$table;
					$ann_rows=$tb::find()->where(['email'=>$this->userInfo->email,'status'=>2])->orderBy(['announce_date'=>SORT_ASC])->count('id');
					$anns[]=$ann_rows;
					$count+=$ann_rows;
				}
				$this->userAnnounces2=$count;
				$this->userAnnounces2_rows=$anns;
				Yii::$app->cache->set($cacheName,$this->userAnnounces2,$this->cacheTimeDay);
				Yii::$app->cache->set($cacheName2,$this->userAnnounces2_rows,$this->cacheTimeDay);
			}
			$cacheName='userAnnounces4_'.intval(Yii::$app->session["logged_id"]); $this->userAnnounces4=Yii::$app->cache->get($cacheName);	// silinmiw
$cacheName2='userAnnounces4_rows_'.intval(Yii::$app->session["logged_id"]); $this->userAnnounces4_rows=Yii::$app->cache->get($cacheName2);	// silinmiw_rows
			if($this->userAnnounces4===false or $this->userAnnounces4_rows===false){
				$count=0;
				$anns=[];
				foreach(Yii::$app->params["fullAnnouncesArchives"] as $table)
				{
					$tb='backend\models\\'.$table;
					$ann_rows=$tb::find()->where(['email'=>$this->userInfo->email,'status'=>4])->orderBy(['announce_date'=>SORT_ASC])->count('id');
					$anns[]=$ann_rows;
					$count+=$ann_rows;
				}
				$this->userAnnounces4=$count;
				$this->userAnnounces4_rows=$anns;
				Yii::$app->cache->set($cacheName,$this->userAnnounces4,$this->cacheTimeDay);
				Yii::$app->cache->set($cacheName2,$this->userAnnounces4_rows,$this->cacheTimeDay);
			}
        }
        else{
            Yii::$app->cache->delete($cacheName);
            $this->userInfo=false;
            unset(Yii::$app->session["logged_id"]);
            unset(Yii::$app->session["logged_password"]);
        }
    }

    public function getCountries(){
        $cacheName='countries';
        $this->countries=Yii::$app->cache->get($cacheName);
        if($this->countries===false){
            $this->countries=Countries::find()->select(['id','title_'.Yii::$app->language])->orderBy(['title_'.Yii::$app->language=>SORT_ASC])->asArray()->all();
            $this->countries=[0=>'']+ArrayHelper::map($this->countries,'id','title_'.Yii::$app->language);
            Yii::$app->cache->set($cacheName,$this->countries,$this->cacheTimeDay);
        }
    }

    public function getCities(){
        $cacheName='cities';
        $this->cities=Yii::$app->cache->get($cacheName);
        if($this->cities===false)
        {
            $this->cities=Cities::find()->select(['id','title_'.Yii::$app->language])->orderBy(['title_'.Yii::$app->language=>SORT_ASC])->asArray()->all();
            $this->cities=[0=>'']+ArrayHelper::map($this->cities,'id','title_'.Yii::$app->language);
            Yii::$app->cache->set($cacheName,$this->cities,$this->cacheTimeDay);
        }
    }

    public function getRegions(){
        $cacheName='regions';
        $this->regions=Yii::$app->cache->get($cacheName);
        if($this->regions===false)
        {
            $this->regions=Regions::find()->select(['id','title_'.Yii::$app->language])->orderBy(['title_'.Yii::$app->language=>SORT_ASC])->asArray()->all();
            $this->regions=[0=>'']+ArrayHelper::map($this->regions,'id','title_'.Yii::$app->language);
            Yii::$app->cache->set($cacheName,$this->regions,$this->cacheTimeDay);
        }
    }

    public function getSettlements(){
        $cacheName='settlements';
        $this->settlements=Yii::$app->cache->get($cacheName);
        if($this->settlements===false)
        {
            $this->settlements=Settlements::find()->select(['id','title_'.Yii::$app->language])->orderBy(['title_'.Yii::$app->language=>SORT_ASC])->asArray()->all();
            $this->settlements=[0=>'']+ArrayHelper::map($this->settlements,'id','title_'.Yii::$app->language);
            Yii::$app->cache->set($cacheName,$this->settlements,$this->cacheTimeDay);
        }
    }

    public function getMetros(){
        $cacheName='metros';
        $this->metros=Yii::$app->cache->get($cacheName);
        if($this->metros===false)
        {
            $this->metros=Metros::find()->select(['id','title_'.Yii::$app->language])->orderBy(['title_'.Yii::$app->language=>SORT_ASC])->asArray()->all();
            $this->metros=[0=>'']+ArrayHelper::map($this->metros,'id','title_'.Yii::$app->language);
            Yii::$app->cache->set($cacheName,$this->metros,$this->cacheTimeDay);
        }
    }

    public function getMarks(){
        $cacheName='marks';
        $this->marks=Yii::$app->cache->get($cacheName);
        if($this->marks===false)
        {
            $this->marks=Marks::find()->select(['id','title_'.Yii::$app->language])->orderBy(['title_'.Yii::$app->language=>SORT_ASC])->asArray()->all();
            $this->marks=[0=>'']+ArrayHelper::map($this->marks,'id','title_'.Yii::$app->language);
            Yii::$app->cache->set($cacheName,$this->marks,$this->cacheTimeDay);
        }
    }

    public function getPackagePrices(){
        $cacheName='packagePrices';
        $this->packagePrices=Yii::$app->cache->get($cacheName);
        if($this->packagePrices===false){
            $this->packagePrices=PackagePrices::find()->where(['id'=>1])->asArray()->one();
            Yii::$app->cache->set($cacheName,$this->packagePrices,$this->cacheTimeDay);
        }
    }

    public function titleGenerator($lang,$announce_type,$property_type,$space,$room_count,$mark,$settlement,$metro,$region,$city,$country,$address,$format='not_full'){
            if($announce_type==1) $title='Satılır '; else $title='İcarəyə verilir ';
            if($property_type==7) $title.=$space.' sot ';
            else if($property_type==6) $title.=$space.' m<sup>2</sup> ';
            else if($property_type==1 || $property_type==2 || $property_type==5)  $title.=$room_count.' otaqlı '.$space.' m<sup>2</sup> ';
            else  $title.=$room_count.' otaqlı '.$space.' m<sup>2</sup> ';
            $title.=mb_strtolower(Yii::t('app','property_type'.$property_type),'utf-8').' ';

            if($mark!='') { $mark=explode("-",$mark);  $title.=$this->marks[$mark[0]].', '; }
            else if($settlement>0) $title.=$this->settlements[$settlement].', ';
            elseif($metro>0) $title.=$this->metros[$metro].', ';
            elseif($region>0) $title.=$this->regions[$region].', ';
            elseif($city>0) $title.=$this->cities[$city].', ';
			else $title.=$this->countries[$country].', ';
			
			if($format=='full_format') $title.=$address.' ünvanında'; else $title=substr($title,0,strlen($title)-2);
			
            return $title;
    }
	
	public function descGenerator($lang,$metro,$settlement,$region,$city,$repair,$document,$announce_type,$property_type,$space,$room_count,$country){
            // Binəqədi qəsəbəsi ünvanında əla təmirli  3 otaqlı, 380 m2 sahəsi olan kupça ilə  yeni tikili satılır
			if($metro>0) $title=$this->metros[$metro].' metrosunda ';
			elseif($settlement>0) $title=$this->settlements[$settlement].' qəsəbəsi ünvanında ';
			elseif($region>0) $title=$this->regions[$region].' rayonunda ';
			elseif($city>0) $title=$this->cities[$city].' şəhərində ';
			elseif($country>0) $title=$this->countries[$country].' ölkəsində ';
			
			$neyi=['m. ']; $neye=[''];
			$title=str_replace($neyi,$neye,$title);
			
			$title.=mb_strtolower(Yii::t('app','repair'.$repair),'utf-8').' ';
			if($property_type==7) $title.=$space.' sot sahəsi olan ';
            else if($property_type==6) $title.=$space.' m2 sahəsi olan ';
            $title.=$room_count.' otaqlı, '.$space.' m2 sahəsi olan ';
			if($document==1) $title.='kupça ilə ';
			$title.=mb_strtolower(Yii::t('app','property_type'.$property_type),'utf-8').' ';
			if($property_type==1 || $property_type==2) $title.='mənzil ';
			if($announce_type==1) $title.='satılır'; else $title.='icarəyə verilir';

            return $title;
    }

    public function locationsGenerator($marks,$to='profil_elanlar'){
        $return='';
        if($marks!=''){
            $marks=explode('-',$marks);
            foreach($marks as $mark){
				if($to=='profil_elanlar' && isset($this->marks[$mark]) ) $return.='<a href="'.Url::to(['elanlar/?ann_type=3&selected_marks[]='.$mark]).'">'.$this->marks[$mark].'</a>';
                else if($to=='elan_view' && isset($this->marks[$mark]) ) $return.='<h3><a href="'.Url::to(['elanlar/?ann_type=3&selected_marks[]='.$mark]).'">'.$this->marks[$mark].'</a><h3>';
                elseif($to=='backend' && isset($this->marks[$mark]) ) $return.=$this->marks[$mark].', ';
            }
        }
        if($to=='backend' && $return!='') $return=substr($return,0,strlen($return)-2);
        return $return;
    }

    public function getLeftDays($announce_date){
        $this->getPackagePrices();
        return $this->packagePrices["announce_time"]-floor((time()-$announce_date)/86400);
    }

    public function setSorting($obj,$place=''){
        if($place=='search'){
            $column = '(CASE WHEN sort_search>0 then sort_search END)'; $obj->addOrderBy([$column => SORT_DESC]);
            $column = '(CASE WHEN sort_foward>0 then sort_foward END)'; $obj->addOrderBy([$column => SORT_DESC]);
            $column = '(CASE WHEN sort_package>0 then sort_package END)'; $obj->addOrderBy([$column => SORT_DESC]);
        }
        else if($place=='home'){
            $column = '(CASE WHEN sort_foward>0 then sort_foward END)'; $obj->addOrderBy([$column => SORT_DESC]);
            $column = '(CASE WHEN sort_package>0 then sort_package END)'; $obj->addOrderBy([$column => SORT_DESC]);
        }
        $obj->addOrderBy(['announce_date' => SORT_DESC]);
        return $obj;
    }
	
	public function setSortingDAO($place=''){
        $column = '';
        if($place=='search'){
            $column .= '
				CASE WHEN sort_search>0 then sort_search END DESC, 
				CASE WHEN sort_foward>0 then sort_foward END DESC, 
				CASE WHEN sort_package>0 then sort_package END DESC,
			';
        }
        else if($place=='home'){
            $column .= '
					CASE WHEN sort_foward>0 then sort_foward END DESC,
					CASE WHEN sort_package>0 then sort_package END DESC,
			';
        }
		$column.=" announce_date DESC";
		$query=" order by ".$column;
        return $query;
    }

}