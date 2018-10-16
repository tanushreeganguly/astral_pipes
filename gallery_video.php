<?php
require_once("config/config.php");
$POST		= $objTypes->validateUserInput($_POST);
$last_data=$POST['last_data'];

$sqlimage=$objTypes->fetchAll("select title1,title2,location,id,image1,thumbnail1,youtube from tbl_adhesive where is_active=1 and type='video' and is_delete=1 order by id desc limit $last_data,6");
$img_video="";
if(count($sqlimage)>0){
	foreach($sqlimage as $image_list){					   
	$img_video.="<div class='galleryBlurb'>
		<div class='galleryImg'>
		<a id='".$image_list['id']."' href='http://www.youtube.com/watch?v=".stripslashes($image_list['youtube'])."' class='video_link'><img orgSrc='".base_url."uploads/astral_pipes_image/large/".$image_list['image1']."' src='".base_url."assets/images/loader-gallery.gif' alt='' class='loader_gif'>
		<img class='gal_img' src='".base_url."uploads/astral_pipes_image/large/".$image_list['image1']."' style='opacity: 1;'>
		<div class='video_play'><img src='".base_url."assets/images/play-btn.png' alt=''></div>
		</a></div><h3>".stripslashes($image_list['title1'])." ".stripslashes($image_list['title2'])."</h3>
	  </div>";  					
	}	   }
  echo $img_video;  
?>

<script type="text/javascript" src="<?=base_url?>assets/js/gallery.js"></script>
<script>
    $('.video_link').magnificPopup({
        type: 'iframe',
        closeOnBgClick: true,
        modal: true,
        gallery: {
            enabled: false
        }
    });
</script>

 
 