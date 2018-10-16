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
		'title'	            => $POST['title'],		
		'investor_id'   	=>($_POST['investor_id']),
		'meta_description'  => $POST['meta_description'],
        'meta_keywords'     => $POST['meta_keywords'],
        'meta_title'        => $POST['meta_title'],
        'ip'                => $ip,
        'agent'             => $agent,
        'added_by'          => $_SESSION['SessAdminName']
	);
    if($id > 0){
		$update_params = array(
	        'updated_date'		=> date("Y-m-d H:i:s"),
	        'updated_by'   		=> $_SESSION['SessAdminName'],
		);
		$params = array_merge($params, $update_params);
		$where  = array(
			':id'          => $id
		);
		$update 	= $objTypes->update("tbl_investor_details", $params, "id = :id", $where);
		if($update){
			$insert_id	= $id;
		}
	}
	else{
		$insert = $objTypes->insert("tbl_investor_details", $params);
		if($insert){
			$insert_id = $objTypes->lastInsertId();
		}
	}
	if($insert_id > 0){
			if(isset($_FILES['catalogue']['name']) && $_FILES['catalogue']['name'] != "")
			{			
				$ext 			= pathinfo($_FILES['catalogue']['name'], PATHINFO_EXTENSION);
				$ext			= strtolower($ext);
				$validatefiles  = array("pdf", "PDF");
				$filetype 		= array('application/pdf','application/PDF');
				if(in_array($ext, $validatefiles) == false){
					header("location:add_investor.php?sysmsg=35");
					exit();		
				}
				if(in_array(strtolower($_FILES['catalogue']['type']), $filetype) == false ){
					header("location:add_investor.php?sysmsg=35");
					exit();	
				}
				if(isset($_FILES['catalogue']['name'])){					
					$ext 	  = pathinfo($_FILES['catalogue']['name'], PATHINFO_EXTENSION);
					echo $filename = basename($_FILES['catalogue']['name'], $ext);
					$filename		=	strtolower($_FILES['catalogue']['name']);	
					$filename = str_replace(' ', '_', $filename); 
					$filename = str_replace('', '.', $filename); 				
					$filename = time().'_'.$filename;
					$movefile = move_uploaded_file($_FILES['catalogue']['tmp_name'], "../uploads/investor_broucher/".$filename);				
				}
				$update_params  = array('broucher'=> $filename);
				$params			= array_merge($params, $update_params);
				$where	  		= array(':id'=> $insert_id);
				$updatepdf 		= $objTypes->update("tbl_investor_details", $params, "id = :id", $where);
			}
	}
		header("location:list_investor.php?sysmsg=1001&pgNo=$pgNo");
		exit();	
}

#==== STATUS UPDATION
if(($_REQUEST['status']<>"") && ($_REQUEST['id'] <> "")){
	$statusVal  = intval($_REQUEST['status']);
	$status		= ($statusVal=='0') ? '1' : '0';
	$id			= intval($_REQUEST['id']);
	$pgNo 		= intval(base64_decode($_REQUEST['pgNo']));
	$title  = $_REQUEST['title'];
    $params     = array("is_active" => $status);
	$where 		= array(":id" => $id);
	$update     = $objTypes->update("tbl_investor_details", $params, "id = :id", $where);
	if($update){
		header("location:list_investor.php?sysmsg=1001&pgNo=".$pgNo);
		exit();
	}
    else{
		header("location:list_investor.php?sysmsg=4&pgNo=".$pgNo);
		exit();
	}
}
#==== DELETE
if(($_REQUEST['action']=="delete") && ($_REQUEST['id'] <> ""))
{
	$id		= intval($_REQUEST['id']);
	$pgNo 	= intval(base64_decode($_REQUEST['pgNo']));
	$title  = $_REQUEST['title'];
	$params	= array("is_delete" => '0');
	$where  = array(":id" => $id);
	$delete = $objTypes->update("tbl_investor_details", $params, "id = :id", $where);
	if($delete){
		header("location:list_investor.php?sysmsg=1002&pgNo=$pgNo");
		exit();
	}else{
		header("location:list_investor.php?sysmsg=4&pgNo=$pgNo");
		exit();
	}
}
#==== ACTIVE ALL
if(($POST['action']=="activeall") && ($_POST['DelCheckBox'] <> "")){
	$DelCheckBox	= $_POST['DelCheckBox'];
	$Result			= count($DelCheckBox);
	$pgNo 			= intval($_REQUEST['pgNo']);
	$title  = $_REQUEST['title'];
	if($Result == "0"){
		header("location:list_investor.php?sysmsg=8&pgNo=$pgNo");
		exit();
	}
	$Delete	= implode(',', $DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_investor_details SET is_active = '1' WHERE id IN ($Delete)");
	if($update > 0){
		header("location:list_investor.php?sysmsg=1012&pgNo=$pgNo");
		exit();
	}
    else{
		header("location:list_investor.php?sysmsg=13&pgNo=$pgNo");
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
		header("location:list_investor.php?sysmsg=9&pgNo=$pgNo");
		exit();
	}
    $Delete = implode(',',$DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_investor_details SET is_active = '0' WHERE id IN ($Delete)");
	if($update > 0){
		header("location:list_investor.php?sysmsg=1013&pgNo=$pgNo");
		exit();
	}
    else{
		header("location:list_investor.php?sysmsg=14&pgNo=$pgNo");
		exit();
	}
}
#==== DELETE  ALL
if(($POST['action']=="deleteall") && ($_POST['DelCheckBox'] <> "")){
	$DelCheckBox	= $_POST['DelCheckBox'];
	$Result			= count($DelCheckBox);
	$title  = $_REQUEST['title'];
	if($Result == "0"){
		header("location:list_investor.php?sysmsg=10");
		exit();
	}
	$Delete = implode(',',$DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_investor_details SET is_delete = '0' WHERE id IN ($Delete)");
	if($update > 0){
		header("location:list_investor.php?sysmsg=1014");
		exit();
	}
    else{
		header("location:list_investor.php?sysmsg=4");
		exit();
	}
}