<?php
namespace frontend\controllers;

use backend\models\EmailChanger;
use backend\models\Users;
use backend\models\ArchiveDb;
use frontend\components\MyController;
use frontend\components\MyFunctionsF;
use Yii;
use yii\db\Query;
use yii\helpers\Url;
use yii\web\UploadedFile;
use backend\components\MyFunctions;
use backend\models\ImageUpload;
use backend\models\Announces;
use backend\models\AnnouncesArchive2015;
use backend\models\AnnouncesArchive2014;
use frontend\components\CreateZipFile;

class ProfilController extends MyController
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;

        if(!$this->userInfo)
        {
            return $this->redirect(Url::toRoute(['/']));
        }
        else { return true; }
    }

    public function actionIndex(){
		return $this->render('index');
    }

    public function actionElanlar()
    {
		if(Yii::$app->session->hasFlash('success')){
			$checkZip=Yii::$app->session->getFlash('success');
			$expCheck=explode("-",$checkZip);
			if($expCheck[0]=='zipDownload'){
				$ZipId=$expCheck[1];
				foreach(Yii::$app->params["fullAnnouncesArchives"] as $table){
					$tb='backend\models\\'.$table;
					$announce=$tb::find()->where(['id'=>$ZipId])->one();
					if(!empty($announce)) break;
				}
				if(!empty($announce)){
					if($announce->email==$this->userInfo->email){
					$createZipFile = new CreateZipFile;
					$images=explode(",",$announce->images);
					foreach($images as $image){
						$fileToZip=MyFunctionsF::getImagePath()."/".$image;
						$type=explode(".",$image); $type=end($type);
						$createZipFile->addFile(file_get_contents($fileToZip), 'emlak.az-'.rand(1,99).rand(100,999).'.'.$type);
					}
					$zipName='emlak.az-'.$ZipId.'-images.zip';
					$fd=fopen($zipName, "wb"); $out=fwrite($fd,$createZipFile->getZippedfile()); fclose($fd);
					$createZipFile->forceDownload($zipName);
					unlink($zipName);
					}
					else{
					$saveArchive=new ArchiveDb();
					$saveArchive->from_='User:'.$this->userInfo->email;
					$saveArchive->to_='Announce:'.$ZipId;
					$saveArchive->operation='user_cannot_imgDownload';
					$saveArchive->announce_id=$ZipId;
					$saveArchive->create_time=time();
					$saveArchive->note='User email:'.$this->userInfo->email.', Announce email:'.$announce->email;
					$saveArchive->save(false);
					}
				}
				
			}
			else{
				Yii::$app->session->setFlash('success',$checkZip);
			}
		}
		
		$status=intval(Yii::$app->request->get('status'));     if($status<0 || $status>4 || Yii::$app->request->get('status')=='') $status=1;
		$del_id=intval(Yii::$app->request->get('delete'));
		if($del_id>0){
			foreach(Yii::$app->params["fullAnnouncesArchives"] as $table){
				$tb='backend\models\\'.$table;
				$del_info=$tb::find()->where(['id'=>$del_id])->one();
				if(!empty($del_info)) break;
			}
			if(!empty($del_info)  && $del_info->email==$this->userInfo->email && $del_info->status!=4){
				$del_info->deleted_time=time();
				$del_info->status=4;
				$del_info->save(false);
				
				$saveArchive=new ArchiveDb();
				$saveArchive->from_='User:'.$this->userInfo->id;
				$saveArchive->to_='Announce:'.$del_id;
				$saveArchive->operation='user_deleted';
				$saveArchive->announce_id=$del_id;
				$saveArchive->create_time=time();
				$saveArchive->save(false);
				
				Yii::$app->session->setFlash('success',Yii::t('app','lang256'));
				Yii::$app->cache->flush();
			}
			else if(!empty($del_info)  && $del_info->email!=$this->userInfo->email){
				Yii::$app->session->setFlash('danger','Are you clever?');
			}
			return $this->redirect(Url::to(['profil/elanlar/?status='.$status]));
		}
		
		
        $sort_type=intval(Yii::$app->request->get('sort_type'));  if($sort_type<0 || $sort_type>4) $sort_type=0;
        $page=intval(Yii::$app->request->get('page'));	if($page<1) $page=1;
        $limit=10;	$bitmis_limit=$limit; $show=2;
        $start=$page*$limit-$limit;
        $link=Yii::$app->controller->id.'/'.Yii::$app->controller->action->id.'?status='.$status.'&sort_type='.$sort_type.'&page='.$page;
		if(Yii::$app->request->get('map') && is_numeric(Yii::$app->request->get('map'))) {$start=0; $limit=500; $map=1; }
		
		$var='userAnnounces'.$status; $announces_count=$this->$var;

        $query=new Query();
        $query->select('*');
        if($status==0) $query->from('announces')->where(['email'=>$this->userInfo->email,'status'=>0])->orderBy(['announce_date'=>SORT_DESC]);
        elseif($status==2) {
			$lazim=$start+$bitmis_limit;
			if($lazim>$announces_count) $lazim=$announces_count;
			
			$key=0;		$ended_ann=[];
			foreach(Yii::$app->params["fullAnnouncesArchives"] as $tb=>$table){
				$qaliq=0;
				if(isset($this->userAnnounces2_rows[$key])){
					if($this->userAnnounces2_rows[$key]>=$lazim){
						$usEmail=
						$ann_rows=Yii::$app->db->createCommand("select * from $tb where email='".$this->userInfo->email."' and status='$status' order by announce_date desc limit $start,$bitmis_limit")->queryAll();
						$ended_ann=array_merge($ended_ann,$ann_rows);
					}
					else{
						$ann_rows=Yii::$app->db->createCommand("select * from $tb where email='".$this->userInfo->email."' and status='$status' order by announce_date desc limit $start,$bitmis_limit")->queryAll();
						$ended_ann=array_merge($ended_ann,$ann_rows);
						$qaliq=$lazim-$this->userAnnounces2_rows[$key];  // 5 catmir tutaqki
						$start=0; $bitmis_limit=$qaliq;
						$lazim=$start+$bitmis_limit;
					}
				}
				$key++;
			}
			
		}
        elseif($status==3) $query->from('announces')->where(['email'=>$this->userInfo->email,'status'=>3])->orderBy(['announce_date'=>SORT_DESC]);
		elseif($status==4) {
			$lazim=$start+$bitmis_limit;
			if($lazim>$announces_count) $lazim=$announces_count;
			
			$key=0;		$ended_ann=[];
			foreach(Yii::$app->params["fullAnnouncesArchives"] as $table){
				$qaliq=0;
				if(isset($this->userAnnounces4_rows[$key])){
					$tb='backend\models\\'.$table;
					if($this->userAnnounces4_rows[$key]>=$lazim){
						$ann_rows=$tb::find()->where(['email'=>$this->userInfo->email,'status'=>$status])->orderBy(['deleted_time'=>SORT_DESC])
						->offset($start)->limit($bitmis_limit)->asArray()->all();
						$ended_ann=array_merge($ended_ann,$ann_rows);
					}
					else{
						$ann_rows=$tb::find()->where(['email'=>$this->userInfo->email,'status'=>$status])->orderBy(['deleted_time'=>SORT_DESC])
						->offset($start)->limit($bitmis_limit)->asArray()->all();
						$ended_ann=array_merge($ended_ann,$ann_rows);
						$qaliq=$lazim-$this->userAnnounces4_rows[$key];  // 5 catmir tutaqki
						$start=0; $bitmis_limit=$qaliq;
						$lazim=$start+$bitmis_limit;
					}
				}
				$key++;
			}
			
		}
        else $query->from('announces')->where(['email'=>$this->userInfo->email,'status'=>1])->orderBy(['announce_date'=>SORT_DESC]);

        if($sort_type==1) $query->orderBy(['announce_date'=>SORT_DESC]);
        elseif($sort_type==2) $query->orderBy(['space'=>SORT_ASC]);
        elseif($sort_type==3) $query->orderBy(['price'=>SORT_ASC]);
        elseif($sort_type==4) $query->orderBy(['price'=>SORT_DESC]);
        else $query=$this->setSorting($query,'search');

        if($status!=2 && $status!=4) $announces=$query->offset($start)->limit($limit)->all();
		else $announces=$ended_ann;
//var_dump($announces);
        $max_page=ceil($announces_count/$limit);
        if($page<1) $page=1; if($page>$max_page) $page=$max_page; if($page<1) $page=1;
		
		if(isset($map) && is_numeric($map)) $renderFile='map'; else $renderFile='elanlar';

        return $this->render($renderFile,[
            'announces'=>$announces,
            'announces_count'=>$announces_count,
            'status'=>$status,
            'sort_type'=>$sort_type,
            'show'=>$show,
            'page'=>$page,
            'max_page'=>$max_page,
            'link'=>$link,
            'start'=>$start,
            'limit'=>$limit,
        ]);
    }

    public function actionCheck_login(){
        $logini=addslashes(Yii::$app->request->post('logini'));
        $check_login=Users::find()->where(['login'=>$logini])->one();
        if(strlen(strpos($logini," "))>0 || strlen(strpos($logini,"'"))>0 || strlen(strpos($logini,","))>0 || strlen(strpos($logini,'"'))>0 || strlen(strpos($logini,"/"))>0 || strlen(strpos($logini,"\\"))>0 || strlen(strpos($logini,"+"))>0) return '1';	// yalniz herf ve reqem daxil ede bilsin...
        elseif(!empty($check_login)) return '2';    // bu login artiq var...
        else return 'ok';
    }

    public function actionChange_image(){
        $tmp=UploadedFile::getInstanceByName('profil_edit_img');
        if ($tmp != null) {
            $saveParth='users/'.date("Y-m");
            $title=$this->userInfo->name;
            $imageName=MyFunctions::fileNameGenerator(MyFunctions::slugGenerator($title)).'-'.uniqid(rand(1,99)).'.'.$tmp->extension;
            $thumbName=MyFunctions::fileNameGenerator(MyFunctions::slugGenerator($title)).'-'.uniqid(rand(1,99)).'.'.$tmp->extension;

            $imageUpload=new ImageUpload();
            $saved=$imageUpload->save($tmp,$saveParth,$imageName);
            if($saved)
            {
                $imageUpload->maxSize($saveParth.'/'.$imageName,Users::MAX_IMAGE_WIDTH,Users::MAX_IMAGE_HEIGHT);
                $imageUpload->thumbExport($saveParth.'/'.$imageName,$saveParth.'/thumb/',$thumbName,Users::THUMB_IMAGE_WIDTH,Users::THUMB_IMAGE_HEIGHT);
                $imageUpload->deleteOldImages([$this->userInfo->image,$this->userInfo->thumb]);
                $this->userInfo->image=$saveParth.'/'.$imageName;
                $this->userInfo->thumb=$saveParth.'/thumb/'.$thumbName;
                $this->userInfo->save(false);
                return MyFunctionsF::getImageUrl().'/'.$this->userInfo->thumb;
            }
        }
    }

    public function actionDuzelis()
    {
        $name=$this->userInfo->name;
        $login=$this->userInfo->login;
        $text=$this->userInfo->text;
        $address=$this->userInfo->address;
        if($this->userInfo->mobile!='') $mobiles=explode("***",$this->userInfo->mobile);
        else $mobiles='';
        if(is_array($mobiles) && isset($mobiles[0])) $mobile1=$mobiles[0]; else $mobile1='';
        if(is_array($mobiles) && isset($mobiles[1])) $mobile2=$mobiles[1]; else $mobile2='';
        if(is_array($mobiles) && isset($mobiles[2])) $mobile3=$mobiles[2]; else $mobile3='';
        $email=$this->userInfo->email;

        if(Yii::$app->request->post('edit_submit'))
        {
            $name=Yii::$app->request->post('edit_name');
            $login=Yii::$app->request->post('edit_login');
            $text=Yii::$app->request->post('edit_text');
            $address=Yii::$app->request->post('edit_address');
            $mobile1=Yii::$app->request->post('edit_mobile1');
            $mobile2=Yii::$app->request->post('edit_mobile2');
            $mobile3=Yii::$app->request->post('edit_mobile3');
            $email=Yii::$app->request->post('edit_email');
            $pass=Yii::$app->request->post('edit_pass');
            $pass2=Yii::$app->request->post('edit_pass2');

            $login_check=Users::find()->where('login=:login and id!=:id', [':login'=>$login,':id'=>$this->userInfo->id])->one();
            $email_check=Users::find()->where('email=:email and id!=:id', [':email'=>$email,':id'=>$this->userInfo->id])->one();

            if($name=='') Yii::$app->session->setFlash('error',Yii::t('app','lang50'));
            elseif($login!='' && $this->userInfo->premium==0 && $this->userInfo->login!=$login) Yii::$app->session->setFlash('error',Yii::t('app','lang106'));
            elseif($login!='' && !empty($login_check)) Yii::$app->session->setFlash('error',Yii::t('app','lang104'));
            elseif(strlen(strpos($login," "))>0 || strlen(strpos($login,"'"))>0 || strlen(strpos($login,","))>0 || strlen(strpos($login,'"'))>0 || strlen(strpos($login,"/"))>0 || strlen(strpos($login,"\\"))>0 || strlen(strpos($login,"+"))>0) Yii::$app->session->setFlash('error',Yii::t('app','lang105'));
            elseif($email=='') Yii::$app->session->setFlash('error',Yii::t('app','lang79'));
            elseif(!empty($email_check)) Yii::$app->session->setFlash('error',Yii::t('app','lang102'));
            elseif($pass!='' && strlen($pass)<5) Yii::$app->session->setFlash('error',Yii::t('app','lang127'));
            elseif($pass!=$pass2) Yii::$app->session->setFlash('error',Yii::t('app','lang81'));
            else
            {
                $this->userInfo->name=$name;
                $this->userInfo->login=$login;
                $this->userInfo->text=$text;
                $this->userInfo->address=$address;
                $mobiles='';
                if($mobile1!='') $mobiles.=$mobile1.'***';
                if($mobile2!='') $mobiles.=$mobile2.'***';
                if($mobile3!='') $mobiles.=$mobile3.'***';
                if($mobiles!='') $mobiles=substr($mobiles,0,strlen($mobiles)-3);
                $this->userInfo->mobile=$mobiles;

                if($pass!='')
                {
                    $new_pass=md5(md5($pass).'key');
                    $this->userInfo->password=$new_pass;
                    Yii::$app->session["logged_password"]=$new_pass;
                }

                if($email!=$this->userInfo->email)
                {
                    $check_inserted=EmailChanger::find()->where(['old_email'=>$this->userInfo->email,'new_email'=>$email])->all();
                    if(!empty($check_inserted))
                    {
                        foreach($check_inserted as $row){ $row->delete(); }
                    }

                    $code=md5(rand(1,99999));
                    $code2=md5(rand(1,99999));

                    $insert=new EmailChanger();
                    $insert->old_email=$this->userInfo->email;
                    $insert->new_email=$email;
                    $insert->code=$code;
                    $insert->code2=$code2;
                    $insert->create_time=time();
                    $insert->save();
                    $mesaj=Yii::t('app','lang111').'<br /> <br />
                    <a href="http://emlak.az/qeydiyyat/change_email?code='.$code.'&answer=1" target="_blank">'.Yii::t('app','lang112').'</a><br />
                    <a href="http://emlak.az/qeydiyyat/change_email?code='.$code.'&answer=0" target="_blank">'.Yii::t('app','lang113').'</a>';

                    return Yii::$app->mailer->compose()->setTo($this->userInfo->email)
                        ->setFrom([$this->info_contact->email => 'Emlak.az'])->setSubject(Yii::t('app','lang110'))->setTextBody($mesaj)->send();

                    $insert=new EmailChanger();
                    $insert->old_email=$this->userInfo->email;
                    $insert->new_email=$email;
                    $insert->code=$code2;
                    $insert->code2=$code;
                    $insert->create_time=time();
                    $insert->save();
                    $mesaj=Yii::t('app','lang111').'<br /> <br />
                    <a href="http://emlak.az/qeydiyyat/change_email?code='.$code2.'&answer=1" target="_blank">'.Yii::t('app','lang112').'</a><br />
                    <a href="http://emlak.az/qeydiyyat/change_email?code='.$code2.'&answer=0" target="_blank">'.Yii::t('app','lang113').'</a>';
                    Yii::$app->session->setFlash('success',Yii::t('app','lang108'));

                    return Yii::$app->mailer->compose()->setTo($this->userInfo->email)
                        ->setFrom([$email => 'Emlak.az'])->setSubject(Yii::t('app','lang110'))->setTextBody($mesaj)->send();

                }
                else Yii::$app->session->setFlash('success',Yii::t('app','lang107'));

                $this->userInfo->save(false);
                $cacheName='userInfo'.intval(Yii::$app->session["logged_id"]); $userInfo=Yii::$app->cache->delete($cacheName);

                return $this->redirect(Url::toRoute(['profil/']));
            }

        }

        return $this->render('duzelis',[
            'name'=>$name,
            'login'=>$login,
            'text'=>$text,
            'address'=>$address,
            'mobile1'=>$mobile1,
            'mobile2'=>$mobile2,
            'mobile3'=>$mobile3,
            'email'=>$email,
        ]);
    }
}
