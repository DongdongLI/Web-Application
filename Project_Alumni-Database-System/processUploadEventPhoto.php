<?php
	include './include/utilities.php';
	$dbc = getDBConnection();		
	$uploadOk = 1;
	$target_dir = "images/events/".$_POST["eventId"];
	if(!is_dir($target_dir)){
		if (!mkdir($target_dir, 0777, true)) {
			$uploadOk = 0;
		}
	}
	$target_file = $target_dir ."/". basename($_FILES["fileToUpload"]["name"]);
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		//echo "fail";
		header("Location: ". "uploadEventPhoto.php?eventId=".$_POST["eventId"]."&result=fail");
		// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			//echo "success";
		} else {
			//echo "fail";
			header("Location: ". "uploadEventPhoto.php?eventId=".$_POST["eventId"]."&result=fail");
			$uploadOk=0;
		}
	}
	
	if($uploadOk==0){
		//echo "fail";
		header("Location: ". "uploadEventPhoto.php?eventId=".$_POST["eventId"]."&result=fail");
	}
	else{
		$querieslist = getQueriesListXML('uploadEventPhoto.query');
		$stmt = $dbc->prepare($querieslist->INS_EVENT_PHOTO->SQLStatement);
		if ($stmt == false) {closeDBConnection($dbc); die('Error in creating the statement'.$dbc->error);}
		$stmt->bind_param('ssi', $_FILES["fileToUpload"]["name"],$_POST["photoDescription"],$_POST["eventId"]);
		if($stmt->execute()){
			mysqli_stmt_close($stmt);
			closeDBConnection($dbc);
			//echo "success";
			header("Location: ". "uploadEventPhoto.php?eventId=".$_POST["eventId"]."&result=success");
		}
		else{
			mysqli_stmt_close($stmt);
			closeDBConnection($dbc);
			header("Location: ". "uploadEventPhoto.php?eventId=".$_POST["eventId"]."&result=fail");
			//echo "fail";
		}	
	}
?>