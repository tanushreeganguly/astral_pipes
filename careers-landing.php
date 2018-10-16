<?php include_once('config/config.php');
$row=$objTypes->fetchRow('select * from tbl_pages where id=1');
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
  <title><?=stripslashes($row['meta_title']);?></title>
  <meta name="description" content="<?=stripslashes($row['meta_description']);?>" />
  <meta name="keywords" content="<?=stripslashes($row['meta_keywords']);?>" />
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
        <a href="index.html">Home</a> Careers 
      </div>
    </section>


    <section id="siteInner">
      <div class="container">
        <div class="sect_title inner_title">
          <h1>
            <span>Careers</span>
          </h1>
        <div class="tl_bg">Careers</div>
        </div>

 </div>
 </section>


<section id="carrerL">
  <div class="container">
    
    <?php echo str_replace('assets',base_url.'assets',stripslashes($row['description']));?>

              <div class="centerbuttonCom">
                  <a href="<?=base_url?>career" class="commanBtn">Current Job Openings</a>
              </div> 

</section>


<section id="workwith">
    <div class="container">
        <div class="sect_title inner_title">
          <h2>
            <span>Work With Us</span>
          </h2>
        </div>

        <div class="workseclistH">
            <div class="workwithus"> <img src="<?=base_url?>assets/images/market-leader.gif"> <h3>Market Leader</h3> <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p></div>
              <div class="workwithus"> <img src="<?=base_url?>assets/images/innovation-driven.gif"> <h3>Innovation Driven</h3> <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed incididunt ut labore et dolore magna aliqua.</p></div>
              <div class="workwithus"> <img src="<?=base_url?>assets/images/transparent-culture.gif"> <h3>Transparent Culture</h3> <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit,  eiusmod tempor incididunt ut labore et dolore magna aliqua.</p></div>
              <div class="workwithus bordernonelast"> <img src="<?=base_url?>assets/images/growth-opportunities.gif"> <h3>Growth Opportunities</h3> <p> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed  eiusmod tempor incididunt ut labore et dolore magna aliqua.</p></div>

        </div>


    </div>
</section>

<?php include_once('include/footer.php'); ?>
</div>

  <!--JS Files-->
  <?php include_once('include/js.php');?>
  <!--[if lt IE 9]>
        <script src="<?=base_url?>js/html5shiv.min.js"></script>
    <![endif]-->
</body>

</html>