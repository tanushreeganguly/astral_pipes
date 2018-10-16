<?php	include_once('config/config.php');
$sql 	=	"SELECT * from tbl_micro_category WHERE is_active = 1 and is_delete = 1 and id =1";
$row	=	$objTypes->fetchRow($sql); 
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
    <title>Entwässerung von HAURATON</title>
	<meta name="description" content="<?=stripslashes($row['meta_description'])?>" />
	<meta name="keywords" content="<?=stripslashes($row['meta_keywords'])?>" />
    <link href="<?=base_url?>assets/images/favicon.ico" rel="shortcut icon" type="" />
    <link href="<?=base_url?>assets/css/main.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url?>assets/css/owl.carousel.min.css" rel="stylesheet" type="text/css">
  <?php include_once('include/googlecode.php'); ?>
</head>

<body>
  <?php include_once('include/othercode.php'); ?>
    <div id="wrapper">
     <?php include_once('include/header.php'); ?>
        <!--Slider Start-->
     <section id="aboutbanner">
      <div class="mainaboutban">          
		<picture>
			<img src="<?=base_url?>uploads/micro_category_images/large/<?=$row['image']?>" alt="<?=stripslashes($row['title'])?>">
		</picture>
      </div>
      </section>           
     <!--Slider End-->
    <section id="hauratoninfo">
      <div class="container">
        <div class="inner_title">
          <h2>
            <span><img src="<?=base_url?>assets/images/hauraton/hauraton-logo.jpg"></span>
          </h2>
        </div>
	<div class="infoholer"><?=stripslashes($row['description'])?></div>
   </div>
    </section>  
    <section id="proinfoList">
      <div class="secondContainer">
         <div class="proHauTBlurb">
		 <?php 
			$prod_sql 	=	"SELECT * from   tbl_micro_product_category WHERE is_active=1 and is_delete=1 order by id desc";
			$prod_arr=	$objTypes->fetchAll($prod_sql);
			if(isset($prod_arr) && sizeof($prod_arr) > 0){
				foreach ($prod_arr as $prod_v){ ?>
           <ul class="colList1">
             <li>
             <div class="circleImgH"><img src="<?=base_url?>uploads/micro_product_category/<?=$prod_v['image']?>" alt="<?=stripslashes($prod_v['title'])?>"></div>  
             <div class="civilsListH">
             <h3><?=$prod_v['title']?></h3>  
			 <?php 
			$brand_sql 	=	"SELECT * from  tbl_micro_brand WHERE product_cat_id=".$prod_v['id']." and is_active=1 and is_delete=1 order by id desc";
			$brand_arr=	$objTypes->fetchAll($brand_sql);
			if(isset($brand_arr) && sizeof($brand_arr) > 0){
				foreach ($brand_arr as $brand_v){ ?>				
					<a href="<?=base_url?>hauraton-product/<?php echo $objTypes->prepare_url(stripslashes($brand_v['title']));?>-<?=$brand_v['id']?>"><?=$brand_v['title'];?></a>   
			<?php } } ?>				
             </div>
             </li>
           </ul>
			<?php } } ?>
			
         </div>
      </div>
    </section>  
        <?php include_once('include/footer.php'); ?>
    </div>
    <!--JS Files-->
	  <?php include_once('include/js.php');?>
    <script type="text/javascript" src="<?=base_url?>assets/js/waypoints.js"></script>
    <script type="text/javascript" src="<?=base_url?>assets/js/owl.carousel-beta.js"></script>
    <script type="text/javascript" src="<?=base_url?>assets/js/product.js"></script>
</body>
</html>