<?php include_once('config/config.php'); 
$POST   = $objTypes->validateUserInput($_REQUEST);
$company_name = isset($POST['company_name'])  ? $POST['company_name'] : '';
$designation = isset($POST['designation'])  ? $POST['designation'] : '';
$type = isset($POST['type'])  ? $POST['type'] : '';
$job_id = isset($POST['job_id'])  ? $POST['job_id'] : '';
$user_id = isset($POST['user_id'])  ? $POST['user_id'] : '';



$insert_arr = array(
				'current_employer'=> $company_name,
				'designation'		=> $designation,
				'industry_type'	=> $type,	
				'user_id'		=> $user_id,		
				'job_id'	=> $job_id					
				);	

				$insert_serve = $objTypes->insert("tbl_job_detail", $insert_arr);	

				if($insert_serve>0){
					echo "success";exit;
				}	else{

					echo "Failed";exit;
				}				

?>

 