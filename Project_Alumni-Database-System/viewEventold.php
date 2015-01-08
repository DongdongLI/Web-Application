<?php 

	include './include/utilities.php';
	isLoggedIn();

	$imageFileNameArray = array();
	$imagesDescArray = array();
	
	$disableDonateButton = "disabled";
	
	//isLoggedIn();
	$eventId=$_GET["eventId"];
	
	$dbc = getDBConnection();
	if($dbc == false){
		die('Error in creating the DB connection.');
	}
	
	$querieslist = getQueriesListXML('viewEvent.query');
	$stmt = $dbc->prepare($querieslist->SEL_EVENT_BY_ID->SQLStatement);
	if ($stmt == false) {
		closeDBConnection($dbc);
		die('Error in creating the statement  for Event.');
	}
	
	$stmt->bind_param('i', $eventId);
	$stmt->execute();
	$result=$stmt->bind_result($eventId, $eventName, $eventTypeId, $eventType, $eventDesc, $eventStartDate, $eventEndDate, $organizingDeptId, $organizingDept, $contactPerson, $contactPersonNumber, $venue);
	$stmt->fetch();

	if(!$result){
		closeDBConnection($dbc);
		die('Error in executing the query.');
	}
	
	getImagesBasedOnId($eventId, $querieslist);	
	enableDonationsButton($eventId, $querieslist);
	
	function getImagesBasedOnId($eventId, $querieslist) {
		$dbc = getDBConnection();
		$stmtImages = $dbc->prepare($querieslist->SEL_EVENT_IMAGES_BY_ID->SQLStatement);
		
		if ($stmtImages == false) {
			echo ($dbc->error);
			closeDBConnection($dbc);
			die('Error in creating the statement for Images.');
		}
		
		$stmtImages->bind_param('i', $eventId);		
		$stmtImages->execute();
		
		$resultImages=$stmtImages->bind_result($eventPhotoId, $photoFileName, $photoDesc);
		
		if(!$resultImages) {
			closeDBConnection($dbc);
			die('Error in executing the query.');
		}

		while ($stmtImages->fetch()) {
			$photoFileName = EVENTS_PICS_HOME .'/' . $eventId . '/' . $photoFileName;
			//echo $photoFileName;
			array_push($GLOBALS['imageFileNameArray'], $photoFileName);
			array_push($GLOBALS['imagesDescArray'], $photoDesc);
		}
		
		mysqli_stmt_close($stmtImages);
		closeDBConnection($dbc);
	}
	
	function enableDonationsButton($eventId, $querieslist) {
		$dbc = getDBConnection();
		$stmtFundRaising = $dbc->prepare($querieslist->SEL_EVENT_FUND_RAISING_BY_ID->SQLStatement);
	
		if ($stmtFundRaising == false) {
			echo ($dbc->error);
			closeDBConnection($dbc);
			die('Error in creating the statement for Images.');
		}
	
		$stmtFundRaising->bind_param('i', $eventId);
		$stmtFundRaising->execute();
		$result=$stmtFundRaising->bind_result($tempEventId);
		$stmtFundRaising->fetch();
	
		if($tempEventId != ""){
			$GLOBALS["disableDonateButton"] = "";
		}
	
		mysqli_stmt_close($stmtFundRaising);
		closeDBConnection($dbc);
	}
?>

