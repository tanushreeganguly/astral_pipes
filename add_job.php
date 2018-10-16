<?php
include_once('config/config.php');
$POST   = $objTypes->validateUserInput($_REQUEST);
$addjob  = intval($POST['adddata']);

$html_data='<div class="cr_form_con cr_info" id="job_'.$addjob.'">
            <div class="close_btn">X</div>
            <ul class="job_info">
              <li>
                <span><strong>Employment Status</strong></span>
                <span>
                  <select name="employment_status_'.$addjob.'" id="employment_status_'.$addjob.'" class="selectBox" >
                    <option value="">Select</option>
                    <option value="Fresher">Fresher</option>
                    <option value="Experience">Experience</option>
                  </select>
                </span>
              </li>
              <li>
                <span><strong>Employer</strong></span>
                <span id="employerbox_'.$addjob.'">
                  <input type="text" name="employer_'.$addjob.'" id="employer_'.$addjob.'" class="textBox">
                  <span></span>
                </span>
              </li>
              <li>
                <span><strong>Start Date</strong></span>
                <span>
                  <input type="text" name="start_date_'.$addjob.'" id="start_date_'.$addjob.'" class="calendarBox">
                </span>
              </li>
              <li>
                <span><strong>Industry Type</strong></span>
                <span>
                  <select name="industry_type_'.$addjob.'" id="industry_type_'.$addjob.'" class="selectBox">
                    <option value="" >Select</option>
          					<option value="account" >Account</option>
          					<option value="agriculture">Agriculture</option>
          					<option value="advertising">Advertising or Media</option>
          					<option value="army">Army or Airforce/</option>
                    <option value="auto">Auto</option>
          					<option value="banking">Banking</option>
          					<option value="bpo">BPO</option>
          					<option value="broking house">Broking house</option>
          					<option value="cement">Cement</option>
          					<option value="ceramic">Ceramic</option>
          					<option value="chemical">Chemical</option>
          					<option value="construction">Construction</option>
          					<option value="consultant">Consultant</option>
          					<option value="consumer durable">Consumer Durable</option>
          					<option value="courier">Courier</option>
          					<option value="dairy">Dairy</option>
          					<option value="design">Design</option>
          					<option value="education">Education</option>
                  </select>
                </span>
              </li>
              <li>
                <span><strong>Industry Type</strong></span>
                <span>
                  <select name="designation_'.$addjob.'" id="designation_'.$addjob.'" class="selectBox">
                    <option option="">Select</option>	
          					<option option="assistant">Assistant</option>					
                    <option option="jr officer">Jr. Officer</option>
          					<option option="officer">Officer</option>
          					<option option="sr officer">Sr. Officer</option>					
          					<option option="jr executive">Jr. Executive</option>
          					<option option="executive">Executive</option>
                    <option option="sr executive">Sr. Executive</option>
          					<option option="asst manager">Asst. Manager</option>
          					<option option="dy manager">Dy. Manager</option>
          					<option option="manager">Manager</option>
          					<option option="sr manager">Sr. Manager</option>
          					<option option="asst gm">Asst.GM</option>
          					<option option="officer">Officer</option>
          					<option option="dy gm">Dy GM</option>
          					<option option="sr gmvpresident">Sr.GMVPPresident</option>
          					<option option="jr engineer">Jr.Engineer</option>
                  </select>
                </span>
              </li>
              <li>
                <span><strong>Reporting To</strong></span>
                <span id="reportingbox_'.$addjob.'">
                  <input type="text" class="textBox" name="reporting_to_'.$addjob.'" id="reporting_to_'.$addjob.'" value="">
                  <span></span>
                </span>
              </li>
              <li>
                <span><strong>Role</strong></span>
                <span id="rolebox_'.$addjob.'">
                  <input type="text" class="textBox" name="role_'.$addjob.'" id="role_'.$addjob.'" value="">
                  <span></span>
                </span>
              </li>
              <li>
                <span><strong>CTC</strong></span>
                <span id="ctcbox_'.$addjob.'">
                  <input type="text" class="textBox" name="ctc_'.$addjob.'" id="ctc_'.$addjob.'" value="">
                  <span></span>
                </span>
              </li>
              <li>
                <span><strong>Gross Salary</strong></span>
                <span id="grossbox_'.$addjob.'">
                  <input type="text" class="textBox" name="gross_'.$addjob.'" id="gross_'.$addjob.'" value="">
                  <span></span>
                </span>
              </li>
            </ul>
            
          </div>';
          echo $html_data;

 ?>
<script type="text/javascript">
	$( function() {

              var c="<?php echo $addjob;?>";
              $('input').on('keyup',function()
                {
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
                    $('.per_info li span span').text(''); 
                    $('.edu_info li span span').text(''); 
                    $('.job_info li span span').text('');
                    $('.loc_info li span span').text(''); 
                    $('.other_info li span span').text('');
                    $('input,select').removeClass('errorblue');
                    $(this).addClass('errorblue');

                 });
    
               $('#employer_'+c).keyup(function()
                {
                    charactersonly(this);
                    $('input').removeClass('errorblue');
                    $("this").focus();
                    $('#employer_'+c).addClass('errorblue');
                    $("#employerbox_"+c+" span").text('Only characters');
                });
               $('#reporting_to_'+c).keyup(function()
                {
                    charactersonly(this);
                    $('input').removeClass('errorblue');
                    $('#reporting_to_'+c).addClass('errorblue');
                    $("this").focus();
                    $("#reportingbox_"+c+" span").text('Only characters');
                });
               $('#role_'+c).keyup(function()
                {
                    charactersonly(this);
                    $('input').removeClass('errorblue');
                    $('#role_'+c).addClass('errorblue');
                    $("this").focus();
                    $("#rolebox_"+c+" span").text('Only characters');
                });
               $('#ctc_'+c).keyup(function()
                {
                    onlydecimal(this);
                    $('input').removeClass('errorblue');
                    $('#ctc_'+c).addClass('errorblue');
                    $("this").focus();
                    $("#ctcbox_"+c+" span").text('Only alphanumerics');
                });
               $('#gross_'+c).keyup(function()
                {
                    onlydecimal(this);
                    $('input').removeClass('errorblue');
                    $('#gross_'+c).addClass('errorblue');
                    $("this").focus();
                    $("#grossbox_"+c+" span").text('Only alphanumerics');
                });
                

         
                   $( ".calendarBox" ).datepicker({changeYear: true,maxDate: new Date(),yearRange: '1950:new Date("Y")'});
                 // $( "#start_date" ).datepicker();
                } );

  $('.close_btn').on('click',function(){
    $(this).parent().hide();
  });
     
</script>