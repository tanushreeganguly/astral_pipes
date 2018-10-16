<?php 
include_once('config/config.php'); 
$sql	=	"SELECT * from tbl_investor_relation WHERE is_active = 1 and is_delete = 1";
$row 	=	$objTypes->fetchRow($sql); 
?>
<!doctype html>
<html>
<style>
table { width:100%;}
</style>

  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
  <title><?=$row['meta_title']?></title>
  <meta name="description" content="<?=$row['meta_description']?>" />    
  <meta name="keywords" content="<?=$row['meta_keywords']?>" />
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
          <a href="<?=base_url?>">Home</a> Investor Relations
        </div>
      </section>

      <section id="siteInner">
        <div class="full-width">
          <div class="sect_title inner_title">
            <h1> <span>Investor Relations</span> </h1>
            <div class="tl_bg">Investor Relations</div>
          </div>
          
          <div class="fullwidth" >         
			 <div class="primaryinfo"><?=stripslashes($row['text1'])?> </div>
			 <div class="primaryinfo"><?=stripslashes($row['text2'])?></div>
			 <div id="stockinfo" class="primaryinfo"><?=stripslashes($row['text3'])?></div>          
          </div> 
        </div>
      </section>
         <?php
			$investor_sql = "select * from tbl_investor_category where is_active=1 and  is_delete = 1 order by sortorder asc ";
			$investor_row = $objTypes->fetchAll($investor_sql); 			
			if(isset($investor_row) && sizeof($investor_row) >  0 ) {
			?>
	  <section id="siteInner">
        <div class="container">
			<div class="faqCon">
			<?php
			foreach ($investor_row as $investor_val){	
				$investor_data_sql = "select * from tbl_investor_details where is_active=1 and  is_delete = 1 and investor_id=".$investor_val['id']." order by sortorder asc ";
				$investor_data_row = $objTypes->fetchAll($investor_data_sql); 						
				if(isset($investor_data_row) && sizeof($investor_data_row) >  0 ) {
						?>
			<div class="bordersectiondiv">
            <div class="mypets"><?=($investor_val['title'])?></div>
            <div class="thepet"> 
			
				<table>
					<?php foreach($investor_data_row as $investor_data_val) { ?>
					<tr>
						  <td><?=($investor_data_val['title'])?></td> 
						  <td> <a download href="<?=base_url?>uploads/investor_broucher/<?php echo $investor_data_val['broucher']; ?>" target="_blank" class="commanBtn">DOWNLOAD</a></td>
						</tr> 
					<?php } ?>
				</table>
			   </div> 
            </div>
				<?php  } } ?>
							
				</div>
          </div>
        </div>
      </section>
	  <?php } ?>
	<?php include_once 'include/footer.php'; ?>
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