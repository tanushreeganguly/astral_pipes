<?php
#=== Includes
require_once("../config/config.php");
require_once("verify_logins.php");

#==== Validations For Security
$POST		= $objTypes->validateUserInput($_POST);
$id 		= isset($POST['id']) ? intval($POST['id']) : intval($_REQUEST['id']) ;
$ip			= $_SERVER['REMOTE_ADDR'];
$agent		= addslashes($_SERVER['HTTP_USER_AGENT']);

#==== ADD - UPDATE - INSERT 
if(($POST['SAVE']=="SAVE")){
	$pgNo 	= intval(base64_decode($_REQUEST['pgNo']));
	$params = array(
					'title'	           	=> $POST['title'],
					'job_code'	        => $POST['job_code'],
					'department'	    => $_POST['department'],
					'education'	        => $_POST['education'],
					'from_experience'   => $POST['from_experience'],
					'to_experience'	    => $POST['to_experience'],
					'from_date'	        => $POST['from_date'],
					'to_date'	        => $POST['to_date'],
					'location'			=> $POST['location'],	
					'job_description'	=> $_POST['job_description'],	
					'meta_description'  => $POST['meta_description'],
					'meta_keywords'     => $POST['meta_keywords'],
					'meta_title'        => $POST['meta_title'],
					'ip'                => $ip,
					'agent'             => $agent,
					'added_by'          => $_SESSION['SessAdminName'],
				);

	if($id > 0){
		$update_params = array('updated_date'=> date("Y-m-d H:i:s"),'updated_by'=> $_SESSION['SessAdminName']);
		$params = array_merge($params, $update_params);
		$where  = array(':id'=> $id);
		$update = $objTypes->update("tbl_careers", $params, "id = :id", $where);
		if($update){$insert_id	= $id;}
	}else{
		$insert = $objTypes->insert("tbl_careers", $params);
		if($insert){$insert_id = $objTypes->lastInsertId();}
	}
	
	if($insert_id > 0){		
			if(isset($_FILES['application_form']['name']) && $_FILES['application_form']['name'] != "")
			{			
				$ext 			= pathinfo($_FILES['application_form']['name'], PATHINFO_EXTENSION);
				$ext			= strtolower($ext);
				$validatefiles  = array("doc", "docx","DOC", "DOCX");
				$filetype 		= array('application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document');

				if(in_array($ext, $validatefiles) == false){
					header("location:add_career.php?sysmsg=35");
					exit();		
				}

				if(in_array(strtolower($_FILES['application_form']['type']), $filetype) == false ){
					header("location:add_career.php?sysmsg=35");
					exit();	
				}
				
				
				if(isset($_FILES['application_form']['name'])){
					$ext 	  = pathinfo($_FILES['application_form']['name'], PATHINFO_EXTENSION);
					$filename = basename($_FILES['application_form']['name'], $ext);			
					$filename = $POST['title'].'_'.time().'.'.$ext;
					$movefile = move_uploaded_file($_FILES['application_form']['tmp_name'], "../uploads/career_doc/".$filename);				
				}
				$update_params  = array('application_form'=> $filename);
				$where	  		= array(':id'=> $insert_id);
				$objTypes->update("tbl_careers", $update_params, "id = :id", $where);
			}
       
	}
	header("location:list_career.php?sysmsg=1001&pgNo=".$pgNo);
	exit();
}

#==== STATUS UPDATION
if(($_REQUEST['status']<>"") && ($_REQUEST['id'] <> "")){
	$statusVal  = intval($_REQUEST['status']);
	$status		= ($statusVal=='0') ? '1' : '0';
	$id			= intval($_REQUEST['id']);
	$pgNo 		= intval(base64_decode($_REQUEST['pgNo']));
	$title  	= $_REQUEST['title'];
	$cat_type 	= $_REQUEST['cat_type'];
    $params     = array("is_active" => $status);
	$where 		= array(":id" => $id);

	$update     = $objTypes->update("tbl_careers", $params, "id = :id", $where);
	if($update){
		header("location:list_career.php?sysmsg=1001&pgNo=$pgNo&title=$title&cat_type=$cat_type");
		exit();
	}
    else{
		header("location:list_career.php?sysmsg=4&pgNo=$pgNo&title=$title&cat_type=$cat_type");
		exit();
	}
}

