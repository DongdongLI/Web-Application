<?php include './include/utilities.php';
isLoggedIn();

	$querieslist = getQueriesListXML('getUserProfile.query');
	// Code to execute the query. 
	$dbc = getDBConnection();
	if($dbc == false){  die('Error in creating the DB connection.'); } 
	$stmt = $dbc->prepare($querieslist->SEL_ALUMNI->SQLStatement);
	if ($stmt == false) {closeDBConnection($dbc); die('Error in creating the statement.');}
	$stmt->bind_param('i', $_GET["alid"] );	
	$stmt->execute();
	$result=$stmt->get_result();

	if($result){
		// Query executed successfully. Fetch the row details.
		$row=mysqli_fetch_assoc($result);
	}
	else{
		closeDBConnection($dbc); die('Error in executing the query.');
	}
	mysqli_stmt_close($stmt);	
	closeDBConnection($dbc);
?>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="css/bootstrap.css" rel="stylesheet">	
	<link rel="stylesheet" href="./css/common.css">
	<title>
		<?= $row["NAME"];?>'s Profile page.
	</title>
  </head>
  <body>
	<?=getAlumniDBHeader();?>
	<div class="subHeader">
		<div class="subHeaderContent">About Me - <?= $row["NAME"];?><hr>
			<table class="table">
			  <tbody cols="70,30">
				<tr>
				  <td class="small">
					<small> <?= $row["ABOUT_ME"];?>
					</small>
				  </td>
				  <td>
					<img class="profileview" src="<?=getUserProfilePicLink($_GET["alid"]); ?>">
				  </td>
				</tr>
			  </tbody>
			</table>
		</div>
		<div class="subHeaderContent">My Association With University<hr>
		<small>
			Date of Joining: <?= $row["DOJ"];?>
			<div class="subHeaderContent2">Major Details<hr>
			Major Degree: <?= $row["MAJOR_DEGREE"];?>&nbsp;&nbsp;&nbsp;
			Major Department: <?= $row["MAJOR_DEPARTMENT_NAME"];?>&nbsp;&nbsp;&nbsp;
			Major Year of Completion: <?= $row["MAJOR_YR_OF_COMPLETION"];?><BR>
			Major Advisor: <?= $row["ADVISOR_NAME"];?>
			</div>
			<BR>
			<div class="subHeaderContent2">Minor Details<hr>
			<!--NA indicates Not Available -->
			Minor Degree: <?= $row["MINOR_DEGREE"] ?>&nbsp;&nbsp;&nbsp; 
			Minor Department: <?= $row["MINOR_DEPARTMENT_NAME"] ?>&nbsp;&nbsp;&nbsp;
			Minor Year of Completion: <?= $row["MINOR_YR_OF_COMPLETION"] ?>			
			</div>			
		</small>
		</div>
		<BR>
		<div class="subHeaderContent">Reach Me @<hr>
		<small>
			Linked In Profile: <a href='http://<?= $row["LINKEDIN_PROFILE"] ?>'><?= $row["LINKEDIN_PROFILE"] ?></a><BR>
			Facebook profile: <a href='http://<?= $row["FACEBOOK_PROFILE"] ?>'> <?= $row["FACEBOOK_PROFILE"] ?> </a><BR>
			Home Phone Number (<img class="phone" src=./images/AlumniDB_TelephoneIcon.png /> ): <?= $row["CURRENT_PHONE"] ?><BR>
			Mobile Number (<img class="phone" src=./images/AlumniDB_CellPhoneIcon.png /> ): <?= $row["MOBILE"] ?><BR>
		</small>
		</div>
		<BR>
		<div class="subHeaderContent">Address Details<hr>
		<table class="table">
			<thead>
			  <tr>
				<th class=small>Current Address</th>
				<th class=small>Permanent Address</th>
			  </tr>
			</thead>
			<tbody>
			  <tr>
				<td class=small>
					<!--<address> -->
						House Number: <?= $row["CURRENT_ADDRESS_H_NO"] ?><BR>
						Stree Address: <?= $row["CURRENT_STREET_ADDRESS"] ?><BR>
						City: <?= $row["CURRENT_CITY"] ?><BR>
						State: <?= $row["CURRENT_STATE"] ?><BR>
						Country: <?= $row["CURRENT_COUNTRY"] ?><BR>
						ZipCode: <?= $row["CURRENT_ZIPCODE"] ?>
					<!--</address> -->
				</td>
				<td class=small>
					<!--<address> -->
						House Number: <?= $row["PERM_ADDRESS_H_NO"] ?><BR>
						Stree Address: <?= $row["PERM_STREET_ADDRESS"] ?><BR>
						City: <?= $row["PERM_CITY"] ?><BR>
						State: <?= $row["PERM_STATE"] ?><BR>
						Country: <?= $row["PERM_COUNTRY"] ?><BR>
						ZipCode: <?= $row["PERM_ZIPCODE"] ?>
					<!--</address> -->
				</td>
			  </tr>
			</tbody>
		</table>
		</div>
	</div>
  </body>

</html>