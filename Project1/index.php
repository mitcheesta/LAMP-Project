<!--Name: index.php from Project1 for LAMP 1
	Author: Michelle Estanol
	Purpose: 
		- has code for website base as well as function for displaying the main page
		- manages starting code for page (add includes and starts sessions)
		- manages button presses and routing between pages
-->

<?php
	session_start(); //start session

	//first time page is visited, set the SESSION['page'] to 'Main'
	if(!isset($_SESSION["action"])){
		$_SESSION["action"] = "Display";
	}
	if(!isset($_SESSION["page"])){
		$_SESSION["page"] = 1;
	}

	//add other php pages
	require_once("./includes/formSurveyOne.php");
	require_once("./includes/formSurveyTwo.php");
	require_once("./includes/formSurveyThree.php");
	require_once("./includes/formSummary.php");
	require_once("./includes/formThankYou.php");
	require_once("./includes/formValidation.php");
	require_once("./includes/dbOperations.php");
	require_once("./includes/saveFormData.php");

	//set constant variables
	define("DBHOST", "localhost");
	define("DBDB", "lamp1_survey");
	define("DBUSER", "lamp1_survey");
	define("DBPW", "!survey!");
?>

<!-- HTML code for start of <html>, full <head>, and start of <body> -->
<html>
	<head>
		<title>LAMP 1 Project 1</title>
		<link rel="stylesheet" href="./styles/style.css" type="text/css">
	</head>
	<body>
<!-- End of HTML code -->

<!-- Determine which type of page to display based on the POST data (i.e. which button was pressed)
		- checks which button was pressed
					- possible values: btnStart, btnNext, btnPrevious, btnSave
		- checks that POST object has the expected data
		- sets the value of SESSION["action"]

-->
<?php

	if(isset($_POST["btnStart"]) && ($_POST["btnStart"]) == "Start Survey"){
		$_SESSION["action"] = "Start"; 
	}
	else if(isset($_POST["btnNext"]) && ($_POST["btnNext"]) == "Next"){
		$_SESSION["action"] = "Next"; 
	}
	else if(isset($_POST["btnPrevious"]) && ($_POST["btnPrevious"]) == "Previous"){
		$_SESSION["action"] = "Previous"; 
	}
	else if(isset($_POST["btnSave"]) && ($_POST["btnSave"]) == "Save"){
		$_SESSION["action"] = "Save"; 
	}
	else{
		$_SESSION["action"] = "Redisplay"; 
	}

?>

<!-- Router to determine which page to display based on SESSION data
		- SESSION data should have been properly set in the preceding block of PHP
-->
<?php

	$_SESSION['errors'] = array(); //create SESSION['errors'] to hold associative array of errors

