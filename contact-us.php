<?php 
include_once('config/config.php'); 
$row=$objTypes->fetchRow('select * from tbl_pages where id=6');
include_once('include/common_functions.php'); 
if(!class_exists('FormToken'))
{
	if(!require_once('include/form_token.php')){
		die('Class FormToken Not Exists.');
	}else{
		$token = new FormToken();		
	}
}
$POST	= $objTypes->validateUserInput($_REQUEST);
function noHTML($input, $encoding = 'UTF-8') {
   return htmlentities($input, ENT_QUOTES | ENT_HTML5, $encoding);
}
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
	$name 	 = noHTML(addslashes(strip_tags($POST['name'])));
	$email	 = noHTML(addslashes(strip_tags($POST['email'])));
	$mobile  = noHTML(addslashes(strip_tags($POST['mobile'])));
	$type_enquiry = noHTML(addslashes(strip_tags($POST['type_enquiry'])));
	$message = noHTML(addslashes(strip_tags($POST['message'])));
	$error	 = "";
	$flag	 = true;
	$decodename 		= html_entity_decode($name, ENT_QUOTES | ENT_HTML5, 'UTF-8');
	$decodeemail		= html_entity_decode($email, ENT_QUOTES | ENT_HTML5, 'UTF-8');
	$decodemsg			= html_entity_decode($message, ENT_QUOTES | ENT_HTML5, 'UTF-8');
	$decodetype_enquiry	= html_entity_decode($type_enquiry, ENT_QUOTES | ENT_HTML5, 'UTF-8');
	if($token->validateKey() == false){
		$error = "There is some problem, please try again.";		
		$flag  = false;
		$name = $email = $mobile = $location  = $message = ''; 
		$_POST = array();
	}
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
	if($email=="" ){
		$error 	= "Please enter a valid email id";
		$flag	= false;
	}else if($email!=''){ 	
		if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/",$decodeemail)) 
		{
			$error="Plesae enter valid emailid ";
			$flag=false;
		}
	}
	if($type_enquiry=="" ){
		$error 	= "Please specify the type of enquiry";
		$flag	= false;
	}else if(!preg_match("/^[a-zA-Z0-9,\(\)&.\/\- ]{1,250}+$/",$decodetype_enquiry)){
		$error="Please enter valid enquiry type, allowed specialcharacters (,()&./-)";
		$flag=false;
	}	
	if($message!=""){
		if(!preg_match("/^[a-zA-Z0-9,\(\)&.\/\- ]{1,250}+$/",$decodemsg)) 
				{
					$error="Please enter valid message, allowed specialcharacters (,()&./-) and max 250 characters";
					$flag=false;
				}		
	}
	$success = '';
	if($flag==true && strlen($error)<=0){		
		$insert_arr = array(
					'name'		=> $decodename,
					'email'		=> $decodeemail,
					'mobile' 	=> $mobile,
					'enquiry_type'	=>$decodetype_enquiry,
					'message'	=> $decodemsg,
					'ip'		=> $_SERVER['REMOTE_ADDR'],
					'agent'     => addslashes($_SERVER['HTTP_USER_AGENT'])
					);
		$insert = $objTypes->insert("tbl_contact", $insert_arr);
		if($insert)
		{			 
			 $name= $email = $mobile =$message = $decodetype_enquiry = '';			 
			 $insert_id = $objTypes->lastInsertId();	
			 if(isset($insert_id) && $insert_id > 0){	
				$sendotp = smssendotp($mobile);	
				$decodetype_enquiry = $decodestate = ''; 
				$success= 'Thank you for your details! We will get in touch with you shortly.';	
				$error =  '';				
			}				
		}//insert
		else{
			$error =  'something went wrong';
		}
	}
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
    <title><?=stripslashes($row['meta_title']);?></title>
	<meta name="description" content="<?=stripslashes($row['meta_description']);?>" />
	<meta name="keywords" content="<?=stripslashes($row['meta_keywords']);?>" />
    <link href="assets/images/favicon.ico" rel="shortcut icon" type="" />
    <link href="assets/css/main.css" rel="stylesheet" type="text/css">
    <link href="assets/css/owl.carousel.min.css" rel="stylesheet" type="text/css">
		<style type="text/css">
	  .errorRed{ border: solid 1px red!important;}
	  .error_display{ font-size:15px!important;color:red;padding:0 0 20px 0px;text-align:center;}
	  .success_msg { font-size:15px!important;color:green;}
	  </style>
	<?php include_once('include/googlecode.php'); ?>
