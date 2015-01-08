<?php 

	include './include/utilities.php';
	isLoggedIn();
	
	$eventName=$_POST["eventName"];
	$eventType=$_POST["eventType"];
	$eventStartDate=$_POST["eventStartDate"];
	$eventEndDate=$_POST["eventEndDate"];
	$organizingDept=$_POST["organizingDept"];
	$contactPerson=$_POST["contactPerson"];
	$venue=$_POST["venue"];
	
	$selectedButtonEvent = -1;
	
	$selectQuery = "select events.Event_ID, events.Event_Name, event_type.Event_Type_Desc, events.Event_Start_Date, events.Event_END_Date, 
	department.Department_Name, events.Contact_Person_Name from events ";
	
	$innerJoinQuery = " INNER JOIN event_type, department ";
	
	$sqlWhereQuery="";
	
	if ($eventName != "") {
		if ($sqlWhereQuery != "") {
			$sqlWhereQuery .= " AND ";
		}
		
		$sqlWhereQuery .= " upper(events.Event_name) LIKE upper('%" . $eventName . "%')";
	}
	
	if ($eventType != "") {
		if ($sqlWhereQuery != "") {
			$sqlWhereQuery .= " AND ";
		}
	
		$sqlWhereQuery .= " events.event_ID=" . $eventType;
	}
	
	if ($eventStartDate != "") {	
		if ($sqlWhereQuery != "") {
			$sqlWhereQuery .= " AND "; 
		}
		
		$startDate = date("Y-m-d", strtotime($eventStartDate));
		$sqlWhereQuery .= " events.Event_Start_Date BETWEEN '" . $startDate . " 00:00:00.00' AND '" . $startDate . " 23:59:59.999'";
	}
	
	if ($eventEndDate != "") {
		if ($sqlWhereQuery != "") {
			$sqlWhereQuery .= " AND ";
		}
		
		$endDate = date("Y-m-d", strtotime($eventEndDate));
		$sqlWhereQuery .= " events.Event_END_Date BETWEEN '" . $endDate . " 00:00:00.00' AND '" . $endDate . " 23:59:59.999'";
	}
	
	if ($contactPerson != "") {
		if ($sqlWhereQuery != "") {
			$sqlWhereQuery .= " AND ";
		}
	
		$sqlWhereQuery .=  " upper(events.Contact_Person_Name) LIKE upper('%" . $contactPerson . "%')";
	}
	
	if ($organizingDept != "") {
		if ($sqlWhereQuery != "") {
			$sqlWhereQuery .= " AND ";
		}
		
		$sqlWhereQuery .= " events.Organizing_dept_ID=" .$organizingDept;
	}
	
	
	if ($venue != "") {
		if ($sqlWhereQuery != "") {
			$sqlWhereQuery .= " AND ";
		}
	
		$sqlWhereQuery .=  " upper(events.venue) LIKE upper('%" . $venue . "%')";
	}
	
	
	if ($sqlWhereQuery != "") {
		$selectQuery .= $innerJoinQuery ." WHERE " . $sqlWhereQuery . " AND events.Organizing_dept_ID=department.Department_ID AND events.event_type_ID=event_type.Event_Type_ID";
		$dbc = getDBConnection();	
		$stmt = $dbc->prepare($selectQuery);
			
		if ($stmt == false) {
			closeDBConnection($dbc); 
			die('Error in creating the statement.');
		}
		
		$stmt->execute();
	    $result=$stmt->bind_result($eventId, $eventName, $eventType, $eventStartDate, $eventEndDate, $organizingDept, $contactPerson);
	
		if(!$result){
			closeDBConnection($dbc); die('Error in executing the query.');
		}
	}

?>

<html>
<head>
<meta charset="ISO-8859-1">
<title>Event Search Results</title>
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/common.css" rel="stylesheet">
<script type="text/javascript" src="jquery-ui-1.11.2.custom/jquery-ui.js"></script>
<link href="jquery-ui-1.11.2.custom/jquery-ui.css" rel="stylesheet">
</head>
<body>
	<?=getAlumniDBHeader();?>
	<div class="subHeader">
		<div class="subHeaderContent">Search Results<hr>
			<small class="small">
			  <div class="table-responsive">
				<table class="table" >
				  <thead>
					<tr class="small">
					  <th>Name</th>
					  <th>Event Type</th>
					  <th>Start Date</th>
					  <th>End Date</th>
					  <th>Organizing Department</th>
					  <th>Contact</th>
					</tr>
				  </thead>
				  <tbody>
				  <?php
					while ($stmt->fetch()) {	
					?>
						<tr class="small">
							<td><a href="./viewEvent.php?eventId=<?= $eventId; ?>"><?= $eventName ?></a></td>
							<td> <?= $eventType ?></td>
							<td> <?= $eventStartDate ?></td>
							<td> <?= $eventEndDate ?></td>
							<td> <?= $organizingDept ?></td>
							<td> <?= $contactPerson ?></td>
						</tr>
				  <?php
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
		<BR><BR><BR><BR>
		<a href="./searchEvent.php" class="subHeaderContent">Back to Event Search Page</a>
	</div>
	

	
</body>
</html>