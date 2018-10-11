<?php
namespace backend\controllers;

use backend\components\MyFunctions;
use backend\models\Announces;
use backend\models\AnnouncesArchive2014;
use backend\models\AnnouncesArchive2015;
use backend\models\AnnouncesEdited;
use backend\models\ArchiveDb;
use backend\models\PackagePrices;
use backend\models\SmsAnn;
use frontend\components\MyController;
use Yii;
use yii\helpers\Url;
use frontend\web\PHPMailer\Phpmailer;

class AnnouncesController extends MyController
{
    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionJquery(){
        $url=addslashes(Yii::$app->request->post('url')); // ?id=256353&ok=1&status=0&changeStatus=1&imageChanged=0
        $currentAdminId=$this->getUserInfoAdmin('id');
        return $this->redirect('https://emlak.az/emlak0050pro/announces/index'.$url.'&currentAdminId='.$currentAdminId);
        //return file_get_contents('http://emlak.az/emlak0050pro/announces/index'.$url.'&currentAdminId='.$currentAdminId);
    }

    public $modelName='backend\models\Announces';

    public function actionIndex($page=0,$id=0,$ok=0,$reasons='',$status=0,$changeStatus='',$offset=0,$limit=1,$sendSms=false,$archiveView=false){
        if(isset($_GET["count"]) && $_GET["count"]==1) $this->checkCountWrite();

        if(Yii::$app->request->get("cacheUpdate")){
            Yii::$app->cache->flush();
        }

        $currentAdminId=intval(Yii::$app->request->get('currentAdminId'));

        $ids='2503203333';
        if($offset>=0){
            $eee=Announces::find()->where('id in ('.$ids.') ')->offset($offset)->limit($limit)->orderBy(['id'=>SORT_ASC])->asArray()->all();
            foreach($eee as $aaa){
                $a=MyFunctions::setWatermarktoImages($aaa["id"],$offset,$limit);
                //return $a;
            }
        }
        if($id>0 && $ok==1 && $changeStatus==1){
            return $this->changeStatus($id,$status,$changeStatus,'',$currentAdminId,$sendSms,$archiveView);
        }
        elseif($id>0 && $changeStatus==3){
            return $this->changeStatus($id,$status,$changeStatus,$reasons,$currentAdminId,$sendSms,$archiveView);
        }
        elseif($changeStatus==4){
            return $this->changeStatus($id,$status,$changeStatus,$reasons,$currentAdminId,$sendSms,$archiveView);
        }
        $show=2;
        $limit=10;

        if($id>0){
            $count=1; $max_page=1; $page=1; $link=Yii::$app->controller->id.'/index?status='.$status;
            foreach(Yii::$app->params["fullAnnouncesArchives"] as $table)
            {
                $tb='backend\models\\'.$table;
                $announces=$tb::find()->where(['id'=>$id])->asArray()->all();
                if(!empty($announces)) break;
            }
            $sameAnnounces=[];
        }
        else{
            $link=Yii::$app->controller->id.'/index?status='.$status;

            if($status<5){
                if($status==0) $limit=5;
                $count=Announces::find()->where(['status'=>$status])->count('id'); $max_page=ceil($count/$limit);
                $start=$page*$limit-$limit;
                if($page<1) $page=1; if($page>$max_page) $page=$max_page; if($page<1) $page=1; if($max_page==0) $max_page=1;
                $announces=Announces::find()->where(['status'=>$status]);
                if($status==4) $announces->orderBy(['deleted_time'=>SORT_DESC]);
                elseif($status==0) $announces->orderBy(['announce_date'=>SORT_ASC]);
                else $announces->orderBy(['announce_date'=>SORT_DESC]);
                $announces=$announces->offset($start)->limit($limit)->asArray()->all();
            }
            elseif($status==5){
                $count=Announces::find()->where('sort_foward>0')->count('id'); $max_page=ceil($count/$limit);
                $start=$page*$limit-$limit;
                if($page<1) $page=1; if($page>$max_page) $page=$max_page; if($page<1) $page=1; if($max_page==0) $max_page=1;
                $announces=Announces::find()->where('sort_foward>0')->orderBy(['announce_date'=>SORT_DESC])->offset($start)->limit($limit)->asArray()->all();
            }
            elseif($status==6){
                $count=Announces::find()->where('urgently>0')->count('id'); $max_page=ceil($count/$limit);
                $start=$page*$limit-$limit;
                if($page<1) $page=1; if($page>$max_page) $page=$max_page; if($page<1) $page=1; if($max_page==0) $max_page=1;
                $announces=Announces::find()->where('urgently>0')->orderBy(['announce_date'=>SORT_DESC])->offset($start)->limit($limit)->asArray()->all();
            }
            elseif($status==7){
                $count=Announces::find()->where('sort_premium>0')->count('id'); $max_page=ceil($count/$limit);
                $start=$page*$limit-$limit;
                if($page<1) $page=1; if($page>$max_page) $page=$max_page; if($page<1) $page=1; if($max_page==0) $max_page=1;
                $announces=Announces::find()->where('sort_premium>0')->orderBy(['announce_date'=>SORT_DESC])->offset($start)->limit($limit)->asArray()->all();
            }
            elseif($status==8){
                $count=Announces::find()->where('sort_search>0')->count('id'); $max_page=ceil($count/$limit);
                $start=$page*$limit-$limit;
                if($page<1) $page=1; if($page>$max_page) $page=$max_page; if($page<1) $page=1; if($max_page==0) $max_page=1;
                $announces=Announces::find()->where('sort_search>0')->orderBy(['announce_date'=>SORT_DESC])->offset($start)->limit($limit)->asArray()->all();
            }
            elseif($status==9) //Butun elanlar
            {
                extract($_GET);
                $query_w = 'id>0';
                if(isset($announce_type)) $announce_type_exp=explode("888",$announce_type); else $announce_type=0;
                if(isset($property_type)) $property_type=intval($property_type); else $property_type=0;
                if(isset($repair)) $repair=intval($repair); else $repair=-1;
                if(isset($city)) $city=intval($city); else $city=0;
                if(isset($room_min)) $room_min=intval($room_min); else $room_min=0;
                if(isset($room_max)) $room_max=intval($room_max); else $room_max=0;
                if(isset($space_min)) $space_min=intval($space_min); else $space_min=0;
                if(isset($space_max)) $space_max=intval($space_max); else $space_max=0;
                if(isset($price_min)) $price_min=intval($price_min); else $price_min=0;
                if(isset($price_max)) $price_max=intval($price_max); else $price_max=0;
                if(isset($document)) $document=intval($document); else $document=0;
                if(isset($announcer)) $announcer=intval($announcer); else $announcer=0;
                if(isset($day)) $day=intval($day); else $day=0;
                if(!isset($selected_regions)) $selected_regions='';
                if(!isset($selected_metros)) $selected_metros='';
                if(!isset($selected_settlements)) $selected_settlements='';
                if(!isset($selected_marks)) $selected_marks='';

                if($announce_type>0) { $query_w.=" and rent_type=".$announce_type_exp[1]." and announce_type=".$announce_type_exp[0]; $link.='&announce_type='.$announce_type; }
                if($property_type>0) { $query_w.=" and property_type=".$property_type; $link.='&property_type='.$property_type; }
                if($repair>=0) { $query_w.=" and repair=".$repair; $link.='&repair='.$repair; }
                if($city>0) { $query_w.=" and city=".$city; $link.='&city='.$city; }
                if($room_min>0) { $query_w.=" and room_count>=".$room_min; $link.='&room_min='.$room_min; }
                if($room_max>0) { $query_w.=" and room_count<=".$room_max; $link.='&room_max='.$room_max; }
                if($space_min>0) { $query_w.=" and space>=".$space_min; $link.='&space_min='.$space_min; }
                if($space_max>0) { $query_w.=" and space<=".$space_max; $link.='&space_max='.$space_max; }
                if($price_min>0) { $query_w.=" and price>=".$price_min; $link.='&price_min='.$price_min; }
                if($price_max>0) { $query_w.=" and price<=".$price_max; $link.='&price_max='.$price_max; }
                if($document>0) { $query_w.=" and document=1"; $link.='&document=1'; }
                if($announcer>0) { $query_w.=" and announcer=".$announcer; $link.='&announcer='.$announcer; }
                if($day==1) { $dat_time=time()-86400;  $query_w.=" and announce_date>".$dat_time; $link.='&day=1'; }
                if($day==7) { $dat_time=time()-(86400*7); $query_w.=" and announce_date>".$dat_time; $link.='&day=7'; }
                if($day==30) { $dat_time=time()-(86400*30); $query_w.=" and announce_date>".$dat_time; $link.='&day=30'; }

                $addQ='';
                if(is_array($selected_regions) && count($selected_regions)>0){
                    $addQ.="region IN(".implode(",",$selected_regions).") or ";
                    foreach($selected_regions as $item){
                        $link.='&selected_regions[]='.$item;
                    }
                }
                if(is_array($selected_metros) && count($selected_metros)>0){
                    $addQ.="metro IN(".implode(",",$selected_metros).") or ";
                    foreach($selected_metros as $item){
                        $link.='&selected_metros[]='.$item;
                    }
                }
                if(is_array($selected_settlements) && count($selected_settlements)>0){
                    $addQ.="settlement IN(".implode(",",$selected_settlements).") or ";
                    foreach($selected_settlements as $item){
                        $link.='&selected_settlements[]='.$item;
                    }
                }
                if(is_array($selected_marks) && count($selected_marks)>0){
                    if(count($selected_marks)==1) $addQ.="mark=".$selected_marks[0]." or ";
                    else{
                        foreach($selected_marks as $mrk){
                            $lk1='-'.$mrk.'-';		$lk2=$mrk.'-';   $lk3='-'.$mrk;
                            $addQ.="mark like '%$lk1%' or mark like '$lk2%' or mark like '%$lk3' or mark='$mrk' or ";
                            $link.='&selected_marks[]='.$mrk;
                        }
                    }
                }
                if($addQ!=''){
                    $addQ=substr($addQ,0,strlen($addQ)-3);
                    $query_w.=" and ($addQ) ";
                }

                $count = 0; $anns=[];

                foreach(Yii::$app->params["fullAnnouncesArchives"] as $table)
                {
                    $tb='backend\models\\'.$table;

                    $announces_count=$tb::find()->where($query_w)->count('id');
                    $count+=$announces_count;
                    $anns[]=$announces_count;
                }

//
//                foreach(Yii::$app->params["fullAnnouncesArchives"] as $table)
//                {
//                    $tb='backend\models\\'.$table;
//
//                    $announces=$tb::find()->orderBy(['announce_date'=>SORT_DESC])->offset($start)->limit($limit)->asArray()->all();
//
//                    if(!empty($announces)) break;
//                }

                $limit=10; $gosterilecek=$limit; $show=2;
                $start=$page*$limit-$limit;
                $minLazim=$start; $lazim=$start+$gosterilecek;

                $announces=[]; $key=0;

                foreach(Yii::$app->params["fullAnnouncesArchives"] as $tb=>$table){

                    $tb='backend\models\\'.$table;

                    if(isset($anns[$key])){
                        if($anns[$key]>=$lazim){
//                            $ann_rows=Yii::$app->db->createCommand("select * from $tb where order by announce_date desc limit $start,$gosterilecek")->queryAll();
                            $ann_rows=$tb::find()->where($query_w)->orderBy(['announce_date'=>SORT_DESC])->offset($start)->limit($gosterilecek)->asArray()->all();

                            $announces=array_merge($announces,$ann_rows);
                            break;
                        }
                        else{
                            if($anns[$key]>$minLazim){
//                                $ann_rows=Yii::$app->db->createCommand("select * from $tb where order by announce_date desc limit $start,$gosterilecek")->queryAll();

                                $ann_rows=$tb::find()->where($query_w)->orderBy(['announce_date'=>SORT_DESC])->offset($start)->limit($gosterilecek)->asArray()->all();

                                $announces=array_merge($announces,$ann_rows);
                                $gosterilecek-=count($ann_rows);
                                $start=0;
                                $lazim=$start+$gosterilecek;
                            }
                            else{
                                $start=$minLazim-$anns[$key];
                                $minLazim=$start;
                            }
                        }
                    }
                    $key++;
                }

                $max_page=ceil($count/$limit);
                if($page<1) $page=1; if($page>$max_page) $page=$max_page; if($page<1) $page=1;
            }
            $sameAnnounces=[];
        }
        if($status==0 || $status==9) $renderFile='index_new'; else $renderFile='index';

        return $this->render($renderFile, [
            'titleName' => Announces::$titleName,
            'announces' => $announces,
            'sameAnnounces' => $sameAnnounces,
            'show'=>$show,
            'page'=>$page,
            'max_page'=>$max_page,
            'link'=>$link,
            'status'=>$status,
            'count'=>$count,
            'id'=>$id,
        ]);

    }
    public function changeStatus($id,$status,$changeStatus,$reasons='',$currentAdminId,$sendSms,$archiveView){
        if($changeStatus==1)
        {
            if(AnnouncesEdited::find()->where(['announce_id'=>$id])->count('id')>0)
            {
                Yii::$app->session->setFlash('danger','Bu elan düzəliş edilməsi üçün sorğu göndərib. Düzəlişi tamamlanmamış elanı aktiv etmək olmaz.');
                return $this->redirect(Url::to([Yii::$app->controller->id.'/index?status='.$status]));
            }
            else
            {
                $time=time();
                foreach(Yii::$app->params["fullAnnouncesArchives"] as $tb_name=>$table){
                    $tb='backend\models\\'.$table;
                    $update=$tb::find()->where(['id'=>$id])->one();
                    if(!empty($update)) break;
                }
                if(empty($update)){
                    Yii::$app->session->setFlash('danger','Bu kodda elan tapılmadı.');
                    return $this->redirect(Url::to([Yii::$app->controller->id.'/index?status='.$status]));
                }
                if($update->status==1)
                {
                    Yii::$app->session->setFlash('danger','Aktiv elanı yenidən aktiv etmək istəyirsən? Are you clever?');
                    return $this->redirect(Url::to([Yii::$app->controller->id.'/index?status='.$status]));
                }
                else if($update->status==2 && $update->announce_date<($time-($this->packagePrices["announce_time"]*86400)))
                {
                    Yii::$app->session->setFlash('danger','Elanın vaxtı bitdiyinə görə aktiv edilə bilmir. Aktiv etmək üçün irəli çəkə bilərsiz.');
                    return $this->redirect(Url::to(['announces-search/index?AnnouncesSearch[id]='.$id]));
                }
                else
                {
                    //MyFunctions::setWatermarktoImages($id);
                    $saveArchive=new ArchiveDb();
                    $saveArchive->from_='Admin:'.$currentAdminId;
                    $saveArchive->to_='Announce:'.$id;
                    if($update->status==0) $saveArchive->operation='accept'; else $saveArchive->operation='active';
                    $saveArchive->mobiles=$update->mobile;
                    if($time-$update->create_time<(86400*3)) $saveArchive->time_count=$this->packagePrices["announce_time"];
                    $saveArchive->announce_id=$id;
                    $saveArchive->create_time=date("Y-m-d H:i:s");
                    $saveArchive->save(false);

                    if($sendSms) $update->sms_status=$sendSms;
                    if($archiveView=="true") $update->archive_view=time();
                    $update->status=1;
                    $update->reasons='-';
                    if($time-$update->create_time<(86400*3) or $update->create_time==$update->announce_date) $update->announce_date=$time;
                    $update->save(false);

                    // elan basqa bazadadirsa onu berpa edir
                    if($tb_name!='announces'){
                        Yii::$app->db->createCommand("insert into announces select * from $tb_name where id='$id' ")->execute();
                        Yii::$app->db->createCommand("delete from $tb_name where id='$id' ")->execute();
                    }

                    // email gondersin
//					$mail = new PHPMailer();
//					$mail->SetFrom($this->infoContact[0]["email"], 'Emlak.az');
//					$mail->AddReplyTo($this->infoContact[0]["email"]);
//					$mail->AddAddress($update->email);
//					//$mail->AddAddress('e.alizade92@gmail.com');
//					$mail->Subject='Elanınız aktiv edildi.';

                    $code=MyFunctions::codeGeneratorforUser($update->id);
                    $editURL='https://emlak.az/elan-ver/index?id='.$update->id.'&code='.$code;

                    $message='
					Hörmətli '.$update->name.'. Sizin emlak.az saytında yerləşdirdiyiniz elan aktiv edildi.<br />
					Elanınızın kodu: <b>'.$update->id.'</b><br />
					Elanınızın tez satılmasını istəyirsizsə, aşağıdakı xidmətlərimizdən yararlana bilərsiz:<br /><br />
					<a href="https://emlak.az/'.$update->id.'-do-premium.html">Elanı premium et / 20 AZN</a><br /><br />
					<a href="https://emlak.az/'.$update->id.'-.html">Axtarışda seçilən et / 10 gün-10 AZN</a><br /><br />
					<a href="https://emlak.az/'.$update->id.'-.html">Təcili et / 5 AZN</a><br /><br /><br />
					
					Elanınızda düzəliş etmək istəsəz <a href="'.$editURL.'">bu linkə</a> daxil ola bilərsiz.
					';
//					$mail->MsgHTML($message);
//					$mail->Send();

                    Yii::$app->mailer->compose()
                        ->setFrom($this->infoContact[0]["email"])
                        ->setReplyTo($this->infoContact[0]["email"])
                        ->setTo($update->email)
                        ->setSubject('Elanınız aktiv edildi.')
                        ->setTextBody('Elanınız aktiv edildi.')
                        ->setHtmlBody($message)
                        ->send();
                    //

                    //Sms gonder
                    if($sendSms=="true")
                    {
//                        $sms_message='
//					Hormetli '.$update->name.'. Sizin emlak.az saytinda yerleshdirdiyiniz elan aktiv edildi.
//					Elaninizin kodu: '.$update->id.'
//					Elaninizin tez satilmasini isteyirsizse, ashagidaki xidmetlerimizden yararlana bilersiz:
//					Elani premium et / 20 AZN - emlak.az/'.$update->id.'-do-premium.html
//					Axtarishda sechilen et / 10 gun-10 AZN - emlak.az/'.$update->id.'-.html
//					Tecili et / 5 AZN - emlak.az/'.$update->id.'-.html
//
//					Elaninizda duzelish etmek istesez '.$editURL.' daxil ola bilersiz.
//					';
                        $sms_message = 'Hormetli '.$update->name.', sizin '.$update->id.' kodlu elaniniz aktiv edildi. Emlakinizi Premium ederek tez satilmasina nail olun; 0125551818; 0505551818';
                        if(strpos($update->mobile,'*')>0)
                        {
                            $explode = explode('*',$update->mobile);
                            $mobile = $explode[0];
                        }
                        else
                            $mobile = $update->mobile;

                        $replace1 = str_replace(")", "", $mobile);
                        $replace2 = str_replace("(","",$replace1);
                        $replace3 = str_replace("-","",$replace2);
                        $replace4 = str_replace(" ","",$replace3);

                        $sms_mobile = substr($replace4, 1);

                        $smsUsername = 'emlak_az';
                        $smsPassword = 'emlak896';

                        $getdata = http_build_query(
                            array(
                                'user' => $smsUsername,
                                'password' => $smsPassword,
                                'gsm' => $sms_mobile,
                                'text' => $sms_message
                            )
                        );

                        $opts = array('http' =>
                            array(
                                'method'  => 'GET',
                                'header'  => 'Content-type: application/x-www-form-urlencoded',
                                'content' => $getdata
                            )
                        );

                        $context  = stream_context_create($opts);

                        $data = file_get_contents('http://www.poctgoyercini.com/api_http/sendsms.asp', false, $context);

                        $explode_data = explode('&',$data);

                        $saveSms = new SmsAnn();
                        $saveSms->message_status = $changeStatus;
                        $saveSms->time = time();
                        $saveSms->ann_id = $update->id;
                        $saveSms->sms_status = $explode_data[0];
                        $saveSms->sms_id = $explode_data[2];
                        $saveSms->charge = $explode_data[3];
                        $saveSms->error_text = $explode_data[1];
                        $saveSms->mobile = $sms_mobile;
                        $saveSms->save(false);

                    }
                    //

                    // yuklenmeye gore muveqqeti cixardiram...
                    $this->getCacheUpdate($update->email);
                    Yii::$app->session->setFlash('success','Elan aktiv edildi.');
                    return $this->redirect(Url::to([Yii::$app->controller->id.'/index?status='.$status]));
                }
            }
        } // end if $changeStatus==1
        else if($changeStatus==3){
            foreach(Yii::$app->params["fullAnnouncesArchives"] as $table){
                $tb='backend\models\\'.$table;
                $update=$tb::find()->where(['id'=>$id])->one();
                if(!empty($update)) break;
            }
            if(empty($update)){
                Yii::$app->session->setFlash('danger','Bu kodda elan tapılmadı.');
                return '';
            }

            $update->reasons=$reasons;
            $update->status=3;
            //$update->urgently=0;
            //$update->sort_search=0;
            //$update->sort_foward=0;
            //$update->sort_package=0;
            //$update->sort_premium=0;
            $update->save(false);

            $reasons=explode('-',$reasons);
            $text='';
            foreach($reasons as $r){
                if(intval($r)>0) $text.=Yii::t('app','error_r'.$r).'***';
            }
            $code=MyFunctions::codeGeneratorforUser($update->id);
            $editURL='https://emlak.az/elan-ver/index?id='.$update->id.'&code='.$code;
            $message=str_replace('***','<br />',$text);
            // email gondersin
//            $mail = new PHPMailer();
//            $mail->SetFrom($this->infoContact[0]["email"], 'Emlak.az');
//            $mail->AddReplyTo($this->infoContact[0]["email"]);
//            $mail->AddAddress($update->email);
//            $mail->Subject='Elanınız aktiv edilmədi.';

            $message='
			Hörmətli '.$update->name.'. Sizin emlak.az saytında yerləşdirdiyiniz elan aktiv edilmədi.<br />
			Elanınızın kodu: <b>'.$update->id.'</b><br /><br/>
			'.$message.'
			<br /><br/>
			Elanınızda düzəliş etmək istəsəz <a href="'.$editURL.'">bu linkə</a> daxil ola bilərsiz.
			';
//            $mail->MsgHTML($message);
//            $mail->Send();

            Yii::$app->mailer->compose()
                ->setFrom($this->infoContact[0]["email"])
                ->setReplyTo($this->infoContact[0]["email"])
                ->setTo($update->email)
                ->setSubject('Elanınız aktiv edilmədi.')
                ->setTextBody('Elanınız aktiv edilmədi.')
                ->setHtmlBody($message)
                ->send();
            // istifadeciye email gonderilsin qebul edilmemekle bagli...$message hazirdi qabagina artir birce, elaniniz deaktiv edildi..
            //

            $saveArchive=new ArchiveDb();
            $saveArchive->from_='Admin:'.$currentAdminId;
            $saveArchive->to_='Announce:'.$id;
            if($update->status==0) $saveArchive->operation='not_accept'; else $saveArchive->operation='deactive';
            $saveArchive->announce_id=$id;
            $saveArchive->text=$text;
            $saveArchive->create_time=date("Y-m-d H:i:s");
            $saveArchive->save(false);

            //Sms gonder
            if($sendSms=="true")
            {
//                $sms_message='
//			Hormetli '.$update->name.'. Sizin emlak.az saytinda yerleshdirdiyiniz elan aktiv edilmedi.
//			Elaninizin kodu: '.$update->id.'
//			Elaninizda duzelish etmek istesez bu linke daxil ola bilersiniz: '.$editURL;
                $sms_message = 'Hormetli '.$update->name.', teessuf ki sizin '.$update->id.' kodlu elaniniz aktiv edilmedi. Sebebi barede bizimle elaqe saxlayin; 0125551818; 0505551818';
                if(strpos($update->mobile,'*')>0)
                {
                    $explode = explode('*',$update->mobile);
                    $mobile = $explode[0];
                }
                else
                    $mobile = $update->mobile;

                $replace1 = str_replace(")", "", $mobile);
                $replace2 = str_replace("(","",$replace1);
                $replace3 = str_replace("-","",$replace2);
                $replace4 = str_replace(" ","",$replace3);

                $sms_mobile = substr($replace4, 1);

                $smsUsername = 'emlak_az';
                $smsPassword = 'emlak896';

                $getdata = http_build_query(
                    array(
                        'user' => $smsUsername,
                        'password' => $smsPassword,
                        'gsm' => $sms_mobile,
                        'text' => $sms_message
                    )
                );

                $opts = array('http' =>
                    array(
                        'method'  => 'GET',
                        'header'  => 'Content-type: application/x-www-form-urlencoded',
                        'content' => $getdata
                    )
                );

                $context  = stream_context_create($opts);

                $data = file_get_contents('http://www.poctgoyercini.com/api_http/sendsms.asp', false, $context);

                $explode_data = explode('&',$data);

                $saveSms = new SmsAnn();
                $saveSms->message_status = $changeStatus;
                $saveSms->time = time();
                $saveSms->ann_id = $update->id;
                $saveSms->sms_status = $explode_data[0];
                $saveSms->sms_id = $explode_data[2];
                $saveSms->charge = $explode_data[3];
                $saveSms->error_text = $explode_data[1];
                $saveSms->mobile = $sms_mobile;
                $saveSms->save(false);

            }
            //

            // yuklenmeye gore muveqqeti cixardiram...
            $this->getCacheUpdate($update->email);
            //MyFunctions::setWatermarktoImages($id);
            Yii::$app->session->setFlash('success','Əməliyyat təsdiq edildi');


            return $this->redirect(Url::toRoute([Yii::$app->controller->id.'/index?status='.$status]));
        } // end if $changeStatus==3
        else if($changeStatus==4){
            // yuklenmeye gore muveqqeti cixardiram...
            //MyFunctions::setWatermarktoImages($id);

            foreach(Yii::$app->params["fullAnnouncesArchives"] as $table){
                $tb='backend\models\\'.$table;
                $update=$tb::find()->where(['id'=>$id])->one();
                if(!empty($update)) break;
            }
            if(empty($update)){
                Yii::$app->session->setFlash('danger','Bu kodda elan tapılmadı.');
                return $this->redirect(Url::to([Yii::$app->controller->id.'/index?status='.$status]));
            }
            if($update->status==4 or ($update->status==2 && $update->deleted_time>0) )
            {
                Yii::$app->session->setFlash('danger','Silinmiş elanı yenidən silmək istəyirsən? Are you clever?');
                return $this->redirect(Url::to([Yii::$app->controller->id.'/index?status='.$status]));
            }
            $update->reasons=$reasons;
            $update->deleted_time=time();
            $update->status=4;
            $update->save(false);

            $reasons=explode('-',$reasons);
            $text='';
            foreach($reasons as $r){
                if(intval($r)>0) $text.=Yii::t('app','error_r'.$r).'***';
            }
            $message=str_replace('***','<br />',$text);
            // email gondersin
//            $mail = new PHPMailer();
//            $mail->SetFrom($this->infoContact[0]["email"], 'Emlak.az');
//            $mail->AddReplyTo($this->infoContact[0]["email"]);
//            $mail->AddAddress($update->email);
//            $mail->Subject='Elanınız saytdan silindi.';
            $message='
			Hörmətli '.$update->name.'. Sizin emlak.az saytında yerləşdirdiyiniz elan saytdan silindi.<br />
			Elanınızın kodu: <b>'.$update->id.'</b><br /><br/>
			';
//            $mail->MsgHTML($message);
//            $mail->Send();

            Yii::$app->mailer->compose()
                ->setFrom($this->infoContact[0]["email"])
                ->setReplyTo($this->infoContact[0]["email"])
                ->setTo($update->email)
                ->setSubject('Elanınız saytdan silindi.')
                ->setTextBody('Elanınız saytdan silindi.')
                ->setHtmlBody($message)
                ->send();
            //

            //Sms gonder
            if($sendSms=="true")
            {
//                $sms_message='
//			Hormetli '.$update->name.'. Sizin emlak.az saytinda yerleshdirdiyiniz elan saytdan silindi.
//			Elaninizin kodu: '.$update->id;
                    $sms_message = 'Hormetli '.$update->name.', sizin '.$update->id.' kodlu elaniniz saytimizdan silindi; 0125551818; 0505551818';
                if(strpos($update->mobile,'*')>0)
                {
                    $explode = explode('*',$update->mobile);
                    $mobile = $explode[0];
                }
                else
                    $mobile = $update->mobile;

                $replace1 = str_replace(")", "", $mobile);
                $replace2 = str_replace("(","",$replace1);
                $replace3 = str_replace("-","",$replace2);
                $replace4 = str_replace(" ","",$replace3);

                $sms_mobile = substr($replace4, 1);

                $smsUsername = 'emlak_az';
                $smsPassword = 'emlak896';

                $getdata = http_build_query(
                    array(
                        'user' => $smsUsername,
                        'password' => $smsPassword,
                        'gsm' => $sms_mobile,
                        'text' => $sms_message
                    )
                );

                $opts = array('http' =>
                    array(
                        'method'  => 'GET',
                        'header'  => 'Content-type: application/x-www-form-urlencoded',
                        'content' => $getdata
                    )
                );

                $context  = stream_context_create($opts);

                $data = file_get_contents('http://www.poctgoyercini.com/api_http/sendsms.asp', false, $context);

                $explode_data = explode('&',$data);

                $saveSms = new SmsAnn();
                $saveSms->message_status = $changeStatus;
                $saveSms->time = time();
                $saveSms->ann_id = $update->id;
                $saveSms->sms_status = $explode_data[0];
                $saveSms->sms_id = $explode_data[2];
                $saveSms->charge = $explode_data[3];
                $saveSms->error_text = $explode_data[1];
                $saveSms->mobile = $sms_mobile;
                $saveSms->save(false);

            }
            //

            $saveArchive=new ArchiveDb();
            $saveArchive->from_='Admin:'.$this->adminLoggedInfo[0]["id"];
            $saveArchive->to_='Announce:'.$id;
            $saveArchive->operation='admin_deleted';
            $saveArchive->announce_id=$id;
            $saveArchive->text=$text;
            $saveArchive->create_time=date("Y-m-d H:i:s");
            $saveArchive->save(false);

            $this->getCacheUpdate($update->email);
            Yii::$app->session->setFlash('success','Əməliyyat təsdiq edildi');
            return $this->redirect(Url::toRoute([Yii::$app->controller->id.'/index?status='.$status]));
        } // end if $changeStatus==4
    }

