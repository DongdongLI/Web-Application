<!DOCTYPE html>
<?php
	//include 'header.php';
	include './include/utilities.php';
	isLoggedIn();
	$querieslist = getQueriesListXML('getUserById.query');
	$querieslist2 = getQueriesListXML('updateUserProfile.query');
	//session_start();
	//echo $_SESSION["LoginUserID"];//isLoggedIn();
	$dbc = getDBConnection();
	if($dbc == false){  die('Error in creating the DB connection.'); }
//query using XML, function: connect,close 
	$q=$dbc->prepare($querieslist->GET_USER_BY_ID->SQLStatement);
	//$_SESSION["LoginUserID"]
	//$q="select * from member where Username='$username'";
	//$q="select * from member where member_id=".$_SESSION["LoginUserID"];
	$q->bind_param('i',$_SESSION["LoginUserID"]);//$_SESSION["LoginUserID"]);
	$q->execute();
	//$result=mysql_query($q,$conn);
	$result=$q->get_result();
	if (!$result) {

		closeDBCollection($dbc);
		die('Error in executing the query.');
	}
	while ( ($row=mysqli_fetch_assoc($result) ) )//while($row=mysql_fetch_array($result))
	{
		$fn=$row["FirstName"];
		//echo $fn;
		$mn=$row["MiddleName"];
		$ln=$row["LastName"];
		$pass=$row["Password"];
		$about=$row["About_Me"];

		$cur_addr_H=$row["Current_Address_H_No"];
		$cur_addr_S=$row["Current_Street_Address"];
		$cur_city=$row["Current_City"];
		$cur_state=$row["Current_State"];
		$cur_country=$row["Current_Country"];
		$cur_zip=$row["Current_Zipcode"];
	
		$per_addr_H=$row["Perm_Address_H_No"];
		$per_addr_S=$row["Perm_Street_Address"];
		$per_city=$row["Perm_City"];
		$per_state=$row["Perm_State"];
		$per_country=$row["Perm_Country"];
		$per_zip=$row["Perm_Zipcode"];
			
		$h_tel=$row["Home_Phone_Current"];
		$mo=$row["Mobile_Number_Current"];
		$fb=$row["Facebook_Profile"];
		$li=$row["LinkedIN_Profile"];
	}

	if(isset($_POST['submitted']))
	{
		if(empty($_POST['first_name']))
			$_POST['first_name']=$fn;
		else
			$fn=$_POST['first_name'];//$fn = mysqli_real_escape_string($conn, trim($_POST['first_name']));

		if(empty($_POST['password']))
			$_POST['password']=$pass;
		else
			$pass=$_POST['password'];

		if(empty($_POST['middle_name']))
			$_POST['middle_name']=$mn;
		else
			$mn=$_POST['middle_name'];

		if(empty($_POST['last_name']))
			$_POST['last_name']=$ln;
		else
			$ln=$_POST['last_name'];

		if(empty($_POST['Mobile_Number_Current']))
			$_POST['Mobile_Number_Current']=$mo;
		else
			$mo=$_POST['Mobile_Number_Current'];

		if(empty($_POST['Home_Phone_Current']))
			$_POST['Home_Phone_Current']=$h_tel;
		else
			$h_tel=$_POST['Home_Phone_Current'];

		if(empty($_POST['Facebook_Profile']))
			$_POST['Facebook_Profile']=$fb;
		else
			$fb=$_POST['Facebook_Profile'];	

		if(empty($_POST['LinkedIN_Profile']))
			$_POST['LinkedIN_Profile']=$li;
		else
			$li=$_POST['LinkedIN_Profile'];

		if(empty($_POST['About_Me']))
			$_POST['About_Me']=$about;
		else
			$about=$_POST['About_Me'];

		if(empty($_POST['Current_Address_H_No']))
			$_POST['Current_Address_H_No']=$cur_addr_H;
		else
			$cur_addr_H=$_POST['Current_Address_H_No'];

		if(empty($_POST['Current_Street_Address']))
			$_POST['Current_Street_Address']=$cur_addr_S;
		else
			$cur_addr_S=$_POST['Current_Street_Address'];

		if(empty($_POST['Current_City']))
			$_POST['Current_City']=$cur_city;
		else
			$cur_city=$_POST['Current_City'];

		if(empty($_POST['Current_State']))
			$_POST['Current_State']=$cur_state;
		else
			$cur_state=$_POST['Current_State'];

		if(empty($_POST['Current_Country']))
			$_POST['Current_Country']=$cur_country;
		else
			$cur_country=$_POST['Current_Country'];

		if(empty($_POST['Current_Zipcode']))
			$_POST['Current_Zipcode']=$cur_zip;
		else
			$cur_zip=$_POST['Current_Zipcode'];

		if(empty($_POST['Perm_Address_H_No']))
			$_POST['Perm_Address_H_No']=$per_addr_H;
		else
			$per_addr_H=$_POST['Perm_Address_H_No'];

		if(empty($_POST['Perm_Street_Address']))
			$_POST['Perm_Street_Address']=$per_addr_S;
		else
			$per_addr_S=$_POST['Perm_Street_Address'];

		if(empty($_POST['Perm_City']))
			$_POST['Perm_City']=$per_city;
		else
			$per_city=$_POST['Perm_City'];

		if(empty($_POST['Perm_State']))
			$_POST['Perm_State']=$per_state;
		else
			$per_state=$_POST['Perm_State'];

		if(empty($_POST['Perm_Country']))
			$_POST['Perm_Country']=$per_country;
		else
			$per_country=$_POST['Perm_Country'];

		if(empty($_POST['Perm_Zipcode']))
			$_POST['Perm_Zipcode']=$per_zip;
		else
			$per_zip=$_POST['Perm_Zipcode'];
		$q2=$dbc->prepare($querieslist2->UPDATE_PROFILE->SQLStatement);
		$q2->bind_param('sssssssssssssssssssssi',$ln,$fn,$mn,$pass,$about,
		$cur_addr_H,
		$cur_addr_S,
		$cur_city,
		$cur_state,
		$cur_country,
		$cur_zip,
	
		$per_addr_H,
		$per_addr_S,
		$per_city,
		$per_state,
		$per_country,
		$per_zip,
			
		$h_tel,
		$mo,
		$fb,
		$li,$_SESSION["LoginUserID"]);
		$q2->execute();
		
		if($result2=$q2->get_result())
		{
			echo "<h1>update successfully</h1>";
		}
	}
	//echo $fn.$mn.$ln.$pass.$h_tel.$li;
	
