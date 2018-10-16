<?php 
include_once('config/config.php'); 
$page=$objTypes->fetchRow('select meta_title,meta_description,meta_keywords from tbl_pages where id=9');
$total_image=$objTypes->fetchall('select title1,title2,location,id,image1,thumbnail1 from tbl_adhesive where is_active=1 and type="image" and is_delete=1 order by id desc');
$totalimg=count($total_image);
$sqlimage=$objTypes->fetchall('select title1,title2,location,id,image1,thumbnail1 from tbl_adhesive where is_active=1 and type="image" and is_delete=1 order by id desc limit 0,6');
$totalvideo=$objTypes->fetchall('select title1,title2,location,image1,thumbnail1,youtube from tbl_adhesive where is_active=1 and type="video" and is_delete=1 order by id desc');
$total_video=count($totalvideo);
$sqlvideo=$objTypes->fetchall('select title1,title2,location,image1,thumbnail1,youtube from tbl_adhesive where is_active=1 and type="video" and is_delete=1 order by id desc limit 0,6');
if($_REQUEST['type']=='video')
{
	$typeClass = 'activeTab';
	$style_video="display:block";
	$style_image="display:none";
}
else
{
	$typeClassG = 'activeTab';
	$style_image="display:block";
	$style_video="display:none";
}

?>
<!doctype html>
<html>

  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
   <title><?=stripslashes($page['meta_title']);?></title>
  <meta name="description" content="<?=stripslashes($page['meta_description']);?>" />
  <meta name="keywords" content="<?=stripslashes($page['meta_keywords']);?>" />
  <link href="<?=base_url?>assets/images/favicon.ico" rel="shortcut icon" type="" />
  <link href="<?=base_url?>assets/css/magnific-popup.css" rel="stylesheet" type="text/css">
  <link href="<?=base_url?>assets/css/main.css" rel="stylesheet" type="text/css">
  
  </head>

  <body>
