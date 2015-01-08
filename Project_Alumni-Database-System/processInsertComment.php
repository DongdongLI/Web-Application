<?php 
 include './include/utilities.php';
 isLoggedIn();
 ?>

<html>

<head>
<title>Insert Comment</title>
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/common.css" rel="stylesheet">
<script type="text/javascript" src="js/jquery-1.11.1.js"></script>
</head>
<html>
<body>
	<?=getAlumniDBHeader();?>
<?php
 if(isset($_POST["comment"]))
  {
	if(!empty($_POST["comment"]))
	{
		$dbc = getDBConnection();
		$querieslist = getQueriesListXML('InsertDeleteComments.query');
		$stmt = $dbc->prepare($querieslist->INS_COMMENT->SQLStatement);
		if ($stmt == false) 
		{
			closeDBConnection($dbc); 
			die('Error in creating the statement.');
		}
		$stmt->bind_param('sii',$_POST["comment"], $_SESSION["LoginUserID"], $_POST["EventID"]);
		$result = $stmt->execute();
	
		if(!$result) {
			echo ($dbc->error);
			closeDBConnection($dbc);
			die('Error in executing the query.');
		}
   
		mysqli_stmt_close($stmt);
		closeDBConnection($dbc);

		echo '<div class="subHeader">';
		echo '	<div class="subHeaderContent">';
		echo '	<p class="small">Thank you for your comment!</p><hr/>';
		echo "	</div>";
		echo '</div>';
	}
	else 
		echo "Please enter a comment!";
  } 
?>
	<div class="subHeader">
		<a href="homepage.php" class="subHeaderContent">Go Back to Home Page</a>
	</div>
</body>
</html>