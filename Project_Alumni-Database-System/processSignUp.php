<?php 
	include './include/utilities.php';
	$dbc = getDBConnection();
?>
<?php
	$querieslist = getQueriesListXML('signUp.query');
	$stmt = $dbc->prepare($querieslist->CHECK_USERNAME_ALREADY_EXISTS->SQLStatement);
	if ($stmt == false) {closeDBConnection($dbc); die('Error in creating the statement CHECK_USERNAME_ALREADY_EXISTS');}
	$stmt->bind_param('s',$_POST["username"]);
	$stmt->execute();
	$stmt->bind_result($col1);
	if (mysqli_stmt_fetch($stmt)){
		echo "fail";
	}
	else{
		$stmt = $dbc->prepare($querieslist->INS_MEMBER->SQLStatement);
		if ($stmt == false) {closeDBConnection($dbc); die('Error in creating the statement INS_MEMBER');}
		$stmt->bind_param('sssss',$_POST["firstName"] ,$_POST["middleName"],$_POST["lastName"],$_POST["username"],$_POST["password"]);
		if($stmt->execute()){
			mysqli_stmt_close($stmt);
			$stmt = $dbc->prepare($querieslist->SEL_MEM_ID->SQLStatement);
			if ($stmt == false) {closeDBConnection($dbc); die('Error in creating the statement SEL_MEM_ID ');}
			$stmt->bind_param('s',$_POST["username"]);
			$stmt->execute();
			$stmt->bind_result($col1, $col2);
			//echo $col1+'  '+$col2;
			//closeDBConnection($dbc);
			//$dbc=getDBConnection();
			if(mysqli_stmt_fetch($stmt)){
				mysqli_stmt_close($stmt);
				if($_POST["memberType"]=="f"){
					$stmt = $dbc->prepare($querieslist->INS_FACULTY->SQLStatement);
					//echo mysqli_error($dbc);
					if ($stmt == false) {closeDBConnection($dbc); die('Error in creating the statement INS_FACULTY '. $col1.'  '.$col2);}
					$stmt->bind_param('i',$col2);
					$stmt->execute();
					mysqli_stmt_close($stmt);
					closeDBConnection($dbc);
					echo "success";
				}
				else if($_POST["memberType"]=="a"){
					$stmt = $dbc->prepare($querieslist->INS_ALUMNI->SQLStatement);
					if ($stmt == false) {closeDBConnection($dbc); die('Error in creating the statement INS_ALUMNI'. $col1.'  '.$col2);}
					$stmt->bind_param('i',$col2);
					$stmt->execute();
					mysqli_stmt_close($stmt);
					closeDBConnection($dbc);
					echo "success";
				}
			} 
		}
		else{
			mysqli_stmt_close($stmt);
			closeDBConnection($dbc);
			echo "other";
		}	
	}
	
?>
