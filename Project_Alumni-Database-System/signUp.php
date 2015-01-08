<?php 
	include 'header.php';
	include './include/utilities.php';
?>
	<div class="subHeader">
		<div class="subHeaderContent">Sign Up<hr></div>
	</div>
	<div class="content">
		<form role="form" id="signUpForm" class="form-horizontal" method="post">
			<div id="vMessages">
				<ul></ul>
			</div>
			<div class="form-group">
				<label for="firstName" class="col-sm-2 control-label">First Name</label>
				<div class="col-sm-10">
					<input id="firstname" name="firstName" class="form-control"/>
				</div>
			</div>
			<div class="form-group">
				<label for="middleName" class="col-sm-2 control-label">Middle Name</label>
				<div class="col-sm-10">
					<input name="middleName" class="form-control"/>
				</div>
			</div>
			<div class="form-group">
				<label for="lastName" class="col-sm-2 control-label">Last Name</label>
				<div class="col-sm-10">
					<input name="lastName" class="form-control"/>
				</div>
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
				<label for="memberType" class="col-sm-2 control-label">Member Type</label>
				<div class="col-sm-10">
					<select name="memberType" class="form-control" id="memberType">
						<option>Select</option>
						<option value="f">Faculty</option>
						<option value="a">Alumni</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="signUp" class="col-sm-2 control-label"></label>
				<div class="col-sm-10">
					<input name="signUp" id="signUp" type="button" class="btn btn-primary" value="Sign Up" style="float:right"/>
					<a href="./login.php" ><input style="display:none;" id="login" type="button"></a>
				</div>
				
			</div>
		</form>
	</div>
	<script type="text/javascript">
		$('#signUp').click(function(){
			$('#vMessages ul').empty();
			vMessagesCount=0;
			if($('#firstname').val()==''){
				$('#vMessages ul').append('<li>First Name is a required field</li>');
				vMessagesCount++;
			}
			if($('#username').val()==''){
				$('#vMessages ul').append('<li>Username is a required field</li>');
				vMessagesCount++;
			}
			if($('#password').val()==''){
				$('#vMessages ul').append('<li>Password is a required field</li>');
				vMessagesCount++;
			}
			if($('#memberType').val()=='Select'){
				$('#vMessages ul').append('<li>Please select Member Type</li>');
				vMessagesCount++;
			}
			if(vMessagesCount==0){
				$.ajax({
			           type: "POST",
			           url: "processSignUp.php",
			           data: $("#signUpForm").serialize(), // serializes the form's elements.
			           success: function(data)
			           {
				           //alert(data);
				           if(data.indexOf("fail")>-1){
				        		$('#vMessages ul').empty();
			        	   		$('#vMessages ul').append('<li>Usename already exists. Try a different one.</li>'); 
				           }
				           else if(data.indexOf("success")>-1){
					            alert('Sign Up Successful!');
				       			$('#login').click();
				           }
				           else{
				        		$('#vMessages ul').empty();
			        	   		$('#vMessages ul').append('<li>Sign Up failed. Please try again.</li>');
					       }				           
			           }
			         });
			}
		});
	</script>
</body>
</html>