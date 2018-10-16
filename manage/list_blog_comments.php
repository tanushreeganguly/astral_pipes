<?php
require_once("left.php"); 

#==== Validations For Security
$POST		= $objTypes->validateUserInput($_REQUEST); 
$comments	    =  ($POST['comments']<>'') ? $POST['comments'] : '' ;

$condition	= " is_delete='1' " ;
$where      = array(":is_delete" => 1);

if($comments){
	$where[':blog_comments'] = '%'.$comments.'%';
}

$params    = array(":is_delete" => 1);
if($comments){
    $select = $objTypes->select("tbl_blog_comments", "*", "is_delete = :is_delete AND blog_comments LIKE :blog_comments", $where, "id DESC");
}else {
	$select = $objTypes->select("tbl_blog_comments", "*", "is_delete = :is_delete", $where, "id DESC");
}

#==== PAGINATION
$pgNo		= ($POST['pgNo']<>'') ? $POST['pgNo'] : intval($_REQUEST['pgNo']) ;
$url		= "<td align=center valign=middle><a href=javascript:getPage({pgNo})>{pgTxt}</a></td>";
$totalCount = sizeof($select);
$total		= ($totalCount > ADMIN_COUNT ) ? ADMIN_COUNT : $totalCount;
$totalPages	= ceil($totalCount/ADMIN_COUNT);
$pgNo		= ($pgNo > $totalPages)? $totalPages : $pgNo;
$pgNo		= ($pgNo < 1) ? 1 : $pgNo;
$from		= $pgNo * ADMIN_COUNT - ADMIN_COUNT;
$to 		= $from + ADMIN_COUNT;

$limit		= "$from,".ADMIN_COUNT;
$order		= 'blog_comments ASC';
if($comments){
        $TypeArray = $objTypes->select("tbl_blog_comments", "*", "is_delete = :is_delete AND blog_comments LIKE :blog_comments", $where, "id DESC"); 
}else {
	$TypeArray = $objTypes->select("tbl_blog_comments", "*", "is_delete = :is_delete", $where, "id DESC", $limit);
}
?>
<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> List Blog Comments <small></small> </h1>
    <ol class="breadcrumb">
      <li></li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title"></h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <p>
            <div class="callout callout-danger errorDiv" <?php  $objSystemMsg->createStyle($sysmsg); ?>> <span id="errormessage"><?php echo $objSystemMsg->displayError($sysmsg); ?></span> </div>
            </p>
            <form id="frmListing" name="frmListing" action="<?=$_SERVER['PHP_SELF'];?>" method="post">
            <input type="hidden" name="action" id="action" value="">
            <input type="hidden" id="pgNo" name="pgNo"  value="<?php echo $pgNo; ?>"/>
            <table id="example2" class="table table-bordered table-hover" >
              <thead>
              <tr>
                <td colspan="3">
                 <div class="input-group">
                  <input type="text" name="comments" placeholder="Comments..." class="form-control" value="<?=$comments?>">
                      <span class="input-group-btn">
                        <button type="submit" class="btn btn-success btn-flat">Search</button>
                      </span>
                </div>
                </td>
             </tr>
                
                <tr>
                  <th width="1%"><input type="checkbox" id="selectall"/></th>
                  <th width="4%">#</th>
                  <th width="25%">Username - Email</th>
				  <th width="25%">Comments</th>   
				  <th width="25%">Admin Approval</th>
				  <!--th width="25%">User Approval</th> -->   
				  <!--th width="25%">Publish</th-->   				  
                  <th width="10%">Status</th>
                  <th width="10%">Action</th>
                </tr>
              </thead>
              <tbody>
              <?php
			  if($TypeArray){
				foreach($TypeArray as $key => $val){					
				if($page=='1'){$sino = $key+1;}else{$sino = ($pgNo-1)*ADMIN_COUNT+($key+1);}
			  ?>
                <tr>
                  <td><input type="checkbox" class="case" id="DelCheckBox[]" name="DelCheckBox[]" value="<?=$val['id']?>"/></td>
                  <td><?=$sino;?></td>
				  <td><?=stripslashes($val['user_name']) .' - '. stripslashes($val['user_email'])?></td>
                  <td><?=stripslashes($val['blog_comments'])?></td>
				  <td><a href="act_blog_comments.php?id=<?=$val['id']?>&admin_approved=<?=$val['is_admin_approved']?>&pgNo=<?=base64_encode($pgNo)?>"><?=($val['is_admin_approved'] == "1") ? "<span class='label label-success'>Aproved</span>":"<span class='label label-danger'>Not Approved</span>" ?></a></td>
				  <!--td><a href="act_blog_comments.php?id=<?=$val['id']?>&user_approved=<?=$val['is_user_approved']?>&pgNo=<?=base64_encode($pgNo)?>"><?=($val['is_user_approved'] == "1") ? "<span class='label label-success'>Aproved</span>":"<span class='label label-danger'>Not Approved</span>" ?></a></td-->
				  <!--td><a href="act_blog_comments.php?id=<?=$val['id']?>&publish=<?=$val['publish']?>&pgNo=<?=base64_encode($pgNo)?>"><?=($val['publish'] == "1") ? "<span class='label label-success'>Publish</span>":"<span class='label label-danger'>Unpublish</span>" ?></a></td-->
				  <td><a href="act_blog_comments.php?id=<?=$val['id']?>&status=<?=$val['is_active']?>&pgNo=<?=base64_encode($pgNo)?>">
                    <?=($val['is_active'] == "1") ? "<span class='label label-success'>Active</span>":"<span class='label label-danger'>Inactive</span>" ?>
                    </a> </td>
                  <td>
                  <a href="act_blog_comments.php?id=<?=$val['id']?>&pgNo=<?=base64_encode($pgNo)?>&action=delete" onclick="return window.confirm('Do you want to delete this record?')"><i class="fa  fa-trash"></i></a>
                  </td>
                </tr>
                <?php } }  else { print "<tr><td colspan='9'> NO Records Found !!!</td></tr>";} ?>
              </tbody>
              <tr><td colspan="4">
              <div class="row"><div class="col-sm-12">
              <a class="btn btn-success btn-xs" onclick="javascript:Active_CheckBox()">Active All &nbsp;&nbsp;<i class="fa fa-thumbs-up"></i></a>
              <a class="btn btn-warning btn-xs" onclick="javascript:Deactive_CheckBox()">Deactive All &nbsp;&nbsp;<i class="fa fa-thumbs-down"></i></a>
              <a class="btn btn-danger btn-xs" onclick="javascript:Delete_CheckBox()">Delete All &nbsp;&nbsp;<i class="fa fa-trash"></i></a>
              </div></div>
              </td>
              <td colspan="5">
                <table border="0" cellspacing="1" cellpadding="1" align="right">
                <tr class="sidelink">
                <?php if($totalPages > 1){ echo $objTypes->getPageLink($pgNo, $totalPages, $url, $count); } ?>
                </tr>
                </table>
              </td>
              </tr>
            </table>
           </form>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php require_once("footer.php"); ?>
