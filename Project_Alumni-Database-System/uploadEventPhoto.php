<!DOCTYPE html>
<?php 
	include './include/utilities.php';
	$dbc = getDBConnection();
?>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Insert title here</title>
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/common.css" rel="stylesheet">
<script type="text/javascript" src="js/jquery-1.11.1.js"></script>
<script type="text/javascript" src="jquery-ui-1.11.2.custom/jquery-ui.js"></script>
<link href="jquery-ui-1.11.2.custom/jquery-ui.css" rel="stylesheet">
<!-- <script src="jssor.slider.mini.js"></script> -->
</head>
<body>
	<form role="form" class="form-horizontal" action="./processUploadEventPhoto.php" id="uploadEventPhotoForm" method="post" enctype="multipart/form-data" style="padding:20px;width:350px">
	    <div id="result" style="display: none;">
			<ul></ul>
		</div>
		<?php 
		if($_GET["result"]=="success"){
		?>
			<script type="text/javascript">
				$('#result ul').empty();
				$('#result ul').append("Image Uploaded Successfully");
				$('#result').fadeIn('fast');
				setTimeout(function() {
				    $('#result').fadeOut('fast');
				}, 3000); 
				//alert("Image Uploaded Successfully");
			</script>
		<?php 	
		}
		else if($_GET["result"]=="fail"){
		?>
			<script type="text/javascript">
				$('#result ul').empty();
				$('#result ul').append("Image Upload Failed");
				$('#result').fadeIn('fast');
				setTimeout(function() {
				    $('#result').fadeOut('fast');
				}, 3000);  
				//alert("Image Upload Failed");
			</script>
		<?php
		}
		?>
	    <div class="form-group">
			<label for="fileToUpload" class="col-sm-2 control-label">Select File To Upload</label>
			<div class="col-sm-10">
				<input type="file" name="fileToUpload" id="fileToUpload">
			</div>
		</div>
	    <div class="form-group">
			<label for="photoDescription" class="col-sm-2 control-label">Description</label>
			<div class="col-sm-10">
				<textarea name="photoDescription" id="photoDescription" class="form-control" style="width:300px"></textarea>
			</div>
		</div>
	    <input type="hidden" name="eventId" id="eventId" value=<?=$_GET["eventId"]?>>
	    <input type="submit" value="Upload Image" name="uploadImageButton" id="uploadImageButton" class="btn btn-primary" style="float:right">
	</form>
</body>
</html>