<?php 
	require_once ('config/config.php'); 
	include ('include/header.php');
?>
	<script type="text/javascript" src="<?=base_url?>js/jquery-1.12.1.min.js"></script>
	<div class="sign_up_con">
		<span>Unsubcribe for our newsletter!</span>
		<p>
		<div class="callout callout-danger errorDiv" <?php $objSystemMsg->createStyle($sysmsg);?> >
			<span id="errormessage"><?php echo $objSystemMsg->displayError($sysmsg); ?></span>
		</div>
		</p>
		<div class="signUp clearfix">	
			<form name="signup" method="post" action="<?=base_url?>newsletter_signup.php" onsubmit="return validationsignup();">
			<input type="text" id="Unsubcribe_email" name="Unsubcribe_email" placeholder="Your email address" class="signup_Input" />
			<input type="submit" name="Unsubcribe" value="Unsubcribe" class="signUpBtn">
			</form>
		</div>
	</div>
			
	<?php include_once('include/js.php'); ?>
	<script type="text/javascript" language="javascript">
	var sysmsg = "<?=$sysmsg?>";
	if(sysmsg==0){
		$(".errorDiv").hide();
	}
	else{
		$(".errorDiv").show().fadeOut(4000);
	}
	</script>
	<script>
	function validateEmail(email) {
		
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
		}
		
	function validationsignup(){
		var email = $("input#Unsubcribe_email").val();
		
		if($("input#Unsubcribe_email").val()==""){
			$(".errorDiv").show().fadeOut(4000);
			$('#errormessage').text("Please enter email id");
			$("input#Unsubcribe_email").focus();
			return false;
		}
		else if (!validateEmail(email))
						{
							$(".errorDiv").show().fadeOut(4000);
							$('#errormessage').text("Please enter valid email id");
							$("input#Unsubcribe_email").focus();
							return false;
						}
		return true;
	}
	</script>