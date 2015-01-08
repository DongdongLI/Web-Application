<?php
    include './include/utilities.php';
    isLoggedIn();
?>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css" media="screen">
	<link rel="stylesheet" type="text/css" href="css/common.css" media="screen">
	<link rel="stylesheet" type="text/css" href="css/style.css" media="screen">
	<title>Home Page</title>
</head>
<body>
	<!--<div class="header">
		<div class="headerContent">
			Welcome to Alumni System!
		</div>
	</div>-->
	<?= getAlumniDBWelcomeHeader(); ?>

	<div class="subHeader">
		<div class="subHeaderContent">Home Page<hr></div>
	
		<div class="content">
			<ul d="nav">
				<li><a href="searchEvent.php">Search Events</a></li>
				<li><a href="update profile.php">Update Profile</a></li>
				<li><a href="searchAlumni.php">Search Alumni</a></li>
				<li><a href="createEvent.php">Create Events</a></li>
				<li><a href="viewdonations.php">My Donations</a></li>
			</ul>
		</div>
	</div>
</body>
	
</style>
</html>