?>


<html>
<head>
	
	<link rel="stylesheet" type="text/css" href="css/style.css" media="screen">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css" media="screen">
	<link rel="stylesheet" type="text/css" href="css/common.css" media="screen">
</head>
<body>

<?=getAlumniDBHeader();?>
		<div class="subHeader">
		<div style="margin:10px">Profile Update<hr></div>
	</div>
		<ul id="navi">
			<li style="float:right;"><a href="homepage.php">Go Back to Home Page</a></li>
		</ul>
	<table >
	<form method="POST" action="<?php $_PHP_SELF ?>">
		<tr>
			<td style="color:blue;">Password</td>
			<td><p>New Password:<br/>
			<input type="password" name="password" size="15" maxlength="45"/></p></td>
		</tr>
		<tr>
			<td style="color:blue;">Personal Info</td>
			<td><p>First Name:<br/>
			<input type="text" name="first_name" size="15" maxlength="20" value="<?=$fn?>" /></p></td>
			<td><p>Middle Name:<br/><input type="text" name="middle_name" size="15" maxlength="20" value="<?=$mn?>"/></p></td>
			<td><p>Last Name: <input type="text" name="last_name" size="15" maxlength="40" value="<?=$ln?>"/></p></td>
			<td><p>Mobile Phone Number: <input type="text" name="Mobile_Number_Current" size="15" maxlength="15" value="<?=$mo?>"/></p></td>
			<td><p>Home Phone Number: <input type="text" name="Home_Phone_Current" size="15" maxlength="15" value="<?=$h_tel?>"/></p></td>
		</tr>
		<tr>
			<td style="color:blue;">Current Address</td>
			<td><p>Current Address(Apartment NO.): <input type="text" name="Current_Address_H_No" size="15" maxlength="15" value="<?=$cur_addr_H?>"/></p></td>
			<td><p>Current Address(street): <input type="text" name="Current_Street_Address" size="15" maxlength="45" value="<?=$cur_addr_S?>"/></p></td>
			<td><p>Current City: <input type="text" name="Current_City" size="15" maxlength="20" value="<?=$cur_city?>"/></p></td>
			<td><p>Current State:<br/> <input type="text" name="Current_State" size="15" maxlength="30" value="<?=$cur_state?>"/></p></td>
			<td><p>Current Country: <input type="text" name="Current_Country" size="15" maxlength="45" value="<?=$cur_country?>"/></p></td>
			<td><p>Current Zip: <input type="text" name="Current_Zipcode" size="15" maxlength="7" value="<?=$cur_zip?>"/></p></td>
		</tr>
		<tr>
			<td style="color:blue;">Permanent Address</td>
			<td><p>Permanent Address(Apartment NO.): <input type="text" name="Perm_Address_H_No" size="15" maxlength="15" value="<?=$per_addr_H?>"/></p></td>
			<td><p>Permanent Address(street): <input type="text" name="Perm_Street_Address" size="15" maxlength="45" value="<?=$per_addr_S?>"/></p></td>
			<td><p>Permanent City: <input type="text" name="Perm_City" size="15" maxlength="20" value="<?=$per_city?>"/></p></td>
			<td><p>Permanent State: <input type="text" name="Perm_State" size="15" maxlength="30" value="<?=$per_state?>"/></p></td>
			<td><p>Permanent Country: <input type="text" name="Perm_Country" size="15" maxlength="45" value="<?=$per_country?>"/></p></td>
			<td><p>Permanent Zip: <input type="text" name="Perm_Zipcode" size="15" maxlength="7" value="<?=$per_zip?>"/></p></td>
		</tr>
		<tr>
			<td style="color:blue;">Social Network Information</td>
			<td><p>Facebook Profile:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="Facebook_Profile" size="15" maxlength="255" value="<?=$fb?>"/></p></td>
			<td><p>LinkedIN Profile:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="LinkedIN_Profile" size="15" maxlength="255" value="<?=$li?>"/></p></td>
		</tr>
		<tr>
			<td style="color:blue;">about me: <textarea name="About_Me" rows="3" cols="30" style="color:black;"><?php echo $about;?></textarea></td>
		</tr>
		
	
	<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
	
	

	<p><input type="submit" name="submit" value="Update Profile"  style="color:red;" /></p>
	<input type="hidden" name="submitted" value="TRUE" />
	</form>
</table>
</body>
</html>
