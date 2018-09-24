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
	    'title1'	=> $POST['title1'],
		'title2'	=> $POST['title2'],
		'description'	=> ($_POST['description']),
		'externalurl'       => $POST['externalurl'],
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
		$update 	= $objTypes->update("tbl_homebanner", $params, "id = :id", $where);
		if($update){
			$insert_id	= $id;
		}
	}
	else{
		$insert = $objTypes->insert("tbl_homebanner", $params);
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
			$filename 		= basename($_FILES['image']['name'], $ext);
            $filename 		= time().'.'.$ext;

			if($_FILES['image']['size'] > 3097152){
				header("location:add_homebanner.php?sysmsg=16&id=".$insert_id);
                exit();
            }

            if(in_array($ext, $validatefiles) == false){
                header("location:add_homebanner.php?sysmsg=11&id=".$insert_id);
                exit();
            }

			if(in_array(strtolower($_FILES['image']['type']), $filetype) == false ){
                header("location:add_homebanner.php?sysmsg=11&id=".$insert_id);
                exit();
            }

			$where      = array(':id' => $insert_id);
			$imagename	= $objTypes->fetchRow("SELECT image, thumbnail FROM tbl_homebanner WHERE id = :id", $where);
			unlink("../uploads/homebanner_images/large/".str_replace('main_', '', $imagename['image']));		
			unlink("../uploads/homebanner_images/large/".$imagename['image']);
			unlink("../uploads/homebanner_images/large/".$imagename['thumbnail']);

			if(move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/homebanner_images/large/".$filename)){
				$path 		= "../uploads/homebanner_images/large/".$filename;
				$main_image = "../uploads/homebanner_images/large/main_".$filename;
				

				$magicianObj = new imageLib($path);
				$magicianObj->saveImage($main_image, 100);

				$thumb_image = "../uploads/homebanner_images/large/thumb_".$filename;
				$thumb_width = "1920";
				$thumb_height= "695";

				$magicianObj2 = new imageLib($path);
				$magicianObj2->resizeImage($thumb_width, $thumb_height, $option = 2);
				$magicianObj2->saveImage($thumb_image, 100);

				$img_params = array('image' => 'main_'.$filename, 'thumbnail' => 'thumb_'.$filename);
				$update     = $objTypes->update("tbl_homebanner", $img_params, "id = :id", $where);
			}
			
		}
		
		if(isset($_FILES['image1']['name']) && $_FILES['image1']['name'] != ""){
			$validatefiles 	= array("jpg", "bmp", "jpeg", "gif","JPG", "BMP", "JPEG", "GIF");
			$filetype 		= array('image/gif', 'image/jpeg', 'image/JPEG', 'image/GIF', 'image/bmp', 'image/BMP');
			$ext 	  		= pathinfo($_FILES['image1']['name'], PATHINFO_EXTENSION);
            $ext 	  		= strtolower($ext);
			$filename1 		= basename($_FILES['image1']['name'], $ext);
            $filename1   	= time().'.'.$ext;

			if($_FILES['image1']['size'] > 3097152){
				header("location:add_homebanner.php?sysmsg=16&id=".$insert_id);
                exit();
            }

            if(in_array($ext, $validatefiles) == false){
                header("location:add_homebanner.php?sysmsg=11&id=".$insert_id);
                exit();
            }

			if(in_array(strtolower($_FILES['image1']['type']), $filetype) == false ){
                header("location:add_homebanner.php?sysmsg=11&id=".$insert_id);
                exit();
            }

			$where      = array(':id' => $insert_id);
			$imagename1	= $objTypes->fetchRow("SELECT image1, thumbnail1 FROM tbl_homebanner WHERE id = :id", $where);
			unlink("../uploads/homebanner_images/medium/".str_replace('main_', '', $imagename1['image1']));		
			unlink("../uploads/homebanner_images/medium/".$imagename1['image1']);
			unlink("../uploads/homebanner_images/medium/".$imagename1['thumbnail1']);

			if(move_uploaded_file($_FILES['image1']['tmp_name'], "../uploads/homebanner_images/medium/".$filename1)){
				$path1 		= "../uploads/homebanner_images/medium/".$filename1;
				$main_image1 = "../uploads/homebanner_images/medium/main_".$filename1;
				

				$magicianObj = new imageLib($path1);
				$magicianObj->saveImage($main_image1, 100);

				$thumb_image1 = "../uploads/homebanner_images/medium/thumb_".$filename1;
				$thumb_width1 = "1000";
				$thumb_height1= "362";

				$magicianObj2 = new imageLib($path1);
				$magicianObj2->resizeImage($thumb_width1, $thumb_height1, $option = 2);
				$magicianObj2->saveImage($thumb_image1, 100);

				$img_params = array('image1' => 'main_'.$filename1, 'thumbnail1' => 'thumb_'.$filename1);
				$update     = $objTypes->update("tbl_homebanner", $img_params, "id = :id", $where);
			}
			
		}
		
		if(isset($_FILES['image2']['name']) && $_FILES['image2']['name'] != ""){
			$validatefiles 	= array("jpg", "bmp", "jpeg", "gif","JPG", "BMP", "JPEG", "GIF");
			$filetype 		= array('image/gif', 'image/jpeg', 'image/JPEG', 'image/GIF', 'image/bmp', 'image/BMP');
			$ext 	  		= pathinfo($_FILES['image2']['name'], PATHINFO_EXTENSION);
            $ext 	  		= strtolower($ext);
			$filename2 		= basename($_FILES['image2']['name'], $ext);
            $filename2   	= time().'.'.$ext;

			if($_FILES['image2']['size'] > 3097152){
				header("location:add_homebanner.php?sysmsg=16&id=".$insert_id);
                exit();
            }

            if(in_array($ext, $validatefiles) == false){
                header("location:add_homebanner.php?sysmsg=11&id=".$insert_id);
                exit();
            }

			if(in_array(strtolower($_FILES['image2']['type']), $filetype) == false ){
                header("location:add_homebanner.php?sysmsg=11&id=".$insert_id);
                exit();
            }

			$where      = array(':id' => $insert_id);
			$imagename2	= $objTypes->fetchRow("SELECT image2, thumbnail2 FROM tbl_homebanner WHERE id = :id", $where);
			unlink("../uploads/homebanner_images/small/".str_replace('main_', '', $imagename1['image2']));		
			unlink("../uploads/homebanner_images/small/".$imagename1['image2']);
			unlink("../uploads/homebanner_images/small/".$imagename1['thumbnail2']);

			if(move_uploaded_file($_FILES['image2']['tmp_name'], "../uploads/homebanner_images/small/".$filename2)){
				$path2 		= "../uploads/homebanner_images/small/".$filename2;
				$main_image2 = "../uploads/homebanner_images/small/main_".$filename2;
				

				$magicianObj = new imageLib($path2);
				$magicianObj->saveImage($main_image2, 100);

				$thumb_image2 = "../uploads/homebanner_images/small/thumb_".$filename2;
				$thumb_width2 = "480";
				$thumb_height2= "174";

				$magicianObj2 = new imageLib($path2);
				$magicianObj2->resizeImage($thumb_width2, $thumb_height2, $option = 2);
				$magicianObj2->saveImage($thumb_image2, 100);

				$img_params = array('image2' => 'main_'.$filename2, 'thumbnail2' => 'thumb_'.$filename2);
				$update     = $objTypes->update("tbl_homebanner", $img_params, "id = :id", $where);
			}
			header("location:list_homebanner.php?sysmsg=1000&pgNo=".$pgNo);
			exit();
		}
		if($POST['store_image2']=="" ||$POST['store_image1']=="" || $POST['store_image']==""){
				
			header("location:list_homebanner.php?sysmsg=3&pgNo=".$pgNo);
			
			exit();
		}else{
			if($filename1!="" ||$filename!="" ||$filename2!=""){
				header("location:list_homebanner.php?sysmsg=1000&pgNo=".$pgNo);
			}else{
				header("location:list_homebanner.php?sysmsg=1001&pgNo=".$pgNo);
				exit();
			}
		}
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

	$update     = $objTypes->update("tbl_homebanner", $params, "id = :id", $where);
	if($update){
		header("location:list_homebanner.php?sysmsg=1001&pgNo=".$pgNo);
		exit();
	}
    else{
		header("location:list_homebanner.php?sysmsg=4&pgNo=".$pgNo);
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
	$delete = $objTypes->update("tbl_homebanner", $params, "id = :id", $where);
	if($delete){
		header("location:list_homebanner.php?sysmsg=1002&pgNo=$pgNo");
		exit();
	}else{
		header("location:list_homebanner.php?sysmsg=4&pgNo=$pgNo");
		exit();
	}
}

