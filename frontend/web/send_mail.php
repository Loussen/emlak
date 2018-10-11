<?php
//require("PHPMailer/class.phpmailer.php");
require("PHPMailer/Phpmailer.php");
$to = urldecode($_GET["to"]);
$subject = urldecode($_GET["subject"]);
$message = urldecode($_GET["message"]);
$file = urldecode($_GET["file"]);

if($to==''){
	$to='e.alizade92@gmail.com';
	$subject='test mövzu';
	$message='<a href="https://google.com">test mövzu</a>';
	
	$file='';
	if($file!=''){ $subject= file_get_contents($file); $subject= eregi_replace("[\]",'',$body); }
	$query='?to='.urlencode($to).'&subject='.urlencode($subject).'&message='.urlencode($message);
	header("Location: http://emlak.az/send_mail.php".$query);
}

if($to!='' && $subject!='' && $message!=''){
	$mail = new PHPMailer();
	$mail->SetFrom('office@emlak.az', 'Emlak.az');
	$mail->AddReplyTo($to);
	$mail->AddAddress($to);
	$mail->Subject=$subject;
	$mail->MsgHTML($message);

	if(!$mail->Send()) echo "error";
	else echo "ok";
}
else echo 'empty';
?>