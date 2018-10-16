<?php
require_once("config/config.php");
/*------------------------Product entry-----------------------------*/
$sql_trun="TRUNCATE TABLE tbl_search";
$statement = $objTypes->prepare($sql_trun);
 
//Execute the statement.
$statement->execute();

$sql_application = $objTypes->fetchAll('select title,id,short_description from tbl_applications where is_active=1 and is_delete=1');

foreach($sql_application as $application){
		$url="applications/".$objTypes->prepare_url(str_replace(" ","-",strtolower($application['title'])))."-".$application['id'];
		$params=array(
				'url'=>$url,
				'title'=>$application['title'],
				'description'=>$application['short_description'],				
				'content'=>$application['short_description']
				);

		$insert_search = $objTypes->insert("tbl_search", $params);
		
	}

/*----------------------------------application-details-------------------------------*/

$sql_application_detail= $objTypes->fetchAll('select a.title as product_title,a.id,a.short_description,a.description,b.title as application_title from tbl_products_details as a left join tbl_applications as b on b.id=a.app_id where a.is_active=1 and a.is_delete=1');
foreach($sql_application_detail as $application_detail){
		$url="application-details/".$objTypes->prepare_url(str_replace(" ","-",strtolower($application_detail['application_title'])))."-".$objTypes->prepare_url(str_replace(" ","-",strtolower($application_detail['product_title'])))."-".$application_detail['id'];
		$params=array(
						'url'=>$url,
						'title'=>$application_detail['product_title'],
						'content'=>strip_tags($application_detail['short_description']),
						'description'=>strip_tags($application_detail['description'])
						);
		$insert_detail = $objTypes->insert("tbl_search", $params);
		
	}

/*-----------------------------page------------------------------*/
 $sql_partner="select title,short_description,id,description from tbl_pages where is_active=1 and is_delete=1";
 $data_partner = $objTypes->fetchAll($sql_partner);
 foreach($data_partner as $value_partner)
 {
 	if($value_partner['title']=="RnD" || $value_partner['title']=="why astral pipes" || $value_partner['title']=="Our Manufacturing Plants" || $value_partner['title']=="Vision"){
 		$url="about-us";
 	}else{
	    $url=$objTypes->prepare_url(str_replace(array(" ","&"),"-",strtolower($value_partner['title'])));
	}
	 $params=array(
				 'url'=>$url,
				 'content'=>$value_partner['short_description'],
				 'description'=>$value_partner['description'],
				 'title'=>$value_partner['title']
				 );
		 $insert = $objTypes->insert("tbl_search", $params);
		 
 }

/*------------------------------------------------------*/
/*------------------------------career-----------------------------*/
 $sql_career="select title,job_description from tbl_careers where is_active=1 and is_delete=1";
 $data_career = $objTypes->fetchAll($sql_career);
foreach($data_career as $value_career)
 {
	 	$params=array(
				 'url'=>'career',
				 'content'=>$value_career['job_description'],
				 'title'=>$value_career['title']
				 );
		 $insert = $objTypes->insert("tbl_search", $params);
		 
 }

/*--------------------------------------------------------------*/
/*---------------------------press release--------------------------*/
$sql_press="select title,description from tbl_pressrelease where is_active=1 and is_delete=1";
$data_press = $objTypes->fetchAll($sql_press);

foreach($data_press as $value_press)
{
		$param=array(
				'url'=>'press-release',
				'content'=>$value_press['description'],
				'title'=>$value_press['title']
				);

		$insert = $objTypes->insert("tbl_search", $param);
		
		
}

/*--------------------------------------------------*/
/*---------------------------event --------------------------*/
$sql_event="select title,short_description from tbl_event where is_active=1 and is_delete=1";
$data_event = $objTypes->fetchAll($sql_event);
foreach($data_event as $value_event)
{
		$params=array(
				'url'=>'news-events',
				'content'=>$value_event['short_description'],
				'title'=>$value_event['title']
				);
		$insert = $objTypes->insert("tbl_search", $params);
		
}
/*-------------------------faq-------------------------*/
$sql_event="select title,description from tbl_faq where is_active=1 and is_delete=1";
$data_event = $objTypes->fetchAll($sql_event);
foreach($data_event as $value_event)
{
		$params=array(
				'url'=>'faq',
				'content'=>$value_event['description'],
				'title'=>$value_event['title']
				);
		$insert = $objTypes->insert("tbl_search", $params);
		
}
/*-------------------------client-------------------------*/
$sql_client="select client,description from tbl_clients where is_active=1 and is_delete=1";
$data_client = $objTypes->fetchAll($sql_client);
foreach($data_client as $value_client)
{
		$params=array(
				'url'=>'clients',
				//'content'=>$value_client['description'],
				'title'=>$value_client['client']
				);
		$insert = $objTypes->insert("tbl_search", $params);
		
}
?>