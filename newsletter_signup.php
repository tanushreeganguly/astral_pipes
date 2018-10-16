<?php 
require_once("config/config.php"); 
if(!class_exists('PHPMailer')){
	if( !require_once( 'include/PHPMailer/PHPMailerAutoload.php' )){
		die('PHPMailer Class Does not Exists!');
	}else{		
		$mail 	= new PHPMailer();
	}
}
#==== Validations For Security
$POST		= $objTypes->validateUserInput($_POST);
$ip			= $_SERVER['REMOTE_ADDR'];
$agent		= addslashes($_SERVER['HTTP_USER_AGENT']);
#==== ADD - INSERT
if(($POST['signup_email'])){
	 $sql 	=	"SELECT count(*) as count from  tbl_newsletter_signup WHERE signup_email='".$POST['signup_email']."' and status=1"; 
	$arr=	$objTypes->fetchAll($sql); 
	if(isset($arr) && $arr[0]['count'] != 0){
			echo 'Already subscribed'; exit; 
		}else{				
		$signup_email = addslashes(strip_tags($POST['signup_email']));	
		$params = array(
				   'signup_email'	 => $signup_email,
				   'ip'              => $ip,
				   'agent'           => $agent
					);
		$insert = $objTypes->insert("tbl_newsletter_signup", $params);
		//if($insert){
			$insert_id = $objTypes->lastInsertId();
			if($insert_id > 0){		
			$mail->IsSMTP();
			$mail->Mailer 	  = "smtp";
			$mail->Host       = "astralipipes.com"; 
			$mail->SMTPDebug  = 0; 
			$mail->SMTPAuth   = true; 
			$mail->Port       = 25;
			$mail->SMTPSecure = 'TLS';
			$mail->Username   = "info@astralipipes.com";
			$mail->Password   = "info123!@#";
			$mail->addReplyTo('info@astralipipes.com', 'Astral Pipes'); 
			$mail->setFrom('info@astralipipes.com', 'Astral Pipes');
			$mail->addAddress('info@astralipipes.com', 'Astral Pipes');
			//$mail->addBCC('santhosh.nair@bcwebwise.com', 'Santhosh');	
			$mail->addBCC('mitul.jagushte@bcwebwise.com', 'Mitul Jagushte');
			$mail->addAddress($signup_email);
			$mail->isHTML(true);	
			$mail->Subject  = 'NewsLetter';			
			$mail->Body     = 'We appreciate your interest in our services. Our team will get in touch with you shortly.';
			//if(!$mail->send()){
				// echo "Error in sending message.";
				 echo "Thank you";
			//}else {				
				//echo "Thank you";
			//}	
			}
		//}
			}	
}
if(($POST['Unsubcribe']=="Unsubcribe"))
{
	$unsubcribe_email = addslashes(strip_tags($POST['Unsubcribe_email']));
	$where      = array(":status" => '1');
	if($unsubcribe_email){
	$where[':signup_email'] = $unsubcribe_email ;
	}
	$params = array(
	   'signup_email'	 => $unsubcribe_email,
       'ip'              => $ip,
       'agent'           => $agent
    );
	 $select_email = $objTypes->select("tbl_newsletter_signup", "*","status = :status AND signup_email = :signup_email" ,$where);
	 $num_rows 	   =  count($select_email);
	 if($num_rows > 0)
	 {
		$update = $objTypes->inquery("UPDATE tbl_newsletter_signup SET status = '0' WHERE signup_email = '".$unsubcribe_email."' ");
		if($update)
		{	header("location:unsubcribe.php?sysmsg=1017");
			exit();
		}else {
			header("location:unsubcribe.php?sysmsg=3");
			exit();
		}
	 }
	else{
		header("location:unsubcribe.php?sysmsg=34");
		exit();
	}
}