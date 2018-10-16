<?php 
include_once('config/config.php'); 
$id			=	$_GET['id']; 
$sql 		=	"SELECT * from tbl_micro_brand WHERE is_active = 1 and is_delete = 1 and id =".$id;
$row		=	$objTypes->fetchRow($sql); 
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
  <link href="<?=base_url?>assets/css/magnific-popup.css" rel="stylesheet" type="text/css">
  <link href="<?=base_url?>assets/css/owl.carousel.min.css" rel="stylesheet" type="text/css">
  <?php include_once('include/googlecode.php'); ?>
</head>
<body>
  <?php include_once('include/othercode.php'); ?>
    <div id="wrapper">
     <?php include_once('include/header.php'); ?>
      <section id="breadcrumbs">
        <div class="container">
          <a href="<?=base_url?>hauraton">Home</a> <?php echo isset($row['title']) ? $row['title']: '' ?>
        </div>
      </section>
      <section id="siteInner">
        <div class="container">
          <div class="sect_title inner_title">
          <h1>
            <span><?php echo isset($row['title']) ? $row['title']: '' ?></span>
          </h1>
        </div>
         </div>
      </section>
      <section id="HuraTproimg">
        <div class="container">
          <div class="centerhuraTimg"><img src="<?=base_url?>uploads/micro_brand/<?=$row['desk_image']?>"></div>
        </div>
      </section>
	<section id="scrollNav">
	  <div class="container">
		<div class="nav_slik">
			<ul class="tabmenuslik">
			<li scrollto="#hauRaboutProduct"><a href="javascript:void()" class="tabLabel activeH" >About Product</a></li>  
			<li scrollto="#prodtabsmenuH"><a href="javascript:void()" class="tabLabel" value="Products">Products</a></li>
			<?php 
			$features_sql 	=	"SELECT * from  tbl_micro_features WHERE is_active=1 and is_delete=1 and brand_id= ".$row['id']." order by sortorder asc";
			$features_arr=	$objTypes->fetchAll($features_sql);
			if(isset($features_arr) && sizeof($features_arr) > 0){ ?>
				<li scrollto="#featuresandBen"><a href="javascript:void()" class="tabLabel" value="Features & Benefits">Features & Benefits</a></li>
			
			<?php } 
				$gallery_sql 	=	"SELECT * from   tbl_micro_gallery WHERE is_active=1 and is_delete=1 and brand_id= ".$row['id']." ";
			$gallery_arr=	$objTypes->fetchAll($gallery_sql);
			if(isset($gallery_arr) && sizeof($gallery_arr) > 0){ ?>
				<li scrollto="#proGal"><a href="javascript:void()" class="tabLabel" value="Gallery">Gallery</a></li>  
			<?php } ?>
			</ul>
	   </div>
	 </div>
	</section>
	<section id="hauRaboutProduct">
	   <div class="container">
		 <div class="aboutproductinfoM">
			<div class="abouheadinsecond"><h2><?=$row['label'];?></h2></div>       
			<div class="proimgmainprorecyfix"><img src="<?=base_url?>uploads/micro_brand/<?=$row['about_image']?>"></div>
			<div class="proRecyfixData">
			 <ul>
				<h3><?php echo isset($row['title']) ? $row['title']: '' ?></h3>
				<?=stripslashes($row['about'])?>
				<span id="readmore_data" style="display:none">
						<?php				
						echo isset($row['more_about']) ? stripslashes($row['more_about']) : '' ?>
				</span>
				<?php if(isset($row['more_about']) && $row['more_about'] !='') { ?>
						<div class="probuttonpostion" id="more_about">
							<a href="javascript:;" class="commanBtn" id="readmore">Read more</a>
						</div>
					<?php } ?>
			 </ul> 
			</div>
		 </div>
	   </div>
	</section>
  <section id="prodtabsmenuH">
	  <div class="container">
			<div class="sect_title inner_title"><h2><span>Products</span></h2></div>
		<div class="aboutproductinfoM">
		   <div class="pro_tabsBlurb">
		   <?php 
			$article_sql 	=	"SELECT * from tbl_micro_product WHERE is_active=1 and is_delete=1 and brand_id= ".$row['id']." ";
			$article_arr=	$objTypes->fetchAll($article_sql);
			$j= 1;
			if(isset($article_arr) && sizeof($article_arr) > 0){
			foreach($article_arr as $article_v) {	
			$nomarginlast = ($j==sizeof($article_arr) ) ? 'nomarginlast' : '';		
			?>
			<a href="<?=base_url?>hauraton/<?php echo $objTypes->prepare_url(stripslashes($article_v['title']));?>-<?=$article_v['id']?>" class="<?=$nomarginlast?>"><?=$article_v['title']?></a>
			<?php $j++; } } ?>
		  </div>
		  <?php if(isset($row['broucher']) && $row['broucher'] !='') { ?>
			<div class="download_brochure"><a href="<?php echo base_url?>uploads/micro_product_brouchers/<?php echo $row['broucher'];?>" download>Download BROCHURE</a></div>
		  <?php } ?>
		</div>
	  </div>
	</section>
	<?php 
		$acces_sql 	=	"SELECT * from  tbl_micro_design_scope WHERE is_active=1 and is_delete=1 and brand_id= ".$row['id']." order by id desc";
		$acces_arr	=	$objTypes->fetchAll($acces_sql);
		if(isset($acces_arr) && sizeof($acces_arr) > 0){
		?>
	<section id="newdiscover">
	  <div class="container">
		 <div class="sect_title inner_title"><h2><span>Discover new scope of design</span></h2></div>
			<div class="discoverBlurb">
			<?php foreach($acces_arr as $data){ ?>
				<div class="pro_left50">
				<div class="pro_leftimgsec"><img src="<?=base_url?>uploads/micro_design_scope/<?=$data['image'];?>"></div>
					<div class="protext_Right">
						<div class="pro_headingBlurb">
							<h3><?=stripslashes($data['title'])?></h3>
							<h3><?=stripslashes($data['title2'])?></h3>
							<?=stripslashes($data['short_description'])?>
							<?php if(isset($data['external_url']) && $data['external_url'] !='' ) {?>
								<a target="_blank" href="<?=$data['external_url']?>" class="commanBtn">Know More</a>
							<?php } ?>
						</div>
					</div>
				</div>
			<?php } ?>
			<div class="clear"></div>
			</div>
		</div>
	</section>
		<?php } ?>
