<?php

session_start();
if(isset($_SESSION['YOUBOOK_userid']))
{
	$_SESSION['YOUBOOK_userid'] = NULL;
	unset($_SESSION['YOUBOOK_userid']);
}


header("Location: Login.php");
die;
?>