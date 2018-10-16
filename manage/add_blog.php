<!-- Content Wrapper. Contains page content -->
<?php
require_once("left.php");

#==== Object Initialisations

$POST		= $objTypes->validateUserInput($_POST);
$blog_id 		= isset($POST['id']) ? intval($POST['id']) : intval($_REQUEST['id']) ;
$mode 		= ($id<>'0') ? 'Edit' : 'Add';
$params     = array(":blog_id" => $blog_id);
$TypeArray	= $objTypes->fetchRow("SELECT * FROM tbl_blog WHERE blog_id = :blog_id", $params);

?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> <?=$mode?> Blog <small></small> </h1>
    <ol class="breadcrumb">
      <li><a href="list_blog.php"><i class="fa  fa-navicon"></i> List</a></li>
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
          <form role="form" id="productForm"  method="post" action="act_blog.php" onsubmit="return validateForm();" enctype="multipart/form-data">
          <input type="hidden" name="id" id="id" value="<?=$TypeArray['blog_id']?>"  />
           <input type="hidden" name="pgNo" id="pgNo" value="<?=$_REQUEST['pgNo']?>"  />
		    <!-- <input type="hidden" name="category_type" id="category_type" value="bus"  />-->
            <div class="box-body">
			
					 
			  
			<div class="form-group">
                <label for="exampleInputEmail1">Title<?=MANDATORY?></label>
                <input type="text" class="form-control " id="title" name="title" value="<?=stripslashes($TypeArray['blog_title'])?>" placeholder="Title" style="width:40%;">
              </div>
			  
			   <div class="form-group">
                <label for="exampleInputEmail1">Author</label>
                <select class="form-control" name="author_id" id="author_id" style="width: 40%" required="required">
                    <option value="">Select Author</option>
                    <?php
                    $params     = array(":is_active" => '1', ":is_delete" => '1');
                    $AuthorArray	= $objTypes->fetchAll("SELECT blog_author_name as title,blog_author_id as id FROM tbl_blog_author WHERE is_active = :is_active AND is_delete = :is_delete", $params);
                    if(sizeof($AuthorArray) > 0){
                        foreach($AuthorArray as $author){  
							if($author['id'] == $TypeArray['blog_author_name']){
                                $selected = 'selected';
                            }
                            else{
                                $selected = '';
                            }						
                            ?>
                            <option value="<?php echo $author['id'] ?>" <?=$selected?>><?php echo $author['title']; ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
              </div>
	
			<div class="form-group">
                <label for="exampleInputEmail1">Tag</label>
                <input type="text" class="form-control " id="tag" name="tag" value="<?=stripslashes($TypeArray['blog_tag'])?>" placeholder="Tag" style="width:40%;">
              </div>
			  
             
              <div class="form-group">
                <label for="exampleInputEmail1">Short Description</label>
                <textarea class="form-control" placeholder="Short Description..." name="short_description" id="short_description" rows="3" style="width:40%;"><?=($TypeArray['blog_short_desc'])?></textarea>
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Description</label>
                <textarea class="form-control" id="editor1" name="description"  rows="10" cols="80" placeholder="Description..." ><?=stripslashes($TypeArray['blog_desc'])?></textarea>
              </div>
	
             			  
			   <div class="form-group">
                  <label for="exampleInputEmail1">Image</label>
                  <input type="file" class="form-control " id="image" name="image" value="" placeholder="Blog Image" style="width:40%;"  multiple="multiple">
				  <div class="alert alert-danger alert-dismissible" style="width:40%;margin-top:10px;">[Note:- Extension : JPG, JPEG, BMP, GIF, PNG <br />MAX File Upload Size : 3MB<br /></div>
                  <?php if($TypeArray['blog_image']){ ?>
                <a href="#"><img src="../uploads/blog/<?=stripslashes($TypeArray['blog_image'])?>"  onerror="this.style.display='none'" height="80" width="100" onclick='window.open("../uploads/blog/<?=stripslashes($TypeArray['blog_image'])?>","","width=600,height=600,scrollbars=Yes,resizable=yes")' /></a>
				<?php } ?>
              </div>
			   <div class="form-group">
					<label for="exampleInputEmail1">Home Blog</label><br/>
					<?php
					/*if($TypeArray['home_blog']){
						$checked= ($TypeArray['home_blog']==1) ? 'checked="checked"' : '';
					} echo $checked; */
					?>
					<input type="radio" name="home_blog" id="home_blog" value="1" <?php echo ($TypeArray['home_blog']==1) ? 'checked="checked"' : '';?> >	Yes
					<input type="radio" name="home_blog" id="home_blog" value="0" <?php echo ($TypeArray['home_blog']==0) ? 'checked="checked"' : '';?> > 	No
					</div>
			  
						
              <div class="form-group">
                <label for="exampleInputEmail1">Meta Title</label>
                <input type="text" class="form-control " id="meta_title" name="meta_title" value="<?=stripslashes($TypeArray['prod_seo_title'])?>" placeholder="Meta Title" style="width:40%;">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Meta Keywords</label>
                <input type="text" class="form-control " id="meta_keywords" name="meta_keywords" value="<?=stripslashes($TypeArray['prod_seo_keyword'])?>" placeholder="Meta Keywords" style="width:40%;">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Meta Description</label>
                <textarea class="form-control" rows="3" name="meta_description" id="meta_description" placeholder="Meta Description ..." style="width:40%;"><?=stripslashes($TypeArray['prod_seo_desc'])?></textarea>
              </div>
			   
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <button type="submit" class="btn btn-primary" value="SAVE" name="SAVE" id="SAVE">Submit</button>
              <a href="list_blog.php?&pgNo=<?php echo intval(base64_decode($_REQUEST['pgNo'])); ?>" class="btn btn-danger" >Back</a>
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
           	window.location.href = '<?=base_url?>act_blog.php?id='+id+'&param=rimg&prodid=<?php echo $id ?>&pgNo=<?=$_REQUEST['pgNo']?>';
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
function validateForm(){
	if($("input#title").val()==""){
		$(".errorDiv").show().fadeOut(4000);
		$('#errormessage').text("Title is Mandatory");
		$("input#title").focus();
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
</script>
<script>
  $(function () {	  
	//config.enterMode = CKEDITOR.ENTER_BR;
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('editor1');
	CKEDITOR.config.autoParagraph = false;

	
    //bootstrap WYSIHTML5 - text editor
    $(".textarea").wysihtml5();
	//config.enterMode = CKEDITOR.ENTER_DIV;
  });
</script>