<?php 
		
		if(isset($features_arr) && sizeof($features_arr) > 0){
	  ?>	
<section id="featuresandBen">
<div class="container">
   <div class="proarticleListH">
          <div class="inner_title">
          <h2>
          <span>Features & Benefits</span>
          </h2>
          </div>
       <div class="hauratonfaqCon">
	   <?php foreach ($features_arr as $features_v){  ?>
            <div class="bordersectiondiv">
            <div class="mypets"><?=$features_v['title']?></div>
            <div class="thepet">
             <p><?=$features_v['description']?></p>
             </div>
             </div>
             <?php } ?>
	   </div>
    </div>
  </div>
</section>
		<?php  } ?>
		<?php 
			if(isset($gallery_arr) && sizeof($gallery_arr) > 0){
		?>	
<section id="proGal">
   <div class="container">
	<div class="galleryproSlBlurb">
	<div class="inner_title gallery_heading"><h2><span>Gallery</span></h2></div>
		<div class="gallery-carousel popup-gallery">	
			<?php foreach($gallery_arr as $val){ ?>
			<div class="gallery-item">
			  <a href="<?=base_url?>uploads/micro_gallery/<?=$val['image']?>"  title="<?=$val['title']?>">
				<img src="<?=base_url?>uploads/micro_gallery/<?=$val['thumbnail']?>">
			  </a>
			</div>
			<?php } ?>
		</div> 
	</div>
   </div>
</section>
		<?php } ?>
       <?php include_once 'include/footer.php'; ?>
    </div>
    <!--JS Files-->
      <?php include_once 'include/js.php'; ?>
	<script type="text/javascript" src="<?=base_url?>assets/js/jquery.magnific-popup.js"></script> 
    <script type="text/javascript" src="<?=base_url?>assets/js/owl.carousel-beta.js"></script>
    <script type="text/javascript" src="<?=base_url?>assets/js/ddaccordion.js"></script>
	<script>
	$('.tabLabel').click(function(){
			var tab_value = $(this).attr('value');
			//$("#tab_text").html(tab_value);
			$(".tabLabel").removeClass('activeH');
			$(this).addClass('activeH');
		});
		
	 $(".lnkwallpaper").click(function(){
		$(".overlay").fadeIn(500);
		$(".download-overlay").fadeIn(500);
	  })
	  $(".close").click(function(){
		$(".overlay").fadeOut(500);
		$(".download-overlay").fadeOut(500);
	  });
	  $(document).on("click","#readmore",function() {	
			 $("#more_about").hide();
			 $("#readmore_data").css("display","block");
		  });
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
	  });
	</script>
	<script type="text/javascript">
	  $('.gallery-carousel').owlCarousel({
		nav:      true,
		//navText:  ['<img src="assets/images/hauraton/gal-prev.png">','<img src="assets/images/hauraton/gal-next.png">'],
		margin:   10,
		loop:     false,
		autoplay: true,
		responsive:{
				0:{
					items: 1
				},
				375:{
					items: 1
				},
				550:{
					items: 2
				},
				800:{
					items: 2
				},
				900:{
					items: 3
				},
		  1024:{
					items:3
				}
		}
	  });
	$('.popup-gallery').magnificPopup({
		delegate: '.owl-item:not(.cloned) a',
		type: 'image',
		removalDelay: 500, //delay removal by X to allow out-animation
		callbacks: {
		  beforeOpen: function() {
			// just a hack that adds mfp-anim class to markup 
			 this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
			 this.st.mainClass = this.st.el.attr('data-effect');
		  }
		},
		tLoading: 'Loading image #%curr%...',
		mainClass: 'mfp-img-mobile',
		gallery: {
		  enabled: true,
		  navigateByImgClick: true,
		  preload: [0,1] // Will preload 0 - before current, and 1 after the current image
		},
		image: {
		  tError: '<a href="%url%">The image #%curr%</a> could not be loaded.',
		  titleSrc: function(item) {
			return item.el.attr('title') + '<small></small>';
		  }
		}
	  });
	</script>
  <script type="text/javascript">
    var tabList = $('.nav_slik').find('li');
    tabList.each(function(){
        $(this).bind('click', function(){
            var scrollPos = $(this).attr('scrollTo');
            $("html, body").animate({ scrollTop:($(scrollPos).offset().top - 180) }, {duration:1200});
        });
    });
  </script>
  </body>
</html>