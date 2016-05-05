<?php
if(isset($_POST["searchterm"]))
{
$value = $_POST["searchterm"];
$v= str_replace(' ', '', $value);
}
?>	
	<frameset cols="60%,40%">
<frame src="display.php?name=<?php echo $v; ?>">
<frame src="recommend.php?name=<?php echo $v;?>">
</frameset>