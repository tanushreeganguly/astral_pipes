<!-- Content Wrapper. Contains page content -->
<?php 
require_once("left.php");
#==== Object Initialisations
$POST		= $objTypes->validateUserInput($_POST);
$id 		= isset($POST['id']) ? intval($POST['id']) : intval($_REQUEST['id']) ;
$mode 		= ($id<>'0') ? 'Edit' : 'Add';
$params     = array(":id" => $id);
$res_arr	= $objTypes->fetchRow("SELECT id,type, is_home,title, image, thumbnail, youtube, thumbnail, added_by, updated_by, updated_date FROM tbl_whats_new WHERE id = :id", $params);
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> <?=$mode?> Whats new <small></small> </h1>
    <ol class="breadcrumb">
      <li><a href="list_whats_new.php"><i class="fa  fa-navicon"></i> Whats new List</a></li>
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
          <form role="form" method="post" action="act_whats_new.php" onsubmit="return validateForm();" enctype="multipart/form-data">
          <input type="hidden" name="id" id="id" value="<?=$res_arr['id']?>"  />
           <input type="hidden" name="pgNo" id="pgNo" value="<?=$_REQUEST['pgNo']?>"  />
            <div class="box-body">
				  <div class="form-group">
					  <label for="exampleInputEmail1">Title<?=MANDATORY?></label>
					  <input type="text" class="form-control" id="title" name="title" value="<?=stripslashes($res_arr['title'])?>" placeholder="Title" style="width:40%;">
				  </div>
				  <div class="form-group">
			  <label for="exampleInputEmail1">Type<?=MANDATORY?></label>
			  <select class="form-control" name="type" id="type" style="width: 40%" required>
				  <option value="">Select Type</option>
				  <option value="image" <?php if($res_arr['type']=="image") echo "selected";?>>Image</option>
			      <option value="video" <?php if($res_arr['type']=="video") echo "selected";?>>Video</option>
			  </select>
             </div>
				  <div class="form-group">
					  <label for="exampleInputEmail1">Youtube Link</label>
					  <input type="text" class="form-control " id="youtube" name="youtube" value="<?=stripslashes($res_arr['youtube'])?>" placeholder="Youtube" style="width:40%;">
				  </div>
				  <div class="form-group">
						<label for="exampleInputEmail1">Image<?=MANDATORY?></label>
						<input type="file" class="form-control " id="image" name="image" value="" placeholder=" image" style="width:40%;" onchange="return Checkfile1()">
						<div class="alert alert-danger alert-dismissible" style="width:40%;margin-top:10px;">[Note:- File Size : 565 x 420  , MAX File Upload Size : 3MB]</div>
						<?php if($res_arr['image']){ ?>
						<a href="#" id='existing_image'><img src="../uploads/whats_new_images/<?=stripslashes($res_arr['image'])?>"  onerror="this.style.display='none'" width="100" onclick='window.open("../uploads/whats_new_images/<?=stripslashes($res_arr['image'])?>","","width=600,height=600,scrollbars=Yes,resizable=yes")' /></a>
						<?php } ?>
						<input type="hidden" name="store_image" value="<?php echo $res_arr['image']; ?>">
						 <input type="hidden" name="store_image" value="<?php echo $res_arr['image']; ?>">
				  </div>
				   <div class="form-group">
					<label for="exampleInputEmail1">Home</label><br/>					
					<input type="radio" name="is_home" id="is_home" value="1" <?php echo ($res_arr['is_home']==1) ? 'checked="checked"' : '';?> >	Yes
					<input type="radio" name="is_home" id="is_home" value="0" <?php echo ($res_arr['is_home']==0) ? 'checked="checked"' : '';?> > No
			  </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <button type="submit" class="btn btn-primary" value="SAVE" name="SAVE" id="SAVE">Submit</button>
              <a href="list_whats_new.php" class="btn btn-danger" >Back</a>
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
}
else{
	$(".errorDiv").show().fadeOut(4000);
}
function validateForm(){	
	if($("#title1").val()==""){
		$(".errorDiv").show().fadeOut(4000);
		$('#errormessage').text("Please enter title1");
		$("#title1").focus();
		return false;
	}
	if($("#title2").val()==""){
		$(".errorDiv").show().fadeOut(4000);
		$('#errormessage').text("Please enter title2");
		$("#title2").focus();
		return false;
	}	
	return true;
}
function Checkfile1(){
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
</script>