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
						<th>Country</th>
						<th>State</th>
						<th>Location</th>						
						<th>Mobile Number</th>						
						<th>Email</th>						
						<th>Inquiry For</th>
						<th>Inquiry</th>
						<th>Date</th>						
					</tr>
				</thead>
				";
	$i=1;
	foreach($select  as $rows)
	{			
			$data .= "<tr>
						
						<td>".$rows['name']."</td>
						<td>".$rows['country']."</td>";
						
							$data .= "<td>".$rows['state']."</td>
							          <td>".$rows['location']."</td>";
						
						$data .= "						
						<td>".$rows['mobile']."</td>						
						<td>".$rows['email']."</td>										
						<td>".$rows['enquiry_type']."</td>
						<td>".$rows['message']."</td>
						<td>".$rows['insert_date']."</td>";						
					$data .= "</tr>";
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

	header("Content-Disposition: attachment; filename=Enquiry_Report_".$currentdate.".xls");
	header("Cache-Control: public");
	header("Content-length: ".strlen($data));
	header("Pragma: no-cache");
	header("Expires: 0");
	print $data;
}else{
	echo 'No Records!';
	header("location:list_enquiry_records.php");
}
?>