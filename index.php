<?php 
include_once('config/config.php');
$page=$objTypes->fetchRow('select meta_title,meta_description,meta_keywords from tbl_pages where id=12');
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
    <title><?=stripslashes($page['meta_title']);?></title>
	<meta name="description" content="<?=stripslashes($page['meta_description']);?>" />
	<meta name="keywords" content="<?=stripslashes($page['meta_keywords']);?>" />
    <meta property="og:type" content="website"/>
    <meta property="og:url" content=""/>
    <meta property="og:title" content="<?=stripslashes($page['meta_title']);?>"/>
    <meta property="og:image" content=""/>
    <meta property="og:description" content="<?=stripslashes($page['meta_description']);?>"/>
	<link href="<?=base_url?>assets/images/favicon.ico" rel="shortcut icon" type="" />
    <link href="<?=base_url?>assets/css/main.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url?>assets/css/owl.carousel.min.css" rel="stylesheet" type="text/css">  
</head>
<body class="home">
    <?php include_once('include/othercode.php'); ?>
    <div id="wrapper">
     <?php include_once('include/header.php'); ?>
        <!--Slider Start-->       
	<section id="slider_holder">
	<?php
        # home page banner
        $order			= 'id DESC';
        $where      	= array(":is_delete" => '1' , ":is_active" => '1');
        $banner_arr 	= $objTypes->select("tbl_homebanner", "*", "is_delete = :is_delete and is_active = :is_active ", $where, $order);
        if(isset($banner_arr) && sizeof($banner_arr) > 0){
          foreach ($banner_arr as $banner_value){
        ?>		
		 <div class="item">          
			<picture>
			  <source media="(max-width: 799px)" srcset="<?=base_url?>uploads/homebanner_images/small/<?php echo $banner_value['image2'];?>">
			  <source media="(max-width: 1023px)" srcset="<?=base_url?>uploads/homebanner_images/medium/<?php echo $banner_value['image1'];?>">
			  <img src="<?=base_url?>uploads/homebanner_images/large/<?php echo $banner_value['image'];?>" alt="<?php echo $banner_value['title1']?> <?php echo $banner_value['title2']?>">
			</picture>
			<div class="bannerDet">
			<?php if($banner_value['externalurl']!='') {?>             
				<div class="text_slide">
					<div class="overlay"></div>
					<span> <a href="<?php echo $banner_value['externalurl'];?>" class="knowMoreBtn" target="_blank">Know More</a></span>
				</div>
				 <?php }?>
			</div>
			<div class="parentscrollsec">
				<div class="scrollIndicator" scrollto="sect">
					<img src="<?=base_url?>assets/images/scroll-indicator.png" alt="Scroll to Explore">
				</div>
			</div>
		 </div>
		<?php } } ?>
	</section>           
     <!--Slider End-->
        <section id="application" class="sect">
            <div class="container">
             <h2>What Defines Astral</h2>
				<!--1-->
				<?php
				# home page banner
				$order			= 'sortorder ASC';
				$where      	= array(":is_delete" => '1' , ":is_active" => '1');
				$astral_arr 	= $objTypes->select("tbl_astral_defines", "*", "is_delete = :is_delete and is_active = :is_active ", $where, $order);
				$i = 1; 
				if(isset($astral_arr) && sizeof($astral_arr) > 0){
				  foreach ($astral_arr as $astral_val){ 
				?>	
                <div class="tilesCon">
					<div class="tiles">
					 <div class="cube">
						<div class="tile_front_face">
							<div class="front_tile_det">
								<?php if($i==1 || $i==3){ ?>
									<div class="firstrowImg"> 
									<div class="icon_con">
										<img src="<?=base_url?>uploads/astral_defines_images/<?=stripslashes($astral_val['image'])?>" alt="<?=$astral_val['title']?>">
									</div>
								</div> 								
								 <div class="firstrowText">
									 <div class="front_textH">
										 <div class="desc_con"><?=$astral_val['title']?></div>
											<div class="hovparacon">
												<p><?=stripslashes($astral_val['description'])?></p>
											</div>
									</div>
								</div>
								<?php } else { ?>
								 <div class="midtextcolumH">
								 <div class="front_textH">
									<div class="desc_con"><?=$astral_val['title']?></div>
									<div class="hovparacon">
										<p><?=stripslashes($astral_val['description'])?></p>
									</div>
								 </div>
								  </div>
								  <div class="bottomimgHov">
									<div class="icon_con">
										<img src="<?=base_url?>uploads/astral_defines_images/<?=stripslashes($astral_val['image'])?>" alt="<?=$astral_val['title']?>">
									</div>
								  </div>
								<?php } ?>
							</div>
						</div>
						<div class="tile_back_face tile_01_backface">
						   <div class="imageonMob"><img src="<?=base_url?>uploads/astral_defines_images/<?=stripslashes($astral_val['image'])?>" alt="hov-img"></div>
								<div class="exploe_con">
								<h3><?=$astral_val['title']?></h3>
								<p><?=stripslashes($astral_val['description'])?></p>
								<?php if($astral_val['externalurl']) { ?>
									<a href="<?=$astral_val['externalurl']?>" class="knowmoreBtn">Know more</a>
								<?php } ?>
							</div>                       
							<div class="clear"></div>
						</div>                        
				 </div>
					</div>
				</div>
				<?php $i++; } } ?>
			<!--for loop ends -->
			</div>
		</section>
		<div class="clear"></div>
        <section id="home_about">
            <div class="container">                
                    <h2>Applications</h2>         
                <div class="animiconH">
                    <div class="bottomiconHSec">
                        <a href="<?=base_url?>applications/plumbing-system-1">
                        <div class="animationbgcol1">
                            <div class="midimgsecH">						
								<img src="<?=base_url?>assets/images/anim-icon1.gif" alt="loading">
							</div>
                            <div class="texsectionbot">Plumbing
                                <br>System</div>
                        </div>
                        </a>
                    </div>
                    <div class="topiconHSec">
                        <a href="<?=base_url?>applications/industrial-application-7">
                        <div class="animationbgcol2">
                            <div class="TopimgsecH"><img src="<?=base_url?>assets/images/anim-icon2.gif"></div>
                            <div class="Toptexsectionbot">Industrial
                                <br>Applications</div>
                        </div>
                        </a>
                    </div>
                    <div class="bottomiconHSec">
                        <a href="<?=base_url?>applications/agriculture-piping-system-9">
                        <div class="animationbgcol3">
                            <div class="midimgsecH"><img src="<?=base_url?>assets/images/anim-icon3.gif"></div>
                            <div class="texsectionbot">Agriculture
                                <br>System</div>
                        </div>
                        </a>
                    </div>
                    <div class="topiconHSec">
                        <a href="<?=base_url?>applications/hauraton-surface-drainage-system-6">
                        <div class="animationbgcol4">
						    <div class="TopimgsecH"><img src="<?=base_url?>assets/images/anim-icon4.gif"></div>
                            <div class="Toptexsectionbot">Hauraton Surface
                                <br>Drainage System</div>
                        </div>
                        </a>
                    </div>
                    <div class="bottomiconHSec">
                        <a href="<?=base_url?>applications/sewerage-drainage-system-5">
                        <div class="animationbgcol5">
							<div class="midimgsecH"><img src="<?=base_url?>assets/images/anim-icon5.gif"></div>
								<div class="texsectionbot">Drainage
									<br>System</div>							
                        </div>
                        </a>
                    </div>
                    <div class="topiconHSec">
                        <a href="<?=base_url?>applications/fire-sprinkles-piping-system-2">
                        <div class="animationbgcol6">
							<div class="TopimgsecH"><img src="<?=base_url?>assets/images/anim-icon6.gif"></div>
                            <div class="Toptexsectionbot">Fire Sprinklers
                                <br>Piping System </div>
                        </div>
                        </a>
                    </div>
                    <div class="topiconHSec">
                        <a href="<?=base_url?>applications/insulation-11">
                        <div class="animationbgcol7">
                            <div class="TopimgsecH"><img src="<?=base_url?>assets/images/anim-icon7.gif"></div>
                            <div class="texsectionbot">Insulation</div>
                        </div>
                        </a>
                    </div>
                    <div class="topiconHSec">
                        <a href="<?=base_url?>applications/electrical-pipes-8">
                        <div class="animationbgcol8">
                            <div class="TopimgsecH"><img src="<?=base_url?>assets/images/anim-icon8.gif"></div>
                            <div class="Toptexsectionbot">Electrical
                                <br>System</div>
                        </div>
                        </a>
                    </div>
                </div>
            </div>
        </section>        
		<!-- benchmark section start -->
		<section id="benchmarkAnimH">
                 <div class="containerBench">                
                 <div class="animationparsecH">
					<h2>Setting Benchmarks</h2>
                 </div>
				 <div class="mainAnimpartH">               
					<!-- for mobile img start -->
					<div class="centerimgDesk centerimgMob">
						<img src="<?=base_url?>assets/images/ben-first.png">
					</div>
					<!-- for mobile img  ends -->
				   <ul class="bemarkColFirst">
					   <li id="bemark1">
					   <p>To introduce CPVC piping system in India in </p>
					   <h3>1999</h3>
					   </li>
					   <li id="bemark2">
					   <p>To introduce lead free uPVC plumbing piping system in India in</p>
					   <h3>2004</h3>
					   </li>
				   </ul>
					<!-- for desktop img start -->
					 <div class="centerimgDesk">
						<img src="<?=base_url?>assets/images/benchmarks/left.png" class="petals" id="benchLeft" >
						<img src="<?=base_url?>assets/images/benchmarks/one.png" id="benchOne">
						<img src="<?=base_url?>assets/images/benchmarks/right.png" class="petals" id="benchRight">
					 </div>
					 <!-- for desktop img ends -->
					 <ul class="bemarkColFirst">
						 <li id="bemark3">
						 <p>To get National Sanitation Foundation (NSF) certification in india in</p>
						 <h3>2007</h3>
						 </li>
						 <li id="bemark4">
						 <p>To launch lead free uPVC column pipes in India in </p>
						 <h3>2012</h3>
						 </li>
					 </ul> 
					</div>
					</div>
		</section>
		<section id="product">
            <div class="containerBench">                
				<h2>Key Product Range</h2>                
                <div class="productInner">
                    <div class="similar_products">
                        <div class="sect_title">
                        </div>
                        <div class="sm_prod_slider">
                             <?php 
							$prod_arr = $objTypes->fetchAll("SELECT a.*,a.title as a_title,p.title as p_title,p.id as pid,p.* FROM `tbl_applications` a left join tbl_products_details p on a.id=p.app_id where a.is_active=1 and a.is_delete=1 and p.is_active=1 and p.is_delete=1 limit 15");
							foreach($prod_arr as $prod_v) { ?>
								<a href="<?=base_url?>application-details/<?php echo $objTypes->prepare_url(stripslashes($prod_v['a_title']));?>-<?php echo $objTypes->prepare_url(stripslashes($prod_v['p_title']));?>-<?=$prod_v['pid']?>">
									<div class="sm_blurb">
										<div class="sm_thumb">
											<div class="sm_overlay"></div>
											<img src="<?=base_url?>uploads/product_images/large/<?php echo $prod_v['desk_image']; ?>" alt="<?=$prod_v['title']?>">
										</div>
										<div class="slidetextimgbothH">
											<img src="<?=base_url?>uploads/product_images/logo/<?php echo $prod_v['logo']; ?>" alt="<?=$prod_v['title']?>">
											<p><?php echo substr(stripslashes($prod_v['short_description']),0,150); ?>...</p>
										</div>                                   
									</div>
								</a>
							<?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="WhatsNewsecH">
            <div class="container">
                <div class="whatnewparentConH">
                <div class="astralimgconH">
                    <div class="astimgbot">
                        <img src="<?=base_url?>assets/images/astral-pipes.jpg" alt="">
                    </div>
                    <div class="whatnewheadingT">
                        <h3>What's new at Astral Pipes</h3>
                    </div>
                </div>
				<?php 
					$video_arr	=	$objTypes->fetchRow("SELECT * from tbl_whats_new where is_home=1 and type='video' and is_delete=1 and is_active=1 order by id desc limit 1"); 
					$video 		=	explode('=',$video_arr['youtube']);
				?>
                <div class="vidsecH">
                    <div class="videoHolder clearfix">
                        <div class="videoCon">
                            <iframe src="https://www.youtube.com/embed/<?=$video[1]?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen=""></iframe>
                            <div class="vidAllsec"><a href="<?=base_url?>gallery/video">View all Videos</a></div>
                        </div>
                    </div>
                </div>
                <div class="astvidTwitterH">
                    <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fastralpipes%2F&tabs=timeline&width=375&height=420&small_header=true&adapt_container_width=true&hide_cover=true&show_facepile=true" width="375" height="450" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
                </div>
                <div class="clearfix"></div>
                <div class="vidconleftpartH">
                    <div class="imgandconvidbothH">
                        <div class="samesectionboth">
                            <span><img src="<?=base_url?>assets/images/money-control.jpg" alt=""></span>
                            <h4>Last Updated : Nov 15, 2017 05:29 PM IST | Source: Moneycontrol.com</h4>
                            <h3>Astral gets women brigade to warn menfolk of social evils from open defecation</h3>
                            <p>Astral Pipes has come up with a social message on the subject through its latest film about Open Defecation. Astral Pipes has come up with a social message on the subject through its latest film about Open Defecation. </p>
                        </div>
                        <div class="samesectionboth">
                            <span><img src="<?=base_url?>assets/images/economics-times.jpg" alt=""></span>
                            <h4>Last Updated : Nov 15, 2017 05:29 PM IST | Source: Moneycontrol.com</h4>
                            <h3>Astral Pipes - The 'Sultan' of CPVC Pipes</h3>
                            <p>Astral Pipes, India's most trusted pipe brand, is proud to be associated with Yash Raj Films' latest venture Sultan. The film stars Bollywood superstar Salman Khan who is also the brand ambassador of Astral Pipes.
                            </p>
                        </div>
                    </div>
                </div>
				<?php 
					$img_arr	=	$objTypes->fetchRow("SELECT * from tbl_whats_new where is_home=1 and type='image' and is_delete=1 and is_active=1 order by id desc limit 1"); 
				?>
                <div class="vidconallimgsecH">
                    <div class="allimgsecionHR"><img src="<?=base_url?>uploads/whats_new_images/<?=$img_arr['image']?>" alt="<?=$img_arr['title'];?>"></div>
                    <a href="<?=base_url?>gallery">View All Images</a>
                </div>
				</div>
                <div class="clearfix"></div>
            </div>
        </section>
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
                      <a href="javascript:;">
						<img src="<?=base_url?>assets/images/astral-adh.png" alt="">
					  </a>
                    </li>
                    <li>
					  <a href="https://astralcpvc.co.ke/" target="_blank">
						<img src="<?=base_url?>assets/images/sub-astralpipes-kenya.png" alt="Astralpipes Kenya">
					  </a>
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
	<?php include_once('include/js.php');?>
    <script type="text/javascript" src="<?=base_url?>assets/js/owl.carousel-beta.js"></script>
    <script type="text/javascript" src="<?=base_url?>assets/js/jquery.counterup.min.js"></script>
    <script type="text/javascript" src="<?=base_url?>assets/js/product.js"></script>
    <script type="text/javascript" src="<?=base_url?>assets/js/home.js"></script>
	<script type="text/javascript" src="<?=base_url?>assets/js/waypoints.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('.scrollIndicator').bind('click', function() {
            $("html, body").animate({ scrollTop: ($('#application').offset().top - 80) }, { duration: 1200 });
        });
    });
    </script>
</body>
</html>