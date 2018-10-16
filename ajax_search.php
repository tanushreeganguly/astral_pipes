<?php
include_once('config/config.php');
include_once('include/common_functions.php');

$query				=	str_replace("+"," ",$_REQUEST['query']);
$offset 			= 	is_numeric($_POST['offset']) ? $_POST['offset'] : die();
$postnumbers		= 	is_numeric($_POST['number']) ? $_POST['number'] : die();
$commonFunctions	=	new commonFunctions();
$query 				= 	strtolower($_GET['query']);
$flag  = false;
if($query !=""){
	$sql="select * from tbl_search where content like '%".$POST['search_data']."%' 
			or url like '%".$POST['search_data']."%' or title like '%".$POST['search_data']."%' or description like '%".$POST['search_data']."%' LIMIT ".$postnumbers." OFFSET ".$offset;
	$data 	=	$objTypes->fetchAll($sql);
	$html				=	"";
		if($data){ 
			foreach($data as $value){ 
			$flag = true; 
			$html.='<div class="search_data">
			  <h3>
				'.stripslashes(ucwords(strtolower($value['title']))).'
			  </h3> 
					<p>';
					
						if($value['content']){
						$html.=substr(stripslashes($value['content']),0,250); $html.='<br/><br/>';
				 }
					$html.='<a href=""> Read More</a></p> </div> 
			  <p>&nbsp;</p>';
				}
		}else{
			//header('location:'.base_url.'404.php');
			//$html.="<div>No results Found</div>"; 
		}
 if($offset == 0 && $html==''){
	echo $html="<div style='text-align:center'>No result found for <b>".$query." </b>, Try Searching another Keyword.</div>";
}else{
	echo $html;
}
}