<html>
<head>
<meta charset="ISO-8859-1">
<title>Event Details</title>
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/common.css" rel="stylesheet">
<link href="js/imageSlider/themes/1/js-image-slider.css" rel="stylesheet" type="text/css" />
<script src="js/imageSlider/themes/1/js-image-slider.js" type="text/javascript"></script>
<script type="text/javascript" src="js/jquery-1.11.1.js"></script>
<script type="text/javascript" src="jquery-ui-1.11.2.custom/jquery-ui.js"></script>
<link href="jquery-ui-1.11.2.custom/jquery-ui.css" rel="stylesheet">
</head>
<body>
	<!-- <div class="header">
		<div class="headerContent">Events</div>
	</div> -->
	<?=getAlumniDBHeader();?>
	<div class="subHeader">
		<div class="subHeaderContent"><?= $eventName ?><hr>
			<form role="form" id="updateEventForm" class="form-horizontal" method="post">
					<div id="vMessages">
						<ul></ul>
					</div>
					<input name="eventId" id="eventId" type="hidden" value="<?= $eventId ?>"/>
					<div class="form-group" style="margin-top:10px">
						<label for="eventName" class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10">
							<input name="eventName" id="eventName" value="<?= $eventName ?>" class="form-control"/>
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
							<input id="eventStartDate" name="eventStartDate" class="form-control" value="<?= $eventStartDate ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label for="eventEndDate" class="col-sm-2 control-label">Event End Date/ Time</label>
						<div class="col-sm-10">
							<input id="eventEndDate" name="eventEndDate" class="form-control" value="<?= $eventEndDate ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label for="description" class="col-sm-2 control-label">Description</label>
						<div class="col-sm-10">
							<textarea name="description" id="description" class="form-control"><?= $eventDesc ?></textarea>
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
					<script type="text/javascript">
						$('#eventType').val('<?= $eventTypeId ?>');
						$('#organizingDept').val('<?= $organizingDeptId ?>');	

					</script>
					<div class="form-group">
						<label for="contactPerson" class="col-sm-2 control-label">Contact Person</label>
						<div class="col-sm-10">
							<input name="contactPerson" id="contactPerson" class="form-control" value="<?= $contactPerson ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label for="contactPersonNumber" class="col-sm-2 control-label">Contact Person Number</label>
						<div class="col-sm-10">
							<input name="contactPersonNumber" id="contactPersonNumber" class="form-control" value="<?= $contactPersonNumber ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label for="venue" class="col-sm-2 control-label">Venue</label>
						<div class="col-sm-10">
							<input name="venue" id="venue" class="form-control" value="<?= $venue ?>"/>
						</div>
					</div>
					<div id="uploadPhotosDiv" style="display: none;" title="Event Photos">
						<iframe src="uploadEventPhoto.php?eventId=<?=$eventId?>&result=" width="370" height="290"></iframe>
					</div>
					
				</form>
			</div>
		
    <div id="sliderFrame">
        <div id="slider">
		  <?php	  
		  for ($i = 0; $i < count($GLOBALS['imageFileNameArray']); ++$i) {
			?>
			<img src="<?= $GLOBALS['imageFileNameArray'][$i] ?>" alt="<?= $GLOBALS['imagesDescArray'][$i] ?>" />
		  <?php
			}			
		  ?>
        </div>
    </div>
    <BR><BR>
		<table align="center">
			<tr>
			<form action="./donateEvent.php?eventId=<?= $eventId;?>" method="get">
					<td><input name="leaveCommentButton" type="submit" class="btn btn-primary" formmethod="post" formaction="./insertcomment.php?eventId=<?= $eventId;?>" value="Leave Comment" style="margin-left:50px"/></td>			
				</form>
				<form action="./deletecomment.php?eventId=<?= $eventId;?>" method="get">
					<td><input name="leaveCommentButton" type="submit" class="btn btn-primary" formmethod="post" formaction="./deletecomment.php?eventId=<?= $eventId;?>" value="Delete Comment" /></td>
				</form>
				<form action="./donateEvent.php?eventId=<?= $eventId;?>" method="get">
					<td><input name="donationButton" type="submit" class="btn btn-primary" formmethod="post" formaction="./donateEvent.php?eventId=<?= $eventId;?>" value="Make a Donation" <?= $disableDonateButton;?> /></td>			
				</form>
<!-- 				<td><input name="updateEventButton" type="submit" class="btn btn-primary" value="Update Event" /></td> -->
					<td><input name="updateEvent" id="updateEvent" type="button" class="btn btn-primary" value="Update Event" style="margin-right:0"/></td>
					<td><input name="uploadPhotos" id="uploadPhotos" type="button" class="btn btn-primary"  value="Upload Event Photos"/></td>
			</tr>
		</table>
    
		<BR>
		<BR>
		<a href="./searchEvent.php" class="subHeaderContent">Back to Event Search Page</a>
		<script type="text/javascript">
		 $( "#uploadPhotosDiv" ).dialog({
			 autoOpen: false,
			 height: 350,
			 width:400,
			 resizable: false			 
		 });
		
		$('#uploadPhotos').click(function(){
			$('#uploadPhotosDiv').dialog("open");
		});

		$('#uploadPhotosDiv').bind('dialogclose', function(event) {
			window.location.href = "./viewEvent.php?eventId=<?= $eventId?>";
		 });

		$('#updateEvent').click(function(){
			$('#vMessages ul').empty();
			vMessagesCount=0;
			if($('#eventId').val()==''){
				$('#vMessages ul').append('<li>Event Id is a required field</li>');
				vMessagesCount++;
			}
			if($('#eventName').val()==''){
				$('#vMessages ul').append('<li>Event Name is a required field</li>');
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
			           url: "processUpdateEvent.php",
			           data: $("#updateEventForm").serialize(), // serializes the form's elements.
			           success: function(data)
			           {
				           //alert(data);
				           if(data.indexOf("success")>-1){
				        	    $('#vMessages ul').empty();
			        	   		$('#vMessages ul').append('<li>Event Updated Successfully!</li>');				       			
				           }
				           else{
				        		$('#vMessages ul').empty();
			        	   		$('#vMessages ul').append('<li>Event updation failed. Please try again.</li>');
					       }				           
			           }
			         });
			}

		});

			function switchAutoAdvance() {
	            imageSlider.switchAuto();
	            switchPlayPauseClass();
	        }
	        function switchPlayPauseClass() {
	            var auto = document.getElementById('auto');
	            var isAutoPlay = imageSlider.getAuto();
	            auto.className = isAutoPlay ? "group2-Pause" : "group2-Play";
	            auto.title = isAutoPlay ? "Pause" : "Play";
	        }
	        switchPlayPauseClass();
			
		</script>
		
	</div>
</body>

</html>