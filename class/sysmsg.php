<?php
class systemMsg
{
	function __construct(){}

	function displayError($msgCode)
	{
		$msgCode = (int)$msgCode;
		switch($msgCode){
			#server side validations
			case 1:
				$message = "You forgot to enter some Mandatory Fields";
				break;
			case 2:
				$message = "Password's Mismatch ,Try Again";
				break;
			case '3':
				$message = "An error occured in Insertion ,Try Again";
				break;
			case '4':
				$message = "An error occured in Updation ,Try Again";
				break;
			case '5':
				$message = "An error occured in Deletion ,Try Again";
				break;
			case '6':
				$message = "An error occured in Contacting Site Administrator ,Try Again";
				break;
			case '7':
				$message = "Failed to do the process,Try Again";
				break;
			case '8':
				$message = "Please select at least one record to Activate";
			case '9':
				$message = "Please select at least one record to Deactivate";
			case '10':
				$message = "Please select at least one record to delete";
				break;
			case '11':
				$message = "Sorry, uploaded file is invalid, allowed extensions are: (jpg, png, jpeg, bmp, gif)";
				break;
			case '12':
				$message = "Alias already exists with us. please use another alias";
				break;
			case '13':
				$message = "Record you have selected are already actived.";
				break;
			case '14':
				$message = "Record you have selected are already deactived.";
				break;
			case '15':
				$message = "Please upload banner with specified dimension.";
				break;
			case '16':
				$message = "Please upload image with specified size.";
				break;
			case '17':
				$message = "Please upload banner with specified size.";
				break;
			case '33':
				$message = "An error occured while saving you data,Try Again";
				break;
			case '34':
				$message = "Your email id is not subscribed";
				break;

			case '35':
				$message = "Sorry, uploaded file is invalid, allowed extensions are: (pdf)";
				break;	
				
				
			case 910:
				$message = "You have missed updating some important informations. It is important for others to search you.<br> So kindly please update it now.";
				break;
			case 900:
				$message = "Unable to send mail for your request, please try again";
				break;
			case 901:
				$message = "Unable to process your request. Please check the information you have given is correct.";
				break;
			case 902:
				$message = "Please update your basic information before going further.";
				break;
			#Custom Errors
			case 100:
				$message = "Invalid Login, Try Again";
				break;
			case 101:
				$message = "Select a unit and Committee";
				break;
			case 102:
				$message = "Security String Error";
				break;
			case 103:
				$message = "Public User Login Restricted";
				break;
			case 105:
				$message = "Processed Successfully";
				break;

			case 1000:
				$message = "Record Added Successfully";
				break;
			case 1001:
				$message = "Record Updated Successfully";
				break;
			case 1002:
				$message = "Record Deleted Successfully";
				break;
			case 1003:
				$message = "Record Added Successfully But Error Occured in file upload ";
				break;
			case 1004:
				$message = "Record Added Successfully But Error Occured while saving filename  ";
				break;
			case 1005:
				$message = "Thanks you for your comments,We will get back to you soon.";
				break;
			case 1006:
				$message = "Your password is changed successfully";
				break;
			case 1007:
				$message = "Your request is processed, Check your email for Password Reset";
				break;
			case 1008:
			     $message="Thanks for posting your story, and you can view when the administrator approved";
				 break;
			case 1009:
			     $message="Successfully send your invitation";
				 break;
			case 1010:
				 $message = "Your request is processed, Check your email for Email Reset";
				 break;
			case 1011:
				 $message = "Applied For Job Successfully";
				 break;
			case 1012:
				 $message = "Multiple Records Successfully Activated";
				 break;
			case 1013:
				 $message = "Multiple Records Successfully Deactivated";
				 break;
			case 1014:
				$message = "Multiple Records Deleted Successfully";
				 break;
			case 1015:
				$message = "Status Activated Successfully";
				break;
			case 1016:
				$message = "Status Deactivated Successfully";
				break;
			case 1017:
				$message = "Your email id is unsubscribed";
				break;
			case 1018:
				$message = "Image Successfully removed.";
				break;
			default:
				$message = "";
		}
		return $message;
	}
	function createStyle($msgCode){
		$msgCode = (int)$msgCode;
		if(($msgCode<>"")&&($msgCode >=1000)){
		echo "style='border:solid 1px #2AAF00;background-color:#E7FFDF;color:#2AAF00;display: block;'";
		}
		else if (($msgCode<>"")&&($msgCode <1000)){
		echo "style='border:solid 1px #FF0000;background-color:#FFCFCF;color:#FF0000;display: block;'";
		}
		else{
		echo "style='color:#FF0000;display: none;'"; //Just avaoid the shiver while removing error class
		}
	}

	function createSiteStyle($msgCode){
		$msgCode = (int)$msgCode;
		if(($msgCode<>"")&&($msgCode >=1000)){
			echo "style='border:solid 1px #2AAF00;background-color:#E7FFDF;color:#2AAF00;display: block;'";
		}
		else if (($msgCode<>"")&&($msgCode <1000)){
			echo "style='border:solid 1px #FF0000;background-color:#FFCFCF;color:#FF0000;display: block;'";
		}
		else{
			echo "style='border:solid 1px #FAFAFA;background-color:#FAFAFA;color:#FF0000;display: none;'"; //Just avaoid the shiver while removing error class
		}
	}

}



?>
