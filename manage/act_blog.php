<?php
#=== Includes

require_once("../config/config.php");
require_once("verify_logins.php");

#==== Validations For Security
$POST		= $objTypes->validateUserInput($_POST);
$blog_id 		= isset($POST['id']) ? intval($POST['id']) : intval($_REQUEST['id']) ;
$ip			= $_SERVER['REMOTE_ADDR'];
$agent		= addslashes($_SERVER['HTTP_USER_AGENT']);

#==== ADD - UPDATE - INSERT 
if(($POST['SAVE']=="SAVE")){
	
	if($POST['home_blog'] == 1){	
		$update_blog = array(
				'home_blog'   		=> 0
			);			
		$update     = $objTypes->update("tbl_blog", $update_blog);
	}
	
	$session_time=time();
	$date=date("Y-m-d");
	$today = date("Y-m-d H:i:s"); 
	$added_date = date('d-m-Y');
	$date_var=explode("-",$added_date);
	$pgNo 	= intval(base64_decode($_REQUEST['pgNo']));
	$params = array(
		'blog_title'	    => $POST['title'],
		'blog_author_name' 	=> $POST['author_id'],
		'blog_short_desc'	=> $POST['short_description'],
		'blog_desc'			=> $_POST['description'],
        'prod_seo_desc'  	=> $POST['meta_description'],
        'prod_seo_keyword'  => $POST['meta_keywords'],
        'prod_seo_title'    => $POST['meta_title'],
		'ip'                => $ip,
        'agent'             => $agent,
		'fldyear'     		=> $date_var[2],
		'fldmonth'     		=>  $date_var[1],
		'blog_add_date'		=> $date,
		'blog_timestamp'    => $today,
		'fldUserid'			=>$_SESSION['SessAdminName'],
		'fld_add_time'      => $session_time,
		'is_active'			=>  1,
		'is_delete'			=>  1,
        'added_by'          => $_SESSION['SessAdminName'],
		'updated_by'        => $_SESSION['SessAdminName'],
		'blog_tag'          => $POST['tag'],
		'home_blog'         => $POST['home_blog']
	);
	if($blog_id > 0){
		$update_params = array(
	        'updated_date'		=> date("Y-m-d H:i:s"),
	        'updated_by'   		=> $_SESSION['SessAdminName'],
		);
		$params = array_merge($params, $update_params);
		 
		$where = array(
			':blog_id'          => $blog_id
		);
		$update 	= $objTypes->update("tbl_blog", $params, "blog_id = :blog_id", $where);

		if($update){
			$insert_id	= $blog_id;
		}
	}
	else{
		$insert = $objTypes->insert("tbl_blog", $params);
		if($insert){
			$insert_id = $objTypes->lastInsertId();
		}
	}
	
	if($insert_id > 0){
		
		$validatefiles 	= array("jpg", "bmp", "jpeg", "gif","JPG", "BMP", "JPEG", "GIF","png","PNG");
		$filetype 		= array('image/gif', 'image/jpeg','image/JPG','image/jpg', 'image/JPEG', 'image/GIF', 'image/bmp', 'image/BMP','image/png','image/PNG');
		if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != ""){
			$ext 	  		= pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $ext 	  		= strtolower($ext);
			$filename 		= basename($_FILES['image']['name'], $ext);
            $filename 		= time().'.'.$ext;

			if($_FILES['image']['size'] > 3097152){
				header("location:add_blog.php?sysmsg=16&id=".$insert_id);
                exit();
            }

            if(in_array($ext, $validatefiles) == false){
                header("location:add_blog.php?sysmsg=11&id=".$insert_id);
                exit();
            }

			if(in_array(strtolower($_FILES['image']['type']), $filetype) == false ){
                header("location:add_blog.php?sysmsg=11&id=".$insert_id);
                exit();
            }

			$where      = array(':blog_id' => $insert_id);
			/*$imagename	= $objTypes->fetchRow("SELECT image, thumbnail FROM tbl_truck_product_types WHERE id = :id", $where);
			unlink("../uploads/truck_images/product_types/".str_replace('main_', '', $imagename['image']));
			unlink("../uploads/truck_images/product_types/".$imagename['image']);
			unlink("../uploads/truck_images/product_types/".$imagename['thumbnail']);*/

			if(move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/blog/".$filename)){
				$path 		= "../uploads/blog/".$filename;
				$main_image = "../uploads/blog/main_".$filename;
				$main_width	= "545";
				$main_height= "367";

				$magicianObj = new imageLib($path);
				$magicianObj->resizeImage($main_width, $main_height);
				$magicianObj->saveImage($main_image, 100);

				$thumb_image = "../uploads/blog/thumb_".$filename;
				$thumb_width = "374";
				$thumb_height= "251";

				$magicianObj2 = new imageLib($path);
				$magicianObj2->resizeImage($thumb_width, $thumb_height);
				$magicianObj2->saveImage($thumb_image, 100);

				$img_params = array('blog_image' => 'main_'.$filename);
				$update     = $objTypes->update("tbl_blog", $img_params, "blog_id = :blog_id", $where);
			}
			else{
				header("location:add_blog.php?sysmsg=1003&id=".$insert_id);
				exit();
			}
		}
		
	}

	header("location:list_blog.php?sysmsg=1000&pgNo=".$pgNo);
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
	$where 		= array(":blog_id" => $id);

	$update     = $objTypes->update("tbl_blog", $params, "blog_id = :blog_id", $where);
	if($update){
		header("location:list_blog.php?sysmsg=1001&pgNo=$pgNo&title=$title");
		exit();
	}
    else{
		header("location:list_blog.php?sysmsg=4&pgNo=$pgNo&title=$title");
		exit();
	}
}

