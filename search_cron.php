<?php
date_default_timezone_set('Asia/Kolkata');
include_once('include/common_functions.php');

$commonFunctions=new commonFunctions();
error_log("<br/>Cron Started at ".date('Y-m-d H:i:s'), 3, 'error.log');
echo "<br/>Cron Started at ".date('Y-m-d H:i:s');
require_once("config/config.php");

$sql_trun="TRUNCATE TABLE tbl_search";
$statement = $objTypes->prepare($sql_trun);
 
//Execute the statement.
$statement->execute();

$sql="select title,id,description from tbl_faq where is_active=1 and is_delete=1";
$data = $objTypes->fetchAll($sql);

foreach($data as $val){	
	$params=array(
			'url'=>'faq',
			'title'=>$val['title'],
			'content'=>strip_tags($val['description']),
			'description'=>strip_tags($val['description']),
			'is_active' => 1,
			'is_delete' => 1
			);
	$insert = $objTypes->insert("tbl_search", $params);
	if($insert){
		$insert_id = $objTypes->lastInsertId();
	}
}
echo '<br/> FAQs added..!'; 
/*-------------------------FAQs ends----------------------------*/
/*-------------------------FAQs ends----------------------------*/

/*---------------------Testimonials starts----------------------*/
/*---------------------Testimonials Ends------------------------*/

error_log("Cron Ended Successfully at ".date('Y-m-d H:i:s'), 3, 'error.log');
echo "<br/><br/>Cron Ended Successfully at ".date('Y-m-d H:i:s');
$subject	= "Cron Executed for Astral Pipe Search on  ".date('Y-m-d H:i:s');
$to 		= "farheen.parkar@bcwebwise.com";
$from 		= "farheen.parkar@bcwebwise.com";
$headers 	= 'From: ' . $from . "\r\n";
$headers 	.= "MIME-Version: 1.0" . "\r\n";
$headers 	.= "Content-type:text/html;charset=utf-8" . "\r\n";
$msg  = 'Cron Executed Successfully for Search '.date("jS F Y");
//$send_mail = mail($to, $subject, $msg, $headers);

?>