    public function changeSmstatus($id,$status,$changeStatus,$reasons='',$currentAdminId,$sendSms){
        if($sendSms=="true" or $sendSms=="false")
        {
            if(AnnouncesEdited::find()->where(['announce_id'=>$id])->count('id')>0)
            {
                Yii::$app->session->setFlash('danger','Bu elan düzəliş edilməsi üçün sorğu göndərib. Düzəlişi tamamlanmamış elanı aktiv etmək olmaz.');
                return $this->redirect(Url::to([Yii::$app->controller->id.'/index?status='.$status]));
            }
            else
            {
                $time=time();
                foreach(Yii::$app->params["fullAnnouncesArchives"] as $tb_name=>$table){
                    $tb='backend\models\\'.$table;
                    $update=$tb::find()->where(['id'=>$id])->one();
                    if(!empty($update)) break;
                }
                if(empty($update)){
                    Yii::$app->session->setFlash('danger','Bu kodda elan tapılmadı.');
                    return $this->redirect(Url::to([Yii::$app->controller->id.'/index?status='.$status]));
                }
                else
                {
                    //MyFunctions::setWatermarktoImages($id);
//                    $saveArchive=new ArchiveDb();
//                    $saveArchive->from_='Admin:'.$currentAdminId;
//                    $saveArchive->to_='Announce:'.$id;
//                    if($update->status==0) $saveArchive->operation='accept'; else $saveArchive->operation='active';
//                    $saveArchive->mobiles=$update->mobile;
//                    if($time-$update->create_time<(86400*3)) $saveArchive->time_count=$this->packagePrices["announce_time"];
//                    $saveArchive->announce_id=$id;
//                    $saveArchive->create_time=date("Y-m-d H:i:s");
//                    $saveArchive->save(false);

                    $update->sms_status=$sendSms;
                    if($time-$update->create_time<(86400*3) or $update->create_time==$update->announce_date) $update->announce_date=$time;
                    $update->save(false);

                    // elan basqa bazadadirsa onu berpa edir
                    if($tb_name!='announces'){
                        Yii::$app->db->createCommand("insert into announces select * from $tb_name where id='$id' ")->execute();
                        Yii::$app->db->createCommand("delete from $tb_name where id='$id' ")->execute();
                    }

                    // yuklenmeye gore muveqqeti cixardiram...
                    $this->getCacheUpdate($update->email);
                    if($sendSms=="true")
                        Yii::$app->session->setFlash('success','Elan sms aktiv edildi.');
                    else
                        Yii::$app->session->setFlash('success','Elan sms deaktiv edildi.');

                    return $this->redirect(Url::to([Yii::$app->controller->id.'/index?status='.$status]));
                }
            }
        } // end if $changeStatus==1
    }

