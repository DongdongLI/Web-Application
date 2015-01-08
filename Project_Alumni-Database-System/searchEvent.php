<!DOCTYPE html>
<?php 
	include './include/utilities.php';
	isLoggedIn();
	$dbc = getDBConnection();
?>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Search Event</title>
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/common.css" rel="stylesheet">
<script type="text/javascript" src="js/jquery-1.11.1.js"></script>
<script type="text/javascript" src="jquery-ui-1.11.2.custom/jquery-ui.js"></script>
<link href="jquery-ui-1.11.2.custom/jquery-ui.css" rel="stylesheet">
</head>
<body>
	<?=getAlumniDBHeader();?>
	<div class="subHeader">
		<div class="subHeaderContent">Search Event<hr></div>
	</div>
	<div class="content">
	<form role="form" id="searchForm" class="form-horizontal" method="post" action="./processSearchEvent.php">
		<div id="vMessages">
				<ul></ul>
		</div>
		<div class="form-group">
			<label for="eventName" class="col-sm-2 control-label">Name</label>
			<div class="col-sm-10">
				<input name="eventName" class="form-control"/>
			</div>
		</div>
		<div class="form-group">
			<label for="eventType" class="col-sm-2 control-label">Event Type</label>
			<div class="col-sm-10">
				<select name="eventType" class="form-control">
					<option></option>
					<?php 
						$querieslist = getQueriesListXML('searchEvent.query');
						$stmt = $dbc->prepare($querieslist->SEL_EVENT_TYPE->SQLStatement);
						$stmt->execute();
						$stmt->bind_result($col1, $col2);
						while (mysqli_stmt_fetch($stmt)){
							echo '<option value='.$col1.'>'.$col2.'</option>';
						}
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="eventStartDate" class="col-sm-2 control-label">Event Start Date/Time</label>
			<div class="col-sm-10">
				<input id="eventStartDate" name="eventStartDate" class="form-control"/>
			</div>
		</div>
		<div class="form-group">
			<label for="eventEndDate" class="col-sm-2 control-label">Event End Date/Time</label>
			<div class="col-sm-10">
				<input id="eventEndDate" name="eventEndDate" class="form-control"/>
			</div>
		</div>
		<div class="form-group">
			<label for="organizingDept" class="col-sm-2 control-label">Organizing Department</label>
			<div class="col-sm-10">
				<select name="organizingDept" class="form-control">
					<option></option>
					<?php 
						$querieslist = getQueriesListXML('searchEvent.query');
						$stmt = $dbc->prepare($querieslist->SEL_DEPT->SQLStatement);
						$stmt->execute();
						$stmt->bind_result($col1, $col2);
						while (mysqli_stmt_fetch($stmt)){
							echo '<option value='.$col1.'>'.$col2.'</option>';
						}
						mysqli_stmt_close($stmt);
						closeDBConnection($dbc);
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="contactPerson" class="col-sm-2 control-label">Contact Person</label>
			<div class="col-sm-10">
				<input name="contactPerson" class="form-control"/>
			</div>
		</div>
		<div class="form-group">
			<label for="venue" class="col-sm-2 control-label">Venue</label>
			<div class="col-sm-10">
				<input name="venue" class="form-control"/>
			</div>
		</div>
		<div class="form-group">
			<label for="SearchEvent" class="col-sm-2 control-label"></label>
			<div class="col-sm-10">
				<input name="searchEventButton" type="submit" class="btn btn-primary" value="Search Event" style="float:right"/>
			</div>
		</div>		
	</form>	
	</div>
	<div class="subHeader">
		<a href="homepage.php" class="subHeaderContent">Go Back to Home Page</a>
	</div>		
	
	<script type="text/javascript">
		$(document).ready(function(){
			$('#eventStartDate').datepicker();
			//{
			//});
			$('#eventEndDate').datepicker();
			//{
			//});
			});
	</script>
</body>
