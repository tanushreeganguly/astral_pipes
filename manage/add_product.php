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
	$res_arr	= $objTypes->fetchRow("SELECT * FROM tbl_products_details WHERE id = :id", $params);
}
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> <?=$mode?> Product <small></small> </h1>
    <ol class="breadcrumb">
      <li><a href="list_product.php"><i class="fa  fa-navicon"></i> Product List</a></li>
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
          <form id="productForm" role="form" method="post" action="act_product.php" onsubmit="return validateForm();" enctype="multipart/form-data">
          <input type="hidden" name="id" id="id" value="<?=$res_arr['id']?>"  />
           <input type="hidden" name="pgNo" id="pgNo" value="<?=$_REQUEST['pgNo']?>"  />
            <div class="box-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Title<?=MANDATORY?></label>
                <input type="text" class="form-control " id="title" name="title" value="<?=stripslashes($res_arr['title'])?>" placeholder="Title" style="width:40%;" required>
              </div>
			  
			  <div class="form-group">
				<label for="exampleInputEmail1">Logo<?=MANDATORY?></label>
					<input type="file" class="form-control " id="logo" name="logo" value="" placeholder="Logo" style="width:40%;" onchange="return Checkfile3()">
					<div class="alert alert-danger alert-dismissible" style="width:40%;margin-top:10px;">[Note:- File Size : 100 x 100  , MAX File Upload Size : 2MB]</div>
					<?php if($res_arr['logo']){ ?>
					<a href="#" id='existing_image'><img src="../uploads/product_images/logo/<?=stripslashes($res_arr['logo'])?>"  onerror="this.style.display='none'" width="100" onclick='window.open("../uploads/product_images/logo/<?=stripslashes($res_arr['logo'])?>","","width=600,height=600,scrollbars=Yes,resizable=yes")' /></a>
						<?php } ?>
				  </div>
				  
			 <div class="form-group">
			  <label for="exampleInputEmail1">Application<?=MANDATORY?></label>
			  <select class="form-control" name="app_id" id="app_id" style="width: 40%" required>
				  <option value="">Select Application</option>
				  <?php
                      $app_arr	= $objTypes->fetchAll("SELECT title, id FROM tbl_applications WHERE is_delete='1' AND is_active='1' ");
						if(sizeof($app_arr) > 0){
							foreach($app_arr as $app_v){
								if($app_v['id'] == $res_arr['app_id']){
									$selected1 = 'selected';
								}
								else{
									$selected1 = '';
								}
								?>
								<option value="<?php echo $app_v['id'] ?>" <?=$selected1?>><?php echo stripslashes($app_v['title']); ?></option>
								<?php
							}
						}
						?>
			  </select>
             </div>
             <div class="form-group">
                <label for="exampleInputEmail1">Short Description</label>
                <textarea class="form-control" placeholder="Short Description..." name="short_description" id="editor1" rows="3" ><?=stripslashes($res_arr['short_description'])?></textarea>
              </div>
              
              <div class="form-group">
				<label for="exampleInputEmail1">Desktop Image<?=MANDATORY?></label>
					<input type="file" class="form-control " id="desk_image" name="desk_image" value="" placeholder="Desktop Banner Image" style="width:40%;" onchange="return Checkfile()">
					<div class="alert alert-danger alert-dismissible" style="width:40%;margin-top:10px;">[Note:- File Size : 1920 x 695  , MAX File Upload Size : 3MB]</div>
					<?php if($res_arr['desk_image']){ ?>
					<a href="#" id='existing_image'><img src="../uploads/product_images/large/<?=stripslashes($res_arr['desk_image'])?>"  onerror="this.style.display='none'" width="100" onclick='window.open("../uploads/product_images/large/<?=stripslashes($res_arr['desk_image'])?>","","width=600,height=600,scrollbars=Yes,resizable=yes")' /></a>
						<?php } ?>
				  </div>
				  <div class="form-group">
						<label for="exampleInputEmail1">Tab Image<?=MANDATORY?></label>
						<input type="file" class="form-control " id="tab_image" name="tab_image" value="" placeholder="Tab Banner Image" style="width:40%;" onchange="return Checkfile1()">
						<div class="alert alert-danger alert-dismissible" style="width:40%;margin-top:10px;">[Note:- File Size : 1000 x 362  , MAX File Upload Size : 3MB]</div>
						<?php if($res_arr['tab_image']){ ?>
						<a href="#" id='existing_image1'><img src="../uploads/product_images/medium/<?=stripslashes($res_arr['tab_image'])?>"  onerror="this.style.display='none'" width="100" onclick='window.open("../uploads/product_images/medium/<?=stripslashes($res_arr['tab_image'])?>","","width=600,height=600,scrollbars=Yes,resizable=yes")' /></a>
						<?php } ?>
				  </div>
				   <div class="form-group">
						<label for="exampleInputEmail1">Mobile Image<?=MANDATORY?></label>
						<input type="file" class="form-control " id="mobile_image" name="mobile_image" value="" placeholder="Mobile Banner Image" style="width:40%;" onchange="return Checkfile2()">
						<div class="alert alert-danger alert-dismissible" style="width:40%;margin-top:10px;">[Note:- File Size : 480 x 174  , MAX File Upload Size : 3MB]</div>
						<?php if($res_arr['mobile_image']){ ?>
						<a href="#" id='existing_mobile_image'><img src="../uploads/product_images/small/<?=stripslashes($res_arr['mobile_image'])?>"  onerror="this.style.display='none'" width="100" onclick='window.open("../uploads/product_images/small/<?=stripslashes($res_arr['mobile_image'])?>","","width=600,height=600,scrollbars=Yes,resizable=yes")' /></a>
						<?php } ?>
				  </div>
                           
               <div class="form-group">
                <label for="exampleInputEmail1">Broucher (PDF only)</label>
               	<input type="file" class="form-control" placeholder="PDF" name="catalogue" id="catalogue"  style="width:40%;" onchange="return Checkpdf(catalogue)" />
              </div>
				<?php if($res_arr['broucher']){ ?>
                <a href="../uploads/product_broucher/<?php echo $res_arr['broucher']; ?>" id='existing_image' target="_blank"><img src="../images/pdf-icon.jpg"  /></a>
				<?php } ?>
				
               <div class="form-group">
                <label for="exampleInputEmail1">About</label>
                <textarea class="form-control" placeholder="About..." name="about" id="editor2" rows="2" style="width:30%;"><?=stripslashes($res_arr['about'])?></textarea>
              </div>
              
              <div class="form-group">
                <label for="exampleInputEmail1">Technical details</label>
                <textarea class="form-control" placeholder="Technical details..." name="technical_details" id="editor3" rows="3" style="width:40%;"><?=stripslashes($res_arr['technical_details'])?></textarea>
              </div>
			<div class="form-group">
                <label for="exampleInputEmail1">Features & Benefits </label>
                <textarea class="form-control" placeholder="Features & Benefits..." name="features_benefits" id="editor4" rows="3" style="width:40%;"><?=stripslashes($res_arr['features_benefits'])?></textarea>
			</div>
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
              <a href="list_product.php?&pgNo=<?php echo intval(base64_decode($_REQUEST['pgNo'])); ?>" class="btn btn-danger" >Back</a>
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
           	window.location.href = '<?=base_url?>act_product.php?id='+id+'&param=rimg&prodid=<?php echo $id ?>&pgNo=<?=$_REQUEST['pgNo']?>';
           $(this).closest("#productForm").append('<input type="hidden" name="param" value="rimg" /><input type="hidden" name="id" value="'+id+'" /><input type="hidden" name="prodid" value="<?php echo $id ?>" /><input type="hidden" name="pgNo" value="<?=$_REQUEST['pgNo']?>" />');
           $(this).closest("#productForm").submit();
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
		$('#errormessage').text("Product Title is Mandatory");
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
function Checkfile3(){
	var fup = document.getElementById('logo');
	var fileName = fup.value;
	var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
	if(ext == "jpg" || ext == "JPG"  || ext == "gif" || ext == "GIF" || ext == "png" || ext == "PNG" || ext == "jpeg" || ext == "JPEG"){
		//return true;
	}else{
		alert('Upload jpg, png, gif files only.');
		$(".errorDiv").show().fadeOut(4000);
		$('#errormessage').text("Upload jpg, png, gif files only.");
		$("input#logo").focus();
		$("input#logo").val("");
		return false;
	}
}
</script>
<script>
  $(function () {
	CKEDITOR.replace('editor1');
	CKEDITOR.replace('editor2');
	CKEDITOR.replace('editor3');
	CKEDITOR.replace('editor4');
    //bootstrap WYSIHTML5 - text editor
    $(".textarea").wysihtml5();
  });
</script>