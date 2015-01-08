<?php
	include './include/utilities.php';
	$dbc = getDBConnection();
?>
<?php
	$querieslist = getQueriesListXML('createEvent.query');
	$stmt = $dbc->prepare($querieslist->INS_EVENT->SQLStatement);
	if ($stmt == false) {closeDBConnection($dbc); die('Error in creating the statement'.$dbc->error);}
	$stmt->bind_param('sisssisss',$_POST["eventName"] ,$_POST["eventType"],$_POST["description"],$_POST["eventStartDate"],$_POST["eventEndDate"],$_POST["organizingDept"],$_POST["contactPerson"],$_POST["contactPersonNumber"],$_POST["venue"]);
	$eventId=0;
	if($stmt->execute()){
		$eventId=mysqli_insert_id($dbc);
		mysqli_stmt_close($stmt);
		$ok=0;
		if($_POST["eventCategory"]=="fr"){
			$stmt = $dbc->prepare($querieslist->INS_FR_EVENT->SQLStatement);
			if ($stmt == false) {closeDBConnection($dbc); die('Error in creating the statement'.$dbc->error);}
			$stmt->bind_param('ii',$eventId ,$_POST["memberId"]);
			if($stmt->execute()){
				$ok=1;	
			}
		}
		else if($_POST["eventCategory"]=="nfr"){
			$stmt = $dbc->prepare($querieslist->INS_NFR_EVENT->SQLStatement);
			if ($stmt == false) {closeDBConnection($dbc); die('Error in creating the statement'.$dbc->error);}
			$stmt->bind_param('iiis',$eventId ,$_POST["memberId"], $approverId=9, $approvedFlag='Y');
			if($stmt->execute()){
				$ok=1;	
			}
		}
		mysqli_stmt_close($stmt);
		closeDBConnection($dbc);
		if($ok==1){
			echo "success";
		}
		else{
			echo "other ".$eventId;
		}
	}
	else{
		mysqli_stmt_close($stmt);
		closeDBConnection($dbc);
		echo "other ".$eventId;
	}
	
?>