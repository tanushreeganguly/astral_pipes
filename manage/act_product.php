<?php
#=== Includes
require_once("../config/config.php");
require_once("verify_logins.php");

#==== Validations For Security
$POST		= $objTypes->validateUserInput($_POST);
$id 		= isset($POST['id']) ? intval($POST['id']) : intval($_REQUEST['id']) ;
$ip			= $_SERVER['REMOTE_ADDR'];
$agent		= addslashes($_SERVER['HTTP_USER_AGENT']);
$app_ids = $_POST['app_id'];

$napp_ids = count($app_ids);
//echo $napp_ids;
	//print_r($app_ids); exit; 
#==== ADD - UPDATE - INSERT
if(($POST['SAVE']=="SAVE")){
	for($i=0; $i < $napp_ids; $i++)
    {
    $pgNo 	= intval(base64_decode($_REQUEST['pgNo']));
	$params = array(
		'title'	            => $POST['title'],
        'short_description'	=>($_POST['short_description']),		
		'app_id'   			=> $app_ids[$i],		
		'short_code' 		=> $POST['short_code'],		
		'description'   	=>($_POST['description']),
		'additional_details'=>($_POST['additional_details']),
		'technical_details'	=>($_POST['technical_details']),		
		'long_technical_details'	=>($_POST['long_technical_details']),
		'features_benefits'	=>($_POST['features_benefits']),
		'meta_description'  => $POST['meta_description'],
        'meta_keywords'     => $POST['meta_keywords'],
        'meta_title'        => $POST['meta_title'],
        'ip'                => $ip,
        'agent'             => $agent,
        'added_by'          => $_SESSION['SessAdminName']
	);
    if($id > 0){
		$update_params = array(
	        'updated_date'	=> date("Y-m-d H:i:s"),
	        'updated_by'   	=> $_SESSION['SessAdminName'],
		);
		$params = array_merge($params, $update_params);
		$where  = array(
			':id'  => $id
		);
		$update 	= $objTypes->update("tbl_products_details", $params, "id = :id", $where);
		if($update){
			$insert_id	= $id;
		}
	}else{
		$insert = $objTypes->insert("tbl_products_details", $params);
		if($insert){
			$insert_id = $objTypes->lastInsertId();
		}
	}
	}
	if($insert_id > 0){		
		if(isset($_FILES['logo']['name']) && $_FILES['logo']['name'] != ""){
			$validatefiles 	= array("png","PNG","jpg", "bmp", "jpeg", "gif","JPG", "BMP", "JPEG", "GIF");
			$filetype 		= array('image/png','image/PNG','image/gif', 'image/jpeg', 'image/JPEG', 'image/GIF', 'image/bmp', 'image/BMP');
			$ext 	  		= pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
            $ext 	  		= strtolower($ext);
			$filename 		= basename($_FILES['logo']['name'], $ext);
            $filename 		= time().'.'.$ext;
			if($_FILES['logo']['size'] > 3097152){
				header("location:add_product.php?sysmsg=16&id=".$insert_id);
                exit();
            }
            if(in_array($ext, $validatefiles) == false){
                header("location:add_product.php?sysmsg=11&id=".$insert_id);
                exit();
            }
			if(in_array(strtolower($_FILES['logo']['type']), $filetype) == false ){
                header("location:add_product.php?sysmsg=11&id=".$insert_id);
                exit();
            }
			$where      = array(':id' => $insert_id);
			$imagename	= $objTypes->fetchRow("SELECT logo FROM tbl_products_details WHERE id = :id", $where);
			unlink("../uploads/product_images/logo/".str_replace('main_', '', $imagename['logo']));		
			unlink("../uploads/product_images/logo/".$imagename['logo']);
			unlink("../uploads/product_images/logo/".$imagename['logo']);
			if(move_uploaded_file($_FILES['logo']['tmp_name'], "../uploads/product_images/logo/".$filename)){
				$path 		= "../uploads/product_images/logo/".$filename;
				$main_image = "../uploads/product_images/logo/main_".$filename;
				$magicianObj = new imageLib($path);
				$magicianObj->saveImage($main_image, 100,$option = 2);
				$img_params = array('logo' => 'main_'.$filename);
				$update     = $objTypes->update("tbl_products_details", $img_params, "id = :id", $where);
			}
		}
		
		if(isset($_FILES['brand_logo']['name']) && $_FILES['brand_logo']['name'] != ""){
			$validatefiles 	= array("PNG","png","jpg", "bmp", "jpeg", "gif","JPG", "BMP", "JPEG", "GIF");
			$filetype 		= array('image/PNG','image/png','image/gif', 'image/jpeg', 'image/JPEG', 'image/GIF', 'image/bmp', 'image/BMP');
			$ext 	  		= pathinfo($_FILES['brand_logo']['name'], PATHINFO_EXTENSION);
            $ext 	  		= strtolower($ext);
			$filename 		= basename($_FILES['brand_logo']['name'], $ext);
            $filename 		= time().'.'.$ext;
			if($_FILES['brand_logo']['size'] > 3097152){
				header("location:add_product.php?sysmsg=16&id=".$insert_id);
                exit();
            }
            if(in_array($ext, $validatefiles) == false){
                header("location:add_product.php?sysmsg=11&id=".$insert_id);
                exit();
            }
			if(in_array(strtolower($_FILES['brand_logo']['type']), $filetype) == false ){
                header("location:add_product.php?sysmsg=11&id=".$insert_id);
                exit();
            }
			$where      = array(':id' => $insert_id);
			$imagename	= $objTypes->fetchRow("SELECT brand_logo FROM tbl_products_details WHERE id = :id", $where);
			unlink("../uploads/product_images/brand_logo/".str_replace('main_', '', $imagename['brand_logo']));		
			unlink("../uploads/product_images/brand_logo/".$imagename['brand_logo']);
			unlink("../uploads/product_images/brand_logo/".$imagename['brand_logo']);
			if(move_uploaded_file($_FILES['brand_logo']['tmp_name'], "../uploads/product_images/brand_logo/".$filename)){
				$path 		= "../uploads/product_images/brand_logo/".$filename;
				$main_image = "../uploads/product_images/brand_logo/main_".$filename;
				$magicianObj = new imageLib($path);
				$magicianObj->saveImage($main_image, 100,$option = 2);
				$img_params = array('brand_logo' => 'main_'.$filename);
				$update     = $objTypes->update("tbl_products_details", $img_params, "id = :id", $where);
			}
		}
		
			if(isset($_FILES['catalogue']['name']) && $_FILES['catalogue']['name'] != "")
			{			
				$ext 			= pathinfo($_FILES['catalogue']['name'], PATHINFO_EXTENSION);
				$ext			= strtolower($ext);
				$validatefiles  = array("pdf", "PDF");
				$filetype 		= array('application/pdf','application/PDF');
				if(in_array($ext, $validatefiles) == false){
					header("location:add_product.php?sysmsg=35");
					exit();		
				}
				if(in_array(strtolower($_FILES['catalogue']['type']), $filetype) == false ){
					header("location:add_product.php?sysmsg=35");
					exit();	
				}
				if(isset($_FILES['catalogue']['name'])){
					$ext 	  = pathinfo($_FILES['catalogue']['name'], PATHINFO_EXTENSION);
					$filename = basename($_FILES['catalogue']['name'], $ext);			
					$filename = 'broucher_'.time().'.'.$ext;
					$movefile = move_uploaded_file($_FILES['catalogue']['tmp_name'], "../uploads/product_broucher/".$filename);				
				}
				$update_params  = array('broucher'=> $filename);
				$params			= array_merge($params, $update_params);
				$where	  		= array(':id'=> $insert_id);
				$updatepdf 		= $objTypes->update("tbl_products_details", $params, "id = :id", $where);
			}	
		if(isset($_FILES['desk_image']['name']) && $_FILES['desk_image']['name'] != ""){
			$validatefiles 	= array("jpg", "bmp", "jpeg", "gif","JPG", "BMP", "JPEG", "GIF");
			$filetype 		= array('image/gif', 'image/jpeg', 'image/JPEG', 'image/GIF', 'image/bmp', 'image/BMP');
			$ext 	  		= pathinfo($_FILES['desk_image']['name'], PATHINFO_EXTENSION);
            $ext 	  		= strtolower($ext);
			$filename 		= basename($_FILES['desk_image']['name'], $ext);
            $filename 		= time().'.'.$ext;
			if($_FILES['desk_image']['size'] > 3097152){
				header("location:add_product.php?sysmsg=16&id=".$insert_id);
                exit();
            }
            if(in_array($ext, $validatefiles) == false){
                header("location:add_product.php?sysmsg=11&id=".$insert_id);
                exit();
            }
			if(in_array(strtolower($_FILES['desk_image']['type']), $filetype) == false ){
                header("location:add_product.php?sysmsg=11&id=".$insert_id);
                exit();
            }
			$where      = array(':id' => $insert_id);
			$imagename	= $objTypes->fetchRow("SELECT desk_image, desk_thumb FROM tbl_products_details WHERE id = :id", $where);
			unlink("../uploads/product_images/large/".str_replace('main_', '', $imagename['desk_image']));		
			unlink("../uploads/product_images/large/".$imagename['desk_image']);
			unlink("../uploads/product_images/large/".$imagename['desk_thumb']);
			if(move_uploaded_file($_FILES['desk_image']['tmp_name'], "../uploads/product_images/large/".$filename)){
				$path 		= "../uploads/product_images/large/".$filename;
				$main_image = "../uploads/product_images/large/main_".$filename;
				$magicianObj = new imageLib($path);
				$magicianObj->saveImage($main_image, 100);
				$thumb_image = "../uploads/product_images/large/thumb_".$filename;
				$thumb_width = "1920";
				$thumb_height= "688";
				$magicianObj2 = new imageLib($path);
				$magicianObj2->resizeImage($thumb_width, $thumb_height);
				$magicianObj2->saveImage($thumb_image, 100, $option = 2);
				$img_params = array('desk_image' => 'main_'.$filename, 'desk_thumb' => 'thumb_'.$filename);
				$update     = $objTypes->update("tbl_products_details", $img_params, "id = :id", $where);
			}
		}
		if(isset($_FILES['tab_image']['name']) && $_FILES['tab_image']['name'] != ""){
			$validatefiles 	= array("jpg", "bmp", "jpeg", "gif","JPG", "BMP", "JPEG", "GIF");
			$filetype 		= array('image/gif', 'image/jpeg', 'image/JPEG', 'image/GIF', 'image/bmp', 'image/BMP');
			$ext 	  		= pathinfo($_FILES['tab_image']['name'], PATHINFO_EXTENSION);
            $ext 	  		= strtolower($ext);
			$filename1 		= basename($_FILES['tab_image']['name'], $ext);
            $filename1   	= time().'.'.$ext;
			if($_FILES['tab_image']['size'] > 3097152){
				header("location:add_product.php?sysmsg=16&id=".$insert_id);
                exit();
            }
            if(in_array($ext, $validatefiles) == false){
                header("location:add_product.php?sysmsg=11&id=".$insert_id);
                exit();
            }
			if(in_array(strtolower($_FILES['tab_image']['type']), $filetype) == false ){
                header("location:add_product.php?sysmsg=11&id=".$insert_id);
                exit();
            }
			$where      = array(':id' => $insert_id);
			$imagename1	= $objTypes->fetchRow("SELECT tab_image, tab_thumb FROM tbl_products_details WHERE id = :id", $where);
			unlink("../uploads/product_images/medium/".str_replace('main_', '', $imagename1['tab_image']));		
			unlink("../uploads/product_images/medium/".$imagename1['tab_image']);
			unlink("../uploads/product_images/medium/".$imagename1['tab_thumb']);
			if(move_uploaded_file($_FILES['tab_image']['tmp_name'], "../uploads/product_images/medium/".$filename1)){
				$path1 		= "../uploads/product_images/medium/".$filename1;
				$main_image1 = "../uploads/product_images/medium/main_".$filename1;
				$magicianObj = new imageLib($path1);
				$magicianObj->saveImage($main_image1, 100);
				$thumb_image1 = "../uploads/product_images/medium/thumb_".$filename1;
				$thumb_width1 = "1000";
				$thumb_height1= "362";
				$magicianObj2 = new imageLib($path1);
				$magicianObj2->resizeImage($thumb_width1, $thumb_height1);
				$magicianObj2->saveImage($thumb_image1, 100 ,$option = 2);
				$img_params = array('tab_image' => 'main_'.$filename1, 'tab_thumb' => 'thumb_'.$filename1);
				$update     = $objTypes->update("tbl_products_details", $img_params, "id = :id", $where);
			}
		}
		#mobile image 
		if(isset($_FILES['mobile_image']['name']) && $_FILES['mobile_image']['name'] != ""){
			$validatefiles 	= array("jpg", "bmp", "jpeg", "gif","JPG", "BMP", "JPEG", "GIF");
			$filetype 		= array('image/gif', 'image/jpeg', 'image/JPEG', 'image/GIF', 'image/bmp', 'image/BMP');
			$ext 	  		= pathinfo($_FILES['mobile_image']['name'], PATHINFO_EXTENSION);
            $ext 	  		= strtolower($ext);
			$filename1 		= basename($_FILES['mobile_image']['name'], $ext);
            $filename1   	= time().'.'.$ext;
			if($_FILES['mobile_image']['size'] > 3097152){
				header("location:add_product.php?sysmsg=16&id=".$insert_id);
                exit();
            }
            if(in_array($ext, $validatefiles) == false){
                header("location:add_product.php?sysmsg=11&id=".$insert_id);
                exit();
            }
			if(in_array(strtolower($_FILES['mobile_image']['type']), $filetype) == false ){
                header("location:add_product.php?sysmsg=11&id=".$insert_id);
                exit();
            }
			$where      = array(':id' => $insert_id);
			$imagename1	= $objTypes->fetchRow("SELECT mobile_image, mobile_thumb FROM tbl_products_details WHERE id = :id", $where);
			unlink("../uploads/product_images/small/".str_replace('main_', '', $imagename1['mobile_image']));		
			unlink("../uploads/product_images/small/".$imagename1['mobile_image']);
			unlink("../uploads/product_images/small/".$imagename1['mobile_thumb']);
			if(move_uploaded_file($_FILES['mobile_image']['tmp_name'], "../uploads/product_images/small/".$filename1)){
				$path1 		= "../uploads/product_images/small/".$filename1;
				$main_image1 = "../uploads/product_images/small/main_".$filename1;
				$magicianObj = new imageLib($path1);
				$magicianObj->saveImage($main_image1, 100);
				$thumb_image1 = "../uploads/product_images/small/thumb_".$filename1;
				$thumb_width2 = "480";
				$thumb_height2= "174";
				$magicianObj2 = new imageLib($path1);
				$magicianObj2->resizeImage($thumb_width1, $thumb_height1);
				$magicianObj2->saveImage($thumb_image1, 100,$option = 2);
				$img_params = array('mobile_image' => 'main_'.$filename1, 'mobile_thumb' => 'thumb_'.$filename1);
				$update     = $objTypes->update("tbl_products_details", $img_params, "id = :id", $where);
			}
		}
	}
		header("location:list_product.php?sysmsg=14&pgNo=$pgNo");
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
	$update     = $objTypes->update("tbl_products_details", $params, "id = :id", $where);
	if($update){
		header("location:list_product.php?sysmsg=1001&pgNo=".$pgNo);
		exit();
	}
    else{
		header("location:list_product.php?sysmsg=4&pgNo=".$pgNo);
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
	$delete = $objTypes->update("tbl_products_details", $params, "id = :id", $where);
	if($delete){
		header("location:list_product.php?sysmsg=1002&pgNo=$pgNo");
		exit();
	}else{
		header("location:list_product.php?sysmsg=4&pgNo=$pgNo");
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
		header("location:list_product.php?sysmsg=8&pgNo=$pgNo");
		exit();
	}
	$Delete	= implode(',', $DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_products_details SET is_active = '1' WHERE id IN ($Delete)");
	if($update > 0){
		header("location:list_product.php?sysmsg=1012&pgNo=$pgNo");
		exit();
	}
    else{
		header("location:list_product.php?sysmsg=13&pgNo=$pgNo");
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
		header("location:list_product.php?sysmsg=9&pgNo=$pgNo");
		exit();
	}
    $Delete = implode(',',$DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_products_details SET is_active = '0' WHERE id IN ($Delete)");
	if($update > 0){
		header("location:list_product.php?sysmsg=1013&pgNo=$pgNo");
		exit();
	}
    else{
		header("location:list_product.php?sysmsg=14&pgNo=$pgNo");
		exit();
	}
}
#==== DELETE  ALL
if(($POST['action']=="deleteall") && ($_POST['DelCheckBox'] <> "")){
	$DelCheckBox	= $_POST['DelCheckBox'];
	$Result			= count($DelCheckBox);
	$title  = $_REQUEST['title'];
	if($Result == "0"){
		header("location:list_product.php?sysmsg=10");
		exit();
	}
	$Delete = implode(',',$DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_products_details SET is_delete = '0' WHERE id IN ($Delete)");
	if($update > 0){
		header("location:list_product.php?sysmsg=1014");
		exit();
	}
    else{
		header("location:list_product.php?sysmsg=4");
		exit();
	}
}