<?php
include_once('config/config.php');
if(!class_exists('FormToken'))
{
	if(!require_once('include/form_token.php')){
		die('Class FormToken Not Exists.');
	}else{
		$token = new FormToken();
	}
}
function noHTML($input, $encoding = 'UTF-8') {
   return htmlentities($input, ENT_QUOTES | ENT_HTML5, $encoding);
}
$POST	= $objTypes->validateUserInput($_REQUEST);
function smssendotp($number)
{		
		$ch = curl_init();  // initiate curl
		$url = "http://www.smsjust.com/sms/user/urlsms.php?"; // where you want to post data - final
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_POST, true);  // tell curl you want to post something
		curl_setopt($ch, CURLOPT_POSTFIELDS, "username=astralpoly&pass=aptl@2017&senderid=ASTRAL&dest_mobileno=$number&message=Thank you for your details! We will get in touch with you shortly&response=Y"); 
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch); 
		if($result)
		{			
			return 1; 
		}else{			
			return 0; 
		}
		curl_close($ch);
}
if(isset($POST['data']) && $POST['data']=='1')
{ 
	$name 	 = noHTML(addslashes(strip_tags(trim($POST['name']))));
	$email	 = noHTML(addslashes(strip_tags(trim($POST['email']))));
	$decodeemail= html_entity_decode($email, ENT_QUOTES | ENT_HTML5, 'UTF-8');
	$mobile  = noHTML(addslashes(strip_tags(trim($POST['mobile']))));
	$type_enquiry = noHTML(addslashes(strip_tags(trim($POST['type_enquiry']))));
	$country = noHTML(addslashes(strip_tags(trim($POST['country']))));
	if($country=="India"){
		$state 	 = noHTML(addslashes(strip_tags(trim($POST['state']))));
	}else{
		$state 	 = noHTML(addslashes(strip_tags(trim($POST['state_input']))));	
	}
	
	$location		= 	noHTML(addslashes(strip_tags(trim($POST['location']))));
	$message 		= 	noHTML(addslashes(strip_tags(trim($POST['message']))));	
	
	$decodelocation =	html_entity_decode($location, ENT_QUOTES | ENT_HTML5, 'UTF-8');
	$decodemessage	= 	html_entity_decode($message, ENT_QUOTES | ENT_HTML5, 'UTF-8');
	$decodetype_enquiry =  html_entity_decode($type_enquiry, ENT_QUOTES | ENT_HTML5, 'UTF-8');
	$decodename 	=  	html_entity_decode($name, ENT_QUOTES | ENT_HTML5, 'UTF-8');
	$decodestate  	= 	html_entity_decode($state, ENT_QUOTES | ENT_HTML5, 'UTF-8');
	$decodecountry	= 	html_entity_decode($country, ENT_QUOTES | ENT_HTML5, 'UTF-8');
	
	$error	 = "";
	$flag	 	 = true;
	if($token->validateKey() == false){
		$error = "There is some problem, please try again.";		
		$flag  = false;
	}
	if(strlen($error)<=0){
		if($name==""){
			$error 	= "Please enter your name";
			$flag	= false;
		}elseif(!preg_match('/^[a-zA-Z ]+$/',$name)){
			$error 	= "Please enter valid name";
			$flag	= false;
		}elseif(strlen($name_ser) > '75'){
			$error 	= "Please enter valid name";
			$flag	= false;
		}
	}
	if(strlen($error)<=0){
		if($mobile=="" ){
			$error 	= "Please enter a valid mobile number";
			$flag	= false;
		}else if(strlen($mobile)!='10'){ 
			$error="Please Enter 10 Digit Mobile number.";
			$flag=false;		
		}else if(!preg_match("/^[0-9]{10}+$/",$mobile)){
			$error="Plesae enter valid Mobile number and maximum 10 digits";
			$flag=false;
		}	
	}
	if(strlen($error)<=0){	
	
		if($email=="" ){
			$error 	= "Please enter a valid email id";			
			$flag	= false;
		}else if($email!=''){ 
				if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,8})$/",$decodeemail)){
				$error 	= "Please enter valid email id";
				$flag	= false;
				$ser_eclass = "email";
			}
		}
	}
	
	if(strlen($error)<=0){
		if($country=="" ){
			$error 	= "Please enter Country";
			$flag	= false;
		}else if(!preg_match("/^[a-zA-Z0-9,\(\)&.\/\- ]{1,250}+$/",$decodecountry)){
		$error="Please enter valid Country, allowed specialcharacters (,()&./-)";
		$flag=false;
		}	
	}
	if(strlen($error)<=0){
		if($type_enquiry=="" ){
			$error 	= "Please specify the type of enquiry";
			$flag	= false;
		}else if(!preg_match("/^[a-zA-Z0-9,\(\)&.\/\- ]{1,250}+$/",$decodetype_enquiry)){
		$error="Please enter valid enquiry type, allowed specialcharacters (,()&./-)";
		$flag=false;
		}	
	}
	if(strlen($error)<=0){
		if($state=="" ){
			$error 	= "Please enter state name";
			$flag	= false;
		}
		if($state!="" ){
			if(!preg_match('/^[a-z A-Z]+$/',$state)){
				$error 	= "Please enter a valid state";
				$flag	= false;
			}else if(!preg_match("/^[a-zA-Z0-9,\(\)&.\/\- ]{1,250}+$/",$decodestate)){
		$error="Please enter valid enquiry type, allowed specialcharacters (,()&./-)";
		$flag=false;
		}	
		}
	}
	if(strlen($error)<=0){
		if($location=="" ){
			$error 	= "Please enter your location";
			$flag	= false;
		}
		if($location!="" ){
			if(!preg_match('/^[a-zA-Z0-9 ]+$/',$location)){
				$error 	= "Please enter a valid location";
				$flag	= false;
			}
		}
	}
	if(strlen($error)<=0){		
		if($message!=""){
			if(!preg_match('/^[a-z.A-Z0-9-!, ]+$/',$decodemessage)){
				$error 	= "Please enter a valid message";
				$flag	= false;
			}			
		} 
	}
		
	if($flag==true && strlen($error)<=0){		
		$insert_arr = array(
						'name'		=> $decodename,
						'email'		=> $decodeemail,
						'mobile' 	=> $mobile,
						'enquiry_type'	=> $decodetype_enquiry,
						'country'	=> $decodecountry,
						'state'		=> $decodestate,
						'location'	=> $decodelocation,
						'message'	=> $decodemessage,
						'ip'		=> $_SERVER['REMOTE_ADDR'],
						'agent'     => addslashes($_SERVER['HTTP_USER_AGENT'])
						);					
							
		$insert_enquiry = $objTypes->insert("tbl_enquiry", $insert_arr);
		$ins = $objTypes->lastInsertId();
		if($insert_enquiry)
		{
			$sendotp = smssendotp($mobile);			
			$error	 ="";	
			$success ="Thank you for your details! We will get in touch with you shortly.";	
			$name=$email=$mobile=$type_enquiry=$country=$state=$location=$message=$decodemessage='';
		}
	}
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
  <title>Astral Pipes | Dealer</title>
  <meta name="description" content="Astral Pipes | Enquiry" />
  <meta name="keywords" content="Astral Pipes | Enquiry" />
  <link href="assets/images/favicon.ico" rel="shortcut icon" type="" />
  <link href="assets/css/main.css" rel="stylesheet" type="text/css">
   <?php include_once('include/googlecode.php'); ?>
   <style>
   .clscenter { text-align:center; }
   .success_msg { color:green;}
   .state_input {display:none;} 
   </style>
