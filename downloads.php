<?php	include_once('config/config.php');	?>
<!doctype html>
<html>
  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
  <title><?=stripslashes($row['meta_title'])?></title>
  <meta name="description" content="<?=stripslashes($row['meta_description'])?>" />
  <meta name="keywords" content="<?=stripslashes($row['meta_keywords'])?>" />
  <link href="<?=base_url?>assets/images/favicon.ico" rel="shortcut icon" type="" />
  <link href="<?=base_url?>assets/css/magnific-popup.css" rel="stylesheet" type="text/css">
  <link href="<?=base_url?>assets/css/main.css" rel="stylesheet" type="text/css">
 <?php include_once('include/googlecode.php'); ?>
</head>
<body>
  <?php include_once('include/othercode.php'); ?>
    <div id="wrapper">
     <?php include_once('include/header.php'); ?>
    <section id="breadcrumbs">
      <div class="container">
        <a href="<?=base_url?>">Home</a> Newsletter &amp; Downloads
      </div>
    </section>
      <section id="gallery">
        <div class="container">
          <div class="sect_title inner_title">
            <h1><span>Newsletter &amp; Downloads</span></h1>
            <div class="tl_bg">Newsletter</div>
          </div>
        </div>
      </section>
        <section id="photovidGal">
          <div class="product_graystrip">
              <div class="res_specs_tl"><a href="javascript:;">Sections <img src="<?=base_url?>assets/images/arrow-selection.png" alt=""></a></div>
              <div class="specs_list">
                <span attr="photo" class="activeTab">PDF Downloads</span>
                <span attr="video">Newsletter</span>   
              </div>   
            </div>
          <div class="container">        
          <div class="productInner">            
            <div class="galleryCon" id="gallery_photo"> 
             <div class="faqCon appFarqcon">
			 
			 <?php 
			$app_sql = "SELECT * from  tbl_applications WHERE is_active=1 and is_delete=1 order by sortorder asc";
			$app_arr = $objTypes->fetchAll($app_sql);
			if(isset($app_arr) && sizeof($app_arr) > 0){
				foreach ($app_arr as $app_v){ ?>
				<?php 
				$prod_sql 	=	"SELECT * from  tbl_products_details WHERE app_id=".$app_v['id']." and is_active=1 and is_delete=1 order by id desc";
				$prod_arr=	$objTypes->fetchAll($prod_sql);
				if(isset($prod_arr) && sizeof($prod_arr) > 0){ ?>
            <div class="bordersectiondiv">
            <div class="mypets"><?=strtoupper($app_v['title'])?></div>
            <div class="thepet">
					<ul class="pdf_links">
					<?php foreach ($prod_arr as $prod_v){ 
						$download_path 	=	($prod_v['broucher'] != '') ? base_url."uploads/product_broucher/".$prod_v['broucher'] : '#';
						$download 		=	($prod_v['broucher'] != '') ? 'download' : '';
					?>
						<li><a <?=$download?> href="<?=$download_path?>"> <?=$prod_v['title']?></a></li>
					<?php } ?>
				   </ul>					
				</div>
            </div>
			<?php }  } ?>
			<?php }  ?>
          </div>
            </div>			
            <div class="galleryCon" id="gallery_video">
             <div class="faqCon appFarqcon">
             </div>
            </div>
          </div>
        </div>
      </section>
            <?php include_once('include/footer.php'); ?>
    </div>
    <!--JS Files-->
   <?php include_once('include/js.php'); ?>
   
    <script type="text/javascript" src="<?=base_url?>assets/js/jquery.magnific-popup.js"></script> 
    <script type="text/javascript" src="<?=base_url?>assets/js/gallery.js"></script>
    <script type="text/javascript" src="<?=base_url?>assets/js/ddaccordion.js"></script>
	<script type="text/javascript">
      //Initialize first demo:
      ddaccordion.init({
        headerclass: "mypets", //Shared CSS class name of headers group
        contentclass: "thepet", //Shared CSS class name of contents group
        collapseprev: true, //Collapse previous content (so only one open at any time)? true/false
        defaultexpanded: [0], //index of content(s) open by default [index1, index2, etc]
        animatedefault: false, //Should contents open by default be animated into view?
        persiststate: false, //persist state of opened contents within browser session?
        toggleclass: ["", "openpet"], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
        togglehtml: ["none", "", ""], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
        animatespeed: "fast" //speed of animation: "fast", "normal", or "slow"
      })
    </script>
  </body>
</html>