    public function actionShowimages($id){
//        $archives=ArchiveDb::find()->where('id='.$id)->orderBy(['id'=>SORT_ASC])->asArray()->all();
        $announces=Announces::findOne($id);
        if(empty($announces)) exit();
        else{
            return $this->renderPartial('showimages', [
                'announces' => $announces,
            ]);
        }
    }

    public function actionShowarchive($id){
        $archives=ArchiveDb::find()->where('announce_id='.$id)->orderBy(['id'=>SORT_DESC])->asArray()->all();
        if(empty($archives)){
            echo 'Məlumat tapılmadı.<br />';
        }
        else{
            return $this->renderPartial('showarchive', [
                'archives' => $archives,
                'id' => $id,
            ]);
        }
    }

    public function actionShowmap($id){
        $announces=Announces::findOne($id);
        if(empty($announces)) exit();
        else
        {
            return $this->renderPartial('showimages', [
                'announces' => $announces,
            ]);
        }
    }

    public function actionArchiveview($id,$status,$redirect_status='')
    {
        foreach(Yii::$app->params["fullAnnouncesArchives"] as $tb_name=>$table)
        {
            $tb='backend\models\\'.$table;
            $find=$tb::find()->where(['id'=>$id])->one();
            $count = Yii::$app->db->createCommand("select count(id) from announces where id='$id'")->queryScalar();

            if($tb_name!='announces')
            {
                $count2=$tb::find()->where(['id'=>$id])->one();
            }

            if(!empty($find))
            {
                if($count==0 && $status==1)
                {
//                    Yii::$app->db->createCommand("insert into announces select * from $tb_name where id='$id' ")->execute();

                    $save_ann = new Announces();
                    $save_ann->id = $find->id;
                    $save_ann->email = $find->email;
                    $save_ann->mobile = $find->mobile;
                    $save_ann->name = $find->name;
                    $save_ann->price = $find->price;
                    $save_ann->cover = $find->cover;
                    $save_ann->images = $find->images;
                    $save_ann->logo_images = $find->logo_images;
                    $save_ann->room_count = $find->room_count;
                    $save_ann->rent_type = $find->rent_type;
                    $save_ann->property_type = $find->property_type;
                    $save_ann->announce_type = $find->announce_type;
                    $save_ann->country = $find->country;
                    $save_ann->city = $find->city;
                    $save_ann->region = $find->region;
                    $save_ann->settlement = $find->settlement;
                    $save_ann->metro = $find->metro;
                    $save_ann->mark = $find->mark;
                    $save_ann->address = $find->address;
                    $save_ann->google_map = $find->google_map;
                    $save_ann->floor_count = $find->floor_count;
                    $save_ann->current_floor = $find->current_floor;
                    $save_ann->space = $find->space;
                    $save_ann->repair = $find->repair;
                    $save_ann->document = $find->document;
                    $save_ann->text = $find->text;
                    $save_ann->view_count = $find->view_count;
                    $save_ann->announcer = $find->announcer;
                    $save_ann->status = $find->status;
                    $save_ann->insert_type = $find->insert_type;
                    $save_ann->urgently = $find->urgently;
                    $save_ann->sort_search = $find->sort_search;
                    $save_ann->sort_foward = $find->sort_foward;
                    $save_ann->sort_package = $find->sort_package;
                    $save_ann->sort_premium = $find->sort_premium;
                    $save_ann->announce_date = $find->announce_date;
                    $save_ann->create_time = $find->create_time;
                    $save_ann->deleted_time = $find->deleted_time;
                    $save_ann->reasons = $find->reasons;
                    $save_ann->discount = $find->discount;
                    $save_ann->panarama = $find->panarama;
                    $save_ann->sms_status = $find->sms_status;
                    $save_ann->cdn_server = $find->cdn_server;
//                    $save_ann->archive_view = $find->archive_view;
                    $save_ann->save(false);
                }
                elseif($count>0 && $status==0)
                {
                    if(!empty($count2))
                        Yii::$app->db->createCommand("delete from announces where id='$id' and archive_view>0 ")->execute();
                    else
                        Yii::$app->db->createCommand("update announces set archive_view=0 where id='$id' and archive_view>0")->execute();
                }

                if($status==1)
                    Yii::$app->db->createCommand("update announces set archive_view='".time()."' where id='$id' ")->execute();

                break;
            }
        }

//        echo Yii::$app->request->urlReferrer;
        return $this->redirect(['index?status='.$redirect_status]);
    }

}
?>