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
		'description'	    => $_POST['description'],
		'brand_id'	        => $POST['brand_id'],
			
		'product_id'	        => $POST['product_id'],
		
		'accessories_id'	=> $POST['accessories_id'],
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
		$update 	= $objTypes->update("tbl_micro_accessories_details", $params, "id = :id", $where);

		if($update){
			$insert_id	= $id;
		}
    }
    else{
        $insert = $objTypes->insert("tbl_micro_accessories_details", $params);
		if($insert){
			$insert_id = $objTypes->lastInsertId();
		}
    }

    if($insert_id > 0){
        if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != ""){
			$validatefiles 	= array("PNG","png","jpg", "bmp", "jpeg", "gif","JPG", "BMP", "JPEG", "GIF");
			$filetype 		= array('image/png','image/PNG','image/gif', 'image/jpeg', 'image/JPEG', 'image/GIF', 'image/bmp', 'image/BMP');
			$ext 	  		= pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $ext 	  		= strtolower($ext);
			$filename 		= basename($_FILES['image']['name'], $ext);
            $filename 		= time().'.'.$ext;
			if($_FILES['image']['size'] > 3097152){
				header("location:add_micro_accessories_details.php?sysmsg=16&id=".$insert_id);
                exit();
            }
            if(in_array($ext, $validatefiles) == false){
                header("location:add_micro_accessories_details.php?sysmsg=11&id=".$insert_id);
                exit();
            }
			if(in_array(strtolower($_FILES['image']['type']), $filetype) == false ){
                header("location:add_micro_accessories_details.php?sysmsg=11&id=".$insert_id);
                exit();
            }
			$where      = array(':id' => $insert_id);
			$imagename	= $objTypes->fetchRow("SELECT image, thumb FROM tbl_micro_accessories_details WHERE id = :id", $where);
			unlink("../uploads/micro_accessories/".str_replace('main_', '', $imagename['image']));		
			unlink("../uploads/micro_accessories/".$imagename['image']);
			unlink("../uploads/micro_accessories/".$imagename['desk_thumb']);
			if(move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/micro_accessories/".$filename)){
				$path 		= "../uploads/micro_accessories/".$filename;
				$main_image = "../uploads/micro_accessories/main_".$filename;
				$magicianObj = new imageLib($path);
				$magicianObj->saveImage($main_image, 100);
				$thumb_image = "../uploads/micro_accessories/thumb_".$filename;
				$thumb_width = "200";
				$thumb_height= "200";
				$magicianObj2 = new imageLib($path);
				$magicianObj2->resizeImage($thumb_width, $thumb_height);
				$magicianObj2->saveImage($thumb_image, 100, $option = 2);
				$img_params = array('image' => 'main_'.$filename, 'thumb' => 'thumb_'.$filename);
				$update     = $objTypes->update("tbl_micro_accessories_details", $img_params, "id = :id", $where);
			}
		}
        header("location:list_micro_accessories_details.php?sysmsg=1000");
		exit();
    }
    else{
        header("location:add_micro_accessories_details.php?sysmsg=3");
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

	$update     = $objTypes->update("tbl_micro_accessories_details", $params, "id = :id", $where);
	if($update){
		header("location:list_micro_accessories_details.php?sysmsg=1001&pgNo=".$pgNo);
		exit();
	}
    else{
		header("location:list_micro_accessories_details.php?sysmsg=4&pgNo=".$pgNo);
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
	$delete = $objTypes->update("tbl_micro_accessories_details", $params, "id = :id", $where);
	if($delete){
		header("location:list_micro_accessories_details.php?sysmsg=1002&pgNo=$pgNo");
		exit();
	}else{
		header("location:list_micro_accessories_details.php?sysmsg=4&pgNo=$pgNo");
		exit();
	}
}

#==== ACTIVE ALL
if(($POST['action']=="activeall") && ($_POST['DelCheckBox'] <> "")){
	$DelCheckBox	= $_POST['DelCheckBox'];
	$Result			= count($DelCheckBox);
	$pgNo 			= intval($_REQUEST['pgNo']);

	if($Result == "0"){
		header("location:list_micro_accessories_details.php?sysmsg=8&pgNo=$pgNo");
		exit();
	}
	$Delete	= implode(',', $DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_micro_accessories_details SET is_active = '1' WHERE id IN ($Delete)");

	if($update > 0){
		header("location:list_micro_accessories_details.php?sysmsg=1012&pgNo=$pgNo");
		exit();
	}
    else{
		header("location:list_micro_accessories_details.php?sysmsg=13&pgNo=$pgNo");
		exit();
	}
}

#==== DEACTIVE ALL
if(($POST['action']=="deactiveall") && ($_POST['DelCheckBox'] <> "")){
	$DelCheckBox	= $_POST['DelCheckBox'];
	$Result			= count($DelCheckBox);
	$pgNo 			= intval($_REQUEST['pgNo']);

	if($Result == "0"){
		header("location:list_micro_accessories_details.php?sysmsg=9&pgNo=$pgNo");
		exit();
	}
    $Delete = implode(',',$DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_micro_accessories_details SET is_active = '0' WHERE id IN ($Delete)");

	if($update > 0){
		header("location:list_micro_accessories_details.php?sysmsg=1013&pgNo=$pgNo");
		exit();
	}
    else{
		header("location:list_micro_accessories_details.php?sysmsg=14&pgNo=$pgNo");
		exit();
	}
}

#==== DELETE  ALL
if(($POST['action']=="deleteall") && ($_POST['DelCheckBox'] <> "")){
	$DelCheckBox	= $_POST['DelCheckBox'];
	$Result			= count($DelCheckBox);

	if($Result == "0"){
		header("location:list_micro_accessories_details.php?sysmsg=10");
		exit();
	}
	$Delete = implode(',',$DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_micro_accessories_details SET is_delete = '0' WHERE id IN ($Delete)");

	if($update > 0){
		header("location:list_micro_accessories_details.php?sysmsg=1014");
		exit();
	}
    else{
		header("location:list_micro_accessories_details.php?sysmsg=4");
		exit();
	}
}
