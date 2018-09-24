<?php 
include_once('config/config.php'); 

function getCoordinates($address){ 
	$address = str_replace(" ", "+", $address); // replace all the white space with "+" sign to match with google search pattern 
	$url = "http://maps.google.com/maps/api/geocode/json?sensor=false&address=$address"; 
	$response = file_get_contents($url); 
	$json = json_decode($response,TRUE); //generate array object from the response from the web 
	return ($json['results'][0]['geometry']['location']['lat'].",".$json['results'][0]['geometry']['location']['lng']); 
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
  <title>Astral Pipes</title>
  <meta name="description" content="" />    
  <meta name="keywords" content="" />
  <link href="<?=base_url?>assets/images/favicon.ico" rel="shortcut icon" type="" />
  <link href="<?=base_url?>assets/css/main.css" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
			/*IN.UI.Share().params({
			url: "http://www.example.com"
			}).place()*/
			$('#loading').show();
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
						  var company_name  = member.positions.values[j].company.name;
						  var designation  = member.positions.values[j].title;
						  var type  = member.positions.values[j].company.type;
						 $.ajax({
						  type: 'POST',
						  url: 'ajax_apply_for_job.php',
						  data:  'user_id='+response+'&company_name='+company_name+'&designation='+designation+'&job_id='+job_code+'&type='+type,  
						  success:function(response){ 
							$('#loading').hide();						   
						  }
						});
						}
					   $('.error_data').html('Successfully applied for Job..!');
				  }else{
					$('.error_data').html('Already applied');
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
			<a href="<?=base_url?>">Home</a> Career
		  </div>
		</section>
     <section id="siteInner">
      <div class="container">
        <div class="sect_title inner_title">
          <h2>
            <span>Careers</span>
          </h2>
		<div class="tl_bg">Careers</div>
        </div>
        <div class="careerCon">
          <p>Didn't the job you were looking for?
            <a href="javascript:;">Submit Resume</a>
          </p>
          <div class="cr_block">
            <div class="jobsearcH"><h3>Job Search</h3></div>
            <div class="searchForm">
              <ul>
                <li>
                  <span>Location</span>
                  <span>
                   <?php 
                    $loc_sql    = "select distinct(location) from tbl_careers where is_delete = 1 and is_active = 1 order by id DESC";
                    $loc_arr    = $objTypes->fetchAll($loc_sql);
                    if(isset($loc_arr) && sizeof($loc_arr) > 0 ) { ?>                    
						<select name="location" id="location" class="selectBox">
							<option value="">All </option>
						<?php foreach($loc_arr as $loc_v) { ?>
							   <option value="<?php echo strtolower($loc_v['location']); ?>"><?php echo $loc_v['location']; ?></option>
						  <?php } ?>
						</select>
                    <?php } ?>
                  </span>
                </li>
                <li>
                  <span>Job Title</span>
                  <span>
                    <?php 
                    $job_title_sql    = "select title from tbl_careers where is_delete = 1 and is_active = 1 order by id DESC";
                    $job_title_arr    = $objTypes->fetchAll($job_title_sql);
                    if(isset($job_title_arr) && sizeof($job_title_arr) > 0 ) { ?>     
						<select name="job_title" id="job_title" class="selectBox">
							  <option value="">All </option>
								<?php foreach($job_title_arr as $job_title_v) { ?>
									<option value="<?php echo strtolower($job_title_v['title']); ?>"><?php echo $job_title_v['title']; ?></option>
								<?php } ?>
						</select>
                    <?php } ?>
                  </span>
                </li>
                <li>
                  <span>Department</span>
                  <span>
                    <?php 
                    $depart_sql    = "select distinct(department) from tbl_careers where is_delete = 1 and is_active = 1 order by id DESC";
                    $depart_arr    = $objTypes->fetchAll($depart_sql);
                    if(isset($depart_arr) && sizeof($depart_arr) > 0 ) { ?>     
						<select name="department" id="department" class="selectBox">
							  <option value="">All </option>
								<?php foreach($depart_arr as $depart_v) { ?>
									<option value="<?php echo strtolower($depart_v['department']); ?>"><?php echo $depart_v['department']; ?></option>
								<?php } ?>
						</select>
                       <?php } ?>
                  </span>
                </li>
                <li>
                  <span>Experience</span>
                  <span>
                    <select class="selectBox" name="experience" id="experience">
                      <option value="">Select To Experience</option>
					  <?php for($i=1;$i<=20;$i++){ ?>
						<option value="<?php echo $i;?>" ><?=$i?></option>
                      <?php } ?>
				  </select>
                  </span>
                </li>
                <li></li>
              </ul>
            </div>
          </div>
		  
			 <div  id="loading" style="display:none;" >
				<img src="<?=base_url?>assets/images/loading.gif" alt="loading">
			 </div>
		  
			  <div class="sect_titleNew innerPagesmall_title">
				  <h2><span>Current Openings</span></h2>
			  </div>
			  <?php $result	= $objTypes->fetchAll("SELECT job_code,id,location,title,department,education,from_experience,to_experience,from_date,to_date FROM tbl_careers WHERE is_delete = 1 and is_active = 1 order by job_code ASC");
			  $html = ''; 
			  if(sizeof($result) > 0){ ?>				
			  <div id="current_opening_ajax">
				<div class="error_data" style="color:red;">
				<?php if(isset($POST['msg']) && $POST['msg']==1){ ?>
                    Successfully applied for Job..!
                <?php } ?>
				</div>
				  <div class="opening_table_con">
					<div class="opening_details">
					  <ul>
						<li class="th">
						  <span>Job Code</span>
						  <span>Job Title</span>
						  <span>Function</span>
						  <span>Education</span>
						  <span>Job Code</span>
						  <span>Date</span>
						</li>
					  </ul>
					</div>
					<?php foreach($result as $res){  
							$coords = getCoordinates($res['location']); ?>
					<div class="opening_details">
					  <ul>
						 <li>
						  <span><?=$res['job_code']?></span>
						   <div class="bgimg"><img src="assets/images/arrow-ta.jpg"></div>
						  <span><?=$res['title']?>
							<div class="loc">Mumbai</div>
						  </span>
						  <span><?=$res['department']?></span>
						  <span><?=$res['education']?></span>
						  <span><?=$res['to_experience']?>years</span>
						  <span><?=date('d/m/Y',strtotime($res['from_date']));?>
							<br> TO
							<br><?=date('d/m/Y',strtotime($res['to_date']));?></span>
						  <span>
							<a href="javascript:;" class="commanBtn">Apply Now</a>
						  </span>
						   <span>
							  <div class="api_links">
								<a href="javascript:;" class="linkdinlog" id="<?php echo $res['id']; ?>" >Apply With</a>
								<a href="<?=base_url?>career-details/<?=$res['id']?>">Read More</a>
							  </div>
							</span>
							</li>
						</ul>
					</div> <!--opening details-->
			  <?php } ?>
				  </div>
			  </div>
			  <?php } ?>
      </div>
    </section>
    <?php include_once('include/footer.php'); ?>
  </div>
  <!--JS Files-->
  <?php include_once('include/js.php');?>
</body>
</html>
<script type="text/javascript">
$(document).ready(function(){	  
    $(document).on('change','#location',function(){	
	  var job_title = $("#job_title").val();
	  var location 	= $("#location").val(); 
	  var department = $("#department").val(); 
	  var experience = $("#experience").val(); 
     // if(location){
        $.ajax({
          type: 'POST',
          url: 'ajax_current_opening.php',
          data:  'location='+location+'&job_title='+job_title+'&department='+department+'&experience='+experience,     
          success:function(response){ 
            if(response){
				$("#current_opening_ajax").html('');  
				$("#current_opening_ajax").html(response);             
            }else{
				$("#current_opening_ajax").html('We could not find jobs matching your search criteria.');
			}           
          }
        });
      //}
    });
	$(document).on('change','#job_title',function(){  
	  var job_title  = $("#job_title").val();
	  var location 	 = $("#location").val(); 
	  var department = $("#department").val(); 
	  var experience = $("#experience").val(); 
      //if(job_title){
		$.ajax({
		  type: 'POST',
		  url: 'ajax_current_opening.php',
		  data:  'location='+location+'&job_title='+job_title+'&department='+department+'&experience='+experience,   
		  success:function(response){   
		  if(response){
					$("#current_opening_ajax").html(response);             
			}else{
					$("#current_opening_ajax").html('We could not find jobs matching your search criteria.');
				   }           
		   }
		});
      //}
    });
	$(document).on('change','#department',function(){
		  var job_title = $("#job_title").val();
		  var location 	= $("#location").val(); 
		  var department = $("#department").val(); 
		  var experience = $("#experience").val(); 
      //if(department){
        $.ajax({
          type: 'POST',
          url: 'ajax_current_opening.php',
          data:  'location='+location+'&job_title='+job_title+'&department='+department+'&experience='+experience,     
          success:function(response){            
            if(response){
				$("#current_opening_ajax").html(response);             
            }else{
				$("#current_opening_ajax").html('We could not find jobs matching your search criteria.');
			}           
          }
        });
      //}
    });
	$(document).on('change','#experience',function(){		
      var job_title  = $("#job_title").val();
	  var location 	 = $("#location").val(); 
	  var department = $("#department").val(); 
	  var experience = $("#experience").val(); 	  
      //if(experience){
        $.ajax({
          type: 'POST',
          url: 'ajax_current_opening.php',
          data:  'location='+location+'&job_title='+job_title+'&department='+department+'&experience='+experience,    
          success:function(response){
            if(response){
              $("#current_opening_ajax").html(response);             
            }else{
              $("#current_opening_ajax").html('We could not find jobs matching your search criteria.');
            }          
          }
        });
      //}
    });
});
</script>