<?php
namespace frontend\controllers;

use frontend\components\MyController;
use frontend\components\MyFunctionsF;
use backend\models\ArchiveDb;
use backend\models\MobilePackage;
use backend\models\AnnouncesShare;
use Yii;
use frontend\web\payment\classes\filter\filter;
use frontend\web\payment\classes\stub\PaymentGatewayGoldenpayYii;
use yii\helpers\Url;

class CallbackController extends MyController
{
    public function actionIndex(){
        $payment_key = $this->getFilteredParam('payment_key');
		$stub = new PaymentGatewayGoldenpayYii();
		$resp = $stub->getPaymentResult($payment_key);
		if ($resp->status->code == 1 && $resp->checkCount == 0) {
			$description=explode("-",$resp->description);		$id=$description[0]; $desc=$description[1];
			$amount=$resp->amount;
			$time=time();
			if($desc=='premium'){
				$amount/=100; $sort_premium=0;
				if($amount==$this->packagePrices["announce_premium10"]) {$sort_premium=$time+(86400*10); $time_count=10; }
				elseif($amount==$this->packagePrices["announce_premium15"]) {$sort_premium=$time+(86400*15); $time_count=15; }
				elseif($amount==$this->packagePrices["announce_premium30"]) {$sort_premium=$time+(86400*30); $time_count=30; }
				if($sort_premium>0 && $amount>0){
					foreach(Yii::$app->params["fullAnnouncesArchives"] as $tb_name=>$table){
						$tb='backend\models\\'.$table;
						$announce=$tb::find()->where(['id'=>$id])->one();
						if(!empty($announce)) break;
					}
					if(!empty($announce)){
						$muddet=$sort_premium;
						$aa=ceil($muddet/10);		$aa=$aa*10;		$muddet=$muddet+($aa-$muddet);
						if($announce->sort_premium<=$time) $announce->sort_premium=$muddet;
						else $announce->sort_premium=$muddet+($announce->sort_premium-$time);
						$announce->status=1;
						$announce->announce_date=$time;
						$announce->save(false);
						
						$saveArchive=new ArchiveDb();
						if($this->userInfo!=false) $saveArchive->from_='User:'.$this->userInfo->id;
						else $saveArchive->from_='unknow';
						$saveArchive->to_='Announce:'.$id;
						$saveArchive->operation='user_do_premium';
						$saveArchive->mobiles=$announce->mobile;
						$saveArchive->time_count=$time_count;
						$saveArchive->announce_id=$id;
						$saveArchive->price=$amount;
						$saveArchive->create_time=$time;
						$saveArchive->save(false);
						
						if($tb_name!='announces'){
							Yii::$app->db->createCommand("insert into announces select * from $tb_name where id='$id' ")->execute();
							Yii::$app->db->createCommand("delete from $tb_name where id='$id' ")->execute();
						}
						$this->getCacheUpdate();
						Yii::$app->session->setFlash('success',Yii::t('app','lang264'));
						
						echo "<script type='text/javascript'>window.opener.refreshParent();window.close();</script>";
					}
				}
				else echo "<script type='text/javascript'>window.close();</script>";
			}
			elseif($desc=='foward'){
				$amount/=100; $sort_foward=$time+($this->packagePrices["announce_foward_time"]*3600); $time_count=($this->packagePrices["announce_foward_time"]/86400);
				if($amount==$this->packagePrices["announce_foward1"]) $paket=0;
				elseif($amount==$this->packagePrices["announce_foward20"]) $paket=19;
				elseif($amount==$this->packagePrices["announce_foward50"]) $paket=49;
				if($amount>0){
					foreach(Yii::$app->params["fullAnnouncesArchives"] as $tb_name=>$table){
						$tb='backend\models\\'.$table;
						$announce=$tb::find()->where(['id'=>$id])->one();
						if(!empty($announce)) break;
					}
					if(!empty($announce)){
						$muddet=$sort_foward;
						$aa=ceil($muddet/10);		$aa=$aa*10;		$muddet=$muddet+($aa-$muddet);
						if($announce->sort_foward<=$time) $announce->sort_foward=$muddet;
						else $announce->sort_foward=$muddet+($announce->sort_foward-$time);
						$announce->status=1;
						$announce->announce_date=$time;
						$announce->save(false);
						
						$saveArchive=new ArchiveDb();
						if($this->userInfo!=false) $saveArchive->from_='User:'.$this->userInfo->id;
						else $saveArchive->from_='unknow';
						$saveArchive->to_='Announce:'.$id;
						$saveArchive->operation='user_do_foward';
						$saveArchive->mobiles=$announce->mobile;
						$saveArchive->time_count=$time_count;
						$saveArchive->announce_id=$id;
						$saveArchive->price=$amount;
						$saveArchive->create_time=$time;
						$saveArchive->save(false);
						
						if($tb_name!='announces'){
							Yii::$app->db->createCommand("insert into announces select * from $tb_name where id='$id' ")->execute();
							Yii::$app->db->createCommand("delete from $tb_name where id='$id' ")->execute();
						}
						$this->getCacheUpdate();
						Yii::$app->session->setFlash('success',Yii::t('app','lang268'));
						
						echo "<script type='text/javascript'>window.opener.refreshParent();window.close();</script>";
					}
				}
				else echo "<script type='text/javascript'>window.close();</script>";
			}
			elseif($desc=='urgently'){
				$amount/=100; $urgently=$time+(30*86400); $time_count=30;
				if($amount==$this->packagePrices["announce_urgent"]){
					foreach(Yii::$app->params["fullAnnouncesArchives"] as $tb_name=>$table){
						$tb='backend\models\\'.$table;
						$announce=$tb::find()->where(['id'=>$id])->one();
						if(!empty($announce)) break;
					}
					if(!empty($announce)){
						$muddet=$urgently;
						$aa=ceil($muddet/10);		$aa=$aa*10;		$muddet=$muddet+($aa-$muddet);
						if($announce->urgently<=$time) $announce->urgently=$muddet;
						else $announce->urgently=$muddet+($announce->urgently-$time);
						$announce->status=1;
						$announce->announce_date=$time;
						$announce->save(false);
						
						$saveArchive=new ArchiveDb();
						if($this->userInfo!=false) $saveArchive->from_='User:'.$this->userInfo->id;
						else $saveArchive->from_='unknow';
						$saveArchive->to_='Announce:'.$id;
						$saveArchive->operation='user_do_urgently';
						$saveArchive->mobiles=$announce->mobile;
						$saveArchive->time_count=$time_count;
						$saveArchive->announce_id=$id;
						$saveArchive->price=$amount;
						$saveArchive->create_time=$time;
						$saveArchive->save(false);
						
						if($tb_name!='announces'){
							Yii::$app->db->createCommand("insert into announces select * from $tb_name where id='$id' ")->execute();
							Yii::$app->db->createCommand("delete from $tb_name where id='$id' ")->execute();
						}
						$this->getCacheUpdate();
						Yii::$app->session->setFlash('success',Yii::t('app','lang273'));
						
						echo "<script type='text/javascript'>window.opener.refreshParent();window.close();</script>";
					}
				}
				else echo "<script type='text/javascript'>window.close();</script>";
			}
			elseif($desc=='mobile'){
				$mobile=explode("mm",$resp->description); $mobiles=[];
				if(isset($mobile[1]) && !in_array($mobile[1],$mobiles) && trim($mobile[1])!='' ) $mobiles[]=$mobile[1];
				if(isset($mobile[2]) && !in_array($mobile[2],$mobiles) && trim($mobile[2])!='' ) $mobiles[]=$mobile[2];
				if(isset($mobile[3]) && !in_array($mobile[3],$mobiles) && trim($mobile[3])!='' ) $mobiles[]=$mobile[3];
				$mobile=implode("*",$mobiles);
				
				$amount/=100;	$paket=0;
				if($amount==$this->packagePrices["announce_package1"]) $paket=1;
				elseif($amount==$this->packagePrices["announce_package10"]) $paket=10;
				elseif($amount==$this->packagePrices["announce_package50"]) $paket=50;
				if($amount>0 && $paket>0 && $mobile!=''){
					$saveArchive=new ArchiveDb();
					if($this->userInfo!=false) $saveArchive->from_='User:'.$this->userInfo->id;
					else $saveArchive->from_='Mobile:'.$mobile;
					$saveArchive->to_='Announce:'.$id;
					$saveArchive->operation='mobile_get_package';
					$saveArchive->mobiles=$mobile;
					$saveArchive->time_count=$paket;
					$saveArchive->announce_id=$id;
					$saveArchive->price=$amount;
					$saveArchive->create_time=$time;
					$saveArchive->save(false);
					
					$saveMobile=new MobilePackage();
					$saveMobile->mobile=$mobile;
					$saveMobile->balance=$paket;
					$saveMobile->create_time=$time;
					$saveMobile->save(false);
					
					$this->getCacheUpdate();
					
					echo "<script type='text/javascript'>window.opener.refreshParent();window.close();</script>";
				}
				else echo "<script type='text/javascript'>window.close();</script>";
			}
			elseif($desc=='profilPaket'){
				$amount/=100;	$paket=0;
				if($amount==$this->packagePrices["announce_package1"]) $paket=1;
				elseif($amount==$this->packagePrices["announce_package10"]) $paket=10;
				elseif($amount==$this->packagePrices["announce_package50"]) $paket=50;
				if($amount>0 && $paket>0){
					$saveArchive=new ArchiveDb();
					$saveArchive->from_='User:'.$this->userInfo->id;
					$saveArchive->to_='User:'.$this->userInfo->id;
					$saveArchive->operation='profil_get_package';
					$saveArchive->time_count=$paket;
					$saveArchive->announce_id=$id;
					$saveArchive->price=$amount;
					$saveArchive->create_time=$time;
					$saveArchive->save(false);
					
					$this->userInfo->package_announce+=$paket;	$this->userInfo->save(false);
					$this->getCacheUpdate();
					Yii::$app->session->setFlash('success',Yii::t('app','lang272'));
					echo "<script type='text/javascript'>window.opener.refreshParent();window.close();</script>";
				}
				else echo "<script type='text/javascript'>window.close();</script>";
			}
			elseif($desc=='rieltorPaket'){
				$amount/=100;	$paket=0;	$muddet=0;
				if($amount==$this->packagePrices["realtor_premium1"]) { $paket=1; $muddet=$time+(86400*30); }
				elseif($amount==$this->packagePrices["realtor_premium3"]) { $paket=3; $muddet=$time+(86400*90); }
				elseif($amount==$this->packagePrices["realtor_premium6"]) { $paket=6; $muddet=$time+(86400*180); }
				if($amount>0 && $paket>0){
					$saveArchive=new ArchiveDb();
					$saveArchive->from_='User:'.$this->userInfo->id;
					$saveArchive->to_='User:'.$this->userInfo->id;
					$saveArchive->operation='profil_get_rieltorPackage';
					$saveArchive->time_count=$paket.' aylıq';
					$saveArchive->price=$amount;
					$saveArchive->create_time=$time;
					$saveArchive->save(false);
					
					if($this->userInfo->premium<=$time) $this->userInfo->premium=$muddet;
					else $this->userInfo->premium=$muddet+($this->userInfo->premium-$time);
					$this->userInfo->save(false);
					$this->getCacheUpdate();
					Yii::$app->session->setFlash('success',Yii::t('app','lang272'));
					echo "<script type='text/javascript'>window.opener.refreshParent();window.close();</script>";
				}
				else echo "<script type='text/javascript'>window.close();</script>";
			}
			elseif($desc=='searchFoward'){
				$amount/=100; $sort_search=$time+(10*86400); $time_count=10;
				if($amount==$this->packagePrices["announce_search10"]){
					foreach(Yii::$app->params["fullAnnouncesArchives"] as $tb_name=>$table){
						$tb='backend\models\\'.$table;
						$announce=$tb::find()->where(['id'=>$id])->one();
						if(!empty($announce)) break;
					}
					if(!empty($announce)){
						$muddet=$sort_search;
						$aa=ceil($muddet/10);		$aa=$aa*10;		$muddet=$muddet+($aa-$muddet);
						if($announce->sort_search<=$time) $announce->sort_search=$muddet;
						else $announce->sort_search=$muddet+($announce->sort_search-$time);
						$announce->status=1;
						$announce->announce_date=$time;
						$announce->save(false);
						
						$saveArchive=new ArchiveDb();
						if($this->userInfo!=false) $saveArchive->from_='User:'.$this->userInfo->id;
						else $saveArchive->from_='unknow';
						$saveArchive->to_='Announce:'.$id;
						$saveArchive->operation='user_do_searchFoward';
						$saveArchive->mobiles=$announce->mobile;
						$saveArchive->time_count=$time_count;
						$saveArchive->announce_id=$id;
						$saveArchive->price=$amount;
						$saveArchive->create_time=$time;
						$saveArchive->save(false);
						
						if($tb_name!='announces'){
							Yii::$app->db->createCommand("insert into announces select * from $tb_name where id='$id' ")->execute();
							Yii::$app->db->createCommand("delete from $tb_name where id='$id' ")->execute();
						}
						$this->getCacheUpdate();
						Yii::$app->session->setFlash('success',Yii::t('app','lang272'));
						
						echo "<script type='text/javascript'>window.opener.refreshParent();window.close();</script>";
					}
				}
				else echo "<script type='text/javascript'>window.close();</script>";
			}
			elseif($desc=='share'){
				$amount/=100;
				if($amount==$this->packagePrices["announce_share10"]){
					foreach(Yii::$app->params["fullAnnouncesArchives"] as $tb_name=>$table){
						$tb='backend\models\\'.$table;
						$announce=$tb::find()->where(['id'=>$id])->one();
						if(!empty($announce)) break;
					}
					if(!empty($announce)){
						$save=new AnnouncesShare();
						$save->announce_id=$id;
						$save->create_time=$time;
						$save->save(false);
						
						$saveArchive=new ArchiveDb();
						if($this->userInfo!=false) $saveArchive->from_='User:'.$this->userInfo->id;
						else $saveArchive->from_='unknow';
						$saveArchive->to_='Announce:'.$id;
						$saveArchive->operation='user_do_Share';
						$saveArchive->mobiles=$announce->mobile;
						$saveArchive->announce_id=$id;
						$saveArchive->price=$amount;
						$saveArchive->create_time=$time;
						$saveArchive->save(false);
						
						if($tb_name!='announces'){
							Yii::$app->db->createCommand("insert into announces select * from $tb_name where id='$id' ")->execute();
							Yii::$app->db->createCommand("delete from $tb_name where id='$id' ")->execute();
						}
						$this->getCacheUpdate();
						Yii::$app->session->setFlash('success',Yii::t('app','lang272'));
						
						echo "<script type='text/javascript'>window.opener.refreshParent();window.close();</script>";
					}
				}
				else echo "<script type='text/javascript'>window.close();</script>";
			}
			elseif($desc=='imgDownload'){
				$amount/=100;
				if($amount==$this->packagePrices["announce_download"]){
					foreach(Yii::$app->params["fullAnnouncesArchives"] as $tb_name=>$table){
						$tb='backend\models\\'.$table;
						$announce=$tb::find()->where(['id'=>$id])->one();
						if(!empty($announce)) break;
					}
					if(!empty($announce)){
						$saveArchive=new ArchiveDb();
						$saveArchive->from_='User:'.$this->userInfo->id;
						$saveArchive->to_='Announce:'.$id;
						$saveArchive->operation='user_do_imgDownload';
						$saveArchive->announce_id=$id;
						$saveArchive->price=$amount;
						$saveArchive->create_time=$time;
						$saveArchive->save(false);
						
						Yii::$app->session->setFlash('success','zipDownload-'.$id);
						echo "<script type='text/javascript'>window.opener.refreshParent();window.close();</script>";
					}
				}
				else echo "<script type='text/javascript'>window.close();</script>";
			}
			elseif($desc=='all' || $desc=='all_reklam'){
				$amount/=100;			$qaliq_amount=$amount;
				$premium_amount=intval($description[2]); $search_amount=intval($description[3]); $share_amount=intval($description[4]); $urgent_amount=intval($description[5]);
				if($desc=='all_reklam') $foward_amount=intval($description[6]); else $foward_amount=0;
				$true=false;
				foreach(Yii::$app->params["fullAnnouncesArchives"] as $tb_name=>$table){
					$tb='backend\models\\'.$table;
					$announce=$tb::find()->where(['id'=>$id])->one();
					if(!empty($announce)) break;
				}
				if(empty($announce)) { echo "<script type='text/javascript'>window.close();</script>"; exit(); }
				
				if($premium_amount>0 && $qaliq_amount>=$premium_amount){
					// premium
					$sort_premium=0;
					if($premium_amount==$this->packagePrices["announce_premium10"]) {$sort_premium=$time+(86400*10); $time_count=10; }
					elseif($premium_amount==$this->packagePrices["announce_premium15"]) {$sort_premium=$time+(86400*15); $time_count=15; }
					elseif($premium_amount==$this->packagePrices["announce_premium30"]) {$sort_premium=$time+(86400*30); $time_count=30; }
					if($sort_premium>0){
						if(!empty($announce)){
							$muddet=$sort_premium;
							$aa=ceil($muddet/10);		$aa=$aa*10;		$muddet=$muddet+($aa-$muddet);
							$announce->sort_premium=$muddet; $announce->save(false);
							
							$saveArchive=new ArchiveDb();
							if($this->userInfo!=false) $saveArchive->from_='User:'.$this->userInfo->id;
							else $saveArchive->from_='unknow';
							$saveArchive->to_='Announce:'.$id;
							$saveArchive->operation='user_do_premium';
							$saveArchive->mobiles=$announce->mobile;
							$saveArchive->time_count=$time_count;
							$saveArchive->announce_id=$id;
							$saveArchive->price=$premium_amount;
							$saveArchive->create_time=$time;
							$saveArchive->save(false);
							$qaliq_amount-=$premium_amount; $true=true;		
						}
					}
				
				}
				if($search_amount>0 && ($qaliq_amount>=$search_amount || $this->userInfo->package_search>0) ){
					// axtarisda ireli cekmek
					$sort_search=$time+(10*86400); $time_count=10;
					if($search_amount==$this->packagePrices["announce_search10"]){
						if(!empty($announce)){
							$muddet=$sort_search;
							$aa=ceil($muddet/10);		$aa=$aa*10;		$muddet=$muddet+($aa-$muddet);
							$announce->sort_search=$muddet; $announce->save(false);
							
								
							if($this->userInfo!=false && $this->userInfo->package_search>0){
								$this->userInfo->package_search-=1;		$this->userInfo->save(false);
								
								$saveArchive=new ArchiveDb();
								$saveArchive->from_='User:'.$this->userInfo->id;
								$saveArchive->to_='Announce:'.$id;
								$saveArchive->operation='user_do_searchFoward';
								$saveArchive->mobiles=$announce->mobile;
								$saveArchive->time_count=$time_count;
								$saveArchive->announce_id=$id;
								$saveArchive->note='Əməliyyatdan sonrakı paket qalığı: '.$this->userInfo->package_search;
								$saveArchive->create_time=$time;
								$saveArchive->save(false);
							}
							else{
								$saveArchive=new ArchiveDb();
								if($this->userInfo!=false) $saveArchive->from_='User:'.$this->userInfo->id;
								else $saveArchive->from_='unknow';
								$saveArchive->to_='Announce:'.$id;
								$saveArchive->operation='user_do_searchFoward';
								$saveArchive->mobiles=$announce->mobile;
								$saveArchive->time_count=$time_count;
								$saveArchive->announce_id=$id;
								$saveArchive->price=$search_amount;
								$saveArchive->create_time=$time;
								$saveArchive->save(false);
								$true=true;	
								$qaliq_amount-=$search_amount;
							}
						}
					}
				
				}
				if($share_amount>0 && $qaliq_amount>=$share_amount){
					// fb ve isntagram
					if($share_amount==$this->packagePrices["announce_fb"]){
						if(!empty($announce)){
							$save=new AnnouncesShare();
							$save->announce_id=$id;
							$save->create_time=$time;
							$save->save(false);
							
							$saveArchive=new ArchiveDb();
							if($this->userInfo!=false) $saveArchive->from_='User:'.$this->userInfo->id;
							else $saveArchive->from_='unknow';
							$saveArchive->to_='Announce:'.$id;
							$saveArchive->operation='user_do_Share';
							$saveArchive->mobiles=$announce->mobile;
							$saveArchive->announce_id=$id;
							$saveArchive->price=$share_amount;
							$saveArchive->create_time=$time;
							$saveArchive->save(false);
							$qaliq_amount-=$share_amount; $true=true;
						}
					}
				}
				if($urgent_amount>0 && $qaliq_amount>=$urgent_amount){
					// tecili
					$urgently=$time+(30*86400); $time_count=30;
					if($urgent_amount==$this->packagePrices["announce_urgent"]){
						if(!empty($announce)){
							$muddet=$urgently;
							$aa=ceil($muddet/10);		$aa=$aa*10;		$muddet=$muddet+($aa-$muddet);
							$announce->urgently=$muddet; $announce->save(false);
							
							$saveArchive=new ArchiveDb();
							if($this->userInfo!=false) $saveArchive->from_='User:'.$this->userInfo->id;
							else $saveArchive->from_='unknow';
							$saveArchive->to_='Announce:'.$id;
							$saveArchive->operation='user_do_urgently';
							$saveArchive->mobiles=$announce->mobile;
							$saveArchive->time_count=$time_count;
							$saveArchive->announce_id=$id;
							$saveArchive->price=$urgent_amount;
							$saveArchive->create_time=$time;
							$saveArchive->save(false);
							$qaliq_amount-=$share_amount; $true=true;
						}
					}
				}
				if($foward_amount>0 && ($qaliq_amount>=$foward_amount || $this->userInfo->package_foward>0) ){
					// ireli cekmek
					$sort_foward=$time+($this->packagePrices["announce_foward_time"]*3600); $time_count=$this->packagePrices["announce_foward_time"]/24;
					if($foward_amount==$this->packagePrices["announce_foward1"]){
						if(!empty($announce)){
							$muddet=$sort_foward;
							$aa=ceil($muddet/10);		$aa=$aa*10;		$muddet=$muddet+($aa-$muddet);
							$announce->sort_foward=$muddet; $announce->save(false);
								
							if($this->userInfo!=false && $this->userInfo->package_foward>0){
								$this->userInfo->package_foward-=1;		$this->userInfo->save(false);
								
								$saveArchive=new ArchiveDb();
								$saveArchive->from_='User:'.$this->userInfo->id;
								$saveArchive->to_='Announce:'.$id;
								$saveArchive->operation='user_do_foward';
								$saveArchive->mobiles=$announce->mobile;
								$saveArchive->time_count=$time_count;
								$saveArchive->announce_id=$id;
								$saveArchive->note='Əməliyyatdan sonrakı paket qalığı: '.$this->userInfo->package_foward;
								$saveArchive->create_time=$time;
								$saveArchive->save(false);
							}
							else{
								$saveArchive=new ArchiveDb();
								if($this->userInfo!=false) $saveArchive->from_='User:'.$this->userInfo->id;
								else $saveArchive->from_='unknow';
								$saveArchive->to_='Announce:'.$id;
								$saveArchive->operation='user_do_foward';
								$saveArchive->mobiles=$announce->mobile;
								$saveArchive->time_count=$time_count;
								$saveArchive->announce_id=$id;
								$saveArchive->price=$foward_amount;
								$saveArchive->create_time=$time;
								$saveArchive->save(false);
								$true=true;	
								$qaliq_amount-=$foward_amount;
							}
						}
					}
				}
				
				if($true==true){
					$this->getCacheUpdate();
					Yii::$app->session->setFlash('success',Yii::t('app','lang282'));
					echo "<script type='text/javascript'>window.opener.refreshParent();window.close();</script>";
				} else echo "<script type='text/javascript'>window.close();</script>";
			}
			else echo "<script type='text/javascript'>window.close();</script>";
		}
		else {
			Yii::$app->session->setFlash('danger',Yii::t('app','lang265'));
			echo "<script type='text/javascript'>window.opener.refreshParent();window.close();</script>";
		}
    }
	
