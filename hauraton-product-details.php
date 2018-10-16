<?php 
include_once('config/config.php'); 
$id			=	$_GET['id']; 
$sql 		=	"SELECT * from tbl_micro_product WHERE is_active = 1 and is_delete = 1 and id =".$id;
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
			<?php
			$brand_sql 	=	"SELECT * from  tbl_micro_brand WHERE id=".$row['brand_id']." and is_active=1 and is_delete=1 order by id desc";
			$brand_arr=	$objTypes->fetchRow($brand_sql);
			//print_r($brand_arr); 

			if(isset($brand_arr['desk_image']) &&  $brand_arr['desk_image'] != '') { ?>        
          <div class="centerhuraTimg"><img src="<?=base_url?>uploads/micro_brand/<?=$brand_arr['desk_image']?>"></div>
			<?php } ?>
			<?php if(isset($row['label']) && $row['label'] !='' ){ ?>
           <div class="inner_title">
			  <h2>
				<span><?php echo isset($row['label']) ? $row['label']: '' ?></span>
			  </h2>
		   </div>
			<?php } ?>
        </div>
      </section>
	  <?php 
		$combi_sql 	=	"SELECT * from tbl_micro_combi_article WHERE is_active=1 and is_delete=1 and product_id= ".$row['id']." order by sortorder asc";
		$combi_arr=	$objTypes->fetchAll($combi_sql);
		if(isset($combi_arr) && sizeof($combi_arr) > 0){
	  ?>				
		  <section id="combiArticle">
			<div class="container">
			  <div class="proarticleListH">
				<div class="inner_title">
				  <h2>
					<span>Combi article</span>
				  </h2>
				</div>			
				<div class="hauratonfaqCon">
				<?php foreach ($combi_arr as $combi_v){  ?>
				  <div class="bordersectiondiv">
					<div class="mypets"><?=$combi_v['title']?></div>
					<div class="thepet">
					  <div class="recyfixproimglist">
					   <?php 
						$article_sql 	=	"SELECT * from tbl_micro_combi_article_details WHERE is_active=1 and is_delete=1 and combi_article_id= ".$combi_v['id']." ";
						$article_arr=	$objTypes->fetchAll($article_sql);
						$j= 1;
						if(isset($article_arr) && sizeof($article_arr) > 0){
						foreach($article_arr as $article_v) {	
						$lastnoborder = ($j==sizeof($article_arr) ) ? 'lastnoborder' : '';
						
						?>
							<div class="recyfixstandard <?=$lastnoborder?>">
							  <a href="javascript:void(0);" class="lnkwallpaper combiarticle" id="<?=$article_v['id']?>">
								<img src="<?=base_url?>uploads/micro_combi_article/<?=$article_v['image']?>">
								<p><?=$article_v['title']?></p>
							  </a>
							</div>  
						<?php $j++; } } ?>					
					  </div>
					</div>
				  </div>
				<?php } ?>
				</div>
			  </div>
			</div>
		  </section>
		<?php }  ?>
	  
		<?php 
		$acces_sql 	=	"SELECT * from  tbl_micro_accessories WHERE is_active=1 and is_delete=1 and product_id= ".$row['id']." order by sortorder asc";
		$acces_arr	=	$objTypes->fetchAll($acces_sql);
		
		if(isset($acces_arr) && sizeof($acces_arr) > 0){
		?>
		<section id="Accessories">
        <div class="container">
          <div class="proarticleListH">
            <div class="inner_title">
              <h2>
                <span>Accessories</span>
              </h2>
            </div>
            <div class="hauratonfaqCon ">
			<?php foreach ($acces_arr as $acces_v){  ?>
			 <?php 
					$accessories_sql 	=	"SELECT * from tbl_micro_accessories_details WHERE is_active=1 and is_delete=1 and accessories_id= ".$acces_v['id']." ";
					$accessories_arr=	$objTypes->fetchAll($accessories_sql);
					if(isset($accessories_arr) && sizeof($accessories_arr) > 0){
					$i= 1; 
				?>
              <div class="bordersectiondiv">
			 
                <div class="mypets1"><?=$acces_v['title']?></div>
                <div class="thepets2">
                  <div class="recyfixproimglist" >
				  <?php
						foreach($accessories_arr as $accessories_v) {
						$lastnoborder = ($i==sizeof($accessories_arr) ) ? 'lastnoborder' : '';
						?>				  
						<div class="recyfixstandard <?=$lastnoborder?>" >
						  <a href="javascript:void(0);" class="lnkwallpaper accessories" id="<?=$accessories_v['id']?>">
							<img src="<?=base_url?>uploads/micro_accessories/<?=$accessories_v['image']?>">
							<p><?=$accessories_v['title']?></p>
						  </a>
						</div>
						<?php $i++;	 }  ?>
			
                  </div>
                </div>
			
              </div>
			  <?php } ?>
              <?php } ?>
			  <div class="clear"></div>           
			</div>
          </div>
        </div>
      </section>
		<?php } ?>
 <!-- popupdata start here -->
   <div class="overlay"></div>
   <div class="download-overlay">
   <div class="download-pop">
   <a href="javascript:void(0);" class="close"></a>
    <div class="leftsideimg"><img src="<?=base_url?>assets/images/application-details/pipes/small/pro1.jpg"alt=""></div>
     <div class="rightsideConD"> <h3>Brass FPT Coupling</h3></div> 
