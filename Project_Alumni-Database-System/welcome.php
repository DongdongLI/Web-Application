<?php 
	include './include/utilities.php';
	$dbc = getDBConnection();
?>
<HTML>
<BODY>
<?php
	//echo $_POST["username"];
	$querieslist = getQueriesListXML('login.query');
	$stmt = $dbc->prepare($querieslist->SEL_MEMBER->SQLStatement);
	$stmt->bind_param( "ss", $_POST["username"], $_POST["password"]); 
	// "ss' is a format string, each "s" means string
	$stmt->execute();	
	// member_id,firstname,middlename,lastname,username,email
	$stmt->bind_result($col1, $col2, $col3, $col4, $col5);
	if (mysqli_stmt_fetch($stmt)){	
		//echo $col1;
		if (!$col1==NULL){
			session_start();
			$_SESSION["LoginUserID"]=$col1;
			$_SESSION["username"]=$col5;
			echo "Welcome, "."$col2";

			mysqli_stmt_close($stmt);
			closeDBConnection($dbc);
			// home page code here
			header("Location: ". "homePage.php");
		}
	}
	else{
		isLoggedIn();
	}
?>
<a href="./login.php">Logout</a>
</BODY>
</HTML>