<?php 
	include './include/utilities.php';
	isLoggedIn();
?>
<html>
<head>
<meta charset="ISO-8859-1">
<title>Make a Donation</title>
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/common.css" rel="stylesheet">
</head>
<body>
	<?=getAlumniDBHeader();?>
	<div class="content">
	<form role="form" class="form-horizontal" method="get" action="./processDonateEvent.php">
		<input type="hidden" name="eventId" value="<?=$_GET["eventId"]; ?>" />
		<div class="subHeader">
		<div class="subHeaderContent">Card Details<hr></div>
	</div>
		<div class="form-group">
			<label for="CardNumber" class="col-sm-2 control-label" required>Card Number</label>
			<div class="col-sm-10">
				<input id="CardNumber" name="CardNumber" class="form-control"/>
			</div>
		</div>
		<div class="form-group">
			<label for="ExpiryDate" class="col-sm-2 control-label">Expiry Date</label>
			<div class="col-sm-10">
				<input id="ExpiryDate" name="ExpiryDate" class="form-control"/>
			</div>
		</div>
		<div class="form-group">
			<label for="CVV" class="col-sm-2 control-label">CVV</label>
			<div class="col-sm-10">
				<input id="CVV" name="CVV" class="form-control" size="5" maxlength="5"/>
			</div>
		</div>
		<div class="form-group">
			<label for="NameOnCard" class="col-sm-2 control-label">Name on Card</label>
			<div class="col-sm-10">
				<input id="NameOnCard" name="NameOnCard" class="form-control"/>
			</div>
		</div>
		<div class="form-group">
			<label for="Amount" class="col-sm-2 control-label">Amount</label>
			<div class="col-sm-10">
				<input id="Amount" name="Amount" class="form-control"/>
			</div>
		</div>
		<div class="form-group">
			<label for="Pay" class="col-sm-2 control-label"></label>
			<div class="col-sm-10">
				<input name="donate" type="submit" class="btn btn-primary" value="Donate"/>
			</div>
		</div>	
	</form>	
	</div>
	<div class="subHeader">
		<a href="homepage.php" class="subHeaderContent">Go Back to Home Page</a>
	</div>	
</body>
</html>