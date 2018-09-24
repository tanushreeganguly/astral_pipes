<?php
ob_start();
#=== Includes
require_once("../config/config.php");
require_once("verify_logins.php");
//print_r($_REQUEST); exit; 
#==== Object Initialisations
$condition		= " a.is_active='1' AND a.is_delete='1' " ;
$order			= 'a.id DESC';
$group			= '';
$limit			= ""; 
$jobcode	=  ($_REQUEST['jobcode']<>'') ? $_REQUEST['jobcode'] : '' ;
$title	    =  ($_REQUEST['title']<>'') ? $_REQUEST['title'] : '' ;
$department	=  ($_REQUEST['department']<>'') ? $_REQUEST['department'] : '' ;
$location	=  ($_REQUEST['location']<>'') ? $_REQUEST['location'] : '' ;
$params     = array();
//$condition  = "a.is_delete=1 ";
if($jobcode){
	$condition  .= " AND c.job_code LIKE '%".$jobcode."%'";
}
if($title){
	$condition  .= " AND a.name LIKE '%".$title."%'";
}
if($department){
	$condition  .= " AND c.department LIKE '%".$department."%'";
}
if($location){
	$condition  .= " AND c.location LIKE '%".$location."%'";
}
$CareerApplicationArray		= $objTypes->fetchAll("SELECT a.*,a.id as user_id,a.name,c.id,c.department,c.job_code FROM `tbl_career_apply` a JOIN tbl_careers c on a.job_id=c.id WHERE ".$condition." ORDER BY a.id DESC");;
		if(count($CareerApplicationArray) >0){ 
		$line='<table border="1">
				  <thead>
					   <tr>
						  <th>Job Code</th>
						  <th>Reference No.</th>
						  <th>Name</th>
						  <th>Email</th>
						  <th>Mobile</th>
						  <th>DOB</th>
						  <th>Gender</th>
						  <th>PAN No</th>
						  <th>Aadhaar No</th>	
						  <th>Language</th>
						  <th>Country</th>
						  <th>City</th>						
						  <th>State</th>
						  <th>Alternate No</th>
						  
						  <th>Medium</th>
						  <th>Employment type</th>
						  <th>Willing to relocate</th>
						  <th>Option state</th>
						  <th>Option city</th>
						  <th>Notice period</th>
						  <th>Resume title</th>
						  <th>Employee Status</th>
						  <th>Current employer</th>
						  <th>Start date</th>
						  <th>Industry type</th>
						  <th>Designation</th>
						  <th>Reporting to</th>
						  <th>Role</th>
						  <th>CTC</th>
						  <th>Gross</th>
						</tr>
				  </thead>   
			  <tbody>';
		foreach($CareerApplicationArray as $val)
		{
				$user_id = $val['user_id'];
				$user_sql = "select * from tbl_job_user where user_id=".$user_id;
				$user_arr	= $objTypes->fetchRow($user_sql);
				#job details
				$job_sql = "select * from  tbl_job_detail where user_id=".$user_id;
				$job_arr	= $objTypes->fetchRow($job_sql);	
					$line .='<tr>
						<td>'.stripslashes($val['job_code']).'</td>	
						<td>'.stripslashes($val['ref_no']).'</td>								
						<td>'.stripslashes($val['name']).'</td>
						<td>'.stripslashes($val['email']).'</td>
						<td>'.stripslashes($val['mobile']).'</td>
						<td>'.stripslashes($val['dob']).'</td>
						<td>'.stripslashes(($val['gender']==0) ? 'Male' : 'Female').'</td>
						<td>'.stripslashes($val['pan_no']).'</td>
						<td>'.stripslashes($val['aadhar_no']).'</td>
						<td>'.stripslashes($val['language']).'</td>
						<td>'.stripslashes($val['country']).'</td>
						<td>'.stripslashes($val['city']).'</td>
						<td>'.stripslashes($val['state']).'</td>
						<td>'.stripslashes($val['alternate_no']).'</td>
						<td>'.stripslashes($user_arr['medium']).'</td>
						<td>'.stripslashes($user_arr['employment_type']).'</td>
						<td>'.stripslashes($user_arr['willing_relocate']).'</td>
						<td>'.stripslashes($user_arr['option_state']).'</td>
						<td>'.stripslashes($user_arr['option_city']).'</td>
						<td>'.stripslashes($user_arr['notice_period']).'</td>
						<td>'.stripslashes($user_arr['resume_title']).'</td>
						<td>'.stripslashes($job_arr['employee_status']).'</td>
						<td>'.stripslashes($job_arr['current_employer']).'</td>
						<td>'.stripslashes($job_arr['start_date']).'</td>
						<td>'.stripslashes($job_arr['industry_type']).'</td>
						<td>'.stripslashes($job_arr['designation']).'</td>
						<td>'.stripslashes($job_arr['reporting_to']).'</td>
						<td>'.stripslashes($job_arr['role']).'</td>
						<td>'.stripslashes($job_arr['ctc']).'</td>
						<td>'.stripslashes($job_arr['gross']).'</td>
						</tr>';	
		}
		$line .='</tbody></table>';
		$data = trim($line);
		if ($data == "") {			
			$data = "\n no matching records found\n";
		}
		// Create table header showing to download a xls (excel) file
		header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
		header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		header("Content-Disposition: attachment;filename=\"Career.xlsx\"");
		header("Cache-Control: max-age=0");		
		header("Content-Disposition: attachment; filename=Career_".date("y-m-d-h-i-s").".xls");
		header("Cache-Control: public");
		header("Content-length: ".strlen($data)); 
		header("Pragma: no-cache");
		header("Expires: 0");
		print $data;
		} else{
			header("location:list_applied_users.php");
		}
?>