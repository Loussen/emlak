<?php
ob_start(); session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$timezone = "Asia/Baku"; if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);

$host="localhost";
$username="emlakaz";
$password="Jkrfh72VXsb4DL";
$db="emlakaz";
$time=time();

$connect=mysql_connect($host,$username,$password) or die(mysql_error() );
mysql_select_db($db,$connect);
mysql_query("set names utf8");

set_time_limit(86400); ini_set('max_execution_time', 86400); ini_set('memory_limit', '-1');
?>