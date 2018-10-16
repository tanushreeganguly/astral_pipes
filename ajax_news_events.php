<?php 
include_once('config/config.php');
$offset 			= 	is_numeric($_POST['offset']) ? $_POST['offset'] : die();
$postnumbers		= 	is_numeric($_POST['number']) ? $_POST['number'] : die();

$sql = "select * from  tbl_event where is_active=1 and is_delete=1  LIMIT ".$postnumbers." OFFSET ".$offset; 
$data = $objTypes->fetchAll($sql);
if(is_array($data)) { ?>
	<?php foreach($data as $val){ ?>
	<li>
		<div class="eventmainimg"><img src="<?=base_url?>uploads/event_images/<?php echo $val['image'];?>" alt="<?=$val['title']?>"></div>
			<div class="eventinfosectionH">
			<div class="event-Title"><?=stripslashes($val['title'])?></div>
			  <div class="dateH"><?php echo date("d", strtotime($val['from_date']));?>-<?php echo date("d M Y", strtotime($val['to_date']));?>
			  </div>
			  <div class="eventlocMap">
				<img src="<?=base_url?>assets/images/event-map-locaction.png" alt="locationMap">
			  </div>
			  <div class="eventventueH">VENUE</div>    
				<div class="locationeventDetails">
					<p><?=stripslashes($val['address'])?></p>
				</div>
				<div class="parainfolast">
				  <p><?=stripslashes($val['short_description'])?></p>
				</div>
			</div> 
	</li>
	<?php } ?>
<?php } ?>