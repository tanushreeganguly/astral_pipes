<?php 
include_once('config/config.php');
$page			=	$objTypes->fetchRow('select meta_title,meta_description,meta_keywords from tbl_pages where id=7');
$total_records	=	$objTypes->fetchall('select * from tbl_pressrelease where is_active=1 and is_delete=1 order by id desc');
$total	=	count($total_records);  
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">
  <title><?=stripslashes($page['meta_title']);?></title>
  <meta name="description" content="<?=stripslashes($page['meta_description']);?>" />
  <meta name="keywords" content="<?=stripslashes($page['meta_keywords']);?>" />  
  <link href="<?=base_url?>assets/images/favicon.ico" rel="shortcut icon" type="" />
  <link href="<?=base_url?>assets/css/main.css" rel="stylesheet" type="text/css">
     <?php include_once('include/googlecode.php'); ?>
</head>
<body>
      <?php include_once('include/othercode.php'); ?>
    <div id="wrapper">
     <?php include_once('include/header.php'); ?>
      <section id="breadcrumbs">
        <div class="container">
          <a href="<?=base_url?>">Home</a> Press Release
      </div>
    </section>
    <section id="siteInner">
      <div class="container">
        <div class="sect_title inner_title">
          <h1>
            <span>Press Release</span>
          </h1>
        <div class="tl_bg">Press Release</div>
        </div>
 </div>
 </section>
<section id="press-release">
  <div class="container">
     <div class="pro_grid_holder grid" id="ajax_press_release">
         <div class="grid-sizer"></div>
		 <?php  
			$press_sql = "select * from tbl_pressrelease where is_active=1 and  is_delete = 1 order by id desc limit 0,6 ";
			$press_row = $objTypes->fetchAll($press_sql); 			
			$i = 1; 
			if(isset($press_row) && sizeof($press_row) >  0 ) {
				foreach($press_row as $press_val){
					if($i==1){
						$class = "bgone";
					}else if($i==2){
						$class = "bgTwo";
					}else if($i==3){
						$class = "bgthree";
					}else if($i==4){
						$class = "bgfour";
					}else if($i==5){
						$class = "bgfive";
					}else if($i==6){
						$class = "bgsix";
					}else{
						$i=1;
						$class = "bgone";
					}
			?>					 
                <div class="grid-item grid_deliver">
                  <div class="grid_inner <?=$class?>">                    
                    <div class="pro_det">
					 <input type="hidden" name="count" id="count" value="<?php echo count($press_row);?>">
						<?php if($press_val['image']) { ?>
						<h2><img src="<?=base_url?>uploads/press_images/<?=$press_val['image']?>" alt="<?=stripslashes($press_val['title'])?>" /></h2>
						<?php } ?>
                      <div class="pressheadingmain"><?=stripslashes($press_val['title'])?></div>
                      <div class="datesectionH"><?=date('d M Y',strtotime($press_val['release_date']))?></div>
                       <p><?=stripslashes($press_val['description'])?></p>
					   <?php if($press_val['link'] !='' ) { ?>
						<a target="_blank" rel="nofollow" href="<?=$press_val['link'];?>">Read More</a>
					   <?php } ?>
                    </div>
                  </div>
                </div>
			<?php $i++; }  } ?>							 
  </div></div>
</section>
		<?php if( $total > count($press_row)){ #for load more ?>
			<div class="centerbuttonCom">
			<div class="loadmorebuttonad"><a href="javascript:;" class="commanBtn">Load More</a></div></div>
		<?php }?>
 <div class="clear"></div>
   <?php include_once 'include/footer.php'; ?>
  </div>
  <!--JS Files-->
  <?php include_once('include/js.php');?>
   <script type="text/javascript" src="<?=base_url?>assets/js/imagesloaded.pkgd.min.js"></script>
   <script type="text/javascript" src="<?=base_url?>assets/js/masonry.pkgd.min.js"></script>
   <script type="text/javascript" src="<?=base_url?>js/custom_pagination.js"></script>
   <script type="text/javascript" src="<?=base_url?>js/pagination.js"></script>
   <script>		
	var  base_url ='<?=base_url?>ajax_press_release.php';
      $(document).ready(function(){        
        var gridDeliver = $('.grid_deliver');
        var gridExperties = $('.grid_experties');
        var gridStepahed = $('.grid_step_ahed');
        var proTabArr = $('.proTab').find('span');
        $(proTabArr).each(function(){
          $(this).bind('click', function(){
            var currTab = 'grid_'+$(this).attr('id');
            $('.grid-item').css({'display':'none'});
            $('.'+currTab).css({'display':'block'});
            msnry.layout();
            proTabArr.removeClass('activePro');
            $(this).addClass('activePro');
          });
        });
        $('.grid_deliver').css({'display':'block'});
        var container = document.querySelector('.pro_grid_holder');
        var msnry = new Masonry( container, {
          columnWidth: '.grid-sizer'
        });
        setTimeout(function(){
          msnry.layout();
        },10);
		$('.commanBtn').on('click',function(){
			var total='<?php echo $total;?>';
			var getUrl = window.location;
			var baseUrl = getUrl .protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
			var total_count=$('#count').val();
			var var2=6;
				$.ajax({
					type: "POST",
					data:{'last_data':total_count},
					url: baseUrl+'/ajax_press_release.php',
					success:function(response){
						$("#ajax_press_release").append(response);
						console.log(response);
						var sum = Number(total_count) + Number(var2);						
						$('#count').val(sum);
						if(total<sum){
							$(".commanBtn").hide();
						}
					}
					});
			});
		/*$('#ajax_press_release').scrollPagination({			
				nop     : 9, // The number of posts per scroll to be loaded
				offset  : 0, // Initial offset, begins at 0 in this case
				error   : '<a>More data Coming Soon...<div class="color-1-bg-light color-bg"></div></a>', // When the user reaches the end this is the message that is
					// displayed. You can change this if you want.
				delay   : 600, // When you scroll down the posts will load after a delayed amount of time.
							   // This is mainly for usability concerns. You can alter this as you see fit
				scroll  : true // The main bit, if set to false posts will not load as the user scrolls. 
							   // but will still load if the user clicks.		
			});*/
      });
    </script>
</body>
</html>