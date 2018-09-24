<?php
ob_start();
#=== Includes
require_once("../config/config.php");
require_once("verify_logins.php");
#==== Object Initialisations
$condition		= " a.is_active='1' AND a.is_delete='1' " ;
$order			= 'a.id DESC';
$group			= '';
$limit			= ""; 
$title	    =  ($_REQUEST['title']<>'') ? $_REQUEST['title'] : '' ;
$refno	    =  ($POST['refno']<>'') ? $POST['refno'] : '' ;

$params     = array();
//$condition  = "a.is_delete=1 ";
if($title){
	$condition  .= " AND a.name LIKE '%".$title."%'";
}
if($refno){
	$condition  .= " AND a.ref_no= '".$refno."'";
}
$CareerApplicationArray		= $objTypes->fetchAll("SELECT a.*,a.id as user_id ,c.* FROM `tbl_career_apply` a JOIN tbl_job_user c on a.id=c.user_id where ".$condition." and  a.job_id='' order by a.id DESC");;
		if(sizeof($CareerApplicationArray) > 0 ){ 
		$line='<table border="1">
				  <thead>
					   <tr>
						  <th>#</th>
						  <th>Name</th>
						  <th>Email</th>
						  <th>Mobile</th>
						</tr>
				  </thead>   
			  <tbody>';
			  $i=1;
		foreach($CareerApplicationArray as $val)
		{
			$user_id = $val['user_id'];					
			$line .='<tr>
				<td>'.$i++.'</td>					
				<td>'.stripslashes($val['name']).'</td>
				<td>'.stripslashes($val['email']).'</td>
				<td>'.stripslashes($val['mobile']).'</td>
				</tr>';	
		}
		$line .='</tbody></table>';
		$data = trim($line);
		//print $data; exit();
		if ($data == "") {
			$data = "\n no matching records found\n";
		}
		// Create table header showing to download a xls (excel) file
		header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
		header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		header("Content-Disposition: attachment;filename=\"Career.xlsx\"");
		header("Cache-Control: max-age=0");
		header("Content-Disposition: attachment; filename=FutureJob_".date("y-m-d-h-i-s").".xls");
		header("Cache-Control: public");
		header("Content-length: ".strlen($data)); 
		header("Pragma: no-cache");
		header("Expires: 0");
		print $data;
		}else{
	//echo 'No Records!';
	header("location:list_future_job_applicants.php");
}
?>