	public function actionCheck_package_search_foward(){
		if($this->userInfo!=false && $this->userInfo->package_search>0)
			return 'yes_package';
		else
			return 'no_package';
	}
	
	public function actionCheck_package_foward(){
		if($this->userInfo!=false && $this->userInfo->package_foward>0)
			return 'yes_package';
		else
			return 'no_package';
	}
	
	public function actionFoward(){
		if(Yii::$app->request->post() && $this->userInfo!=false){
			$id=Yii::$app->request->post('item');
			foreach(Yii::$app->params["fullAnnouncesArchives"] as $tb_name=>$table){
				$tb='backend\models\\'.$table;
				$announce=$tb::find()->where(['id'=>$id])->one();
				if(!empty($announce)) break;
			}
			if(empty($announce)){
				Yii::$app->session->setFlash('danger',Yii::t('app','lang254'));
				return $this->redirect(['elanlar/index']);
			}
			else{
				$row=$announce;
				$title=$this->titleGenerator('az',$row["announce_type"],$row["property_type"],$row["space"],$row["room_count"],$row["mark"],$row["settlement"],$row["metro"],$row["region"],$row["city"],$row["address"]);
				$slugTitle=MyFunctionsF::slugGenerator($title);
				
				if($this->userInfo->package_foward<=0){
					Yii::$app->session->setFlash('danger',Yii::t('app','lang269'));
					return $this->redirect(Url::to(['/'.$row["id"].'-'.$slugTitle.'.html']));
				}
				
				$time=time();
				$this->userInfo->package_foward-=1; $this->userInfo->save(false);
				
				$muddet=$time+(3600*$this->packagePrices["announce_foward_time"]);
				$announce->announce_date=$time;
				$announce->status=1;
				if($announce->sort_foward<=$time) $announce->sort_foward=$muddet;
				else $announce->sort_foward=$muddet+($announce->sort_foward-$time);
				$announce->save(false);
				
				$saveArchive=new ArchiveDb();
				$saveArchive->from_='User:'.$this->userInfo->id;
				$saveArchive->to_='Announce:'.$id;
				$saveArchive->operation='user_do_foward';
				$saveArchive->mobiles=$announce->mobile;
				$saveArchive->time_count=($this->packagePrices["announce_foward_time"]/24);
				$saveArchive->announce_id=$id;
				$saveArchive->note='Əməliyyatdan sonrakı paket qalığı: '.$this->userInfo->package_foward;
				$saveArchive->create_time=$time;
				$saveArchive->save(false);

				if($tb_name!='announces'){
					Yii::$app->db->createCommand("insert into announces select * from $tb_name where id='$id' ")->execute();
					Yii::$app->db->createCommand("delete from $tb_name where id='$id' ")->execute();
				}
				$this->getCacheUpdate();
				
				Yii::$app->session->setFlash('success',Yii::t('app','lang272'));
				return $this->redirect(Url::to(['/'.$row["id"].'-'.$slugTitle.'.html']));
			}
			
		}
		else $this->redirect(Url::to(['site/index']));
	}
	
