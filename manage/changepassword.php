<!-- Content Wrapper. Contains page content -->
<?php
require_once("left.php");
$id 		= (int)$_REQUEST['id'];
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> Change Password <small></small> </h1>
    <ol class="breadcrumb">
      <li><a href="changepassword.php"><i class="fa  fa-navicon"></i> Change Password</a></li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <!--Table Start-->
    <div class="row">
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary" >
          <div class="box-header">
            <h3 class="box-title"></h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <p>
        	<div class="callout callout-danger errorDiv" <?php  $objSystemMsg->createStyle($sysmsg); ?>>
        		<span id="errormessage"><?php echo $objSystemMsg->displayError($sysmsg); ?></span>
        	</div>
          </p>
          <form role="form" method="post" action="act_pass.php" onsubmit="return validateForm();">
            <div class="box-body">
            
                 <div class="form-group">
                <label for="exampleInputEmail1">User Name : &nbsp;&nbsp;<b><?php echo $_SESSION['SessAdminName'];?></b></label>
                
              </div> 
                    
              <div class="form-group">
                <label for="exampleInputEmail1">Old Password<?=MANDATORY?></label>
                <input type="password" class="form-control" id="oldpass" name="oldpass"  placeholder="Old Password" style="width:40%;" >
              </div>
              
              <div class="form-group">
                <label for="exampleInputPassword1">New Password<?=MANDATORY?></label>
                <input type="password" class="form-control" id="pass1" name="pass1"  placeholder="New Password" style="width:40%;" >
              </div>
              
              <div class="form-group">
                <label for="exampleInputPassword1">Re Enter New Password<?=MANDATORY?></label>
                <input type="password" class="form-control" id="pass2" name="pass2"  placeholder="Re Enter New Password" style="width:40%;" >
              </div>
           
              
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <button type="submit" class="btn btn-primary" value="SAVE" name="SAVE" id="SAVE">Submit</button>
            </div>
          </form>
        </div>
        <!-- /.box -->
      </div>
    </div>
    <!--Table End-->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php require_once("footer.php"); ?>
<div class='control-sidebar-bg'></div>
</div>
<!-- ./wrapper -->
<!-- REQUIRED JS SCRIPTS -->
<!-- jQuery 2.1.4 -->
<script src="<?=base_url?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="<?=base_url?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="<?=base_url?>dist/js/app.min.js" type="text/javascript"></script>

</body></html>
<!--<script>

function checkPass(objForm)
{
	if(objForm.oldpass.value=="")
	{	
		alert("Enter Your Pasword");	
		objForm.oldpass.focus();
		return false;
	}
	if(objForm.pass1.value=="")
	{
		alert("Enter Your New Pasword");	
		objForm.pass1.focus();
		return false;
	}
	if(objForm.pass2.value=="")
	{
		alert("Retype New Pasword");	
		objForm.pass2.focus();
		return false;
	}

	if((objForm.pass1.value)!==(objForm.pass2.value))		
	{
		alert("Both Password Doesn't Match");	
		objForm.pass1.value="";
		objForm.pass2.value="";	
		objForm.pass1.focus();
		return false;
	}	
}
</script>-->
<script type="text/javascript" language="javascript">
var sysmsg = "<?=$sysmsg?>";
if(sysmsg==0){
	$(".errorDiv").hide();
}else{ 
	$(".errorDiv").show().fadeOut(4000);
}
</script>
<script type="text/javascript" language="javascript">
function validateForm(){
	if($("input#oldpass").val()==""){
		$(".errorDiv").show().fadeOut(4000);
		$('#errormessage').text("Old Password is Mandatory");
		$("input#oldpass").focus();
		return false;
	}
	else if($("input#pass1").val()==""){
		$(".errorDiv").show().fadeOut(4000);
		$('#errormessage').text("New Password is Mandatory");
		$("input#pass1").focus();
		return false;
	}
	else if($("input#pass2").val()==""){
		$(".errorDiv").show().fadeOut(4000);
		$('#errormessage').text("Confirm Password is Mandatory");
		$("input#pass2").focus();
		return false;
	}
	else if($("input#pass1").val()!=$("input#pass2").val()){
		$(".errorDiv").show().fadeOut(4000);
		$('#errormessage').text("Both Password Doesn't Match");
		$("input#pass1").focus();
		$("#pass1").val(""); 
		$("#pass2").val(""); 
		return false;
	}
	return true;
}	
</script>