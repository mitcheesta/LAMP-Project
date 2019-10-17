<!--Name: formValidation.php from Project 1
	Author: Michelle Estanol
	Purpose: Provides three functions for validating the three form parts.
-->

<?php

/* Purpose: To validate the page one data.
        - full name not empty
        - age not empty and only has numbers
        - student is not empty and is 'fulltime', 'parttime', or 'no'
*/
function validatePageOne(){
    $error_msg = array(); //create new empty array for error messages
    
    //check fullname textbox
    if(isset($_POST['fullName'])){
        $fullName = trim($_POST['fullName']);

        if(strlen($fullName) == 0){
            $error_msg[] = "1_fullName";
        }
    }
    else{
        $error_msg[] = "1_fullName"; 
    }

    //check age textbox
    if(isset($_POST['age'])){
        $age = trim($_POST['age']);

        if(strlen($age) == 0){ //if empty
            $error_msg[] = "1_age";
        }
        else if(!preg_match('/^[0-9]+$/', $age)){ //if fails performed regex match for numbers
            $error_msg[] = "1_age";
        }
    }
    else{
        $error_msg[] = "1_age";
    }

    //check student dropdown
    if(isset($_POST['student'])){
        $student = trim($_POST['student']);

        if(strlen($student) == 0){
            $error_msg[] = "1_student";
        }
        else if(!preg_match('/^(fulltime|parttime|no)$/', $student)){
            $error_msg[] = "1_student";
        }
    }
    else{
        $error_msg[] = "1_student"; 
    }

    return (sizeof($error_msg) > 0)? $error_msg : null; //if $error_msg has elements, return it; if not, return null
}

/* Purpose: To validate the page two data.
        - radio has one selected and value is from acceptable list
        - checkbox has at least one selected and values are from acceptable list
*/
function validatePageTwo(){
    $error_msg = array();

    //check radio howPurchased
    if(isset($_POST['howPurchased'])){
        $howPurchased = trim($_POST['howPurchased']); //make sure white space hasn't been inserted

        if(strlen($howPurchased) == 0){ //if empty
            $error_msg[] = "2_howPurchased";
        }
        else if(!preg_match('/^(online|phone|mobile|store)$/', $howPurchased)){ //if fails performed regex match for numbers
            $error_msg[] = "2_howPurchased";
        }
    }
    else{
        $error_msg[] = "2_howPurchased";
    }

    //check checkbox purchases[]
    $checkValues = $GLOBALS['2_purchasesValues'];
    $foundValue = false;

    foreach($checkValues as $checkValue => $displayText){
        if(isset($_POST[$checkValue])){
            $foundValue = true;
        }
    }
    if($foundValue == false){
        $error_msg[] = "2_purchases[]";
    }

    return (sizeof($error_msg) > 0)? $error_msg : null; //if $error_msg has elements, return it; if not, return null
}

/* Purpose: To validate the page three data.
        - only a single satisfaction value that is from 1 to 5
        - recommendation cannot be empty and must be 'yes', 'maybe' or 'no'
*/
function validatePageThree(){
    $error_msg = array();

    //check for each satisfaction radio and recommend dropdown
    $numSelected = count($_SESSION['purchases[]']);

    for($y = 1; $y <= $numSelected; ++$y){ 
        //checks satisfaction
        if(isset($_POST['satisfaction'.$y])){ //if satisfaction#
            $satisfaction = $_POST['satisfaction'.$y];

            if(!preg_match('/^[1-5]$/', $satisfaction)){ //checks if value isn't between 1 to 5
                $error_msg[] = "3_satisfaction".$y;
            }
        }
        else{  
            $error_msg[] = "3_satisfaction".$y;
        }
        
        //checks recommend
        if(isset($_POST['recommend'.$y])){ //if recommeneded#
            $recommend = $_POST['recommend'.$y];

            if(strlen($recommend) == 0){ //if empty
                $error_msg[] = "3_recommend".$y;
            }
            else if(!preg_match('/^(yes|maybe|no)$/', $recommend)){ //if not yes, maybe, no
                $error_msg[] = "3_recommend".$y;
            }
        }
        else{
            $error_msg[] = "3_recommend".$y;
        }
    }
    return (sizeof($error_msg) > 0)? $error_msg : null; //if $error_msg has elements, return it; if not, return null
}

?>