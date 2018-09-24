<!-- Content Wrapper. Contains page content -->
<?php 
require_once("left.php");

#==== Object Initialisations
$POST		= $objTypes->validateUserInput($_POST);
$id 		= isset($POST['id']) ? intval($POST['id']) : intval($_REQUEST['id']) ;
$mode 		= ($id<>'0') ? 'Edit' : 'Add';
$params     = array(":id" => $id);
$res_arr	= $objTypes->fetchRow("SELECT id, title1, title2, description,externalurl, image, image1, image2, thumbnail, added_by, updated_by, updated_date FROM tbl_homebanner WHERE id = :id", $params);
//echo ">>>";  print_r($res_arr); exit;
?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> <?=$mode?> Home Page Banner  <small></small> </h1>
    <ol class="breadcrumb">
      <li><a href="list_homebanner.php"><i class="fa  fa-navicon"></i> Home Page Banner List</a></li>
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
          <form role="form" method="post" action="act_homebanner.php" onsubmit="return validateForm();" enctype="multipart/form-data">
          <input type="hidden" name="id" id="id" value="<?=$res_arr['id']?>"  />
           <input type="hidden" name="pgNo" id="pgNo" value="<?=$_REQUEST['pgNo']?>"  />
            <div class="box-body">
				  <div class="form-group">
					  <label for="exampleInputEmail1">Title1<?=MANDATORY?></label>
					  <input type="text" class="form-control " id="title1" name="title1" value="<?=stripslashes($res_arr['title1'])?>" placeholder="Title1" style="width:40%;">
				  </div>
				  <div class="form-group">
					  <label for="exampleInputEmail1">Title2<?=MANDATORY?></label>
					  <input type="text" class="form-control " id="title2" name="title2" value="<?=stripslashes($res_arr['title2'])?>" placeholder="Title2" style="width:40%;">
				  </div>
				  <div class="form-group">
						<label for="exampleInputEmail1">Description</label>
						<textarea class="form-control" placeholder="Short Description..." name="description" id="editor1" rows="3" style="width:40%;"><?=stripslashes($res_arr['description'])?></textarea><p id="cnt"></p>
				  </div>
				  <div class="form-group">
					<label for="exampleInputEmail1">External Url</label>
					<input type="url" class="form-control " id="externalurl" name="externalurl" value="<?=stripslashes($res_arr['externalurl'])?>" placeholder="External Url" style="width:40%;">
				  </div>
				  <div class="form-group">
						<label for="exampleInputEmail1">Desktop Image<?=MANDATORY?></label>
						<input type="file" class="form-control " id="image" name="image" value="" placeholder="Desktop Banner Image" style="width:40%;" onchange="return Checkfile()">
						<div class="alert alert-danger alert-dismissible" style="width:40%;margin-top:10px;">[Note:- File Size : 1920 x 695  , MAX File Upload Size : 3MB]</div>
						<?php if($res_arr['image']){ ?>
						<a href="#" id='existing_image'><img src="../uploads/homebanner_images/large/<?=stripslashes($res_arr['image'])?>"  onerror="this.style.display='none'" width="100" onclick='window.open("../uploads/homebanner_images/large/<?=stripslashes($res_arr['image'])?>","","width=600,height=600,scrollbars=Yes,resizable=yes")' /></a>
						<?php } ?>
				  </div>
				  <div class="form-group">
						<label for="exampleInputEmail1">Tab Image<?=MANDATORY?></label>
						<input type="file" class="form-control " id="image1" name="image1" value="" placeholder="Tab Banner Image" style="width:40%;" onchange="return Checkfile1()">
						<div class="alert alert-danger alert-dismissible" style="width:40%;margin-top:10px;">[Note:- File Size : 1000 x 362  , MAX File Upload Size : 3MB]</div>
						<?php if($res_arr['image1']){ ?>
						<a href="#" id='existing_image1'><img src="../uploads/homebanner_images/medium/<?=stripslashes($res_arr['image1'])?>"  onerror="this.style.display='none'" width="100" onclick='window.open("../uploads/homebanner_images/medium/<?=stripslashes($res_arr['image1'])?>","","width=600,height=600,scrollbars=Yes,resizable=yes")' /></a>
						<?php } ?>
				  </div>
				   <div class="form-group">
						<label for="exampleInputEmail1">Mobile Image<?=MANDATORY?></label>
						<input type="file" class="form-control " id="image2" name="image2" value="" placeholder="Mobile Banner Image" style="width:40%;" onchange="return Checkfile2()">
						<div class="alert alert-danger alert-dismissible" style="width:40%;margin-top:10px;">[Note:- File Size : 480 x 174  , MAX File Upload Size : 3MB]</div>
						<?php if($res_arr['image2']){ ?>
						<a href="#" id='existing_image2'><img src="../uploads/homebanner_images/small/<?=stripslashes($res_arr['image2'])?>"  onerror="this.style.display='none'" width="100" onclick='window.open("../uploads/homebanner_images/small/<?=stripslashes($res_arr['image2'])?>","","width=600,height=600,scrollbars=Yes,resizable=yes")' /></a>
						<?php } ?>
				  </div>
				   <input type="hidden" name="store_image" value="<?php echo $res_arr['image']; ?>">
				   <input type="hidden" name="store_image1" value="<?php echo $res_arr['image1']; ?>">
				   <input type="hidden" name="store_image2" value="<?php echo $res_arr['image2']; ?>">
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <button type="submit" class="btn btn-primary" value="SAVE" name="SAVE" id="SAVE">Submit</button>
              <a href="list_homebanner.php" class="btn btn-danger" >Back</a>
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
</script>
<script type="text/javascript" language="javascript">
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
	
	/*if($("#externalurl").val()==""){
		$(".errorDiv").show().fadeOut(4000);
		$('#errormessage').text("Please enter url");
		$("#externalurl").focus();
		return false;
	}*/
	
	var image_name = '<?php echo  $res_arr['image'] ?>';
	if(image_name !='')
	{
		if($("#existing_image").html()=='')
		{
			
			if($("input#image").val()==""){
			$(".errorDiv").show().fadeOut(4000);
			$('#errormessage').text("Image is Mandatory");
			$("input#image").focus();
			return false;
			}
		}
	}
	else{
			if($("input#image").val()==""){
			$(".errorDiv").show().fadeOut(4000);
			$('#errormessage').text("Image is Mandatory");
			$("input#image").focus();
			return false;
			}
	}
	<!--------------------tab---------------->
	var image_name1 = '<?php echo  $res_arr['image1'] ?>';
	if(image_name1 !='')
	{
		if($("#existing_image1").html()=='')
		{
			
			if($("input#image1").val()==""){
			$(".errorDiv").show().fadeOut(4000);
			$('#errormessage').text("Image is Mandatory");
			$("input#image1").focus();
			return false;
			}
		}
	}
	else{
			if($("input#image1").val()==""){
			$(".errorDiv").show().fadeOut(4000);
			$('#errormessage').text("Image is Mandatory");
			$("input#image1").focus();
			return false;
			}
	}
	<!--------------------mobile---------------->
	
	var image_name2 = '<?php echo  $res_arr['image2'] ?>';
	if(image_name2 !='')
	{
		if($("#existing_image2").html()=='')
		{
			
			if($("input#image2").val()==""){
			$(".errorDiv").show().fadeOut(4000);
			$('#errormessage').text("Image is Mandatory");
			$("input#image2").focus();
			return false;
			}
		}
	}
	else{
			if($("input#image2").val()==""){
			$(".errorDiv").show().fadeOut(4000);
			$('#errormessage').text("Image is Mandatory");
			$("input#image2").focus();
			return false;
			}
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

