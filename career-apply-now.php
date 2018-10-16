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
if(!class_exists('PHPMailer')){
  if( !require_once( 'include/PHPMailer/PHPMailerAutoload.php' )){
    die('PHPMailer Class Does not Exists!');
  }else{    
    $mail   = new PHPMailer();
  }
}
$POST   =   $objTypes->validateUserInput($_REQUEST);
function smssendotp($ref_no,$mobile)
{
        $ch = curl_init();  // initiate curl
        $url = "http://www.smsjust.com/sms/user/urlsms.php?"; // where you want to post data - final
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, true);  // tell curl you want to post something
        curl_setopt($ch, CURLOPT_POSTFIELDS, "username=astralpoly&pass=aptl@2017&senderid=ASTRAL&dest_mobileno=$mobile&message=Thank you for contacting us, your application reference number is $ref_no&response=Y"); 
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
$jobid  =   intval($POST['id']);
$result =   $objTypes->fetchRow("select job_code,department,title,to_experience,id from tbl_careers where id=".$jobid);
$year   =   date('Y');
$v      =   $year-30;
function pancard_validation($pan_no)
{
  if (!preg_match("/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/", $pan_no)) {
      return false; 
    }else{
      return true; 
    }
}
function aadhaar_validation($aadhaar_no)
{
  if (!preg_match("/^[0-9]{12}+$/", $aadhaar_no)) {
      return false; 
    }else{
      return true; 
    }
}
if(isset($POST['data']) && $POST['data']=='1')
{
  $error   = "";
  $flag    = true;
  $job_code= noHTML(addslashes(strip_tags(trim($POST['job_code']))));
  $function= noHTML(addslashes(strip_tags(trim($POST['function']))));
  $experience= noHTML(addslashes(strip_tags(trim($POST['experience']))));
  $job_title= noHTML(addslashes(strip_tags(trim($POST['job_title']))));
  $name    = noHTML(addslashes(strip_tags(trim($POST['name']))));
  $email   = noHTML(addslashes(strip_tags(trim($POST['email']))));
  $decodeemail= html_entity_decode($email, ENT_QUOTES | ENT_HTML5, 'UTF-8');
  $mobile  = noHTML(addslashes(strip_tags(trim($POST['mobile']))));
  $gender  = noHTML(addslashes(strip_tags(trim($POST['gender']))));
  $pan     = noHTML(addslashes(strip_tags(trim($POST['pan']))));
  $aadhar  = noHTML(addslashes(strip_tags(trim($POST['aadhar']))));
  $country = noHTML(addslashes(strip_tags(trim($POST['country']))));
  $city    = noHTML(addslashes(strip_tags(trim($POST['city']))));
  $dob1    = noHTML(trim(strip_tags(addslashes($POST['dob']))));
  $dob  = html_entity_decode($dob1, ENT_QUOTES | ENT_HTML5, 'UTF-8');
  if($country=='India'){
     $state    = noHTML(addslashes(strip_tags(trim($POST['state']))));
   }else{
     $state    = noHTML(addslashes(strip_tags(trim($POST['state_input']))));
   }
  $alternate= noHTML(addslashes(strip_tags(trim($POST['alternate']))));
  $language= noHTML(addslashes(strip_tags(trim($POST['language']))));
  $medium   = noHTML(addslashes(strip_tags(trim($POST['medium']))));
  $year_from    = noHTML(addslashes(strip_tags(trim($POST['year_from']))));
  $year_to    = noHTML(addslashes(strip_tags(trim($POST['year_to']))));
  $institute_name= noHTML(addslashes(strip_tags(trim($POST['institute_name']))));
  $decodeinstitute_name= html_entity_decode($institute_name, ENT_QUOTES | ENT_HTML5, 'UTF-8');
  $institute_state= noHTML(addslashes(strip_tags(trim($POST['institute_state']))));
  $institute_city= noHTML(addslashes(strip_tags(trim($POST['institute_city']))));
  $qualification=noHTML(addslashes(strip_tags(trim($POST['qualification']))));
  $course=noHTML(addslashes(strip_tags(trim($POST['course']))));
  $evalution=noHTML(addslashes(strip_tags(trim($POST['evalution']))));
  $result_marks=noHTML(addslashes(strip_tags(trim($POST['result']))));
  $job_id= noHTML(addslashes(strip_tags(trim($POST['job_id']))));
  $willing_relocate= noHTML(addslashes(strip_tags(trim($POST['willing_relocate']))));
  $option_state= noHTML(addslashes(strip_tags(trim($POST['option_state']))));
  $option_city1= noHTML(addslashes(strip_tags(trim($POST['option_city']))));
  $option_city= html_entity_decode($option_city1, ENT_QUOTES | ENT_HTML5, 'UTF-8');
  $notice_period= noHTML(addslashes(strip_tags(trim($POST['notice_period']))));
  $resume_title= noHTML(addslashes(strip_tags(trim($POST['resume_title']))));
  $jobdata= noHTML(addslashes(strip_tags(trim($POST['jobdata']))));
        if($token->validateKey() == false){
          $error = "There is some problem, please try again.";    
          $flag  = false;
        }
        if(strlen($error)<=0){
          if($name==""){
          $error  = "Please enter name";
          $flag = false;
          $nameclass = "errorRed";
        }elseif(!preg_match('/^[a-z A-Z ]+$/',$name)){
          $error  = "Please enter valid name";
          $flag = false;
          $nameclass = "errorRed";
        }elseif(strlen($name_ser) > '75'){
          $error  = "Please enter valid name";
          $flag = false;
          $nameclass = "errorRed";
        }
        }
        if(strlen($error)<=0){
        if(strlen($error)<=0 && strlen($dob1)<=0){
          $error="Please select date of birth."; $flag=false;
          $dobclass = "errorRed";
        }else if(preg_match("/^(\d{4})\/(\d{2})\/(\d{2})$/", $dob, $matches)) {
          if(checkdate($matches[2], $matches[3], $matches[1])) { 
            if(!in_array($matches[1], range(1930, date('Y')))){
              $error="Please select valid year."; $flag=false;
              $dobclass = "errorRed";
            }
            if(!in_array($matches[2], range(1, 12))){
              $error="Please select valid month."; $flag=false;
               $dobclass = "errorRed";
            }
            if(!in_array($matches[3], range(1, 31))){
              $error="Please select valid date."; $flag=false;
               $dobclass = "errorRed";
            }
          }
          else{
             $error="Please select valid date of birth."; $flag=false;
              $dobclass = "errorRed";
          }
        }else if(!preg_match("/^[0-9\/]+$/D",$dob) && strlen($error)<=0) 
        {
          $error="Please enter valid date of birth."; $flag=false;
          $dobclass = "errorRed";
        }
        }
        if(strlen($error)<=0){
          if($pan!='')
          {    
            $pan_exist = pancard_validation($pan);
            if($pan_exist==false){
              $error  = "Please enter valid pan no";
              $flag = false;
              $panclass = "errorRed";
            } 
          }
        }
        if(strlen($error)<=0){
        if($aadhar!='')
        {
          $exist = aadhaar_validation($aadhar); 
          if($exist==false){
            $error  = "Please enter valid aadhar no";
            $flag = false;
            $aadharclass = "errorRed";
          }
        }
      }
      if(strlen($error)<=0){
        if($email=="" ){
          $error  = "Please enter email id";
          $flag = false;
          $emailclass = "errorRed";
        }else if($email!=''){   
          if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/",$decodeemail)) 
          {
            $error="Plesae enter valid emailid ";
            $flag=false;
            $emailclass = "errorRed";
          }
        }
      }
      if(strlen($error)<=0){
        if($mobile=="" ){
          $error  = "Please enter mobile number";
          $flag = false;
          $mobileclass = "errorRed";
        }
        if($mobile!='') 
        { 
            if(strlen($mobile)!='10')
            { 
              $error="Please Enter 10 Digit Mobile.";
              $flag=false;
              $mobileclass = "errorRed";
            }
            if(!preg_match("/^[0-9]{10}+$/",$mobile)) 
            {
              $error="Plesae enter valid mobile number and max 10 digit";
              $flag=false;
              $mobileclass = "errorRed";
            }
        }
      }
      if(strlen($error)<=0){
        if($country =='') 
        {   
            $error="Please enter state"; 
            $flag=false;
            $countryclass = "errorRed";
        }
        if($country!='') 
        { 
            if(!preg_match("/^[a-z A-Z &]+$/",$country)) 
            {
              $error="Please enter valid state"; 
              $flag =false;
              $countryclass = "errorRed";
            }
        }
        }
      if(strlen($error)<=0){
        if($state =='') 
        {   
            $error="Please enter state"; 
            $flag=false;
            $stateclass = "errorRed";
        }
        if($state!='') 
        { 
            if(!preg_match("/^[a-z A-Z &]+$/",$state)) 
            {
              $error="Please enter valid state"; 
              $flag =false;
              $stateclass = "errorRed";
            }
        }
        }
        if(strlen($error)<=0){
        if($city =='') 
        {   
            $error="Please enter city"; 
            $flag=false;
            $cityclass = "errorRed";
        }
        if($city!='') 
        { 
            if(!preg_match("/^[a-z A-Z]+$/",$city)) 
            {
              $error="Please enter valid city"; 
              $flag =false;
              $cityclass = "errorRed";
            }
        } 
      }
      if(strlen($error)<=0){
        if($language!='') 
        { 
            if(!preg_match("/^[a-z A-Z]+$/",$language)) 
            {
              $error="Please enter valid language"; 
              $flag =false;
              $languageclass = "errorRed";
            }
        }
     }
     if(strlen($error)<=0){
        if($alternate!='') 
        { 
          if(strlen($alternate)!='10')
          { 
            $error="Please Enter 10 Digit Mobile.";
            $flag=false;
            $alternateclass = "errorRed";
          }
          if(!preg_match("/^[0-9]{10}+$/",$alternate)) 
          {
            $error="Plesae enter valid alternate number and max 10 digit";
            $flag=false;
            $alternateclass = "errorRed";
          }
        }
      }
      if(strlen($error)<=0){
         if($medium!='') 
        { 
            if(!preg_match("/^[a-z A-Z]+$/",$medium)) 
            {
              $error="Please enter valid medium"; 
              $flag =false;
              $mediumclass = "errorRed";
            }
        }
      }
      if(strlen($error)<=0){
        if($qualification!='') 
        { 
            if(!preg_match("/^[a-z A-Z0-9]+$/",$qualification)) 
            {
              $error="Please enter valid qualification"; 
              $flag =false;
              $qualificationclass = "errorRed";
            }
        }
      }
      if(strlen($error)<=0){
        if($decodeinstitute_name!='') 
        {   
          if(!preg_match("/^[a-z A-Z ,()&\.\- ]{1,50}+$/",$decodeinstitute_name)) 
          {
            $error="Please enter valid institute name, allowed specialcharacters (,()&.-) and max 50 characters";
            $flag=false;
            $institutenameclass = "errorRed";
          }
        }
      }
      if(strlen($error)<=0){
         if($year_from!='') 
        { 
            if(!preg_match("/^[0-9]+$/",$year_from)) 
            {
              $error="Please enter valid year from"; 
              $flag =false;
              $yearfromclass = "errorRed";
            }
        }
      }
      if(strlen($error)<=0){
        if($year_to!='') 
        { 
            if(!preg_match("/^[0-9]+$/",$year_to)) 
            {
              $error="Please enter valid year to"; 
              $flag =false;
              $yeartoclass = "errorRed";
            }
        }
      }
      if(strlen($error)<=0){
        if($institute_state!='') 
        {   
          if(!preg_match("/^[a-zA-Z ]+$/",$institute_state)) 
          {
            $error="Please enter valid institute state";
            $flag=false;
            $institutestateclass = "errorRed";
          }
        }
      }
      if(strlen($error)<=0){
        if($institute_city!='') 
        {   
          if(!preg_match("/^[a-zA-Z ]+$/",$institute_city)) 
          {
            $error="Please enter valid institute city";
            $flag=false;
            $institutecityclass = "errorRed";
          }
        }
      }
      if(strlen($error)<=0){
        if($course!='') 
        {   
          if(!preg_match("/^[a-zA-Z 0-9]+$/",$course)) 
          {
            $error="Please enter valid course";
            $flag=false;
            $courseclass = "errorRed";
          }
        }  
      }
      if(strlen($error)<=0){
        if($evalution!='') 
        {   
          if(!preg_match("/^[a-zA-Z ]+$/",$evalution)) 
          {
            $error="Please enter valid evalution";
            $flag=false;
            $evalutionclass = "errorRed";
          }
        }
      }
      if(strlen($error)<=0){
        if($result_marks!='') 
        {   
          if(!preg_match("/^[a-zA-Z 0-9]+$/",$result_marks)) 
          {
            $error="Please enter valid result";
            $flag=false;
            $resultmarkclass = "errorRed";
          }
        }  
      }
      if(strlen($error)<=0){
       if($option_state!='') 
        {   
          if(!preg_match("/^[a-zA-Z ]+$/",$option_state)) 
          {
            $error="Please enter valid option state";
            $flag=false;
            $optionstateclass = "errorRed";
          }
        }
      }
      if(strlen($error)<=0){
      if($option_city!='') 
      {   
        if(!preg_match("/^[a-zA-Z ,]+$/",$option_city)) 
        {
          $error="Please enter valid option city, Allowed only ','";
          $flag=false;
          $optioncityclass = "errorRed";
        }
      } 
    }
    if(strlen($error)<=0){
      if($notice_period!='') 
      {   
        if(!preg_match("/^[a-zA-Z 0-9]+$/",$notice_period)) 
        {
          $error="Please enter valid notice period";
          $flag=false;
          $noticeperiodclass = "errorRed";
        }
      } 
    }
    if(strlen($error)<=0){
      if($resume_title!='') 
      {   
        if(!preg_match("/^[a-zA-Z 0-9]+$/",$resume_title)) 
        {
          $error="Please enter title";
          $flag=false;
          $resumetitleclass = "errorRed";
        }
      }
    }
      if(strlen($error)<=0){
      if(isset($_FILES['resume']['name']) && $_FILES['resume']['name'] != ""){
        $ext      = pathinfo($_FILES['resume']['name'], PATHINFO_EXTENSION);
        $ext      = strtolower($ext);
        $validatefiles  = array("pdf", "PDF","doc","Doc","docx","DOCX");
       // $filetype     = array('application/pdf');
        if(in_array($ext, $validatefiles) == false){
          $error  = "File type is not supported. Allowed only pdf and doc"; 
          $flag=false;
        }
      }
    }
    if(strlen($error)<=0){
      if($_FILES['resume']['size'] > 3097152){
          $error  = "Maximum file size 3mb"; 
          $flag=false;
        }
        }
    if($flag==true && strlen($error)<=0){
      $insertarray = array(
                'name'    => $name,
                'email'   => $decodeemail,
                'mobile'  => $mobile,
                'gender'  => $gender,
                'pan_no'  => $pan,
                'job_code'=> $job_code,
                'aadhar_no'=> $aadhar,
                'country' => $country,
                'language'=> $language,
                'city'    => $city,
                'dob'     => date('Y-m-d',strtotime($dob)),
                'passing_year'    => $year_from."-".$year_to,
                'state'    => $state,
                'medium'    => $medium,
                'institute_name'    => $decodeinstitute_name,
                'institute_state'    => $institute_state,
                'institute_city'    => $institute_city,
                'course'    => $course,
                'result'    => $result_marks,
                'qualification'    => $qualification,
                'evalution'    => $evalution,
                'alternate_no'=> $alternate,
                'job_id'=> $job_id,
                'ip'    => $_SERVER['REMOTE_ADDR'],
                'agent'     => addslashes($_SERVER['HTTP_USER_AGENT'])
               );
      $result_apply = $objTypes->fetchAll("SELECT * FROM tbl_career_apply WHERE email = '".$decodeemail."' and job_id= '".$job_id."' and is_delete = 1 and is_active = 1");
      if(sizeof($result_apply) == 0 ){
       //print_r($insertarray);
      $insert_serve = $objTypes->insert("tbl_career_apply", $insertarray);
     // print_r($insert_serve);
      //echo '============'; exit;
      if($insert_serve)
      {
                $userid = $objTypes->lastInsertId()     ;
                $ref_no = 'AA000-'.$userid;
                $params = array(
                                 'ref_no'    => 'AA000-'.$userid
                             );
                          //$objTypes->update($UpdatePdfArray,"id = '".$id."'");
                            $where  = array(
                              ':id'          => $userid
                          );
                          $update = $objTypes->update("tbl_career_apply", $params, "id = :id", $where);
                                      $sendotp = smssendotp($ref_no, $mobile); 
                          $insertsecond= array(
                                      'job_id'=> $job_id,
                                      'user_id'=> $userid,
                                      'willing_relocate'=> $willing_relocate, 
                                      'option_state'=> $option_state, 
                                      'option_city'=> $option_city, 
                                      'notice_period'=> $notice_period,        
                                      'resume_title'=> $resume_title
                                  );
        //echo $insert_serve;
                            //print_r($insertsecond);
                         $insert_serve1 = $objTypes->insert("tbl_job_user", $insertsecond);
                             // echo '****';
                          if($insert_serve1)
                          {  
                              $id = $objTypes->lastInsertId();
                              if(isset($_FILES['resume']['name']) && $_FILES['resume']['name'] != ""){
                                    $ext      = pathinfo($_FILES['resume']['name'], PATHINFO_EXTENSION);
                                    $ext      = strtolower($ext);
                                    $validatefiles  = array("pdf", "PDF","doc","Doc","docx","DOCX");
                                   // $filetype     = array('application/pdf');
                                    if(in_array($ext, $validatefiles) == false){
                                      $error  = "File type is not supported. Allowed only pdf and doc"; 
                                    }
                                   /* if(in_array(strtolower($_FILES['resume']['type']), $filetype) == false ){
                                      $error  = "File type is not supported"; 
                                    }*/
                                    if($error==""){       
                                      $ext    = pathinfo($_FILES['resume']['name'], PATHINFO_EXTENSION);
                                      $filename = basename($_FILES['resume']['name'], $ext);      
                                      $filename = 'resume_'.time().'.'.$ext;
                                      $movefile = move_uploaded_file($_FILES['resume']['tmp_name'], "uploads/resume/".$filename);
                                      //$UpdatePdfArray = array('catalogue' => $filename);
                                      $params = array(
                                          'resume'    => $filename
                                         ); 
                                      //$objTypes->update($UpdatePdfArray,"id = '".$id."'");
                                        $where  = array(
                                          ':id'          => $id
                                      );
                                      $update = $objTypes->update("tbl_job_user", $params, "id = :id", $where);
                                  }
                              }
                              for($x=1;$x<=$jobdata;$x++){
                                  $employment_status= noHTML(addslashes(strip_tags(trim($POST['employment_status_'.$x]))));
                                  $employer= noHTML(addslashes(strip_tags(trim($POST['employer_'.$x]))));
                                  $industry_type1= noHTML(addslashes(strip_tags(trim($POST['industry_type_'.$x]))));
                                  $industry_type= html_entity_decode($industry_type1, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                                  $reporting_to= noHTML(addslashes(strip_tags(trim($POST['reporting_to_'.$x]))));
                                  $role= noHTML(addslashes(strip_tags(trim($POST['role_'.$x]))));
                                  $ctc1= noHTML(addslashes(strip_tags(trim($POST['ctc_'.$x]))));
                                  $ctc= html_entity_decode($ctc1, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                                  $designation1= noHTML(addslashes(strip_tags(trim($POST['designation_'.$x]))));
                                  $gross1= noHTML(addslashes(strip_tags(trim($POST['gross_'.$x]))));
                                  $gross= html_entity_decode($gross1, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                                  $designation1= noHTML(addslashes(strip_tags(trim($POST['designation_'.$x]))));
                                  $designation= html_entity_decode($designation1, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                                  $start_date1=noHTML(trim(strip_tags(addslashes($POST['start_date_'.$x]))));
                                  $start_date  = html_entity_decode($start_date1, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                                   if(strlen($error)<=0){
                                   if($employment_status!='')
                                  {
                                    if(!preg_match("/^[a-zA-Z ]+$/",$employment_status)) 
                                    {
                                      $error="Please enter valid employer";
                                      $flag=false;
                                      $employmentstatusclass = "errorRed";
                                    }
                                  }
                                }
                                if(strlen($error)<=0){
                                  if($employer!='')
                                  {
                                    if(!preg_match("/^[a-zA-Z ]+$/",$employer)) 
                                    {
                                      $error="Please enter valid employer";
                                      $flag=false;
                                      $employerclass = "errorRed";
                                    }
                                  }
                                }
                                if(strlen($error)<=0){
                                  if($employer!='' && $start_date1==''){
                                    $error="Please select start date."; $flag=false;
                                     $startdateclass = "errorRed";
                                  }
                                  if($start_date1!=''){
                                   if(preg_match("/^(\d{4})\/(\d{2})\/(\d{2})$/", $start_date, $matches)) {
                                    if(checkdate($matches[2], $matches[3], $matches[1])) { 
                                      if(!in_array($matches[1], range(1930, date('Y')))){
                                        $error="Please select valid year."; $flag=false;
                                        $startdateclass = "errorRed";
                                      }
                                      if(!in_array($matches[2], range(1, 12))){
                                        $error="Please select valid month."; $flag=false;
                                         $startdateclass = "errorRed";
                                      }
                                      if(!in_array($matches[3], range(1, 31))){
                                        $error="Please select valid date."; $flag=false;
                                         $startdateclass = "errorRed";
                                      }
                                    }
                                    else{
                                       $error="Please select valid start date."; $flag=false;
                                        $startdateclass = "errorRed";
                                    }
                                  }else if(!preg_match("/^[0-9\/]+$/D",$start_date) && strlen($error)<=0) 
                                  {
                                    $error="Please enter valid start date."; $flag=false;
                                    $startdateclass = "errorRed";
                                  }
                                }
                                }
                                  if(strlen($error)<=0){
                                   if($employer!="" && $industry_type!='')
                                  {
                                    if(!preg_match("/^[a-zA-Z ]+$/",$industry_type)) 
                                    {
                                      $error="Please enter valid industry type";
                                      $flag=false;
                                      $industrytypeclass = "errorRed";
                                    }
                                  }
                                }
                                if(strlen($error)<=0){
                                   if($employer!="" && $designation!='')
                                  {
                                    if(!preg_match("/^[a-zA-Z \.\-]+$/",$designation)) 
                                    {
                                      $error="Please enter valid designation";
                                      $flag=false;
                                      $designationclass = "errorRed";
                                    }
                                  }
                                }
                                  if(strlen($error)<=0){
                                  if($employer!="" && $reporting_to!='')
                                  {
                                    if(!preg_match("/^[a-zA-Z ]+$/",$reporting_to)) 
                                    {
                                      $error="Please enter valid reporting to";
                                      $flag=false;
                                      $reportingtoclass = "errorRed";
                                    }
                                  }
                                }
                                  if(strlen($error)<=0){
                                  if($employer!="" && $role!='')
                                  {
                                    if(!preg_match("/^[a-zA-Z ]+$/",$role)) 
                                    {
                                      $error="Please enter valid role";
                                      $flag=false;
                                      $roleclass = "errorRed";
                                    }
                                  }
                                }
                                if(strlen($error)<=0){
                                  if($employer!="" && $ctc!='')
                                  {
                                    if(!preg_match("/^[a-zA-Z 0-9 \.]+$/",$ctc)) 
                                    {
                                      $error="Please enter valid ctc";
                                      $flag=false;
                                      $ctcclass = "errorRed";
                                    }
                                  }
                                }
                                if(strlen($error)<=0){
                                  if($employer!="" && $gross!='')
                                  {
                                    if(!preg_match("/^[a-zA-Z 0-9 \.]+$/",$gross)) 
                                    {
                                      $error="Please enter valid gross";
                                      $flag=false;
                                      $grossclass = "errorRed";
                                    }
                                  }
                                }
                                 /* if($start_date!='')
                                  {
                                    if(!preg_match("/^[ 0-9]+$/",$start_date)) 
                                    {
                                      $error="Please enter valid start date";
                                      $flag=false;
                                    }
                                  }*/
                                  if($employer!="" && $flag==true){
                                    $insert3= array(
                                                'job_id'=> $job_id,
                                                'user_id'=> $userid,
                                                'employee_status'=> $employment_status, 
                                                'current_employer'=> $employer, 
                                                'industry_type'=> $industry_type, 
                                                'role'=> $role,  
                                                'designation'=> $designation,       
                                                'reporting_to'=> $reporting_to,
                                                'ctc'=> $ctc,
                                                'start_date'=> date('Y-m-d',strtotime($start_date)),
                                                'gross'=> $gross
                                                    );
                                    $insert_serve3 = $objTypes->insert("tbl_job_detail", $insert3);
                                  }
                              }
                          }
                  }                              
                 if($flag==true && strlen($error)<=0) 
                 {               
                 $name=$email=$mobile=$country=$city=$state=$pan=$aadhar=$language=$medium=$dob=$gender=$institute_name=$institute_city=$institute_state=$course=$result_marks=$qualification=$alternate=$evalution=$year_from=$year_to=$employment_status=$employer=$industry_type=$role=$designation=$reporting_to=$ctc=$start_date=$gross=$option_state=$option_city=$notice_period=$resume_title=$decodeinstitute_name="";   
                $error="Successfully applied for Job..!";
                 }              
              }else{
                 $error="Already applied.";
              }             
            } 
      }
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
    <title>Astral Pipes | Career Form</title>
	<meta name="description" content="Astral Pipes | Career Form" />    
    <meta name="keywords" content="Astral Pipes | Career Form" />
    <link href="<?=base_url?>assets/images/favicon.ico" rel="shortcut icon" type="" />
    <link href="<?=base_url?>assets/css/main.css" rel="stylesheet" type="text/css">
    <link href="<?=base_url?>css/jquery-ui.css" rel="stylesheet" type="text/css">
	<?php include_once('include/googlecode.php'); ?>
</head>
<body>
<?php include_once('include/othercode.php'); ?>
    <div id="wrapper">
    <?php include_once('include/header.php'); ?>
        <section id="breadcrumbs">
            <div class="container">
                <a href="<?=base_url?>">Home</a> Careers
            </div>
        </section>
        <section id="siteInner" class="careerForm">
            <div class="container">
                <a href="<?=base_url?>career" class="backBtn">Back</a>
                <div class="sect_title inner_title">
                    <h1>
                        <span>Careers</span>
                    </h1>
                    <div class="tl_bg">Careers</div>
                </div>
                <div class="careerCon">
                    <form name='career_form' method='post' enctype='multipart/form-data'>
                    <div class="cr_form_con">
                        <div class="head_tl_holder">
                            <h3>Position Applying For</h3>
                            <div><?php echo $token->outputKey();?></div>
                            <input type="hidden" name="job_id" value="<?php echo $jobid;?>">
                            <input type="hidden" name="user_id" value="">
                            <input type="hidden" name="job_code" value="<?php echo $result['job_code'];?>">
                            <input type="hidden" name="data" value="1">
                            <input type="hidden" name="jobdata" id="jobdata" value="1">
                            <input type="hidden" name="job_title" id="job_title" value="<?php echo stripslashes($result['title']);?>">
                            <input type="hidden" name="function" id="function" value="<?php echo stripslashes($result['department']);?>">
                        </div>
                        <ul class="applying_for">
                            <li>
                                <span>
                                    <input type="text" class="textBox" value="<?php  echo stripslashes($result['title']);?>" readonly>
                                </span>
                            </li>
                            <li>
                                <span>
                                    <?php  if($result['to_experience']==0 || $experience=0) {?>
                                       <input type="text"  class="textBox" value="Fresher" readonly> 
                                    <?php  }if($result['to_experience']>0 || $experience>0){?>
                                        <input type="text"  class="textBox" value="Experienced" readonly>
                                    <?php }?>
                                </span>
                            </li>
                            <li>
                                <span>
                                    <input type="text" class="textBox" value="<?php echo stripslashes($result['department']);?>" readonly>
                                </span>
                            </li>
                            <li>
                                <span>
                                    <input type="text" placeholder="Website" class="textBox" readonly>
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="errMsg"><?php echo $error;?></div>
                    <div class="cr_form_con">
                        <div class="head_tl_holder">
                            <h3>Personal Information</h3>
                        </div>
                        <ul class="per_info">
                            <li>
                                <span><strong>Name*</strong></span>
                                <span id="namebox">
                                   <input type="text" name="name" id="name" class="textBox <?php echo $nameclass;?>" value="<?php echo $name;?>">
                                   <span></span>
                                </span>
                            </li>
                            <li>
                                <span><strong>Date of Birth*</strong></span>
                                <span>
                                  <input type="text" class="calendarBox <?php echo $dobclass;?>" name="dob" id="dob" value="<?php if($dob!=''){ echo date('m/d/Y',strtotime($dob));}?>" readonly>
                                </span>
                            </li>
                            <li>
                                <span><strong>Gender</strong></span>
                                 <span>
                                  <input type="radio" name="gender" id="Male" value="0" checked>
                                  <label for="Male">Male</label>
                                  <input type="radio" name="gender" id="Female" value="1" <?php if($gender=="1") echo "checked";?>>
                                  <label for="Female">Female</label>
                                  <input type="radio" name="gender" id="Other" value="2" <?php if($gender=="2") echo "checked";?>>
                                  <label for="Other">Other</label>
                                </span>
                            </li>
                            <li></li>
                            <li>
                                <span><strong>Pan Number</strong></span>
                                <span id="panbox">
                                  <input type="text" class="textBox <?php echo $panclass;?>" name="pan" id="pan" value="<?php echo $pan;?>" maxlength="10">
                                  <span></span>
                                </span>
                            </li>
                            <li>
                                <span><strong>Aadhaar Number</strong></span>
                                 <span id="aadharbox">
                                  <input type="text" class="textBox <?php echo $aadharclass;?>" name="aadhar" id="aadhar" value="<?php echo $aadhar;?>" maxlength="12">
                                  <span></span>
                                </span>
                            </li>
                            <li>
                                <span><strong>Language Know</strong></span>
                               <span>
                                  <input type="radio" id="Hindi" name="language" value="hindi" checked>
                                  <label for="Hindi">Hindi</label>
                                  <input type="radio" id="English" name="language" value="english" <?php if($language=="english") echo "checked";?>>
                                  <label for="English">English</label>
                                  <input type="radio" id="Gujrati" name="language" value="gujrati" <?php if($language=="gujrati") echo "checked";?>>
                                  <label for="Gujrati">Gujrati</label>
                                  <input type="radio" id="Marathi" name="language" value="marathi" <?php if($language=="marathi") echo "checked";?>>
                                  <label for="Marathi">Marathi</label>
                                  <input type="radio" id="Telgu" name="language" value="telegu" <?php if($language=="telegu") echo "checked";?>>
                                  <label for="Telgu">Telgu</label>
                                  <input type="radio" id="Otherlan" name="language" value="other" <?php if($language=="other") echo "checked";?>>
                                  <label for="Otherlan">Other</label>
                                </span>
                            </li>
                        </ul>
                        <ul>
                            <li>
                                <span><strong>Country</strong></span>
                                <span>
                                  <select name="country" id="country" class="selectBox <?php echo $countryclass;?>">
                                    <option value="India"  <?php if($language=="other") echo "selected";?>>India</option>
                                  </select>
                                </span>
                            </li>
                            <li>
                                <span><strong>State*</strong></span>
                                <span id="statebox">
                                  <select id="state_select" name="state" class="selectBox <?php echo $stateclass;?>">
                                    <option value="">State</option>
                                    <?php
                                    $params     = array(":is_active" => '1');
                                    $state_arr  = $objTypes->fetchAll("SELECT state_name,state_id  FROM tbl_state_master WHERE is_active = :is_active", $params);
                                    if(sizeof($state_arr) > 0){
                                      foreach($state_arr as $state_v){                            
                                        ?>
                                      <option value="<?php echo $state_v['state_name'] ?>" <?php echo ($state==$state_v['state_name']) ? 'selected': ''?>><?php echo ucfirst(strtolower($state_v['state_name'])); ?></option>
                                    <?php } }  ?>
                                  </select>
                                  <p>        
                                    <input type="text" class="textBox <?php echo $stateclass;?>" id="state_input" name="state_input" value="<?php echo $state;?>" > 
                                    <span></span> 
                                  </p>
                                </span>
                            </li>
                            <li>
                                <span><strong>City*</strong></span>
                                <span id="citybox">
                                   <input type="text" class="textBox <?php echo $cityclass;?>" name="city" id="city_input" value="<?php echo $city;?>">
                                   <span></span>
                                </span>
                            </li>
                            <li>
                                <span><strong>Mobile*</strong></span>
                                <span id="mobilebox">
                                  <input type="text" name="mobile" id="mobile" value="<?php echo $mobile;?>" class="textBox <?php echo $mobileclass;?>" maxlength="10">
                                  <span></span>
                                </span>
                            </li>
                            <li>
                                <span><strong>Email*</strong></span>
                                <span>
                                  <input type="text" name="email" id="email" value="<?php echo $email;?>" class="textBox <?php echo $emailclass;?>">
                                </span>
                            </li>
                            <li>
                                <span><strong>Alternate No</strong></span>
                                <span id="alternatebox">
                                  <input type="text" name="alternate" id="alternate" value="<?php echo $alternate;?>" class="textBox <?php echo $alternateclass;?>" maxlength="10">
                                  <span></span>
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="cr_form_con">
                        <div class="head_tl_holder">
                            <h3>Education Details</h3>
                        </div>
                        <ul>
                            <li>
                                <span><strong>Medium Of Study During School</strong></span>
                                <span>
                                  <select name="medium" id="medium" class="selectBox">
                                    <option value="english" <?php echo ($medium=="english") ? 'selected': ''?>>English</option>
                                    <option value="hindi" <?php echo ($medium=="hindi") ? 'selected': ''?>>Hindi</option>
                                    <option value="gujrati" <?php echo ($medium=="gujrati") ? 'selected': ''?>>Gujrati</option>
                                    <option value="marathi" <?php echo ($medium=="marathi") ? 'selected': ''?>>Marathi</option>
                                    <option value="telgu" <?php echo ($medium=="telgu") ? 'selected': ''?>>Telgu</option>
                                    <option value="malayalam" <?php echo ($medium=="malayalam") ? 'selected': ''?>>Malayalam</option>
                                    <option value="other" <?php echo ($medium=="other") ? 'selected': ''?>>Other</option>
                                  </select>
                                </span>
                            </li>
                            <li>
                                <span><strong>Highest Qualification</strong></span>
                                <span>
                                  <select name="qualification" id="qualification" class="selectBox <?php echo $qualificationclass;?>">
                                    <option value="10th Pass" <?php echo ($qualification=="10th Pass") ? 'selected': ''?>>10th Pass</option>
                                    <option value="12th Pass" <?php echo ($qualification=="12th Pass") ? 'selected': ''?>>12th Pass</option>
                                    <option value="Graduation" <?php echo ($qualification=="Graduation") ? 'selected': ''?>>Graduation</option>
                                    <option value="Master Degree" <?php echo ($qualification=="Master Degree") ? 'selected': ''?>>Master Degree</option>
                                    <option value="PDGCA" <?php echo ($qualification=="PDGCA") ? 'selected': ''?>>PDGCA</option>
                                    <option value="Phd" <?php echo ($qualification=="Phd") ? 'selected': ''?>>Phd</option>
                                  </select>
                                </span>
                            </li>
                            <li>
                                <span><strong>Institute Name</strong></span>
                                <span id="institutebox">
                                  <input type="text" class="textBox <?php echo $institutenameclass;?>" name="institute_name" id="institute" value="<?php echo $institute_name;?>">
                                  <span></span>
                                </span>
                            </li>
                            <li class="year_passing">
                                <span><strong>Years Of Passing Between</strong></span>
                                <span>
                                  <select name="year_from" id="year_from" class="selectBox <?php echo $yearfromclass;?>">
                                    <option value="">From</option>
                                    <?php
                                      for($i=$year;$i>$v;$i--){
                                    ?>
                                    <option value="<?php echo $i;?>" <?php echo ($year_from==$i) ? 'selected': ''?>><?php echo $i;?></option>
                                  <?php }?>
                                  </select>
                                  <select name="year_to" id="year_to" class="selectBox <?php echo $yeartoclass;?>">
                                    <option value="">To</option>
                                    <?php
                                      for($i=$year;$i>$v;$i--){
                                    ?>
                                     <option value="<?php echo $i;?>" <?php echo ($year_to==$i) ? 'selected': ''?>><?php echo $i;?></option>
                                    <?php }?>
                                  </select>
                                </span>
                            </li>
                            <li>
                                <span><strong>State/ Union Territory</strong></span>
                                <span id="institute_statebox">
                                  <input type="text" class="textBox <?php echo $institutestateclass;?>" name="institute_state" id="institute_state" value="<?php echo $institute_state;?>">
                                  <span></span>
                                </span>
                            </li>
                            <li>
                                <span><strong>City</strong></span>
                                <span id="institute_citybox">
                                  <input type="text" class="textBox <?php echo $institutecityclass;?>" name="institute_city" id="institute_city" value="<?php echo $institute_city;?>"><span></span>
                                </span>
                            </li>
                            <li>
                                <span><strong>Course</strong></span>
                                <span id="coursebox">
                                  <input type="text" class="textBox <?php echo $courseclass;?>" name="course" id="course" value="<?php echo $course;?>">
                                  <span></span>
                                </span>
                            </li>
                            <li>
                                <span><strong>Evalution Methodology</strong></span>
                                <span>
                                  <select name="evalution" id="evalution" class="selectBox <?php echo $evalutionclass;?>">
                                    <option value="Grade" <?php echo ($evalution=="Grade") ? 'selected': ''?>>Grade</option>
                                    <option value="CPI" <?php echo ($evalution=="CPI") ? 'selected': ''?>>CPI</option>
                                    <option value="Ranking" <?php echo ($evalution=="Ranking") ? 'selected': ''?>>Ranking</option>
                                    <option value="Class" <?php echo ($evalution=="Class") ? 'selected': ''?>>Class</option>
                                    <option value="Score" <?php echo ($evalution=="Score") ? 'selected': ''?>>Score</option>
                                    <option value="Percentage" <?php echo ($evalution=="Percentage") ? 'selected': ''?>>Percentage</option>
                                  </select>
                                </span>
                            </li>
                            <li>
                                <span><strong>Result</strong></span>
                                <span id="resultbox">
                                  <input type="text" class="textBox <?php echo $resultmarkclass;?>" name="result" id="result" value="<?php echo $result_marks;?>">
                                  <span></span>
                                </span>
                          </li>
                        </ul>
                    </div>
                    <div class="cr_form_con cr_info">
                        <div class="head_tl_holder">
                            <h3>Job Details</h3>
                        </div>
                        <ul class="job_info">
                            <li>
                                <span><strong>Employment Status</strong></span>
                                <span>
                                  <select name="employment_status_1" id="employment_status_1" class="selectBox <?php echo $employmentstatusclass;?>" >
                                    <option value="">Select</option>
                                    <option value="Fresher" <?php echo ($employment_status=='Fresher') ? 'selected':''?>>Fresher</option>
                                    <option value="Experience" <?php echo ($employment_status=='Experience') ? 'selected':''?>>Experience</option>
                                  </select>
                                </span>
                            </li>
                            <li>
                               <span><strong>Employer</strong></span>
                                <span id="employerbox_1"><input type="text" name="employer_1" id="employer_1" class="textBox <?php echo $employerclass;?>" value="<?=$employer?>">
                                <span></span>
                            </li>
                            <li>
                                <span><strong>Start Date</strong></span>
                                <span ><input type="text" name="start_date_1" id="start_date_1" value="<?php if($start_date!=''){ echo date('m/d/Y',strtotime($start_date));}?>" class="calendarBox <?php echo $startdateclass;?>"></span>
                            </li>
                            <li>
                                <span><strong>Industry Type</strong></span>
                                <span>
                                            <select name="industry_type_1" id="industry_type_1" class="selectBox <?php echo $industrytypeclass;?>">
                                                <option value="">Select</option>
                                                <option value="account" <?php echo ($industry_type=='account') ? 'selected' : ''?>>Account</option>
                                                <option value="agriculture" <?php echo ($industry_type=='agriculture') ? 'selected':''?> >Agriculture</option>
                                                <option value="advertising" <?php echo ($industry_type=='advertising')?'selected':''?> >Advertising or Media</option>
                                                <option value="army" <?php echo ($industry_type=='army')?'selected':''?> >Army or Airforce</option>
                                                <option value="auto"  <?php echo ($industry_type=='auto')?'selected':''?>>Auto</option>
                                                <option value="banking" <?php echo ($industry_type=='banking')?'selected':''?>>Banking</option>
                                                <option value="bpo" <?php echo ($industry_type=='bpo')?'selected':''?>>BPO</option>
                                                <option value="broking_house" <?php echo ($industry_type=='broking house')?'selected':''?>>Broking house</option>
                                                <option value="cement" <?php echo ($industry_type=='cement')?'selected':''?>>Cement</option>
                                                <option value="ceramic" <?php echo ($industry_type=='ceramic')?'selected':''?>>Ceramic</option>
                                                <option value="chemical" <?php echo ($industry_type=='chemical')?'selected':''?>>Chemical</option>
                                                <option value="construction" <?php echo ($industry_type=='construction')?'selected':''?>>Construction</option>
                                                <option value="consultant" <?php echo ($industry_type=='consultant')?'selected':''?>>Consultant</option>
                                                <option value="consumer_durable" <?php echo ($industry_type=='consumer durable')?'selected':''?>>Consumer Durable</option>
                                                <option value="courier" <?php echo ($industry_type=='courier')?'selected':''?>>Courier</option>
                                                <option value="dairy" <?php echo ($industry_type=='dairy')?'selected':''?>>Dairy</option>
                                                <option value="design" <?php echo ($industry_type=='design')?'selected':''?>>Design</option>
                                                <option value="education" <?php echo ($industry_type=='education')?'selected':''?>>Education</option>
                                            </select>
                                    </span>
                            </li>
                            <li>
                                <span><strong>Designation</strong></span>
                                <span>
                                  <select name="designation_1" id="designation_1" class="selectBox <?php echo $designationclass;?>">
                                            <option option="">Select</option>   
                                            <option option="assistant" <?php echo ($designation=='assistant')?'selected':''?>>Assistant</option>                    
                                            <option option="jr_officer" <?php echo ($designation=='jr officer')?'selected':''?>>Jr. Officer</option>
                                            <option option="officer" <?php echo ($designation=='officer')?'selected':''?>>Officer</option>
                                            <option option="sr_officer" <?php echo ($designation=='sr officer')?'selected':''?>>Sr. Officer</option>                    
                                            <option option="jr_executive" <?php echo ($designation=='jr executive')?'selected':''?>>Jr. Executive</option>
                                            <option option="executive" <?php echo ($designation=='executive')?'selected':''?>>  Executive</option>
                                            <option option="sr_executive" <?php echo ($designation=='sr executive')?'selected':''?>>Sr. Executive</option>
                                            <option option="asst_manager" <?php echo ($designation=='asst manager')?'selected':''?>>Asst. Manager</option>
                                            <option option="dy_manager" <?php echo ($designation=='dy manager')?'selected':''?>>Dy. Manager</option>
                                            <option option="manager" <?php echo ($designation=='manager')?'selected':''?>>Manager</option>
                                            <option option="sr_manager" <?php echo ($designation=='sr manager')?'selected':''?>>Sr. Manager</option>
                                            <option option="asst_gm" <?php echo ($designation=='asst gm')?'selected':''?>>Asst.GM</option>
                                            <option option="dy_gm" <?php echo ($designation=='dy gm')?'selected':''?>>Dy GM</option>
                                            <option option="sr_gmvpresident" <?php echo ($designation=='sr gmvpresident')?'selected':''?>>Sr.GMVP President</option>
                                            <option option="jr_engineer" <?php echo ($designation=='jr engineer')?'selected':''?>>Jr.Engineer</option>
                                  </select>
                                </span>
                              </li>
                            <li>
                                <span><strong>Reporting To</strong></span>
                                 <span id="reportingbox_1">
                                  <input type="text" class="textBox <?php echo $reportingtoclass;?>" name="reporting_to_1" id="reporting_to_1" value="<?=$reporting_to?>">
                                  <span></span>
                                </span>
                            </li>
                            <li>
                                <span><strong>Role</strong></span>
                                <span id="rolebox_1">
                                  <input type="text" class="textBox <?php echo $roleclass;?>" name="role_1" id="role_1" value="<?=$role?>">
                                  <span></span>
                                </span>
                            </li>
                            <li>
                                <span><strong>CTC</strong></span>
                                <span id="ctcbox_1">
                                  <input type="text" id="ctc_1" class="textBox <?php echo $ctcclass;?>" name="ctc_1" value="<?=$ctc?>">
                                  <span></span>
                                </span>
                            </li>
                            <li>
                                <span><strong>Gross Salary</strong></span>
                                <span id="grossbox_1">
                                  <input type="text" id="gross_1" name="gross_1" class="textBox <?php echo $grossclass;?>" value="<?=$gross?>">
                                  <span></span>
                                </span>
                            </li>
                        </ul>
                        <!--a href="javascript:;" class="commanBtn">Add More</a-->
                    </div>
                    <div class="add_job"></div>
                    <div class="job_more" ><a href="javascript:void(0);" class="commanBtn" id="add_more" data="1">Add More</a></div>
                    <div class="cr_form_con cr_info">
                        <div class="head_tl_holder">
                            <h3>Other Information</h3>
                        </div>
                        <ul class="other_info">
                            <li>
                                <span><strong>Willing To Relocate</strong></span>
                                <span>
                                  <input type="radio" id="yes" name="willing_relocate" value="y" <?php echo ($willing_relocate=='y' || $willing_relocate=='') ? 'checked': ''?>>
                                  <label for="yes">Yes</label>
                                  <input type="radio" id="no" name="willing_relocate" value="N"<?php echo ($willing_relocate=='N') ? 'checked': ''?> >
                                  <label for="no">No</label>
                                </span>
                              </li>
                              <?php if($willing_relocate!='N'){?>
                            <li>
                                <span><strong>Select State</strong></span>
                                <span>
                                  <select name="option_state" id="prefferd_state" class="selectBox <?php echo $optionstateclass;?>">
                                    <option value="">Select State</option>
                                     <?php
                                    $params     = array(":is_active" => '1');
                                    $state_arr  = $objTypes->fetchAll("SELECT state_name,state_id  FROM tbl_state_master WHERE is_active = :is_active", $params);
                                    if(sizeof($state_arr) > 0){
                                      foreach($state_arr as $state_v){                            
                                        ?>
                                      <option value="<?php echo $state_v['state_name'] ?>" <?php echo ($option_state==$state_v['state_name']) ? 'selected': ''?>><?php echo ucfirst(strtolower($state_v['state_name'])); ?></option>
                                    <?php } }  ?>
                                  </select>
                                </span>
                            </li>
                            <li>
                                <span><strong>Enter City</strong></span>
                                <span id="prefferd_citybox">
                                 <input type="text" class="textBox <?php echo $optioncityclass;?>" name="option_city" id="prefferd_city" value="<?php echo $option_city;?>">
                                 <span></span>
                                 You can add multiple city, separated by ','.
                                </span>
                            </li>
                          <?php }?>
                            <li>
                                <span><strong>Notice Period</strong></span>
                                <span id="notice_periodbox">
                                  <input type="text" class="textBox <?php echo $noticeperiodclass;?>" name="notice_period" id="notice_period" value="<?php echo $notice_period;?>">
                                  <span></span>
                                </span>
                            </li>
                            <li>
                                <span><strong>Resume Title</strong></span>
                                <span id="resume_titlebox">
                                  <input type="text" class="textBox <?php echo $resumetitleclass;?>" name="resume_title" id="resume_title" value="<?php echo $resume_title;?>">
                                  <span></span>
                                </span>
                            </li>
                            <li></li>
                            <li class="selectFiles">
                                <div class="file-upload">
                                  <div class="file-select">
                                    <div class="file-select-button" id="fileName">Choose Your File*</div>
                                    <div class="file-select-name" id="noFile"></div>
                                    <input type="file" name="resume" id="chooseFile" value="">
                                  </div>
                                  <div>Allowed only pdf and doc file</div>
                                </div>

                            </li>
                        </ul>
                       <button class="commanBtn" id="commanBtn">Submit</button>
                    </div>
                </form>
                </div>
            </div>
        </section>
    <?php include_once('include/footer.php'); ?>
    </div>
    <!--JS Files-->
    <?php include_once('include/js.php');?>
    <script type="text/javascript" src="<?=base_url?>assets/js/common.js"></script>
    <script type="text/javascript" src="<?=base_url?>js/jquery-ui.js"></script>
    <script type="text/javascript" src="<?=base_url?>js/jquery.ui.datepicker.js"></script>
     <script type="text/javascript">
      $(document).ready(function(){ 
         $('input').on('keyup',function()
          {
              $('input,select').removeClass('errorRed');
              $('.errMsg').text('');
              $('.per_info li span span').text(''); 
              $('.edu_info li span span').text(''); 
              $('.job_info li span span').text('');
              $('.loc_info li span span').text(''); 
              $('.other_info li span span').text(''); 
              $('input,select').removeClass('errorblue');
              $(this).addClass('errorblue');
           });
           $('select').on('change',function()
          {
              $('input,select').removeClass('errorRed');
              $('.errMsg').text('');
              $('.per_info li span span').text(''); 
              $('.edu_info li span span').text(''); 
              $('.job_info li span span').text('');
              $('.loc_info li span span').text(''); 
              $('.other_info li span span').text('');
              $('input,select').removeClass('errorblue');
              $(this).addClass('errorblue');
           });
         $('#name').keyup(function()
          {
              $('input,select').removeClass('errorRed');
              $('input,select').removeClass('errorblue');
              charactersonly(this);
              $("#name").addClass('errorblue');
              $("#name").focus();
              $("#namebox span").text('Only characters');
          });
          /*
          $('#name').keyup(function(){
               if (!/^[a-zA-Z]*$/g.test(document.career_form.name.value)) {
                    $("#namebox span").text('Invalid characters');
                    document.career_form.name.focus();
                    return false;
                }else{                  
                }
          });*/
          $('#pan').keyup(function()
          {
              $('input,select').removeClass('errorblue');
              alphanumericsonly(this);
              $("#pan").addClass('errorblue');
              $("#pan").focus();
              $("#panbox span").text('Only alphanumerics');
          });
          $('#aadhar').keyup(function()
          {
              $('input,select').removeClass('errorblue');
              numericsonly(this);
              $("#aadhar").addClass('errorblue');
              $("#aadhar").focus();
              $("#aadharbox span").text('Only numbers');
          });
         $('#city_input').keyup(function()
          {
              charactersonly(this);
              $('input,select').removeClass('errorblue');
              $("#city_input").addClass('errorblue');
              $("#city_input").focus();
              $("#citybox span").text('Only characters');
          });
         $('#mobile').keyup(function()
          {
              numericsonly(this);
              $('input,select').removeClass('errorblue');
              $("#mobile").addClass('errorblue');
              $("#mobile").focus();
              $("#mobilebox span").text('Only numbers');
          });
         $('#alternate').keyup(function()
          {
              numericsonly(this);
              $('input,select').removeClass('errorblue');
              $("#alternate").addClass('errorblue');
              $("#alternate").focus();
              $("#alternatebox span").text('Only numbers');
          });
         $('#institute').keyup(function()
          {
              specificsinstituteonly(this);
              $('input,select').removeClass('errorblue');
              $("#institute").addClass('errorblue');
              $("#institute").focus();
              $("#institutebox span").text('Only characters ,.()&-');
          });
         $('#institute_state').keyup(function()
          {
              charactersonly(this);
              $('input,select').removeClass('errorblue');
              $("#institute_state").addClass('errorblue');
              $("#institute_state").focus();
              $("#institute_statebox span").text('Only characters');
          });
         $('#institute_city').keyup(function()
          {
              charactersonly(this);
              $('input,select').removeClass('errorblue');
              $("#institute_city").addClass('errorblue');
              $("#institute_city").focus();
              $("#institute_citybox span").text('Only characters');
          });
         $('#course').keyup(function()
          {
              alphanumericsonly(this);
              $('input,select').removeClass('errorblue');
              $("#course").addClass('errorblue');
              $("#course").focus();
              $("#coursebox span").text('Only alphanumerics');
          });
         $('#result').keyup(function()
          {
              alphanumericsonly(this);
              $('input,select').removeClass('errorblue');
              $("#result").addClass('errorblue');
              $("#result").focus();
              $("#resultbox span").text('Only alphanumerics');
          });
         $('#employer_1').keyup(function()
          {
              charactersonly(this);
              $('input,select').removeClass('errorblue');
              $("this").focus();
              $("#employer_1").addClass('errorblue');
              $("#employerbox_1 span").text('Only characters');
          });
         $('#reporting_to_1').keyup(function()
          {
              charactersonly(this);
              $('input,select').removeClass('errorblue');
              $("#reporting_to_1").addClass('errorblue');
              $("this").focus();
              $("#reportingbox_1 span").text('Only characters');
          });
         $('#role_1').keyup(function()
          {
              charactersonly(this);
              $('input,select').removeClass('errorblue');
              $("#role_1").addClass('errorblue');
              $("this").focus();
              $("#rolebox_1 span").text('Only characters');
          });
         $('#ctc_1').keyup(function()
          {
              onlydecimal(this);
              $('input,select').removeClass('errorblue');
              $("#ctc_1").addClass('errorblue');
              $("this").focus();
              $("#ctcbox_1 span").text('Only alphanumerics');
          });
         $('#gross_1').keyup(function()
          {
              onlydecimal(this);
              $('input,select').removeClass('errorblue');
              $("#gross_1").addClass('errorblue');
              $("this").focus();
              $("#grossbox_1 span").text('Only alphanumerics');
          });
         $('#prefferd_city').keyup(function()
          {
              specificscityonly(this);
              $('input,select').removeClass('errorblue');
              $("#prefferd_city").addClass('errorblue');
              $("this").focus();
              $("#prefferd_citybox span").text('Only characters');
          });
         $('#notice_period').keyup(function()
          {
              alphanumericsonly(this);
              $('input,select').removeClass('errorblue');
              $("#notice_period").addClass('errorblue');
              $("this").focus();
              $("#notice_periodbox span").text('Only alphanumerics');
          });
         $('#resume_title').keyup(function()
          {
              alphanumericsonly(this);
              $('input,select').removeClass('errorblue');
              $("#resume_title").addClass('errorblue');
              $("this").focus();
              $("#resume_titlebox span").text('Only alphanumerics');
          });
         $('input:radio[name="willing_relocate"]').change(
          function(){
              if ($(this).val() == 'N') {
                 $("#prefferd_city").parent().siblings(':first').hide();
                 $("#prefferd_state").parent().siblings(':first').hide();
                 $("#prefferd_city").parent().hide();
                 $("#prefferd_state").parent().hide();
              }
              if ($(this).val() == 'y') {
                 $("#prefferd_city").parent().siblings(':first').show();
                 $("#prefferd_state").parent().siblings(':first').show();
                 $("#prefferd_city").parent().show();
                 $("#prefferd_state").parent().show();
              }
          });
        $("#add_more").on('click',function(){
          //alert("xxx");
          var adddata=$("#add_more").attr('data');
          var2=1;
          var adddata=Number(adddata)+Number(var2);
          //alert(adddata);
            $.ajax({
              type: "POST",
              data:{'adddata':adddata},
              url: 'add_job.php',
              success:function(response){
                //alert(response);
                $(".add_job").append(response);
                $("#add_more").attr('data',adddata);
              }
          });
        });
        $("#state_input").hide();
        $("#country").change(function(){
          var country = $("#country").val();
          if(country=='Us'){
            $("#state_select").hide();
            $("#state_input").show();
          }else{
            $("#state_select").show();
            $("#state_input").hide();
          }
        });
        $("#commanBtn").on('click',function(){
          $('input,select').removeClass('errorblue');
          $("html, body").animate({ scrollTop: 250 }, "slow");
          //$(".errMsg").attr('style','color:red');
           var name=$("#name").val().trim();
           var email=$("#email").val().trim();
           var mobile=$("#mobile").val().trim();
           var dob=$("#dob").val().trim();
           var pan=$("#pan").val().trim();
           var aadhar=$("#aadhar").val().trim();
           var country=$("#country").val().trim();
           if(country=='Us'){
            var state=$("#state_input").val().trim();
           }else{
            var state=$("#state_select").val().trim();
           }
           var city=$("#city_input").val().trim();
           var file=$("#noFile").html();
           var regEx = new RegExp("/[0-9]/");
           var checkemail  = validateEmailAddress(email);
           $("input").removeClass('errorRed');
               if(name==""){
                  $(".errMsg").show();
                  $(".errMsg").text("Please enter your name");
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
                if(dob==""){
                  $(".errMsg").show();
                  $(".errMsg").text("Please enter date of birth");
                  $("#dob").addClass('errorRed');
                  $("#dob").focus();
                  isOk = false;
                  return false;
                }else{      
                  $("#dob").removeClass('errorRed');     
                 }
                 var regExp = /[a-zA-z]{5}\d{4}[a-zA-Z]{1}/; 
                 if(pan!=''){
                  if(!pan.match(regExp) ){ 
                    $(".errMsg").show();
                    $(".errMsg").text("Please enter valid pan no");
                    $("#pan").addClass('errorRed');
                    $("#pan").focus();
                    isOk = false;
                    return false;
                     } 
                  }
                  if(aadhar!=''){
                   if(checkUID(aadhar)==false)
                   {
                      $(".errMsg").show();
                      $(".errMsg").text("Please enter aadhar no");
                      $("#aadhar").addClass('errorRed');
                      $("#aadhar").focus();
                      isOk = false;
                      return false;
                    }
                  }
                 if(state==""){
                  $(".errMsg").show();
                  $(".errMsg").text("Please enter state name");
                  $("#state_select").addClass('errorRed');
                  $("#state_select").focus();
                  isOk = false;
                  return false;
                }else{      
                  $("#state_select").removeClass('errorRed');     
                }
               if(city==""){
                  $(".errMsg").show();
                  $(".errMsg").text("Please enter city name");
                  $("#city_input").addClass('errorRed');
                  $("#city_input").focus();
                  isOk = false;
                  return false;
                }else{      
                  $("#city_input").removeClass('errorRed');     
                 }
                 if(mobile==""){
                  $(".errMsg").show();
                  $(".errMsg").text("Please enter your mobile");
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
                      $(".errMsg").show();
                      $(".errMsg").text("Please enter a valid mobile number");
                      $("#mobile").addClass('errorRed');
                      $("#mobile").focus();
                      isOk = false;
                      return false;
                    }   
                  $("#mobile").removeClass('errorRed');     
                    }
                if(email==''){
                    $(".errMsg").show();
                    $(".errMsg").text('Please enter your email address');
                    $("#email").addClass('errorRed')
                    $("#email").focus();
                    isOk = false;
                    return  false;
                  }else if(!checkemail && email!=''){
                    $(".errMsg").show();
                    $(".errMsg").text('Please enter a valid email id');
                    $("#email").addClass('errorRed');
                    $("#email").focus();
                    isOk = false;
                    return false;
                  }else{
                    $("#email").removeClass('errorRed');
                  }
                /* if(file==''){
                    $(".errMsg").show();
                    $(".errMsg").text('Please enter your file');
                    $("#chooseFile").addClass('errorRed')
                    $("#chooseFile").focus();
                    isOk = false;
                    return  false;
                  }
                 var file = document.getElementById('chooseFile').files[0];
                  if(file && file.size < 3097152) { // 10 MB (this size is in bytes)
                    $('career_form').submit();
                      //Submit form        
                  } else {
                    $(".errMsg").show();
                    $(".errMsg").text('Maximum file size would be 3mb.');
                    $("#chooseFile").addClass('errorRed')
                    $("#chooseFile").focus();
                    isOk = false;
                    return  false;
                  }
					*/
                  var jobdata=$("#add_more").attr('data');
                  $("#jobdata").val(jobdata);
                  $('career_form').submit();
               }); 
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
                    var invalidChars = /([^a-z 0-9,])/gi
                    if(invalidChars.test(ob.value)) 
                    {
                        ob.value = ob.value.replace(invalidChars,"");
                    }
                }
                function specificscityonly(ob) 
                {
                    var invalidChars = /([^a-z,])/gi
                    if(invalidChars.test(ob.value)) 
                    {
                        ob.value = ob.value.replace(invalidChars,"");
                    }
                }
                function specificsinstituteonly(ob) 
                {
                    var invalidChars = /([^a-z A-Z,.()&\-])/gi
                    if(invalidChars.test(ob.value)) 
                    {
                        ob.value = ob.value.replace(invalidChars,"");
                    }
                }
                function onlydecimal(ob){
                   var invalidChars = /([^a-z 0-9.])/gi
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
                function checkUID(uid) 
                {
                      if (uid.length != 12) {
                          return false;
                      }
                      var Verhoeff = {
                          "d": [[0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                              [1, 2, 3, 4, 0, 6, 7, 8, 9, 5],
                              [2, 3, 4, 0, 1, 7, 8, 9, 5, 6],
                              [3, 4, 0, 1, 2, 8, 9, 5, 6, 7],
                              [4, 0, 1, 2, 3, 9, 5, 6, 7, 8],
                              [5, 9, 8, 7, 6, 0, 4, 3, 2, 1],
                              [6, 5, 9, 8, 7, 1, 0, 4, 3, 2],
                              [7, 6, 5, 9, 8, 2, 1, 0, 4, 3],
                              [8, 7, 6, 5, 9, 3, 2, 1, 0, 4],
                              [9, 8, 7, 6, 5, 4, 3, 2, 1, 0]],
                          "p": [[0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                              [1, 5, 7, 6, 2, 8, 3, 0, 9, 4],
                              [5, 8, 0, 3, 7, 9, 6, 1, 4, 2],
                              [8, 9, 1, 6, 0, 4, 3, 5, 2, 7],
                              [9, 4, 5, 3, 1, 2, 6, 8, 7, 0],
                              [4, 2, 8, 6, 5, 7, 3, 9, 0, 1],
                              [2, 7, 9, 3, 8, 0, 6, 4, 1, 5],
                              [7, 0, 4, 6, 9, 1, 3, 2, 5, 8]],
                          "j": [0, 4, 3, 2, 1, 5, 6, 7, 8, 9],
                          "check": function (str) {
                              var c = 0;
                              str.replace(/\D+/g, "").split("").reverse().join("").replace(/[\d]/g, function (u, i) {
                                  c = Verhoeff.d[c][Verhoeff.p[i % 8][parseInt(u, 10)]];
                              });
                              return c;
                          },
                          "get": function (str) {
                              var c = 0;
                              str.replace(/\D+/g, "").split("").reverse().join("").replace(/[\d]/g, function (u, i) {
                                  c = Verhoeff.d[c][Verhoeff.p[(i + 1) % 8][parseInt(u, 10)]];
                              });
                              return Verhoeff.j[c];
                          }
                      };
                      String.prototype.verhoeffCheck = (function () {
                          var d = [[0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                              [1, 2, 3, 4, 0, 6, 7, 8, 9, 5],
                              [2, 3, 4, 0, 1, 7, 8, 9, 5, 6],
                              [3, 4, 0, 1, 2, 8, 9, 5, 6, 7],
                              [4, 0, 1, 2, 3, 9, 5, 6, 7, 8],
                              [5, 9, 8, 7, 6, 0, 4, 3, 2, 1],
                              [6, 5, 9, 8, 7, 1, 0, 4, 3, 2],
                              [7, 6, 5, 9, 8, 2, 1, 0, 4, 3],
                              [8, 7, 6, 5, 9, 3, 2, 1, 0, 4],
                              [9, 8, 7, 6, 5, 4, 3, 2, 1, 0]];
                          var p = [[0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
                              [1, 5, 7, 6, 2, 8, 3, 0, 9, 4],
                              [5, 8, 0, 3, 7, 9, 6, 1, 4, 2],
                              [8, 9, 1, 6, 0, 4, 3, 5, 2, 7],
                              [9, 4, 5, 3, 1, 2, 6, 8, 7, 0],
                              [4, 2, 8, 6, 5, 7, 3, 9, 0, 1],
                              [2, 7, 9, 3, 8, 0, 6, 4, 1, 5],
                              [7, 0, 4, 6, 9, 1, 3, 2, 5, 8]];
                          return function () {
                              var c = 0;
                              this.replace(/\D+/g, "").split("").reverse().join("").replace(/[\d]/g, function (u, i) {
                                  c = d[c][p[i % 8][parseInt(u, 10)]];
                              });
                              return (c === 0);
                          };
                      })();
                      if (Verhoeff['check'](uid) === 0) {
                          return true;
                      } else {
                          return false;
                      }
                }
                function validateFirstnameLastname(obj, msg){
                  var validStr = /^[a-zA-Z ]{1,}$/;
                  NameArr=obj.value.split("");                  
                  for(i=0;i<NameArr.length+5;i++)
                  {
                    if (validStr.test(NameArr[i]) == false)
                    {
                      jQuery(".errMsg").text(msg);
                      obj.focus();
                      obj.select();
                      return false;
                    }
                  }
                  return true;
                }
                $(function() {
                  $("#dob").datepicker({maxDate: "-18Y",changeYear: true,yearRange: '1950:new Date("Y")'});
                  $( ".calendarBox" ).datepicker({changeYear: true,maxDate: new Date(),yearRange: '1950:new Date("Y")'});
                 });
      </script>
  </body>
</html>