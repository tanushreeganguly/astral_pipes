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
	$pgNo 	= intval(base64_decode($_REQUEST['pgNo']));
	if($POST['home_image'] == 1){	
		$where = array(
				':type'          => 'video'
		);
		$update_blog = array(
				'is_home'   		=> 0
			);			
		$update     = $objTypes->update("tbl_adhesive", $update_blog,"type = :type",$where);
	}
	$params = array(
	    'title1'	=> $POST['title1'],
		'title2'	=> $POST['title2'],
		'location'	=> $POST['location'],
		'is_home'   => $POST['home_image'],
		'youtube'   => $POST['youtube'],
		'type'   => $POST['type'],
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
		$update 	= $objTypes->update("tbl_adhesive", $params, "id = :id", $where);
		if($update){
			$insert_id	= $id;
		}
	}
	else{
		$insert = $objTypes->insert("tbl_adhesive", $params);
		if($insert){
			$insert_id = $objTypes->lastInsertId();
		}
	}
	

	if($insert_id > 0){
		$counter = 0;
		
			
		
		if(isset($_FILES['image1']['name']) && $_FILES['image1']['name'] != ""){
			$validatefiles 	= array("jpg", "bmp", "jpeg", "gif","JPG", "BMP", "JPEG", "GIF");
			$filetype 		= array('image/gif', 'image/jpeg', 'image/JPEG', 'image/GIF', 'image/bmp', 'image/BMP');
			$ext 	  		= pathinfo($_FILES['image1']['name'], PATHINFO_EXTENSION);
            $ext 	  		= strtolower($ext);
			$filename1 		= basename($_FILES['image1']['name'], $ext);
            $filename1 		= time().'.'.$ext;

			if($_FILES['image1']['size'] > 3097152){
				header("location:add_video.php?sysmsg=16&id=".$insert_id);
                exit();
            }

            if(in_array($ext, $validatefiles) == false){
                header("location:add_video.php?sysmsg=11&id=".$insert_id);
                exit();
            }

			if(in_array(strtolower($_FILES['image1']['type']), $filetype) == false ){
                header("location:add_video.php?sysmsg=11&id=".$insert_id);
                exit();
            }

			$where      = array(':id' => $insert_id);
			$imagename1	= $objTypes->fetchRow("SELECT image1, thumbnail1 FROM tbl_adhesive WHERE id = :id", $where);
			unlink("../uploads/astral_pipes_image/large/".str_replace('main_', '', $imagename['image1']));		
			unlink("../uploads/astral_pipes_image/large/".$imagename1['image1']);
			unlink("../uploads/astral_pipes_image/large/".$imagename1['thumbnail1']);

			if(move_uploaded_file($_FILES['image1']['tmp_name'], "../uploads/astral_pipes_image/large/".$filename1))
			{
				$path1		= "../uploads/astral_pipes_image/large/".$filename1;
				$main_image11 = "../uploads/astral_pipes_image/large/main_".$filename1;
				$main_width11	= "355";
				$main_height11= "200";

				$magicianObj = new imageLib($path1);
				$magicianObj->resizeImage($main_width11, $main_height11);
				$magicianObj->saveImage($main_image11, 100);

				$thumb_image1 = "../uploads/astral_pipes_image/large/thumb_".$filename1;
				$thumb_width1 = "565";
				$thumb_height1= "416";

				$magicianObj2 = new imageLib($path1);
				$magicianObj2->resizeImage($thumb_width1, $thumb_height1);
				$magicianObj2->saveImage($thumb_image1, 100);

				$img_params = array('image1' => 'main_'.$filename1, 'thumbnail1' => 'thumb_'.$filename1);
				$update     = $objTypes->update("tbl_adhesive", $img_params, "id = :id", $where);
			}
			header("location:list_video.php?sysmsg=1000&id=".$insert_id);
			exit();
		}
		if($POST['store_image1']=="" || $POST['store_image']==""){
				
			header("location:list_video.php?sysmsg=3&pgNo=".$pgNo);
			
			exit();
		}else{
			if($filename1!="" ||$filename!=""){
				header("location:list_video.php?sysmsg=1000&pgNo=".$pgNo);
			}else{
				header("location:list_video.php?sysmsg=1001&pgNo=".$pgNo);
				exit();
			}
		}
	}	
}

