<?php
#=== Includes
require_once("../config/config.php");
require_once("verify_logins.php");
#==== Validations For Security
$POST		= $objTypes->validateUserInput($_POST);
$product_id 		= isset($POST['product_id']) ? intval($POST['product_id']) : intval($_REQUEST['product_id']) ;

$params     = array(":product_id" => $product_id,":is_active" => 1,":is_delete" => 1);
$TypeArray	= $objTypes->fetchAll("SELECT * FROM  tbl_micro_combi_article WHERE product_id = :product_id and is_active = :is_active and is_delete = :is_delete", $params);
$html = ''; 
if(sizeof($TypeArray) > 0){
	$html .='
	<option value="">Select Combi Article</option>';			
	foreach($TypeArray as $prod_v){   
		$html .='<option value="'.$prod_v['id'].'" >'.$prod_v['title'].'</option>';
   }	
}				
echo $html; 