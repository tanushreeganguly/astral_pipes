<?php
include_once('config/config.php');
$POST   = $objTypes->validateUserInput($_REQUEST);
$jobid  = intval($POST['id']);
$result = $objTypes->fetchRow("select job_code,department,title,to_experience,job_description,education,to_date,from_date,from_experience,location,meta_title,meta_description,meta_keywords from tbl_careers where id=".$jobid);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
  <title><?=$result['meta_title']?></title>
  <meta name="description" content="<?=$result['meta_description']?>" />
  <meta name="keywords" content="<?=$result['meta_keywords']?>" />
  <link href="<?=base_url?>assets/images/favicon.ico" rel="shortcut icon" type="" />
  <link href="<?=base_url?>assets/css/main.css" rel="stylesheet" type="text/css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
   <?php include_once('include/googlecode.php'); ?>
    <script type="text/javascript" src="//platform.linkedin.com/in.js">
    api_key: 81w5xifcml7xwt
    authorize: true
    // onLoad: onLinkedInLoad
    scope: r_basicprofile r_emailaddress
    </script>
   <script type="text/javascript">
   var job_code;
    function onLinkedInAuth() {
      IN.API.Profile("me")
      .fields("firstName", "lastName", "industry", "location:(name)", "picture-url", "headline", "summary", "num-connections", "public-profile-url", "distance", "positions", "email-address", "educations", "date-of-birth")
      .result(displayProfiles);
      $('#loading').show();
      /*IN.UI.Share().params({
      url: "http://www.example.com"
      }).place()*/
    }
    function displayProfiles(profiles) {  
      member = profiles.values[0];
      var email = member.emailAddress; 
      var name  = member.firstName+" "+member.lastName;
      var location  = member.location.name;
      var total_job=member.positions.values.length;
      var area_detail=location.split(',');
      $.ajax({
        type: 'POST',
        url: 'ajax_apply_for_career.php',
        beforeSend: function(){
              $('#loading').show();
         },
        data:  'email='+email+'&name='+name+'&job_id='+job_code+'&city='+area_detail[0]+'&country='+area_detail[1],  
        success:function(response){ 
          $('#loading').hide();
          if(response!=0){
               for(var j=0;j<total_job;j++){
                  var company_name = member.positions.values[j].company.name;
                  var designation  = member.positions.values[j].title;
                  var type  = member.positions.values[j].company.type;
                 $.ajax({
                  type: 'POST',
                  url: 'ajax_apply_for_job.php',
                  data:  'user_id='+response+'&company_name='+company_name+'&designation='+designation+'&job_id='+job_code+'&type='+type,  
                  success:function(response){ 
                    $('#loading').hide();
                    if(response=='success'){
                      alert('Successfully applied for Job..!');
                    }
                  }
                });
                }
                $(".error_data").html('Successfully applied for Job..!');
                return false;
          }else{
           $(".error_data").html('Already applied');
             return false;
          }
        }
      });
    }
    jQuery(document).ready(function(){
        jQuery(document).on("click",".linkdinlog",function() {
        job_code = $(this).attr('id'); 
        IN.UI.Authorize().place();
        IN.Event.on(IN, "auth", onLinkedInAuth);
      });
    });
  </script>
</head>
<body>
  <?php include_once('include/othercode.php'); ?>
  <div id="wrapper">
    <?php include_once('include/header.php'); ?>
    <section id="breadcrumbs">
      <div class="container">
        <a href="<?=base_url?>">Home</a>
        <a href="<?=base_url?>career">Career</a> Job Details
      </div>
    </section>
    <section id="siteInner" class="careerForm">
      <div class="container">
        <a href="<?=base_url?>career" class="backBtn">Back</a>
        <div class="sect_title inner_title">
          <h2><span>Careers</span></h2>
        </div>
      <div  id="loading" style="display:none;" >
           <img src="<?=base_url?>assets/images/loading.gif" alt="loading">
      </div>
        <div class="careerCon careerDet">
          <div class="error_data"></div>
          <ul>
            <li>Job Code</li>
            <li>
              <span><?php echo $result['job_code'];?></span>
              <span><strong>Date :</strong> <?php echo date('d-m-Y',strtotime($result['from_date']));?></span>
            </li>
          </ul>
          <ul>
            <li>Job Title</li>
            <li>
              <span><?php echo stripslashes($result['title']);?></span>
            </li>
          </ul>
          <ul>
            <li>Job Details</li>
            <li>
              <p><?php echo stripslashes($result['job_description']);?></p>
            </li>
          </ul>
          <ul>
            <li>Function</li>
            <li>
              <span><?php echo stripslashes($result['department']);?></span>
            </li>
          </ul>
          <ul>
            <li>Qualification</li>
            <li>
              <span><?php echo stripslashes($result['education']);?></span>
            </li>
          </ul>
          <ul>
            <li>Experience</li>
            <li>
              <span><?php 
			  if($result['to_experience']!=0){
				  echo stripslashes($result['to_experience'])." years of experience";
			  }else{
				  echo "Fresher";
			  } ?> </span>
            </li>
          </ul>
          <ul>
            <li>Location</li>
            <li>
              <span class="locationIcon"><?php echo stripslashes($result['location']);?></span>
              <span><strong>Last Date :</strong> <?php echo date('d-m-Y',strtotime($result['to_date']));?></span>
            </li>
          </ul>
          <ul>
              <li></li>
              <li>
                <span><a href="<?=base_url?>career-apply-now-<?php echo $jobid;?>" class="commanBtn">Apply Now</a></span>
                <span><a href="javascript:void(0)" class="linkdinlog apply_links" id="<?php echo $res['id']; ?>">Apply With</a></span>
              </li>
            </ul>
        </div>
      </div>
    </section>
  <?php include_once('include/footer.php'); ?>
  </div>
  <!--JS Files-->
  <?php include_once('include/js.php'); ?>
</body>
</html>