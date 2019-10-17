<!--Name: formSurveyThree.php from Project1 for INFO3106
	Author: Michelle Estanol
	Purpose: Provides two functions. One for redisplaying the form and one for saving the data into the SESSION object.
-->

<?php

/*  Purpose: Gets the stored form data from POST or SESSION. Then displays the HTML for the form's part one with PHP for displaying errors
    or redisplaying data. 
*/
function displaySurveyThree(){
    //create variables
    $counter = 1;

    //associative arrays to hold values
    $satisfactionScores = array();
    $recommendations = array();
    
    //access SESSION to determine how many times to display form elements
        //uses variable variables to create variable names
    foreach($_SESSION['purchases[]'] as $value => $displayText){
        $varString1 = "satisfaction".$counter;
        $$varString1 = ""; //uses variable variables to set value for $satisfaction#


        //get values from SESSION if they exist; if not, get from POST
        if (isset($_SESSION[$varString1])){
            $$varString1 = $_SESSION[$varString1];
        } 
            else if (isset($_POST[$varString1])){
            $$varString1 = $_POST[$varString1];
        }

        $satisfactionScores[$counter] = $$varString1; //save satisfaction value in array  

        $varString2 = "recommend" . $counter;
        $$varString2 = ""; //uses variable variables to set value for $recommend#

        //get values from SESSION if they exist; if not, get from POST
        if (isset($_SESSION[$varString2])){
            $$varString2 = $_SESSION[$varString2];
        } 
            else if (isset($_POST[$varString2])){
            $$varString2 = $_POST[$varString2];
        }

        $recommendations[$counter] = $$varString2;

        ++$counter;

    }

?>
    <form name="surveyOne" method="POST">
        <h1>INFO3144 Multi-page Survey Application</h1>
        <h2>Page 3 of 3</h2>

        <?php 
            $counter = 1;
            foreach($_SESSION['purchases[]'] as $value => $displayText){
                echo "<h3>" . $counter . ". " . $displayText . "</h3";
        ?>
        
        <label for=<?php echo "radioSatisfaction".$counter; ?>>How happy are you with this device on a scale from 1 (not satisfied) to 5 (very satisfied)?</label>
        <?php  if(isset($_SESSION['errors']['page3']) && in_array('3_satisfaction'.$counter, $_SESSION['errors']['page3'])){?>
            <label for="howPurchased" class="label--error">Select one.</label>
        <?php } ?>
        <ul id=<?php echo "radioSatisfaction".$counter; ?> class="form__ul--radio">
            <li><input type="radio" name=<?php echo "satisfaction".$counter; ?> value="1" id="s1" <?php if($satisfactionScores[$counter] == "1"){ echo "checked"; }  ?>><label for="s1" class="label--radio" >1</label></li>
            <li><input type="radio" name=<?php echo "satisfaction".$counter; ?> value="2" id="s2" <?php if($satisfactionScores[$counter] == "2"){ echo "checked"; } ?>><label for="s2" class="label--radio">2</label></li>
            <li><input type="radio" name=<?php echo "satisfaction".$counter; ?> value="3" id="s3" <?php if($satisfactionScores[$counter] == "3"){ echo "checked"; } ?>><label for="s3" class="label--radio">3</label></li>
            <li><input type="radio" name=<?php echo "satisfaction".$counter; ?> value="4" id="s4" <?php if($satisfactionScores[$counter] == "4"){ echo "checked"; } ?>><label for="s4" class="label--radio">4</label></li>
            <li><input type="radio" name=<?php echo "satisfaction".$counter; ?> value="5" id="s5" <?php if($satisfactionScores[$counter] == "5"){ echo "checked"; } ?>><label for="s5" class="label--radio">5</label></li>
        </ul>

        <label for=<?php echo "recommend".$counter; ?> class="form__label--select">Would you recommend the purchase of this device to a friend?</label>
        <?php if(isset($_SESSION['errors']['page3']) && in_array('3_recommend'.$counter, $_SESSION['errors']['page3'])){ ?>
            <label for=<?php echo "recommend".$counter; ?> class="label--error">The empty option cannot be selected.</label>
        <?php }?> 
        <select name=<?php echo "recommend".$counter; ?> id=<?php echo "recommend".$counter; ?>>
            <option value="" hidden <?php if($recommendations[$counter] == '') { echo "selected"; } ?>></option>
            <option value="yes" <?php if($recommendations[$counter] == 'yes') { echo "selected"; }  ?>>Yes</option>
            <option value="maybe" <?php if($recommendations[$counter] == 'maybe') { echo "selected"; } ?>>Maybe</option>
            <option value="no" <?php if($recommendations[$counter] == 'no') { echo "selected"; } ?> >No</option>
        </select>

        <?php  
            ++$counter;
            }
        ?>

        <footer>
        <div id="divButtons">
            <input type="submit" value="Previous" name="btnPrevious" id="btnPrevious">
            <input type="submit" value="Next" name="btnNext" id="btnNext">  
        </div>
        </footer>
    </form>
<?php
    }
?>

<?php 
/*  Purpose: To save the form's part three in the $_SESSION.
*/
function saveSurveyThreeToSession(){
    foreach($_POST as $name => $value){
        $_SESSION[$name] = $value;
    }

    //remove the button info from the session
    unset($_SESSION['btnNext']);
}

?>