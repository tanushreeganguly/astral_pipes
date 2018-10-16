<?php 
include_once('config/config.php'); 
$id			=	$_GET['id']; 
$sql_prod 	=	"SELECT * from tbl_products_details WHERE is_active = 1 and is_delete = 1 and id =".$id;
$row		=	$objTypes->fetchRow($sql_prod); 
$app_sql 	= 	"select *  from tbl_applications where id=".$row['app_id'];
$app_row	= 	$objTypes->fetchRow($app_sql);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
<title><?=stripslashes($row['meta_title'])?></title>
<meta name="description" content="<?=stripslashes($row['meta_description'])?>" />
<meta name="keywords" content="<?=stripslashes($row['meta_keywords'])?>" />
<link href="<?=base_url?>assets/images/favicon.ico" rel="shortcut icon" type="" />
<link href="<?=base_url?>assets/css/main.css" rel="stylesheet" type="text/css">
<?php include_once('include/googlecode.php'); ?>
</head>
<body>
  <?php include_once('include/othercode.php'); ?>
	<div id="wrapper">
	 <?php include_once('include/header.php'); ?>
	  <section id="breadcrumbs">
		<div class="container">
		  <a href="<?=base_url?>">Home</a> <a href="<?=base_url?>applications/<?php echo $objTypes->prepare_url(stripslashes($app_row['title']));?>-<?php echo $app_row['id']?>"> <?php echo isset($app_row['title']) ? ucwords(strtolower($app_row['title'])) : '' ?></a><?php echo isset($row['title']) ? ucwords(strtolower($row['title'])) : '' ?></span>
		</div>
	  </section>      
	  
	  <section id="siteInner">
		<div class="container">
		  <div class="sect_title inner_title">
		  <h1>
			<span><?php echo isset($row['title']) ? $row['title'] : '' ?></span>
		  </h1>
			<div class="tl_bg"><?php echo isset($row['short_code']) ? $row['short_code']: '' ?></div>
		 </div>        
		 </div>
	  </section>      
	  
	  <section id="appDetailinfo">
		<div class="container">
		  <div class="about-proinfoH">	
			<div class='tableinfoH'>
				<?php 
					$short_description = str_replace("<table","<div class='tableinfoH'><table",stripslashes($row['short_description']));
					$short_description = str_replace("</table>","</table></div>",$short_description);
				    echo isset($row['short_description']) ? stripslashes($short_description) : '' ?>
					<span id="readmore_data" style="display:none">
						<?php
						$description = str_replace("<table","<div class='tableinfoH'><table",stripslashes($row['description']));
						$description = str_replace("</table>","</table></div>",$description);					
						echo isset($row['description']) ? stripslashes($description) : '' ?>
					</span>
					<?php if(isset($row['description']) && $row['description'] !='') { ?>
						<div class="centerbuttonCom" id="read_more">
							<a href="javascript:;" class="commanBtn" id="readmore">Read more</a>
						</div>
					<?php } ?>
			</div>
		  </div>
		</div> 
	</section>
	<?php   
	$pipes_sql_main =	"SELECT * from tbl_product_range WHERE is_active = 1 and is_delete = 1 and product_id =".$row['id']; 
	$pipes_row_main	=	$objTypes->fetchAll($pipes_sql_main);
	if(isset($pipes_row_main) && sizeof($pipes_row_main) > 0){ ?>						
		<section id="proDet">
		   <div class="container">
			  <div class="sect_title inner_title">
				  <h2>
					<span>Product Details</span>
				  </h2>
				</div> 
		   </div> 
		</section>    
	<?php } ?>
	  
	<!-- popupdata start here -->
	<div class="overlay"></div>
	<div class="download-overlay">
	   <div class="download-pop">
	   </div>
	</div>
	<!-- pop data end here -->
	<?php   
	$pipes_sql_main 	=	"SELECT * from tbl_product_range WHERE is_active = 1 and is_delete = 1 and product_id =".$row['id']; 
	$pipes_row_main	=	$objTypes->fetchAll($pipes_sql_main);
	if(isset($pipes_row_main) && sizeof($pipes_row_main) > 0){ ?>
	<section id="appgallerydetails">
		<div class="container">        
		<div class="tabGal">            
			<div class="centertabHgalapp">
				<ul class="tabsAppH">
				<?php   
					$pipes_sql 	=	"SELECT * from tbl_product_range WHERE is_active = 1 and is_delete = 1 and product_cat_id = 1 and product_id =".$row['id']; 
					$pipes_row	=	$objTypes->fetchAll($pipes_sql);
					if(isset($pipes_row) && sizeof($pipes_row) > 0){ ?>
				  <li class="active" rel="tab1">Pipes</li>
				   <?php } ?>
				   <?php   
						$fittings_sql 	=	"SELECT * from tbl_product_range WHERE is_active = 1 and is_delete = 1 and product_cat_id = 2 and product_id =".$row['id']; 
						$fittings_row	=	$objTypes->fetchAll($fittings_sql);
						if(isset($fittings_row) && sizeof($fittings_row) > 0){ ?>
				  <li rel="tab2" class="">Fittings</li>
						<?php } ?>
						<?php   
						$adhesive_sql 	=	"SELECT * from tbl_product_range WHERE is_active = 1 and is_delete = 1 and product_cat_id = 3 and product_id =".$row['id']; 
						$adhesive_row	=	$objTypes->fetchAll($adhesive_sql);
						if(isset($adhesive_row) && sizeof($adhesive_row) > 0){ ?>
				  <li rel="tab3" class="">Adhesives</li>	
						<?php } ?>				  
				</ul>
			<div class="clear"></div>
			</div> 
			<div class="scrollbar" id="Blueschollid">
				<div class="force-overflow">
				  <div class="tab_containergalappsec">
				   <?php   
						$pipes_sql 	=	"SELECT * from tbl_product_range WHERE is_active = 1 and is_delete = 1 and product_cat_id = 1 and product_id =".$row['id']; 
						$pipes_row	=	$objTypes->fetchAll($pipes_sql);
						if(isset($pipes_row) && sizeof($pipes_row) > 0){ ?>
					<h3 class="d_active tab_drawer_headingAppDH" rel="tab1">Pipes</h3>
					<div id="tab1" class="tab_contentApp">
				  <?php
						foreach ($pipes_row as $pipes_val){ ?>		
						<div class="photoGalleryH">
						 <div class="col-33">
							<a href="javascript:;" class="lnkwallpaper">
							<div class="thumb">
								<img src="<?=base_url?>uploads/product_range_images/<?=$pipes_val['image']?>" alt="<?=stripslashes($pipes_val['product_name']);?>"/>
									<span class="desc" id="<?php echo $pipes_val['id'];?>"></span>
							</div>
							</a>
						</div>
						</div>
						<?php } ?>						
						<div class="clear"></div>
						</div>
						<?php }   ?>
					</div>
				  <!-- #tab1 -->
			 <?php   
					$fittings_sql 	=	"SELECT * from tbl_product_range WHERE is_active = 1 and is_delete = 1 and product_cat_id = 2 and product_id =".$row['id']; 
					$fittings_row	=	$objTypes->fetchAll($fittings_sql);
					if(isset($fittings_row) && sizeof($fittings_row) > 0){ ?>
				  <h3 class="tab_drawer_headingAppDH" rel="tab2">Pipes</h3>
				  <div id="tab2" class="tab_contentApp">				  
					<?php 
					foreach ($fittings_row as $fittings_val){ ?>		
					<div class="photoGalleryH">
						 <div class="col-33">
							<a href="javascript:;" class="lnkwallpaper">
							<div class="thumb">
								<img src="<?=base_url?>uploads/product_range_images/<?=$fittings_val['image']?>"  alt="<?=stripslashes($fittings_val['product_name']);?>" />
								<span class="desc" id="<?php echo $fittings_val['id'];?>"></span>
							</div>
							</a>
						</div>
					</div>
					<?php }   ?>					
				  </div><?php } ?>
				  
				  <!-- #tab2 -->
				  
				  <h3 class="tab_drawer_headingAppDH" rel="tab3">Pipes</h3>
				  <div id="tab3" class="tab_contentApp">
					 <?php   
						$adhesive_sql 	=	"SELECT * from tbl_product_range WHERE is_active = 1 and is_delete = 1 and product_cat_id = 3 and product_id =".$row['id']; 
						$adhesive_row	=	$objTypes->fetchAll($adhesive_sql);
						if(isset($adhesive_row) && sizeof($adhesive_row) > 0){
							foreach ($adhesive_row as $adhesive_val){ ?>		
							<div class="photoGalleryH">
								 <div class="col-33">
									<a href="javascript:;" class="lnkwallpaper">
									<div class="thumb">
										<img src="<?=base_url?>uploads/product_range_images/<?=$adhesive_val['image']?>"  alt="<?=stripslashes($adhesive_val['product_name']);?>" /><span  class="desc" id="<?php echo $adhesive_val['id'];?>"></span>
									</div>
									</a>
								</div>
							</div>
						<?php }  } ?>
				  </div>
				  <!-- #tab3 --> 
				</div>
			</div>
		</div>
		
		</div>
	</section>  
	<?php  } //tab show ends ?>	
		<?php 
		$sql_feat =	"SELECT * from tbl_features WHERE is_active = 1 and is_delete = 1 and product_id =".$row['id']." order by sortorder asc " ; 
		$row_feat =	$objTypes->fetchAll($sql_feat);
		if(isset($row_feat) && sizeof($row_feat) > 0){ ?>	
		  <section id="siteInner">
			<div class="container">				
				<div class="sect_title inner_title">
				  <h2><span>Features & Benefits</span></h2>
				</div>
				<div class="faqCon appFarqcon">
				<!--Start-->
				<?php 
				foreach ($row_feat as $feat_val){ ?>									
					<div class="bordersectiondiv">
						<div class="mypets"><?=stripslashes($feat_val['title'])?></div>
						<div class="thepet"><?=stripslashes($feat_val['description'])?></div>
					</div>
				<?php }  ?>
				 <!--End-->			
				</div>				
			</div>
		  </section>
		<?php } ?>
	<section id="techincalDet">
		<div class="container"> 
	<?php if($row['technical_details'] !='') { ?>		
			<div class="sect_title inner_title">
			  <h2>
				<span>Technical Details</span>
			  </h2>
			</div> 
			<div class="about-proinfoH">
				<div class='tableinfoH'>
				 <?php 
					$technical_details = str_replace("<table","<div class='tableinfoH'><table",stripslashes($row['technical_details']));
					$technical_details = str_replace("</table>","</table></div>",$technical_details);
				 ?>
					<?=stripslashes($technical_details)?>
					<span id="techmore_data" style="display:none">
					<?php
					$long_technical_details = str_replace("<table","<div class='tableinfoH'><table",stripslashes($row['long_technical_details']));
					$long_technical_details = str_replace("</table>","</table></div>",$long_technical_details);
					echo isset($row['long_technical_details']) ? $long_technical_details : '' ?>
					</span>
					<?php if(isset($row['long_technical_details']) && $row['long_technical_details'] !='') { ?>
						<div class="centerbuttonCom" id="tech_more">
						<a href="javascript:;" class="commanBtn" id="techmore">Read more</a>
						</div>
					<?php } ?>
					</div>
			 </div>
			 <?php } ?>
		<?php if(isset($row['broucher']) && $row['broucher'] !='') { ?>
			<div class="dwonloadcatL">Download Catalogue</div>
			<div class="centerbuttonCom"><a download target="_blank" href="<?=base_url?>uploads/product_broucher/<?=$row['broucher']?>" class="commanBtn">Download Catalogue</a></div>
		<?php } ?>
		</div>
	</section>              
	<?php if($row['additional_details'] != '') { ?>
	<section id="techincalDet">
			<div class="container">        
				<div class="sect_title inner_title">
				  <h2>
					<span>Additional Details</span>
				  </h2>
				</div> 
				<div class="about-proinfoH">
					 <div class="tableinfoH">
						<?=stripslashes($row['additional_details'])?>					
					 </div>
				 </div>
			</div>
		</section>    
	<?php } ?>
	
	<?php include_once('include/footer.php'); ?>
	</div>
