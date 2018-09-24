<!-- Content Wrapper. Contains page content -->
<?php
require_once("left.php");
#==== Object Initialisations
$POST		= $objTypes->validateUserInput($_POST);
$id 		= isset($POST['id']) ? intval($POST['id']) : intval($_REQUEST['id']) ;
$mode 		= ($id<>'0') ? 'Edit' : 'Add';
$params     = array(":id" => $id);
$CareerArr= $objTypes->fetchRow("SELECT * FROM tbl_careers WHERE id = :id", $params);
//$department = array("Marketing", "Sales", "HR", "Production");
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> <?=$mode?> Career<small></small> </h1>
    <ol class="breadcrumb">
      <li><a href="list_career.php"><i class="fa  fa-navicon"></i>List Careers</a></li>
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
        	<div class="callout callout-danger errorDiv" <?php $objSystemMsg->createStyle($sysmsg);?> >
        		<span id="errormessage"><?php echo $objSystemMsg->displayError($sysmsg); ?></span>
        	</div>
          </p>
          <form role="form" method="post" action="act_career.php" onsubmit="return validateForm();" enctype="multipart/form-data" >
          <input type="hidden" name="id" id="id" value="<?=$CareerArr['id']?>"  />
           <input type="hidden" name="pgNo" id="pgNo" value="<?=$_REQUEST['pgNo']?>"  />
            <div class="box-body"> 
             <div class="form-group">
                <label for="exampleInputEmail1">Job Code<?=MANDATORY?></label>
                <input type="text" class="form-control " id="job_code" name="job_code" value="<?=stripslashes($CareerArr['job_code'])?>" placeholder="Job Code" style="width:40%;" required>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Job Title<?=MANDATORY?></label>
                <input type="text" class="form-control " id="title" name="title" value="<?=stripslashes($CareerArr['title'])?>" placeholder="Title" style="width:40%;" required>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Location<?=MANDATORY?></label>
                <input type="text" class="form-control " id="location" name="location" value="<?=stripslashes($CareerArr['location'])?>" placeholder="Location" style="width:40%;" required>
              </div>
               <div class="form-group">
                <label for="exampleInputEmail1">Function/Department<?=MANDATORY?></label>
                <input type="text" class="form-control " id="department" name="department" value="<?=stripslashes($CareerArr['department'])?>" placeholder="Department" style="width:40%;" required>
                 <!-- <select class="form-control" name="department" id="department" style="width: 40%">
                    <option value="">Select Department</option>
                    <?php foreach ($department as $val ) { ?>
                        <option value="<?php echo ($CareerArr['department'] == $val) ? 'selected' : $val; ?> ">
                            <?php echo trim($val); ?>
                        </option>
                    <?php } ?>
                </select>-->
              </div>
                <div class="form-group">
                <label for="exampleInputEmail1">Education<?=MANDATORY?></label>
                <textarea class="form-control" id="editor1" name="education"  rows="10" cols="80" placeholder="education..." ><?=stripslashes($CareerArr['education'])?></textarea>
				<!--<textarea class="form-control" rows="5" name="education" id="education" placeholder="Education" style="width:40%;" required><?=stripslashes($CareerArr['education'])?></textarea>-->
              </div>
                   <div class="form-group">
					<label for="exampleInputEmail1">From Experience<?=MANDATORY?></label>
					  <!--input type="text" class="form-control " id="experience" name="experience" value="<?=stripslashes($CareerArr['from_experience'])?>" placeholder="experience" style="width:40%;" required-->
					  <!--<select class="form-control" name="from_experience" id="from_experience" style="width: 40%">
						  <option value="">Select from Experience</option>
						  <option value="1" <?php echo ($CareerArr['from_experience'] == '1') ? 'selected' : ''; ?>>1</option>
						  <option value="2" <?php echo ($CareerArr['from_experience'] == '2') ? 'selected' : ''; ?>>2</option>
						  <option value="3" <?php echo ($CareerArr['from_experience'] == '3') ? 'selected' : ''; ?>>3</option>
						  <option value="4" <?php echo ($CareerArr['from_experience'] == '4') ? 'selected' : ''; ?>>4</option>
						  <option value="5" <?php echo ($CareerArr['from_experience'] == '5') ? 'selected' : ''; ?>>5</option>
						  <option value="6" <?php echo ($CareerArr['from_experience'] == '6') ? 'selected' : ''; ?>>6</option>
						  <option value="7" <?php echo ($CareerArr['from_experience'] == '7') ? 'selected' : ''; ?>>7</option>
						  <option value="8" <?php echo ($CareerArr['from_experience'] == '8') ? 'selected' : ''; ?>>8</option>
						  <option value="9" <?php echo ($CareerArr['from_experience'] == '9') ? 'selected' : ''; ?>>9</option>
						  <option value="10" <?php echo ($CareerArr['from_experience'] == '10') ? 'selected' : ''; ?>>10</option>
						  <option value="11" <?php echo ($CareerArr['from_experience'] == '11') ? 'selected' : ''; ?>>11</option>
						  <option value="12" <?php echo ($CareerArr['from_experience'] == '12') ? 'selected' : ''; ?>>12</option>
						  <option value="13" <?php echo ($CareerArr['from_experience'] == '13') ? 'selected' : ''; ?>>13</option>
						  <option value="14" <?php echo ($CareerArr['from_experience'] == '14') ? 'selected' : ''; ?>>14</option>
						  <option value="15" <?php echo ($CareerArr['from_experience'] == '15') ? 'selected' : ''; ?>>15</option>
						  <option value="16" <?php echo ($CareerArr['from_experience'] == '16') ? 'selected' : ''; ?>>16</option>
						  <option value="17" <?php echo ($CareerArr['from_experience'] == '17') ? 'selected' : ''; ?>>17</option>
						  <option value="18" <?php echo ($CareerArr['from_experience'] == '18') ? 'selected' : ''; ?>>18</option>
						  <option value="19" <?php echo ($CareerArr['from_experience'] == '19') ? 'selected' : ''; ?>>19</option>
						  <option value="20" <?php echo ($CareerArr['from_experience'] == '20') ? 'selected' : ''; ?>>20</option>
					  </select>-->
					  <select class="form-control" name="from_experience" id="from_experience" style="width: 40%">
						  <option value="">Select From Experience</option>
						  <?php for($i=1;$i<=20;$i++){ ?>
						  <option value="<?php echo $i;?>" <?php echo ($CareerArr['from_experience'] == $i) ? 'selected' : ''; ?>><?=$i?></option>
						  <?php } ?>
						</select>
				  </div>
			  
			     <div class="form-group">
					<label for="exampleInputEmail1">To Experience<?=MANDATORY?></label>
					<!--input type="text" class="form-control " id="experience" name="experience" value="<?=stripslashes($CareerArr['to_experience'])?>" placeholder="experience" style="width:40%;" required-->
					<select class="form-control" name="to_experience" id="to_experience" style="width: 40%">
                      <option value="">Select To Experience</option>
					  <?php for($i=1;$i<=20;$i++){ ?>
                      <option value="<?php echo $i;?>" <?php echo ($CareerArr['to_experience'] == $i) ? 'selected' : ''; ?>><?=$i?></option>
                      <?php } ?>
					</select>
				 </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Job Description<?=MANDATORY?></label>
                <!--<textarea class="form-control" rows="5" name="job_description" id="job_description" placeholder="Job Description ..." style="width:40%;" required><?=stripslashes($CareerArr['job_description'])?></textarea>-->
              <textarea class="form-control" id="editor2" name="job_description"  rows="10" cols="80" placeholder="job_description..." ><?=stripslashes($CareerArr['job_description'])?></textarea>
				</div>
              <div class="form-group">
                <label for="exampleInputEmail1">From Date<?=MANDATORY?></label>
                <div class="input-group date" style="width:40%;">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="from_date" name="from_date" value="<?=stripslashes($CareerArr['from_date'])?>"  placeholder="From Date" required>
                </div>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">To Date<?=MANDATORY?></label>
                <div class="input-group date" style="width:40%;">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="to_date" name="to_date" value="<?=stripslashes($CareerArr['to_date'])?>"  placeholder="To Date" required>
                </div>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Meta Title</label>
                <input type="text" class="form-control " id="meta_title" name="meta_title" value="<?=stripslashes($CareerArr['meta_title'])?>" placeholder="Meta Title" style="width:40%;">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Meta Keywords</label>
                <input type="text" class="form-control " id="meta_keywords" name="meta_keywords" value="<?=stripslashes($CareerArr['meta_keywords'])?>" placeholder="Meta Keywords" style="width:40%;">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Meta Description</label>
                <textarea class="form-control" rows="3" name="meta_description" id="meta_description" placeholder="Meta Description ..." style="width:40%;"><?=stripslashes($CareerArr['meta_description'])?></textarea>
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <button type="submit" class="btn btn-primary" value="SAVE" name="SAVE" id="SAVE">Submit</button>
              <a href="list_career.php?&pgNo=<?php echo intval(base64_decode($_REQUEST['pgNo'])); ?>" class="btn btn-danger" >Back</a>
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
<!-- date-range-picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="<?=base_url?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="<?=base_url?>plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url?>dist/js/app.min.js" type="text/javascript"></script>
<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
</body>
</html>
<script type="text/javascript" language="javascript">
var sysmsg = "<?=$sysmsg?>";
var id  = "<?=$CareerArr['id']?>";
if(sysmsg==0){
	$(".errorDiv").hide();
}
else{
	$(".errorDiv").show().fadeOut(4000);
}
</script>
<script type="text/javascript" language="javascript">
function validateForm(){	
	var id = '<?=$id?>';
	if($("input#title").val()==""){
		$(".errorDiv").show().fadeOut(4000);
		$('#errormessage').text("Title is Mandatory");
		$("input#title").focus();
		return false;
	}
	if($("input#location").val()==""){
		$(".errorDiv").show().fadeOut(4000);
		$('#errormessage').text("location is Mandatory");
		$("input#location").focus();
		return false;
	}
	if($("textarea#job_description").val()==""){
		$(".errorDiv").show().fadeOut(4000);
		$('#errormessage').text("job description is Mandatory");
		$("textarea#job_description").focus();
		return false;
	}
	if($("textarea#requirements").val()==""){
		$(".errorDiv").show().fadeOut(4000);
		$('#errormessage').text("requirements is Mandatory");
		$("textarea#requirements").focus();
		return false;
	}	
	if($("input#application_form").val()=="" && id=="0"){ 
		$(".errorDiv").show().fadeOut(4000);
		$('#errormessage').text("Form is Mandatory");
		$("input#application_form").focus();
		return false;
	}
	return true;
}
function Checkfile(){
	var fup = document.getElementById('application_form');
	var fileName = fup.value;
	var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
	if(ext == "doc" || ext == "DOC"  || ext == "docx" || ext == "DOCX"  ){ //|| ext == "PDF" || ext == "pdf"
		//return true;
	}else{
		alert('Upload word files only.');
		$(".errorDiv").show().fadeOut(4000);
		$('#errormessage').text("Upload word files only.");
		$("input#application_form").focus();
		$("input#application_form").val("");
		return false;
	}
}
</script>
<script>
//Date picker
$('#from_date,#to_date').datepicker({
  format: "yyyy-mm-dd",
	//startDate: '-d',
	todayHighlight: true,
	 pickTime:true,
	autoclose: true
});
$(function () {
// Replace the <textarea id="editor1"> with a CKEditor
// instance, using default configuration.
CKEDITOR.replace('editor1');
CKEDITOR.replace('editor2');
//bootstrap WYSIHTML5 - text editor
$(".textarea").wysihtml5();
});
</script>