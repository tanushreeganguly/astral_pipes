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
        'short_description'	=> $POST['short_description'],
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
		$where = array(
			':id'          => $id
		);
		$update 	= $objTypes->update("tbl_pages", $params, "id = :id", $where);

		if($update){
			$insert_id	= $id;
		}
    }
    else{
        $insert = $objTypes->insert("tbl_pages", $params);
		if($insert){
			$insert_id = $objTypes->lastInsertId();
		}
    }

    if($insert_id > 0){
        $validatefiles 	= array("jpg", "bmp", "jpeg", "gif","JPG", "BMP", "JPEG", "GIF");
        $filetype 		= array('image/gif', 'image/jpeg', 'image/JPEG', 'image/GIF', 'image/bmp', 'image/BMP');
        if(isset($_FILES['banner']['name']) && $_FILES['banner']['name'] != ""){
			$ext 	  				= pathinfo($_FILES['banner']['name'], PATHINFO_EXTENSION);
			$ext 	  				= strtolower($ext);
			$filename 				= basename($_FILES['banner']['name'], $ext);
			$filename 				= 'banner_'.time().'.'.$ext;
			list($width, $height) 	= getimagesize($_FILES['banner']['tmp_name']);

			if($_FILES['banner']['size'] > 3097152){
				header("location:add_page.php?sysmsg=17&id=".$insert_id);
                exit();
            }

			if(in_array($ext, $validatefiles) == false){
                header("location:add_page.php?sysmsg=11&id=".$insert_id);
                exit();
            }

			if(in_array(strtolower($_FILES['banner']['type']), $filetype) == false ){
                header("location:add_page.php?sysmsg=11&id=".$insert_id);
                exit();
            }

			/*if(array($width, $height) != array('1920', '250')){
				header("location:add_page.php?sysmsg=15&id=".$insert_id);
                exit();
			}*/
			
			$where      = array(':id' => $insert_id);
			$imagename	= $objTypes->fetchRow("SELECT banner FROM tbl_pages WHERE id = :id", $where);
			unlink("../uploads/contentpages_images/".$imagename['banner']);

			if(move_uploaded_file($_FILES['banner']['tmp_name'], "../uploads/contentpages_images/".$filename)){
				$path 		= "../uploads/contentpages_images/".$filename;
				$main_image = "../uploads/contentpages_images/main_".$filename;
				//$main_width	= "545";
				//$main_height= "367";

				$magicianObj = new imageLib($path);
				//$magicianObj->resizeImage($main_width, $main_height);
				$magicianObj->saveImage($main_image, 100);

				$thumb_image = "../uploads/contentpages_images/thumb_".$filename;
				$thumb_width = "1920";
				$thumb_height= "250";

				$magicianObj2 = new imageLib($path);
				$magicianObj2->resizeImage($thumb_width, $thumb_height, $option = 2);
				$magicianObj2->saveImage($thumb_image, 100);

				$img_params = array('banner' => "thumb_".$filename);
				$update     = $objTypes->update("tbl_pages", $img_params, "id = :id", $where);
			}
			else{
				header("location:add_page.php?sysmsg=1003&id=".$insert_id);
				exit();
			}
		}
        header("location:list_pages.php?sysmsg=1000");
		exit();
    }
    else{
        header("location:add_page.php?sysmsg=3");
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

	$update     = $objTypes->update("tbl_pages", $params, "id = :id", $where);
	if($update){
		header("location:list_pages.php?sysmsg=1001&pgNo=".$pgNo);
		exit();
	}
    else{
		header("location:list_pages.php?sysmsg=4&pgNo=".$pgNo);
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
	$delete = $objTypes->update("tbl_pages", $params, "id = :id", $where);
	if($delete){
		header("location:list_pages.php?sysmsg=1002&pgNo=$pgNo");
		exit();
	}else{
		header("location:list_pages.php?sysmsg=4&pgNo=$pgNo");
		exit();
	}
}

#==== ACTIVE ALL
if(($POST['action']=="activeall") && ($_POST['DelCheckBox'] <> "")){
	$DelCheckBox	= $_POST['DelCheckBox'];
	$Result			= count($DelCheckBox);
	$pgNo 			= intval($_REQUEST['pgNo']);

	if($Result == "0"){
		header("location:list_pages.php?sysmsg=8&pgNo=$pgNo");
		exit();
	}
	$Delete	= implode(',', $DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_pages SET is_active = '1' WHERE id IN ($Delete)");

	if($update > 0){
		header("location:list_pages.php?sysmsg=1012&pgNo=$pgNo");
		exit();
	}
    else{
		header("location:list_pages.php?sysmsg=13&pgNo=$pgNo");
		exit();
	}
}

#==== DEACTIVE ALL
if(($POST['action']=="deactiveall") && ($_POST['DelCheckBox'] <> "")){
	$DelCheckBox	= $_POST['DelCheckBox'];
	$Result			= count($DelCheckBox);
	$pgNo 			= intval($_REQUEST['pgNo']);

	if($Result == "0"){
		header("location:list_pages.php?sysmsg=9&pgNo=$pgNo");
		exit();
	}
    $Delete = implode(',',$DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_pages SET is_active = '0' WHERE id IN ($Delete)");

	if($update > 0){
		header("location:list_pages.php?sysmsg=1013&pgNo=$pgNo");
		exit();
	}
    else{
		header("location:list_pages.php?sysmsg=14&pgNo=$pgNo");
		exit();
	}
}

#==== DELETE  ALL
if(($POST['action']=="deleteall") && ($_POST['DelCheckBox'] <> "")){
	$DelCheckBox	= $_POST['DelCheckBox'];
	$Result			= count($DelCheckBox);

	if($Result == "0"){
		header("location:list_pages.php?sysmsg=10");
		exit();
	}
	$Delete = implode(',',$DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_pages SET is_delete = '0' WHERE id IN ($Delete)");

	if($update > 0){
		header("location:list_pages.php?sysmsg=1014");
		exit();
	}
    else{
		header("location:list_pages.php?sysmsg=4");
		exit();
	}
}
