<?php
class  commonFunctions
{
	function RemoveInvalidCharacter($mString)
	{

		$invalid_chars = array(' ', '`', '~', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '=', '+', '[', ']', '{', '}', '\\', '¦', ':', ';', '"', '\'', ',', '<', '>', '/', '?');
		$corrected_chars = array('_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_', '_');
		$newname = str_replace($invalid_chars, $corrected_chars, $mString);
		return $newname;
	}

	function RemoveInvalidTitleCharacter($mString)
	{

		$invalid_chars = array(' ','`', '~', '!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '=', '+', '[', ']', '{', '}', '\\', '¦', ':', ';', '"', '\'', ',', '<', '>', '/', '?');
		$corrected_chars = array('-','', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
		$newname = str_replace($invalid_chars, $corrected_chars, $mString);
		return $newname;
	}
}

?>