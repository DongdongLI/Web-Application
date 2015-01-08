<?php
include './include/utilities.php';
isLoggedIn();
?>

<html>

<head>
<meta charset="ISO-8859-1">
<title>Your Comments</title>
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/common.css" rel="stylesheet">
<script type="text/javascript" src="js/jquery-1.11.1.js"></script>
</head>
<body>
	<?=getAlumniDBHeader();?>
	
	<div class="subHeader">
		<div class="subHeaderContent">Comment<hr></div>
	</div>

	<div class="content">
		<form role="form" class="form-horizontal" method="post" action="./processInsertComment.php">
			<input type="hidden" name="EventID" value="<?=$_GET["eventId"]; ?>" />
			<div class="form-group">
				<label for="insertcomment" class="col-sm-2 control-label">Type your comment here</label>
				<div class="col-sm-10">
					<textarea name="comment" rows="6" class="form-control" value="">
					</textarea>
				</div>
			</div>
        
            <div class="form-group">
                <label for="createEvent" class="col-sm-2 control-label"></label>
                <div class="col-sm-10">
                <input type='submit' value='Submit' class='btn btn-primary' /> 
                <input type="reset" value="Reset" class='btn btn-primary' /> 
                </div>
            </div>
         </form>
    </div>
	<div class="subHeader">
		<a href="homepage.php" class="subHeaderContent">Go Back to Home Page</a>
	</div>	
</body>
</html>