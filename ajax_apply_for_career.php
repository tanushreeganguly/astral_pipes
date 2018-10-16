<?php include_once('config/config.php');
require ('include/PHPMailer/PHPMailerAutoload.php');
$POST   = $objTypes->validateUserInput($_REQUEST); 
$email = isset($POST['email'])  ? $POST['email'] : '';
$name  = isset($POST['name'])  ? $POST['name'] : '';
$job_id  = isset($POST['job_id'])  ? $POST['job_id'] : '';
$country  = isset($POST['country'])  ? $POST['country'] : '';
$city  = isset($POST['city'])  ? $POST['city'] : '';

//echo "SELECT * FROM tbl_career_apply WHERE email = '".$email."' and job_code= '".$job_code."' and is_delete = 1 and is_active = 1";

$result	= $objTypes->fetchAll("SELECT * FROM tbl_career_apply WHERE email = '".$email."' and job_id= '".$job_id."' and is_delete = 1 and is_active = 1");

if(count($result)<1){
$insert_arr = array(
				'name'		=> 	$name,
				'email'		=> 	$email,
				'country'	=> 	$country,	
				'city'		=> 	$city,
				'job_id'	=> 	$job_id,					
				'ip'		=> 	$_SERVER['REMOTE_ADDR'],
				'agent'     => 	addslashes($_SERVER['HTTP_USER_AGENT']),
				'is_active'	=>	1,
				'is_delete'	=>	1
				);							
$insert = $objTypes->insert("tbl_career_apply", $insert_arr);

	if($insert){
					echo  $user_id=$objTypes->lastInsertId(); 
		                  $params = array(
                              'ref_no'    => 'AA000-'.$user_id
                             );
                          //$objTypes->update($UpdatePdfArray,"id = '".$id."'");
                          
                            $where  = array(
                              ':id'          => $user_id
                          );
                          $update = $objTypes->update("tbl_career_apply", $params, "id = :id", $where);

				        $usermail 	= new PHPMailer;				
						$usermail->isHTML(true);								
						$usermail->IsSMTP();
						$usermail->Mailer 	  = "smtp";
						$usermail->Host       = "astraladhesive.com"; 
						$usermail->SMTPDebug  = 0; 
						$usermail->SMTPAuth   = true; 
						$usermail->Port       = 25;
						$usermail->SMTPSecure = 'TLS';
						$usermail->Username   = "info@astraladhesive.com"; 
						$usermail->Password   = "info123!@#";		
						$usermail->setFrom('info@astraladhesive.com', 'Astral Adhesives');		
						$usermail->addReplyTo('info@astraladhesive.com', 'Astral Adhesives'); 					
						$usermail->isHTML(true);

						$usermail->addAddress(strtolower($email), $name);								
						//$mail->addBCC('santhosh.nair@bcwebwise.com', 'Santhosh');
						
						$usermail->Subject  = "Applied job ".$jobdata['job_code'];
						$usermail->Body     = "You have successfully applied the job! Your ref. no is AA000-".$user_id;
						
						if(!$usermail->send()){					
							$message_serve1	= "Thankyou";
						}else{
							$message_serve1 = 'Thankyou';
						}


						 $mail 	= new PHPMailer;				
						$mail->isHTML(true);								
						$mail->IsSMTP();
						$mail->Mailer 	  = "smtp";
						$mail->Host       = "astraladhesive.com"; 
						$mail->SMTPDebug  = 0; 
						$mail->SMTPAuth   = true; 
						$mail->Port       = 25;
						$mail->SMTPSecure = 'TLS';
						$mail->Username   = "info@astraladhesive.com"; 
						$mail->Password   = "info123!@#";		
						$mail->setFrom('info@astraladhesive.com', 'Astral Adhesives');		
						$mail->addReplyTo('info@astraladhesive.com', 'Astral Adhesives'); 					
						$mail->isHTML(true);

						$mail->addAddress('tanushree.ganguly@bcwebwise.com', 'Admin');								
						//$mail->addBCC('santhosh.nair@bcwebwise.com', 'Santhosh');
						
						$mail->Subject  = "New Application for ".$jobdata['job_code'];
						$mail->Body     = "New Application ref. no is AA000-".$user_id.". Please check your cms.";
						
						if(!$mail->send()){					
							$message_serve	= "Thankyou";
						}else{
							$message_serve = 'Thankyou';
						}
		


		exit; 
	}
else{
	echo "0"; exit;
}

}else{
	echo "0"; exit;
}

?>

 