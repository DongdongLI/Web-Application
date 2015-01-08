<?php

include './include/utilities.php';

isLoggedIn();

    	$querieslist = getQueriesListXML('donations.query');
	// Code to execute the query. 
	$dbc = getDBConnection();
	if($dbc == false){  die('Error in creating the DB connection.'); } 
	//if($_POST["searchOption"] == "Last Name"){
		$stmt = $dbc->prepare($querieslist->VIEW_DONATIONS->SQLStatement);
	//}
	
	if ($stmt == false) {closeDBConnection($dbc); die('Error in creating the statement.');}
	// Since both the parameters are strings the binding is being done outside. 
	$stmt->bind_param('i', $_SESSION["LoginUserID"] );	
	$stmt->execute();
	$result=$stmt->get_result();   
        
        if(!$result){
		closeDBConnection($dbc); die('Error in executing the query.');
	}
        // echo $_SESSION["LoginUserID"];
      ?>
<html>
<head>
<meta charset="ISO-8859-1">
<title>View Donations</title>
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/common.css" rel="stylesheet">
</head>
<body>
	<?=getAlumniDBHeader();?>
	<div class="subHeader">
		<div class="subHeaderContent">Donations made so far 
			<small class="small">
			  <div class="table-responsive">
				<table class="table" >
				  <thead>
					<tr class="small">
					  <th>S No. </th>
					  <th>Event Name</th>
					  <th>Donation Amount</th>
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
								<?= $row["Event_Name"]; ?>
							</td>
							<td> <?= $row["Donation_Amount"]; ?>
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
                <div class="subHeader">
		<a href="homepage.php" class="subHeaderContent">Go Back to Home Page</a>
	</div>	
	</div>
</body>
