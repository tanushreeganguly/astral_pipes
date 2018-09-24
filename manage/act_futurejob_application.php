<?php
#=== Includes
require_once("../config/config.php");
require_once("verify_logins.php");

#==== Validations For Security
$POST		= $objTypes->validateUserInput($_POST);
$id 		= isset($POST['id']) ? intval($POST['id']) : intval($_REQUEST['id']) ;
$ip			= $_SERVER['REMOTE_ADDR'];
$agent		= addslashes($_SERVER['HTTP_USER_AGENT']);


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

	$update     = $objTypes->update("tbl_career_apply", $params, "id = :id", $where);
	if($update){
		header("location:list_future_job_applicants.php?sysmsg=1001&pgNo=$pgNo&cat_type=$cat_type");
		exit();
	}
    else{
		header("location:list_future_job_applicants.php?sysmsg=4&pgNo=$pgNo&cat_type=$cat_type");
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
	$delete = $objTypes->update("tbl_career_apply", $params, "id = :id", $where);
	if($delete){
		header("location:list_future_job_applicants.php?sysmsg=1002&pgNo=$pgNo&cat_type=$cat_type");
		exit();
	}else{
		header("location:list_future_job_applicants.php?sysmsg=4&pgNo=$pgNo&cat_type=$cat_type");
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
		header("location:list_future_job_applicants.php?sysmsg=8&pgNo=$pgNo&cat_type=$cat_type");
		exit();
	}
	$Delete	= implode(',', $DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_career_apply SET is_active = '1' WHERE id IN ($Delete)");

	if($update > 0){
		header("location:list_future_job_applicants.php?sysmsg=1012&pgNo=$pgNo&cat_type=$cat_type");
		exit();
	}
    else{
		header("location:list_future_job_applicants.php?sysmsg=13&pgNo=$pgNo&cat_type=$cat_type");
		exit();
	}
}

#==== DEACTIVE ALL
if(($POST['action']=="deactiveall") && ($_POST['DelCheckBox'] <> "")){
	$DelCheckBox	= $_POST['DelCheckBox'];
	$Result			= count($DelCheckBox);
	$pgNo 			= intval($_REQUEST['pgNo']);
	$title  = $_REQUEST['title'];

	if($Result == "0"){
		header("location:list_future_job_applicants.php?sysmsg=9&pgNo=$pgNo");
		exit();
	}
    $Delete = implode(',',$DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_career_apply SET is_active = '0' WHERE id IN ($Delete)");

	if($update > 0){
		header("location:list_future_job_applicants.php?sysmsg=1013&pgNo=$pgNo");
		exit();
	}
    else{
		header("location:list_future_job_applicants.php?sysmsg=14&pgNo=$pgNo");
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
		header("location:list_future_job_applicants.php?sysmsg=10");
		exit();
	}
	$Delete = implode(',',$DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_career_apply SET is_delete = '0' WHERE id IN ($Delete)");

	if($update > 0){
		header("location:list_future_job_applicants.php?sysmsg=1014&cat_type=$cat_type");
		exit();
	}
    else{
		header("location:list_future_job_applicants.php?sysmsg=4&cat_type=$cat_type");
		exit();
	}
}
