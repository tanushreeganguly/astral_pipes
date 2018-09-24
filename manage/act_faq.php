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
        'description'		=> addslashes($_POST['description']),
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
		$update 	= $objTypes->update("tbl_faq", $params, "id = :id", $where);

		if($update){
			$insert_id	= $id;
		}
    }
    else{
        $insert = $objTypes->insert("tbl_faq", $params);
		if($insert){
			$insert_id = $objTypes->lastInsertId();
		}
    }

    if($insert_id > 0){
        
        header("location:list_faq.php?sysmsg=1000");
		exit();
    }
    else{
        header("location:add_faq.php?sysmsg=3");
		exit();
    }
}

#==== STATUS UPDATION
if(($_REQUEST['status']<>"") && ($_REQUEST['id'] <> "")){
	$statusVal  = intval($_REQUEST['status']);
	$status		= ($statusVal=='0') ? '1' : '0';
	$id			= intval($_REQUEST['id']);
	$pgNo 		= intval(base64_decode($_REQUEST['pgNo']));
    $params     = array("is_active" => $status);
	$where 		= array(":id" => $id);

	$update     = $objTypes->update("tbl_faq", $params, "id = :id", $where);
	if($update){
		header("location:list_faq.php?sysmsg=1001&pgNo=".$pgNo);
		exit();
	}
    else{
		header("location:list_faq.php?sysmsg=4&pgNo=".$pgNo);
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
	$delete = $objTypes->update("tbl_faq", $params, "id = :id", $where);
	if($delete){
		header("location:list_faq.php?sysmsg=1002&pgNo=$pgNo");
		exit();
	}else{
		header("location:list_faq.php?sysmsg=4&pgNo=$pgNo");
		exit();
	}
}

#==== ACTIVE ALL
if(($POST['action']=="activeall") && ($_POST['DelCheckBox'] <> "")){
	$DelCheckBox	= $_POST['DelCheckBox'];
	$Result			= count($DelCheckBox);
	$pgNo 			= intval($_REQUEST['pgNo']);

	if($Result == "0"){
		header("location:list_faq.php?sysmsg=8&pgNo=$pgNo");
		exit();
	}
	$Delete	= implode(',', $DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_faq SET is_active = '1' WHERE id IN ($Delete)");

	if($update > 0){
		header("location:list_faq.php?sysmsg=1012&pgNo=$pgNo");
		exit();
	}
    else{
		header("location:list_faq.php?sysmsg=13&pgNo=$pgNo");
		exit();
	}
}

#==== DEACTIVE ALL
if(($POST['action']=="deactiveall") && ($_POST['DelCheckBox'] <> "")){
	$DelCheckBox	= $_POST['DelCheckBox'];
	$Result			= count($DelCheckBox);
	$pgNo 			= intval($_REQUEST['pgNo']);

	if($Result == "0"){
		header("location:list_faq.php?sysmsg=9&pgNo=$pgNo");
		exit();
	}
    $Delete = implode(',',$DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_faq SET is_active = '0' WHERE id IN ($Delete)");

	if($update > 0){
		header("location:list_faq.php?sysmsg=1013&pgNo=$pgNo");
		exit();
	}
    else{
		header("location:list_faq.php?sysmsg=14&pgNo=$pgNo");
		exit();
	}
}

#==== DELETE  ALL
if(($POST['action']=="deleteall") && ($_POST['DelCheckBox'] <> "")){
	$DelCheckBox	= $_POST['DelCheckBox'];
	$Result			= count($DelCheckBox);

	if($Result == "0"){
		header("location:list_faq.php?sysmsg=10");
		exit();
	}
	$Delete = implode(',',$DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_faq SET is_delete = '0' WHERE id IN ($Delete)");

	if($update > 0){
		header("location:list_faq.php?sysmsg=1014");
		exit();
	}
    else{
		header("location:list_faq.php?sysmsg=4");
		exit();
	}
}
