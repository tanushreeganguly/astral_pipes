<?php
require_once("../config/config.php");
require_once("verify_logins.php");

date_default_timezone_set('Asia/Calcutta'); 


$select     = $objTypes->select("tbl_enquiry", "*", "", "", "id DESC");

if($select && count($select) > 0){
	$data 	= "<table border='1'>
				<thead>
					<tr>
						<th>Name</th>
						<th>Address</th>
						<th>Country</th>
						<th>State</th>
						<th>City</th>
						<th>Zip Code</th>
						<th>Phone Number</th>
						<th>Mobile Number</th>
						<th>Email</th>
						<th>Product Name</th>
						
						<th>Type</th>
						<th>message</th>
						<th>Date</th>
						
					</tr>
				</thead>
				";
	$i=1;
	foreach($select  as $rows)
	{
			$where[':spare_service_id'] =  $rows['id'];
			$where_state[':state_id']   =  $rows['state'];
			
			//$select_images     = $objTypes->select("tbl_enquiry_images", "*", "spare_service_id=:spare_service_id", $where, "id DESC");
			
			//$select_state    = $objTypes->select("tbl_state_master", "*", "state_id=:state_id", $where_state, "state_id DESC");
			
			$data .= "<tr>
						
						<td>".$rows['name']."</td>
						<td>".$rows['address']."</td>
						<td>".$rows['country']."</td>";
						
						$data .= "<td>".$rows['state']."</td>";
						
						$data .= "<td>".$rows['city']."</td>
						
						<td>".$rows['zip']."</td>
						<td>".$rows['phone']."</td>
						<td>".$rows['mobile']."</td>
						
						<td>".$rows['email']."</td>
						<td>".$rows['product']."</td>
						<td>".$rows['contacttype']."</td>
						<td>".$rows['message']."</td>
						<td>".$rows['insert_date']."</td><td>";
						
					$data .= "</td></tr>";
		
		
	}
	
	$data 		.='</tbody></table>';	
	$html 		 = trim($data);
	$currentdate = date("Y-m-d H:i:s");

	//print $data;exit;
	header("Expires: 0");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Content-Type: application/vnd.ms-excel; charset=utf-8");
	header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
	header("Content-Disposition: attachment;filename=\"$filename.xlsx\"");
	header("Cache-Control: max-age=0");

	header("Content-Disposition: attachment; filename=Contact_Report_".$currentdate.".xls");
	header("Cache-Control: public");
	header("Content-length: ".strlen($data));
	header("Pragma: no-cache");
	header("Expires: 0");
	print $data;
}else{
	echo 'No Records!';
	header("location:list_contact_records.php");
}
?>