<!-- Main Footer -->
<footer class="main-footer"> <strong>Copyright &copy; <?=date("Y")?>&nbsp;<a href="<?=SITE_NAME?>" target="_blank">Astral pipes</a>.</strong> All rights reserved. </footer>
<script type="text/javascript">
function validateNumbersOnly(e) 
{
	var unicode = e.charCode ? e.charCode : e.keyCode;
	
	if ((unicode == 8) || (unicode == 9) || (unicode > 47 && unicode < 58)||(unicode == 43)||(unicode == 45) ||(unicode == 188) ||(unicode == 189) ||(unicode == 32)) 
	{
		return true;
	}
	else 
	{
		//alert("This field accepts only Numbers");
		return false;
	}
}
</script>