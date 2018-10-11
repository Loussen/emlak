<?php
include "config.php";
include "../PHPMailer/class.phpmailer.php";
$process_type=addslashes($_GET["process_type"]);

// bitmis elanlar ucun cron
if($process_type=='ann'){
	
    $ann=intval($_GET["ann"]);
    $package_prices=mysql_fetch_assoc(mysql_query("select * from package_prices where id=1"));
    $bitib=$time-($package_prices["announce_time"]*86400);
    $moved=0;
    if($_GET["id"]) $id=intval($_GET["id"]); else $id=0;
    if($_GET["admin"]) $admin=intval($_GET["admin"]); else $admin=0;
    if($_GET["code"]) $code=addslashes($_GET["code"]); else $code='';
    $check_code=md5(md5($id.'-'.$admin.'-'.date("d")));
    if($ann==1) $addW="announcer=2"; else $addW='';
    if($id>0 && $check_code==$code) $sql=mysql_query("select * from announces where id='$id' ");
    else $sql=mysql_query("select id,email,name,mobile,sms_status from announces where announce_date<='$bitib' $addW  ");
    
	while($row=mysql_fetch_assoc($sql)){
        $moveT='announces_archive_'.date("Y");
//        mysql_query("update announces set status=2 where id='$row[id]' and status!=4 and archive_view=0 ");
        mysql_query("update announces set status=2 where id='$row[id]' "); //14.05.2017 Azer Changed
        mysql_query("insert into $moveT select * from announces where id='$row[id]' ");
//        mysql_query("delete from announces where id='$row[id]' and archive_view=0 ");
        mysql_query("delete from announces where id='$row[id]' "); //14.05.2017 Azer Changed
        $moved++;

        $code=md5(md5($row["id"].'-777'));
        $editURL='http://emlak.az/elan-ver/index?id='.$row["id"].'&code='.$code;

        // mail gonderilsin bitmesi ile bagli
        $mail = new PHPMailer();
//        $mail->IsSMTP();
//        $mail->SMTPAuth = true;
//        $mail->Host = 'smtp.gmail.com';
//        $mail->Port = 587;
//        $mail->SMTPSecure = 'tls';
//        $mail->Username = 'send@emlak.az';
//        $mail->Password = 'yeni4292020emlak';
        $mail->SetFrom('send@emlak.az', 'Emlak.az');
        $mail->AddReplyTo($to);
        $mail->AddAddress($row["email"]);
        $mail->Subject="Elanınız vaxtı bitib";
        $message='
		Hörmətli '.$row["name"].'. Sizin emlak.az saytında yerləşdirdiyiniz elanın vaxtı bitdiyinə görə saytdan çıxarıldı.<br />
		Elanınızın kodu: <b>'.$row["id"].'</b><br /><br/>
		Elanı yenidən aktiv etmək istəyirsizsə, elanınızı <a href="http://emlak.az/'.$row["id"].'-.html">irəli çək</a>ə bilərsiz.<br /><br />
		
		Elanınızda düzəliş etmək istəsəz <a href="'.$editURL.'">bu linkə</a> daxil ola bilərsiz.
		';
        $mail->MsgHTML($message);
        if($mail->Send()) {
            echo "mailler gonderildi<br>";
        } else {
            // bir sorun var, sorunu ekrana bastıralım
            echo $mail->ErrorInfo.'<br>';
        }
        //

        //Sms gonder
        if($row['sms_status']=="true")
        {
//            $sms_message='
//		Hormetli '.$row["name"].'. Sizin emlak.az saytinda yerleshdirdiyiniz elanin vaxti bitdiyine gore saytdan chixarildi.
//		Elaninizin kodu: '.$row["id"].'
//		Elani yeniden aktiv etmek isteyirsizse, elaninizi bu linke daxil olaraq ireli ceke bilersiniz: emlak.az/'.$row["id"].'-.html
//
//		Elaninizda duzelish etmek istesez bu linke daxil ola bilersiz: '.$editURL;
            $sms_message = 'Hormetli '.$row["name"].', '.$row["id"].' kodlu elaninizin vaxti bitdi. Yeniden aktiv etmek uchun Elani ireli chek -den istifade edin; 0125551818; 0505551818';
            if(strpos($row["mobile"],'*')>0)
            {
                $explode = explode('*',$row["mobile"]);
                $mobile = $explode[0];
            }
            else
                $mobile = $row["mobile"];

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

//            $saveSms = new SmsAnn();
//            $saveSms->message_status = $changeStatus;
//            $saveSms->time = time();
//            $saveSms->ann_id = $update->id;
//            $saveSms->sms_status = $explode_data[0];
//            $saveSms->sms_id = $explode_data[2];
//            $saveSms->charge = $explode_data[3];
//            $saveSms->error_text = $explode_data[1];
//            $saveSms->mobile = $sms_mobile;
//            $saveSms->save(false);

            mysql_query("insert into sms_ann (id,message_status,`time`,ann_id,sms_status,sms_id,charge,error_text,mobile) values ('',2,time(),'$row[id]','$explode_data[0]','$explode_data[2]',$explode_data[3],'$explode_data[1]','$sms_mobile') ");

        }
        //

        if($id>0 && $check_code==$code) $from='manual_cron:'.$admin;
        else $from='auto_cron';
        // insert archive
        $to=$row["id"];
        $operation='announce_ended';
        $announce_id=$row["id"];
		$create_time=date("Y-m-d H:i:s");
        mysql_query("insert into archive_db (from_,to_,operation,announce_id,create_time) values ('$from','$to','$operation','$announce_id','$create_time') ");
    }
    echo 'Elan bitmis edildi...';

    // premiumu bitmis profillerin premiumunu legv edir
    mysql_query("update users set premium=0 where premium<='$time' ");
}

