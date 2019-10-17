<!--Name: formSurveyOne.php from Project 1
	Author: Michelle Estanol
	Purpose: Provides two functions. One for redisplaying the form and one for saving the data into the SESSION object.
-->

<?php
/*  Purpose: Gets the stored form data from POST or SESSION. Then displays the HTML for the form's part one with PHP for displaying errors
    or redisplaying data. 
*/
function displaySurveyOne(){
    //create variables
    $fullName = "";
    $age = "";
    $student = "";

    //get values from SESSION if they exist; if not, get from POST
    if (isset($_SESSION['fullName'])){
		$fullName = $_SESSION['fullName'];
    } 
    else if (isset($_POST['fullName'])){
		$fullName = $_POST['fullName'];
    }
    
	if (isset($_SESSION['age'])){
		$age = $_SESSION['age'];
    } 
    else if (isset($_POST['age'])){
		$age = $_POST['age'];
	}
    
    if (isset($_SESSION['student'])){
		$student = $_SESSION['student'];
    } 
    else if (isset($_POST['student'])){
        $student = $_POST['student'];
    }
?>
    <form name="surveyOne" method="POST">
        <h1>INFO3144 Multi-page Survey Application</h1>
        <h2>Page 1 of 3</h2>

        <label for="fullName">Full Name</label>
        <input type="text" name="fullName" id="fullName" value="<?php if($fullName != '') { echo $fullName; }  ?>">
        <?php if(isset($_SESSION['errors']['page1']) && in_array('1_fullName', $_SESSION['errors']['page1'])){ ?>
            <label for="fullName" class="label--error">Cannot be empty.</label>
        <?php } ?>

        <label for="age">Your Age</label>
        <input type="text" name="age" id="age" value="<?php if($age != '') { echo $age; }  ?>">
        <?php if(isset($_SESSION['errors']['page1']) && in_array('1_age', $_SESSION['errors']['page1'])){ ?>
            <label for="age" class="label--error">Cannot be empty. Must be numeric.</label>
        <?php } ?>

        <label for="student">Are you a student?</label>   
        <select name="student" id="student">
            <option value="" hidden <?php if($student == '') { echo "selected"; } ?>></option>
            <option value="fulltime" <?php if($student == "fulltime") {  echo "selected"; }  ?>>Yes, Full Time</option>
            <option value="parttime" <?php if($student == "parttime") { echo "selected"; } ?>>Yes, Part Time</option>
            <option value="no" <?php if($student == "no") { echo "selected"; } ?>>No</option>
        </select>
        <?php if(isset($_SESSION['errors']['page1']) && in_array('1_student', $_SESSION['errors']['page1'])){ ?>
            <label for="student" class="label--error">Cannot be empty.</label>
        <?php } ?>

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
/*  Purpose: To save the form's part one in the $_SESSION.
*/
function saveSurveyOneToSession(){
    $_SESSION['fullName'] = $_POST['fullName'];
    $_SESSION['age'] = $_POST['age'];
    $_SESSION['student'] = $_POST['student'];
}
?>