<?php include_once('include/othercode.php'); ?>
    <div id="wrapper">

   
  <?php include_once('include/header.php'); ?>
    <section id="breadcrumbs">
      <div class="container">
        <a href="<?=base_url?>">Home</a> Gallery
      </div>
    </section>


      <section id="gallery">
        <div class="container">
          <div class="sect_title inner_title">
            <h1><span>Gallery</span></h1>
            <div class="tl_bg">Gallery</div>
          </div>
        </div>
      </section>


        <section id="photovidGal">

 <div class="product_graystrip">
              <div class="res_specs_tl"><a href="javascript:;">Sections <img src="<?=base_url?>assets/images/arrow-selection.png" alt=""></a></div>
              <div class="specs_list">
                 <span attr="photo" class="<?=$typeClassG?>" >Photo Gallery</span>
                <span attr="video" class="<?=$typeClass?>">Video Gallery</span>   
                
                  
                
                
                
              </div>   
            </div>

          <div class="container">
        
          <div class="productInner">
           

            <div class="galleryCon" id="gallery_photo" style=" <?php echo $style_image;?>">
            
            <input type="hidden" name="count_image" id="count_image" value="<?php echo count($sqlimage);?>">
			<?php
			   $count_img=count($sqlimage);
			   if(count($sqlimage)>0){
				   foreach($sqlimage as $image_list){
					$image_gallery_list="";
					$sqlgallery=$objTypes->fetchAll('select thumb_image from tbl_gallery where event_id='.$image_list['id']); 
					$event_id=$image_list['id'];
					if(count($sqlgallery)>0){
						$image_array='';
						foreach($sqlgallery as $gallery){
						$image_array[]=base_url.'uploads/astral_pipes_image/small/'.$gallery['thumb_image'];
						
						};
					}
					
					$image_gallery_list=implode(',',$image_array);
					
					   
			?>
              <div class="galleryBlurb">
                  <div class="galleryImg">
                    <a id="<?php echo $image_list['id'];?>" data-links="<?php echo $image_gallery_list;?>" class="magnific-gallery">
                      
                       <img orgSrc="<?=base_url?>uploads/astral_pipes_image/large/<?php echo $image_list['image1']?>" src="<?=base_url?>assets/images/loader-gallery.gif" alt="" class="loader_gif">
                     
                      
                       
                    </a>
                    
                    <div class="overlayHover">
                        <div class="content-detailsHov">
                          <a href="#">VIEW MORE</a>
                        </div>  

                    </div>


                  </div>

                   <h3><?php echo stripslashes($image_list['title1'])." ".stripslashes($image_list['title2']); if($image_list['location']!=""){ echo ",".stripslashes($image_list['location']);}?></h3>
              </div>
              
               <?php 
						$image_gallery_list="";
				   }
			   }?>
               

			<div class="new_image" ></div>
              
               <?php
			   	if($totalimg>$count_img){
			   ?>
              <div class="loadMoreBtnCon" id="load_img">
                <a href="javascript:;" class="commanBtn" id="load_image">Load More</a>
              </div>
              <?php }?>
              
            </div>
            
            

            <div class="galleryCon" id="gallery_video" style=" <?php echo $style_video;?>">
            <input type="hidden" name="count_video" id="count_video" value="<?php echo count($sqlvideo);?>">
            <?php
				 $countvideo=count($sqlvideo);
			     if(count($sqlvideo)>0){
				   foreach($sqlvideo as $video_list){
				 ?>
                 
                
                  <div class="galleryBlurb">
                    <div class="galleryImg">
                       <a href="http://www.youtube.com/watch?v=<?php echo stripslashes($video_list['youtube']);?>" class="video_link">
                              <img orgSrc="<?=base_url?>uploads/astral_pipes_image/large/<?php echo stripslashes($video_list['image1']);?>" src="<?=base_url?>assets/images/loader-gallery.gif" alt="" class="loader_gif">
                          <div class="video_play"><img src="<?=base_url?>assets/images/play-btn.png" alt=""></div>
                        </a>
                    </div>
                    <h3><?php echo stripslashes($video_list['title1'])." ".stripslashes($video_list['title2']); if($video_list['location']!=""){ echo ",".stripslashes($video_list['location']);}?></h3>
                </div>
             
                	 <?php
					}
				 }?>
               <div class="new_video"></div>
               
                
               <?php 
               		if($total_video>$countvideo){
               ?>

                <div class="loadMoreBtnCon" id="loadvideo">
                  <a href="javascript:;" class="commanBtn"  id="load_video">Load More</a>
                </div>
                 <?php }?>
            </div>


            

          </div>

        </div>
      </section>
      
   
   <?php include_once('include/footer.php'); ?>


    </div>

    <!--JS Files-->    
    <?php include_once('include/js.php');?>
    <script type="text/javascript" src="<?=base_url?>assets/js/jquery.magnific-popup.js"></script> 
   <!-- <script type="text/javascript" src="<?=base_url?>assets/js/common.js"></script>-->
    <script type="text/javascript" src="<?=base_url?>assets/js/gallery.js"></script>
    <script type="text/javascript">
		$(document).ready(function(){
			//var data = window.location;
			//var arr = data.split('/');
			//var num=count(arr);
			//alert(num);
		});
		$('#load_image').on('click',function(){
			var total_image='<?php echo $totalimg;?>';
			var getUrl = window.location;
			var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
			var img_count=$('#count_image').val();
			var var2=6;
					$.ajax({
								type: "POST",
								data:{'last_data':img_count},
								url: baseUrl+'/gallery_image.php',
								success:function(response){
									//console.log(response);
									$(".new_image").append(response);
									//console.log(response);
									var sum = Number(img_count) + Number(var2);
									
									$('#count_image').val(sum);
									if(total_image<sum){
											$("#load_img").hide();
									}
								}

						});
			
		});
		$('#load_video').on('click',function(){
			var total_video='<?php echo $total_video;?>';
			var getUrl = window.location;
			var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
			var video_count=$('#count_video').val();
			var var2=6;
					$.ajax({
								type: "POST",
								data:{'last_data':video_count},
								url: baseUrl+'/gallery_video.php',
								success:function(response){
									//console.log(response);
									$(".new_video").html(response);
									
									var sum = Number(video_count) + Number(var2);
									$('#count_video').val(sum);
									if(total_video<sum)
									{
										$("#loadvideo").hide();
									}
								}
						});
			
		});
	</script>
    
    <!--[if lt IE 9]>
        <script src="js/html5shiv.min.js"></script>
    <![endif]-->
  </body>
</html>