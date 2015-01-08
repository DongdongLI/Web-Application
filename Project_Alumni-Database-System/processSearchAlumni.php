<?php include './include/utilities.php';
isLoggedIn();

	$querieslist = getQueriesListXML('processSearchAlumni.query');
	// Code to execute the query. 
	$dbc = getDBConnection();
	if($dbc == false){  die('Error in creating the DB connection.'); } 
	if($_POST["searchOption"] == "Last Name"){
		$stmt = $dbc->prepare($querieslist->SEL_ALUMNI_LASTNAME->SQLStatement);
	}
	else{
		$stmt = $dbc->prepare($querieslist->SEL_ALUMNI_CUR_STATE->SQLStatement);
	}
	if ($stmt == false) {closeDBConnection($dbc); die('Error in creating the statement.');}
	// Since both the parameters are strings the binding is being done outside. 
	$stmt->bind_param('s', $_POST["searchText"] );	
	$stmt->execute();
	$result=$stmt->get_result();

	if(!$result){
		closeDBConnection($dbc); die('Error in executing the query.');
	}
?>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Almni Search Results</title>
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/common.css" rel="stylesheet">
</head>
<body>
	<?=getAlumniDBHeader();?>
	<div class="subHeader">
		<div class="subHeaderContent">Search Results for - <?= $_POST["searchOption"] . " starting with ". $_POST["searchText"] ?><hr>
			<small class="small">
			  <div class="table-responsive">
				<table class="table" >
				  <thead>
					<tr class="small">
					  <th>Sl No. </th>
					  <th>Alumni Profile link</th>
					  <th>Current State</th>
					</tr>
				  </thead>
				  <tbody>
				  <?php
					$counter=1;
					while ( ($row=mysqli_fetch_assoc($result) ) ){
				  ?>
						<tr class="small">
							<td> <?= $counter; ?>
							</td>
							<td>
								<a href="./getUserProfile.php?alid=<?= $row["MEMBER_ID"]; ?>" target="_new"><?= $row["NAME"]; ?></a>
							</td>
							<td> <?= $row["CURRENT_STATE"]; ?>
							</td>
						</tr>
				  <?php
						$counter=$counter+1;
					}
					// Close the statement and database connections after fetching all the results. 
					mysqli_stmt_close($stmt);	
					closeDBConnection($dbc);					
				  ?>
				  </tbody>
				</table>
			  </div>
			</small>
		</div>
		<BR>
		<BR>
		<a href="./searchAlumni.php" class="subHeaderContent">Back to Search Alumni Page</a>
	</div>
</body>
</html>