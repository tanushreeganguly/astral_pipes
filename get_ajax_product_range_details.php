<?php 
include_once('config/config.php');
$id 	= 	$_POST['id'] ? $_POST['id'] : '';
$sql	=	"select * from  tbl_product_range where is_active=1 and is_delete=1 and id= ".$id; 
$data 	= 	$objTypes->fetchRow($sql);
if(is_array($data)) { ?>
 <a href="#" class="close"></a>  
	<div class="leftsideimg">
		<img src="<?=base_url?>uploads/product_range_images/<?=$data['image']?>" alt="<?=$data['title']?>">
	</div>
	<div class="rightsideConD">	
		<h3><?=$data['product_name']?></h3>
	</div> 
	<div class="clear"></div> 
	<div class="tableinfoH">
		<?=stripslashes($data['description'])?>
	</div>
	<div class="clear"></div>
 <?php  } ?>