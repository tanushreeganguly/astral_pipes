<?php require_once("left.php"); 

#==== Validations For Security.
$POST		= $objTypes->validateUserInput($_REQUEST);
$jobcode	=  ($POST['jobcode']<>'') ? $POST['jobcode'] : '' ;
$title	    =  ($POST['title']<>'') ? $POST['title'] : '' ;
$department	=  ($POST['department']<>'') ? $POST['department'] : '' ;
$location	=  ($POST['location']<>'') ? $POST['location'] : '' ;
$params     = array();
$condition  = "a.is_delete=1 ";
if($jobcode){
	$condition  .= " AND c.job_code LIKE '%".$jobcode."%'";
}
if($title){
	$condition  .= " AND a.name LIKE '%".$title."%'";
}
if($department){
	$condition  .= " AND c.department LIKE '%".$department."%'";
}
if($location){
	$condition  .= " AND c.location LIKE '%".$location."%'";
}
$EventArr	= $objTypes->fetchAll("SELECT a.*,a.id as user_id ,a.name,c.department,c.job_code FROM `tbl_career_apply` a JOIN tbl_careers c on a.job_code=c.job_code WHERE ".$condition." ORDER BY a.id DESC");

#==== PAGINATION
$pgNo		= ($POST['pgNo']<>'') ? $POST['pgNo'] : intval($_REQUEST['pgNo']) ;
$url		= "<td align=center valign=middle><a href=javascript:getPage({pgNo})>{pgTxt}</a></td>";
$totalCount = sizeof($EventArr);
$total		= ($totalCount > ADMIN_COUNT ) ? ADMIN_COUNT : $totalCount;
$totalPages	= ceil($totalCount/ADMIN_COUNT);
$pgNo		= ($pgNo > $totalPages)? $totalPages : $pgNo;
$pgNo		= ($pgNo < 1) ? 1 : $pgNo;
$from		= $pgNo * ADMIN_COUNT - ADMIN_COUNT;
$to 		= $from + ADMIN_COUNT;
$limit		= "$from,".ADMIN_COUNT;
$order		= 'a.name ASC';
$CareerArr	= $objTypes->fetchAll("SELECT a.*,a.id as user_id ,a.name,c.id,c.location,c.department,c.job_code FROM `tbl_career_apply` a JOIN tbl_careers c on a.job_id=c.id WHERE ".$condition." ORDER BY a.id DESC LIMIT ". $limit);
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> List Applied Users<small></small> </h1>
    <ol class="breadcrumb">
     <li><a href="export_career_application.php?jobcode=<?=$jobcode?>&title=<?=$title?>&department=<?=$department?>"><i class="fa  fa-file-excel-o"></i> <strong style="color:#FF0000;font-size:16px;">Report</strong> </a></li>
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
             <input type="hidden" id="title" name="title"  value="<?php echo $title; ?>"/>
              <input type="hidden" id="cat_type" name="cat_type"  value="<?php echo $cat_type; ?>"/>
            <table id="example2" class="table table-bordered table-hover" >
              <thead>
			  <tr>
			  <td colspan="2">
                 <div class="input-group">
                  <input type="text" name="jobcode" placeholder="Job Code..." class="form-control" value="<?=$jobcode?>">
                </div>
                </td> 
                <td colspan="1">
                 <div class="input-group">
                  <input type="text" name="title" placeholder="Title..." class="form-control" value="<?=$title?>">
                </div>
                </td>  
				<td colspan="1">
                 <div class="input-group">
                  <input type="text" name="location" placeholder="Location..." class="form-control" value="<?=$location?>">
                </div>
                </td> 
				<td >
                 <div class="input-group">
					<input type="text" name="department" placeholder="Department..." class="form-control" value="<?=$department?>">
				  <span class="input-group-btn">
					<button type="submit" class="btn btn-success btn-flat">Search</button>
				  </span>
                </div>
                </td>	
             </tr>  
              <tr>
                  <th width="1%"><input type="checkbox" id="selectall"/></th>
                  <th width="8%">Job code</th>
                  <th width="25%">User details</th>
                  <th width="25%">Job Details</th>   
                  <th width="25%">Other Information</th>    
                  <th width="10%">Action</th>
               </tr>
              </thead>
              <tbody>
              <?php
			  if($CareerArr){
			  	foreach($CareerArr as $key=>$val){
					$user_id = $val['user_id'];
					$user_sql = "select * from tbl_job_user where user_id=".$user_id;
					$user_arr	= $objTypes->fetchRow($user_sql);						
					if($page=='1'){$sino = $key+1;}else{$sino = ($pgNo-1)*ADMIN_COUNT+($key+1);}
			  ?>
                <tr>
                  <td><input type="checkbox" class="case" id="DelCheckBox[]" name="DelCheckBox[]" value="<?=$val['id']?>"/></td>
                  <td><?=$val['job_code'];?></td>
                  <td><?='Name: '.stripslashes($val['name']) .'<br/>Email:' .stripslashes($val['email']) .'<br/>Phone : '.stripslashes($val['phone']);?></td>
                  <td>
				  <?php 
					$job_sql = "select * from  tbl_job_detail where user_id=".$user_id;
					$job_arr	= $objTypes->fetchRow($job_sql);	
					echo 'Employee status: '. $job_arr['employee_status'];
					echo '<br/>Current employer: '. $job_arr['current_employer'];
					echo '<br/>Industry type: '. $job_arr['industry_type'];					
					echo '<br/>Designation: '. $job_arr['designation'];
					echo '<br/>CTC : '. $job_arr['ctc'];
					echo '<br/>Gross : '. $job_arr['gross'];
				  ?>
				  </td>  
				   <td>
				  <?php 					
					echo 'Resume title: '. $user_arr['resume_title'];					
					echo '<br/>Employment type: '. $user_arr['employment_type'];					
					echo '<br/>Willing relocate: '. $user_arr['willing_relocate'];	
					echo '<br/>State : '. $user_arr['option_state'] . ' City:'.$user_arr['option_city'];
					echo '<br/>Notice Period: '. $user_arr['notice_period'];
				  ?>
				  </td>  
                  <td><?php if($user_arr['resume']!='') { ?><a href="../uploads/resume/<?=stripslashes($user_arr['resume'])?>" download><i class="fa   fa-cloud-download"></i></a>&nbsp;&nbsp;&nbsp;
				  </a><?php } ?>&nbsp;&nbsp;&nbsp;<a href="act_career_applications.php?id=<?=$val['user_id']?>&action=delete" onclick="return window.confirm('Do you want to delete this record?')"><i class="fa  fa-trash"></i></a> </td>
                </tr> 
                <?php } }  else { print "<tr><td colspan='9'> NO Records Found !!!</td></tr>";} ?>
              </tbody>
              <tr><td colspan="4">
              <div class="row"><div class="col-sm-12">
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
				document.frmListing.action='act_career_applications.php?action=deleteall';
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
				document.frmListing.action='act_career_applications.php';
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
				document.frmListing.action='act_career_applications.php';
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