<!-- Content Wrapper. Contains page content -->
<?php 
require_once("left.php");

#==== Object Initialisations
$POST		= $objTypes->validateUserInput($_POST);
$id 		= isset($POST['id']) ? intval($POST['id']) : intval($_REQUEST['id']) ;
$mode 		= ($id<>'0') ? 'Edit' : 'Add';
$params     = array(":id" => $id);
$TypeArray	= $objTypes->fetchRow("SELECT id, title1, title2, is_home, image1,location,youtube, thumbnail1, added_by, updated_by, updated_date FROM tbl_adhesive WHERE id = :id", $params);
//echo ">>>";  print_r($TypeArray); exit;
?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> <?=$mode?> Gallery Video<small></small> </h1>
    <ol class="breadcrumb">
      <li><a href="list_video.php"><i class="fa  fa-navicon"></i> Video List</a></li>
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
          <form role="form" method="post" action="act_video.php" onsubmit="return validateForm();" enctype="multipart/form-data">
          <input type="hidden" name="id" id="id" value="<?=$TypeArray['id']?>"  />
		  <input type="hidden" name="type" id="type" value="video"  />
          <input type="hidden" name="pgNo" id="pgNo" value="<?=$_REQUEST['pgNo']?>"  />
            <div class="box-body">
				  <div class="form-group">
					  <label for="exampleInputEmail1">Title1<?=MANDATORY?></label>
					  <input type="text" class="form-control " id="title1" name="title1" value="<?=stripslashes($TypeArray['title1'])?>" placeholder="Title1" style="width:40%;">
				  </div>
				  <div class="form-group">
					  <label for="exampleInputEmail1">Title2</label>
					  <input type="text" class="form-control " id="title2" name="title2" value="<?=stripslashes($TypeArray['title2'])?>" placeholder="Title2" style="width:40%;">
				  </div>
				  <div class="form-group">
					  <label for="exampleInputEmail1">Location</label>
					  <input type="text" class="form-control " id="location" name="location" value="<?=stripslashes($TypeArray['location'])?>" placeholder="Location" style="width:40%;">
				  </div>
				  <div class="form-group">
					  <label for="exampleInputEmail1">Youtube</label>
					  <input type="text" class="form-control " id="youtube" name="youtube" value="<?=stripslashes($TypeArray['youtube'])?>" placeholder="Youtube" style="width:40%;">
				<div class="alert alert-danger alert-dismissible" style="width:40%;margin-top:10px;">Ex.KuhT5ZlnlRI</div>
						
				 <div class="form-group">
						<label for="exampleInputEmail1"> Landing page Image</label>
						<input type="file" class="form-control " id="image1" name="image1" value="" placeholder=" Image1" style="width:40%;" onchange="return Checkfile1()">
						<div class="alert alert-danger alert-dismissible" style="width:40%;margin-top:10px;">[Note:- File Size : 565 x 416  , MAX File Upload Size : 3MB]</div>
						<?php if($TypeArray['image1']){ ?>
						<a href="#" id='existing_image1'><img src="../uploads/astral_pipes_image/large/<?=stripslashes($TypeArray['image1'])?>"  onerror="this.style.display='none'" width="100" onclick='window.open("../uploads/astral_pipes_image/large/<?=stripslashes($TypeArray['image1'])?>","","width=600,height=600,scrollbars=Yes,resizable=yes")' /></a>
						<?php } ?>
						
						 <input type="hidden" name="store_image1" value="<?php echo $TypeArray['image1']; ?>">
				  </div>
				
				  
				  </div>
				
				    <div class="form-group">
					<label for="exampleInputEmail1">Home Video</label><br/>
					
					<input type="radio" name="home_image" id="home_image" value="1" <?php echo ($TypeArray['is_home']==1) ? 'checked="checked"' : '';?> >	Yes
					<input type="radio" name="home_image" id="home_image" value="0" <?php echo ($TypeArray['is_home']==0) ? 'checked="checked"' : '';?> > No
			  </div>
              
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <button type="submit" class="btn btn-primary" value="SAVE" name="SAVE" id="SAVE">Submit</button>
              <a href="list_video.php" class="btn btn-danger" >Back</a>
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

jQuery(function(){
    jQuery('.img-wrap2 .close2').click(function() {
        var id = $(this).closest('.img-wrap2').find('img').data('id');
        if(confirm('Are you sure you want to delete selected images?')) {
           	window.location.href = '<?=base_url?>act_video.php?id='+id+'&param=rimg&prodid=<?php echo $id ?>&pgNo=<?=$_REQUEST['pgNo']?>';
           $(this).closest("#productForm").append('<input type="hidden" name="param" value="rimg" /><input type="hidden" name="id" value="'+id+'" /><input type="hidden" name="prodid" value="<?php echo $id ?>" /><input type="hidden" name="pgNo" value="<?=$_REQUEST['pgNo']?>" />');
           $(this).closest("#productForm").submit();
        }
        else{
            return false;
        }
    });
})

function validateForm(){
	
	if($("#title1").val()==""){
		$(".errorDiv").show().fadeOut(4000);
		$('#errormessage').text("Please enter title1");
		$("#title1").focus();
		return false;
	}	
	/*
	var image_name = '<?php echo  $TypeArray['image'] ?>';
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
	var image_name1 = '<?php echo  $TypeArray['image1'] ?>';
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
	}*/
	
	return true;
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

</script>

<style>
.img-wrap2 {
    position: relative;
    display: inline-block;
    border: 1px red solid;
    font-size: 0;
}
.img-wrap2 .close2 {
    position: absolute;
    top: 2px;
    right: 2px;
    z-index: 100;
    background-color: #FFF;
    padding: 5px 2px 2px;
    color: #000;
    font-weight: bold;
    cursor: pointer;
    opacity: .2;
    text-align: center;
    font-size: 22px;
    line-height: 10px;
    border-radius: 50%;
}
.img-wrap2:hover .close2 {
    opacity: 1;
}
</style>
