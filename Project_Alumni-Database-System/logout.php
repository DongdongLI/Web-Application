<?php 
	include './include/utilities.php';
	logout();
	if( is_null($_SESSION["LoginUserID"]) ){	
		header("Location: ". "login.php");
		exit;
	}	
?>