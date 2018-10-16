<?php 
include_once('config/config.php');
$POST		= $objTypes->validateUserInput($_POST);

$last_data=$POST['last_data'];
$sql = "select * from  tbl_pressrelease where is_active=1 and is_delete=1 order by id desc limit $last_data,6" ;
$img_html="";

//$sql = "select * from  tbl_pressrelease where is_active=1 and is_delete=1  LIMIT ".$postnumbers." OFFSET ".$offset; 
$press_row = $objTypes->fetchAll($sql); 
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
 <script>		
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
</script>