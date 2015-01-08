<?php
    
 include './include/utilities.php';
 isLoggedIn();

?>
<html>
<head>
 <meta charset="ISO-8859-1">
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
    <div class="subHeaderContent">
			<?php 
                
				$dbc = getDBConnection();
				$querieslist = getQueriesListXML('InsertDeleteComments.query');


				$stmt = $dbc->prepare($querieslist->SEL_ALL_COMMENTS->SQLStatement);
				$stmt->bind_param('i', $_GET["eventId"] );	
				$stmt->execute();
				/* Store the result (to get properties) */
				$stmt->store_result();

				/* Get the number of rows */
				$num_of_rows = $stmt->num_rows;
				
				if ($num_of_rows > 0){
					echo "<form action='processDeleteComment.php' method='post'>";
					echo '<p><b>Comments for this Event<br></b></p>';
					echo "	<div class='form-group-overflow'>";
					echo "	<TABLE border=1 cellpadding=5 class='form-group' witdh=100%>";
					echo "      <col width='80%'><col width='20%'>";
					echo "\n	<TR><TH>Select Comments to Delete</TH><TH>Comment Date</TH></TR>";
					
					$stmt->bind_result($event_comment_iD,$event_comments,$comment_date);
					while($stmt->fetch())
                    {
						echo "<tr>";
						echo '<td align=left valign="top" ><input type=checkbox name="commentid[]" id=commentid value="'. $event_comment_iD . '" />';
						echo "<textarea cols=95 disabled rows=5 class='small'>$event_comments</textarea></td>";
						echo "<td class='small'>$comment_date</td>";
						echo "</tr>";			
					}
					echo "	</table>";
					echo "	</div>";
					echo "<BR><BR>";
					echo "<div class='form-group'>";
					echo "	<label for='DelEvent' class='col-sm-2 control-label'></label>";
					echo "	<div class='col-sm-10'>";
                   
                   $stmt1 = $dbc->prepare($querieslist->DEL_BY_EVENTOWNER->SQLStatement);
				   $stmt1->bind_param('ii', $_GET["eventId"],$_GET["eventId"] );	
				  $stmt1->execute();
                  $stmt1->bind_result($event_owner_id);
                  if($stmt1->fetch())
                  {

                  if($event_owner_id==$_SESSION["LoginUserID"])
                   {
					echo "	<input name='delcomment' type='submit' class='btn btn-primary' value='Delete' align='right' />";		
					}
				    
                    else { 
                    echo"<input name='delcomment' type='submit' class='btn btn-primary' value='Delete' align='right' disabled/>";
                    }
                  mysqli_stmt_close($stmt1);
                  }
                  echo "  </div>";
					echo "</div>";}
                   
				   else{
					echo '<p class="small">No comments available. </p>';
				}
				/* free results */
				$stmt->free_result();
				
			   mysqli_stmt_close($stmt);
             
			   closeDBConnection($dbc);

			?>
	</div>
	<BR>
	<div class="subHeader">
		<a href="homepage.php" class="subHeaderContent">Go Back to Home Page</a>
	</div>	
</body>
</html>