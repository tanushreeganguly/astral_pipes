<!-- Content Wrapper. Contains page content -->
<?php
require_once("left.php");
#==== Object Initialisations

$POST		= $objTypes->validateUserInput($_POST);
$id 		= isset($POST['id']) ? intval($POST['id']) : intval($_REQUEST['id']) ;
$mode 		= ($id<>'0') ? 'Edit' : 'Add';
$params     = array(":id" => $id);
$params_img = array(":category_id" => $id);

if($id!=0){
	$res_arr	= $objTypes->fetchRow("SELECT * FROM tbl_clients WHERE id = :id", $params);
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> <?=$mode?> client <small></small> </h1>
    <ol class="breadcrumb">
      <li><a href="list_clients.php"><i class="fa  fa-navicon"></i> client List</a></li>
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
          <form id="clientForm" role="form" method="post" action="act_clients.php" onsubmit="return validateForm();" enctype="multipart/form-data">
          <input type="hidden" name="id" id="id" value="<?=$res_arr['id']?>"  />
           <input type="hidden" name="pgNo" id="pgNo" value="<?=$_REQUEST['pgNo']?>"  />
            <div class="box-body">
             
			 <div class="form-group">
			  <label for="exampleInputEmail1">Category<?=MANDATORY?></label>
			  <select class="form-control" name="client_cat_id" id="client_cat_id" style="width: 40%" required>
				  <option value="">Select Category</option>
				  <?php
                      $cat_arr	= $objTypes->fetchAll("SELECT title, id FROM tbl_client_category WHERE is_delete='1' AND is_active='1' ");
						if(sizeof($cat_arr) > 0){
							foreach($cat_arr as $cat_v){
								if($cat_v['id'] == $res_arr['client_cat_id']){
									$selected = 'selected';
								}
								else{
									$selected = '';
								}
								?>
								<option value="<?php echo $cat_v['id'] ?>" <?=$selected?>><?php echo stripslashes($cat_v['title']); ?></option>
								<?php
							}
						}
						?>
			  </select>
             </div>
			 
			 
			  <div class="form-group">
                <label for="exampleInputEmail1">Client<?=MANDATORY?></label>
                <input type="text" class="form-control " id="client" name="client" value="<?=stripslashes($res_arr['client'])?>" placeholder="Client" style="width:40%;" required>
              </div>
			  
			   <div class="form-group">
                <label for="exampleInputEmail1">Description</label>
                <textarea class="form-control" id="editor1" name="description"  rows="10" cols="80" placeholder="Description..." ><?=stripslashes($res_arr['description'])?></textarea>
              </div>
			  
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <button type="submit" class="btn btn-primary" value="SAVE" name="SAVE" id="SAVE">Submit</button>
              <a href="list_clients.php?&pgNo=<?php echo intval(base64_decode($_REQUEST['pgNo'])); ?>" class="btn btn-danger" >Back</a>
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
<script>
jQuery(function(){
    jQuery('.img-wrap2 .close2').click(function() {
        var id = $(this).closest('.img-wrap2').find('img').data('id');
        if(confirm('Are you sure you want to delete selected images?')) {
           	window.location.href = '<?=base_url?>act_clients.php?id='+id+'&param=rimg&prodid=<?php echo $id ?>&pgNo=<?=$_REQUEST['pgNo']?>';
           $(this).closest("#clientForm").append('<input type="hidden" name="param" value="rimg" /><input type="hidden" name="id" value="'+id+'" /><input type="hidden" name="prodid" value="<?php echo $id ?>" /><input type="hidden" name="pgNo" value="<?=$_REQUEST['pgNo']?>" />');
           $(this).closest("#clientForm").submit();
        }
        else{
            return false;
        }
    });
})
</script>
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
$(document).ready(function(){
	var cat;
	var title=$("#title").val();
	
	if(title==""){
		$("#parcat").hide();
		$("#cat").hide();
		
	}
});

function validateForm(){
	if($("input#title").val()==""){
		$(".errorDiv").show().fadeOut(4000);
		$('#errormessage').text("client Title is Mandatory");
		$("input#title").focus();
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
		$("input#catalogue").focus();
		$("input#catalogue").val("");
		return false;
	}
}
function Checkfile(){
	var fup = document.getElementById('desk_image');
	var fileName = fup.value;
	var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
	if(ext == "jpg" || ext == "JPG"  || ext == "gif" || ext == "GIF" || ext == "png" || ext == "PNG" || ext == "jpeg" || ext == "JPEG"){
		//return true;
	}else{
		alert('Upload jpg, png, gif files only.');
		$(".errorDiv").show().fadeOut(4000);
		$('#errormessage').text("Upload jpg, png, gif files only.");
		$("input#desk_image").focus();
		$("input#desk_image").val("");
		return false;
	}
}
function Checkfile1(){
	var fup = document.getElementById('tab_image');
	var fileName = fup.value;
	var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
	if(ext == "jpg" || ext == "JPG"  || ext == "gif" || ext == "GIF" || ext == "png" || ext == "PNG" || ext == "jpeg" || ext == "JPEG"){
		//return true;
	}else{
		alert('Upload jpg, png, gif files only.');
		$(".errorDiv").show().fadeOut(4000);
		$('#errormessage').text("Upload jpg, png, gif files only.");
		$("input#tab_image").focus();
		$("input#tab_image").val("");
		return false;
	}
}

function Checkfile2(){
	var fup = document.getElementById('mobile_image');
	var fileName = fup.value;
	var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
	if(ext == "jpg" || ext == "JPG"  || ext == "gif" || ext == "GIF" || ext == "png" || ext == "PNG" || ext == "jpeg" || ext == "JPEG"){
		//return true;
	}else{
		alert('Upload jpg, png, gif files only.');
		$(".errorDiv").show().fadeOut(4000);
		$('#errormessage').text("Upload jpg, png, gif files only.");
		$("input#mobile_image").focus();
		$("input#mobile_image").val("");
		return false;
	}
}
</script>
<script>
  $(function () {
     CKEDITOR.config.allowedContent = true;
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
	CKEDITOR.replace('editor1');
    //bootstrap WYSIHTML5 - text editor
    $(".textarea").wysihtml5();
  });
</script>