<div class="clear"></div>
 <div class="tableinfoH">
    <table>
    <thead>
        <tr>
            <th>Size </th>
            <th>Part No</th>
            <th>Standard Package</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>437 ML</td>
            <td>TIPS - 473</td>
            <td>12</td>
        </tr>
        <tr>
            <td>946 ML</td>
            <td>TIPS - 473</td>
            <td>12</td>
        </tr>
        <tr>
            <td>437 ML</td>
            <td>TIPS - 473</td>
            <td>12</td>
        </tr>
            <tr>
            <td>437 ML</td>
            <td>TIPS - 473</td>
            <td>12</td>
        </tr>
    </tbody>
</table>
</div>
<div class="clear"></div>
</div>
</div>
<!-- pop data end here -->
       <?php include_once 'include/footer.php'; ?>
	   </div>
    <!--JS Files-->
    <?php include_once 'include/js.php'; ?>
    <script type="text/javascript" src="<?=base_url?>assets/js/ddaccordion.js"></script>
	<script>
	$(".accessories").click(function(){
		var id= $(this).attr('id'); 
		$.ajax({
			type: 'POST',
			url: '<?=base_url?>ajax_get_accessories.php',
			data:  'id='+id,
			success:function(response){
				//console.log(response);
				if(response){
					$(".download-pop").html(response);
				}						
			}			
		});		
	});
	$(".combiarticle").click(function(){
		var id= $(this).attr('id'); 
		$.ajax({
			type: 'POST',
			url: '<?=base_url?>ajax_get_combi_article.php',
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
  })

  $(document).on("click",".close",function() {	
	$(".overlay").fadeOut(500);
	$(".download-overlay").fadeOut(500);
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
      })
     ddaccordion.init({
        headerclass: "mypets1", //Shared CSS class name of headers group
        contentclass: "thepets2", //Shared CSS class name of contents group
        collapseprev: true, //Collapse previous content (so only one open at any time)? true/false
        defaultexpanded: [0], //index of content(s) open by default [index1, index2, etc]
        animatedefault: false, //Should contents open by default be animated into view?
        persiststate: false, //persist state of opened contents within browser session?
        toggleclass: ["", "openpet2"], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
        togglehtml: ["none", "", ""], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
        animatespeed: "fast" //speed of animation: "fast", "normal", or "slow"
      })
    </script>
    <!--[if lt IE 9]>
        <script src="js/html5shiv.min.js"></script>
    <![endif]-->
  </body>
</html>