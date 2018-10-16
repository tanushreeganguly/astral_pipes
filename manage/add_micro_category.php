<!-- Content Wrapper. Contains page content -->
<?php 
require_once("left.php");

#==== Object Initialisations
$POST		= $objTypes->validateUserInput($_POST);
$id 		= isset($POST['id']) ? intval($POST['id']) : intval($_REQUEST['id']) ;
$mode 		= ($id<>'0') ? 'Edit' : 'Add';
$params     = array(":id" => $id);
$res_arr	= $objTypes->fetchRow("SELECT * FROM tbl_micro_category WHERE id = :id", $params);
?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> <?=$mode?> Category   <small></small> </h1>
    <ol class="breadcrumb">
      <li><a href="list_micro_category.php"><i class="fa  fa-navicon"></i> category List</a></li>
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
          <form role="form" method="post" action="act_micro_category.php" onsubmit="return validateForm();" enctype="multipart/form-data">
          <input type="hidden" name="id" id="id" value="<?=$res_arr['id']?>"  />
           <input type="hidden" name="pgNo" id="pgNo" value="<?=$_REQUEST['pgNo']?>"  />
            <div class="box-body">
				  <div class="form-group">
					  <label for="exampleInputEmail1">Title<?=MANDATORY?></label>
					  <input type="text" class="form-control " id="title" name="title" value="<?=stripslashes($res_arr['title'])?>" placeholder="Title" style="width:40%;" required>
				  </div>
				  <div class="form-group">
						<label for="exampleInputEmail1">Description</label>
						<textarea class="form-control" placeholder="Short Description..." name="description" id="editor1" rows="3" style="width:40%;"><?=stripslashes($res_arr['description'])?></textarea><p id="cnt"></p>
				  </div>
				 
				  <div class="form-group">
						<label for="exampleInputEmail1">Desktop Image</label>
						<input type="file" class="form-control " id="image" name="image" value="" placeholder="Desktop Banner Image" style="width:40%;" onchange="return Checkfile()">
						<div class="alert alert-danger alert-dismissible" style="width:40%;margin-top:10px;">[Note:- File Size : 1920 x 695  , MAX File Upload Size : 3MB]</div>
						<?php if($res_arr['image']){ ?>
						<a href="#" id='existing_image'><img src="../uploads/micro_category_images/large/<?=stripslashes($res_arr['image'])?>"  onerror="this.style.display='none'" width="100" onclick='window.open("../uploads/micro_category_images/large/<?=stripslashes($res_arr['image'])?>","","width=600,height=600,scrollbars=Yes,resizable=yes")' /></a>
						<?php } ?>
				  </div>
				  <div class="form-group">
						<label for="exampleInputEmail1">Tab Image</label>
						<input type="file" class="form-control " id="image1" name="image1" value="" placeholder="Tab Banner Image" style="width:40%;" onchange="return Checkfile1()">
						<div class="alert alert-danger alert-dismissible" style="width:40%;margin-top:10px;">[Note:- File Size : 1000 x 362  , MAX File Upload Size : 3MB]</div>
						<?php if($res_arr['image1']){ ?>
						<a href="#" id='existing_image1'><img src="../uploads/micro_category_images/medium/<?=stripslashes($res_arr['image1'])?>"  onerror="this.style.display='none'" width="100" onclick='window.open("../uploads/micro_category_images/medium/<?=stripslashes($res_arr['image1'])?>","","width=600,height=600,scrollbars=Yes,resizable=yes")' /></a>
						<?php } ?>
				  </div>
				   <div class="form-group">
						<label for="exampleInputEmail1">Mobile Image</label>
						<input type="file" class="form-control " id="image2" name="image2" value="" placeholder="Mobile Banner Image" style="width:40%;" onchange="return Checkfile2()">
						<div class="alert alert-danger alert-dismissible" style="width:40%;margin-top:10px;">[Note:- File Size : 480 x 174  , MAX File Upload Size : 3MB]</div>
						<?php if($res_arr['image2']){ ?>
						<a href="#" id='existing_image2'><img src="../uploads/micro_category_images/small/<?=stripslashes($res_arr['image2'])?>"  onerror="this.style.display='none'" width="100" onclick='window.open("../uploads/micro_category_images/small/<?=stripslashes($res_arr['image2'])?>","","width=600,height=600,scrollbars=Yes,resizable=yes")' /></a>
						<?php } ?>
				  </div>
				   <input type="hidden" name="store_image" value="<?php echo $res_arr['image']; ?>">
				   <input type="hidden" name="store_image1" value="<?php echo $res_arr['image1']; ?>">
				   <input type="hidden" name="store_image2" value="<?php echo $res_arr['image2']; ?>">
				   
				   <div class="form-group">
                <label for="exampleInputEmail1">Meta Title</label>
                <input type="text" class="form-control " id="meta_title" name="meta_title" value="<?=stripslashes($res_arr['meta_title'])?>" placeholder="Meta Title" style="width:40%;">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Meta Keywords</label>
                <input type="text" class="form-control " id="meta_keywords" name="meta_keywords" value="<?=stripslashes($res_arr['meta_keywords'])?>" placeholder="Meta Keywords" style="width:40%;">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Meta Description</label>
                <textarea class="form-control" rows="3" name="meta_description" id="meta_description" placeholder="Meta Description ..." style="width:40%;"><?=stripslashes($res_arr['meta_description'])?></textarea>
              </div>
				
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <button type="submit" class="btn btn-primary" value="SAVE" name="SAVE" id="SAVE">Submit</button>
              <a href="list_micro_category.php" class="btn btn-danger" >Back</a>
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
var sysmsg = "<?=$sysmsg?>";
if(sysmsg==0){
	$(".errorDiv").hide();
}else{
	$(".errorDiv").show().fadeOut(4000);
}
</script>
<script type="text/javascript" language="javascript">
function validateForm(){	
	if($("#title").val()==""){
		$(".errorDiv").show().fadeOut(4000);
		$('#errormessage').text("Please enter title");
		$("#title1").focus();
		return false;
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
		$("input#image1").focus();
		$("input#image1").val("");
		return false;
	}
}
function Checkfile2(){
	var fup = document.getElementById('image2');
	var fileName = fup.value;
	var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
	if(ext == "jpg" || ext == "JPG"  || ext == "gif" || ext == "GIF" || ext == "png" || ext == "PNG" || ext == "jpeg" || ext == "JPEG"){
		//return true;
	}else{
		alert('Upload jpg, png, gif files only.');
		$(".errorDiv").show().fadeOut(4000);
		$('#errormessage').text("Upload jpg, png, gif files only.");
		$("input#image2").focus();
		$("input#image2").val("");
		return false;
	}
}

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