#==== DELETE
if(($_REQUEST['action']=="delete") && ($_REQUEST['id'] <> ""))
{
	$id		= intval($_REQUEST['id']);
	$pgNo 	= intval(base64_decode($_REQUEST['pgNo']));
	$title  = $_REQUEST['title'];
	$cat_type = $_REQUEST['cat_type'];
	$params	= array("is_delete" => '0');
	$where  = array(":id" => $id);
	$delete = $objTypes->update("tbl_careers", $params, "id = :id", $where);
	if($delete){
		header("location:list_career.php?sysmsg=1002&pgNo=$pgNo&title=$title&cat_type=$cat_type");
		exit();
	}else{
		header("location:list_career.php?sysmsg=4&pgNo=$pgNo&title=$title&cat_type=$cat_type");
		exit();
	}
}

#==== ACTIVE ALL
if(($POST['action']=="activeall") && ($_POST['DelCheckBox'] <> "")){
	$DelCheckBox	= $_POST['DelCheckBox'];
	$Result			= count($DelCheckBox);
	$pgNo 			= intval($_REQUEST['pgNo']);
	$title  = $_REQUEST['title'];
	$cat_type = $_REQUEST['cat_type'];

	if($Result == "0"){
		header("location:list_career.php?sysmsg=8&pgNo=$pgNo&title=$title&cat_type=$cat_type");
		exit();
	}
	$Delete	= implode(',', $DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_careers SET is_active = '1' WHERE id IN ($Delete)");

	if($update > 0){
		header("location:list_career.php?sysmsg=1012&pgNo=$pgNo&title=$title&cat_type=$cat_type");
		exit();
	}
    else{
		header("location:list_career.php?sysmsg=13&pgNo=$pgNo&title=$title&cat_type=$cat_type");
		exit();
	}
}

#==== DEACTIVE ALL
if(($POST['action']=="deactiveall") && ($_POST['DelCheckBox'] <> "")){
	$DelCheckBox	= $_POST['DelCheckBox'];
	$Result			= count($DelCheckBox);
	$pgNo 			= intval($_REQUEST['pgNo']);
	$title  = $_REQUEST['title'];
	$cat_type = $_REQUEST['cat_type'];

	if($Result == "0"){
		header("location:list_career.php?sysmsg=9&pgNo=$pgNo&title=$title&cat_type=$cat_type");
		exit();
	}
    $Delete = implode(',',$DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_careers SET is_active = '0' WHERE id IN ($Delete)");

	if($update > 0){
		header("location:list_career.php?sysmsg=1013&pgNo=$pgNo&title=$title&cat_type=$cat_type");
		exit();
	}
    else{
		header("location:list_career.php?sysmsg=14&pgNo=$pgNo&title=$title&cat_type=$cat_type");
		exit();
	}
}

#==== DELETE  ALL
if(($POST['action']=="deleteall") && ($_POST['DelCheckBox'] <> "")){
	$DelCheckBox	= $_POST['DelCheckBox'];
	$Result			= count($DelCheckBox);
	$title  = $_REQUEST['title'];
	$cat_type = $_REQUEST['cat_type'];

	if($Result == "0"){
		header("location:list_career.php?sysmsg=10");
		exit();
	}
	$Delete = implode(',',$DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_careers SET is_delete = '0' WHERE id IN ($Delete)");

	if($update > 0){
		header("location:list_career.php?sysmsg=1014&title=$title&cat_type=$cat_type");
		exit();
	}
    else{
		header("location:list_career.php?sysmsg=4&title=$title&cat_type=$cat_type");
		exit();
	}
}
