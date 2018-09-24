<?php	include_once('config/config.php');	?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
  <title>Astral Pipes</title>
  <meta name="description" content="" />    
  <meta name="keywords" content="" />
  <link href="<?=base_url?>assets/images/favicon.ico" rel="shortcut icon" type="" />
  <link href="<?=base_url?>assets/css/main.css" rel="stylesheet" type="text/css">
</head>
<body>
  <?php include_once('include/othercode.php'); ?>
    <div id="wrapper">
     <?php include_once('include/header.php'); ?>
    <section id="breadcrumbs">
      <div class="container">
        <a href="<?=base_url?>">Home</a> Clients
      </div>
    </section>
        <section id="siteInner">
        <div class="container">
          <div class="sect_title inner_title">
            <h2><span>Astral Poly Technik Clients</span></h2>
          <div class="tl_bg">Clients</div>
        </div>
		<div class="alltabsectionconH">
			<div class="centertabH">
				<ul class="tabs">
				<?php
				# Client category
				$order			= 'sortorder ASC';
				$where      	= array(":is_delete" => '1' , ":is_active" => '1');
				$cat_arr 	= $objTypes->select("tbl_client_category", "*", "is_delete = :is_delete and is_active = :is_active ", $where, $order);
				$i = 1; 
				if(isset($cat_arr) && sizeof($cat_arr) > 0){
				  foreach ($cat_arr as $cat_v){ 
				?>	
					<li class="client_cat<?=($i==1) ? ' active' : ''?>" id="<?=$cat_v['id']?>" rel="tab<?=$cat_v['id']?>"><?=$cat_v['title']?></li>
				<?php $i++; } }?>
				</ul>
				<div class="clear"></div>
			</div>
			<div class="tab_container">
			<?php
				# Clients 
				$clients_arr 	= $objTypes->FetchAll("SELECT c.*,cat.title as name,cat.image as image FROM `tbl_clients` c left join tbl_client_category cat on c.`client_cat_id` = cat.id where cat.is_active=1 and cat.is_delete=1");
				$i = 1; 
				if(isset($clients_arr) && sizeof($clients_arr) > 0){
				  foreach ($clients_arr as $clients_v){ 
				?>	
				<h3 class="d_active tab_drawer_heading" rel="tab<?=$i?>"><?=$clients_v['name']?></h3>
				<div id="tab<?=$clients_v['client_cat_id']?>" class="tab_content">
					<div class="allclientlistingH">
					  <div class="box_topimg">
						<?php if($clients_v['image'] !='') { ?>
							<img src="<?=base_url?>uploads/client_images/<?=$clients_v['image']?>" alt="<?=$clients_v['name']?>">
						<?php } ?>
						</div>
					  <div class="titlenameclist"><?=$clients_v['name']?></div>
					   <?=stripslashes($clients_v['description'])?>
					</div>
				</div>					  
				<?php $i++; } }?>
			  <!-- #tab--> 
			</div>
		</div>
		<!-- .tab_container -->
		</div>
		</section>
		<div class="clear"></div>    
      <?php include_once('include/footer.php'); ?>
  </div>
  <!--JS Files-->
  <?php include_once('include/js.php');?>
</body>
</html>