<!--Name: formSurveyTwo.php from Project 1
	Author: Michelle Estanol
	Purpose: Provides two functions. One for redisplaying the form and one for saving the data into the SESSION object.
-->

<?php
//create global associative array that holds the checkbox names and their associated label's value
$GLOBALS['2_purchasesValues'] = ["homePhone" => "Home Phone", "mobilePhone" => "Mobile Phone", "tv" => "Smart TV", "laptop" => "Laptop", "desktop" => "Desktop Computer", "tablet" => "Tablet", "homeTheatre" => "Home Theatre"];

/*  Purpose: Gets the stored form data from POST or SESSION. Then displays the HTML for the form's part one with PHP for displaying errors
    or redisplaying data. 
*/
function displaySurveyTwo(){
    //create variables
    $howPurchased = '';
    $purchases = array();

    //get values from SESSION if they exist; if not, get from POST
    if (isset($_SESSION['howPurchased'])){
		$howPurchased = $_SESSION['howPurchased'];
    } 
    else if (isset($_POST['howPurchased'])){
		$howPurchased = $_POST['howPurchased'];
	}

    //displays form elements for each product purchased
    $checkValues = $GLOBALS['2_purchasesValues'];
    foreach($checkValues as $checkValue => $displayText){ //compares the product names against the SESSION and POST
        if(isset($_SESSION['purchases[]'][$checkValue])){
            $purchases[] = $checkValue;
        }
        else if(isset($_POST[$checkValue])){
            $purchases[] = $checkValue;
        }
    }

?>
    <form name="surveyOne" method="POST">
        <h1>Multi-page Survey Application</h1>
        <h2>Page 2 of 3</h2>

        <label for="howPurchased">How did you complete your purchase?</label>
       <?php  if(isset($_SESSION['errors']['page2']) && in_array('2_howPurchased', $_SESSION['errors']['page2'])){?>
            <label for="howPurchased" class="label--error">Select one.</label>
        <?php } ?>
        <ul id="radioPurchase" class="form__ul--radio">
            <li><input type="radio" name="howPurchased" value="online" id="online" <?php if($howPurchased == 'online') { echo "checked"; }  ?>><label for="online" class="label--radio">Online</label></li>
            <li><input type="radio" name="howPurchased" value="phone" id="phone" <?php if($howPurchased == 'phone') { echo "checked"; }?>><label for="phone" class="label--radio" <?php if($howPurchased == 'phone') { echo "checked"; }?>>Phone</label></li>
            <li><input type="radio" name="howPurchased" value="mobile" id="mobile" <?php if($howPurchased == 'mobile') { echo "checked"; }?>><label for="mobile" class="label--radio" <?php if($howPurchased == 'mobile') { echo "checked"; }?>>Mobile App</label></li>
            <li><input type="radio" name="howPurchased" value="store" id="store" <?php if($howPurchased == 'store') { echo "checked"; }?>><label for="store" class="label--radio" <?php if($howPurchased == 'store') { echo "checked"; }?>>In store</label></li>
        </ul>

        <label for="purchases[]">Which of the following did you purchase?</label>
        <?php  if(isset($_SESSION['errors']['page2']) && in_array('2_purchases[]', $_SESSION['errors']['page2'])){?>
            <label for="purchases[]" class="label--error">Select at least one.</label>
        <?php } ?>
        <ul id="chkboxPurchase">
            <li><input type="checkbox" name="homePhone" id="homePhone" <?php if(is_numeric(array_search('homePhone', $purchases))) { echo "checked"; }  ?>><label for="homePhone" class="label--chkbox">Home Phone</label></li>
            <li><input type="checkbox" name="mobilePhone" id="mobilePhone" <?php if(is_numeric(array_search('mobilePhone', $purchases))) { echo "checked"; }  ?>><label for="mobilePhone" class="label--chkbox">Mobile Phone</label></li>
            <li><input type="checkbox" name="tv" id="tv" <?php if(is_numeric(array_search('tv', $purchases))) { echo "checked"; } ?>><label for="tv" class="label--chkbox">Smart TV</label></li>
            <li><input type="checkbox" name="laptop" id="laptop" <?php if(is_numeric(array_search('laptop', $purchases))) { echo "checked"; } ?>><label for="laptop" class="label--chkbox">Laptop</label></li>
            <li><input type="checkbox" name="desktop" id="desktop" <?php if(is_numeric(array_search('desktop', $purchases))) { echo "checked"; } ?>><label for="desktop" class="label--chkbox">Desktop Computer</label></li>
            <li><input type="checkbox" name="tablet" id="tablet" <?php if(is_numeric(array_search('tablet', $purchases))) { echo "checked"; } ?>><label for="tablet" class="label--chkbox">Tablet</label></li>
            <li><input type="checkbox" name="homeTheatre" id="homeTheatre" <?php if(is_numeric(array_search('homeTheatre', $purchases))) { echo "checked"; } ?>><label for="homeTheatre" class="label--chkbox">Home Theatre</label></li>
        </ul>

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
/*  Purpose: To save the form's part two in the $_SESSION.
*/
function saveSurveyTwoToSession(){
    $_SESSION['howPurchased'] = $_POST['howPurchased'];

    //Stores selected purchases[] as an associative array within SESSION
    foreach($GLOBALS['2_purchasesValues'] as $value => $displayText){
        if(isset($_POST[$value])){
            $_SESSION['purchases[]'][$value] = $displayText;
        }
    }
}

?>