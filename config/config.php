<?php
	ob_start();
	session_start();
	//error_reporting(0);
	error_reporting(E_ALL);
	#===== DBCONFIG START
    define("DB_HOST", "localhost");
    define("DB_USER", "root");
    define("DB_PASS", "Lock2fit2017");
    define("DB_DATABASE", "astral_pipes");
	define("SITE_NAME", "http://10.10.10.3/astral-pipes/");

	#===== PROTOCOL.
	if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
	{
		$protocol = 'https://';
	}
	else
	{
		 $protocol = 'http://';
	}

	#==== Base URL
	define('base_url' , $protocol.$_SERVER['SERVER_NAME'].preg_replace('@/+$@','',dirname($_SERVER['SCRIPT_NAME'])).'/');
    #====== SITE PATH START
    define("DIR_ROOT", $_SERVER['DOCUMENT_ROOT']."/bharatbenz/");      //DIR PATH
    define("SITE_ROOT", $protocol.$_SERVER['HTTP_HOST']."/bharatbenz/"); // IP

    #===== SITE ADMIN PATH START
    define("ADMIN_DIR", $_SERVER['DOCUMENT_ROOT'].dirname($_SERVER['REQUEST_URI']));
    define("ADMIN_SITE", $protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI']));

  	define("ADMIN_COUNT",10);
	define("MANDATORY","&nbsp;&nbsp;<SPAN STYLE='color:#FF0000'><sup>*</sup></span>");

	include_once(DIR_ROOT."class/load_utility.php");
	include_once(DIR_ROOT."class/sysmsg.php");
	include_once(DIR_ROOT."class/php_image_magician.php");

	$objSystemMsg = new systemMsg();
	$objTypes 	  = new load_utility('mysql:dbname='.DB_DATABASE.';host='.DB_HOST.';charset=UTF8', DB_USER, DB_PASS);
	@$sysmsg 	  = intval($_REQUEST['sysmsg']);
	
	$UrlTitle	  = strip_tags($_REQUEST['title']); 
	$UrlId		  = intval($_REQUEST['id']);
	$UrlCatName	  = strip_tags($_REQUEST['cat_name']);
?>
