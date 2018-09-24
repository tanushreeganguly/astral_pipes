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
	if($POST['is_home'] == 1){	
		$update_arr = array(
				'is_home' => 0,
			);		
		$where_arr 	= array(":type" => $POST['type']);			
		$update     = $objTypes->update("tbl_whats_new", $update_arr,"type = :type",$where_arr);
	}  
	$pgNo 	= intval(base64_decode($_REQUEST['pgNo']));	
	$params = array(
	    'title'	  => $POST['title'],
		'type'	  => $POST['type'],
		'youtube' => $POST['youtube'],
		'is_home' => $POST['is_home'],
		'ip'      => $ip,
        'agent'   => $agent,
        'added_by'=> $_SESSION['SessAdminName']
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
		$update 	= $objTypes->update("tbl_whats_new", $params, "id = :id", $where);
		if($update){
			$insert_id	= $id;
		}
	}else{
		$insert = $objTypes->insert("tbl_whats_new", $params);
		if($insert){
			$insert_id = $objTypes->lastInsertId();
		}
	}

	if($insert_id > 0){
		if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != ""){
			$validatefiles 	= array("jpg", "bmp", "jpeg", "gif","JPG", "BMP", "JPEG", "GIF");
			$filetype 		= array('image/gif', 'image/jpeg', 'image/JPEG', 'image/GIF', 'image/bmp', 'image/BMP');
			$ext 	  		= pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $ext 	  		= strtolower($ext);
			$filename1 		= basename($_FILES['image']['name'], $ext);
            $filename1 		= time().'.'.$ext;

			if($_FILES['image']['size'] > 3097152){
				header("location:add_whats_new.php?sysmsg=16&id=".$insert_id);
                exit();
            }

            if(in_array($ext, $validatefiles) == false){
                header("location:add_whats_new.php?sysmsg=11&id=".$insert_id);
                exit();
            }

			if(in_array(strtolower($_FILES['image']['type']), $filetype) == false ){
                header("location:add_whats_new.php?sysmsg=11&id=".$insert_id);
                exit();
            }

			$where      = array(':id' => $insert_id);
			$imagename1	= $objTypes->fetchRow("SELECT image, thumbnail FROM tbl_whats_new WHERE id = :id", $where);
			unlink("../uploads/whats_new_images/".str_replace('main_', '', $imagename['image']));		
			unlink("../uploads/whats_new_images/".$imagename1['image']);
			unlink("../uploads/whats_new_images/".$imagename1['thumbnail1']);

			if(move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/whats_new_images/".$filename1))
			{
				$path1 		= "../uploads/whats_new_images/".$filename1;
				$main_image = "../uploads/whats_new_images/main_".$filename1;
				$main_width	= "355";
				$main_height= "200";

				$magicianObj = new imageLib($path1);
				//$magicianObj->resizeImage($thumb_width, $thumb_height, $option = 2);
				$magicianObj->saveImage($main_image, 100);

				$thumb_image = "../uploads/whats_new_images/thumb_".$filename1;
				$thumb_width1 = "565";
				$thumb_height1= "416"; 

				$magicianObj2 = new imageLib($path1);
				$magicianObj2->resizeImage($thumb_width1, $thumb_height1);
				$magicianObj2->saveImage($thumb_image, 100);

				$img_params = array('image' => 'main_'.$filename1, 'thumbnail' => 'thumb_'.$filename1);
				$update     = $objTypes->update("tbl_whats_new", $img_params, "id = :id", $where);
			}
			header("location:list_whats_new.php?sysmsg=1000&id=".$insert_id);
			exit();
		}
	}	
	header("location:list_whats_new.php?sysmsg=1000&id=".$insert_id);
	exit();
}

#==== STATUS UPDATION
if(($_REQUEST['status']<>"") && ($_REQUEST['id'] <> "")){
	$statusVal  = intval($_REQUEST['status']);
	$status		= ($statusVal=='0') ? '1' : '0';
	$id			= intval($_REQUEST['id']);
	$pgNo 		= intval(base64_decode($_REQUEST['pgNo']));
    $params     = array("is_active" => $status);
	$where 		= array(":id" => $id);
	
	$update     = $objTypes->update("tbl_whats_new", $params, "id = :id", $where);
	if($update){
		header("location:list_whats_new.php?sysmsg=1001&pgNo=".$pgNo);
		exit();
	}else{
		header("location:list_whats_new.php?sysmsg=4&pgNo=".$pgNo);
		exit();
	}
}

#==== DELETE
if(($_REQUEST['action']=="delete") && ($_REQUEST['id'] <> "")){
	$id		= intval($_REQUEST['id']);
	$pgNo 	= intval(base64_decode($_REQUEST['pgNo']));
	$params	= array("is_delete" => '0');
	$where  = array(":id" => $id);
	$delete = $objTypes->update("tbl_whats_new", $params, "id = :id", $where);
	if($delete){
		header("location:list_whats_new.php?sysmsg=1002&pgNo=$pgNo");
		exit();
	}else{
		header("location:list_whats_new.php?sysmsg=4&pgNo=$pgNo");
		exit();
	}
}

#==== ACTIVE ALL
if(($POST['action']=="activeall") && ($_POST['DelCheckBox'] <> "")){
	$DelCheckBox	= $_POST['DelCheckBox'];
	$Result			= count($DelCheckBox);
	$pgNo 			= intval($_REQUEST['pgNo']);

	if($Result == "0"){
		header("location:list_whats_new.php?sysmsg=8&pgNo=$pgNo");
		exit();
	}
	$Delete	= implode(',', $DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_whats_new SET is_active = '1' WHERE id IN ($Delete)");

	if($update > 0){
		header("location:list_whats_new.php?sysmsg=1012&pgNo=$pgNo");
		exit();
	}
    else{
		header("location:list_whats_new.php?sysmsg=13&pgNo=$pgNo");
		exit();
	}
}

#==== DEACTIVE ALL
if(($POST['action']=="deactiveall") && ($_POST['DelCheckBox'] <> "")){
	$DelCheckBox	= $_POST['DelCheckBox'];
	$Result			= count($DelCheckBox);
	$pgNo 			= intval($_REQUEST['pgNo']);

	if($Result == "0"){
		header("location:list_whats_new.php?sysmsg=9&pgNo=$pgNo");
		exit();
	}
    $Delete = implode(',',$DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_whats_new SET is_active = '0' WHERE id IN ($Delete)");

	if($update > 0){
		header("location:list_whats_new.php?sysmsg=1013&pgNo=$pgNo");
		exit();
	}
    else{
		header("location:list_whats_new.php?sysmsg=14&pgNo=$pgNo");
		exit();
	}
}

#==== DELETE  ALL
if(($POST['action']=="deleteall") && ($_POST['DelCheckBox'] <> "")){
	$DelCheckBox	= $_POST['DelCheckBox'];
	$Result			= count($DelCheckBox);

	if($Result == "0"){
		header("location:list_whats_new.php?sysmsg=10");
		exit();
	}
	$Delete = implode(',',$DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_whats_new SET is_delete = '0' WHERE id IN ($Delete)");

	if($update > 0){
		header("location:list_whats_new.php?sysmsg=1014");
		exit();
	}
    else{
		header("location:list_whats_new.php?sysmsg=4");
		exit();
	}
}
