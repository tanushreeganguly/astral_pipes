<?php include_once('config/config.php');
$POST   = $objTypes->validateUserInput($_REQUEST);
 ?>
<!doctype html>
<html>
  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
  <title>Astral Pipes | Search</title>
  <meta name="description" content="Astral Pipes is the leader in manufacturing the best quality PVC, UPVC and CPVC plumbing pipes for residential, commercial, industrial and agriculture applications" />    
  <meta name="keywords" content="pvc plumbing pipes, upvc pipes india, upvc plumbing pipes, cpvc pipes india, pvc plumbing fittings, pvc fittings" />
  <link href="<?=base_url?>assets/images/favicon.ico" rel="shortcut icon" type="" />
  <link href="<?=base_url?>assets/css/main.css" rel="stylesheet" type="text/css">
  <link href="<?=base_url?>assets/css/owl.carousel.min.css" rel="stylesheet" type="text/css">
  <link href="<?=base_url?>assets/css/direction-reveal.css" rel="stylesheet" type="text/css">
  </head>
  <body>
    <div id="wrapper">
     <?php include_once('include/header.php'); ?>
	  <section id="application">
        <div class="container searchData">
          <div class="sect_title">
            <h2><span>Search for '<?php echo stripslashes($POST['search_data']);?>'</span></h2>
          </div>
		<?php
		if($POST['search_data']!=""){
			$sql="select * from tbl_search where content like '%".$POST['search_data']."%' 
			or url like '%".$POST['search_data']."%' or title like '%".$POST['search_data']."%' or description like '%".$POST['search_data']."%'";
			$data = $objTypes->fetchAll($sql);
		 if(count($data)>0){
			foreach($data as $value){
			?>	
			  <div class="search_data">
			  <h3>
				<?php echo stripslashes(ucwords(strtolower($value['title'])));?>
			  </h3> 
					<p>
					<?php
						if($value['content']){
						echo substr(stripslashes($value['content']),0,250);?> <br/><br/>
				<?php } ?>
					<a href="<?=base_url.$value['url']?>"> Read More</a></p> </div> 
			  <p>&nbsp;</p>
			<?php
			}
		  }else{ ?>
			<div>No records found.</div>
		  <?php
		  }
		}else{?>
			<div>No records found.</div>
		  <?php
		  }
		  ?>
			</div>
		</section>
	<?php include_once('include/footer.php'); ?>
    </div>
    <!--JS Files-->
   <?php include_once 'include/js.php';?>
    <script type="text/javascript" src="<?=base_url?>assets/js/owl.carousel-beta.js"></script>
    <script type="text/javascript" src="<?=base_url?>assets/js/ScrollMagic.js"></script>
    <script type="text/javascript" src="<?=base_url?>assets/js/animation.gsap.js"></script>
    <script type="text/javascript" src="<?=base_url?>assets/js/debug.addIndicators.js"></script> 
    <script type="text/javascript" src="<?=base_url?>assets/js/about-us.js"></script>
  </body>
</html>