#==== DELETE
if(($_REQUEST['action']=="delete") && ($_REQUEST['id'] <> ""))
{
	$id		= intval($_REQUEST['id']);
	$pgNo 	= intval(base64_decode($_REQUEST['pgNo']));
	$title  = $_REQUEST['title'];
	$cat_type = $_REQUEST['cat_type'];
	$params	= array("is_delete" => '0');
	$where  = array(":blog_id" => $id);
	$delete = $objTypes->update("tbl_blog", $params, "blog_id = :blog_id", $where);
	if($delete){
		header("location:list_blog.php?sysmsg=1002&pgNo=$pgNo&title=$title");
		exit();
	}else{
		header("location:list_blog.php?sysmsg=4&pgNo=$pgNo&title=$title");
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
		header("location:list_blog.php?sysmsg=8&pgNo=$pgNo&title=$title");
		exit();
	}
	$Delete	= implode(',', $DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_blog SET is_active = '1' WHERE id IN ($Delete)");

	if($update > 0){
		header("location:list_blog.php?sysmsg=1012&pgNo=$pgNo&title=$title");
		exit();
	}
    else{
		header("location:list_blog.php?sysmsg=13&pgNo=$pgNo&title=$title");
		exit();
	}
}

#==== DEACTIVE ALL
if(($POST['action']=="deactiveall") && ($_POST['DelCheckBox'] <> "")){
	$DelCheckBox	= $_POST['DelCheckBox'];
	$Result			= count($DelCheckBox);
	$pgNo 			= intval($_REQUEST['pgNo']);
	$title  = $_REQUEST['title'];
	$cat_type = $_REQUEST['cat_type'];

	if($Result == "0"){
		header("location:list_blog.php?sysmsg=9&pgNo=$pgNo&title=$title");
		exit();
	}
    $Delete = implode(',',$DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_blog SET is_active = '0' WHERE id IN ($Delete)");

	if($update > 0){
		header("location:list_blog.php?sysmsg=1013&pgNo=$pgNo&title=$title");
		exit();
	}
    else{
		header("location:list_blog.php?sysmsg=14&pgNo=$pgNo&title=$title");
		exit();
	}
}

#==== DELETE  ALL
if(($POST['action']=="deleteall") && ($_POST['DelCheckBox'] <> "")){
	$DelCheckBox	= $_POST['DelCheckBox'];
	$Result			= count($DelCheckBox);
	$title  = $_REQUEST['title'];
	$cat_type = $_REQUEST['cat_type'];

	if($Result == "0"){
		header("location:list_blog.php?sysmsg=10");
		exit();
	}
	$Delete = implode(',',$DelCheckBox);
	$update = $objTypes->inquery("UPDATE tbl_blog SET is_delete = '0' WHERE id IN ($Delete)");

	if($update > 0){
		header("location:list_blog.php?sysmsg=1014&title=$title");
		exit();
	}
    else{
		header("location:list_blog.php?sysmsg=4&title=$title");
		exit();
	}
}
