<!-- Content Wrapper. Contains page content -->
<?php require_once("left.php"); 

//print_r($_SESSION['PHPSESSID']); 
//setcookie("PHPSESSID","",time()-1,"/"); // delete session cookie  
//print_r($_COOKIE);
/*$a = session_id();
if(empty($a)) session_start();
$_COOKIE["PHPSESSID"] = md5(rand(time()));
echo "SID: ".SID."<br>session_id(): ".session_id()."<br>COOKIE: ".$_COOKIE["PHPSESSID"];*/
?>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1> Dashboard  <small></small> </h1>
    <ol class="breadcrumb">
      <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Dashbord</a></li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
   <div class="row">
      <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title"></h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <div style="margin-top:15%;text-align:center;height:200px;"><h1>Welcome To Admin Panel</h1></div>
          
        </div>
        <!-- /.box -->
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<!-- Main Footer -->
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
</body></html>