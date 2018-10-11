<?php
namespace frontend\controllers;

use backend\models\Announces;
use backend\models\AnnouncesEdited;
use backend\models\ArchiveDb;
use backend\models\BlackList;
use backend\models\ImageUpload;
use backend\models\MobilePackage;
use frontend\components\MyController;
use frontend\components\MyFunctionsF;
use Yii;
use yii\helpers\Url;
use yii\validators\EmailValidator;
use yii\web\UploadedFile;

class ElanVerController extends MyController
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex($id=0,$code='',$admin=0, $status=0, $edited=0)
    {
        $this->getPackagePrices();
        Yii::$app->session['temporary_images']=[];
        $edit='';
        $mobile1='';
        $mobile2='';
        $mobile3='';
        // $edited // eger admin redakte edilmiwler siyahisindan bura gelibse...=1

        if($id>0)
        {
            if($admin>0) { $thisCode=MyFunctionsF::codeGeneratorforAdmin($id,$admin); $who='Admin:'.$admin; }
            elseif($this->userInfo!=false) { $thisCode=MyFunctionsF::codeGeneratorforUser($id); $who='User:'.$this->userInfo->email; }
            else { $thisCode=MyFunctionsF::codeGeneratorforUser($id); $who='Announce:'.$id; }

            if ($thisCode!=$code) $this->redirect(Url::toRoute('/'));
            elseif ($edited==1 && $who!='Admin:'.$admin) $this->redirect(Url::toRoute('/'));
            else if(AnnouncesEdited::find()->where(['announce_id'=>$id,'status'=>0])->count('id')>0 && $who!='Admin:'.$admin ){
                Yii::$app->session->setFlash('warning',Yii::t('app','lang206'));
                $this->redirect(Url::toRoute('profil/elanlar?status='.$status));
            }
            else{
                if($edited==0){
					foreach(Yii::$app->params["fullAnnouncesArchives"] as $table){
						$tb='backend\models\\'.$table;
						$edit=$tb::find()->where(['id'=>$id])->one();
						if(!empty($edit)) break;
					}
                }
				else $edit=AnnouncesEdited::find()->where(["announce_id"=>$id])->one();
                if(empty($edit)) $this->redirect(Url::toRoute('/'));
				elseif($edit->status!=1 && $admin==0){		// gozlemede olan elani redakte etmek olmaz
					Yii::$app->session->setFlash('warning',Yii::t('app','lang252'));
					$this->redirect(Url::toRoute('profil/elanlar?status='.$status));
				}
                $mobiles=explode("*",$edit->mobile);
                if(isset($mobiles[0])) $mobile1=$mobiles[0];
                if(isset($mobiles[1])) $mobile2=$mobiles[1];
                if(isset($mobiles[2])) $mobile3=$mobiles[2];

                Yii::$app->session['admin']=$admin;
                Yii::$app->session['code']=$code;
            }
        }
        else{
            Yii::$app->session['admin']=''; Yii::$app->session['code']='';
        }
		
		if($this->userInfo!=false && $edit==''){
			
			$mobiles=explode("***",$this->userInfo->mobile);
			if(isset($mobiles[0])) $mobile1=$mobiles[0];
			if(isset($mobiles[1])) $mobile2=$mobiles[1];
			if(isset($mobiles[2])) $mobile3=$mobiles[2];
		}

        return $this->render('index',[
            'edit'=>$edit,
            'edited'=>$edited,
            'mobile1'=>$mobile1,
            'mobile2'=>$mobile2,
            'mobile3'=>$mobile3,
            'status'=>$status,
            'announceId'=>$id,
        ]);
    }

    public function actionOk($id)
    {
        $this->getPackagePrices();

        return $this->render('ok',[
            'id'=>$id,
        ]);
    }

    public function actionCheck_phone()
    {
        $this->getPackagePrices();

        $mobiles=[];
        $mobile1=addslashes(Yii::$app->request->post('mobile1')); if($mobile1!='') $mobiles[]=$mobile1;
        $mobile2=addslashes(Yii::$app->request->post('mobile2')); if($mobile2!='') $mobiles[]=$mobile2;
        $mobile3=addslashes(Yii::$app->request->post('mobile3')); if($mobile3!='') $mobiles[]=$mobile3;
        $email=addslashes(Yii::$app->request->post('email'));
        $country=intval(Yii::$app->request->post('country'));
        $announce_id=intval(Yii::$app->request->post('announce_id'));
		$edited=intval(Yii::$app->request->post('edited'));
		$editingId=intval(Yii::$app->session["editing_id"]);	$oldInfo='';
		if($editingId>0){
			if($edited==0){
				foreach(Yii::$app->params["fullAnnouncesArchives"] as $table){
					$tb='backend\models\\'.$table;
					$oldInfo=$tb::find()->where(['id'=>$editingId])->one();
					if(!empty($oldInfo)) break;
				}
			}
			else{
				$tb='backend\models\AnnouncesEdited';
				$oldInfo=$tb::find()->where(['announce_id'=>$editingId])->one();
			}
		}
        if($oldInfo=='') $announce_id=0;

        $result[0]=0; // 0=> nomrenin duzgun ve ya yanliw olmagi...  default yanliw goturduk...0
        $result[1]=$this->packagePrices["announce_limit"]; // 1=> nomrenin pulsuz elan yerlewdirme limitin gosterir... default bazadan goturduk...
        $result[2]=0; // 2=> nomrenin elan paketi qalib yoxsa qutarib onu gosterir... default qalmayib goturduk...0
        $result[3]=0; // 5=> nomrenin qara siyahida olub olmamasini deyir... default olaraq qara siyahida deyil...0
        $result[4]=0; // 3=> profilin elan yerlewdirme balansi qalib yoxsa qutarib onu gosterir...  default qalmayib goturduk...0
        $result[5]=0; // 4=> emailin duzgun olub olmamasini yoxlayir. default duzgun deyil goturduk...

        if($country==1)
        {
            //$prefixNumber=['012','018','025','044','050','051','055','070','077'];
            // eger wertlere elave etmek istesen bu kodlari daxil et... // && in_array(substr($mobile1,1,3),$prefixNumber)
            if( $mobile1!='' && strlen($mobile1)%15==0 )  $result[0]='1';
            if( $mobile2!='' && strlen($mobile2)%15==0 )  $result[0]='1';
            if( $mobile3!='' && strlen($mobile3)%15==0 )  $result[0]='1';
        }
        else if($mobile1!='' || $mobile2!='' || $mobile3!='') $result[0]='1';

        //$month_ago=time()-(86400*30);
        foreach($mobiles as $mob)
        {
            $elan_sayi=Announces::find()->select(['id'])->where(['like', 'mobile', $mob])->andWhere('status=1 or status=0 or status=3')->andWhere('insert_type=0')->count();
            $limit=$this->packagePrices["announce_limit"]-$elan_sayi;
            if($announce_id>0 && strpos($oldInfo->mobile,substr($mob,1))>=0) $limit++; // eger editdirse limit sayini 1 dene artirsinki edit ede bile...
            if($limit<$result[1]) $result[1]=$limit;

            $balance=MobilePackage::find()->select(['id'])->where(['like', 'mobile', $mob])->andWhere('balance>0')->count();
            if($balance>0) $result[2]=1;

            $blackList=BlackList::find()->select(['id'])->where(['mobile'=>$mob,'status'=>1])->count();
            if($blackList>0) $result[3]=1;
        }
        if($this->userInfo!=false) $result[4]=intval($this->userInfo->package_announce);
        $validator = new EmailValidator(); if($validator->validate($email)) $result[5]=1;

        return $result[0].'***'.$result[1].'***'.$result[2].'***'.$result[3].'***'.$result[4].'***'.$result[5];
    }

    public function actionMarks_select(){
        if(Yii::$app->request->post())
        {
            $val=Yii::$app->request->post('val'); $val=explode("-",$val); $val=array_filter($val);
            $return='';
            foreach($val as $row)
            {
                if(isset($this->marks[$row])) $return.='<li><a data-id="'.$row.'" href="javascript:void(0);" class="remove"></a>'.$this->marks[$row].'</li>';
            }
            return $return;
        }
    }

    public function actionAdd(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $tmps=UploadedFile::getInstancesByName('files');
            if(!empty($tmps))
            {
                $saveParth='announces/temporary';
                $images=Yii::$app->session["temporary_images"];
                $newImagesThumb=[];
                foreach($tmps as $tmp)
                {
                    $imageName=uniqid(rand(1,99)).'.'.$tmp->extension;
                    $thumbName=uniqid(rand(1,99)).'.'.$tmp->extension;
                    $imageUpload=new ImageUpload();
                    $saved=$imageUpload->save($tmp,$saveParth,$imageName);
                    if($saved)
                    {
                        $images[$thumbName]=$imageName; $newImagesThumb[]=$thumbName;
                        $imageUpload->thumbExport($saveParth.'/'.$imageName,$saveParth.'/thumb/',$thumbName,Announces::THUMB2_IMAGE_WIDTH,Announces::THUMB2_IMAGE_HEIGHT, true);
                    }
                }
                Yii::$app->session["temporary_images"]=$images;

                return implode("~~~",$newImagesThumb);
            }
            else
            {
                $startTime=time()+microtime();
                // insert announce to base
                $edited=intval(Yii::$app->request->post('edited'));
                $mobiles=[];
                $mobile1=addslashes(Yii::$app->request->post('mobile1')); if($mobile1!='') $mobiles[]=$mobile1;
                $mobile2=addslashes(Yii::$app->request->post('mobile2')); if($mobile2!='') $mobiles[]=$mobile2;
                $mobile3=addslashes(Yii::$app->request->post('mobile3')); if($mobile3!='') $mobiles[]=$mobile3;
                $mobile=implode("*",$mobiles);
                $email=addslashes(Yii::$app->request->post('email'));
                $name=addslashes(Yii::$app->request->post('name'));
                $price=addslashes(Yii::$app->request->post('price'));
                $room_count=intval(Yii::$app->request->post('room_count'));                 // free
                $rent_type=intval(Yii::$app->request->post('rent_type'));                   // free
                $property_type=intval(Yii::$app->request->post('property_type'));
                $announce_type=intval(Yii::$app->request->post('announce_type'));
                $country=intval(Yii::$app->request->post('country'));
                $city=intval(Yii::$app->request->post('city'));
                $region=intval(Yii::$app->request->post('region'));
                $settlement=intval(Yii::$app->request->post('settlement'));
                $metro=intval(Yii::$app->request->post('metro'));
                $mark=Yii::$app->request->post('selected_marks'); if($mark!='') $mark=substr($mark,0,strlen($mark)-1);
                $address=addslashes(Yii::$app->request->post('address'));
                $google_map=addslashes(Yii::$app->request->post('google_map'));
                $floor_count=intval(Yii::$app->request->post('floor_count'));               // free
                $current_floor=intval(Yii::$app->request->post('current_floor'));           // free
                $space=addslashes(Yii::$app->request->post('space'));
                $repair=intval(Yii::$app->request->post('repair'));                         // free
                $document=addslashes(Yii::$app->request->post('document'));
                $text=addslashes(Yii::$app->request->post('text'));
                $announcer=intval(Yii::$app->request->post('announcer'));
                $images=Yii::$app->session["temporary_images"];
                $editingId=intval(Yii::$app->session["editing_id"]);
                $rotated=intval(Yii::$app->request->post('rotated'));
                if($editingId>0)
                {
                    if($edited==0){
						foreach(Yii::$app->params["fullAnnouncesArchives"] as $table){
							$tb='backend\models\\'.$table;
							$oldInfo=$tb::find()->where(['id'=>$editingId])->one();
							if(!empty($oldInfo)) break;
						}
                    }
                    else{
                        $tb='backend\models\AnnouncesEdited';
                        $oldInfo=$tb::find()->where(['announce_id'=>$editingId])->one();
                    }
                    $dest='announces/'.date("Y/m",$oldInfo->create_time).'/'.$editingId;
                }
                else { $oldInfo=''; $dest=''; }

                $this->getPackagePrices();
    $result[0]=0; // 0=> nomrenin duzgun ve ya yanliw olmagi...  default yanliw goturduk...0
    $result[1]=$this->packagePrices["announce_limit"]; // 1=> nomrenin pulsuz elan yerlewdirme limitin gosterir... default bazadan goturduk...
    $result[2]=0; // 2=> nomrenin elan paketi qalib yoxsa qutarib onu gosterir... default qalmayib goturduk...0
    $result[3]=0; // 5=> nomrenin qara siyahida olub olmamasini deyir... default olaraq qara siyahida deyil...0
    $result[4]=0; // 3=> profilin elan yerlewdirme balansi qalib yoxsa qutarib onu gosterir...  default qalmayib goturduk...0
    $result[5]=0; // 4=> emailin duzgun olub olmamasini yoxlayir. default duzgun deyil goturduk...
                if($country==1)
                {
                    if($mobile1!='' && strlen($mobile1)%15==0)  $result[0]='1';
                    if($mobile2!='' && strlen($mobile2)%15==0)  $result[0]='1';
                    if($mobile3!='' && strlen($mobile3)%15==0)  $result[0]='1';
                }
                else if($mobile1!='' || $mobile2!='' || $mobile3!='') $result[0]='1';

                $month_ago=time()-(86400*30);
                foreach($mobiles as $mob)
                {
                    $elan_sayi=Announces::find()->select(['id'])->where(['like', 'mobile', $mob])->andWhere('status=1 or status=0 or status=3')->andWhere('insert_type=0')->count();
                    $limit=$this->packagePrices["announce_limit"]-$elan_sayi;
                    if($editingId>0 && strpos($oldInfo->mobile,substr($mob,1))>=0) $limit++;
                    if($limit<$result[1]) $result[1]=$limit;

					$balance=MobilePackage::find()->select(['id'])->where(['like', 'mobile', $mob])->andWhere('balance>0')->count();
					if($balance>0) $result[2]=1;

					$blackList=BlackList::find()->select(['id'])->where(['mobile'=>$mob,'status'=>1])->count();
					if($blackList>0) $result[3]=1;
                }

                if($this->userInfo!=false) $result[4]=intval($this->userInfo->package_announce);
                $validator = new EmailValidator(); if($validator->validate($email)) $result[5]=1;

                $error=false;
                if($result[0]==0) { $error=true; $error_name='1'; }                                 // nomre duzgun yazilmayib ve ya daxil edilmeyib
                if($result[3]==1 && ($editingId==0 or $oldInfo->mobile!=$mobile) ) { $error=true; $error_name='2'; }   // nomre qara saiyahidadir
                if($result[1]<1 && $result[4]==0 && $result[2]==0) { $error=true; $error_name='3'; } // pulsuz yerlewdirme limiti bitib
                if($result[5]==0) { $error=true; $error_name='4'; }                                  // email sehvdir
                if($name=='') { $error=true; $error_name='5'; }
                if($country==0) { $error=true; $error_name='6'; }
                if($price=='') { $error=true; $error_name='7'; }
                if($property_type==0) { $error=true; $error_name='8'; }
                if($announce_type==0) { $error=true; $error_name='9'; }
                if($country==1 && $city==0) { $error=true; $error_name='10'; }
                if($address=='') { $error=true; $error_name='11'; }
                if($google_map=='') { $error=true; $error_name='12'; }
                if($space=='') { $error=true; $error_name='13'; }
                if($document=='') { $error=true; $error_name='14'; }
                if($text=='') { $error=true; $error_name='15'; }
                if($announcer==0) { $error=true; $error_name='16'; }
                if(count($images)<4) { $error=true;    $error_name='17';  }                           // sekil sayi azdir
                if($error==false)
                {
$title=$this->titleGenerator('az',$announce_type,$property_type,$space,$room_count,$mark,$settlement,$metro,$region,$city,$address);
                    $time=time();
                    if($result[1]>0) $insert_type=0; else if($result[2]>0) $insert_type=1;  else $insert_type=2;

                    if($editingId==0)     // yeni elan
                    {
                        $insertAnnounce=new Announces();
                        $insertAnnounce->email=$email;
                        $insertAnnounce->mobile=$mobile;
                        $insertAnnounce->name=$name;
                        $insertAnnounce->price=$price;
                        $insertAnnounce->room_count=$room_count;
                        $insertAnnounce->rent_type=$rent_type;
                        $insertAnnounce->property_type=$property_type;
                        $insertAnnounce->announce_type=$announce_type;
                        $insertAnnounce->country=$country;
                        $insertAnnounce->city=$city;
                        $insertAnnounce->region=$region;
                        $insertAnnounce->settlement=$settlement;
                        $insertAnnounce->metro=$metro;
                        $insertAnnounce->mark=$mark;
                        $insertAnnounce->address=$address;
                        $insertAnnounce->google_map=$google_map;
                        $insertAnnounce->floor_count=$floor_count;
                        $insertAnnounce->current_floor=$current_floor;
                        $insertAnnounce->space=$space;
                        $insertAnnounce->repair=$repair;
                        $insertAnnounce->document=$document;
                        $insertAnnounce->text=$text;
                        $insertAnnounce->announcer=$announcer;
                        $insertAnnounce->insert_type=$insert_type;
                        $insertAnnounce->announce_date=$time;
                        $insertAnnounce->create_time=$time;
                        $insertAnnounce->reasons='-';
if($announce_type==1) $insertAnnounce->rent_type=0;
if($country!=1){ $insertAnnounce->city=0; $insertAnnounce->region=0; $insertAnnounce->settlement=0; $insertAnnounce->metro=0; $insertAnnounce->mark='';}
elseif($city!=3){$insertAnnounce->region=0; $insertAnnounce->settlement=0; $insertAnnounce->metro=0; $insertAnnounce->mark='';}
if($property_type==3 || $property_type==4 || $property_type==8) {$insertAnnounce->current_floor=0;}
if($property_type==6) {$insertAnnounce->current_floor=0; $insertAnnounce->floor_count=0;}
if($property_type==7) {$insertAnnounce->current_floor=0; $insertAnnounce->floor_count=0; $insertAnnounce->repair=0;}
                        $insertAnnounce->save(false);       $insertedId = $insertAnnounce->id;

                        $saveArchive=new ArchiveDb();
                        $saveArchive->from_=$email;
                        $saveArchive->to_='User:'.$email;
                        $saveArchive->operation='insert';
                        $saveArchive->mobiles=$mobile;
                        $saveArchive->insert_type=$insert_type;
                        $saveArchive->time_count=$this->packagePrices["announce_time"];
                        $saveArchive->announce_id=$insertedId;
                        $saveArchive->create_time=$time;
                        $saveArchive->save(false);

                        $folder='announces/'.date('Y');  $folderM=$folder.'/'.intval(date("m"));   $folderA=$folderM.'/'.$insertedId;
                        if(!is_dir(MyFunctionsF::getImagePath().'/'.$folder)) mkdir(MyFunctionsF::getImagePath().'/'.$folder,0757);
                        if(!is_dir(MyFunctionsF::getImagePath().'/'.$folderM)) mkdir(MyFunctionsF::getImagePath().'/'.$folderM,0757);
                        if(!is_dir(MyFunctionsF::getImagePath().'/'.$folderA)) mkdir(MyFunctionsF::getImagePath().'/'.$folderA,0757);
                        $count=1; $save_images=[]; $cover='';
                        foreach($images as $image)
                        {
                            $oldImage=MyFunctionsF::getImagePath().'/announces/temporary/'.$image;
                            $type=explode(".",$oldImage);   $type=end($type);   $type=strtolower($type);
                            $newImage='emlak.az-'.MyFunctionsF::fileNameGenerator($title);
                            $newImage=$folderA.'/'.$newImage.'-'.uniqid(rand(1,99)).'-'.uniqid(rand(1,99)).'.'.$type;
                            rename($oldImage,MyFunctionsF::getImagePath().'/'.$newImage);
                            if($count==1) $cover=$newImage;
                            $save_images[]=$newImage;
                            $count++;
                        }
                        $save_images=implode(",",$save_images);
                        $updateAnnounce=Announces::find()->where(['id'=>$insertedId])->one();
                        $updateAnnounce->cover=$cover;
                        $updateAnnounce->images=$save_images;
                        $updateAnnounce->save(false);

                        Yii::$app->session['temporary_images']=[];
						Yii::$app->cache->flush();
                        return 'inserted-'.$insertedId;
                    }
                    else
                    {
if($announce_type==1) $rent_type=0;
if($country!=1){ $city=0; $region=0; $settlement=0; $metro=0; $mark='';}
elseif($city!=3){$region=0; $settlement=0; $metro=0; $mark='';}
if($property_type==3 || $property_type==4 || $property_type==8) {$current_floor=0;}
if($property_type==6) {$current_floor=0; $floor_count=0;}
if($property_type==7) {$current_floor=0; $floor_count=0; $repair=0;}


                        $insertedId=$editingId;
                        $admin=intval(Yii::$app->session['admin']);
                        $code=Yii::$app->session['code'];
if($admin>0) { $thisCode=MyFunctionsF::codeGeneratorforAdmin($insertedId,$admin); $who='Admin:'.$admin; }
elseif($this->userInfo!=false) { $thisCode=MyFunctionsF::codeGeneratorforUser($insertedId); $who='User:'.$this->userInfo->email; }
else { $thisCode=MyFunctionsF::codeGeneratorforUser($insertedId); $who='Announce:'.$insertedId; }
                        if ($thisCode!=$code) { return false; }
                        else
                        {
$changedInformation='';
if($oldInfo->name!=$name) $changedInformation.=Yii::t('app','lang141',[],'az').': '.$oldInfo->name.' -> '.$name.'***';
if($oldInfo->country!=$country) $changedInformation.=Yii::t('app','lang142',[],'az').': '.$this->countries[$oldInfo->country].' -> '.$this->countries[$country].'***';
if($oldInfo->mobile!=$mobile) $changedInformation.=Yii::t('app','lang42',[],'az').': '.$oldInfo->mobile.' -> '.$mobile.'***';
if($oldInfo->email!=$email) $changedInformation.=Yii::t('app','lang12',[],'az').': '.$oldInfo->email.' -> '.$email.'***';
if($oldInfo->announcer!=$announcer) $changedInformation.=Yii::t('app','lang143',[],'az').': '.Yii::t('app','announcer'.$oldInfo->announcer).' -> '.Yii::t('app','announcer'.$announcer).'***';
if($oldInfo->announce_type!=$announce_type) $changedInformation.=Yii::t('app','lang154',[],'az').': '.Yii::t('app','announce_type'.$oldInfo->announce_type).' -> '.Yii::t('app','announce_type'.$announce_type).'***';
if($oldInfo->property_type!=$property_type) $changedInformation.=Yii::t('app','lang155',[],'az').': '.Yii::t('app','property_type'.$oldInfo->property_type).' -> '.Yii::t('app','property_type'.$property_type).'***';
if($oldInfo->room_count!=$room_count) $changedInformation.=Yii::t('app','lang160',[],'az').': '.$oldInfo->room_count.' -> '.$room_count;
if($oldInfo->space!=$space) $changedInformation.=Yii::t('app','lang156',[],'az').': '.$oldInfo->space.' -> '.$space.'***';
if($oldInfo->current_floor!=$current_floor) $changedInformation.=Yii::t('app','lang161',[],'az').': '.$oldInfo->current_floor.' -> '.$current_floor.'***';
if($oldInfo->floor_count!=$floor_count) $changedInformation.=Yii::t('app','lang162',[],'az').': '.$oldInfo->floor_count.' -> '.$floor_count.'***';
if($oldInfo->repair!=$repair) $changedInformation.=Yii::t('app','lang163',[],'az').': '.Yii::t('app','repair'.$oldInfo->repair).' -> '.Yii::t('app','repair'.$repair).'***';
if($oldInfo->document!=$document) $changedInformation.=Yii::t('app','lang170',[],'az').': '.Yii::t('app','document'.$oldInfo->document).' -> '.Yii::t('app','document'.$document).'***';
if($oldInfo->price!=$price) $changedInformation.=Yii::t('app','lang171',[],'az').': '.$oldInfo->price.' -> '.$price.'***';
if($oldInfo->rent_type!=$rent_type) $changedInformation.=Yii::t('app','lang202',[],'az').': '.Yii::t('app','rent_type'.$oldInfo->rent_type).' -> '.Yii::t('app','rent_type'.$rent_type).'***';
if($oldInfo->text!=$text) $changedInformation.=Yii::t('app','lang172',[],'az').': '.$oldInfo->text.' -> '.$text.'***';
if($oldInfo->city!=$city) $changedInformation.=Yii::t('app','lang164',[],'az').': '.$this->cities[$oldInfo->city].' -> '.$this->cities[$city].'***';
if($oldInfo->region!=$region) $changedInformation.=Yii::t('app','lang165',[],'az').': '.$this->regions[$oldInfo->region].' -> '.$this->regions[$region].'***';
if($oldInfo->settlement!=$settlement) $changedInformation.=Yii::t('app','lang166',[],'az').': '.$this->settlements[$oldInfo->settlement].' -> '.$this->settlements[$settlement].'***';
if($oldInfo->metro!=$metro) $changedInformation.=Yii::t('app','lang167',[],'az').': '.$this->metros[$oldInfo->metro].' -> '.$this->metros[$metro].'***';
if($oldInfo->mark!=$mark)
{
    $mmm=explode("-",$oldInfo->mark); $oldMarks=''; foreach($mmm as $mm) { $oldMarks.=$this->marks[$mm].', '; }
    $oldMarks=substr($oldMarks,0,strlen($oldMarks)-1);

    $mmm=explode("-",$mark); $newMarks=''; foreach($mmm as $mm) { $newMarks.=$this->marks[$mm].', '; }
    $newMarks=substr($newMarks,0,strlen($newMarks)-1);

    $changedInformation.=Yii::t('app','lang168',[],'az').': '.$oldMarks.' -> '.$newMarks.'***';
}
if($oldInfo->address!=$address) $changedInformation.=Yii::t('app','lang28',[],'az').': '.$oldInfo->address.' -> '.$address.'***';
if($oldInfo->google_map!=$google_map) $changedInformation.=Yii::t('app','lang203',[],'az').': '.$oldInfo->google_map.' -> '.$google_map.'***';
                            $array1=Yii::$app->session["temporary_images_for_diff"]; $array2=$images;
                            $imageDif = array_diff($array1, $array2)+array_diff($array2, $array1);
                            $deleted=array_diff($array1, $array2); $added=array_diff($array2, $array1);

                            //check sorted
                            $siralama1=implode(",",$array1); $siralama2=implode(",",$array2);
                            if($siralama1!=$siralama2) $siralama=true; else $siralama=false;

                            if(count($imageDif)>0 or $rotated!=0)
                            {
                                $changedInformation.='Şəkil dəyişikliyi edilib:'.count($deleted).' silinib, '.count($added).' əlavə edilib~';
                                if(count($deleted)>0)
                                {
                                    $deletedText='';
                                    foreach($deleted as $kkk=>$ddd){$deletedText.=$kkk.'='.$ddd.'***';}
                                    $deletedText=substr($deletedText,0,strlen($deletedText)-3);
                                    $changedInformation.='Silinənlər: '.$deletedText;
                                }
                                $changedInformation.='~';
                                if(count($added)>0)
                                {
                                    $addedText='';
                                    foreach($added as $kkk=>$ddd){$addedText.=$kkk.'='.$ddd.'***';}
                                    $addedText=substr($addedText,0,strlen($addedText)-3);
                                    $changedInformation.='Əlavə edilənlər: '.$addedText;
                                }
                                $changedInformation.='***';
                                if($rotated!=0) $changedInformation.='Şəkil çevrilməsi edilib.';

                                $count=1; $save_images=[];  $save_logo_images=[];
$title=$this->titleGenerator('az',$announce_type,$property_type,$space,$room_count,$mark,$settlement,$metro,$region,$city,$address);
                                foreach($images as $logo=>$image)
                                {
                                    $oldImage=MyFunctionsF::getImagePath().'/announces/temporary/'.$image;
                                    $type=explode(".",$oldImage);   $type=end($type);   $type=strtolower($type);
                                    if(intval(strpos($image,'-'))>0) $newImage=$dest.'/'.$image;
                                    else $newImage=$dest.'/emlak.az-'.MyFunctionsF::fileNameGenerator($title).'-'.uniqid(rand(1,99)).'-'.uniqid(rand(1,99)).'.'.$type;
                                    rename($oldImage,MyFunctionsF::getImagePath().'/'.$newImage);
                                    if($count==1) $cover=$newImage;
                                    $save_images[]=$newImage;

                                    $logoly_image=explode("-",$newImage);   unset($logoly_image[count($logoly_image)-1]);
                                    $logoly_image=implode("-",$logoly_image).'.'.$type;
                                    $save_logo_images[]=$logoly_image;

                                    $count++;
                                }
                                $save_images=implode(",",$save_images);
                                $save_logo_images=implode(",",$save_logo_images);

                            }
                            else
                            {
                                if($edited==0) $cover=$oldInfo->cover; else $cover='';
                                $save_images=[]; $save_logo_images=[];

                                // siralamani tetbiq edir...
                                $count=0;
                                foreach($images as $logo=>$image)
                                {
                                    $type=explode(".",$image);   $type=end($type);   $type=strtolower($type);
                                    $logoly_image=explode("-",$dest.'/'.$image);   unset($logoly_image[count($logoly_image)-1]);
                                    $logoly_image=implode("-",$logoly_image).'.'.$type;
                                    $save_images[]=$dest.'/'.$image;
                                    $save_logo_images[]=$logoly_image;
                                    if(!is_file(MyFunctionsF::getImagePath().'/'.$logoly_image))
                                copy(MyFunctionsF::getImagePath().'/'.$dest.'/'.$image,MyFunctionsF::getImagePath().'/'.$logoly_image);

                                    if($count==0 && $who=='Admin:'.$admin)
                                    {
                                        $new_cover=$logoly_image;
                                        $type=explode(".",$new_cover);   $type=end($type);   $type=strtolower($type);
                                        $new_cover=explode("-",$new_cover);   unset($new_cover[count($new_cover)-1]);
                                        $cover=implode("-",$new_cover).'.'.$type;
                                        if(!is_file(MyFunctionsF::getImagePath().'/'.$cover) or $siralama)
                                            copy(MyFunctionsF::getImagePath().'/'.$dest.'/'.$image,MyFunctionsF::getImagePath().'/'.$cover);
                                        $count++;
                                    }
                                }

                                $save_images=implode(",",$save_images);
                                $save_logo_images=implode(",",$save_logo_images);

                            }

                            /*
                            // istifadeci wekilleri silen zaman serverden silinsin...
                            if(count($deleted)>0 && $who!='Admin:'.$admin)
                            {
                                foreach($deleted as $logo=>$original)
                                {
                                    unlink(MyFunctionsF::getImagePath().'/'.$dest.'/'.$logo);
                                    unlink(MyFunctionsF::getImagePath().'/'.$dest.'/'.$original);
                                }
                            }
                            */

                            if($changedInformation!='')
                            {
                                $saveArchive=new ArchiveDb();
                                $saveArchive->from_=$who;
                                $saveArchive->to_='Announce:'.$insertedId;
                                if($edited==0) $saveArchive->operation='update';
                                else $saveArchive->operation='update_edited';
                                $saveArchive->mobiles=$mobile;
                                $saveArchive->announce_id=$insertedId;
                                $saveArchive->text=$changedInformation;
                                $saveArchive->create_time=$time;
                                $saveArchive->save(false);

                                if($who=='Admin:'.$admin)
                                {
                                    if($edited==0){
										foreach(Yii::$app->params["fullAnnouncesArchives"] as $table){
											$tb='backend\models\\'.$table;
											$updateAnnounce=$tb::find()->where(['id'=>$insertedId])->one();
											if(!empty($updateAnnounce)) break;
										}
                                    }else{
                                        $tb='backend\models\AnnouncesEdited';
                                        $updateAnnounce=$tb::find()->where(['announce_id'=>$insertedId])->one();
                                    }

                                    $updateAnnounce->email=$email;
                                    $updateAnnounce->mobile=$mobile;
                                    $updateAnnounce->name=$name;
                                    $updateAnnounce->price=$price;
                                    if($edited==0) $updateAnnounce->cover=$cover;
                                    $updateAnnounce->images=$save_images;
                                    $updateAnnounce->logo_images=$save_logo_images;
                                    $updateAnnounce->room_count=$room_count;
                                    $updateAnnounce->rent_type=$rent_type;
                                    $updateAnnounce->property_type=$property_type;
                                    $updateAnnounce->announce_type=$announce_type;
                                    $updateAnnounce->country=$country;
                                    $updateAnnounce->city=$city;
                                    $updateAnnounce->region=$region;
                                    $updateAnnounce->settlement=$settlement;
                                    $updateAnnounce->metro=$metro;
                                    $updateAnnounce->mark=$mark;
                                    $updateAnnounce->address=$address;
                                    $updateAnnounce->google_map=$google_map;
                                    $updateAnnounce->floor_count=$floor_count;
                                    $updateAnnounce->current_floor=$current_floor;
                                    $updateAnnounce->space=$space;
                                    $updateAnnounce->repair=$repair;
                                    $updateAnnounce->document=$document;
                                    $updateAnnounce->text=$text;
                                    $updateAnnounce->announcer=$announcer;
if($announce_type==1) $updateAnnounce->rent_type=0;
if($country!=1){ $updateAnnounce->city=0; $updateAnnounce->region=0; $updateAnnounce->settlement=0; $updateAnnounce->metro=0; $updateAnnounce->mark='';}
elseif($city!=3){$updateAnnounce->region=0; $updateAnnounce->settlement=0; $updateAnnounce->metro=0; $updateAnnounce->mark='';}
if($property_type==3 || $property_type==4 || $property_type==8) {$updateAnnounce->current_floor=0;}
if($property_type==6) {$updateAnnounce->current_floor=0; $updateAnnounce->floor_count=0;}
if($property_type==7) {$updateAnnounce->current_floor=0; $updateAnnounce->floor_count=0; $updateAnnounce->repair=0;}
                                    $updateAnnounce->save(false);
                                    // wekil iwlerini heyata kecirsin...
                                    if( (count($imageDif)>0 or $rotated!=0) and ($oldInfo->status==1) ) $this->setWatermarktoImages($insertedId);
                                    return 'updatedAdmin-'.$insertedId;
                                }
                                else
                                {
                                    // user update
                                    $insertEdited=new AnnouncesEdited();
                                    $insertEdited->announce_id=$insertedId;
                                    $insertEdited->email=$email;
                                    $insertEdited->mobile=$mobile;
                                    $insertEdited->name=$name;
                                    $insertEdited->price=$price;
                                    $insertEdited->images=$save_images;
                                    $insertEdited->logo_images=$save_logo_images;
                                    $insertEdited->room_count=$room_count;
                                    $insertEdited->rent_type=$rent_type;
                                    $insertEdited->property_type=$property_type;
                                    $insertEdited->announce_type=$announce_type;
                                    $insertEdited->country=$country;
                                    $insertEdited->city=$city;
                                    $insertEdited->region=$region;
                                    $insertEdited->settlement=$settlement;
                                    $insertEdited->metro=$metro;
                                    $insertEdited->mark=$mark;
                                    $insertEdited->address=$address;
                                    $insertEdited->google_map=$google_map;
                                    $insertEdited->floor_count=$floor_count;
                                    $insertEdited->current_floor=$current_floor;
                                    $insertEdited->space=$space;
                                    $insertEdited->repair=$repair;
                                    $insertEdited->document=$document;
                                    $insertEdited->text=$text;
                                    $insertEdited->announcer=$announcer;
                                    $insertEdited->create_time=$time;
                                    $insertEdited->status=0;
if($announce_type==1) $insertEdited->rent_type=0;
if($country!=1){ $insertEdited->city=0; $insertEdited->region=0; $insertEdited->settlement=0; $insertEdited->metro=0; $insertEdited->mark='';}
elseif($city!=3){$insertEdited->region=0; $insertEdited->settlement=0; $insertEdited->metro=0; $insertEdited->mark='';}
if($property_type==3 || $property_type==4 || $property_type==8) {$insertEdited->current_floor=0;}
if($property_type==6) {$insertEdited->current_floor=0; $insertEdited->floor_count=0;}
if($property_type==7) {$insertEdited->current_floor=0; $insertEdited->floor_count=0; $insertEdited->repair=0;}
                                    $insertEdited->save(false);
                                    Yii::$app->session->setFlash('success',Yii::t('app','lang204'));
                                    if($this->userInfo!=false) return 'updatedUser-'.$insertedId;
                                    else return 'updatedAnnounce-'.$insertedId;
                                }
                            }
                            else
                            {
                                if($edited==0){
									foreach(Yii::$app->params["fullAnnouncesArchives"] as $table){
										$tb='backend\models\\'.$table;
										$updateAnnounce=$tb::find()->where(['id'=>$insertedId])->one();
										if(!empty($updateAnnounce)) break;
									}
                                }else{
                                    $tb='backend\models\AnnouncesEdited';
                                    $updateAnnounce=$tb::find()->where(['announce_id'=>$insertedId])->one();
                                }
                                if($edited==0) $updateAnnounce->cover=$cover;
                                $updateAnnounce->images=$save_images;
                                $updateAnnounce->logo_images=$save_logo_images;
                                $updateAnnounce->save(false);
                                // return 'updatedSimple-'.$insertedId;
                            }
                            Yii::$app->session->setFlash('success',Yii::t('app','lang205'));
                            if($who=='Admin:'.$admin) return 'updatedSimpleAdmin-'.$insertedId;
                            else if($this->userInfo!=false) return 'updatedSimpleUser-'.$insertedId;
                            else return 'updatedAnnounce-'.$insertedId;
                        }   // kod duzgundurse
                    }   // end update
                }   // ifler wertler yoxlamalar
                else return $error_name;
            }   // submit buttonu
        }   // if post
        return false;
    }

    public function setWatermarktoImages($id){
		$tb='backend\models\Announces';
		$announce=$tb::find()->where(['id'=>$id])->one();
		if(empty($announce)){
			foreach(Yii::$app->params["announcesArchives"] as $table){
				$tb='backend\models\\'.$table;
				$announce=$tb::find()->where(['id'=>$id])->one();
				if(!empty($announce)) break;
			}
		}
        $images=explode(",",$announce->images);
        $logo_images=explode(",",$announce->logo_images);
        $count=0;
        foreach($images as $image)
        {
            $file=MyFunctionsF::getImagePath().'/'.$image;
            $forSavePatch=explode("/",$logo_images[$count]); $fileThumb=end($forSavePatch);
            unset($forSavePatch[count($forSavePatch)-1]); $saveParth=implode("/",$forSavePatch);

            $img=new ImageUpload();
            $img->maxSize($file,Announces::MAX_IMAGE_WIDTH,Announces::MAX_IMAGE_HEIGHT,100);
            $img->thumbExportAnnounce($file,$saveParth,$fileThumb,Announces::THUMB3_IMAGE_WIDTH,Announces::THUMB3_IMAGE_HEIGHT,'watermark.png','watermark_logo.png');
            $count++;

            if($count==1)   // cover image
            {
                $tip=explode(".",$fileThumb); $tip=end($tip);
                $fileCover=explode("-",$fileThumb); unset($fileCover[count($fileCover)-1]); $fileCover=implode("-",$fileCover).'.'.$tip;
                $img->thumbExport($file,$saveParth,$fileCover,Announces::THUMB_IMAGE_WIDTH,Announces::THUMB_IMAGE_HEIGHT, false,'','',100);
            }
        }
    }

    public function actionImages_sort(){
        $all_images=Yii::$app->request->post('all_images');

        $all_images=explode(",",$all_images);
        $new_sort=[];
        foreach($all_images as $image)
        {
            if($image!='')
            {
                $new_sort[$image]=Yii::$app->session["temporary_images"][$image];
            }
        }
        Yii::$app->session["temporary_images"]=$new_sort;
    }

    public function actionDelete_image(){
        if(Yii::$app->request->post())
        {
            $thumbImage=Yii::$app->request->post('thumbImage');
            $temporaryImage=intval(Yii::$app->request->post('temporaryImage'));     // eger 1dise, yeni wekildir... else: editden gelib...

            if($temporaryImage==1) { $fileName=explode('/thumb/',$thumbImage); $fileName=end($fileName); }
            else { $fileName=explode('/temporary/',$thumbImage); $fileName=end($fileName); }

            if(isset(Yii::$app->session["temporary_images"][$fileName]))
            {
                $temporary_images=Yii::$app->session["temporary_images"];
                unset($temporary_images[$fileName]); Yii::$app->session["temporary_images"]=$temporary_images;
                return 'deleted';
            }
            else return false;
        }
    }

    public function actionRotate(){
        if(Yii::$app->request->post())
        {
            $thumbImage=Yii::$app->request->post('thumbImage');
            $temporaryImage=intval(Yii::$app->request->post('temporaryImage'));
            $action=Yii::$app->request->post('action'); if($action=='left') $degrees=-90; else $degrees=90;

            if($temporaryImage==1) { $fileName=explode('/thumb/',$thumbImage);    $saveParth=$fileName[0];    $fileName=end($fileName); }
            else { $fileName=explode('/',$thumbImage); $saveParth='announces/temporary';   $fileName=end($fileName); }

            if(isset(Yii::$app->session["temporary_images"][$fileName]))
            {
                $image=Yii::$app->image->load(MyFunctionsF::getImagePath().'/'.$saveParth.'/'.Yii::$app->session["temporary_images"][$fileName]);
                $image->rotate($degrees)->save(MyFunctionsF::getImagePath().'/'.$saveParth.'/'.Yii::$app->session["temporary_images"][$fileName]);
                return 'rotated';
            }
            else return false;
        }
    }
}