</head>
 <body>
      <?php include_once('include/othercode.php'); ?>
     <div id="wrapper">
     <?php include_once('include/header.php'); ?>
      <?php echo str_replace("assets",base_url."assets",stripslashes($row['description']));?>
        <section id="contact_forn_con">
            <div class="container">
                <div class="sect_title">
                    <h2><span>Reach out to us for any query</span></h2>
                </div>				
                <div class="fileldsCon">
                <form action="<?php echo base_url;?>contact-us#contact_forn_con" method="post" name="contact" id="contact">
				<div class="success_msg"><?php echo isset($success) ? $success : '';?></div>
                    <div class="error_display"><?php echo $error;?></div>
                    <div class="fieldHolder">
					<input type="hidden" name="data" value="1">	
					<?php echo $token->outputKey(); ?>
                        <input type="text" name="name" id="name" class="formTextBox" value="<?php echo $name; ?>"  placeholder="Name *">
                    </div>
                    <div class="fieldHolder">
                        <input type="text" name="email" id="email" class="formTextBox" value="<?php echo $email; ?>" placeholder="Email *">
                    </div>
                    <div class="fieldHolder">
                        <input type="text" name="mobile" id="mobile" maxlength="10" class="formTextBox" value="<?php echo $mobile; ?>" placeholder="Mobile No. *">
                    </div>
                    <div class="fieldHolder">
                        <select name="type_enquiry" id="type_enquiry" class="formSelectBox">
                            <option value="">Enquiry Type *</option>
                            <option value="sales"  <?php  if($decodetype_enquiry=='sales') echo 'selected';  ?>>Sales</option>
							<option value="exports"  <?php  if($decodetype_enquiry=='exports') echo 'selected';  ?>>Exports</option>
							<option value="dealership"  <?php  if($decodetype_enquiry=='dealership') echo 'selected';  ?>>Dealership</option>
                        </select>
                    </div>
                    <div class="fieldHolder">
                        <textarea name="message" id="message" cols="30" rows="4" class="textArea" placeholder="Message *"><?php echo $message ?></textarea>
                    </div>
                </div>
                <div class="btnHolder">
                    <button class="commanBtn">Submit</button>
                </div>
				</form>
            </div>
        </section>
           <?php include_once 'include/footer.php'; ?>
    </div>
    <!--JS Files-->
	<?php include_once 'include/js.php'; ?>
    <script type="text/javascript" src="assets/js/owl.carousel-beta.js"></script>
    <script type="text/javascript" src="assets/js/contact.js"></script>
      <script type="text/javascript">
	$(document).ready(function(){
		 $("#mobile").keypress(function (e) {
			 //if the letter is not digit then display error and don't type anything
			 if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
				//display error message
				$(".error_display").show();
				$(".error_display").text("Please enter only digits");
				return false;
			}
		   });
	$(".commanBtn").on('click',function(){
		$(".success_msg").html('');
		var name 		= $("#name").val().trim();		
		var mobile		= $("#mobile").val().trim();
		var email		= $("#email").val().trim();
		var type_enquiry= $("#type_enquiry").val().trim();
		var message		= $("#message").val().trim();
		var regEx = new RegExp("/[0-9]/");
		var checkemail  = validateEmailAddress(email);
		if(name==""){
			$(".error_display").show();
			$(".error_display").text("Please enter your name");
			$("#name").addClass('errorRed');
			$("#name").focus();
			$("#type_enquiry").removeClass('errorRed');	
			$("#mobile").removeClass('errorRed');			
			$("#email").removeClass('errorRed');	
			$("#message").removeClass('errorRed');
			isOk = false;
			return false;
		}else if(!validateFirstnameLastname(document.getElementById('name'),"Please enter valid name.")) {
			$("#name").addClass('errorRed');
			$("#name").focus();
			$("#type_enquiry").removeClass('errorRed');	
			$("#mobile").removeClass('errorRed');			
			$("#email").removeClass('errorRed');			
			$("#message").removeClass('errorRed');
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
			$("#type_enquiry").removeClass('errorRed');	
			$("#mobile").removeClass('errorRed');			
			$("#message").removeClass('errorRed');
			isOk = false;
			return  false;
		}else if(!checkemail && email!=''){
			$(".error_display").show();
			$(".error_display").text('Please enter a valid email id');
			$("#email").addClass('errorRed')
			$("#type_enquiry").removeClass('errorRed');	
			$("#mobile").removeClass('errorRed');	
			$("#message").removeClass('errorRed');			isOk = false;
			return false;
		}else{
			$("#email").removeClass('errorRed');
		}
		if(mobile==""){
			$(".error_display").show();
			$(".error_display").text("Please enter your mobile");
			$("#mobile").addClass('errorRed');
			$("#mobile").focus();
			$("#type_enquiry").removeClass('errorRed');				
			$("#email").removeClass('errorRed');			
			$("#message").removeClass('errorRed');
			isOk = false;
			return false;
		}else if(isNaN(mobile)){
			$(".error_display").text("Please enter only digits");
			$("#mobile").addClass('errorRed');
			$("#mobile").focus();
			$("#type_enquiry").removeClass('errorRed');	
			$("#name").removeClass('errorRed');			
			$("#email").removeClass('errorRed');	
			$("#message").removeClass('errorRed');
			isOk = false;
			return false;
		}else{			
			$("#mobile").removeClass('errorRed');			
			}
		 if($("#mobile").val().length != 10) {
			$(".error_display").show();
			$(".error_display").text("Please enter a valid mobile number");
			$("#mobile").addClass('errorRed');
			$("#mobile").focus();
			$("#type_enquiry").removeClass('errorRed');	
			$("#name").removeClass('errorRed');
			$("#email").removeClass('errorRed');				
			$("#message").removeClass('errorRed');
			isOk = false;
			return false;
		}
		if(type_enquiry==""){
			$(".error_display").show();
			$(".error_display").text("Please specify the type of enquiry");
			$("#type_enquiry").addClass('errorRed');
			$("#type_enquiry").focus();
			$("#name").removeClass('errorRed');	
			$("#mobile").removeClass('errorRed');	
			$("#email").removeClass('errorRed');			
			$("#message").removeClass('errorRed');
			isOk = false;
			return false;
		}else{			
			$("#type_enquiry").removeClass('errorRed');			
		}
		if(message==""){
			$(".error_display").show();
			$(".error_display").text("Please enter your message");
			$("#message").addClass('errorRed');
			$("#message").focus();
			$("#type_enquiry").removeClass('errorRed');	
			$("#mobile").removeClass('errorRed');			
			$("#email").removeClass('errorRed');				
			$("#name").removeClass('errorRed');
			isOk = false;
			return false;
		}else{			
			$("#message").removeClass('errorRed');			
		}
			$("#contact").submit();
		});
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
</body>
</html>