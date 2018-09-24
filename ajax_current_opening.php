<?php	include_once('config/config.php'); 
$POST	= $objTypes->validateUserInput($_POST);
$location_query = (isset($POST['location']) && $POST['location'] != '')  ? 'location like "%'.$POST['location'].'%" and ' : ''; 

$job_title_query = (isset($POST['job_title'])&& $POST['job_title'] != '')  ? 'title like "%'.$POST['job_title'].'%" and ' : '';

$department_query = (isset($POST['department']) && $POST['department'] != '') ? 'department like "%'.$POST['department'].'%" and' : '';

$experience_query = (isset($POST['experience']) && $POST['experience'] != '')  ?  'to_experience <= '.$POST['experience'].' and' : '';

$result	= $objTypes->fetchAll("SELECT * FROM tbl_careers WHERE  $location_query  $department_query $job_title_query $experience_query  is_delete = 1 and is_active = 1");

$html = ''; 
if(sizeof($result) > 0){
	$html .='<div class="opening_table_con">
					<div class="opening_details">
					  <ul>
						<li class="th">
						  <span>Job Code</span>
						  <span>Job Title</span>
						  <span>Function</span>
						  <span>Education</span>
						  <span>Job Code</span>
						  <span>Date</span>
						</li>
					  </ul>
					</div>';
            foreach($result as $res){ 
            $html.='<div class="opening_details" id="opening_details">   
			  <ul>
			    <li>
			      <span>'.$res['job_code'].'</span>
			      <span>'.$res['title'].'<div class="loc">'.$res['location'].'</div></span>
			      <span>'.$res['department'].'</span>
			      <span>'.$res['education'].'</span>
			      <span>'.$res['to_experience'].'years</span>
			      <span>'.date('d/m/Y',strtotime($res['from_date'])).'
			        <br> TO
			        <br>'.date('d/m/Y',strtotime($res['to_date'])).'</span>
					
			      <span><a href="'.base_url.'career-form-'.$res['id'].'" class="commanBtn">Apply Now</a></span>
			    <span>
					<div class="api_links">
						<a href="javascript:;" class="linkdinlog" id="'.$res['id'].'" >Apply With</a>
						<a href="'.base_url.'career-details/'.$res['id'].'">Read More</a>
					  </div>
					</span>
						</li>
					  </ul>
				</div> ';
			 }
   $html.='</div>
	  </div>';
}
	echo $html; 
?>