<!--JS Files-->
  <?php include_once('include/js.php');?>
<script type="text/javascript" src="<?=base_url?>assets/js/ddaccordion.js"></script>	
<script>
	$(".desc").click(function(){
		var id= $(this).attr('id'); 
		$.ajax({
			type: 'POST',
			url: '<?=base_url?>get_ajax_product_range_details.php',
			data:  'id='+id,
			success:function(response){
				//console.log(response);
				if(response){
					$(".download-pop").html(response);
				}						
			}			
		});		
	});
$(".lnkwallpaper").click(function(){   	
	$(".overlay").fadeIn(500);
	$(".download-overlay").fadeIn(500);
  });
  
$(document).on("click",".close",function() {	
	$(".overlay").fadeOut(500);
	$(".download-overlay").fadeOut(500);
  });
  
	$(document).on("click","#readmore",function() {	
		 $("#read_more").hide();
		 $("#readmore_data").css("display","block");
		 /*$("#readmore").text("Read less");
		 $("#readmore").attr("id","readless");*/
	  });
	  
	 /* $(document).on("click","#readless",function() {	
		 console.log('readless');			 
		 $("#readless").text("Read more");
		 $("#readless").attr("id","readmore");
		 $("#readmore_data").css("display","none");
	  });*/
	  
	  $(document).on("click","#techmore",function() {
		 $("#techmore_data").css("display","block");
		 $("#tech_more").hide();			
	  });
