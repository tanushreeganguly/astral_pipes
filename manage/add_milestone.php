<!-- Content Wrapper. Contains page content -->
<?php
require_once("left.php");

#==== Object Initialisations
$POST		= $objTypes->validateUserInput($_POST);
$id 		= isset($POST['id']) ? intval($POST['id']) : intval($_REQUEST['id']) ;
$mode 		= ($id<>'0') ? 'Edit' : 'Add';
$params     = array(":id" => $id);
$TypeArray	= $objTypes->fetchRow("SELECT id, year, content,thumbnail1,image1, insert_date FROM tbl_milestone WHERE id = :id", $params);
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> <?=$mode?> Milestone <small></small> </h1>
    <ol class="breadcrumb">
      <li><a href="list_milestone.php"><i class="fa  fa-navicon"></i> Milestones List</a></li>
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
          <form role="form" method="post" action="act_milestone.php" onsubmit="return validateForm();" enctype="multipart/form-data">
          <input type="hidden" name="id" id="id" value="<?=$TypeArray['id']?>"  />
           <input type="hidden" name="pgNo" id="pgNo" value="<?=$_REQUEST['pgNo']?>"  />
            <div class="box-body">
              <div class="form-group">
                <label for="exampleInputEmail1">Year<?=MANDATORY?></label>
                <input type="text" class="form-control " id="title" name="title" value="<?=stripslashes($TypeArray['year'])?>" placeholder="Title" style="width:40%;">
              </div>
             
              <div class="form-group">
                <label for="exampleInputEmail1">Short Description<?=MANDATORY?></label>
                <textarea class="form-control" placeholder="Short Description..." name="short_description" id="short_description" rows="3" style="width:40%;"><?=stripslashes($TypeArray['content'])?></textarea>
              </div>
              <div class="form-group">
            <label for="exampleInputEmail1">Image</label>
            <input type="file" class="form-control " id="image1" name="image1" value="" placeholder=" Image1" style="width:40%;" onchange="return Checkfile1()">
            <div class="alert alert-danger alert-dismissible" style="width:40%;margin-top:10px;">[Note:- File Size : 200 x 200  , MAX File Upload Size : 3MB]</div>
            <?php if($TypeArray['image1']){ ?>
            <a href="#" id='existing_image1'><img src="../uploads/milestone_image/<?=stripslashes($TypeArray['image1'])?>"  onerror="this.style.display='none'" width="100" onclick='window.open("../uploads/milestone_image/<?=stripslashes($TypeArray['image1'])?>","","width=200,height=200,scrollbars=Yes,resizable=yes")' /></a>
            <?php } ?>
            
             <input type="hidden" name="store_image1" value="<?php echo $TypeArray['image1']; ?>">
          </div>
              
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <button type="submit" class="btn btn-primary" value="SAVE" name="SAVE" id="SAVE">Submit</button>
              <a href="list_milestone.php?&pgNo=<?php echo intval(base64_decode($_REQUEST['pgNo'])); ?>" class="btn btn-danger" >Back</a>
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
<script src="<?=base_url?>ckeditor/ckeditor.js"></script>
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
		$('#errormessage').text("Page Title is Mandatory");
		$("input#title").focus();
		return false;
	}
  if($("input#short_description").val()==""){
    $(".errorDiv").show().fadeOut(4000);
    $('#errormessage').text("Content is Mandatory");
    $("input#short_description").focus();
    return false;
  }
	return true;
}


</script>

