<?php
@session_start();
if(isset($_POST["userid"]) && isset($_POST["name"]))
{
	$_SESSION["userid"] = $_POST["userid"];
	if(isset($_POST["imageurl"]))
	{
		$_SESSION["imageurl"] = $_POST["imageurl"];
	}
    $name = explode(' ',$_POST["name"]);
	$_SESSION["username"] = $name[0];
	echo "1";
}
?>