<!-- Content Wrapper. Contains page content -->
<?php
require_once("left.php");

#==== Object Initialisations
$POST		= $objTypes->validateUserInput($_POST);
$id 		= isset($POST['id']) ? intval($POST['id']) : intval($_REQUEST['id']) ;
$mode 		= ($id<>'0') ? 'Edit' : 'Add';
$params     = array(":id" => $id);
$res_arr	= $objTypes->fetchRow("SELECT * FROM tbl_micro_accessories_details WHERE id = :id", $params);
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> <?=$mode?> Accessories <small></small> </h1>
    <ol class="breadcrumb">
      <li><a href="list_micro_accessories_details.php"><i class="fa  fa-navicon"></i> Accessories List</a></li>
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
          <form role="form" method="post" action="act_micro_accessories_details.php" onsubmit="return validateForm();" enctype="multipart/form-data">
          <input type="hidden" name="id" id="id" value="<?=$res_arr['id']?>"  />
           <input type="hidden" name="pgNo" id="pgNo" value="<?=$_REQUEST['pgNo']?>"  />
            <div class="box-body">
			 <div class="form-group">
			  <label for="exampleInputEmail1">Brand<?=MANDATORY?></label>
			  <select class="form-control" name="brand_id" id="brand_id" style="width: 40%" required>
				  <option value="">Select Brand</option>
				  <?php
                      $prod_arr	= $objTypes->fetchAll("SELECT title, id FROM tbl_micro_brand WHERE is_delete='1' AND is_active='1' ");
						if(sizeof($prod_arr) > 0){
							foreach($prod_arr as $prod_v){
								if($brand_id) {
									if($prod_v['id'] == $brand_id){
									$selected1 = 'selected';
									}
									else{
										$selected1 = '';
									}
								}else{
								if($prod_v['id'] == $res_arr['brand_id']){
									$selected1 = 'selected';
								}
								else{
									$selected1 = '';
								}
								}
								?>
								<option value="<?php echo $prod_v['id'] ?>" <?=$selected1?>><?php echo stripslashes($prod_v['title']); ?></option>
								<?php
							}
						}
						?>
			  </select>
             </div>
              
			   <div class="form-group">
			  <label for="exampleInputEmail1">Product<?=MANDATORY?></label>
			  <select class="form-control" name="product_id" id="product_id" style="width: 40%" required>
				  <option value="">Select Product</option>
				  <?php
                      $prod_arr	= $objTypes->fetchAll("SELECT title, id FROM tbl_micro_product WHERE is_delete='1' AND is_active='1' ");
						if(sizeof($prod_arr) > 0){
							foreach($prod_arr as $prod_v){
								if($brand_id) {
									if($prod_v['id'] == $brand_id){
									$selected1 = 'selected';
									}
									else{
										$selected1 = '';
									}
								}else{
								if($prod_v['id'] == $res_arr['product_id']){
									$selected1 = 'selected';
								}
								else{
									$selected1 = '';
								}
								}
								?>
								<option value="<?php echo $prod_v['id'] ?>" <?=$selected1?>><?php echo stripslashes($prod_v['title']); ?></option>
								<?php
							}
						}
						?>
			  </select>
             </div>
             <div class="form-group" id="product_type_div">
                <label for="exampleInputEmail1">Accessories</label>
                <select class="form-control" name="accessories_id" id="accessories_id_data" style="width: 40%">
                    <option value="">Select Accessories</option>
					<?php
                    $params     = array(":product_id" => $res_arr['product_id'] ,":is_active" => '1', ":is_delete" => '1');
                    $ProdArray	= $objTypes->fetchAll("SELECT title, id FROM tbl_micro_accessories WHERE  is_active = :is_active AND is_delete = :is_delete and product_id = :product_id ", $params);
                    if(sizeof($ProdArray) > 0){
                        foreach($ProdArray as $prod_v){
                            if($prod_v['id'] == $res_arr['accessories_id']){
                                $selected = 'selected';
                            }
                            else{
                                $selected = '';
                            }
                            ?>
                            <option value="<?php echo $prod_v['id'] ?>" <?=$selected?>><?php echo $prod_v['title']; ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
              </div>			  
			  <div class="form-group">
                <label for="exampleInputEmail1">Title<?=MANDATORY?></label>
                <input type="text" class="form-control " id="title" name="title" value="<?=stripslashes($res_arr['title'])?>" placeholder="Title" style="width:40%;">
              </div>
			  
			   <div class="form-group">
                <label for="exampleInputEmail1">Description</label>
                <textarea class="form-control" id="editor1" name="description"  rows="10" cols="80" placeholder="Description..." ><?=stripslashes($res_arr['description'])?></textarea>
               </div>
			  
			    <div class="form-group">
				<label for="exampleInputEmail1"> Image</label>
					<input type="file" class="form-control " id="image" name="image" value="" placeholder="  Image" style="width:40%;" onchange="return Checkfile()">
					<div class="alert alert-danger alert-dismissible" style="width:40%;margin-top:10px;">[Note:- File Size : 1920 x 695  , MAX File Upload Size : 3MB]</div>
					<?php if($res_arr['image']){ ?>
					<a href="#" id='existing_image'><img src="../uploads/micro_accessories/<?=stripslashes($res_arr['image'])?>"  onerror="this.style.display='none'" width="100" onclick='window.open("../uploads/micro_accessories/<?=stripslashes($res_arr['image'])?>","","width=600,height=600,scrollbars=Yes,resizable=yes")' /></a>
						<?php } ?>
				</div>
				
              
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <button type="submit" class="btn btn-primary" value="SAVE" name="SAVE" id="SAVE">Submit</button>
              <a href="list_micro_accessories_details.php?&pgNo=<?php echo intval(base64_decode($_REQUEST['pgNo'])); ?>" class="btn btn-danger" >Back</a>
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
		$('#errormessage').text("Title is Mandatory");
		$("input#title").focus();
		return false;
	}
	return true;
}
		$(document).on('change', '#product_id', function() {
			var product_id=$("#product_id").val(); console.log(product_id);
			//var prod_type_id=$(this).val();
				if(product_id){
					$.ajax({
						type: 'POST',
						url: '<?=base_url?>ajax_get_accessories.php',
						data:  'product_id='+product_id,		
						success:function(response){			
						console.log(response);		$("#accessories_id_data").html('');		
							$("#accessories_id_data").html(response);										
						}
					});
				}
		});
</script>
<script>
  $(function () {
	CKEDITOR.config.allowedContent = true;
    CKEDITOR.replace('editor1', {
        extraPlugins: 'imageuploader'
    });
    $(".textarea").wysihtml5();
  });
</script>