	public function actionSearch(){
		if(Yii::$app->request->post() && $this->userInfo!=false){
			$id=Yii::$app->request->post('item');
			foreach(Yii::$app->params["fullAnnouncesArchives"] as $tb_name=>$table){
				$tb='backend\models\\'.$table;
				$announce=$tb::find()->where(['id'=>$id])->one();
				if(!empty($announce)) break;
			}
			if(empty($announce)){
				Yii::$app->session->setFlash('danger',Yii::t('app','lang254'));
				return $this->redirect(['elanlar/index']);
			}
			else{
				$row=$announce;
				$title=$this->titleGenerator('az',$row["announce_type"],$row["property_type"],$row["space"],$row["room_count"],$row["mark"],$row["settlement"],$row["metro"],$row["region"],$row["city"],$row["address"]);
				$slugTitle=MyFunctionsF::slugGenerator($title);
				
				if($this->userInfo->package_search<=0){
					Yii::$app->session->setFlash('danger',Yii::t('app','lang269'));
					return $this->redirect(Url::to(['/'.$row["id"].'-'.$slugTitle.'.html']));
				}
				
				$time=time();
				$this->userInfo->package_search-=1; $this->userInfo->save(false);
				
				$muddet=$time+(86400*10);
				$announce->announce_date=$time;
				$announce->status=1;
				if($announce->sort_search<=$time) $announce->sort_search=$muddet;
				else $announce->sort_search=$muddet+($announce->sort_search-$time);
				$announce->save(false);
				
				$saveArchive=new ArchiveDb();
				$saveArchive->from_='User:'.$this->userInfo->id;
				$saveArchive->to_='Announce:'.$id;
				$saveArchive->operation='user_do_searchFoward';
				$saveArchive->mobiles=$announce->mobile;
				$saveArchive->time_count=$muddet/86400;
				$saveArchive->announce_id=$id;
				$saveArchive->note='Əməliyyatdan sonrakı paket qalığı: '.$this->userInfo->package_search;
				$saveArchive->create_time=$time;
				$saveArchive->save(false);
				
				if($tb_name!='announces'){
					Yii::$app->db->createCommand("insert into announces select * from $tb_name where id='$id' ")->execute();
					Yii::$app->db->createCommand("delete from $tb_name where id='$id' ")->execute();
				}
				$this->getCacheUpdate();
				
				Yii::$app->session->setFlash('success',Yii::t('app','lang272'));
				return $this->redirect(Url::to(['/'.$row["id"].'-'.$slugTitle.'.html']));
			}
			
		}
		else $this->redirect(Url::to(['site/index']));
	}
	
	public function getFilteredParam($param){
		$filterList = array(
			'cardType'    => "/^[v|m]$/",
			'amount'      => '/^[0-9.]*$/',
			'item'        => '/^[a-zA-Z\(\) 0-9\-]*$/',
			'lang'        => '/^(lv|en|ru)$/',
			'payment_key' => '/^[a-zA-Z0-9\-]*$/',
		);
		$filter = $filterList[$param];
		if (is_null($filter) || !is_string($filter)) {
			echo "Filter for this parameter not found: ".$param;
			exit();
		}
		$new_param = filter_input(INPUT_POST, $param, FILTER_SANITIZE_STRING); 
		if ($new_param == null) {
			$new_param = filter_input(INPUT_GET, $param, FILTER_SANITIZE_STRING); 
		}
		if (!preg_match($filter, $new_param)){
			echo "Wrong parameter characters: ".$new_param;
			exit();
		}
		return $new_param;
	}
	
	public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

}
