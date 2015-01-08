<?php 
	include './include/utilities.php';
	isLoggedIn();
	$dbc = getDBConnection();			
	
	$querieslist = getQueriesListXML('DonateEvent.query');
	$dbc = getDBConnection();
	$stmt = $dbc->prepare($querieslist->INS_DONATION->SQLStatement);
	$stmt->bind_param( 'iid', $_GET["eventId"],$_SESSION["LoginUserID"], $_GET["Amount"]);
	$stmt->execute();
	mysqli_stmt_close($stmt);
	closeDBConnection($dbc);
?>

<html>
<head>
<meta charset="ISO-8859-1">
<title>Donation status</title>
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/common.css" rel="stylesheet">
</head>
<body>
	<?=getAlumniDBHeader();?>
    <div class="subHeader">
		<div class="subHeaderContent">Successful payment confirmation<hr>
			<br><p class = "small">Thank you for your contribution. We have received your donation.</p>
		</div>
	</div>
	<div class="subHeader">
		<a href="homepage.php" class="subHeaderContent">Go Back to Home Page</a>
	</div>
</body>