</head>
<body>
<?php include_once('include/othercode.php'); ?>
  <div id="wrapper">
	<?php include_once('include/header.php'); ?>
    <section id="breadcrumbs">
      <div class="container">
        <a href="<?=base_url?>">Home</a> Enquiry
      </div>
    </section>
    <section id="siteInner">
      <div class="container">
        <div class="sect_title inner_title">
          <h1>
            <span>Enquiry</span>
          </h1>
        <div class="tl_bg">Enquiry</div>
        </div>
 </div>
 </section>
 <section id="Enquiryform">
	<div class="container">
	
		<form action="<?php echo base_url;?>dealer#dealer" method="post" name="enquiry" id="enquiry">
		<div class="enquiryFormH">   
			<div class="cr_block">
			<div class="success_msg"><?php echo isset($success) ? $success : '';?></div>
			<div class="errMsg error_display"><?php echo $error;?></div>
		   <div class="enqiryForm">
			<input type="hidden" name="data" value="1">	
				<?php echo $token->outputKey(); ?>	
			  <ul class="enquiry">
				<li>
				  <span>Name*</span>
				  <span id="namebox" class="clscenter">
					<input type="text" placeholder="Name " class="textBox" id="name" name="name" value="<?php echo $name; ?>"><span></span>
				  </span>
				</li>
				<li>
				  <span>Email ID*</span>
				  <span>
					<input type="text" class="textBox" placeholder="Email id "  name="email" id="email" value="<?php echo $email; ?>">
				  </span>
				</li>
				<li>
				  <span>Mobile No*</span>
				  <span id="mobilebox"  class="clscenter">
					<input type="text" class="textBox" id="mobile" placeholder="Mobile "  name="mobile" maxlength="10" value="<?php echo $mobile; ?>"><span></span>
				  </span>
				</li>
				<li>
				  <span>Country*</span>
				  <span>
					<select name="country" id="country" class="selectBox" >
					  <option value="">Select Country </option>
					  <option value="India" <?php if($country=='India') echo 'selected';?>>India</option>
					  <option value="US" <?php if($country=='US') echo 'selected';?>>US</option>
					</select>
				  </span>
				</li>
				 <li id="state_select_custom" style="display:none;">
				  <span>State*</span>	                  
					<span id="state_inputbox" class="clscenter"> 
					<select id="state_select" name="state" class="selectBox">
						<option value="">State</option>
						<?php
						$params     = array(":is_active" => '1');
						$state_arr	= $objTypes->fetchAll("SELECT state_name,state_id  FROM tbl_state_master WHERE is_active = :is_active", $params);
						if(sizeof($state_arr) > 0){
							foreach($state_arr as $state_v){  													
								?>
							<option value="<?php echo $state_v['state_name'];?>" <?php echo ($state==$state_v['state_name']) ? 'selected': ''?>><?php echo ucfirst(strtolower($state_v['state_name']));?></option>
						<?php } }  ?>
					</select>
					</span>
	            </li>
				 <li style="display:none;" id="state_text_custom">
				  <span>State*</span>
				  <span id="mobilebox"  class="clscenter">
					<input type="text" class="textBox" id="state_text" placeholder="State"  name="state_input" value="<?php echo $state; ?>"><span></span>
				  </span>
				</li>
				
				 <!--li>
				  <span>State*</span>	                  
					<span id="state_inputbox" class="clscenter"> 
					<select id="state_select" name="state" class="selectBox">
						<option value="">State</option>
						<?php
						$params     = array(":is_active" => '1');
						$state_arr	= $objTypes->fetchAll("SELECT state_name,state_id  FROM tbl_state_master WHERE is_active = :is_active", $params);
						if(sizeof($state_arr) > 0){
							foreach($state_arr as $state_v){  													
								?>
							<option value="<?php echo $state_v['state_name'];?>" <?php echo ($state==$state_v['state_name']) ? 'selected': ''?>><?php echo ucfirst(strtolower($state_v['state_name']));?></option>
						<?php } }  ?>
					</select>
						<p>				
	                    <input type="text" class="textBox state_input" id="state_input" name="state_input" value="<?php echo $state;?>" ><span></span>	
	                 	</p>
						</span>
	            </li-->
				<li>
				  <span>Location*</span>
				  <span id="locationbox" class="clscenter">
					<input type="text" placeholder="Location" name="location" id="location" value="<?php echo $location; ?>" class="textBox" ><span></span>
				  </span>
				</li>
				<li>
				  <span>Inquiring For* </span>
				  <span>
					<select name="type_enquiry" id="type_enquiry" class="selectBox">
						<option value="">Select Enquiry type</option>
						<option value="dealership" <?php echo ($type_enquiry=='dealership') ? 'selected': ''?>>Dealership</option>
					</select>
				  </span>
				</li>
				<li>
				  <span>Comment*</span>
				  <span id="messagebox" class="clscenter">
					<textarea name="message" placeholder="Comment" id="message" cols="30" rows="5" class="textArea"><?php echo $decodemessage; ?></textarea><span></span>
				  </span>
				</li>
			  </ul>
			<div class="btnHld">
				<a href="javascript:;" class="commanBtn">Submit</a>
			</div>
			</div>
		</div>
		</div>
		</form>
	</div>
