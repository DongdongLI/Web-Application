<!DOCTYPE html>
<?php 
	include './include/utilities.php';
	isLoggedIn();
	$dbc = getDBConnection();
?>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Create Event</title>
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/common.css" rel="stylesheet">
<script type="text/javascript" src="js/jquery-1.11.1.js"></script>
<script type="text/javascript" src="jquery-ui-1.11.2.custom/jquery-ui.js"></script>
<link href="jquery-ui-1.11.2.custom/jquery-ui.css" rel="stylesheet">
</head>
<body>
	<?=getAlumniDBHeader();?>
	<div class="subHeader">
		<div class="subHeaderContent">Create Event<hr></div>
	</div>
	<div class="content">
	<form role="form" id="createEventForm" class="form-horizontal" method="post">
	
		<div id="vMessages">
				<ul></ul>
		</div>
		
		<div class="form-group">
			<label for="eventName" class="col-sm-2 control-label">Name</label>
			<div class="col-sm-10">
				<input name="eventName" id="eventName" class="form-control"/>
			</div>
		</div>
		<div class="form-group">
			<label for="eventCatogery" class="col-sm-2 control-label">Event Category</label>
			<div class="col-sm-10">
				<select name="eventCategory" class="form-control">
					<option>Select</option>
					
					<?php 
						$querieslist = getQueriesListXML('createEvent.query');
						$stmt = $dbc->prepare($querieslist->CHECK_IF_MEMBER_IS_FACULTY->SQLStatement);
						if ($stmt == false) {closeDBConnection($dbc); die('Error in creating the statement CHECK_IF_MEMBER_IS_FACULTY');}
						$stmt->bind_param('s',$_SESSION["LoginUserID"]);
						$stmt->execute();
						$stmt->bind_result($col1);
						if (mysqli_stmt_fetch($stmt)){
							echo '<option value="fr">Fund Raising</option>';
						    echo '<option value="nfr">Non-Fund Raising</option>';
						}
						else{
							echo '<option value="nfr">Non-Fund Raising</option>';
						}
					?>
					
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="eventType" class="col-sm-2 control-label">Event Type</label>
			<div class="col-sm-10">
				<select name="eventType" id="eventType" class="form-control">
					<option>Select</option>
					<?php 
						mysqli_stmt_close($stmt);
						$querieslist = getQueriesListXML('createEvent.query');
						$stmt = $dbc->prepare($querieslist->SEL_EVENT_TYPE->SQLStatement);
						//$stmt->bind_param( "ss", $_POST["username"], $_POST["password"]);
						// "ss' is a format string, each "s" means string
						$stmt->execute();
						// member_id,firstname,middlename,lastname,username,email
						$stmt->bind_result($col1, $col2);
						while (mysqli_stmt_fetch($stmt)){
							echo '<option value='.$col1.'>'.$col2.'</option>';
						}
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label for="eventStartDate" class="col-sm-2 control-label">Event Start Date/ Time</label>
			<div class="col-sm-10">
				<input id="eventStartDate" name="eventStartDate" class="form-control"/>
			</div>
		</div>
		<div class="form-group">
			<label for="eventEndDate" class="col-sm-2 control-label">Event End Date/ Time</label>
			<div class="col-sm-10">
				<input id="eventEndDate" name="eventEndDate" class="form-control"/>
			</div>
		</div>
		<div class="form-group">
			<label for="description" class="col-sm-2 control-label">Description</label>
			<div class="col-sm-10">
				<textarea name="description" id="description" class="form-control"></textarea>
			</div>
		</div>
		<div class="form-group">
			<label for="organizingDept" class="col-sm-2 control-label">Organizing Department</label>
			<div class="col-sm-10">
				<select name="organizingDept" id="organizingDept" class="form-control">
					<option>Select</option>
					<?php 
						mysqli_stmt_close($stmt);
						$querieslist = getQueriesListXML('createEvent.query');
						$stmt = $dbc->prepare($querieslist->SEL_DEPT->SQLStatement);
						//$stmt->bind_param( "ss", $_POST["username"], $_POST["password"]);
						// "ss' is a format string, each "s" means string
						$stmt->execute();
						// member_id,firstname,middlename,lastname,username,email
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
				<input name="contactPerson" id="contactPerson" class="form-control"/>
			</div>
		</div>
		<div class="form-group">
			<label for="contactPersonNumber" class="col-sm-2 control-label">Contact Person Number</label>
			<div class="col-sm-10">
				<input name="contactPersonNumber" id="contactPersonNumber" class="form-control"/>
			</div>
		</div>
		<div class="form-group">
			<label for="venue" class="col-sm-2 control-label">Venue</label>
			<div class="col-sm-10">
				<input name="venue" id="venue" class="form-control"/>
			</div>
		</div>
		
		<input name="memberId" id="memberId" type="hidden" value="<?=$_SESSION["LoginUserID"] ?>" class="form-control"/>
		
		<div class="form-group">
			<label for="createEvent" class="col-sm-2 control-label"></label>
			<div class="col-sm-10 createContent" >
				<input name="createEvent" id="createEvent" type="button" class="btn btn-primary" value="Create Event"/>	
			</div>
				
		</div>
		
		
	</form>	
	</div>
	<div class="subHeader">
		<a href="homepage.php" class="subHeaderContent">Go Back to Home Page</a>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#eventStartDate').datepicker({ dateFormat: 'yy-mm-dd' });
			$('#eventEndDate').datepicker({ dateFormat: 'yy-mm-dd' });
		});

		$('#createEvent').click(function(){
			$('#vMessages ul').empty();
			vMessagesCount=0;
			if($('#eventName').val()==''){
				$('#vMessages ul').append('<li>Event Name is a required field</li>');
				vMessagesCount++;
			}
			if($('#eventCategory').val()=='Select'){
				$('#vMessages ul').append('<li>Please select a Event Category</li>');
				vMessagesCount++;
			}
			if($('#eventType').val()=='Select'){
				$('#vMessages ul').append('<li>Please select a Event Type</li>');
				vMessagesCount++;
			}
			if($('#organizingDept').val()=='Select'){
				$('#vMessages ul').append('<li>Please select a Organizing Department</li>');
				vMessagesCount++;
			}
			
			if(vMessagesCount==0){
				$.ajax({
			           type: "POST",
			           url: "processCreateEvent.php",
			           data: $("#createEventForm").serialize(), // serializes the form's elements.
			           success: function(data)
			           {
				           if(data.indexOf("success")>-1){
					            //alert('Event Created Successfully!');
					            $('#vMessages ul').empty();
					            $('#vMessages ul').append('<li>Event Created Successfully!</li>');
				           }
				           else{
				        		$('#vMessages ul').empty();
			        	   		$('#vMessages ul').append('<li>Event creation failed. Please try again.</li>');
					       }				           
			           }
			         });
			}
		});

		
		
	</script>
</body>
</html>