#==== Image Removal
if(($_REQUEST['param']<>"") && ($_REQUEST['id'] <> "")){
	
    $id		 = intval($_REQUEST['id']);
    $prodid  = intval($_REQUEST['prodid']);
    $where 	 = array(":id" => $id);
    $pgNo 	 = intval(base64_decode($_REQUEST['pgNo']));

    $sql     = "SELECT image, thumb_image FROM tbl_gallery WHERE id = :id";
    $image   = $objTypes->fetchRow($sql, $where);
    unlink("../uploads/astral_pipes_image/small/".str_replace('main_', '', $image['image']));
	unlink("../uploads/astral_pipes_image/small/".$image['image']);
	unlink("../uploads/astral_pipes_image/small/".$image['thumb_image']);

    $delete  = $objTypes->delete("tbl_gallery", "id = :id", $where);
    if($delete){
        header("location:list_video.php?sysmsg=1018&pgNo=".$pgNo);
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

	$update     = $objTypes->update("tbl_adhesive", $params, "id = :id", $where);
	if($update){
		header("location:list_video.php?sysmsg=1001&pgNo=".$pgNo);
		exit();
	}
    else{
		header("location:list_video.php?sysmsg=4&pgNo=".$pgNo);
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
	$delete = $objTypes->update("tbl_adhesive", $params, "id = :id", $where);
	if($delete){
		header("location:list_video.php?sysmsg=1002&pgNo=$pgNo");
		exit();
	}else{
		header("location:list_video.php?sysmsg=4&pgNo=$pgNo");
		exit();
	}
}

#==== ACTIVE ALL
if(($POST['action']=="activeall") && ($_POST['DelCheckBox'] <> "")){
	$DelCheckBox	= $_POST['DelCheckBox'];
	$Result			= count($DelCheckBox);
	$pgNo 			= intval($_REQUEST['pgNo']);

	if($Result == "0"){
		header("location:list_video.php?sysmsg=8&pgNo=$pgNo");
		exit();
	}
	$Delete	= implode(',', $DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_adhesive SET is_active = '1' WHERE id IN ($Delete)");

	if($update > 0){
		header("location:list_video.php?sysmsg=1012&pgNo=$pgNo");
		exit();
	}
    else{
		header("location:list_video.php?sysmsg=13&pgNo=$pgNo");
		exit();
	}
}

#==== DEACTIVE ALL
if(($POST['action']=="deactiveall") && ($_POST['DelCheckBox'] <> "")){
	$DelCheckBox	= $_POST['DelCheckBox'];
	$Result			= count($DelCheckBox);
	$pgNo 			= intval($_REQUEST['pgNo']);

	if($Result == "0"){
		header("location:list_video.php?sysmsg=9&pgNo=$pgNo");
		exit();
	}
    $Delete = implode(',',$DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_adhesive SET is_active = '0' WHERE id IN ($Delete)");

	if($update > 0){
		header("location:list_video.php?sysmsg=1013&pgNo=$pgNo");
		exit();
	}
    else{
		header("location:list_video.php?sysmsg=14&pgNo=$pgNo");
		exit();
	}
}

#==== DELETE  ALL
if(($POST['action']=="deleteall") && ($_POST['DelCheckBox'] <> "")){
	$DelCheckBox	= $_POST['DelCheckBox'];
	$Result			= count($DelCheckBox);

	if($Result == "0"){
		header("location:list_video.php?sysmsg=10");
		exit();
	}
	$Delete = implode(',',$DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_adhesive SET is_delete = '0' WHERE id IN ($Delete)");

	if($update > 0){
		header("location:list_video.php?sysmsg=1014");
		exit();
	}
    else{
		header("location:list_video.php?sysmsg=4");
		exit();
	}
}
