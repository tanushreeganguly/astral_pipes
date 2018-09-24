<!-- Content Wrapper. Contains page content -->
<?php 
require_once("left.php");

#==== Object Initialisations
$POST		= $objTypes->validateUserInput($_POST);
$id 		= isset($POST['id']) ? intval($POST['id']) : intval($_REQUEST['id']) ;
$mode 		= ($id<>'0') ? 'Edit' : 'Add';
$params     = array(":id" => $id);
$TypeArray	= $objTypes->fetchRow("SELECT id,title,envelope FROM tbl_newsletter WHERE id = :id", $params);
//echo ">>>";  print_r($TypeArray); exit;
?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> <?=$mode?> Astral Adhesive <small></small> </h1>
    <ol class="breadcrumb">
      <li><a href="list_newsletter.php"><i class="fa  fa-navicon"></i>Add Newsletter</a></li>
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
          <form role="form" method="post" action="act_newsletter.php" onsubmit="return validateForm();" enctype="multipart/form-data">
          <input type="hidden" name="id" id="id" value="<?=$TypeArray['id']?>"  />
		   <input type="hidden" name="type" id="type" value="image"  />
           <input type="hidden" name="pgNo" id="pgNo" value="<?=$_REQUEST['pgNo']?>"  />
            <div class="box-body">
				  <div class="form-group">
					  <label for="exampleInputEmail1">Title<?=MANDATORY?></label>
					  <input type="text" class="form-control " id="title" name="title" value="<?=stripslashes($TypeArray['title'])?>" placeholder="Title1" style="width:40%;">
				  </div>
				 
				  <div class="form-group">
                  <label for="exampleInputEmail1">Newsletter Envelope</label>
                  <input type="file" class="form-control " id="envelope" name="envelope" value="" placeholder="Product Envelope" style="width:40%;" onchange="return Checkpdf(envelope)" multiple="multiple">
                  <div class="alert alert-danger alert-dismissible" style="width:40%;margin-top:10px;">[Note:- Extension : PDF, pdf <br />MAX File Upload Size : 3MB<br /></div>
                  <?php
                 
                  if($TypeArray['envelope']){
                      ?>
                      <div class="">
                         
                          <a href="../uploads/newsletter_pdf/<?php echo $TypeArray['envelope'] ?>" target="_blank">View Envelope</a>
                      </div>
                      <?php
                 	 }
                  ?>
              </div>
				
				 
              
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <button type="submit" class="btn btn-primary" value="SAVE" name="SAVE" id="SAVE">Submit</button>
              <a href="list_newsletter.php" class="btn btn-danger" >Back</a>
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
<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
</body>
</html>
<script type="text/javascript" language="javascript">

/*$('textarea').keypress(function(e) {
    var tval = $('textarea').val(),
        tlength = tval.length,
        set = 100,
        remain = parseInt(set - tlength);
    $('#cnt').text(remain);
    if (remain <= 0 && e.which !== 0 && e.charCode !== 0) {
        $('textarea').val((tval).substring(0, tlength - 1))
    }
})*/


var sysmsg = "<?=$sysmsg?>";
if(sysmsg==0){
	$(".errorDiv").hide();
}
else{
	$(".errorDiv").show().fadeOut(4000);
}



function validateForm(){
	
	if($("#title").val()==""){
		$(".errorDiv").show().fadeOut(4000);
		$('#errormessage').text("Please enter title");
		$("#title").focus();
		return false;
	}
	
	
	return true;
}
function Checkpdf(pdf_id){
	var fup = pdf_id
	var fileName = fup.value;
	var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
	if(ext == "pdf" || ext == "PDF" ){
		//return true;
	}else{
		alert('Upload pdf files only.');
		$(".errorDiv").show().fadeOut(4000);
		$('#errormessage').text("Upload pdf files only.");
		$("input#images").focus();
		$("input#images").val("");
		return false;
	}
}


</script>
