<!--Name: saveFormData.php from Project 1
	Author: Michelle Estanol
	Purpose: Provides functions for connecting to and disconnecting from DB.
-->
<?php

/*  Purpose: To insert the user's personal info into the participants table (fullname, age, student)
    Pre-condition: Takes in a database connection object.
    Post-condition: If successful, returns the id of the inserted row of data and inserts data into participants table.
*/
function saveParticipantToDB($db_conn){
    //converts student form data to database-acceptable single char
    switch($_SESSION['student']){
        case "fulltime":
            $studentChar = "f";
            break;
        case "parttime":
            $studentChar = "p";
            break;
        case "no":
            $studentChar = "n";
            break;
    }

    $qryParticipants = "INSERT INTO participants SET " . 
    "part_fullname = '" . $_SESSION['fullName'] . "', " .
    "part_age = '" . $_SESSION['age'] . "', " .
    "part_student = '" . $studentChar . "';";

    $db_conn->query($qryParticipants); //do the query
    if(checkForDBUpdateError($db_conn, $qryParticipants)){ //if error-handling passed
        return $db_conn->insert_id;
    }
}

/*  Purpose: To insert the user's purchase info into the participants table (user's id, the product, howPurchased, 
        satisfied, recommend).
    Pre-condition: Takes in a database connection object and data for insertion.
    Post-condition: If successful, inserts data into responses table.
*/
function saveResponsesToDB($db_conn, $product, $howPurchased, $satisfied, $recommend, $userDB){
    $qryResponses = "INSERT INTO responses SET " .
    "resp_part_id = '" . $userDB .  "', " .
    "resp_product = '" . $product .  "', " .
    "resp_how_purchased = '" . $howPurchased .  "', " .
    "resp_satisfied = '" . intval($satisfied) .  "', " . //converts string to int
    "resp_recommend = '" . $recommend . "';";

    $db_conn->query($qryResponses); //do the query
    checkForDBUpdateError($db_conn, $qryResponses); //error-handling
}

/*  Purpose: To check if errors occur from the query.
    Pre-condition: Takes in database connection and query string object.
*/
function checkForDBUpdateError($db_conn, $qry){
    if($db_conn->errno != 0){
        die("Error running database query: " . $qry . "\n"
            . "Error: " . $db_conn->errno . "\n"
            . "Description: " . $db_conn->error . "\n\n"
        );
        return false;
    }
    else{
        return true;
    }
}
?>