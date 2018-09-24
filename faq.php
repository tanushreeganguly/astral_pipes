<?php include_once('config/config.php'); ?>
<!doctype html>
<html>
  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
  <title>Astral Pipes</title>
  <link href="<?=base_url?>assets/images/favicon.ico" rel="shortcut icon" type="" />
  <link href="<?=base_url?>assets/css/main.css" rel="stylesheet" type="text/css">
  </head>
  
  <body>
    <?php include_once('include/othercode.php'); ?>
    <div id="wrapper">
     <?php include_once('include/header.php'); ?>
	 <div class="gutter"></div>
      <section id="breadcrumbs">
        <div class="container">
          <a href="<?=base_url;?>">Home</a> FAQs
        </div>
      </section>

      <section id="siteInner">
        <div class="container">
          <div class="sect_title inner_title">
          <h2>
            <span>FAQs</span>
          </h2>
		<div class="tl_bg">FAQs</div>
        </div>
          <div class="faqCon">
		  <?php
			  $order	= 'id DESC';
			  $where    = array(":is_delete" => '1' , ":is_active" => '1');
			  $faq_arr 	= $objTypes->select("tbl_faq", "*", "is_delete = :is_delete and is_active = :is_active ", $where,$order);			
				if(isset($faq_arr) && sizeof($faq_arr) > 0){ ?>
			   <div class="bordersectiondiv">
			    <?php	foreach($faq_arr as $faq_val){	?>            
					<div class="mypets"><?php echo stripslashes($faq_val['title']);?></div>
					<div class="thepet"><?php echo stripslashes($faq_val['description']);?></div>
				<?php } ?> 
				</div>
			<?php } ?>            
          </div>        
        </div>
      </section>
      
      <?php include_once('include/footer.php'); ?>

    </div>

    <!--JS Files-->
    <?php include_once('include/js.php');?>
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