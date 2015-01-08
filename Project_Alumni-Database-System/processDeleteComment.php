<?php
    include './include/utilities.php';
    isLoggedIn();
?>
<html>

<head>
<title>Delete Comments</title>
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/common.css" rel="stylesheet">
<script type="text/javascript" src="js/jquery-1.11.1.js"></script>
</head>

<body>
	<?=getAlumniDBHeader();?>
    <div class="subHeader">
		<div class="subHeaderContent">Delete Comment<hr></div>
	</div>
    <div class=" content">
    <div class="col-sm-10">
<?php 

  $dbc = getDBConnection();
  $strCommentIDsSelected ="";
 $querieslist = getQueriesListXML('InsertDeleteComments.query');
 //$ID = get_post();
 //echo count($_POST);echo "<BR>";
 echo "Number of comments deleted: " . count( $_POST['commentid']);
 for($i=0 ; $i< (count ($_POST['commentid']));$i++ ){
     $strCommentIDsSelected=$_POST['commentid'][$i];
      $stmt = $dbc->prepare($querieslist->DEL_COMMENT->SQLStatement);
	if ($stmt == false) 
   {closeDBConnection($dbc); 
    die('Error in creating the statement.');
    }
	$stmt->bind_param('i',$strCommentIDsSelected);
	$stmt->execute();
 }
 
	
	mysqli_stmt_close($stmt);
    closeDBConnection($dbc);


?>

     </div>        </div>
	 <BR>
	<div class="subHeader">
		<a href="homepage.php" class="subHeaderContent">Go Back to Home Page</a>
	</div>	 
</body>
</html>