</section>
	<?php include_once 'include/footer.php'; ?>
  </div>
  <!--JS Files-->
  <?php include_once('include/js.php');?>
</body>
</html>
<script type="text/javascript">
	$(document).ready(function(){	
			var country = $("#country").val();	
				if(country=='US'){
					//$("#state_select").hide();
					$("#state_text_custom").show();					
					$("#state_select_custom").hide();
				}else{
					$("#state_text_custom").hide();
					$("#state_select_custom").show();
				}			
	
	      $('input,textarea').on('keyup',function()
	      {
	      	  $('input,select,textarea').removeClass('errorRed');
	      	  $('.errMsg').text('');
	      	  $('.enquiry li span span').text(''); 
	          $('input,select').removeClass('errorblue');
	          $(this).addClass('errorblue');
	       });
	      
	      $('select').on('change',function()
	      {
	      	  $('input,select,textarea').removeClass('errorRed');
	      	  $('.errMsg').text('');
	      	  $('.enquiry li span span').text(''); 
	          $('input,select').removeClass('errorblue');
	          $(this).addClass('errorblue');
	       });
		$('#location').keyup(function()
          {
              alphanumericsonly(this);
              $("#location").addClass('errorblue');
              $("#location").focus();
              $("#locationbox span").text('Only alphanumerics');
          });
		$('#state_input').keyup(function()
          {
              charactersonly(this);
              $("#state_input").addClass('errorblue');
              $("#state_input").focus();
              $("#state_inputbox span").text('Only characters');
          });	
		$('#mobile').keyup(function()
          {
              numericsonly(this);
              $("#mobile").addClass('errorblue');
              $("#mobile").focus();
              $("#mobilebox span").text('Only numerics');
          });
          $('#name').keyup(function()
          {
              charactersonly(this);
              $("#name").addClass('errorblue');
              $("#name").focus();
              $("#namebox span").text('Only characters');
          });	
          $('#message').keyup(function()
          {
              specificsonly(this);
              $("#message").addClass('errorblue');
              $("#message").focus();
              $("#messagebox span").text('Only specific specialcharacters(.,!)');
          });
			$("#country").change(function(){
				var country = $("#country").val(); 
				if(country=='US'){
					$("#state_text_custom").show();					
					$("#state_select_custom").hide();
				}else{
					$("#state_text_custom").hide();
					$("#state_select_custom").show();
				}
			});
					
		$(".commanBtn").on('click',function(){
			$('input,select').removeClass('errorblue');
			$("html, body").animate({ scrollTop: 230 }, "slow");
			var name 		= $("#name").val().trim();		
			var mobile		= $("#mobile").val().trim();
			var country		= $("#country").val().trim();
			var email		= $("#email").val().trim();
			var type_enquiry= $("#type_enquiry").val().trim();			
			var location	= $("#location").val().trim();
			var message		= $("#message").val().trim();
			
			var regEx = new RegExp("/[0-9]/");
		
			var checkemail  = validateEmailAddress(email);
			$("input").removeClass('errorRed');
			if(name==""){
				$(".error_display").show();
				$(".error_display").text("Please enter your name");
				$("#name").addClass('errorRed');
				$("#name").focus();
				isOk = false;
				return false;
			}else if(!validateFirstnameLastname(document.getElementById('name'),"Please enter valid name.")) {
				$("#name").addClass('errorRed');
				isOk = false;
				return false;
			}else{
				$("#name").removeClass('errorRed');
			}	
			
		
			if(email==''){
				$(".error_display").show();
				$(".error_display").text('Please enter your email address');
				$("#email").addClass('errorRed')
				$("#email").focus();
				isOk = false;
				return  false;
			}else if(!checkemail && email!=''){
				$(".error_display").show();
				$(".error_display").text('Please enter a valid email id');
				$("#email").addClass('errorRed');
				$("#email").focus();
				isOk = false;
				return false;
			}else{
				$("#email").removeClass('errorRed');
			}
			
			if(mobile==""){
				$(".error_display").show();
				$(".error_display").text("Please enter your mobile");
				$("#mobile").addClass('errorRed');
				$("#mobile").focus();
				isOk = false;
				return false;
			}else{
					if(!$.isNumeric(mobile))
					{
						$(".errMsg").text("Please enter valid mobile no.");
						$("#mobile").addClass('errorRed');
						$("#mobile").focus();
						isOk = false;
						return false;
					
					}	
					 if(mobile.length != 10) {
						$(".error_display").show();
						$(".error_display").text("Please enter a valid mobile number");
						$("#mobile").addClass('errorRed');
						$("#mobile").focus();
						isOk = false;
						return false;
					}		
				$("#mobile").removeClass('errorRed');			
			}
			if(country==""){
				$(".error_display").show();
				$(".error_display").text("Please select country");
				$("#country").addClass('errorRed');
				$("#country").focus();
				isOk = false;
				return false;
			}else{
				$("#country").removeClass('errorRed');
			}	
			
			if(country=='US'){
				var state_input = $("#state_text").val();
				if(state_input==""){
					$(".error_display").show();
					$(".error_display").text("Please enter state name");
					$("#state_text").addClass('errorRed');
					$("#state_text").focus();
					isOk = false;
					return false;
				}else{
					$("#state_input").removeClass('errorRed');
				}
			}
			if(country=='India'){
				var state = $("#state_select").val();
				if(state==""){
				$(".error_display").show();
				$(".error_display").text("Please enter state name");
				$("#state_select").addClass('errorRed');
				$("#state_select").focus();
				isOk = false;
				return false;
			 }	else{
			 	$("#state_select").removeClass('errorRed');	
			 }	
			}
			/*
			if(state=="" && state_input==""){
				$(".error_display").show();
				$(".error_display").text("Please enter state name");
				$("#state_select").addClass('errorRed');
				$("#state_select").focus();
				isOk = false;
				return false;
			}else{			
				$("#state_select").removeClass('errorRed');			
			}*/
			
			if(location==""){
				$(".error_display").show();
				$(".error_display").text("Please enter your location");
				$("#location").addClass('errorRed');
				$("#location").focus();
				isOk = false;
				return false;
			}else{			
				$("#location").removeClass('errorRed');			
			}
			
			
			if(type_enquiry==""){
				$(".error_display").show();
				$(".error_display").text("Please specify the type of enquiry");
				$("#type_enquiry").addClass('errorRed');
				$("#type_enquiry").focus();
				isOk = false;
				return false;
			}else{			
				$("#type_enquiry").removeClass('errorRed');			
			}
			if(message==""){
				$(".error_display").show();
				$("#message").removeClass('errorblue');
				$("#message").addClass('errorRed');
				$(".error_display").text("Please enter your message");				
				$("#message").focus();
				isOk = false;
				return false;
			}else{			
				$("#message").removeClass('errorRed');			
			}
			
				$("#enquiry").submit();
		});
		function alphanumericsonly(ob) 
        {
            var invalidChars = /([^a-z 0-9])/gi
            if(invalidChars.test(ob.value)) 
            {
                ob.value = ob.value.replace(invalidChars,"");
            }
        }
         function charactersonly(ob) 
        {
            var invalidChars = /([^a-z ])/gi
            if(invalidChars.test(ob.value)) 
            {
                ob.value = ob.value.replace(invalidChars,"");
            }
        }
        function numericsonly(ob) 
        {
            var invalidChars = /([^0-9])/gi
            if(invalidChars.test(ob.value)) 
            {
                ob.value = ob.value.replace(invalidChars,"");
            }
        }
        function specificsonly(ob) 
        {
            var invalidChars = /([^a-z 0-9,!.])/gi
            if(invalidChars.test(ob.value)) 
            {
                ob.value = ob.value.replace(invalidChars,"");
            }
        }
		function validateEmailAddress(elementValue){
			var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;  
			var op = emailPattern.test(elementValue); 
			if(op==false){
				return false;
			}else{
			   return true;
			}
		}
		function validateFirstnameLastname(obj, msg){
			var validStr = /^[a-zA-Z ]{1,}$/;
			NameArr=obj.value.split("");
			/*if(NameArr.length>2)
			{
				alert(msg+'111');
				obj.focus();
				obj.select();
				return false;
			}*/
			for(i=0;i<NameArr.length+5;i++)
			{
				if (validStr.test(NameArr[i]) == false)
				{
					jQuery(".error_display").text(msg);
					obj.focus();
					obj.select();
					return false;
				}
			}
			return true;
		}		
		
	});
	
	</script>