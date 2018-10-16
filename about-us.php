<?php	include_once('config/config.php');	
$sql_vision		=	$objTypes->fetchRow('select * from tbl_pages where id=2');
$sql_why		=	$objTypes->fetchRow('select description from tbl_pages where id=3');
$sql_manufacture=	$objTypes->fetchRow('select description from tbl_pages where id=4');
$sql_rnd		=	$objTypes->fetchRow('select description from tbl_pages where id=5');
$sql_milestone	=	$objTypes->fetchAll('select content,thumbnail1,year from tbl_milestone where is_active=1 and is_delete=1');
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
    <title><?=stripslashes($sql_vision['meta_title']);?></title>
	<meta name="description" content="<?=stripslashes($sql_vision['meta_description']);?>" />
	<meta name="keywords" content="<?=stripslashes($sql_vision['meta_keywords']);?>" />
    <link href="<?=base_url?>assets/images/favicon.ico" rel="shortcut icon" type="" />
    <link href="<?=base_url?>assets/css/main.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url?>assets/css/owl.carousel.min.css" rel="stylesheet" type="text/css">
	<?php include_once('include/googlecode.php'); ?>
</head>
<body class="home">
   <?php include_once('include/othercode.php'); ?>
    <div id="wrapper">
     <?php include_once('include/header.php'); ?>       
		<section id="aboutbanner">
		  <div class="mainaboutban">          
			<picture>
				<img src="<?=base_url?>assets/images/about-us-banner.jpg" alt="">
			</picture>
			<div class="aboutHeading"><h1>About <span>Us</span></h1></div>
		 </div>
      </section>           
     <!--Slider End-->
         <section id="vision">
           <div class="container">
               <div class="aboutList">
			     <div class="abouttopListnav">
                  <div class="iconresponsive"><p id="tab_text">Vision & Value</p><img src="assets/images/down-icon-img.png"></div>
                   <ul class="headerlistingsec">
                    <li class="tabLabel activemain" scrollto="#vision" value="Vision & Value">Vision & Value</li>
                    <li class="tabLabel" scrollto="#whyastralpipes" value="Why Astral Pipes">Why Astral Pipes</li>
                    <li class="tabLabel" scrollto="#milestoneH" value="Milestone">Milestone</li>
                    <li class="tabLabel" scrollto="#ourPlants" value="Our Manufacturing Plants">Our Manufacturing Plants</li>
                    <li class="tabLabel" scrollto="#Rdfacilities" value="R&D Facilites">R&D Facilites</li>
                    <li class="tabLabel" scrollto="#subsidiaries"  value="Group Companies">Group Companies</li>
                </ul>
              </div>			 
                <?php echo str_replace("assets",base_url."assets",stripslashes($sql_vision['description']));?>
			</div>
           </div>
       </section>
       <?php echo str_replace("assets",base_url."assets",stripslashes($sql_why['description']));?>
		<section id="milestoneH">
			<div class="container">
				<div class="sect_title inner_title">
				  <h2>
					<span>Milestone</span>
				  </h2>
				</div>
			<div class="testimonials">
			  <div class="row">
				<div class="col-sm-12">
				  <div id="customers-testimonials" class="owl-carousel">
					<?php
					  foreach($sql_milestone as $milestone){ ?>
						<div class="item">
						  <div class="shadow-effect">
							<img class="img-circle" src="<?=base_url?>uploads/milestone_image/<?php echo stripslashes($milestone['thumbnail1']);?>" alt="">
							<div class="testimonial-name"><?php echo stripslashes($milestone['year']);?></div>
							<p><?php echo stripslashes($milestone['content']);?> </p>
						  </div>
						</div>
				    <?php } ?>
				  </div>
				</div>
			  </div>
			</div>
			</div>
		</section>
<?php echo str_replace("assets",base_url."assets",stripslashes($sql_manufacture['description']));?>
<?php echo str_replace("assets",base_url."assets",stripslashes($sql_rnd['description']));?>
<div class="clear"></div>
        <!-- benchmark section start -->
        <section id="subsidiaries">
            <div class="container">
                <div class="sect_title">
                    <h2>Group Companies</h2>
                </div>
                <ul>
                      <li>
                      <a href="http://rexpoly.co.in/" target="_blank">
						<img src="<?=base_url?>assets/images/rex.png" alt="REX">
					  </a>
                    </li>
                    <li>
                       <a href="javascript:;"><img src="<?=base_url?>assets/images/astral-adh.png" alt=""></a>
                    </li>
                    <li>
                        <a href="https://astralcpvc.co.ke/" target="_blank">
						<img src="<?=base_url?>assets/images/sub-astralpipes-kenya.png" alt="Astralpipes Kenya"></a>
                    </li>
                    <li>
					  <a href="http://bond-it.co.uk/" target="_blank">
						<img src="<?=base_url?>assets/images/sub-bond-it.png" alt="Bond it">
					  </a>
                    </li>
                </ul>
            </div>
        </section>
       <?php include_once('include/footer.php'); ?>
    </div>
    <!--JS Files-->
    <?php include 'include/js.php' ?>
    <script type="text/javascript" src="<?=base_url?>assets/js/waypoints.js"></script>
    <script type="text/javascript" src="<?=base_url?>assets/js/owl.carousel-beta.js"></script>
    <script type="text/javascript" src="<?=base_url?>assets/js/product.js"></script>
	<script type="text/javascript" src="<?=base_url?>assets/js/about-us.js"></script>
	<script>
	$(document).ready(function(){
		$('.tabLabel').click(function(){
			var tab_value = $(this).attr('value');
			$("#tab_text").html(tab_value);
			$(".tabLabel").removeClass('activemain');
			$(this).addClass('activemain');
		});
	});
    $('.iconresponsive').bind('click', function(){
	   if($(this).hasClass('open')){
		$('.headerlistingsec').slideUp(300);
		TweenMax.to('.iconresponsive img',0.5, {rotation: 0, ease:Sine.easeInOut});
		$('.iconresponsive').removeClass('open');
	  }else{
		console.log('Open');
		$('.headerlistingsec').slideDown(300);
		TweenMax.to('.iconresponsive img',0.5, {rotation: -180, ease:Sine.easeInOut});
		$('.iconresponsive').addClass('open');
	  }
	}); 
	var winWidth = $(window).innerWidth();
	if (winWidth <= 900) { 
	  $('.headerlistingsec li').bind('click', function () { 
		$('.headerlistingsec').slideUp(300); 
		$('.iconresponsive').removeClass('open'); 
		TweenMax.to('.iconresponsive img', 0.5, { rotation: 0, ease: Sine.easeInOut }); 
	  }); 
	}
	</script> 
   <script>
	jQuery(document).ready(function($) {
                "use strict";
                //  TESTIMONIALS CAROUSEL HOOK
                $('#customers-testimonials').owlCarousel({
                    loop: true,
                    center: true,
                    items:3,
                    margin: 0,
                    autoplay: true,
                    dots:true,
                    autoplayTimeout:2000,
                    smartSpeed: 450,
                    responsive: {
                      0: {
                        items: 1
                      },
                      768: {
                        items: 2
                      },
                      1160: {
                        items:5
                      }
                    }
                });
            });
	</script>
</body>
</html>