if($_SESSION["action"] == "Start"){ //create SESSION['survey'] to hold current page of survey (initialized with 1)
	displaySurveyOne();
	$_SESSION['page'] = 2;
}
else if($_SESSION["action"] == "Next"){
	//validate form data
	switch($_SESSION['page']){
		case 2: //if currently on survey part 1
			$error_msg = validatePageOne(); //create array to hold error messages
			
			$_SESSION['errors']['page1'] = array(); //create an empty array within 'errors' for page 1's errors
				//also resets the "list" of found errors

			if($error_msg != null){
				foreach($error_msg as $value){
					array_push($_SESSION['errors']['page1'], $value); //push all error messages into the SESSION['errors']['page1']
				}
				displaySurveyOne(); //redisplay part 1
			}
			else{
				saveSurveyOneToSession();
				$_SESSION['page'] = 3;
				displaySurveyTwo(); 
			}

			break;
		case 3: //if currently on survey part 2
			if(isset($_POST['btnNext'])){ //if user hits 'Next' after filling in page 2, validate
				$error_msg = validatePageTwo();
			
				$_SESSION['errors']['page2'] = array(); //create an empty array within 'errors' for page 1's errors
				//also resets the "list" of found errors

				if($error_msg != null){
					foreach($error_msg as $value){
						array_push($_SESSION['errors']['page2'], $value); //push all error messages into the SESSION['errors']['page1']
					}
					displaySurveyTwo(); //if errors present, redisplay page 2
				}
				else{
					saveSurveyTwoToSession();
					$_SESSION['page'] = 4;
					displaySurveyThree();
				}			
			}
			else{ //if user still working on part 2, redisplay
				displaySurveyTwo();
			}
			break;
		case 4: //if currently on survey part 3
			if(isset($_POST['btnNext'])){ //if user hits 'Next' after filling in page 2, validate
				$error_msg = validatePageThree();
			
				$_SESSION['errors']['page3'] = array(); //create an empty array within 'errors' for page 1's errors
				//also resets the "list" of found errors

				if($error_msg != null){
					foreach($error_msg as $value){
						array_push($_SESSION['errors']['page3'], $value); //push all error messages into the SESSION['errors']['page1']
					}
					displaySurveyThree(); //if errors present, redisplay part 3
				}
				else{
					saveSurveyThreeToSession();

					$_SESSION['page'] = 5;
					displaySummary();
				}			
			}
			else{//if user still working on page 3, redisplay
				displaySurveyThree();
			}
			break;
	}//switch end
}
else if($_SESSION["action"] == "Previous"){
	switch($_SESSION['page']){
		case 2:
			//change page# in SESSION
			$_SESSION['page'] = 1;

			//call the previous page
			displayMainPage();

			break;

		case 3:
			//change page# in SESSION
			$_SESSION['page'] = 2;

			//call the previous page
			displaySurveyOne();

			break;

		case 4:
			//change page# in SESSION
			$_SESSION['page'] = 3;

			//call the previous page
			displaySurveyTwo();

			break;

		case 5:
			//change page# in SESSION
			$_SESSION['page'] = 4;

			//call the previous page
			displaySurveyThree();

			break;
	}
}
else if($_SESSION["action"] == "Save"){ //if 'Save' button pressed
	$db_conn = connectToDB(DBHOST, DBUSER, DBPW, DBDB); //create a db connection using defined constants

	//inserts user info into database and saves the table id for that entry into $userID
	$userID = saveParticipantToDB($db_conn);
	
	//for each item purchased, inserts that product's info into db
	$counter = 1;
	foreach($_SESSION['purchases[]'] as $purchase => $text){
		saveResponsesToDB($db_conn, $text, $_SESSION['howPurchased'], $_SESSION['satisfaction'.$counter], $_SESSION['recommend'.$counter], $userID);
		++$counter;
	}

	disconnectFromDB($db_conn); //disconnect from db
	$_SESSION['page'] = 6;
	displayThankYou(); //display thank you page
}
else if($_SESSION["action"] == "Redisplay"){
	switch($_SESSION["page"]){
		case 1:
			displayMainPage();
			break;
		case 2:
			displaySurveyOne();
			break;
		case 3:
			displaySurveyTwo();
			break;
		case 4:
			displaySurveyThree();
			break;
			
		case 5:
			displaySummary();
			break;

		case 6:
			displayThankYou();
			break;
	}
}
else if($_SESSION["action"] == "Display"){
	displayMainPage();
}

?>

<!-- HTML code for  </body> and  </html> -->
	</body>
</html>
<!-- End of HTML code -->

<!-- Purpose: To display the main page's HTML. -->
<?php
	function displayMainPage(){
?>
	<form method="POST">
		<h1>Multi-page Survey Application</h1>
		<h2 style="border: none;">By Michelle Estanol</h2>
		<div id="divHowTo">
			<p>Welcome to our online survey system.</p>
			<h3>How to Use</h3>
			<ul>
				<li>You may go backwards to review or change your answers using the 'Previous' button.</li>
				<li>The form will remember your completed pages as long as you don't close your browser window.</li>
				<li>To begin, please press the 'Start Survey' button.</li>
			</ul>
		</div>

		<footer>
			<div id="divButtons">
				<input type="submit" value="Start Survey" name="btnStart" id="btnStart">
			</div>
		</footer>
	</form>
<?php
	}
?>
