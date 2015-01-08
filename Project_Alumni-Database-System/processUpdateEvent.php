<?php
	include './include/utilities.php';
	isLoggedIn();
	$dbc = getDBConnection();
?>
<?php
	$querieslist = getQueriesListXML('createEvent.query');
	$stmt = $dbc->prepare($querieslist->UPD_EVENT->SQLStatement);
	if ($stmt == false) {closeDBConnection($dbc); die('Error in creating the statement'.$dbc->error);}
	$stmt->bind_param('sisssisssi',$_POST["eventName"] ,$_POST["eventType"],$_POST["description"],$_POST["eventStartDate"],$_POST["eventEndDate"],$_POST["organizingDept"],$_POST["contactPerson"],$_POST["contactPersonNumber"],$_POST["venue"],$_POST["eventId"]);
	if($stmt->execute()){
		mysqli_stmt_close($stmt);
		closeDBConnection($dbc);
		echo "success";
	}
	else{
		mysqli_stmt_close($stmt);
		closeDBConnection($dbc);
		echo "other";
	}
	
?>