// wekilleri temizleyir
elseif($process_type=='images'){
    for($i=1;$i<=2;$i++){
        if($i==1) $folder='temporary'; else $folder='temporary/thumb';
        $ac=opendir('../images/announces/'.$folder);
        while($oxu=readdir($ac)){
            if($oxu!='.' and $oxu!='..'){
                $filename='../images/announces/'.$folder.'/'.$oxu;
                if (file_exists($filename)) {
                    if(time()-filemtime($filename)>3600) unlink($filename);
                }
            }
        }
    }

    for($i=1;$i<=2;$i++){
        if($i==1) $folder='temporary'; else $folder='temporary/thumb';
        $ac=opendir('../images/users/'.$folder);
        while($oxu=readdir($ac)){
            if($oxu!='.' and $oxu!='..'){
                $filename='../images/users/'.$folder.'/'.$oxu;
                if (file_exists($filename)){
                    if(time()-filemtime($filename)>3600) unlink($filename);
                }
            }
        }
    }
    echo 'okeydir kizim ) afferin sana ) baglaya bilirsin. '.date("d.m.Y H:i:s");
}

elseif($process_type=='set_zero'){
    // ireli cekilmiwleri temizleyir vaxdi eger bitibse...
    $sql=mysql_query("select id,urgently,sort_search,sort_foward,sort_package,sort_premium from announces where urgently>0 or sort_search>0 or sort_foward>0 or sort_package>0 or sort_premium>0");
    while($row=mysql_fetch_assoc($sql)){
        if($row["urgently"]<$time) mysql_query("update announces set urgently=0 where id='$row[id]' ");
        if($row["sort_search"]<$time) mysql_query("update announces set sort_search=0 where id='$row[id]' ");
        if($row["sort_foward"]<$time) mysql_query("update announces set sort_foward=0 where id='$row[id]' ");
        if($row["sort_package"]<$time) mysql_query("update announces set sort_package=0 where id='$row[id]' ");
        if($row["sort_premium"]<$time) mysql_query("update announces set sort_premium=0 where id='$row[id]' ");
    }
    echo 'Baglaya bilersen. '.date("d.m.Y H:i:s");
}

