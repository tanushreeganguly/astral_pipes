<?php	include_once('config/config.php');	
$id		=	$_GET['id']; 
$sql 	=	"SELECT * from tbl_applications WHERE is_active = 1 and is_delete = 1 and id =".$id;
$row	=	$objTypes->fetchRow($sql); 
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
  <title>Astral Pipes</title>
  <meta name="description" content="<?=$row['meta_description']?>" />
  <meta name="keywords" content="<?=$row['meta_keyword']?>" />
  <link href="<?=base_url?>assets/images/favicon.ico" rel="shortcut icon" type="" />
  <link href="<?=base_url?>assets/css/main.css" rel="stylesheet" type="text/css">
</head>

<body>
  <?php include_once('include/othercode.php'); ?>
    <div id="wrapper">
     <?php include_once('include/header.php'); ?>
    <section id="breadcrumbs">
      <div class="container">
        <a href="<?=base_url?>">Home</a> Applications
      </div>
    </section>

    <section id="siteInner">
      <div class="container">
        <div class="sect_title inner_title">
          <h2>
            <span> <?php echo isset($row['title']) ? $row['title']: '' ?></span>
          </h2>
        <div class="tl_bg">Applications</div>
        </div>

        <div class="appUndergroundH">
           <div class="apdiscripH">
           <p><?php echo isset($row['short_description']) ? $row['short_description']: ''; ?></p>  
           </div>

           <ul class="applicgrL">  
			<?php 
			$prod_sql 	=	"SELECT * from  tbl_products_details WHERE app_id=$id and is_active=1 and is_delete=1 order by id desc";
			$prod_arr=	$objTypes->fetchAll($prod_sql);
			if(isset($prod_arr) && sizeof($prod_arr) > 0){
				foreach ($prod_arr as $prod_v){ ?>
				   <li>
						<a href="#">
						 <div class="appimgMid">
							<img src="<?=base_url?>uploads/product_images/logo/<?=$prod_v['logo']?>" alt="<?=$prod_v['title']?>"></div> 
							<h3><?=$prod_v['title']?></h3>  
					   </a>
				   </li> 
				<?php } } ?>
		   </ul>
        </div>
 </div>
 </section>
    <?php include_once('include/footer.php'); ?>
  </div>
  <?php include_once('include/js.php');?>
</body>

</html>