<?php 
include_once('config/config.php');
$id 	= 	$_POST['id'] ? $_POST['id'] : '';
$sql	=	"select * from  tbl_micro_combi_article_details where is_active=1 and is_delete=1 and id= ".$id; 
$data 	= 	$objTypes->fetchRow($sql);
if(is_array($data)) { ?>
 <a href="javascript:void(0);" class="close"></a>  
	<div class="leftsideimg">
		<img src="<?=base_url?>uploads/micro_combi_article/<?=$data['image']?>" alt="<?=$data['title']?>">
	</div>
	<div class="rightsideConD">	
		<h3><?=$data['title']?></h3>
	</div> 
	<div class="clear"></div> 
	<div class="tableinfoH">
		<?=stripslashes($data['description'])?>
	</div>
	<div class="clear"></div>
 <?php  } ?>