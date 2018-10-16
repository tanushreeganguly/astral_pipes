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
		'title'	        	=> $POST['title'],
		'label'	        	=> $POST['label'],
		'about'				=>($_POST['about']),	
		//'cat_id'	        => $POST['cat_id'],
		'product_cat_id'	=> $POST['product_cat_id'],		
		'more_about'		=>($_POST['more_about']),
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
		$update 	= $objTypes->update("tbl_micro_brand", $params, "id = :id", $where);
		if($update){
			$insert_id	= $id;
		}
	}
	else{
		$insert = $objTypes->insert("tbl_micro_brand", $params);
		if($insert){
			$insert_id = $objTypes->lastInsertId();
		}
	}

	if($insert_id > 0){
		
		if(isset($_FILES['about_image']['name']) && $_FILES['about_image']['name'] != ""){
			$validatefiles 	= array("jpg", "bmp", "jpeg", "gif","JPG", "BMP", "JPEG", "GIF");
			$filetype 		= array('image/PNG','image/png', 'image/gif', 'image/jpeg', 'image/JPEG', 'image/GIF', 'image/bmp', 'image/BMP');
			$ext 	  		= pathinfo($_FILES['about_image']['name'], PATHINFO_EXTENSION);
            $ext 	  		= strtolower($ext);
			$filename 		= basename($_FILES['about_image']['name'], $ext);
            $filename 		= time().'.'.$ext;
			if($_FILES['about_image']['size'] > 3097152){
				header("location:add_micro_brand.php?sysmsg=16&id=".$insert_id);
                exit();
            }
            if(in_array($ext, $validatefiles) == false){
                header("location:add_micro_brand.php?sysmsg=11&id=".$insert_id);
                exit();
            }
			if(in_array(strtolower($_FILES['about_image']['type']), $filetype) == false ){
                header("location:add_micro_brand.php?sysmsg=11&id=".$insert_id);
                exit();
            }
			$where      = array(':id' => $insert_id);
			$imagename	= $objTypes->fetchRow("SELECT about_image,about_thumb FROM tbl_micro_brand WHERE id = :id", $where);
			unlink("../uploads/micro_brand/".str_replace('main_', '', $imagename['about_image']));		
			unlink("../uploads/micro_brand/".$imagename['about_image']);
			unlink("../uploads/micro_brand/".$imagename['about_thumb']);
			if(move_uploaded_file($_FILES['about_image']['tmp_name'], "../uploads/micro_brand/".$filename)){
				$path 		= "../uploads/micro_brand/".$filename;
				$main_image = "../uploads/micro_brand/main_".$filename;
				$magicianObj = new imageLib($path);
				$magicianObj->saveImage($main_image, 100,$option = 2);
				$img_params = array('about_image' => 'main_'.$filename,'about_thumb' => 'thumb_'.$filename);
				$update     = $objTypes->update("tbl_micro_brand", $img_params, "id = :id", $where);
			}
		}
		
			if(isset($_FILES['catalogue']['name']) && $_FILES['catalogue']['name'] != "")
			{			
				$ext 			= pathinfo($_FILES['catalogue']['name'], PATHINFO_EXTENSION);
				$ext			= strtolower($ext);
				$validatefiles  = array("pdf", "PDF");
				$filetype 		= array('application/pdf','application/PDF');
				if(in_array($ext, $validatefiles) == false){
					header("location:add_micro_brand.php?sysmsg=35");
					exit();		
				}
				if(in_array(strtolower($_FILES['catalogue']['type']), $filetype) == false ){
					header("location:add_micro_brand.php?sysmsg=35");
					exit();	
				}
				if(isset($_FILES['catalogue']['name'])){
					$ext 	  = pathinfo($_FILES['catalogue']['name'], PATHINFO_EXTENSION);
					$filename = basename($_FILES['catalogue']['name'], $ext);			
					$filename = 'broucher_'.time().'.'.$ext;
					$movefile = move_uploaded_file($_FILES['catalogue']['tmp_name'], "../uploads/micro_product_brouchers/".$filename);				
				}
				$update_params  = array('broucher'=> $filename);
				$params			= array_merge($params, $update_params);
				$where	  		= array(':id'=> $insert_id);
				$updatepdf 		= $objTypes->update("tbl_micro_brand", $params, "id = :id", $where);
			}	
		if(isset($_FILES['desk_image']['name']) && $_FILES['desk_image']['name'] != ""){
			$validatefiles 	= array('image/PNG', 'image/png',"jpg", "bmp", "jpeg", "gif","JPG", "BMP", "JPEG", "GIF");
			$filetype 		= array('image/gif', 'image/jpeg', 'image/JPEG', 'image/GIF', 'image/bmp', 'image/BMP');
			$ext 	  		= pathinfo($_FILES['desk_image']['name'], PATHINFO_EXTENSION);
            $ext 	  		= strtolower($ext);
			$filename 		= basename($_FILES['desk_image']['name'], $ext);
            $filename 		= time().'.'.$ext;
			if($_FILES['desk_image']['size'] > 3097152){
				header("location:add_micro_brand.php?sysmsg=16&id=".$insert_id);
                exit();
            }
            if(in_array($ext, $validatefiles) == false){
                header("location:add_micro_brand.php?sysmsg=11&id=".$insert_id);
                exit();
            }
			if(in_array(strtolower($_FILES['desk_image']['type']), $filetype) == false ){
                header("location:add_micro_brand.php?sysmsg=11&id=".$insert_id);
                exit();
            }
			$where      = array(':id' => $insert_id);
			$imagename	= $objTypes->fetchRow("SELECT desk_image, desk_thumb FROM tbl_micro_brand WHERE id = :id", $where);
			unlink("../uploads/micro_brand/".str_replace('main_', '', $imagename['desk_image']));		
			unlink("../uploads/micro_brand/".$imagename['desk_image']);
			unlink("../uploads/micro_brand/".$imagename['desk_thumb']);
			if(move_uploaded_file($_FILES['desk_image']['tmp_name'], "../uploads/micro_brand/".$filename)){
				$path 		= "../uploads/micro_brand/".$filename;
				$main_image = "../uploads/micro_brand/main_".$filename;
				$magicianObj = new imageLib($path);
				$magicianObj->saveImage($main_image, 100);
				$thumb_image = "../uploads/micro_brand/thumb_".$filename;
				$thumb_width = "1920";
				$thumb_height= "688";
				$magicianObj2 = new imageLib($path);
				$magicianObj2->resizeImage($thumb_width, $thumb_height);
				$magicianObj2->saveImage($thumb_image, 100, $option = 2);
				$img_params = array('desk_image' => 'main_'.$filename, 'desk_thumb' => 'thumb_'.$filename);
				$update     = $objTypes->update("tbl_micro_brand", $img_params, "id = :id", $where);
			}
		}
	}
		header("location:list_micro_brand.php?sysmsg=14&pgNo=$pgNo");
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
	$update     = $objTypes->update("tbl_micro_brand", $params, "id = :id", $where);
	if($update){
		header("location:list_micro_brand.php?sysmsg=1001&pgNo=".$pgNo);
		exit();
	}
    else{
		header("location:list_micro_brand.php?sysmsg=4&pgNo=".$pgNo);
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
	$delete = $objTypes->update("tbl_micro_brand", $params, "id = :id", $where);
	if($delete){
		header("location:list_micro_brand.php?sysmsg=1002&pgNo=$pgNo");
		exit();
	}else{
		header("location:list_micro_brand.php?sysmsg=4&pgNo=$pgNo");
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
		header("location:list_micro_brand.php?sysmsg=8&pgNo=$pgNo");
		exit();
	}
	$Delete	= implode(',', $DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_micro_brand SET is_active = '1' WHERE id IN ($Delete)");
	if($update > 0){
		header("location:list_micro_brand.php?sysmsg=1012&pgNo=$pgNo");
		exit();
	}
    else{
		header("location:list_micro_brand.php?sysmsg=13&pgNo=$pgNo");
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
		header("location:list_micro_brand.php?sysmsg=9&pgNo=$pgNo");
		exit();
	}
    $Delete = implode(',',$DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_micro_brand SET is_active = '0' WHERE id IN ($Delete)");
	if($update > 0){
		header("location:list_micro_brand.php?sysmsg=1013&pgNo=$pgNo");
		exit();
	}
    else{
		header("location:list_micro_brand.php?sysmsg=14&pgNo=$pgNo");
		exit();
	}
}
#==== DELETE  ALL
if(($POST['action']=="deleteall") && ($_POST['DelCheckBox'] <> "")){
	$DelCheckBox	= $_POST['DelCheckBox'];
	$Result			= count($DelCheckBox);
	$title  = $_REQUEST['title'];
	if($Result == "0"){
		header("location:list_micro_brand.php?sysmsg=10");
		exit();
	}
	$Delete = implode(',',$DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_micro_brand SET is_delete = '0' WHERE id IN ($Delete)");
	if($update > 0){
		header("location:list_micro_brand.php?sysmsg=1014");
		exit();
	}
    else{
		header("location:list_micro_brand.php?sysmsg=4");
		exit();
	}
}