<!-- Content Wrapper. Contains page content -->
<?php
require_once("left.php");

#==== Object Initialisations

$POST		= $objTypes->validateUserInput($_POST);
$id 		= isset($POST['id']) ? intval($POST['id']) : intval($_REQUEST['id']) ;
$mode 		= ($id<>'0') ? 'Edit' : 'Add';
$params     = array(":id" => $id);
$params_img    = array(":product_id" => $id);
$TypeArray	= $objTypes->fetchRow("SELECT * FROM tbl_pressrelease WHERE id = :id", $params);
?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> <?=$mode?> Press Release <small></small> </h1>
    <ol class="breadcrumb">
      <li><a href="list_pressrelease.php"><i class="fa fa-navicon"></i> Press release List</a></li>
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
          <form role="form" method="post" action="act_pressrelease.php" onsubmit="return validateForm();" enctype="multipart/form-data">
          <input type="hidden" name="id" id="id" value="<?=$TypeArray['id']?>"  />
           <input type="hidden" name="pgNo" id="pgNo" value="<?=$_REQUEST['pgNo']?>"  />
            <div class="box-body">
			<div class="form-group">
                <label for="exampleInputEmail1">Title<?=MANDATORY?></label>
                <input type="text" class="form-control " id="title" name="title" value="<?=stripslashes($TypeArray['title'])?>" placeholder="Title" style="width:40%;">
              </div>
	             
              <!--div class="form-group">
                <label for="exampleInputEmail1">Short Description</label>
                <textarea class="form-control" placeholder="Short Description..." name="short_description" id="short_description" rows="3" style="width:40%;"><?=($TypeArray['short_description'])?></textarea>
              </div-->
			  
			  <div class="form-group">
                <label for="exampleInputEmail1">Description</label>
                <textarea class="form-control" id="editor1" name="description"  rows="10" cols="80" placeholder="Description..." ><?=stripslashes($TypeArray['description'])?></textarea>
              </div>
			  
              <div class="form-group">
                <label for="exampleInputEmail1">Link</label>
                <input type="url" class="form-control " id="link" name="link" value="<?=stripslashes($TypeArray['link'])?>" placeholder="Link" style="width:40%;">
              </div>
			  
			  <div class="form-group">
                <label for="exampleInputEmail1">Release date<?=MANDATORY?></label>
                <div class="input-group date" style="width:40%;">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="release_date" name="release_date" value="<?=stripslashes($TypeArray['release_date'])?>"  placeholder="Release date" required>
                </div>
              </div>
             	<div class="form-group" id="Imagelink">
                <label for="exampleInputEmail1">Image<?=MANDATORY?></label>
                <input type="file" class="form-control " id="image" name="image" value="" placeholder=" Testimonial Image" style="width:40%;" onchange="return Checkfile()">
                <div class="alert alert-danger alert-dismissible" style="width:40%;margin-top:10px;">[Note:- File Size : 440X295  , MAX File Upload Size : 3MB]</div>
                <?php if($TypeArray['thumbnail']){ ?>
                <a href="#" id='existing_image'><img src="../uploads/press_images/<?=stripslashes($TypeArray['thumbnail'])?>"  onerror="this.style.display='none'" height="80" width="100" onclick='window.open("../uploads/testimonial_images/<?=stripslashes($TypeArray['thumbnail'])?>","","width=600,height=600,scrollbars=Yes,resizable=yes")' /></a>
				<?php } ?>
              </div>					
              <div class="form-group">
                <label for="exampleInputEmail1">Meta Title</label>
                <input type="text" class="form-control " id="meta_title" name="meta_title" value="<?=stripslashes($TypeArray['meta_title'])?>" placeholder="Meta Title" style="width:40%;">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Meta Keywords</label>
                <input type="text" class="form-control " id="meta_keywords" name="meta_keywords" value="<?=stripslashes($TypeArray['meta_keywords'])?>" placeholder="Meta Keywords" style="width:40%;">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Meta Description</label>
                <textarea class="form-control" rows="3" name="meta_description" id="meta_description" placeholder="Meta Description ..." style="width:40%;"><?=stripslashes($TypeArray['meta_description'])?></textarea>
              </div>
			   
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <button type="submit" class="btn btn-primary" value="SAVE" name="SAVE" id="SAVE">Submit</button>
              <a href="list_pressrelease.php?pgNo=<?php echo intval(base64_decode($_REQUEST['pgNo'])); ?>" class="btn btn-danger" >Back</a>
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
if(sysmsg==0){
	$(".errorDiv").hide();
}
else{
	$(".errorDiv").show().fadeOut(4000);
}
</script>
<script type="text/javascript" language="javascript">
function validateForm(){
	if($("input#title").val()==""){
		$(".errorDiv").show().fadeOut(4000);
		$('#errormessage').text("Category Title is Mandatory");
		$("input#title").focus();
		return false;
	}
	if($("input#short_description").val()==""){
		$(".errorDiv").show().fadeOut(4000);
		$('#errormessage').text("Short description is Mandatory");
		$("input#short_description").focus();
		return false;
	}
	if($("input#link").val()==""){
		$(".errorDiv").show().fadeOut(4000);
		$('#errormessage').text("Link is Mandatory");
		$("input#link").focus();
		return false;
	}
	if($("input#release_date").val()==""){
		$(".errorDiv").show().fadeOut(4000);
		$('#errormessage').text("Release date is Mandatory");
		$("input#release_date").focus();
		return false;
	}
	return true;
}
function Checkfile(){
	var fup = document.getElementById('image');
	var fileName = fup.value;
	var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
	if(ext == "jpg" || ext == "JPG"  || ext == "gif" || ext == "GIF" || ext == "png" || ext == "PNG" || ext == "jpeg" || ext == "JPEG"){
		//return true;
	}else{
		alert('Upload jpg, png, gif files only.');
		$(".errorDiv").show().fadeOut(4000);
		$('#errormessage').text("Upload jpg, png, gif files only.");
		$("input#image").focus();
		$("input#image").val("");
		return false;
	}
}
function Checkfile1(){
	var fup = document.getElementById('image1');
	var fileName = fup.value;
	var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
	if(ext == "jpg" || ext == "JPG"  || ext == "gif" || ext == "GIF" || ext == "png" || ext == "PNG" || ext == "jpeg" || ext == "JPEG"){
		//return true;
	}else{
		alert('Upload jpg, png, gif files only.');
		$(".errorDiv").show().fadeOut(4000);
		$('#errormessage').text("Upload jpg, png, gif files only.");
		$("input#image").focus();
		$("input#image").val("");
		return false;
	}
}
//Date picker
$('#release_date').datepicker({
  format: "yyyy-mm-dd",
	//startDate: '-d',
	todayHighlight: true,
	 pickTime:true,
	autoclose: true
});
</script>
<script>
  $(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1');
	
    //bootstrap WYSIHTML5 - text editor
    $(".textarea").wysihtml5();
  });
</script>