// tmp papkasini temizleyir
elseif($process_type=='tmp'){
    // tmp papkasini temizleyir... 2 saat kohneden melumat daxil olubsa...
    $silindi=0;
    for($i=1;$i<=2;$i++){
        $folder1='../../tmp'; $limit1=20000;
        $folder2='../../../backend/tmp'; $limit2=40000;
        if($i==1) {$folder=$folder1; $limit=$limit1;}else{$folder=$folder2; $limit=$limit2;}
        $ac=opendir($folder);
        while($oxu=readdir($ac)){
            if($oxu!='.' and $oxu!='..'){
                $file=$folder.'/'.$oxu;
                $ft=filemtime($file);

                if($time-$ft>7200){
                    unlink($file);
                    $silindi++;
                }
            }
            if($silindi>=$limit) break;
        }
    }

    if($silindi>0){
        echo $silindi.' fayl silindi. 0 olana qeder davam et. hadi kocum ). '.date("H:i:s");
        $new_url='http://emlak.az/cron/cron.php?process_type=tmp';
        header("Refresh: 1; url=$new_url");
    }
    else echo 'okeydir kizim ) afferin sana ) baglaya bilirsin. '.date("d.m.Y H:i:s");
}

// debug papkasini temizleyir
elseif($process_type=='debug'){
    // tmp papkasini temizleyir... 2 saat kohneden melumat daxil olubsa...
    $silindi=0;
    $limit=50000;
    $ac=opendir('../../runtime/debug');
    while($oxu=readdir($ac)){
        if($oxu!='.' and $oxu!='..'){
            $file='../../tmp/runtime/debug/'.$oxu;
            $ft=filemtime($file);
            unlink($file);
            $silindi++;
        }
        if($silindi>=$limit) break;
    }

    if($silindi>=$limit){
        echo $silindi.' fayl silindi. 0 olana qeder davam et. hadi kocum ). '.date("H:i:s");
        $new_url='http://emlak.az/cron/cron.php?process_type=debug';
        header("Refresh: 1; url=$new_url");
    }
    else echo 'okeydir kizim ) afferin sana ) baglaya bilirsin. '.date("d.m.Y H:i:s");
}
elseif($process_type=='clear_property_type0'){
    mysql_query("delete from announces where property_type='0' ");
	echo 'okdur. baglaya bilirsin. '.date("d.m.Y H:i:s");
}
/*
// 2 gun qalmiw email getsin
elseif($process_type=='email_2'){
	require("../PHPMailer/class.phpmailer.php");
	$package_prices=mysql_fetch_assoc(mysql_query("select * from package_prices where id=1"));
	$contact_info=mysql_fetch_assoc(mysql_query("select * from package_prices where id=1"));
	$son2=($package_prices["announce_time"]-2)*86400;
	$min=$time-($package_prices["announce_time"]*86400);
	$sql=mysql_query("select email,id,name from announces where announce_date+'$son2'<'$time' and status=1 and announce_date>'$min'");
	
	$to='e.alizade92@gmail.com';
	$subject='test mövzu';
	$message='<a href="https://google.com">test mövzu</a>';
	$mail = new PHPMailer();
	$mail->SetFrom('office@emlak.az', 'Emlak.az');
	$mail->AddReplyTo($to);
	while($row=mysql_fetch_assoc($sql)){
		$mail->AddAddress($row["email"]);
		$mail->Subject="Elanınızın bitməyinə az qaldı";
		$message='
		Hörmətli '.$row->name.'. Sizin emlak.az saytında yerləşdirdiyiniz elan saytdan silindi.<br />
		Elanınızın kodu: <b>'.$update->id.'</b><br /><br/>
		';
		$mail->MsgHTML($message);
		$mail->Send();
	}
}
*/
?>