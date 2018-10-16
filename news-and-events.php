<?php	
include_once('config/config.php'); 
$page	=	$objTypes->fetchRow('select meta_title,meta_description,meta_keywords from tbl_pages where id=8');
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
  <title><?=stripslashes($page['meta_title']);?></title>
  <meta name="description" content="<?=stripslashes($page['meta_description']);?>" />
  <meta name="keywords" content="<?=stripslashes($page['meta_keywords']);?>" />
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
        <a href="<?=base_url?>">Home</a> News & Events
      </div>
    </section>
    <section id="siteInner">
      <div class="container">
        <div class="sect_title inner_title">
          <h2>
            <span>News & Events</span>
          </h2>
        <div class="tl_bg">News & Event</div>
        </div>
		<div class="newsandeventlistH">
			<ul class="eventlistH" id="ajax_news_events">	
				<!--ajax contents-->	
			</ul>			
		</div>
	 </div>
	</section>
    <?php include_once('include/footer.php'); ?>
  </div>
    <!--JS Files-->
	<?php include_once('include/js.php'); ?>  
	<script type="text/javascript" src="<?=base_url?>js/custom_pagination.js"></script>
	<script type="text/javascript" src="<?=base_url?>js/pagination.js"></script>
	<script type="text/javascript">
	var  base_url ='<?=base_url?>ajax_news_events.php';
	$(document).ready(function() {
		$('#ajax_news_events').scrollPagination({			
			nop     : 9, // The number of posts per scroll to be loaded
			offset  : 0, // Initial offset, begins at 0 in this case
			error   : '<a>More data Coming Soon...<div class="color-1-bg-light color-bg"></div></a>', // When the user reaches the end this is the message that is
										// displayed. You can change this if you want.
			delay   : 600, // When you scroll down the posts will load after a delayed amount of time.
						   // This is mainly for usability concerns. You can alter this as you see fit
			scroll  : true // The main bit, if set to false posts will not load as the user scrolls. 
						   // but will still load if the user clicks.		
		});
	});
	</script>
</body>
</html>