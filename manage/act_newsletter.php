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
if(($POST['SAVE']=="SAVE"))
{
	$step='';
	$pgNo 	= intval(base64_decode($_REQUEST['pgNo']));
	
	$params = array(
	    'title'	=> $POST['title'],
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
		$where = array(
			':id'          => $id
		);
		$update 	= $objTypes->update("tbl_newsletter", $params, "id = :id", $where);
		if($update){
			$insert_id	= $id;
		}

	}
	else{
		$insert = $objTypes->insert("tbl_newsletter", $params);
		if($insert){
			$insert_id = $objTypes->lastInsertId();
			$step='add';
		}
	}
		if($insert_id > 0){	
		if(isset($_FILES['envelope']['name']) && $_FILES['envelope']['name'] != ""){
				$ext 			= pathinfo($_FILES['envelope']['name'], PATHINFO_EXTENSION);
				$ext			= strtolower($ext);
				$validatefiles 	= array("pdf", "PDF");
				$filetype 		= array('application/pdf');

				if(in_array($ext, $validatefiles) == false){
					header("location:add_newsletter.php?sysmsg=11&id=".$id."&pgNo=".$pgNo);
					exit();		
				}

				if(in_array(strtolower($_FILES['envelope']['type']), $filetype) == false ){
					header("location:add_newsletter.php?sysmsg=11&id=".$id."&pgNo=".$pgNo);
					exit();	
				}
				
				if(isset($_FILES['envelope']['name'])){				
					$ext 	  = pathinfo($_FILES['envelope']['name'], PATHINFO_EXTENSION);
					$filename = basename($_FILES['envelope']['name'], $ext);			
					$filename = 'envelope_'.time().'.'.$ext;
					$movefile = move_uploaded_file($_FILES['envelope']['tmp_name'], "../uploads/newsletter_pdf/".$filename);
				}
					
					//$UpdatePdfArray = array('catalogue' => $filename);
					$update_params = array(
			        'envelope'		=> $filename
					);
					//$objTypes->update($UpdatePdfArray,"id = '".$id."'");
					$params = array_merge($params, $update_params);
						$where  = array(
							':id'          => $insert_id
					);
					$update 	= $objTypes->update("tbl_newsletter", $params, "id = :id", $where);
				}
		}

	header("location:list_newsletter.php?sysmsg=1000&pgNo=".$pgNo);
	exit();
	}	
		

#==== Image Removal



#==== STATUS UPDATION
if(($_REQUEST['status']<>"") && ($_REQUEST['id'] <> "")){
	$statusVal  = intval($_REQUEST['status']);
	$status		= ($statusVal=='0') ? '1' : '0';
	$id			= intval($_REQUEST['id']);
	$pgNo 		= intval(base64_decode($_REQUEST['pgNo']));
    $params     = array("is_active" => $status);
	$where 		= array(":id" => $id);

	$update     = $objTypes->update("tbl_newsletter", $params, "id = :id", $where);
	if($update){
		header("location:list_newsletter.php?sysmsg=1001&pgNo=".$pgNo);
		exit();
	}
    else{
		header("location:list_newsletter.php?sysmsg=4&pgNo=".$pgNo);
		exit();
	}
}

#==== DELETE
if(($_REQUEST['action']=="delete") && ($_REQUEST['id'] <> ""))
{
	$id		= intval($_REQUEST['id']);
	$pgNo 	= intval(base64_decode($_REQUEST['pgNo']));
	$params	= array("is_delete" => '0');
	$where  = array(":id" => $id);
	$delete = $objTypes->update("tbl_newsletter", $params, "id = :id", $where);
	if($delete){
		header("location:list_newsletter.php?sysmsg=1002&pgNo=$pgNo");
		exit();
	}else{
		header("location:list_newsletter.php?sysmsg=4&pgNo=$pgNo");
		exit();
	}
}

#==== ACTIVE ALL
if(($POST['action']=="activeall") && ($_POST['DelCheckBox'] <> "")){
	$DelCheckBox	= $_POST['DelCheckBox'];
	$Result			= count($DelCheckBox);
	$pgNo 			= intval($_REQUEST['pgNo']);

	if($Result == "0"){
		header("location:list_newsletter.php?sysmsg=8&pgNo=$pgNo");
		exit();
	}
	$Delete	= implode(',', $DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_newsletter SET is_active = '1' WHERE id IN ($Delete)");

	if($update > 0){
		header("location:list_newsletter.php?sysmsg=1012&pgNo=$pgNo");
		exit();
	}
    else{
		header("location:list_newsletter.php?sysmsg=13&pgNo=$pgNo");
		exit();
	}
}

#==== DEACTIVE ALL
if(($POST['action']=="deactiveall") && ($_POST['DelCheckBox'] <> "")){
	$DelCheckBox	= $_POST['DelCheckBox'];
	$Result			= count($DelCheckBox);
	$pgNo 			= intval($_REQUEST['pgNo']);

	if($Result == "0"){
		header("location:list_newsletter.php?sysmsg=9&pgNo=$pgNo");
		exit();
	}
    $Delete = implode(',',$DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_newsletter SET is_active = '0' WHERE id IN ($Delete)");

	if($update > 0){
		header("location:list_newsletter.php?sysmsg=1013&pgNo=$pgNo");
		exit();
	}
    else{
		header("location:list_newsletter.php?sysmsg=14&pgNo=$pgNo");
		exit();
	}
}

#==== DELETE  ALL
if(($POST['action']=="deleteall") && ($_POST['DelCheckBox'] <> "")){
	$DelCheckBox	= $_POST['DelCheckBox'];
	$Result			= count($DelCheckBox);

	if($Result == "0"){
		header("location:list_newsletter.php?sysmsg=10");
		exit();
	}
	$Delete = implode(',',$DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_newsletter SET is_delete = '0' WHERE id IN ($Delete)");

	if($update > 0){
		header("location:list_newsletter.php?sysmsg=1014");
		exit();
	}
    else{
		header("location:list_newsletter.php?sysmsg=4");
		exit();
	}
}