#==== ACTIVE ALL
if(($POST['action']=="activeall") && ($_POST['DelCheckBox'] <> "")){
	$DelCheckBox	= $_POST['DelCheckBox'];
	$Result			= count($DelCheckBox);
	$pgNo 			= intval($_REQUEST['pgNo']);

	if($Result == "0"){
		header("location:list_homebanner.php?sysmsg=8&pgNo=$pgNo");
		exit();
	}
	$Delete	= implode(',', $DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_homebanner SET is_active = '1' WHERE id IN ($Delete)");

	if($update > 0){
		header("location:list_homebanner.php?sysmsg=1012&pgNo=$pgNo");
		exit();
	}
    else{
		header("location:list_homebanner.php?sysmsg=13&pgNo=$pgNo");
		exit();
	}
}

#==== DEACTIVE ALL
if(($POST['action']=="deactiveall") && ($_POST['DelCheckBox'] <> "")){
	$DelCheckBox	= $_POST['DelCheckBox'];
	$Result			= count($DelCheckBox);
	$pgNo 			= intval($_REQUEST['pgNo']);

	if($Result == "0"){
		header("location:list_homebanner.php?sysmsg=9&pgNo=$pgNo");
		exit();
	}
    $Delete = implode(',',$DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_homebanner SET is_active = '0' WHERE id IN ($Delete)");

	if($update > 0){
		header("location:list_homebanner.php?sysmsg=1013&pgNo=$pgNo");
		exit();
	}
    else{
		header("location:list_homebanner.php?sysmsg=14&pgNo=$pgNo");
		exit();
	}
}

#==== DELETE  ALL
if(($POST['action']=="deleteall") && ($_POST['DelCheckBox'] <> "")){
	$DelCheckBox	= $_POST['DelCheckBox'];
	$Result			= count($DelCheckBox);

	if($Result == "0"){
		header("location:list_homebanner.php?sysmsg=10");
		exit();
	}
	$Delete = implode(',',$DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_homebanner SET is_delete = '0' WHERE id IN ($Delete)");

	if($update > 0){
		header("location:list_homebanner.php?sysmsg=1014");
		exit();
	}
    else{
		header("location:list_homebanner.php?sysmsg=4");
		exit();
	}
}
