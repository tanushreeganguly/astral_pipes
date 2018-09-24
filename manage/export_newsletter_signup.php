<?php
ob_start();
#=== Includes
require_once("../config/config.php");
require_once("verify_logins.php");
#==== Object Initialisations
$condition		= " status=1 " ;
$order			= 'id DESC'; 
$group			= '';
$limit			= ""; 
$career_app_arr		= $objTypes->fetchAll("SELECT * FROM tbl_newsletter_signup WHERE  status=1 ORDER BY id DESC ");

//print_r($career_app_arr); exit; 
if(is_array($career_app_arr) && sizeof($career_app_arr) > 0 ){
	$line='<table border="1">
				  <thead>
					   <tr>
						  <th>Email</th>
						  <th>Date</th>
						</tr>
				  </thead>   
			  <tbody>';
		foreach($career_app_arr as $val){
			$line .='<tr>		
				<td>'.stripslashes($val['signup_email']).'</td>
				<td>'.stripslashes($val['insert_date']).'</td></tr>';	
		}	  
		$line .='</tbody></table>';
		$data = trim($line);
		// Create table header showing to download a xls (excel) file
		header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
		header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		header("Content-Disposition: attachment;filename=\"Career.xlsx\"");
		header("Cache-Control: max-age=0");
		header("Content-Disposition: attachment; filename=newsletter-".date("y-m-d-h-i-s").".xls");
		header("Cache-Control: public");
		header("Content-length: ".strlen($data)); 
		header("Pragma: no-cache");
		header("Expires: 0");
		print $data;
	}else{
		header("Location:list_newsletter_signup.php");
	}
?>