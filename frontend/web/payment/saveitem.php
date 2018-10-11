<?php
//header("Location: http://emlak.az/callback/index");
//exit();
/* 
 * *** GoldenPay integration PHP code sample ***
 * 
 * Save selected item and redireck user to payment page.
 */

require_once 'classes/filter/filter.php';
require_once 'classes/stub/PaymentGatewayGoldenpay.php';

$cardType = getFilteredParam('cardType');
$amount = intval(getFilteredParam('amount')*100);			//$amount=1;
$description = getFilteredParam('item');
$lang = getFilteredParam('lang');

//$check_system=explode("-",$description);	$kodu=$check_system[0];			if($kodu==273850) $amount=1;

$stub = new PaymentGatewayGoldenpay();

/*
 * Response: {"status":{"code":1,"message":"success"},"paymentKey":"8d53b07f-ec45-48b9-b877-c0e9d5c54682"}
 * 
 * Save payment key to your db : $resp->paymentKey
 */
$resp = $stub->getPaymentKeyJSONRequest($amount, $lang, $cardType, $description);
header('Location: '.$resp->urlRedirect);
?>


Please wait ...



