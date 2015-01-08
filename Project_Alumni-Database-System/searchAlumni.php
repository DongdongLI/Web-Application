<?php include './include/utilities.php';
isLoggedIn();
?>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Alumni Search</title>
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/common.css" rel="stylesheet">
</head>
<body>
	<?=getAlumniDBHeader();?>
	<div class="subHeader">
		<div class="subHeaderContent">Search Alumni<hr></div>
	</div>
	<div class="content">
		<form role="form" class="form-horizontal" method="post" action="./processSearchAlumni.php">
			<div class="form-group">
				<label for="searchText" class="col-sm-2 control-label">Search Text</label>
				<div class="col-sm-10">
					<input name="searchText" class="form-control"/>
				</div>
			</div>
			<div class="form-group">
				<label for="searchOption" class="col-sm-2 control-label">Search Criteria</label>
				<div class="col-sm-10">
					<label class="radio-inline"><input checked type="radio" name="searchOption" value="Last Name">Last Name</label>
					<label class="radio-inline"><input type="radio" name="searchOption" value="Current State">Current State</label>
				</div>
			</div>
			<div class="form-group">
				<label for="searchAlumni" class="col-sm-2 control-label"></label>
				<div class="col-sm-10">
					<input name="searchAlumni" type="submit" class="btn btn-primary" value="Search Alumni" style="float:right"/>
				</div>
			</div>		
		</form>		
	</div>
	<div class="subHeader">
		<a href="homepage.php" class="subHeaderContent">Go Back to Home Page</a>
	</div>
</body>
</html>