</script>
<script type="text/javascript">
	$(".tab_contentApp").hide();
	$(".tab_contentApp:first").show();
  /* if in tab mode */
	$("ul.tabsAppH li").click(function() {
		
	  $(".tab_contentApp").hide();
	  var activeTab = $(this).attr("rel"); 
	  $("#"+activeTab).fadeIn();        
		
	  $("ul.tabsAppH li").removeClass("active");
	  $(this).addClass("active");
	  $(".tab_drawer_heading").removeClass("d_active");
	  $(".tab_drawer_heading[rel^='"+activeTab+"']").addClass("d_active");
	  
	});
	/* if in drawer mode */
	$(".tab_drawer_headingAppDH").click(function() {
	  
	  $(".tab_contentApp").hide();
	  var d_activeTab = $(this).attr("rel"); 
	  $("#"+d_activeTab).fadeIn();
	  
	  $(".tab_drawer_headingAppDH").removeClass("d_active");
	  $(this).addClass("d_active");
	  
	  $("ul.tabsAppH li").removeClass("active");
	  $("ul.tabsAppH li[rel^='"+d_activeTab+"']").addClass("active");
	});
	
	/* Extra class "tab_last" 
	   to add border to right side
	   of last tab */
	$('ul.tabs li').last().addClass("tab_last");
</script>
	
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