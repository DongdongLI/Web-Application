<?php 
	include './include/utilities.php';
	// set LoginUserID in session to null if it isn't already 
	//session_start();
	if(!isset($_SESSION["LoginUserID"])){
		$_SESSION["LoginUserID"]=NULL;
	} 
	// unset session if already
	//logout();
?>
<html>
<head>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/common.css" rel="stylesheet">
	<script type="text/javascript" src="js/jquery-1.11.1.js"></script>
	<title>Login to <?= APP_NAME; ?> </title>
</head>
<body>
	<div class="header">
		<div class="headerContent"><?= APP_NAME; ?></div>
	</div>

	<div class="subHeader">
		<div class="subHeaderContent">Login<hr></div>
	</div>
	<div class="content">
		<form role="form" id="loginForm" class="form-horizontal" method="post" action="./welcome.php">
			<div id="vMessages">
				<ul></ul>
			</div>
			<div class="form-group">
				<label for="username" class="col-sm-2 control-label">Username</label>
				<div class="col-sm-10">
					<input id="username" name="username" class="form-control"/>
				</div>
			</div>
			<div class="form-group">
				<label for="password" class="col-sm-2 control-label">Password</label>
				<div class="col-sm-10">
					<input id="password" name="password" type="password" class="form-control"/>
				</div>
			</div>
			<div class="form-group">
				<label for="login" class="col-sm-2 control-label"></label>
				<div class="col-sm-10">
					<input name="login" id="login" type="button" class="btn btn-primary" value="Login" style="float:right;margin-left:10px"/>
					<a href="./signUp.php"><input name="signUp" type="button" class="btn btn-primary" value="Sign Up" style="float:right"/></a>
					
				</div>
			</div>
		</form>
	</div>
	<script type="text/javascript">
		$('#login').click(function(){
			$('#vMessages ul').empty();
			var vMessagesCount=0;
			if($('#username').val()==''){
				vMessagesCount++;
				$('#vMessages ul').append('<li>Username is a required field</li>');
			}
			if($('#password').val()==''){
				vMessagesCount++;
				$('#vMessages ul').append('<li>Password is a required field</li>');
			}
			if(vMessagesCount==0){
				$('#loginForm').submit();
			}
				
			});
	</script>
</body>

</html>