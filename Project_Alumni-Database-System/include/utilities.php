<?php 
include 'constants.php';

function getQueriesListXML($filename) {
 //$queries_xml_nodes = ;
 return simplexml_load_file(QUERIES_HOME."/$filename");
}

function getDBConnection(){
	$dbcon = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME,DB_PORT);
	return $dbcon;
}

function closeDBConnection($dbConnection){
	mysqli_close($dbConnection);
}

// Needs to be placed in every PHP page for which user has to be logged in.
// Thus it prevents unauthenticated user access to the system.
// session_unset() should be done when the signout action is performed.
function isLoggedIn(){
	// edit by Rajiv - I don't think session_start(); should be here, it should be only in login.php 
	session_start();
	if( is_null($_SESSION["LoginUserID"]) ){	
		header("Location: ". "login.php");
		exit;
	}
}

function logout(){
	// Unbinds all the session variables.
	session_unset();
	if (ini_get("session.use_cookies")) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 42000,
			$params["path"], $params["domain"],
			$params["secure"], $params["httponly"]
			);
	}
	// Destroy the session completely.
	session_destroy(); 
	
}

function getAlumniDBHeader(){
	return '<div class="header">'.
				'<div class="headerContent">'. APP_NAME . 
					'<a href="./logout.php" style="float:right" class="headerContentAlignRight">Logout (' . $_SESSION["username"] .') </a>' .
				'</div>' .
			'</div>';
}

function getAlumniDBWelcomeHeader(){
	return '<div class="header">'.
				'<div class="headerContent"> Welcome to '. APP_NAME . '!' . 
					'<a href="./logout.php" style="float:right" class="headerContentAlignRight">Logout (' . $_SESSION["username"] .') </a>' . 
				'</div>' .
			'</div>';
}

// Functions related to uploading profile and event images.
function saveUserProfilePic($tempfile,$originalfilename,$userID){
	/* Write the code here to delete to the existing profile pics */
	$extn = end (explode (".",$originalfilename) );
	// USER_PROFILE_PICS_HOME . "/
	return move_uploaded_file($tempfile, USER_PROFILE_PICS_HOME."/$userID.$extn" );
}

function getUserProfilePicLink($userID){
	// a function call is being used to get the file name
	$profilePicFile = getProfilePicFile($userID);
	$files_available = scandir(USER_PROFILE_PICS_HOME. "/$userID");
	foreach($files_available as $filename){
		if ( ($filename == $profilePicFile) ){
			return USER_PROFILE_PICS_HOME."/$userID/$profilePicFile";
		}
	}
	return NO_PROFILE_PIC;
}

// Yet to fully develop to retrieve the complete file name from the database.
function getProfilePicFile($userID){
	return "$userID.jpg";
}

?>
 