</div>
<!-- ./wrapper -->
<!-- jQuery 2.1.4 -->
<script src="<?=base_url?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="<?=base_url?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<!-- DATA TABES SCRIPT -->
<script src="<?=base_url?>plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?=base_url?>plugins/datatables/dataTables.bootstrap.min.js" type="text/javascript"></script>
<!-- SlimScroll -->
<script src="<?=base_url?>/plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<!-- FastClick -->
<script src='<?=base_url?>plugins/fastclick/fastclick.min.js'></script>
<!-- AdminLTE App -->
<script src="<?=base_url?>dist/js/app.min.js" type="text/javascript"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?=base_url?>dist/js/demo.js" type="text/javascript"></script>
<!-- page script -->
<!--<script type="text/javascript">
  $(function () {
   // $("#example1").dataTable();
	$('#example2').dataTable({
	  "bPaginate": true,
	  "bLengthChange": false,
	  "bFilter": false,
	  "bSort": false,
	  "bInfo": true,
	  "bAutoWidth": false
	});
  });
</script>-->
<script type="text/javascript" language="javascript">
var sysmsg = "<?=$sysmsg?>";
if(sysmsg==0){
	$(".errorDiv").hide();
}else{
	$(".errorDiv").show().fadeOut(4000);
}
</script>
<script type="text/javascript" language="javascript">
function getPage(pgNo)
{
	//alert(pgNo);
	document.getElementById('pgNo').value = parseInt(pgNo);
	//document.getElementById('cat_type').value = cat_type;
	document.frmListing.submit();
	return false;
}
</script>
<script type="text/javascript">
$('#selectall').click(function() {
   if (this.checked) {
       $(':checkbox').each(function() {
           this.checked = true;
       });
   } else {
      $(':checkbox').each(function() {
           this.checked = false;
       });
   }
});
// multiple checkbox check and uncheck
$(function(){

    // add multiple select / deselect functionality
    $("#selectall").click(function () {
          $('.case').attr('checked', this.checked);
    });

    // if all checkbox are selected, check the selectall checkbox
    // and viceversa
    $(".case").click(function(){

        if($(".case").length == $(".case:checked").length) {
            $("#selectall").attr("checked", "checked");
        } else {
            $("#selectall").removeAttr("checked");
        }

    });
});
</script>
<script type="text/javascript">
// multiple checkbox check and uncheck for Delete all purpose
function Delete_CheckBox()
{
	var numberOfChecked = $('input:checkbox:checked').length;

	if(numberOfChecked>=1)
	{
		if(confirm("Are you sure  want to Delete Selected Record ?."))
		{
			$("#action").attr("value","deleteall");
			document.frmListing.action='act_blog_comments.php?action=deleteall';
			document.frmListing.submit();
		}
	}
	else
	{
		alert("Please select at least one record.");
		return false;
	}
}
// multiple checkbox check and uncheck for Active all purpose
function Active_CheckBox()
{
	var numberOfChecked = $('input:checkbox:checked').length;
	if(numberOfChecked>=1)
	{
		if(confirm("Are you sure  want to Activate Selected Record ?."))
		{
			$("#action").attr("value","activeall");
			document.frmListing.action='act_blog_comments.php';
			document.frmListing.submit();
		}
	}
	else
	{
		alert("Please select at least one record.");
		return false;
	}
}
// multiple checkbox check and uncheck for Deactive all purpose
function Deactive_CheckBox()
{
	var numberOfChecked = $('input:checkbox:checked').length;

	if(numberOfChecked>=1)
	{
		if(confirm("Are you sure  want to Deactivate Selected Record ?."))
		{
			$("#action").attr("value","deactiveall");
			document.frmListing.action='act_blog_comments.php';
			document.frmListing.submit();
		}
	}
	else
	{
		alert("Please select at least one record.");
		return false;
	}
}
</script>
</body></html>
