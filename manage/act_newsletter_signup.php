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
    $params     = array("status" => $status);
	$where 		= array(":id" => $id);

	$update     = $objTypes->update("tbl_newsletter_signup", $params, "id = :id", $where);
	if($update){
		header("location:list_newsletter_signup.php?sysmsg=1001&pgNo=".$pgNo);
		exit();
	}
    else{
		header("location:list_newsletter_signup.php?sysmsg=4&pgNo=".$pgNo);
		exit();
	}
}

#==== DELETE
if(($_REQUEST['action']=="delete") && ($_REQUEST['id'] <> ""))
{
	$id		= intval($_REQUEST['id']);
	$pgNo 	= intval(base64_decode($_REQUEST['pgNo']));
	$where	= array("is_delete" => '0');
	//$where  = array(":id" => $id);
	$delete = $objTypes->inquery("DELETE FROM tbl_newsletter_signup WHERE id = $id");
	if($delete){
		header("location:list_newsletter_signup.php?sysmsg=1002&pgNo=$pgNo");
		exit();
	}else{
		header("location:list_newsletter_signup.php?sysmsg=4&pgNo=$pgNo");
		exit();
	}
}

#==== ACTIVE ALL
if(($POST['action']=="activeall") && ($_POST['DelCheckBox'] <> "")){
	$DelCheckBox	= $_POST['DelCheckBox'];
	$Result			= count($DelCheckBox);
	$pgNo 			= intval($_REQUEST['pgNo']);

	if($Result == "0"){
		header("location:list_newsletter_signup.php?sysmsg=8&pgNo=$pgNo");
		exit();
	}
	$Delete	= implode(',', $DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_newsletter_signup SET status = '1' WHERE id IN ($Delete)");

	if($update > 0){
		header("location:list_newsletter_signup.php?sysmsg=1012&pgNo=$pgNo");
		exit();
	}
    else{
		header("location:list_newsletter_signup.php?sysmsg=13&pgNo=$pgNo");
		exit();
	}
}

#==== DEACTIVE ALL
if(($POST['action']=="deactiveall") && ($_POST['DelCheckBox'] <> "")){
	$DelCheckBox	= $_POST['DelCheckBox'];
	$Result			= count($DelCheckBox);
	$pgNo 			= intval($_REQUEST['pgNo']);

	if($Result == "0"){
		header("location:list_newsletter_signup.php?sysmsg=9&pgNo=$pgNo");
		exit();
	}
    $Delete = implode(',',$DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_newsletter_signup SET status = '0' WHERE id IN ($Delete)");

	if($update > 0){
		header("location:list_newsletter_signup.php?sysmsg=1013&pgNo=$pgNo");
		exit();
	}
    else{
		header("location:list_newsletter_signup.php?sysmsg=14&pgNo=$pgNo");
		exit();
	}
}

#==== DELETE  ALL
if(($POST['action']=="deleteall") && ($_POST['DelCheckBox'] <> "")){
	$DelCheckBox	= $_POST['DelCheckBox'];
	$Result			= count($DelCheckBox);

	if($Result == "0"){
		header("location:list_newsletter_signup.php?sysmsg=10");
		exit();
	}
	$Delete = implode(',',$DelCheckBox);
	$update = $objTypes->inquery("DELETE FROM tbl_newsletter_signup WHERE id IN ($Delete)");


	if($update > 0){
		header("location:list_newsletter_signup.php?sysmsg=1014");
		exit();
	}
    else{
		header("location:list_newsletter_signup.php?sysmsg=4");
		exit();
	}
}
